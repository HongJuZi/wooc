<?php

/**
 * @version			$Id: HString.php 1857 2012-05-19 05:13:49Z xjiujiu $
 * @create 			2012-3-17 16:19:19 By xjiujiu
 * @package 	 	hongjuzi
 * @subpackage 		utils
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die('Restricted access!');

/**
 * 字符串处理工具类 
 * 
 * 主要包括长度，过滤，转换等处理 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.utils
 * @since 			1.0.0
 */
class HString extends HObject
{

    /**
     * 过滤SQL注入非法字符 
     * 
     * @desc
     *
     * @param string | array $string 需要处理的字符串 
     * @access public static
     * @return string | array
     * @exception none
     */
    public static function filterSqlInjection($string)
    {
        if(is_array($string)) {
            foreach($string as $key => $row) {
                //$row            = self::_addslashes($row);
                $string[$key]   = self::encodeHtml($row);
            }

            return $string;
        }
        //$string     = self::_addslashes($string);
        return self::encodeHtml($string);
    }
    
    /**
     * 过滤HTML XSS攻击
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $content 需要处理的内容
     */
    public function filterHtmlXSS($content)
    {
        $skipList = array(
            'onabort', 'onactivate','onafterprint','onafterupdate',
            'onbeforeactivate','onbeforecopy','onbeforecut',
            'onbeforedeactivate','onbeforeeditfocus','onbeforepaste',
            'onbeforeprint','onbeforeunload','onbeforeupdate',
            'onblur','onbounce','oncellchange','onchange',
            'onclick','oncontextmenu','oncontrolselect',
            'oncopy','oncut','ondataavailable',
            'ondatasetchanged','ondatasetcomplete','ondblclick',
            'ondeactivate','ondrag','ondragend',
            'ondragenter','ondragleave','ondragover',
            'ondragstart','ondrop','onerror','onerrorupdate',
            'onfilterchange','onfinish','onfocus','onfocusin',
            'onfocusout','onhelp','onkeydown','onkeypress',
            'onkeyup','onlayoutcomplete','onload',
            'onlosecapture','onmousedown','onmouseenter',
            'onmouseleave','onmousemove','onmouseout',
            'onmouseover','onmouseup','onmousewheel',
            'onmove','onmoveend','onmovestart','onpaste',
            'onpropertychange','onreadystatechange','onreset',
            'onresize','onresizeend','onresizestart',
            'onrowenter','onrowexit','onrowsdelete',
            'onrowsinserted','onscroll','onselect',
            'onselectionchange','onselectstart','onstart',
            'onstop','onsubmit','onunload','javascript',
            '<script>', '</script>','eval','behaviour','expression',
            'embed','frame','iframe'
        );
        if(!is_array($content)) {
            return str_ireplace($skipList, '', $content);
        }
        foreach($content as $key => $html) {
            $content[$key]  = str_ireplace($skipList, '', $html);
        }

        return $content;
    }

    /**
     * 给字符串加上反斜杆 
     * 
     * 当开启了自动加反斜杆的配置时，就直接返回 
     * 
     * @access protected static
     * @param string $string 需要处理的字符串
     * @return string 
     * @exception none
     */
    protected static function _addslashes($string)
    {
        
        if((PHP_VERSION < 6 && !get_magic_quotes_gpc())) {
            return addslashes(self::cleanSlash($string));
        } 
        
        return $string;
    }

    /**
     * 清除反斜杆 
     * 
     * 用法：
     * <code>
     *  HString::cleanSlash('test\''); //test'
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $content  需要处理的内容
     * @return String 
     * @throws none
     */
    public static function cleanSlash($content)
    {
        return stripslashes($content);
    }

    /**
     * 格式化HTML字符
     * 
     * 对：', ", <, >, & 等符号进行转换
     * 
     * @access public static
     * @param string $string 需要处理的字符串
     * @return string 
     * @exception none
     */
    public static function encodeHtml($htmlCode)
    {
        return htmlspecialchars($htmlCode, ENT_QUOTES);
    }

    /**
     * 还原HTML标签 
     * 
     * 把由encodeHtml转化后的html代码反转回来 
     * 
     * @access public
     * @param string $htmlCode 需要处理的HTML代码
     * @return string 
     * @exception none
     */
    public static function decodeHtml($htmlCode)
    {
        return htmlspecialchars_decode($htmlCode, ENT_QUOTES);
    }

    /**
     * 安字符数来计算字符串的长度 
     * 
     * 支持按给写的编码来得到对应的长度 
     * 
     * @access public static
     * @param string $string 需要处理的字符串
     * @param string $encode 字符编码
     * @return int 
     * @exception none
     */
    public static function getLenByChar($string, $encode = 'utf8')
    {
        return mb_strlen($string, $encode);
    }

