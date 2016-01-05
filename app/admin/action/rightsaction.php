<?php

/**
 * @version			$Id$
 * @create 			2013-10-05 12:10:26 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.rightspopo, app.admin.action.AdminAction, model.rightsmodel');

/**
 * 权限资源的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class RightsAction extends AdminAction
{

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_popo        = new RightsPopo();
        $this->_model       = new RightsModel($this->_popo);
    }

    /**
     * 加载当前所有父类列表
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignAllParentList()
    {
        HResponse::setAttribute(
            'parents',
            $this->_model->getAllRows('`parent_id` = -1 OR `parent_id` IS NULL')
        );
    }

    /**
     * 加载zTree树形数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aloadztree()
    {
        HVerify::isAjax();
        $id     = HRequest::getParameter('id');
        HVerify::isRecordId($id, '权限编号');
        $list       = $this->_model->getAllRows('`parent_id` = ' . $id);
        if(!$list) {
            HResponse::Json('[]');
        }
        $ztreeJson  = array();
        foreach($list as $item) {
            array_push($ztreeJson, array(
                'id' => $item['id'],
                'name' => $item['name'],
                'isParent' => false,
                'pId' => $id 
            ));
        }
        HResponse::json($ztreeJson);
    }

}

?>
