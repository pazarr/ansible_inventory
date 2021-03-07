package main

import (
    "fmt"
    "encoding/json"
    "net/http"
    "log"
    _ "github.com/mattn/go-sqlite3"
)

func ansibleQuery(w http.ResponseWriter, r *http.Request) {
        if r.URL.Path != "/ansible-query" {
                http.Error(w, "404 not found.", http.StatusNotFound)
                return
        }
	w.Header().Add("Content-Type", "application/json")
        switch r.Method {
        case "GET":
		 w.Header().Add("Content-Type", "text/html")
                 http.ServeFile(w, r, "html/query.html")
        case "POST":
                if err := r.ParseForm(); err != nil {
                        fmt.Fprintf(w, "ParseForm() err: %v", err)
                        return
                }
                ansibleQueryType := r.FormValue("q")
		switch ansibleQueryType {
			case "list":
			        json.NewEncoder(w).Encode(getAllList())
			case "host":
				//hostName := getHostDetails(r.FormValue("hostname"))
				json.NewEncoder(w).Encode(getHostDetails(r.FormValue("hostname")))
			default:
				var postKV = make(map[string][]string)
				for k, v := range r.Form {
					postKV[k] = v
				}
				apiCall(postKV)
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
                 http.ServeFile(w, r, "html/index.html")
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

        fmt.Printf("Starting server...\n")
        if err := http.ListenAndServe(":"+ argsPort, nil); err != nil {
                log.Fatal(err)
        }
}

