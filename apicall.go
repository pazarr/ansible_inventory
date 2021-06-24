package main

import (
    "database/sql"
    "fmt"
    "strconv"
    "time"
    _ "github.com/go-sql-driver/mysql"
)
//Api calls via POST JSON body
func apiCallJSON(postBody map[string]interface{}) map[string]interface {} {
  returnMsg := make(map[string]interface {})
  currentTime := time.Now()
  if query, ok := postBody["query"] ; ok {
    switch query {
//This block is legacy and must go in the future
      case "getAnsibleList":
        returnMsg = getAllList()
        fmt.Printf("List call")
        break
      case "getAnsibleHost":
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
      case "getGroups":
        returnMsg = getGroupList()
        break
      case "removeHostFromInventory":
        if _, ok := postBody["hostname"] ; ok {
          fmt.Printf("Remove hosts ")
          hostList := postBody["hostname"].([]interface{})
          aString := make([]string, len(hostList))
          for i, v := range hostList {
            aString[i] = v.(string)
          }
          fmt.Printf("%q\n", hostList)
          returnMsg = removeHostFromInventory(aString)
        } else {
          fmt.Println("Valid JSON query, but no acction associated")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Info"
          returnMsg["Message"] = "Valid JSON query, but no actin associated"
          returnMsg["Query"] = query
        }
        break
    }
  } else {
    fmt.Println("Valid JSON query")
    returnMsg["Timestamp"] = currentTime.String()
    returnMsg["Level"] = "Info"
    returnMsg["Message"] = "Valid JSON query"
    returnMsg["Query"] = query
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
		switch fromPost["query"][0] {
//This block is legacy and must go in the future
			case "list":
				return getAllList()
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
      case "getAnsibleList":
				return getAllList()
        fmt.Printf("List call")
				break
      case "getAnsibleHost":
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
      case "getGroups":
        returnMsg = getGroupList()
        break
			case "addHost":
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
      case "removeHost":
        if len(fromPost["hostname"]) != 0 {
        	var hostId int64
        	cursor := database.QueryRow("SELECT host_id FROM hosts WHERE name=\"" + fromPost["hostname"][0] + "\"")
        	err := cursor.Scan(&hostId)
        	if ( err == sql.ErrNoRows ) {
            fmt.Printf("No host " + fromPost["hostname"][0] + " found")
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = "No host " + fromPost["hostname"][0] +" found"
            break
          }
        	_, err = database.Exec("DELETE FROM hosts WHERE host_id=\"" + strconv.FormatInt(hostId, 10) + "\"")
          if err != nil {
            fmt.Println("SQL error during host delete " + err.Error())
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = err.Error()
            break
          } else {
            fmt.Println("Deleted host from inventory: " + fromPost["hostname"][0])
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Info"
            returnMsg["Message"] = "Removed host " + fromPost["hostname"][0] + " from inventory"
          }
        } else {
          fmt.Println("Missing hostname from the query")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = "Missing hostname from the query"
        }
        break
      case "removeHostFromGroup":
        if len(fromPost["hostname"]) != 0 && len(fromPost["group"]) != 0 {
        var hostId int64
        var groupId int64
        cursor := database.QueryRow("SELECT host_id FROM hosts WHERE name=\"" + fromPost["hostname"][0] + "\"")
        err := cursor.Scan(&hostId)
        if ( err == sql.ErrNoRows ) {
          fmt.Println("Host is not found")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = fromPost["hostname"][0] + " host is not found"
          break
        }
        cursor = database.QueryRow("SELECT group_id FROM hostgroups WHERE name=\"" + fromPost["group"][0] + "\"")
        err = cursor.Scan(&groupId)
        if ( err == sql.ErrNoRows ) {
          fmt.Println("Hostsroup is not found")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = fromPost["group"][0] + " hostgroup is not found"
          break
        }
        cursor = database.QueryRow("SELECT host_id FROM memberships WHERE host_id=" + strconv.FormatInt(hostId, 10) + " AND group_id=" + strconv.FormatInt(groupId, 10))
        err = cursor.Scan(&hostId)
        if ( err == sql.ErrNoRows ) {
          fmt.Println(fromPost["hostname"][0] +" host is not member of the " + fromPost["group"][0])
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] =  fromPost["hostname"][0] + " host is not member of " + fromPost["group"][0] + " hostgroup"
          break
        }
        _, err = database.Exec("DELETE FROM memberships WHERE host_id=\"" + strconv.FormatInt(hostId, 10) + "\" AND group_id=\"" + strconv.FormatInt(groupId, 10) + "\"")
        if err != nil {
          fmt.Println(err.Error())
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = err.Error()
          break
        }
        fmt.Println("Host removed from hostgroup")
        returnMsg["Timestamp"] = currentTime.String()
        returnMsg["Level"] = "Info"
        returnMsg["Message"] = "Host removed from hostgroup"
        } else {
          fmt.Println("Missing arguments")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = "Missing arguments"
          break
       }
       break
     case "addHostVar":
       if len(fromPost["hostname"]) != 0 && len(fromPost["hostvar"]) != 0 && len(fromPost["value"]) != 0 {
         var hostId int64
         var qCount int
//Is hostname is valid?
         cursor := database.QueryRow("SELECT host_id from hosts WHERE name=\"" + fromPost["hostname"][0] +"\"")
         err := cursor.Scan(&hostId)
         if ( err == sql.ErrNoRows ) {
           fmt.Printf("Host name is not registered")
           returnMsg["Timestamp"] = currentTime.String()
           returnMsg["Level"] = "Error"
           returnMsg["Message"] = "This host name is not registeres"
           break
         }
         cursor = database.QueryRow("SELECT * from hostvars WHERE host_id=" + strconv.FormatInt(hostId, 10) + " AND host_var=\"" + fromPost["hostvar"][0] + "\"")
         err = cursor.Scan(&qCount)
         if ( err == sql.ErrNoRows ) {
           _,err = database.Exec("INSERT INTO hostvars(host_id,host_var,value) VALUES(" + strconv.FormatInt(hostId, 10) + ",\"" + fromPost["hostvar"][0] + "\",\"" + fromPost["value"][0] + "\")")
           if err != nil {
             fmt.Printf(err.Error())
             returnMsg["Timestamp"] = currentTime.String()
             returnMsg["Level"] = "Error"
             returnMsg["Message"] = err.Error()
             break
           }
           fmt.Printf("Register new host variable")
           returnMsg["Timestamp"] = currentTime.String()
           returnMsg["Level"] = "Info"
           returnMsg["Message"] = "Register new host variable"
           break
         } else {
           _,err = database.Exec("UPDATE hostvars SET value=\"" + fromPost["value"][0] + "\" WHERE host_id=\"" + strconv.FormatInt(hostId, 10) + "\" AND host_var=\"" + fromPost["hostvar"][0] + "\"")
           if err != nil {
             fmt.Printf(err.Error())
             returnMsg["Timestamp"] = currentTime.String()
             returnMsg["Level"] = "Error"
             returnMsg["Message"] = err.Error()
             break
           }
           fmt.Printf("Update host variable")
           returnMsg["Timestamp"] = currentTime.String()
           returnMsg["Level"] = "Info"
           returnMsg["Message"] = "Update host variable"
         }
       }
      break
    case "addGroupVar":
      if len(fromPost["group"]) != 0 && len(fromPost["groupvar"]) != 0 && len(fromPost["value"]) != 0 {
        var groupId int64
        var qCount int
//Is hostname is valid?
        cursor := database.QueryRow("SELECT group_id from hostgroups WHERE name=\"" + fromPost["group"][0] +"\"")
        err := cursor.Scan(&groupId)
        if ( err == sql.ErrNoRows ) {
          fmt.Printf("Hostgroup name is not registered")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Message"] = "This hostgroup name is not registered"
          break
        }
        cursor = database.QueryRow("SELECT * from groupvars WHERE group_id=" + strconv.FormatInt(groupId, 10) + " AND group_var=\"" + fromPost["groupvar"][0] + "\"")
        err = cursor.Scan(&qCount)
        if ( err == sql.ErrNoRows ) {
          _,err = database.Exec("INSERT INTO groupvars(group_id,group_var,value) VALUES(" + strconv.FormatInt(groupId, 10) + ",\"" + fromPost["groupvar"][0] + "\",\"" + fromPost["value"][0] + "\")")
          if err != nil {
            fmt.Printf(err.Error())
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = err.Error()
            break
          }
          fmt.Printf("Register new hostgroup variable")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Info"
          returnMsg["Message"] = "Register new hostgroup variable"
          break
        } else {
          _,err = database.Exec("UPDATE groupvars SET value=\"" + fromPost["value"][0] + "\" WHERE group_id=\"" + strconv.FormatInt(groupId, 10) + "\" AND group_var=\"" + fromPost["groupvar"][0] + "\"")
          if err != nil {
            fmt.Printf(err.Error())
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = err.Error()
            break
          }
          fmt.Printf("Update hostgroup variable")
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Info"
          returnMsg["Message"] = "Update hostgroup variable"
        }
      }
     break
   }
  }
  return returnMsg
 }
