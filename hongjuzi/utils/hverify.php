<?php

/**
 * @version			$Id: HVerify.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-4-8 11:59:01 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		utils
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die('Restricted access!');

/**
 * 验证工具类集合 
 * 
 * 验证字串，数值范围，长度等合法性工具
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.utils
 * @since 			1.0.0
 */
class HVerify
{

    /**
     * 验证字符串长度 
     * 
     * 通过给定的字符串及合法的范围来验证是否满足当前的条件 
     * 
     * @access public static
     * @param string $string 需要验证的字串
     * @param int $max 允许的最大长度 
     * @param int $min 允许的最少长度，默认为:0
     * @param string $encode 处理字串的编码类型, 默认为：'utf8'
     * @exception HVerifyException 验证异常
     */
    public static function isStrLen($string, $name, $min, $max = 0)
    {
        $len    = (strlen($string) + mb_strlen($string, 'UTF8')) / 2;
        if($min !== 0 && $min > $len) {
            throw new HVerifyException($name . HResponse::lang('STR_LEN_LESS_THEN', false) . $min . '。');
        }
        if($max != 0 && $max < $len) {
            throw new HVerifyException($name . HResponse::lang('STR_LEN_BIG_THEN', false) . $max . '。');
        }
    }

    /**
     * 验证元素是否为空，但不包括0 
     * 
     * 当验证的元素值为0时，表示不为空 
     * 
     * @access public static
     * @param mix $element 需要验证的元素
     * @return boolean 
     * @exception none
     */
    public static function isEmptyNotZero($element)
    {
        if($element === 0 || $element === '0') return false;

        return empty($element);
    }

    /**
     * 验证变量是不是空，包括0在内
     * 
     * 对于数组只支持一维的验证 
     * 
     * @access public static
     * @param mix $param 需要验证的变量
     * @return boolean 
     * @exception none
     */
    public static function isEmpty($param, $name = '') 
    {
        if(is_array($param)) {
            $param  = array_filter($param);
        }
        if(empty($param)) {
            if(!$name) {
                return true;
            }
            throw new HVerifyException($name . HResponse::lang('CAN_NOT_BE_EMPTY', false));
        }

        return false;
    }

    /**
     * 验证是否为合法的文件名 
     * 
     * 不能包含有：', ", *, ^, \, /, >, <, |, #, !, $, @等不合法的字符
     * 
     * @access public static
     * @param string $filePath 需要检测的文件路径
     * @return void 
     * @exception HVerifyException 
     */
    public static function fileName($filePath)
    {
        if(preg_match('%[\*\|\'"@!&<>~\\/#\$\^\?`]%i', $filePath)) {
            throw new HVerifyException(HResponse::lang('FILE_NAME_FORBID_CHARS', false));
        }
    }

    /**
     * 验证链接地址是否合法 
     * 
     * 用法：
     * <code>
     *  HVerify::isUri('http://www.xjiujiu.com'); //验证正常
     *  HVerify::isUri('https://test.com');     //验证正常
     *  HVerify::isUri('test.com');             //抛出验证异常
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $uri 需要验证的地址
     * @return void
     * @throws HVerifyException 
     */
    public static function isUri($uri)
    {
        if(!preg_match("/^http[s]:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\’:+!]*([^<>\"])*$/", $uri)) {
            throw new HVerifyException(HResponse::lang('URL_ERROR', false));
        }
    }

    /**
     * 验证邮箱地址是否正确 
     * 
     * 用法：
     * <code>
     *  HVerify::isEmail('test');    //抛出验证异常
     *  HVerify::isEmail('example@example.com'); //验证正常
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $email 需要验证的邮箱地址
     * @return void
     * @throws HVerifyException 
     */
    public static function isEmail($email)
    {
        if(!preg_match('/^[\w\-\.]+@[\w\-]+(\.\w+)+$/', $email)) {
            throw new HVerifyException(HResponse::lang('EMAIL_FORMAT_ERROR', false));
        }
    }

