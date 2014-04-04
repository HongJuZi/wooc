<?php

/**
 * @version			$Id$
 * @create 			2012-4-8 17:52:14 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入模块相关类
HClass::import('config.popo.ModelManagerPopo, app.admin.action.AdminAction, model.ModelManagerModel');

/**
 * 生成工具的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class ModelManagerAction extends AdminAction
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
        $this->_popo        = new ModelManagerPopo();
        $this->_model       = new ModelManagerModel($this->_popo);
    }

    /**
     * 快捷操作面板 
     * 
     * @access public
     */
    public function control()
    {
        $this->_render('modelmanager/control_view');
    }

    /**
     * 添加动作
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function addview()
    {
        HResponse::succeed('此功能只对VIP开放，如何成为VIP？请联系：xjiujiu@foxmail.com~');
    }

    /**
     * 添加动作
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function add()
    {
        HResponse::succeed('此功能只对VIP开放，如何成为VIP？请联系：xjiujiu@foxmail.com~');
    }

    /**
     * 删除动作 
     * 
     * @access public
     */
    public function delete()
    {
        $recordIds  = HRequest::getParameter('id');
        if(!is_array($recordIds)) {
            $recordIds  = array($recordIds);
        }
        foreach($recordIds as $recordId) {
            HVerify::isRecordId($recordId);
            $record     = $this->_model->getRecordById($recordId);
            if(empty($record)) {
                throw new HVerifyException(HResponse::lang('NO_THIS_RECORD', false));
            }
            //删除模块对应的表
            //$this->_model->dropModelTable($record['en_name']);
            //删除模块相关文件
            $this->_deleteModelFiles($record['en_name']);
            $this->_deleteFiles();
            if(false === $this->_model->delete($recordId)) {
                throw new HRequestException(HResponse::lang('DELETE_FAIL', false));
            }
        }
        HResponse::succeed(
            HResponse::lang('DELETE_SUCCESS', false), 
            HResponse::url('modelmanager', '', 'admin')
        );
    }

    /**
     * 删除模块对应的资源项 
     * 
     * @access protected
     * @exception HRequestException 请求异常 
     */
    protected function _deleteModelFiles($modelEnName)
    {
        foreach(ModelManagerPopo::$deleteResources as $item) {
            try {
                $path   = ROOT_DIR . DS . sprintf($item, $modelEnName);
                HDir::isDir($path) ? HDir::delete($path) : HFile::delete($path);
            } catch(HIOException $ex) {
                if(true == HObject::GC('DEBUG')) {
                    throw new HRequestException($ex->getMessage());
                }
            }
        }
    }

}

?>
