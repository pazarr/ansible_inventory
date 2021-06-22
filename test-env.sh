#!/bin/bash
dockerCLI=$(which docker)
mysqlCLI=$(which mysql)
GOCOMP=$(which go)
export CGO_ENABLED=0
exec "$@"
export DATABASE_PASS="Nn1254E2"
exec "$@"
export DATABASE_NAME="ansible_inventory"
exec "$@"
export DATABASE_USER="root"
exec "$@"
export DATABASE_PORT=2861
exec "$@"
export API_PORT=9697
exec "$@"
export TEST_DATA_MD5="a24113f8a474adbd00108eaf0e96df7f  -"
exec "$@"
export TEST_DATA2_MD5="cee573a9b838a4cb230e281d771e6a9f  -"
exec "$@"
errc=0

isPortOpen=1
randomName=$(tr -dc a-z0-9 </dev/urandom | head -c 16)
function compileAPI {
	$GOCOMP build .
	$dockerCLI build -t inventory-api . > /dev/null
	if [ $? -ne 0 ];then
		echo "failed to build api container"
		break
	fi
}

function createInventoryDBContainer {
	echo -n "Setup new DB container... "
	$dockerCLI run -p $DATABASE_PORT:3306 --net bridge --name inventory-db -e MARIADB_ROOT_PASSWORD=$DATABASE_PASS -d mariadb:latest > /dev/null
	if [ "$?" -ne 0 ]; then
		echo "Failed to build api container..."
		decommissionEnv
		exit 2
	fi
	echo "Done"
	echo -n "Waiting for mysql server to be ready."
	while [ $isPortOpen -eq 1 ]
		do
			$mysqlCLI -h 127.0.0.1 -P $DATABASE_PORT -u $DATABASE_USER --password=$DATABASE_PASS -e "SHOW GLOBAL VARIABLES LIKE 'PORT';" >/dev/null 2>&1
			isPortOpen=$?
			sleep 1
			echo -n "."
		done
	echo " Done"
	echo -n "Upload data... "
	$mysqlCLI -h 127.0.0.1 -P $DATABASE_PORT -u $DATABASE_USER --password=$DATABASE_PASS -e "CREATE DATABASE IF NOT EXISTS $DATABASE_NAME;"
	errc=$?
	$mysqlCLI -h 127.0.0.1 -P $DATABASE_PORT -u $DATABASE_USER --password=$DATABASE_PASS $DATABASE_NAME < ./inventory_ui/deps/ans_inv_17_06_2021.sql
	errc=$((errc+$?))
	if [ "$errc" -ne 0 ]; then
		echo "Failed to migrate DB..."
		decommissionEnv
		exit 2
	fi
}

function createInventoryContainer {
	inventoryDBHost=$($dockerCLI inspect inventory-db |jq '.[0].NetworkSettings.Gateway?')
	isPortOpen=0
	echo -n "Setup new inventory API container... "
	$dockerCLI run -p $API_PORT:8080 --net bridge -e "DATABASE_PASS=$DATABASE_PASS" -e "DATABASE_NAME=$DATABASE_NAME" -e "DATABASE_USER=$DATABASE_USER" -e "DATABASE_PORT=$DATABASE_PORT" -e "DATABASE_HOST=172.17.0.1" --name inventory-api -d inventory-api> /dev/null
	if [ "$errc" -ne 0 ]; then
		echo "Failed to create API container..."
		decommissionEnv
		exit 2
	fi
	echo "Done"
	echo -n "Waiting for inventory API server to be ready."
	while [ $isPortOpen -ne 0 ]
	do
					curl -s localhost:18181
					isPortOpen=$?
					sleep 1
					echo -n "."
					errc=$((errc+1))
					if [ $errc -gt 25 ]; then
						echo "Timeout.."
						decommissionEnv
						exit 2
					fi
	done
	echo " Done"
}

function deployEnv {
	echo "Preparing test environment with unique identifier"
	docker container inspect inventory-db > /dev/null 2>&1
	if [[ "$(docker container ls -f name=inventory-db |wc -l)" -lt 2 ]]; then
		createInventoryDBContainer
	else
		if [ "$TO_DECOMMISSION_DB" != "0" ]; then
			decommissionInventoryDBContainer
			createInventoryDBContainer
	 fi
 fi
  if [[ "$(docker container ls -f name=inventory-api |wc -l)" -lt 2 ]]; then
		createInventoryContainer
  else
		if [ "$TO_DECOMMISSION_INV" != "0" ]; then
			decommissionInventoryContainer
			createInventoryContainer
		fi
  fi
	echo "Test environment is ready"
}


function decommissionEnv {
	if [ "$TO_DECOMMISSION_INV" != "0" ]; then
		echo -n "Cleaning up inventory container... "
		$dockerCLI container rm -f inventory-api > /dev/null 2>&1
		echo "Done"
	fi
	if [ "$TO_DECOMMISSION_DB" != "0" ]; then
		echo -n "Cleaning up DB container... "
		$dockerCLI container rm -f inventory-db > /dev/null 2>&1
		echo "Done"
	fi
}

function decommissionInventoryDBContainer {
	if [ "$TO_DECOMMISSION_DB" != "0" ]; then
		echo -n "Cleaning up DB container... "
		$dockerCLI container rm -f inventory-db > /dev/null 2>&1
		echo "Done"
	fi
}

function decommissionInventoryContainer {
	if [ "$TO_DECOMMISSION_INV" != "0" ]; then
		echo -n "Cleaning up inventory-api container... "
		$dockerCLI container rm -f inventory-api > /dev/null 2>&1
		echo "Done"
	fi
}

function runTest {
	echo "Runing test..."
	testCounter=1
	if [ -f test-case.txt ]; then
		cat ./test-case.txt | while read output
		do
			echo -n "$testCounter) $(echo $output | cut -d'|' -f1 )... "
			postPayload="$(echo $output | cut -d'|' -f2)"
			curlRespons="$(echo -n $(curl -s -X POST -d $postPayload http://localhost:$API_PORT | md5sum)| cut -d " " -f 1 | tr -d "\n")"
			toCompare="$(echo $output | cut -d'|' -f3)"
			if [[ "$curlRespons" == "$toCompare" ]]; then
				echo "Passed"
			else
				echo "Failed"
				#decommissionEnv
				exit 1
			fi
		done
	else
		echo "No test specified... Skipping"
	fi
}

compileAPI
deployEnv
runTest
decommissionInventoryContainer
decommissionInventoryDBContainer
exit 0
