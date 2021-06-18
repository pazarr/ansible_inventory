package main

import (
    "database/sql"
    "fmt"
    "strconv"
    "log"
    "time"
    _ "github.com/go-sql-driver/mysql"
)

func apiCall(fromPost map[string][]string) string {
	//DB setup
        database, err := sql.Open("mysql", databaseConnection)
        if err != nil {
                panic(err)
        }
        database.SetConnMaxLifetime(time.Minute * 3)
        database.SetMaxOpenConns(10)
        database.SetMaxIdleConns(10)
	//Vars
	var returnMsg = "Invalid call"
	if len(fromPost["query"][0]) == 0 {
		returnMsg = "Invalid query"
	} else {
	//processing query result
		switch fromPost["q"][0] {
			case "addHost":
				if len(fromPost["hostname"]) != 0 && len(fromPost["group"]) != 0 {
					var groupId int
					insert, err := database.Exec("INSERT INTO hosts(name) values(\"" + fromPost["hostname"][0] + "\")")
					if err != nil {
						fmt.Println("SQL error: ")
				                log.Fatal(err)
					}
					hostId, err := insert.LastInsertId()
					if err != nil {
						log.Fatal(err)
					}
					cursor := database.QueryRow("SELECT group_id from hostgroups WHERE name=\"" + fromPost["group"][0] +"\"")
					cursor.Scan(&groupId)
					if groupId != 0 {
						_, err = database.Exec("INSERT INTO memberships values(" + strconv.Itoa(groupId) + "," + strconv.FormatInt(hostId, 10) + ")")
	                                        if err != nil {
	                                                fmt.Println("SQL error during insert to membership table: ")
	                                                log.Fatal(err)
	                                        }
						fmt.Printf("Server name: %s with host ID: %s", fromPost["hostname"][0], strconv.FormatInt(hostId, 10))
						returnMsg = "Successfully added new host: " + fromPost["hostname"][0]
					}
				} else {
					returnMsg = "Error, no arguments has received"
				}
				break
			case "removeHost":
				if len (fromPost["hostname"]) != 0 {
					var hostId int64
					cursor := database.QueryRow("SELECT host_id FROM hosts WHERE name=\"" + fromPost["hostname"][0] + "\"")
					cursor.Scan(&hostId)
					if hostId <= 0 {
						fmt.Println("Host is not found with name: " + fromPost["hostname"][0])
					} else {
					}
						_, err := database.Exec("DELETE FROM hosts WHERE rowid=\"" + strconv.FormatInt(hostId, 10) + "\"")
                                                if err != nil {
                                                        fmt.Println("SQL error during host delete: ")
                                                        log.Fatal(err)
                                                }
				}
				break
                        case "rmFromGroup":
                                if len(fromPost["hostname"]) != 0 && len(fromPost["group"]) != 0 {
                                        var hostId int64
					var groupId int64
                                        cursor := database.QueryRow("SELECT host_id FROM hosts WHERE name=\"" + fromPost["hostname"][0] + "\"")
                                        cursor.Scan(&hostId)
                                        cursor = database.QueryRow("SELECT host_id FROM hostgroups WHERE name=\"" + fromPost["group"][0] + "\"")
                                        cursor.Scan(&groupId)
                                        if (hostId >= 0 && groupId >= 0) {
						_, err := database.Exec("DELETE FROM memberships WHERE host_id=\"" + strconv.FormatInt(hostId, 10) + "\" AND group_id=\"" + strconv.FormatInt(groupId, 10) + "\"")
                                                if err != nil {
                                                        fmt.Println("SQL error during membership termination: ")
                                                        log.Fatal(err)
                                                }
                                                returnMsg = "Successfully removed: " + fromPost["hostname"][0]
                                        }
                                }
                                break
		}
	}
	return returnMsg
}


