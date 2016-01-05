<?php

/**
 * @version			$Id: HRouter.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-4-7 11:25:17 By xjiujiu
 * @package 	 	hongjuzi
 * @subpackage 		core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 网站链接的解析类 
 * 
 * 按照用户给定的链接模式来解析对应的链接地址 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 	  	hongjuzi
 * @since 			1.0.0
 */
class HRouter extends HObject
{

    /**
     * @var array $_urlModes 当前支持的url模式 
     */
    protected static $_urlModes = array(
        'normal' => '',
        'pathinfo' => '',
        'custom' => ''
    );

    /**
     * @var HRouter $_hRouter 当前的HRoter对象
     */
    protected static $_hRouter  = null;

    /**
     * @var string $_app 当前所请求的应用名称
     */
    protected $_app;

    /**
     * @var string $_model 当前所请求的模块
     */
    protected $_model;

    /**
     * @var string $_action 当前所请求的动作
     */
    protected $_action;

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
	public function __construct()
    {
        $this->_model   = 'index';
        $this->_action  = 'index';
        $this->_app     = HObject::GC('DEF_APP');
    }

    /**
     * 得到HRouter的唯一实例 
     * 
     * 单例模式 
     * 
     * @access public static
     * @return void
     * @exception none
     */
    public static function getInstance()
    {
        if(!(self::$_hRouter instanceof HRouter)) {
            self::$_hRouter     = new HRouter();
        }

        return self::$_hRouter;
    }

    /**
     * 解析访问链接的模式 
     * 
     * 根据用户给定的解析方式，来解析当前用户的url内容 
     * 
     * @access public 
     * @param string $urlMode 指定的url解析方式，默认为：'pathinfo'
     * @return 当前对象
     */
    public function parseUrl($urlMode = 'pathinfo')
    {
        switch($urlMode) {
            case 'pathinfo': //路径模式解析
                return $this->_parseUrlByPathInfo();
            default:
            case 'normal': //查询参数方式
                return $this->_parseUrlByNormal();
        }
    }

    /**
     * 按pathinfo的方式来解析当前的url 
     * 
     * 以根参数的方式来解析，如：
     * <code>
     * http://www.xjiujiu.com/index.php/admin/product/see?id=1
     * 那么依次解析下来的数据为：
     * $this->_app  = admin;
     * $this->_model    = product;
     * $this->_action   = see;
     * </code> 
     * 
     * @access protected
     * @return $this 当前路由解析对象
     * @throws HVerifyException 验证异常
     */
    protected function _parseUrlByPathInfo()
    {
        $this->_isDefault(
            array_filter(explode('/', HRequest::getPathInfo()))
        );

        return $this;
    }

    /**
     * 是默认的访问路径
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $pathInfo 当前的访问信息
     */
    private function _isDefault($pathInfo)
    {
        if(0 === count($pathInfo)) {
            return;
        }

        $this->_isApp($pathInfo);
    }

    /**
     * 是/app的访问形式
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  Array $pathInfo 当前访问pathInfo信息
     */
    private function _isApp($pathInfo)
    {
        if(1 === count($pathInfo)) {
            if(file_exists(ROOT_DIR . 'app/' .$pathInfo[0])) {
                $this->_app = $pathInfo[0];
                return;
            }
            $this->_model   = $pathInfo[0];
            return;
        }

        $this->_isAppModel($pathInfo);
    }

    /**
     * 是App/Model访问形式
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  Array $pathInfo 当前访问pathInfo信息
     */
    private function _isAppModel($pathInfo)
    {
        if(2 === count($pathInfo)) {
            if(file_exists(ROOT_DIR . 'app/' .$pathInfo[0])) {
                $this->_app     = $pathInfo[0];
                $this->_model   = $pathInfo[1];
                return;
            }
            $this->_model   = $pathInfo[0];
            $this->_action  = ucfirst($pathInfo[1]);
            return;
        }

        $this->_isAppModelAction($pathInfo);
    }

    /**
     * 是app/model/action访问形式
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  Array $pathInfo 当前访问pathInfo信息
     * @throws HVerifyException 验证异常
     */
    private function _isAppModelAction($pathInfo)
    {
        if(3 === count($pathInfo)) {
            $this->_app     = $pathInfo[0];
            $this->_model   = $pathInfo[1];
            $this->_action  = ucfirst($pathInfo[2]);
            return;
        }

        throw new HVerifyException('网址格式有问题，请确认～');
    }

    /**
     * 通过自定义url模式的方式来解析当前的url 
     * 
     * 用正则之类的方式来解析用户给定的url解析方法 
     * 
     * @access protected
     * @return boolean 
     */
    protected function _parseUrlByCli()
    {
        $this->_app     = $pathInfo[0];
        $this->_model   = $pathInfo[1];
        $this->_action  = ucfirst($pathInfo[2]);
    }

    /**
     * 按正常的方式来解析用户请求的Url 
     * 
     * 以根参数的方式来解析，如：
     * <code>
     * http://www.xjiujiu.com/index.php?app=admin&m=product&a=see&id=1
     * 那么依次解析下来的数据为：
     * $this->_app  = admin;
     * $this->_model    = product;
     * $this->_action   = see;
     * </code> 
     * 
     * @access protected
     * @return boolean 
     */
    protected function _parseUrlByNormal()
    {
        $this->_app         = !HRequest::getParameter('app') ?
            'site' : HRequest::getParameter('app');
        $this->_model       = !HRequest::getParameter('m') ?
            'index' : HRequest::getParameter('m');
        $this->_action      = !HRequest::getParameter('a') ?
            'index' : HRequest::getParameter('a');

        return true;
    }

}
?>
