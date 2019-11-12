<?php

namespace code;

/**
 * 跟curl相关的工具类
 * Class CurlsTools
 * 
 * 1、httpGet - get请求之发送数组
 * 2、httpPost - post请求之发送数组
 * 3、curlGetContents - 使用curl获取远程数据
 * 4、putFileFromUrlContent - 异步将远程链接上的内容(图片或内容)写到本地
 * 5、httpProxy - 使用代理抓取页面
 * 6、httpSession - 继续保持本站session的调用
 * 
 */
class CurlTools{

    /**
     * @desc PHP get请求之发送数组
     * @param $url
     * @param array $param
     * @return mixed
     * @throws Exception
     */
    public function httpGet($url){

        // 初始化一个 cURL 对象
        $ch  = curl_init();
        // 设置你需要抓取的URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上(从 PHP 5.1.3 开始，此选项不再有效果)。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 是否获得跳转后的页面
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }

    /**
     * @desc PHP post请求之发送数组
     * @param $url
     * @param array $param
     * @return mixed
     * @throws Exception
     */
    public function httpPost($url, $param = array())
    {

        $ch = curl_init();                      // 初始化一个 cURL 对象
        curl_setopt($ch, CURLOPT_URL, $url);    // 设置需要抓取的URL
        curl_setopt($ch, CURLOPT_HEADER, 0);    // 设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
        // 如果你想PHP去做一个正规的HTTP POST，设置这个选项为一个非零值。
        // 这个POST是普通的 application/x-www-from-urlencoded 类型，多数被HTML表单使用。
        curl_setopt($ch, CURLOPT_POST, 1);
        // 传递一个作为HTTP “POST”操作的所有数据的字符串。
        // //http_build_query:生成 URL-encode 之后的请求字符串
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param)); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type:application/x-www-form-urlencoded;charset=utf-8'
        ));
        $result = curl_exec($ch); // 运行cURL，请求网页
        if ($errno = curl_errno($ch)) {
            throw new Exception ('Curl Error(' . $errno . '):' . curl_error($ch));
        }
        curl_close($ch); // 关闭URL请求
        return $result;  // 返回获取的数据

    }

    /**
     * @desc 使用curl获取远程数据
     * @param  string $url url连接路径
     * @return string      获取到的数据
     */
    public function curlGetContents($url){

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
        curl_setopt($ch, CURLOPT_HEADER,1);                 //是否显示头部信息
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);   //用户访问代理 User-Agent
        curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);            //设置 referer
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果

        //这个是重点，加上这个便可以支持http和https下载
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

    }

    /**
     * @desc 异步将远程链接上的内容(图片或内容)写到本地
     * 说明：
     *     $url = http://src.onlinedown.net/Public/images/bigsoftimg/480000/475065.jpg;
     *     $saveName = 'whm.jpg';
     *     $path = "./"; 保存在当前目录下
     *     $res = putFileFromUrlContent($url,$saveName,$path);
     *     var_dump($res);// 当返回为true时，代表成功，反之，为失败
     * @param $url          远程地址
     * @param $saveName     保存在服务器上的文件名（同名会覆盖）
     * @param $path         保存路径
     * @return boolean
     */
    public function putFileFromUrlContent($url, $saveName, $path = './upload/') {

        if (isset($url) && isset($saveName)) {
            // 设置运行时间为无限制
            set_time_limit ( 0 );
            $url = trim ( $url );
            $curl = curl_init ();
            // 设置你需要抓取的URL
            curl_setopt ( $curl, CURLOPT_URL, $url );
            // 设置header
            curl_setopt ( $curl, CURLOPT_HEADER, 0 );

            // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
            curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );

            //这个是重点，加上这个便可以支持http和https下载
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            // 运行cURL，请求网页
            $file = curl_exec ( $curl );

            // 关闭URL请求
            curl_close ( $curl );

            // 将文件写入获得的数据
            $filename = $path . $saveName;
            $write = @fopen ( $filename, "w" );
            if ($write == false) {
                return false;
            }
            if (fwrite ( $write, $file ) == false) {
                return false;
            }
            if (fclose ( $write ) == false) {
                return false;
            }

            return true;
        }
        
        return false;
    }

    /**
     * @desc 使用代理抓取页面
     * 说明：为什么要使用代理进行抓取呢？
     *     以google为例吧，如果去抓google的数据，短时间内抓的很频繁的话，你就抓取不到了
     *     google对你的ip地址做限制这个时候，你可以换代理重新抓。
     * @param $url
     * @return mixed
     */
    public function httpProxy($url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //是否通过http代理来传输（设置为 TRUE 会通过代理抓取）
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, FALSE);
        // curl_setopt($ch, CURLOPT_PROXY, 125.21.23.6:8080);
        curl_setopt($ch, CURLOPT_PROXY, 'ip:端口号');
        //url_setopt($ch, CURLOPT_PROXYUSERPWD, 'user:password');如果要密码的话，加上这个
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }

    /**
     * @desc 继续保持本站session的调用,
     * 说明：在实现用户同步登录的情况下需要共享session,
     *     如果要继续保持本站的session,那么要把session_id放到http请求中
     * @param $url
     * @return mixed
     */
    public function httpSession($url){

        $session_str = session_name().'='.session_id().'; path=/; domain=.explame.com';
        session_write_close(); //将数据写入文件并且结束session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $session_str);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }
}