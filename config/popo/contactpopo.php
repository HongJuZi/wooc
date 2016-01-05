<?php 

/**
 * @version			$Id$
 * @create 			2015-05-04 22:05:05 By xjiujiu 
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
class ContactPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '联系方式';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'contact';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_contact';

    /**
     * @var string $primaryKey 表主键
     */
    public $primaryKey          = 'id';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '次序', 'default' => '999',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '显示的前后关系','is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '说明', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '联系方式说明信息','is_show' => true, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array( 'len' => 50,),
            'comment' => '唯一，最好用英文','is_show' => true, 
        ),'content' => array(
            'name' => '内容', 
            'verify' => array('null' => false,),
            'comment' => '联系方式内容。','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10',
        ),'author' => array(
            'name' => '维护人', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最后一次维护人员',
        ),);

}

?>
