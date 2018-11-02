<?php

//Union 2 bảng options,topic - unionAll cũng tương tụ
$options = DB::table("options")
->select("id","key")
->where("id",">","1")
->limit(10)
->union();

$data = DB::table("topic")
->select("id","key")
->where("id",">","1")
->union($options)
->limit(10);


foreach($data->get() as $key){
	echo $key->key;//hiện cột key
}

echo $data->count();// Đếm số dòng dữ liệu lấy được
echo $data->total();// Đếm tổng số dòng dữ liệu
echo $data->exists();// Kiểm tra dữ liệu có tồn tại hay không (TRUE = tồn tại) (FALSE = không tồn tại)








//Union nhiều bảng options,topic,cate - unionAll cũng tương tụ
$options = DB::table("options")
->select("id","key")
->where("id",">","1")
->limit(10)
->union();
$cate = DB::table("cate")
->select("id","key")
->where("id",">","1")
->limit(10)
->unionAll();

$data = DB::table("topic")
->select("id","key")
->where("id",">","1")
->union([$options,$cate])
->limit(10);


foreach($data->get() as $key){
	echo $key->key;//hiện cột key
}

echo $data->count();// Đếm số dòng dữ liệu lấy được
echo $data->total();// Đếm tổng số dòng dữ liệu
echo $data->exists();// Kiểm tra dữ liệu có tồn tại hay không (TRUE = tồn tại) (FALSE = không tồn tại)