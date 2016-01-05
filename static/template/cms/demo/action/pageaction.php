<?php 

/**
 * @version $Id$
 * @create 2013-8-6 10:20:09 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('config.popo.articlepopo, model.articlemodel');
HClass::import(HResponse::getCurThemePath() . '.action.defaultaction');

/**
 * 单页信息类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.cms.action
 * @since 1.0.0
 */
class PageAction extends DefaultAction
{

    /**
     * @var protected $_identifier 单页标识
     */
    protected $_identifier;

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_identifier          = '';
        $this->_popo        = new ArticlePopo();
        $this->_model       = new ArticleModel($this->_popo);
        $this->_model->setMustWhere('status', '`status` = 2');
    }
    
    /**
     * {@inheritDoc}
     */
    public function index()
    {
        if(HRequest::getParameter('id')) {
            $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        } else {
            $record     = $this->_model->getRecordByIdentifier($this->_identifier);
        }
        if(!$record) {
            throw new HVerifyException('信息不存在，请确认！');
        }
        HResponse::setAttribute('record', $record);
        $this->_assignSameList($record);
        $this->_otherJobs();
        $this->_commAssign();

        $this->_render('page');
    }

    /**
     * 加载其它任务
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobs() {}

    /**
     * 加载同类
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $record 当前记录
     */
    protected function _assignSameList($record)
    {
        HResponse::setAttribute(
            'sameList', 
            $this->_model->getAllRowsByFields(
                '`id`, `name`',
                '`parent_id` = ' . $record['parent_id']
            )
        );
    }

}

?>
