<?php

/**
 * @version			$Id$
 * @create 			2012-4-8 8:48:15 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.oauth.action.oauthaction');

/**
 * 管理主頁的動作類 
 * 
 * 主要處理後臺管理主頁的相關請求動作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class AuserAction extends OAuthAction
{

    /**
     * 用戶登陸請求動作 
     * 
     * 驗證用戶的登陸信息
     * 
     * @access public
     */
    public function login()
    {
        $this->_loginByEmail();
        HResponse::redirect($this->_getNextUrl());
    }

    /**
     * 用戶名登陸
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function nlogin()
    {
        $this->_loginByName();

        HResponse::redirect($this->_getNextUrl());
    }

    /**
     * 得到下一跳地址
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @return String 得到下一跳地址
     */
    private function _getNextUrl()
    {
        return HRequest::getParameter('next_url') ? HRequest::getParameter('next_url') : HResponse::url();
    }

    /**
     * 異步登錄
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function alogin()
    {
        HVerify::isAjax();
        $this->_loginByEmail();
        HResponse::json(array('rs' => true));
    }
    
    /**
     * 註冊後，直接登錄，異步登錄
     * 
     * @author licheng
     * @access public
     */
    public function registerlogin()
    {
    	HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('user_id'));
        $this->_verifyUserLoginInfo('`id` = ' . HRequest::getParameter('user_id'));
        HResponse::json(array('rs' => true));
    }
    

    /**
     * 通過郵箱登陸
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _loginByEmail()
    {
        $email      = HRequest::getParameter('email');
        $password   = HRequest::getParameter('password', false);
        HVerify::isEmail($email);
        HVerify::isStrLen($password, '登陸密碼', 5, 30);
        $this->_verifyUserLoginInfo(
            '`email` = \'' . $email . '\' AND `password` = \'' . md5($password) . '\''
        );
    }

    /**
     * 驗證用戶登陸信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  $where 驗證條件
     */
    private function _verifyUserLoginInfo($where)
    {
        $vcode      = HSession::getAttribute('vcode');
        if($vcode && $vcode != strtolower(HRequest::getParameter('vcode'))) {
            throw new HVerifyException(HResponse::lang('VCODE_ERROR', false));
        }
        $user       = HClass::quickLoadModel('user'); 
        $userInfo   = $user->getRecordByWhere($where);
        if(empty($userInfo)) {
            throw new HVerifyException(HResponse::lang('用戶名或密碼不正確，請確認！', false));
        }
        $data['id']     = $userInfo['id'];
        $data['ip']     = HRequest::getClientIp();
        $user->edit($data);
        self::_setUserLoginInfo($userInfo);
        self::_setUserRights($userInfo['parent_id']);
        $this->_setUserExtendInfo($userInfo['id']);
        $this->_setReuserMe($user, $userInfo);
    }
    
    /**
     * 登錄方法內部使用 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _loginByName()
    {
        $name     = trim(HRequest::getParameter('name'));
        $password = HRequest::getParameter('password', false);
        HVerify::isStrLen($name, HResponse::lang('USER_NAME', false), 2, 50);
        HVerify::isStrLen($password, HResponse::lang('USER_PASSWORD', false), 5, 30);
        $this->_verifyUserLoginInfo(
            '`name` = \'' . $name . '\' AND `password` = \'' . md5($password) . '\''
        );
    }

    /**
     * 設置用戶擴展信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $userId
     */
    private function _setUserExtendInfo($userId)
    {
        $userInfo   = HClass::quickLoadModel('userinfo');
        $extendInfo = $userInfo->getRecordByWhere('`parent_id` = ' . $userId);
        HSession::setAttribute(null, $extendInfo, 'userinfo');
    }

    /**
     * 設置記住我的登錄狀態
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  UserModel 用戶對象
     * @param  $userInfo 當前的用戶信息集
     */
    private function _setReuserMe($user, &$userInfo)
    {
        if(HRequest::getParameter('remember')) { 
            $hash               = HString::getUUID() . ip2long(HRequest::getClientIp());
            $userInfo['hash']   = $hash;
            $user->edit($userInfo);
            HSession::setAttribute('hjz_keep_login', $hash);
        }
    }

    /**
     * 檢測用戶是否已經登陸 
     * 
     * @access public static
     * @throws HVerifyException 驗證異常
     */
    public static function isLogined()
    {
        if(!HSession::getAttribute('id', 'user') 
            || $_SERVER['REQUEST_TIME'] > HSession::getAttribute('time', 'user')) {
            if(HSession::getAttribute('hjz_keep_login') && !$_COOKIE['hjz_keep_login']) {
                setcookie('hjz_keep_login', HSession::getAttribute('hjz_keep_login'), time() + 3600 * 24);
            }
            if(HSession::getAttribute('is_logout', 'user') || !$_COOKIE['hjz_keep_login']) {
                throw new HVerifyException('您的登陸信息已經過期，請重新登陸！');      
            }
            self::_loginByKeepLoginStatus();
        }
    }

    /**
     * 通過登陸狀態登陸
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    private static function _loginByKeepLoginStatus()
    {
        if(!$_COOKIE['hjz_keep_login']) { return false; }
        $ip     = long2ip(substr($_COOKIE['hjz_keep_login'], 32));
        if(HRequest::getClientIp() != $ip) {
            return false;
        }
        $user     = HClass::quickLoadModel('user');
        $userInfo = $user->getRecordByWhere('`hash` =\'' . $_COOKIE['hjz_keep_login'] . '\'' );
        if($userInfo) {
            self::_setUserLoginInfo($userInfo);
            self::_setUserRights($userInfo['parent_id']);
        }
        throw new HVerifyException('用戶已經不存在，請確認！');
    }

    /**
     * 找回密碼
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function afindpwd()
    {
        HVerify::isAjax();
        HVerify::isEmail(HRequest::getParameter('email'));
        $user         = HClass::quickLoadModel('user');
        $userInfo     = $user->getRecordByWhere(
            '`email` = \'' . HRequest::getParameter('email') . '\''
        );
        if(!$userInfo) {
            throw new HVerifyException('該郵箱還沒未註冊，請確認～');
        }
        $hash       = $user->getFindPwdHashByWhere(
            '`parent_id` = ' . $userInfo['id'] 
            . ' AND `end_time` > \'' . $_SERVER['REQUEST_TIME'] . '\''
        );
        if($hash) {
            throw new HVerifyException('找回密碼鏈接已經發送，請到此郵箱裏查收～');
        }
        $hash   = HString::getUUID();
        if(false === $this->_sendFindPwdEmail($userInfo, $hash)) {
            throw new HRequestException('服務器繁忙，郵件發送失敗！請您稍後再試～');
        }
        $data   = array(
            'hash' => $hash,
            'parent_id' => $userInfo['id'],
            'end_time' => (intval($_SERVER['REQUEST_TIME']) + 3600 * 24) //24小時有效
        );
        if(!$user->addFindPwdHash($data)) {
            throw new HRequestException('服務器繁忙，請您稍後再試～');
        }
        HResponse::json(array('rs' => true));
    }

    /**
     * 重置密碼
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aeditpwd()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('hash'), '驗證口令');
        $password   = HRequest::getParameter('password', false);
        HVerify::isStrLen($password, '新密碼', 6, 20);
        if($password != HRequest::getParameter('repassword', false)) {
            throw new HVerifyException('兩次密碼不一致！'); 
        }
        $user       = HClass::quickLoadModel('user');
        $hashInfo    = $user->getFindPwdHashByWhere(
            '`hash` = \'' . HRequest::getParameter('hash') . '\''
        );
        if(!$hashInfo) {
            throw new HVerifyException('請求無效，請重發找回密碼郵件～');
        }
        if($hashInfo['end_time'] < intval($_SERVER['REQUEST_TIME'])) {
            $user->deleteFindPwdHash($hashInfo['hash']);
            throw new HVerifyException('請求已經過期，請重發找回密碼郵件～');
        }
        $data       = array(
            'id' => $hashInfo['parent_id'],
            'password' => md5($password)
        );
        if(1 > $user->edit($data)) {
            throw new HRequestException('服務器繁忙，請您稍後再試，修改密碼失敗～');
        }
        $user->deleteFindPwdHash($hashInfo['hash']);
        HResponse::json(array('rs' => true));
    }
    
    /**
     * 添加用戶 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function register()
    {
        $this->_register();

        HResponse::redirect($this->_getNextUrl());
    }

    /**
     * 異步註冊
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aregister()
    {
        HVerify::isAjax();
        $this->_register();
        HResponse::json(array('rs' => true));
    }
    
    /**
     * 執行註冊操作
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function doregister()
    {
        $password   = HRequest::getParameter('password', false);
        HVerify::isEmpty(HRequest::getParameter('name'), '登入名稱');
        HVerify::isEmpty(HRequest::getParameter('en_name'), '姓名（英文）');
        HVerify::isEmpty(HRequest::getParameter('tw_name'), '姓名（繁體）');
        HVerify::isEmpty(HRequest::getParameter('age'), '年齡');
        HVerify::isEmpty(HRequest::getParameter('birthday'), '出生日期');
        HVerify::isEmail(HRequest::getParameter('email'), '電郵地址');
        HVerify::isEmpty(HRequest::getParameter('phone'), '電話');
        HVerify::isEmpty($password, '密碼');
        if($password !== HRequest::getParameter('repassword', false)) {
            throw new HVerifyException('兩次密碼不一致！');
        }
        $user       = HClass::quickLoadModel('user');
        if($user->getRecordByWhere('`name` = \'' . HRequest::getParameter('name') . '\'')) {
            throw new HVerifyException('用戶名已經被註冊，請您另換一個！');
        }
        $actor      = $this->_getActorByIdentifier('member');
        HRequest::setParameter('sort_num', $_SERVER['REQUEST_TIME']);
        HRequest::setParameter('password', md5($password));
        HRequest::setParameter('parent_id', $actor['id']); //普通會員
        HRequest::setParameter('edit_time', $_SERVER['REQUEST_TIME']);
        HRequest::setParameter('ip', HRequest::getClientIp());
        HRequest::setParameter('author', 0);
        $userId     = $user->add(HPopoHelper::getAddFieldsAndValues($user->getPopo()));
        if(1 > $userId) {
            throw new HRequestException('註冊失敗，服務器正忙，請您稍後再試～');
        }
        self::_setUserLoginInfo(array(
            'id' => $userId,
            'name' => HRequest::getParameter('name'),
            'email' => HRequest::getParameter('email'),
            'parent_id' => $actor['id'] 
        ));
        self::_setUserRights($actor['rights']);
        HResponse::redirect(HResponse::url());
        //$this->_addUserExtendInfo($userId);
    }

    /**
     * 註冊使用內部使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _register()
    {
    	$vcode = trim(HRequest::getParameter('vcode'));
    	if($vcode != HSession::getAttribute('vcode')){
    		throw new HVerifyException('驗證碼輸入錯誤！');
    	}
        $userName       = trim(HRequest::getParameter('name'));
        HVerify::isStrLen($userName, '姓名', 2, 50);
        HVerify::isEmail(HRequest::getParameter('email'));
        $password   = HRequest::getParameter('password', false);
        HVerify::isStrLen($password, '密碼', 6, 20);
        HRequest::setParameter('password', md5($password));
        $actorInfo  = $this->_getActorByIdentifier('member');
        $user       = HClass::quickLoadModel('user');
        if($user->getRecordByWhere('`email` = \'' . HRequest::getParameter('email') . '\'')) {
            throw new HVerifyException('郵箱地址已被使用，請您另換一個！');
        }
         if($user->getRecordByWhere('`name` = \'' . $userName . '\'')) {
            throw new HVerifyException('用戶名已經被註冊，請您另換一個！');
        }
        HRequest::setParameter('sort_num', $_SERVER['REQUEST_TIME']);
        HRequest::setParameter('parent_id', $actorInfo['id']); //普通會員
        HRequest::setParameter('edit_time', $_SERVER['REQUEST_TIME']);
        HRequest::setParameter('ip', HRequest::getClientIp());
        $userId     = $user->add(HPopoHelper::getAddFieldsAndValues($user->getPopo()));
        if(!$userId) {
            throw new HVerifyException('非常抱歉，服務器正忙，請你稍後再試！');
        }
        self::_setUserLoginInfo(array(
            'id' => $userId,
            'name' => $userName,
            'email' => HRequest::getParameter('email'),
            'parent_id' => $actorInfo['id'] 
        ));
        self::_setUserRights($actorInfo['rights']);
        $this->_addUserExtendInfo($userId);
    }

    /**
     * 添加用戶的擴展信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $userId 用戶ID
     */
    private function _addUserExtendInfo($userId)
    {
        $userInfo   = HClass::quickLoadModel('userinfo');
        if(1 > $userInfo->add(array('parent_id' => $userId, 'edit_time' => $_SERVER['REQUEST_TIME']))) {
            throw new HRequestException('添加用戶擴展信息失敗～');
        }
    }

	/**
	 * ajax檢測郵箱地址或者用戶名是否被註冊
	 */
    public function emailOrUserNameIsUsed()
    {
		$userJson = HRequest::getParameter('user');
		$userModel = HClass::quickLoadModel('user');
		$status = 1;
		if($userJson['email']){
			if($userModel->getRecordByWhere('`email` = \'' . $userJson['email'] . '\'')) {
            	$status = 0;
        	}
		}
		if($userJson['name']){
			if($userModel->getRecordByWhere('`name` = \'' . $userJson['name'] . '\'')) {
            	$status = 0;
        	}
		}
		HResponse::json(array('status' => $status));
	}

	/**
	 * 發送用戶郵箱，驗證激活用戶
	 * 
	 * @desc
	 * 
	 * @param string $email:接收人郵件地址
	 * @param string $name:郵件接收人姓名
	 * @param string $hash:接收人hash值
	 * @param string $password:郵件接收人原始登錄密碼
	 * 
	 * @return boolean 發送成功true，反之false
	 * 
	 * @author licheng
	 * @access private
	 */
	private function _sendUserValidate($email,$name,$hash,$password){
		HClass::import('hongjuzi.net.hemail');
        $model  = new HEmail(HObject::GC('MAIL'));
        $activeUrl = HResponse::url('enter/setaccount', 'hash=' . $hash.'&password='.$password, 'cms');
        $body = $this->getEmailBody($name,'HaoJindu賬號激活','請點擊以下鏈接，激活用戶吧',$activeUrl,'該鏈接在24小時內有效，24小時後需要重新激活');
        return $model->send('HaoJindu賬號激活', $email, null, $body);
	}
	
	
	/**
	 * 發送用戶郵箱，邀請加入團隊
	 * 
	 * @desc
	 * 
	 * @param string $email:接收人郵件地址
	 * @param string $name:接收人姓名
	 * @param string $hash:接收人hash值
	 * @param object $user:邀請人object
	 * @param object $team:邀請加入的團隊object
	 * 
	 * @return boolean 發送成功true，反之false
	 * 
	 * @author licheng
	 * @access private
	 */
	private function _sendUserGetinTeam($email,$name,$hash,$user,$team){
		HClass::import('hongjuzi.net.hemail');
        $model  = new HEmail(HObject::GC('MAIL'));
        $activeUrl = HResponse::url('enter/jointeam', 'hash=' . $hash.'&team_id='.md5($team['id']), 'cms');
        $body = $this->getEmailBody($name,
        							$user['name'].'邀請您加入他（她）在HaoJindu中創建的團隊：'.$team['name'],
									'點擊以下鏈接，接受邀請',
									$activeUrl,
									'該鏈接在24小時內有效，請及時處理！');
		return $model->send('HaoJindu團隊邀請', $email, null, $body);
	}


	/**
	 * 獲取發送郵件的body部分（通用）
	 * 
	 * @desc
	 * 
	 * @param string $name:郵件接收人
	 * @param string $title:郵件標題：如 HaoJindu註冊用戶激活
	 * @param string $titleinfo:郵件標題提醒：如 請點擊以下鏈接，激活用戶吧：
	 * @param string $activeUrl:跳轉鏈接
	 * @param string $valideinfo:有效時間提醒文本：如 該鏈接在24小時內有效，24小時後需要重新激活
	 * 
	 * @return string 發送郵件的主題部分html
	 * 
	 * @author licheng
	 * @access private
	 */
	 private function getEmailBody($name,$title,$titleinfo,$activeUrl,$valideinfo){
	 	$body   = <<<EMAIL_HTML
 <html><meta charset="utf-8" />
<table style="border:3px solid #d9f4ff;width:594px" cellspacing="0" cellpadding="0">
  <tbody><tr>
    <td><table style="border:1px solid #65c3d6;font-size:14px" cellspacing="0" cellpadding="0">
        <tbody><tr>
          <td>
          <img>
            <table cellspacing="0" cellpadding="0" border="0">
              <tbody><tr>
                <td style="padding:20px 16px;color:#333"><table cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                      <td style="height:28px;padding-left:14px">Hi, {$name}!</td>
                    </tr>
                    <tr>
                      <td style="height:28px;padding-left:14px">{$title}</td>
                    </tr>
                    <tr>
                      <td style="color:#666;height:28px;padding-top:24px;padding-left:14px">{$titleinfo}</td>
                    </tr>
                    <tr>
                      <td style="padding:10px 0 0 14px"><a href="{$activeUrl}" style="color:#0082cb;word-break:break-all;word-wrap:break-word;display:inline-block;max-width:540px" target="_blank">{$activeUrl}</a></td>
                    </tr>
                    <tr>
                      <td style="color:red;height:28px;padding-top:6px;padding-left:14px;font-size:12px">（{$valideinfo}）</td>
                    </tr>
                    <tr>
                      <td style="color:#999;padding-top:50px;padding-left:14px;font-size:12px">如果以上鏈接無法訪問，<wbr>請將該網址復制並粘貼至新的瀏覽器窗口中。</td>
                    </tr>如果直接點擊無法打開，請復制鏈接地址，在新的瀏覽器窗口裏打開。
                    <tr>
                      <td style="color:#999;padding:10px 0 20px 14px;font-size:12px">如果你錯誤地收到了此電子郵件，你無需執行任何操作！</td>
                    </tr>
                    <tr>
                      <td style="color:#999;font-size:12px;display:block;border-top:1px dotted #9f9f9f;padding-top:18px;padding-left:14px">我是系統自動發送的郵件，請不要直接回復哦。 <a href="http://www.hongjuzi.net" target="_blank">紅橘子</a>&nbsp;</td>
                    </tr>
                  </tbody></table></td>
              </tr>
            </tbody></table></td>
        </tr>
      </tbody></table></td>
  </tr>
</tbody></table>
</html>
EMAIL_HTML;
		return $body;
	 }
	


    /**
     * 發送重置密碼
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  Arrray $userInfo 用戶信息
     * @param  String $hash 當前的哈希碼
     */
    private function _sendFindPwdEmail($userInfo, $hash)
    {
        HClass::import('hongjuzi.net.hemail');
        $model  = new HEmail(HObject::GC('MAIL'));
        $pwdUrl = HResponse::url('enter/resetpwd', 'hash=' . $hash, 'cms');
        $url    = HResponse::url();
        $body   = <<<EMAIL_HTML
 <html><meta charset="utf-8" />
<table style="border:3px solid #d9f4ff;width:594px" cellspacing="0" cellpadding="0">
  <tbody><tr>
    <td><table style="border:1px solid #65c3d6;font-size:14px" cellspacing="0" cellpadding="0">
        <tbody><tr>
          <td>
          <img>
            <table cellspacing="0" cellpadding="0" border="0">
              <tbody><tr>
                <td style="padding:20px 16px;color:#333"><table cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                      <td style="height:28px;padding-left:14px">Hi, {$userInfo['name']}!</td>
                    </tr>
                    <tr>
                      <td style="height:28px;padding-left:14px">找回您在 <b style="color:#f3750f"><a href="{$url}" target="_blank">好進度</a></b>的密碼</td>

                    </tr>
                    <tr>
                      <td style="color:#666;height:28px;padding-top:24px;padding-left:14px">請點擊以下鏈接，開始重置密碼吧：</td>
                    </tr>
                    <tr>
                      <td style="padding:10px 0 0 14px"><a href="{$pwdUrl}" style="color:#0082cb;word-break:break-all;word-wrap:break-word;display:inline-block;max-width:540px" target="_blank">{$pwdUrl}</a></td>
                    </tr>
                    <tr>

                      <td style="color:red;height:28px;padding-top:6px;padding-left:14px;font-size:12px">（該鏈接在24小時內有效，24小時需要重新註冊）</td>
                    </tr>
                    <tr>
                      <td style="color:#999;padding-top:50px;padding-left:14px;font-size:12px">如果以上鏈接無法訪問，<wbr>請將該網址復制並粘貼至新的瀏覽器窗口中。</td>
                    </tr>如果直接點擊無法打開，請復制鏈接地址，在新的瀏覽器窗口裏打開。
                    <tr>
                      <td style="color:#999;padding:10px 0 20px 14px;font-size:12px">如果你錯誤地收到了此電子郵件，你無需執行任何操作！<wbr>此賬號密碼將不會更改。</td>
                    </tr>
                    <tr>
                      <td style="color:#999;font-size:12px;display:block;border-top:1px dotted #9f9f9f;padding-top:18px;padding-left:14px">我是系統自動發送的郵件，請不要直接回復哦。 <a href="{$url}">好進度</a>&nbsp;帳戶團隊</td>
                    </tr>
                  </tbody></table></td>
              </tr>
            </tbody></table></td>
        </tr>
      </tbody></table></td>
  </tr>
</tbody></table>
</html>
EMAIL_HTML;
        
        return $model->send('好進度密碼重置', $userInfo['email'], null, $body);
    }

    /**
     * 用戶註銷動作 
     * 
     * 註銷用戶當前的登陸記錄信息，回到初始的狀態 
     * 
     * @access public
     */
    public function logout()
    {
        HSession::destroy();
        HSession::setAttribute('is_logout', 1, 'user');
        setcookie('hjz_keep_login', '', time() - 1);

        HResponse::redirect(Hresponse::url());
    }

}

?>
