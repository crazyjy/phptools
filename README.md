# phptools
整理了 php 一些常用方法

# 安装方法：
composer require crazyjy/phptools

# 使用方法：

require "./vendor/autoload.php";

use code\HelloTools;
$file = new HelloTools();
$file->greet(); // 输出 “Hello Tools”
unset($file);

** 其余方法类似 **

 * 跟curl相关的工具类********************************************************************
 * Class CurlsTools
 * 
 * 1、httpGet - get请求之发送数组
 * 2、httpPost - post请求之发送数组
 * 3、curlGetContents - 使用curl获取远程数据
 * 4、putFileFromUrlContent - 异步将远程链接上的内容(图片或内容)写到本地
 * 5、httpProxy - 使用代理抓取页面
 * 6、httpSession - 继续保持本站session的调用
 * 
 * 文件工具类********************************************************************
 * Class FileTools
 * 
 * 1、 dirReplace - 替换相应的字符
 * 2、 isEmpty - 判断目录是否为空
 * 3、 rename - 文件重命名
 * 4、 checkPath - 文件保存路径处理
 * 5、 downFile - 文件下载功能
 * 6、 isWriteAble - 判断 文件/目录 是否可写（取代系统自带的 is_writeable 函数）
 * 7、 saveArrayToFiles - 保存数组变量到php文件
 * 8、 paramLabel - 转化格式化的字符串为数组
 * 9、 getFileExtension - 获取文件扩展名
 * 10、getDirTree - 获取目录列表
 * 11、dirPath - 转化 \ 为 /
 * 12、dirCreate - 创建目录
 * 13、dirCopy - 拷贝目录及下面所有文件
 * 14、getBasename - 获取完整文件名
 * 15、dirList - 列出目录下所有文件
 * 16、dirDelete - 删除目录及目录下面的所有文件
 * 17、close - 关闭文件操作
 * 18、createBase64 - Base64字符串生成图片文件,自动解析格式
 * 19、byteFormat - 文件字节转具体大小 array("B", "KB", "MB", "GB", "TB", "PB","EB","ZB","YB")， 默认转成M
 * 20、unlinkFile - 删除文件
 * 21、handleFile - 文件操作(复制/移动)
 * 22、handleDir - 文件夹操作(复制/移动)
 * 23、listInfo - 返回指定文件和目录的信息
 * 24、openInfo - 返回关于打开文件的信息
 * 25、changeFile - 改变文件和目录的相关属性
 * 26、getUploaFileInfo - 取得上传文件信息
 * 27、setFileName - 设置文件命名规则
 * 28、createFile - 创建指定路径下的指定文件
 * 29、readFile - 读取文件操作
 * 30、allowUploadSize - 确定服务器的最大上传限制（字节数）
 * 31、writeLogFile - 写文件日志
 * 32、readLogFile - 读取文件内容
 * 33、getDirFileList - 获取文件名称列表
 * 34、checkDirEmpty - 判断目录是否存在
 *
 * 与服务器相关的工具类********************************************************************
 * Class ServerTools
 *
 * 1、getOS - 判断当前服务器系统
 * 2、getMemoryUsage - 脚本使用的内存
 * 3、isIE - IE浏览器判断
 * 4、getIp - 获取客户端地址ip
 * 
 * 替换敏感字符串工具类********************************************************************
 * Class CharacterTools
 *
 * 1、replace - 替换非法字符
 * 2、check - 检查是否含有非法自符
 *
 * 字符串相关操作的工具类********************************************************************
 * Class StringTools 
 *
 * 1、mSubStr - 字符串截取，支持中文和其他编码
 * 2、hideTel - 利用正则表达式实现手机号码中间4位用星号替换显示
 * 3、getFileExt - 获取指定文件的后缀名
 * 4、is_utf8_gb2312 - 判断字符串是utf-8 还是gb2312
 * 5、safeEncoding - utf-8和gb2312自动转化
 * 6、subStrCut - 将用户名中间用星号表示（支持中文）
 * 7、randomString - 随机字符串生成
 * 8、random - 随机字符生成
 * 9、uniqueNumber - 生成唯一id号
 * 10、strExists - 查询字符是否存在于某字符串
 * 11、getSubstr - 实现中文字串截取无乱码的方法
 * 12、mobileHide - 手机号隐藏中间
 * 13、autoCharset - 自动转换字符集（支持数组转换）
 * 
 * 上传文件工具类********************************************************************
 * class UploadTools 
 *
 * 1、upload - 文件上传 ('jpeg','jpg','png','gif','bmp','doc','xls','csv','zip','rar','txt','wps')
 * 
 * 校验工具类，如验证ip、手机、邮箱等********************************************************************
 * Class VerifyTools
 *
 * 1、isIPAddress - 验证ip地址
 * 2、isValidEmail - 验证邮箱格式
 * 3、isMobile - 判断是否为手机访问
 * 4、isWeiXin - 判断是否为微信访问
 * 5、checkMobile - 检查手机号码格式
 * 6、checkTelephone - 检查固定电话
 * 7、isHttps - 当前请求是否是https
 * 
 * Zip压缩解压工具类 （需要使用php Zip支持）********************************************************************
 * Class ZipTools
 *
 * 1、zip - 压缩文件成Zip 压缩包（只支持目录）
 * 2、unZip - 从zip压缩文件中提取文件
 *