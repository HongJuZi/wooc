<?php 

/**
 * @version			$Id$
 * @create 			2013-08-07 16:08:18 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 会员模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class MemberModel extends BaseModel
{
	/**
     * 得到用户的信息通过登陆信息 
     * 
     * 给验证用户的信息使用 
     * 
     * @access public
     * @param string $userName 当前所使用的用户名
     * @param string $userPasswd 当前所使用的密码
     * @return null | array 
     * @exception none
     */
    public function getMemberByLogin($userName, $password)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields(array('id', 'name', 'password', 'parent_id'))
            ->where(array(
                '`name`=\'' . $userName . '\' AND ',
                '`password`=\'' . $password . '\''))
                ->limit(1);

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
     * @exception none
     */
    public function isMemberNameUsed($userName)
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
     * 通过用户名来得到当前用户的信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $userName 需要检测的用户名
     * @return array 
     * @throws none
     */
    public function getMemberInfoByName($userName)
    {
        $this->_db->getSql()
            ->table('#_member')
            ->fields('id')
            ->where('`name` = \'' . $userName . '\'')
            ->limit(1);

        return $this->_db->select()->getRecord();
    }

    /**
     * 检测用户登陆
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $userName
     * @param $password
     */
    public function checkMemberByNameAndPwd($userName,$password)
    {
        $this->_db->getSql()
        ->table('#_member')
        ->fields(array('id', 'name', 'password'))
        ->where(array(
            ' `name` = \''.$userName .'\' AND'.
            '  `password` =\''.$password .'\''))
        ->limit(1);

        return $this->_db->select()->getRecord();
    }
    
  /**
   * 获取字母数字随机组合的字符串
   * @param $length  字符串的长度
   */
  	public function randstr($length) {
       $hash = '';
       $chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $max = strlen($chars) - 1;
       mt_srand((double)microtime() * 1000000);
       for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
       }
       return $hash;
  }

}

?>
