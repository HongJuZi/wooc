<?php

/**
 * @version			$Id$
 * @create 			2012-3-29 15:27:12 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		filesystem
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

HClass::import('hongjuzi.filesystem.HIni');

/**
 * .ini文件解析成对象工具类
 * 
 * 实现对ini类型文件的解析，可生成对应的数组或是对象
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.filesystem
 * @since 			1.0.0
 */
class HIniObject extends HIni
{
    /**
     * {@inheritDoc}
     */
    public function __construct($filePath = '')
    {
        parent::__construct($filePath);
    }

    /**
     * 解析当前的ini文件内容成对象 
     * 
     * 把当前的ini文件内容解析成所想要的格式 
     * 
     * @access protected
     * @return stdClass 
     * @exception none
     */
    protected function _parseIni()
    {
        $iniContent     = $this->_formatIniContent();
        $this->_iniResult = new StdClass();
        $rows           = explode("\n", $iniContent);
        $sectionName    = 'default';
        $this->_iniResult->default   = array();
        foreach($rows as $row) {
            $row        = trim($row);
            if(empty($row) || $row{0} == ';') {
                continue;
            }
            if($row{0} === '[') {
                $sectionName    = mb_substr($row, 1, -1, 'utf8');
                $this->_iniResult->$sectionName  = array();
            } else {
                list($item, $value)         = explode('=', $row);
                $this->_iniResult->{$sectionName}[rtrim($item)]     = ltrim($value);
            } 
        }

        return $this->_iniResult;
    }

    /**
     * {@inheritDoc}
     */
    public function getIni()
    {
        return $this->_parseIni();
    }

    /**
     * {@inheritDoc}
     */
    public function saveIni($filePath = '')
    {
        $filePath   = empty($filePath) ? $this->_filePath : $filePath;
        
        return HFile::write($filePath, $this->_iniContent);
    }

    /**
     * {@inheritDoc}
     */
    public function getSection($sectionName)
    {
        if(isset($this->_iniResult->{$sectionName})) {
            return $this->_iniResult->{$sectionName};
        }

        return null;
    }

}

?>
