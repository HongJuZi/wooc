<?php 

/**
 * @version			$Id$
 * @create 			2012-4-9 8:41:21 By xjiujiu
 * @package 		application
 * @subpackage 		core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die();

/**
 * 网站模块的Popo基类
 * 
 * 模块的基本信息配置类 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.core
 * @since 			1.0.0
 */
class HPopo extends HObject
{

    /**
     * 得到当前所有的字段配置信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return Array 配置对象
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * 得到字段配置 
     * 
     * 只返回字段对应的配置的项目 
     * 
     * @access public
     * @return array | ''
     */
    public function getFieldCfg($field)
    {
        if(isset($this->_fields[$field])) {
            return $this->_fields[$field];
        }

        return null;
    }

    /**
     * 得到当前字段验证配置
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $field 当前需要查找的字段
     * @return Array 当前的数组
     */
    public function getFieldVerifyCfg($field)
    {
        return $this->getFieldAttribute($field, 'verify');
    }

    /**
     * 得到字段的页面名称
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $field 需要查找的字段
     * @return String 找到的名称
     */
    public function getFieldName($field)
    {
        return $this->getFieldAttribute($field, 'name');
    }

    /**
     * 得到字段的提示信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $field 字段名称 
     * @return String 查找到的字段对应的值 
     */
    public function getFieldComment($field)
    {
        return $this->getFieldAttribute($field, 'comment');
    }

    /**
     * 得到字段的属性 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $field 当前字段
     * @param  String $attr 需要查找的属性
     * @return String 查找到的字段属性值 
     */
    public function getFieldAttribute($field, $attr)
    {
        if(isset($this->_fields[$field][$attr])) {
            return $this->_fields[$field][$attr];
        }

        return '';
    }

    /**
     * 设置配置属性
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $field 需要操作的字段
     * @param  String $attr 属性值
     * @param  String $value 值
     */
    public function setFieldAttribute($field, $attr, $value)
    {
        if(isset($this->_fields[$field])) {
            $this->_fields[$field][$attr]   = $value;
        }
    }

    /**
     * 设置模块配置文件的字段配置信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $field 字段名
     * @param  Array $cfg 字段配置信息
     */
    public function setFieldCfg($field, $cfg)
    {
        if(isset($this->_fields[$field])) {
            $this->_fields[$field]  = $cfg;
        }
    }

    /**
     * 检测是否含有当前字段
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $field 字段名
     * @return boolean 
     */
    public function hasField($field)
    {
        return isset($this->_fields[$field]);
    }

}

?>
