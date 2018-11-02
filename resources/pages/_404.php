<?php
Route::link("*", 
function(){
	view("Not_Found", "", "_404");
});
