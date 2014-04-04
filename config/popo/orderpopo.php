<?php 

/**
 * @version			$Id$
 * @create 			2014-02-26 11:02:39 By xjiujiu 
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
class OrderPopo extends HPopo
{

    /**
     * @var string $modelZhName 模块中文名称 
     */
    public $modelZhName         = '用户订单';

    /**
     * @var string $modelEnName 模块英文名称 
     */
    public $modelEnName         = 'order';

    /**
     * @var string $_parentTable 父表名 
     */
    protected $_parent          = 'user';

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_order';

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
            'comment' => '系统编号','is_show' => true, 
        ),'code' => array(
            'name' => '订单号', 
            'verify' => array('null' => false, 'len' => 12,),
            'comment' => '系统自动生成订单号','is_show' => true, 
        ),'name' => array(
            'name' => '用户名', 
            'verify' => array('null' => false, 'len' => 50,),
            'comment' => '登录系统使用的账号','is_show' => true, 
        ),'parent_id' => array(
            'name' => '所属用户', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '订单所属的用户','is_show' => true, 
        ),'phone' => array(
            'name' => '联络电话', 
            'verify' => array( 'len' => 20,),
            'comment' => '用户常用电话号码','is_show' => true, 
        ),'email' => array(
            'name' => '邮箱', 
            'verify' => array( 'len' => 50,),
            'comment' => '常用邮箱地址','is_show' => true, 
        ),'url' => array(
            'name' => '货品网址', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '正确的URL地址','is_show' => true, 
        ),'goods_name' => array(
            'name' => '货品名称', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '字符长度：1~255。','is_show' => true, 
        ),'price' => array(
            'name' => '货品价钱', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '只能是数字','is_show' => true, 
        ),'color' => array(
            'name' => '货品颜色', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '货品指定的颜色信息','is_show' => true, 
        ),'size' => array(
            'name' => '货品尺码', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '尺码信息，长度：1～255个字符','is_show' => true, 
        ),'number' => array(
            'name' => '购买数量', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '只能是数字','is_show' => true, 
        ),'category' => array(
            'name' => '货品种类', 
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '用户想买的货品种类','is_show' => true, 
        ),'comment' => array(
            'name' => '备注', 
            'verify' => array( 'len' => 255,),
            'comment' => '附加说明信息，1～255个字符','is_show' => true, 
        ),'image_path' => array(
            'name' => '头像', 
            'verify' => array( 'len' => 255,),
            'comment' => '用户头像,支持jpg','is_show' => true, 'is_file' => true, 'zoom' => array('small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5
        ),'status' => array(
            'name' => '订单状态', 'default' => '1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '订单当前的状态，1正常，2正在处理，3已经发货','is_show' => true, 
        ),'need_next' => array(
            'name' => '下一件', 'default' => '否',
            'verify' => array('null' => false, 'options' => array('是','否'),),
            'comment' => '是否需要订购下一件货品，默认否','is_show' => true, 
        ),'edit_time' => array(
            'name' => '编辑时间', 
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '最近一次修改时间',
        ),'create_time' => array(
            'name' => '创建时间', 
            'verify' => array('null' => false,),
            'comment' => '格式：2013-04-10 08:09:09',
        ),'author' => array(
            'name' => '维护员', 'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '上一次修改的管理员','is_show' => true, 
        ),);

}

?>
