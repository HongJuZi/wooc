<?php

/**
 * @version			$Id$
 * @create 			2015-05-04 23:05:57 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.themepopo, app.admin.action.AdminAction, model.thememodel');

/**
 * 主题风格的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class ThemeAction extends AdminAction
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
        $this->_popo        = new ThemePopo();
        $this->_model       = new ThemeModel($this->_popo);
    }

    /**
     * 主页
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        $this->_assignThemeDirList();
        $this->_search(null);

        $this->_render('theme/list');
    }

    /**
     * 搜索方法 
     * 
     * @access public
     */
    public function search()
    {
        $this->_assignThemeDirList();
        $this->_search($this->_combineWhere());

        $this->_render('theme/list');
    }

    /**
     * 加载主题目录列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignThemeDirList()
    {
        HClass::import('hongjuzi.filesystem.hdir');
        $list       = HDir::getFiles(ROOT_DIR . 'static/template/cms');
        $errList    = array();
        foreach($list as $dir) {
            if(!file_exists($dir . '/hconfig.php')) {
                continue;
            }
            $data       = require_once($dir . '/hconfig.php');
            $pathInfo   = pathinfo($dir);
            $data['app']            = 'cms';
            $data['identifier']     = $pathInfo['filename'];
            if($this->_model->getRecordByIdentifier($data['identifier'])) {
                continue;
            }
            $data['image_path']     = HResponse::url() . 'static/template/cms/' 
                . $data['identifier'] . '/' . $data['image_path'];
            if(1 > $this->_model->add($data)) {
                $errList[] = $data;
                continue;
            }
        }

        HResponse::setAttribute('errList', $errList);
    }

    /**
     * 安装主题
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function install()
    {
        HVerify::isRecordId(HRequest::getParameter('id'), '模板编号');
        $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('主题已经不存在，请确认！');
        }
        $data   = array('status' => 2);
        $this->_model->editByWhere($data, '`id` = ' . HRequest::getParameter('id'));

        HResponse::succeed(
            '“' . $record['name'] . '”主题安装成功，正在为您导航到主题首页...', 
            HResponse::url('theme')
        );
    }

    /**
     * 删除主题
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function adelete()
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('id'), '模板编号');
        $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('主题已经不存在，请确认！');
        }
        $this->_model->delete($record['id']);

        HResponse::json(array('ok' => true));
    }

    /**
     * 启用当前的主题
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function active()
    {
        HVerify::isRecordId(HRequest::getParameter('id'), '模板编号');
        $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('主题已经不存在，请确认！');
        }
        $data   = array('status' => 2);
        $this->_model->editByWhere(
            $data, 
            '`id` != ' . HRequest::getParameter('id')
            . ' AND `status` = 3'
        );
        $data   = array('status' => 3);
        $this->_model->editByWhere($data, '`id` = ' . HRequest::getParameter('id'));

        HResponse::succeed(
            '“' . $record['name'] . '”主题启用成功，正在为您导航到主题首页...', 
            HResponse::url('theme')
        );
    }

    /**
     * 加载详细
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function adetail()
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('id'), '模板编号');
        $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('主题已经不存在，请确认！');
        }

        HResponse::json(array('rs' => true, 'data' => $record));
    }

    /**
     * 预览主题
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function preview()
    {
        $this->_editview();

        $this->_render('theme/preview');
    }

    /**
     * 模板市场
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function market()
    {
        $this->_otherJobsAfterList();

        $this->_render('theme/market');
    }

}

?>
