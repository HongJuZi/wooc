<?php

/**
 * @version         $Id: HVerify.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create          2012-4-8 11:59:01 By xjiujiu
 * @package         hongjuzi
 * @subpackage      utils
 * @copyRight       Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die('Restricted access!');

/**
 * 驗證工具類集合 
 * 
 * 驗證字串，數值範圍，長度等合法性工具
 * 
 * @author          xjiujiu <xjiujiu@foxmail.com>
 * @package         hongjuzi.utils
 * @since           1.0.0
 */
class HVerify
{

    /**
     * 驗證字符串長度 
     * 
     * 通過給定的字符串及合法的範圍來驗證是否滿足當前的條件 
     * 
     * @access public static
     * @param string $string 需要驗證的字串
     * @param int $max 允許的最大長度 
     * @param int $min 允許的最少長度，默認為:0
     * @param string $encode 處理字串的編碼類型, 默認為：'utf8'
     * @exception HVerifyException 驗證異常
     */
    public static function isStrLen($string, $name, $min, $max = 0)
    {
        $len    = (strlen($string) + mb_strlen($string, 'UTF8')) / 2;
        if($min !== 0 && $min > $len) {
            throw new HVerifyException($name . HTranslate::__('字符長度不能小於') . $min . '。');
        }
        if($max != 0 && $max < $len) {
            throw new HVerifyException($name . HTranslate::__('字符長度不能大於') . $max . '。');
        }
    }

    /**
     * 驗證元素是否為空，但不包括0 
     * 
     * 當驗證的元素值為0時，表示不為空 
     * 
     * @access public static
     * @param mix $element 需要驗證的元素
     * @return boolean 
     * @exception none
     */
    public static function isEmptyNotZero($element)
    {
        if($element === 0 || $element === '0') return false;

        return empty($element);
    }

    /**
     * 驗證變量是不是空，包括0在內
     * 
     * 對於數組只支持一維的驗證 
     * 
     * @access public static
     * @param mix $param 需要驗證的變量
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
            throw new HVerifyException($name . HTranslate::__('不能為空'));
        }

        return false;
    }

    /**
     * 驗證是否為合法的文件名 
     * 
     * 不能包含有：', ", *, ^, \, /, >, <, |, #, !, $, @等不合法的字符
     * 
     * @access public static
     * @param string $filePath 需要檢測的文件路徑
     * @return void 
     * @exception HVerifyException 
     */
    public static function fileName($filePath)
    {
        if(preg_match('%[\*\|\'"@!&<>~\\/#\$\^\?`]%i', $filePath)) {
            throw new HVerifyException(HTranslate::__('文件名有不合法的字符'));
        }
    }

    /**
     * 驗證鏈接地址是否合法 
     * 
     * 用法：
     * <code>
     *  HVerify::isUri('http://www.xjiujiu.com'); //驗證正常
     *  HVerify::isUri('https://test.com');     //驗證正常
     *  HVerify::isUri('test.com');             //拋出驗證異常
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $uri 需要驗證的地址
     * @return void
     * @throws HVerifyException 
     */
    public static function isUri($uri)
    {
        if(!preg_match("/^http[s]:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\’:+!]*([^<>\"])*$/", $uri)) {
            throw new HVerifyException(HTranslate::__('網址格式錯誤'));
        }
    }

    /**
     * 驗證郵箱地址是否正確 
     * 
     * 用法：
     * <code>
     *  HVerify::isEmail('test');    //拋出驗證異常
     *  HVerify::isEmail('example@example.com'); //驗證正常
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $email 需要驗證的郵箱地址
     * @return void
     * @throws HVerifyException 
     */
    public static function isEmail($email)
    {
        if(!preg_match('/^[\w\-\.]+@[\w\-]+(\.\w+)+$/', $email)) {
            throw new HVerifyException(HTranslate::__('郵箱格式錯誤'));
        }
    }

    /**
     * 驗證電話號碼是否正確 
     * 
     * 用法：
     * <code>
     *  HVerify::isPhone('0745-2563696');   //正確
     *  HVerify::isPhone('28648963');       //正確
     *  HVerify::isPhone('2342342323');     //拋出異常
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $phone 需要驗證的電話
     * @return void
     * @throws HVerifyException 
     */
    public static function isPhone($phone)
    {
        if(!preg_match("/^(((\d{3}))|(\d{3}-))?((0\d{2,3})|0\d{2,3}-)?[1-9]\d{6,8}$/", $phone)) {
            throw new HVerifyException(HTranslate::__('電話號碼格式有錯'));
        } 
    }

    /**
     * 驗證手機號是否正確 
     * 
     * 用法：
     * <code>
     *  HVerify::isMobile('15116325635');   //驗證正常 
     *  HVerify::isMobile('12312312312');   //拋出異常
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $mobile 手機號
     * @return void
     * @throws HVerifyException 
     */
    public static function isMobile($mobile)
    {
        if(!preg_match('/(?:13\d{1}|15[03689])\d{8}$/', $mobile)) {
            throw new HVerifyException(HTranslate::__('手機號碼格式有錯'));
        }
    }

