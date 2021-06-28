package main

import (
    "database/sql"
    "fmt"
    "strconv"
    "log"
    "time"
    _ "github.com/go-sql-driver/mysql"
)

func getHostDetails(hostName string) map[string]interface {} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
    panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
  //Vars
  var allVars = make(map[string]interface {})
  var hostVarName string
  var hostVarValue string
  hostVars, err :=
   database.Query("SELECT host_var, value FROM hostvars WHERE host_id = (SELECT host_id FROM hosts WHERE name='" + hostName + "');")
	if err != nil {
		fmt.Println("SQL select error: ")
		log.Fatal(err)
	}
	for hostVars.Next() {
		hostVars.Scan(&hostVarName, &hostVarValue)
		allVars[hostVarName] = hostVarValue
	}
        return allVars
}

func getHostList() map[string]interface{} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
    panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
  //Vars
  var allHost []string
  var hostName string
  fetchAllHost, err :=
  database.Query("SELECT name FROM hosts ORDER BY name ASC")
  if err != nil {
    fmt.Println("SQL select error: ")
    log.Fatal(err)
  }
  for fetchAllHost.Next() {
    fetchAllHost.Scan(&hostName)
    allHost = append(allHost,hostName)
  }
  hostMap := map[string]interface{}{
    "hosts": allHost,
  }
  return hostMap
}

func getMetaData() map[string]interface{} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
    panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
  //Vars
  var hostVarName string
  var hostVarValue string
  var hostId int
  var hostName string
  var hostMap = make(map[string]interface{})
  var allVars = make(map[string]string)

  allHost, err := database.Query("SELECT host_id,name FROM hosts ORDER BY name ASC")
  if err != nil {
    fmt.Println("SQL select error: ")
    log.Fatal(err)
  }
  for allHost.Next() {
    allHost.Scan(&hostId,&hostName)
    hostVars, err :=
    database.Query("SELECT host_var, value FROM hostvars WHERE host_id=" + strconv.Itoa(hostId))
    if err != nil {
      fmt.Println("SQL select error: ")
      log.Fatal(err)
    }
    allVars = make(map[string]string)
    for hostVars.Next() {
      hostVars.Scan(&hostVarName, &hostVarValue)
      allVars[hostVarName] = hostVarValue
    }
    hostMap[hostName] = allVars
  }
  return hostMap
  }

func getGroupList() map[string]interface{} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
          panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
  //Vars
  var combinedMap = make(map[string]interface{})
  var hostName string
  var groupVarName string
  var groupVarValue string
  var groupName string
  grouprows, err :=
          database.Query("SELECT group_id,name FROM hostgroups ORDER BY name ASC")
  if err != nil {
    fmt.Println(err.Error())
  }
  //Create map groups and hosts
  for grouprows.Next() {
    var allHosts []string
    var allVars = make(map[string]string)
    var groupId int
    grouprows.Scan(&groupId, &groupName)
    hostAssoc, err :=
      database.Query("SELECT name FROM hosts WHERE host_id IN (SELECT host_id FROM memberships WHERE group_id=" + strconv.Itoa(groupId) + ");")
          if err != nil {
            fmt.Println(err.Error())
    }
    for hostAssoc.Next() {
      hostAssoc.Scan(&hostName)
      allHosts = append(allHosts,hostName)
    }
    groupVars, err :=
      database.Query("SELECT group_var, value FROM groupvars WHERE group_id=" + strconv.Itoa(groupId))
    if err != nil {
      fmt.Println(err.Error())
    }
    for groupVars.Next() {
      groupVars.Scan(&groupVarName, &groupVarValue)
      allVars[groupVarName] = groupVarValue
    }
    groupMap := map[string]interface{}{
      "hosts": allHosts,
      "vars": allVars,
                }
    combinedMap[groupName] = groupMap
  }
  return combinedMap
}

