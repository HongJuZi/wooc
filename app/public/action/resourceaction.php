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
HClass::import('app.oauth.action.auseraction');

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
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function beforeAction() 
    {
        AUserAction::isLogined();
    }

    /**
     * 构造函数 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo        = new ResourcePopo();
        $this->_model       = new ResourceModel($this->_popo);
    }

    /**
     * 上传文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function auploadfile()
    {
        $extension  = $this->_verifyUpload(10, 'file');
        $fileInfo   = $this->_aupload($extension, false);

        HResponse::json(array(
            'rs' => true,
            'data' => array(
                'id' => $fileInfo['id'],
                'name' => $fileInfo['name'],
                'src' => $fileInfo['path'],
                'extension' => $extension
            )
        ));
    }

    /**
     * 上传图片
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function auploadimage()
    {
        HRequest::setParameter('is_ajax', true);
        $extension  = $this->_verifyUpload(0.5, 'image');
        $fileInfo   = $this->_aupload($extension, true);
        $linked     = $this->_addResourceLinkedData($fileInfo);

        HResponse::json(array(
            'rs'    => true,
            'data'  => array(
                'id'    => $fileInfo['id'],
                'name'  => $fileInfo['name'],
                'src'   => $fileInfo['path'],
                'small' => HFile::getImageZoomTypePath($fileInfo['path'], 'small'),
                'extension' => $extension,
                'linked' => $linked
            )
        ));
    }

    /**
     * 上传视频
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function auploadvideo()
    {
        HRequest::setParameter('is_ajax', true);
        $extension  = $this->_verifyUpload(50, 'video');
        $fileInfo   = $this->_aupload($extension, false);
        $linked     = $this->_addResourceLinkedData($fileInfo);

        HResponse::json(array(
            'rs' => true,
            'data' => array(
                'id' => $fileInfo['id'],
                'name' => $fileInfo['name'],
                'src' => $fileInfo['path'],
                'extension' => $extension,
                'linked' => $linked
            )
        ));
    }

    /**
     * 上传音频
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function auploadaudio()
    {
        HRequest::setParameter('is_ajax', true);
        $extension  = $this->_verifyUpload(10, 'audio');
        $fileInfo   = $this->_aupload($extension, false);
        $linked     = $this->_addResourceLinkedData($fileInfo);

        HResponse::json(array(
            'rs' => true,
            'data' => array(
                'id' => $fileInfo['id'],
                'name' => $fileInfo['name'],
                'src' => $fileInfo['path'],
                'extension' => $extension,
                'linked' => $linked
            )
        ));
    }

    /**
     * @var private static $_extMap    扩展名映射
     */
    private static $_extMap    = array(
        'file' => array('.apk', '.doc', '.ipa', '.ppt', '.rar', '.pdf', '.xls', '.xlsx'),
        'image' => array('.jpg', '.png', '.gif', '.bmp', '.jpeg'),
        'video' => array('.mp4','.avi','.3gp','.rmvb','.wmv','.mkv','.mpg','.mov','.vob','.flv', '.asf'),
        'audio' => array('.mp3','.wma','.wav', '.ape', '.ogg', '.flac')
    );
    
    /**
     * 内部使用的上传接口
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @param  $extension 类型
     * @param  $isZoom 是否压缩
     * @access private
     */
    private function _aupload($extension, $isZoom = false)
    {
        $fhash      = sha1_file($_FILES['path']['tmp_name']);
        $fileInfo   = $this->_model->getRecordByWhere('`fhash` = \'' . $fhash . '\'');
        if(!$fileInfo) {
            $this->_uploadFile();
            $fileInfo   = $this->_addNewFile($extension, $fhash);
            if(true === $isZoom) {
                $popo   = HClass::quickLoadPopo(HRequest::getParameter('model'));
                $cfg    = $popo->getFieldCfg(HRequest::getParameter('field'));
                $cfg    = array_merge($cfg, $this->_popo->getFieldCfg('path'));
                if($cfg['zoom']) {
                    $this->_zoomImage($fileInfo['path'], $cfg['zoom']);
                }
            }
        }

        return $fileInfo;
    }

    /**
     * 添加文件资源关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $file 文件信息
     * @return array 关联数据
     */
    private function _addResourceLinkedData($file)
    {
        if(HRequest::getParameter('nolinked')) {
            return;
        }
        if(!HRequest::getParameter('linked') || !HRequest::getParameter('model')) {
            return '格式不符合！关联添加数据格式：{linked: hash, model: name}，请确认！';
        }
        $linkedData     = HClass::quickLoadModel('linkeddata');
        $linkedData->setRelItemModel(HRequest::getParameter('model'), 'resource');
        $record         = $linkedData->getRecordByWhere(
            '`rel_id` = \'' . HRequest::getParameter('linked') . '\' AND `item_id` = ' . $file['id']
        );
        if($record) {
            return $record;
        }
        $data           = array(
            'rel_id' => HRequest::getParameter('linked'),
            'item_id' => $file['id'],
            'author' => HSession::getAttribute('id', 'user'),
        );
        $id             = $linkedData->add($data);
        if(1 > $id) {
            throw new HRequestException('添加文件关联数据失败，请联系管理员！');
        }
        $data['id']     = $id;

        return $data;
    }

    /**
     * 添加新文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $type 类型
     * @param  $fhash 校验码
     * @return 数据
     */
    private function _addNewFile($type, $fhash)
    {
        $fileInfo   = array(
            'name' => $_FILES['path']['name'],
            'type' => $type,
            'path' => HRequest::getParameter('path'),
            'fhash' => $fhash,
            'author' => HSession::getAttribute('id', 'user')
        );
        $fileInfo['id']      = $this->_model->add($fileInfo);
        if(1 > $fileInfo['id']) {
            throw new HRequestException('添加资源文件失败！');
        }

        return $fileInfo;
    }

    /**
     * 验证上传
     *
     * @access private
     */
    private function _verifyUpload($size, $type)
    {
        if(empty($_FILES)) {
            throw new HVerifyException('文件不能为空！');
        }
        if($_FILES['path']['size'] > ($size * 1000 * 1000)) {
            throw new HVerifyException('上传文件限制大小为');
        }
        $extension  = HFile::getExtension($_FILES['path']['name']);
        if('*' === $type) {
            return $extension;
        }
        if(!isset(self::$_extMap[$type])) {
            throw new HVerifyException('类型不存在，请确认！');
        }
        if(!in_array($extension, self::$_extMap[$type])) {
            throw new HVerifyException('文件类型不支持！');
        }

        return $extension;
    }

    /**
     * 异步下载
     */
    public function adownload()
    {
        HVerify::isAjax();
        $url        = urldecode(HRequest::getParameter('url'));
        HVerify::isEmpty($url, '下载地址');
        $fhash      = md5($url);
        $record     = $this->_model->getRecordByWhere('`fhash` = \'' . $fhash . '\'');
        if($record) {
            $name   = $record['name'];
            $src    = $record['path'];
            $id     = $record['id'];
        }else{
            $pathInfo   =  pathinfo($url);
            HClass::import('hongjuzi.filesystem.hdir');
            $path   = 'static/uploadfiles/resource/' . date('Y/m/d', $_SERVER['REQUEST_TIME']) . '/';
            HDir::create(ROOT_DIR . DS . $path); 
            $filePath   = $path . HRequest::download($url, ROOT_DIR . $path, '', 1);
            $name       = $pathInfo['basename'];
            $src        = $filePath;
            $data       = array(
                'path'      => $filePath,
                'name'      => $pathInfo['basename'],
                'type'      => $pathInfo['extension'],
                'fhash'     => $fhash,
                'author'    => HSession::getAttribute('id', 'user')
            );
            $id          = $this->_model->add($data);
            if(1 > $id) {
                throw new HRequestException('音乐资源添加失败');
            }
        }

        HResponse::json(array(
            'rs'    => true, 
            'data' => array(
                'name'  => $name,
                'src'   => $src,
                'id'   => $id
            )
        ));
    }

    /**
     * 异步删除资源
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function adelete()
    {
        HVerify::isAjax();
        AuserAction::isLogined();
        HVerify::isRecordId(HRequest::getParameter('id'), '图片编号');
        HVerify::isEmpty(HRequest::getParameter('rel_model'), '关联模块');
        $linkedData     = HClass::quickLoadModel('linkeddata');
        $record         = $linkedData->setRelItemModel(HRequest::getParameter('rel_model'), 'resource')
            ->getRecordById(HRequest::getParameter('id'));
        if(!$record) {
            throw new HVerifyException('请确认关联信息是否存在～');
        }
        if(HSession::getAttribute('id', 'user') != $record['author']) {
            throw new HVerifyException('你没有操作此文件的权限！');
        }
        $res            = $this->_model->getRecordById($record['item_id']);
        if(!$res) {
            throw new HVerifyException('请确认图片是否存在～');
        }
        $totalUse       = intval($res['total_use']) - 1;
        $data           = array(
            'id' => $record['item_id'],
            'total_use' => $totalUse
        );
        if(1 > $this->_model->edit($data)) {
            throw new HRequestException('更新资源使用数量失败！');
        }
        if(1 > $linkedData->delete(HRequest::getParameter('id'))) {
            throw new HRequestException('删除关联信息失败， 请确认～');
        }
        HResponse::json(array('rs' => true));
    }

}

?>
