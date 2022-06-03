#!/bin/bash
#
# Manage SQLRelay Server. Currently without Wayfair's fancy systemd unit files.

self=$0
echo "self=$self"
if [ "${self:0:1}" != "/" ]; then
 self=$(pwd)/$self
fi
selfdir=$(dirname $self)
selfname=$(basename $self .sh)
data_folder=$(realpath --canonicalize-existing "$selfdir/../data")

operation=${1-"show"}

if [ "$operation" = "show" ]; then
    ps -u $(id --user) --forest -o pid,ppid,comm:32,etimes,wchan
    sqlr-status -id test -short
    sqlr-status -id test -connection-detail -query
elif [ "$operation" = "start" ]; then
    sqlr-start -id test
elif [ "$operation" = "stop" ]; then
    sqlr-stop -id test
elif [ "$operation" = "test" ]; then

    read -r -d '' sqlrsh_query <<EOF
setclientinfo sqlrelay_test;
response timeout 10.5;
ping;
sqlrcmd gstat;
sqlrcmd cstat;
SELECT CAST(HOST_NAME() as VARCHAR(64)) as HOST_NAME,
       CAST(APP_NAME() as VARCHAR(64)) as APP_NAME;
EOF
    t0=$(date +%s)
    sqlrsh -id test -command "$sqlrsh_query"
    status=$?
    t1=$(date +%s)
    dt=$(($t1 - $t0))
    echo "status=$status in $dt seconds" 1>&2

elif [ "$operation" = "config" ]; then
    prototype_config_file="$data_folder/test.conf"
    if [ ! -f "$prototype_config_file" ]; then
	echo "ERROR: file not found $prototype_config_file" 1>&2
	exit 1
    else
	echo "Using prototype config $prototype_config_file" 1>&2
    fi
    destination_config_file="/etc/sqlrelay.conf.d/test.conf"
    # so the first thing we do is arrange for locations set up by the
    # sqlrelay package installation, which created a user named sqlrelay,
    # to have more open file access controls to make it easier to run
    # sqlrelay services as the current user, and to be able to manipulate
    # the log files created. Some of these directories are the same inode.
    directories_to_chmod="\
	/var/log/sqlrelay /run/sqlrelay /var/run/sqlrelay \
        /etc/sqlrelay.conf.d /var/sqlrelay"
    # And these directories will be needed, but were not created at package
    # install time.
    directories_to_create="/var/log/sqlrelay/debug /var/log/sqlrelay/odbc"
    for d in $directories_to_chmod; do
	if [ -d $d ]; then
	    sudo chmod --recursive uog+rwx $d
	fi
    done
    mkdir -p $directories_to_create
    chmod uog+rwx $directories_to_create
    run_as_user=$(id --name --user)
    run_as_group=$(id --name --group)
    odbc_trace_directory="/var/log/sqlrelay/odbc"
    sed -e "s|__RUN_AS_USER__|$run_as_user|g" \
	-e "s|__RUN_AS_GROUP__|$run_as_group|g" \
	-e "s|__ODBC_TRACE_DIRECTORY__|$odbc_trace_directory|g" \
	$prototype_config_file > $destination_config_file
    status=$?
    echo "sed status=$status" 1>&2
    
elif [ "$operation" = "clean" ]; then
    # we clean logs only. There are files in /var/run/sqlrelay
    # but normal sqlr-stop should take care of them.
    echo "Cleaning up SQLRelay log files" 1>&2
    rm -f /var/log/sqlrelay/debug/* /var/log/sqlrelay/odbc/*
else
    echo "$selfname: unknown operation $operation, try show, config, start, stop, test" 1>&2
fi
