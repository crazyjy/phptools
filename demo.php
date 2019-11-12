<?php

require "./vendor/autoload.php";

use code\HelloTools;
$file = new HelloTools();
$file->greet(); // 输出 “Hello Tools”
unset($file);