<?php

/**
 * @version			$Id$
 * @create 			2013-11-07 01:11:15 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.judgepopo, app.public.action.publicaction, model.judgemodel');

/**
 * 评论的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class JudgeAction extends PublicAction
{

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo    = new JudgePopo();
        $this->_model   = new JudgeModel($this->_popo);
    }

    /**
     * 重定向到主页
     * 
     * @desc
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function index()
    {
        HResponse::redirect(HResponse::url());
    }

    /**
     * 收藏
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function asave()
    {
        $this->_aAddJudge('save', 3, '`options` = 3');
        HResponse::json(array('rs' => true));
    }

    /**
     * 点赞
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function agreat()
    {
        $this->_aAddJudge('great', 1, '(`options` = 1 OR `options` = 2)');
        HResponse::json(array('rs' => true));
    }

    /**
     * 点弱
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aweak()
    {
        $this->_aAddJudge('weak', 2, '(`options` = 1 OR `options` = 2)');
        HResponse::json(array('rs' => true));
    }

    /**
     * 异步给评介
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @param  int $option 当前的选项
     * @access private
     */
    private function _aAddJudge($field, $option, $where)
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('app'), '应用');
        HVerify::isRecordId(HRequest::getParameter('id'), '信息编号');
        HVerify::isEmpty(HRequest::getParameter('model'), '应用栏目');
        $model      = HClass::quickLoadModel(HRequest::getParameter('model'));
        $record     = $model->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('此分享已被删除，请您确认！');
        }
        $this->_addJudge($option, $where);
        $this->_incModelInfoStats($model, $field, $record);
        if(HSession::getAttribute('id', 'user') != $record['parent_id']) {
            $this->_sendFeed($option, $record, $model->getPopo()->modelZhName);
        }
    }

    /**
     * 发送站内通知
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $option 当前选项
     * @param  int $parentId 分享的作者
     * @param  int $modelName 模块名称
     */
    private function _sendFeed($option, $record, $modelName)
    {
        $user       = HClass::quickLoadModel('user');
        $userInfo   = $user->getRecordById($record['parent_id']);
        if(!$userInfo || $userInfo['id'] == HSession::getAttribute('id', 'user')) { 
            return ;
        }
        $data       = array(
            'parent_id' => $userInfo['id'],
            'content' => $this->_formatFeedContent($option, $userInfo, $record['id'], $modelName),
            'author' => HSession::getAttribute('id', 'user'),
            'type' => $option
        );
        $feed       = HClass::quickLoadModel('feed');
        if(1 > $feed->add($data)) {
            throw new HRequestException('动态信息发送失败～');
        }
    }

    /**
     * 格式化评价通知内容
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $option 当前选项
     * @param  Array $userInfo 用户信息
     * @param  Array $record 评价的信息内容
     * @param  Array $modelZhName 模块中文名
     * @return String 格式化信息
     */
    private function _formatFeedContent($option, $userInfo, $recordId, $modelZhName)
    {
        static $optionMap   = array(1 => '赞', 2 => '弱', 3 => '收藏');

        return '[通知]<a href="' 
            . HResponse::url('user', 'id=' . HSession::getAttribute('id', 'user'), HRequest::getParameter('app')) . '">' 
            . $userInfo['name'] . '</a>' 
            . $optionMap[$option] 
            . '了你的<a href="' 
            . HResponse::url(HRequest::getParameter('model'), 'id=' . $recordId, HRequest::getParameter('app')) . '">' 
            . $modelZhName . '</a>。';
    }

    /**
     * 增加模块信息状态值
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  HModel $model 模块对像
     * @param  string $field 当前字段
     * @param  Array $record 记录信息
     */
    private function _incModelInfoStats($model, $field, $record)
    {
        $data   = array('id' => $record['id'], $field => (intval($record[$field]) + 1));
        if(1 > $model->edit($data)) {
            throw new HRequestException('服务器繁忙，请您稍后再试！');
        }
    }

    /**
     * 添加评价信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $option 当前值
     * @param  String $where 条件
     * @throws HVerifyException | HRequestException
     */
    private function _addJudge($option, $where)
    {
        $judgeInfo  = $this->_model->getJudgeRecord(
            HSession::getAttribute('id', 'user'),
            HRequest::getParameter('id'),
            HRequest::getParameter('model'),
            $where
        );
        if($judgeInfo) {
            $infoMap    = array('', '您已经给过评价！', '您已经给过评价！', '您已经收藏了此分享！');
            throw new HVerifyException($infoMap[$option]);
        }
        $data   = array(
            'options' => $option,
            'parent_id' => HSession::getAttribute('id', 'user'),
            'item_id' => HRequest::getParameter('id'),
            'model' => HRequest::getParameter('model')
        );
        if(1 > $this->_model->add($data)) {
            throw new HRequestException('服务器繁忙，请您稍后再试！');
        }
    }

}

?>
