<?php 

/**
 * @version			$Id$
 * @create 			2012-4-25 21:50:27 By xjiujiu
 * @description     HongJuZi Framework
 * @copyright 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

/**
 * 前台应用的Action基类部分
 * 
 * 提取前台应用对应action的公用方法 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.front.action
 * @since 			1.0.0
 */
class FrontAction extends HAction
{

    /**
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function beforeAction()
    {
        HModel::$mustWhere  = array(
            'website_id' => '(`website_id` = 1 OR `website_id` = ' . HSession::getAttribute('id', 'website') . ')'
        );
    }

    /**
     * 模块主页显示动作用来调配当前所要显示的页面 
     * 
     * @access public
     */
    public function index()
    {
        if(!HRequest::getParameter('id')) {
            $this->_list();
            return;
        }

        $this->_detail();
    }

    /**
     * 模块主页显示方法 
     * 
     * @access protected
     * @param int $perpage 每页加载的记录条数，默认为10
     */
    protected function _list($where = '', $perpage = 10)
    {
        $this->_assignModelList($where, $perpage);
        $this->_commAssign();
        $this->_assignSeoInfo();
        HResponse::setAttribute('title', $this->_popo->modelZhName);
        HResponse::setAttribute('typeName', $this->_popo->modelZhName);
    }

    /**
     * 根据类型得到信息列表 
     * 
     * @access public
     * @param int $perpage 每页加载的记录数量，默认为10
     */
    protected function _type($perpage = 10)
    {
        HVerify::isRecordId(HRequest::getParameter('id'));
        $typeInfo   = $this->_getCategoryInfo(HRequest::getParameter('id'));
        if(true == HVerify::isEmpty($typeInfo)) {
            throw new HVerifyException(HResponse::lang('CATEGORY_NOT_EXISTS'));
        }
        $this->_assignModelList($this->_getCategoryWhere($typeInfo['id']), $perpage);
        $this->_commAssign();
        $this->_assignSeoInfo();
        HResponse::setAttribute('title', $typeInfo['name']);
        HResponse::setAttribute('typeInfo', $typeInfo);
    }

    /**
     * 得到分类条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $id  当前的分类ID
     * @return String 条件 
     */
    protected function _getCategoryWhere($id)
    {
        return '`parent_id` = ' . $id;
    }

    /**
     * 按标签查找文章
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    protected function _tag()
    {
        HVerify::isNumber(HRequest::getParameter('id'), '标签编号');
        $relationship   = HClass::quickLoadModel('relationship');
        $relList        = $relationship->getAllRows(
            '`item_id` = ' . HRequest::getParameter('id') 
            . ' AND `model` = \'article\''
        );
        $where          = '1 = 2';
        if($relList) {
            $where      = HSqlHelper::whereInByListMap('id', 'rel_id', $relList);
        }
        parent::_list($where);
    }

    /**
     * 得到标签分类条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $tag
     * @return String 标签条件
     */
    protected function _getTagWhere($tag)
    {
        return '`tags` LIKE \'%,' . $tag . ',%\'';
    }

    /**
     * 得到当前类型的记录的详细信息 
     * 
     * 通过指定的类型ID来得到对应记录的详细信息 
     * 
     * @author 			xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    protected function _getCategoryInfo($typeId)
    {
        if(!$this->_popo->get('parent')) {
            return null;
        }
        
        return HClass::quickLoadModel($this->_popo->get('parent'))->getRecordById($typeId);
    }

    /**
     * 根据E文名来查找当前的记录
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _name()
    {
        HVerify::isEmpty(HRequest::getParameter('n')); 
        $this->_record('`identifier` = \'' . HRequest::getParameter('n') . '\'');
    }
    
    /**
     * 显示新闻的详细信息 
     * 
     * @access public
     */
    protected function _detail()
    {
        HVerify::isRecordId(HRequest::getParameter('id'));
        $this->_record('`id` = ' . HRequest::getParameter('id'));
    }

    /**
     * 得到记录信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $where 查询条件，默认为'1 = 2'
     */
    protected function _record($where = '1 = 2')
    {
        $record     = $this->_model->getRecordByWhere($where);
        if(empty($record)) {
            throw new HVerifyException(HResponse::lang('RECORD_NOT_EXISTS', false));
        }
        $this->_updateTotalVisits($record);
        $this->_assignSeoInfo($record['seo_keywords'], $record['seo_desc']);
        $this->_assignCategoryInfo($record['parent_id']);
        $this->_commAssign();
        HResponse::setAttribute('record', $record);
        HResponse::setAttribute('title', $record['name']);
        $typeWhere      = $this->_getCategoryWhere($record['parent_id']);
        HResponse::setAttribute(
            'preRecord',
            $this->_model->getPreRecord($record['id'], $typeWhere)
        );
        HResponse::setAttribute('nextRecord',
            $this->_model->getNextRecord($record['id'], $typeWhere)
        );
    }

    /**
     * 加载当前信息分类信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignCategoryInfo($catId) 
    {
        if(1 > intval($catId)) {
            $typeInfo   = $this->_getCategoryInfo($record['parent_id']);
            HResponse::setAttribute('typeInfo', $typeInfo);
        }
    }

    /**
     * 更新总访问量
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $record 当前的信息记录
     */
    protected function _updateTotalVisits($record)
    {
        if(isset($record['total_visits'])) {
            $record['total_visits']     = (intval($record['total_visits']) + 1);
            $this->_model->updateTotalVisits($record['id'], $record['total_visits']);
        }
    }

    /**
     * 搜索动作 
     * 
     * @access public
     */
    public function search()
    {
        HVerify::isEmpty(HRequest::getParameter('keywords'), '关键字');

        $this->_list($this->_getSearchWhere(HRequest::getParameter('keywords')));
    }

    /**
     * 公用的赋值方法 
     * 
     * @access protected
     */
    protected function _commAssign()
    {
        $this->_assignSiteConfig();
        HResponse::setAttribute('modelEnName', $this->_popo->modelEnName);
        HResponse::setAttribute('modelZhName', $this->_popo->modelZhName);
    }

    /**
     * 设置页面的SEO信息 
     * 
     * @access protected
     * @param string $seoKeyWords 网站的SEO Keywords部分
     * @param string $seoDesc 网站SEO DESC 部分
     */
    protected function _assignSeoInfo($seoKeyWords = '', $seoDesc = '')
    {
        $siteCfg    = HResponse::getAttribute('siteCfg');
        HResponse::setAttribute(
            'seoDesc', 
            $seoDesc ? $seoDesc . ',' . $siteCfg['seo_desc'] : $siteCfg['seo_desc']
        );
        HResponse::setAttribute(
            'seoKeywords', 
            $seoKeyWords ? $seoKeyWords . '|' . $siteCfg['seo_keywords'] : $siteCfg['seo_keywords']
        );
    }

    /**
     * 赋值网站的配置信息 
     * 
     * @access protected
     */
    protected function _assignSiteConfig()
    {
        $company     = HClass::quickLoadModel('company');
        HResponse::setAttribute(
            'siteCfg', 
            $company->getRecordByWhere('1 = 1')
        );
    }
    
    /**
     * 得到所有的父类型 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignParentList()
    {
        $parent    = HClass::quickLoadModel($this->_popo->get('parent'));
        HResponse::setAttribute('parentList', $parent->getAllRows());
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

}

?>