    /**
     * 通过字节数来得到字符串的长度 
     * 
     * 直接按每个字符所占的内存字节和 
     * 
     * @access public static
     * @param $string
     * @return int 
     */
    public static function getLenByByte($string)
    {
        return strlen($string);
    }

    /**
     * 格式化字符串为本地系统编码格式 
     * 
     * 支持格式到:windows, linux, mac 
     * 
     * @access public static
     * @param string $string 需要处理的文本
     * @return string 
     */
    public static function formatEncodeToOs($string)
    {
        HClass::import('hongjuzi.environment.HOs');
        $osName     = strtolower(HOs::getOsName());
        if('other' === $osName || false !== strpos($osName, 'windows')) {
            return iconv('UTF-8', 'GBK', $string);
        }
        
        return $string;
    }

    /**
     * 格式化字符串为程序的编码格式，从操作系统中 
     * 
     * 支持格式为：windows, linux, mac 
     * 
     * @access public static
     * @param string $string 需要处理的文本
     * @return string 格式化系统字符串
     */
    public static function formatEncodeFromOs($string)
    {
        HClass::import('hongjuzi.environment.HOs');
        if(false !== strpos(HOs::getOsName(), 'Windows')) {
            return iconv('GBK', 'UTF-8', $string);
       }
        
        return $string;
    }

    /**
     * 剪切字符串 
     * 
     * @access public static
     * @param string $string 需要处理的字符串
     * @param int $max 最大的显示字串长
     * @param string $overMask 超过的标记, 默认为：...
     * @return string 
     */
    
    public static function cutString($string, $max, $overMask = '')
    {
        $enMax      = 2 * $max;
        $strLen     = strlen($string);        
        for($i = 0; $i < $strLen && $i < $enMax; $i ++) {
            if(128 <= ord($string[$i])) {
                $enMax --;
            }
        }
        preg_match_all('/./us', $string, $match);
        if($enMax < count($match[0])) { 
            return mb_substr($string , 0, $enMax, 'utf8') . $overMask;
        }

        return $string;
    }
    
    /**
     * 清除字符串里的HTML标签 
     * 
     * @access public static
     * @param string $string 需要处理的字符
     * @return string 
     */
    public static function cleanHtmlTag($string)
    {
        return strip_tags($string);
    }

    /**
     * 把DS换成url的/形式 
     * 
     * 如果当前的DS不是/，则把所有的DS换成/
     * 
     * @access public static
     * @param string $uri 需要处理链接地址
     * @return string  处理后的url串
     */
    public static function DSToSlash($uri)
    {
        if(DS == '/') {
            return $uri;
        }

        return strtr($uri, array(DS => '/'));
    }

    /**
     * 把正斜杆换成DS 
     * 
     * 当DS 不是正斜杆时就换 
     * 
     * @access public static
     * @param string $uri 需要处理的资源路径
     * @return string 处理后的路径值 
     * @exception none
     */
    public static function slashToDS($uri)
    {
        if(DS == '/') {
            return $uri;
        }

        return strtr($uri, array('/' => DS));
    }

    /**
     * 过滤多余的反斜杆 
     * 
     * @desc
     * 
     * @access public static
     * @param string $string 需要处理的字符串
     * @return string 
     */
    public static function filterMoreBackSlash($string)
    {
        return preg_replace('%\\\+%', '', $string);
    }

    /**
     * 得到给定的网址目录地址 
     * 
     * 解析给定网址的目录地址 
     * 
     * @access public static
     * @param string $url
     * @return string 
     */
    public static function getDirUrlByUrl($url)
    {
        $dirUrl     = '';
        if(($loc = strpos($url, '?')) > -1) {
            $dirUrl     = mb_substr($url, 0, $loc, 'utf8');
        }
        if(($loc = strpos($url, '.php')) > -1) {
            $dirUrl     = mb_substr($url, 0, $loc, 'utf8');
            return dirname($dirUrl);
        }
        
        return $dirUrl;
    }

    /**
     * 把\r\n转换成html p段落 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param String $content 需要转换的内容
     * @return String 转换后的内容
     * @throws none
     */
    public static function nrToP($content)
    {
        return '<p>' . preg_replace('/\r?\n/i', '</p><p>', $content) . '</p>';
    }

