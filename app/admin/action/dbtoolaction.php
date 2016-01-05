<?php 

/**
 * @version			$Id$
 * @create 			2012-5-1 22:27:14 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminBaseAction, model.DbtoolModel');

/**
 * 数据库工具类 
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since			1.0.0
 */
class DbtoolAction extends AdminBaseAction
{

    /**
     * @var array $_dbConfig 数据库的配置信息
     */
    protected $_dbConfig;

    /**
     * 构造函数 
     * 
     * @desc
     * 
     * @access public
     */
    public function __construct()
    {
        $this->_dbConfig    = HObject::GC('DATABASE');
        $this->_model       = new DbtoolModel($this->_dbConfig['dbName']);
    }

    /**
     * 数据库工具入口方法 
     * 
     * @access public
     */
    public function index()
    {
        $this->_render('dbtools');
    }

    /**
     * 备份数据库 
     * 
     * @access public
     */
    public function backup()
    {
        $backupName         = HRequest::getParameter('backup_file_name');
        $backupFilePath     = ROOT_DIR . HObject::GC('RUNTIME_DIR') . '/temp/' . $backupName . '.sql';
        HFile::create($backupFilePath, $this->_model->getBackupDbSql(), true);
        HResponse::outputFile($backupFilePath);
    }

    /**
     * 还原数据库 
     * 
     * @access public
     */
    public function recovery()
    {
        HClass::import('hongjuzi.net.HUploader');
        $hUploader  = new HUploader(
            HObject::GC('RUNTIME_DIR') . '/temp/',
            2,
            '.sql',
            ROOT_DIR
        );
        $rs     = $hUploader->uploader($_FILES['recovery_file'], false);
        if(isset($rs['error'])) {
            throw new HVerifyException('文件上传失败！错误信息: ' . $rs['error']);
        }
        $recoveryDbSql  = $this->_getRecoveryDbSql(ROOT_DIR . $rs['path']);
        if(empty($recoveryDbSql)) {
            throw new HRequestException('没有可恢复的数据，请确认！');
        }
        if(!$this->_model->recoveryDb($recoveryDbSql)) {
            throw new HRequestException('数据库恢复失败！');
        }

        HResponse::succeed('数据库恢复成功！');
    }

    /**
     * 得到恢复数据库的SQL语句 
     * 
     * @access protected
     * @param string $recoveryFilePath 恢复文件的路径
     * @return array 
     */
    protected function _getRecoveryDbSql($recoveryFilePath)
    {
        $querySql       = '';
        $recoveryDbSqls = array();
        $sqls           = file($recoveryFilePath);
        foreach($sqls as $sql) {
            $sql        = trim($sql);
            if(empty($sql) || substr($sql, 0, 2) == '--') {
                $querySql           = '';
                continue;
            }
            $endChar    = substr($sql, -1);
            if($endChar == ';') {
                $recoveryDbSqls[]   = $querySql . $sql;
                $querySql           = '';
            } else {
                $querySql   .= $sql;
            }
        }
        try {
            HFile::delete($recoveryFilePath);
        } catch(HIOException $ex) {
            //log
        }
        
        return $recoveryDbSqls;
    }

}

?>
