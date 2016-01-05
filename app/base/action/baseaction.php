<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

/**
 * 应用的最上层基础类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.base.action
 * @since 1.0.0
 */
class BaseAction extends HAction
{

    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        if(!file_exists(ROOT_DIR . '/config/install.lock')) {
            HResponse::info('Wooc 程序还没有安装，请先安装！', HResponse::url('install'));
        }
    }

    /**
     * 加载语言类型列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLangList()
    {
        $langList   = $this->_getLangList();
        HResponse::setAttribute('lang_id_list', $langList);
        HResponse::setAttribute('lang_id_map', HArray::turnItemValueAsKey($langList, 'id'));
    }

    /**
     * 得到语言列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _getLangList($where = '1 = 1')
    {
        $lang   = HClass::quickLoadModel('lang');

        return $lang->getAllRows($where);
    }

    /**
     * 转换语言
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _switchLang()
    {
        if(!HSession::getAttribute('id', 'lang')) {
            $lang   = HClass::quickLoadModel('lang');
            $record = $lang->getRecordByWhere('`is_default` = 2');
            HSession::setAttributeByDomain($record, 'lang');
            return;
        }
        $id   = HRequest::getParameter('lang');
        if(!$id) {
            return;
        }
        if($id == HSession::getAttribute('id', 'lang')) {
            return;
        }
        $this->_switchLangById($id);
    }

    /**
     * 通过id切换指定语言
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $id 语言编号
     */
    protected function _switchLangById($id)
    {
        $lang   = HClass::quickLoadModel('lang');
        $record = $lang->getRecordById($id);
        if(!$record) {
            throw new HVerifyException('语言不支持，请确认！');
        }
        HSession::setAttributeByDomain($record, 'lang');
        //加载语言字典
        HTranslate::loadDictByApp(HResponse::getAttribute('HONGJUZI_APP'), $record['identifier']);
    }

    /**
     * 得到网站信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _getWebSite($where)
    {
        $information    = HClass::quickLoadModel('information');

        return $information->getRecordByWhere($where);
    }

    /**
     * 加载信息作者信息 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignAuthorInfo()
    {
        $record = HResponse::getAttribute('record');
        $user   = HClass::quickLoadModel('user');
        HResponse::setAttribute('author', $user->getRecordById($record['author']));
    }

    /**
     * 加载相册
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    protected function _assignAlbum()
    {
        $record     = HResponse::getAttribute('record');
        $linkedData = HClass::quickLoadModel('linkeddata');
        $linkList   = $linkedData->setRelItemModel($this->_popo->modelEnName, 'resource')
            ->getAllRows('`rel_id` = \'' . $record['hash'] . '\'');
        if(empty($linkList)) { return ; } 
        $resource   = HClass::quickLoadModel('resource');
        $resourceList   = $resource->getAllRows(HSqlHelper::whereInByListMap('id', 'item_id', $linkList));
        HResponse::setAttribute('album', $linkList);
        HResponse::setAttribute('resourceMap', HArray::turnItemValueAsKey($resourceList, 'id'));
    }

}


?>
