<?php

namespace code;

/**
 * 字符串相关操作的工具类 
 * Class StringTools 
 *
 * 方法：
 * 1、mSubStr - 字符串截取，支持中文和其他编码
 */

class TimeTools{

    /**
     * 计算前后相差天数
     * 
     * 输入：
     *     2018-05-05 21:21:11 时间格式（24小时制度）
     *     2018-05-06 21:21:11 时间格式（24小时制度）
     * 返回：
     *     1（小于0天则为0）
     *     
     * [differenceDay description]
     * @param  [type] $begin_date [description]
     * @param  [type] $end_date   [description]
     * @return [type]             [description]
     */
    public function differenceDay($begin_date, $end_date) {
        $day = round((strtotime($end_date)-strtotime($begin_date))/3600/24);
        return $day>0?$day:0;
    }

}

