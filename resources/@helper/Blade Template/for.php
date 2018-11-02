@for($i=0; $i < 10; $i++)

<p>Vòng lặp for: {{ $i }}</p>
@if($i==8)
Dừng lặp
@break
@endif

@endfor