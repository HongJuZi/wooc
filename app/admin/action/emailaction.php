<?php

/**
 * @version			$Id$
 * @create 			2012-5-11 22:19:13 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminAction');

/**
 * 发送邮件工具控制层类 
 * 
 * 封装了对邮件发送功能，如同时给多人发送、添加附件等
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class EmailAction extends AdminAction
{
    
    /**
     * 邮件工具主页方法
     * 
     * @desc
     * 
     * @access public
     */
    public function index()
    {
        $this->_render('email');
    }

    /**
     * 发送邮件动作 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function send()
    {
        HVerify::isEmpty(HRequest::getParameter('subject'), '邮件标题');
        HVerify::isEmail(HRequest::getParameter('to'), '邮件地址');
        HVerify::isEmpty(HRequest::getParameter('content'), '邮件内容');
        $this->_uploadAttachments();
        HClass::import('hongjuzi.net.HEmail');
        $this->_model   = new HEmail(HObject::GC('MAIL'));
        $rs     = $this->_model->send(
            HRequest::getParameter('subject'),
            HRequest::getParameter('to'),
            HRequest::getParameter('attachments'),
            HRequest::getParameter('content')
        );
        $this->_deleteAttachments();
        if($rs === false) {
            HResponse::succeed('发送失败！');
        }

        HResponse::succeed('发送成功');
    }

    /**
     * 上传附件动作 
     * 
     * @desc
     * 
     * @access protected
     * @return void 
     * @exception none
     */
    protected function _uploadAttachments()
    {
        if(!array_filter($_FILES['attachments']['name'])) {
            HRequest::setParameter('attachments', array());
            return ;
        }
        HClass::import('hongjuzi.net.HUploader');
        $hUploader  = new HUploader(
            'app/runtime/temp',
            2,
            '*',
            ROOT_DIRHRequest::getParameter('attachments')
        );

        for($i =0; $i < count($_FILES['attachments']['name']); $i ++) {
            $attachment['name']     = $_FILES['attachments']['name'][$i];
            $attachment['type']     = $_FILES['attachments']['type'][$i];
            $attachment['tmp_name'] = $_FILES['attachments']['tmp_name'][$i];
            $attachment['error']    = $_FILES['attachments']['error'][$i];
            $attachment['size']     = $_FILES['attachments']['size'][$i];
            $rs = $hUploader->uploader($attachment, false);
            if(isset($rs['error']) && $rs['error'] != '') {
                HResponse::succeed($rs['error']);
            }
            if(isset($rs['path'])) {
                $attachments[]  = ROOT_DIR . DS . $rs['path'];
            }
        }
        HRequest::setParameter('attachments', $attachments);
    }

    /**
     * 删除邮件的附件 
     * 
     * @descHRequest::getParameter('attachments')
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _deleteAttachments()
    {
        if(!HRequest::getParameter('attachments')) {
            return;
        }
        $rs     = HFile::delete(HRequest::getParameter('attachments'));
        if($rs == false) {
            HLog::write('删除邮件上传附件失败！' .
                var_export(HRequest::getParameter('attachments'), true),
                L_WRAN
            );
        }
    }

    /**
     * 发送邮件 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return 是否发送成功 
     * @throws HHVerifyException 验证异常
     */
    public static function post($subject, $to, $body)
    {
        HVerify::isEmpty($subject, '主题');
        HVerify::isEmpty($to, '收件人');
        HVerify::isEmpty($body, '邮件内容');
        HClass::import('hongjuzi.net.HEmail');
        $model      = new HEmail(HObject::GC('MAIL'));

        return $model->send($subject, $to, null, $body);
    }

}

?>
