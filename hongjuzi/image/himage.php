<?php

/**
 * @version			$Id: HImage.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-31 22:28:12 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die();

/**
 * 图片工具类 
 * 
 * 集成图片的缩放，水印，验证码等 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.image
 * @since 			1.0.0
 */
class HImage extends HObject
{

    /**
     * @var string $_imagePath 图片路径
     */
    protected $_imagePath;

    /**
     * @var string $_savePath 处理后的文件存储位置 
     */
    protected $_savePath;

    /**
     * @var resource $_soruce 打开的图片资源
     */
    protected $_soruce;

    /**
     * @var protected $_imageInfo 图片信息容器，宽度、高度、类型、扩展名
     */
    protected $_imageInfo;

    /**
     * 构造函数 
     * 
     * 初始化类中的变量
     * 
     * @access public
     */
	public function __construct($imagePath = '', $savePath = '')
    {
        $this->_soruce        = null;
        $this->_imagePath     = $imagePath;
        $this->_saveImagePath =  HString::formatEncodeToOs($savePath);
        $this->_initImageInfo();
    }

   /**
     * 初始化图片信息 
     * 
     * @desc 
     * 
     * @access protected
     */
    protected function _initImageInfo()
    {
        if(empty($this->_imagePath)) {
            return;
        }
        $info   = getimagesize($this->_imagePath);
        $mime   = $info['mime'];
        $mime   = explode('/',$mime);
        $this->_imageInfo['width']  = $info[0];
        $this->_imageInfo['height'] = $info[1];
        $this->_imageInfo['type']   = $mime[1] == 'vnd.wap.wbmp' ? 'xbmp' : $mime[1];
        $this->_imageInfo['ext']    = HFile::getExtension($this->_imagePath);
    }
  
    /**
     * 得到图片资源 
     * 
     * 就类似于打开文件，把文件加载到内存中 
     * 
     * @access protected
     * @param string $imagePath 需要处理的图片路径
     * @exception HVerifyException 验证异常
     */
    protected function _loadImageRes()
    {
        $createFunc     = 'imagecreatefrom' . $this->_imageInfo['type'];
        if(function_exists($createFunc)) {
            return $createFunc($this->_imagePath);
        }
        throw new HVerifyException('Image type not support!' . $this->_imageInfo['type']);
    }

    /**
     * 创建新的图像
     * 
     * 根据设定的宽，高创建新的图像 
     * 
     * @access protected
     * @param int $newWidth 新的宽
     * @param int $newHeight 新的高
     * @return resource 创建的新图片资源对象
     */
    protected function _createNewImage($newWidth, $newHeight)
    {
        if(function_exists('imagecopyresampled')) {
            $outImg  = imagecreatetruecolor($newWidth, $newHeight);
            imagesavealpha($this->_source, true);
            imagealphablending($outImg, false);
            imagesavealpha($outImg, true);
            imagecopyresampled(
                $outImg, $this->_soruce,
                0, 0, 0, 0,
                $newWidth, $newHeight,
                $this->_imageInfo['width'], $this->_imageInfo['height']
            );

            return $outImg;
        }
        $outImg  = imagecreate($newWidth, $newHeight);
        imagecopyresized(
            $outImg, $this->_soruce,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $this->_imageInfo['width'], $this->_imageInfo['height']
        );

        return $outImg;
    }

    /**
     * 留白的方式来创建图片
     * 
     * 在保持图片大小不变的情况下空出来的内容留白处理
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $position 居中坐标
     * @param  $nSize 新的尺寸
     * @param  $tSize 位移尺寸
     */
    protected function _createNewImageByFillWhite($position, $nSize, $tSize)
    {
        if(function_exists('imagecopyresampled')) {
            $outImg     = imagecreatetruecolor($nSize['width'], $nSize['height']);
            $white      = imagecolorallocate($outImg, 255, 255, 255);
            imagefill($outImg, 0, 0, $white);
            imagecopyresampled(
                $outImg, $this->_soruce,
                $position['x'], $position['y'], 0, 0,
                $tSize['width'], $tSize['height'],
                $this->_imageInfo['width'], $this->_imageInfo['height']
            );

            return $outImg;
        }
        $outImg  = imagecreate($nSize['width'], $nSize['height']);
        imagecopyresized(
            $outImg, $this->_soruce,
            $position['x'], $position['y'], 0, 0,
            $tSize['width'], $tSize['height'],
            $this->_imageInfo['width'], $this->_imageInfo['height']
        );

        return $outImg;
    }

    /**
     * 设置图片的背景颜色 
     * 
     * 可以手动指定各种着色值 
     * 
     * @access protected
     * @param int $r 红色部分, 默认值为：255
     * @param int $g 绿色部分, 默认值为：255
     * @param int $b 蓝色部分, 默认值为：255
     */
    protected function _setImageBackground($r = 255, $g = 255, $b = 255)
    {
        imagecolorallocate($this->_soruce, $r, $g, $b);
    }

    /**
     * 得到随机颜色 
     * 
     * @access protected
     * @return 颜色对象
     */
    protected function _getRandColor()
    {
        return  imagecolorallocate($this->_soruce, rand(0, 100), rand(0, 150), rand(0, 200));
    }

    /**
     * 得到字体 
     * 
     * 根据项目的字体配置 
     * 
     * @access protected
     * @param string $fontName 使用的字体名称
     * @return array | null 
     */
    protected function _getFont($fontName)
    {
        $fonts   = HObject::GC('fonts');
        if(isset($fonts[$fontName])) {
            return $fonts[$fontName];
        }
        throw new HVerifyException('Can not find any fonts in the configure file!');
    }

    /**
     * 输出图片 
     * 
     * 根据给定的图片资源，输出图片到目标目录 
     * 
     * @access protected
     * @param resource $soruce 图片资源
     * @param string $imagePath 图片路径
     * @param int $file 是否输出文件
     * @exception HVerifyException 验证异常
     */
    protected function _outputImage($image, $imagePath, $file = true)
    {
        $imageFunc  = 'image' . $this->_imageInfo['type'];
        if(!function_exists($imageFunc)) {
            throw new HVerifyException('不支持输出当前图片类型！' . $this->_imageInfo['type']);
        }
        if($file) {
            'jpeg' === $this->_imageInfo['ext'] ? $imageFunc($image, $imagePath, 80) : $imageFunc($image, $imagePath);
        } else {
            header('Content-type: image/' . $this->_imageInfo['type']);
            'jpeg' === $this->_imageInfo['ext'] ? $imageFunc($image, 80) : $imageFunc($image);
        }
        imagedestroy($image);
        imagedestroy($this->_soruce);
    }

    /**
     * 验证类执行条件是否满足条件 
     * 
     * 看一下执行的条件是否满足，如操作的文件是否存在等 
     * 
     * @access protected
     * @return boolean 文件是否存在
     */
    protected function _verifyImageFile()
    {
        if(!file_exists($this->_imagePath)) {
            throw new HIOException('找不到指定的图片!' . $this->_imagePath);
        }
        $info = pathinfo($this->_imagePath);
        if(!is_writeable($info['dirname'])){
            throw new HIOException('文件目录不可写!' . $info['dirname']);
        }
    }

    /**
     * 得到图片名称 
     * 
     * @access protected
     * @param string $imagePath 需要处理的图片路径
     * @return string 当前文件名称
     */
    protected function _getImageName($iamgePath = '')
    {
        $imagePath  = empty($imagePath) ? $this->_imagePath : $imagePath;
    
        return HFile::getName($imagePath);
    }

}
?>
