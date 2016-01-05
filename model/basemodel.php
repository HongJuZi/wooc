<?php

/**
 * @version			$Id$
 * @create 			2012-4-25 21:23:17 By xjiujiu
 * @package 		app.admin
 * @subpackage 		model
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//引入缓存实例化工厂
HClass::import('hongjuzi.cache.hcachefactory');

/**
 * 后台管理模块的M层共用方法基类 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.model
 * @since 			1.0.0
 */
class BaseModel extends HModel 
{

    /**
     * 快捷操作方法 
     * 
     * @access public
     */
    public function moreUpdate($dataIds, $quickOperationConfigs)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($quickOperationConfigs['field'])
            ->values($quickOperationConfigs['value'])
            ->where(HSqlHelper::whereIn($this->_getPrimaryKey(), $dataIds));

        return $this->_db->update();
    }

    /**
     * 添加模块记录 
     * 
     * @access public
     * @param  Array $data 需要添加的数据
     * @param  Array $fields 需要添加的数据字段
     * @return int 影响行数
     */
    public function add($data, $fields = '')
    {
        return $this->_add($this->_popo, $data, $fields);
    }

    /**
     * 编辑数据 
     * 
     * @access public
     */
    public function edit($data)
    {
        return parent::_edit($data, '`id` =' . $data['id']);
    }

    /**
     * 指定需要编辑的条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  array $data 需要更新的字段数据
     * @param  String $where 更新执行条件
     * @return int 影响的行数
     */
    public function editByWhere($data, $where)
    {
        return parent::_edit($data, $where);
    }

    /**
     * 删除给定的Id记录 
     * 
     * @access public
     * @param int $id 记录Id
     * @return int 影响行数
     */
    public function delete($id)
    {
        return $this->_delete('`id`=' . $id, $this->_popo);
    }

    /**
     * 指定的刪除條件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $where 刪除條件
     * @return int 影響的行數
     */
    public function deleteByWhere($where)
    {
        return $this->_delete($where, $this->_popo);
    }

    /**
     * 通过链接名称得到单条记录 
     * 
     * @access public
     * @param int $identifier 链接名称
     * @return array 查找到的数据集
     */
    public function getRecordByIdentifier($identifier)
    {
        return $this->getRecordByWhere("`identifier` = '{$identifier}'"); 
    }

    /**
     * 更新当前信息的浏览次数 
     * 
     * @access public
     * @param int $id 记录ID
     * @param int $totalVisits 当前的总浏览次数
     * @return int 影响行数
     */
    public function updateTotalVisits($id, $totalVisits)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('total_visits')
            ->values($totalVisits)
            ->where('`id`=' . $id );

        return $this->_db->update();
    }

    /**
     * 得到当前记录之前的上一条记录ID 
     * 
     * @access public
     * @param $curRecordId
     * @param int $parentId 当前记录的类型
     * @return array 查找到的结果集
     */
    public function getPreRecord($id, $where)
    {
        $wherePre  = '`id` < ' . $id;
        $fields     = '`id`, ';
        $fields    .= $this->_popo->hasField('name') ? '`name`' : '`id` as name';

        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where(HSqlHelper::mergeWhere(
                array($where, $wherePre, $this->_getMustWhere()),
                'AND'
            ))->limit(1);
        $record     = $this->_db->select()->getRecord();
        if(!$record['id']) {
            return null;
        }
        
        return $this->getRecordById($record['id']);
    }

    /**
     * 得到下一条记录ID 
     * 
     * @access public
     * @param int $curRecordId 当前的记录ID
     * @param int $parentId 当前记录的类型
     * @return array  查找到的结果集
     */
    public function getNextRecord($id, $where = '')
    {
        $whereNext  = '`id` > ' . $id;
        $fields     = '`id`, ';
        $fields    .= $this->_popo->hasField('name') ? '`name`' : '`id` as name';

        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where(HSqlHelper::mergeWhere(
                array($where, $whereNext, $this->_getMustWhere()),
                'AND'
            ))->limit(1);
        
        $record     = $this->_db->select()->getRecord();
        if(!$record['id']) {
            return null;
        }
        
        return $this->getRecordById($record['id']);
    }

}
?>
