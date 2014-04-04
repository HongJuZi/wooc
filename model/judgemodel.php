<?php 

/**
 * @version			$Id$
 * @create 			2013-11-07 01:11:15 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('model.BaseModel');

/**
 * 评论模块 
 * 
 * 自动生成模块对应的类及数据库表,实现简单的CURD功能 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		model
 * @since 			1.0.0
 */
class JudgeModel extends BaseModel
{

    /**
     * 得到赞或弹弱的记录
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  int $userId 用户ID
     * @param  int $itemId 信息ID
     * @param  String $model 模块E名称
     * @param  String $wehre option条件
     * @return Array | null
     */
    public function getJudgeRecord($userId, $itemId, $model, $where)
    {
        return $this->getRecordByWhere(
            '`parent_id` = ' . $userId 
            . ' AND `item_id` = ' . $itemId
            . ' AND `model` = \'' . $model . '\''
            . ' AND ' . $where
        );
    }

}

?>
