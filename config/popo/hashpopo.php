<?php 

/**
 * @version			$Id$
 * @create 			2014-01-10 10:01:13 By xjiujiu 
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
class HashPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = 'hash模块';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'hash';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_hash';

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
        ),'hash' => array(
            'name' => '哈希码', 
            'verify' => array('null' => false, 'len' => 32,),
            'comment' => '32位随机生成','is_show' => true, 
        ),'parent_id' => array(
            'name' => '用户', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '用户ID值','is_show' => true, 
        ),'end_time' => array(
            'name' => '有效时间', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '哈希值有效时间','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10 08:09:09',
        ),);

}

?>