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
 * 没有结束页分页效果
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.utils.page 
 * @since 1.0.0
 */
class HNoEndPage extends HPage
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
            'first' => '&lt; {PRE_PAGE}',
            'disabled' => '<span class="disabled %s">%s</span>',
            'current' => '<span class="current %s">%s</span>', 
            'normal' => '<a href="%s" class="%s">%s</a>',
            'last' => '{NEXT_PAGE} &gt;',
            'wrapper' =>  '%s'
        );
    }

    /**
     * 得到分页的HTML代码 
     * 
     * @access public
     * @return string 
     */
    public function getPageHtml()
    {
        if(1 > $this->_totalPages) { return ''; }
        $pageHtml   = $this->_getPreHtml();
        $pageHtml   .= $this->_getCurPageHtml($this->_curPage);
        $pageHtml   .= $this->_getNextHtml();

        return sprintf($this->_pageStyleHtml['wrapper'], $pageHtml); 
    }

}

?>
