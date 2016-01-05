<?php 

/**
 * @version $Id$
 * @create 2013-4-14 21:17:19 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die('Restricted access!');

/**
 * SQL语句帮手类 
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.utils 
 * @since 1.0.0
 */
class HSqlHelper extends HObject
{
 
    /**
     * WhereIn条件子句 
     * 
     * 用法：
     * <code>
     *  HArray::whereInByListMap('field', 'extractField', $list);    
     *  // $list   = array(array('user_id' => '12212', 'user_name' => 'xjiujiu'));
     * </code>
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $field 条件字段
     * @param  String $extractField 需要提取的字段
     * @param  array $list 数据集
     * @return String 组合后的条件句
     */
    public static function whereInByListMap($field, $extractField, array $list)
    {
        if(empty($list) || 1 > count($list)) {
            return '1 = 2';
        }
        $whereIn   = '';
        foreach($list as $data) {
            if(isset($data[$extractField]) && !empty($data[$extractField])) {
                $whereIn   .= ',\'' . $data[$extractField] . '\''; 
            }
        }
        if(!$whereIn) {
            return '1 = 2';
        }
        $whereIn{0}     = ' ';
        if(empty($whereIn)) {
            return '';
        }
        if(false !== strpos($field, '`')) {
            return $field . ' IN ('. $whereIn . ' )';
        }

        return  '`' . $field . '` IN ('. $whereIn . ' )';
    }

    /**
    *   同以上方法，二维数组 换成 索引数组
    **/
    public static function whereInByArray($field, array $list)
    {
        if(empty($list) || 1 > count($list)) {
            return '1 = 2';
        }
        $whereIn   = '';
        for ($i=0; $i < count($list); $i++) { 
            if(!empty($list[$i]) ){
                $whereIn   .= ',\'' . $list[$i] . '\''; 
            }
        }
        if(!$whereIn) {
            return '1 = 2';
        }
        $whereIn{0}     = ' ';

        return empty($whereIn) ? '' : '`' . $field . '` IN ('. $whereIn . ' )';
    }

    /**
     * 字段在所有的数据集中 
     * 
     * Example:
     * <code>
     *  HSqlHelper::whereIn('field', array(1, 2, 3, 4, 5));
     * </code>
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $field 条件字段
     * @param  Array $data 数据数组
     * @return String 组合后的WhereIn 子句 
     */
    public static function whereIn($field, $data)
    {
        return '`' . $field . '` IN (\'' . implode('\', \'', array_unique($data)) . '\')';
    }

    /**
     * 得到FIND_IN_SET字符串
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  $field 字段
     * @param  $attr 列表里的字段
     * @param  $list 列表
     * @return 得到FIND_IN_SET字符串
     */
    public static function findInSetByListMap($field, $attr, $list)
    {
        if(empty($list)) {
            return null;
        }
        $findInSet  = '';
        foreach($list as $item) {
            $findInSet  .= ',' . $item[$attr];
        }
        if($findInSet) {
            $findInSet{0}   = ' ';
        }

        return empty($list) ? null : ' FIND_IN_SET (`' . $field . '`, \'' . $findInSet . '\')';
    }

    /**
     * WhereNotIn
     * 
     * 用法：
     * <code>
     *  HSqlHelper::whereNotIn('id', array(1, 2, 3, 4, 5)); //return `id` NOT IN(1, 2, 3, 4, 5)
     * </code>
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return String 组合后的条件子句
     */
    public static function whereNotIn($field, $data)
    {
        return '`' . $field . '` NOT IN (\'' . implode('\', \'', array_unique($data)) . '\')';
    }

