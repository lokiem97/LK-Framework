@php
$id="hi";
@endphp

@switch($id)
@case("0")
id = 0
@break

@case("hi")
id = hi
@break

@default
id = khác
@endswitch