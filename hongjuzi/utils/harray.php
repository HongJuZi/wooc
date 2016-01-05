<?php

/**
 * @version			$Id: harray.php 1889 2012-05-20 06:47:59Z xjiujiu $
 * @create 			2012-3-4 12:23:57 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		utils
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * @point
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.utils
 * @since 			1.0.0
 */
class HArray
{

    /**
     * 将Array转换成字符串 
     * 
     * 结合给定的前缀，中间串，后缀，把数组连成字符串 
     * 
     * @access public static
     * @param string | array $srcArr
     * @param string $pre 连接前缀 默认为 ''
     * @param string $mid 连接中间字串 默认为 ''
     * @param string $last 连接后缀 默认为 ''
     * @return string 
     * @exception none
     */
    public static function arrayToString($srcArr, $pre = '', $mid = '', $last = '')
    {
        if(is_array($srcArr)) {
            return $pre .
                   implode($mid, $srcArr) .
                   $last;
        }
        return $srcArr;
    }

    /**
     * 提取数组里指定的所有键值 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  array | null $data 当前的数据项, 需要是二维数组
     * @param  String $extractField 需要提取的元素键值
     * @param  String $subItemField 子元素的键值 
     * @param  Boolean $override 是否覆盖原来的值 ,默认为false
     * @return array 当前数组里存储的值
     * @throws none
     */
    public static function extractElement(array $data, $extractField, $subItemField = '', $override = false)
    {
        $fields  = array();
        foreach($data as $array) {
            if(empty($array)) {
                continue;
            }
            if(isset($array[$extractField])) {
                if($override == false || !in_array($array[$extractField], $fields)) {
                    $fields[]   = $array[$extractField];
                }
            }
            if(!HVerify::isEmptyNotZero($subItemField) && is_array($array[$subItemField])) {
                foreach($array[$subItemField] as $item) {
                    $value  = self::_extractElement($item, $extractField, $subItemField);
                    if($override == false || !in_array($value, $fields)) {
                        $fields[]   = $value;
                    }
                }
            }
        }

        return $fields;
    }

    /**
     * 提取当前数组中的所有子项里的元素 
     * 
     * 得到所有指定数组里的元素
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     * @param  array | null $item 当前的数据项
     * @param  String $extractField 需要提取的元素键值
     * @param  String $subItemField 子元素的键值 
     * @return Object 当前数组里存储的值 
     * @throws none
     */
    protected static function _extractElement(&$item, $extractField, $subItemField)
    {
        if(isset($item[$subItemField]) && !is_array($item[$subItemField])) {
            self::_extractElement($item[$subItemField]);
        }

        return $item[$extractField];
    }

    /**
     * 转换当前的元素值作为当前数组元素的KEY值 
     * 
     * 用法：
     * <code>
     *  $arr    = array(array('a', '1'), array('b', '2')); //测试数组
     *  $arr    = HArray::turnItemValueAsKey($arr, 0); 
     *  var_dump($arr);                                    // array('a' => array('a', '1'), 'b'=> array('b', '2'));
 ;    * </code> 
     * 注意：它对于重复的KEY将会自动覆盖
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  Array $arraa需要处理的数组
     * @param  mix $key 值对应的键
     * @return array 
     * @throws none
     */
    public static function turnItemValueAsKey(&$array, $key)
    {
        $arrTemp    = array();
        foreach($array as $item) {
            $arrTemp[$item[$key]]   = $item;
        }

        return $arrTemp;
    }

    /**
     * 合并二维数组
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  Array $arr1 数组一
     * @param  Array $arr2 数组二
     * @return Array 需要合并的数组
     */
    public static function merge($arr1, $arr2)
    {
        if(empty($arr1) || !is_array($arr1)) {
            return $arr2;
        }
        if(empty($arr2) || !is_array($arr2)) {
            return $arr1;
        }
        if(count($arr1) > count($arr2)) {
            foreach($arr1 as $key => $ele) {
                $arr1[$key]     = array_merge($ele, $arr2[$key]);
            }

            return $arr1;
        }

        foreach($arr2 as $key => $ele) {
            $arr2[$key]     = array_merge($ele, $arr1[$key]);
        }

        return $arr2;
    }
    
    /**
     * 通过List<Map>来生成合法的ZTree数据
     * 
     * Example:
     * <code>
     *  HArray::makeZtreeJsonByListMap(array(array('id' => '123', 'name' => '小明'))); 
     *  // return json: {[id: 123, name: '小明']}
     * </code>
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $list Array 需要处理的数据集
     * @param $map 需要提取的字段
     * @param $isParent 是否为父级
     * @return String 格式化后的JSON数据
     */
    public static function makeZtreeJsonByListMap($list, $map = null, $isParent = true)
    {
        if(empty($list)) {
            return '[]';
        }
        $json       = array();
        $isParent   = true === $isParent ? 'isParent: true' : '';
        if(null === $map) {
            foreach($list as $item) {
                $jsonItem   = array($isParent);
                foreach($item as $key => $value) {
                    array_push($jsonItem, $key . ': "' . $value . '"');
                }
                array_push($json, '{' . implode(',', $jsonItem) . '}');
            }
        } else {
            foreach($list as $item) {
                $jsonItem   = array($isParent);
                foreach($map as $attr => $field) {
                    array_push($jsonItem, $attr . ': "' . $item[$field] . '"');
                }
                array_push($json, '{' . implode(',', $jsonItem) . '}');
            }
        }
        
        return '[' . implode(',', $json) . ']';
    }

    /**
     * 转换Map成ListMap
     * 
     * 可以指定Key => value对应的键，如：
     * array(1 => 'test') => turnMapToListMap($map, $list, array('id', 'name'))
     * ====> array(array('id' => 1, 'name' => 'test'))
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     */
    public static function turnMapToListMap($map, $fields)
    {
        $list   = array();
        foreach($map as $key => $value) {
            $list[$key]     = array($fields[0] => $key, $fields[1] => $value);
        }

        return $list;
    }


    /**
     * 对二维数组排序
     * 
     * @desc
     * 
     * @author licheng
     * @access public static
     * @param  Array $arr 排序数组
     * @param  String $keys 排序字段
     * @param  String $type 排序方式：asc，desc
     * @return Array:返回排序好的数组
     */
    public static function arraySort($arr,$keys,$type = 'asc'){
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        $type == 'asc'?asort($keysvalue):arsort($keysvalue);
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }

}
?>
