<?php

/**
 * @version			$Id$
 * @create 			2012-4-10 8:53:12 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		database
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 框架数据库实例工厂类 
 * 
 * 根据用户的配置返回对应的数据库驱动实例 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.database
 * @since 			1.0.0
 */
class HDbFactory extends HObject
{

    /**
     * @var private static $_dbMap 数据库操作容器
     */
    private static $_dbMap  = array();

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function __construct()
    {
    
    }

    /**
     * 得到数据库的驱动实例 
     * 
     * 当系统不提供对应的驱动时，抛出异常
     * 
     * @access public
     * @param object $dbConfig 数据库配置
     * @return IDatabase 
     * @exception none
     */
    public static function getDbDriver($dbConfig)
    {
        $hash   = self::_getDbCfgHash($dbConfig);
        if(!isset(self::$_dbMap[$hash])) {
            switch($dbConfig->dbDriver) {
                case 'mysql':
                    HClass::import('hongjuzi.database.db.mysql.HMysql');
                    self::$_dbMap[$hash]    = HMysql::getInstance($dbConfig);
                    break;
                case 'mysqli':
                    HClass::import('hongjuzi.database.db.mysql.HMysqli');
                    self::$_dbMap[$hash]    = HMysqli::getInstance($dbConfig);
                    break;
                case 'PDO':
                    HClass::import('hongjuzi.database.db.mysql.HPdo');
                    self::$_dbMap[$hash]    = HPdo::getInstance($dbConfig);
                    break;
                case 'oracle':
                    HClass::import('hongjuzi.database.db.HOracle');
                    self::$_dbMap[$hash]    = HOracle::getInstance($dbConfig);
                    break;
                default:
                    throw new HVerifyException('CAN_NOT_FOUND_DB_DRIVER');
            }
        }
        return self::$_dbMap[$hash];
    }

    /**
     * 当前数据库的配置 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  Array $dbConfig 数据库的配置
     * @return String 
     */
    protected static function _getDbCfgHash($dbConfig)
    {
        return md5($dbConfig->dbHost . $dbConfig->dbUserName . $dbConfig->dbUserPassword . $dbConfig->dbPort);
    }

}

?>
