<?php

/**
 * @version			$Id: hmysqlsql.php 1889 2012-05-20 06:47:59Z xjiujiu $
 * @create 			2012-3-5 16:10:17 By xjiujiu
 * @package 		hongjuzi.scheme.mysql
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

HClass::import('hongjuzi.scheme.HSqlBase');
/**
 * Mysql需要执行的Sql生成类 
 * 
 * 此类负责Mysql数据库驱动的sql语句的生成，为添加，
 * 修改，查询，删除及其它类型的Sql语句提供自动生成
 * 的功能，及组合。
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.scheme.mysql
 * @since 			1.0.0
 */
class HMysqlSql extends HSqlBase
{
    /**
     * 构造函数初
     * 
     * 始化Sql语句的组成部分
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    public function getAddSql()
    {
        return $this->_genBaseInsertSql();        
    }

    /**
     * {@inheritDoc} 
     */
    public function getUpdateSql()
    {
        return $this->_genBaseUpdateSql();
    }

    /**
     * {@inheritDoc}
     */
    public function getDeleteSql()
    {
        return 'DELETE FROM ' . '`' . $this->_table . '` ' . $this->_where . ' ' . $this->_limit . ';';
    }

}


?>
