<?php


//Các file functions
foreach(glob("".SYSTEM_ROOT."/functions/*.php") as $f){
	require_once($f);
}

//Tự động load các class khi cần
spl_autoload_register(function ($class) {
    $file_path = SYSTEM_ROOT."/".str_replace("\\", "/", $class).".php";
	if(file_exists($file_path)) { require_once($file_path); }
});
