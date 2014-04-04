<?php 

/**
 * @version			$Id$
 * @create 			2013-10-30 12:10:50 By xjiujiu 
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
class LangPopo extends HPopo
{

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_lang';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'langtype';

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '语言翻译';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'lang';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序', 'default' => '9999',
            'verify' => array('null' => true, 'is_numeric' => true,),
            'comment' => '只能是数字，默认为：99999。','is_show' => true, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array('null' => true, 'is_numeric' => true,),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '名称', 
            'verify' => array('null' => true, 'max_len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'parent_id' => array(
            'name' => '所属分类', 'default' => '-1',
            'verify' => array( 'is_numeric' => true,),
            'comment' => '请正确选取',
        ),'mask_id' => array(
            'name' => '对应标识', 
            'verify' => array( 'is_numeric' => true,),
            'comment' => '语言标识长度255字以内。','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => true,),
            'comment' => '格式：2013-04-10','is_show' => true, 
        ),'author' => array(
            'name' => '操作人', 'default' => '1',
            'verify' => array('null' => true, 'is_numeric' => true,),
            'comment' => '所属会员','is_show' => true, 
        ),);

}

?>
