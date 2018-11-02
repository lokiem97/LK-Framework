@php
$bien="giá trị";
@endphp

//echo ra $bien (Mã hóa HTML)
{{$bien}}

//echo ra $bien (Cho phép HTML)
{!!$bien!!}

//Nếu dùng JS framework như angular: cần đổi {{angular-content}} sang @{{angular-content}}
@{{angular-content}}