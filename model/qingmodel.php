<?php 

/**
 * @version			$Id$
 * @create 			2013-11-09 22:11:47 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 轻博客模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class QingModel extends BaseModel
{

    /**
     * 得到必须的查看条件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return String 必须的条件
     */
    protected function _getMustWhere()
    {
        return HSqlHelper::mergeWhere(
            array(
                '`status` = 1 AND (`open` = 1 OR `parent_id` = ' . HSession::getAttribute('id', 'user') . ')',
                parent::_getMustWhere()
            ),
            'AND'
        );
    }

}

?>
