<?php
namespace pages\setup\controllers;
use pages\setup\classes\ModelName;
use DB;


if(!DEBUG){ redirect("/"); die; }


class Setup{

	public function index(){
		view("SetupView");
	}

	//Lưu dữ liệu
	public function submit(){
		if(getCookie("setup_key")!=SETUP_KEY){ die; }
		//Lưu option
		foreach($_POST["options"] as $key=>$value){
			option_update($key,$value, "important");
		}

		// Lưu tài khoản Admin
		$login_key=md5("".$account["id"]."".random_str(50)."");
		setcookie("login_key", $login_key, time()+3600*24*365, "/");
		DB::table("account")->where("id", "=", 1)->create(["nick"=>POST("nick"), "password"=>password_create(POST("password")), "login_key"=>$login_key, "level"=>9]);
		option_update("actived" ,1, "important");
		Header("location: /");
	}


	//Xóa bảng
	public function tableDelete(){
		if(getCookie("setup_key")!=SETUP_KEY){ die; }
		DB::query("DROP TABLE `".GET("table_delete","","SQL")."`");
		redirect(THIS_LINK);
	}


	//Đăng nhập
	public function login(){
		setcookie("setup_key", md5(POST("setup_key")), time()+3600*24*365, "/");
		redirect(THIS_LINK);
	}

}
