<?php

/**
 * @version			$Id$
 * @create 			2013-06-17 01:06:41 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.categorypopo, app.admin.action.AdminAction, model.categorymodel'); 

/**
 * 信息分类的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class CategoryAction extends AdminAction
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
        $this->_popo        = new CategoryPopo();
        $this->_model       = new CategoryModel($this->_popo);
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
            array_push($where, '`parent_path` LIKE \'%:' . HRequest::getParameter('type') . ':%\'');
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
     * 添加模块视图 
     * 
     * @access public
     */
    public function addview()
    {  
        $this->_addview();
        $this->_assignCategoryRootNodes();
        $this->_assignUserList();

        $this->_render($this->_popo->modelEnName . '/info');
    }

    /**
     * 执行模块的添加 
     * 
     * @access public
     */
    public function add()
    {
        $this->_checkIdentifier();
        $id     = $this->_add();
        $this->_addLangLinkedData($id);
        $this->_updateParentPath($id, HRequest::getParameter('parent_id'));
        HResponse::succeed($acName . '添加成功！', HResponse::url('category'));
    }

    /**
     * 编辑动作 
     * 
     * @access public
     */
    public function editview()
    {
        $this->_editview();
        $record     = HResponse::getAttribute('record');
        $this->_assignCategoryRootNodes($this->_model);
        $this->_assignParentInfo($record['parent_id']);
        $this->_assignUserList();
        
        $this->_render($this->_popo->modelEnName . '/info');
    }

    /**
     * 加载用户列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignUserList()
    {
        $user   = HClass::quickLoadModel('user');
        HResponse::setAttribute('author_list', $user->getAllRowsByFields('`id`, `name`'));
    }

    /**
     * 编辑提示动作 
     * 
     * @access public
     */
    public function edit()
    {
        $record         = $this->_model->getRecordById(HRequest::getParameter('id'));
        if(HVerify::isEmpty($record)) {
            throw new HVerifyException(HResponse::lang('NO_THIS_RECORD', false));
        }
        $this->_checkIdentifier(HRequest::getParameter('id'));
        $this->_edit();
        $this->_addLangLinkedData($record['id']);
        $this->_updateParentPath($record['id'], HRequest::getParameter('parent_id'));

        HResponse::succeed(HTranslate::__('更新分类成功！'));
    }

    /**
     * 检测标识是否已经使用过
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $id 编号
     */
    private function _checkIdentifier($id = '0')
    {
        if(!HRequest::getParameter('identifier')) {
            return;
        }
        $where  = '`id` != ' . $id . ' AND `identifier` = \'' . HRequest::getParameter('identifier') . '\'';
        if($this->_model->getRecordByWhere($where)) {
            throw new HVerifyException('标识已经被使用，请重新换一个！');
        }
    }

    /**
     * 更新分类的层级信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $id 记录编号
     * @param  $pid 上级分类
     * @return 当前的分类层级
     */
    private function _updateParentPath($id, $pid)
    {
        $data      = array(
            'parent_path' => $this->_getParentPath($id, $pid)
        );
        $record     = $this->_model->getRecordById($id);
        $this->_model->editByWhere($data, '`id` = ' . $id);
        $this->_updateSubCategoryParentPath($record, $data['parent_path']);
        $this->_updateArticleParentPath($record, $data['parent_path']);

        return $data['parent_path'];
    }

    /**
     * 更新子分类层级
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $record 分类记录
     * @param  $path 当前新层级
     */
    private function _updateSubCategoryParentPath($record, $path)
    {
        $list   = $this->_category->getSubCategoryByParentPath($record['parent_path'], $record['id'], false);
        if(empty($list)) {
            return;
        }
        foreach($list as $item) {
            $data   = array(
                'parent_path' => str_replace($record['parent_path'], $path, $item['parent_path'])
            );
            $this->_model->editByWhere($data, '`id` = ' . $item['id']);
        }
    }

    /**
     * 更新文章层级
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  $record 记录
     * @param  $path 层级
     */
    private function _updateArticleParentPath($record, $path)
    {
        $id         = 0;
        $limit      = 500;
        $article    = HClass::quickLoadModel('article');
        $article->getPopo()->setFieldAttribute('id', 'is_order', 'ASC');
        do {
            $list   = $article->getSomeRowsByFields(
                $limit,
                '`id`, `parent_path`',
                'id > ' . $id . ' AND `parent_path` LIKE \'' . $record['parent_path'] . '%\''
            );
            if(!$list) {
                break;
            }
            foreach($list as $item) {
                $id     = $item['id'];
                $data   = array(
                    'parent_path' => str_replace($record['parent_path'], $path, $item['parent_path'])
                );
                $article->editByWhere($data, '`id` = ' . $item['id']);
            }
        } while(true);
    }

    /**
     * 得到当前记录的parent_PATH值 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $id 当前记录的ID
     * @param  int $parentId 当前的父层
     * @return 当前的所属层级 
     */
    protected function _getParentPath($id, $parentId)
    {
        if(empty($parentId) || -1 == $parentId) {
            return ':' . $id . ':';
        }
        $parent     = $this->_model->getRecordById($parentId);
        if(null == $parent) {
            return ':' . $id . ':';
        }

        return $parent['parent_path'] . $id . ':';
    }

    /**
     * 查找子分类 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @throws HRequestException 请求异常 | HVerifyException 验证异常 
     */
    public function asubcategory()
    {
    	$modelName = HRequest::getParameter('model_name');
    	$modelName == ''?$typeModel = $this->_model:$typeModel = HClass::quickLoadModel($modelName);
        HVerify::isAjax();
        HVerify::isNumber(HRequest::getParameter('pid'));
        HResponse::json(array(
            'list' => $typeModel->getAllRows(
                '`parent_id` = ' . HRequest::getParameter('pid')
            )
        ));
    }

    /**
     * 异步加载分享
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aload()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('id'), '分类编号');

        echo HArray::makeZtreeJsonByListMap(
            $this->_model->getAllRows('`parent_id` = ' . HRequest::getParameter('id')),
            null,
            true
        );
    }

    /**
     * 异步新建分类
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function anew()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('name'), '名称');
        $data   = array(
            'name' => urldecode(HRequest::getParameter('name')),
            'parent_id' => intval(HRequest::getParameter('pid')),
            'author' => HSession::getAttribute('id', 'user')
        );
        $id     = $this->_model->add($data);
        if(1 > $id) {
            throw new HRequestException('添加新分类失败！');
        }
        $this->_updateParentPath($id, $data['parent_id']);
        $list   = $this->_model->getSubCategoryByIdentifier('article-cat');

        HResponse::json(array(
            'rs' => true,
            'data' => $this->_getCategoryTree($list),
            'node' => array(
                'id' => $id,
                'name' => $data['name'],
                'pId' => $data['parent_id'],
                'checked' => true
            )
        ));
    }

    /**
     * 得到分类的树形字符串
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $list 数据集合
     * @return 格式化事的字符串
     */
    private function _getCategoryTree($list)
    {
        HClass::import('hongjuzi.utils.HTree');
        $hTree  = new HTree(
            $list, 
            'id', 'parent_id',
            'name', 'id',
            '<option value="{id}">' . '{name}' . '</option>'
        );
        
        return $hTree->getTree();
    }

}

?>
