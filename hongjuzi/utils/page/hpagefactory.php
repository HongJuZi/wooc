<?php 

/**
 * @version			$Id$
 * @create 			2012-4-10 15:24:08 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		utils
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die('Restricted access!');

/**
 * 分页工具类 
 * 
 * 支持1,2,3,4,5,6,....,10风格类型的分页 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.utils
 * @since 			1.0.0
 */
class HPageFactory extends HObject
{

    /**
     * 分页风格生成工厂
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $style = 'bootstrap'
     * @return 分页对象
     */
    public static function getInstance($style = 'bootstrap')
    {
        switch($style) {
        case 'bootstrap':
            HClass::import('hongjuzi.utils.page.hbootstrap');
            return new HBootstrap();
        case 'noendpage': 
            HClass::import('hongjuzi.utils.page.hnoendpage');
            return new HNoEndPage();
        case 'default':
        default:
            HClass::import('hongjuzi.utils.page.hpage');
            return new HPage();
        }
    }

}


?>
