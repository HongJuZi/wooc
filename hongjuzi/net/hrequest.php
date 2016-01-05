<?php

/**
 * @version			$Id: HRequest.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-17 15:21:31 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		net
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die('Restricted access!');

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
     * @access public static
     * @param  array $params 当前的请求变量数组
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
     * @param  boolea $xss 是否过滤HTML XSS攻击，默认为: true
     * @return mix 请求的值
     */
    public static function getParameter($attr = null, $xss = false)
    {
        if(null === $attr) { return self::$_parameters; }
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET': return self::_get($attr, $xss);
            case 'POST': return self::_post($attr, $xss);
            default: return null;
        }
    }

    /**
     * 删除指定的请求变量
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
     * @param  boolea $xss 是否去掉XSS攻击，默认为: false
     * @return String 当前属性值
     */
    protected static function _get($attr, $xss = false)
    {
        if(isset(self::$_parameters[$attr])) {
            return self::$_parameters[$attr];
        }
        if(isset($_GET[$attr])) {
            $temp   = !is_array($_GET[$attr]) ? trim($_GET[$attr]) : $_GET[$attr];
            $temp   = $xss === true ? HString::filterHtmlXSS($temp) : $temp;
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
     * @param  boolea $xss 是否去掉XSS攻击，默认为: false
     * @return mix 当前请求值
     */
    protected static function _post($attr, $xss = false)
    {
        if(isset(self::$_parameters[$attr])) {
            return self::$_parameters[$attr];
        }
        if(isset($_POST[$attr])) {
            $temp   = !is_array($_POST[$attr]) ? trim($_POST[$attr]) : $_POST[$attr];
            $temp   = $xss === true ? HString::filterHtmlXSS($temp) : $temp;
            self::$_parameters[$attr]    = HString::filterSqlInjection($temp);
            return self::$_parameters[$attr];
        }

        return null;
    }

    /**
     * 检测是否有请求给定的变量
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
     */
    public static function getPathInfo()
    {
        $startLoc   = preg_match('/^\/+/', $_SERVER['PATH_INFO']) ? 1 : 0;

        return mb_substr(
            $_SERVER['PATH_INFO'], $startLoc, 
            strlen($_SERVER['PATH_INFO']), 'utf8'
        );
    }

    /**
     * 得到用户查询的变量及值 
     * 
     * 如：http://www.xjiujiu.com/index.php?app=admin&m=product&a=see 
     * 返回的结果为：app=admin&m=product&a=see
     * 
     * @access public static
     * @return string 查询的字符串
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
     */
    public static function getCurUrl($filterParams = null, $query = null)
    {
        $curUrl     = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if($filterParams) {
            $urlInfo    = parse_url($curUrl);
             $curUrl    = $urlInfo['host'] . $urlInfo['path'];
            if($urlInfo['query']) {
                parse_str($urlInfo['query'], $params);
                foreach($filterParams as $attr) {
                    unset($params[$attr]);
                }
                $curUrl .= '?' . http_build_query($params); 
            }
        }
        if($query) {
            if(false === strpos($curUrl, '?')) {
                $curUrl .= '?' . $query;
            } else {
                $loc    = strpos($curUrl, '?') + 1;
                $curUrl .= $loc === strlen($curUrl) ? $query : '&' . $query;
            }
        }
        if('on' == $_SERVER['HTTPS']) {
            return 'https://' . $curUrl;
        } 
        
        return 'http://' . $curUrl;
    }

    /**
     * 得到用户的IP
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
     * @var private static $_header 请求的头报文
     */
    private static $_header     = array(
        "Accept: text/xml,application/xml,application/xhtml+xml,
        text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
        "Accept-Language: ru-ru,ru;q=0.7,en-us;q=0.5,en;q=0.3",
        "Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7",
        "Keep-Alive: 300"
    );
    
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
        $valueArr = array();
        foreach($keysArr as $key => $val){
            $valueArr[] = $key . '=' . $val;
        }

        return $baseURL . '?' . implode('&', $valueArr);
    }

    /**
     * get方式请求资源
     *
     * @param string $url     基于的baseUrl
     * @param array $keysArr  参数列表数组      
     * @return string         返回的资源内容
     */
    public static function getRequest($url, $keysArr = null)
    {
        $combined = self::combineURL($url, $keysArr);

        return self::getContents($combined);
    }

    /**
     * get_contents
     * 服务器通过get请求获得内容
     * @param string $url       请求的url,拼接后的
     * @return string           请求返回的内容
     */
    public static function getContents($url, $refer = 'http://www.baidu.com')
    {
        if (ini_get("allow_url_fopen") == "1") {
            return file_get_contents($url);
        }
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, self::$useragentmap[ceil(rand(0, 7))]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);       //连接超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);              //数据传输的最大允许时间
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $refer);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $response   = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * post请求数据
     *
     * @param string $url       基于的baseUrl
     * @param array $keysArr    请求的参数列表
     * @param int $flag         标志位
     * @return string           返回的资源内容
     */
    public static function post($url, $keysArr, $ssl = 0)
    {
        if(false === strpos($url, '?')) {
            $url	.= '?' . http_build_query($keysArr);
        } else {
            $url	.= '&' . http_build_query($keysArr);
        }
        $ch		= curl_init();
        if(!$ssl) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_POST, TRUE); 
        curl_setopt($ch, CURLOPT_USERAGENT, self::$useragentmap[ceil(rand(0, 6))]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr); 
        curl_setopt($ch, CURLOPT_REFERER, $refer);
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret = curl_exec($ch);
        curl_close($ch);

        return $ret;
    }

    /**
     * @var private static  $useragentmap   浏览器伪装
     */
    private static  $useragentmap   = array(
        'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0',
        'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
        'Opera/9.27 (Windows NT 5.2; U; zh-cn)',
        'Opera/8.0 (Macintosh; PPC Mac OS X; U; en)',
        'Mozilla/5.0 (Macintosh; PPC Mac OS X; U; en) Opera 8.0',
        'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1 Safari/525.13',
        'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) ',
        'Baiduspider+(+http://www.baidu.com/search/spider.htm)'
    );

    /**
     * 并发请求URL 
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
        foreach ($urls as $key => $url) {
            $ch     = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $delay);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_USERAGENT, self::$useragentmap[ceil(rand(0, 6))]);
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

    /**
     *  检测是否为机器人
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return Boolean 是否为机器人
     */
    public static function isRobot()
    {
        $agent  = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (empty($agent)) {
            return false;
        } 
        $spiderSite  = array(
            'tencenttraveler', 'baiduspider+', 'baidugame',
            'googlebot', 'msnbot', 'sosospider+', 'sogou web spider',
            'ia_archiver', 'yahoo! slurp', 'youdaobot', 'yahoo slurp',
            'msnbot', 'java (often spam bot)', 'baiduspider',
            'voila', 'yandex bot', 'bspider', 'twiceler', 'sogou spider',
            'speedy spider', 'google adsense', 'heritrix', 'python-urllib',
            'alexa (ia archiver)', 'ask', 'exabot', 'custo', 'outfoxbot/yodaobot',
            'yacy', 'surveybot', 'legs', 'lwp-trivial',
            'nutch', 'stackrambler', 'the web archive (ia archiver)',
            'perl tool', 'mj12bot', 'netcraft', 'msiecrawler',
            'wget tools', 'larbin', 'fish search',
        );
        foreach($spiderSite as $val) {
            if(strpos($agent, $str) !== false) {
                return true;
            }
        }

        return false;
    }

    /*
     *功能：php完美实现下载远程图片保存到本地
     *参数：文件url,保存文件目录,保存文件名称，使用的下载方式
     *当保存文件名称为空时则使用远程文件原来的名称
     */
    public static function download($url, $dir = '', $name = '', $isRand = 0)
    {
        if(empty($url)){
            throw new HVerifyException('链接地址不能为空！');
        }
        if($name === '') {//保存文件名
            $ext    = strrchr($url, '.');
            $rand   = '';
            if($isRand) {
                $rand   = rand(pow(10,2), pow(10,3)-1);
            }
            $name   = time() . $rand . $ext;
        }
        //创建保存目录
        if(!file_exists($dir)) {
            throw new HVerifyException('目录不存在！');
        }
        //获取远程文件所采用的方法 
        if($type){
            $ch      = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$timeout);
            $file   = curl_exec($ch);
            curl_close($ch);
        } else {
            ob_clean();
            ob_start(); 
            readfile($url);
            $file   = ob_get_contents(); 
            ob_end_clean(); 
        }
        //$size=strlen($file);
        //文件大小 
        $fp2    = @fopen($dir.$name,'a');
        fwrite($fp2, $file);
        fclose($fp2);
        unset($file, $url);

        return $name;
    }

}
?>
