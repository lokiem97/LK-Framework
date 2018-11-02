<?php
use classes\BladeTemplate;
/*
##### Các Function cần thiết
*/

//Load file view
function view($file, $var='', $folder=''){
	if(empty($folder)){
		$path=Route::path("views/$file");
	}else{
		$path=SOURCE_ROOT."/".$folder."/views/$file";
	}
	if(file_exists($path.".blade.php")){
		BladeTemplate::start($path.".blade.php", $var);
	}else{
		if(is_array($var)){ extract($var); }
		$path=$path.".blade.php";
if(!file_exists($path)){
//Tạo file view mẫu
file_put_contents($path,
'
@extends("default")
@php
$_Config=[
"title"   =>"Tiêu đề trang",
"loading" => true
];
@endphp

@section("mid-container")
{{$controllerName}}<br/>
{{$functionName}}<br/>
{!!$callModel!!}
@endsection

@section("script")
<script></script>
@endsection


@section("footer")
@parent
@endsection
');
}
require_once($path);
	}



}




//Nhúng các file layout
function layout($file, $var=''){
	if(is_array($var)){ extract($var); }
	$path=SYSTEM_ROOT."/layouts/$file.php";
	if(file_exists($path)){
		require_once($path);
	}
}




// Lấy giá trị $_GET['key']
function GET($key, $type='', $default=''){
	$out=isset($_GET[$key]) ? $_GET[$key] : $default;
	if($type=="INT"){
	$out=intval($out);
	}else if($type=="SQL"){
	$out=DB::safe($out);
	}else if($type=="LINK"){
	$out=str_link($out);
	}
	return $out;
}






// Lấy giá trị $_POST['key']
function POST($key, $type='', $default=''){
	$out=isset($_POST[$key]) ? $_POST[$key] : $default;
	if($type=="INT"){
	$out=intval($out);
	}else if($type=="SQL"){
	$out=DB::safe($out);
	}else if($type=="LINK"){
	$out=str_link($out);
	}
	return $out;
}





// Lấy COOKIE
function getCookie($key, $default=''){
	$out=isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
	return $out;
}





// Lấy SESSION
function getSession($key, $default=''){
	$out=isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
	return $out;
}




function __($txt,$p=''){
	return $txt;
}








// chuyển hướng tới link
function redirect($link=""){
	if(empty($link)){ $link="/"; }
	Header("Location: $link");
	die;
}



// Mã hóa mật khẩu
function password_encode($password){
	foreach(array("sha256", "sha384", "sha512", "md5") as $hash){
	for($i=0; $i <= 1000; $i++){ $password = hash($hash,$password); }
	}
	return $password;
}

function password_create($password){
	return password_hash(password_encode($password), PASSWORD_DEFAULT);
}
function password_check($password, $hash){
	return password_verify(password_encode($password), $hash);
}




// Hiển thị thời gian
function display_date($time='0',$type='H:i - d/m/Y'){
$shift=UTC_TIME*3600;
		if($type=='shift'){return $shift;}

if($time>0){return date($type, $time+$shift);}else{return '<span style="color:hotpink">display_date(time(),"d/m/Y")</span>';}
}




// Loại bỏ tất cả dấu, ký tự đặc biệt
function str_link($text, $space="-", $lower=true){
$text = html_entity_decode(trim($text," "),ENT_QUOTES,'UTF-8');
$A = array(
'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
'd'=>'đ',
'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
'i'=>'í|ì|ỉ|ĩ|ị',
'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
'D'=>'Đ',
'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
' ' => '[^a-z0-9]'
);

foreach($A as $nonUnicode=>$uni){
$text = preg_replace("/($uni)/i", $nonUnicode, $text);
}

$B = array(
$space => '\s+',
'' => '[^A-z0-9\-_]'
);
foreach($B as $nonUnicode=>$uni){
$text = preg_replace("/($uni)/i", $nonUnicode, $text);
}

if($lower){ $text=strtolower($text); }

return $text;

}





// Phân loại thiết bị người dùng
function device($os=false,$output=''){
	$ua = (empty($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT']);
	if($os){
		
if(preg_match('/Windows NT|^$/i', $ua)){
  $output='WINDOWS';
}elseif(preg_match('/Windows Mobile|Windows Phone|^$/i', $ua)){
  $output='WINDOWSPHONE';
}elseif(preg_match('/Android|^$/i', $ua)){
  $output='ANDROID';
}elseif(preg_match('/MIDP|Symbian|^$/i', $ua)){
  $output='JAVA';
}elseif(preg_match('/iPhone OS|ipad|^$/i', $ua)){
  $output='IOS';
}elseif(preg_match('/Mac OS|^$/i', $ua)){
  $output='MAC';
}else{
  $output='NULL';
}

	}else{
if(preg_match('/Android|iPhone|ipad|MIDP|Phone|Mobile|Wap|^$/i', $ua)){
    $output='mobile';
	}else{
	$output='desktop';
	}
	}
	return $output;
}









// Html char
function html_encode($str){return htmlentities(trim($str), ENT_QUOTES, 'UTF-8');}
function html_decode($str){return html_entity_decode(trim($str), ENT_QUOTES, 'UTF-8');}





// Cắt văn bản
function cutword($str, $len,$char='0'){ 
	$str=html_entity_decode(trim($str), ENT_QUOTES, 'UTF-8');
	if($char=='1'){ $str=str_replace(array("\r","\n","\"","'","`","~","#","$","^","<",">","/","\\","="),',',$str); }
    if (mb_strlen($str, 'UTF-8') > $len*5) { 
        $str = mb_substr($str, 0, $len*5, 'UTF-8');  
        $str = mb_substr($str, 0, mb_strrpos($str," ", 'UTF-8'), 'UTF-8');  
        $str = strip_tags(implode(' ',array_slice(explode(' ',$str),0,$len)));
        } 
    return $str; 
}
	
	
	

// Tạo ký tự ngẫu nhiên
function random_str($length=10, $number=true) {
    $characters = ''.($number ? '0123456789' : '').'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $str= '';
    for($i=0; $i < $length; $i++){
    $str.= $characters[rand(0, $charactersLength - 1)];
    }
return $str;
}






























// Modal box
/*
echo modal('id1', 'tiêu đề', '<div class="amenu">nội dung 1</div>','350px', false, true);
echo '<a data-id="id1" class="link modal-click">Click để hiện hộp thông báo</a>';
*/
$modal_include_script=true;
function modal($id='', $title, $content, $width='90%', $show=false, $close=true){
	global $modal_include_script;
	$output="";
	if($modal_include_script){
	$output.='<script src="/system/assets/modules/modal.js"></script>';
	$modal_include_script=false;
	}
	$output.= '
	<div class="modal modal-id-'.$id.''.($close ? ' modal-allow-close' : '').''.($show ? '' : ' hidden').'">
	<div class="modal-body" style="width:'.$width.'">
	<div class="big-title">'.$title.' '.($close ? '<i style="float:right" class="modal-close link fa fa-times"></i>' : '').'</div>
	<div class="modal-content">'.$content.'</div>
	</div>
	</div>
	';
	return $output;
}




// CURL get content url
function file_get_contents_curl($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}

//Tiêu đề trang
function meta_title($title){
	return strip_tags(htmlspecialchars(html_decode($title)));
}

//Mô tả trang
function meta_desc($description){
	return cutword(strip_tags($description), 45,1);
}