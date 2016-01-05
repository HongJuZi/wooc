<?php 

/**
 * @version			$Id$
 * @create 			2015-10-15 10:10:01 By xjiujiu 
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
class JobsPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '工作内推';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'jobs';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_jobs';

    /**
     * @var string $primaryKey 表主键
     */
    public $primaryKey          = 'id';

    /**
     * @var public static $statusMap      项目合作状态类型
     */
    public static $statusMap      = array(
        1 => array('id' => 1, 'name' => '招人中'),
        2 => array('id' => 2, 'name' => '结止'),
        3 => array('id' => 3, 'name' => '取消')
    );

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序', 'default' => '9999',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '显示排序','is_show' => true, 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '标题', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度255个字符','is_show' => true, 
        ),'company' => array(
            'name' => '公司名称', 
            'verify' => array( 'len' => 255,),
            'comment' => '公司名称','is_show' => true, 
        ),'url' => array(
            'name' => '公司网站', 
            'verify' => array( 'len' => 255,),
            'comment' => '公司官方网站','is_show' => true, 
        ),'job' => array(
            'name' => '职位', 
            'verify' => array( 'len' => 255,),
            'comment' => '职位名称','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属分类', 'default' => '0',
            'verify' => array( 'len' => 50,),
            'comment' => '请正确选取','is_show' => false, 
        ),'min_money' => array(
            'name' => '最小薪水', 
            'verify' => array(),
            'comment' => '薪水范围','is_show' => true, 
        ),'max_money' => array(
            'name' => '最大薪水', 
            'verify' => array(),
            'comment' => '薪水范围','is_show' => true, 
        ),'address' => array(
            'name' => '工作地点', 'is_show' => true,
            'verify' => array('null' => false),
            'comment' => '工作的工作地点','is_show' => true, 
        ),'content' => array(
            'name' => '详细内容', 
            'verify' => array(),
            'comment' => '长度1000字以内。',
        ),'end_time' => array(
            'name' => '结止时间', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '上一次最后的结止时间','is_show' => true, 
        ),'total_visits' => array(
            'name' => '阅读数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '总到访数','is_show' => true, 
        ),'total_comments' => array(
            'name' => '总评论数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '只能是数字','is_show' => true, 
        ),'status' => array(
            'name' => '状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '1草稿,2发布,3删除',
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '维护人', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最近一次维护人员','is_show' => true, 
        ),);

}

?>
