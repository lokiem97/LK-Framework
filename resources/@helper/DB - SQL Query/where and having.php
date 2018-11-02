<?php

//Where
DB::table("test")->where("id",">","0")//1 điều kiện
DB::table("test")->where("id","IN",[1,2,9])//where IN
DB::table("test")->where("id","BETWEEN",[1,10])//where BETWEEN
DB::table("test")->where("key","LIKE","%tim%")//where LIKE
DB::table("test")->where([
["id", ">", "0"],
["AND", "id", "=", "2"],
["AND", "type", "=", "ok"],
["OR",  "id", ">", "0"]
])//nhiều điều kiện




//Having
DB::table("test")->having("id",">","0")//1 điều kiện
DB::table("test")->having("id","IN",[1,2,9])//having IN
DB::table("test")->having("id","BETWEEN",[1,10])//having BETWEEN
DB::table("test")->having("key","LIKE","%tim%")//having LIKE
DB::table("test")->having([
["id", ">", "0"],
["AND", "id", "=", "2"],
["AND", "type", "=", "ok"],
["OR",  "id", ">", "0"]
])//nhiều điều kiện