<?php 

/**
 * @version			$Id$
 * @create 			2012-4-9 8:44:22 By xjiujiu
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
class ModelManagerPopo extends HPopo
{

    /**
     * @var string $_table 模块表名 
     */
    protected $_table           = '#_modelmanager';

    /**
     * @var string $_parent 父类型名 
     */
    protected $_parent          = 'modelmanager';

    /**
     * @var string $_modelZhName 模块中文名称 
     */
    public $modelZhName         = '系统模块';

    /**
     * @var string $_modelEnName 模块英文名称 
     */
    public $modelEnName     = 'modelmanager';

    /**
     * @var public static $hasMultiLangMap     多语言配置表
     */
    public static $hasMultiLangMap     = array(
        '1' => array('id' => 1, 'name' => '不支持'),
        '2' => array('id' => 2, 'name' => '支持')
    );

    /**
     * @var array $_fields 模块字段配置 
     */
    protected $_fields          = array('sort_num' => array(
            'name' => '排序', 
            'verify' => array(),
            'comment' => '只能是数字，默认为：当前时间。','is_show' => false, 'is_order' => 'ASC', 
        ),'id' => array(
            'name' => 'ID', 
            'verify' => array(),
            'comment' => '只能是数字','is_show' => true, 'is_order' => 'DESC', 
        ),
        'name' => array(
            'name' => '中文名称',
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),
        'identifier' => array(
            'name' => '标识',
            'verify' => array('null' => false, 'len' => 255,),
            'comment' => '长度范围：2~255。','is_show' => true, 'is_search' => true, 
        ),
        'parent_id' => array(
            'name' => '所属父类',
            'default' => '0',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '请正确选取','is_show' => true, 
        ),
        'description' => array(
            'name' => '描述',
            'is_show' => true 
        ),
        'type' => array(
            'name' => '类型',
            'default' =>'1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '类型','is_show' => true
        ),
        'image_path' => array(
            'name' => '形象图片',
            'is_show' => true, 'is_file' => true,
            'size' => 0.5, 'type' => array( '.jpg', '.gif', '.png'), 'zoom' => array('small' => array(60, 60))
        ),
        'has_multi_lang' => array(
            'name' => '多语言',
            'default' =>'1',
            'verify' => array('null' => false, 'numeric' => true,),
            'comment' => '是否支持多语言','is_show' => true
        ),
        'create_time' => array(
            'name' => '创建时间',
            'is_show' => true,
            'comment' => '格式示例：2012-04-11 18:31:30。'
        ),
        'author' => array(
            'name' => '维护员',
            'is_show' => false,
            'comment' => '信息或模块的创建人。'
        )
    );

    /**
     * @var string $_dbEngine 数据库引擎 
     */
    protected $_dbEngine    = 'MyISAM';

    /**
     * @var string $_dbCharset 数据库数据集 
     */
    protected $_dbCharset   = 'utf8';

    /**
     * @var Array<String, Array<?,?> $filesMap 代码文件模板
     */
    //TODO:: tpl有主题的问题如：default或是其它，所有的app是不是可以统一的进行替换～
    public static $filesMap = array(
        'popo' => array(
            'src' => 'app/wizard/data/popo/popo.hd',
            'desc' => 'config/popo/%spopo.php'
        ),
        'model' => array(
            'src' => 'app/wizard/data/model/model.hd',
            'desc' => 'model/%smodel.php'
        ),
        'action' => array(
            'admin' => array(
                'src' => 'app/wizard/data/action/adminaction.hd',
                'desc' => 'app/{app}/action/%saction.php'
            ),
            'other' => array(
                'src' => 'app/wizard/data/action/action.hd',
                'desc' => 'app/{app}/action/%saction.php'
            )
        ),
        'tpl' => array(
            'admin' => array(
                'src' => 'app/wizard/data/html/admin/info.hd',
                'desc' => 'static/template/admin/default/%s/info.tpl',
            )
        ),
        'res' => 'static/resource/'
    );

    /**
     * @var Array $deleteResources 需要删除的资源
     */
    public static $deleteResources  = array(
        'model' => array('model/%smodel.php', 'config/popo/%spopo.php'),
        'app' => array('app/%s/action/%saction.php', 'static/template/%s/%s/')
    );

    /**
     * @var Array<String, String> $_fieldMaskCfgMap 字段标识配置表
     */
    public static $fieldMaskCfgMap        = array(
        'link' => "'is_link' => true",
        'show' => "'is_show' => true",
        'hide' => "'is_show' => false",
        'asc' => "'is_order' => 'ASC'",
        'desc' => "'is_order' => 'DESC'",
        'album' => "'zoom' => array('small' => array(300, 320)), 'type' => array('.png', '.jpg', '.gif', '.bmp'), 'size' => 0.5",
        'image' => "'is_file' => true, 'zoom' => array('small' => array(100, 120)), 'type' => array('.png', '.jpg', '.gif'), 'size' => 0.5",
        'file' => "'is_file' => true, 'size' => 2, 'type' => '*'",
        'search' => "'is_search' => true"
    );

}

?>
