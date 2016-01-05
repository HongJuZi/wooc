<?php

/**
 * @version			$Id: HOs.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-27 12:19:45 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		environment
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 当前程序运行操作系统类 
 * 
 * 检测当前操作系统的信息 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.environment
 * @since 			1.0.0
 */
class HOs
{

    /**
     * 得到操作系统类型 
     * 
     * 通过PATH_SEPARATOR的类型来判断 
     * 
     * @access public static
     * @return string
     */
    public static function getOsName()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'NT 5.1')) {
            return 'Windows XP (SP2)';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'NT 5.2') && strpos($_SERVER['HTTP_USER_AGENT'], 'WOW64')){
            return 'Windows XP 64-bit Edition';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'NT 5.2')) {
            return 'Windows 2003';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'NT 6.0')) {
            return 'Windows Vista';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'NT 6.2')) {
            return 'Windows 8';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'NT 6.3')) {
            return 'Windows 8.1';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'NT 5.0')) {
            return 'Windows 2000';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], '4.9')) {
            return 'Windows ME';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'NT 4')) {
            return 'Windows NT 4.0';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], '98')) {
            return 'Windows 98';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], '95')) {
            return 'Windows 95';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Mac')) {
            return 'Mac';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')) {
            return 'Linux';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Unix')) {
            return 'Unix';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'FreeBSD')) {
            return 'FreeBSD';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'SunOS')) {
            return 'SunOS';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'BeOS')) {
            return 'BeOS';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'OS/2')) {
            return 'OS/2';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'PC')) {
            return 'Macintosh';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'AIX')) {
            return 'AIX';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'IBM OS/2')) {
            return 'IBM OS/2';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'BSD')) {
            return 'BSD';
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'NetBSD')) {
            return 'NetBSD';
        }

        return 'Other';
    }

    /**
     * 得到操作系统类型 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getOsType()
    {
        return php_uname('s');
    }

    /**
     * 得到操作系统版本号 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getOsVersion()
    {
        return php_uname('v');
    }

    /**
     * 得到操作系统稳定版本号
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getOsRelease()
    {
        return php_uname('r');
    }

    /**
     * 得到机器类型
     * 
     * @desc
     * 
     * @access public static
     * @return string
     * @exception none
     */
    public static function getMachineType()
    {
        return php_uname('m');
    }

    /**
     * 得到当前的用户进程 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getCurrentUser()
    {
        return Get_Current_User();
    }

}
?>
