{{--Head--}}
<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="language" content="Vietnamese" /><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>{{ str_link($_Config['title']) }}</title>
<meta property="og:title" content="@yield("title")"/>
<meta name="description" content="'.meta_desc($description).'" />
<meta property="og:description" content="'.meta_desc($description).'"/>
<meta name="robots"content="'.$robots.'" />
{!! empty($_Config['imageMeta']) ? '' : '<meta property="og:image" content="'.$_Config['imageMeta'].'" />' !!}
{!! empty($_Config['canonical']) ? '' : '<link rel="canonical" href="'.$_Config['canonical'].'" />' !!}
<link rel="stylesheet" href="/assets/css/style.css" media="all" />
<script src="/assets/js/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
@yield("head-tag")
</head>
<body>




{{--Logo & box tìm kiếm--}}
<div class="header">
<div class="header-body">

<a href="/">
<img class="logo" src="option::get("header_logo")" alt="'.ucwords(DOMAIN).'"></a>

<form action="/" class="head-form hidden-mb">
<input type="text" name="s" placeholder="Nhập từ..." class="head-input" onkeyup="search();" required="">
 <button class="btn-button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>

</div>
</div>





{{--Hiện ảnh loading--}}
@if($_Config['loading'])
<div id="loading">
<div style="top:0;padding-top:50px;position:fixed;z-index:9999;width:100%;height:100%;overflow:auto;background-color:#000;background-color:rgba(0,0,0,0.5);left:0">
<img style="position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;width:90px" src="https://meohay.com/wp-content/themes/sienit/control/assets/images/loading_gif.gif"/>
</div>
</div>

<script>
$(document).ready(function(){
setTimeout(function(){
$("#loading").hide();
},'.$loading.');
});
</script>
@endif



@section("mid-container")
Mid
@show


@yield("script")




@section("footer")
Dưới trang
@show