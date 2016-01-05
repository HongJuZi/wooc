<?php

/**
 * @version			$Id$
 * @create 			2012-5-11 23:11:40 By xjiujiu
 * @package 		app.admin
 * @subpackage 		model
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('vendor.mail.phpmailer.class..PHPMailer');

/**
 * 发送邮件数据操作层类 
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.model
 * @since 			1.0.0
 */
class EmailModel extends HModel
{

    /**
     * @var PHPMailer $_mailer 邮件发送工具实体
     */
    private $_mailer;

    /**
     * @var array $_mailCfg 邮件配置项
     */
    private $_mailCfg;

    /**
     * @var string $_subject 邮件标题
     */
    private $_subject;

    /**
     * @var string $_body 邮件发送的内容
     */
    private $_body;

    /**
     * 构造函数 
     * 
     * 初始化类的变量
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function __construct($mailCfg)
    {
        $this->_subject     = '';
        $this->_to          = '';
        $this->_attachments = '';
        $this->_body        = '';
        $this->_mailCfg     = $mailCfg;
        $this->_mailer      = new PHPMailer(); 
    }

    /**
     * 初始化邮件实例的公用配置项 
     * 
     * 所有邮件发送方式的公用初始化方法 
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _initMailer()
    {
        $this->_mailer->Host        = $this->_mailCfg['mailHost'];
        $this->_mailer->Port        = $this->_mailCfg['mailPort'];
        $this->_mailer->Username    = $this->_mailCfg['mailUserName'];
        $this->_mailer->Password    = $this->_mailCfg['mailUserPasswd'];
        $this->_mailer->SetFrom(
            $this->_mailCfg['mailFromEmail'],
            $this->_mailCfg['mailFromName']
        );
        $this->_mailer->AddReplyTo(
            $this->_mailCfg['mailReplyEmail'],
            $this->_mailCfg['mailReplyName']
        );
    }

    /**
     * 初始化Mailer配置，以STMP的方式 
     * 
     * STMP的专用初始化过程 
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _initMailerByStmp()
    {
        $this->_mailer->IsSMTP();
        $this->_mailer->STMPDebug   = 2;
        $this->_mailer->SMTPAuth    = true;
        $this->_initMailer();
    }

    /**
     * 初始化Mailer的配置项，以Gmail方式来发送 
     * 
     * Gmail的方式来初始化Mailer的对应项
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _initMailerByGmail()
    {
        $this->_mailer->SMTPSecure  = 'ssl';
        $this->_initMailerByStmp();
    }

    /**
     * 以POP3的方式来初始化Mailer参数 
     * 
     * @desc
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _initMailerByPop3()
    {
        $this->_initMailer();
    }

    /**
     * 初始化Mailer用最基本的方式 
     * 
     * @desc
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _initMailerByBasic()
    {
    
    }

    /**
     * 执行邮件的发送功能 
     * 
     * @desc
     * 
     * @access public
     * @param string $subject 发送邮件的标题
     * @param array $to 接收邮件集合
     * @param array $attachments 邮件的附件集合
     * @param string $body 邮件内容
     * @param string $method 发送邮件的方式, 默认为'smtp' 
     * @return boolean 
     * @exception none
     */
    public function send($subject, $to, $attachments, $body)
    {
        $this->_addAddress($to);
        $this->_addAttachments($attachments);
        $this->_subject     = $subject;
        $this->_body        = $this->_getBody($body);

        switch($this->_mailCfg['mailMethod']) {
            case 'stmp':
                return $this->_sendByStmp();
            case 'pop3':
                return $this->_sendByPop3();
            case 'gmail':
                return $this->_sendByGmail();
            case 'basic':
            default:
                return $this->_sendByBasic();
        }
    }

    /**
     * 得到邮件主体内容 
     * 
     * @desc
     * 
     * @access protected
     * @return string 
     * @exception none
     */
    protected function _getBody($body)
    {
        return eregi_replace('[\]', '', HString::decodeHtml($body)); 
    }

    /**
     * 通过SMTP的方式来发送邮件 
     * 
     * @desc
     * 
     * @access protected
     * @return boolean 
     * @exception none
     */
    protected function _sendByStmp()
    {
        $this->_initMailerByStmp();

        return $this->_send();
    }

    /**
     * 通过POP3的方式发送邮件 
     * 
     * @desc
     * 
     * @access protected
     * @return boolean 
     * @exception none
     */
    protected function _sendByPop3()
    {
        $this->_initMailerByPop3();

        return $this->_send();
    }

    /**
     * 使用Gmail来发送邮件 
     * 
     * @desc
     * 
     * @access protected
     * @return boolean
     * @exception none
     */
    protected function _sendByGmail()
    {
        $this->_initMailerByGmail();

        return $this->_send();
    }

    /**
     * 使用最基本的方式来发送邮件 
     * 
     * @desc
     * 
     * @access protected
     * @return boolean 
     * @exception none
     */
    protected function _sendByBasic()
    {
        $this->_initMailerByBasic();

        return $this->_send(); 
    }

    /**
     * 执行邮件的发送过程 
     * 
     * @desc
     * 
     * @access protected
     * @return boolean 
     * @exception none
     */
    protected function _send()
    {
        $this->_mailer->Subject     = $this->_subject;
        $this->_mailer->AltBody     = $this->_getAltBody();
        $this->_mailer->MsgHTML($this->_body);
        if(!$this->_mailer->Send()) {
            HLogger::log($this->_mailer->ErrorInfo, L_ERROR);
            return false; 
        }

        return true;       
    }

    /**
     * 得到提示内容 
     * 
     * @desc
     * 
     * @access protected
     * @return string
     * @exception none
     */
    protected function _getAltBody()
    {
        return HString::cutString(HString::cleanHtmlTag($this->_body), 40); 
    }

    /**
     * 添加接收邮件的地址 
     * 
     * @desc
     * 
     * @access protected
     * @param string $to 接收的邮件地址
     * @return void
     * @exception none
     */
    protected function _addAddress($to)
    {
        if(!is_array($to)) {
            $to  = explode(';', $to);
        }
        foreach($to as $address) {
            if(empty($address)) {
                continue;
            }
            $this->_mailer->AddAddress(
                $address,
                mb_substr($address, 0, strpos('@', 'utf-8'))
            );
        }
    }

    /**
     * 设置邮件的附件内容 
     * 
     * @desc
     * 
     * @access protected
     * @param array $attachments 需要添加的附件
     * @return void
     * @exception none
     */
    protected function _addAttachments($attachments)
    {
        foreach($attachments as $attachment) {
            $this->_mailer->AddAttachment(HString::formatEncodeToOs($attachment));
        }   
    }

}

?>
