<?php
/**
 * @version			$Id: HObject.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @package 		hongjuzi.core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 框架基类 
 * 
 * 实现框架类的最基本的操作，如set, get方法 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.core
 * @since 			1.0.0
 */
class HObject
{

    /**
     * @var private static $_hconfigs 系统的配置
     */
    private static $_hConfigs   = null;

    /**
     * @var private static $_hconfigFilePath 配置文件路径
     */
    private static $_hConfigFilePath    = 'config/hconfig.php';

    /**
     * 得到配置项值的快捷调用方法 
     * 
     * 获取配置项的对应值内容 
     * 
     * @access public static
     * @param sting $configItem 配置项名称
     * @return mix
     */
    public static function GC($item = '')
    {
        return self::GCAttr($item);
    }

    /**
     * 得到配置项值的快捷调用方法 
     * 
     * 获取配置项的对应值内容 
     * 
     * @access public static
     * @param sting $configItem 配置项名称
     * @param String $attr 配置的属性
     * @return mix
     */
    public static function GCAttr($item = '', $attr = '')
    {
        if(empty($item) || !isset(self::$_hConfigs[$item])) {
            return null;
        }

        return empty($attr)  ? self::$_hConfigs[$item] : self::$_hConfigs[$item][$attr];
    }


    /**
     * 加载系统默认配置
     *
     * 获取配置项的对应值内容
     *
     * @access public static
     */
    public static function loadSysCfg()
    {
        //加载初始配置
        self::$_hConfigs    = require_once(ROOT_DIR . self::$_hConfigFilePath);
        //设置时区
        date_default_timezone_set(self::$_hConfigs['TIME_ZONE']);
    }

    /**
     * 加载应用配置
     *
     * 合并系统默认配置及应用于的独立的配置项的对应值内容
     *
     * @access public static
     */
    public static function loadAppCfg($app = null)
    {
        $app            = null === $app ? HResponse::getAttribute('HONGJUZI_APP') : $app;
        $appCfgPath     = ROOT_DIR . 'app/' . $app . DS . 'hconfig.php';
        if(file_exists($appCfgPath)) {
            self::$_hConfigs    = array_merge(self::$_hConfigs, require_once($appCfgPath));
        }
    }

    /**
     * 加载网站对应的配置
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $site 对应网站，默认为SITE_URL null，要包含http://www.xxx.com/
     */
    public static function loadSiteCfg($site = null)
    {
        if(IS_CLI) { return; }
        $site           = null === $site ? SITE_URL : $site;
        $site           = str_replace('http://', '', strtolower($site), $site);
        $site           = strtr($site, array('/' => '', '.' => '-'));
        $siteCfgPath    = ROOT_DIR . 'config/sites/' . $site . '.php';
        if(file_exists($siteCfgPath)) {
            self::$_hConfigs    = array_merge(self::$_hConfigs, require_once($siteCfgPath));
            return;
        }
        $content        = file_get_contents(ROOT_DIR . HObject::GC('CONFIG_TPL'));
        file_put_contents(
            $siteCfgPath, 
            strtr(
                $content, 
                array('{site_url}' => SITE_URL, '{site}' => $site, '{salt}' => HString::getUUID())
            )
        );
    }

    /**
     * 设置系统配置的快捷操作方法
     * 
     * @access public
     * @param string $item 配置项
     * @param mix $value 当前项的设置值
     */
    public function SC($item, $value)
    {
        self::$_hConfigs[$item]    = $value;
    }

    /**
     *  编辑配置文件 
     * 
     * 用法：
     * <code>
     *  HObject::EC();
     * </code> 
     * 
     * @access protected
     */
    public static function EC()
    {
        HFile::write(
            ROOT_DIR . self::$_hConfigFilePath,
            '<?php return ' . var_export(self::$_hConfigs, true) . '; ?>'
        );
    }

    /**
     * 错误信息控制器 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param int $errNo 错误的类型
     * @param string $errStr 错误信息
     * @param string $errFile 错误文件 
     * @param int $errLine 错误所在行号 
     * @param string $errContext 错误的具体内容
     * @return boolean
     */
    public static function errorHandler($errNo, $errStr, $errFile = '', $errLine = '', $errContext = '')
    {
        if(!error_reporting() && $errNo) {
            return ;
        }
        switch($errNo) {
            case E_USER_ERROR:
                echo "<b>My ERROR</b> [$errNo] $errStr<br />\n";
                echo "  Fatal error on line $errLine in file $errFile";
                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                echo "Aborting...<br />\n";
                exit(1);
                break;
            case E_USER_WARNING:
                echo "<b>My WARNING</b> [$errNo] $errStr<br />\n";
                break;
            case E_USER_NOTICE:
                echo "<b>My NOTICE</b> [$errNo] $errStr<br />\n";
                break;
            case 8:
                return true;
            default:
                //echo "Unknown error type: [$errNo] $errStr on line $errLine in file $errFile.<br />\n";
                break;
        }

        return true;
    }

    /**
     * 设置类中的属性 
     * 
     * 这里不管类中有没有对应的属性，都去动态的设置 
     * 
     * @access public
     * @param  string $property
     * @param  mix $value
     * @return HObject 对象自己
     */
    public function set($property, $value) 
    {
        $privateProperty            = '_' . $property;
        $this->$privateProperty     = $value;

        return $this;
    }

    /**
     * 得到类中的属性值 
     * 
     * 当类中有对应的定义时直接返回对应的值当没有时则
     * 返回一个 null 的对象 
     * 
     * @access public
     * @param string $property
     * @return mix | null 
     * @exception none
     */
    public function get($property)
    {
        $protectedProperty    = '_' . $property;
        if(isset($this->$protectedProperty)) {
            return $this->$protectedProperty;
        }

        return null; 
    }

}
?>
