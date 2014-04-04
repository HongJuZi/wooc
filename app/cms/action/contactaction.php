<?php 

/**
 * @version $Id$
 * @create 2013-8-6 10:20:09 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.cms.action.articleaction');

/**
 * 关于我们信息类
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.cms.action
 * @since 1.0.0
 */
class ContactAction extends ArticleAction
{

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
        parent::__construct();
        $this->_identifier    = 'contact-us';
        $this->_popo->modelZhName   = '联系我们';
    }

    /**
     * 联系我们主页
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @throws none
     */
    public function index()
    {
        if(HRequest::getParameter('id')) { 
            $this->_detail();
            exit;
        }
        $this->_record('`identifier` = \'contact-us\'');
        $this->_assignProductList();
        HResponse::setAttribute('identifier', $this->_identifier);

        $this->_render('contact');
    }

    /**
     *  加载产品列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignProductList()
    {
        HResponse::setAttribute(
            'catList', 
            $this->_category->getSubCategoryByIdentifier('goods', false)
        );
    }

}

?>
