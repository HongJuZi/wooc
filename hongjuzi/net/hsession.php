<?php

/**
 * @version			$Id$
 * @create 			2012-4-8 8:54:55 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		session
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 对$_SESSION的封装 
 * 
 * 对$_SESSION的存储方式做一个封装，可以是文件，也可以是数据库 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.session
 * @since 			1.0.0
 */
class HSession extends HObject
{

    /**
     * 检测是否有某属性 
     * 
     * 不管是不是空值，只要当前的$_SESSION设置的了该属性就反回true 
     * 
     * @access public
     * @param string $attribute 当前的属性名
     * @return boolean
     * @exception none
     */
    public static function isHas($attr, $domain = 'root')
    {
        if(isset($_SESSION[$domain][$attr])) {
            return true;
        }

        return false;
    }

    /**
     * 得到当前$_SESSION对像里的属性值 
     * 
     * 如果$_SESSION中存在此值则按原值返回
     * 
     * @access public
     * @param string $attribute 属性名称
     * @param  String 域名称，默认为：root
     * @return mix
     */
    public static function getAttribute($attr, $domain = 'root')
    {
        if(isset($_SESSION[$domain][$attr])) {
            return $_SESSION[$domain][$attr];
        }

        return null;
    }

    /**
     * 得到当前域下所有的属性集合
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String 域名称，默认为：root
     * @return Array 当前域下所有属性集合
     */
    public static function getAttributeByDomain($domain = 'root')
    {
        return $_SESSION[$domain];
    }

    /**
     * 设置当前的$_SESSION的属性值 
     * 
     * 支持是否重写当前已经设置的属性 
     * 
     * @access public
     * @param string $attribute 属性名称
     * @param mix $value 属性对应的值
     * @param  String 域名称，默认为：root
     */
    public static function setAttribute($attr, $value, $domain = 'root')
    {
        if(empty($attr) && $value) {
            $_SESSION[$domain]   = $value;
            return;
        }
        $_SESSION[$domain][$attr]   = $value;
    }

    /**
     * 指定Session 域的值
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  Mix $value 需要配置的值
     * @param  String $domain 需要配置的域，默认为：'root'
     */
    public static function setAttributeByDomain($value, $domain = 'root')
    {
        $_SESSION[$domain]  = $value;
    }

    /**
     * 销毁当前的Session属性 
     * 
     * 用法：
     * <code>
     *  HSession::destroy('user_name');     //删除当前的用户名
     *  HSession::destroy();                //删除所有的Session内容                 
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $attr 需要删除的属性值，默认为空
     * @param  String 域名称，默认为：root
     */
    public function destroy($attr = '', $domain = '')
    {
        if(!$attr && !$domain) {
            session_destroy();
            return;
        }
        if(!$attr && isset($_SESSION[$domain])) {
            unset($_SESSION[$domain]);
            return;
        }
        unset($_SESSION[$domain][$attr]);
    }

}

?>
