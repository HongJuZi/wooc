<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//引入引用文件
HClass::import('app.base.action.frontaction');

/**
 * 安装父类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com> 
 * @package app.install.action
 * @since 1.0.0
 */
class InstallAction extends FrontAction
{

    /**
     * @var protected $errors 错误信息
     */
    protected $_errors;

    /**
     * @var protected $_defLang 默认语言
     */
    protected static $_defLang = 454;

    /**
     * @var private static $_langMap    语言映射
     */
    private static $_langMap    = array(
        '465' => array('id' => '454', 'name' => '简体中文', 'identifier' => 'zh-cn')
    );

    /**
     * {@inheritDoc}
     */
    public function beforeAction()
    {
        HVerify::isCSRF();
        if(file_exists(ROOT_DIR . '/config/install.lock')) {
            HResponse::info('程序已经安装成功！如果需要重新安装，请删除：config/install.lock文件。', HResponse::url());
        }
    }

    /**
     * 初始化任务
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_errors  = null;
        $this->_assignLangList();
        $this->_switchLang();
    }

    /**
     * 加载语言列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLangList()
    {
        HResponse::setAttribute('lang_id_list', self::$_langMap);
        HResponse::setAttribute('lang_id_map', self::$_langMap);
    }

    /**
     * 转换语言
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _switchLang()
    {
        if(!HSession::getAttribute('id', 'lang')) {
            HSession::setAttributeByDomain(self::$_langMap[self::$_defLang], 'lang');
            return;
        }
        $id   = HRequest::getParameter('lang');
        if(!isset(self::$_langMap[$id])) {
            HSession::setAttributeByDomain(self::$_langMap[self::$_defLang], 'lang');
            return;
        }
        HSession::setAttributeByDomain(self::$_langMap[$id], 'lang');
    }

}
