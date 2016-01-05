<?php

/**
 * @version			$Id: HZip.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-31 9:23:37 By xjiujiu
 * @package 		hongjuzi.filesystem
 * @subpackage 		archive
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * Zip的工具类 
 * 
 * 包括解、压zip包 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.filesystem.archive
 * @since 			1.0.0
 */
class HZip
{

    /**
     * @var ZipArchive $_zip ZipArchive实例
     */
    protected $_zip;

    /**
     * @var string $_filePath zip文件路径
     */
    protected $_filePath;

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     * @param string $filePath zip文件路径
     * @return void
     * @exception none
     */
    public function __construct($filePath)
    {
        $this->_zip         = new ZipArchive();
        $this->_filePath    = $filePath;
    }

    /**
     * 压缩文件 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function zip($fileList, $overwrite = false)
    {
        if(file_exists($this->_filePath) && !$overwrite) {
            return true;
        }
        if(!is_array($fileList)) {
            $fileList   = array($fileList);
        }
        if(true !== $this->_zip->open($this->_filePath,
           $overwrite ? ZipArchive::CREATE : ZipArchive::OVERWRITE)) {
            HLog::logger('Open zip file error!');
           return false;
        }
        HObject::import('hongjuzi.filesystem.HFile');
        foreach($fileList as $file) {
            $this->_zip->addFile($file, HFile::getFileBaseName($file));
        }
        $this->_zip->close();

        return file_exists($this->_filePath);
    }

    /**
     * 解压文件 
     * 
     * @desc
     * 
     * @access public
     * @param string $descPath 目标目录
     * @return void
     * @exception none
     */
    public function unzip($descPath = '.')
    {
        if(!file_exists($this->_filePath)) {
            HLog::logger('The zip file is not exists!');
            return false;
        }
        if(!file_exists($descPath)) {
            HLog::logger('The desc path is not exists!');
            return false;
        }
        if(!($this->_zip->open($this->_filePath))) {
            return false;
        }
        $this->_zip->extractTo($descPath);
        $this->_zip->close();

        return true;
    }

}
?>
