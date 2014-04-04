<?php

/**
 * @version			$Id: HRequest.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-17 15:21:31 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		net
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die('Restricted access!');

/**
 * 对Http的Request请求封装 
 * 
 * 在输入的时候就对进入的数据进行注入的检测入格式化
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.net
 * @since 			1.0.0
 */
class HRequest extends HObject
{

    /**
     * @var private static $_parameters 变量存储的容器  
     */
    private static $_parameters = array();

    /**
     * 设置变量的值 
     * 
     * @desc
     * 
     * @access public static
     * @param  String $attr 属性名
     * @param  String $value 属性值
     */
    public static function setParameter($attr, $value)
    {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST': self::$_parameters[$attr]  = HString::filterSqlInjection($value); break;
            case 'GET':
            default: self::$_parameters[$attr]      = HString::filterSqlInjection($value); break;
        }
    }

    /**
     * 通过关联数组的形式来赋值当前的请求变量
     * 
     * @desc
     * 
     * @access public static
     * @param  array $params 当前的请求变量数组
     * @return void 
     * @exception none
     */
    public static function setParameterByArray(array $params)
    {
        foreach($params as $key => $value) {
            self::setParameter($key, $value);
        }
    }

    /**
     * 得到$_GET里的属性值 
     * 
     * 对$_GET进行过滤 
     * 
     * @access public static
     * @param  String $attr 当前的属性名，默认为空，返回所有的链接内容
     * @param  boolea $trim 是否去掉两端的空格，默认为: true
     * @return mix 请求的值
     */
    public static function getParameter($attr = null, $trim = true)
    {
        if(null === $attr) { return self::$_parameters; }
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET': return self::_get($attr, $trim);
            case 'POST': return self::_post($attr, $trim);
            default: return null;
        }
    }

    /**
     * 删除指定的请求变量
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $attr 请求的变量名
     */
    public static function deleteParameter($attr)
    {
        unset($_GET[$attr]);
        unset($_POST[$attr]);
        unset(self::$_parameters[$attr]);
    }

    /**
     * 对$_GET使用值的缓存 
     * 
     * 当$_GET属性进行过一次使用后，则将它的处理值进行缓存，
     * 下次使用时，直接使用缓存 
     * 
     * @access protected static
     * @param string $attr 属性名称
     * @param  boolea $trim 是否去掉两端的空格，默认为: true
     * @return String 当前属性值
     */
    protected static function _get($attr, $trim = true)
    {
        if(isset(self::$_parameters[$attr])) {
            return self::$_parameters[$attr];
        }
        if(isset($_GET[$attr])) {
            $temp   = true === $trim && !is_array($_GET[$attr]) ? trim($_GET[$attr]) : $_GET[$attr];
            self::$_parameters[$attr]    = HString::filterSqlInjection($temp);
            return self::$_parameters[$attr];
        }
        
        return null;
    }

    /**
     * 得到$_POST里的属性值 
     * 
     * 首先考虑从寄存器中拿 
     * 
     * @access protected static
     * @param string $attr 属性名称
     * @param  boolea $trim 是否去掉两端的空格，默认为: true
     * @return mix 当前请求值
     */
    protected static function _post($attr, $trim = true)
    {
        if(isset(self::$_parameters[$attr])) {
            return self::$_parameters[$attr];
        }
        if(isset($_POST[$attr])) {
            $temp   = true === $trim && !is_array($_POST[$attr]) ? trim($_POST[$attr]) : $_POST[$attr];
            self::$_parameters[$attr]    = HString::filterSqlInjection($temp);
            return self::$_parameters[$attr];
        }

        return null;
    }

    /**
     * 检测是否有请求给定的变量
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $attr 变量值
     * @return Boolean 是否
     */
    public function hasParam($attr)
    {
        return isset($_POST[$attr]) || isset($_GET[$attr]) ? true : false;
    }

    /**
     * 得到上传的文件信息 
     * 
     * 暂时只做了是否存在上传的内容检测 
     *
     * @param string $attr 属性名 
     * @access public static
     * @return mix 
     * @exception none
     */
    public static function getFiles($attr)
    {
        if(isset($_FILES[$attr])) {
            return $_FILES[$attr];
        }

        return null;
    }

    /**
     * 得到以PathInfo方式访问的内容 
     * 
     * 如：http://www.xxxx.com/index.php/admin/product 
     * pathinfo的内容就为：admin/product
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getPathInfo()
    {
        $startLoc   = preg_match('/^\/+/', $_SERVER['PATH_INFO']) ? 1 : 0;
        return mb_substr($_SERVER['PATH_INFO'], $startLoc, strlen($_SERVER['PATH_INFO']), 'utf8');
    }

    /**
     * 得到用户查询的变量及值 
     * 
     * 如：http://www.xjiujiu.com/index.php?app=admin&m=product&a=see 
     * 返回的结果为：app=admin&m=product&a=see
     * 
     * @access public static
     * @return string 查询的字符串
     * @exception none
     */
    public static function getQueryString()
    {
        return $_SERVER['QUERY_STRING'];
    }

    /**
     * 得到用户请求的链接地址 
     * 
     * 返回所有的链接内容 
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * 得到当前页面请求的链接地址 
     * 
     * 组合$_SERVER的HTTP_HOST跟REQUEST_URI来得到 
     * 
     * @access public static
     * @return string 
     * @throws none
     */
    public static function getCurUrl()
    {
        $curUrl     = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if('on' == $_SERVER['HTTPS']) {
            return 'https://' . $curUrl;
        } 
        
        return 'http://' . $curUrl;
    }

    /**
     * 得到用户的IP
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return String 当前用户的IP
     */
    public static function getClientIp()
    {
        $unknown = 'unknown';  
        if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] 
            && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown) ) {  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        } elseif ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']
            && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {  
            $ip = $_SERVER['REMOTE_ADDR'];  
        }  
        /*  
        处理多层代理的情况  
        或者使用正则方式：$ip = preg_match('/[\d\.]
        {7,15}/', $ip, $matches) ? $matches[0] : $unknown;  
         */  
        if (false !== strpos($ip, ','))  
            $ip = reset(explode(',', $ip));  

        return $ip;  
    } 

    /**
     * 请求的令牌
     * 
     * 请求时间加自定义前缀的md5哈希值
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $slat 前缀，默认为：'HJZ_'
     * @return String 哈希值
     */
    public static function token($slat = 'HJZ_')
    {
        $token  = md5($slat . $_SERVER['REQUEST_TIME']);
        HSession::setAttribute('token', 'auth');

        return $token;
    }
    
     /**
     * 请求一个URL地址
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $url 当前的网站链接
     * @return String 得到的网站内容 
     */
    public static function requestUrl($url)
    {
        $ch   = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $delay);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)');
        curl_setopt($ch, CURLOPT_NOSIGNAL, true);
        curl_setopt($ch, CURLOPT_FELLOWLOCATION, 1);
        $content= curl_exec($ch);
        curl_close($ch);

        return $content;
    }
    
    /**
     * combineURL
     * 拼接url
     *
     * @param string $baseURL   基于的url
     * @param array  $keysArr   参数列表数组
     * @return string           返回拼接的url
     */
    public static function combineURL($baseURL, $keysArr = null)
    {
        if(empty($keysArr)) {
            return $baseUrl;
        }
        $combined = $baseURL . '?';
        $valueArr = array();

        foreach($keysArr as $key => $val){
            $valueArr[] = $key . '=' . $val;
        }

        return $baseURL . '?' . implode('&', $valueArr);
    }

    /**
     * get_contents
     * 服务器通过get请求获得内容
     * @param string $url       请求的url,拼接后的
     * @return string           请求返回的内容
     */
    public function get_contents($url)
    {
        if(ini_get('allow_url_fopen') == '1') {
            $response   = file_get_contents($url);
        } else {
            $ch         = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $response   = curl_exec($ch);
            curl_close($ch);
        }
        //-------请求为空
        if(empty($response)) {
            throw new HRequestException('无法访问到资源！' . $url);
        }

        return $response;
    }

    /**
     * get
     * get方式请求资源
     * @param string $url     基于的baseUrl
     * @param array $keysArr  参数列表数组      
     * @return string         返回的资源内容
     */
    public function get($url, $keysArr = null)
    {
        return $this->get_contents(self::combineURL($url, $keysArr));
    }

    /**
     * post请求数据
     *
     * post方式请求资源
     *
     * @param string $url       基于的baseUrl
     * @param array $keysArr    请求的参数列表
     * @param int $flag         标志位
     * @return string           返回的资源内容
     */
    public static function post($url, $keysArr, $flag = 0){

        $ch = curl_init();
        if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_POST, TRUE); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr); 
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret = curl_exec($ch);

        curl_close($ch);
        return $ret;
    }

    /**
     * 并发请求URL 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  Array $urls
     * @param  int delay 延时
     * @return Array 请求的内容
     */
    public static function requestUrlMulti($urls, $delay)
    {
        $queue = curl_multi_init();
        $map = array();
        $useragentmap   = array(
            'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0',
            'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
            'Opera/9.27 (Windows NT 5.2; U; zh-cn)',
            'Opera/8.0 (Macintosh; PPC Mac OS X; U; en)',
            'Mozilla/5.0 (Macintosh; PPC Mac OS X; U; en) Opera 8.0',
            'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1 Safari/525.13',
            'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) '
        );
        foreach ($urls as $key => $url) {
            $ch     = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $delay);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_USERAGENT, $useragentmap[ceil(rand(0, 6))]);
            curl_setopt($ch, CURLOPT_NOSIGNAL, true);
            curl_setopt($ch, CURLOPT_FELLOWLOCATION, 1);
            curl_multi_add_handle($queue, $ch);
            $map[(string) $ch]  = $url;
        }
        $responses  = array();
        do {
            while (($code = curl_multi_exec($queue, $active)) == CURLM_CALL_MULTI_PERFORM) ;
            if ($code != CURLM_OK) { break; }
            // a request was just completed -- find out which one
            while ($done = curl_multi_info_read($queue)) {
                // get the info and content returned on the request
                $info   = curl_getinfo($done['handle']);
                $error  = curl_error($done['handle']);
                $html   = curl_multi_getcontent($done['handle']);
                $responses[$map[(string) $done['handle']]] = compact('info', 'error', 'html');
                // remove the curl handle that just completed
                curl_multi_remove_handle($queue, $done['handle']);
                curl_close($done['handle']);
            }
            // Block for data in / output; error handling is done by curl_multi_exec
            if ($active > 0) {
                curl_multi_select($queue, 0.5);
            }
        } while ($active);
        curl_multi_close($queue);
        
        return $responses;
    }

}
?>
