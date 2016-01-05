<?php 

/**
 * @version			$Id$
 * @create 			2012-4-25 21:50:27 By xjiujiu
 * @description     HongJuZi Framework
 * @copyright 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.base.action.frontaction');

/**
 * CMS应用的Action基类部分
 * 
 * 提取CMS模块对应action的公用方法 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @since 			1.0.0
 */
class CmsAction extends FrontAction
{

    /**
     * @var String $_catIdentifier 针对分类
     */
    protected $_catIdentifier;

    /**
     * @var protected $_category  分类对象
     */
    protected $_category    = null;

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_catIdentifier   = null;
        $this->_category        = HClass::quickLoadModel('category');
    }

    /**
     * 模块主页显示动作用来调配当前所要显示的页面 
     * 
     * @access public
     */
    public function index()
    {
        //fix wp page id bug
        if(HRequest::getParameter('p')) {
            HRequest::setParameter('id', HRequest::getParameter('p'));
        }
        if(!HRequest::getParameter('id')) {
            $this->_list();
            return;
        }

        $this->_detail();
    }

    /**
     * 根据类型得到信息列表 
     * 
     * @access public
     * @param int $perpage 每页加载的记录数量，默认为10
     */
    protected function _type($catId, $perpage = 10)
    {
        $typeInfo   = $this->_getCategoryInfo($catId);
        if(true == HVerify::isEmpty($typeInfo)) {
            throw new HVerifyException(HTranslate::__('分类已经不存在'));
        }
        $this->_assignModelList($this->_getCategoryWhere($typeInfo['id']), $perpage);
        $this->_commAssign();
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
        $catInfo    = $this->_category->getRecordById($id);
        if(!$catInfo) {
            return '1 = 2';
        }

        return '`parent_path` LIKE \'' . $catInfo['parent_path'] . '%\'';
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
            throw new HVerifyException(HTranslate::__('记录不存在'));
        }
        $this->_updateTotalVisits($record);
        $this->_assignSeoInfo($record['seo_keywords'], $record['seo_desc']);
        $this->_assignAuthorInfo($record['author']);
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
     * 加载作者信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $id 用户编号
     */
    protected function _assignAuthorInfo($id)
    {
        if(!$id) {
            return;
        }
        $user   = HClass::quickLoadModel('user');
        HResponse::setAttribute('author', $user->getRecordById($id));
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
        parent::_commAssign();
        $this->_assignNavmenus();
    }

    /**
     * 加载可用语言
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLangList()
    {
        $website    = HClass::quickLoadModel('website');
        $list       = $website->getAllRowsByFields(
            '`id`, `lang_id`',
            '`is_open` = 2'
        );
        $langList   = $this->_getLangList(HSqlHelper::whereInByListMap('id', 'lang_id', $list));
        HResponse::setAttribute('lang_id_list', $langList);
        HResponse::setAttribute('lang_id_map', HArray::turnItemValueAsKey($langList, 'id'));
    }

    /**
     * 得到导航栏链接 
     * 
     * @access protected
     */
    protected function _assignNavmenus()
    {
        $navmenu        = HClass::quickLoadModel('navmenu');
        $navmenu->setMustWhere('lang', '`lang_id` = ' . HSession::getAttribute('id', 'lang'));
        $mainMenu       = $this->_category->getRecordByIdentifier('main-navmenu');
        if(empty($mainMenu)) {
            throw new HVerifyException('主菜单没有配置，请确认！');
        }
        HResponse::setAttribute(
            'navmenuList', 
            $navmenu->getAllRows('`position_id` = ' . $mainMenu['id'])
        );
    }

    /**
     * 加载友情链接
     *
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLink()
    {
        HResponse::setAttribute('linkList', HClass::quickLoadModel('link')->getSomeRows(5));
    }

}

?>
