<?php 

/**
 * @version			$Id$
 * @create 			2015-04-22 09:04:52 By xjiujiu 
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
class AdvPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '大图展示';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'adv';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_adv';

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
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array( 'len' => 20,),
            'comment' => '字符串长度：20','is_show' => true, 
        ),'parent_id' => array(
            'name' => '位置', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '显示位置','is_show' => true, 
        ),'url' => array(
            'name' => '跳转链接', 'default' => '###',
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '合法的URL发址',
        ),'target' => array(
            'name' => '打开位置', 'default' => '_self',
            'verify' => array('null' => false, 'len' => 20,),
            'comment' => '当前窗口_self、新窗口_blank、自定义','is_show' => true, 
        ),'description' => array(
            'name' => '内容简介', 
            'verify' => array(),
            'comment' => '长度255字以内。','is_show' => true, 
        ),'image_path' => array(
            'name' => '图片', 
            'verify' => array( 'len' => 255,),
            'comment' => '请选择允许的类型。','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(300, 320)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最后一次维护人员','is_show' => false, 
        ),);

}

?>
