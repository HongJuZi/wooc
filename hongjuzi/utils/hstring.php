<?php

/**
 * @version			$Id: HString.php 1857 2012-05-19 05:13:49Z xjiujiu $
 * @create 			2012-3-17 16:19:19 By xjiujiu
 * @package 	 	hongjuzi
 * @subpackage 		utils
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die('Restricted access!');

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
                $row            = self::_addslashes($row);
                $string[$key]   = self::encodeHtml($row);
            }
        } else {
            $string     = self::_addslashes($string);
            $string     = self::encodeHtml($string);
        }

        return $string;
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
        if(!get_magic_quotes_gpc()) {
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
        if('Other' == HOs::getOsName() || false !== strpos(HOs::getOsName(), 'Windows')) {
            return iconv('utf-8', 'gb2312', $string);
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
            return iconv('gb2312', 'utf-8', $string);
       }
        
        return $string;
    }

    /**
     * 剪切字符串 
     * 
     * @desc
     * 
     * @access public static
     * @param string $string 需要处理的字符串
     * @param int $max 最大的显示字串长
     * @param string $overMask 超过的标记, 默认为：......
     * @return string 
     */
    public static function cutString($string, $max, $overMask = '.....')
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
     * @desc
     * 
     * @access public static
     * @param string $string 需要处理的字符
     * @return string 
     */
    public static function cleanHtmlTag($string)
    {
        return $string;
        $mode   = '%</?[:\w]+(\s?[:\w]+(:\w+)?=\"([/\w.:;\-()\s#=?%]*|[\x{4e00}-\x{9fa5}])*\"\s?)*/?>%i';

        return preg_replace($mode, '', $string);
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

}
?>
