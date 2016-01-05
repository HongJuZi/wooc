<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//引入分词
HClass::import('app.public.action.publicaction');

/**
 * 字符类处理工具类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package public.action
 * @since 1.0.0
 */
class TstringAction extends PublicAction
{
    
    /**
     * 异步执行分词功能
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function afenci()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('data'), '内容不能为空！');
        HClass::import('model.fencimodel');
        $fenci  = new FenciModel();
        $top    = $fenci->doFenci(HRequest::getParameter('data'), 10);

        HResponse::json(array('rs' => true, 'data' => $top));
    }

    /**
     * 拼音服务接口
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function apinyin()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('data'), '内容不能为空！');

        HResponse::json(array(
            'rs' => true, 
            'data' => HString::getPinYin(urldecode(HRequest::getParameter('data'))) 
        ));
    }

}


?>
