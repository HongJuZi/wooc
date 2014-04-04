<?php

/**
 * @version			$Id$
 * @create 			2012-5-11 22:19:13 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminAction');
HClass::import('vendor.sdk.taobao.TopSdk', false);

/**
 * 发送邮件工具控制层类 
 * 
 * 封装了对邮件发送功能，如同时给多人发送、添加附件等
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class AlimamaAction extends AdminAction
{

    /**
     * @var private $_client SDK客户端调用对象
     */
    private $_client;

    /**
     * 构造函数
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_initClient();
    }
    
    /**
     * 主页方法
     * 
     * @desc
     * 
     * @access public
     */
    public function index()
    {
        $req = $this->_loadApi('ItemcatsGetRequest');
        $req->setFields("cid,parent_cid,name,is_parent");
        $req->setParentCid(0);
        $resp = $this->_client->execute($req);
        $res_cats = (array) $resp->item_cats;
        $item_cate = array();
        foreach ($res_cats['item_cat'] as $val) {
            $val = (array) $val;
            $item_cate[] = $val;
        }
        var_dump($item_cate);
        //$this->_render('email');
    }

    /**
     * 加载可用的API
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $api 可用API名
     */
    private function _loadApi($api)
    {
        HClass::import('vendor.sdk.taobao.top.request.' . $api, false);

        return new $api;
    }

    /**
     * 初始化客户端
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _initClient()
    {
        $taobaoCfg  = HObject::GC('TAOBAO');
        $this->_client  = new TopClient();
        $this->_client->appkey     = $taobaoCfg['key'];
        $this->_client->secretKey  = $taobaoCfg['secret'];
    }

}

?>
