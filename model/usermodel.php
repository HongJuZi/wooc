<?php 

/**
 * @version			$Id$
 * @create 			2012-04-25 12:04:21 By xjiujiu
 * @package 		app.admin
 * @subpackage 		model
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('model.BaseModel');

/**
 * 用户列表模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class UserModel extends BaseModel
{

    /**
     * 通过ID来得到当用户信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function getUserListByIds($userIds)
    {
        $this->_db->getSql()
            ->table('#_user')
            ->fields(array('id', 'name'))
            ->where(HArray::whereIn(array('id' => $userIds)));

        return $this->_db->select()->getList();
    }

    /**
     * 通过用户名来得到当前用户的信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $userName 需要检测的用户名
     * @return array 查找到的结果集
     */
    public function getUserInfoByName($userName)
    {
        $this->_db->getSql()
            ->table('#_user')
            ->fields('id')
            ->where('`name` = \'' . $userName . '\'')
            ->limit(1);

        return $this->_db->select()->getRecord();
    }

    /**
     * 通过用户的ID来更新用户的信息  
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  int $userId 当前用户的ID
     * @param  array $recordFV 需要更新的字段及值
     * @return int 影响的行数 
     */
    public function updateUserInfoById($userId, $recordFV)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields(array_keys($recordFV))
            ->values(array_values($recordFV))
            ->where('`id`=' . $userId)
            ->limit(1);

        return $this->_db->update();
    }

    /**
     * 得到用户的信息通过登陆信息 
     * 
     * 给验证用户的信息使用,Support user name or user email check
     * 
     * @access public
     * @param string $userName 当前所使用的用户名
     * @param string $userPasswd 当前所使用的密码
     * @return null | array 
     */
    public function getUserInfoByLogin($userName, $userPasswd)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('*')
            ->where(array(
                '`name`=\'' . $userName . '\' AND ',
                '`password`=\'' . $userPasswd . '\''
            ))->limit(1);

        return $this->_db->select()->getRecord();
    }

    /**
     * 通过邮箱地址登陆
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return Array 查找到的信息集
     */
    public function loginByEmail($email, $password)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('*')
            ->where(array(
                '`email` = \'' . $email . '\' AND ',
                '`password`=\'' . $password . '\''
            ))->limit(1);

        return $this->_db->select()->getRecord();
    }

    /**
     * 检测用户名是否已经使用 
     * 
     * @desc
     * 
     * @access public
     * @param string $userName 当前检测的用户名
     * @return boolean 
     */
    public function isUserNameUsed($userName)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('`name`')
            ->where('`name`=\'' . $userName . '\'')
            ->limit(1);
        $record     = $this->_db->select()->getRecord();
        if(!isset($record['name'])) {
            return false;
        }

        return true;
    }

    /**
     * 查找是否有发送过找回密码记录
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $where 查询条件
     * @return Array 查找到的结果集
     */
    public function getFindPwdHashByWhere($where)
    {
       $linkeddata  = HClass::quickLoadModel('linkeddata');
       $linkeddata->setRelItemModel('user', 'hash');
       $rst         = $linkeddata -> getRecordByWhere($where);
       return $rst;
    }

    /**
     * 添加找回密码记录
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return int 影响行数
     */
    public function addFindPwdHash($data)
    {
        $linkeddata  = HClass::quickLoadModel('linkeddata');
        $linkeddata->setRelItemModel('user', 'hash');
        $arr    = array(
            'item_id'=> $data['parent_id'], 
            'rel_id' => $data['hash'],
            'extend' => $data['end_time'],
            'author' => $data['parent_id']
        );
        $rst    = $linkeddata->add($arr);
        return $rst;
    }

    /**
     * 删除找回密码的Hash记录
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $hash 哈希值
     * @return int 影响行数
     */
    public function deleteFindPwdHash($hash)
    {
        $linkeddata  = HClass::quickLoadModel('linkeddata');
        $linkeddata->setRelItemModel('user', 'hash');
        $arr    = array(
            'rel_id'=> $hash
        );
        $where  = "`rel_id` = '" . $hash . "'";
        return $linkeddata->deleteByWhere($where);
    }

}

?>
