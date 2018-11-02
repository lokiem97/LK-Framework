<?php
//Join bảng


//Join 1 bảng - cate sang topic
$data = DB::table("topic")
->select("topic.*","cate.name as cate_name")
->join("LEFT JOIN", "cate", "topic.cate_id", "cate.id")
->where("topic.id",">","0")
->orderBy("topic.id","DESC")
->limit(10);

foreach($data->get() as $key){
	echo $key->id;//hiện cột id
}

echo $data->count();// Đếm số dòng dữ liệu lấy được
echo $data->total();// Đếm tổng số dòng dữ liệu
echo $data->exists();// Kiểm tra dữ liệu có tồn tại hay không (TRUE = tồn tại) (FALSE = không tồn tại)




//Join nhiều bảng topic,cate,options
$data = DB::table("topic")
->select("topic.*","cate.name as cate_name","options.key as option_key")
->join([
	["LEFT JOIN", "cate", "topic.cate_id", "cate.id"],
	["LEFT JOIN", "options", "cate.id", "options.id"],
])
->where("topic.id",">","0")
->orderBy("topic.id","DESC")
->limit(10);

foreach($data->get() as $key){
	echo $key->id;//hiện cột id
}

echo $data->count();// Đếm số dòng dữ liệu lấy được
echo $data->total();// Đếm tổng số dòng dữ liệu
echo $data->exists();// Kiểm tra dữ liệu có tồn tại hay không (TRUE = tồn tại) (FALSE = không tồn tại)
