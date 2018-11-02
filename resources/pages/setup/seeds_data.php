<?php
/*
# Tạo dữ liệu mẫu
*/

DB::table("options")
->where("key", "=", "Test")
->create(["key"=>"Test", "value"=>"Khởi tạo dữ liệu"]);

