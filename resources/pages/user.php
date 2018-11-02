<?php
//Đăng nhập
Route::link("/user/login","LoginController@index");//Trang đăng nhập
Route::post("loginSubmit","LoginController@loginSubmit");//ấn đăng nhập

//Đăng ký
Route::link("/user/register","RegisterController@index");

//Trang user khác
Route::link("/user/{action}","UserController@index");