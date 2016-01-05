<?php

/**
 * @version			$Id: HBrowser.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-26 12:32:17 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		environment
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 用户浏览器检测工具 
 * 
 * 得到当前用用户所使用的浏览器的环境信息
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.system
 * @since 			1.0.0
 */
class HBrowser extends HObject
{

    /**
     * 得到当前浏览器的名称 
     * 
     * 根据user_agent标识来得到用户所使用的浏览器名称, 大写 
     * 
     * @access public static
     * @return string 
     * @exception none
     */
    public static function getBrowserName()
    {
        return 'CHROME';
    }

    /**
     * 判断是否为微信浏览器
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return Boolean
     */
    public static function isWeiXinBrowser()
    {
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }   

        return false;
    }

    /**
     * 检测用户的类型
     * 
     * 是手机，还是PC 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return 设备类型
     */
    public static function getClientType()
    {
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
			return 'wap';
		}
		//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA'])) {
		//找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], 'wap') ? 'wap' : 'pc';
		}
		//判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT'])) {
			$clientkeywords = array (
				'nokia', 'sony', 'ericsson', 'mot',
				'samsung', 'htc', 'sgh', 'lg',
				'sharp', 'sie-', 'philips', 'panasonic',
				'alcatel', 'lenovo', 'iphone', 'ipod',
				'blackberry', 'meizu', 'android', 'netfront',
				'symbian', 'ucweb', 'windowsce', 'palm',
				'operamini', 'operamobi', 'openwave', 'nexusone',
				'cldc', 'midp', 'wap', 'mobile'
			);
			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match('/(' . implode('|', $clientkeywords) . ')/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				return 'wap';
			}
		}
		//协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT'])) {
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) 
                && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false 
                || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
				return 'wap';
			}
		}

		return 'pc';        
    }

    /**
     * 检测是否为机器人
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return Boolean
     */
    public static function isRobot()
    {
        $agent      = strtolower($_SERVER['HTTP_USER_AGENT']); 
        $spiderSite = array( 
            'TencentTraveler', 'Baiduspider+', 'BaiduGame', 'Googlebot', 
            'msnbot', 'Sosospider+', 'Sogou web spider', 'ia_archiver', 
            'Yahoo! Slurp', 'YoudaoBot', 'Yahoo Slurp', 'MSNBot', 
            'Java (Often spam bot)', 'BaiDuSpider', 'Voila', 'Yandex bot', 
            'BSpider', 'twiceler', 'Sogou Spider', 'Speedy Spider', 
            'Google AdSense', 'Heritrix', 'Python-urllib', 'Alexa (IA Archiver)', 
            'Ask', 'Exabot', 'Custo', 'OutfoxBot/YodaoBot', 
            'yacy', 'SurveyBot', 'legs', 'lwp-trivial', 
            'Nutch', 'StackRambler', 'The web archive (IA Archiver)', 'Perl tool', 
            'MJ12bot', 'Netcraft', 'MSIECrawler', 'WGet tools', 
            'larbin', 'Fish search', 
        ); 
        foreach($spiderSite as $val) { 
            if (strpos($agent, strtolower($val)) !== false) { 
                return true; 
            } 
        } 

        return false;
    }

}
?>
