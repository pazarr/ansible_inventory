package main

import (
    "database/sql"
    "fmt"
    "strconv"
    "log"
    "time"
    _ "github.com/go-sql-driver/mysql"
)

func apiCall(fromPost map[string][]string) map[string]interface {} {
	//DB setup
        database, err := sql.Open("mysql", databaseConnection)
        if err != nil {
                panic(err)
        }
        database.SetConnMaxLifetime(time.Minute * 3)
        database.SetMaxOpenConns(10)
        database.SetMaxIdleConns(10)
	//Vars
	//var returnMsg map[string]interface {}
	returnMsg := make(map[string]interface {})
	if len(fromPost["query"][0]) == 0 {
		returnMsg["Error"] = "Invalid query"
	} else {
	//processing query result
		switch fromPost["query"][0] {
			case "list":
				return getAllList()
				break
			case "host":
				if len(fromPost["hostname"]) != 0 {
					return getHostDetails(fromPost["hostname"][0])
                                } else {
					returnMsg["Error"] = "Error, no arguments has received"
                                }
				break
			case "addHost":
				if len(fromPost["hostname"]) != 0 && len(fromPost["group"]) != 0 {
					var groupId int
          cursor := database.QueryRow("SELECT group_id from hostgroups WHERE name=\"" + fromPost["group"][0] +"\"")
					cursor.Scan(&groupId)
					if groupId != 0 {
// If we have the group, we insert the new host to inventory
          insert, err := database.Exec("INSERT INTO hosts(name) values(\"" + fromPost["hostname"][0] + "\")")
// If SQL fails we report error and break
          if err != nil {
            fmt.Println( err.Error())
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = err.Error
            break
            //log.Fatal(err)
          }
// Fetch ID from last SQL query
          hostId, err := insert.LastInsertId()
          if err != nil {
            fmt.Println(err.Error())
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = err.Error
            break
            //log.Fatal(err)
          }
          _, err = database.Exec("INSERT INTO memberships values(" + strconv.Itoa(groupId) + "," + strconv.FormatInt(hostId, 10) + ")")
          if err != nil {
            fmt.Println(err.Error())
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = err.Error
            break
            //log.Fatal(err)
          } else {
            fmt.Printf("Server name: %s with host ID: %s", fromPost["hostname"][0], strconv.FormatInt(hostId, 10))
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Info"
            returnMsg["Message"] = "Successfully added new host: " + fromPost["hostname"][0]
          }
				} else {
          fmt.Printf("Wrong argument provided")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = "Wrong argument provided"
				}
				break
			case "removeHost":
				if len (fromPost["hostname"]) != 0 {
					var hostId int64
					cursor := database.QueryRow("SELECT host_id FROM hosts WHERE name=\"" + fromPost["hostname"][0] + "\"")
					cursor.Scan(&hostId)
					if hostId <= 0 {
						fmt.Println("Host is not found with name: " + fromPost["hostname"][0])
                                                returnMsg["Timestamp"] = currentTime.String()
                                                returnMsg["Action"] = "Remove host from inventory"
						returnMsg["Level"] = "Error"
                                                returnMsg["Message"] = "Couldn't find host  " + fromPost["hostname"][0]
					} else {
					}
						_, err := database.Exec("DELETE FROM hosts WHERE host_id=\"" + strconv.FormatInt(hostId, 10) + "\"")
                                                if err != nil {
                                                        fmt.Println("SQL error during host delete " + err.Error())
	                                                returnMsg["Timestamp"] = currentTime.String()
        	                                        returnMsg["Action"] = "SQL query"
                	                                returnMsg["Level"] = "Error"
                        	                        returnMsg["Message"] = err.Error()
//                                                        log.Fatal(err)
                                                } else {
                                                fmt.Println("Host is not found with name: " + fromPost["hostname"][0])
                                                returnMsg["Timestamp"] = currentTime.String()
                                                returnMsg["Action"] = "Remove host from inventory"
                                                returnMsg["Level"] = "Info"
                                                returnMsg["Message"] = "Removed " + fromPost["hostname"][0] + " from inventory"
						}
				}
				break
                        case "removeFromGroup":
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
                                                returnMsg["Msg"] = "Successfully removed: " + fromPost["hostname"][0]
                                        }
                                }
                                break
		}
	}
	return returnMsg
}
