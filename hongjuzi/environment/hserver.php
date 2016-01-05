<?php

/**
 * @version			$Id: HServer.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-27 12:08:16 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		environment
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 服务器信息检测工具类 
 * 
 * 收集服务器相关版本及配置信息，为程序的运行提供服务器部分的
 * 环境检测。 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.environment
 * @since 			1.0.0
 */
class HServer extends HObject
{

    /**
     * 得到服务器名称 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getHttpdName()
    {
        return $_SERVER['SERVER_SIGNATURE'];
    }

    /**
     * 得到Httpd服务器的版本 
     * 
     * @desc
     * 
     * @access public static
     * @return void
     * @exception none
     */
    public static function getHttpdVersion() 
    {
        return '';
    }

    /**
     * 得到服务器的解析引擎 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getParseEngine()
    {
        return $_SERVER['SERVER_SOFTWARE'];
    }

    /**
     * 得到服务器版本 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getPhpVersion()
    {
        return PHP_VERSION; 
    }

    /**
     * 得到PHP的安装文件路径 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getPhpSetUpPath()
    {
        return DEFAULT_INCLUDE_PATH;
    }

    /**
     * 得到PHP跟WEB服务器的运行方式 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getPhpRunMethod()
    {
        return php_sapi_name();
    }

    /**
     * 得到zend引擎的版本 
     * 
     * @desc
     * 
     * @access public static
     * @return void
     * @exception none
     */
    public static function getZendVersion()
    {
        return zend_version();
    }

    /**
     * 得到服务器IP 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getServerIp()
    {
        return GetHostByName($_SERVER['SERVER_NAME']); 
    }

    /**
     * 得到服务器的端口 
     * 
     * @desc
     * 
     * @access public static
     * @return int 
     * @exception none
     */
    public static function getServerPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * 得到服务器域名 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getServerHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * 得到最大上传文件大小限制 
     * 
     * @desc
     * 
     * @access public static
     * @return string
     * @exception none
     */
    public static function getUploadMaxFileSize()
    {
        return get_cfg_var('upload_max_filesize') ? get_cfg_var('upload_max_filesize') : '不允许上传附件!';
    }

    /**
     * 得到脚本最大的执行时间 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getMaxExecuteTime()
    {
        return get_cfg_var('max_execution_time') . '秒';
    }

    /**
     * 得到最的内存限制 
     * 
     * @desc
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getMemoryLimit()
    {
        return get_cfg_var('memory_limit') ? get_cfg_var('memory_limit') : '无';
    }

    /**
     * 检测当前的php版本是否支持 
     * 
     * 只用传入对应的版本号即可，如:
     * <code>
     * var_dump(HServer::isSupportVersion('4.3.0'));
     * var_dump(HServer::isSupportVersion('5.3.0'));
     * var_dump(HServer::isSupportVersion('6.0.0'));
     * </code> 
     * 
     * @access public static
     * @param $minVersion
     * @return void
     * @exception none
     */
    public static function isSupportVersion($minVersion)
    {
        if(!version_compare(PHP_VERSION, $minVersion, '>=')) {
            return false;
        }

        return true;
    }

    /**
     * 加载外部的PHP扩展 
     * 
     * 注意得版本匹配 
     * 
     * @access public static
     * @param string $extensionPath 扩展的路径
     * @return boolean 
     * @exception none
     */
    public static function loadExtension($extensionPath)
    {
        if(!extension_loaded($extensionPath)) {
            if(!dl($extensionPath)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 公用的检测是否支持插件的方法 
     * 
     * 只用传入插件的名称即可，如
     * <code>
     *  HServer::isSupportExtension('mstring')
     * </code> 
     * 
     * @access public static
     * @param $extensionName
     * @return void
     * @exception none
     */
    public static function isSupportExtension($extensionName)
    {
        return extension_loaded($extensionName);
    }

    /**
     * 是否支持GD图形库
     * 
     * @desc
     * 
     * @access public static
     * @return void
     * @exception none
     */
    public static function isSupportGD()
    {
        return extension_loaded('gd');
    }

    /**
     * 是否支持PDO数据库访问方式 
     * 
     * 使用直接写死的gd检测 
     * 
     * @access public static
     * @return boolean 
     * @exception none
     */
    public static function isSupportPDO()
    {
        return extension_loaded('pdo');
    }

}
?>
