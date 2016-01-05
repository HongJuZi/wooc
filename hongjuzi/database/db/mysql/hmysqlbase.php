<?php
/**
 * @version			$Id: hmysqlbase.php 1964 2012-07-05 10:28:02Z admin $
 * @package 	    hongjuzi.database 
 * @subpackage 	    mysql 
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

//导入数组工具类
HClass::import('hongjuzi.database.IHDatabase');

/**
 * Mysql数据库操作基类 
 * 
 * 实现Mysql数据库公用的操作方法,并定义必须实现的方法
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.database.db.mysql
 * @since 			1.0.0
 */
class HMysqlBase extends HObject implements IHDatabase
{

    /**
     * @var string $_fetchMode 查询结果集的模式 默认为: MYSQL_ASSOC
     */
    protected $_fetchMode;

    /**
     * @var result | boolean $_result 查询资源存储器
     */
    protected $_result;

    /**
     * @var object $_hConfigs 系统的配置项实例
     */
    protected $_hConfigs;

    /**
     * @var HMysqlSql $_hSql Sql语句生成对象
     */
    protected $_hSql;

    /**
     * @var string $_sparator 语句的分隔符
     */
    protected $_sparator;

    /**
     * 构造函数 
     * 
     * 类开始跑的准备工作 
     * 
     * @access public
     * @return void
     * @exception none
     */
	public function __construct($hConfigs)
    {
        $this->_result      = null;
        $this->_hSql        = null;
        $this->_fetchMode   = ASSOC;
        $this->_hConfigs    = $hConfigs;
        $this->_sparator    = ';';
    }

    /**
     * 克隆函数 
     * 
     * 私有的防止不产生多个对象
     * 
     * @access public 
     * @return void
     * @exception none
     */
    public function __clone() {}

    /**
     * 析构函数 
     * 
     * 释放无用的变量内存空间 
     * 
     * @access public
     */
    public function __destruct() 
    {
        unset($this->_result);
    }

    /**
     * 实现IDatabase接口中connect方法 
     * 
     * 连接Mysql数据库 
     * 
     * @access public
     * @exception HDatabaseConnectionException 
     */
    public function connect() { }

    /**
     * 设置当前数据库的读取编码类型
     * 
     * 通过读取配置文件里的编码配置项，要是没有找到就给以utf-8，作为默认 
     * 
     * @access public
     */
    public function charset()
    {
        if(null === $this->_hConfigs->dbCharset) {
            $this->_hConfigs->dbCharset   = 'utf8';
        }
        $this->_query('SET NAMES ' . $this->_hConfigs->dbCharset . ';');
    }

    /**
     * 创建数据库 
     * 
     * @access public
     * @param string $sql 需要执行的SQL语句，默认为：''
     */
    public function createDb($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getCreateDbSql() : $sql;

        return $this->_query($sql);
    }

    /**
     * 删除数据库 
     * 
     * @access public
     * @param string $sql 执行需要删除的数据库， 默认为: ''
     * @return boolean 
     */
    public function dropDb($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getCreateDbSql() : $sql;

        return $this->_query($sql);
    }

    /**
     * 执行快捷的查询 
     * 
     * 创建数据库，创建表，查看数据库信息之类的操作快捷入口  
     * 
     * @access public
     * @param string $sql 需要执行的SQL操作, 默认为空
     * @return boolean 
     */
    public function createTable($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getCreateTableSql() : $sql;

        return $this->_query($sql);
    }

    /**
     * 删除表 
     * 
     * 可以指定SQL或是用HSql来生成 
     * 
     * @access public
     * @param string $sql 删除表的SQL语句，默认为空
     * @return boolean 
     * @exception none
     */
    public function dropTable($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getDropTableSql() : $sql;

        return $this->_query($sql);
    }

    /**
     * {@inheritDoc} 
     */
    public function selectDb() { }

    /**
     * {@inheritDoc} 
     */
    public function select($sql = '') { }

    /**
     * 得到单条记录
     * 
     * 可以指定所需要的字段 
     *
     * @access public
     * @return void
     * @exception none
     */
    public function getRecord()
    {
        $record = $this->_getFetch();
        $this->_freeResult();

        return $record;
    }

    /**
     * 得到记录列表 
     * 
     * 可以指定列表的键 
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function getList($key = '')
    {
        $list   = array();
        while($record = $this->_getFetch()) {
            if(empty($key)) {
                $list[]     = $record;
            } else {
                if(array_key_exists($key, $record)) {
                    $list[$record[$key]]    = $record;
                } else {
                    $list[] = $record;
                }
            }
        }
        $this->_freeResult();

        return $list;
    }

    /**
     * 以对象的形式得到单条记录 
     * 
     * 直接返回当前记录对象 
     * 
     * @access public
     * @return object 记录对象 
     * @exception none
     */
    public function getObject()
    {
        $object     = $this->_getFetch(OBJ);
        $this->_freeResult();
        
        return $object;
    }

