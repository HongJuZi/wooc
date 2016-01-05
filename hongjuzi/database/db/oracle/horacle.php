<?php 

/**
 * @version $Id$
 * @create 2013-7-12 19:36:32 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die();

//导入数组工具类
HObject::import('hongjuzi.database.IHDatabase');

/**
 * Oracle IOC8支持Oracle 10.2G版本驱动
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.database.oracle 
 * @since 1.0.0
 */
class HOracle extends HObject implements IHDatabase
{

    /**
     * @var Array $_dbCfg 数据库的连接对象
     */
    protected $_dbCfg;

    /**
     * @var resource $_conn 数据库的连接实例
     */
    protected $_conn;

    /**
     * 构造函数
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct($dbCfg)
    {
        $this->_conn    = null;
        $this->_dbCfg   = $dbCfg;
    }

    /**
     * {@inheritDoc}
     */
    public function connect()
    {
        $this->_conn    = oci_connect(
            $this->_dbCfg['dbUserName'],
            $this->_dbCfg['dbUserPassword'],
            $this->_dbCfg['dbName'],
            $this->_dbCfg['charset']
        ); 
        if(!$this->_conn) {
            throw new HDatabaseException('Oracle connection fail!' . print_r(oci_error()));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function selectDb() { }

    /**
     * {@inheritDoc}
     */
    public function select($sql = '')
    {
        $list   = array();
        $stmt   = oci_parse($this->_conn, $sql);
        if(!oci_execute($stmt)) {
            throw new HDatabaseException('Oracle execute fail!' . print_r(oci_error()));
        }
        while($row = oci_fetch_array($stmt, OCI_BOTH)) {
            $list[]     = $row;
        }

        return $list;
    }

    /**
     * {@inheritDoc}
     */
    public function add($sql = '')
    {
        return $this->query($sql);
    }

    /**
     * {@inheritDoc}
     */
    public function update($sql = '')
    {
        return $this->query($sql);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($sql = '')
    {
        return $this->query($sql);
    }

    /**
     * 通用的执行SQL语句方法
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return boolean 是否成功
     */
    public function query($sql)
    {
        $stmt   = oci_parse($this->_conn, $sql);

        return oci_execute($stmt, OCI_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        oci_close($this->_conn);
    }

}

?>
