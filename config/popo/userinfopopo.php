<?php 

/**
 * @version			$Id$
 * @create 			2013-12-20 13:12:45 By xjiujiu 
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
class UserinfoPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '用户扩展信息';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'userinfo';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'user';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_userinfo';

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
            'comment' => '系统自动编号','is_show' => true, 
        ),'share' => array(
            'name' => '分享数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '总的分享数缓存','is_show' => true, 
        ),'watched' => array(
            'name' => '观注数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '用户总的观注数缓存','is_show' => true, 
        ),'followed' => array(
            'name' => '听从数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '用户总的听众数缓存','is_show' => true, 
        ),'tags' => array(
            'name' => '标签', 
            'verify' => array( 'len' => 255,),
            'comment' => '用户个人标签','is_show' => true, 
        ),'school' => array(
            'name' => '所在大学', 
            'verify' => array( 'len' => 100,),
            'comment' => '长下拉','is_show' => true, 
        ),'department' => array(
            'name' => '专业', 
            'verify' => array( 'len' => 100,),
            'comment' => '字符串长度：20','is_show' => true, 
        ),'class' => array(
            'name' => '班级', 
            'verify' => array( 'len' => 50,),
            'comment' => '字符长度50。','is_show' => true, 
        ),'birthday' => array(
            'name' => '出生年月', 
            'verify' => array( 'len' => 10,),
            'comment' => '出生信息','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属用户', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '关联用户ID','is_show' => true, 
        ),'url' => array(
            'name' => '个人主页', 
            'verify' => array( 'len' => 255,),
            'comment' => '个人网站地址',
        ),'location' => array(
            'name' => '地址', 
            'verify' => array( 'len' => 255,),
            'comment' => '用户地址信息',
        ),'city' => array(
            'name' => '城市ID', 
            'verify' => array( 'numeric' => true,),
            'comment' => '所在城市ID',
        ),'province' => array(
            'name' => '省ID', 
            'verify' => array( 'numeric' => true,),
            'comment' => '所在省ID',
        ),'edit_time' => array(
            'name' => '编辑时间', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '上一次编辑时间格式：2013-04-10','is_show' => true, 
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
