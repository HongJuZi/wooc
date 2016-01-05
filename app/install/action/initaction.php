<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.install.action.installaction');
HClass::import('hongjuzi.environment.HOs');
HClass::import('hongjuzi.environment.HServer');
HClass::import('model.installmodel');

/**
 * 初始化类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.install.action
 * @since 1.0.0
 */
class InitAction extends InstallAction
{

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();

        $this->_errors  = null;
    }

    /**
     * 初始化首页
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        $this->_assignSystemEnvironment();
        $this->_assignDirsRightEnvironment(); 
        if(0 < count($this->_errors)) {
            HResponse::setAttribute('errors', $this->_errors);
            HResponse::setAttribute('redoUrl', HResponse::url('init'));
            $this->_render('error');
            return;
        }

        $this->_render('init');
    }

    /**
     * 赋值服务器及操作系统信息 
     * 
     * @access protected
     */
    protected function _assignServerOsEnvironment()
    {
        HClass::import('hongjuzi.environment.HOs');
        
        HResponse::setAttribute('serverHost', HServer::getServerHost());
        HResponse::setAttribute('serverOs', HOs::getOsName());
        HResponse::setAttribute('phpVersion', HServer::getPhpVersion());
        HResponse::setAttribute('parseEngine', HServer::getParseEngine());
    }

    /**
     * 赋值系统目录读写权限信息 
     * 
     * @access protected
     */
    protected function _assignDirsRightEnvironment()
    {
        static $_dirs   = array(
            'runtime',
            'config',
            'app/install/data',
            'static/uploadfiles'
        );
        static $_testFile   =  'temp.txt';
        foreach($_dirs as $dir) {
            $testFilePath   = ROOT_DIR . DS . $dir . DS . $_testFile;
            if(is_readable(ROOT_DIR . DS . $dir)) {
                $dirsInfo[$dir]['r']    = true;
            }
            try {
                HFile::create($testFilePath, 'test', true);
                HFile::delete($testFilePath);
            } catch(HIOException $ex) {
                $this->_errors[str_replace('/', '-', $dir) . '-no-write']    = ROOT_DIR . $dir . '不可写，需要设置到可写权限！';
            }
        }
    }

    /**
     * 赋值服务器的扩展支持等信息 
     * 
     * @access protected
     */
    protected function _assignSystemEnvironment()
    {
        if(!HServer::isSupportGD()) {
            $this->_errors['no-gd-extend']       = '<code>GD</code> 扩展不可用，请在 <code>php.ini</code> 中设置此扩展为开启状态！';
        }
        if(!HServer::isSupportExtension('mysql')) {
            $this->_errors['no-mysql-extend']    = '<code>MySQL</code>扩展不可用，请在 <code>php.ini</code> 中设置此扩展为开启状态！';
        }
        if(ini_get('allow_url_fopen') != 1) {
            $this->_errors['no-allow-url-fopen'] = '<code>allow_url_fopen</code> 不可用，请在 <code>php.ini</code> 中设置此函数为开启状态！';
        }
    }

    /**
     * 初始化错误信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function error()
    {
        $this->_render('error');
    }

    /**
     * 测试数据库连接
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function testdb()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('db_host'), '数据库地址');
        HVerify::isEmpty(HRequest::getParameter('db_port'), '数据库端口');
        HVerify::isEmpty(HRequest::getParameter('db_name'), '数据库名');
        HVerify::isEmpty(HRequest::getParameter('db_user'), '数据库用户名');
        HVerify::isEmpty(HRequest::getParameter('db_password'), '数据库登陆密码');
        $cfg    = array(
            'dbType' => 'mysql',
            'dbDriver' => HRequest::getParameter('db_driver'),
            'dbHost' => HRequest::getParameter('db_host'),
            'dbPort' => HRequest::getParameter('db_port'),
            'dbName' => HRequest::getParameter('db_name'),
            'dbUserName' => HRequest::getParameter('db_user'),
            'dbUserPassword' => HRequest::getParameter('db_password'),
            'dbCharset' => 'utf8' 
        );
        try {
            $this->_model   = new InstallModel($cfg);
        } catch(Exception $ex) {
            throw new HVerifyException('数据库用户名或密码不正确，请认真核对！');
        }
        if(!$this->_model->checkDbConnection()) {
            throw new HVerifyException('数据库连接失败，请确认信息是否准确！');
        }
        if(!$this->_model->isDbExists($cfg['dbName'])) {
            throw new HVerifyException($cfg['dbName'] . '数据库不存在，请先创建！');
        }

        HResponse::json(array('rs' => true));
    }

}

?>
