<?php


DB::table("test")->where("id",">","0")->orderBy("id","DESC")//orderBy 1 cột

DB::table("test")->where("id",">","0")->orderBy([ ["id","ASC"], ["key","DESC"] ])//orderBy nhiều cột
