<?php 

/**
 * @version			$Id$
 * @create 			2015-05-02 22:05:02 By xjiujiu 
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
class SharesettingPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '分享设置';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'sharesetting';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_sharesetting';

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
            'name' => '分享名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '第三方分享名称','is_show' => true, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '唯一，建议使用英文','is_show' => true, 
        ),'appid' => array(
            'name' => 'apiID', 'default' => '',
            'verify' => array('null' => false, 'len' => 32,),
            'comment' => '认证口令','is_show' => true, 
        ),'content' => array(
            'name' => '验证链接', 
            'verify' => array( 'len' => 100,),
            'comment' => 'key值验证链接。','is_show' => true, 
        ),'key' => array(
            'name' => '认证key值', 'default' => '',
            'verify' => array('null' => false, 'len' => 64,),
            'comment' => '认证的key值','is_show' => true, 
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
