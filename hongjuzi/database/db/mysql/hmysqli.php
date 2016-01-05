<?php

/**
 * @version			$Id: hmysqli.php 1964 2012-07-05 10:28:02Z admin $
 * @create 			2012-3-7 15:02:11 By xjiujiu
 * @package 		hongjuzi.database.db
 * @subpackage 		mysql
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

//定义Mysql的查询结果类型
define('ASSOC', MYSQLI_ASSOC);
define('NUM', MYSQLI_NUM);
define('BOTH', MYSQLI_BOTH);
define('OBJ', 'MYSQL_OBJ');
//引入SQL生成工具
HClass::import('hongjuzi.database.db.mysql.HMysqlBase');
HClass::import('hongjuzi.scheme.mysql.HMysqliSql');

/**
 * 以Mysqli方式实现对Mysql数据库的驱动 
 * 
 * 使用了Mysqli里一些特有的特性来实现相关数据库的操作，灵活性更大 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.database.db.mysql
 * @since 			1.0.0
 */
class HMysqli extends HMysqlBase
{

    /**
     * @var static HMysqli $_db 数据库Mysqli的驱动对象
     */
    protected static $_db   = null;

    /**
     * @var Mysqli $_mysqli
     */
    protected $_mysqli;

    /**
     * @var Mysqli_Stmt $_stmt 对象
     */
    protected $_stmt;

    /**
     * 构造函数 
     * 
     * @access public
     */
	public function __construct($hConfigs)
    {
        parent::__construct($hConfigs);
        $this->_mysqli      = null;
        $this->_stmt        = null;
        $this->_initDb();
    }

    /**
     * 克隆方法 
     * 
     * @access public
     */
    public function __clone() {}

    /**
     * 得到唯一Mysqli对象的入口 
     * 
     * 单例模式实现者 
     * 
     * @access public static
     * @return HMysqli 
     */
    public static function getInstance($hConfigs)
    {
        if(!(self::$_db instanceof HMysqli)) {
            self::$_db  = new HMysqli($hConfigs);
        }

        return self::$_db;
    }

    /**
     * 初始化数据库连接及选择对应的数据库 
     * 
     * @access protected
     */
    protected function _initDb()
    {
        $this->_connect();
        $this->selectDb($this->_hConfigs->dbName);
        $this->_query('set names ' . $this->_hConfigs->dbCharset);
    }

    /**
     * {@inheritDoc} 
     */
    protected function _connect()
    {
        $this->_mysqli  = new Mysqli(
            $this->_hConfigs->dbHost,
            $this->_hConfigs->dbUserName,
            $this->_hConfigs->dbUserPassword,
            '',
            $this->_hConfigs->dbPort
        );
        if($this->_mysqli->connect_error) {
            throw new HSqlException('数据库连接失败！' . $this->_mysqli->connect_error);
        }
    }
    
    /**
     * {@inheritDoc} 
     */
    public function selectDb($dbName = '')
    {
        $dbName     = empty($dbName) ? $this->_hConfigs->dbName : $dbName;
        
        return $this->_mysqli->select_db($dbName);
    }

    /**
     * {@inheritDoc} 
     */
    public function select($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getSelectSql() : $sql;
        $this->_getResult($sql);

        return $this;
    }

    /**
     * 得到查询结果 
     * 
     * @param string $sql执行的Sql语句 
     * @access protected
     */
    protected function _getResult($sql)
    {
        $this->_result  = $this->_query($sql);
    }

    /**
     * 得到单条记录
     * 
     * @access public
     */
    public function _getFetch($fetchMode = '')
    {
        $fetchMode  = empty($fetchMode) ? $this->_fetchMode : $fetchMode;
        switch($fetchMode) {
            case ASSOC:
                return $this->_result->fetch_assoc();
            case OBJ:
                return $this->_result->fetch_object();
            case NUM:
                return $this->_result->fetch_row();
            case BOTH:
            default:
                return $this->_result->fetch_array(MYSQLI_BOTH);
        }
    }

    /**
     * 释放记录结果集资源 
     * 
     * 当结果资源不为空时
     * 
     * @access protected
     */
    protected function _freeResult()
    {
        if(!empty($this->_result)) {
            $this->_result->free();
        }
    }

    /**
     * {@inheritDoc} 
     */
    public function add($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getAddSql() : $sql;
        if(false === $this->_isBindParam()) {
            if(false !== $this->_query($sql)) {
                return $this->_mysqli->insert_id;
            }

            return false;
        }

        return $this->_prepare($sql);
    }

    /**
     * {@inheritDoc} 
     */
    public function update($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getUpdateSql() : $sql;
        if(false === $this->_isBindParam()) {
            return $this->_query($sql);
        }

        return $this->_prepare($sql);
    }

