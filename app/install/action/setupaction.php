<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.install.action.installaction');
HClass::import('model.installmodel');

/**
 * 设置类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.install.action
 * @since 1.0.0
 */
class SetupAction extends InstallAction
{

    /**
     * 初始化首页
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        $this->_verifyInitData();
        $this->_setDbConfig();
        $this->_setCdnUrlConfig();
        HObject::EC();
        $this->_verifyDatabaseIsEmpty();
        if(0 < count($this->_errors)) {
            HResponse::setAttribute('errors', $this->_errors);
            $this->_render('error-setup');
            return;
        }

        $this->_render('setup');
    }

    /**
     * 检测数据库是否为空
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _verifyDatabaseIsEmpty()
    {
        $cfg        = HObject::GC('DATABASE');
        $install    = new InstallModel($cfg); 
        $list       = $install->getTables($cfg['dbName']);
        if(empty($list)) {
            return;
        }
        $tablesMap  = require_once(ROOT_DIR . 'app/install/data/tablesmap.php');
        $tables     = HArray::extractElement($list, 'Tables_in_' . $cfg['dbName']);
        foreach($tables as $table) {
            if(in_array(str_replace($cfg['tablePrefix'], '', $table), $tablesMap)) {
                $this->_errors[]    = '<code>' . $table . '</code> 表已经存在，请保存好数据后删除！';
            }
        }
    }

    /**
     * 清空老的数据表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function cleanup()
    {
        $cfg        = HObject::GC('DATABASE');
        $install    = new InstallModel($cfg); 
        $list       = $install->getTables($cfg['dbName']);
        $tablesMap  = require_once(ROOT_DIR . 'app/install/data/tablesmap.php');
        $tables     = HArray::extractElement($list, 'Tables_in_' . $cfg['dbName']);
        foreach($tables as $table) {
            if(!in_array(str_replace($cfg['tablePrefix'], '', $table), $tablesMap)) {
                continue;
            }
            if(!$install->query('DROP TABLE `' . $table . '`')) {
                HResponse::warn('删除表<code>' . $table . '</code>失败，请确认是否有删除权限！', HResponse::url('init'));
                return;
            }
        }
        HResponse::succeed('清除老数据成功，正在为您导航到初始化数据页面。', HResponse::url('init'));
    }

    /**
     * 校验初始化数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _verifyInitData()
    {
        HVerify::isEmpty(HRequest::getParameter('dbDriver'), '数据库驱动');
        HVerify::isEmpty(HRequest::getParameter('dbHost'), '数据库地址');
        HVerify::isEmpty(HRequest::getParameter('dbPort'), '数据库端口');
        HVerify::isEmpty(HRequest::getParameter('dbUserName'), '数据库用户');
        HVerify::isEmpty(HRequest::getParameter('dbUserPassword'), '数据库密码');
        HVerify::isEmpty(HRequest::getParameter('dbName'), '数据库名称');
        HVerify::isEmpty(HRequest::getParameter('tablePrefix'), '数据库表前缀');
        HVerify::isEmpty(HRequest::getParameter('site_name'), '网站名称');
        HVerify::isEmpty(HRequest::getParameter('site_lang'), '默认语言');
        HVerify::isStrLen(HRequest::getParameter('name'), '管理员名称', 2);
        HVerify::isStrLen(HRequest::getParameter('password'), '管理员密码', 6);
        HVerify::isEmail(HRequest::getParameter('email'), '常用邮箱');
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
            if(HRequest::getParameter($item)) {
                $dbCfg[$item]   = HRequest::getParameter($item);
            }
        }
        HObject::SC('DATABASE', $dbCfg);
    }

    /**
     * 设置加速CDN地址
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _setCdnUrlConfig()
    {
        HObject::SC('CDN_URL', HResponse::url() . 'vendor/');
        HObject::SC('STATIC_URL', HResponse::url());
    }

    /**
     * 初始化表格
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function inittable()
    {
        $this->_importSqlFile('app/install/data/wooc-tables.sql');

        HResponse::json(array('rs' => true));
    }

    /**
     * 初始化网站基础数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function initdata()
    {
        $this->_importSqlFile('app/install/data/wooc-data.sql');

        HResponse::json(array('rs' => true));
    }

    /**
     * 导入SQL文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $file 文件路径
     */
    private function _importSqlFile($file)
    {
        $cfg        = HObject::GC('DATABASE');
        $content    = file_get_contents(ROOT_DIR . $file);
        $content    = strtr($content, array(
            '{prefix}' => $cfg['tablePrefix'],
            '{charset}' => $cfg['dbCharset'],
            "\r\n" => "\n",
        ));
        $sqls       = explode(";\n", $content);
        $install    = new InstallModel($cfg); 
        foreach($sqls as $sql) {
            if(!trim($sql)) {
                return;
            }
            $install->query($sql);
        }
    }

    /**
     * 初始化网站数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function initwebsite()
    {
        HVerify::isEmpty(HRequest::getParameter('name'), '网站名称');
        HVerify::isEmpty(HRequest::getParameter('lang'), '默认语言');
        HVerify::isEmpty(HRequest::getParameter('administrator'), '管理员名称');
        HVerify::isEmpty(HRequest::getParameter('email'), '管理员常用邮箱');
        $data       = array(
            'name' => HRequest::getParameter('name'),
            'seo_keywords' => HRequest::getParameter('name') . ',wooc',
            'seo_desc' => HRequest::getParameter('name') . ',又一个Wooc网站！',
            'description' => HRequest::getParameter('name') . ',又一个Wooc网站！',
            'lang_id' => HRequest::getParameter('lang'),
            'is_open' => 2,
            'is_default' => 2
        );
        $website    = HClass::quickLoadModel('website');
        if(1 > $website->add($data)) {
            throw new HRequestException('添加网站信息失败！');
        }

        HResponse::json(array('rs' => true));
    }

    /**
     * 初始化管理员数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function initadmin()
    {
        HVerify::isStrLen(HRequest::getParameter('name'), '管理员名称', 2);
        HVerify::isStrLen(HRequest::getParameter('password'), '管理员密码', 6);
        HVerify::isEmail(HRequest::getParameter('email'), '常用邮箱');
        $user   = HClass::quickLoadModel('user');
        $data   = array(
            'name' => HRequest::getParameter('name'),
            'password' => md5(HRequest::getParameter('password')),
            'email' => HRequest::getParameter('email'),
            'parent_id' => '1',
            'login_time' => $_SERVER['REQUEST_TIME'],
            'author' => 0,
            'ip' => HRequest::getClientIp()
        );
        if(!$user->add($data)) {
            throw new HRequestException('添加管理员用户失败！');
        }
        //写入完装完成标识文件
        file_put_contents(ROOT_DIR . 'config/install.lock', 'Great, Wooc installed!');

        HResponse::json(array('rs' => true));
    }

}

?>
