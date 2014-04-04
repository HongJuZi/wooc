<?php

/**
 * @version			$Id$
 * @create 			2012-5-13 23:52:52 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

/**
 * 安装程序应用主页控制层类 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.install.action
 * @since 			1.0.0
 */
class IndexAction extends HAction 
{

    /**
     * {@inheritDoc}
     */
    public function beforeAction()
    {
        if(file_exists(ROOT_DIR . '/install.lock')) {
            HResponse::warn('程序已经安装成功！', HResponse::url());
        }
    }

    /**
     * 安装程序主页 
     * 
     * @access public
     */
    public function index()
    {
        $this->_assignTempSiteUrl();
        switch(HRequest::getParameter('step')) {
            case 2: $this->_stepTwo(); break;
            case 3: $this->_stepThree(); break;
            case 4: $this->_stepFour(); break;
            case 5: $this->_stepFive(); break;
            case 1: default: $this->_stepOne(); break;
        }
    }

    /**
     * 赋值临时当前的网站访问地址 
     * 
     * 根据临时当前网的请求地址，来设定当前网站的访问地址 
     * 
     * @access protected
     */
    protected function _assignTempSiteUrl()
    {
        HObject::SC('SITE_URL', HString::getDirUrlByUrl(HRequest::getCurUrl())); 
    }

    /**
     * 执行安装步骤一
     * 
     * 让同户同意用户许可协议 
     * 
     * @access protected
     */
    protected function _stepOne()
    {
        $this->_render('step-1');
    }

