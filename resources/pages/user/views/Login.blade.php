@extends("default")
@php
$_Config=[
"title"   =>"Tiêu đề trang",
"loading" => true
];
@endphp
@section("head-tag")
Mã thêm
@endsection



@section("mid-container")
<div class="middle">
<div class="middle-body" style="width:95%;max-width:400px;margin: 0 auto">

<div class="simple-title center bd">Đăng nhập</div>
<div class="wall-sky"></div>
{!! (isset($login_wrong) ? '<div class="error">'.$login_wrong.'</div>' : '') !!}
<form action="" method="POST">
<div class="menu bd">
<div class="pd-5"><input class="font-icon" placeholder="&#xf2c0; Tên đăng nhập" style="width:100%" type="text" value="{{ GET('nick') }}" name="nick"/></div>
<div class="pd-5"><input class="font-icon" placeholder="&#xf023; Mật khẩu" style="width:100%" type="password" name="password"/></div>
<div class="pd-5"><input style="width:100%" name="loginSubmit" type="submit" value="Đăng nhập"/></div>
</div>
<div class="list bd password_forget link"><i class="fa  fa-key" aria-hidden="true"></i> Quên mật khẩu</div>
<div id="password_forget" class="hidden">
<div class="menu bd">
<input style="width:100%" type="text" value="{{password_create('123456')}}"/><br/>
Copy mật khẩu trên và thay vào <b>password</b> trong database<br/>Mật khẩu mới sẽ là <b>123456</b>
</div>
</div>
</form>

</div>
</div>

@endsection





@section("script")
<script>
$(".password_forget").click(function(){
	$("#password_forget").slideToggle();
});
</script>
@endsection


@section("footer")
@parent
Hihi
@endsection