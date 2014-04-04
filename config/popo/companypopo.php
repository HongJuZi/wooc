<?php 

/**
 * @version			$Id$
 * @create 			2014-03-31 15:03:10 By xjiujiu 
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
class CompanyPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '公司信息';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'company';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = '';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_company';

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
        ),'site_name' => array(
            'name' => '公司名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),'image_path' => array(
            'name' => '公司标志图片', 
            'verify' => array( 'len' => 255,),
            'comment' => '合法的图片地址，只支持jpg, png图片。','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'seo_keywords' => array(
            'name' => 'SEO关键字', 
            'verify' => array( 'len' => 255,),
            'comment' => '如公司的经营范围等长度范围：300以内。','is_show' => true, 
        ),'seo_desc' => array(
            'name' => 'SEO描述', 
            'verify' => array( 'len' => 255,),
            'comment' => '如，公司的经营理念及范围描述长度范围：300以内。','is_show' => true, 
        ),'description' => array(
            'name' => '公司简介', 
            'verify' => array(),
            'comment' => '长度255字以内。','is_show' => true, 
        ),'content' => array(
            'name' => '公司详细信息', 
            'verify' => array(),
            'comment' => '请录入贵公司的详细信息','is_show' => false, 
        ),'administrator' => array(
            'name' => '公司负责人', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度：1～255个字符。','is_show' => true, 
        ),'qq' => array(
            'name' => 'QQ号', 
            'verify' => array( 'len' => 50,),
            'comment' => '用于客服qq号','is_show' => true, 
        ),'weibo' => array(
            'name' => '微博地址', 
            'verify' => array( 'len' => 150,),
            'comment' => '网站微博地址，可以有多个，用“,”隔开',
        ),'weixin' => array(
            'name' => '公司微信账号', 
            'verify' => array( 'len' => 255,),
            'comment' => '请输入合法的微信账号信息','is_show' => true, 
        ),'wangwang' => array(
            'name' => '阿里旺旺账号', 
            'verify' => array( 'len' => 255,),
            'comment' => '多个请用逗号隔开，用于客服等','is_show' => true, 
        ),'email' => array(
            'name' => '邮箱地址', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '负责人联系邮箱','is_show' => true, 
        ),'phone' => array(
            'name' => '联系电话', 
            'verify' => array( 'len' => 50,),
            'comment' => '负责人联系电话',
        ),'fax' => array(
            'name' => '传真', 
            'verify' => array( 'len' => 50,),
            'comment' => '传真账号',
        ),'address' => array(
            'name' => '联系地址', 
            'verify' => array( 'len' => 255,),
            'comment' => '具体地理位置','is_show' => true, 
        ),'copyright' => array(
            'name' => '备案编号', 
            'verify' => array( 'len' => 255,),
            'comment' => '可选填 ，如果有备案请填写此项','is_show' => true, 
        ),'website_id' => array(
            'name' => '所属网站', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '数据所在的网站范围','is_show' => false, 
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10',
        ),'author' => array(
            'name' => '维护员', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '会员信息',
        ),);

}

?>
