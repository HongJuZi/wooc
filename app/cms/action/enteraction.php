<?php 

/**
 * @version $Id$
 * @create 2012-10-16 17:41:59 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HClass::import('app.cms.action.CmsAction, model.emailmodel');

/**
 * 登陆动作 
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package None
 * @since 1.0.0
 */
class EnterAction extends CmsAction
{

    /**
     * {@inheritDoc}
     */
    public function beforeAction() 
    { 
        $this->_commAssign();
    }

    /**
     * 登陆界面
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        $this->_render('login');
    }
    
    /**
     * 用户登陆 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @throws none
     */
    public function signin()
    {
        HVerify::stringLen(HRequest::getParameter('name'), HResponse::lang('USER_NAME', false), 4, 50);
        HVerify::stringLen(HRequest::getParameter('password'), HResponse::lang('PASSWORD', false), 5, 50);
        $this->_isStudent();
        $user       = HClass::quickLoadModel('user');
        if($user->getRecordByWhere('`name` = \'' . HRequest::getParameter('name') . '\'')) {
            $record     = $user->getUserInfoByLogin(
                HRequest::getParameter('name'),
                md5(HRequest::getParameter('password'))
            );
            if(!$record) {
                throw new HVerifyException('用户名或密码不正确 ！');
            }
        } else {
            if('111111' != HRequest::getParameter('password')) {
                throw new HVerifyException('密码不正确 ！');
            }
            $record     = array(
                'name' => HRequest::getParameter('name'),
                'password' => md5('111111'),
                'parent_id' => $actor
            );
            $record['id']    = $user->add($record);
            if(1 > $record['id']) {
                throw new HVerifyException('服务器系统繁忙，请您稍后再试！');
            }
        }
        $this->_setUserLoginInfo($record);
        HResponse::redirect(HResponse::url());
    }

    /**
     * 是否为学生
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _isStudent()
    {
        $student    = HClass::quickLoadModel('student');
        $record     = $student->getRecordByWhere('`id` = \'' . HRequest::getParameter('name') . '\'' );
        if($record) {
            HSession::setAttribute('class', $record['parent_id']);
            HSession::setAttribute('user_turename', $record['name']);
            return $this->_getActorIdByIdentify('student');
        }

        return $this->_isTeacher();
    }

    /**
     * 是否为老师
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _isTeacher()
    {
        $teacher    = HClass::quickLoadModel('teacher');
        $record     = $teacher->getRecordByWhere('`id` = \'' . HRequest::getParameter('name') . '\'');
        if($record) {
            HSession::setAttribute('user_turename', $record['name']);
            return $this->_getActorIdByIdentify('teacher');
        }
        throw new HVerifyException('用户不存在，请确认您的学号或工号输入正确！');
    }

    /**
     * 通过标识得到角色ID
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $identifier 标识ID
     * @return String 角色ID
     */
    private function _getActorIdByIdentify($identifier)
    {
        $actor      = HClass::quickLoadModel('actor');
        $typeInfo   = $actor->getRecordByWhere('`identifier` = \'' . $identifier . '\'');
        HSession::setAttribute('actor', $identifier);
        HSession::setAttribute('rights', $typeInfo['rights']);
        HSession::setAttribute('actorMap', HArray::turnItemValueAsKey($actor->getAllRows(), 'identifier'));

        return $typeInfo['id'];
    }

    /**
     * 设置用户登陆信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected 
     * @param  array $userInfo 用户登陆信息
     * @return void
     * @throws none
     */
    protected function _setUserLoginInfo($userInfo)
    {
        HSession::setAttribute('user_id', $userInfo['id']);
        HSession::setAttribute('user_name', $userInfo['name']);
        HSession::setAttribute('user_type', $userInfo['parent_id']);
        HSession::setAttribute('user_time', time() + 3600);
    }

    /**
     * 找用戶密碼
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function forgot()
    {
        $this->_render('forgot');
    }
    
    /**
     * 检测是否已经登陆 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @throws HVerifyException
     */
    public static function isLogined()
    {
        if(!HSession::getAttribute('user_name') || time() > intval(HSession::getAttribute('user_time'))) {
            throw new HVerifyException('您还没有登陆！');
        }
    }

    /**
     * 登出系统 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     */
    public static function logout()
    {
        session_destroy();
        HResponse::redirect(HResponse::url());
    }

}

?>
