<?php 

/**
 * @version			$Id$
 * @create 			2012-5-3 12:01:52 By xjiujiu
 * @package 		app.admin
 * @subpackage 		model
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

/**
 * 模块状态Model层类 
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.model
 * @since 			1.0.0
 */
class ModelstatusModel extends HModel
{

    /**
     * 得到各模块的信息 
     * 
     * @desc
     * 
     * @access public
     * @return array 
     * @exception none
     */
    public function getModelStatus()
    {
        $pass       = 0;
        $unpass     = 0;
        $models     = $this->_getAllModels();
        foreach($models as $key => $model) {
            if($model['pass_flag'] == 2) {
                $pass ++;
            } else {
                $unpass ++;
            }
            $models[$key]['status'] = $this->_getModelDetailStatus($model['en_name']);
        }
        //$models['pass']     = $pass;
        //$models['unpass']   = $unpass;

        return $models;
    }

    /**
     * 得到所有的模块信息 
     * 
     * @desc
     * 
     * @access protected
     * @return array
     * @exception none
     */
    protected function _getAllModels()
    {
        $modelmanagerPopo   = HObject::loadPopoClass('modelmanager');
        $this->_db->getSql()
            ->table($modelmanagerPopo->get('table'))
            ->fields(array(
                'name',
                'en_name',
                'pass'
            ));

        return $this->_db->select()->getList();
    }

    /**
     * 得到模块的详细状态 
     * 
     * @desc
     * 
     * @access protected
     * @param $modelName
     * @return array 
     * @exception none
     */
    protected function _getModelDetailStatus($modelName)
    {
        $modelPopo  = HObject::loadPopoClass($modelName);
        $this->_db->getSql()
            ->table($modelPopo->get('table'))
            ->fields('count(*) as total')
            ->where('`pass`=\'是\'');
        $totalInfo    = $this->_db->select()->getRecord();
        $modelStatus['pass']    = $totalInfo['total'];
        $this->_db->getSql()
            ->table($modelPopo->get('table'))
            ->fields('count(*) as total')
            ->where('`pass`!=\'是\'');
        $totalInfo    = $this->_db->select()->getRecord();
        $modelStatus['unpass']    = $totalInfo['total'];

        return $modelStatus;
    }

}

?>
