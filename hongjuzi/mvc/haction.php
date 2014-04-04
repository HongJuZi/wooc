<?php 

/**
 * @version			$Id$
 * @create 			2012-4-7 17:29:25 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die();

/**
 * 框架的动作基类 
 * 
 * 为用户自定义的动作类作一个公用部分的提取 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.core
 * @since 			1.0.0
 */
class HAction extends HObject
{

    /**
     * @var HModel $_model 对应的模块对象
     */
    protected $_model;

    /**
     * @var HPopo $_popo 当前模块的配置对象
     */
    protected $_popo;

    /**
     * 控制器前驱方法
     * 
     * 在调用目标方法之前执行，用于做认证或是初始化时用
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function beforeAction() { }

    /**
     * 控制器后驱方法
     * 
     * 在调用完目标方法后执行，可以用于记录日志，触发其它的任务事件等
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function afterAction() { }

    /**
     * 验证用户搜索内容 
     * 
     * @desc
     * 
     * @access protected
     * @return void
     * @exception HHVerifyException 验证异常 
     */
    protected function _verifySearch()
    {
        HVerify::isEmptyNotZero(HRequest::getParameter('keywords'), '搜索关键字不能为空！');
    }

    /**
     * 上传模块标志图 
     * 
     * @desc
     * 
     * @access protected
     * @param  HPopo 需要上传的配置对象
     * @return void
     * @exception HRequestException 
     */
    protected function _uploadFile($popo = '')
    {
        $popo   = empty($popo) ? $this->_popo : $popo;
        HClass::import('hongjuzi.net.HUploader');
        foreach(HPopoHelper::getFileFields($popo) as $field => $uploadFileCfg) {
            if(!HRequest::getFiles($field)) {
                continue;
            }
            $uploadFile      = HRequest::getFiles($field);
            if(empty($uploadFile['name'])) {
                continue;
            }
            if($uploadFile['error']) {
                throw new HRequestException('上传出错，请确认是否磁盘空间不足，或上传的文件已经不存在！');
            }
            $hUploader          = new HUploader(
                HObject::GC('RES_DIR') . DS . $this->_popo->modelEnName,
                $uploadFileCfg['size'],
                $uploadFileCfg['type'],
                ROOT_DIR
            );
            $uploadedInfo       = $hUploader->uploader($uploadFile, $uploadFileCfg['isGenDateDir']);
            if(isset($uploadedInfo['error'])) {
                if(!empty($uploadedInfo['error'])) {
                    throw new HRequestException(($uploadedInfo['error']));
                }
            }
            if(!empty($uploadedInfo['path']) && isset($uploadFileCfg['zoom'])) {
                $this->_zoomImage($uploadedInfo['path'], $uploadFileCfg['zoom']);
            }
            $this->_deleteUploadFiles(HRequest::getParameter('old_' . $field), $uploadFileCfg);
            HRequest::setParameter($field, HString::DSToSlash($uploadedInfo['path']));
        }
    }

    /**
     * 缩放图片
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $src 源图
     * @param  Array $zoomCfg 缩放配置
     * @throws HRequestException 请求异常
     */
    protected function _zoomImage($src, $zoomCfg)
    {
        HClass::import('hongjuzi.image.HImageZoom');
        $hImageZoom     = new HImageZoom(ROOT_DIR . $src);
        foreach($zoomCfg as $type => $zoomSize) {
            try {
                $hImageZoom->zoom($zoomSize[0], $zoomSize[1], $type);
            } catch(HIOException $ex) {
                $this->_deleteUploadFiles($src, $uploadFileCfg);
                throw new HRequestException($ex->getMessage());
            }
        }
    }

    /**
     * 删除当前记录里使用到的文件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return void
     */
    protected function _deleteFiles($record, $popo = null)
    {
        $popo   = null == $popo ? $this->_popo : $popo;
        foreach(HPopoHelper::getFileFields($popo) as $field => $fieldCfg) {
            $this->_deleteUploadFiles($record[$field], $fieldCfg);
        }
    }

