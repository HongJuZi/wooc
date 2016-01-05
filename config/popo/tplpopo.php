<?php 

/**
 * @version			$Id$
 * @create 			2015-04-07 22:04:48 By xjiujiu 
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
class TplPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '模板';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'tpl';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_tpl';

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
        ),'app' => array(
            'name' => '所属应用', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '所属的应用','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '操作人', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '管理人员','is_show' => true, 
        ),);

}

?>
