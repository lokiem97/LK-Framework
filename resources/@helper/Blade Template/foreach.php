@php
$array=["Thử","nào"];
@endphp

@foreach($array as $test)
@php
$i++;
@endphp

@if($i==1)

Bỏ qua
@continue

@elseif($i==2)

Dừng vòng lặp
@break

@endif

{{$test}} <br/>


@endforeach