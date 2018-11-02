<?php
/*
# Tạo bảng
*/
define("TABLE_CHARACTER", "utf8");
define("TABLE_COLLATE", "utf8_unicode_ci");






CreateTable("files", "
`id` INT(200) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`name` TEXT NOT NULL,
`size` TEXT NOT NULL,
`folder` TEXT NOT NULL,
`type` TEXT NOT NULL,
`desc` TEXT NOT NULL,
`time` INT(200) NOT NULL,
`parent` INT(200) NOT NULL,
`deleted` INT(1) NOT NULL
","Bảng lưu thông tin file");





CreateTable("options", "
`id` INT(200) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`key` TEXT NOT NULL,
`value` LONGTEXT NOT NULL,
`parent` TEXT NOT NULL,
`array` INT(1) NOT NULL
","Bảng lưu các tùy chọn");





CreateTable("account", "
`id` INT(200) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`nick` TEXT NOT NULL,
`password` TEXT NOT NULL,
`login_key` TEXT NOT NULL,
`level` INT(1) NOT NULL,
`login_failed` INT(200) NOT NULL,
`login_failed_time` INT(200) NOT NULL
","Bảng lưu tài khoản người dùng");




CreateTable("categories", "
`id` INT(200) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`title` TEXT NOT NULL,
`link` TEXT NOT NULL,
`desc` TEXT NOT NULL,
`parent` TEXT NOT NULL,
`parents` TEXT NOT NULL,
`children` TEXT NOT NULL,
`time` INT(200) NOT NULL
","Bảng chuyên mục");



CreateTable("post", "
`id` INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`title` TEXT NOT NULL,
`content` LONGTEXT NOT NULL,
`desc` TEXT NOT NULL,
`parent` TEXT NOT NULL,
`parents` TEXT NOT NULL,
`link` TEXT NOT NULL,
`time` INT(200) NOT NULL
","Bảng bài viết");




CreateTable("widget", "
`id` INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`name` TEXT NOT NULL,
`title` TEXT NOT NULL,
`group` TEXT NOT NULL,
`content` LONGTEXT NOT NULL,
`content_preview` LONGTEXT NOT NULL,
`sort` INT(200) NOT NULL,
`time` INT(200) NOT NULL
","Bảng chứa tiện ích");



CreateTable("topic", "
`id` INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`text` TEXT NOT NULL,
`desc` TEXT NOT NULL,
`cate_id` INT(200) NOT NULL
","Bảng chứa tiện ích");




CreateTable("cate", "
`id` INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`name` TEXT NOT NULL
","Bảng chứa tiện ích");