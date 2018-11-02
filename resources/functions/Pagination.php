<?php
/*
# Phân trang
*/
function paginationLinks($op, $pageCurrent, $limit, $total){
		$totalPage   = ceil($total/$limit);
		if($totalPage<2){ return; }
		$pageCurrent  = ($pageCurrent > 0 ? $pageCurrent : 1);
$out=''.($op['goto'] ? '<script>$(document).ready(function(){
$(".page-current").on("click", function() {
var to_page = prompt("Nhập trang cần đến, trang cuối: '.$totalPage.'", "'.$pageCurrent.'");
var page = parseInt(to_page);
if(page>0 && page<='.$totalPage.'){
location.href="'.$op['url'].'page="+page+"";
}		  
}); 
});</script>' : '').'';
if($pageCurrent > 1 && $totalPage > 1){
$out.='<a class="page-prev" data-page="'.($pageCurrent-1).'" href="'.($op['url']=='#' ? '' : ''.$op['url'].'page='.($pageCurrent-1).'').''.$op['jump'].'">'.$op['prev'].'</a>';
}
$out.='<span data-total="'.$totalPage.'" data-page="'.$pageCurrent.'" class="page-current">'.$pageCurrent.'</span>';
if($pageCurrent < $totalPage && $totalPage > 1){
$out.='<a class="page-next" data-page="'.($pageCurrent+1).'" href="'.($op['url']=='#' ? '' : ''.$op['url'].'page='.($pageCurrent+1).'').''.$op['jump'].'">'.$op['next'].'</a>';
}
return $out;
}