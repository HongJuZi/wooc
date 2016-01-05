<?php 

/**
 * @version			$Id$
 * @create 			2015-04-22 22:04:44 By xjiujiu 
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
            'name' => '排序', 'default' => '999',
            'verify' => array('null' => false,),
            'comment' => '只能是数字，默认为：当前时间。','is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '标题', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'url' => array(
            'name' => '跳转链接', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '合法的URL发址','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属分类', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '请正确选取','is_show' => true, 
        ),'position_id' => array(
            'name' => '位置', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '菜单显示的位置','is_show' => true, 
        ),'description' => array(
            'name' => '内容简介', 
            'verify' => array(),
            'comment' => '长度255字以内。','is_show' => true,
        ),'target' => array(
            'name' => '打开位置', 'default' => '_self',
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '_self本窗口、_blank新开窗口、自定义','is_show' => true, 
        ),'extend' => array(
            'name' => '自定义数据', 
            'verify' => array( 'len' => 255,),
            'comment' => '如标识、扩展类名等','is_show' => true, 
        ),'lang_id' => array(
            'name' => '语言', 'default' => '454',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '对应语言','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10',
        ),'author' => array(
            'name' => '维护员', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '所属会员',
        ),);

}

?>
