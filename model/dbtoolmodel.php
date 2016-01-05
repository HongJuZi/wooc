<?php 

/**
 * @version			$Id$
 * @create 			2012-5-2 9:37:08 By xjiujiu
 * @package 		app.admin
 * @subpackage 		model
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

/**
 * 数据库备份数据库操作层类 
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class DbtoolModel extends HModel
{

    /**
     * @var string $_dbName 当前备份的数据库名
     */
    protected $_dbName;

    /**
     * @var array $_dbCfg 当前数据库的配置信息
     */
    protected $_dbCfg;

    /**
     * 构造函数 
     * 
     * @access public
     */
    public function __construct($dbName = '')
    {
        parent::__construct();

        $this->_dbName  = $dbName;
    }

    /**
     * 得到数据库备份的SQL语句 
     * 
     * @access public
     * @return string
     */
    public function getBackupDbSql()
    {
        $backupSql  = $this->_addComment('网站数据库"' . $this->_dbName . '"备份内容！');
        $backupSql  .= $this->_addSplitLine();
        $tables     = $this->_getDbTables();
        $backupSql  .= $this->_getDbCreateTableSql($tables);
        $backupSql  .= $this->_addSplitLine();
        $backupSql  .= $this->_getDbInsertDataSql($tables);

        return $backupSql;
    }

    /**
     * 得到数据库创建语句 
     * 
     * @access protected
     * @return string 
     */
    protected function _getDbCreateSql()
    {
        return 'CREATE DATABASE `' . $this->_dbName . '`;';
    }

    /**
     * 得到创建数据库表的SQL语句 
     * 
     * @desc
     * 
     * @access protected
     * @Pararm array $tables 数据表集合
     * @return string 
     * @exception none
     */
    protected function _getDbCreateTableSql($tables)
    {
        $tableSql   = '';
        foreach($this->_getDbTables() as $table) {
            $tableName  = $this->_formatTableName($table['Name']);
            $this->_addComment('创建表 ' . $tableName);
            $tableSql   .= 'DROP TABLE IF EXISTS `' . $tableName . "`;\n";
            $tableSql   .= 'CREATE TABLE `' . $tableName . '` (';
            $tableSql   .= $this->_getTableFieldsSql($table['Name']);
            $tableSql   .= "\n)engine=" . $table['Engine'] .
                           ' DEFAULT CHARSET=' . substr($table['Collation'], 0, strpos($table['Collation'], '_')) .
                           ' auto_increment=' . $table['Auto_increment'] .
                           ' comment=\'' . $table['Comment'] . "';\n";
        }

        return $tableSql;
    }

    /**
     * 得到数据库里的所有表 
     * 
     * @access protected
     * @return array
     */
    protected function _getDbTables()
    {
        return $this->_db->select('SHOW TABLE STATUS FROM ' . $this->_dbName . ';')
            ->getList();
    }

    /**
     * 得到表字段的SQL语句 
     * 
     * @access protected
     * @param string $table
     * @return string 
     */
    protected function _getTableFieldsSql($table)
    {
        $fields     = $this->_db->select('SHOW FIELDS FROM `' . $table . '`')
            ->getList();
        if(empty($fields)) {
            return '';
        }
        $fieldsSql  = array();
        foreach($fields as $field) {
            $fieldsSql[]    = '`' . $field['Field'] . '` ' .
                              $field['Type'] .
                              $this->_isNull($field['Null']) .
                              $this->_hasDefault($field['Default']) .
                              ' ' . $field['Extra'] .
                              $this->_isKey($field['Field'], $field['Key']);
        }

        return implode(",\n", $fieldsSql);
    }

    /**
     * 查看字段是否允许为空 
     * 
     * @desc
     * 
     * @access protected
     * @param string $null 当前的空值标识
     * @return string 
     * @exception none
     */
    protected function _isNull($null)
    {
        if('YES' == $null) {
            return ' NULL';
        }

        return ' NOT NULL';
    }

    /**
     * 是否有设置默认值 
     * 
     * @access protected
     * @param string $default 当前的值
     * @return string 
     */
    protected function _hasDefault($default)
    {
        if(HVerify::isEmptyNotZero($default)) {
            return  '';
        }

        return  'CURRENT_TIMESTAMP' === $default 
           ? ' DEFAULT ' . $default : ' DEFAULT \'' . $default . '\'';
    }

    /**
     * 查看是否要添加索引 
     * 
     * @desc
     * 
     * @access protected
     * @param string $field 当前字段
     * @param string $key 是否为索引标识
     * @return string 
     * @exception none
     */
    protected function _isKey($field, $key)
    {
        switch($key) {
        case 'PRI':
            return ' PRIMARY KEY';
        case 'MUL':
            return ', INDEX(`' . $field . '`)';
        default:
            return '';
        }
    }

    /**
     * 得到数据库表里的数据SQL 
     * 
     * @desc
     * 
     * @access protected
     * @Pararm array $tables 数据表集合
     * @return string 
     * @exception none
     */
    protected function _getDbInsertDataSql($tables)
    {
        $insertDataSql  = '';
        foreach($tables as $table) {
            $tableName  = $this->_formatTableName($table['Name']);
            $insertDataSql  .= $this->_addComment($tableName);
            $list           = $this->_getTableData($table['Name']);
            foreach($list as $record) {
                $record     = array_filter($record);
                $insertDataSql .= $this->_db->getSql()
                    ->table($tableName)
                    ->fields(array_keys($record))
                    ->values(array_values($record))
                    ->getBaseInsertSql() . "\n";
            }
        }

        return $insertDataSql;
    }

    /**
     * 格式化表名 
     * 
     * 把当前的表名用，表的前缀来替换 
     * 
     * @access protected
     * @param string $tableName 当前的表名
     * @return string 
     * @exception none
     */
    protected function _formatTableName($tableName)
    {
        static $dbCfg   = null;
        if($dbCfg === null) {
            $dbCfg  = HObject::GC('DATABASE');
        }
        
        return strtr($tableName, array($dbCfg['tablePrefix'] => '#_'));   
    }

    /**
     * 得到数据表里所有的数据 
     * 
     * @desc
     * 
     * @access protected
     * @param string $table 表名称
     * @return array 
     * @exception none
     */
    protected function _getTableData($table)
    {
        $this->_db->getSql()
            ->table($table)
            ->fields('*');
        
        return $this->_db->select()->getList();
    }

    /**
     * 添加注释段
     * 
     * @desc
     * 
     * @access protected
     * @return string 
     * @exception none
     */
    protected function _addComment($comment)
    {
        return "--\n" .
               '-- ' . $comment . "\n" .
               "--\n\n" ;
    }

    /**
     * 添加分隔线 
     * 
     * @desc
     * 
     * @access protected
     * @return string 
     * @exception none
     */
    protected function _addSplitLine($count = 40)
    {
        return "\n-- " . str_repeat('-', $count) . "\n\n";
    }

    /**
     * 恢复数据库
     * 
     * @desc
     * 
     * @access public
     * @param array $sqls 需要执行的SQL语句
     * @return boolean
     * @exception none
     */
    public function recoveryDb($sqls)
    {
        foreach($sqls as $sql) {
            if(false === $this->_db->query($sql, true)) {
                return false;
            }
        }

        return true;
    }

}


?>
