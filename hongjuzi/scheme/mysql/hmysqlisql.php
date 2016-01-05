<?php

/**
 * @version			$Id: hmysqlisql.php 1964 2012-07-05 10:28:02Z admin $
 * @create 			2012-3-8 20:03:14 By xjiujiu
 * @package 		hongjuzi.scheme.mysql
 * @copyright 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

HClass::import('hongjuzi.scheme.HSqlBase');

/**
 * Mysqli数据库驱动的专用Sql语句生成器  
 * 
 * 实现IHsql接口 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.scheme.mysql
 * @since 			1.0.0
 */
class HMysqliSql extends HSqlBase 
{

    /**
     * @Var string $_filedsType 字段类型
     */
    protected $_filedsType;


    /**
     * 构造函数 
     * 
     * @desc
     * 
     * @access public
     */
    public function __construct()
    {
        parent::__construct();

        $this->_filedsType  = '';
    }

    /**
     * 设置字段类型 
     * 
     * 用于绑定变量的形式 
     * 
     * @access public
     * @param string $filedsType
     */
    public function filedsType($filedsType)
    {
        $this->_filedsType  = $filedsType;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAddSql()
    {
        $this->_genInsertFieldSql();
        if(false == $this->isBindParam()) {
            return $this->_genBaseInsertSql();
        }

        return $this->_genParamInsertSql();
    }

    /**
     * 生成变量绑定形式的INSERT语句 
     * 
     * 在使用Stmt的时候使用 
     * 
     * @access protected
     */
    protected function _genParamInsertSql()
    {
        $this->_genInsertFieldSql();

        return 'INSERT INTO ' .
               '`' . $this->_table . '` ' .
               '(' . $this->_fields . ') ' .
               'VALUES ' .
               $this->_genParamInsertValueSql() . ';';
    }

    /**
     * 生成变量绑定形式的插入记录值部分的SQL 
     * 
     * 得使用像Mysqli, PDO这样的插口支持 
     * 
     * @access protected
     */
    protected function _genParamInsertValueSql()
    {
        if(!is_array($this->_values)) {
            throw new HSqlParseException('绑定变量形式的, 添加记录的值只能为数组！');
        } else {
            $params     = strlen($this->_filedsType);
            for($i = 0; $i < $params - 1; $i++) {
                $values     = '?, ';
            }

            return '(' . $values . '?)';
        }

    }

    /**
     * {@inheritDoc} 
     */
    public function getUpdateSql()
    {
        if(false == $this->isBindParam()) {
            return $this->_genBaseUpdateSql();
        }

        return $this->_genParamUpdateSql();
    }

    /**
     * 生成绑定变量形式的更新语句 
     * 
     * 只用于支持变量绑定的操作接口，如Mysqli, PDO等 
     * 
     * @access protected
     */
    protected function _genParamUpdateSql()
    {
        $updateInfo     = '';
        foreach($this->_fields as $key => $field) {
            $updateInfo .= '`' . $field . '` = ?'; 
        }

        return 'UPDATE ' . '`' . $this->_table . '` ' . 'SET ' . $updateInfo . ' ' . $this->_where . ' ' . $this->_limit . ';';
    }

    /**
     * 是否当前的查询方式为变量绑定 
     * 
     * @desc 
     * 
     * @access public
     */
    public function isBindParam()
    {
        if(empty($this->_filedsType)) {
            return false;
        }

        return true;
    }
    
    /**
     * Values变量的Gettor方法 
     * 
     * 得到当前的字段值设置 
     * 
     * @access public
     */
    public function getValues()
    {
        return $this->_values;
    }

    /**
     * FiledsType的Gettor方法 
     * 
     * 得到当前字段类型的设置 
     * 
     * @access public
     * @return string 
     */
    public function getFiledsType()
    {
        return $this->_filedsType; 
    }

    /**
     * 得到创建表的SQL语句 
     * 
     * 组合：table, fields, index, primary, engine, charset,
     *       autoIncrement, comment
     * 
     * @access public
     * @return string 
     */
    public function getCreateTableSql()
    {
        return sprintf("CREATE TABLE `%s` ( %s %s %s )
            ENGINE=%s DEFAULT CHARSET=%s AUTO_INCREMENT=%d COMMENT='%s'",
            $this->_table,
            $this->_getCreateTableFields(),
            $this->_index,
            $this->_primaryKey,
            $this->_engine,
            $this->_charset,
            $this->_autoIncrement,
            $this->_comment
        );
    }

    /**
     * 生成创建表的字段SQL语句 
     * 
     * 把Fields的数组给连成串 
     * 
     * @access protected
     * @return string 当前的字段
     */
    protected function _getCreateTableFields()
    {
        if(is_string($this->_fields)) {
            return $this->_fields;
        }

        return implode(',', $this->_fields);
    }

}

?>
