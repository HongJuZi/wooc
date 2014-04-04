<?php 

/**
 * @version			$Id$
 * @create 			2013-12-20 14:12:55 By xjiujiu 
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
class ConfigPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '网站信息配置';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'config';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_config';

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
        ),'site_name' => array(
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
            'comment' => '长度范围：300以内。','is_show' => true, 
        ),'seo_desc' => array(
            'name' => 'SEO描述', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度范围：300以内。','is_show' => true, 
        ),'administrator' => array(
            'name' => '网站负责人', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '网站的所有者或是管理员。','is_show' => true, 
        ),'qq' => array(
            'name' => 'QQ号', 
            'verify' => array( 'len' => 50,),
            'comment' => '常用qq号','is_show' => true, 
        ),'email' => array(
            'name' => '邮箱地址', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '负责人联系邮箱','is_show' => true, 
        ),'phone' => array(
            'name' => '联系电话', 
            'verify' => array( 'len' => 50,),
            'comment' => '负责人联系电话',
        ),'fax' => array(
            'name' => '传真', 
            'verify' => array( 'len' => 50,),
            'comment' => '传真账号',
        ),'weibo' => array(
            'name' => '微博地址', 
            'verify' => array( 'len' => 150,),
            'comment' => '网站微博地址，可以有多个，用“,”隔开',
        ),'address' => array(
            'name' => '联系地址', 
            'verify' => array( 'len' => 255,),
            'comment' => '具体地理位置','is_show' => true, 
        ),'copyright' => array(
            'name' => '版本信息', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '所有权及备案信息',
        ),'website_id' => array(
            'name' => '所属网站', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '数据所在的网站范围','is_show' => false, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10',
        ),'author' => array(
            'name' => '维护员', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '会员信息',
        ),);

}

?>
