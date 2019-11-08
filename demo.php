<?php

require "./vendor/autoload.php";

use code\HelloTools;
use code\FileTools;

HelloTools::greet();

$file = new FileTools();

echo $file->isEmpty('/var')."\n";

?>