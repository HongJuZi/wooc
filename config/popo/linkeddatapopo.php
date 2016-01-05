<?php 

/**
 * @version			$Id$
 * @create 			2014-04-07 15:04:53 By xjiujiu 
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

/**
 * 模块工具的基本信息类 
 * 
 * 用于记录单模块的配置信息 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		config.popo
 * @since 			1.0.0
 */
class LinkeddataPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '关联数据';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'linkeddata';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 此项需要配置默认表，它会操作一个系列的表，如：#_linkeddata_relmodel_itemmodel
     */
    protected $_table           = '#_linkeddata';

    /**
     * @var string $primaryKey 表主键
     */
    public $primaryKey          = 'id';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'item_id' => array(
            'name' => '被关联编号', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '多的对象的编号','is_show' => true, 
        ),'rel_id' => array(
            'name' => '关联编号', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '一的对象的编号','is_show' => true, 
        ),'extend' => array(
            'name' => '扩展信息', 'default' => 0,
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '如标签关联的分类信息等','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '关联添加的时间表','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 'default' => 0,
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '文件审核人','is_show' => true, 
        ),);

}

?>
