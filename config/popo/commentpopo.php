<?php 

/**
 * @version			$Id$
 * @create 			2015-03-08 12:03:12 By xjiujiu 
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
class CommentPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '评论';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'comment';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'user';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_comment';

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
            'comment' => '系统编号','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '维护人', 
            'verify' => array('null' => false,),
            'comment' => '信息最后一次维护人','is_show' => true, 
        ),'email' => array(
            'name' => '邮箱', 
            'verify' => array('null' => false, 'len' => 100,),
            'comment' => '评论人联系邮箱','is_show' => true, 
        ),'content' => array(
            'name' => '评论内容', 
            'verify' => array('null' => false, 'len' => 500,),
            'comment' => '长度255','is_show' => true, 
        ),'item_id' => array(
            'name' => '文章', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '被评论的文章','is_show' => true, 
        ),'status' => array(
            'name' => '状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '1, 正常, 2 删除','is_show' => true, 
        ),'ip' => array(
            'name' => 'IP', 
            'verify' => array('null' => false, 'len' => 100,),
            'comment' => '评论的IP地址','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '评论提交时间','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '信息最后一次维护人','is_show' => true, 
        ),);

}

?>
