<?php
/*
# File System core
*/
define("DEBUG", TRUE); //Cảnh báo: luôn để FALSE khi không chỉnh sửa code
define("SETUP_KEY", md5("LoKiem")); //Mã đăng nhập domain/setup
define("SOURCE_FOLDER", "pages");// Thư mục chính chứa các trang
define("SOURCE_ROOT", SYSTEM_ROOT."/".SOURCE_FOLDER);//Đường dẫn thư mục chứa các trang
define("PUBLIC_ROOT", $_SERVER['DOCUMENT_ROOT']);//Thư mục chứa dữ liệu công khai
define("DOMAIN", $_SERVER["HTTP_HOST"]);//Tên miền
define("HOME", "http".(empty($_SERVER['HTTPS']) ? "" : "s")."://".DOMAIN."");//Trang chủ
define("THIS_URL", HOME."".$_SERVER['REQUEST_URI']."");//Link hiện tại
define("THIS_LINK", HOME."".strtok($_SERVER["REQUEST_URI"],'?'));//Link hiện tại(Không có GET)
define("UTC_TIME",7);//Múi giờ




//Các file hệ thống
foreach(["database", "autoload", "route"] as $file){
	require_once($file.".php");
}