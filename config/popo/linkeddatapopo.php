<?php 

/**
 * @version			$Id$
 * @create 			2014-02-18 17:02:32 By xjiujiu 
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
    protected $_parent          = 'user';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_linkeddata';

    /**
     * @var string $primaryKey 表主键
     */
    public $primaryKey          = 'id';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序', 
            'verify' => array(),
            'comment' => '排序编号，越小在前，默认当前时间','is_show' => true, 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '文件名称','is_show' => true, 'is_search' => true, 
        ),'res_id' => array(
            'name' => '资源ID', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '关联的资源。','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属用户', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '这个资源是由谁添加','is_show' => true, 
        ),'description' => array(
            'name' => '内容简介', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度255字以内。',
        ),'hash' => array(
            'name' => '内容简介', 
            'verify' => array('null' => false, 'len' => 32,),
            'comment' => '长度255字以内。','is_show' => true, 
        ),'is_cover' => array(
            'name' => '封面', 'default' => '否',
            'verify' => array('null' => false, 'options' => array('是','否'),),
            'comment' => '是否作为封面显示',
        ),'folder' => array(
            'name' => '文件夹', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '文件所属文件夹','is_show' => true, 
        ),'model' => array(
            'name' => '所属模块', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '当前的信息关联为哪一个模块','is_show' => true, 
        ),'top' => array(
            'name' => '置顶状态', 'default' => '否',
            'verify' => array('null' => false, 'options' => array('是','否'),),
            'comment' => '请从下拉选择','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '关联添加的时间表','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '文件审核人','is_show' => true, 
        ),);

}

?>
