<?php

require "./vendor/autoload.php";

use code\ZipTools;

$file = new ZipTools();

$path = "./upload";
$name = "./upload/test.zip";

$file->unZip($name, $path); // 调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
unset($file);