<?php 

/**
 * @version			$Id$
 * @create 			2012-10-10 20:10:38 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 数据模型模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class DatamodelModel extends BaseModel
{

    /**
     * 更新拥有字段 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  int $id 需要更新的数据模型ID值 
     * @param  String $hasFields 已经拥有的字段id集
     * @return int 影响的记录条数 
     * @throws none
     */
    public function updatefields($id, $hasFields)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('has_fields')
            ->values($hasFields)
            ->where('`datamodel_id` = \'' . $id . '\'');

        return $this->_db->update();
    }

    /**
     * 通过Ajax来得到数据模型的所有列表 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return array 
     * @throws none
     */
    public function getDataModelListByAjax()
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields(array('datamodel_id', 'datamodel_name'))
            ->where('`pass_flag` = 2');

        return $this->_db->select()->getList();
    }

}

?>
