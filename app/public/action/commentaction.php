<?php

/**
 * @version			$Id$
 * @create 			2013-11-09 21:11:44 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.commentpopo, app.public.action.publicaction, model.commentmodel');

/**
 * 评论的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class CommentAction extends PublicAction
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
        $this->_popo    = new CommentPopo();
        $this->_model   = new CommentModel($this->_popo);
    }

    /**
     * 添加话题分享评论
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function asendqing()
    {
        HVerify::isAjax();
        HVerify::isNumber(HRequest::getParameter('item_id'), '评论对象');
        HVerify::isStrLen(HRequest::getParameter('content'), '评论内容', 2, 206);
        HVerify::isEmpty(HRequest::getParameter('hash'), '校验码');
        $qing       = HClass::quickLoadModel('qing');
        $record     = $qing->getRecordById(HRequest::getParameter('item_id'));
        if(!$record) {
            throw new HRequestException('评论对象已经被删除，请确认～');
        }
        HRequest::setParameter('model', 'qing');
        HRequest::setParameter('parent_id', HSession::getAttribute('id', 'user'));
        HRequest::setParameter('author', HSession::getAttribute('id', 'user'));
        $cId    = $this->_model->add(HPopoHelper::getAddFieldsAndValues($this->_popo));
        if(1 > $cId) {
            throw new HRequestException('服务器繁忙，请您稍后再试～');
        }
        $this->_updateModelTotalComments(1, 'qing', HRequest::getParameter('item_id'));
        //导入类包，进行相关的格式化
        HClass::import('app.cms.action.cmsaction');
        $user   = HSession::getAttributeByDomain('user');
        $user['avatar']     = CmsAction::getAvatar($user);

        HResponse::json(array(
            'rs' => true, 
            'comment' => array(
                'id' => $cId, 
                'content' => HRequest::getParameter('content'), 
                'create_time' => '刚刚',
                'attachment' => $this->_getCommentAttachments(HRequest::getParameter('hash'))
            ),
            'user' => $user
        ));
    }

    /**
     * 添加评论
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function asend()
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('item_id'), '分享编号');
        HVerify::isNumber(HRequest::getParameter('reply_to'), '被回复人编号');
        HVerify::isStrLen(HRequest::getParameter('content'), '评论内容', 2, 206);
        HVerify::isEmpty(HRequest::getParameter('app'), '应用信息');
        HVerify::isEmpty(HRequest::getParameter('model'), '模块信息');
        $model      = HClass::quickLoadModel(HRequest::getParameter('model'));
        $qing       = $model->getRecordById(HRequest::getParameter('item_id'));
        if(!$qing) {
            throw new HRequestException('分享已经被删除，请确认～');
        }
        HRequest::setParameter('parent_id', HSession::getAttribute('id', 'user'));
        HRequest::setParameter('author', HSession::getAttribute('id', 'user'));
        $cId    = $this->_model->add(HPopoHelper::getAddFieldsAndValues($this->_popo));
        if(1 > $cId) {
            throw new HRequestException('服务器繁忙，请您稍后再试～');
        }
        $this->_updateModelTotalComments(1, HRequest::getParameter('model'), HRequest::getParameter('item_id'));
        $this->_sendCommentFeed($cId, $qing['parent_id']);
        $this->_sendReplyFeed($cId);
        //导入类包，进行相关的格式化
        HClass::import('app.cms.action.cmsaction');
        $user   = HSession::getAttributeByDomain('user');
        $user['avatar']     = CmsAction::getAvatar($user);

        HResponse::json(array(
            'rs' => true, 
            'comment' => array(
                'id' => $cId, 
                'content' => HRequest::getParameter('content'), 
                'create_time' => CmsAction::formatTime($_SERVER['REQUEST_TIME']),
                'attachment' => $this->_getCommentAttachments(HRequest::getParameter('hash'))
            ),
            'user' => $user
        ));
    }

    /**
     * 发送回复通知
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _sendReplyFeed($cId)
    {
        if(1 > HRequest::getParameter('reply_to')) {
            return;
        }
        $content    = '用户“<a href="' . HResponse::url('user', 'id=' . HSession::getAttribute('id', 'user')) . '">' 
            . HSession::getAttribute('name', 'user') . '</a>”回复了你的评论。<a href="'
            . HResponse::url(HRequest::getParameter('model') . '/comment', 'id=' . $cId, HRequest::getParameter('app')) . '">去看看</a>';
        //添加系统的评论通知
        $this->_sendFeed($content, HRequest::getParameter('reply_to'), 4);
    }

    /**
     * 发送评论feed
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $cId 评论id
     * @param  int $uId 分享作者ID
     */
    private function _sendCommentFeed($cId, $uId)
    {
        $content    = '用户“<a href="' . HResponse::url('user', 'id=' . HSession::getAttribute('id', 'user')) . '">' 
            . HSession::getAttribute('name', 'user') . '</a>”回复了你的分享。<a href="'
            . HResponse::url(HRequest::getParameter('model') . '/comment', 'id=' . $cId, HRequest::getParameter('app')) . '">去看看</a>';
        //添加系统的评论通知
        $this->_sendFeed($content, $uId, 4);
    }

    /**
     * 更新模块记录里的总评论数
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _updateModelTotalComments($number = 1, $model, $itemId)
    {
        //TODO::需要检测当前的Model是否存在～
        $model  = HClass::quickLoadModel($model);
        $record = $model->getRecordById($itemId);
        $data   = array(
            'id' => $record['id'],
            'total_comments' => ($number + intval($record['total_comments']))
        );
        if(1 > $model->edit($data)) {
            throw new HRequestException('更新模块总评论数失败～');
        }
    }

    /**
     * 加载话题分享评论
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aloadqing()
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('item_id'), '分享编号');
        $where      = '`item_id` = ' . HRequest::getParameter('item_id') . ' AND `model` = \'qing\'';
        $list       = $this->_model->getAllRows($where);
        //加载作者
        $userMap        = array();
        if($list) {
            HClass::import('app.cms.action.cmsaction');
            $user       = HClass::quickLoadModel('user');
            $userMap    = HArray::turnItemValueAsKey(
                $user->getAllRowsByFields(
                    array('id', 'name', 'sex'),
                    HSqlHelper::whereInByListMap('id', 'parent_id', $list)
                ),
                'id'
            );
            foreach($list as &$comment) {
                $userMap[$comment['parent_id']]['avatar']   = CmsAction::getAvatar($userMap[$comment['parent_id']]);
                $comment['create_time']                     = CmsAction::formatTime($comment['create_time']);
                $comment['attachment']                      = $this->_getCommentAttachments($comment['hash']);
            }
        }
        HResponse::json(
            array( 'rs' => true, 'data' => $list, 'userMap' => $userMap)
        );
    }

    /**
     * 加载评论附件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $hash 当前的哈希码
     * @return array 查找到的附件们
     */
    private function _getCommentAttachments($hash)
    {
        $linkedData     = HClass::quickLoadModel('LinkedData');
        $list           = $linkedData->getAllRows('`hash` = \'' . $hash . '\'');
        if(!$list) {
            return null;
        }
        $resource       = HClass::quickLoadModel('resource');

        return $resource->getAllRows(HSqlHelper::whereInByListMap('id', 'res_id', $list));
    }

    /**
     * 异步加载评论列表
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aload()
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('item_id'), '分享编号');
        HVerify::isEmpty(HRequest::getParameter('model'), '当前栏目');
        $where      = '`item_id` = ' . HRequest::getParameter('item_id')
            . ' AND `model` = \'' . HRequest::getParameter('model'). '\'';
        $pageHtml   = $this->_genPageHtml($page + 1, $totalPages, 'page');
        $this->_assignModelList($where, 9);
        //加载作者
        $userMap        = array();
        if(HResponse::getAttribute('list')) {
            $user       = HClass::quickLoadModel('user');
            $userMap    = HArray::turnItemValueAsKey(
                $user->getAllRowsByFields(
                    array('id', 'name'),
                    HSqlHelper::whereInByListMap('id', 'parent_id', HResponse::getAttribute('list'))
                ),
                'id'
            );
            foreach($userMap as &$userInfo) {
                $userInfo['avatar3']    = CmsAction::getAvatar($userInfo, 3);
            }
        }
        HResponse::json(
            array(
                'rs' => true,
                'data' => HResponse::getAttribute('list'),
                'userMap' => $userMap,
                'pageHtml' => HResponse::getAttribute('pageHtml')
            )
        );
    }

    /**
     * 异步删除评论
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function adelete()
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('id'), '评论编号');
        $where      = '`parent_id` = ' . HSession::getAttribute('id', 'user')
            . ' AND `id` = ' . HRequest::getParameter('id');
        $record     = $this->_model->getRecordByWhere($where);
        if(!$record) {
            throw new HRequestException('请确认此评论信息是你发的～');
        }
        if(1 > $this->_model->delete(HRequest::getParameter('id'))) {
            throw new HRequestException('服务器繁忙，请稍后再试，删除失败～');
        }
        $this->_updateModelTotalComments(-1, $record['model'], $record['item_id']);
        HResponse::json(array('rs' => true));
    }

    /**
     * 异步赞评论
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function agreat()
    {
        $this->_updateGreatOrWeak('great');
    }

    /**
     * 异步弱评论
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aweak()
    {
        $this->_updateGreatOrWeak('weak');
    }

    /**
     * 更新赞或弱
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $field 需要更新的字段
     */
    private function _updateGreatOrWeak($field)
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('app'), '应用');
        HVerify::isRecordId(HRequest::getParameter('id'), '评论编号');
        $record = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('评论已被删除～');
        }
        //检测是否已经评价过
        $relationship   = $this->_verifyHasRelationship($type = 1);
        //添加对应的评价数
        $total = (intval($record[$field]) + 1);
        $data   = array(
            'id' => $record['id'],
            $field => $total
        );
        if(1 > $this->_model->edit($data)) {
            throw new HRequestException('服务繁忙请您稍后再试～');
        }
        $this->_addCommentRelationship($relationship);
        $this->_sendJudgeCommentFeed($field, $record['parent_id']);
        HResponse::json(array('rs' => true, 'data' => $total));
    }

    /**
     * 添加评价关联
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  HModel $relationship 关联对象 
     */
    private function _addCommentRelationship($relationship, $type = 1)
    {
        $data           = array(
            'item_id' => HSession::getAttribute('id', 'user'),
            'rel_id' => HRequest::getParameter('id'),
            'model' => 'comment',
            'author' => HSession::getAttribute('id', 'user')
        );
        if(1 > $relationship->add($data)) {
            throw new HRequestException('添加用户-评论关联数据失败～');
        }
    }

    /**
     * 发送评价Feed
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _sendJudgeCommentFeed($field, $uId)
    {
        static $fieldNameMap    = array(
            'weak' => '弱',
            'great' => '赞'
        );
        $app    = HRequest::getParameter('app');
        $content= '[通知]<a href="' . HResponse::url('user', 'id=' . HSession::getAttribute('id', 'user'), $app) . '">' 
            . HSession::getAttribute('name', 'user') . '</a>'
            . $fieldNameMap[$field] . '了你的<a href="' 
            . HResponse::url('qing/comment', 'id=' . HRequest::getParameter('id'), $app)  . '">评论</a>';
        $type   = 'weak' === $field ? 2 : 1;
        $this->_sendFeed($content, $uId, $type);
    }

    /**
     * 发送举报消息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function areport()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('app'), '应用');
        HVerify::isRecordId(HRequest::getParameter('id'), '评论编号');
        $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('评价已被删除，请确认～');
        }
        //检测是否已经举报过
        $relationship   = $this->_verifyHasRelationship(3);
        $user       = HClass::quickLoadModel('user');
        $author     = $user->getRecordById($record['parent_id']);
        $content    = '[举报]<a href="'
            . HResponse::url('user', 'id=' . HSession::getAttribute('id', 'user'), HRequest::getParameter('app')) . '">' 
            . HSession::getAttribute('name', 'user') . '</a>'
            . '举报了<a href="' . HResponse::url('user', 'id=' . $author['id']) .'">'
            . $author['name'] . '</a>的<a href="' 
            . HResponse::url('qing/comment', 'id=' . HRequest::getParameter('id'), $app)  . '">评论</a>';
        //发给管理员
        $admin      = $user->getRecordByWhere('`name`=\'admin\'');
        $uId        = !$admin ? 0 : $admin['id'];
        $this->_sendFeed($content, $uId, 4);
        $this->_addCommentRelationship($relationship, 2);
        HResponse::json(array('rs' => true));
    }

    /**
     * 检测是否已经有关联数据，即已经做过此操作
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $type 评价的分类，如：有1.赞、弱｜2.收藏|3.举报, 默认为1
     * @return HModel $relationship 关联数据对象
     * @throws HVerifyException 验证异常 
     */
    private function _verifyHasRelationship($type = 1)
    {
        $relationship   = HClass::quickLoadModel('relationship');
        $relItem        = $relationship->getRecordByWhere(
            '`item_id` = ' . HSession::getAttribute('id', 'user') . 
            ' AND `type` = ' . $type . //1.代表赞、弱
            ' AND `rel_id` = ' . HRequest::getParameter('id') .
            ' AND `model` = \'comment\''
        );
        if($relItem) {
            throw new HVerifyException('你已经操作过了～');
        }

        return $relationship;
    }

    /**
     * 发送通知
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $field 字段
     * @param  int $uId 用户ID
     */
    private function _sendFeed($content, $uId, $type = 4)
    {
        if($uId == HSession::getAttribute('id', 'user')) {
            return;
        }
        $app    = HRequest::getParameter('app'); 
        $feed   = HClass::quickLoadModel('feed');
        $data   = array(
            'parent_id' => $uId,
            'content' => $content,
            'author' => HSession::getAttribute('id', 'user'),
            'type' => $type
        );
        if(1 > $feed->add($data)) {
            throw new HRequestException('用户通知发送失败～');
        }
    }

}

?>
