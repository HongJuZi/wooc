<?php 

/**
 * @version			$Id$
 * @create 			2013-11-07 01:11:45 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 虾扯模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class FeedModel extends BaseModel
{

    /**
     * 更新状态
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  int $status 状态值
     * @param  String $where 条件
     * @return int 影响行数 
     */
    public function updateStatus($status, $where)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('status')
            ->values($status)
            ->where($where);

        return $this->_db->update();
    }

}

?>
