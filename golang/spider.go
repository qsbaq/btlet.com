/*****************************************
 * DHT爬取
 * 作者：老季
 * 网址：http://laoji.org
 * 作品地址：https://www.jiloc.com/43136.html
 *******************************************/
package main

import (
	"database/sql"
	"encoding/hex"
	"encoding/json"
	"flag"
	"fmt"
	"log"
	"net/http"
	"strconv"
	"time"

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
	Length   int    `json:"length,omitempty"`
}

func main() {
	sql_type := flag.String("t", "mysql", "DataBase Type")
	db_user := flag.String("u", "btlet", "DataBase UserName")
	db_passwd := flag.String("p", "laoji.org", "DataBase Password")
	db_name := flag.String("d", "btlet", "DataBase Name")
	db_host := flag.String("h", "localhost", "DataBase Address")
	db_port := flag.Int("P", 3306, "DataBase Port")
	flag.Parse()
	db, err := sql.Open(*sql_type, *db_user+":"+*db_passwd+"@tcp("+*db_host+":"+strconv.Itoa(*db_port)+")/"+*db_name+"?charset=utf8")
	checkErr(err)
	defer db.Close()

	stmt, err := db.Prepare(`INSERT laoji_infohash (infohash,name,files,update_time) values (?,?,?,?)`)
	checkErr(err)
	defer stmt.Close()

	go func() {
		http.ListenAndServe(":8081", nil)
	}()

	w := dht.NewWire(65536, 1024, 1024)
	go func() {
		for resp := range w.Response() {
			metadata, err := dht.Decode(resp.MetadataInfo)
			if err != nil {
				log.Println("Skip nil field -> metadata")
				continue
			}
			info := metadata.(map[string]interface{})

			if _, ok := info["name"]; !ok {
				log.Println("Skip nil field -> name")
				continue
			}

			bt := bitTorrent{
				InfoHash: hex.EncodeToString(resp.InfoHash),
				Name:     info["name"].(string),
			}
			if info["files"] == nil {
				log.Println("Skip nil field -> files")
				continue
			} else if v, ok := info["files"]; ok {
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

			json_files, _ := json.Marshal(bt.Files)
			update_time := time.Now().Format("2006-01-02 15:04:05")

			res, err := stmt.Exec(bt.InfoHash, bt.Name, string(json_files), update_time)
			if err != nil {
				fmt.Println(err.Error())
				continue
			} else {
				if _, err = res.LastInsertId(); err != nil {
					panic(err)
				}
			}

			log.Println(bt.InfoHash)
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
