#!/bin/bash

total_file_count=0
total_file_size=0
total_fail_count=0

n="$#"

if [ "$n" -lt 2 ]; then
    echo "ERROR: careful-mv needs at least 2 arguments" 1>&2
    exit 1
fi

# There is BASH_ARGV but it is strange, like in the programming language forth.
# So instead we use eval.

m=$(($n - 1))
arg="\$$n"
eval "destination_directory=$arg"

echo "Going to move $m files to $destination_directory/" 1>&2

if [ ! -d "$destination_directory/" ]; then
    echo "[$destination_directory] is not a directory" 1>&2
    exit 1
fi

j=1

while [ "$j" -lt "$n" ]; do
 arg="\$$j"
 eval "source_file=$arg"
 if [ ! -f "$source_file" ]; then
     # Not counting this as a failure. Most likely a glob pattern.
     echo "Skipping $source_file" 1>&2
 else
     total_file_count=$(($total_file_count + 1))
     size=$(stat --format=%s "$source_file")
     mv "$source_file" "$destination_directory/"
     status=$?
     if [ "$status" != "0" ]; then
	 total_fail_count=$(($total_fail_count + 1))
     else
	 total_file_size=$(($total_file_size + $size))
     fi
 fi
 j=$(($j + 1))
done
     

printf "total_file_count=%d\ntotal_file_size=%d\ntotal_fail_count=%d\n" \
    $total_file_count $total_file_size $total_fail_count