func getAllList() map[string]interface{} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
          panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
  //Vars
  var parentName string
  var groupName string
  var parentVarName string
  var parentVarValue string
	var combinedMap = make(map[string]interface{})
  var hostName string
  var groupVarName string
  var groupVarValue string
  grouprows, err :=
          database.Query("SELECT group_id,name FROM hostgroups ORDER BY name ASC")
  if err != nil {
    fmt.Println(err.Error())
  }
  //Create map groups and hosts
  for grouprows.Next() {
    var allGroup []string
    var allVars = make(map[string]string)
    var groupId int
    grouprows.Scan(&groupId, &groupName)
    hostAssoc, err :=
      database.Query("SELECT name FROM hosts WHERE host_id IN (SELECT host_id FROM memberships WHERE group_id=" + strconv.Itoa(groupId) + ");")
          if err != nil {
            fmt.Println(err.Error())
    }
    for hostAssoc.Next() {
      hostAssoc.Scan(&hostName)
      allGroup = append(allGroup,hostName)
    }
    groupVars, err :=
      database.Query("SELECT group_var, value FROM groupvars WHERE group_id=" + strconv.Itoa(groupId))
    if err != nil {
      fmt.Println(err.Error())
    }
    for groupVars.Next() {
      groupVars.Scan(&groupVarName, &groupVarValue)
      allVars[groupVarName] = groupVarValue
    }
    groupMap := map[string]interface{}{
      "hosts": allGroup,
      "vars": allVars,
                }
    combinedMap[groupName] = groupMap
  }

//Set all host list
  combinedMap["all"] = getHostList()
// Set all host metadata
  combinedMap["_meta"] = getMetaData()
//Fetch all Parent groups and handle SQL error
//        database, _ := sql.Open("sqlite3", "./ansible.db")
  rows, err :=
          database.Query("SELECT parent_id,name FROM parentgroups ORDER BY name ASC")
  if err != nil {
          fmt.Println("SQL select error: ")
          log.Fatal(err)
  }
//Create map from all children of the Parent
  for rows.Next() {
    var allGroup []string
    var allVars = make(map[string]string)
		var rowId int
		rows.Scan(&rowId, &parentName)
		groupAssoc, err :=
			database.Query("SELECT name FROM hostgroups WHERE group_id IN (SELECT group_id FROM parent_child WHERE parent_id=" + strconv.Itoa(rowId) + ");")
	        if err != nil {
			fmt.Println("SQL select error: ")
			log.Fatal(err)
		}
		for groupAssoc.Next() {
			groupAssoc.Scan(&groupName)
			allGroup = append(allGroup,groupName)
		}
		parentVars, err :=
			database.Query("SELECT parent_var, value FROM parentvars WHERE parent_id=" + strconv.Itoa(rowId))
		if err != nil {
			fmt.Println("SQL select error: ")
			log.Fatal(err)
		}
		for parentVars.Next() {
			parentVars.Scan(&parentVarName, &parentVarValue)
			allVars[parentVarName] = parentVarValue
		}
		parentMap := map[string]interface{} {
			"children": allGroup,
			"vars": allVars,
    }
		combinedMap[parentName] = parentMap
	}
        return combinedMap
}

func removeHostFromInventory(hostname string) map[string]interface{} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
    panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
  //Vars
  returnMsg := make(map[string]interface {})
  currentTime := time.Now()
  var hostId int64
  if len(hostname) > 0 {
    err = database.QueryRow("SELECT host_id FROM hosts WHERE name = ?", hostname).Scan(&hostId)
    if err == sql.ErrNoRows {
      fmt.Printf("No host " + hostname + " found")
      returnMsg["Timestamp"] = currentTime.String()
      returnMsg["Level"] = "Error"
      returnMsg["Query"] = "removeHostFromInventory"
      returnMsg["Message"] = "No host " + hostname +" found"
    }
    if err == nil {
      _, err = database.Exec("DELETE FROM hosts WHERE host_id=\"" + strconv.FormatInt(hostId, 10) + "\"")
      if err != nil {
        fmt.Println("SQL error during host delete " + err.Error())
        returnMsg["Timestamp"] = currentTime.String()
        returnMsg["Level"] = "Error"
        returnMsg["Query"] = "removeHostFromInventory"
        returnMsg["Message"] = err.Error()
      } else {
          fmt.Println("Deleted host from inventory: " + hostname)
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Info"
          returnMsg["Query"] = "removeHostFromInventory"
          returnMsg["Message"] = hostname + "is removed from inventory"
      }
    }
  } else {
      fmt.Println("Missing hostname(s) from the query")
      returnMsg["Timestamp"] = currentTime.String()
      returnMsg["Level"] = "Error"
      returnMsg["Query"] = "removeHostFromInventory"
      returnMsg["Message"] = "Missing hostname(s) from the query"
  }
  return returnMsg
}

