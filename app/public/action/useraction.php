<?php

/**
 * @version			$Id$
 * @create 			2013-11-17 18:11:51 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.userpopo, app.public.action.publicaction, app.oauth.action.auseraction,  app.cms.action.cmsaction, model.usermodel');

/**
 * 用户扩展信息处理的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class UserAction extends PublicAction
{

    public function beforeAction()
    {
        AuserAction::isLogined();
    }

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo    = new UserPopo();
        $this->_model   = new UserModel($this->_popo);
        AuserAction::isLogined();  
    }

    /**
     * 注册用户默认关注系统用户
     * @return [type] [description]
     */
    public function defaultfocus()
    {
        HVerify::isAjax();
        $userList   = $this->_model->getAllRowsByFields(array('id', 'name'), '`is_default` = 1');
        if(!empty($userList)) {
            $uid    = HSession::getAttribute('id', 'user');
            $linkeddata     = HClass::quickLoadModel('linkeddata');
            $linkeddata->setRelItemModel('user', 'focus');
            foreach ($userList as $key => $value) {
                $mid    = $value['id'];
                $data   = array(
                    'item_id'   => $mid,
                    'rel_id'    => $uid,
                    'extend'    => 1,
                    'author'    => $uid
                );
                $id     = $linkeddata->add($data);
                if(1 > $id) {
                    throw new HRequestException('关注失败，请稍后再试');
                }
                 //更新关注数与粉丝数
                $this->_updateUserFocusAndFans($mid, $uid, 1);
                $extendName     = '关注了';
                $noticeData     = array(
                    'parent_id' => $mid,
                    'type'      => 4,
                    'content'   => '<a href="' . HResponse::url('user', 'mid='.$uid, 'cms') . '">' . HSession::getAttribute('name', 'user') . '</a>'
                    . $extendName . '用户<a href="' . HResponse::url('user', 'mid=' . $mid, 'cms') . '">' . $value['name'] . '</a>',
                    'author'    => $uid,
                    'extend'    => $extendName . '用户<a href="' . HResponse::url('user', 'mid='. $uid, 'cms') . '">' . $value['name'] . '</a>'
                );

                CmsAction::addNotice($noticeData);
            }
        }

        HResponse::json(array('rs' => true));
    }

    /**
     * 关注用户与解除关注
     * @return [type] [description]
     */
    public function focus()
    {
        HVerify::isAjax();
        $mid            = HRequest::getParameter('mid');
        $type           = HRequest::getParameter('type');
        $uid            = HSession::getAttribute('id', 'user');
        //不能自己关注自己
        if($mid === $uid) {
            throw new HRequestException('不能自己关注自己');
        }
        $linkeddata     = HClass::quickLoadModel('linkeddata');
        $muserInfo      = $this->_model->getRecordById($mid);
        $linkeddata->setRelItemModel('user', 'focus');
        $where          = "`item_id` = " . $mid . " and `rel_id` = " . $uid;
        $record         = $linkeddata->getRecordByWhere($where);
        $extend         = 1;
        if(empty($record)) {
            //$extend    = $this->_isfocus($linkeddata, $mid, $uid, $extend);
            $data   = array(
                'item_id' => $mid,
                'rel_id'  => $uid,
                'extend'  => $extend,
                'author'  => $uid
            );
            $id     = $linkeddata->add($data);
            $rstId  = $id;
            if(1 > $id) {
                throw new HRequestException('关注失败，请稍后再试');
            }
            //更新关注数与粉丝数
            $this->_updateUserFocusAndFans($mid, $uid, 1);
        }else {
            //加关注与取消关注切换
            $extend         = $record['extend'] > 0 ? 0 : 1;
            $record['extend'] = $extend;
            $id     = $linkeddata->edit($record);
            if(1 > $id) {
                throw new HRequestException('解除关注失败，请稍后再试');
            }
            $rstId  = $record['id'];
            //更新关注数与粉丝数
            $this->_updateUserFocusAndFans($mid, $uid, $record['extend'] == 1 ? 1 : -1);
        }
        $extendName     = $extend == 1 ? '关注了' : '取消关注了';
        $noticeData     = array(
            'parent_id' => $muserInfo['id'],
            'type'      => 4,
            'content'   => '<a href="' . HResponse::url('user', 'mid='.$uid, 'cms') . '">' . HSession::getAttribute('name', 'user') . '</a>'
            . $extendName . '用户<a href="' . HResponse::url('user', 'mid=' . $muserInfo['id'], 'cms') . '">' . $muserInfo['name'] . '</a>',
            'author'    => $uid,
            'extend'    => $extendName . '用户<a href="' . HResponse::url('user', 'mid='. $muserInfo['id'], 'cms') . '">' . $muserInfo['name'] . '</a>'
        );
        CmsAction::addNotice($noticeData);
        
        HResponse::json(array('rs'=>true, 'extend' => $extend, 'id'=>$rstId, 'type' =>$type, 'mid'=> $mid));
    }


    private function _updateUserRelation($linkeddata, $mid, $uid, $extend)
    {
        $data = array(
            'item_id' => $mid,
            'rel_id'  => $uid,
            'extend'  => $extend
        );
        if(1 > $linkeddata->edit($data)){
            throw new HRequestException('更新用户关系失败');
        }
    }

    /**
     * 更新用户关注数与粉丝数
     * @return [type] [description]
     */
    private function _updateUserFocusAndFans($mid, $uid, $nums)
    {
        //$mid => 粉丝数 , $uid => 关注数
        $mRecord    = $this->_model->getRecordById($mid);
        $mRecord['total_fans'] = $mRecord['total_fans'] + $nums;
        if(1 > $this->_model->edit($mRecord)) {
            throw new HRequestException('粉丝数更新失败，请稍后再试');
        }
        $uRecord    = $this->_model->getRecordById($uid);
        $uRecord['total_focus'] = $uRecord['total_focus'] + $nums;
        if(1 > $this->_model->edit($uRecord)) {
            throw new HRequestException('关注数更新失败，请稍后再试');
        }
    }

     /**
     * 用户今日签到
     * @return [type] [description]
     */
    public function usersign()
    {
        HVerify::isAjax();
        $uid    = HSession::getAttribute('id', 'user');
        $nums   = HRequest::getParameter('nums');
        $linkeddata = HClass::quickLoadModel('linkeddata');
        $linkeddata->setRelItemModel('user','sign');
        $data   = array(
                'item_id' => 0,
                'rel_id'  => $uid,
                'extend'  => 0,
                'author'  => $uid
        );
        if(1 > $linkeddata->add($data)) {
            throw new HRequestException('今日签到失败，请稍后再试');
        }
        $nums = $nums + 1;
        //更新签到数
        $this->_updateUserSign($nums);
        //计算积分
        CmsAction::countIntegral(0);
        HResponse::json(array('rs'=> true, 'nums'=> $nums));
    }

    /**
     * 更新用户总签到数
     * @param  [type] $nums [description]
     * @return [type]       [description]
     */
    private function _updateUserSign($nums)
    {
        $data   = array(
            'id' => HSession::getAttribute('id', 'user'),
            'total_sign' => $nums
        );

        if(1 > $this->_model->edit($data)) {
            throw new HRequestException('签到总数更新失败，请稍后再试');
        }
    }

     /**
     * 编辑用户的描述
     * @return [type] [description]
     */
    public function edescription()
    {
        HVerify::isAjax();
        $id     = HRequest::getParameter('id');
        $desc   = HRequest::getParameter('description');
        if($id != HSession::getAttribute('id', 'user')) {
            throw new HRequestException('用户请求错误');
        }
        $data = array(
            'id' => $id,
            'description' => $desc
        );
        if(1 > $this->_model->edit($data)) {
            throw new HRequestException('修改详情失败，请稍后再试');
        }

        HResponse::json(array('rs'=>true, 'data' => array('description' => $desc, 'id' => $id)));
    }

    /**
     * 得到用户的信息
     * @return [type] [description]
     */
    public function getuserinfo()
    {
        HVerify::isAjax();
        $id     = HRequest::getParameter('id');
        if($id != HSession::getAttribute('id', 'user')) {
            throw new HRequestException('用户请求错误');
        }
        $record     = $this->_model->getRecordById($id);

        HResponse::json(array('rs'=>true, 'data'=> $record));
    }

    /**
     * 添加用户资料收藏
     * @return [type] [description]
     */
    public function addcollect()
    {
        HVerify::isAjax();
        $itemId = HRequest::getParameter('item_id');    //文件ID
        $relId  = HRequest::getParameter('rel_id');     //用户ID
        $uId    = HSession::getAttribute('id', 'user');
        if($uId != $relId) {
            throw new  HRequestException('网络请求错误');
        }
        HVerify::isEmpty($itemId);
        HVerify::isEmpty($relId);
        HRequest::setParameter('extend', 0);
        HRequest::setParameter('author', $uId);
        $linkeddata     = HClass::quickLoadModel('linkeddata');
        $linkeddata->setRelItemModel('user', 'collect');
        $where          = '`item_id` = ' . $itemId . ' and `rel_id` = ' . $relId;
        $record         = $linkeddata->getRecordByWhere($where);
        if(!empty($record)) {
            throw new HRequestException('对不起该资料您已经收藏');
        }
        if(1 > $linkeddata->add(HPopoHelper::getAddFieldsAndValues($linkeddata->getPopo()))) {
            throw new HRequestException('收藏失败，请稍后再试');
        }
        //更新收藏数
        $this->_updateFilesCollectNums($itemId);
        $files          =  HClass::quickLoadModel('files');
        $filesRecord    = $files->getRecordById($itemId);
        CmsAction::countIntegral($itemId);
        $noticeData     = array(
            'parent_id' => HSession::getAttribute('id', 'user'),
            'type'      => 1,
            'content'   => '感谢您收藏了 ' . '<a href="' . HResponse::url('files', 'id='. $filesRecord['id'], 'cms') . '">' . $filesRecord['name'] . '</a>',
            'author'    => HSession::getAttribute('id', 'user'),
            'extend'    => '收藏了资料'. '<a rel="tipsy" title="' . $filesRecord['name'] . '" href="' . HResponse::url('files', 'id='. $filesRecord['id'], 'cms') . '">' . $filesRecord['name'] . '</a>'
        );
        CmsAction::addNotice($noticeData);   
        HResponse::json(array('rs'=>true));
    }

    /**
     * 更新资料收藏数
     * @return [type] [description]
     */
    private function _updateFilesCollectNums($id)
    {
        $files      = HClass::quickLoadModel('files');
        $record     = $files->getRecordById($id);
        if(empty($record)) {
            throw new HRequestException('该资料记录已经不存在，请稍后再试');
        }
        $data       = array(
            'id' => $id,
            'total_collect' => $record['total_collect'] + 1
        );
        if(1 > $files->edit($data)) {
            throw new HRequestException('资料收藏数更新失败，请稍后再试');
        }
    }

    /**
     * 换一组兴趣
     * @return [type] [description]
     */
    public function getinterest()
    {
        HVerify::isAjax();
        $page       = HRequest::getParameter('page');
        $interest   = HClass::quickLoadModel('interest');
        $popo       = $interest->getPopo();
        $popo->setFieldAttribute('id', 'is_order', 'ASC');
        $interest->set('popo', $popo);
        $prev       = 12;
        $list       = $interest->getList($page, $prev);
        $userInterest = $this->_getUserInterest();
        foreach($list as $key => $value) {
            $isexist    = 0;
            if(array_key_exists($value['id'], $userInterest)) {
                $isexist    = 1;
            }
            $list[$key]['isexist'] = $isexist;
        }
        $total      = $interest->getTotalRecords();
        $totalpage  = ceil($total/$prev);

        HResponse::json(array('rs'=>true, 'data'=>$list, 'totalpage'=>$totalpage));
    }

    /**
     * 得到用户的兴趣组
     * @return [type] [description]
     */
    private function _getUserInterest()
    {
        $uid        = HSession::getAttribute('id', 'user');
        $record     = $this->_model->getRecordById($uid);
        $interest   = $record['interest'];
        $interestModel = HClass::quickLoadModel('interest');
        if(empty($interest)) {
            $userInterest   = null;
        }else{
            $where          = '`id` in (' . $interest . ')';
            $userInterest   = HArray::turnItemValueAsKey($interestModel->getAllRows($where), 'id');
        }

        return $userInterest;
    }
     /**
     * 保存头像
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function saveavatar()
    {
        HClass::import('hongjuzi.filesystem.hdir');
        $result             = array();
        $result['success']  = false;
        if(empty($_FILES)) {
            HResponse::json($result);
            exit;
        }
        //定义一个变量用以储存当前头像的序号
        $i                  = 1;
        $msg                = '';
        $maxSize            = 0.2 * 1024 * 1024; //单位Bytes
        $type               = 'image/jpeg|application/x-jpg|image/pjpeg';
        $avatarPathPrefix   = HFile::getAvatarPathByUserIdPrefix(HSession::getAttribute('id', 'user'));
        //遍历所有文件域
        while (list($key, $val) = each($_FILES)) {
            if($_FILES[$key]['error'] > 0) {
                $msg    .= $_FILES[$key]['error'];
                continue;
            }
            if($maxSize < $_FILES[$key]['size']) {
                $msg    .= '第' . $i .'张头像文件太大';
                continue;
            }
            if(false === strpos($type, $_FILES[$key]['type'])) {
                $msg    .= '第' . $i .'张头像文件类型不对！';
                continue;
            }
            //原始图片(file 域的名称：__source，如果客户端定义可以上传的话，可在此处理）。
            if($key == '__source') {
                $_FILES['image_path']   = $_FILES['__source'];
                try {
                    $this->_uploadFile();
                    $successNum++;
                } catch(Exception $ex) {
                    $msg    .= $ex->getMessage();
                }
                continue;
            }
            //头像图片(file 域的名称：__avatar1,2,3...)。
            $filePath   = HObject::GC('RES_DIR') . '/user/' . $avatarPathPrefix . $i . '.jpg';
            HDir::create(dirname($filePath));
            move_uploaded_file($_FILES[$key]['tmp_name'], ROOT_DIR . $filePath);
            $result['avatarUrls'][$i] = HResponse::url() . $filePath;
            $result['success'] = true;
            $i ++;
        }
        $result['message'] = $msg;
        //返回图片的保存结果（返回内容为json字符串）
        HResponse::json($result);
    }

     /**
     * 添加用户订阅
     * @return [type] [description]
     */
    public function addbook()
    {
        HVerify::isAjax();
        $linkeddata = HClass::quickLoadModel('linkeddata');
        $linkeddata->setRelItemModel('user', 'book');
        $data = array(
            'item_id' => HRequest::getParameter('id'),
            'rel_id'  => HSession::getAttribute('id', 'user'),
            'extend'  => 0,
            'author'  => HSession::getAttribute('id', 'user')
        );

        $id     = $linkeddata->add($data);
        if(1 > $id) {
            throw new HRequestException('订阅失败，请稍后再试');
        }

        HResponse::json(array('rs'=>true, 'id' => $id , 'data_id' => HRequest::getParameter('id')));
    }

    /**
     * 取消用户订阅
     * @return [type] [description]
     */
    public function delbook()
    {
        HVerify::isAjax();
        $id             = HRequest::getParameter('id');
        $linkeddata     = HClass::quickLoadModel('linkeddata'); 
        $linkeddata->setRelItemModel('user', 'book');
        $record         = $linkeddata->getRecordById($id);
        if(empty($record)) {
            throw new HRequestException('该记录已经不存在，请稍后再试');
        }
        if(1 > $linkeddata->delete($id)) {
            throw new HRequestException('取消订阅失败，请稍后再试');
        }

        HResponse::json(array('rs'=>true, 'id'=>$id));
    }

    /**
     * 更新用户基本信息
     * @return [type] [description]
     */
    public function updatebaseinfo()
    {
        HVerify::isEmpty(HRequest::getParameter('name'));
        $interest   = HRequest::getParameter('interest');
        $this->_addInterestUser($interest);
        if(1 > $this->_model->edit(HPopoHelper::getUpdateFieldsAndValues($this->_model->getPopo()))) {
            throw new HRequestException('更新失败，请稍后再试');
        }
        HSession::setAttribute('name', HRequest::getParameter('name'), 'user');
        HResponse::redirect(HResponse::url('muser/editinfo' ,'' ,'cms'));
    }

    /**
     * 建立用户与兴趣组的关联
     * @param [type] $interest [description]
     */
    private function _addInterestUser($interest)
    {
        $linkeddata     = HClass::quickLoadModel('linkeddata');
        $linkeddata->setRelItemModel('user', 'interest');
        $interestModel  = HClass::quickLoadModel('interest');
        $uid            = HSession::getAttribute('id', 'user');
        if(!empty($interest)) {
            $where  = '`rel_id` = ' . $uid;
            if(!$linkeddata->deleteByWhere($where)){
                throw new HRequestException('兴趣与用户关联解除失败，请稍后再试');
            }
            if(strpos($interest, ';')){
                $interestArr    = explode(';', $interest);
                $interestArr    = array_filter($interestArr);
                for($i=0; $i<count($interestArr); $i++) {
                    $item_id    = $interestArr[$i];
                    $data = array(
                        'item_id'   => $item_id,
                        'rel_id'    => $uid,
                        'extend'    => 0,
                        'author'    => $uid
                    );
                    if(1 > $linkeddata->add($data)) {
                            throw new HRequestException('添加兴趣与用户关联失败，请稍后再试'); 
                    }
                }
            }else{
                $data   = array(
                    'item_id' => $interest,
                    'rel_id'  => $uid,
                    'extend'  => 0, 
                    'author'  => $uid
                );
                
                if(1 > $linkeddata->add($data)) {
                    throw new HRequestException('添加兴趣与用户关联失败，请稍后再试'); 
                }
               
            }
        }
    }

    /**
     * 修改密码
     * @return [type] [description]
     */
    public function updateuserpwd()
    {
        $oldPwd     = HRequest::getParameter('oldpwd');
        $newPwd     = HRequest::getParameter('newpwd');
        $id         = HRequest::getParameter('id');
        $record     = $this->_model->getRecordById($id);
        if($record['password'] != md5($oldPwd)) {
            throw new HRequestException('旧密码错误');
        }
        $data   = array(
            'id' => $id,
            'password' => md5($newPwd)
        );
        if(1 > $this->_model->edit($data)) {
            throw new HRequestException('修改密码失败，请稍后再试');
        }
        HSession::destroy();
        HResponse::redirect(HResponse::url());
    }

    /**
     * 删除关联用户相关信息
     * @return [type] [description]
     */
    public function deluserlinkeddatainfo()
    {
        $model          = HRequest::getParameter('model');;
        $id             = HRequest::getParameter('id');
        if('history' == $model) {
            $linkeddata     = HClass::quickLoadModel($model);
            $record         = $linkeddata->getRecordById($id);
            $relId          = $record['author'];
        }else{
            $linkeddata     = HClass::quickLoadModel('linkeddata');
            $linkeddata->setRelItemModel('user', $model);    
            $record         = $linkeddata->getRecordById($id);
            $relId          = $record['rel_id'];
        }
        if(empty($record) || HSession::getAttribute('id', 'user') != $relId) {
            throw new HRequestException('该记录已经不存在，请稍后再试');
        }
        if(1 > $linkeddata->delete($id)) {
            throw new HRequestException('删除用户关联数据失败，请稍后再试');
        }

        HResponse::json(array('rs'=>true, 'id'=> $id));
    }

    /**
     * 清空关联用户相关信息
     * @return [type] [description]
     */
    public function emptyuserlinkeddatainfo()
    {
        $model          = HRequest::getParameter('model');
        $idStr          = HRequest::getParameter('idstr');
        $idStr          = empty($idStr) ? 0 : $idStr;
        $where          = '`id` in (' . $idStr . ')';
        if('history' == $model) {
            $linkeddata     = HClass::quickLoadModel($model);
        } else {
            $linkeddata     = HClass::quickLoadModel('linkeddata');
            $linkeddata->setRelItemModel('user', $model);
        }
        if(1 > $linkeddata->deleteByWhere($where)) {
            throw new HRequestException('清空关联用户相关信息失败');
        }

        HResponse::json(array('rs'=>true));
    }
}

?>
