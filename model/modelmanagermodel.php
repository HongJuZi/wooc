<?php 

/**
 * @version			$Id$
 * @create 			2012-4-8 22:10:14 By xjiujiu
 * @package 		app.admin
 * @subpackage 		model
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('model.BaseModel');

/**
 * 模块生成工具模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class ModelManagerModel extends BaseModel
{

    /**
     * 创建表 
     * 
     * 根据用户给定的参数来创建对应的表  
     * 
     * @access public
     * @param string $modelEnName 模块名称
     * @param array $fields 表所有的字段
     * @param array primaryKey 表的关键字
     * @param string $comment 表的注释内容
     * @param string $engine 数据库引擎
     * @param string $charset 数据库编码
     * @param int $autoIncrement 自增起始值
     * @return boolean 
     * @exception none
     */
    public function createModelTable($modelEnName, $fields,
        $primaryKey, $comment = '', $engine = 'MYSIAM',
        $charset = 'utf8', $autoIncrement = 1
    )
    {
        $dbConfig    = HObject::GC('DATABASE');
        $this->_db->getSql()
            ->table($dbConfig['tablePrefix'] . $modelEnName)
            ->fields($fields)
            ->primaryKey($primaryKey)
            ->engine($engine)
            ->charset($charset)
            ->autoIncrement($autoIncrement)
            ->comment($comment);
        
        return $this->_db->createTable();
    }

    /**
     * 删除对应的表 
     * 
     * 默认使用HSql的形式 
     * 
     * @access public
     * @param string $modelEnName 模块名称 
     * @return boolean 
     * @exception none
     */
    public function dropModelTable($modelEnName)
    {
        $dbConfig    = HObject::GC('DATABASE');
        $this->_db->getSql()
            ->table($dbConfig['tablePrefix'] . $modelEnName);

        return $this->_db->dropTable();
    }

    /**
     * 得到快捷操作的菜单 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function getOnDesktopModel()
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('*')
            ->where('`on_desktop` = \'是\'')
            ->orderBy(HPopoHelper::getOrderFields($this->_popo));

        return $this->_db->select()->getList();
    }

    /**
     * 得到系统里所有的表
     * 
     * @desc
     * 
     * @access public
     * @return Array<Map> 系统里所有的表
     */
    public function getTableList()
    {
        return $this->_db->select('SHOW TABLES;')->getList();
    }

    /**
     * 通过表名查看表的详细信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $table 需要查看的表名
     * @return Array<String, String> 信息集合  
     */
    public function getTableInfo($table)
    {
        return $this->_db->select('SHOW CREATE TABLE `' . $table . '`')->getRecord();
    }

    /**
     * 得到表字段的详细信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $table 需要查找的表名
     * @return Array<String, String> 查找到的字段信息集 
     */
    public function getTableFields($table)
    {
        return $this->_db->select('SHOW FULL COLUMNS FROM `' . $table . '`;')->getList();
    }

}

?>