    /**
     * 删除上传的缩放文件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $path 当前上传的文件
     * @param  Array<String, String> $zoomCfg 缩放文件配置
     * @return void 
     * @exception HIOException 文件删除失败异常
     */
    protected function _deleteUploadFiles($path, $uploadFileCfg = '')
    {
        if(empty($path)) {
            return ;
        }
        if(isset($uploadFileCfg['zoom'])) {
            foreach($uploadFileCfg['zoom'] as $type => $zoomSize) {
                HFile::delete(HFile::getImageZoomTypePath($path, $type), ROOT_DIR);
            }
        }
        HFile::delete($path, ROOT_DIR);
    }

    /**
     * 得到当前的访问页位置 
     * 
     * @desc
     * 
     * @access protected
     * @param int $totalPages 总的页数
     * @return int 当前页码
     */
    protected function _getPageNumber($totalPages)
    {
        $page   = intval(HRequest::getparameter('page'));
        if($page < 1 || $page > $totalPages) {
            return 0;
        }

        return $page - 1;
    }

    /**
     * 生成分页部分的HTML代码 
     * 
     * @desc
     * 
     * @access protected
     * @param int $curPage 当前访问页
     * @param int $totalPages 总记录条数
     * @param string $paramName 分页的存储变量
     * @return string 
     */
    protected function _genPageHtml($curPage, $totalPages, $paramName = 'page')
    {
        HClass::import('hongjuzi.utils.HPage');
        $hPage      = new HPage(
            $curPage,
            $totalPages,
            $paramName,
            HObject::GC('PAGE_STYLE')
        );

        return $hPage->getPageHtml();
    }

    /**
     * 得到搜索执行的条件SQL部分 
     * 
     * @desc
     * 
     * @access protected
     * @param string $keywords 关键字
     * @return string 关键字条件
     */
    protected function _getSearchWhere($keywords)
    {
        if(true == preg_match('/^\/(\d+)$/i', $keywords, $matchs)) {
            return $this->_popo->primaryKey . '=' . $matchs[1];
        }

        return '`' . implode(
            '` LIKE \'%' . $keywords . '%\' OR `',
            HPopoHelper::getSearchFields($this->_popo)
        ) . '` LIKE \'%' . $keywords . '%\' OR 1 = 2';
    }

    /**
     * 载加模块列表到视图层 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $where 需要查找的条件，默认为空
     * @param  int $perpage 每页显示的条数, 默认为10
     */
    protected function _assignModelList($where = '', $perpage = 10)
    {
        $totalRows  = $this->_model->getTotalRecords($where);
        $totalPages = ceil($totalRows / $perpage);
        $page       = $this->_getPageNumber($totalPages);
        $list       = $this->_model->getListByWhere($where, $page, $perpage);
        $pageHtml   = $this->_genPageHtml($page + 1, $totalPages, 'page');
        HResponse::setAttribute('list', $list);
        HResponse::setAttribute('curPage', $page + 1);
        HResponse::setAttribute('perpage', $perpage);
        HResponse::setAttribute('pageHtml', $pageHtml);
        HResponse::setAttribute('totalRows', $totalRows);
        HResponse::setAttribute('totalPages', $totalPages);
    }

    /**
     * 加载关联模块列表
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $modelName 当前模块名称
     * @param  String $field 关联的字段名
     * @param  Array 需要加载的数据集合
     * @return Array 关联数据
     */
    protected function _getRelationModelList($modelName, $relField, $list)
    {
        if(empty($modelName) || empty($list)) {
            return;
        }
        $relModel = $modelName != $this->_popo->modelEnName ?  HClass::quickloadModel($modelName) : $this->_model;

        return '*' != $list ? $relModel->getAllRows(HSqlHelper::whereInByListMap($relModel->getPopo()->primaryKey, $relField, $list)) 
            : $relModel->getAllRows();
    }

    /**
     * 通过POPO配置来验证数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @throws VerifyException 验证异常
     */
    protected function _verifyDataByPopoCfg()
    {
        $fields     = $this->_popo->get('fields');
        foreach($fields as $field => $cfg) {
            foreach($cfg['verify'] as $type => $value) {
                $verifyMethod   = '_verify' . ucfirst($type);
                $this->$verifyMethod($value, $field, $cfg['name']);
            }
        }
    }

