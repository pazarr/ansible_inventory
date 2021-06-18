#!/bin/bash
dockerDaemon=$(which docker)
mysqlCLI=$(which mysql)
export DATABASE_PASS="Nn1254E2"
export DATABASE_NAME="ansible_inventory"
export DATABASE_USER="root"
export DATABASE_PORT="3306"
export DATABASE_HOST="127.0.0.1"
isPortOpen=1
if [ $(docker container ls -f name=ansible-db |wc -l) -ne 2 ]; then
	echo -n "Setup new DB container... "
	$dockerDaemon run -p 127.0.0.1:3306:3306  --name ansible-db -e MARIADB_ROOT_PASSWORD=Nn1254E2 -d mariadb:latest > /dev/null 2>&1
	echo "Done"
	echo -n "Waiting for mysql server ito be ready."
	while [ $isPortOpen -eq 1 ]
	do
		$mysqlCLI -h $DATABASE_HOST -P $DATABASE_PORT -u $DATABASE_USER --password=$DATABASE_PASS -e "SHOW GLOBAL VARIABLES LIKE 'PORT';" >/dev/null 2>&1
		isPortOpen=$?
		sleep 1
		echo -n "."
	done
	echo " Done"
	echo -n "Upload data... "
	$mysqlCLI -h $DATABASE_HOST -P $DATABASE_PORT -u $DATABASE_USER --password=$DATABASE_PASS -e "CREATE DATABASE IF NOT EXISTS $DATABASE_NAME;"
	$mysqlCLI -h $DATABASE_HOST -P $DATABASE_PORT -u $DATABASE_USER --password=$DATABASE_PASS $DATABASE_NAME < ./inventory_ui/deps/ans_inv_17_06_2021.sql
	echo "Done"
fi
