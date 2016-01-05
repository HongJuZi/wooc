<?php 

/**
 * @version			$Id$
 * @create 			2015-05-04 23:05:35 By xjiujiu 
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
class ThemePopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '主题风格';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'theme';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_theme';

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
            'name' => '标题', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '跟模板目录名称一致','is_show' => true, 
        ),'description' => array(
            'name' => '模板介绍', 
            'verify' => array('null' => false,),
            'comment' => '模板相关描述信息。','is_show' => false, 
        ),'image_path' => array(
            'name' => '预览图片', 
            'verify' => array( 'len' => 255,),
            'comment' => '图片地址','is_show' => true, 
        ),'tag' => array(
            'name' => '标签', 'default' => 'all',
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '模板的关键词','is_show' => false, 
        ),'publisher' => array(
            'name' => '作者', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '开发作者','is_show' => true, 
        ),'website' => array(
            'name' => '作者网站', 
            'verify' => array( 'len' => 255,),
            'comment' => '作者个人的网站','is_show' => true, 
        ),'version' => array(
            'name' => '版本', 'default' => '1.0',
            'verify' => array('null' => false, 'len' => 20,),
            'comment' => '模板版本号','is_show' => true, 
        ),'app' => array(
            'name' => '应用', 'default' => 'cms',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '对应有效的应用','is_show' => true, 
        ),'status' => array(
            'name' => '状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '1不使用、2使用、3删除','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => false, 
        ),'author' => array(
            'name' => '作者', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '用户的ID','is_show' => false, 
        ),);

}

?>
