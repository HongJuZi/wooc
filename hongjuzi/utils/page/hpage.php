<?php 

/**
 * @version			$Id$
 * @create 			2012-4-10 15:24:08 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		utils
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die('Restricted access!');

/**
 * 分页工具类 
 * 
 * 支持1,2,3,4,5,6,....,10风格类型的分页 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.utils
 * @since 			1.0.0
 */
class HPage extends HObject
{
    /**
     * @var array $_pageStyleHtml 分页的模板
     */
    protected $_pageStyleHtml;

    /**
     * @var int $_totalShowPages 总共显示的页数
     */
    protected $_totalShowPages;

    /**
     * @var int $_curPage 当前访问的页码
     */
    protected $_curPage;

    /**
     * @var int $_totalPages 总的页码
     */
    protected $_totalPages;

    /**
     * @var protected $_totalRows
     */
    protected $_totalRows;

    /**
     * @var string $_paramName 存储公页号的变量名
     */
    protected $_paramName;

    /**
     * 构造函数 
     * 
     * @access public
     */
    public function __construct()
    {
        $this->_curPage         = 0;
        $this->_totalPages      = 0;
        $this->_paramName       = 'page';
        $this->_totalShowPages  = 5; 
        $this->_pageStyleHtml   =  array(
            'header' => '{TOTAL_RECORDS}：<strong>%d</strong>; {CUR_LOCATION}：<strong>%d/%d</strong>{PAGE}。',
            'first' => '&lt; {PRE_PAGE}',
            'disabled' => '<span class="disabled %s">%s</span>',
            'current' => '<span class="current %s">%s</span>', 
            'normal' => '<a href="%s" class="%s">%s</a>',
            'more' => '<a href="%s" class="%s">...</a>',
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
        $pageHtml   .= $this->_getPreHtml();
        if($this->_totalPages < $this->_totalShowPages) {
            for($page = 1; $page <= $this->_totalPages; $page ++) {
                $pageHtml   .= $this->_getPageHtml($page);
            }
        } else {
            $pageHtml   .= $this->_getShowPageNumber();
        }
        $pageHtml   .= $this->_getNextHtml();

        return sprintf($this->_pageStyleHtml['wrapper'], $pageHtml); 
    }

    /**
     * 把中间的看成一个可以滑动的固定长度的尺子 
     * 
     * 把$this->_totalShowPages 当成一个可以滑动的固定长度尺子，
     * 然后$this->_totalPages就是一个给定长度的木块，尺子在这个
     * 木块上滑动。情况两种：
     * 1. 尺子长度大于木块长度，那么就直接输出所有的页码；
     * 2. 尺子长度小于木块长度，那么就只用找到输出这个尺子长度页
     *    数的起始点——$start, $end;
     * 
     * @access protected
     * @return string 
     */
    protected function _getShowPageNumber()
    {
        $pageHtml   = '';
        //找到$start点
        $start  = $this->_curPage - 2 > 1 ? $this->_curPage - 2 : $start  = 1;
        //找到$end 点
        $end        = $start + $this->_totalShowPages;
        if($end >= $this->_totalPages) {
            $end    = $this->_totalPages;
            $start  = $end - $this->_totalShowPages;    //保证页面显示的长度为$this->_totalShowPages
            $start  = 0 == $start ? 1 : $start;
        }
        if($start > 1) {
            $pageHtml   .= $this->_getPageHtml(1);
            $preMore    = $this->_curPage - $this->_totalShowPages;
            if($preMore < 1) {
                $preMore    = 1;
            }
            $pageHtml       .= $this->_getMorePageHtml($preMore);
        }
        for($page = $start; $page < $end; $page ++) {
            $pageHtml   .= $this->_getPageHtml($page);
        }
        if($end != $this->_totalPages) {
            $pageHtml   .= $this->_getMorePageHtml($end);
        }
        $pageHtml   .= $this->_getNormalPageHtml($this->_totalPages);

        return $pageHtml;
    }

    /**
     * 得到页面链接，正常还是当前页面 
     * 
     * @access protected
     * @param int $page 页码值
     * @return string 
     */
    protected function _getPageHtml($page)
    {
        if($this->_curPage == $page) {
            return $this->_getCurPageHtml($page);
        }

        return $this->_getNormalPageHtml($page);
    }

    /**
     * 得到分页HTML代码的Header部分 
     * 
     * @access protected
     * @return void
     */
    protected function _getPageHeaderHtml()
    {
		$header		= strtr(
			$this->_pageStyleHtml['header'],
			array(
				'{TOTAL_RECORDS}' => HTranslate::__('总记录'),
				'{CUR_LOCATION}' => HTranslate::__('当前页'),
				'{PAGE}' => HTranslate::__('页') 
			)
		);

        return sprintf($header, $this->_totalRows, $this->_curPage, $this->_totalPages);
    }

    /**
     * 得到正常显示的页码HTML 
     * 
     * @desc
     * 
     * @access protected
     * @param int $page 页码
     */
    protected function _getNormalPageHtml($page)
    {
        return sprintf($this->_pageStyleHtml['normal'], $this->_genPageLink($page), 'normal', $page);
    }

    /**
     * 得到当前访问页的HTML代码 
     * 
     * @desc
     * 
     * @access protected
     * @param $pageNumber
     */
    protected function _getMorePageHtml($page)
    {
        return sprintf($this->_pageStyleHtml['more'], $this->_genPageLink($page), 'more');
    }

    /**
     * 得到当前访问页的HTML代码 
     * 
     * @desc
     * 
     * @access protected
     * @param $pageNumber
     */
    protected function _getCurPageHtml($page)
    {
        return sprintf($this->_pageStyleHtml['current'], 'current', $page); 
    }

    /**
     * 得到上一页的HTML代码 
     * 
     * @desc
     * 
     * @access protected
     */
    protected function _getPreHtml()
    {
		$first	= strtr(
			$this->_pageStyleHtml['first'],
			array(
				'{PRE_PAGE}' => HTranslate::__('上一页')
			)
		);
        if($this->_curPage == 1) {
            return sprintf(
                $this->_pageStyleHtml['disabled'], 
                'per-page',
                $first
            );
        }
        
        return sprintf($this->_pageStyleHtml['normal'],
            $this->_genPageLink($this->_curPage - 1),
            'per-page',
            $first
        );
    }

    /**
     * 得到下一页的HTML代码 
     * 
     * @access protected
     */
    protected function _getNextHtml()
    {
		$last	= strtr(
			$this->_pageStyleHtml['last'],
			array(
				'{NEXT_PAGE}' => HTranslate::__('下一页')
			)
		);
        if($this->_totalPages == 0 || $this->_curPage == $this->_totalPages) {
            return sprintf(
                $this->_pageStyleHtml['disabled'],
                'next-page',
                $last
            );
        }
        
        return sprintf($this->_pageStyleHtml['normal'],
            $this->_genPageLink($this->_curPage + 1),
            'next-page', 
            $last
        );
    }

    /**
     * 生成对应的页面访问链接 
     * 
     * @access protected
     * @param  int $page 当前页码
     */
    protected function _genPageLink($page)
    {
        $regMode    = '/&?' . $this->_paramName . '=\d+/i';
        $uri        = preg_replace($regMode, '', HRequest::getCurUrl());
        if(false !== ($loc = strpos($uri, '?'))) {
            if($loc != strlen($uri)) {
                return str_replace('?&', '?', $uri . '&' . $this->_paramName . '=' . $page);
            }
            return $uri . $this->_paramName . '=' . $page;
        }

        return $uri . '?' . $this->_paramName . '=' . $page;
    }

    /**
     * 总页数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $totalPages
     * @return 当前总页数
     */
    public function setTotalPages($totalPages)
    {
        $this->_totalPages  = $totalPages;

        return $this;
    }

    /**
     * 当前页
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $curPage 当前页
     * @return 当前页对象
     */
    public function setCurPage($curPage)
    {
        $this->_curPage     = $curPage;

        return $this;
    }

    /**
     * 设置当前页码变量
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $paramName 变量名
     * @return 当前分页对象
     */
    public function setParamName($paramName)
    {
        $this->_paramName   = $paramName;

        return $this;
    }

    /**
     * 设置总的页面显示数量
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $totalShowPages
     * @return 当前分页对象
     */
    public function setTotalShowPages($totalShowPages)
    {
        $this->_totalShowPages  = $totalShowPages;

        return $this;
    }

}


?>
