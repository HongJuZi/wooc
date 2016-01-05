<?php 

/**
 * @version			$Id$
 * @create 			2015-10-15 10:10:37 By xjiujiu 
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
class VendortokenPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '第三方认证';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'vendortoken';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_vendortoken';

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
            'name' => '口令', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '认证口令','is_show' => true, 
        ),'parent_id' => array(
            'name' => '用户', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '对应用户编号','is_show' => true, 
        ),'vendor' => array(
            'name' => '第三方标识', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '建议使用英文','is_show' => true, 
        ),'content' => array(
            'name' => '内容', 
            'verify' => array(),
            'comment' => '验证配置具体内容。','is_show' => true, 
        ),'end_time' => array(
            'name' => '有效时间', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '口令的有效时间','is_show' => true, 
        ),'status' => array(
            'name' => '状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '分享同步状态1,没有,2正在同步','is_show' => true, 
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
