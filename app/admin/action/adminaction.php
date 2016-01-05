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
HClass::import('app.base.action.AdministratorAction');

/**
 * 模块动作类 
 * 
 * 有数据库相关操作或有增删改查操作模块的基类 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class AdminAction extends AdministratorAction
{

    /**
     * @var protected $_linkedData 关联操作对象
     */
    protected $_linkedData;

    /**
     * @var protected $_category 综合分类对象
     */
    protected $_category;
    
    /**
     * @var protected $_modelCfg 当前模块配置对象
     */
    protected $_modelCfg;

    /**
     * @var protected $_listMap 列表映射
     */
    protected $_listMap;

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_listMap     = array();
        $this->_linkedData  = HClass::quickLoadModel('linkeddata');
        $this->_category    = HClass::quickLoadModel('category');
    }

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
        $where      = $this->_getDateWhere();
        if(1 < intval(HRequest::getParameter('type'))) {
            array_push($where, $this->_getParentWhere(HRequest::getParameter('type')));
        }
        if(HRequest::getParameter('lang_id')) {
            array_push($where, '`lang_id` = \'' . HRequest::getParameter('lang_id') . '\'');
        }
        $keyword    = HRequest::getParameter('keywords');
        if($keyword && '关键字...' !== $keyword) {
            array_push($where, $this->_getSearchWhere($keyword));
        }
        
        return !$where ? null : implode(' AND ', $where);
    }

    /**
     * 得到日期条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return 日期条件
     */
    protected function _getDateWhere()
    {
        $where  = array('1 = 1');
        if(HRequest::getParameter('start_date')) {
            array_push($where, '`create_time` >= \'' . HRequest::getParameter('start_date') . '\'');
        }
        if(HRequest::getParameter('end_date')) {
            array_push($where, '`create_time` < \'' . HRequest::getParameter('end_date') . '\'');
        }

        return $where;
    }

    /**
     * 得到上级条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $id 编号
     * @return 上层条件
     */
    protected function _getParentWhere($id)
    {
        return '`parent_id` = \'' . $id . '\'';
    }

    /**
     * 主页动作 
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
        $this->_otherJobsAfterList();
    }

    /**
     * 加载完列表的方法
     *
     * @return [type] [description]
     */
    protected function _otherJobsAfterList() 
    {
        $this->_assignModelCfg();
        $this->_assignAllParentList();
        $this->_registerParentFormatMap(HResponse::getAttribute('parent_id_list'));
        $this->_registerAuthorFormatMap();
        $this->_assignLangLinkedToList();
        $this->_assignLangList();
        $this->_assignRootCategoryList();
        HResponse::registerFormatMap('lang_id', 'name', HResponse::getAttribute('lang_id_map'));
    }

    /**
     * 詳細頁面後驅方法 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobsAfterInfo() { }

    /**
     * 加载语言关联列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLangLinkedToList()
    {
        if(2 != $this->_modelCfg['has_multi_lang']) {
            return;
        }
        $list       = HResponse::getAttribute('list');
        if(!$list) {
            return;
        }
        $this->_linkedData->setRelItemModel($this->_popo->modelEnName, 'lang');
        $linkedList = $this->_linkedData->getAllRowsByFields(
            '`item_id`, `extend`, `rel_id`', 
            HSqlHelper::whereInByListMap('rel_id', 'id', $list)
        );
        foreach($list as $key => $item) {
            $langMap    = array();
            foreach($linkedList as $linked) {
                if($linked['rel_id'] != $item['id']) {
                    continue;
                }
                $langMap[$linked['item_id']]    = $linked;
            }
            $item['lang_map']   = $langMap;
            $list[$key]         = $item;
        }
        HResponse::setAttribute('list', $list);
    }

    /**
     * 添加视图后驱
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobsAfterAddView() 
    { 
        $this->_assignLangList();
        $this->_assignModelCfg();
        $this->_assignRootCategoryList();
        $this->_assignLangLinkedListByLId(HRequest::getParameter('fid'));
    }

    /**
     * 视频详细页后驱
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobsAfterEditView($record = null) 
    { 
        $this->_assignLangList();
        $this->_assignModelCfg();
        $this->_assignRootCategoryList();
        $this->_assignLangLinkedListById($record['id']);
    }

    /**
     * 加载模块配置对象
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignModelCfg()
    {
        $modelManager       = HClass::quickLoadModel('modelmanager');
        $this->_modelCfg    = $modelManager->getRecordByIdentifier($this->_popo->modelEnName);
        HResponse::setAttribute('modelCfg', $this->_modelCfg);
    }

    /**
     * 添加模块视图 
     * 
     * @access public
     */
    public function addview()
    {  
        $this->_addview();
        $this->_otherJobsAfterInfo();

        $this->_render($this->_popo->modelEnName . '/info');
    }

    /**
     * 添加视图的最小原子代码，内部使用
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @throws Exception 添加或是验证异常
     */
    protected function _addview()
    {
        $this->_assignAllParentList();
        HResponse::setAttribute('popo', $this->_popo);
        HResponse::setAttribute('nextAction', 'add');
        HResponse::setAttribute('author', HSession::getAttribute('name', 'user'));
        $this->_otherJobsAfterAddView();
    }

    /**
     * 执行模块的添加 
     * 
     * @access public
     */
    public function add()
    {
        $insertId   = $this->_add();
        $this->_addLangLinkedData($insertId);

        HResponse::succeed('新' . $this->_popo->modelZhName . '添加成功！');
    }

    /**
     * 添加原子方法内部使用
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
            throw new HRequestException(HTranslate::__('添加失败'));
        }

        return $insertId;
    }

    /**
     * 设置当前的排序号
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
        HRequest::setParameter('sort_num', '99999');
    }

    /**
     * 编辑视图的原子方法，内部使用
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
            throw new HVerifyException(HTranslate::__('没有这条信息'));
        }
        $this->_assignAllParentList();
        $this->_assignAuthorInfo($record['author']);
        $this->_assignPreNextRecord($record);
        
        HResponse::setAttribute('record', $record);
        HResponse::setAttribute('nextAction', 'edit');
        HResponse::setAttribute('popo', $this->_popo);
        $this->_otherJobsAfterEditView($record);
    }

    /**
     * 加载上一条跟下一条信息
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
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignTags()
    {
        if(!HResponse::getAttribute('record')) {
            return;
        }
        $record         = HResponse::getAttribute('record');
        $where          = '`rel_id` = ' . $record['id'];
        $relList        = $this->_linkedData->setRelItemModel($this->_popo->modelEnName, 'tags')->getAllRows($where);
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
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _addTagLinkedData($relId)
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
                $itemId, 
                $relId,
                HSession::getAttribute('id', 'user')
            );
        }
        $fields         = array('item_id', 'rel_id', 'author');
        $this->_linkeddata->setRelItemModel(HResponse::getAttribute('HONGJUZI_MODEL'), 'tags');
        if(1 > $this->_linkeddata->add($data, $fields)) {
            throw new HRequestException('标签关联添加失败！');
        }
    }

    /**
     * 加载当前信息作者 
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
     * 编辑动作 
     * 
     * @access public
     */
    public function editview()
    {
        $this->_editview();
        $this->_otherJobsAfterInfo();
        
        $this->_render($this->_popo->modelEnName . '/info');
    }

    /**
     * 编辑提示动作 
     * 
     * @access public
     */
    public function edit()
    {
        $record     = $this->_edit();
        $this->_addLangLinkedData($record['id']);

        HResponse::succeed($this->_popo->modelZhName . '信息更新成功！');
    }

    /**
     * 编辑的原子方法
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @throws HVerifyException | HRequestException
     */
    protected function _edit()
    {
        $this->_setFieldsDefaultValue();
        $this->_verifyDataByPopoCfg();
        $record         = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(HVerify::isEmpty($record)) {
            throw new HVerifyException(HTranslate::__('没有这个记录'));
        }
        $this->_setAutoFillFields();
        $this->_uploadFile();
        if(false === $this->_model->edit(HPopoHelper::getUpdateFieldsAndValues($this->_popo))) {
            throw new HRequestException(HTranslate__('更新失败'));
        }

        return $record;
    }

    /**
     * 设置一些请求的字段值
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
     * @access public
     */
    public function delete()
    {
        $recordIds  = HRequest::getParameter('id');
        if(!is_array($recordIds)) {
            $recordIds  = array($recordIds);
        }
        $this->_delete($recordIds);
        $this->_otherJobsAfterDelete($recordIds);

        HResponse::succeed(
            '删除成功！', 
            HResponse::url($this->_popo->modelEnName, '', 'admin')
        );
    }

    /**
     * 删除后其它的动作
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  array $ids 需要处理的编号
     */
    protected function _otherJobsAfterDelete($ids) 
    {
        $this->_assignModelCfg();
        $this->_deleteLangLinkedData($ids);
    }

    /**
     * 删除信息内部使用
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
                throw new HRequestException(HTranslate::__('删除失败'));
            }
        }
    }

    /**
     * 快捷操作 
     * 
     * @access public
     */
    public function quick()
    {
        HVerify::isEmpty(HRequest::getParameter('operation'), HTranslate::__('操作不能为空'));
        HVerify::isEmpty(HRequest::getParameter('id'), HTranslate::__('操作项目'));
        $recordIds          = HRequest::getParameter('id');
        switch(HRequest::getParameter('operation')) {
            case 'delete': $this->delete(); return;
            default: throw new HVerifyException('操作还没有开放使用～');
        }
        if(false === $this->_model->moreUpdate($recordIds, $opCfg)) {
            throw new HRequestException(HTranslate::__('更新失败'));
        }
        HResponse::succeed(HTranslate::__('更新成功'), $this->_getReferenceUrl(1));
    }

    /**
     * 删除快捷操作里的文件
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
            $this->_getRelationModelList($this->_popo->get('parent'), 'parent_id', '*')
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
        $data   = HResponse::getAttribute('list');
        if(!$data || !$this->_popo->getFieldAttribute('parent_id', 'is_show')) { 
            return ; 
        }
        $parent = HClass::quickLoadModel($this->_popo->get('parent'));    
        $list   = $parent->getAllRowsByFields(
            '`id`, `name`, `parent_id`',
            HSqlHelper::whereInByListMap('id', 'parent_id', $data)
        );
        //注册用户名格式化
        HResponse::registerFormatMap(
            'parent_id',
            'name',
            HArray::turnItemValueAsKey($list, 'id')
        );
    }
    
    /**
     * 加载关联的作者信息列表
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
            throw new HVerifyException(HTranslate::__('信息已经不存在'));
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
     * 得到用户的头像地址
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $uid 用户ID
     * @param  String $size='middle' 图片大小
     * @return String
     */
    public function getAvatar($uid) 
    {
        $uid    = abs(intval($uid));    //UID取整数绝对值
        $uid    = sprintf("%09d", $uid); //前边加0补齐9位，例如UID为31的用户变成 000000031
        $dir1   = substr($uid, 0, 3);   //取左边3位，即 000
        $dir2   = substr($uid, 3, 2);   //取4-5位，即00
        $dir3   = substr($uid, 5, 2);   //取6-7位，即00

        // 下面拼成用户头像路径，即000/00/00/31_avatar_middle.jpg
        return $dir1 . '/' . $dir2 . '/' . $dir3 . '/' . substr($uid, -2) . '_avatar_%s.jpg';
    }

    /**
     * Grid加载列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aloadlist()
    {
        HVerify::isAjax();
        $fields     = HPopoHelper::getShowFieldsAndCfg($this->_popo);
        $page       = $this->_getPageNumber();
        $where      = $this->_getSearchWhere(HRequest::getParameter('keywords'));
        $list       = $this->_model->getListByFields(
            array_keys($fields),
            $where,
            $page,
            15
        );

        HResponse::json(array(
            'rs' => true, 
            'data' => array(
                'fields' => $fields,
                'list' => $list
            ))
        );
    }
    
    /**
     * 自动化完成任务
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function akeyword()
    {
        HVerify::isAjax();
        $keyword    = urldecode(HRequest::getParameter('keyword'));
        if(!$keyword) {
            HResponse::json(array('rs' => true, 'data' => array()));
            return;
        }
        $where      = '`name` LIKE \'%' . $keyword . '%\'';
        $ids        = array_filter(explode(',', HRequest::getParameter('ids')));
        if($ids) {
            $where  .= ' AND ' . HSqlHelper::whereNotIn('id', $ids);
        }
        $list       = $this->_model->getSomeRowsByFields(5, '`id`, `name`, `lang_id`', $where);

        HResponse::json(array('rs' => true, 'data' => $list));
    }

    /**
     * 删除语言关联信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function adellanglinked()
    {
        HVerify::isAjax();
        HVerify::isNumber(HRequest::getParameter('id'), '编号');
        HVerify::isNumber(HRequest::getParameter('copy_id'), '关联编号');
        $this->_linkedData->setRelItemModel($this->_popo->modelEnName, 'lang');
        $where      = '`extend` = ' . HRequest::getParameter('copy_id')
            . ' AND `rel_id` = ' . HRequest::getParameter('id');
        $record     = $this->_linkedData->getRecordByWhere($where);
        if(!$record) {
            throw new HVerifyException('记录已经不存在，请确认！');
        }
        $this->_linkedData->deleteByWhere($where);
        //删除对应关联
        $this->_linkedData->deleteByWhere(
            '`extend` = ' . HRequest::getParameter('id')
            . ' AND `rel_id` = ' . HRequest::getParameter('copy_id')
        );
        HResponse::json(array('rs' => true));
    }

    /**
     * 添加语言对应关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $id 当前记录编号
     */
    protected function _addLangLinkedData($id)
    {
        if(!HRequest::getParameter('lang_linked')) {
            return;
        }
        $langLinked     = HRequest::getParameter('lang_linked');
        $this->_linkedData->setRelItemModel($this->_popo->modelEnName, 'lang');
        $this->_deleteLangLinkedEachOther($id, $langLinked);
        $this->_updateLangLinkedData($id, $langLinked);
    }

    /**
     * 更新语言关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $id 当前信息编号
     * @param  $langLinked 关联语言数组
     */
    protected function _updateLangLinkedData($id, $langLinked)
    {
        $list           = $this->_linkedData->getAllRowsByFields('`item_id`, `extend`', '`rel_id` = ' . $id);
        foreach($list as $item) {
            $key        = array_search($item['extend'], $langLinked);
            if(false !== $key) {
                unset($langLinked[$key]);
            }
        }
        $linkedList     = $this->_model->getAllRowsByFields(
            '`id`, `lang_id`',
            HSqlHelper::whereIn('id', $langLinked)
        );
        $data           = array();
        $record         = $this->_model->getRecordById($id);
        foreach($linkedList as $linked) {
            $item['rel_id']     = $id;
            $item['item_id']    = $linked['lang_id'];
            $item['extend']     = $linked['id'];
            $item['author']     = HSession::getAttribute('id', 'user');
            $data[]             = $item;
            $item['rel_id']     = $linked['id'];
            $item['item_id']    = $record['lang_id'];
            $item['extend']     = $record['id'];
            $data[]             = $item;
        }
        if(empty($data)) {
            return;
        }
        if(1 > $this->_linkedData->addMore('`rel_id`, `item_id`, `extend`, `author`', $data)) {
            throw new HRequestException('添加语言关联数据失败，请确认！');
        }
    }

    /**
     * 删除对应语言关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $ids 编号
     */
    protected function _deleteLangLinkedData($ids)
    {
        if(2 != $this->_modelCfg['has_multi_lang']) {
            return;
        }
        $this->_linkedData->setRelItemModel($this->_popo->modelEnName, 'lang');
        $this->_linkedData->deleteByWhere(HSqlHelper::whereIn('rel_id', $ids));
        $this->_linkedData->deleteByWhere(HSqlHelper::whereIn('extend', $ids));
    }

    /**
     * 异步得到详细信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aget()
    {
        HVerify::isAjax();
        HVerify::isNumber(HRequest::getParameter('id'), '编号');
        $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(empty($record)) {
            throw new HVerifyException('记录已经不存在，请确认！');
        }
        $record['format_datetime']  = date('Y-m-d H:m:s', $record['create_time']);

        HResponse::json(array('rs' => true, 'data' => $record));
    }

    /**
     * 加载对应语言关联编号
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLangLinkedListByLId($id)
    {
        if(!$id) {
            return;
        }
        $record     = $this->_model->getRecordById($id);
        if(!$record) {
            throw new HVerifyException('对应语言已经不存在，请确认！');
        }
        $record['copy_id']   = $record['id'];
        HResponse::setAttribute('copyRecord', $record);
        HResponse::setAttribute('langLinkedMap', array($record['lang_id'] => $record));
    }

    /**
     * 删除相互连接关系
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $id 当前信息编号
     * @param  $langLinked 关联编号数组
     */
    protected function _deleteLangLinkedEachOther($id, $langLinked)
    {
        $where          = '`rel_id` = ' . $id . ' AND ' . HSqlHelper::whereNotIn('extend', $langLinked);
        $this->_linkedData->setRelItemModel($this->_popo->modelEnName, 'lang');
        $deleteList     = $this->_linkedData->getAllRowsByFields('`id`, `extend`', $where);
        if(!$deleteList) {
            return;
        }
        $this->_linkedData->deleteByWhere(HSqlHelper::whereInByListMap('id', 'id', $deleteList));
        $this->_linkedData->deleteByWhere(
            '`extend` = ' . $id . ' AND ' . HSqlHelper::whereInByListMap('rel_id', 'extend', $deleteList)
        );
    }

    /**
     * 删除标签关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $ids 删除的数据对象编号
     */
    protected function _deleteTagsLinkedData($ids)
    {
        $this->_linkedData->setRelItemModel($this->_popo->modelEnName, 'tags');
        $where  = HSqlHelper::whereIn('item_id', $ids);
        $list   = $this->_linkedData->getAllRowsByFields('`id`, `rel_id`', $where);
        $tags   = HClass::quickLoadModel('tags');
        foreach($list as $item) {
            $total  = $this->_linkedData->getTotalRecords('`rel_id` = ' . $item['rel_id'] . ' AND ' . $where);
            $tags->incFieldByWhere('hots', '`id` = ' . $item['rel_id'], -1 * $total);
            $this->_linkedData->deleteByWhere('`rel_id` = ' . $item['rel_id'] . ' AND ' . $where);
        }
    }

    /**
     * 加载语言关联列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLangLinkedListById($id)
    {
        if(2 != $this->_modelCfg['has_multi_lang']) {
            return;
        }
        if(!$id) {
            return;
        }
        $this->_linkedData->setRelItemModel($this->_popo->modelEnName, 'lang');
        $linkedList = $this->_linkedData->getAllRowsByFields('`item_id`, `extend`', '`rel_id` = ' . $id);
        $matchList  = $this->_model->getAllRowsByFields(
            '`id`, `name`, `lang_id`',
            HSqlHelper::whereInByListMap('id', 'extend', $linkedList)
        );
        HResponse::setAttribute('langLinkedMap', HArray::turnItemValueAsKey($matchList, 'lang_id'));
    }

    /**
     * 加载最顶级分类到视图中
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignRootCategoryList()
    {
        HResponse::setAttribute(
            'rootCatList', 
            $this->_category->getAllRowsByFields(
                '`id`, `name`, `parent_id`',
                '`parent_id` < 1'
            )
        );
    }

    /**
     * 格式化以ZTree数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $list 数据集合
     * @param $ids 有的编号
     * @return Array 格式化数据
     */
    protected function _formatToZTreeNodes($list, $ids)
    {
        $nodes      = array();
        foreach($list as $item) {
            $nodes[]    = array(
                'id' => $item['id'],
                'pId' => $item['parent_id'],
                'name' => $item['name'],
                'open' => true,
                'checked' => in_array($item['id'], $ids)
            );
        }

        return $nodes;
    }

}

?>
