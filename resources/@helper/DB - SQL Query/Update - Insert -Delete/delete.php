<?php

//Xóa dữ liệu
$data = DB::table("tên_bảng")
->where("id","=","1")
->delete();//xóa nếu id = 1