<?php

DB::table("options")->select("value","key")->distinct()->where("id", ">", "0")->get();