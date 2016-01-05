<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die('Restricted access!');

HClass::import('hongjuzi.utils.page.hpage');

/**
 * BootStrap风格的分页工具类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.utils.page
 * @since 1.0.0
 */
class HBootstrap extends HPage
{

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_pageStyleHtml   = array(
            'header' => '{TOTAL_RECORDS}：<strong>%d</strong>; {CUR_LOCATION}：<strong>%d/%d</strong>{PAGE}。',
            'first' => '&lt;&lt;',
            'disabled' => '<li class="disabled %s"><a href="###">%s</a></li>',
            'current' => '<li class="active %s"><a href="###">%s</a></li>', 
            'normal' => '<li><a href="%s" class="%s">%s</a></li>',
            'more' => '<li><a href="%s" class="%s">...</a></li>',
            'last' => '&gt;&gt;',
            'wrapper' =>  '<ul class="pagination">%s</ul>'
        );
    }

}
