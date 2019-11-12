<?php 

namespace code;

/**
 * 上传文件工具类
 * class UploadTools 
 *
 * 方法：
 *     1、upload - 文件上传 ('jpeg','jpg','png','gif','bmp','doc','xls','csv','zip','rar','txt','wps')
 * 
 * 参数1：文件保存路径，不存在则会创建（默认为./upload）
 * 参数2：文件大小（默认10M）
 * 
 * return bool;
 */
class UploadTools {

    private $upload_name;                           // 上传文件名
    private $upload_tmp_name;                       // 上传临时文件名
    private $upload_final_name;                     // 上传文件的最终文件名
    private $upload_target_dir;                     // 文件被上传到的目标目录
    private $upload_target_path;                    // 文件被上传到的最终路径
    private $upload_filetype ;                      // 上传文件类型
    private $allow_uploadedfile_type;               // 允许的上传文件类型
    private $upload_file_size;                      // 上传文件的大小
    private $allow_uploaded_maxsize;                // 允许上传文件的最大值，单位为字节，现在相当于允许上传 10M 的文件

    /**
     * 初始化构造函数
     * [__construct description]
     * @param string  $file_patch    [description]
     * @param integer $file_max_size [description]
     */
    public function __construct($file_patch = "./upload", $file_max_size = 10240000)
    {
        $this->upload_name = $_FILES["file"]["name"];
        $this->upload_filetype = $_FILES["file"]["type"];
        $this->upload_tmp_name = $_FILES["file"]["tmp_name"];
        $this->allow_uploadedfile_type = array('jpeg','jpg','png','gif','bmp','doc','xls','csv','zip','rar','txt','wps');
        $this->upload_file_size = $_FILES["file"]["size"];
        $this->upload_target_dir = $file_patch;
        $this->allow_uploaded_maxsize = $file_max_size;
    }

    /**
     * 获取文件扩展名
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    private function getFileExt($filename){

        if ($info = pathinfo($filename)) {
            return @$info["extension"];
        }
        
        exit("获取不到文件扩展名");
    }


    /**
     * 上传文件方法
     * [upload description]
     * @return [type] [description]
     */
    public function upload()
    {
        if(!empty($_FILES)){
            $upload_filetype = self::getFileExt($this->upload_name);         // 获取文件扩展名
            if(in_array($upload_filetype,$this->allow_uploadedfile_type))    // 判断文件类型是否符合要求
            {
                if($this->upload_file_size <= $this->allow_uploaded_maxsize) // 判断文件大小是否超过允许的最大值
                {
                    if(!is_dir($this->upload_target_dir))                    // 如果文件上传目录不存在
                    {
                        mkdir($this->upload_target_dir,true);                // 创建文件上传目录
                        chmod($this->upload_target_dir,0777);                // 改权限
                    }
                    $this->upload_final_name = date("YmdHis").rand(1000,9999).'.'.$upload_filetype;      // 生成随机文件名
                    $this->upload_target_path = $this->upload_target_dir."/".$this->upload_final_name;   // 文件上传目标目录
                    if(!move_uploaded_file($this->upload_tmp_name, $this->upload_target_path))           // 文件移动失败
                    {
                        echo "<p style='color=red'>文件上传失败！</p>";
                    } 
                    else 
                    {
                        echo "<p style='color=green'>文件上传成功！</p>";
                        return true;
                    }
                }
                else
                {
                    echo("<p style='color=red'>文件太大,上传失败！</p>");
                }
            }
            else
            {
                echo("<p style='color=red'>仅支持一下文件类型，请重新选择：<br>".implode('，',$this->allow_uploadedfile_type)."</p>");
            }
        }else{
            echo("<p style='color=red'>请上传文件！</p>");
        }
        return false;
    }
}