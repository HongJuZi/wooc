<?php

/**
 * @version			$Id$
 * @create 			2012-3-31 22:28:12 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die();

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
     * @var string $_zoomType 缩放图片的类型
     */
    protected $_zoomType;

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
        
        $this->_zoomType   = '';
    }
   
    /**
     * 缩放图片 
     * 
     * 把图片放大或是缩小，支持是否按比例 
     * 
     * @access public
     * @param int $width 图片的宽
     * @param int $height 图片的高
     * @param string $type 图片缩放类型
     * @param $isFile 是否为文件
     * @exception HIOException 文件读写异常
     */
    public function zoom($width = 300, $height = 320, $type = '', $isFile = true)
    {
        //验证执行的条件
        $this->_verifyImageFile();
        $this->_soruce  = $this->_loadImageRes();
        $path           = $this->_getZoomImageSavePath($width, $height, $type);
        if(($width || $height)) {
            $size       = $this->_getScaleSize($width, $height);
            $zoomImage  = $this->_createNewImage($size[0], $size[1]);
            $this->_outputImage($zoomImage, $path, $isFile);
            return;
        }
        $this->_outputImage($this->_soruce, $path, $isFile);
    }

    /**
     * 留白缩放
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $width = 400 指定宽度，默认为400
     * @param $height = 300 指定高度，默认为300
     * @param $type 缩放类型
     * @param $isFile 是否生成文件
     */
    public function zoomByFillWhite($width = 400, $height = 300, $type = '', $isFile = true)
    {
        //验证执行的条件
        $this->_verifyImageFile();
        $this->_soruce          = $this->_loadImageRes();
        $oWidth                 = $this->_imageInfo['width'];
        $oHeight                = $this->_imageInfo['height'];
        $oRate                  = $oWidth / $oHeight;
        $nRate                  = $width / $height;
        $tSize['width']         = $width;
        $tSize['height']        = $height;
        $position['x'] = $position['y'] = 0;
        if($oRate > 1 && $nRate >= 1){
            if($oRate > $nRate){
                $tSize['height']    = ceil($tSize['width'] / $oRate);
                $position['y']      = ceil(($height - $tSize['height']) / 2);
            } elseif($oRate < $nRate) {
                $tSize['width']     = ceil($oRate * $tSize['height']);
                $position['x']      = ceil(($width - $tSize['height']) / 2);
            }
        } elseif($oRate > 1 && $nRate < 1) {
            $tSize['height']        = ceil($tSize['width']/$oRate);
            $position['y']          = ceil(($height-$tSize['height']) / 2);
        } elseif($oRate < 1 && $nRate >=1 ) {
            $tSize['width']         = ceil($oRate * $tSize['height']);
            $position['x']          = ceil(($width - $tSize['width']) / 2);
        } elseif( $oRate < 1 && $nRate < 1) {
            if($oRate > $nRate){
                $tSize['height']    = ceil($tSize['width'] / $oRate);
                $position['y']      = ceil(($height - $tSize['height']) / 2);
            }elseif($oRate < $nRate) {
                $tSize['width']     = ceil($oRate * $tSize['height']);
                $position['x']      = ceil(($width - $tSize['width']) / 2);
            }
        }
        $path           = $this->_getZoomImageSavePath($width, $height, $type);
        if(($width || $height)) {
            $this->_outputImage(
                $this->_createNewImageByFillWhite(
                    $position, 
                    array('width' => $width, 'height' => $height),
                    $tSize
                ),
                $path,
                $isFile
            );
            return;
        }
        $this->_outputImage($this->_soruce, $path, $isFile);
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
     * @param $type 缩放类型
     * @return string  生成的路径
     */
    protected function _getZoomImageSavePath($width, $height, $type = '')
    {
        return $this->_getZoomImageSaveDir() . DS . $this->_getZoomImageName($width, $height, $type);
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
    protected function _getZoomImageName($width, $height, $type = '')
    {
        if($type) {
            return $this->_getImageName() . '-' . $type . $this->_imageInfo['ext'];
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
