<?php

/**
 * @version			$Id$
 * @create 			2012-4-21 18:06:36 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		utils
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 树形工具类 
 * 
 * 把特定的数据转换成树形的结构 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.utils
 * @since 			1.0.0
 */
class HTree extends HObject
{

    /**
     * @var string $_repeatStr 层级重复的字符
     */
    protected $_repeatStr;

    /**
     * @var string $_tplStr 显示模板
     */
    protected $_tplStr;

    /**
     * @var string $_preStr 前缀字符
     */
    protected $_preStr;

    /**
     * @var protected $_replaceKey 需要替换值的内容
     */
    protected $_replaceKey;

    /**
     * @var protected $_keys 需要换上给定元素值的数组键
     */
    protected $_keys;
        
    /**
     * @var array $_data 需要输出的数据
     */
    protected $_data;

    /**
     * @var int $_level 标识当前的元素层级
     */
    protected $_level;

    /**
     * @var string $_tree 最终生成的树型内容
     */
    protected $_tree;

    /**
     * 构造函数 
     * 
     * @desc
     * 
     * @access public
     * @param array $data 需要处理的数据
     * @param int | string $id 唯一ID
     * @param int | string $parentId 父类ID
     * @param string $replaceKey 需要替换的字段
     * @param array $keys 其它需要替换的段
     * @param string $tplStr 模板字符串
     * @param string $preStr 需要重复的字符串 '|'
     * @param string $repeatStr 需要重复的字符串 '-'
     */
    public function __construct($data, $id, $parentId, $replaceKey = '', $keys = '',
        $tplStr = '', $preStr = '|', $repeatStr = '--')
    {
        $this->_data        = $data;
        $this->_tmpData     = $data;
        $this->_id          = $id;
        $this->_parentId    = $parentId;
        $this->_replaceKey  = $replaceKey;
        $this->_keys        = $keys;
        $this->_tplStr      = $tplStr;
        $this->_preStr      = $preStr;
        $this->_repeatStr   = $repeatStr;
        $this->_level       = 0;
    }

    /**
     * 通过Key的关联得到树形结构
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return String 当前的树形结果 
     */
    public function getTree()
    {
        $this->_buildTreeRaw();
        foreach($this->_data as $data) {
            if(false === $data['is_root']) {
                continue;
            }
            $this->_level   = 0;
            $this->_tree    .= strtr($this->_tplStr, $this->_getStrtrArray($data));
            $this->_genParentTree($data['children']);
        }

        return $this->_tree;
    }

    /**
     * 构造树形原始数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _buildTreeRaw()
    {
        $tmpData        = array();
        foreach($this->_data as $data) {
            $data['children']   = $this->_findChildNodes($data[$this->_id]);
            $tmpData[$data[$this->_id]]     = $data;
        }
        foreach($tmpData as &$data) {
            $data['is_root']    = isset($tmpData[$data[$this->_parentId]]) ? false : true;
        }
        $this->_data    = $tmpData;
    }

    /**
     * 解析树形数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return Array 树形结构数据
     */
    public function parseTree()
    {
        $this->_buildTreeRaw();

        return $this->_data;
    }

    /**
     * 生成树用的是递归
     * 
     * @desc
     * 
     * @access protected
     * @param array $children 当前遍历的父类元素
     */
    private function _genParentTree($children)
    {
        $this->_level ++;
        if(!empty($children)) {
            foreach($children as $id) {
                $child                      = $this->_data[$id];
                $child[$this->_replaceKey]  = $this->_preStr . str_repeat($this->_repeatStr, $this->_level) . $child[$this->_replaceKey];
                $this->_tree                .= strtr($this->_tplStr, $this->_getStrtrArray($child));
                $this->_genParentTree($child['children']);
            }
        }

        $this->_level --;
        return '';
    }

    /**
     * 找到所有的子结点 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $pId 父结点
     * @return Array 子结点
     */
    private function _findChildNodes($pId)
    {
        $nodes  = array();
        foreach($this->_tmpData as $key => $row) {
            if($pId == $row[$this->_parentId]) {
                $nodes[]    = $row[$this->_id];
                $this->_data[$row[$this->_id]]['is_root']    = false;
                unset($this->_tmpData[$key]);
            }
        }

        return $nodes;
    }

    /**
     * 得到模板里需要替换的变量 
     * 
     * @desc
     * 
     * @access protected
     * @param array $element 元素记录
     * @return array 
     */
    protected function _getStrtrArray($element)
    {
        $strtrArr   = array(
            '{' . $this->_replaceKey . '}' => $element[$this->_replaceKey]
        );
        if(!HVerify::isEmptyNotZero($this->_keys)) {
            if(!is_array($this->_keys)) {
                $this->_keys    = array($this->_keys);
            }
            foreach($this->_keys as $key) {
                $strtrArr['{' . $key . '}']   = $element[$key];
            }
        }

        return $strtrArr;
    }

    /**
     * 得到导航栏的层级代码 
     * 
     * @desc
     * 
     * @access public
     * @param string $subnavWrap 子元素的外层
     * @return string 
     * @exception none
     */
    public function getNavmenuTree($subnavWrap)
    {
        $this->_buildTreeRaw();
        foreach($this->_data as $data) {
            if(false === $data['is_root']) {
                continue;
            }
            $navmenu        = strtr($this->_tplStr, $this->_getStrtrArray($data));
            $this->_tree    .= sprintf($navmenu, $this->_genNavmenuTreeStr($data['children'], $subnavWrap));
        }

        return $this->_tree;
    }

    /**
     * 生成树用的是递归
     * 
     * @desc
     * 
     * @access protected
     * @param array $children 子结点
     * @param String $subnavWrap 树形HTML结构 
     * @return string  树形结构
     */
    protected function _genNavmenuTreeStr($children, $subnavWrap)
    {
        if(empty($children)) {
            return '';
        }
        foreach($children as $id) {
            $child      = $this->_data[$id];
            $subnav     .= strtr($this->_tplStr, $this->_getStrtrArray($child));
            $subnav     = empty($child['children']) ? sprintf($subnav, '') 
                : sprintf($subnav, $this->_genNavmenuTreeStr($child['children'], $subnavWrap));
        }

        return sprintf($subnavWrap, $subnav);
    }


}

?>
