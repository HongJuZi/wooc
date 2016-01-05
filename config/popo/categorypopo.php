<?php 

/**
 * @version			$Id$
 * @create 			2014-10-09 19:10:53 By xjiujiu 
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
class CategoryPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '综合分类';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'category';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_category';

    /**
     * @var string $primaryKey 表主键
     */
    public $primaryKey          = 'id';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序', 
            'verify' => array(), 'default' => 999,
            'comment' => '只能是数字，默认为：当前时间。','is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => null, 
        ),'name' => array(
            'name' => '标题', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array( 'len' => 255,),
            'comment' => '唯一，建议使用英文','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属分类', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '请正确选取','is_show' => true, 
        ),'parent_path' => array(
            'name' => '所属层级', 
            'verify' => array('null' => true, 'len' => 255,),
            'comment' => '格式:：:3:2:1:','is_show' => false, 
        ),'description' => array(
            'name' => '内容简介', 
            'verify' => array(),
            'comment' => '长度255字以内。','is_show' => true,
        ),'image_path' => array(
            'name' => '图片', 
            'verify' => array( 'len' => 255,),
            'comment' => '请选择允许的类型。','is_show' => true, 'is_file' => true, 
            'zoom' => array('middle' => array(400, 400), 'small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'total_use' => array(
            'name' => '总使用数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '当前分类总使用数','is_show' => false, 
        ),'is_recommend' => array(
            'name' => '是否推荐', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '是否推荐','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => false, 
        ),'author' => array(
            'name' => '管理员', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '请从下拉里选择','is_show' => true, 
        ),);

}

?>
