<?php

/**
 * @version			$Id: HFile.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-13 17:15:37 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		filesystem
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die();

/**
 * 文件操作工具类 
 * 
 * 框架的文件操作支持类 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.filesystem
 * @since 			1.0.0
 */
class HFile extends HObject
{

    /**
     * 新建文件 
     * 
     * 有是否覆盖已经存在的文件选项
     * 
     * @access public
     * @param string $file
     * @param string $content 需要写入到文件里的内容，默认为空
     * @param boolean $override 当存在时是否覆盖，默认为：false
     * @return void 
     * @exception HIOException 
     */
    public static function create($file, $content = '', $override = false)
    {
        $file   = HString::formatEncodeToOs($file);
        if(file_exists($file) && ($override === false)) {
            return;
        }
        if(false === file_put_contents($file, $content)) {
            throw new HIOException($file . '文件写入失败！');
        }
    }

    /**
     * 读取文件内容 
     * 
     * @desc
     * 
     * @access public static
     * @param string $file 文件路径
     * @param int $length 读取的长度, 默认长度为：0 (表示读取所有)
     * @return string 
     * @exception HIOException 
     */
    public static function read($file, $length = 0)
    {
        $content    = file_get_contents(HString::formatEncodeToOs($file));
        if(false === $content) {
            throw new HIOException($file . '文件读取失败！');
        }
        
        return $length <= 0 ? $content : substr($content, 0, $length);
    }

    /**
     * 写入文件内容 
     * 
     * 用file open的方式 
     * 
     * @access public static
     * @param string $file 要操作的文件路径
     * @param string $content 需要写入的文件内容
     * @return void 
     * @exception HIOException 
     */
    public static function write($file, $content)
    {
        $file   = HString::formatEncodeToOs($file);
        if(false === file_put_contents($file, $content)) {
            throw new HIOException($file . '文件写入失败！');
        }
        self::setChangeTime($file);
    }

    /**
     * 追加文件内容 
     * 
     * fopen的方式来打开文件，追加内容 
     * 
     * @access public static
     * @param string $file 文件路径
     * @param string $content 需要追加的内容
     * @return boolean  是否添加成功
     */
    public static function append($file, $content)
    {
        $fileHandle     = fopen(HString::formatEncodeToOs($file), 'a+');
        $appendLength   = fwrite($fileHandle, $content);
        fclose($fileHandle);

        return $appendLength > 0 ? true : false;
    }

    /**
     * 复制文件 
     * 
     * @desc
     * 
     * @access public static
     * @param string $src 源文件路径
     * @param string $desc 目标文件路径
     * @return void 
     * @exception HIOException 
     */
    public static function copy($src, $desc)
    {
        if(!copy(HString::formatEncodeToOs($src), HString::formatEncodeToOs($desc))) {
            throw new HIOException('文件复制失败！');
        }
    }

    /**
     * 移动文件 
     * 
     * 还只支持单文件的移动 
     * 
     * @access public static
     * @param string $src 源文件路径
     * @param string $to 目标位置
     * @return boolean 
     * @exception HIOException 
     */
    public static function move($src, $to)
    {
        return rename(HString::formatEncodeToOs($src), HString::formatEncodeToOs($to));
    }

    /**
     * 重命名文件 
     * 
     * 把老的文件名用新名称替换 
     * 
     * @access public static
     * @param string $oldPath 老文件名路径
     * @param string $newPath 新文件名路径
     * @return boolean 
     * @exception none
     */
    public static function rename($oldPath, $newPath)
    {
        return rename(
            HString::formatEncodeToOs($oldPath),
            HString::formatEncodeToOs($newPath)
        );
    } 

    /**
     * 删除文件 
     * 
     * 对unlink的封装, 支持数组集合, 支持递归 
     * 
     * @access public static
     * @param string | array $files 需要删除的文件集合
     * @param string $baseDir 当前需要删除文件的基目录
     * @return void 
     * @exception HIOException 
     */
    public static function delete($files, $baseDir = '')
    {
        if(!is_array($files)) {
            $files  = array($files);
        }
        foreach($files as $file) {
            if(is_array($file)) {
                self::delete($file, $baseDir);
            } else {
                $path   = HString::formatEncodeToOs($baseDir . $file);
                if(self::isExists($baseDir . $file) && !unlink($path)) {
                    throw new HIOException('文件删除失败！' . $path);
                }
            }
        }
    }

    /**
     * 得到文件夹所在目录 
     * 
     * 直接dirname了 
     * 
     * @access public static
     * @param string $file 文件路径
     * @return string 
     * @exception none
     */
    public static function getDir($file)
    {
        return dirname($file);
    }

    /**
     * 得到文件名包含扩展名 
     * 
     * 支持uri及字符串形式 
     * 
     * @access public static
     * @param string $file 需要处理的文件路径
     * @return string 
     * @exception none
     */
    public static function getName($file)
    {
        $fileInfo   = pathinfo($file);
        
        return strtr($fileInfo['basename'],
                     array('.' . $fileInfo['extension'] => ''));
    }

