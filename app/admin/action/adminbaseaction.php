<?php 

/**
 * @version			$Id$
 * @create 			2012-4-25 21:16:23 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.oauth.action.auserAction');

/**
 * 后台管理的父类 
 * 
 * 后台管理类的公用部分 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class AdminBaseAction extends HAction
{

    /**
     * {@inheritDoc}
     */
    public function beforeAction()
    {
        try {
            AuserAction::isLogined();
            $this->_verifyRights();
            HModel::$mustWhere  = array(
                'website_id' => '(`website_id` = 1 OR `website_id` = ' . HSession::getAttribute('id', 'website') . ')'
            );
        } catch(HVerifyException $ex) {
            HResponse::redirect(HResponse::url('enter', '', 'admin'));
        }
    }

    /**
     * 验证用户权限
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @throws HRequestException 验证异常
     */
    protected function _verifyRights()
    {
        $rights     = HClass::quickLoadModel('rights');
        $model      = $rights->getRecordByWhere(
            '`identifier` = \'' . HResponse::getAttribute('HONGJUZI_MODEL') . '\''
        );
        $actionData   = array(
            'name' => $this->_getActionName(HResponse::getAttribute('HONGJUZI_ACTION')),
            'identifier' => HResponse::getAttribute('HONGJUZI_ACTION'),
            'app' => HResponse::getAttribute('HONGJUZI_APP'),
        );
        if(empty($model)) {
            $modelName  = empty($this->_popo->modelZhName) 
                ? HResponse::getAttribute('HONGJUZI_MODEL') : $this->_popo->modelZhName;
            $modelData  = array(
                'name' => $modelName,
                'identifier' => HResponse::getAttribute('HONGJUZI_MODEL'),
                'parent_id' => '-1',
                'app' => HResponse::getAttribute('HONGJUZI_APP')
            );
            $modelId    = $rights->add($modelData);
            
            if(1 > $modelId) {
                throw new HRequestException('自学习栏目权限失败！');
            }
            $actionData['parent_id'] = $modelId;
            if(1 > $rights->add($actionData)) {
                throw new HRequestException('自学习功能权限失败！');
            }
            return;
        }
        $action     = $rights->getRecordByWhere(
            '`identifier` = \'' . HResponse::getAttribute('HONGJUZI_ACTION') . '\''
            . ' AND `parent_id` = ' . $model['id']
        );
        if(empty($action)) {
            $actionData['parent_id'] = $model['id'];
            if(1 > $rights->add($actionData)) {
                throw new HRequestException('自学习功能权限失败！');
            }
            return;
        }
        if(false === strpos(HSession::getAttribute('rights', 'user'), ',' . $model['id'] . ',')) {
            //throw new HRequestException('您没有访问这个栏目的权限，如有疑问请联系管理员！');
        }
        if(false === strpos(HSession::getAttribute('rights', 'user'), ',' . $action['id'] . ',')) {
            //throw new HRequestException('您没有访问这个功能的权限，如有疑问请联系管理员！');
        }
    }

    /**
     * 得到当前执行动作的中文名称
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $action 当前动作名称
     * @return String 中文名称 
     */
    protected function _getActionName($action)
    {
        static $_actionNameMap  = array(
            'index' => '列表', 'search' => '搜索',
            'addview' => '添加页面', 'add' => '执行添加',
            'editview' => '编辑页面', 'edit' => '执行编辑',
            'quick' => '批量操作'
        );

        return $this->_popo->modelZhName
            . (isset($_actionNameMap[$action]) ? $_actionNameMap[$action] : $action);
    }

}

?>