    /**
     * {@inheritDoc} 
     */
    public function delete($sql = '')
    {
        $sql    = empty($sql) ? $this->_hSql->getDeleteSql() : $sql;

        return $this->_query($sql); 
    }

    /**
     * 对HMysqliSql里的是否为绑定变量执行形式的委托 
     * 
     * 这里得考虑一下是不是没有生成HSql对象的情况 
     * 
     * @access protected
     */
    protected function _isBindParam()
    {
        if(empty($this->_hSql) ||
           (false === $this->_hSql->isBindParam())) {
            return false;
        }

        return true;    
    }

    /**
     * 得到最后插入的记录ID
     * 
     * 注意得设置auto_increment字段 
     * 
     * @access public
     * @return int 
     */
    public function getLastInsertId()
    {
        return $this->_mysqli->insert_id;
    }

    /**
     * 使用Mysql传统方式来执行Sql的操作 
     * 
     * 不支持参数的绑定
     * 
     * @access protected
     * @param string $sql 需要执行的SQL语句
     * @param string $prefix 是否需要替换前缀
     * @return resource 
     */
    protected function _query($sql, $prefix = true)
    {
        $sql    = $prefix == true ? $this->_replaceTablePrefix($sql) : $sql;
        $this->_reconnectDb();
        $query  = $this->_mysqli->query($sql);
        if(true === HObject::GC('DEBUG')) {
            echo $sql . '<br/>';
        }
        if(!$query) {
            throw new HSqlException('SQL exec fail: ' . $sql . '<br/>Message: ' . $this->_mysqli->error);
        }

        return $query;
    }

    /**
     * 重新检测Db的连接情况
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _reconnectDb()
    {
        if($this->_mysqli->ping()) {
            return;
        }
        $this->_mysqli->close();
        $this->_initDb();
    }

    /**
     * 使用Mysql传统方式来执行Sql的操作 
     * 
     * 不支持参数的绑定
     * 
     * @access public 
     * @param string $sql 需要执行的SQL语句
     * @param string $prefix 是否需要替换前缀
     * @return resource 
     */
    public function query($sql, $prefix = true)
    {
        $this->_result  = $this->_query($sql);

        return $this->_result;
    }

    /**
     * 得到Sql准备对象
     * 
     * 以绑定参数的形式 
     * 
     * @access protected
     * @param string $sql
     */
    protected function _prepare($sql)
    {
        $this->_getStmt();
        if(false === $this->_stmt->prepare($sql)) {
            $this->_freeHSql();
            throw new HSqlException('SQL语句执行错误！' . $sql);
        }
        $rows     = $this->_hSql->getValues();
        if(!is_array($rows[0])) {
            $rows = array($rows);
        }
        $executeError   = -1;
        foreach($rows as $key => $values) {
            $this->_bindParams($values);
            if(!$this->_stmt->execute()) {
                $executeError ++;
                HLog::write('SQL执行错误！' . $sql, HLog::L_ERROR);
            }
        }
        $this->_freeHSql();

        return $key == $executeError ? false : true;
    }

    /**
     * 得到Mysqli的一个准备状态对象 
     * 
     * 用于执行绑定参数类的SQL执行 
     * 
     * @access protected
     */
    protected function _getStmt()
    {
        $this->_stmt    = $this->_mysqli->stmt_init();
    }

    /**
     * 关闭Mysqli的准备状态 
     * 
     * @access protected
     */
    protected function _closeStmt()
    {
        if($this->_stmt != null) {
            $this->_stmt->close();
        }
    }

    /**
     * 翻译HSql对象 
     * 
     * 每用完一次HSql对象就得重新生成不然会使用上一次的对象 
     * 
     * @access protected
     */
    protected function _freeHSql()
    {
        $this->_hSql    = null;
    }

    /**
     * 绑定字段的值 
     * 
     * 按给定的字段的数量一一对应 
     * 
     * @access protected
     * @param array $values 字段对应的值
     */
    protected function _bindParams($values)
    {
        $params     = $values;
        array_unshift($params, $this->_hSql->getFiledsType());
        call_user_func_array(
            array($this->_stmt, 'bind_param'),
            $params
        );
    }

    /**
     * 得到Mysqli的SQL语句生成对象 
     * 
     * 得到SQL生成对象 
     * 
     * @access public
     * @return HMysqliSql
     */
    public function getSql()
    {
        $this->_hSql    = new HMysqliSql();

        return $this->_hSql;
    }

    /**
     * 得到数据库错误信息 
     * 
     * 包括Sql执行错误及其它类型的错误信息 
     * 
     * @access protected
     * @return string 
     */
    protected function getDbError()
    {
        return 'Code: ' . $this->_mysqli->erron .
               'Message' . $this->_mysqli->error;
    }

    /**
     * {@inheritDoc} 
     */
    public function close()
    {
        if($this->_mysqli instanceof Mysqli) {
            $this->_mysqli->close();    
        }
    }

}
?>
