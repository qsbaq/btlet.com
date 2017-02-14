package main

import (
	"database/sql"
	"encoding/hex"
	"encoding/json"
	"fmt"
	"net/http"
	//"strings"
	//"net/http/pprof"

	_ "github.com/go-sql-driver/mysql"
	"github.com/shiyanhui/dht"
)

type file struct {
	Path   []interface{} `json:"path"`
	Length int           `json:"length"`
}

type bitTorrent struct {
	InfoHash string `json:"infohash"`
	Name     string `json:"name"`
	Files    []file `json:"files,omitempty"`
	//Files  string `json:"files"`
	Length int `json:"length,omitempty"`
}

func main() {
	db, err := sql.Open("mysql", "root:jjjjjj@tcp(localhost:3306)/btlet?charset=utf8")
	checkErr(err)

	stmt, err := db.Prepare(`INSERT infohash (infohash,name,files) values (?,?,?)`)
	checkErr(err)

	go func() {
		http.ListenAndServe(":6060", nil)
	}()

	w := dht.NewWire(65536, 1024, 256)
	go func() {
		for resp := range w.Response() {
			metadata, err := dht.Decode(resp.MetadataInfo)
			if err != nil {
				continue
			}
			info := metadata.(map[string]interface{})

			if _, ok := info["name"]; !ok {
				continue
			}

			bt := bitTorrent{
				InfoHash: hex.EncodeToString(resp.InfoHash),
				Name:     info["name"].(string),
			}

			if v, ok := info["files"]; ok {
				files := v.([]interface{})
				bt.Files = make([]file, len(files))

				for i, item := range files {
					f := item.(map[string]interface{})
					bt.Files[i] = file{
						Path:   f["path"].([]interface{}),
						Length: f["length"].(int),
					}
				}
			} else if _, ok := info["length"]; ok {
				bt.Length = info["length"].(int)
			}

			//fmt.Println(bt.Files)

			json_files, _ := json.Marshal(bt.Files)

			res, err := stmt.Exec(bt.InfoHash, bt.Name, string(json_files))
			if err != nil {
				if myerr, ok := err.(mysql.MySQLError); ok {
					myerr.Number == "1062"
					fmt.Println("Duplicate entry")
				} else {
					panic(err)
				}
			} else {
				if _, err = res.LastInsertId(); err != nil {
					panic(err)
				}
			}

			fmt.Println(bt)
			/*
				data, err := json.Marshal(bt)

				if err == nil {

					fmt.Printf("%s\n\n", data)
				}
			*/
		}
	}()
	go w.Run()

	config := dht.NewCrawlConfig()
	config.OnAnnouncePeer = func(infoHash, ip string, port int) {
		w.Request([]byte(infoHash), ip, port)
	}
	d := dht.New(config)

	d.Run()
}

func checkErr(err error) {
	if err != nil {
		panic(err)

	}
}