    /**
     * 文本转换成Unicode字符串
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $str  需要转换的字符串
     * @return String 转换后的字符串 
     */
    public static function text2Unicode( $str )
    {
        $unicode    = array();      
        $values     = array();
        $lookingFor = 1;
        for ($i = 0; $i < strlen( $str ); $i++ ) {
            $thisValue = ord( $str[ $i ] );
            if ( $thisValue < ord('A') ) {
                if ($thisValue >= ord('0') && $thisValue <= ord('9')) {
                    $unicode[] = '00'.dechex($thisValue);
                } else {
                    $unicode[] = '00'.dechex($thisValue);
                }
            } else {
                if ( $thisValue < 128) 
                    $unicode[] = '00'.dechex($thisValue);
                else {
                    if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;                
                    $values[] = $thisValue;                
                    if ( count( $values ) == $lookingFor ) {
                        $number = ( $lookingFor == 3 ) ?
                            ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
                            ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );
                        $number = dechex($number);
                        $unicode[] = (strlen($number)==3)?"0".$number:"".$number;
                        $values = array();
                        $lookingFor = 1;
                    } 
                } 
            }
        } 
        for ($i = 0 ; $i < count($unicode) ; $i++) {
            $unicode[$i] = str_pad($unicode[$i] , 4 , "0" , STR_PAD_LEFT);
        }

