<?php 

/**
 * @version			$Id$
 * @create 			2012-4-7 16:24:57 By xjiujiu
 * @package 		application
 * @subpackage 		core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die();

/**
 * 网站应用基类
 * 
 * 网站应用的入口类 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.core
 * @since 			1.0.0
 */
class HApplication extends HObject
{

    /**
     * @var HApplication $_instance 应用类实例
     */
    protected static $_instance     = null;

    /**
     * 类实例的唯一实例化入口 
     * 
     * 单例模式得到应用程序的唯一实例 
     * 
     * @access public static
     * @return HApplication
     */
    public static function getInstance()
    {
        if(null === self::$_instance) {
            self::$_instance    = new HApplication();
        }

        return self::$_instance;
    }

    /**
     * 应用跑起来的入口 
     * 
     * @access public static
     */
    public static function run()
    {
        try {
            HObject::loadSysCfg();
            $app    = self::getInstance()->doRouter();
            HObject::loadAppCfg();
            $app->recordRequest()
                ->loadWebsite()
                ->loadAppLangCfg()
                ->importModelActionFile()
                ->invokeAction();
        } catch(HVerifyException $ex) {
           self::_reponseMessage($ex);
        } catch(HRequestException $ex) {
            self::_reponseMessage($ex);
        } catch(HIOException $ex) {
            HLog::write($ex->getMessage(), HLog::$L_ERROR);
            HResponse::redirect(HResponse::url('error/notfound', '', 'public'));
        } catch(HNotFoundException $ex) {
            HLog::write($ex->getMessage(), HLog::$L_ERROR);
            HResponse::redirect(HResponse::url('error/notfound', '', 'public'));
        } catch(Exception $ex) {
            HLog::write($ex->getMessage(), HLog::$L_ERROR);
            self::_reponseMessage(new Exception('抱歉！服务器正忙，请您稍后再试～'));
        }
    }

    /**
     * 加载哪一个网站信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function loadWebsite()
    {
        if(!HSession::getAttributeByDomain('website')) {
            $website        = HClass::quickLoadModel('website');
            HSession::setAttributeByDomain($website->getRecordByIdentifier('main'), 'website');
        }

        return $this;
    }

    /**
     * 响应用户信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     */
    protected static function _reponseMessage($ex)
    {
        try {
            HVerify::isAjax();
            HResponse::json(array('rs' => false, 'message' => $ex->getMessage(), 'status' => $ex->status));
        } catch(HVerifyException $e) {
            HResponse::alert($ex->getMessage(), -1, 1, $ex->status);
        }
    }

    /**
     * 委托HRouter来解析当前的url链接 
     * 
     * 按用户给定的urlMode方式来解析 
     * 
     * @access public
     * @return HApplication 当前应用
     */
    public function doRouter()
    {
        $router     = HRouter::getInstance()->parseUrl(HObject::GC('URL_MODE'));
        HResponse::setAttribute('HONGJUZI_APP', $router->get('app'));
        HResponse::setAttribute('HONGJUZI_MODEL', $router->get('model'));
        HResponse::setAttribute('HONGJUZI_ACTION', strtolower($router->get('action')));
        unset($router);

        return $this;
    }

    /**
     * 加载应用对应的语言配置文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return HApplication 当前应用
     */
    public function loadAppLangCfg()
    {
        HResponse::loadLang(HResponse::getAttribute('HONGJUZI_APP'));

        return $this;
    }

    /**
     * 导入对应的处理模块动作文件 
     * 
     * 按当前的请求的应用模块来导入对应的动作文件 
     * 
     * @access protected
     * @return HApplication 当前应用
     */
    public function importModelActionFile()
    {
        HClass::import(
            'app.' .  HResponse::getAttribute('HONGJUZI_APP') 
            . '.action.'. HResponse::getAttribute('HONGJUZI_MODEL') . 'action'
        );

        return $this;
    }

    /**
     * 调用请求的动作 
     * 
     * @access public
     */
    public function invokeAction()
    {
        $className  = ucfirst(HResponse::getAttribute('HONGJUZI_MODEL')) . 'Action';
        $method     = HResponse::getAttribute('HONGJUZI_ACTION');
        if(!class_exists($className)) {
            throw new HNotFoundException('没有找到对应的类！' . $className);
        }
        $classObj   = new $className;
        if(!method_exists($classObj, $method)) {
            throw new HNotFoundException('没有找到对应的方法！' . $className);
        }
        $classObj->beforeAction();
        $classObj->{$method}();
        $classObj->afterAction();
    }

    /**
     * 记录当前的请求信息 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return HApplication 当前应用
     */
    public function recordRequest()
    {
        try {
            HVerify::isAjax();
            return $this;
        } catch(HVerifyException $ex) { }
        $referenceList  = !HSession::getAttribute('referenceList') ? array() : HSession::getAttribute('referenceList');
        if(count($referenceList) > 2) {
            array_pop($referenceList);
        }
        $reference      = array(
            'APP' => HResponse::getAttribute('HONGJUZI_APP'),
            'MODEL' => HResponse::getAttribute('HONGJUZI_MODEL'),
            'ACTION' => HResponse::getAttribute('HONGJUZI_ACTION'),
            'URL' => HRequest::getCurUrl()
        );
        array_unshift($referenceList, $reference);
        HSession::setAttribute('referenceList', $referenceList);

        return $this;
    }

}

?>
