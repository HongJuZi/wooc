<?php 

/**
 * @version			$Id$
 * @create 			2012-4-28 22:49:45 By xjiujiu
 * @package 		app.admin
 * @subpackage 		action
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminBaseAction');

/**
 * 网站配置的动作类文件 
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		None
 * @since 			1.0.0
 */
class SiteconfigAction extends AdminBaseAction
{

    /**
     * @var array $_siteConfig 网站的配置信息
     */
    protected $_siteConfig;

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_siteConfig     = HObject::GC('SITE');
    }

    /**
     * 网站信息配置的主页动作 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function index()
    {
        HResponse::setAttribute('record', $this->_siteConfig);

        $this->_render('sitecfg');
    }

    /**
     * 编辑网站配置信息 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function edit()
    {
        HObject::SC('SITE_URL', HRequest::getParameter('site_url'));
        HObject::SC('SITE_NAME', HRequest::getParameter('site_name'));
        HObject::SC('SEO_KEYWORDS', HRequest::getParameter('seo_keywords'));
        HObject::SC('SEO_DESC', HRequest::getParameter('seo_desc'));
        foreach($this->_siteConfig as $key => $item) {
            $this->_siteConfig[$key]    = HRequest::getParameter($key);
        }
        $this->_siteConfig['message']   = HString::filterMoreBackSlash($this->_siteConfig['message']);
        HObject::SC('SITE', $this->_siteConfig);
        if(!HObject::EC()) {
            throw new HRequestException('更新失败！');
        }

        HResponse::succeed('更新成功！');
    }

}

?>
