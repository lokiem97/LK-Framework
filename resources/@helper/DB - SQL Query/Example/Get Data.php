<?php

//Lấy dữ liệu (nhiều)
$data = DB::table("tên_bảng")
->select("*")
->where("id",">","1")
->orderBy("id","DESC")
->limit(10);

foreach($data->get() as $key){
	echo $key->id;//hiện cột id
}

echo $data->count();// Đếm số dòng dữ liệu lấy được
echo $data->total();// Đếm tổng số dòng dữ liệu
echo $data->exists();// Kiểm tra dữ liệu có tồn tại hay không (TRUE = tồn tại) (FALSE = không tồn tại)




//Lấy dữ liệu (một)
$data = DB::table("tên_bảng")
->select("*")
->where("id","=","1")
->get(true);
echo $key->id;//hiện cột id
