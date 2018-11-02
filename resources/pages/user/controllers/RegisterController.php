<?php
namespace pages\user\controllers;
use pages\user\classes\ModelName;
use DB;

class RegisterController{

	public function index(){
		$controllerName = "Controller: RegisterController";
		$functionName="Function: index";
		$callModel=ModelName::get();
		view("RegisterControllerView", compact("controllerName", "functionName", "callModel"));
	}

}

