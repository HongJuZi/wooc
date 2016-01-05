<?php

/**
 * @version			$Id: hini.php 1889 2012-05-20 06:47:59Z xjiujiu $
 * @create 			2012-3-29 15:27:12 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		filesystem
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * .ini文件的操作工具类
 * 
 * 实现对ini类型文件的解析，可生成对应的数组或是对象
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.filesystem
 * @since 			1.0.0
 */
class HIni extends HObject
{
    /**
     * @var string $_filePath 需要操作的ini文件路径
     */
    protected $_filePath;

    /**
     * @var string $_iniContent ini文件里的内容
     */
    protected $_iniContent;

    /**
     * @var stdClass | array $_iniResult ini内容的解析结果
     */
    protected $_iniResult;

    /**
     * 构造函数 
     * 
     * 初始化类中的属性 
     * 
     * @access public
     * @param string $filePath 文件路径
     * @return void
     * @exception none
     */
    public function __construct($filePath = '')
    {
        $this->_filePath    = $filePath;
        $this->_iniContent  = null;
        $this->_iniResult   = null;
        if(!empty($this->_filePath)) {
            $this->_loadFile();
        }
    }

    /**
     * 验证Ini文件 
     * 
     * 确定当前的ini文件是否可以操作 
     * 
     * @access protected
     * @return boolean 
     * @exception none
     */
    protected function _verifyIniFile()
    {
        if(empty($this->_filePath)) {
            return false;
        }
        HClass::import('hongjuzi.filesystem.HFile');
        if(!HFile::isExists($this->_filePath)) {
            return false;
        }

        return true;
    }

    /**
     * 加载ini文件
     * 
     * 加载指定的ini文件 
     * 
     * @access public
     * @param string $filePath 文件操作路径
     * @return void
     * @exception none
     */
    public function loadIniFile($filePath)
    {
        $this->_filePath    = $filePath;

        return $this->_loadFile();
    }

    /**
     * 加载ini文件 
     * 
     * 加载给定的ini文件 
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _loadFile()
    {
        if(false === $this->_verifyIniFile()) {
            throw new HIOException('文件不存在！' . $this->_filePath);
        }
        $this->_iniContent  = HFile::read($this->_filePath);

        return true;
    }

    /**
     * 加载ini字符串 
     * 
     * @desc
     * 
     * @access public
     * @param string $iniContent 加载指定的ini内容
     * @return void
     * @exception none
     */
    public function loadIniString($iniContent)
    {
        $this->_iniContent  = $iniContent;
    }

    /**
     * 格式化Ini的内容
     * 
     * 把/r/n的换行全换成/n的形式
     * 
     * @access protected
     * @return string
     * @exception none
     */
    protected function _formatIniContent()
    {
        return strtr($this->_iniContent, array("\r" => ''));
    }

    /**
     * 得到Ini的解析结果对象 
     * 
     * 以给定或文件名为名的ini解析对象 
     * 
     * @access public
     * @return stdClass 
     * @exception none
     */
    public function getIni() { }

    /**
     * 保存Ini文件 
     * 
     * 将给定的ini内容存到指定的文件中 
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function saveIni($filePath) { }

    /**
     * 得到配置块的内容 
     * 
     * 如：
     * <code>
     * ini 文件内容
     * [section1]
     * item1=value1
     * item2=value2
     * [section2]
     * item3=value3
     * item4=value4
     * 
     * </code> 
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function getSection($sectionName) { }

}

?>
