<?php

/**
 * @version			$Id$
 * @create 			2013-08-08 12:08:51 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.langtypepopo, app.cms.action.CmsAction, model.langtypemodel');

/**
 * 语言种类的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @since 			1.0.0
 */
class LangtypeAction extends CmsAction
{
    /**
     * {@inheritDoc}
     */
    public function beforeAction() { }

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo    = new LangtypePopo();
        $this->_model   = new LangtypeModel($this->_popo);
    }

    /**
     * 语种切换方法
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @throws HRequestException 请求异常 
     */
    public function index()
    {
        HVerify::isEmpty(HRequest::getParameter('lang'), '语种');
        $record     = $this->_model->getRecordByWhere(
            '`identifier` = \'' . HRequest::getParameter('lang') . '\''
        );
        if(empty($record)) {
            throw new HVerifyException('暂不支持此语种！');
        }
        HSession::setAttribute('CUR_LANG', $record['identifier']);
        HResponse::redirect($_SERVER['HTTP_REFERER']);
    }

}

?>
