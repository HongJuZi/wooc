<?php 

/**
 * @version			$Id$
 * @create 			2013-12-20 13:12:10 By xjiujiu 
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
class TagsPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '标签';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'tags';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_tags';

    /**
     * @var string $primaryKey 表主键
     */
    public $primaryKey          = 'id';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序', 
            'verify' => array(),
            'comment' => '只能是数字，默认为：当前时间。','is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'hots' => array(
            'name' => '使用量', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '被使用的次数','is_show' => true, 
        ),'top' => array(
            'name' => '置顶状态', 'default' => '否',
            'verify' => array('null' => false, 'options' => array('是','否'),),
            'comment' => '请从下拉选择','is_show' => true, 
        ),'author' => array(
            'name' => '维护员', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '上一次修改的用户','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),);

}

?>
