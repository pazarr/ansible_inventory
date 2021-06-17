#!/usr/bin/python

import MySQLdb
import sys
import json
import simplejson
from sqlite3 import Error

db = MySQLdb.connect("localhost","ansible","qwelkj123","an_inv_dev" )
cursor = db.cursor()

if sys.argv[1] == "--list":

        hosts_dict = {}
        group_dict = {}

        sql_groups = "SELECT * FROM hostgroups"
        cursor.execute(sql_groups)
        group_results = cursor.fetchall()
        for group_row in group_results:
                group_name = group_row[1]
                gid = group_row[0]
                hosts_sql = "SELECT name FROM hosts WHERE host_id IN (SELECT host_id FROM memberships WHERE group_id =%s)"
                cursor.execute(hosts_sql, gid)
                results = cursor.fetchall()
                hosts_dict = {}
                for row in results:
                        hname = row[0]
                        hosts_dict.setdefault('hosts', []).append(row[0])
                if hosts_dict:
                        group_dict[group_name] = hosts_dict
        print json.dumps(group_dict)

elif sys.argv[1] == "--host":
        host_dict = {}
        sql="SELECT host_var,value FROM hostvars WHERE host_id IN (SELECT host_id FROM hosts WHERE name=" + sys.argv[1] +")"
        cursor.execute("SELECT host_var,value FROM hostvars WHERE host_id IN (SELECT host_id FROM hosts WHERE name=%s)",( sys.argv[2]))
        rows = cursor.fetchall()
        for row in rows:
                host_dict[row[0]] = row[1]
        print json.dumps(host_dict)

else:
        print('something went wrong, please debug')
