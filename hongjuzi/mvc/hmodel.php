<?php

/**
 * @version			$Id: HModel.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-4-7 17:30:58 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die();

//导入数据库实例工厂
HClass::import('hongjuzi.database.HDbFactory');

/**
 * 模块蕨类 
 * 
 * 给用户自定义的模块类作一个公用部份的提取 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.core
 * @since 			1.0.0
 */
class HModel extends HObject
{

    /**
     * @var String $mustWhere 必须包括的条件
     */
    public static $mustWhere    = null;

    /**
     * @var IDatabase $_db 数据库驱动实例
     */
    protected $_db;

    /**
     * @var HPopo $_popo 模块的Popo对象
     */
    protected $_popo;

    /**
     * @var HModel $_model 模块对象
     */
    protected $_model;

    /**
     * 构造函数
     * 
     * 初始化对应的类变量 
     * 
     * @access public
     */
    public function __construct($popo = null)
    {
        $this->_popo        = $popo;
        $this->_db          = HDbFactory::getDbDriver($this->_genDbConfig());
    }

    /**
     * 得生成数据库的配置信息 
     * 
     * @desc
     * 
     * @access protected
     * @return object 
     */
    protected function _genDbConfig()
    {
        return (object)HObject::GC('DATABASE');
    }

    /**
     * Model 层内部使用的查找单个记录信息方法
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $fields 需要查找的字段
     * @param  String $where 查询的条件
     * @return Array<String, Object> 查找到的记录集
     */
    protected function _getRecord($fields, $where)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where($this->_mergeMustWhere($where))
            ->limit(1);
        