    /**
     * 得到文件扩展名 
     * 
     * 支持文件路径形式及单文件名形式,结果中包含"."，如".php" 
     * 
     * @access public static
     * @param string $file 需要处理的文件路径
     * @return string 
     * @exception none
     */
    public static function getExtension($file)
    {
        $fileInfo   = pathinfo($file);

        return '.' . strtolower($fileInfo['extension']);
    }

    /**
     * 得到文件名 
     * 
     * @desc
     * 
     * @access public static
     * @param $file
     * @return void
     * @exception none
     */
    public static function getBaseName($file)
    {
        $fileInfo   = pathinfo($file);

        return $fileInfo['basename'];
    }

    /**
     * 检察文件是否存在 
     * 
     * @desc
     * 
     * @access public static
     * @param string $file 文件路径
     * @return boolean 
     * @exception none
     */
    public static function isExists($file)
    {
        return file_exists(HString::formatEncodeToOs($file));
    }

    /**
     * 检验文件是否可读 
     * 
     * @desc
     * 
     * @access public static
     * @param  String $file 需要处理的文件路径
     * @return Boolean 
     * @exception none
     */
    public static function isReadable($file)
    {
        return is_readable(HString::formatEncodeToOs($file));
    }

    /**
     * 得到文件上一次修改的时间 
     * 
     * 用法：
     * <code>
     *  HFile::getChangeTime('F:/www/test.txt');    //2012-07-20 12:32:30
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $file 需要处理的文件路径
     * @param  String $format 当前的时间格式，默认为：'Y-m-d H:m:s'
     * @return String 格式化后的值 
     * @throws none
     */
    public static function getChangeTime($file, $format = 'Y-m-d H:m:s')
    {
        return date($format, filectime($file));
    }

    /**
     * 设置文件修改的时间 
     * 
     * 用法：
     * <code>
     *  HFile::setChangeTime("F:/www/test.txt"); //使用当前的时间值
     *  HFile::setChangeTime("F:/www/test.txt", time() - 1000); //使用指定的修改时间
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $file 需要修改的文件
     * @param  int $time 设置的时间值，默认为：''
     * @return Boolean  
     * @throws none
     */
    public static function setChangeTime($file, $time = '')
    {
        return empty($time) ? touch($file, time(), time()) : touch($file, $time, $time);
    } 

    /**
     * 得到当前文件的大小 
     * 
     * 用法：
     * <code>
     *  HFile::getSize('F:/www/test/txt');  //0.05M
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $file 需要处理的文件路径
     * @return String 当前文件大小字符
     */
    public static function getSize($file)
    {
        $size   = sprintf("%u", filesize($file));
        if(1024 > $size) {  //Bytes级
            return $size . 'Bytes';
        }
        if(1048756 > $size) {   //KB级
            return sprintf("%01.2f", $size / 1024) . 'KB';
        }
        if(1073741824 > $size) { //M级
            return sprintf("%01.2f", $size / 1048756) . 'M';
        }
        if(1099511627776 > $size) {  //G级
            return sprintf("%01.2f", $size / 1073741824) . 'G';
        }
        if(1125899906842624 > $size) { //T级
            return sprintf("%01.2f", $size / 1099511627776) . 'T';
        }
    }

    /**
     * 得到图片缩放类型对应的文件路径 
     * 
     * 根据用户给定的路径路径，及缩放类型返回对应的文件缩放文件路径
     * 
     * @access public
     * @param string $imagePath 原始文件路径
     * @param string $zoomType 文件缩放的类型
     * @param string $def 默认的图片路径
     * @return string  替换后的结果
     */
    public static function getImageZoomTypePath($imagePath, $zoomType, $def = 'default.jpg')
    {
        if(empty($imagePath)) { return $def; }
        $type   = self::getExtension($imagePath);

        return str_replace($type, '-' . $zoomType . $type, $imagePath);
    }

    /**
     * 通过用户ID得到用户的头像路径
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  int $uId 用户ID
     * @param  String $size 用户尺寸,默认为1号
     * @return String 头像路径
     */
    public static function getAvatar($uId, $size = 1)
    {
        return self::getAvatarPathByUserIdPrefix($uId) . $size . '.jpg';
    }

    /**
     * 通过用户ID得到用户的头像路径
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  int $uId 用户ID
     * @param  String $size 用户尺寸,默认为1号
     * @return String 头像路径
     */
    public static function getAvatarPathByUserIdPrefix($uId)
    {
        $uId    = abs(intval($uId));//UID取整数绝对值
        $uId    = sprintf('%09d', $uId);//前边加0补齐9位，例如UID为31的用户变成 000000031
        $dir1   = substr($uId, 0, 3); //取左边3位，即 000
        $dir2   = substr($uId, 3, 2); //取4-5位，即00
        $dir3   = substr($uId, 5, 2); //取6-7位，即00
        // 下面拼成用户头像路径，即000/00/00/31_avatar_middle.jpg
        
        return $dir1 . '/' . $dir2 . '/' . $dir3 . '/' . substr($uId, -2) . '-avatar-';
    }

}
?>
