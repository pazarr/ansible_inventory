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
  //set local variables
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
//        database, _ := sql.Open("sqlite3", "./ansible.db")
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
    //var hostMetaData = make(map[string]interface{})
    var hostMap = make(map[string]interface{})
    var allVars = make(map[string]string)
    //        database, _ := sql.Open("sqlite3", "./ansible.db")
    allHost, err :=
            database.Query("SELECT host_id,name FROM hosts ORDER BY name ASC")
    if err != nil {
            fmt.Println("SQL select error: ")
            log.Fatal(err)
    }
    for allHost.Next() {
		//set local variables
		var hostVarName string
		var hostVarValue string
		var hostId int
		var hostName string
		//processing query result
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
