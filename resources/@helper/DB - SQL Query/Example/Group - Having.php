<?php


//Group & Having
$data = DB::table("bills")
->select("product", "cate", "SUM(price) AS price")
->where("id",">","0")
->groupBy("cate")
->having("price",">","1000")
->orderBy("price","DESC")
->limit(10);


foreach($data->get() as $key){
	echo $key->product.': '.$key->price.'<br/>';//hiện cột id
}

echo $data->count();// Đếm số dòng dữ liệu lấy được
echo $data->total();// Đếm tổng số dòng dữ liệu
echo $data->exists();// Kiểm tra dữ liệu có tồn tại hay không (TRUE = tồn tại) (FALSE = không tồn tại)
