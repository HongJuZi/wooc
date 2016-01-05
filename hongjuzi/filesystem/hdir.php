<?php 

/**
 * @version			$Id: hdir.php 2055 2012-08-05 07:29:50Z xjiujiu $
 * @create 			2012-3-15 10:07:46 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		filesystem
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 文件夹操作类 
 * 
 * 文件夹快捷操作方法封装 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.filesystem
 * @since 			1.0.0
 */
class HDir extends HObject
{

    /**
     * @var array $_dirHandles 文件夹操作句柄容器 
     */
    private static $_dirHandles     = array();
    
    /**
     * 创建文件夹 
     * 
     * 支持多文件夹数组 
     * 
     * @access public
     * @param string $dirPath 需要创建的文件夹, 默认为空
     * @param boolean $isCreateLevel 是否创建层级 默认为：true
     * @param String $mode 新建目录的权限，默认为0777
     * @exception HIOException 
     */
    public static function create($dirs, $isCreateLevel = true, $mode = 0777) 
    {
        if(!is_array($dirs)) {
            $dirs    = array($dirs);
        }
        foreach($dirs as $dir) {
            if(is_dir($dir)) {
                continue;
            }
            if($isCreateLevel) {
                $dir        = strtr($dir, array('\\' => '/'));
                $dirLevel   = explode('/', $dir);
                $dirPath    = '';
                foreach($dirLevel as $subDir) {
                    $dirPath    = self::_formatDirPath($dirPath . $subDir . DS);
                    if(!is_dir($dirPath)) {
                        $mask   = umask(0);
                        if(!mkdir($dirPath, $mode)) {
                            throw new HIOException($dirPath . '目录创建失败！');
                        }
                        @chmod($dirPath, $mode);
                        umask($mask);
                    }
                }
                continue;
            }
            $mask   = umask(0);
            if(!mkdir(self::_formatDirPath($dir), $mode)) {
                throw new HIOException($dir . '目录创建失败！');
            }
            @chmod($dirPath, $mode);
            umask($mask);
        }
    }

    /**
     * 得到文件夹里所有的文件夹 
     * 
     * 支持是否包括子文件夹 
     *
     * @param string $dirPath 需要处理的文件夹路径
     * @param boolean $includeSubDirs 是否包括当前文件夹的子文件夹
     * @access public
     * @return array  查找到的所有文件夹
     */
    public static function getDirs($dirPath = '', $includeSubDirs = false)
    {
        $dirs       = array();
        if(($dirHandle = self::_openDir($dirPath))) {
            while(false !== ($file = readdir($dirHandle))) {
                if(true === self::_isCurParentDir($file)) {
                    continue;
                }
                $filePath   = self::_formatDirPath($dirPath) . '/' . $file;
                if(!is_dir($filePath)) {
                    continue;
                }
                $dirs[]     = $dirPath . '/' . HString::formatEncodeFromOs($file);
                if(true === $includeSubDirs) {
                    $subDirs    = self::getDirs($filePath, true);
                    if(!empty($subDirs)) {
                        $dirs   = array_merge($dirs, $subDirs);
                    }
                }
            }
        }
    
        return $dirs;
    }

    /**
     * 得到文件夹中所有的文件 
     * 
     * 支持是否包括子文件夹 
     *
     * @param string $dirPath 要操作的文件夹路径，默认为空
     * @param boolean $includeSubDirs 是否包括子文件夹 
     * @param boolean $encodePath 是否给路径字符串转成程序的编码 
     * @access public
     * @return array 找到的所有文件
     * @exception none
     */
    public static function getFiles($dirPath = '', $includeSubDirs = false, $filter = null)
    {
        $files      = array();
        if(($dirHandle = self::_openDir($dirPath))) {
            while(false !== ($file = readdir($dirHandle))) {
                if(true === self::_isCurParentDir($file)) {
                    continue;
                }
                $file       = HString::formatEncodeFromOs($file);
                $filePath   = self::_formatDirPath($dirPath) . DS . $file;
                if(true === self::isDir($filePath) && true === $includeSubDirs) {
                    $files  = array_merge($files, self::getFiles($filePath, $includeSubDirs, $filter));
                    continue;
                }
                if(null === $filter || in_array(HFile::getExtension($file, ''), $filter)) {
                    $files[]    = $dirPath . DS . $file;
                }
            }
        }

        return $files;
    }

    /**
     * 检测是否为当前目录或是上一组目录标识 
     * 
     * 直接用的三元运算 
     *
     * @param string $item 当前的项目
     * @access protected
     * @return boolean 
     * @exception none
     */
    protected static function _isCurParentDir($item)
    {
        return ($item == '.') || ($item == '..') ? true : false;
    }

    /**
     * 得到当前目录里的所有资源
     * 
     * @desc
     * 
     * @access public
     * @param string $dirPath 操作的目录
     * @return array 
     * @exception none
     */
    public static function getCurrentDirsAndFiles($dirPath, $orderBy = 0)
    {
        return scandir(self::_formatDirPath($dirPath), $orderBy);
    }

    /**
     * 删除目录 
     * 
     * 包括目录下的所以内容 
     * 
     * @access public
     * @param string $dirPath 需要操作的目录路径，默认为空
     * @return void 
     * @exception HIOException
     */
    public static function delete($dirs = '')
    {
        if(!is_array($dirs)) {
            $dirs    = array($dirs);
        }
        foreach($dirs as $dirPath) {
            $dirs       = self::getDirs($dirPath, true);
            $files      = self::getFiles($dirPath, true);
            try {
                //删除所有的文件
                HFile::delete($files);
            } catch(HIOException $ex) {
                throw new HIOException($ex->getMessage());
            }
            //删除所有的文件
            foreach($dirs as $dir) {
                self::_closeDir($dir);
                if(file_exists($dir) && !unlink(self::_formatDirPath($dir))) {
                    throw new HIOException($dir . '删除目录失败！');
                }
            }
            self::_closeDir($dirPath);
            if(file_exists($dirPath) && !rmdir(self::_formatDirPath($dirPath))) {
                throw new HIOException($dirPath . '删除目录失败！');
            }
        }
    }

