#!/bin/bash

operation=${1?"must specify operation: download, apt-enable"}
sqlrelay_version=${2-"1.9.2"}
temp=${3-"$(pwd)/tmp"}

echo "temp=$temp" 1>&2

if [ ! -d $temp ]; then
 mkdir -p $temp
fi

temp_directory="${temp}/sqlrelay-binary-distribution-${sqlrelay_version}"


sourceforge_download() {

 NAME=${1-"foo"}
 VERSION=${2-"0.0"}
 NAME1=${3-"$NAME"}
 REF=${4-"https://sqlrelay.sourceforge.net/download2.html"}
 EXT=${5-"tar.gz"}

 TS=$(date --utc +%s)

 OUTPUT="${temp}/${NAME1}-${VERSION}.${EXT}"
 URL="https://downloads.sourceforge.net/project/${NAME}/${NAME}/${VERSION}/${NAME1}-${VERSION}.${EXT}"

if [ -f $OUTPUT ]; then
 echo "Already have $OUTPUT"
else
 echo "Downloading $OUTPUT"
 echo "from $URL"

 curl --silent --show-error \
 --write-out "\n%{http_code} %{content_type} %{time_total} %{size_download} %{size_upload} %{url_effective}\n" \
 --compressed \
 --dump-header ${temp}/${NAME1}-${VERSION}.hdr.txt \
 --output "${OUTPUT}.tmp" \
 --get \
 --location \
 --url "${URL}" \
 --form-string r=${REF} \
 --form-string ts=$$TS \
 --form-string use_mirror=superb-dca2
 status=$?
 echo "Status=$status"

 cat ${temp}/${NAME1}-${VERSION}.hdr.txt


 mv ${OUTPUT}.tmp ${OUTPUT}
fi
}

sqlrelay_unpack() {
    tgz_file="${temp}/sqlrelay-binary-distribution-${sqlrelay_version}.tar.gz"
    file --uncompress "$tgz_file"
    gzip -t -v "$tgz_file"
    gzip_test_status=$?
    echo "gzip_test_status=$gzip_test_status"

    if [ "$gzip_test_status" != "0" ]; then
	echo "gzip -t failed, exiting"
	return 1
    fi

    if [ -d "$temp_directory" ]; then
	echo "Already unpacked $temp_directory"
    else
	tar --directory=$temp \
	    --extract \
	    --file="${tgz_file}" \
	    --gzip
    fi

    du -hs ${temp_directory}
    status=$?
    return $status
}

# The client packages are needed to build and test the pdo_sqlrelay.so
client_library_packages="sqlrelay-c++ rudiments sqlrelay-common"
client_dev_packages="sqlrelay-c++-dev rudiments-dev"
# The server packages are needed to start a sqlrelay server in the same machine.
# this is a nice way to test because it makes it makes the server logs available
# for comparison with the client logs.
server_packages="sqlrelay sqlrelay-odbc sqlrelay-clients"
all_packages="$client_library_packages $client_dev_packages $server_packages"

if [ "$operation" = "download" ]; then
    sourceforge_download "sqlrelay" ${sqlrelay_version} sqlrelay-binary-distribution
    status=$?
    if [ "$status" != "0" ]; then
	echo "Failed status=$status"
	exit $status
    fi
    sqlrelay_unpack
    status=$?
    if [ "$status" != "0" ]; then
	echo "Failed status=$status"
	exit $status
    fi
    exit 0
elif [ "$operation" = "show-env" ]; then
    uname -a
    lsb_release -a
    hostname --fqdn
    hostname --all-ip-addresses
    id
    pwd
    ps -p 1 -o pid,ppid,comm:32,etimes,wchan
    ps -u $(id --user) --forest -o pid,ppid,comm:32,etimes,wchan
    df -h .
    if [ "$(which docker)" != "" ]; then
	docker version
    fi
elif [ "$operation" = "apt-enable" ]; then
    lsb_release -idrc
    status=$?
    if [ "$status" != "0" ]; then
	echo "This is not Ubuntu. Exiting ..."
	exit 1
    fi
    release=$(lsb_release -r)
    if [[ "$release" =~ ^Release:[[:space:]]+([0-9]+)[.]([0-9]+) ]]; then
	release_maj=${BASH_REMATCH[1]}
	release_min=${BASH_REMATCH[2]}
	subfolder="ubuntu${release_maj}${release_min}x64"
	echo "Looking for $subfolder"
	deb_dir="${temp_directory}/${subfolder}"
	if [ ! -d "$deb_dir" ]; then
	    echo "Subfolder not found. Exiting"
	    exit 1
	fi
	du -hs $deb_dir
	dpkg -l dpkg-dev
	status=$?
	if [ "$status" != "0" ]; then
	    sudo apt-get -y install dpkg-dev
	fi
	if [ -f $deb_dir/Packages.gz ]; then
	    echo "Already have ${subfolder}/Packages.gz"
	else
	    (cd $deb_dir;  dpkg-scanpackages . /dev/null | gzip -9c > Packages.gz)
	fi
	deb_list_d_file="/etc/apt/sources.list.d/sqlrelay.list"
	if [ -f $deb_list_d_file ]; then
	    echo "Already have $deb_list_d_file, updating"
	fi
	sudo bash -c "echo 'deb [allow-insecure=yes] file:$deb_dir ./' > $deb_list_d_file"
	sudo apt-get update
    else
	echo "Could not parse [$release]. Exiting"
	exit 1
    fi
    exit 0
elif [ "$operation" = "apt-install" ]; then
    sudo apt-get -y --allow-unauthenticated install $all_packages
elif [ "$operation" = "yum-install" ]; then
    sudo yum install --exclude 'lgto*' -y $(echo -n $all_packages | sed 's/-dev/-devel/g')
elif [ "$operation" = "apt-remove" ]; then
    # remove just rudiments and everything goes with it.
    sudo apt -y remove rudiments
else
    echo "unknown operation: $operation, try download or apt-enable"
    exit 1
fi

