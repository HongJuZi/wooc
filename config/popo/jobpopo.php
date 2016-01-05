<?php 

/**
 * @version			$Id$
 * @create 			2015-05-31 21:05:51 By xjiujiu 
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
class JobPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '自动化工作包';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'job';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_job';

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
            'comment' => '自动编号','is_show' => true, 
        ),'name' => array(
            'name' => '名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '任务名称','is_show' => true, 
        ),'identifier' => array(
            'name' => '标识', 
            'verify' => array('null' => false, 'len' => 30,),
            'comment' => '英语唯一','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属分类', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '请正确选取','is_show' => true, 
        ),'description' => array(
            'name' => '说明', 
            'verify' => array( 'len' => 255,),
            'comment' => '任务说明信息','is_show' => true, 
        ),'cfg' => array(
            'name' => '配置', 
            'verify' => array('null' => false,),
            'comment' => '任务配置项目','is_show' => true, 
        ),'hours' => array(
            'name' => '执行时长', 'default' => '1',
            'verify' => array('null' => false,),
            'comment' => '任务执行的时间长度','is_show' => true, 
        ),'status' => array(
            'name' => '状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '任务执行状态：0停止，1开始，2暂停','is_show' => true, 
        ),'edit_time' => array(
            'name' => '编辑时间', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '格式:：2013-09-09 08:09:09',
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '维护员', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '上一次修改的管理员','is_show' => true, 
        ),);

}

?>
