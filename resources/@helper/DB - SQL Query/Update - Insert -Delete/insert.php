<?php

//Insert dữ liệu
$data = DB::table("tên_bảng")
->insert(
["name"=>"Tên", "email"=>"test@gmail.com"]
);