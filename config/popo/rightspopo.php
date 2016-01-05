<?php 

/**
 * @version			$Id$
 * @create 			2013-12-20 13:12:02 By xjiujiu 
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
class RightsPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '权限资源';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'rights';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'rights';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_rights';

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
            'name' => '名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array( 'len' => 50,),
            'comment' => '对应于代码里的模块或方法名称','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属模块', 'default' => '-1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '请正确选取','is_show' => true, 
        ),'app' => array(
            'name' => '应用', 
            'verify' => array( 'len' => 255,),
            'comment' => '所有在的应用','is_show' => true, 
        ),'description' => array(
            'name' => '内容简介', 
            'verify' => array(),
            'comment' => '长度255字以内。',
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '维护员', 'default' => '-1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '所属会员','is_show' => true, 
        ),);

}

?>