    /**
     * 执行安装步骤二
     * 
     * 安装环境的检测 
     * 
     * @access protected
     */
    protected function _stepTwo()
    {
        HClass::import('hongjuzi.environment.HServer');
        
        $this->_assignServerOsEnvironment();
        $this->_assignSystemEnvironment();
        $this->_assignDirsRightEnvironment();

        $this->_render('step-2');
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
     * 赋值服务器的扩展支持等信息 
     * 
     * @access protected
     */
    protected function _assignSystemEnvironment()
    {
        HResponse::setAttribute('isGd', HServer::isSupportGD() ? 'On' : 'Off');
        HResponse::setAttribute('isSafeMode', !ini_get('safe_mode') ? 'Off' : 'On');
        HResponse::setAttribute('isMysql', HServer::isSupportExtension('mysql') ? 'On' : 'Off');
        HResponse::setAttribute('isAllowUrlFopen', ini_get('allow_url_fopen') == 1 ? 'On' : 'Off');
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
        $dirsInfo           = array();
        foreach($_dirs as $dir) {
            $testFilePath   = ROOT_DIR . DS . $dir . DS . $_testFile;
            if(is_readable(ROOT_DIR . DS . $dir)) {
                $dirsInfo[$dir]['r']    = true;
            }
            try {
                HFile::create($testFilePath, 'test', true);
                HFile::delete($testFilePath);
                $dirsInfo[$dir]['w']    = true;
            } catch(HIOException $ex) {
                $dirsInfo[$dir]['w']    = false;
            }
        }
        HResponse::setAttribute('dirsInfo', $dirsInfo);
    }

    /**
     * 执行安装步骤三
     * 
     * 参数配置 
     * 
     * @access protected
     */
    protected function _stepThree()
    {
        $this->_render('step-3');
    }

    /**
     * 执行安装步骤四
     * 
     * 正在安装 
     * 
     * @access protected
     */
    protected function _stepFour()
    {
        HVerify::isEmpty(HRequest::getParameter('site_name'), '网站名称');
        HVerify::isEmpty(HRequest::getParameter('admin_email'), '网站管理员');
        HVerify::isEmpty(HRequest::getParameter('admin_user_name'), '管理员用户名');
        HVerify::isEmpty(HRequest::getParameter('admin_user_passwd'), '管理员用户密码');
        HSession::setAttribute(HRequest::getParameter('admin_user_name'), 'name', 'install');
        HSession::setAttribute(HRequest::getParameter('admin_user_password'), 'password', 'install');
        HSession::setAttribute(HRequest::getParameter('site_name'), 'site_name', 'install');
        HSession::setAttribute(HRequest::getParameter('admin_email'), 'admin_email', 'install');
        $this->_setDbConfig();

        $this->_render('step-4');
    }

    /**
     * 设置数据库的配置信息 
     * 
     * @access protected
     */
    protected function _setDbConfig()
    {
        $dbCfg   = HObject::GC('DATABASE');
        foreach($dbCfg as $item => $value) {
            if(null !== HRequest::getParameter($item)) {
                $dbCfg[$item]   = HRequest::getParameter($item);
            }
        }
        HObject::SC('DATABASE', $dbCfg);
        HObject::EC();
    }

    /**
     * 设置网站的配置信息 
     * 
     * @access protected
     */
    protected function _setSiteConfig()
    {
        $config     = HClass::quickLoadModel('config');
        $data       = array(
            'site_name' => HSession::getAttribute('site_name', 'install'),
            'email' => HSession::getAttribute('admin_email', 'install')
        );
        if(1 > $config->add($data)) {
            throw new HRequestException('添加网站配置失败，请您稍后再试！');
        }
    }

    /**
     * 执行安装过程 
     * 
     * @access public
     */
    public function setup()
    {
        $dbCfg  = HObject::GC('DATABASE');
        $this->_initModel($dbCfg);
        $msg    = $this->_createDb($dbCfg);
        $msg    .= $this->_importDbData();
        $msg    .= $this->_addAdminUser();
        $this->_setSiteConfig();
        
        $siteUrl    = HResponse::url();
        echo <<<SETUP_HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{$siteUrl}/public/template/install/css/style.css" type="text/css" />
    <style type="text/css">
        body {
            background: none;
        }
        .twbox tr{
            text-align: center;
        }
    </style>
</head>
<body>
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="twbox" style="width: 650px;">
    <tbody><tr>
        <th width="50%" align="center"><strong>执行名称</strong></th>
        <th ><strong>执行结果</strong></th>
    </tr>
{$msg}
    <tr>
    <td colspan="2">
        <a href="{$siteUrl}/index.php/install?step=5" target="_top">点击此完成安装 &gt;&gt;</a>
    </td>
    </tr>
    </tbody>
    
</table>
<br/>
    <br/>
    <br/>
    <br/>
    <br/>
</body>
</html>
SETUP_HTML;
        exit();
    }

    /**
     * 初始化Index模块对象  
     * 
     * @access protected
     */
    protected function _initModel($dbCfg)
    {
        HClass::import('model.installmodel');
        $this->_model     = new InstallModel($dbCfg);
    } 

    /**
     * 创建指定的数据库 
     * 
     * @access protected
     */
    protected function _createDb($dbCfg)
    {
        if(true == $this->_model->isDbExists($dbCfg['dbName'])) {
            return '<tr><td>数据库</td><td style="color: green;">已经存在</td></tr>';
        }
        if(false == $this->_model->createDb($dbCfg['dbName'])) {
            throw new HRequestException('创建数据库失败！');
        }
        $this->_model->selectDb($dbCfg['dbName']);
        
        return '<tr><td>创建数据库</td><td style="color: green;">成功</td></tr>';
    }

    /**
     * 导入数据库数据 
     * 
     * @access protected
     */
    protected function _importDbData()
    {
        try {
            $this->_model->importDbData($this->_paserSqlFromFile(ROOT_DIR . DS . '/app/install/data/db.sql'));
            return '<tr><td>导入数据库数据</td><td style="color: green;">成功</td></tr>';
        } catch(Exception $ex) {
            throw new HRequestException('导入数据库信息失败！错误的SQL语句：' . $ex->getMessage());
        }
    }

    /**
     * 从文件中解析出可用的SQL语句 
     * 
     * @access protected
     * @param string $dbFilePath 恢复文件的路径
     * @return array 
     */
    protected function _paserSqlFromFile($dbFilePath)
    {
        $querySql       = '';
        $dbSqls         = array();
        $sqls           = file($dbFilePath);
        foreach($sqls as $sql) {
            $sql        = trim($sql);
            if(empty($sql) || substr($sql, 0, 2) == '--') {
                $querySql           = '';
                continue;
            }
            $endChar    = substr($sql, -2);
            if(preg_match('/[\'"`\)]{1};$/', $endChar)) {
                $dbSqls[]   = $querySql . $sql;
                $querySql   = '';
            } else {
                $querySql   .= $sql;
            }
        }
        
        return $dbSqls;
    }

    /**
     * 添加管理员账号 
     * 
     * @access protected
     * @return string 
     */
    protected function _addAdminUser()
    {
        $user   = HClass::quickLoadModel('user');
        $data   = array(
            'name' => HSession::getAttribute('name', 'install'),
            'passwd' => md5(Hsession::getAttribute('passwd', 'install')),
            'email' => HSession::getAttribute('admin_email', 'install'),
            'parent_id' => '1',
            'edit_time' => HDatetime::getNow(),
            'author' => 0, 
        );
        if(!$user->add($data)) {
            throw new HRequestException('添加管理员用户失败！');
        }

        return '<tr><td>添加管理员用户</td><td style="color: green;">成功</td></tr>';
    }

    /**
     * 执行安装步骤五
     * 
     * 安装完成 
     * 
     * @access protected
     */
    protected function _stepFive()
    {
        HObject::SC('INSTALL', 2);
        HObject::EC();
        HSession::setAttributeByDomain(null, 'install');
        $this->_render('step-5');
    }

}

?>