        return $this->_db->select()->getRecord();
    }

    /**
     * 得到单条记录 
     * 
     * @desc
     * 
     * @access public
     * @param int $id 记录id
     * @return array 查找到的结果集
     */
    public function getRecordById($id)
    {
        return $this->_getRecord('*', '`id`=\'' . $id . '\'');
    }

    /**
     * 指定查询条件来查找对应的记录 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $where 查找的条件
     * @return Array<String, Object> 查找到的记录集
     */
    public function getRecordByWhere($where)
    {
        return $this->_getRecord('*', $where);
    }

    /**
     * Model层内部使用的查到表记录列表的方法
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String | Array<String> $fields 需要查找的字段
     * @param  String String $where 需要查找的条件
     * @param  String $orderBy 需要排序的字段
     * @param  int $page 当前的页数
     * @param  int $perpage = 10 每页显示的记录条数
     * @return Array<Array<?, ?>
     */
    protected function _getList($fields, $where, $orderBy, $page, $perpage = 10)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where($this->_mergeMustWhere($where))
            ->orderBy($orderBy)
            ->limit($page, $perpage);

        return $this->_db->select()->getList();
    }

    /**
     * 通过指定字段来得到记录列表 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String | Array<String> $fields 需要查找的字段
     * @param  String String $where 需要查找的条件
     * @param  int $page 当前的页数
     * @param  int $perpage = 10 每页显示的记录条数
     * @return Array<Array<?, ?>
     */
    public function getListByFields($fields, $page = 0, $perpage = 10)
    {
        return $this->_getList(
            $fields,
            null,
            HPopoHelper::getOrderFields($this->_popo),
            $page,
            $perpage
        );
    }

    /**
     * 得到条件查询记录列表并限制页数及条数  
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String | Array<String> $where 需要查找的条件
     * @param  String String $where 需要查找的条件
     * @param  int $page 当前的页数
     * @param  int $perpage = 10 每页显示的记录条数
     * @return Array<Array<?, ?>
     */
    public function getListByWhere($where, $page = 0, $perpage = 10)
    {
        return $this->_getList(
            HPopoHelper::getShowFields($this->_popo),
            $where,
            HPopoHelper::getOrderFields($this->_popo),
            $page,
            $perpage
        );
    }
    
    /**
     * 查询记录集合，并分页
     * @access public
     * @param  String | Array<String> $where 需要查找的条件
     * @param  String String $where 需要查找的条件
     * @param  Array $fields 需要查询的字段
     * @param  Array $orderBy 集合的排序方式
     * @param  int $page 当前的页数
     * @param  int $perpage = 10 每页显示的记录条数
     * @return Array<Array<?, ?>
     */
    public function getListByThree($where, $fields = null,$orderBy = null,$page = 0, $perpage = 10)
    {
        if(empty($fields)) { 
            $fields = HPopoHelper::getShowFields($this->_popo);
        }
        if(empty($orderBy)) {
            $orderBy = HPopoHelper::getOrderFields($this->_popo);
        }

        return $this->_getList($fields, $where, $orderBy, $page, $perpage);
    }

    /**
     * 得到记录列表并限制页数及条数  
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String | Array<String> $fields 需要查找的字段
     * @param  int $page 当前的页数
     * @param  int $perpage = 10 每页显示的记录条数
     * @return Array<Array<?, ?>
     */
    public function getList($page = 0, $perpage = 10)
    {
        return $this->_getList(
            HPopoHelper::getShowFields($this->_popo),
            '',
            HPopoHelper::getOrderFields($this->_popo),
            $page,
            $perpage
        );
    } 

    /**
     * 根据指定的字段查找所有满足条件的行
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String | Array $fields 字段
     * @param  String $where 条件
     * @return Array 查找到的结果集
     */
    public function getAllRowsByFields($fields, $where)
    {
        return $this->_getAllRows(
            $fields,
            $where,
            HPopoHelper::getOrderFields($this->_popo)
        );
    }

    /**
     * Model层内部使用的得到所有的记录方法
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String | Array<String> $fields 需要查找的字段
     * @param  String $where 查找的条件 
     * @param  String $orderBy 当前排序的方式
     * @return Array<Array<?, ?>  查找到的结果集
     */
    public function _getAllRows($fields, $where, $orderBy = null)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where($this->_mergeMustWhere($where))
            ->orderBy($orderBy);

        return $this->_db->select()->getList();
    }

    /**
     * 得到所有的记录，如果有条件则按对应的条件来 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $where 需要查找的记录集，默认为：空
     * @return Array<Array<?,?>> 查找到的记录集
     */
    public function getAllRows($where = '')
    {
        return $this->_getAllRows(
            HPopoHelper::getShowFields($this->_popo),
            $where,
            HPopoHelper::getOrderFields($this->_popo)
        );
    }

    /**
     * 数据层内部使用的只查看指定行数方法 
     * 
     * @desc
     * 
     * @access protected
     * @param  String | Array $fields 需要查看的字段信息
     * @param  String $orderBy 排序信息
     * @param  String $where 需要查找的条件
     * @param  int $rows 指定需要的行数
     * @return 查找到的结果集
     */
    protected function _getSomeRows($fields, $orderBy, $where, $rows)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where($this->_mergeMustWhere($where))
            ->orderBy($orderBy)
            ->limit($rows);

        return $this->_db->select()->getList();
    }

    /**
     * 得到指定的数据数量
     * 
     * @desc
     * 
     * @access public
     * @return Array 查找到的数据集合
     */
    public function getSomeRows($rows, $where = '')
    {
        return $this->_getSomeRows(
            HPopoHelper::getShowFields($this->_popo),
            HPopoHelper::getOrderFields($this->_popo),
            $where,
            $rows
        );
    }

    /**
     * 查出指定的行，及指定字段 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  int $rows 指定的行数
     * @param  String $fields 指定的字段 
     * @param  String $where 指定的条件
     * @return Array 查出的结果集
     */
    public function getSomeRowsByFields($rows, $fields, $where)
    {
        return $this->_getSomeRows($fields, HPopoHelper::getOrderFields($this->_popo), $where, $rows);
    }

    /**
     * Model层内使用的总记录统计方法
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $fields 需要统计的字段
     * @param  String $where 搜索关键字,默认值：''
     * @return int 查找到的总记录条数
     */
    protected function _getTotalRecords($fields, $where ='')
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where($this->_mergeMustWhere($where));
        $record     = $this->_db->select()->getRecord();

        return intval($record['total']);
    }
 
    /**
     * 得到模块的总记录数 
     * 
     * @desc
     * 
     * @access public
     * @param  String $where 需要统计的条件
     * @return int 得到的总记录数
     */
    public function getTotalRecords($where = '')
    {
        return $this->_getTotalRecords('count(*) AS total', $this->_mergeMustWhere($where));
    }

    /**
     * 得到最后添加记录的ID
     * 
     * 系统最后执行的一条insert的ID返回值 
     * 
     * @access public
     * @return int | null 
     * @exception none
     */
    public function getLastInsertId()
    {
        return $this->_db->getLastInsertId();
    }

    /**
     * 内部使用，删除记录的
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $id 指定id
     * @param  HPopo $popo 当前对象的配置对象
     * @return 影响的行数
     */
    protected function _delete($where, $popo)
    {
        $this->_db->getSql()
            ->table($popo->get('table'))
            ->where($this->_mergeMustWhere($where));

        return $this->_db->delete();
    }

    /**
     * 更新数据，内部使用
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  HPopo $popo 当前模块的配置对象
     * @param  Array $record 当前的记录
     * @return int 影响的行数
     */
    public function _edit($data, $where)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields(array_keys($data))
            ->values(array_values($data))
            ->where($this->_mergeMustWhere($where))
            ->limit(1);

        return $this->_db->update();
    }

    /**
     * 得到POPO模块配置对象
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return HPopo模块配置对象 
     */
    public function getPopo()
    {
        return $this->_popo;
    }

    /**
     * 同必要的条件合并
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return String 合并后的条件子句
     */
    protected function _mergeMustWhere($where)
    {
        $mustWheres     = array();
        foreach(HModel::$mustWhere as $field => $mWhere) {
            if($this->_popo->hasField($field)) {
                $mustWheres[]   = $mWhere;
            }
        }
        if(empty($mustWheres)) {
            return $where;
        }
        if(!is_array($where)) {
            $mustWheres[]   = $where;
            return HSqlHelper::mergeWhere($mustWheres, 'AND');
        }

        return HSqlHelper::mergeWhere(array_merge($where, $mustWheres), 'AND');
    }

}
?>