func removeHostFromGroup(hostName string, groupName string) map[string]interface{} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
          panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
  returnMsg := make(map[string]interface {})
  currentTime := time.Now()
  var hostId int64
  var groupId int64
  err = database.QueryRow("SELECT group_id FROM hostgroups WHERE name = ?", groupName).Scan(&groupId)
  if err == sql.ErrNoRows {
    fmt.Printf("No hostgroup " + groupName + " found")
    returnMsg["Timestamp"] = currentTime.String()
    returnMsg["Level"] = "Error"
    returnMsg["Query"] = "removeHostFromGroup"
    returnMsg["Message"] = "No hostgroup " + groupName +" found"
  }
  if err == nil {
    err = database.QueryRow("SELECT host_id FROM hosts WHERE name = ?", hostName).Scan(&hostId)
    if err == sql.ErrNoRows {
      fmt.Printf("No host " + hostName + " found")
      returnMsg["Timestamp"] = currentTime.String()
      returnMsg["Level"] = "Error"
      returnMsg["Query"] = "removeHostFromGroup"
      returnMsg["Message"] = "No host " + hostName +" found"
    }
    if err == nil {
        err = database.QueryRow("SELECT host_id FROM memberships WHERE host_id=? AND group_id=?", strconv.FormatInt(hostId, 10), strconv.FormatInt(groupId, 10)).Scan(&hostId)
        if err == sql.ErrNoRows {
          fmt.Printf("Host " + hostName + " is not member of" + groupName)
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Query"] = "removeHostFromGroup"
          returnMsg["Message"] = hostName + " host is not member of " + groupName + " hostgroup"
        }
      if err == nil {
        _, err = database.Exec("DELETE FROM memberships WHERE host_id=? AND group_id=?",strconv.FormatInt(hostId, 10),strconv.FormatInt(groupId, 10))
        fmt.Printf("fourth")
        if err != nil {
          fmt.Println(err.Error())
          returnMsg["Timestamp"] = currentTime.String()
          returnMsg["Level"] = "Error"
          returnMsg["Query"] = "removeHostFromGroup"
          returnMsg["Message"] = err.Error()
        } else {
            fmt.Println("Host removed from hostgroup")
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Info"
            returnMsg["Query"] = "removeHostFromGroup"
            returnMsg["Message"] = hostName + " removed from " + groupName + " hostgroup"
        }
      }
    }
  }
  return returnMsg
 }

 func addHostVar(hostName string, hostvarName string, hostvarValue string) map[string]interface{} {
   //DB setup
   database, err := sql.Open("mysql", databaseConnection)
   if err != nil {
    panic(err)
   }
   database.SetConnMaxLifetime(time.Minute * 3)
   database.SetMaxOpenConns(10)
   database.SetMaxIdleConns(10)
   returnMsg := make(map[string]interface {})
   currentTime := time.Now()
   var hostId int64
   var qCount int
   err = database.QueryRow("SELECT host_id FROM hosts WHERE name = ?",hostName).Scan(&hostId)
   if err == sql.ErrNoRows {
     fmt.Printf("No host " + hostName + " found")
     returnMsg["Timestamp"] = currentTime.String()
     returnMsg["Level"] = "Error"
     returnMsg["Query"] = "addHostVar"
     returnMsg["Message"] = "No host " + hostName +" found"
   } else {
    err = database.QueryRow("SELECT value from hostvars WHERE host_id=? AND host_var=?",strconv.FormatInt(hostId, 10),hostvarName).Scan(&qCount)
    if err == sql.ErrNoRows {
      _,err = database.Exec("INSERT INTO hostvars(host_id,host_var,value) VALUES(?,?,?)",strconv.FormatInt(hostId, 10),hostvarName,hostvarValue)
      if err == nil {
        fmt.Printf("Register new host variable")
        returnMsg["Timestamp"] = currentTime.String()
        returnMsg["Level"] = "Info"
        returnMsg["Message"] = "Register new host variable"
      } else {
        fmt.Printf(err.Error())
        returnMsg["Timestamp"] = currentTime.String()
        returnMsg["Level"] = "Error"
        returnMsg["Query"] = "addHostVar"
        returnMsg["Message"] = err.Error()
      }
    } else {
      _,err = database.Exec("UPDATE hostvars SET value=? WHERE host_id=? AND host_var=?",hostvarValue,strconv.FormatInt(hostId, 10),hostvarName)
      if err == nil {
        fmt.Printf("Update host variable")
        returnMsg["Timestamp"] = currentTime.String()
        returnMsg["Level"] = "Info"
        returnMsg["Message"] = "Update host variable"
      } else {
        fmt.Printf(err.Error())
        returnMsg["Timestamp"] = currentTime.String()
        returnMsg["Level"] = "Error"
        returnMsg["Query"] = "addHostVar"
        returnMsg["Message"] = err.Error()
      }
    }
  }
  return returnMsg
}

