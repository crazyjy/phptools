<?php
/**
 * 测试upload文件方法
 */
require "./vendor/autoload.php";

use code\UploadTools;

$file = new UploadTools();

$file->upload();

?>