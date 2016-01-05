<?php

/**
 * @version			$Id$
 * @create 			2012-3-31 22:28:12 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

//导入图片工具父包
HClass::import('hongjuzi.image.HImage');

//定义验证码的样式
define('VCODE_NUM', 1);
define('VCODE_ALPHA', 2);
define('VCODE_NUM_ALPHA', 3);

/**
 * 图片工具类 
 * 
 * 集成图片的缩放，水印，验证码等 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.image
 * @since 			1.0.0
 */
class HImageVCode extends HImage
{

    /**
     * 构造函数
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_imageInfo['type']   = 'png';
    }
    
    /**
     * 生成验证码图片 
     * 
     * 直接生成对应的验证码图片并返回当前的验证码内容 
     * 
     * @access public
     * @param int $width 图片宽度
     * @param int $height 图片高度
     * @param int $length 字符个数，默认为:4
     * @param int $style 验证码样式, 默认为: VCODE_NUM_ALPHA 
     * @return string 随机字符串
     */
    public function genVerifyCode($width , $height, $length = 4, $imagePath = '', $style = VCODE_NUM_ALPHA)
    {
        $this->_soruce   = imagecreate($width, $height);
        $codeString      = $this->_genCodeString($length, $style);
        $this->_setImageBackground();
        $this->_addStringToImage($codeString, $height); 
        $this->_addRandPoint($width, $height, 10);
        $this->_addRandLine($width, $height, 1);
        
        $this->_outputImage($this->_soruce, $imagePath, false);

        return strtolower($codeString);
    }

    /**
     * 添加字符串到图片中 
     * 
     * 如验证码，水印之类 
     * 
     * @access protected
     * @param  String $string 字符串
     */
    protected function _addStringToImage($content, $height, $space = 10)
    {
        static $fontSize    = 5;
        $y      = intval($height / 2 - 5);
        $length = strlen($content);
        for($i = 0; $i < $length; $i ++) {
            $x  = 5 + $i * $space;
            imagestring(
                $this->_soruce,
                $fontSize,
                $x, $y,
                $content[$i],
                $this->_getRandColor()
            );
        }
    }

    /**
     * 生成验证码字符串 
     * 
     * 根据设定的验证码样式，来得到想要的字符串 
     * 
     * @access protected
     * @param int $length 串长度
     * @param int $style 验证码样式, 默认为: VCODE_NUM_ALPHA 
     * @return string  随机字符
     */
    protected function _genCodeString($length, $style)
    {
        static $randData  = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
        switch($style) {
            case VCODE_NUM:
                $min    = 0;
                $max    = 8;
                break;
            case VCODE_ALPHA:
                $min    = 9;
                $max    = strlen($randData) - 1;
                break;
            case VCODE_NUM_ALPHA:
            default: 
                $min    =0;
                $max    = strlen($randData) - 1;
                break;
        }
        $codeString   = '';
        for($i = 0; $i < $length; $i ++) {
            $codeString .= $randData[rand($min, $max)];
        }

        return $codeString;
    }

    /**
     * 添加干扰点 
     * 
     * 给图片中加入干扰点 
     * 
     * @access protected
     * @param int $width 图片的宽度
     * @param int $height 图片的高度
     * @param int $totalPoints 总的干扰点数，默认为：50
     */
    protected function _addRandPoint($width, $height, $totalPoints = 50)
    {
        for($i = 0; $i < $totalPoints; $i ++) {
            imagesetpixel(
                $this->_soruce,
                rand() % $width, rand() % $height,
                $this->_getRandColor()
            );
        }
    }

    /**
     * 添加干扰线 
     * 
     * 给图片加入干扰线，如验证码之类的 
     * 
     * @access protected
     * @param int $width 图片的宽度
     * @param int $height 图片的高度
     * @param int $totalLines 总的线条数, 默认为3条
     */
    protected function _addRandLine($width, $height, $totalLines = 3)
    {
        for($i = 0; $i < $totalLines; $i ++) {
            $x1     = rand(2, $width);
            $x2     = rand(2, $width);
            $y1     = rand(2, $height);
            $y2     = rand(2, $height);
            imageline(
                $this->_soruce,
                $x1, $y1, $x2, $y2,
                $this->_getRandColor()
            );
        }
    }

}
?>
