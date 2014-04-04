<?php 

/**
 * @version			$Id$
 * @create 			2013-12-05 23:12:59 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 用户附加信息模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class UserinfoModel extends BaseModel
{

    /**
     * 更新指定字段的数值
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $field 字段名
     * @param  int $number 数值
     * @param  String $where 条件
     * @return int 影响行数
     */
    public function updateNumber($field, $number, $where)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('`' . $field . '` += ' . $number)
            ->where($where)
            ->limit(1);

        return $this->_db->update();
    }

}

?>
