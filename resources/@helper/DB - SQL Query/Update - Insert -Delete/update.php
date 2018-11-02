<?php

//Update dữ liệu
$data = DB::table("tên_bảng")
->where("id","=","1")
->update(
["name"=>"Tên mới", "email"=>"new@gmail.com"]
);//Cập nhất nếu id=1


//Update dữ liệu (nếu không tồn tại sẽ insert)
$data = DB::table("tên_bảng")
->where("id","=","1")
->update(
["id"=>"1", "name"=>"Tên mới", "email"=>"new@gmail.com"]
,true);//Nếu không tồn tại id = 1 sẽ tự insert