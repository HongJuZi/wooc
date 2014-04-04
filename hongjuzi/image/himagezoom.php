<?php

/**
 * @version			$Id$
 * @create 			2012-3-31 22:28:12 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HPATH_BASE') or die();

//导入图片工具父包
HClass::import('hongjuzi.image.HImage');

/**
 * 图片工具类 
 * 
 * 集成图片的缩放，水印，验证码等 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuz.image
 * @since 			1.0.0
 */
class HImageZoom extends HImage
{

    /**
     * @var string $_zoomImageMask 缩放图片的类型
     */
    protected $_zoomImageMask;

    /**
     * 构造函数 
     * 
     * 初始化类中的变量
     * 
     * @access public
     */
	public function __construct($imagePath = '', $savePath = '')
    {
        parent::__construct($imagePath, $savePath);
        
        $this->_zoomImageMask   = '';
    }
   
    /**
     * 缩放图片 
     * 
     * 把图片放大或是缩小，支持是否按比例 
     * 
     * @access public
     * @param int $width 图片的宽
     * @param int $height 图片的高
     * @param string $zoomImageMask 图片缩放类型
     * @param boolean $isScale 是否缩放
     * @exception HIOException 文件读写异常
     */
    public function zoom($width = 0, $height = 0, $zoomImageMask = '', $isScale = true)
    {
        //验证执行的条件
        $this->_verifyImageFile();
        $this->_zoomImageMask   = $zoomImageMask;
        $this->_soruce          = $this->_loadImageRes();
        if(($width || $height)) {
            $size       = $this->_getScaleSize($width, $height);
            $zoomImage  = $this->_createNewImage($size[0], $size[1]);
            $this->_outputImage($zoomImage, $this->_getZoomImageSavePath($width, $height));
            return;
        }
        $this->_outputImage($this->_soruce, $this->_getZoomImageSavePath($width, $height));
    }

    /**
     * 得到缩放的尺寸 
     * 
     * 根据要求的缩放宽高，计算出缩放后的真实宽高 
     * 
     * @access protected
     * @param int $width 目标宽
     * @param int $height 目标高
     */
    protected function _getScaleSize($width, $height)
    {
        $scale     = 1;
        if($width && $width < $this->_imageInfo['width']) {
            $scale     = $width / $this->_imageInfo['width'];
        }
        if($height && $height < $this->_imageInfo['height']) {
            $heightScale= $height / $this->_imageInfo['height'];
            $scale      = $scale < $heightScale ? $scale : $heightScale;
        }

        return array(
            intval($this->_imageInfo['width'] * $scale),
            intval($this->_imageInfo['height'] * $scale)
        );
    }

    /**
     * 得到缩放图片的保存路径
     * 
     * 根据设置的情况动态的生成，默认是当前的文件名加上缩放的宽高 
     * 
     * @access protected
     * @param int $width 指定的缩放宽
     * @param int $height 指定的缩放高
     * @return string 
     */
    protected function _getZoomImageSavePath($width, $height)
    {
        return $this->_getZoomImageSaveDir() . DS . $this->_getZoomImageName($width, $height);
    }

    /**
     * 得到图片存储的路径
     * 
     * 如果没有设置的话就直接放到当前操作文件目录了
     * 
     * @access protected
     * @return 图片目录名称
     */
    protected function _getZoomImageSaveDir()
    {
        return !empty($this->_saveImagePath) ? $this->_saveImagePath : dirname($this->_imagePath);
    }
 
    /**
     * 得到缩放图片的文件名 
     * 
     * 默认为在原名的后面加上缩放的大小，如：test.jpg -> test-400X300.jpg 
     * 
     * @access protected
     * @param int $width 设置的宽度
     * @param int $height 设置的高度
     * @return  string 缩放的图片名称
     */
    protected function _getZoomImageName($width, $height)
    {
        if(!empty($this->_zoomImageMask)) {
            return $this->_getImageName() . '-' . $this->_zoomImageMask . $this->_imageInfo['ext'];
        }
        if(!($width || $height)) {
            return $this->_getImageName() . '-zoom' . $this->_imageInfo['ext'];
        }

        return $this->_getImageName() . '-' . $width . 'x' . $height . $this->_imageInfo['ext'];
    }

    /**
     * 计算宽，高比率 
     * 
     * 计算给定两数的比例值 
     * 
     * @access protected
     * @param int $setValue 设定的值
     * @param int $realValue 实际值
     * @return float 比率值
     */
    protected function _countScale($setValue, $realValue)
    {
        return $setValue / $realValue;
    }

}
?>
