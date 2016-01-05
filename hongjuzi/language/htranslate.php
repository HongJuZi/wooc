<?php

/**
 * @version			$Id: hlanguage.php 1889 2012-05-20 06:47:59Z xjiujiu $
 * @create 			2012-2-27 11:24:38 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		language
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 语言翻译国际化类 
 * 
 * 根据配置得到不同的配置 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 	    hongjuzi.language	
 * @since 			1.0.0
 */
class HTranslate extends HObject 
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
     * @param  String $mark 语言标记
     * @param  String $model 模型
     * @param  String $app 应用
     * @return String 查找到的语言值 
     */
    public function getLanguage($mark, $model = '')
    {
        $this->_loadLanguageCfgFile($model);
        if(isset($mark, self::$_languages[$_GET['HONGJUZI_APP']])) {
            return self::$_languages[$_GET['HONGJUZI_APP']][$mark];
        }

        return $mark;
    }

    /**
     * 加载语言的配置文件 
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
        if(!isset(self::$_languages[$_GET['HONGJUZI_APP']])) {
            self::$_languages[$_GET['HONGJUZI_APP']]    = $lang;
            return;
        }
        self::$_languages[$_GET['HONGJUZI_APP']]        = array_merge(
            $lang,
            self::$_languages[$_GET['HONGJUZI_APP']]
        ); 
    }

    /**
     * 得到语言配置文件路径 
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

    /**
     * @var private static $_dict 语言字典容器
     */
    private static $_dict;

    /**
     * 加载语言字典文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $file 当前的语言库文件
     */
    public static function loadDictByApp($app, $lang)
    {
        $appLangFile   = ROOT_DIR . 'config/i18n/' . $lang . '/' . $app . '/' . $app . '.php';

        return self::loadDict($appLangFile);
    }

    /**
     * 加载指定的字典文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $file 文件路径
     * @return 应用对象
     */
    public static function loadDict($file)
    {
        if(file_exists($file)) {
            self::$_dict    = self::$_dict ? array_merge(self::$_dict, require_once($file)) : require_once($file);
        }

        return $this;
    }

    /**
     * 得到当前的语言信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $mark 语言标记操作
     */
    public static function translate($mark, $echo = true)
    {
        //$markId = self::_addMark($mark);
        //$tplId  = self::_addTpl();
        //self::_addTplAndMarkLinkeddata($markId, $tplId);
        if(isset(self::$_dict[$mark])) {
            if(true == $echo) {
                echo self::$_dict[$mark];
                return;
            }
            return self::$_dict[$mark];
        }
        if(true !== $echo) {
            return $mark;
        }

        echo $mark;
    }

    /**
     * @var private static $_linkedData     关联数据操作对象
     */
    private static $_linkedData     = null;

    /**
     * 添加模板及标识的关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private static
     * @param $markId 标识编号
     * @param  $tplId  模板编号
     */
    private static function _addTplAndMarkLinkeddata($markId, $tplId)
    {
        if(!$markId || !$tplId) {
            return;
        }
        if(self::$_linkedData === null) {
            self::$_linkedData  = HClass::quickLoadModel('linkeddata');
        }
        self::$_linkedData->setRelItemModel('tpl', 'mark');
        $data   = array(
            'item_id' => $markId,
            'rel_id' => $tplId
        );
        $record     = self::$_linkedData->getRecordByWhere('`item_id` = ' . $markId . ' AND `rel_id` = ' . $tplId);
        if($record) {
            return;
        }
        if(1 > self::$_linkedData->add($data)) {
            throw new HRequestException('添加关联数据失败！');
        }
    }

    /**
     * @var private static $_tpl    模板对象
     */
    private static $_tpl    = null;

    /**
     * 加入模板
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private static
     */
    private static function _addTpl()
    {
        if(null === self::$_tpl) {
            self::$_tpl    = HClass::quickLoadModel('tpl');
        }
        $data   = array(
            'app' => HResponse::getAttribute('HONGJUZI_APP'),
            'name' => HResponse::getAttribute('HONGJUZI_MODEL') 
            . '-' . HResponse::getAttribute('HONGJUZI_ACTION')
        );
        $data   = array_filter($data);
        if(2 != count($data)) {
            return null;
        }
        $where  = '`name` = \'' . $data['name']. '\' AND `app` = \'' . $data['app'] . '\'';
        $record = self::$_tpl->getRecordByWhere($where);
        if($record) {
            return $record['id'];
        }
        $id     = self::$_tpl->add($data);
        if(1 > $id) {
            throw new HRequestException('添加模板失败!');
        }

        return $id;
    }

    /**
     * @var private static $_mark 标识对像
     */
    private static $_mark = null;

    /**
     * 添加标识
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     * @param $mark 标识
     */
    protected static function _addMark($mark)
    {
        if(null === self::$_mark) {
            self::$_mark    = HClass::quickLoadModel('mark');
        }
        if(!$mark) {
            return;
        }
        $record = self::$_mark->getRecordByWhere('`name` = \'' . $mark . '\'');
        if($record) {
            return $record['id'];
        }
        $data   = array(
            'name' => $mark,
            'author' => 0
        );
        $id     = self::$_mark->add($data);
        if(1 > $id) {
            throw new HVerifyException(HTranslate::__('添加语言标识失败'));
        }

        return $id;
    }

    /**
     * 翻译输出快捷方法
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $mark 标识
     */
    public static function _($mark)
    {
        self::translate($mark, true);
    }

    /**
     * 翻译返回快捷方法
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $mark 标识
     * @return String 翻译
     */
    public static function __($mark)
    {
        return self::translate($mark, false);
    }

}

?>
