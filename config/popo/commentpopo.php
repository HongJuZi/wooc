<?php 

/**
 * @version			$Id$
 * @create 			2014-01-27 15:01:05 By xjiujiu 
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
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'content' => array(
            'name' => '详细内容', 
            'verify' => array('null' => false,),
            'comment' => '长度1000字以内。','is_show' => true, 
        ),'item_id' => array(
            'name' => '信息ID', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '所属信息ID','is_show' => true, 
        ),'model' => array(
            'name' => '所属模块', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '所属模块','is_show' => true, 
        ),'parent_id' => array(
            'name' => '发表人', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '会员所属所员','is_show' => true, 
        ),'reply_to' => array(
            'name' => '回复给', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '被回复的用户ID','is_show' => true, 
        ),'pass' => array(
            'name' => '审查状态', 'default' => '是',
            'verify' => array('null' => false, 'options' => array('是','否'),),
            'comment' => '请从下拉选择',
        ),'hash' => array(
            'name' => '哈希码', 
            'verify' => array( 'len' => 32,),
            'comment' => '用于关联附件','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最近一次维护人员','is_show' => true, 
        ),);

}

?>
