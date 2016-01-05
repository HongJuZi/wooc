<?php 

/**
 * @version			$Id$
 * @create 			2013-12-20 17:12:08 By xjiujiu 
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
class ActorPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '角色';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'actor';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_actor';

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
            'name' => '编号', 
            'verify' => array(),
            'comment' => '系统自动编号','is_show' => true, 
        ),'name' => array(
            'name' => '名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度255','is_show' => true, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array( 'len' => 20,),
            'comment' => '字符串长度：20','is_show' => true, 
        ),'description' => array(
            'name' => '描述', 
            'verify' => array(),
            'comment' => '角色介绍信息',
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10 08:09:09',
        ),'author' => array(
            'name' => '维护员', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '上一次修改的管理员','is_show' => true, 
        ),);

}

?>
