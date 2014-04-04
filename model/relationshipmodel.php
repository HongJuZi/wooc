<?php 

/**
 * @version			$Id$
 * @create 			2013-11-18 15:11:39 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 外键关联模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class RelationshipModel extends BaseModel
{

    /**
     * 按唯一的项目ID得到一些数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  int $rows 需要的行数
     * @param  String $where 条件
     * @return Array 数据集
     */
    public function getSomeRowsByUniqueItemId($rows, $where)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('DISTINCT(`item_id`), count(`rel_id`) as total')
            ->where($where)
            ->groupBy('item_id')
            ->orderBy('total DESC')
            ->limit($rows);

        return $this->_db->select()->getList();
    }

}

?>
