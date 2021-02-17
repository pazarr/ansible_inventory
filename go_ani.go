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
//        defer rows.Close()
	return rows
}

func getParentList() map[string]map[string][]string {
        database, _ := sql.Open("sqlite3", "./ansible.db")
        rows, err :=
                database.Query("SELECT rowid,name FROM parents ORDER BY name ASC")
        if err != nil {
                fmt.Println("SQL select error: ")
                log.Fatal(err)
        }
	//var allParent []string
        var name string
	var rowid int
        var f = make(map[string]map[string][]string)
        for rows.Next() {
		var allGroups []string
		rows.Scan(&name)
		rows.Scan(&rowid)
		groupAssoc, err :=
			database.Query("SELECT name FROM hostgroups WHERE group_id IN (SELECT group_id FROM parent_child WHERE parent_id=" + strconv.Itoa(rowid))
	        if err != nil {
			fmt.Println("SQL select error: ")
			log.Fatal(err)
		}
		for groupAssoc.Next() {
			rows.Scan(&name)
			allGroups = append(allGroups,name)
		}
                m := map[string][]string{
			"children": allGroups,
                }
		f[name] = m
	}

        return f
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
			default:
				fmt.Fprintf(w, "Request is not supported")
			}
        default:
                fmt.Fprintf(w, "Sorry, only GET and POST methods are supported.")
        }
	m := map[string][]string{
		"hosts": allHosts,
	}
	f := map[string]map[string][]string{
		"all": m,
	}
	json.NewEncoder(w).Encode(f)
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

