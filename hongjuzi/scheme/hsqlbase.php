<?php

/**
 * @version			$Id: hmysqlsqlbase.php 1964 2012-07-05 10:28:02Z admin $
 * @create 			2012-3-5 16:10:17 By xjiujiu
 * @package 		hongjuzi.database.db
 * @subpackage 		mysql
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

//导入SQL语句造成器接口
HClass::import('hongjuzi.scheme.IHSql');

/**
 * Mysql需要执行的Sql生成类基类 
 * 
 * 此类负责Mysql数据库驱动的sql语句的生成，为添加，
 * 修改，查询，删除及其它类型的Sql语句提供自动生成
 * 的功能，及组合。
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.database.db.mysql
 * @since 			1.0.0
 */
class HSqlBase extends HObject implements IHSql
{

    /**
     * @var string $_dbName 数据库名
     */
    protected $_dbName;

    /**
     * @var string $_table 当前操作的表名
     */
    protected $_table;

    /**
     * @var string | array $_fields 当前操作的字段
     */
    protected $_fields;

    /**
     * @var string $_values 对应字段的值
     */
    protected $_values;

    /**
     * @var string $_join 表与表之间的联合查询
     */
    protected $_join;

    /**
     * @var string | array $_where 当前操作的条件
     */
    protected $_where;

    /**
     * @var string | array $_groupBy 当前操作的分组方式
     */
    protected $_groupBy;

    /**
     * @var sting $_having 当前的Having条件
     */
    protected $_having;

    /**
     * @var string | array $_orderBy 当前操作的排序方式
     */
    protected $_orderBy;

    /**
     * @var string $_limit 当前查询的限制操作条数
     */
    protected $_limit;

    /**
     * @var string $_primaryKey 主键
     */
    protected $_primaryKey;

    /**
     * @var string $_index 索引
     */
    protected $_index;

    /**
     * @var string $_engine 数据库引擎
     */
    protected $_engine;

    /**
     * @var string $_charset 编码类型
     */
    protected $_charset;

    /**
     * @var int $_autoIncrement 自增的起始点
     */
    protected $_autoIncrement;

