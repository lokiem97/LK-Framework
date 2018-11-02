
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
