package main

import (
    "database/sql"
    "fmt"
    "strconv"
    "time"
    "strings"
    _ "github.com/go-sql-driver/mysql"
)
//Api calls via POST JSON body
func apiCallJSON(postBody map[string]interface{}) map[string]interface {} {
  returnMsg := make(map[string]interface {})
  currentTime := time.Now()
  if query, ok := postBody["query"] ; ok {
    str := fmt.Sprintf("%v", query)
    switch strings.ToLower(str) {
    case "getansiblelist":
        returnMsg = getAllList()
        fmt.Printf("List call")
        break
      case "getansiblehost":
        if hostnameAnsibleQuery, ok := postBody["hostname"] ; ok {
          fmt.Printf("Host call")
          str := fmt.Sprintf("%v", hostnameAnsibleQuery)
          returnMsg = getHostDetails(str)
        } else {
          fmt.Println("Valid JSON query")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Info"
          returnMsg["Message"] = "Valid JSON query"
          returnMsg["Query"] = query
        }
        break
      case "getgroups":
        returnMsg = getGroupList()
        break
      case "removehostfrominventory":
        if hostnameAnsibleQuery, ok := postBody["hostname"] ; ok {
          fmt.Printf("Query: removeHostFromInventory")
          str := fmt.Sprintf("%v", hostnameAnsibleQuery)
          returnMsg = removeHostFromInventory(str)
        } else {
          fmt.Println("Valid JSON query")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Info"
          returnMsg["Message"] = "Valid JSON query"
          returnMsg["Query"] = query
        }
        break
      case "removehostfromgroup":
        var hostName string
        var groupName string
        if hostnameAnsibleQuery, ok := postBody["hostname"] ; ok {
          hostName = fmt.Sprintf("%v", hostnameAnsibleQuery)
          } else {
              fmt.Println("Hostname is missing from the query")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Hostname is missing from the query"
              returnMsg["Query"] = query
              break
        }
        if groupnameAnsibleQuery, ok := postBody["groupname"] ; ok {
          groupName = fmt.Sprintf("%v", groupnameAnsibleQuery)
          } else {
              fmt.Println("Hostgroup name is missing from the query")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Hostgroup name is missing from the query"
              returnMsg["Query"] = query
              break
        }
        returnMsg = removeHostFromGroup(hostName,groupName)
        break
      case "addhostvar":
        var hostName, hostvarName, hostvarValue string
        if hostNameQuery, ok := postBody["hostname"] ; ok {
          hostName = fmt.Sprintf("%v", hostNameQuery)
          } else {
              fmt.Println("Hostname is missing from the query")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Hostname is missing from the query"
              returnMsg["Query"] = query
              break
        }
        if hostvarNameQuery, ok := postBody["hostvarname"] ; ok {
          hostvarName = fmt.Sprintf("%v", hostvarNameQuery)
          } else {
              fmt.Println("host variable name is missing from the query")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Host variable name(hostvarname) is missing from the query"
              returnMsg["Query"] = query
              break
        }
        if hostvarValueQuery, ok := postBody["hostvarvalue"] ; ok {
          hostvarValue = fmt.Sprintf("%v", hostvarValueQuery)
          } else {
              fmt.Println("host variable value is missing from the query")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Host variable value(hostvarvalue) is missing from the query"
              returnMsg["Query"] = query
              break
            }
        returnMsg = addHostVar(hostName,hostvarName,hostvarValue)
        break
      case "addgroupvar":
        var groupName, groupvarName, groupvarValue string
        if groupNameQuery, ok := postBody["groupname"] ; ok {
          groupName = fmt.Sprintf("%v", groupNameQuery)
          } else {
              fmt.Println("Groupname is missing from the query")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Groupname is missing from the query"
              returnMsg["Query"] = query
              break
        }
        if groupvarNameQuery, ok := postBody["groupvarname"] ; ok {
          groupvarName = fmt.Sprintf("%v", groupvarNameQuery)
          } else {
              fmt.Println("Group variable name is missing from the query")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Group variable name(groupvarname) is missing from the query"
              returnMsg["Query"] = query
              break
        }
        if groupvarValueQuery, ok := postBody["groupvarvalue"] ; ok {
          groupvarValue = fmt.Sprintf("%v", groupvarValueQuery)
          } else {
              fmt.Println("Group variable value is missing from the query")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Group variable value(groupvarvalue) is missing from the query"
              returnMsg["Query"] = query
              break
            }
        returnMsg = addGroupVar(groupName,groupvarName,groupvarValue)
        break
      default:
        fmt.Println("Query is not valid on this context")
        returnMsg["Timestamp"] = currentTime.String()
        returnMsg["Level"] = "Error"
        returnMsg["Message"] = "Query is not valid in this context. Please note, query string is "
        returnMsg["Query"] = query
        break
      }
  } else {
      fmt.Println("Missing query field")
      returnMsg["Timestamp"] = currentTime.String()
      returnMsg["Level"] = "Error"
      returnMsg["Message"] = "Missing query field"
      returnMsg["PostBody"] = postBody
    }
  return returnMsg
}

