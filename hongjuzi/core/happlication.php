<?php 

/**
 * @version			$Id$
 * @create 			2012-4-7 16:24:57 By xjiujiu
 * @package 		application
 * @subpackage 		core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

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
            $app    = self::getInstance();
            $app->startUp();
        } catch(HVerifyException $ex) {
           self::_reponseMessage($ex);
        } catch(HRequestException $ex) {
            self::_reponseMessage($ex);
        } catch(HIOException $ex) {
            HLog::write($ex->getMessage(), HLog::$L_ERROR);
            $app->notFound();
        } catch(HNotFoundException $ex) {
            HLog::write($ex->getMessage(), HLog::$L_ERROR);
            $app->notFound();
        } catch(Exception $ex) {
            HLog::write($ex->getMessage(), HLog::$L_ERROR);
            self::_reponseMessage(new Exception('抱歉！服务器正忙，请您稍后再试～'));
        }
    }

    /**
     * 开启应用
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function startup()
    {
        HObject::loadSysCfg();
        $this->_fixInvokeMethod()->_doRouter();
        HObject::loadAppCfg();
        $this->_defineSiteUrl();
        HObject::loadSiteCfg();
        $this->_recordRequest()
            ->_loadFrameworkLangDict()
            ->_importModelActionFile()
            ->_invokeAction();
    }

    /**
     * 定义网站访问地址
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _defineSiteUrl()
    {
        if(true === HObject::GC('OPEN_SHORT_URL')) {
            @define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
            return $this;
        }
        //定义网站根目录路径
        if(!$_SERVER['REQUEST_URI']) {
            @define('SITE_URL', null);
            return $this;
        }
        $loc    = strpos($_SERVER['REQUEST_URI'], '.php');
        if(false !== $loc) {
            $index	= substr($_SERVER['REQUEST_URI'], 0, $loc - 6); // + 4 长url
        } else { 
            $index  = '';
            if($_SERVER['REQUEST_URI']) {
                $loc    = strpos($_SERVER['REQUEST_URI'], '?');
                $index  = false === $loc ? $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], 0, $loc);
            }
        }
        if(!$index || strrpos($index, '/') !== (strlen($index) - 1)) {
            $index      .= '/';
        }
        @define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . $index);

        return $this;
    }

    /**
     * 加载框架语言字典
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _loadFrameworkLangDict()
    {
        HTranslate::loadDict(ROOT_DIR . 'config/i18n/framework/hongjuzi.php');

        return $this;
    }

    /**
     * 重新导航
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $url 跳转链接
     */
    public function notFound()
    {
        if(false === IS_CLI) {
            HResponse::redirect(HResponse::url('error/notfound', '', 'public'));
            return;
        }
        echo sprintf("[%d]\tOops, the page has not found!", 404);
    }

    /**
     * 校对请求方式
     *
     * 支持CLI及浏览器的请求，自动切换
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return HApplication 当前请求对象
     */
    protected function _fixInvokeMethod()
    {
        if ($_SERVER['SERVER_ADDR'] || (substr(php_sapi_name(), 0, 3) != 'cli')) {
            return $this;
        }
        if(2 > count($_SERVER['argv'])) {
            throw new HVerifyException('Unknow Command, Usage: index.php app/model/action {QueryString}');
        }
        $_SERVER['REQUEST_METHOD']  = 'GET'; //一定要大写...
        $_SERVER['PATH_INFO']       = $_SERVER['argv'][1];
        if(isset($_SERVER['argv'][2])) {
            parse_str($_SERVER['argv'][2], $_GET);
            return $this;
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
        if(true === IS_CLI) { 
            echo sprintf("[%d]\t%s\n", $ex->status, $ex->getMessage());
            return;
        }
        try {
            HVerify::isAjax();
            HResponse::json(array('rs' => false, 'message' => $ex->getMessage(), 'status' => $ex->status));
        } catch(HVerifyException $e) {
            HResponse::alert($ex->getMessage(), -1, 2, $ex->status);
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
    protected function _doRouter()
    {
        $router     = HRouter::getInstance()->parseUrl(HObject::GC('URL_MODE'));
        HResponse::setAttribute('HONGJUZI_APP', $router->get('app'));
        HResponse::setAttribute('HONGJUZI_MODEL', $router->get('model'));
        HResponse::setAttribute('HONGJUZI_ACTION', strtolower($router->get('action')));
        unset($router);

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
    protected function _importModelActionFile()
    {
        //设置当前的主题
        $this->_setCurTheme();
        //开启模板类的插件机制
        $themeAction     = 'static/template/' . HResponse::getAttribute('HONGJUZI_APP') 
            . DS . HObject::GC('CUR_THEME') 
            . '/action/' . HResponse::getAttribute('HONGJUZI_MODEL') . 'action';
        if(file_exists($themeAction . '.php')) {
            HClass::import($themeAction);
            return $this;
        }
        HClass::import(
            'app.' .  HResponse::getAttribute('HONGJUZI_APP') 
            . '.action.'. HResponse::getAttribute('HONGJUZI_MODEL') . 'action'
        );

        return $this;
    }

    /**
     * 设置当前的模板主题
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _setCurTheme()
    {
        if('install' === HResponse::getAttribute('HONGJUZI_APP')) {
            return;
        }
        $where      =  '`app` = \'' . HResponse::getAttribute('HONGJUZI_APP') . '\'';
        $theme      = HClass::quickLoadModel('theme');
        if(!HRequest::getParameter('theme')) {
            $record  = $theme->getRecordByWhere('`status` = 3 AND ' . $where);
            if(!$record) {
                //如果没对应的主题，使用默认！
                HLog::write('网站还没有设置使用的主题，请您稍后再来！', HLog::$L_ERROR);
                return;
            }
            HObject::SC('CUR_THEME', $record['identifier']);
            return;
        }
        $record     = $theme->getRecordByWhere(
            '`identifier` = \'' . HRequest::getParameter('theme') . '\'' . ' AND ' . $where
        );
        if(!$record) {
            return;
        }
        HObject::SC('CUR_THEME', HRequest::getParameter('theme'));
    }

    /**
     * 调用请求的动作 
     * 
     * @access public
     */
    protected function _invokeAction()
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
    protected function _recordRequest()
    {
        if('POST' == $_SERVER['REQUEST_METHOD']) {
            return $this;
        }
        if(true === HVerify::isAjaxByBool()){
            return $this;
        }
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

    /**
     * 加载应用对应的语言配置文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return HApplication 当前应用
     */
    protected function _loadAppLangCfg()
    {
        HTranslate::loadDict(HResponse::getAttribute('HONGJUZI_APP'));

        return $this;
    }

}

?>
