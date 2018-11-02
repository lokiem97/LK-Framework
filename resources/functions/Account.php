<?php
/*
# Thao tác tài khoản
*/

//Lấy User
function account($column, $user_id=''){
	if(empty($user_id)){ $where[]=["login_key", "=", getCookie("login_key")]; }else{ $where[]=["id", "=", $user_id]; }
	$account=DB::table("account")->select($column)->where($where)->get(true);
	return $account->$column ?? NULL;
}




//Cật nhật user
function account_update($id, $value){
	return DB::table("account")->where("id","=",$id)->update($value);
}




//Yêu cầu đăng nhập
function request_level($level=0){
setcookie("ref_link", THIS_LINK, time()+3600, "/");

if(account("id")>0){
if(account("level")<$level){ echo '<div class="error">Bạn không có quyền truy cập</div>'; exit;	}
}else{
move_to("/account/login.php");
}

	
}