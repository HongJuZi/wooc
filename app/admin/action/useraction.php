<?php

/**
 * @version			$Id$
 * @create 			2012-04-25 12:04:22 By xjiujiu
 * @package 	 	app.admin
 * @subpackage 	 	action
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.userpopo, app.admin.action.AdminAction, model.usermodel');
HClass::import('vendor.sdk.weixin.WechatUserHelper');

/**
 * 用户列表的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class UserAction extends AdminAction
{   

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_popo        = new UserPopo();
        $this->_model       = new UserModel($this->_popo);
    }

    /**
     * 主页动作 
     * 
     * @access public
     */
    public function index()
    {        
        $this->_search();

        $this->_render('user/list');
    }

     /**
     * 列表后驱方法
    */
    public function _otherJobsAfterList()
    {
        parent::_otherJobsAfterList();
        HResponse::registerFormatMap(
            'sex',
            'name',
            UserPopo::$_sexMap
        );
    }

    /**
     * 基本信息后驱方法
     */
    public function _otherJobsAfterInfo()
    {
        parent::_otherJobsAfterInfo();
        HResponse::setAttribute('sex_list', UserPopo::$_sexMap);
    }

    /**
     * 全称为CheckUserName即检测当前的用户名 
     * 
     * 当用户名存在时给出错误的提示 
     * 
     * @access public
     */
    public function isunused()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('name'), '用户名');
        if(true === $this->_model->isUserNameUsed($userName)) {
            throw new HVerifyException('用户名已经使用！');
        }
        HResponse::json(array('rs' => true, 'message' => '可以使用！'));
    }

    /**
     * 执行模块的添加 
     * 
     * @access public
     */
    public function add()
    {
        HVerify::isStrLen(HRequest::getParameter('password'), '登录密码', 6, 20);
        $this->_formatFieldData();
        $this->_verifyLoginNameAndEmail();
        $this->_add();

        HResponse::succeed('添加成功！');
    }

    /**
     * 检测用户名或邮箱是否已经使用
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $id 用户编号，默认为NULL表示为新加
     * @throws HVerifyException 验证异常
     */
    private function _verifyLoginNameAndEmail($id = null)
    {
        $where  = '(`name` = \'' . HRequest::getParameter('name') 
            . '\' OR `email` = \'' . HRequest::getParameter('email') . '\')';
        if($id) {
            $where  .= ' AND `id` != ' . $id;
        }
        $record     = $this->_model->getRecordByWhere($where);
        if(!$record) {
            return;
        }
        if($record['name'] == HRequest::getParameter('name')) {
            throw new HVerifyException('用户名已经使用！');
        }
        throw new HVerifyException('邮箱已经使用！');
    }

    /**
     * 格式化字段数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _formatFieldData($isEdit = false)
    {
        if(HRequest::getParameter('password')) {
            HRequest::setParameter('password', md5(HRequest::getParameter('password', false)));
        }
        if(HRequest::getParameter('login_time')) {
            HRequest::setParameter('login_time', strtotime(HRequest::getParameter('login_time')));
        }
    }

    /**
     * 编辑提示动作 
     * 
     * @access public
     */
    public function edit()
    {
        HVerify::isRecordId(HRequest::getParameter('id'), '用户ID');
        if(HRequest::getParameter('password')) {
            HVerify::isStrLen(HRequest::getParameter('password'), '登录密码', 6, 20);
        } else {
            HRequest::deleteParameter('password');
        }
        $this->_formatFieldData(true);
        $this->_verifyLoginNameAndEmail(HRequest::getParameter('id'));
        $this->_edit();

        HResponse::succeed('更新成功！', HResponse::url($this->_popo->modelEnName, '', 'admin'));
    }

    /**
     * 删除动作 
     * 
     * @access public
     * @exception HRequestException 请求异常
     */
    public function delete()
    {
        $recordIds  = HRequest::getParameter('id');
        if(!is_array($recordIds)) {
            $recordIds  = array($recordIds);
        }
        if(in_array(HSession::getAttribute('id', 'user'), $recordIds)) {
            throw new HRequestException('删除用户中不能包含自己！');
        }
        $this->_delete($recordIds);
        HResponse::succeed(
            '删除成功！', 
            HResponse::url($this->_popo->modelEnName, '', 'admin')
        );
    }

    /**
     * @var private $_linkeddata 关联对象
     */
    private $_linkeddata;

    /**
     * 得到用户wx信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function awxinfo()
    {
        HVerify::isAjax();
        $wxCfg          = HObject::GC('WECHAT');
        $wechatUser     = new WechatUserHelper($wxCfg['appid'], $wxCfg['secret']);
        $newOpenIds     = $this->_getNewWxOpenIds();
        $actor          = HClass::quickLoadModel('actor');
        $member         = $actor->getRecordByIdentifier('member');
        $wechatUser->requestAccessToken();
        $data           = array();
        foreach($newOpenIds as $item) {
            $json       = $wechatUser->getInfo($item['item_id']);
            $item       = array(
                'name' => $json['nickname'],
                'image_path' => $json['headimgurl'],
                'sex' => $json['sex'],
                'province' => $json['province'],
                'city' => $json['city'],
                'u_from' => 'weixin',
                'city' => $json['city'],
                'parent_id' => $member['id'],
                'create_time' => date('Y-m-d H:i:s', $json['subscribe_time']),
                'author' => HSession::getAttribute('id', 'user')
            );
            $id     = $this->_model->add($item);
            if(1 > $id) {
                throw new HRequestException('添加微信用户数据失败！');
            }
            $this->_updateOpenIdLinkedData($id, $json);
        }
        
        HResponse::json(array('rs' => true, 'message' => '成功获取到' . count($newOpenIds) . '个新用户编号，可以执行获取用户信息功能！'));
    }

    /**
     * 更新OPENID关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $id 用户id
     * @param  $json 信息数据
     */
    private function _updateOpenIdLinkedData($id, $json)
    {
        $data   = array(
            'rel_id' => $id,
            'extend' => json_encode($json, JSON_UNESCAPED_UNICODE),
            'author' => HSession::getAttribute('id', 'user')
        );
        $this->_linkeddata->editByWhere($data, '`item_id` = \'' . $json['openid'] . '\'');
    }

    /**
     * 得到最新微信用户OPENID
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @return list
     */
    private function _getNewWxOpenIds()
    {
        $this->_linkeddata     = HClass::quickLoadModel('linkeddata');
        $this->_linkeddata->setRelItemModel('user', 'openid');
        $list           = $this->_linkeddata->getAllRowsByFields(
            '`id`, `item_id`', 
            '`rel_id` = 0'
        );
        if(!$list) {
            throw new HVerifyException('用户已经全部同步完成，请确认！');
        }

        return $list;
    }

    /**
     * 得到微信用户列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function awxlist()
    {
        HVerify::isAjax();
        $wxCfg          = HObject::GC('WECHAT');
        $wechatUser     = new WechatUserHelper($wxCfg['appid'], $wxCfg['secret']);
        $json           = $wechatUser->requestAccessToken()->getList();
        if(1 > $json['total']) {
            throw new HVerifyException('用户数据为空，请确认是否有观注用户！');
        }
        $total          = $this->_addUserOpenIdLinkedData($json['data']['openid']);
        
        HResponse::json(array('rs' => true, 'message' => '获取到' . $json['total'] . '个新用户编号，可以执行获取用户信息功能！'));
    }

    /**
     * 添加用户关联OPENID数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $data 关联数据
     * @return {int}
     */
    private function _addUserOpenIdLinkedData($openIds)
    {
        $this->_linkeddata     = HClass::quickLoadModel('linkeddata');
        $this->_linkeddata->setRelItemModel('user', 'openid');
        $list           = $this->_linkeddata->getAllRowsByFields('`id`, `item_id`', HSqlHelper::whereOr('item_id', $openIds));
        $map            = HArray::turnItemValueAsKey($list, 'item_id');
        $data           = array();
        foreach($openIds as $openid) {
            if(isset($map[$openid])) {
                continue;
            }
            $data[]     = array(
                'item_id' => $openid,
                'author' => HSession::getAttribute('id', 'user')
            );
        }
        if(1 > $this->_linkeddata->addMore('`item_id`, `author`', $data)) {
            throw new HRequestException('添加用户OPENID关联数据失败！请联系管理人员。');
        }

        return count($data);
    }

    /**
     * 得到当前模块的所有父类 
     * 
     * 根据当前popo类里的parentTable来判断是否有父类 
     * 
     * @access protected
     * @param  Array $data 需要处理的数据
     */
    protected function _registerParentFormatMap($data = null)
    {
        $data   = HResponse::getAttribute('list');
        if(!$data || !$this->_popo->getFieldAttribute('parent_id', 'is_show')) { 
            return ; 
        }
        $parent = HClass::quickLoadModel('actor');    
        $list   = $parent->getAllRowsByFields(
            '`id`, `name`',
            HSqlHelper::whereInByListMap('id', 'parent_id', $data)
        );
        //注册用户名格式化
        HResponse::registerFormatMap(
            'parent_id',
            'name',
            HArray::turnItemValueAsKey($list, 'id')
        );
    }

}

?>
