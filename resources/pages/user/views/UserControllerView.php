<?php
layout("header",[
"title"       => " $controllerName ",
"description" => "Nội dung mô tả",
"header"      => true,
"footer"      => true,
"robots"      => "index,follow",
"user_level"  => 0,
"loading"     => 0,
"meta_tag"    => ""
]);

echo $controllerName."<br/>".$functionName."<br/>".$callModel;

layout("footer");
