<?php 

/**
 * @version			$Id$
 * @create 			2014-01-23 21:01:06 By xjiujiu 
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
class RelationshipPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '外键关联';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'relationship';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'user';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_relationship';

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
        ),'type' => array(
            'name' => '关联类型', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '如：评论有1-赞、弱，还有2-举报的关联,3评论关联。',
        ),'item_id' => array(
            'name' => '项目ID', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '需要的关联 的项目','is_show' => true, 
        ),'rel_id' => array(
            'name' => '关联ID', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '所属关联的项目','is_show' => true, 
        ),'model' => array(
            'name' => '模块', 'default' => 'article',
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '所在模块','is_show' => true, 
        ),'author' => array(
            'name' => '维护员', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '所属会员','is_show' => true, 
        ),);
}

?>