        return implode("" , $unicode);
    } 

    /**
     * 得到UUID
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  char $char 连接字符, 默认为：''
     * @return String 得到当前的UUID 
     */
    public static function getUUID($char = '')
    {
        return sprintf( '%04x%04x' . $char . '%04x' . $char . '%04x' . $char . '%04x' . $char . '%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * IP转换成整数
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $ip 需要转换的IP地址
     * @return int 整形数据
     */
    public static function ip2int($ip)
    {
        list($ip1,$ip2,$ip3,$ip4)   =   explode(".", $ip);

        return ($ip1<<24)|($ip2<<16)|($ip3<<8)|($ip4);
    }

    /**
     * 格式化邮箱地址
     * 
     * 不显示真实的地址，如x***@**.com
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return 格式化后的值
     */
    public static function formatEmail($email)
    {
        $start  = strpos($email, '@');
        $point  = $start + strpos(substr($email, $start), '.');

        return $email{0} . '***@***' . substr($email, $point);
    }
    
    /**
     * 格式化時間字符串
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $datetime 時間信息
     * @return String 格式化后的時間
     */
    public static function formatTime($datetime)
    {
        $curTime    = $_SERVER['REQUEST_TIME'];
        $timestamp  = is_numeric($datetime) ? $datetime : strtotime($datetime);
        $subTime    = $curTime - $timestamp;
        if(604800 < $subTime) {     //一周以上就显示发表的具体时间
            return date('Y-m-d',$timestamp);
        }
        if(86400 < $subTime) {
            return ceil($subTime / 86400) . '天以前';
        }
        if(3600 < $subTime) {
            return ceil($subTime / 3600) . '小时以前';
        }
        if(60 < $subTime) {
            return ceil($subTime / 60) . '分钟以前';
        }
        if(10 < $subTime) {
            return $subTime . '秒以前';
        }

        return '刚刚';
    }

    /**
     * 格式化到结止时间
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $datetime
     * @return String
     */
    public static function formatEndTime($datetime)
    {
        $curTime    = $_SERVER['REQUEST_TIME'];
        $timestamp  = is_numeric($datetime) ? $datetime : strtotime($datetime);
        $subTime    = $timestamp - $curTime;
        if($subTime < 0) {
            return '已经结束';
        }
        $day        = intval($subTime / 86400);
        $subTime    -= $day * 86400;
        $hour       = intval($subTime / 3600);
        $subTime    -= 3600 * $hour;
        $min        = intval($subTime / 60);
        $sec        = $subTime - $min * 60; 
        $endTimeStr = '';
        if($day > 0) {
            $endTimeStr = $day . '天';
        }
        if($hour > 0) {
            $endTimeStr .= $hour . '小时';
        }
        if($min > 0) {
            $endTimeStr .= $min . '分';
        }
        if($sec > 0) {
            $endTimeStr .= $sec . '秒';
        }

        return $endTimeStr;  
    }

     /**
     * 格式化数字
     * @param  [type] $number   数字
     * @param  [type] $accuracy 精度位数
     * @return [type]           [description]
     */
    public static function formatNumber($number, $accuracy = 2)
    {
        if(!is_numeric($number)) {
            return 0;
        }
        
        return round($number, $accuracy);
    }
    
    /**
     * 替换\r\n的换行为<br/>
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $content 需要转换的内容
     * @return 转播后的内容
     */
    public static function trunRNToBr($content)
    {
        return strtr($content, array("\r" => '', "\n" => '<br/>'));
    }

    /**
     * 得到第一个字母
     * 获取单个汉字拼音首字母。注意:此处不要纠结。汉字拼音是没有以U和V开头的
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $str 需要处理的字符
     * @return 字符串
     */
    public static function getFirstChar($str) 
    {   
        $fchar  = ord($str{0});
        if($fchar >= ord("A") and $fchar <= ord("z") ) {
            return strtoupper($str{0});
        }
        $s1     = iconv("UTF-8","gb2312", $str);
        $s2     = iconv("gb2312","UTF-8", $s1);
        $s      = $s2 == $str ? $s1 : $str;
        $asc    = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if($asc >= -20319 and $asc <= -20284) return "A";
        if($asc >= -20283 and $asc <= -19776) return "B";
        if($asc >= -19775 and $asc <= -19219) return "C";
        if($asc >= -19218 and $asc <= -18711) return "D";
        if($asc >= -18710 and $asc <= -18527) return "E";
        if($asc >= -18526 and $asc <= -18240) return "F";
        if($asc >= -18239 and $asc <= -17923) return "G";
        if($asc >= -17922 and $asc <= -17418) return "H";
        if($asc >= -17922 and $asc <= -17418) return "I";
        if($asc >= -17417 and $asc <= -16475) return "J";
        if($asc >= -16474 and $asc <= -16213) return "K";
        if($asc >= -16212 and $asc <= -15641) return "L";
        if($asc >= -15640 and $asc <= -15166) return "M";
        if($asc >= -15165 and $asc <= -14923) return "N";
        if($asc >= -14922 and $asc <= -14915) return "O";
        if($asc >= -14914 and $asc <= -14631) return "P";
        if($asc >= -14630 and $asc <= -14150) return "Q";
        if($asc >= -14149 and $asc <= -14091) return "R";
        if($asc >= -14090 and $asc <= -13319) return "S";
        if($asc >= -13318 and $asc <= -12839) return "T";
        if($asc >= -12838 and $asc <= -12557) return "W";
        if($asc >= -12556 and $asc <= -11848) return "X";
        if($asc >= -11847 and $asc <= -11056) return "Y";
        if($asc >= -11055 and $asc <= -10247) return "Z";

        return NULL;
    }

    /**
     * 获取整条字符串汉字拼音首字母
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $zh 需要处理的字符
     * @return 字符
     */
    public static function getPinYin($zh)
    {  
        $ret    = "";
        $s1     = iconv("UTF-8","gb2312", $zh);
        $s2     = iconv("gb2312","UTF-8", $s1);
        if($s2 == $zh){$zh = $s1;}
        for($i = 0; $i < strlen($zh); $i++){
            $s1 = substr($zh,$i,1);
            $p  = ord($s1);
            if($p > 160){
                $s2     = substr($zh,$i++,2);
                $ret    .= self::getFirstChar($s2);
                continue;
            }
            $ret .= $s1;
        }

        return $ret;
    }

    /**
     * 生成短连接,生成不重复的字符串6位
     * 
     * @param $pre 前缀
     * @param $str 字符串
     * @author licheng
     * @access protected
     * @return Array 返回一个数组，包含4组短连接，任取一组即可
     */
    protected function getNoRepeatStr($pre,$str)
    {
        $base32 = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";  
        // 利用md5算法方式生成hash值  
        $hex    = hash('md5', $str.$pre);  
        $hexLen = strlen($hex);  
        $subHexLen = $hexLen / 8;  
        $output = array();  
        for( $i = 0; $i < $subHexLen; $i++ )  
        {  
            // 将这32位分成四份，每一份8个字符，将其视作16进制串与0x3fffffff(30位1)与操作  
            $subHex = substr($hex, $i*8, 8);  
            $idx    = 0x3FFFFFFF & (1 * ('0x' . $subHex));  
            // 这30位分成6段, 每5个一组，算出其整数值，然后映射到我们准备的62个字符  
            $out    = '';  
            for( $j = 0; $j < 6; $j++ )  
            {  
                $val = 0x0000003D & $idx;  
                $out .= $base32[$val];  
                $idx = $idx >> 5;  
            }  
            $output[$i] = $out;  
        }  
        return $output;  
    }

    /**
     * XML字符串生成到数组
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $xml xml内容
     * @return 数组
     */
    public static function xmlToArray($xml)
    {
        $obj    = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $data   = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($data as $key => $val) {
            if(!$val) {
                $arr[$key] = '';
                continue;
            }
            $val = (is_array($val)) || is_object($val) ? self::xmlToArray($val) : $val;
            $arr[$key] = $val;
        }

        return $data;
    }

}

?>
