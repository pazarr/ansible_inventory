#!/bin/bash
[ -z $1 ] && echo "Missing args" && exit; 

if [ $1 == "--list" ]; then
	curl -X POST -d "query=list" -s "http://localhost:9697"
elif [ $1 == "--host" ]; then 
	curl -X POST -d "query=host" -d "hostname=$2" -s "http://localhost:9697"
else
	echo "Error"
fi

