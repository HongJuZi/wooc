<?php 

/**
 * @version			$Id$
 * @create 			2014-03-22 13:03:27 By xjiujiu 
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
class UserPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '用户';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'user';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'actor';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_user';

    /**
     * @var string $primaryKey 表主键
     */
    public $primaryKey          = 'id';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序', 
            'verify' => array( 'numeric' => true,),
            'comment' => '只能是数字，默认为：当前时间。','is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '系统编号','is_show' => true, 
        ),'name' => array(
            'name' => '用户名', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '登录系统使用的账号','is_show' => true, 
        ),'password' => array(
            'name' => '密码', 
            'verify' => array( 'len' => 32,),
            'comment' => '登录系统密码',
        ),'sex' => array(
            'name' => '性别', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '用户性别：1，男；2，女；3. 其它。','is_show' => true, 
        ),'age' => array(
            'name' => '年龄', 'default' => '0',
            'verify' => array('null' => false, 'len' => 20,),
            'comment' => '用户真实年龄','is_show' => false, 
        ),'birthday' => array(
            'name' => '出生日期', 
            'verify' => array('null' => false,),
            'comment' => '格式：YYYY-MM-DD','is_show' => false, 
        ),'parent_id' => array(
            'name' => '所属角色', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '用户所具有的权限','is_show' => true, 
        ),'description' => array(
            'name' => '简介', 
            'verify' => array( 'len' => 255,),
            'comment' => '用户信息简介',
        ),'image_path' => array(
            'name' => '头像', 
            'verify' => array( 'len' => 255,),
            'comment' => '用户头像,支持jpg','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'qq' => array(
            'name' => 'QQ', 
            'verify' => array( 'len' => 20,),
            'comment' => '常用QQ号','is_show' => true, 
        ),'email' => array(
            'name' => '邮箱', 
            'verify' => array( 'len' => 50,),
            'comment' => '常用邮箱地址','is_show' => true, 
        ),'phone' => array(
            'name' => '电话号码', 
            'verify' => array( 'len' => 30,),
            'comment' => '常用电话号码，方便联系','is_show' => false, 
        ),'hash' => array(
            'name' => '哈希', 
            'verify' => array( 'len' => 60,),
            'comment' => '记录用户的登陆状态',
        ),'pass' => array(
            'name' => '审核状态', 'default' => '是',
            'verify' => array('null' => false, 'options' => array('是','否'),),
            'comment' => '通过的信息才能被用户看到',
        ),'edit_time' => array(
            'name' => '编辑时间', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最近一次修改时间',
        ),'ip' => array(
            'name' => '登陆IP', 
            'verify' => array('null' => false, 'len' => 32,),
            'comment' => '上一次登陆IP','is_show' => false, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10 08:09:09',
        ),'author' => array(
            'name' => '维护员', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '上一次修改的管理员','is_show' => true, 
        ),);

}

?>
