<?php
namespace pages\_home\controllers;
use pages\_home\classes\ModelName;
use DB;

class Home{

	public function info(){
		$controllerName = "Controller: Home";
		$functionName="Function: info";
		$callModel=ModelName::get();
		view("HomeView", compact("controllerName", "functionName", "callModel"));
	}

}

