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
export DATABASE_PORT="3306"
exec "$@"

isPortOpen=1
randomName=$(tr -dc a-z0-9 </dev/urandom | head -c 16)
function compileAPI {
	$GOCOMP build .
	$dockerCLI build -t inventory-api-$randomName . > /dev/null
	if [ $? -ne 0 ];then
		echo "failed to build api container"
		break
	fi
}
function prepareEnv {
echo "Preparing test environment with unique identifier: $randomName"
	if [ $(docker container ls -f name=inventory-db-$randomName |wc -l) -ne 2 ]; then
		if [ $(docker network inspect inventory-network-$randomName > /dev/null 2>&1; echo $?) -eq 1 ]; then
			echo -n "Create docker network..."
			$dockerCLI network create inventory-network-$randomName
			if [ "$?" -ne 0 ]; then
				echo "We encountered an issue, aborting...."
				exit 2
			fi
			echo " Done"
		else
			echo "Conatiner network exists"
		fi
		echo -n "Setup new DB container... "
		$dockerCLI run -p $DATABASE_PORT:3306  --net inventory-network-$randomName --name inventory-db-$randomName -e MARIADB_ROOT_PASSWORD=$DATABASE_PASS -d mariadb:latest > /dev/null
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
		echo "Done"
	else
		echo "Test DB container is ready"
	fi
        if [ $(docker container ls -f name=inventory-api-$randomName |wc -l) -ne 2 ]; then
					      inventoryDBHost=$($dockerCLI inspect inventory-db-$randomName |jq '.[0].NetworkSettings.Gateway?')
								isPortOpen=0
                echo -n "Setup new inventory API container... "
                $dockerCLI run -p 18181:8080 --net inventory-network-$randomName -e "DATABASE_PASS=$DATABASE_PASS" -e "DATABASE_NAME=$DATABASE_NAME" -e "DATABASE_USER=$DATABASE_USER" -e "DATABASE_PORT=$DATABASE_PORT" -e "DATABASE_HOST=inventory-db-$randomName" --name inventory-api-$randomName -d inventory-api-$randomName > /dev/null
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
        else
                echo "Test iventory API container is ready"
        fi
	echo "Test environment is ready"
}

function decommissionEnv {
	echo -n "Cleaning up test environment... "
	$dockerCLI network rm -f inventory-network-$randomName > /dev/null 2>&1
	$dockerCLI container rm -f inventory-db-$randomName > /dev/null 2>&1
	$dockerCLI container rm -f inventory-api-$randomName > /dev/null 2>&1
	$dockerCLI image prune -a -f
	echo "Done"
}

function runTest {
	echo "Run some test"
}

compileAPI
prepareEnv
runTest
decommissionEnv
