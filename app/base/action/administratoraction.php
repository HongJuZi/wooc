<?php 

/**
 * @version			$Id$
 * @create 			2012-4-25 21:16:23 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.base.action.baseaction');
HClass::import('app.oauth.action.auserAction');

/**
 * 后台管理的父类 
 * 
 * 后台管理类的公用部分 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.base.action
 * @since 			1.0.0
 */
class AdministratorAction extends BaseAction
{
    
    /**
     * @var protected $_rights 当前的模块操作列表
     */
    protected $_rights;

    /**
     * 初始化构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_switchLang();
        $this->_assignWebsite();
    }

    /**
     * {@inheritDoc}
     */
    public function beforeAction()
    {
        try {
            AuserAction::isLogined();
            // $this->_verifyRights();
        } catch(HVerifyException $ex) {
            HResponse::info('正在为您导航到登陆页面...', HResponse::url('enter', '', 'admin'));
        }
    }

    /**
     * 验证用户权限
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @throws HRequestException 验证异常
     */
    protected function _verifyRights()
    {
        if(1 != HSession::getAttribute('parent_id', 'user')) {
            throw new HVerifyException('您没有访问这个功能的权限，如有疑问请联系管理员！');
        }
        $this->_rights  = HClass::quickLoadModel('rights');
        $modelId    = $this->_getRightsModelId();
        $actionId   = $this->_getRightsActionId($modelId);
        $where          = '(`item_id` = ' 
            . $modelId . ' OR `item_id` = ' . $actionId . ') AND `rel_id` = ' 
            . HSession::getAttribute('parent_id', 'user');
        $linkedData     = HClass::quickLoadModel('linkeddata');
        $linkedData->setRelItemModel('actor', 'rights');
        $list           = $linkedData->getAllRows($where);
        if(2 > count($list)) {
            //throw new HVerifyException('您没有访问这个功能的权限，如有疑问请联系管理员！');
        }
    }

    /**
     * 得到当前模块对应权限的编号
     * 
     * 此方法里包含的自学习新模块的功能
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return 当前模块的编号
     */
    protected function _getRightsModelId()
    {
        $model      = $this->_rights->getRecordByWhere(
            '`identifier` = \'' . HResponse::getAttribute('HONGJUZI_MODEL') . '\''
        );
        if($model) {
            return $model['id'];
        }
        $modelName  = empty($this->_popo->modelZhName) 
            ? HResponse::getAttribute('HONGJUZI_MODEL') : $this->_popo->modelZhName;
        $modelData  = array(
            'name' => $modelName,
            'identifier' => HResponse::getAttribute('HONGJUZI_MODEL'),
            'parent_id' => '-1',
            'app' => HResponse::getAttribute('HONGJUZI_APP')
        );
        $modelId    = $this->_rights->add($modelData);
        if(1 > $modelId) {
            throw new HRequestException('自学习栏目权限失败！');
        }

        return $modelId;
    }

    /**
     * 得到当前权限编号 
     * 
     * 此方法有包含有添加新动作的功能
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $modelId 当前权限模块的编号
     * @return 权限编号
     */
    protected function _getRightsActionId($modelId)
    {
        $action     = $this->_rights->getRecordByWhere(
            '`identifier` = \'' . HResponse::getAttribute('HONGJUZI_ACTION') . '\''
            . ' AND `parent_id` = ' . $modelId
        );
        if($action) {
            return $action['id'];
        }
        $actionData   = array(
            'name' => $this->_getActionName(HResponse::getAttribute('HONGJUZI_ACTION')),
            'identifier' => HResponse::getAttribute('HONGJUZI_ACTION'),
            'app' => HResponse::getAttribute('HONGJUZI_APP'),
            'parent_id' => $modelId
        );
        $actionId   = $this->_rights->add($actionData);
        if(1 > $actionId) {
            throw new HRequestException('自学习功能权限失败！');
        }

        return $actionId;
    }

    /**
     * @var protected static $_actionNameMap  动作映射
     */
    protected static $_actionNameMap  = array(
        'index' => '列表', 'search' => '搜索',
        'addview' => '添加页面', 'add' => '执行添加',
        'editview' => '编辑页面', 'edit' => '执行编辑',
        'quick' => '批量操作'
    );

    /**
     * 得到当前执行动作的中文名称
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $action 当前动作名称
     * @return String 中文名称 
     */
    protected function _getActionName($action)
    {
        return $this->_popo->modelZhName
            . (isset(self::$_actionNameMap[$action]) ? self::$_actionNameMap[$action] : $action);
    }

    /**
     * 加载默认网站信息
     *
     * 管理类的应用不需要管是不是网站开放，
     * 只需要找一个默认的网站加载对应的信息就行
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    protected function _assignWebsite()
    {
        $where      = '`is_default` = 2';
        $information = HClass::quickLoadModel('information');
        $record     = $information->getRecordByWhere($where);
        if(!$record) {
            HResponse::error('没有设置默认网站，请先联系管理员设置！');
            return;
        }

        HSession::setAttributeByDomain($record, 'siteCfg');
    }

}

?>
