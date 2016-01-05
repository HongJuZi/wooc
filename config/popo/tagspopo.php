<?php 

/**
 * @version			$Id$
 * @create 			2015-03-08 12:03:05 By xjiujiu 
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
class TagsPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '标签';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'tags';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_tags';

    /**
     * @var string $primaryKey 表主键
     */
    public $primaryKey          = 'id';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('id' => array(
            'name' => '编号', 
            'verify' => array(),
            'comment' => '系统自动增加','is_show' => true, 
            'is_order' => 'DESC'
        ),'name' => array(
            'name' => '名称', 
            'verify' => array('null' => false, 'len' => 200,),
            'comment' => '标签名称','is_show' => true, 
        ),'hots' => array(
            'name' => '使用总数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '标签被使用总数','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '记录创建时间','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '信息最后一次发布人员','is_show' => false, 
        ),);

}

?>
