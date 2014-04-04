<?php 

/**
 * @version			$Id$
 * @create 			2013-08-08 16:08:48 By xjiujiu 
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
class TplPopo extends HPopo
{

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_tpl';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '模板';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'tpl';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('id' => array(
            'name' => 'ID',
            'comment' => '只能是数字',
            'is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '名称',
            'comment' => '长度范围：2~255。',
            'is_show' => true, 'is_search' => true, 
        ),'app' => array(
            'name' => '所属应用',
            'comment' => '长度：50个字符。',
            'is_show' => true, 'is_search' => true, 
        ),'hash' => array(
            'name' => '哈希码',
            'comment' => '唯一标识',
            
        ),'create_time' => array(
            'name' => '创建时间',
            'comment' => '格式：2013-04-10',
            'is_show' => true, 
        ),'author' => array(
            'name' => '操作人',
            'comment' => '管理人员',
            'is_show' => true, 
        )
    );

}

?>
