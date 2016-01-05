<?php

/**
 * @version			$Id: hdatetime.php 2006 2012-07-29 09:19:47Z xjiujiu $
 * @create 			2012-3-11 18:04:18 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		utils
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 日期时间工具类 
 * 
 * 格式化时间及区域化时间 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.utils
 * @since 			1.0.0
 */
class HDatetime
{

    /**
     * 得到本地的日期时间 
     * 
     * 根据当前所设置的时间位置 
     * 
     * @access public static
     * @return string 
     * @exception none
     */
	public static function getNow()
    {
        return date('Y-m-d H:m:s');
    }

    /**
     * 得到本地的日期值 
     * 
     * 这个得依据当前设置的时区 
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getLocalDate()
    {
        return date('Y-m-d');
    }

    /**
     * 得到本地的时间 
     * 
     * 根据当前所设置的时间位置 
     * 
     * @access public static
     * @return string 
     * @exception none
     */
	public static function getLocalTime()
    {
        return date('H:m:s');
    }

    /**
     * 得到年值 
     * 
     * 当有指定的时间时，就按指定的时间来，如果没有就按当前的时间来
     * 
     * @access public static
     * @param string $datetime 指定的时间，默认为：''
     * @return int 
     * @throws none
     */
    public static function getYear($datetime = '')
    {
        if(empty($datetime)) {
            return date('Y'); 
        }

        return date('Y', strtotime($datetime));
    }

    /**
     * 得到月份 
     * 
     * 当有指定时间时，则用给定的时间，如果没有就按当前的时间来 
     * 
     * @access public static
     * @param string $datetime 给定的时间，默认为：''
     * @return int 
     * @throws none
     */
    public static function getMonth($datetime = '')
    {
        if(empty($datetime)) {
            return date('m'); 
        }

        return date('m', strtotime($datetime));
    }

    /**
     * 得到日 
     * 
     * 当有指定的时间时，则用给定的时间，如果没有就按当前的时间来 
     * 
     * @access public static
     * @param string $datetime 给定的时间，默认为：''
     * @return int 
     * @throws none
     */
    public static function getDay($datetime = '')
    {
        if(empty($datetime)) {
            return date('d');
        }

        return date('d', strtotime($datetime));
    }

    /**
     * 格式化当前的时间 
     * 
     * 用法：
     * <code>
     * HDatetime::format('2012-10-29 15:30:30');    //2012-10-29
     * </code> 
     * 
     * @access public static
     * @param  String $datetime 当前的时间
     * @param  String $format 当前的时间格式，默认为：'Y-m-d'
     * @return String　格式化后的时间
     * @exception none
     */
    public static function format($dateTime, $format = 'Y-m-d')
    {
        return date($format, strtotime($dateTime));
    }

}
?>
