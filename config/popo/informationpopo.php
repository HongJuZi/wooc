<?php 

/**
 * @version			$Id$
 * @create 			2015-04-21 01:04:32 By xjiujiu 
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
class InformationPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '网站信息管理';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'information';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_information';

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
        ),'name' => array(
            'name' => '网站名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'image_path' => array(
            'name' => '网站LOGO', 
            'verify' => array( 'len' => 255,),
            'comment' => '合法的图片地址，只支持jpg, png图片。','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'seo_keywords' => array(
            'name' => 'SEO关键字', 
            'verify' => array( 'len' => 255,),
            'comment' => '如公司的经营范围等长度范围：300以内。','is_show' => true, 
        ),'seo_desc' => array(
            'name' => 'SEO描述', 
            'verify' => array( 'len' => 255,),
            'comment' => '如，公司的经营理念及范围描述长度范围：300以内。','is_show' => true, 
        ),'description' => array(
            'name' => '网站简介', 
            'verify' => array(),
            'comment' => '长度255字以内。',
        ),'copyright' => array(
            'name' => '备案编号', 
            'verify' => array( 'len' => 255,),
            'comment' => '可选填 ，如果有备案请填写此项',
        ),'tongji_code' => array(
            'name' => '统计代码', 
            'verify' => array(),
            'comment' => '可选填 ，为您的网站加上统计功能',
        ),'lang_id' => array(
            'name' => '语言', 'default' => '454',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '网站使用的语言','is_show' => true, 
        ),'is_default' => array(
            'name' => '默认', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '1否2是','is_show' => true, 
        ),'is_open' => array(
            'name' => '开放', 'default' => '2',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '1是,2否','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10',
        ),'author' => array(
            'name' => '维护员', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '会员信息',
        ),);

}

?>
