<?php

/**
 * @version			$Id$
 * @create 			2013-11-04 22:11:10 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.resourcepopo, app.public.action.PublicAction, app.oauth.action.auseraction, model.resourcemodel');

/**
 * 文件资源的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class ResourceAction extends PublicAction
{

    /**
     * 认证用户登录
     * 
     * @desc
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function beforeAction() 
    {
        AUserAction::isLogined();
        parent::beforeAction();
    }

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo        = new ResourcePopo();
        $this->_model       = new ResourceModel($this->_popo);
    }

    /**
     * 异步上传
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aupload()
    {
        try {
            if(empty($_FILES)) {
                throw new HVerifyException('文件不能为空！');
            }
            HVerify::isEmpty(HRequest::getParameter('hash'), '哈希');
            $fieldCfg       = $this->_popo->getFieldCfg('path');
            if(null === $fieldCfg) {
                throw new HVerifyException('信息属性不存，请确认！');
            }
            $type           = HFile::getExtension($_FILES['path']['name']);
            if('*' !== $fieldCfg['type'] && !in_array($type, $fieldCfg['type'])) {
                throw new HVerifyException('文件类型不支持！');
            }
            HRequest::setParameter('author', HSession::getAttribute('id', 'user'));
            $fhash              = sha1_file($_FILES['path']['tmp_name']);
            $resInfo            = $this->_model->getRecordByWhere('`fhash` = \'' . $fhash . '\'');
            if(!$resInfo) {
                $pathCfg            = $this->_popo->getFieldCfg('path');
                $pathCfg['size']    = $fieldCfg['size'];
                $pathCfg['zoom']    = $fieldCfg['zoom'];
                $this->_popo->setFieldCfg('path', $pathCfg);
                $this->_uploadFile();
                //添加文件哈希
                HRequest::setParameter('fhash', $fhash);
                HRequest::setParameter('type', $type);
                HRequest::setParameter('name', $_FILES['path']['name']);
                HRequest::setParameter('description', HRequest::getParameter('name'));
                $resId              = $this->_model->add(HPopoHelper::getAddFieldsAndValues($this->_popo));
                if(1 > $resId) {
                    throw new HRequestException('添加资源文件失败！');
                }
                $src    = HRequest::getParameter('path');
            } else {
                $resId  = $resInfo['id'];
                $src    = $resInfo['path'];
                $this->_zoomImage($resInfo['path'], $fieldCfg['zoom']);
                HRequest::setParameter('name', $resInfo['name']);
                HRequest::setParameter('description', $resInfo['name']);
            }
            $ldId       = $this->_addLinkedData($resId);
            HResponse::json(array(
                'rs' => true,
                'name' => HRequest::getParameter('name'),
                'id' => $ldId,
                'src' => $src,
                'small' => HFile::getImageZoomTypePath($src, 'small')
            ));
        } catch(HVerifyException $ex) {
            HResponse::json(array('rs' => false, 'message' => $ex->getMessage()));
        } catch(HRequestException $ex) {
            HResponse::json(array('rs' => false, 'message' => $ex->getMessage()));
        } catch(Exception $ex) {
            HLog::write($ex->getMessage(), HLog::$L_ERROR);
            HResponse::json(array('rs' => false, 'message' => '服务器繁忙，请您稍后再试！'));
        }
    }

    /**
     * 添加关联数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $redId 新添加的文件id
     * @return int 当前新加关联资源的ID
     */
    private function _addLinkedData($resId)
    {
        HRequest::setParameter('res_id', $resId);
        HRequest::setParameter('parent_id', HSession::getAttribute('id', 'user'));
        $linkedData     = HClass::quickLoadModel('linkeddata');

        return $linkedData->add(HPopoHelper::getAddFieldsAndValues($linkedData->getPopo()));
    }

    /**
     * 异步删除资源
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function adelete()
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('id'), '图片编号');
        $linkedData     = HClass::quickLoadModel('linkeddata');
        if(1 > $linkedData->delete(HRequest::getParameter('id'))) {
            throw new HRequestException('请确认图片是否存在～');
        }
        HResponse::json(array('rs' => true));
    }

    /**
     * 修改资源所在的文件夹
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function achgfolder()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('id'), '编号');
        HVerify::isEmpty(HRequest::getParameter('folder'), '文件夹');
        $linkedData     = HClass::quickLoadModel('linkeddata');
        $record         = $linkedData->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('文件已经被删除，请确认！');
        }
        $data   = array('id' => HRequest::getParameter('id'), 'folder' => HRequest::getParameter('folder'));
        if(1 > $linkedData->edit($data)) {
            throw new HRequestException('修改失败，请联系管理员～');
        }
        HResponse::json(array('rs' => true));
    }

}

?>
