<?php 

/**
 * @version $Id$
 * @create 2013/10/13 12:51:32 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
//引入文件
HClass::import('hongjuzi.image.HImageVCode');

/**
 * 验证码生成工具类
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.public.action
 * @since 1.0.0
 */
class VcodeAction extends HAction
{

    /**
     * 生成验证码 
     * 
     * @desc
     * 
     * @access public
     * @return image resource
     */
    public function index()
    {
        $vcode  = new HImageVCode();
        HSession::setAttribute('vcode', $vcode->genVerifyCode(50, 25));
        exit;
    }

}

?>
