<?php

/**
 * @version			$Id: HModel.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-4-7 17:30:58 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

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
     * @var String $mustWhereMap 必须包括的条件
     */
    protected $_mustWhereMap;

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
        $this->_mustWhereMap    = null;
        $this->_popo            = $popo;
        $this->_db              = HDbFactory::getDbDriver($this->_genDbConfig());
    }

    /**
     * 得生成数据库的配置信息 
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
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'))
            ->orderBy(HPopoHelper::getOrderFields($this->_popo))
            ->limit(1);
        
        return $this->_db->select()->getRecord();
    }

    /**
     * 得到单条记录 
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
     * 指定查询条件来查找对应的记录 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $fields 字段
     * @param  String $where 查找的条件
     * @return Array<String, Object> 查找到的记录集
     */
    public function getRecordByFields($fields, $where)
    {
        return $this->_getRecord($fields, $where);
    }

    /**
     * Model层内部使用的查到表记录列表的方法
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
    protected function _getList($fields, $where, $orderBy, $page, $perpage = 10, $groupBy = null)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'))
            ->groupBy($groupBy)
            ->orderBy($orderBy)
            ->limit($page, $perpage);

        return $this->_db->select()->getList();
    }

    /**
     * 通过指定字段来得到记录列表 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String | Array<String> $fields 需要查找的字段
     * @param  String String $where 需要查找的条件
     * @param  int $page 当前的页数
     * @param  int $perpage = 10 每页显示的记录条数
     * @return Array<Array<?, ?>
     */
    public function getListByFields($fields, $where = null, $page = 0, $perpage = 10)
    {
        return $this->_getList(
            $fields,
            $where,
            HPopoHelper::getOrderFields($this->_popo),
            $page,
            $perpage
        );
    }

    /**
     * 得到条件查询记录列表并限制页数及条数  
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
     *
     * @access public
     * @param  String | Array<String> $where 需要查找的条件
     * @param  String String $where 需要查找的条件
     * @param  Array $fields 需要查询的字段
     * @param  Array $orderBy 集合的排序方式
     * @param  int $page 当前的页数
     * @param  int $perpage = 10 每页显示的记录条数
     * @return Array<Array<?, ?>
     */
    public function getListByAll($where, $fields = null, $orderBy = null, $page = 0, $perpage = 10, $groupBy = null)
    {
        return $this->_getList($fields, $where, $orderBy, $page, $perpage, $groupBy);
    }

    /**
     * 得到记录列表并限制页数及条数  
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
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String | Array $fields 字段
     * @param  String $where 条件
     * @return Array 查找到的结果集
     */
    public function getAllRowsByFields($fields, $where , $orderBy = false)
    {
        $orderBy    = false === $orderBy ?  HPopoHelper::getOrderFields($this->_popo) : $orderBy; 

        return $this->_getAllRows( $fields, $where, $orderBy);
    }

    /**
     * Model层内部使用的得到所有的记录方法
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
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'))
            ->orderBy($orderBy);

        return $this->_db->select()->getList();
    }

    /**
     * 得到所有的记录，如果有条件则按对应的条件来 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $where 需要查找的记录集，默认为：空
     * @return Array<Array<?,?>> 查找到的记录集
     */
    public function getAllRows($where = '1 = 1')
    {
        return $this->_getAllRows(
            HPopoHelper::getShowFields($this->_popo),
            $where,
            HPopoHelper::getOrderFields($this->_popo)
        );
    }

    /**
     * 通过给定的order顺序显示信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $fields 给出的字段
     * @param $where 给出的条件信息
     * @param  $orderBy 给定的order信息
     * @return 查找到的结果集
     */
    public function getAllRowsByFieldsAndOrder($fields, $where, $orderBy)
    {
        return $this->_getAllRows( $fields, $where, $orderBy );
    }
    
    /**
     * 通过给定的order顺序显示信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $where 给出的条件信息
     * @param  $orderBy 给定的order信息
     * @return 查找到的结果集
     */
    public function getAllRowsByOrder($where, $orderBy)
    {
        return $this->_getAllRows(
            HPopoHelper::getShowFields($this->_popo),
            $where,
            $orderBy 
        );
    }

    /**
     * 按分组得到数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $where 条件
     * @param  $groupBy 分组
     * @param  $orderBy 排序
     * @return Array 结果
     */
    public function getAllRowsByGroup($where, $groupBy, $orderBy = null)
    {
        $orderBy    = !$orderBy ? HPopoHelper::getOrderFields($this->_popo) : $orderBy;
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields(HPopoHelper::getShowFields($this->_popo))
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'))
            ->groupBy($groupBy)
            ->orderBy($orderBy);

        return $this->_db->select()->getList();
    }

    /**
     * 数据层内部使用的只查看指定行数方法 
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
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'))
            ->orderBy($orderBy)
            ->limit($rows);

        return $this->_db->select()->getList();
    }

    /**
     * 得到指定的数据数量
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
     * @param  String $fields 指定的字段 
     * @param  String $where 指定的条件
     * @return Array 查出的结果集
     */
    public function getSomeRowsByFields($rows, $fields, $where)
    {
        return $this->_getSomeRows($fields, HPopoHelper::getOrderFields($this->_popo), $where, $rows);
    }

    /**
     * 查出指定的行，及指定字段 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $fields 指定的字段 
     * @param  String $where 指定的条件
     * @return Array 查出的结果集
     */
    public function getSomeRowsByAll($rows, $fields, $where, $oderBy)
    {
        return $this->_getSomeRows($fields, $orderBy, $where, $rows);
    }   

    /**
     * Model层内使用的总记录统计方法
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
            ->where(
                HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND')
            );
        $record     = $this->_db->select()->getRecord();

        return intval($record['total']);
    }
 
    /**
     * 得到模块的总记录数 
     * 
     * @access public
     * @param  String $where 需要统计的条件
     * @return int 得到的总记录数
     */
    public function getTotalRecords($where = '')
    {
        return $this->_getTotalRecords(
            'count(1) AS total', 
            HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND')
        );
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
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'));

        return $this->_db->delete();
    }

    /**
     * 更新数据，内部使用
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
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'));

        return $this->_db->update();
    }

    /**
     * 添加方法内部使用
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  HPopo $popo 模块的配置对象
     * @param  Array $data 需要添加的数据
     * @param  Array $fields 需要添加的数据字段
     * @return int 影响的行数
     */
    protected function _add($popo, $data, $fields = '')
    {
        if(empty($fields)) {
            $fields = array_keys($data);
            $data   = array_values($data);
        }
        $this->_db->getSql()
            ->table($popo->get('table'))
            ->fields($fields)
            ->values($data);

        return $this->_db->add();
    }

    /**
     * 得到POPO模块配置对象
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
     * 重设当前的popo对象
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $popo 配置对象
     * @return 当前对象
     */
    public function setPopo($popo)
    {
        $this->_popo    = $popo;

        return $this;
    }

    /**
     * 同必要的条件合并
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return String 合并后的条件子句
     */
    protected function _getMustWhere()
    {
        return empty($this->_mustWhereMap) ? '' : implode(' ', $this->_mustWhereMap);
    }

    /**
     * 设置必要的条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $identifier 条件标识
     * @param  String $where 当前的条件信息
     * @return 当前的数据层操作对象
     */
    public function setMustWhere($identifier, $where)
    {
        $this->_mustWhereMap[$identifier]   = $where;

        return $this;
    }

    /**
     * 删除无用的必要条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $identifier 标识
     * @return 当前数据操作层
     */
    public function deleteMustWhere($identifier)
    {
        unset($this->_mustWhereMap[$identifier]);

        return $this;
    }

    /**
     * 快捷执行SQL语句方法
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $sql 需要执行的SQL语句
     * @return 结果集
     */
    public function query($sql)
    {
        return $this->_db->query($sql);
    }

    /**
     * 得到最大值的Max id，为了解决Limit N, prepage当N很大时的问题
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return Array 数据集
     */
    public function getMaxLimitId($fields, $where, $orderBy)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'))
            ->orderBy($orderBy)
            ->limit(1);

        return $this->_db->select()->getList();
    }

    /**
     * 设置需要操作的表名
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  $table 表名 
     * @return $this 当前数据模块
     */
    public function setTable($table)
    {
        $this->_popo->set('table', '#_' . $table);

        return $this;
    }

    /**
     * 减少某一个字段的值
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $field 字段
     * @param  $where 条件
     * @param  $sub = -1 当前减少的数值
     * @return int 影响的行数
     */
    public function incFieldByWhere($field, $where, $sub = 1)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($field)
            ->values('`' . $field . '` + ' . $sub)
            ->where(HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND'));

        return $this->_db->update();
    }
    
    /**
     * 添加模块记录 
     * 
     * @access public
     * @param  Array $data 需要添加的数据
     * @param  Array $fields 需要添加的数据字段
     * @return int 影响行数
     */
    public function add($data, $fields = '')
    {
        return $this->_add($this->_popo, $data, $fields);
    }

    /**
     * 编辑数据 
     * 
     * @access public
     */
    public function edit($data)
    {
        return $this->_edit($data, '`id` =' . $data['id']);
    }

    /**
     * 指定需要编辑的条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  array $data 需要更新的字段数据
     * @param  String $where 更新执行条件
     * @return int 影响的行数
     */
    public function editByWhere($data, $where)
    {
        return $this->_edit($data, $where);
    }

    /**
     * 删除给定的Id记录 
     * 
     * @access public
     * @param int $id 记录Id
     * @return int 影响行数
     */
    public function delete($id)
    {
        return $this->_delete('`id`=' . $id, $this->_popo);
    }

    /**
     * 指定的刪除條件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $where 刪除條件
     * @return int 影響的行數
     */
    public function deleteByWhere($where)
    {
        return $this->_delete($where, $this->_popo);
    }

    /**
     * 批量添加
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $fields 字段
     * @param  $data 数据
     * @return int 影响行数 
     */
    public function addMore($fields, $data)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields($fields)
            ->values($data);

        return $this->_db->add();
    }

    /**
     * 得到字段的总和
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  $field 字段
     * @param  $where 条件
     * @return float
     */
    public function getSum($field, $where)
    {
        $this->_db->getSql()
            ->table($this->_popo->get('table'))
            ->fields('SUM(`' . $field . '`) as sum')
            ->where(
                HSqlHelper::mergeWhere(array($this->_getMustWhere(), $where), 'AND')
            );
        $record     = $this->_db->select()->getRecord();

        return intval($record['sum']);
    }

    /**
     * 得到数据库里所有的表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $dbName 数据库名
     * @return Array 数组
     */
    public function getTables($dbName)
    {
        $this->_db->query('SHOW TABLES FROM `' . $dbName . '`');

        return $this->_db->getList();
    }

}
?>
