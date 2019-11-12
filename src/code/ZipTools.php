<?php

namespace code;

use ZipArchive;

/**
 * Zip压缩解压工具类 （需要使用php Zip支持）
 * Class ZipTools
 *
 * 方法：
 * 1、zip - 压缩文件成Zip 压缩包（只支持目录）
 * 2、unZip - 从zip压缩文件中提取文件
 */
class ZipTools{

    /**
     * 压缩文件成Zip 压缩包
     * 
     * 参数1：$path = $_SERVER['DOCUMENT_ROOT'];
     * 参数2：$name = $_SERVER['DOCUMENT_ROOT']."/20180826.zip";
     *
     * [zip description]
     * @param  [type] $path [description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function zip($path, $name) {

        $zip = new ZipArchive();

        if($zip->open($name, ZipArchive::CREATE) === TRUE) {
            self::addFileToZip($path, $zip);
            $zip->close();
            return true;
        }

        return false;

    }

    /**
     * 进行压缩
     * [addFileToZip description]
     * @param [type] $path [description]
     * @param [type] $zip  [description]
     */
    private function addFileToZip($path, $zip){

        // 转化 \ 为 / ，适应 windows
        $file_tools = new FileTools();
        $path = $file_tools->dirPath($path);

        // 判断是不是目录，是的话递归进入
        if(is_dir($path)) {
            $handler = opendir($path); //打开当前文件夹由$path指定。
            while (($filename = readdir($handler)) !== false) {
                if ($filename != "." && $filename != "..") {
                    //文件夹文件名字为'.'和'..'，不要对他们进行操作
                    if (is_dir($path . "/" . $filename)) {
                        // 如果读取的某个对象是文件夹，则递归
                        $this->addFileToZip($path . "/" . $filename, $zip);
                    } else { //将文件加入zip对象
                        $zip->addFile($path . "/" . $filename);
                    }
                }
            }
        }else{
            $zip->addFile($path);
        }
        @closedir($path);

    }

    /**
     * @desc 从zip压缩文件中提取文件
     *
     * 使用示例：
     *     $filename = $_SERVER['DOCUMENT_ROOT'].'/unzip.zip';
     *     $path = $_SERVER['DOCUMENT_ROOT'].'/unzip';
     *     unZip($filename,$path);
     *
     * [unZip description]
     * @param  string $filename [description]
     * @param  string $path     [description]
     * @return [type]           [description]
     */
    public function unZip($filename = '', $path = ''){

        //将文件名和路径转成windows系统默认的gb2312编码，否则将会读取不到
        $filename = iconv("utf-8","gb2312",$filename);
        $path = iconv("utf-8","gb2312",$path);

        if (!file_exists($filename)) {
            return false;
        }

        $zip = new ZipArchive();

        if ($zip->open($filename) === TRUE) {   // 中文文件名要使用ANSI编码的文件格式
            $zip->extractTo($path); // 提取全部文件
            $zip->close();
            return true;
        }

        return fasle;
    }
}