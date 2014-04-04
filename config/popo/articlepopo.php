<?php 

/**
 * @version			$Id$
 * @create 			2014-03-30 16:03:18 By xjiujiu 
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
class ArticlePopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '文章';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'article';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_article';

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
            'comment' => '只能是数字，默认为：当前时间。','is_show' => true, 'is_order' => 'DESC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '标题', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array( 'len' => 50,),
            'comment' => '唯一，最好用英文','is_show' => true, 
        ),'seo_keywords' => array(
            'name' => 'SEO关键字', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度范围：300字以内。',
        ),'seo_desc' => array(
            'name' => 'SEO描述', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度范围：300字以内。',
        ),'parent_id' => array(
            'name' => '所属分类', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '请正确选取','is_show' => false, 
        ),'cat_names' => array(
            'name' => '所在分类', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '文章所在分类信息','is_show' => true, 
        ),'description' => array(
            'name' => '内容简介', 
            'verify' => array(),
            'comment' => '长度255字以内。','is_show' => true, 
        ),'content' => array(
            'name' => '详细内容', 
            'verify' => array(),
            'comment' => '长度10000字以内。',
        ),'image_path' => array(
            'name' => '图片', 
            'verify' => array( 'len' => 255,),
            'comment' => '请选择允许的类型。','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'total_visits' => array(
            'name' => '访问总数', 'default' => '0',
            'verify' => array( 'numeric' => true,),
            'comment' => '只能是数字。','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'weibsite_id' => array(
            'name' => '所属网站', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '信息所在的网站范围','is_show' => false, 
        ),'author' => array(
            'name' => '维护人', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最近一次维护人员','is_show' => true, 
        ),);

}

?>
