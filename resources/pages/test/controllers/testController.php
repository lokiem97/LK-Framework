<?php
namespace pages\test\controllers;
use pages\test\classes\ModelName;
use DB;

class testController{

	public function function(){
		$controllerName = "Controller: testController";
		$functionName="Function: function";
		$callModel=ModelName::get();
		view("testControllerView", compact("controllerName", "functionName", "callModel"));
	}

}

