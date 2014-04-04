<?php 

/**
 * @version			$Id$
 * @create 			2012-4-9 8:44:22 By xjiujiu
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
 * @package 		system.popo
 * @since 			1.0.0
 */
class ModelManagerPopo extends HPopo
{

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_modelmanager';

    /**
     * @var string $_parent 父类型名 
     */
    protected $_parent          = 'modelmanager';

    /**
     * @var string $_modelZhName 模块中文名称 
     */
    public $modelZhName         = '模块工具';

    /**
     * @var string $_modelEnName 模块英文名称 
     */
    public $modelEnName     = 'modelmanager';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array(
        'sort_num' => array(
            'name' => '排序编号',
            'is_order' => 'ASC',
            'is_show' => true,
            'default' => 9999
        ),
        'id' => array(
            'name' => 'ID',
            'is_search' => true,
            'is_order' => 'DESC',
            'is_show' => true
        ),
        'name' => array(
            'name' => '中文名称',
            'is_search' => true,
            'is_show' => true
        ),
        'identifier' => array(
            'name' => '标识',
            'is_search' => true,
            'is_order' => 'ASC',
            'is_show' => true
        ),
        'parent_id' => array(
            'name' => '所属父类',
            'is_show' => true
        ),
        'description' => array(
            'name' => '描述',
            'is_show' => false
        ),
        'on_desktop' => array(
            'name' => '显示到桌面',
            'default' =>'是',
            'is_show' => true
        ),
        'image_path' => array(
            'name' => '标志图',
            'is_show' => true,
            'is_file' => true,
            'size' => 0.5,
            'type' => array( '.jpg', '.gif', '.png'),
            'zoom' => array('small' => array(60, 60))
        ),
        'top' => array(
            'name' => '置顶',
            'default' =>'否',
            'is_show' => false
        ),
        'edit_time' => array(
            'name' => '编辑时间',
            'comment' => '格式示例：2012-04-11 18:31:30。'
        ),
        'create_time' => array(
            'name' => '创建时间',
            'is_show' => true,
            'comment' => '格式示例：2012-04-11 18:31:30。'
        ),
        'author' => array(
            'name' => '维护员',
            'is_show' => true,
            'comment' => '信息或模块的创建人。'
        )
    );

}

?>
