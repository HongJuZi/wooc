<?php 

/**
 * @version			$Id$
 * @create 			2016-01-04 22:01:51 By xjiujiu 
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
class MessagePopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '访客留言';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'message';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_message';

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
            'name' => '称呼', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'phone' => array(
            'name' => '手机号码', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 
        ),'email' => array(
            'name' => '邮箱', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 
        ),'content' => array(
            'name' => '详细内容', 
            'verify' => array('null' => false,),
            'comment' => '长度10000字以内。',
        ),'ip' => array(
            'name' => 'IP', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '留言都使用的IP地址','is_show' => true, 
        ),'status' => array(
            'name' => '状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '1正在处理,2删除,3解决',
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 'default' => '-1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最后一次修改人员','is_show' => true, 
        ),);

}

?>