func addGroupVar(groupName string, groupvarName string, groupvarValue string) map[string]interface{} {
  //DB setup
  database, err := sql.Open("mysql", databaseConnection)
  if err != nil {
   panic(err)
  }
  database.SetConnMaxLifetime(time.Minute * 3)
  database.SetMaxOpenConns(10)
  database.SetMaxIdleConns(10)
  returnMsg := make(map[string]interface {})
  currentTime := time.Now()
  var groupId int64
  var qCount int
  err = database.QueryRow("SELECT group_id FROM hostgroups WHERE name = ?",groupName).Scan(&groupId)
  if err == sql.ErrNoRows {
    fmt.Printf("No host " + groupName + " found")
    returnMsg["Timestamp"] = currentTime.String()
    returnMsg["Level"] = "Error"
    returnMsg["Query"] = "addGroupVar"
    returnMsg["Message"] = "No group " + groupName +" found"
  } else {
   err = database.QueryRow("SELECT value from groupvars WHERE group_id=? AND group_var=?",strconv.FormatInt(groupId, 10),groupvarName).Scan(&qCount)
   if err == sql.ErrNoRows {
     _,err = database.Exec("INSERT INTO groupvars(group_id,group_var,value) VALUES(?,?,?)",strconv.FormatInt(groupId, 10),groupvarName,groupvarValue)
     if err == nil {
       fmt.Printf("Register new group variable")
       returnMsg["Timestamp"] = currentTime.String()
       returnMsg["Level"] = "Info"
       returnMsg["Query"] = "addGroupVar"
       returnMsg["Message"] = "Register new group variable"
     } else {
       fmt.Printf(err.Error())
       returnMsg["Timestamp"] = currentTime.String()
       returnMsg["Level"] = "Error"
       returnMsg["Query"] = "addGroupVar"
       returnMsg["Message"] = err.Error()
     }
   } else {
     _,err = database.Exec("UPDATE groupvars SET value=? WHERE group_id=? AND group_var=?",groupvarValue,strconv.FormatInt(groupId, 10),groupvarName)
     if err == nil {
       fmt.Printf("Update host variable")
       returnMsg["Timestamp"] = currentTime.String()
       returnMsg["Level"] = "Info"
       returnMsg["Query"] = "addGroupVar"
       returnMsg["Message"] = "Update group variable"
     } else {
       fmt.Printf(err.Error())
       returnMsg["Timestamp"] = currentTime.String()
       returnMsg["Level"] = "Error"
       returnMsg["Query"] = "addGroupVar"
       returnMsg["Message"] = err.Error()
     }
   }
 }
 return returnMsg
}