//Api calls via POST forms
func apiCallFORM(fromPost map[string][]string) map[string]interface {} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
    panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
	//Vars
  currentTime := time.Now()
	returnMsg := make(map[string]interface {})

	if len(fromPost) == 0 {
    fmt.Println("Missing query parameter")
    returnMsg["Timestamp"] = currentTime.String()
    returnMsg["Level"] = "Error"
    returnMsg["Message"] = "Missing query parameter"
	} else {
	//processing query result
		switch strings.ToLower(fromPost["query"][0]) {
//This block is legacy and must go in the future
			case "list":
				return getAnsibleAllList()
        fmt.Printf("List call")
				break
			case "host":
        if len(fromPost["hostname"]) != 0 {
          fmt.Printf("Host call")
          return getHostDetails(fromPost["hostname"][0])
        } else {
          fmt.Printf("Hostname argument is missing")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = "Hostname argument is missing"
        }
        break
//Legacy blocks end
      case "getansiblelist":
				return getAnsibleAllList()
        fmt.Printf("List call")
				break
      case "getansiblehost":
        if len(fromPost["hostname"]) != 0 {
          fmt.Printf("Host call")
          return getHostDetails(fromPost["hostname"][0])
        } else {
          fmt.Printf("Hostname argument is missing")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = "Hostname argument is missing"
        }
        break
      case "getgroups":
        returnMsg = getGroupList()
        break
			case "addhost":
				if len(fromPost["hostname"]) != 0 && len(fromPost["group"]) != 0 {
					var groupId, count int
          var hostId int64
// Is hostgroup name valid?
          cursor := database.QueryRow("SELECT group_id from hostgroups WHERE name=\"" + fromPost["group"][0] +"\"")
					err := cursor.Scan(&groupId)
					if ( err != nil ) {
            fmt.Printf("Group doesn't exist")
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = "Group doesn't exist"
            break
          }
          cursor = database.QueryRow("SELECT count(*) from hosts WHERE name=\"" + fromPost["hostname"][0] +"\"")
          cursor.Scan(&count)
          if ( count != 0 ) {
            fmt.Printf("Host name is already registered")
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = "This host name is already registeres"
            break
          }
          insert, err := database.Exec("INSERT INTO hosts(name) values(\"" + fromPost["hostname"][0] + "\")")
// If SQL fails we report error and break
            if err != nil {
              fmt.Println( err.Error())
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = err.Error
              break
            }
// Fetch ID from last SQL query
            hostId, err = insert.LastInsertId()
            if err != nil {
              fmt.Println(err.Error())
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = err.Error
              break
            }
            _, err = database.Exec("INSERT INTO memberships values(" + strconv.Itoa(groupId) + "," + strconv.FormatInt(hostId, 10) + ")")
            if err != nil {
              fmt.Println(err.Error())
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = err.Error
              break
            }
            fmt.Printf("Server name: %s with host ID: %s", fromPost["hostname"][0], strconv.FormatInt(hostId, 10))
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Info"
            returnMsg["Message"] = "Successfully added new host: " + fromPost["hostname"][0]
				  } else {
              fmt.Printf("Missing argument")
              returnMsg["Timestamp"] = currentTime.String()
              returnMsg["Level"] = "Error"
              returnMsg["Message"] = "Missing argument"
        }
  			break
      case "removehostfrominventory":
        if hostnameAnsibleQuery, ok := fromPost["hostname"] ; ok {
          fmt.Printf("Query: removeHostFromInventory")
          returnMsg = removeHostFromInventory(hostnameAnsibleQuery[0])
        } else {
          fmt.Println("Valid JSON query")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Info"
          returnMsg["Message"] = "Valid JSON query"
          returnMsg["Query"] = "removeHostFromInventory"
        }
        break
      case "removehostfromgroup":
        if len(fromPost["hostname"][0]) != 0 && len(fromPost["groupname"][0]) != 0 {
          returnMsg = removeHostFromGroup(fromPost["hostname"][0],fromPost["groupname"][0])
        } else {
          fmt.Println("Missing arguments")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = "Missing arguments"
          break
       }
       break
     case "addhostvar":
       if len(fromPost["hostname"]) != 0 && len(fromPost["hostvarname"]) != 0 && len(fromPost["hostvarvalue"]) != 0 {
         returnMsg = addHostVar(fromPost["hostname"][0],fromPost["hostvarname"][0],fromPost["hostvarvalue"][0])
       } else {
         fmt.Println("Missing arguments")
         returnMsg["Timestamp"] = currentTime.String()
         returnMsg["Level"] = "Error"
         returnMsg["Query"] = "addHostVar"
         returnMsg["Message"] = "Missing arguments"
         break
      }
      break
    case "addgroupvar":
      if len(fromPost["groupname"]) != 0 && len(fromPost["groupvarname"]) != 0 && len(fromPost["groupvarvalue"]) != 0 {
        returnMsg = addGroupVar(fromPost["groupname"][0],fromPost["groupvarname"][0],fromPost["groupvarvalue"][0])
      } else {
        fmt.Println("Missing arguments")
        returnMsg["Timestamp"] = currentTime.String()
        returnMsg["Level"] = "Error"
        returnMsg["Query"] = "addGroupVar"
        returnMsg["Message"] = "Missing arguments"
        break
     }
     break
   }
  }
  return returnMsg
 }
