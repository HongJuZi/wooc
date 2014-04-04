<?php

/**
 * @version			$Id$
 * @create 			2013-06-17 01:06:41 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.categorypopo, app.admin.action.AdminAction, model.categorymodel'); 

/**
 * 信息分类的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class CategoryAction extends AdminAction
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
        $this->_popo        = new CategoryPopo();
        $this->_model       = new CategoryModel($this->_popo);
    }

    /**
     * 组合搜索条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return String 组合成的搜索条件
     */
    protected function _combineWhere()
    {
        $where          = array('1 = 1');
        if(1 < intval(HRequest::getParameter('type'))) {
            array_push($where, '`parent_path` LIKE \'%:' . HRequest::getParameter('type') . ':%\'');
        }
        $keywords       = HRequest::getParameter('keywords');
        if(!$keywords || '关键字...' === $keywords) {
            return implode(' AND ', $where);
        }
        $keywordsWhere  = $this->_getSearchWhere($keywords);
        if($keywordsWhere) {
            array_push($where, $keywordsWhere);
        }

        if(!$where) {
            return null;
        }

        return implode(' AND ', $where);
    }

    /**
     * 添加模块视图 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function addview()
    {  
        $this->_addview();
        $this->_assignCategoryRootNodes();

        $this->_render($this->_popo->modelEnName . '/info');
    }

    /**
     * 执行模块的添加 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function add()
    {
        $id     = $this->_add();
        $this->_model->updateParentPath(
            $id,
            $this->_getParentPath($id, HRequest::getParameter('parent_id'))
        );
        HResponse::succeed('添加成功！', $this->_getReferenceUrl(2));
    }

    /**
     * 编辑提示动作 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function edit()
    {
        $record         = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(HVerify::isEmpty($record)) {
            throw new HVerifyException(HResponse::lang('NO_THIS_RECORD', false));
        }
        HRequest::setParameter(
            'parent_path',
            $this->_getParentPath($record['id'], HRequest::getParameter('parent_id'))
        );
        $this->_edit();
        HResponse::succeed(HResponse::lang('UPDATE_SUCCESS', false), $this->_getReferenceUrl(2));
    }

    /**
     * 编辑动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function editview()
    {
        $this->_editview();
        $record     = HResponse::getAttribute('record');
        $this->_assignCategoryRootNodes($this->_model);
        $this->_assignParentInfo($record['parent_id']);
        
        $this->_render($this->_popo->modelEnName . '/info');
    }

    /**
     * 得到当前记录的parent_PATH值 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $id 当前记录的ID
     * @param  int $parentId 当前的父层
     * @return 当前的所属层级 
     */
    protected function _getParentPath($id, $parentId)
    {
        if(empty($parentId) || -1 == $parentId) {
            return ':' . $id . ':';
        }
        $parent     = $this->_model->getRecordById($parentId);
        if(null == $parent) {
            return ':' . $id . ':';
        }

        return $parent['parent_path'] . $id . ':';
    }

    /**
     * 查找子分类 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @throws HRequestException 请求异常 | HVerifyException 验证异常 
     */
    public function asubcategory()
    {
    	$modelName = HRequest::getParameter('model_name');
    	$modelName == ''?$typeModel = $this->_model:$typeModel = HClass::quickLoadModel($modelName);
        HVerify::isAjax();
        HVerify::isNumber(HRequest::getParameter('pid'));
        HResponse::json(array(
            'list' => $typeModel->getAllRows(
                '`parent_id` = ' . HRequest::getParameter('pid')
            )
        ));
    }

    /**
     * 异步加载分享
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aload()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('id'), '分类编号');

        echo HArray::makeZtreeJsonByListMap(
            $this->_model->getAllRows('`parent_id` = ' . HRequest::getParameter('id')),
            null,
            true
        );
    }

}

?>
