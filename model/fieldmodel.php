<?php 

/**
 * @version			$Id$
 * @create 			2012-10-10 20:10:06 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 模块字段模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class FieldModel extends BaseModel
{

    /**
     * 通过ID来得到当前的字段 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $ids 需要查找的ID们。
     * @return array 查找到的字段值 
     * @throws none
     */
    public function getFieldsById($ids)
    {
        if(!is_array($ids)) {
            $ids    = array($ids);
        }

        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields(array('field_name', 'field_zh_name', 'field_sql', 'field_config'))
            ->where(HArray::whereIn(array('field_id' => $ids), 'OR'));

        return $this->_db->select()->getList();
    }

}

?>
