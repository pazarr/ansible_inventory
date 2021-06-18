package main

import (
    "fmt"
    "encoding/json"
    "net/http"
    "log"
    "os"
    _ "github.com/mattn/go-sqlite3"
)
var databaseHost string
var databasePort string
var databaseUser string
var databasePass string
var databaseName string
var databaseConnection string

func ansibleIndex(w http.ResponseWriter, r *http.Request) {
        if r.URL.Path != "/" {
                http.Error(w, "404 not found.", http.StatusNotFound)
                return
        }
        switch r.Method {
        case "GET":
                 http.ServeFile(w, r, "/var/html/index.html")
        case "POST":
                if err := r.ParseForm(); err != nil {
                        fmt.Fprintf(w, "ParseForm() err: %v", err)
                        return
                }
                var postKV = make(map[string][]string)
                for k, v := range r.Form {
			postKV[k] = v
		}
		json.NewEncoder(w).Encode(apiCall(postKV))
        default:
                fmt.Fprintf(w, "Sorry, only GET and POST methods are supported.")
        }
}

func main() {
        databaseHost, err := os.LookupEnv("DATABASE_HOST")
        if err == false {
                fmt.Printf("ENV VAR ERROR DATABASE_HOST")
                os.Exit(2)
        }
	databasePort, err := os.LookupEnv("DATABASE_PORT")
        if err == false {
                fmt.Printf("ENV VAR ERROR DATABASE_PORT")
                os.Exit(2)
        }
	databaseUser, err := os.LookupEnv("DATABASE_USER")
        if err == false {
                fmt.Printf("ENV VAR ERROR DATABASE_USER")
                os.Exit(2)
        }
	databasePass, err := os.LookupEnv("DATABASE_PASS")
	        if err == false {
                fmt.Printf("ENV VAR ERROR DATABASE_PASS")
                os.Exit(2)
        }
	databaseName, err := os.LookupEnv("DATABASE_NAME")
	if err == false {
		fmt.Printf("ENV VAR ERROR DATABASE_NAME")
		os.Exit(2)
        }
	databaseConnection = databaseUser + ":" + databasePass + "@tcp(" + databaseHost + ":" + databasePort + ")/" + databaseName

	argsPort := "8080"
	http.HandleFunc("/", ansibleIndex)

        fmt.Printf("Starting server...\n")
        if err := http.ListenAndServe(":"+ argsPort, nil); err != nil {
                log.Fatal(err)
        }
}

