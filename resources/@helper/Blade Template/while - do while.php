@php
$id = 0;
@endphp

//While loop
@while($id < 10)

<p>Vòng lặp while: {{$id}}.</p>
@php
$id++;
@endphp

@endwhile




//Do while loop
@php
$i = 1;
do{
echo $i;
$i++;
}while ($i <= 10);
@php