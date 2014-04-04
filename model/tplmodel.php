<?php 

/**
 * @version			$Id$
 * @create 			2013-08-08 16:08:48 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 模板模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class TplModel extends BaseModel
{

    /**
     * 查找模板及标识的关系表记录 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $tplId 模板ID
     * @param  String $langId 标识ID
     * @return  Array 查找到的记录集
     */
    public function getRelTplAndLangMask($tplId, $langId)
    {
        $this->_db->getSql()
            ->table('#_tpl_lang')
            ->fields('id')
            ->where('`tpl_id` = ' . $tplId . ' AND `mask_id` = ' . $langId)
            ->limit(1);

        return $this->_db->select()->getRecord();
    }

    /**
     * 添加模板语言标识关系记录
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $tplId 模板ID
     * @param  String $langId 标识ID
     * @return int 当前添加的记录ID 
     */
    public function addRelTplAndLangMask($tplId, $langId)
    {
        $this->_db->getSql()
            ->table('#_tpl_lang')
            ->fields(array('tpl_id', 'mask_id'))
            ->values(array($tplId, $langId));

        return $this->_db->add();
    }

    /**
     * 通过模板标记从关联表里得到所有的标只IDS
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return  Array 查找到的结果集
     */
    public function getAllMaskIdsFromRelByWhere($where)
    {
        $this->_db->getSql()
            ->table('#_tpl_lang')
            ->fields(array('tpl_id', 'mask_id'))
            ->where($where);

        return $this->_db->select()->getList();
    }

}

?>
