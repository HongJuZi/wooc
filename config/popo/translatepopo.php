<?php 

/**
 * @version			$Id$
 * @create 			2015-04-14 20:04:20 By xjiujiu 
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
class TranslatePopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '翻译';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'translate';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_translate';

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
            'name' => '翻译', 
            'verify' => array('null' => false,),
            'comment' => '翻译内容','is_show' => true, 
        ),'mark_id' => array(
            'name' => '标识', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '对应的标识编号','is_show' => true, 
        ),'parent_id' => array(
            'name' => '语言', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '对应语言的编号','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '关联添加的时间表',
        ),'author' => array(
            'name' => '维护人', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '文件审核人','is_show' => false, 
        ),);

}

?>
