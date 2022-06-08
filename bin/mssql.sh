#!/bin/bash
#
# Manage basic Microsoft SQL Server requirements for integration testing.
# There are some good github action libraries for this kind of thing,
# but it suffices to follow the simple examples provided by Microsoft
# on https://hub.docker.com/_/microsoft-mssql-server
# and then this script can run in any street-worthy development environment.
# See also https://docs.microsoft.com/en-us/sql/tools/sqlcmd-utility
# https://docs.docker.com/engine/reference/commandline/ps/

self=$0
echo "self=$self"
if [ "${self:0:1}" != "/" ]; then
 self=$(pwd)/$self
fi
selfdir=$(dirname $self)
selfname=$(basename $self .sh)
data_folder=$(realpath --canonicalize-existing "$selfdir/../data")

operation=${1-"show"}

mssql_container_image="mcr.microsoft.com/mssql/server:2017-latest"
sa_user="sa"
sa_pass="None-123" # 8 characters, Upper,Lower,Decimal,Special

echo "$selfname $operation using data_folder=$data_folder" 1>&2

get_mssql_container_id() {
    mssql_container_id=$(docker ps --filter ancestor=$mssql_container_image  --quiet)
    if [ "$mssql_container_id" = "" ]; then
	echo "ERROR: could not find $mssql_container_image" 1>&2
	exit 1
    else
	echo "Found mssql_container_id=$mssql_container_id" 1>&2
    fi
    echo "$mssql_container_id"
}

if [ "$operation" = "show" ]; then
    docker info
    docker images
    docker ps --no-trunc
elif [ "$operation" = "pull" ]; then
    docker pull $mssql_container_image
elif [ "$operation" = "start" ]; then
 docker run \
     -e "ACCEPT_EULA=Y" \
     -e "SA_PASSWORD=$sa_pass" \
     -p 1433:1433 \
     -d $mssql_container_image
elif [ "$operation" = "test" ]; then
    mssql_container_id=$(get_mssql_container_id)
    if [ "$?" != "0" ]; then exit 1; fi
    read -r -d '' SQL <<EOF
-- Some of this is just raw curiosity
BEGIN
SELECT @@SPID as SPID,
       @@SERVERNAME AS SERVERNAME,
       @@SERVICENAME SERVICENAME,
       SERVERPROPERTY('ComputerNamePhysicalNetBIOS') as ComputerNamePhysicalNetBIOS,
       SERVERPROPERTY('InstanceName') as InstanceName,
       SERVERPROPERTY('MachineName') as MachineName,
       ORIGINAL_DB_NAME() as ORIGINAL_DB_NAME,
       ORIGINAL_LOGIN() as ORIGINAL_LOGIN,
       USER_NAME() as CURRENT_USER_NAME,
       SCHEMA_NAME() as SCHEMA_NAME,
       DB_NAME() as DBNAME

EXEC SP_WHO
END
EOF
    # Note: You may have to wait a minute before
    # the container is ready to respond to this.
    # Or else you will get a connection failure from sqlcmd.
    # the login_timeout is not helping because there really
    # needs to be a retry until the connection succeeds.
    # The use of an odbc.ini DSN could permit the setting
    # of a retry value.
    login_timeout=120
    t0=$(date +%s)
    docker exec \
	$mssql_container_id \
	/opt/mssql-tools/bin/sqlcmd -S localhost -U "$sa_user" -P "$sa_pass" \
	-s "|" \
	-H "mssql.sh" \
	-W \
	-l $login_timeout \
	-Q "$SQL" | sed -e 's/\( \)*/\1/g' -e 's/ |/|/g'
    status=$?
    t1=$(date +%s)
    dt=$(($t1 - $t0))
    echo "status=$status in $dt seconds" 1>&2

elif [ "$operation" = "setup" ]; then
    mssql_container_id=$(get_mssql_container_id)
    if [ "$?" != "0" ]; then exit 1; fi
    read -r -d '' SQL <<EOF
USE [master]
CREATE LOGIN [TEST2] WITH PASSWORD=N'None-123#BAR', 
DEFAULT_DATABASE=[master],
CHECK_EXPIRATION=OFF, 
CHECK_POLICY=OFF
CREATE USER [TEST2] FOR LOGIN [TEST2]
ALTER ROLE [db_datareader] ADD MEMBER [TEST2]
EOF
    login_timeout=120
    t0=$(date +%s)
    docker exec \
	$mssql_container_id \
	/opt/mssql-tools/bin/sqlcmd -S localhost -U "$sa_user" -P "$sa_pass" \
	-s "|" \
	-H "mssql.sh" \
	-W \
	-l $login_timeout \
	-Q "$SQL" | sed -e 's/\( \)*/\1/g' -e 's/ |/|/g'
    status=$?
    t1=$(date +%s)
    dt=$(($t1 - $t0))
    echo "status=$status in $dt seconds" 1>&2

elif [ "$operation" = "stop" ]; then
    mssql_container_id=$(get_mssql_container_id)
    if [ "$?" != "0" ]; then exit 1; fi
    docker stop $mssql_container_id
else
    echo "Unknown operation: $operation, try show, pull, start, stop" 1>&1
    exit 1
fi
