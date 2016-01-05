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

//定义水印的样式
define('MASK_TOP', 1);
define('MASK_RIGHT_TOP', 2);
define('MASK_RIGHT', 3);
define('MASK_RIGHT_DOWN', 4);
define('MASK_DOWN', 5);
define('MASK_LEFT_DOWN', 6);
define('MASK_LEFT', 7);
define('MASK_LEFT_TOP', 8);
define('MASK_CENTER', 9);

/**
 * 图片工具类 
 * 
 * 集成图片的缩放，水印，验证码等 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.image
 * @since 			1.0.0
 */
class HImageMask extends HImage
{

    /**
     * 添加文字水印 
     * 
     * 将给定的文字加到图片中 
     * 
     * @access public
     * @param string $content 文字内容
     * @param int $location 水印的位置，默认为：MASK_RIGHT_DOWN
     * @param string $fontName 字体名，默认为：fangzhenzhongqian
     * @param string $savePath 保存的路径
     * @param int $fontSize 字体大小，默认为：16px
     * @return boolean
     * @exception none
     */
    public function maskText($content, $savePath, $location = MASK_RIGHT_DOWN, $fontName = 'fangzhenzhongqian', $fontSize = 16)
    {
        $this->_verifyImageFile();
        $this->_soruce    = $this->_loadImageRes();
        $maskFont   = $this->_getFont($fontName);
        if(!file_exists(ROOT_DIR . $maskFont['path'])) {
            throw new HVerifyException('没有找到对应的水印字体！' . $maskFont);
        }
        $position   = $this->_getPosition($location, $fontSize * strlen($content), $fontSize);
        $angle  = 0;
        imagettftext(
            $this->_soruce,
            $fontSize,
            $angle,
            $position[0], $position[1],
            $this->_getRandColor(),
            ROOT_DIR . $maskFont['path'],
            $content
        );
        $this->_outputImage($this->_soruce, $savePath);

        return true;
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

        return null;
    }

    /**
     * 得到水印位置 
     * 
     * 根据字体的长度，及设置的Location标识计算得到 
     * 
     * @access protected
     * @param int $location Location标识
     * @param int $maskWidth 水印的宽
     * @param int $maskHeight 水印的高 
     * @return array 
     */
    protected function _getPosition($location, $maskWidth, $maskHeight)
    {
        static $marginTop   = 5;    //顶边间距
        static $marginLeft  = 5;    //左部间距
        switch($location) {
            case MASK_TOP:
                $x  = ($this->_imageInfo['width'] - $maskWidth) / 2;
                $y  = $marginTop + $maskHeight;
                break;
            case MASK_RIGHT_TOP:
                $x  = $this->_imageInfo['width'] - $marginLeft - $maskWidth;
                $y  = $marginTop + $maskHeight;
                break;
            case MASK_RIGHT:
                $x  = $this->_imageInfo['width'] - $marginLeft - $maskWidth;
                $y  = ($this->_imageInfo['height'] - $maskHeight) / 2; 
                break;
            case MASK_RIGHT_DOWN:
                $x  = $this->_imageInfo['width'] - $marginLeft - $maskWidth;
                $y  = $this->_imageInfo['height'] - $marginTop;
                break;
            case MASK_DOWN:
                $x  = ($this->_imageInfo['width'] - $maskWidth) / 2;
                $y  = $this->_imageInfo['height'] - $marginTop;
                break;
            case MASK_LEFT_DOWN:
                $x  = $marginLeft;
                $y  = $this->_imageInfo['height'] - $marginTop; 
                break;
            case MASK_LEFT:
                $x  = $marginLeft;
                $y  = ($this->_imageInfo['height'] - $maskHeight) / 2;
                break;
            case MASK_LEFT_TOP:
                $x  = $marginLeft;
                $y  = $marginTop + $maskHeight;
                break;
            case MASK_CENTER:
            default:
                $x  = ($this->_imageInfo['width'] - $maskWidth) / 2;
                $y  = ($this->_imageInfo['height'] - $maskHeight) / 2;
                break;
        }

        return array($x, $y);
    }

    /**
     * 给图片添加图片水印 
     * 
     * 根据设定的位置 
     * 
     * @access public
     * @param string $maskImagePath 水印图片
     * @param string $savePath 处理后保存的文件路径
     * @param int $location 水印的位置,默认为：MASK_LEFT_TOP
     * @return boolean 
     * @exception none
     */
    public function maskImage($maskImagePath, $savePath, $location = MASK_LEFT_TOP)
    {
        if(!file_exists($maskImagePath)) {
            return false;
        }
        $this->_soruce= $this->_loadImageRes();
        $maskImageRes   = $this->_loadImageRes($maskImagePath);
        $maskWidth      = imagesx($maskImageRes);
        $maskHeight     = imagesy($maskImageRes);
        $position       = $this->_getPosition($location, $maskWidth, $maskHeight);
        $maskImage      = imagecreatetruecolor($this->_imageInfo['width'], $this->_imageInfo['height']);
        imagecopy(
            $maskImage, $this->_soruce,
            0, 0, 0, 0,
            $this->_imageInfo['width'],
            $this->_imageInfo['height']
        );
        imagecopy(
            $maskImage, $maskImageRes,
            $position[0], $position[1],
            0, 0, $maskWidth, $maskHeight
        );
        $this->_outputImage($maskImage, $savePath);

        return true;
    }


}
?>
