<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die();

/**
 * 类工具文件
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.filePathsystem
 * @since 1.0.0
 */
class HClass extends HObject
{

    /**
     * @var private static $_classes 类寄存器
     */
    private static $_classes    = array();

    /**
     * @var Array $_filesMap 文件导入容器
     */
    private static $_filesMap   = array();

    /**
     * 导入类文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $filePath 类文件路径
     * @param  Boolean $isStrtolower 是否转换成小写，默认为：true
     * @return Object 实例化对象 
     */
    public static function import($classes, $isStrtolower = true)
    {
        $classSet   = explode(',', true === $isStrtolower ? strtolower($classes) : $classes);
        foreach($classSet as $filePath) {
            $filePath   = trim($filePath);
            if(empty($filePath)) {
                continue;
            }
            $key        = md5($filePath);
            if(isset(self::$_filesMap[$key])) {
                continue;
            }
            $filePath   = ROOT_DIR . self::_formatClassPath($filePath);
            if(!file_exists($filePath)) {
                throw new HIOException('文件不存在！' . $filePath);
            }
            self::$_filesMap[$key]  = $filePath;
            require($filePath);
        }
    }

    /**
     * 格式化文件路径 
     * 
     * 把 点 换成 系统的目录分隔符,如果文件文件中有点，请用“..”如：“HClass..loader.php”
     *
     * @access private
     * @param string $filePath 未格式化的文件
     * @return string 格式化后的文件
     */
    private static function _formatClassPath($filePath)
    {
        $filePath   = strtr($filePath, array('.' => DS)) . '.php';

        return strtr($filePath, array(DS . DS => '.'));
    }

    /**
     * 快速加载模块对象
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $model 模块英语名称
     * @return HModel 模块数据层操作对象
     */
    public static function quickLoadPopo($model)
    {
        return self::_loadClass('config.popo', $model . 'Popo');
    }

    /**
     * 快速加载模块对象
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $model 模块英语名称
     * @return HModel 模块数据层操作对象
     */
    public static function quickLoadModel($model)
    {
        $obj  = self::_loadClass('model', $model . 'Model');

        return $obj->set('popo', self::_loadClass('config.popo', $model . 'Popo'));
    }

    /**
     * 加载模块对象 
     * 
     * 根据用户传进来的模块名称来得到真正的模块对应的popo, model文件导入类
     * 
     * @access public
     * @param string $model 模块的英文名称
     * @param string $app 应用的名称,默认为：admin
     * @return HModel  模块操作对象
     * @exception none
     */
    public static function loadModelClass($model)
    {
        return self::_loadClass('model', $model . 'Model');
    }

    /**
     * 得到模块Popo对象 
     * 
     * 根据当前的模块名称得到对应模块的Popo对象 
     * 
     * @access public
     * @param string $model 当前的Popo所属模块名
     * @return HPopo 当前的Popo对象
     * @exception none
     */
    public static function loadPopoClass($model)
    {
        return self::_loadClass('config.popo', $model . 'Popo');
    }

    /**
     * 加载类 
     * 
     * 对当前的加载类路径及类名进行加载及实例化 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     * @param String $classDir 当前的类目录
     * @param String $class 当前的类名
     * @return HObject 当前的实例化类对象 
     */
    protected static function _loadClass($classDir, $class)
    {
        $classPath      = strtolower($classDir . '.' . $class);
        $key            = md5($classPath); 
        if(!isset(self::$_classes[$key])) {
            self::import($classPath);
            $obj        = new $class;
            self::$_classes[$key] = $obj;
        }

        return self::$_classes[$key];
    }

}

?>
