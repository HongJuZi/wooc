<?php 

/**
 * @version			$Id$
 * @create 			2013-11-07 01:11:02 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 评论模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class CommentModel extends BaseModel
{

    /**
     * 按项目编辑分组得到所有最新的项目评论
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $where 条件默认为 1 = 1
     * @return Array 数据集合
     */
    public function getAllRowsGroupByItemId($where = '1 = 1')
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('DISTINCT(`item_id`), `content`, `parent_id`')
            ->where($where)
            ->groupBy('item_id')
            ->orderBy(HPopoHelper::getOrderFields($this->_popo));

        return $this->_db->select()->getList();
    }

}

?>
