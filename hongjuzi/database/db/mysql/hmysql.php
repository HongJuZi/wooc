<?php
/**
 * @version			$Id: hmysql.php 1964 2012-07-05 10:28:02Z admin $
 * @package 	    hongjuzi.database 
 * @subpackage 	    mysql 
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

//定义Mysql的查询结果类型
define('ASSOC', MYSQL_ASSOC);
define('NUM', MYSQL_NUM);
define('BOTH', MYSQL_BOTH);
define('OBJ', 'MYSQL_OBJECT');

//导入数组工具类
HClass::import('hongjuzi.database.db.mysql.HMysqlBase');
HClass::import('hongjuzi.scheme.mysql.HMysqlSql');

/**
 * 框架基类 
 * 
 * 实现框架类的最基本的操作，如set, get方法 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.database.db.mysql
 * @since 			1.0.0
 */
class HMysql extends HMysqlBase
{
    
    /**
     * @var object static $_db 数据库对象
     */
    protected static $_db     = null;

    /**
     * @var result $_link 数据库连接资源存储器 
     */
    protected $_link;

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
        parent::__construct($hConfigs);
        $this->_initDb();
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
     * @return void
     * @exception none
     */
    public function __destruct()
    {
        parent::__destruct();
        unset($this->_link);
    }
    /**
     * 得到数据库操作的唯一实例 
     * 
     * 返回数据库的操作实例 
     *
     * @param HConfigs $hConfigs 
     * @access public static
     * @return void
     * @exception none
     */
    public static function getInstance($hConfigs) 
    {
        if(!(self::$_db instanceof HMysql)) {
            self::$_db  = new self($hConfigs);
        }

        return self::$_db;
    } 

    /**
     * 初始化数据库
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _initDb()
    {
        try {
            $this->_connect();
            $this->_query('set names ' . $this->_hConfigs->dbCharset);
            //选择需要操作的数据库
            $this->selectDb();
            return true;
        } catch(HRequestException $ex) {
            HLog::write($ex->getMessage(), HLog::$L_WARN);
            return false; 
        }
    }

    /**
     * 实现IDatabase接口中connect方法 
     * 
     * 连接Mysql数据库 
     * 
     * @access public
     * @exception HDatabaseConnectionException 
     */
    protected function _connect()
    {
        $this->_link   = @mysql_connect(
            $this->_getServerInfo(),
            $this->_hConfigs->dbUserName,
            $this->_hConfigs->dbUserPassword
        );
        if(false === $this->_link) {
            throw new HRequestException('数据库连接失败！');
        }
        
    }

    /**
     * {@inheritDoc} 
     */
    public function selectDb()
    {
        if(false == mysql_select_db($this->_hConfigs->dbName)) {
            throw new HVerifyException('找不到对应的数据库!' . $this->_hConfigs->dbName . '如果没有创建，请先创建。');
        }

        return true;
    }

    /**
     * 得到服务器信息 
     * 
     * 信息由host跟端口的组合 
     * 
     * @access protected
     */
    protected function _getServerInfo()
    {
        return $this->_hConfigs->dbHost .
               ':' .
               $this->_hConfigs->dbPort;
    }

    /**
     * {@inheritDoc} 
     */
    public function select($sql = '')
    {
        try {
            $sql    = empty($sql) ? $this->_hSql->getSelectSql() : $sql;
            $this->_getResult($sql);

        } catch(HSqlParseException $ex) {
            HLogger::log($ex->getMessage(), WARN);
        } catch(HRequestException $ex) {
            HLogger::log($ex->getMessage(), WARN);
        }
        
        return $this;
    }

    /**
     * 得到查询的数组 
     * 
     * @access protected
     * @return array 记录数组
     */
    protected function _getFetch($fetchMode = '')
    {
        $fetchMode  = empty($fetchMode) ? $this->_fetchMode : $fetchMode;
        switch($fetchMode) {
            case ASSOC:
                return @mysql_fetch_array($this->_result, MYSQL_ASSOC);
            case NUM:
                return @mysql_fetch_array($this->_result, MYSQL_NUM);
            case OBJ:
                return @mysql_fetch_object($this->_result);
            case BOTH:
            default:
                return @mysql_fetch_array($this->_result, MYSQL_BOTH);
        }
    }

    /**
     * 得到查询的资源 
     * 
     * 只负责得到查询的资源 
     *
     * @param string $sql 需要执行的Sql语句
     * @access protected
     * @exception HRequestException 
     */
    protected function _getResult($sql)
    {
        $this->_result  = $this->_query($sql);
        if(!is_resource($this->_result)) {
            HLogger::log($this->_getDbError(), WARN);
            throw new HRequestException('SQL执行错误！' . $sql);
        }
    }

    /**
     * 释放结果内存 
     * 
     * 释放所有与结果标识相关联的内存 
     * 
     * @access protected
     * @return boolean 
     */
    protected function _freeResult()
    {
        return @mysql_free_result($this->_result);
    }

    /**
     * {@inheritDoc} 
     */
    public function add($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getAddSql() : $sql;
        if(false === $this->_query($sql)) {
            HLogger::log($this->_getDbError(), WARN);
            return false;
        }

        return true;
    }

    /**
     * 得到最后插入的记录的Id值
     * 
     * @access protected
     * @return int
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
            HLogger::log($this->_getDbError(), WARN);
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
            HLogger::log($this->_getDbError(), WARN);
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
     * (4) OBJ
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
     * 执行数据库的查询 
     * 
     * 查询，更新，添加，删除都是使用此方法来执行最终的
     * Sql语句
     * 
     * @access protected
     * @param string $sql 当前执行的SQL语句
     * @param boolean $prefix 是否需要替换表前缀
     * @return result or boolean 
     * @exception none
     */
    protected function _query($sql, $prefix = true)
    {
        $sql    = $prefix = true ? $this->_replaceTablePrefix($sql) : $sql;
        
        return @mysql_query($sql, $this->_link);
    }

    /**
     * 得到上一次执行sql语句所影响的记录行数 
     * 
     * @access protected
     * @return int
     */
    public function getAffectedRows()
    {
        return @mysql_affected_rows($this->_link);
    }

    /**
     * 得到Sql生成对象 
     * 
     * 返回对应的数据库操作驱动的Sql语句生成器 
     * 
     * @access public
     * @return IHSql 对象 
     */
    public function getSql()
    {
        $this->_hSql   = new HMysqlSql();

        return $this->_hSql;
    }

    /**
     * 过滤Sql里面的非法字符
     * 
     * 给单引号加上反斜杆 
     * 
     * @access protected
     * @param string $sql
     * @return string
     */
    protected function _escapeSql($sql)
    {
        return @mysql_real_escape_string($sql);
    }

    /**
     * 得到数据库错误信息 
     * 
     * 返回当前数据库执行出错的信息内容 
     * 
     * @access protected
     */
    protected function _getDbError()
    {
        return 'Error code: ' . @mysql_errno($this->_link) 
            . ' Error Message: ' .  @mysql_error($this->_link);
    }

    /**
     * {@inheritDoc} 
     */
    public function close()
    {
        if(is_resource($this->_link)) {
            @mysql_close($this->_link);
        }
    } 

}
?>
