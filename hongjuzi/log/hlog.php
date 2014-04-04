<?php 

/**
 * @version			$Id: hlogger.php 1889 2012-05-20 06:47:59Z xjiujiu $
 * @create 			2012-2-25 20:28:39 By xjiujiu
 * @package 	 	hongjuzi
 * @subpackage 		log
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die();

/**
 * 日志类 
 * 
 * 实现系统的日志信息记录，可以是文件，邮件，控制台式的直接输出。 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.log
 * @since 			1.0.0
 */
class HLog extends HObject
{

    /**
     * @var HLog $_hlogger 日志对象
     */
	private static $_hlogger;

    /**
     * @var $_message 当前的日志信息
     */
    private $_message;

    /**
     * @var String static $L_INFo 信息级别
     */
    public static $L_INFO       = 'info';

    /**
     * @var String static $L_NOTICE 注意级别
     */
    public static $L_NOTICE     = 'notice';

    /**
     * @var String  static $L_WARN 警告级别     
     */
    public static $L_WARN       = 'warn';

    /**
     * @var String static $L_ERROR 严重错误级别
     */
    public static $L_ERROR      = 'error';

    /**
     * @var private static $_handlerMap  HLogger的唯一实例存储器  
     */
    private static $_handlerMap  = array('page', 'file', 'email');

    /**
     * @var Array $_logCfg 日志配置
     */
    private $_logCfg;

    /**
     * 构造函数
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_logCfg         = HObject::GC('LOG');
    }

    /**
     * 日志的唯一入口 
     * 
     * 记录日志的方法调用，这里 
     *
     * @param string $message 日志信息 
     * @access public static
     * @param String $message 当前的日志信息
     * @param String $level 日志级别 
     */
    public static function write($message, $level = 'info')
    {
        $hlogger        = self::getInstance();
        $hlogger->exec($message, $level);
        /*如果是调试状态，直接退出整个请求*/
        if(true === HObject::GC('DEBUG')) { exit; }
    }

    /**
     * 得到日志记录的唯一实例 
     * 
     * 单例模式的类实例化入口 
     * 
     * @access public static
     * @return HLogger 实例 
     */
    public static function getInstance()
    {
        if(!(self::$_hlogger instanceof HLog)) {
            self::$_hlogger     = new self();
        }

        return self::$_hlogger;
    }

    /**
     * 写入日志
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $message 需要写入的内容
     * @param  String $level 当前的日志级别
     */
    public function exec($message, $level)
    {
        $message        = $this->formatMessage($message, $level);
        foreach($this->_logCfg['method'] as $method => $levels) {
            if(-1 != strpos($level, $levels)) {
                $this->$method($message);
            }
        }
    }

    /**
     * 格式化日志信息 
     * 
     * 可以根据相关配置得到完整的 
     * 
     * @access public
     * @param string $message 日志信息
     * @param  string $level 日志级别
     */
    public function formatMessage($message, $level)
    {
        $level	= empty($level) ? 'UNKNOW' : $level;

        return sprintf("[%10s]\t%s\t%s\n", strtoupper($level), date('Y-m-d H:m:s'), $message);
    }

    /**
     * 日志直接页面显示 
     * 
     * 日志信息打印到页面或是控制台 
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function page($message)
    {
        echo <<<LOG_PAGE_HTML
<div style="margin: 30px; line-height: 20px; padding: 10px; color: #454444; border: 1px #ccc solid; font-size: 14px; word-wrap: break-wrap; ">{$message}</div>
LOG_PAGE_HTML;
    }

    /**
     * 日志收集到文件中 
     * 
     * 把日志信息写入到文件中 
     * 
     * @access public
     */
    public function file($message)
    {
        $logFile    = ROOT_DIR . $this->_logCfg['dir'] . '/error.log';
        if(file_exists($logFile) && filesize($logFile) >= (1000 * 1000 * floatval($this->_logCfg['size']) )) {
            HFile::move($logFile, $logFile . '-' . time());
        }
        if(file_exists($logFile)) {
            HFile::append($logFile, $message);
            return;
        } 
        HFile::write($logFile, $message);
    }

    /**
     * 把日志信息发到设定的邮箱内 
     * 
     * 把严重的错误信息及时发给管理员去及时处理 
     *
     * @access public
     */
    public function email($message)
    {
        HClass::import('hongjuzi.net.hemail');
        $time       = date('Y-m-d H:m:s', $_SERVER['REQUEST_TIME']);
        $mailCfg    = HObject::GC('MAIL');
        $email      = new HEmail($mailCfg);
        $body       = <<<LOG_PAGE_HTML
<h2>您好，{$mailCfg['mailReplyName']}，以下是您网站的系统日志提醒内容，请您及时修复：</h2>
<div style="margin: 30px; line-height: 20px; padding: 10px; color: #454444; border: 1px #ccc solid; font-size: 14px; word-wrap: break-wrap; ">{$message}</div>
LOG_PAGE_HTML;

        return $email->send(
            '网站日志提醒-您好' . $mailCfg['mailReplyName'], 
            $mailCfg['mailReplyEmail'],
            null,
            $body
        );
    }

}

?>
