<?php
namespace pages\user\controllers;
use pages\user\classes\ModelName;
use DB;

class LoginController{

	//Trang đăng nhập
	public function index(){
		$controllerName="Xin chào";
		if(account("id")>0){ redirect(getCookie("ref_link")); }//Nếu đã đăng nhập
		view("Login", compact("controllerName"));
	}

	//Ấn đăng nhập
	public function loginSubmit(){
		if($account=DB::get_row("SELECT * FROM `account` WHERE `nick` = '".POST("nick")."' ")){
	
	if($account["login_failed"]>9){
		
		if(time()>($account["login_failed_time"])){
		update_account( $account["id"], array("login_failed"=>"0") );
		}else{
		$login_wrong = 'Tài khoản này đã đăng nhập sai quá 10 lần,hãy đăng nhập lại sau <b>'.($account['login_failed_time']-time()).'</b> giây';
		}
		
	}else{
		
	if(password_check(POST("password"), $account["password"])){
		//Login success

	setcookie("login_key", $account["login_key"], time()+3600*24*365, "/");
	update_account( $account["id"], array(
	"login_failed"=>"0"
	));
	
	move_to(get_cookie("ref_link"));
	}else{
	$login_wrong = 'Mật khẩu không chính xác';
	update_account( $account["id"], array("login_failed"=>($account["login_failed"]+1), "login_failed_time"=>time()+20) );
	}
	
	}
	
	}else{
	$login_wrong = 'Tên đăng nhập không hợp lệ';
	}
	}


}//</Class>

