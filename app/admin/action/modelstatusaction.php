<?php 

/**
 * @version			$Id$
 * @create 			2012-5-3 11:20:35 By xjiujiu
 * @package 		app.admin
 * @subpackage 		action
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminBaseAction, model.ModelstatusModel');

/**
 * 模块状态动作类 
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class ModelstatusAction extends AdminBaseAction
{

    /**
     * 构造函数 
     * 
     * @desc
     * 
     * @access public
     */
    public function __construct()
    {
        $this->_model   = new ModelstatusModel();
    }

    /**
     * 模块信息主页 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function index()
    {
        HResponse::setAttribute('modelStatus', $this->_model->getModelStatus());

        $this->_render('hongjuzi/modelstatus');   
    }

}

?>