    /**
     * 得到记录对象数组 
     * 
     * 把对象放入到数组中, 并可以设置是否用对象里的属性做为数组
     * 的键 
     *
     * @param string $key 数组的key 
     * @access public
     * @return array 记录对象数组集
     * @exception none
     */
    public function getObjects($key = '')
    {
        $objects   = array();
        while($object = $this->_getFetch(OBJ)) {
            if(empty($key)) {
                $objects[]     = $object;
            } else {
                if(isset($object->$key)) {
                    $objects[$object->$key]    = $object;
                } else {
                    $objects[]  = $object;
                }
            }
        }
        $this->_freeResult();

        return $objects;
    }

    /**
     * 得到查询的资源 
     * 
     * 只负责得到查询的资源 
     *
     * @param string $sql 需要执行的Sql语句
     * @access protected
     * @return void
     * @exception HDatabaseException 
     */
    protected function _getResult($sql)
    {
        $this->_result  = $this->_query($sql);
        if(!$this->_result) {
            HLogger::log($this->_getMysqlError(), WARN);
            throw new HDatabaseException('查询错误！' . $sql);
        }
    }

    /**
     * 释放结果内存 
     * 
     * 释放所有与结果标识相关联的内存 
     * 
     * @access protected
     * @return boolean 
     * @exception none
     */
    protected function _freeResult() { }

    /**
     * {@inheritDoc} 
     */
    public function add($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getAddSql() : $sql;
        if(false === $this->_query($sql)) {
            HLogger::log($this->_getMysqlError(), WARN);
            return false;
        }

        return true;
    }

    /**
     * 得到最后插入的记录的Id值
     * 
     * @desc
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _getLastInsertId()
    {
        return @mysql_insert_id($this->_link);
    }

    /**
     * {@inheritDoc}
     */
    public function update($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getUpdateSql() : $sql;
        if(false === $this->_query($sql)) {
            HLogger::log($this->_getMysqlError(), WARN);
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc} 
     */
    public function delete($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getDeleteSql() : $sql;
        if(false === $this->_query($sql)) {
            HLogger::log($this->_getMysqlError(), WARN);
            return false;
        }

        return true;
    }

    /**
     * 设置当前Sql查询的模式 
     * 
     * 一共有三种合法的模式：
     * (1) ASSOC;
     * (2) NUM;
     * (3) BOTH;
     * (4) OBJ -> OBJECT
     * 
     * @access public
     * @param $fetchMode
     * @return HMysql对象 
     * @exception HSqlParseException 
     */
    public function setFetchMode($fetchMode)
    {
        $this->_fetchMode   = $fetchMode;

        return $this;
    } 

    /**
     * 外部使用的Query执行快捷入口 
     * 
     * 直接执行相关的SQL操作 
     * 
     * @access public
     * @param string $sql 需要执行的语句
     * @param boolean $prefix 是否需要替换表前缀
     * @return boolean | resource 
     * @exception none
     */
    public function query($sql, $prefix = true)
    {
        return $this->_query($sql, $prefix);
    }

    /**
     * 执行数据库的查询 
     * 
     * 查询，更新，添加，删除都是使用此方法来执行最终的
     * Sql语句
     * 
     * @access protected
     * @param string $sql
     * @return result or false 
     * @exception none
     */
    protected function _query($sql) { }

    /**
     * 替换当前的表前缀为系统设置 
     * 
     * 如：#_core_table => hongjuzi_core_table 
     * 
     * @access protected
     * @param string $sql 当前需要处理的SQL语句
     * @return string 
     * @exception none
     */
    protected function _replaceTablePrefix($sql)
    {
        return strtr($sql, array('#_' => $this->_hConfigs->tablePrefix));
    }

    /**
     * 得到上一次执行sql语句所影响的记录行数 
     * 
     * @desc
     * 
     * @access protected
     * @return void
     * @exception none
     */
    public function getAffectedRows() { }

    /**
     * 得到Sql生成对象 
     * 
     * 返回对应的数据库操作驱动的Sql语句生成器 
     * 
     * @access public
     * @return IHSql 对象 
     * @exception none
     */
    public function getSql() { }

    /**
     * 过滤Sql里面的非法字符
     * 
     * 给单引号加上反斜杆 
     * 
     * @access protected
     * @param string $sql
     * @return string
     * @exception none
     */
    protected function _escapeSql($sql) { }

    /**
     * 得到服务器版本信息 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function getDbVersion()
    {
        $version  = $this->select('SELECT VERSION() AS version;')->getRecord();
        
        return $version['version']; 
    }

    /**
     * 得到数据库错误信息 
     * 
     * 返回当前数据库执行出错的信息内容 
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _getMysqlError() { }

    /**
     * {@inheritDoc} 
     */
    public function close() { } 

}
?>
