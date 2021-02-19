package main

import (
    "database/sql"
    "fmt"
    "encoding/json"
    "strconv"
    "net/http"
    "log"
//    "os"
//    "text/template"

    _ "github.com/mattn/go-sqlite3"
)

func getHostVars(ansibleHostName string) {
    database, _ := sql.Open("sqlite3", "./ansible.db")
    rows, _ := database.Query("SELECT host_var,value FROM hostvars WHERE host_id IN (SELECT rowid FROM hosts WHERE name="+ ansibleHostName +");")
    var rowid int
    var name string
    for rows.Next() {
        rows.Scan(&rowid, &name)
        fmt.Println(strconv.Itoa(rowid) + ": " + name )
    }
}

func getHostList() *sql.Rows {
        database, _ := sql.Open("sqlite3", "./ansible.db")
        rows, err :=
                database.Query("SELECT name FROM hosts ORDER BY name ASC")
        if err != nil {
		fmt.Println("SQL select error: ")
		log.Fatal(err)
	}
	return rows
}

func getMetaData() map[string]interface{} {
	//var hostMetaData = make(map[string]interface{})
	var hostMap = make(map[string]interface{})
	var allVars = make(map[string]string)
        database, _ := sql.Open("sqlite3", "./ansible.db")
        allHost, err :=
                database.Query("SELECT rowid,name FROM hosts ORDER BY name ASC")
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
		for hostVars.Next() {
			hostVars.Scan(&hostVarName, &hostVarValue)
                        allVars[hostVarName] = hostVarValue
                }
                hostMap[hostName] = allVars
	}
	return hostMap
}


func getGroupList() map[string]interface{} {
//Set local variables
        var parentName string
        var groupName string
	var hostName string
        var parentVarName string
        var parentVarValue string
        var rowid int
	var combinedMap = make(map[string]interface{})
//Fetch all hosts
	var allHost []string
	fetchAllHost := getHostList()
	for fetchAllHost.Next() {
		fetchAllHost.Scan(&hostName)
		allHost = append(allHost,hostName)
        }
	hostMap := map[string]interface{}{
		"hosts": allHost,
	}
        combinedMap["all"] = hostMap
// Set all host metadata
        combinedMap["_meta"] = getMetaData()

//Fetch all Parent groups and handle SQL error
        database, _ := sql.Open("sqlite3", "./ansible.db")
        rows, err :=
                database.Query("SELECT rowid,name FROM parentgroups ORDER BY name ASC")
        if err != nil {
                fmt.Println("SQL select error: ")
                log.Fatal(err)
        }
//Create map from all children of the Parent
        for rows.Next() {
	        var allGroup []string
	        var allVars = make(map[string]string)
		rows.Scan(&rowid, &parentName)
		groupAssoc, err :=
			database.Query("SELECT name FROM hostgroups WHERE rowid IN (SELECT group_id FROM parent_child WHERE parent_id=" + strconv.Itoa(rowid) + ");")
	        if err != nil {
			fmt.Println("SQL select error: ")
			log.Fatal(err)
		}
		for groupAssoc.Next() {
			groupAssoc.Scan(&groupName)
			allGroup = append(allGroup,groupName)
		}
		parentVars, err :=
			database.Query("SELECT parent_var, value FROM parentvars WHERE parent_id=" + strconv.Itoa(rowid))
		if err != nil {
			fmt.Println("SQL select error: ")
			log.Fatal(err)
		}
		for parentVars.Next() {
			parentVars.Scan(&parentVarName, &parentVarValue)
			allVars[parentVarName] = parentVarValue
		}
		parentMap := map[string]interface{}{
			"children": allGroup,
			"vars": allVars,
                }

		combinedMap[parentName] = parentMap
	}
        return combinedMap
}
/*func getAllList() struct {
        database, _ := sql.Open("sqlite3", "./ansible.db")
        rows, err :=
                database.Query("SELECT name FROM hosts ORDER BY name ASC")
        if err != nil {
                fmt.Println("SQL select error: ")
                log.Fatal(err)
        }

}
*/
func ansibleQuery(w http.ResponseWriter, r *http.Request) {
	var allHosts []string
        if r.URL.Path != "/ansible-query" {
                http.Error(w, "404 not found.", http.StatusNotFound)
                return
        }
        switch r.Method {
        case "GET":
                 http.ServeFile(w, r, "query.html")
        case "POST":
                if err := r.ParseForm(); err != nil {
                        fmt.Fprintf(w, "ParseForm() err: %v", err)
                        return
                }
                ansibleQueryType := r.FormValue("q")
		switch ansibleQueryType {
			case "list":
				w.Header().Add("Content-Type", "application/json")
				rows := getHostList()
				var name string
				for rows.Next() {
					rows.Scan(&name)
					allHosts = append(allHosts,name)
				}
			        m := map[string][]string{
				        "hosts": allHosts,
			        }

			        f := map[string]map[string][]string{
			                "all": m,
			        }
			        json.NewEncoder(w).Encode(f)
			case "test":
			         m := getGroupList()
				 //m := getMetaData()
				 json.NewEncoder(w).Encode(m)
			default:
				fmt.Fprintf(w, "Request is not supported")
			}
        default:
                fmt.Fprintf(w, "Sorry, only GET and POST methods are supported.")
        }
}

func ansibleIndex(w http.ResponseWriter, r *http.Request) {
        if r.URL.Path != "/" {
                http.Error(w, "404 not found.", http.StatusNotFound)
                return
        }

        switch r.Method {
        case "GET":
                 http.ServeFile(w, r, "index.html")
        case "POST":
                // Call ParseForm() to parse the raw query and update r.PostForm and r.Form.
                if err := r.ParseForm(); err != nil {
                        fmt.Fprintf(w, "ParseForm() err: %v", err)
                        return
                }
                fmt.Fprintf(w, "Post from website! r.PostFrom = %v\n", r.PostForm)
                name := r.FormValue("name")
                address := r.FormValue("address")
                fmt.Fprintf(w, "Name = %s\n", name)
                fmt.Fprintf(w, "Address = %s\n", address)
        default:
                fmt.Fprintf(w, "Sorry, only GET and POST methods are supported.")
        }
}

func main() {
	argsPort := "8080"
        http.HandleFunc("/ansible-query", ansibleQuery)
	http.HandleFunc("/", ansibleIndex)

        fmt.Printf("Starting server for testing HTTP POST...\n")
        if err := http.ListenAndServe(":"+ argsPort, nil); err != nil {
                log.Fatal(err)
        }
}

