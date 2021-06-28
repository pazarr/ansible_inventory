package main

import (
    "fmt"
    "encoding/json"
    "net/http"
    "log"
    "time"
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
  returnMsg := make(map[string]interface {})
  currentTime := time.Now()
  mimetype := r.Header.Get("Content-type")
  fmt.Println("mime type: " + mimetype)
  if r.URL.Path != "/" {
    http.Error(w, "404 not found.", http.StatusNotFound)
    return
  }
  switch r.Method {
    case "GET":
      http.ServeFile(w, r, "/var/html/index.html")
    case "POST":
      if mimetype == "application/json" {
        var queryStruct map[string]interface{}
        err := json.NewDecoder(r.Body).Decode(&queryStruct)
        if err != nil {
            w.Header().Add("Content-Type", "application/json")
            fmt.Printf("Invalid JSON format")
            returnMsg["Timestamp"] = currentTime.String()
            returnMsg["Level"] = "Error"
            returnMsg["Message"] = "Invalid JSON format"
            http.Error(w, "", 400)
            json.NewEncoder(w).Encode(returnMsg)
            break
        }
        queryReturn := apiCallJSON(queryStruct)
        if queryReturn["Level"] == "Error" {
          w.Header().Set("Content-Type", "application/json; charset=utf-8")
          w.Header().Set("X-Content-Type-Options", "nosniff")
          w.WriteHeader(400)
        } else {
          w.Header().Set("Content-Type", "application/json; charset=utf-8")
          w.Header().Set("X-Content-Type-Options", "nosniff")
          w.WriteHeader(200)
        }
          json.NewEncoder(w).Encode(queryReturn)

      } else {
          if err := r.ParseForm(); err != nil {
            fmt.Fprintf(w, "ParseForm() err: %v", err)
            return
          }
          var postKV = make(map[string][]string)
          for k, v := range r.Form {
            postKV[k] = v
          }
          queryReturn := apiCallFORM(postKV)
          if queryReturn["Level"] == "Error" {
            w.Header().Set("Content-Type", "application/json; charset=utf-8")
            w.Header().Set("X-Content-Type-Options", "nosniff")
            w.WriteHeader(400)
          } else {
            w.Header().Set("Content-Type", "application/json; charset=utf-8")
            w.Header().Set("X-Content-Type-Options", "nosniff")
            w.WriteHeader(200)
          }
            json.NewEncoder(w).Encode(queryReturn)
          }
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
