<?php
namespace pages\user\controllers;
use pages\user\classes\ModelName;
use DB;

class UserController{

	public function index($action=""){
		$controllerName = "Controller: UserController";
		$functionName="Function: index";
		$callModel=ModelName::get();
		view("UserControllerView", compact("controllerName", "functionName", "callModel"));
	}

}

