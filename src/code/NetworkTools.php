<?php 

namespace code;

/**
 * 文件工具类
 * Class FileTools
 *
 * 方法：
 * 1、 httpPost - POST方法 支持Authorization（基于 curl）
 * 2、 httpGet - 普通 GET1方法 支持Authorization（基于 curl）
 * 3、 httpPost2 - 普通post方法（基于 curl）
 */

class networkTools() {

    /**
     * POST方法 支持Authorization（基于 curl）
     * @param  [type] $url         [description]
     * @param  [type] $data_string [description]
     * @param  string $header      [description]
     * @return [type]              [description]
     */
    public function httpPost($url, $data_string, $header = '') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . $header,
            'X-AjaxPro-Method:ShowList',
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * 普通 GET1方法 支持Authorization（基于 curl）
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public function httpGet($url) {
        $curl = curl_init(); //初始化
        curl_setopt($curl, CURLOPT_URL, $url); //设置抓取的url
        curl_setopt($curl, CURLOPT_HEADER, 0); //设置为0不返回请求头信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 跳过https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($curl); //执行命令
        curl_close($curl); //关闭URL请求
        return $data; //返回获得的数据   
    }

    /**
     * 普通post方法（基于 curl）
     * @param  [type] $url  [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function httpPost2($url, $data) {
        $curl = curl_init(); //初始化
        curl_setopt($curl, CURLOPT_URL, $url); //设置抓取的url
        curl_setopt($curl, CURLOPT_HEADER, 0); //设置为0不返回请求头信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 跳过https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1); //设置post方式提交
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); //设置post数据，
        $data = curl_exec($curl); //执行命令
        curl_close($curl); //关闭URL请求
        return $data; //返回获得的数据        
    }
}