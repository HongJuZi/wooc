<?php 

/**
 * @version			$Id$
 * @create 			2014-04-07 19:04:25 By xjiujiu 
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
class ResourcePopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '文件资源';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'resource';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_resource';

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
        ),'path' => array(
            'name' => '存储位置', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '请选择允许的类型。','is_show' => true, 'is_file' => true, 'size' => 2, 'type' => '*'
        ),'type' => array(
            'name' => '文件类型', 
            'verify' => array('null' => false, 'len' => 20,),
            'comment' => '文件扩展名','is_show' => true, 
        ),'fhash' => array(
            'name' => '文件哈希', 
            'verify' => array('null' => false, 'len' => 40,),
            'comment' => '用于对比文件是否改变','is_show' => true, 
        ),'total_use' => array(
            'name' => '使用数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '默认为0','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '维护员', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '所属会员','is_show' => true, 
        ),);

}

?>
