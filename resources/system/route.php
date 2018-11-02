<?php
/*
# Class xử lý đường dẫn
*/
class Route{
private static $route,$folder;



//Thư mục chứa route
public static function folder($folder=""){
	if(empty($folder)){
		return self::$folder;
	}else{
		self::$folder=str_link($folder,"_");
	}
}



//Path đến thư mục route
public static function path($path=""){
	return "".SOURCE_ROOT."/".self::$folder."/".$path;
}




//Route phương thức GET
public static function get($get,$action){
	if(isset($_GET[$get])){
		self::$route=["path"=>$get, "folder"=>self::$folder, "action"=>$action, "params"=>[]];
	}
}




//Route phương thức POST
public static function post($post,$action){
	if(isset($_POST[$post])){
		self::$route=["path"=>$post, "folder"=>self::$folder, "action"=>$action, "params"=>[]];
	}
}




//Route URL
public static function link($path,$action){
	if(empty(self::$route)){
			$uriSplit  = explode("/", rtrim(strtok($_SERVER["REQUEST_URI"],'?'), "/"));
			$pathSplit = explode("/", $path);
			$runThis=0;
			if(count($pathSplit)>=count($uriSplit)){
				foreach($pathSplit as $k=>$v){
					if( strpos($v,"}")===FALSE && isset($uriSplit[$k]) && $uriSplit[$k]==$v || strpos($v,"}")!==FALSE && isset($uriSplit[$k]) ||strpos($v,"?}")!==FALSE ){
						//Nếu phần này khớp với link
						if(strpos($v,"}")!==FALSE && isset($uriSplit[$k])){
							preg_match("#{(.+?)([?]*)}#is", $v,$key);
							$params[$key[1]]=$uriSplit[$k];//Lưu các tham số
						}
						$runThis++;
					}else{
						//Route không khớp với link
						break;
					}
				}
			}
			if( count($pathSplit)==$runThis || $path=="*" ){
				self::$route=["path"=>$path, "folder"=>self::$folder, "action"=>$action, "params"=>(isset($params) ? $params : [])];
			}
	}
}





// Tạo thư mục & file cho route mới
private function folderCreate($controller="",$params=""){
	if(!DEBUG){ return; }
	$folder=self::folder();
	$folderList=["", "views", "controllers", "classes"];
	foreach($folderList as $name){
		$sourceFolder="".self::path($name)."";
		if(!file_exists($sourceFolder)){
		//Tạo thư mục
    	mkdir($sourceFolder, 0755);

//Tạo file Model mẫu
$modelFile=$sourceFolder."/ModelName.php";
if($name=="classes" && !file_exists($modelFile)){
file_put_contents($modelFile,
'<?php
//File xử lý dữ liệu database
namespace '.SOURCE_FOLDER.'\\'.$folder.'\\classes;
use DB;
class ModelName{

	public static function get(){
		return "Gọi Model";
	}

}//</Class>

');
}

    	}
        
        //Tạo file controller mẫu
$controllerFile=$sourceFolder."/".$controller[0].".php";
if($name=="controllers" && !file_exists($controllerFile)){
    		$param="";$pi=0;
    		foreach ($params as $key=>$value) {
    			$param.=''.($pi==0 ? '' : ', ').'$'.$key.'=""';
    			$pi++;
    		}
file_put_contents($controllerFile,
'<?php
namespace '.SOURCE_FOLDER.'\\'.$folder.'\\controllers;
use '.SOURCE_FOLDER.'\\'.$folder.'\\classes\ModelName;
use DB;

class '.$controller[0].'{

	public function '.$controller[1].'('.$param.'){
		$controllerName = "Controller: '.$controller[0].'";
		$functionName="Function: '.$controller[1].'";
		$callModel=ModelName::get();
		view("'.$controller[0].'View", compact("controllerName", "functionName", "callModel"));
	}

}

');
}

	}
}









// Chạy Route
public static function run(){
	$route=self::$route;
	self::folder($route["folder"]);
	if (is_callable($route["action"])) {
	//Nếu action là function
		echo call_user_func_array($route["action"], $route["params"]);
	}else{
	//Nếu action gọi controller
		$controller = explode('@', $route["action"]);
		if(count($controller) == 2) {
			$className = $controller[0];
			$method     = $controller[1];
			self::folderCreate([$className,$method],$route["params"]);
			$classSpace=SOURCE_FOLDER."\\{$route["folder"]}\\controllers\\$className";
			$class      = new $classSpace;
			echo call_user_func_array(array($class, $method), $route["params"]);
		}
	}
}










}//</Class>






//Load file route tương ứng với URI
$routeFile = explode("/", rtrim(strtok($_SERVER["REQUEST_URI"],'?'), "/"))[1] ?? "_home";
$routePath = "".SOURCE_ROOT."/".$routeFile.".php";
if(file_exists($routePath)){
	Route::folder($routeFile);
	require_once($routePath);
}
Route::folder("_404");
require_once(SOURCE_ROOT."/_404.php");

Route::run();//Khởi tạo route