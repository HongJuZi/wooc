<?php

/**
 * @version			$Id$
 * @create 			2013-08-05 16:08:27 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.navmenupopo, app.admin.action.AdminAction, model.navmenumodel');

/**
 * 导航菜单的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class NavmenuAction extends AdminAction
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
        $this->_popo        = new NavmenuPopo();
        $this->_popo->setFieldAttribute('extend', 'is_show', false);
        $this->_model       = new NavmenuModel($this->_popo);
    }

    /**
     * 加载列表后的任务
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterList()
    {
        parent::_otherJobsAfterList();
        $this->_assignPositionMap();
    }

    /**
     * 加载位置映射
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignPositionMap()
    {
        HResponse::registerFormatMap(
            'position_id',
            'name',
            HArray::turnItemValueAsKey(
                $this->_category->getSubCategoryByIdentifier('navmenu-position', false),
                'id'
            )
        );
    }

    /**
     * 加载位置列表
     *
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignPositionList()
    {
        HResponse::setAttribute(
            'position_id_list',
            $this->_category->getSubCategoryByIdentifier('navmenu-position', false)
        );
    }

    /**
     * 加载添加其它内容
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterAddView($id)
    {
        parent::_otherJobsAfterAddView($id);
        $this->_assignPositionList();
    }

    /**
     * 加载编辑其它的任务
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterEditView($record)
    {
        parent::_otherJobsAfterEditView($record);
        $this->_assignPositionList();
    }

}

?>
