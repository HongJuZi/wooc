<?php 

/**
 * @version			$Id$
 * @create 			2013-06-17 01:06:41 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 信息分类模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class CategoryModel extends BaseModel
{

    /**
     * 更新当前的所属层级 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  int $id 当前的记录ID
     * @param  string $parentPath 当前的所属层级
     * @return int 影响的行数
     */
    public function updateParentPath($id, $parentPath)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('parent_path')
            ->values($parentPath)
            ->where('`id` = ' . $id);

        return $this->_db->update();
    }

    /**
     * 得到子类信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  int $parentId 需要查找的上级
     * @param  boolean $andSelf 是否包括本身
     * @return Array 查找到的结果集
     */
    public function getSubCategory($parentId, $andSelf = true)
    {
        $where  = '`parent_path` LIKE \'%:' . $parentId . ':%\'';
        $where  .= true == $andSelf ? '' : ' AND `id` != ' . $parentId;
       
        return $this->_getAllRows(
            HPopoHelper::getShowFields($this->_popo),
            $where,
            HPopoHelper::getOrderFields($this->_popo)
        );
    }

    /**
     * 通过标识来得到所有子分类
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $indentifier 当前的标识
     * @param  Boolean $andSelf = true
     * @return Array 查找到的数据
     */
    public function getSubCategoryByIdentifier($identifier, $andSelf = true)
    {
        $record     = $this->getRecordByIdentifier($identifier);
        if(empty($record)) {
            return null;
        }

        return $this->getSubCategory($record['id'], $andSelf);
    }

}

?>
