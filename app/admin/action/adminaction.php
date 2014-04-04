<?php 

/**
 * @version			$Id$
 * @create 			2012-5-20 17:29:07 By xjiujiu
 * @package 		app.admin
 * @subpackage 		action
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminBaseAction');

/**
 * 模块动作类 
 * 
 * 有数据库相关操作或有增删改查操作模块的基类 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class AdminAction extends AdminBaseAction
{

    /**
     * 搜索方法 
     * 
     * @access public
     */
    public function search()
    {
        $this->_search($this->_combineWhere());

        $this->_render('list');
    }

    /**
     * 组合搜索条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return String 组合成的搜索条件
     */
    protected function _combineWhere()
    {
        $where          = array('1 = 1');
        if(1 < intval(HRequest::getParameter('type'))) {
            array_push($where, '`parent_id` = \'' . HRequest::getParameter('type') . '\'');
        }
        $keywords       = HRequest::getParameter('keywords');
        if(!$keywords || '关键字...' === $keywords) {
            return implode(' AND ', $where);
        }
        $keywordsWhere  = $this->_getSearchWhere($keywords);
        if($keywordsWhere) {
            array_push($where, $keywordsWhere);
        }

        if(!$where) {
            return null;
        }

        return implode(' AND ', $where);
    }

    /**
     * 主页动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function index()
    {
        $this->_search();
        $this->_render('list');
    }

    /**
     * 加载模块列表，内容使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $where 查找的条件
     */
    protected function _search($where = '1 = 1')
    {
        $this->_assignModelList(
            $where, 
            !HRequest::getParameter('perpage') ? 10 : intval(HRequest::getParameter('perpage'))
        );
        HResponse::setAttribute('show_fields', HPopoHelper::getShowFieldsAndCfg($this->_popo));
        HResponse::setAttribute('popo', $this->_popo);
        $this->_assignAllParentList();
        $this->_registerFormatMap();
        $this->_assignAllWebsite();
    }

    /**
     * 注册格式化表
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _registerFormatMap() 
    { 
        $this->_registerParentFormatMap(HResponse::getAttribute('parent_id_list'));
        $this->_registerAuthorFormatMap();
    }

    /**
     * 添加模块视图 
     * 
     * @desc
     * 
     * @access public
     */
    public function addview()
    {  
        $this->_addview();
        $this->_render($this->_popo->modelEnName . '/info');
    }

    /**
     * 添加视图的最小原子代码，内部使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @throws Exception 添加或是验证异常
     */
    protected function _addview()
    {
        $this->_assignAllParentList();
        $this->_assignAllWebsite();
        HResponse::setAttribute('popo', $this->_popo);
        HResponse::setAttribute('nextAction', 'add');
        HResponse::setAttribute('author', HSession::getAttribute('name', 'user'));
    }

    /**
     * 执行模块的添加 
     * 
     * @desc
     * 
     * @access public
     */
    public function add()
    {
        $this->_add();

        HResponse::succeed(
            '新' . $this->_popo->modelZhName . '添加成功！',
            HResponse::url($this->_popo->modelEnName)
        );
    }

    /**
     * 添加原子方法内部使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return HRequestException 请求异常
     */
    protected function _add()
    {
        $this->_setFieldsDefaultValue();
        $this->_verifyDataByPopoCfg();
        $this->_setAutoFillFields();
        $this->_uploadFile();
        $insertId  = $this->_model->add(HPopoHelper::getAddFieldsAndValues($this->_popo));
        if(false === $insertId) {
            throw new HRequestException(HResponse::lang('ADD_FAIL'));
        }

        return $insertId;
    }

    /**
     * 设置当前的排序号
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _setAutoFillFields()
    {
        //设置当前排序编号
        if(null === HRequest::getParameter('sort_num')) {
            return;
        }
        if(HRequest::getParameter('sort_num')) {
            HVerify::isNumber(HRequest::getParameter('sort_num'), '排序编号');
            return;
        }
        HRequest::setParameter('sort_num', $_SERVER['REQUEST_TIME']);
    }
 
    /**
     * 编辑动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function editview()
    {
        $this->_editview();
        $this->_render($this->_popo->modelEnName . '/info');
    }

    /**
     * 编辑视图的原子方法，内部使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @throws HVerifyException | HRequestException 
     */
    protected function _editview()
    {
        HVerify::isRecordId(HRequest::getParameter('id'));
        $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(HVerify::isEmpty($record)) {
            throw new HVerifyException(HResponse::lang('NO_THIS_RECORD', false));
        }
        $this->_assignAllParentList();
        $this->_assignAuthorInfo($record['author']);
        $this->_assignPreNextRecord($record);
        $this->_assignAllWebsite();
        
        HResponse::setAttribute('record', $record);
        HResponse::setAttribute('nextAction', 'edit');
        HResponse::setAttribute('popo', $this->_popo);
    }

    /**
     * 加载上一条跟下一条信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignPreNextRecord($record)
    {
        HResponse::setAttribute(
            'preRecord',
            $this->_model->getPreRecord($record['id'])
        );
        HResponse::setAttribute('nextRecord',
            $this->_model->getNextRecord($record['id'])
        );
    }

    /**
     * 加载标签字典
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignTags()
    {
        if(!HResponse::getAttribute('record')) {
            return;
        }
        $record         = HResponse::getAttribute('record');
        $relationship   = HClass::quickLoadModel('relationship');
        $relList        = $relationship->getAllRows('`rel_id` = ' . $record['id']);
        if(!$relList) {
            return;
        }
        $tag            = HClass::quickLoadModel('tags');
        $tagList        = $tag->getAllRows(HSqlHelper::whereInByListMap('id', 'item_id', $relList)); 
        foreach($tagList as $tag) {
            $record['tag_names']   .= ',' . $tag['name']; 
            $record['tag_ids']     .= ',' . $tag['id']; 
        }
        $record['tag_names']{0}     = ' ';
        $record['tag_ids']{0}       = ' ';
        HResponse::setAttribute('record', $record);
    }

    /**
     * 添加标签外键关系
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _addTagRelationship($relId)
    {
        if(!HRequest::getParameter('tag_ids')) {
            return;
        }
        $tagIds     = array_filter(explode(',', HRequest::getParameter('tag_ids')));
        if(!$tagIds) {
            return;
        }
        $data   = array();
        foreach($tagIds as $itemId) {
            $data[]     = array(
                $itemId, $relId, 
                HResponse::getAttribute('HONGJUZI_MODEL'),
                HSession::getAttribute('id', 'user')
            );
        }
        $relationship   = HClass::quickLoadModel('relationship');
        if(1 > $relationship->add($data, array('item_id', 'rel_id', 'model', 'author'))) {
            throw new HRequestException('标签关联添加失败！');
        }
    }

    /**
     * 加载当前信息作者 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $author 当前作者ID
     */
    protected function _assignAuthorInfo($author)
    {
        if(empty($author)) { return ''; }
        if(HSession::getAttribute('id', 'user') == $author) {
            HResponse::setAttribute('author', HSession::getAttribute('name', 'user'));
            return;
        }
        $user   = HClass::quickLoadModel('user');
        HResponse::setAttribute('author', $user->getRecordById($author));
    }

    /**
     * 编辑提示动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function edit()
    {
        $this->_edit();
        HResponse::succeed(
            $this->_popo->modelZhName . '信息更新成功！', 
            HResponse::url($this->_popo->modelEnName)
        );
    }

    /**
     * 编辑的原子方法
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @throws HVerifyException | HRequestException
     */
    protected function _edit()
    {
        $this->_setFieldsDefaultValue();
        $this->_verifyDataByPopoCfg();
        $this->_setAutoFillFields();
        $record         = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(HVerify::isEmpty($record)) {
            throw new HVerifyException(HResponse::lang('NO_THIS_RECORD', false));
        }
        $this->_uploadFile();
        HRequest::setParameter('author', HSession::getAttribute('id', 'user'));
        if(false === $this->_model->edit(HPopoHelper::getUpdateFieldsAndValues($this->_popo))) {
            throw new HRequestException(HResponse::lang('UPDATE_FAIL'), false);
        }
    }

    /**
     * 设置一些请求的字段值
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _setFieldsDefaultValue()
    {
        HRequest::setParameter('edit_time', $_SERVER['REQUEST_TIME']);
        HRequest::setParameter('author', HSession::getAttribute('id', 'user'));
    }

    /**
     * 删除动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function delete()
    {
        $recordIds  = HRequest::getParameter('id');
        if(!is_array($recordIds)) {
            $recordIds  = array($recordIds);
        }
        $this->_delete($recordIds);
        HResponse::succeed(
            '删除成功！', 
            HResponse::url($this->_popo->modelEnName, '', 'admin')
        );
    }

    /**
     * 删除信息内部使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  Array $ids 需要删除的ID
     * @throws HRequestException 请求异常 
     */
    protected function _delete($recordIds)
    {
        foreach($recordIds as $recordId) {
            HVerify::isRecordId($recordId);
            $record     = $this->_model->getRecordById($recordId);
            if(empty($record)) {
                continue;
            }
            $this->_deleteFiles($record);
            if(!empty($record) && false === $this->_model->delete($recordId)) {
                throw new HRequestException(HResponse::lang('DELETE_FAIL', false));
            }
        }
    }

    /**
     * 快捷操作 
     * 
     * @desc
     * 
     * @access public
     */
    public function quick()
    {
        HVerify::isEmpty(HRequest::getParameter('operation'), HResponse::lang('OPERATION_CAN_NOT_EMPTY', false));
        HVerify::isEmpty(HRequest::getParameter('id'), HResponse::lang('YOU_NOT_SELECT_ITEMS', false));
        $recordIds          = HRequest::getParameter('id');
        switch(HRequest::getParameter('operation')) {
            case 'delete': $this->delete(); return;
            default: throw new HVerifyException('操作还没有开放使用～');
        }
        if(false === $this->_model->moreUpdate($recordIds, $opCfg)) {
            throw new HRequestException(HResponse::lang('UPDATE_FAIL', false));
        }
        HResponse::succeed(HResponse::lang('UPDATE_SUCCESS', false), $this->_getReferenceUrl(1));
    }

    /**
     * 删除快捷操作里的文件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  array $list 记录的列表
     * @exception HIOException 文件操作异常
     */
    protected function _deleteFileByList($list, $field)
    {
        $fieldCfg     = $this->_popo->getFieldCfg($field);
        foreach($list as $record) {
            $this->_deleteUploadFiles($record[$field], $fieldCfg);
        }
    }

    /**
     * 得到当前模块的所有父类 
     * 
     * 根据当前popo类里的parentTable来判断是否有父类 
     * 
     * @access protected
     */
    protected function _assignAllParentList()
    {
        HResponse::setAttribute(
            'parent_id_list', 
            $this->_getRelationModelList(
                $this->_popo->get('parent'),
                'parent_id',
                '*'
            )
        );
    }

    /**
     * 得到当前模块的所有父类 
     * 
     * 根据当前popo类里的parentTable来判断是否有父类 
     * 
     * @access protected
     * @param  Array $data 需要处理的数据
     */
    protected function _registerParentFormatMap($data = null)
    {
        if((null !== $data && !$data) || !$this->_popo->getFieldAttribute('parent_id', 'is_show')) { return ; }
        $data   = null === $data ? $this->_getRelationModelList(
            $this->_popo->get('parent'),
            'parent_id',
            HResponse::getAttribute('list')
        ) : $data;
        //注册用户名格式化
        HResponse::registerFormatMap(
            'parent_id',
            'name',
            HArray::turnItemValueAsKey($data, 'id')
        );
    }
    
    /**
     * 加载关联的作者信息列表
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _registerAuthorFormatMap()
    {
        if(!$this->_popo->getFieldAttribute('author', 'is_show')) { return ; }
        //注册用户名格式化
        HResponse::registerFormatMap(
            'author',
            'name',
            HArray::turnItemValueAsKey(
                $this->_getRelationModelList(
                    'user',
                    'author',
                    HResponse::getAttribute('list')
                ), 
                'id'
            )
        );
    }

    /**
     * 得到当前模块的所有父类 
     * 
     * 根据当前popo类里的parentTable来判断是否有父类 
     * 
     * @access protected
     */
    protected function _assignCategoryRootNodes($category = null)
    {
        if(null == $category) {
            $category   = HClass::quickLoadModel('category');
        }
        HResponse::setAttribute('parentName', $category->getPopo()->get('parent'));
        HResponse::setAttribute(
            'parent_id_list', 
            $category->getAllRows('`parent_id` = 0 OR `parent_id` IS NULL')
        );
    }

    /**
     * 检测当前的名称是否被使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @throws HVerifyException 验证异常 
     */
    public function ahasname()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('name'));
        $where      = '`name` = \'' . HRequest::getParameter('name') . '\'';
        if(HRequest::getParameter('id')) {
            $where  .=  ' AND `id` <> ' . HRequest::getParameter('id');
        }
        if(null != $this->_model->getRecordByWhere($where)) {
            throw new HVerifyException('已经有相同的记录名称！');
        }
        HResponse::json(array('rs' => true));
    }

    /**
     * 加载父级的信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $parentId 当前所属的父类ID
     */
    protected function _assignParentInfo($parentId)
    {
        if($this->_popo->modelEnName == $this->_popo->get('parent')) {
            HResponse::setAttribute('parentInfo', $this->_model->getRecordById($parentId));
            return;
        }
        $model  = HClass::quickLoadModel($this->_popo->get('parent'));
        HResponse::setAttribute('parentInfo', $model->getRecordById($parentId));
    }


    /**
     * 快捷更新操作
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aupdate()
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('id'), '信息ID');
        HVerify::isEmpty(HRequest::getParameter('field'), '更新字段');
        if(!$this->_popo->getFieldCfg(HRequest::getParameter('field'))) {
            throw new HVerifyException('字段不存在～');
        }
        $record = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(empty($record)) {
            throw new HVerifyException(HResponse::lang('INFORMATION_HAS_DELETE', false));
        }
        $data   = array(
            'id' => HRequest::getParameter('id'),
            HRequest::getParameter('field') => HRequest::getParameter('data')
        );
        if(1 > $this->_model->edit($data)) {
            if(!HRequest::getParameter('data')) {
                throw new HRequestException('更新失败，请确认这项数据是否为不能为空！');
            }
        }
        HResponse::json(array('rs' => true, 'message' => '更新成功:)'));
    }

    

    /**
     * 自动保存
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @throws Exceptions 
     */
    public function autosave()
    {
        try {
            HVerify::isRecordId(HRequest::getParameter('id'));
            $this->_edit();
            HResponse::json(array('rs' => true, 'id' => ''));
        } catch(HVerifyException $ex) {
            HRequest::setParameter('status', 2);
            HResponse::json(array('rs' => true, 'id' => $this->_add()));
        } catch(HRequestException $ex) {
            HResponse::json(array('rs' => false, 'info' => '自动保存失败，请联系管理员！'));
        }
    }

    /**
     * 加载所有的网站
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignAllWebsite()
    {
        $website    = HClass::quickLoadModel('website');
        HResponse::setAttribute('websiteList', $website->getAllRows());
    }

}

?>
