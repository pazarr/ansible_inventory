#!/bin/bash
if [ "$1" == "--list" ]; then
        wget -qO - "http://localhost/inventory.php?q=list"
        exit $?
elif [ "$1" == "--host" ]; then
        wget -qO - "http://localhost/inventory.php?q=host&hostname=$2"
        exit $?
else
        echo -n "Missing parameters"
        exit 1
fi

