<?php

DB::table("test")->select("*")//chọn toàn bộ
DB::table("test")->select("column1","column2","column3")//chọn từng cột