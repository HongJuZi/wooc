<?php 

/**
 * @version			$Id$
 * @create 			2013-11-04 22:11:51 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 关联数据模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class LinkeddataModel extends BaseModel
{

    /**
     * 得到关联模块的ID集合
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  $itemId 被关联编号
     * @return 查找到的结果集
     */
    public function getRelModelIds($itemId)
    {
        $where  = '`item_id` = ' . $itemId;

        return $this->_getAllRows(
            'rel_id',
            $where,
            HPopoHelper::getOrderFields($this->_popo)
        );
    }

    /**
     * 得到唯一的关联ID
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $where 条件
     * @return Array 查找到的结果集
     */
    public function getListByWhere($where, $page, $perpage)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('distinct(`rel_id`) as rel_id, count(rel_id) as total')
            ->where(HSqlHelper::mergeWhere(array($where, $this->_getMustWhere()), 'AND'))
            ->groupBy('rel_id')
            ->orderBy('total DESC')
            ->limit($page, $perpage);

        return $this->_db->select()->getList();
    }

    /**
     * 得到记录总数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $where 需要的条件
     * @return 结果集
     */
    public function getTotalRecords($where)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('count(`id`) as total')
            ->where(
                HSqlHelper::mergeWhere(array($where, $this->_getMustWhere()), 'AND'
            )
        );
        $record     = $this->_db->select()->getRecord();

        return intval($record['total']);
    }


    /**
     * 获取不重复值得文件id值
     * 
     * @author licheng
     * @access public
     * @param  $disfield 去重复值的字段名称
     * @param  $fields 加载字段集合，其他类似
     * @return 查找到的结果集
     */
    public function getDistinctFiles($where, $page, $perpage = 10)
    {
        $sql = 'select distinct `rel_id` from `' . $this->_popo->get('table') . '` where ' . $where . 
            ' limit ' . $page * $perpage . ',' . $perpage;

        return $this->_db->select($sql)->getList();
    }

    /**
     * 设置关联模块及被关联模块
     * 
     * 如，文件跟标签的送到，则使用为：setRelItemModel('files', 'tags');
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  $relModel 关联模块
     * @param  $itemModel 被关联模块
     * @return $this 当前数据模块
     */
    public function setRelItemModel($relModel, $itemModel)
    {
        $this->_popo->set('table', '#_linkeddata_' . $relModel . '_' . $itemModel);

        return $this;
    }
    
}

?>
