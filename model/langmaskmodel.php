<?php 

/**
 * @version			$Id$
 * @create 			2013-08-08 12:08:03 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 语言标识模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class LangmaskModel extends BaseModel
{

    /**
     * 更新是否已经有关联模板
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $where 执行的条件
     * @return int 影响行数
     */
    public function updateHasTplByWhere($where)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('has_tpl')
            ->values('2')
            ->where($where);

        return $this->_db->update();
    }

}

?>
