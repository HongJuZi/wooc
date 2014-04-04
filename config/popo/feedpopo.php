<?php 

/**
 * @version			$Id$
 * @create 			2014-02-18 17:02:59 By xjiujiu 
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
class FeedPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '系统消息';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'feed';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'user';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_feed';

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
        ),'parent_id' => array(
            'name' => '接收用户', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '动态对应的信息ID','is_show' => true, 
        ),'content' => array(
            'name' => '详细内容', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度206字以内。',
        ),'item_id' => array(
            'name' => '信息对象', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '发起的信息ID',
        ),'status' => array(
            'name' => '状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '文章存储状态1正常，2草稿，3删除','is_show' => true, 
        ),'type' => array(
            'name' => '通知类型', 'default' => '4',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '说明：1赞,2弱,3收藏,4系统',
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
