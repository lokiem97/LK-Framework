<?php
/*
# Thao tác dữ liệu từ bảng option
*/

//Lấy option
function option($key, $default=''){
	$option=DB::table("options")->select("*")->where("key","=",$key)->get(true);
	$out=empty($option->value) ? $default : ($option->array==1 ? unserialize($option->value) : $option->value);
	return $out;
}





//Lấy option dạng array
function option_array($option, $key, $default=''){
	$opt=option($option);
	$out=empty($opt->$key) ? $default :  $opt->$key;
	return $out;
}




//Cập nhật option
function option_update($key, $value='', $parent='general'){
	if(is_array($value)){ $value=serialize($value); $array=1; }else{ $array=0; }
	return DB::table("options")->where("key", "=", $key)->update(["key"=>$key, "value" => $value, "parent"=>$parent, "array" => $array], true);
}




//Xóa option
function option_delete($key,$parent=false){
	if($parent){
	$out=DB::table("options")->where("parent", "=", $key)->delete();// Xóa theo mục
	}else{
	$out=DB::table("options")->where("key", "=", $key)->delete();// Xóa theo key
	}
	return $out;
}