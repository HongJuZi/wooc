<?php 

/**
 * @version $Id$
 * @create 2012-10-21 18:13:50 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die();

/**
 * Popo模块配置对象的助手类 
 * 
 * 如：得到模块添加的字段及值、更新的字段及值等等 
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.utils 
 * @since 1.0.0
 */
class HPopoHelper extends HObject
{

    /**
     * 得到添加的字段KV值 
     * 
     * 用法：
     * <code>
     *  HPopoHelper::getAddFieldsAndValues(new UserPopo());
     * </code>
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  Object &$popo 当前POPO对象的引用
     * @return array 过滤后的数组
     */
    public static function getAddFieldsAndValues(&$popo)
    {
        $addData    = array();
        foreach($popo->get('fields') as $field => $configItem ) {
            if(!HVerify::isEmptyNotZero(HRequest::getParameter($field))) {
                $addData[$field]    = HRequest::getParameter($field);
                continue;
            }
            //TODO::这个需要吗？
            //设置成系统的默认值
            $addData[$field]        = $configItem['default'];
        }

        return $addData;
    }

    /**
     * 得到更新时的字段及值键对 
     * 
     * 用法：
     * <code>
     *  HPopoHelper::getUpdateFieldsAndValues(new UserPopo());
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  HPopo &popo POPO 对象
     * @param  Boolean $isJustRequest 是否只是提交当前请求的字段，默认为 false
     * @return array  过滤后的数组
     */
    public function getUpdateFieldsAndValues(&$popo)
    {
        $updateData     = array();
        foreach($popo->get('fields') as $field => $configItem ) {
            //去掉当前没有提交过来的数据，如：password可以留空，图片路径不更新可以是空
            if(null === HRequest::getParameter($field)) {
                continue;
            }
            if(!HVerify::isEmptyNotZero(HRequest::getParameter($field))) {
                $updateData[$field]     = HRequest::getParameter($field);
               continue;
            }
            $updateData[$field]         = $configItem['default'];
        }
        
        return $updateData;
    }

    /**
     * 得到显示的字段中文名称 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param &$popo
     * @return Array<String, String> 得到的显示字段名称
     */
    public static function getShowFieldNames(&$popo)
    {
        return self::_getFields($popo, 'is_show', 'name');
    }

    /**
     * 得到显示的字段
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param &$popo
     * @return Array<String, String> 得到的显示字段
     */
    public static function getShowFieldsAndCfg(&$popo)
    {
        return self::_getFields($popo, 'is_show', 'cfg');
    }

    /**
     * 得到显示到管理列表中的字段 
     * 
     * 根据用户配置的字段信息得到要显示的字段 
     * 
     * @access public static 
     * @param  HPopo $popo 模块的配置对象
     * @return array 过滤后得到的搜索字段*
     */
    public static function getShowFields(&$popo)
    {
        return self::_getFields($popo, 'is_show');
    }

    /**
     * 得到外部链接需要显示的字段
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param &$popo
     * @return Array <String> 过滤后得到的显示字段 
     */
    public static function getLinkFields(&$popo)
    {
        return self::_getFields($popo, 'is_link');
    }

    /**
     * 得到排序字段 
     * 
     * @desc
     * 
     * @access public static 
     * @param  HPopo $popo 模块的配置对象
     * @return array 过滤后得到的搜索字段*
     */
    public static function getOrderFields(&$popo)
    {
        $orderFields    = self::_getFields($popo, 'is_order', 'is_order');
        if(!isset($orderFields['top'])) {
            return $orderFields;
        }
        $method     = $orderFields['top'];
        unset($orderFields['top']);

        return array_merge(array('top' => $method), $orderFields);
    }

    /**
     * 得到配置的搜索字段 
     * 
     * 用法：
     * <code>
     * HPopoHelper::getSearchFields(new UserPopo());
     * </code> 
     * 
     * @access protected
     * @param  HPopo $popo 模块的配置对象
     * @return array 过滤后得到的搜索字段
     */
    public static function getSearchFields($popo)
    {
        return self::_getFields($popo, 'is_search');
    }

    /**
     * 得到配置的文件字段 
     * 
     * 用法：
     * <code>
     * HPopoHelper::getFileFields(new UserPopo());
     * </code> 
     * 
     * @access protected
     * @param  HPopo $popo 模块的配置对象
     * @return array 过滤后得到的文件字段
     */
    public static function getFileFields($popo)
    {
        return self::_getFields($popo, 'is_file', 'cfg');
    }

    /**
     * 得到批量处理的字段
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  HPopo $popo 模块配置对象
     * @return Array 当前可以进行批量操作的字段集合
     */
    public static function getMoreFields($popo)
    {
        return self::_getFields($popo, 'is_more', 'cfg');
    }

    /**
     * POPO工具类内部使用得到配置的字段 
     * 
     * 用法：
     * <code>
     * HPopoHelper::_getFields(new UserPopo());
     * </code> 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     * @param  HPopo $popo 当前模块的配置对象
     * @param  String $mask 标记值
     * @param  String $attr 默认为：当前的字段-'field', 'cfg'  为得到字段的配置
     * @return array 过滤后得到的搜索字段
     */
    protected static function _getFields($popo, $mask, $attr = null)
    {
        $data   = array();
        foreach($popo->get('fields') as $field => $fieldCfg) {
            if(isset($fieldCfg[$mask]) && !empty($fieldCfg[$mask])) {
                if(null !== $attr && isset($fieldCfg[$attr])) {
                    $data[$field]  = $fieldCfg[$attr];
                    continue;
                }
                if('cfg' == $attr) {
                    $data[$field]  = $fieldCfg;
                    continue;
                }
                $data[]  = $field;
            }
        }

        return $data;
    }

}
?>
