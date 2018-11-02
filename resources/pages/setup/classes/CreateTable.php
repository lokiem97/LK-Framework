<?php
/*
# Tạo bảng
*/
function CreateTable($table,$content,$description){


$check=DB::query("SHOW COLUMNS FROM `$table`");
$content=trim($content);
$content=trim($content,",");
if(!isset($check->num_rows)){
$created=DB::query("CREATE TABLE `$table` (".$content.")
CHARACTER SET ".TABLE_CHARACTER." COLLATE ".TABLE_COLLATE."
");
}else{
$created=FALSE;
}

if($created){
echo '
<div class="list bd">Đã tạo bảng: <b>'.$table.'</b></div>
<div class="menu bd">'.trim(str_replace("
","<br/>", $content),"<br/>").'</div>
';
}else{
echo '
<div class="amenu bd"><b>'.$table.'</b><a style="float:right" onclick="return confirm(\'Dữ liệu cũ trong table '.$table.' sẽ bị xóa, tiếp tục?\')" href="?table_delete='.$table.'">Tạo lại bảng <b>'.$table.'</b></a></div>
<div class="menu">'.$description.'</div>
<div class="menu bd">
<table style="width:100%">
<tr>
';
$i=0;
if($columnList=DB::query("SHOW COLUMNS FROM `$table`")){
while($column = mysqli_fetch_object($columnList) ){
	echo ($i%5==0 ? '</tr><tr>' : '');
	echo '<td class="menu bd center"><b>'.$column->Field.'</b> <br/> <i>('.$column->Type.')</i></td>';
	$i++;
}
}else{
	echo '<span style="color:red">Lỗi tạo bảng, vui lòng xem lại</span>';
}
echo '
</tr>
</table>
</div>
<div class="pd-5"></div>
';
}

}
