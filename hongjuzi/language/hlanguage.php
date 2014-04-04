<?php

/**
 * @version			$Id: hlanguage.php 1889 2012-05-20 06:47:59Z xjiujiu $
 * @create 			2012-2-27 11:24:38 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		language
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die();

/**
 * 语言国际化类 
 * 
 * 根据配置得到不同的配置 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 	    hongjuzi.language	
 * @since 			1.0.0
 */
class HLanguage extends HObject 
{

    /**
     * @var Object static $_instance 实例
     */
    private static $_instance   = null;

    /**
     * @var Array $_langCfg 语言的配置
     */
    protected $_langCfg;

    /**
     * @var Map $_languages 语言窗口
     */
    protected static $_languages;

    /**
     * 构造函数 
     * 
     * 初始化类中的变量, 得到当前所设置的语言类型 
     * 
     * @access private 
     */
     private function __construct($langCfg)
     {
        self::$_languages   = array();
        $this->_langCfg     = $langCfg;
        $this->_initLoadLangCfgFiles();
     }

    /**
     * 初始化加载语言配置文件 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return void
     */
    protected function _initLoadLangCfgFiles()
    {
        if(isset($this->_langCfg['INIT'][$_GET['HONGJUZI_APP']])) {
            foreach($this->_langCfg['INIT'][$_GET['HONGJUZI_APP']] as $model) {
                $this->_loadLanguageCfgFile($model);
            }
        }
    }

    /**
     * 得到语言实例的唯一入口 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  Array $langCfg 语言配置
     * @return Object HLanguage 语言实例 
     */
    public static function getInstance($langCfg)
    {
        if(null == self::$_instance) {
            self::$_instance    = new HLanguage($langCfg);
        }

        return self::$_instance;
    }

    /**
     * 得到当前标记对应的当前语言
     * 
     * 只用给对应的占位标记 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $mask 语言标记
     * @param  String $model 模型
     * @param  String $app 应用
     * @return String 查找到的语言值 
     */
    public function getLanguage($mask, $model = '')
    {
        $this->_loadLanguageCfgFile($model);
        if(isset($mask, self::$_languages[$_GET['HONGJUZI_APP']])) {
            return self::$_languages[$_GET['HONGJUZI_APP']][$mask];
        }

        return $mask;
    }

    /**
     * 加载语言的配置文件 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $model 当前的模块
     * @param  String $app 当前的应用
     */
    protected function _loadLanguageCfgFile($model)
    {
        if(empty($model)) {
            return ;
        }
        static $isLoadedFiles   = array();
        $langCfgPath            = $this->_getLanguageCfgFilePath($model);
        $pathHash               = md5($langCfgPath);
        if(array_key_exists($pathHash, $isLoadedFiles)) {
            return ;
        }
        if(!HFile::isExists($langCfgPath)) {
            throw new Exception('找不到对应的语言配置文件！' . $langCfgPath);
        }
        $isLoadedFiles[$pathHash]                   = 1;
        $lang                                       = require_once($langCfgPath);
        self::$_languages[$_GET['HONGJUZI_APP']]    = !isset(self::$_languages[$_GET['HONGJUZI_APP']]) ? $lang : array_merge(
            $lang,
            self::$_languages[$_GET['HONGJUZI_APP']]
        ); 
    }

    /**
     * 得到语言配置文件路径 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $model 当前的模块名称
     * @return String 语言的路径
     */
    protected function _getLanguageCfgFilePath($model)
    {
        return ROOT_DIR . DS . $this->_langCfg['LANG_DIR']
            . DS . $this->_langCfg['LANG_CUR']
            . DS . $_GET['HONGJUZI_APP'] . DS . $model . '.lang.php';
    }

}

?>