    /**
     * 验证电话号码是否正确 
     * 
     * 用法：
     * <code>
     *  HVerify::isPhone('0745-2563696');   //正确
     *  HVerify::isPhone('28648963');       //正确
     *  HVerify::isPhone('2342342323');     //抛出异常
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $phone 需要验证的电话
     * @return void
     * @throws HVerifyException 
     */
    public static function isPhone($phone)
    {
        if(!preg_match("/^(((\d{3}))|(\d{3}-))?((0\d{2,3})|0\d{2,3}-)?[1-9]\d{6,8}$/", $phone)) {
            throw new HVerifyException(HResponse::lang('PHONE_FORMAT_ERROR', false));
        } 
    }

    /**
     * 验证手机号是否正确 
     * 
     * 用法：
     * <code>
     *  HVerify::isMobile('15116325635');   //验证正常 
     *  HVerify::isMobile('12312312312');   //抛出异常
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $mobile 手机号
     * @return void
     * @throws HVerifyException 
     */
    public static function isMobile($mobile)
    {
        if(!preg_match('/(?:13\d{1}|15[03689])\d{8}$/', $mobile)) {
            throw new HVerifyException(HResponse::lang('TELEPHONE_FORMAT_ERROR', false));
        }
    }

    /**
     * 验证当前的记录ID是否合法 
     * 
     * 用法：
     * <code>
     *  HVerify::isrecordid(12); //yes..
     *  hverify::isrecordid(adf23); //抛出异常
     * </code> 
     * @access public static
     * @param int $id 需要验证的id
     * @return void 
     * @exception hverifyexception 
     */
    public static function isRecordId($id)
    {
        if(!preg_match('/^-?\d+$/', $id)) {
            throw new hverifyexception(HResponse::lang('INVALIDATE_RECORD_ID', false));
        }
    }

    /**
     * 检测当前的id是否为合法数字 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  int $num 需要检测的值
     * @param  int $name 检测值名称
     * @throws hverifyexception 验证异常
     */
    public static function isNumber($num, $name)
    {
        if(!preg_match('/^-?\d+(.\d+)?$/', $num)) {
            throw new HVerifyException($name . HResponse::lang('INVALIDATE_NUMBER', false));
        }
    }

    /**
     * 检测是否为Ajax请求 
     * 
     * 检查标识处: HTTP_X_REQUESTED_WITH (像Jquery, Mootools框架会
     * 加上这个标识) 
     * 
     * @access public static
     * @return boolean 
     * @exception none
     */
    public static function isAjax()
    {
        if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || 
            !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            throw new HVerifyException(HResponse::lang('NOT_AJAX_REQUEST', false));
        }
    }

    /**
     * 验证日期
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $date 需要验证的日期
     * @param  String $name 名称
     * @param  String $format 格式，默认为：Y-m-d
     * @throws HVerifyException 验证异常
     */
    public static function isDate($date, $name, $format = 'Y-m-d')
    {
        if(!preg_match('/^\d{4}-\d{2}-\d{2}$/s', $date)) {
            throw new HVerifyException($name . '时间格式不正确，正确格式如：' . date($format));
        }
    }

    /**
     * 验证是否为日期
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $dateTime 日期时间
     * @param  String $name 名称
     * @param  String $format 时间格式，默认为：Y-m-d H:m:s
     * @throws HVerifyException 验证异常
     */
    public static function isDateTime($dateTime, $name, $format = 'Y-m-d H:m:s')
    {
        if(!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/s', $dateTime)) {
            throw new HVerifyException($name . '时间格式不正确，正确格式如：' . date($format));
        }
    }

    /**
     * 检测是否为Url地址
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @throws HVerifyException 验证异常 
     */
    public static function isUrl($url, $name = '')
    {
        if(!preg_match('/^http(s)?:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"])*$/', $url)) {
            throw new HVerifyException($name . '不是有效的网址，请检查～');
        }
    }

}

?>
