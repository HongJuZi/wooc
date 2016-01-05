<?php

/**
 * @version			$Id$
 * @create 			2012-5-14 23:17:43 By xjiujiu
 * @package 		model
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */

/**
 * 安装程序模块 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.install.model
 * @since 			1.0.0
 */
class InstallModel extends HModel
{
    
    /**
     * 初始化数据库 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  Array $dbCfg 数据库配置数组
     */
    public function __construct($dbCfg)
    {
        $this->_db  = null;
        $this->_initDb($dbCfg);
    }
        
    /**
     * 检测当前数据库连接是否正常 
     * 
     * @access public
     */
    public function checkDbConnection()
    {
        return !!$this->_db;
    }

    /**
     * 得到DB操作实体 
     * 
     * @access protected
     */
    public function _initDb($dbCfg)
    {
        try {
            $this->_db  = HDbFactory::getDbDriver((object)$dbCfg);
            return true;
        } catch(RequestException $ex) {
            return false;
        }
    }

    /**
     * 检测当前的数据库是否存在 
     * 
     * @access public
     * @param string $dbName 数据库名
     * @return boolean 
     */
    public function isDbExists($dbName)
    {
        return $this->_db->selectDb($dbName);
    }

    /**
     * 创建数据库 
     * 
     * @access public
     * @param string $dbName 需要创建的数据库
     * @return boolean 
     */
    public function createDb($dbName)
    {
        $this->_db->getSql()
            ->dbName($dbName);

        return $this->_db->createDb();
    }

    /**
     * 选择当前指定的数据库 
     * 
     * @access public
     * @param string $dbName 数据库名
     * @return boolean 
     */
    public function selectDb($dbName)
    {
        return $this->_db->selectDb($dbName);
    }

}

?>