    /**
     * 验证是不是不能为空
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  配置值 $value
     * @param  不嬘字段 $field
     * @param  字段名称 $name
     * @throws VerifyException 验证异常
     */
    protected function _verifyNull($value, $field, $name)
    {
        if(!HVerify::isEmptyNotZero(HRequest::getParameter($field))) {
            return;
        }
        //如果也没有配置默认值
        if(!HVerify::isEmptyNotZero($this->_popo->getFieldAttribute($field, 'default'))) {
            HRequest::setParameter($field, $this->_popo->getFieldAttribute($field, 'default'));
            return;
        }
        throw new HVerifyException($name . '不能为空！');
    }

    /**
     * 验证长度是否对
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  配置值 $value
     * @param  不嬘字段 $field
     * @param  字段名称 $name
     * @throws VerifyException 验证异常
     */
    protected function _verifyLen($value, $field, $name)
    {
        HVerify::isStrLen(HRequest::getParameter($field), $name, 0, $value);
    }

    /**
     * 验证是否为有效的数字
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  配置值 $value
     * @param  不嬘字段 $field
     * @param  字段名称 $name
     * @throws VerifyException 验证异常
     */
    protected function _verifyNumeric($value, $field, $name)
    {
        HVerify::isNumber(HRequest::getParameter($field), $name);
    }

    /**
     * 检测当前值是否在可选项里
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  配置值 $value
     * @param  不嬘字段 $field
     * @param  字段名称 $name
     * @throws VerifyException 验证异常
     */
    protected function _verifyOptions($value, $field, $name)
    {
        if(!in_array(HRequest::getParameter($field), $value)) {
            throw new HVerifyException($name . '值不正确，请确认！');
        }
    }

    /**
     * 渲染方法 
     * 
     * @desc
     * 
     * @access protected
     * @param string $file 模板路径
     */
    protected function _render($file)
    {
        $file   = HResponse::getAttribute('HONGJUZI_APP')
            . DS . HObject::GC('CUR_THEME') . DS . $file . '.tpl';
        HResponse::setAttribute('RENDER_TPL', $file);
        HResponse::setAttribute('popo', $this->_popo);
        HClass::import('hongjuzi.html.hhtml');

        require_once(HResponse::path('tpl') . DS . $file);
    }
    
    /**
     * 得到当前的语言类型
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return String 当前的语言类型
     */
    protected function _getCurLang()
    {
        return !HSession::getAttribute('CUR_LANG') ? HObject::GC('CUR_LANG') : HSession::getAttribute('CUR_LANG');
    }

    /**
     * 得到之前访问过的应用名称
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $deep = 1 访问深度，默认1
     * @return String 访问历史的应用
     */
    protected function _getReferenceApp($deep = 1)
    {
        return $this->_getReferenceInfo($deep, 'APP');
    }

    /**
     * 得到历史访问的模块
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $deep 深度，默认为1
     * @return String 得到对应深度的模块信息
     */
    protected function _getReferenceModel($deep = 1)
    {
        return $this->_getReferenceInfo($deep, 'MODEL');
    }

    /**
     * 得到历史访问的动作信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $deep 历史深度，默认为 1
     * @return String 对应深度的动作信息
     */
    protected function _getReferenceAction($deep = 1)
    {
        return $this->_getReferenceInfo($deep, 'ACTION');
    }

    /**
     * 得到历史访问的链接信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $deep 历史深度，默认为 1
     * @return String 对应深度的链接信息
     */
    protected function _getReferenceUrl($deep = 1)
    {
        return $this->_getReferenceInfo($deep, 'URL');
    }

    /**
     * 得到访问历史信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $deep 深度 1
     * @param  String $type 历史信息类型，默认为'APP'
     * @return String 访问信息
     */
    protected function _getReferenceInfo($deep = 1, $type = 'APP')
    {
        $referenceList  = HSession::getAttribute('referenceList');
        if(isset($referenceList[$deep])) {
            return $referenceList[$deep][$type];
        }

        return $referenceList[0][$type];
    }

}

?>
