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

/**
 * 后台管理模块的M层共用方法基类 
 * 
 * 抽取了后台管理模块里的公用方法 
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
     * @desc
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
     * @desc
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
     * 添加方法内部使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  HPopo $popo 模块的配置对象
     * @param  Array $data 需要添加的数据
     * @param  Array $fields 需要添加的数据字段
     * @return int 影响的行数
     */
    protected function _add($popo, $data, $fields = '')
    {
        if(empty($fields)) {
            $fields = array_keys($data);
            $data   = array_values($data);
        }
        $this->_db->getSql()
            ->table($popo->get('table'))
            ->fields($fields)
            ->values($data);

        return $this->_db->add();
    }

    /**
     * 编辑数据 
     * 
     * @desc
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
     * @desc
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
     * @desc
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
     * 得到条件查询记录列表并限制页数及条数  
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String | Array<String> $where 需要查找的条件
     * @param  String String $where 需要查找的条件
     * @param  int $page 当前的页数
     * @param  int $perpage = 10 每页显示的记录条数
     * @return Array<Array<?, ?>
     */
    public function getListByWhere($where, $page = 0, $perpage = 10)
    {
        return $this->_getList(
            HPopoHelper::getLinkFields($this->_popo),
            $where,
            HPopoHelper::getOrderFields($this->_popo),
            $page,
            $perpage
        );
    }

    /**
     * 通过链接名称得到单条记录 
     * 
     * @desc
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
     * @desc
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
     * @desc
     * 
     * @access public
     * @param $curRecordId
     * @param int $parentId 当前记录的类型
     * @return array 查找到的结果集
     */
    public function getPreRecord($curRecordId, $whereParentId)
    {
        $where      = HSqlHelper::mergeWhere(
            array('id' . '<' . $curRecordId, $whereParentId), 
            'AND'
        );

        return $this->getRecordByWhere($where);
    }

    /**
     * 得到下一条记录ID 
     * 
     * @desc
     * 
     * @access public
     * @param int $curRecordId 当前的记录ID
     * @param int $parentId 当前记录的类型
     * @return array  查找到的结果集
     */
    public function getNextRecord($curRecordId, $whereParentId = '')
    {
        $where      = HSqlHelper::mergeWhere(
            array('id' . '>' . $curRecordId, $whereParentId), 
            'AND'
        );

        return $this->getRecordByWhere($where);
    }

    /**
     * 得到类型的总记录数 
     * 
     * @desc
     * 
     * @access public
     * @param int $typeId 当前的类型ID
     * @return int 影响行数
     */
    public function getTotalTypeRecords($typeId)
    {
        $where  = array('`pass_flag`=2');
        if(!empty($typeId)) {
            $where[]    = ' AND `parent_id`=' . $typeId;
        }

        return $this->_getTotalRecords(
            'count(' . $this->_getPrimaryKey() . ') as total',
            $where
        );
    }

}
?>