    /**
     * 复制文件夹内容 
     * 
     * @desc
     * 
     * @access public
     * @param string $dirPath 需要复制的文件夹
     * @return void 
     * @exception HIOException
     */
    public static function copy($src = '', $to)
    {
        $dirs       = self::getDirs($src, true);
        $files      = self::getFiles($src, true);
        $to         .= DS . self::_getLastDirName($src);
        $strtrMode  = array($src => $to);
        self::create($to);
        //复制文件夹
        foreach($dirs as $dir) {
            if(!mkdir(strtr($dir, $strtrMode))) {
                throw new HIOException($dir . '目录创建失败！');
            }
        }
        //复制文件
        foreach($files as $file) {
            if(!copy($file, strtr($file, $strtrMode))) {
                throw new HIOException($file . '复制失败！');
            }
        }
    }

    /**
     * 移动文件夹 
     * 
     * 类似于操作系统里的文件夹移动 
     * 
     * @access public static
     * @param string $src 源目录，默认为空
     * @param string $to 目标位置
     * @param boolean $autoCreateToDir 是否自动创建目标文件夹默认为：true
     * @return void
     * @exception none
     */
    public static function move($src = '', $to, $autoCreateToDir = true)
    {
        $dirs       = self::getDirs($src);
        $files      = self::getFiles($src);
        $to         .= DS . self::_getLastDirName($src);
        $strtrMode  = array($src => $to);
        if(true == $autoCreateToDir) {
            self::create($to);
        }
        foreach($files as $file) {
            if(!rename($file, strtr($file, $strtrMode))) {
                throw new IOException('无法移动' . $file . '，对象不存在!');
            }
        }

        self::delete($src);
    }

    /**
     * 得到目录名称 
     * 
     * 得到路径最后的文件夹名称 
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected static function _getLastDirName($dirPath)
    {
        $dirPath        = strtr($dirPath, array('\\' => DS));
        $levels         = explode(DS, $dirPath);
        $lastDirName    = array_pop($levels);
        if(empty($lastDirName)) {
            $lastDirName = array_pop($levels);
        }

        return $lastDirName;
    }

    /**
     * 得到文件夹操作句柄 
     * 
     * 对文件夹的打开句柄进行缓存 
     * 
     * @access protected static
     * @return boolean | string
     * @exception none
     */
    protected static function _openDir($dirPath)
    {
        if(!isset(self::$_dirHandles[$dirPath]) ||
           false === self::$_dirHandles[$dirPath]) {
               self::$_dirHandles[$dirPath]   = opendir(self::_formatDirPath($dirPath));
        } else {
            rewinddir(self::$_dirHandles[$dirPath]);
        }
        
        return self::$_dirHandles[$dirPath];
    }

    /**
     * 关闭打开的文件夹资源 
     * 
     * @desc 
     * 
     * @access protected
     * @param string $dirPath 要关闭的文件夹路径
     * @return boolean 
     * @exception none
     */
    protected static function _closeDir($dirPath) 
    {
        if(isset(self::$_dirHandles[$dirPath])) {
            closedir(self::$_dirHandles[$dirPath]);
            unset(self::$_dirHandles[$dirPath]);
            return true;
        }

        return false;
    }

    /**
     * 检测文件夹是否可写 
     * 
     * @desc
     * 
     * @access public static
     * @param string $dirPath 需要操作的文件夹
     * @return boolean 
     */
    public static function isWriteable($dirPath = '')
    {
        if(!is_writeable(self::_formatDirPath($dirPath))) {
            return false;
        }

        return true;
    }
    
    /**
     * 得到文件夹路径 
     * 
     * @desc
     * 
     * @access protected
     * @param string $dirPath 文件夹路径默认为空
     * @return string 格式化当前的路径
     */
    protected static function _formatDirPath($dirPath)
    {
        return HString::formatEncodeToOs($dirPath);
    }

    /**
     * 得到文件夹名称 
     * 
     * @desc
     * 
     * @access public static
     * @param string $dirPath 需要处理的当前文件夹路径
     * @return string 
     * @exception none
     */
    public static function getDirName($dirPath)
    {
        $pathInfo   = pathinfo($dirPath);

        return $pathInfo['basename'];
    }

    /**
     * 检测当前的操作目录是不是合法的目录 
     * 
     * 支持结尾为/\的目录路径 
     * 
     * @access public static
     * @param string $dirPath 需要检测的目录
     * @return boolean 
     * @exception none
     */
    public static function isDir($dirPath) 
    {
        if(false == is_dir(HString::formatEncodeToOs($dirPath))) {
            if(strrpos($dirPath, DS) == (strlen($dirPath) - 1)) {
                return true;
            }

            return false;
        }

        return true;
    }

    /**
     * 生成合法的目录路径 
     * 
     * 把以/\结尾为的目录路径去掉 
     * 
     * @access public static
     * @param string $dirPath 需要处理的路径地址
     * @return string 
     * @exception none
     */
    public static function genAvilableDirPath($dirPath)
    {
        if(preg_match('%\\\/$%', $dirPath)) {
            $dirPath    = mb_substr($dirPath,0, -1, 'utf-8');
        }

        return $dirPath;
    }

}

?>