    /**
     * @var string $_comment 表的注释
     */
    protected $_comment; 

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
        $this->_dbName      = '';
        $this->_table       = '';
        $this->_fields      = '';
        $this->_values      = '';
        $this->_join        = '';
        $this->_where       = '';
        $this->_orderBy     = '';
        $this->_groupBy     = '';
        $this->_having      = '';
        $this->_limit       = '';
        $this->_index       = '';
        $this->_primaryKey  = '';
        $this->_engine      = 'MYISAM';
        $this->_charset     = 'utf8';
        $this->_comment     = '';
        $this->_autoIncrement   = 1;
    }

    /**
     * 得到创建数据库的SQL语句 
     * 
     * @desc
     * 
     * @access public
     * @return string 
     * @throws none
     */
    public function getCreateDbSql()
    {
        return 'CREATE DATABASE `' . $this->_dbName . '`;'; 
    }

    /**
     * 得到删除数据库的SQL语句 
     * 
     * @desc
     * 
     * @access public
     * @return string 
     * @throws none
     */
    public function getDropDbSql()
    {
        return 'DROP DATABASE `' . $this->_dbName . '`;';
    }

    /**
     * 得到删除表的SQL语句 
     * 
     * 直接给出DROP TABLE的语句 
     * 
     * @access public
     * @return string 
     * @exception none
     */
    public function getDropTableSql()
    {
        return 'DROP TABLE IF EXISTS `' . $this->_table . '`';
    }

    /**
     * 得到当前查询的Sql语句
     *
     * 组合通过设置Sql部分的方式的Select语句 
     * 
     * @access public 
     * @return void
     * @exception none
     */
    public function getSelectSql()
    {
        $this->_genSelectFieldSql();

        return 'SELECT ' .
               $this->_fields . ' ' .
               'FROM ' .
               '`' . $this->_table . '` ' .
               $this->_join . ' ' .
               $this->_where .
               $this->_groupBy . ' ' .
               $this->_orderBy . ' ' .
               $this->_limit . ';';
    }

    /**
     * 将当前的Fields设置为Select语句的形式 
     * 
     * 由于Select, Insert Into, Update这前的Field不一样，得单独格式化 
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _genSelectFieldSql()
    {
        if(empty($this->_fields)) {
            $this->_fields  = '*';
        } else {
            $this->_fields  = HArray::arrayToString($this->_fields,
                $this->_table . '.`', '`,' . $this->_table . '.`','`');
        }
    }

    /**
     * 得到当前添加记录的Sql语句 
     * 
     * 组合得到添加记录的sql语句
     * 
     * @access public 
     * @return void
     * @exception none
     */
    public function getAddSql() { }

    /**
     * 生成最基本的插入语句 
     * 
     * 插入语句的一般形式 
     * 
     * @access protected
     * @return string
     * @exception none
     */
    protected function _genBaseInsertSql()
    {
         $this->_genInsertFieldSql();
         $this->_genBaseInsertValueSql();

         return 'INSERT INTO ' .
               '`' . $this->_table . '` ' .
               '(' . $this->_fields . ') ' .
               'VALUES ' .
               $this->_values . ';';
    }

    /**
     * 得到最基本的InsertSQL语句 
     * 
     * @desc
     * 
     * @access public
     * @return string 
     * @exception none
     */
    public function getBaseInsertSql()
    {
        return $this->_genBaseInsertSql();
    }

    /**
     * 格式化Field为Insert Into可用的Sql可用的形式 
     * 
     * 这里唯一区别于select的是当为空时，$this->_fields不做修改 
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _genInsertFieldSql()
    {
        if(!empty($this->_fields)) {
            $this->_fields  = HArray::arrayToString($this->_fields, '`', '`, `','`');
        }
    }

    /**
     * 组合更新记录的Sql语句 
     * 
     * 根据Update语句的结构，选择所要用到的Sql部分 
     * 
     * @access public
     * @return string 
     * @exception none
     */
    public function getUpdateSql() { }

    /**
     * 格式化字段跟值对应组合成可用的基本的Update语句 
     * 
     * 合并Field跟value 
     * 
     * @access protected
     * @return string 更新的SQL语句
     */
    protected function _genBaseUpdateSql()
    {
        if(!is_array($this->_fields)) {
            $this->_fields  = array($this->_fields);
        }
        if(!is_array($this->_values)) {
            $this->_values  = array($this->_values);
        }
        $updateInfo     = '';
        foreach($this->_fields as $key => $field) {
            $value      = trim($this->_values[$key]);
            if(null === $value) {
                $updateInfo .= ', `' . $field . '` = NULL';
                continue;
            }
            if(0 !== strpos($value, '`')) {
                $value  = '\'' . $value . '\'';
            }
            $updateInfo .= ', `' . $field . '` = ' . $value; 
        }
        $updateInfo{0}  = ' ';

        return 'UPDATE ' . '`' . $this->_table . '` ' .
               'SET ' . $updateInfo . ' ' .
               $this->_where . ' ' .
               $this->_limit . ';';
    }

    /**
     * 得到删除记录的Sql语句 
     * 
     * 根据Delete语句的特点组合成可用语句 
     * 
     * @access public
     * @return string 
     * @exception none
     */
    public function getDeleteSql()
    {
        return 'DELETE FROM ' . 
               '`' . $this->_table . '` ' .
               $this->_where . ' ' .
               $this->_limit . ';';
    }

    /**
     * 设置当前查询要操作的字段 
     * 
     * 调用者根据需要来指定要操作的字段 
     * 
     * @access public
     * @param array | string $fields 默认为空
     * @return HMysqlSql 
     * @exception none
     */
    public function fields($fields = '')
    {
        $this->_fields  = $fields;

        return $this;
    }

    /**
     * 设置当前查询要操作的字段 
     * 
     * 调用者根据需要来指定要操作的字段 
     * 
     * @access public
     * @param array | string $joinFields 联合查询中需要显示的字段 
     * @return HMysqlSql 
     * @exception none
     */
    public function joinFields($joinFields = '')
    {
        $this->_joinFields  = $joinFields;

        return $this;
    }

    /**
     * 设置当前操作的数据库名 
     * 
     * @desc
     * 
     * @access public
     * @param string $dbName 当前操作的数据库名
     * @return HSql 
     * @throws none
     */
    public function dbName($dbName)
    {
        $this->_dbName  = $dbName;

        return $this;
    }

    /**
     * 设置当前的操作表 
     * 
     * 通过这种方式的话，就不用给select传sql语句了，函数自动去解析并
     * 组合设置了的各个sql部分
     *
     * @param string $table 操作表名 
     * @access public
     * @return HMysql 对象 
     * @exception none
     */
    public function table($table)
    {
        $this->_table   = $table;

        return $this;
    }

    /**
     * 设置添加记录的值
     * 
     * 可以支持多条记录批量添加 
     * 
     * @access public
     * @param string | array $values
     * @return HMysql 对象 
     * @exception HSqlParseException 
     */
    public function values($values)
    {
        $this->_values  = $values;

        return $this;
    }

    /**
     * 得到插入记录的基本形式的值SQL语句
     * 
     * 支持二维数组的多条记录批量添加 
     * 
     * @access protected
     */
    protected function _genBaseInsertValueSql()
    {
        if(empty($this->_values)) {
            throw new HVerifyException('添加的数据不能为空！');
        }
        if(!is_array($this->_values)) {
            return $this;
        }
        $isMore         = false;
        $values         = '';
        foreach($this->_values as $data) {
            $valSql     = '';
            if(is_array($data)) {
                $isMore = true;
                foreach($data as $val) {
                    $valSql .= HVerify::isEmptyNotZero($val) ? ',NULL' : ',\'' . $val . '\'';
                }
                $valSql{0}  = ' ';
                $values .= ',(' . $valSql . ')';
            } else {
                $values .= HVerify::isEmptyNotZero($data) ? ',NULL' : ',\'' . $data . '\'';
            }
        }
        $values{0}  = ' ';
        $this->_values  = true === $isMore ? $values : '(' . $values . ')';
    }

    /**
     * 设置对象的值 
     * 
     * 可以是二维数组，即批量添加记录 
     * 
     * @access public
     * @param mix $objects 需要添加的对象
     * @return HMysqlSql 对象 
     * @exception none
     */
    public function objects($objects)
    {
        if(empty($objects)) {
            throw new HSqlParseException('添加或修改的对象不能为空！');
        }
        if(!is_array($objects)) {
            $objects    = array($objects);
        }
        foreach($objects as $key => $object) {
            if(is_object($object)) {
                $vars  = get_object_vars($object);
                //只添加已经给定的field值
                foreach($this->_fields as $loc => $field) {
                    if(isset($vars[$field])) {
                        $values[$key][$loc] = $vars[$field];
                    } else {
                        $values[$key][$loc] = ''; //没有找就为空
                    }
                }
            }
        }
        $this->_values   = $values;
        
        return $this;
    }

    /**
     * 设置联合查询 
     * 
     * 还不支持as table的形式 
     * 
     * @access public
     * @param string $joinTable
     * @param array $where
     * @param string $type 默认为 'LEFT'
     * @return HMysql的对象 
     * @exception HSqlParseException 
     */
    public function join($join)
    {
        $this->_join    = $join;

        return $this;
    }

    /**
     * 设置查询条件
     * 
     * 将给定的查询条件解析成合法的Sql语句形式 
     *
     * @param string | array $where 查询的条件
     * @access public 
     * @return HMysql 对象 
     * @exception none
     */
    public function where($where = '')
    {
        if(empty($where)) {
            return $this;
        }
        $this->_where   = 'WHERE ';
        $this->_where   .= is_array($where) ? implode(' ', $where) : $where;

        return $this;
    }

    /**
     * 设置查询的分组条件
     * 
     * 支持字符及数组 
     * 
     * @access public
     * @param string | array $groupBy 默认为空 
     * @return HMysql对象 
     * @exception none
     */
    public function groupBy($groupBy = '')
    {
        if(empty($groupBy)) {
            return $this;
        }
        $this->_groupBy     = ' GROUP BY ';
        if(is_array($groupBy)) {
            $this->_groupBy     .= '`' . implode('`, `', $groupBy) . '`';
        } else {
            $this->_groupBy     .= '`' . $groupBy . '`';
        }

        return $this;
    }

    /**
     * 设置查询的排序条件 
     * 
     * 支持string | array 
     * 
     * @access public
     * @param string | array $orderBy 默认为空 
     * @return HMysql对象 
     * @exception none
     */
    public function orderBy($orderBy = '')
    {
        if(HVerify::isEmpty($orderBy)) {
            return $this;
        }
        $this->_orderBy     = '';
        if(is_array($orderBy)) {
            foreach($orderBy as $field => $order) {
                $this->_orderBy .= ', ' . $this->_table . '.`' . $field . '` ' . $order;
            }
            $this->_orderBy{0}  = ' ';
            $this->_orderBy     = 'ORDER BY ' . $this->_orderBy;
        } else {
            $this->_orderBy     = 'ORDER BY ' . $orderBy;
        }

        return $this;
    }

    /**
     * 设置查询的限制条数 
     * 
     * 指定好要查看的页及每页要显示的条数。可以根据传入参数
     * 个数的不同来决定选则哪样的Limit形式 
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function limit($page, $perpage = null)
    {
        if(null === $perpage) {
            $this->_limit   = 'LIMIT ' . $page;
        } else {
            $this->_limit       = 'LIMIT ' . ($perpage * $page) . ', ' . $perpage;
        }
        
        return $this;
    }

    /**
     * 设置查询的限制条数 
     * 
     * 从具体哪一行数据开始查询n条数据
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function limitRange($count,$start)
    {
        $this->_limit   = 'LIMIT ' . $start. ', ' . $count;

        return $this;
    }


    /**
     * 设置当前的索引字段 
     * 
     * 支持单字段及多字段的数组形式 
     * 
     * @access public
     * @param string | array $fields 需要设置的字段
     * @return HSql 
     * @exception none
     */
    public function index($fields)
    {
        if(empty($fields)) {
            return $this;
        }
        if(is_string($fields)) {
            $this->_index   = ',INDEX (`' . $fields . '`)';
        }
        $this->_index       = ',INDEX (`' . implode('`,`', $fields) . '`)';

        return $this;
    }

    /**
     * 设置关键字段
     * 
     * 支持单字段及多字段数组形式
     * 
     * @access public
     * @param string | array $fields 需要设置的字段
     * @return HSql 
     * @exception none
     */
    public function primaryKey($fields)
    {
        if(empty($fields)) {
            return $this;
        }
        if(is_string($fields)) {
            $this->_primaryKey  = ',PRIMARY KEY (`' . $fields . '`)';
        }
        $this->_primaryKey      = ',PRIMARY KEY (`' . implode('`,`', $fields) . '`)';

        return $this;
    }

    /**
     * 设置数据库的引擎类型
     * 
     * 对应于MYSQL支持的数据库引擎:
     * MYSIAM, INNODB, .... 
     * 
     * @access public
     * @param string $engine 设置的数据引擎
     * @return HSql 
     * @exception none
     */
    public function engine($engine)
    {
        $this->_engine  = $engine;

        return $this;
    }

    /**
     * 设置当前的数据库编码类型 
     * 
     * 对应于MYSQL支持的编码类型：GBK, UTF8 
     * 
     * @access public
     * @param string $charset 对应的编码类型
     * @return HSql 
     * @exception none
     */
    public function charset($charset)
    {
        $this->_charset     = $charset;

        return $this;
    }

    /**
     * 设置当前的表的自增起点 
     * 
     * 表的自增字段的下一条记录的自增值 
     * 
     * @access public
     * @param int $start 开始值
     * @return HSql 
     * @exception none
     */
    public function autoIncrement($start)
    {
        $this->_autoIncrement   = $start;

        return $this;
    }

    /**
     * 设置表或数据库的注释信息
     * 
     * @desc 
     * 
     * @access public
     * @return HSql 
     * @exception none
     */
    public function comment($comment)
    {
        $this->_comment     = $comment;

        return $this;
    }

}

?>
