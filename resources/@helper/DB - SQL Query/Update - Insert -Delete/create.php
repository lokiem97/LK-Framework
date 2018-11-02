<?php

//Create dữ liệu (nếu chưa có sẽ insert)
$data = DB::table("tên_bảng")
->where("id","=","1")
->create(
["id"=>"1", "name"=>"Tên mới", "email"=>"new@gmail.com"]
);//Nếu không tồn tại id = 1 sẽ tự insert
