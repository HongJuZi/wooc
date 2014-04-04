<?php 

/**
 * @version			$Id: huploader.php 2053 2012-08-05 07:13:54Z xjiujiu $
 * @create 			2012-3-28 11:38:29 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		net
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die();

/**
 * 上传工具类 
 * 
 * 支持多文件上传 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.net
 * @since 			1.0.0
 */
class HUploader extends HObject
{

    /**
     * @var array $_uploadFile 需要上传的文件信息
     */
    protected $_uploadFile;
        
    /**
     * @var string $_savePath 上传的存储路径
     */
    protected $_savePath;

    /**
     * @var float $_maxFileSize 允许的文件最大值，单位:MB
     */
    protected $_maxFileSize;

    /**
     * @var array $_supportFileType 允许的文件类型
     */
    protected $_supportFileType;

    /**
     * @var string $_baseDir 上传目录的根目录
     */
    protected $_baseDir;

    /**
     * @var string $_encodeFileName 对文件名进行编码的方式，用于处理中文
     */
    protected $_encodeFileName;

    /**
     * @var array $_uploadFileInfo 上传成功的文件路径及错误信息存储器
     * 
     * 以上传文件的文件名为键
     */
    protected $_uploadedFileInfo;

    /**
     * 构造函数 
     * 
     * 初始化类的变量 
     * 
     * @access public
     * @param string $savePath 存储的文件夹路径
     * @param float $maxFileSize 支持的上传文件的最大长度, 单位为M
     * @param string $baseDir 上传文件的根目录
     * @param string | array $supportFileType 支持的文件类型
     * @param string $baseDir 上传文件根目录，用于一时上传多个文件
     * @param string $encodeFileName 给文件名加密的方式
     */
    public function __construct($savePath, $maxFileSize, $supportFileType, $baseDir = '', $encodeFileName = '')
    {
        $this->_uploadFile      = null;
        $this->_savePath        = $savePath;
        $this->_maxFileSize     = $maxFileSize * 1024 * 1024;
        $this->_baseDir         = $baseDir;
        $this->_encodeFileName  = $encodeFileName;
        $this->_genSupportFileType($supportFileType);
        $this->_uploadFilePath  = array();
    }

    /**
     * 生成对应于程序识别后的文档类型 
     * 
     * @desc
     * 
     * @access protected
     * @param string | array $supportFileType 支持的文件类型
     */
    protected function _genSupportFileType($supportFileType)
    {
        if($supportFileType === '*') {
            $this->_supportFileType     = '*';
            return;
        }
        HClass::import('hongjuzi.net.HContentType');
        $this->_supportFileType     = !is_array($supportFileType) ? array($supportFileType) : $supportFileType;
        foreach($this->_supportFileType as $fileType) {
            $this->_supportFileType[$fileType]   = HContentType::getContentType($fileType);
        }
    }

    /**
     * 执行上传动作 
     * 
     * @desc
     * 
     * @access public
     * @param resource $uploadFile 资源文件
     * @param boolean $isGenDateDir 生成日期目录，默认为：true
     * @return array 
     */
    public function uploader($uploadFile, $isGenDateDir = true)
    {
        $isGenDateDir       = false !== $isGenDateDir ? true : false;
        $this->_uploadFile  = $uploadFile;

        if(!isset($this->_uploadFile['name']) ||
            empty($this->_uploadFile['name'])) {
            return array('error' => '');
        }
        if($this->_uploadFile['error']) {
            return array('error' => '文件上传有错！');
        }
        if(false == $this->_verifyFileSize()) {
            return array('error' => '文件太大！');
        }
        if(false == $this->_verifyFileType()) {
            return array('error' => '文件类型不支持！');
        }
        $savePath   = $this->_genSaveFolder($isGenDateDir);
        if(null === $savePath) {
            return array('error' => '上传目录生成失败！');
        }
        $descPath   = $savePath . DS . $this->_encodeFileName();
        if(!move_uploaded_file($this->_uploadFile['tmp_name'],
           $this->_baseDir . DS . HString::formatEncodeToOs($descPath))) {
            return array('error' => '文件上传失败！');
        }

        return array('path' =>  $descPath);
    }

    /**
     * 验证文件的大小 
     * 
     * @desc  
     * 
     * @access protected
     */
    protected function _verifyFileSize()
    {
        if($this->_uploadFile['size'] > $this->_maxFileSize) {
            return false;
        }

        return true;
    }

    /**
     * 检测上传的文件类型是否合法 
     * 
     * @desc
     * 
     * @access protected
     */
    protected function _verifyFileType()
    {
        if($this->_supportFileType === '*') {
            return true;
        }
        $fileType   = strtolower(HFile::getExtension($this->_uploadFile['name']));
        if(isset($this->_supportFileType[$fileType])) {
            if(false !== strpos($this->_supportFileType[$fileType], $this->_uploadFile['type'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * 生成对应的存储文件夹路径
     * 
     * @desc
     * 
     * @access protected
     * @param boolean $isGenDateDir 是否生成当前的日期目录
     * @return string | null 
     * @exception none
     */
    protected function _genSaveFolder($isGenDateDir)
    {
        HClass::import('hongjuzi.filesystem.HDir');
        $datePath   = $isGenDateDir === true ? date('Ymd') : '';
        try {
            HDir::create($this->_baseDir . DS . $this->_savePath . DS . $datePath);
            return $this->_savePath . DS . $datePath; 
        } catch(HIOException $ex) {
            HLog::write($ex->getMessage(), HLog::L_WARN);
            return null;
        }
        
    }

    /**
     * 生成文件存储的路径
     * 
     * 这里根据文件夹生成的策略：是按日期还是其它的方式；
     * 及是否对文件名进行加密，方式有：MD5, Base64, 正常 
     * 
     * @access protected
     * @return String | null 当前文件需要存到的文件路径
     * @exception none
     */
    protected function _encodeFileName()
    {
        switch($this->_encodeFileName) {
            case 'md5': 
                return $this->_encodeFileNameByMD5($this->_uploadFile['name']);
                break;
            case 'base64':
                return $this->_encodeFileNameByBase64($this->_uploadFile['name']);
            default:
                return $this->_encodeFileNameByTime($this->_uploadFile['name']);
        }
    }

    /**
     * 使用MD5来加密当前的文件名 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $fileName 需要加密的文件名
     * @return String 处理后的文件名 
     * @throws none
     */
    protected function _encodeFileNameByMD5($fileName)
    {
        return md5(HFile::getName($fileName)) . HFile::getExtension($fileName);
    }

    /**
     * 使用base64_encode的方式来加密当前的文件名 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $fileName 需要处理的文件名
     * @return String 处理后的文件名 
     * @throws none
     */
    protected function _encodeFileNameByBase64($fileName)
    {
        return base64_encode(HFile::getName($fileName)) . HFile::getExtension($fileName);
    }

    /**
     * 加密文件名通过当前的时间截 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $fileName 当前的文件
     * @return String 处理后的文件名 
     * @throws none
     */
    protected function _encodeFileNameByTime($fileName)
    {
        return  mktime() . rand() * 100 . HFile::getExtension($fileName);
    }

}

?>
