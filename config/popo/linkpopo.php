<?php 

/**
 * @version			$Id$
 * @create 			2015-04-21 01:04:52 By xjiujiu 
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
class LinkPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '友情链接';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'link';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'link';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_link';

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
            'comment' => '只能是数字，默认为：99999。','is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'url' => array(
            'name' => '链接', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '合法的URL发址','is_show' => true, 
        ),'description' => array(
            'name' => '内容简介', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度255字以内。','is_show' => true, 
        ),'image_path' => array(
            'name' => '图片', 
            'verify' => array( 'len' => 255,),
            'comment' => '请选择允许的类型。','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'lang_id' => array(
            'name' => '语言', 'default' => '454',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '对应语言','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10 10:00:00',
        ),'author' => array(
            'name' => '维护人', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最近一次维护人员','is_show' => true, 
        ),);

}

?>
