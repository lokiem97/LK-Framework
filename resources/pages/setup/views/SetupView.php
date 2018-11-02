<?php
layout("header",[
"title"       => "Setup",
"description" => "Bắt đầu khởi tạo",
"header"      => true,
"footer"      => true,
"robots"      => "noindex,nofollow",
"user_level"  => 0,
"loading"     => 0,
"meta_tag"    => ""
]);







if(getCookie("setup_key")!=SETUP_KEY){
	echo '
	<form action="" method="POST">
	<div class="menu"><input type="text" placeholder="Nhập mã SETUP_KEY" name="setup_key"/></div>
	';
	die;
}






echo '
<div id="main">
<div style="max-width:650px;margin: 0 auto">
'.(empty( account("id",1) ) ? '
<div class="big-title">SETUP</div>
<form id="setup" action="" method="POST">
<div class="menu bd"><input value="'.option("page_title").'" placeholder="Tiêu đề trang" style="width:100%" type="text" name="options[page_title]"/></div>
<div class="menu bd"><input value="'.option("page_description").'" placeholder="Mô tả trang" style="width:100%" type="text" name="options[page_description]"/></div>
<div class="amenu">Tài khoản Admin</div>
<div class="menu bd"><input placeholder="Tên đăng nhập" style="width:100%" value="Admin" type="text" name="nick"/></div>
<div class="menu bd"><input placeholder="Mật khẩu" style="width:100%" type="password" name="password"/></div>
<div class="cmenu bd center"><input name="submit" id="submit" style="display:none" type="submit" value="OK"/></div>
</form>
' : '').'
<div class="big-title">DANH SÁCH TABLE</div>
';

require_once("".Route::path("classes/CreateTable.php")."");
require_once("".Route::path("create_table.php")."");
require_once("".Route::path("seeds_data.php")."");

echo '
</div>
</div>

<script>
$("#setup").keyup("input", function(){
var this_empty=0;
$("#setup input").each(function(){
if($(this).val()=="") {this_empty=1;}

});
if(this_empty==1){$("#submit").hide(); }else{ $("#submit").show();  }
});
</script>

';








layout("footer");
