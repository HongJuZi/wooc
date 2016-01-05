<?php

/**
 * @version			$Id$
 * @create 			2013-11-04 22:11:10 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.resourcepopo, app.admin.action.AdminAction, model.resourcemodel');

/**
 * 文件资源的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class ResourceAction extends AdminAction
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
            $field      = HRequest::getParameter('field');
            HVerify::isEmpty($field, '字段');
            HVerify::isEmpty(HRequest::getParameter('model'), '模块');
            HVerify::isEmpty(HRequest::getParameter($field), '哈希');
            if($_POST['token'] !== (md5('unique_salt' . $_POST['timestamp']))) {
                throw new HVerifyException('请求过期，请刷新页面！！');
            }
            $popo           = HClass::loadPopoClass(HRequest::getParameter('model'));
            $fieldCfg       = $popo->getFieldCfg($field);
            if(null === $fieldCfg) {
                throw new HVerifyException('信息属性不存，请确认！');
            }
            $type           = HFile::getExtension($_FILES['path']['name']);
            if(!in_array($type, $fieldCfg['type'])) {
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
            //添加关联哈希
            HRequest::setParameter('hash', HRequest::getParameter($field));
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

}

?>