    /**
     * 重载得到WhereNotIn条件句
     *  
     * @description 用法 ：
     * <code>
     *  HHArray::whereNotInByListMap(
         *  "id",
         *  "user_id",
         *  array(array('user_id' => '99', 'user_name' => 'xjiujiu'))
     *  ); 
     * </code>
     * 
     * @title whereNotInByListMap
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @param  String field 条件字段 
     * @param  List<?> ids 当前的条件值集合
     * @return String 生成的条件语句
     */
    public static function whereNotInByListMap($field, $extractField, array $list)
    {
        foreach($list as $map) {
            $whereNotIn .= ',\'' . $map[$extractField] . '\'';
        }
        $whereNotIn{0}    = ' ';
        
        return '`' . $field . '` NOT IN (' . $whereNotIn . ')';
    }

    /**
     * 通过List<Map>的方式来生成对应的WhereOr语句
     *  
     * @description
     * 
     * @title whereOr
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @param  String $field 当前的字段名
     * @param  List<Map> $list 数据集
     * @return String 生成的结果where or 语句
     */
    public static function whereOr($field, $list)
    {
        return '`' . $field . '`=\'' . implode('\' OR `' . $field . '`=\'', $list) . '\'';
    }

    /**
     * 通过List<Map>的方式来生成对应的WhereOr语句
     *  
     * @description
     * 
     * @title whereOrByListMap
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @param  String $field 当前的字段名
     * @param  String $extractField 当前的字段名
     * @param  List<Map> $list 数据集
     * @return String 生成的结果where or 语句
     */
    public static function whereOrByListMap($field, $extractField, $list)
    {
        $whereOr        = '1 = 2';
        foreach($list as $map) {
            $whereOr    .= ' OR `' . $field . '` = \'' . $map[$extractField] . '\'';
        }

        return $whereOr;
    }

    /**
     * 得到LIKE模糊查询条件子句
     *  
     * @description
     * 
     * @title likeOrByRule
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @param  String $field 当前的字段
     * @param  String $list 当前的可能值
     * @param  String $splitCh 前后连接的字符串
     * @return String 组合成的条件句
     */
    public static function likeOrByRule($field, $list, $splitCh = '')
    {
        foreach(split($splitCh, $list) as $item) {
            $whereLike  .= '`' . $field . '` LIKE \'%' . $splitCh . $item . $splitCh . '%\' OR ';
        }
    
        return $whereLike . '1 = 2';
    }

    /**
     * 得到LIKE模糊查询条件子句
     *  
     * @description
     * 
     * @title likeOr
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @param  String $field 当前的字段
     * @param  String $list 当前的可能值
     * @return String 组合成的条件句
     */
    public static function likeOr($field, $list)
    {
        return '`' . $field . '` LIKE \'%' . implode('%\' OR `' . $field . '` LIKE \'%', $list) . '%\'';
    }

    /**
     * 得到LIKE模糊查询条件子句
     *  
     * @description
     * 
     * @title likeOrByListMap
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @param  String $field 当前的字段
     * @param  String $list 当前的可能值
     * @return String 组合成的条件句
     */
    public static function likeOrByListMap($field, $extractField, $list)
    {
        foreach($list as $map) {
            $likeOr     .= '`' . $field . '` LIKE \'%' . $map[$extractField] . '%\' OR ';
        }

        return $likeOr . ' 1 = 2';
    }

    /**
     * 合并多个where条件子句 
     * 
     * Example:
     * <code>
     * HSqlHelper::mergeWhere(
     * array(1 = 2','2 = 3'),
     * 'and'
     * ); //1 = 2 and 2 = 3
     * </code>
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  Array $wheres 条件子句们
     * @param  String $method 合并的条件默认为空格
     * @return String 合并后的条件子句
     */
    public static function mergeWhere($wheres, $method = ' ')
    {
        $where      = 'AND' == $method ? '1 = 1 ' : '1 = 2 ';
        if(HVerify::isEmpty($wheres))
        	return $where;
        $method     = strtoupper($method);
        foreach(array_filter($wheres) as $item) {
            $where  .=  $method . ' (' . $item . ') ';
        }

        return $where;
    }

}

?>
