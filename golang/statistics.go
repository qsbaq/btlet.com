/*****************************************
 * 统计爬取数量
 * 作者：老季
 * 网址：http://laoji.org
 * 作品地址：https://www.jiloc.com/43136.html
 *******************************************/
package main

import (
	"database/sql"
	"flag"
	"fmt"
	"strconv"
	"time"

	_ "github.com/go-sql-driver/mysql"
)

func main() {
	ntime := time.Now()
	yesTime := ntime.AddDate(0, 0, -1)
	yesDate := yesTime.Format("2006-01-02")
	//fmt.Println(yesDate)
	yDate := flag.String("date", yesDate, "Yesterday Time")
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

	var number string
	err = db.QueryRow("select number from laoji_statistics where date = ?", *yDate).Scan(&number)
	var status string
	if err != nil {
		status = "INSERT"
	} else {
		status = "UPDATE"
	}

	stmt, err := db.Prepare(`SELECT count(1) AS number FROM laoji_infohash WHERE DATE_FORMAT(update_time,'%Y-%m-%d')=?`)
	checkErr(err)
	defer stmt.Close()

	rows, err := stmt.Query(*yDate)
	checkErr(err)
	defer rows.Close()

	if rows.Next() {
		rows.Scan(&number)
		update_time := time.Now().Format("2006-01-02 15:04:05")
		if status == "INSERT" {
			stmtIns, err := db.Prepare("INSERT INTO laoji_statistics(date,number,update_time) VALUES( ?, ? ,?)")
			if err != nil {
				checkErr(err)
			}
			defer stmtIns.Close()
			_, err = stmtIns.Exec(*yDate, number, update_time)
			if err != nil {
				checkErr(err)
			}
			fmt.Printf("INSERT %s -> %s\n", *yDate, number)
		} else if status == "UPDATE" {
			stmtUpd, err := db.Prepare("UPDATE laoji_statistics SET number = ?,update_time=? WHERE date= ? ")
			if err != nil {
				checkErr(err)
			}
			defer stmtUpd.Close()
			_, err = stmtUpd.Exec(number, update_time, *yDate)
			if err != nil {
				checkErr(err)
			}
			fmt.Printf("UPDATE %s -> %s\n", *yDate, number)
		}
	}

}

func checkErr(err error) {
	if err != nil {
		panic(err)
	}
}
