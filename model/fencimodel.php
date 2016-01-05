<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

/**
 * 分词数据服务类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package model 
 * @since 1.0.0
 */
class FenciModel extends HObject
{

    /**
     * @var private $_fenci 分词对象
     */
    private $_fenci;

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_initFenciCfg();
    }

    /**
     * 初始化分词配置
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _initFenciCfg()
    {
        /*HClass::import('hongjuzi.filesystem.hdir');
        $utf8Dicts  = ROOT_DIR . 'vendor/scws/dict/utf8';
        if(file_exists($utf8Dicts)) {
            $files      = HDir::getFiles($utf8Dicts);
        }
        if(empty($files)) {
        }*/
        $files  = array(HResponse::path('vendor') . '/scws/dict.utf8.xdb');
        $this->_fenci = scws_open();
        scws_set_charset($this->_fenci, 'utf-8');
        foreach($files as $xdb) {
            scws_add_dict($this->_fenci, $xdb);
        }
        scws_set_rule($this->_fenci, HResponse::path('vendor') . '/scws/rules.utf8.ini');
        scws_set_ignore($this->_fenci, true);
        scws_set_duality($this->_fenci, false);
        scws_set_multi($this->_fenci, SCWS_MULTI_ZMAIN);
    }

    /**
     * 执行分词操作
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $content 需要分词的内容
     * @param  int $number 分出多少个，默认为：5
     * @return Array 分词结果 array(
     * array(1) {
     * array(4) {
             ["word"]=> string(6) "社交"
             ["times"]=> int(1)
             ["weight"]=> float(6.0599999427795)
             ["attr"]=> string(1) "n"
         }
      }
    */
    public function doFenci($content, $number = 5) 
    {
        scws_send_text($this->_fenci, $content);

        //return scws_get_result($this->_fenci);
        return scws_get_tops($this->_fenci, $number);
    }

}
