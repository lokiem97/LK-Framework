<?php
layout("header",[
"title"       => "Trang chủ",
"description" => "Nội dung mô tả",
"header"      => true,
"footer"      => true,
"robots"      => "index,follow",
"user_level"  => 0,
"loading"     => 0,
"meta_tag"    => ""
]);

$data = DB::table("options")
->select("*")
->where("id",">","1")
->orderBy("id","DESC")
->pagination(3);

foreach($data->get() as $key){
	echo $key->id;//hiện cột id
}

echo $data->links([
"url"  => "?",
"jump" => "#jump",
"goto" => true,
"next" => "Trang sau",
"prev" => "Trang trước"
]);

layout("footer");
