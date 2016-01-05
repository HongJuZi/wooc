<?php 

/**
 * @version			$Id$
 * @create 			2015-03-25 21:03:47 By xjiujiu 
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
     * @var public static $statusMap    文章状态映射
     */
    public static $statusMap    = array(
        '1' => array('id' => '1', 'name' => '草稿'),
        '2' => array('id' => '2', 'name' => '正常'),
        '3' => array('id' => '3', 'name' => '删除'),
    );

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序', 'default' => '9999',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '显示排序','is_show' => true, 'is_order' => 'ASC',
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '标题', 
            'verify' => array('null' => false),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'extend_class' => array(
            'name' => '扩展样式', 
            'verify' => array( 'len' => 255,),
            'comment' => '自动定义样式','is_show' => false, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array( 'len' => 200,),
            'comment' => '唯一，最好用英文','is_show' => false, 
        ),'parent_id' => array(
            'name' => '所属分类', 'default' => '0',
            'verify' => array( 'len' => 50,),
            'comment' => '请正确选取','is_show' => true, 
        ),'parent_path' => array(
            'name' => '分类层级', 
            'verify' => array(),
            'comment' => '所在分类层级','is_show' => false, 
        ),'description' => array(
            'name' => '摘要', 
            'verify' => array(),
            'comment' => '长度255字以内。','is_show' => true, 
        ),'content' => array(
            'name' => '详细内容', 
            'verify' => array(),
            'comment' => '长度10000字以内。',
        ),'tags' => array(
            'name' => '标签',
            'verify' => array( 'len' => 255,),
            'comment' => '信息包含的标签分类','is_show' => false, 
        ),'tags_name' => array(
            'name' => '标签名称缓存',
            'verify' => array( 'len' => 255,),
            'comment' => '标签名称缓存','is_show' => true, 
        ),'image_path' => array(
            'name' => '图片', 
            'verify' => array( 'len' => 255,),
            'comment' => '请选择允许的类型。','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(300, 320)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'total_visits' => array(
            'name' => '阅读数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '总到访数','is_show' => true, 
        ),'total_comments' => array(
            'name' => '总评论数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '只能是数字','is_show' => true, 
        ),'status' => array(
            'name' => '状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '1草稿,2发布,3删除',
        ),'lang_id' => array(
            'name' => '语言', 'default' => '454',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '对应语言','is_show' => true, 
        ),'edit_time' => array(
            'name' => '更新时间', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '上一次更新时间','is_show' => false, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最近一次维护人员','is_show' => true, 
        ),);
}

?>
