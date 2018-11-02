<?php
//Phân trang nhanh

$data = DB::table("tên_bảng")
->select("*")
->where("id",">","1")
->orderBy("id","DESC")
->pagination(10);

foreach($data->get() as $key){
	echo $key->id;//hiện cột id
}

echo $data->links([
"url"  => "?",
"jump" => "#jump",
"goto" => true,
"next" => '<i class="fa fa-arrow-right"></i> Sau',
"prev" => '<i class="fa fa-arrow-left"></i> Trước'
]);