<?php

/**
 * @version			$Id$
 * @create 			2013-10-03 18:10:42 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.tagspopo, app.admin.action.AdminAction, model.tagsmodel');

/**
 * 标签的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class TagsAction extends AdminAction
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
        $this->_popo        = new TagsPopo();
        $this->_model       = new TagsModel($this->_popo);
    }

    /**
     * 异步添加标签库
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aadd()
    {
        try {
            HVerify::isAjax();
            if(HRequest::getParameter('tags')) {
                $list   = $this->_model->getAllRows(
                    HSqlHelper::WhereOr(
                        'name', 
                        explode(',', HRequest::getParameter('tags'))
                    )
                );
                $tags   = HRequest::getParameter('tags');
                foreach($list as $record) {
                    $tags   = str_replace($record['name'], '', $tags);
                }
                $tags   = strtr($tags, array(',,' => ','));
                foreach(explode(',', $tags) as $key => $tag) {
                    if(empty($tag)) { continue; }
                    $data[]     = array($tag);
                }
                if(!empty($data) && 1 > $this->_model->add($data, array('name'))) {
                    throw new HRequestException('标签添加失败！');
                }
            }
            HResponse::json(array('rs' => true));
        } catch(HVerifyException $ex) {
            HResponse::json(array('rs' => false, 'message' => $ex->getMessage()));
        }
    }

}

?>
