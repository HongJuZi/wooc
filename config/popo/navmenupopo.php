<?php 

/**
 * @version			$Id$
 * @create 			2013-12-20 13:12:57 By xjiujiu 
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
class NavmenuPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '导航菜单';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'navmenu';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'navmenu';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_navmenu';

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
            'comment' => '只能是数字，默认为：当前时间。','is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '标题', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'jump_url' => array(
            'name' => '跳转链接', 
            'verify' => array( 'len' => 255,),
            'comment' => '合法的URL发址','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属分类', 'default' => '-1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '请正确选取','is_show' => true, 
        ),'description' => array(
            'name' => '内容简介', 
            'verify' => array(),
            'comment' => '长度255字以内。',
        ),'top' => array(
            'name' => '置顶状态', 'default' => '否',
            'verify' => array('null' => false, 'options' => array('是','否'),),
            'comment' => '置顶后信息将优先显示','is_show' => true, 'is_order' => 'ASC', 
        ),'website_id' => array(
            'name' => '所属网站', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '数据所在的网站范围','is_show' => false, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10',
        ),'author' => array(
            'name' => '维护员', 'default' => '-1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '所属会员',
        ),);

}

?>
