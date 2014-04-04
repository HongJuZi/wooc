<?php 

/**
 * @version			$Id$
 * @create 			2013-08-08 12:08:50 By xjiujiu 
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
 * @package 		system.popo
 * @since 			1.0.0
 */
class LangtypePopo extends HPopo
{

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_langtype';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'langtype';

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '语言种类';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'langtype';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序',
            'comment' => '只能是数字，默认为：99999。',
            'is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID',
            'comment' => '只能是数字',
            'is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '名称',
            'comment' => '长度范围：2~255。',
            'is_show' => true, 'is_search' => true, 
        ),'identifier' => array(
            'name' => '标识',
            'is_show' => true,'comment' => '长度范围20字符',
        ),'parent_id' => array(
            'name' => '所属分类',
            'comment' => '请正确选取',
        ),'description' => array(
            'name' => '内容简介',
            'comment' => '长度255字以内。',
            
        ),'create_time' => array(
            'name' => '创建时间',
            'comment' => '格式：2013-04-10',
            'is_show' => true, 
        ),'author' => array(
            'name' => '操作人',
            'comment' => '所属会员',
            'is_show' => true, 
        )
    );

}

?>
