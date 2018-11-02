##### Hướng dẫn tạo trang (VD muốn tạo: domain/test):

B1: tạo file test.php trong thư mục pages.

B2: sửa file test.php như sau:
<?php
Route::link("/test", "TestController@func");
?>
B3: truy cập domain/test - sau đó hệ thống sẽ tự tạo thư mục test trong pages





##### Các kiểu route
Route::link("/path/{gia_tri1}/{gia_tri2?}","ControllerName@function");//Dạng link: domain/path

Route::get("Test","ControllerName@function");//Khi có $_GET["Test"]

Route::post("Test","ControllerName@function");//Khi có $_POST["Test"]