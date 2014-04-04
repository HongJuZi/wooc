<?php 

/**
 * @version			$Id$
 * @create 			2014-02-25 19:02:57 By xjiujiu 
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
class GoodsPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '商品';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'goods';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'category';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_goods';

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
        ),'seo_keywords' => array(
            'name' => 'SEO关键字', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度范围：300字以内。',
        ),'seo_desc' => array(
            'name' => 'SEO描述', 
            'verify' => array( 'len' => 255,),
            'comment' => '长度范围：300字以内。',
        ),'parent_id' => array(
            'name' => '所属分类', 'default' => '-1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '请正确选取','is_show' => true, 
        ),'us_price' => array(
            'name' => '美元价', 'default' => '0',
            'verify' => array('null' => false,),
            'comment' => '美元对应的商品价格同，只能是数字。','is_show' => true, 
        ),'hk_price' => array(
            'name' => '港元价', 'default' => '0',
            'verify' => array('null' => false,),
            'comment' => '港元对应的商品价格同，只能是数字','is_show' => true, 
        ),'quantity' => array(
            'name' => '数量', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '商品总数量','is_show' => true, 
        ),'start_time' => array(
            'name' => '开始时间', 
            'verify' => array(),
            'comment' => '格式:：2013-09-09 08:09:09','is_show' => true, 
        ),'end_time' => array(
            'name' => '截止时间', 
            'verify' => array(),
            'comment' => '团购截止时间','is_show' => true, 
        ),'total_like' => array(
            'name' => '喜欢数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '商品总喜欢数情况','is_show' => true, 
        ),'size' => array(
            'name' => '商品尺寸', 
            'verify' => array( 'len' => 255,),
            'comment' => '商品的尺寸信息','is_show' => true, 
        ),'description' => array(
            'name' => '简要描述', 
            'verify' => array(),
            'comment' => '长度255字以内。',
        ),'content' => array(
            'name' => '详细内容', 
            'verify' => array(),
            'comment' => '长度10000字以内。',
        ),'album_hash' => array(
            'name' => '相册', 
            'verify' => array('null' => false, 'len' => 32,),
            'comment' => '相册标识','zoom' => array('small' => array(300, 320)), 'type' => array('.png', '.jpg', '.gif', '.bmp'), 'size' => 0.5
        ),'image_path' => array(
            'name' => '封面图片', 
            'verify' => array( 'len' => 255,),
            'comment' => '请选择允许的类型。','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'is_best' => array(
            'name' => '精品', 'default' => '否',
            'verify' => array('null' => false, 'options' => array('是','否'),),
            'comment' => '是否为精品商品。','is_show' => true, 
        ),'total_visits' => array(
            'name' => '访问总数', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '只能是数字。','is_show' => true, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10 08:09:09',
        ),'author' => array(
            'name' => '维护员', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '所属会员','is_show' => true, 
        ),);

}

?>
