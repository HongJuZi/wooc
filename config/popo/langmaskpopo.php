<?php 

/**
 * @version			$Id$
 * @create 			2013-08-08 12:08:03 By xjiujiu 
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
class LangmaskPopo extends HPopo
{

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_langmask';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '语言标识';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'langmask';

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('id' => array(
            'name' => 'ID',
            'comment' => '只能是数字',
            'is_show' => true, 'is_order' => 'DESC', 
        ),'name' => array(
            'name' => '标记',
            'comment' => '长度范围：2~255。',
            'is_show' => true, 'is_search' => true, 
        ),'create_time' => array(
            'name' => '创建时间',
            'comment' => '格式：2013-04-10',
            'is_show' => true, 
        ),'author' => array(
            'name' => '操作人',
            'comment' => '用户',
            'is_show' => true, 
        )
    );

}

?>
