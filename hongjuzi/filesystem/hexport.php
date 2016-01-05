<?php

/**
 * @version			$Id$
 * @create 			2012-8-15 21:22:05 By xjiujiu
 * @package 	 	app.admin
 * @subpackage 	 	action
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.render.excel.PHPExcel');

/**
 * 管理主页的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class HExport extends HObject 
{

    /**
     * 构造函数 
     * 
     * 防止实例化本类 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @return void
     * @throws none
     */
    private function __construct()
    {
        //私有构造函数
    }

    /**
     * 防止克隆此对象 
     * 
     * @desc
     * 
     * @author 			xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @return void
     * @throws none
     */
    private function __clone() {}

    /**
     *  
     * 
     * @desc
     * 
     * @author 			xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $type
     * @return void
     * @throws none
     */
    public static function getInstance($type)
    {
        switch($type) {
            case 'excel':
            HClass::import('hongjuzi.filesystem.export.HExcel');
            return new HExcel();
        }
    } 

}

?>