    /**
     * 驗證當前的記錄ID是否合法 
     * 
     * 用法：
     * <code>
     *  HVerify::isrecordid(12); //yes..
     *  hverify::isrecordid(adf23); //拋出異常
     * </code> 
     * @access public static
     * @param int $id 需要驗證的id
     * @return void 
     * @exception hverifyexception 
     */
    public static function isRecordId($id)
    {
        if(!preg_match('/^-?\d+$/', $id)) {
            throw new HVerifyException(HTranslate::__('無效編號'));
        }
    }

    /**
     * 檢測當前的id是否為合法數字 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  int $num 需要檢測的值
     * @param  int $name 檢測值名稱
     * @param  int $min 最少值
     * @param  int $max 最大值
     * @throws hverifyexception 驗證異常
     */
    public static function isNumber($num, $name, $min = null, $max = null)
    {
        if(!is_numeric($num)) {
            throw new HVerifyException($name . HTranslate::__('無效數字'));
        }
        if(null !== $min && $num < $min) {
            throw new HVerifyException($name . '不能小於' . $min);
        }
        if(null !== $max && $num > $max) {
            throw new HVerifyException($name . '不能大於' . $min);
        }
    }

    /**
     * 檢測是否為Ajax請求 
     * 
     * 檢查標識處: HTTP_X_REQUESTED_WITH (像Jquery, Mootools框架會
     * 加上這個標識) 
     * 
     * @access public static
     * @exception VerifyException
     */
    public static function isAjax()
    {
        if(false === self::isAjaxByBool()) {
            throw new HVerifyException(HTranslate::__('非法請求'));
        }
    }

    /**
     * 檢測是否為異常，返回Bool值
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return Boolean
     */
    public static function isAjaxByBool()
    {
        if(HRequest::getParameter('is_ajax')
           || isset($_SERVER['HTTP_X_REQUESTED_WITH'])
           || false !== strpos($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            return true;
       }

        return false;
    }

    /**
     * 驗證日期
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $date 需要驗證的日期
     * @param  String $name 名稱
     * @param  String $format 格式，默認為：Y-m-d
     * @throws HVerifyException 驗證異常
     */
    public static function isDate($date, $name, $format = 'Y-m-d')
    {
        if(!preg_match('/^\d{4}-\d{2}-\d{2}$/s', $date)) {
            throw new HVerifyException($name . '時間格式不正確，正確格式如：' . date($format));
        }
    }

    /**
     * 驗證是否為日期
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $dateTime 日期時間
     * @param  String $name 名稱
     * @param  String $format 時間格式，默認為：Y-m-d H:m:s
     * @throws HVerifyException 驗證異常
     */
    public static function isDateTime($dateTime, $name, $format = 'Y-m-d H:m:s')
    {
        if(!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/s', $dateTime)) {
            throw new HVerifyException($name . '時間格式不正確，正確格式如：' . date($format));
        }
    }

    /**
     * 檢測是否為Url地址
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @throws HVerifyException 驗證異常 
     */
    public static function isUrl($url, $name = '')
    {
        if (!preg_match('%^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?%i', $url)) {
            throw new HVerifyException($name . '不是有效的網址，請檢查～');
        }
    }

    /**
     * 檢測是否有Html的Hack內容
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $content 需要檢測的內容
     * @throws HVerifyException
     */
    public static function isHtmlInject($content)
    {
        $len    = strlen($content) - 1;
        $tmp    = HString::filterHtmlXSS($content);
        if(!isset($tmp[$len])) {
            throw new HVerifyException('提交數據非法！');
        }
    }

    /**
     * 檢測是否存在模塊
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  $model 模塊名稱 
     * @throws HVerifyException
     */
    public static function hasModel($model)
    {
        if(!file_exists(ROOT_DIR . 'model/' . $model . 'model.php')) {
            throw new HVerifyException('模塊不存在！');
        }
    }

    /**
     * 檢測請求是不是軟件在跑～
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    public static function isTooFastRequest()
    {
        if(!HSession::getAttribute('last_request_time')) {
            HSession::setAttribute('last_request_time', $_SERVER['REQUEST_TIME']);
            return;
        }
        if(HObject::GC('MIN_REQUEST_SPACE') > $_SERVER['REQUEST_TIME'] - HSession::getAttribute('last_request_time')) {
            HSession::setAttribute('last_request_time', $_SERVER['REQUEST_TIME']);
            throw new HVerifyException('親，您的請求太快了，休息5秒哈～');
        }
        HSession::setAttribute('last_request_time', $_SERVER['REQUEST_TIME']);
    }

    /**
     * 檢測是否為跨站請求
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @throws HVerifyException
     */
    public static function isCSRF()
    {
        // 擋掉可能的跨站請求
        if (!empty($_GET) || !empty($_POST)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                throw new HVerifyException('非法請求！');
            }
            $parts = parse_url($_SERVER['HTTP_REFERER']);
            if (!empty($parts['port']) && $parts['port'] != 80 && !Typecho_Common::isAppEngine()) {
                $parts['host'] = "{$parts['host']}:{$parts['port']}";
            }
            if (empty($parts['host']) || $_SERVER['HTTP_HOST'] != $parts['host']) {
                throw new HVerifyException('非法請求！');
            }
        }
    }

}

?>
