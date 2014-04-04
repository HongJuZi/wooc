<?php

/**
 * @version			$Id: HResponse.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-19 11:36:17 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		net
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HPATH_BASE') or die('Restricted access!');

/**
 * 對系統的浏覽器輸出作一個封裝
 * 
 * 把所有的輸出內容裝載給一個變量中 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.net
 * @since 			1.0.0
 */
class HResponse extends HObject
{

    /**
     * @var array $_attributes 顯示屬性容器
     */
    protected static $_attributes   = array();

    /**
     * @var Array static $_lang  语言存储容器
     */
    protected static $_lang         = array();

    /**
     * @var protected static $_formatMap 格式化容器
     */
    protected static $_formatMap    = array();

    /**
     * 格式化輸出文本 
     * 
     * @access public static
     * @param string $field 字段名
     * @param array $record 記錄的值
     * @return mix 
     */
    public static function formatText($field, &$record)
    {
        $value  = $record[$field];
        if(isset(self::$_formatMap[$field])) {
            return empty($value) || -1 == $value ? HResponse::lang('NONE', false) 
                    : self::$_formatMap[$field]['data'][$value][self::$_formatMap[$field]['key']];
        }
        switch($field) {
            case 'image_path':
                $imageName  = HFile::getName($value);
                return empty($value) ? HResponse::lang('NO_IMAGE', false) : '<a href="' . self::url() . $value . '" title="' . $imageName 
                    . '" class="lightbox" target="_blank"><img src="' 
                    . self::url() . HFile::getImageZoomTypePath($value, 'small') . '" alt="' . $imageName . '"/></a>';
            case 'file_path':
                return empty($value) ? HResponse::lang('NO_FILE', false) : sprintf("<a href='%s' title='%s'/>%s</a>",
                    self::url() . $value, HFile::getBaseName($value), HFile::getBaseName($value));
            default:
            return 0 != $vaule && empty($value) ? HResponse::lang('EMPTY', false) : HString::cutString($value, 30);
        }
    }

    /**
     * 注冊格式化表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $field 字段名
     * @param  String $key 需要顯示的字段
     * @param  Array $data 數據 
     */
    public static function registerFormatMap($field, $key, $data)
    {
        self::$_formatMap[$field]   = array(
            'key' => $key,
            'data' => $data
        );
    }

    /**
     * 設置當前的屬性
     * 
     * 這裏跟HObject裏的set/get區分下，這裏的是靜態類型 
     * 
     * @access public static
     * @param string $name 屬性名稱
     * @param mix $value 屬性對應的值
     */
    public static function setAttribute($name, $value)
    {
        self::$_attributes[$name]   = $value;
    }

    /**
     * 得到屬性對應的值
     * 
     * 有剛返回對應的值，沒有的情況下返回Null
     * 
     * @access public static
     * @param string $name 屬性名稱
     * @return mix 
     */
    public static function getAttribute($name)
    {
        if(isset(self::$_attributes[$name])) {
            return self::$_attributes[$name];
        }

        return '';
    }

    /**
     * 檢測給定的屬性裏有沒有包含給定的鍵 
     * 
     * 還只支持對數組的檢測 
     * 
     * @access public
     * @param string $attr 當前給定的屬性名
     * @param string $element 需要檢測元素名
     */
    public static function isAttributeHasElement($attr, $element)
    {
        if(!isset(self::$_attributes[$attr])) {
            return false;
        }
        if(is_array(self::$_attributes[$attr])) {
            if(isset(self::$_attributes[$attr][$element])) {
                return true;
            }
        }

        return false;
    }

    /**
     * 檢測給定的屬性裏有沒有包含給定的元素 
     * 
     * 還只支持對數組的檢測 
     * 
     * @access public
     * @param string $attr 當前給定的屬性名
     * @param string $element 需要檢測元素名
     */
    public static function isElementInAttribute($attr, $element)
    {
        if(!isset(self::$_attributes[$attr])) {
            return false;
        }
        if(is_array(self::$_attributes[$attr])) {
            if(in_array($element, self::$_attributes[$attr])) {
                return true;
            }
        }

        return false;
    }

    /**
     * 重定向當前訪問的鏈接 
     * 
     * 浏覽器地址改變
     * 
     * @access public static
     * @param $url 需要跳转的链接
     */
    public static function redirect($url)
    {
        $url    = empty($url) ? self::url() : $url;
        header('Location:' . $url);
        exit;
    }
    
    /**
     * 成功提示
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  $message 提示信息
     * @param  $url 需要跳转的URL
     * @param  $time 延迟时间
     */
    public static function succeed($message, $url = -1, $time = 1)
    {
        self::alert($message, $url, $time, 200);
    }

    /**
     * 只是提示
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  $message 提示信息
     * @param  $url 需要跳转的URL
     * @param  $time 延迟时间
     */
    public static function info($message, $url = -1, $time = 1)
    {
        self::alert($message, $url, $time, 201);
    }

    /**
     * 警告提示
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  $message 提示信息
     * @param  $url 需要跳转的URL
     * @param  $time 延迟时间
     */
    public static function warn($message, $url = -1, $time = 1)
    {
        self::alert($message, $url, $time, 400);
    }

    /**
     * 错误提示
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  $message 提示信息
     * @param  $url 需要跳转的URL
     * @param  $time 延迟时间
     */
    public static function error($message, $url = -1, $time = 1)
    {
        self::alert($message, $url, $time, 500);
    }

    /**
     * 提示内部使用方法
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private static
     * @param  $message 提示信息
     * @param  $url 下一跳链接
     * @param  $time 停留时间
     * @param  $status 状态码
     */
    public static function alert($message, $url, $time, $status)
    {
        $url    = empty($url) ? HResponse::url() : $url;
        require_once(HResponse::path('tpl') . '/public/default/alert.tpl');
        exit;
    }

    /**
     * 指定文檔輸出的編碼類型 
     * 
     * 傳入想輸出的文檔類型名稱即可，如utf8, gbk, gb2312 
     * 
     * @access public static
     * @param string $charset 文檔編碼類型，默認爲: utf8
     */
    public static function contentTypeHeader($charset = 'utf8')
    {
        header('Content-Type:text/html; charset=' . $charset);
    }

    /**
     * 返回下載文件 
     * 
     * 將文件路徑彈出給出提示下載 
     * 
     * @access public static
     * @param string $filePath 需要下載的文件路徑
     * @param string $fileName 下載的文件名稱
     */
    public static function outputFile($filePath, $fileName = '')
    {
        header('Pragma: public');
        header('Expires: 0');
        header('Content-Type:application/force-download');
        header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/octet-stream');  
        header('Content-Type:application/download');
        header('Content-Disposition: attachment; filename=' . HString::formatEncodeToOs(HFile::getBaseName($filePath)));
        header('Content-Transfer-Encoding:binary');
        if(HFile::isExists($filePath)) {
            readfile($filePath);
        }
    }

    /**
     * 下載文件 
     * 
     * 支持所有文件的下載 
     * 
     * @access public static
     * @param string $uri 文件的鏈接地址
     * @return boolean 
     */
    public static function download($uri, $savePath)
    {
        if(false == ($uri && $savePath)) {
            return false;
        }
        HObject::import('hongjuzi.environment.HBrowser');
        if(in_array(HBrowser::getBrowserName(), array('IE', 'OPERA'))) {
            header('Content-Type: application/octetstream');
        } else {
            header('Content-Type: application/octet-stream');
        }
        header('Expires:' . HDatetime::getLocalTime() . 'GMT');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($savePath));
        if('IE' == HBrowser::getBrowserName()) {
            header('Content-Disposition: attachment; filename="' . $uri . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Content-Disposition: attachment; filename="' . $uri . '"');
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: no-cache');
        }
        if(false === @readfile($savePath)) {
            return false;
        }

        return true;
    }

    /**
     * 緩存的Header聲明
     * 
     * 通過Header來控制網頁的緩存時間 
     * 
     * @param int $maxAge 最大的緩存時間
     * @access public static
     */
    public static function cacheHeader($maxAge = 0)
    {
        header('Last-Modified:' . $maxAge);
        header('Expires:' . $maxAge);
        header('Cache-Control:max-age=' . $maxAge);
    }

    /**
     * 通過JSON格式來輸出數據 
     * 
     * 主要用于像Ajax一類的請求輸出 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param array $data 需要向客戶端輸出的數據
     */
    public static function json($data)
    {
        echo json_encode($data);
        exit;
    }

    /**
     * 生成請求的鏈接 
     * 
     * 用法：
     * <code>
     *  HResponse::url('news');   //http://www.xxx.com/index.php/news
     *  HResponse::url('news', '?id=1');  //http://www.xxx.com/index.php/news?id=1
     * </code>
     * 
     * @access public static
     * @param  String $model 模塊名,默認爲空。
     * @param  String $query 查詢的內容，默認爲空。
     * @param  String $app 当前应用，默認爲空。
     * @return String  最絡請求的鏈接
     */
    public static function url($model = '', $query = '', $app = '')
    {
        if($app || $model || $query ) {
            //自动设定当前应用
            $app    = empty($app) ? self::$_attributes['HONGJUZI_APP'] . '/' : $app . '/'; 
            $app    = $app == HObject::GC('DEFAULT_APP') ? '' : $app;
            $query  = empty($query) ? '' : '?' . $query;

            return SITE_URL . 'index.php/' . $app . $model . $query;
        }

        return SITE_URL;
    }

    /**
     * 得到公用資源的路徑 
     * 
     * 組合SITE_URL加上公用資源的路徑,PD即：public directory 的縮寫 
     * 
     * @access public
     * @return string 当前类型的链接地址
     */
    public static function uri($dir = null)
    {
        return self::_path($dir, SITE_URL);
    }

    /**
     * 得到相对于服务器的路径 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $dir 位置
     * @return String 当前资源相对于服务器的路径 
     */
    public static function path($dir = null)
    {
        return self::_path($dir, ROOT_DIR);
    }

    /**
     * 得到资源相对于给定基地址的完整路径 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     * @param  String $dir 目录位置
     * @param  String $basePath 基地址
     * @return String 真实的路径
     */
    protected static function _path($dir, $basePath)
    {
        switch($dir) {
            case 'cdn':
                return HObject::GC('CDN_URL');
            case 'tpl':
            case 'template':
                return $basePath . HObject::GC('TPL_DIR');
            case 'res':
            case 'resource':
                return $basePath . HObject::GC('RES_DIR');
            case 'vendor':
                return $basePath . HObject::GC('VENDOR_DIR');
            case 'demo':
                return $basePath . hobject::GC('TPL_DIR') . '/demo' ;
            default:    //全作为app处理
                $app  = null === $dir ? self::$_attributes['HONGJUZI_APP'] : $dir;
                return $basePath . hobject::GC('TPL_DIR') . '/' . $app  . DS . HObject::GC('CUR_THEME');
        }
    }

    /**
     * @var LangMaskModel static $_langMask 语言标记操作对象
     */
    private static $_langMask   = null;

    /**
     * @var TplModel static $_tpl 模板操作数据层对象 
     */
    private static $_tpl        = null;

    /**
     * 得到当前的语言信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $mask 语言标记操作
     */
    public static function lang($mask, $echo = true)
    {
        if(isset(self::$_lang[$mask])) {
            if(true == $echo) {
                echo self::$_lang[$mask];
                return;
            }
            return self::$_lang[$mask];
        }
        /*
        self::_initLangMaskAndTplModel();
        self::_recordTplAndRelWithLangMask(
            self::_recordLangMask($mask)
        );*/
        if(true !== $echo) {
            return $mask;
        }

        echo $mask;
    }

    /**
     * 初始化语言标识及模板数据层操作类
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     */
    protected static function _initLangMaskAndTplModel()
    {
        if(null == self::$_langMask) {
            self::$_langMask   = HClass::quickLoadModel('langmask');
        }
        if(null == self::$_tpl) {
            self::$_tpl    = HClass::quickLoadModel('tpl');
        }
    }

    /**
     * 记录语言标识
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     * @param  String $mask 当前的语言标识
     */
    protected static function _recordLangMask($mask)
    {
        $record     = self::$_langMask->getRecordByWhere('`name` = \'' . $mask . '\'');
        if($record) {
            return $record['id'];
        }
        $data       = array(
            'name' => $mask,
            'has_tpl' => self::_getActionFile(),
            'author' => intval(HSession::getAttribute('id', 'user'))
        );

        return self::$_langMask->add($data);
    }

    /**
     * 记录当前的模板及添加语言跟模板的使用
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected static
     * @param  String $maskId 当前标识的ID
     */
    protected static function _recordTplAndRelWithLangMask($maskId)
    {
        $actionFile     = self::_getActionFile();
        $hash           = md5($actionFile);
        $record         = self::$_tpl->getRecordByWhere('`hash` = \'' . $hash . '\'');
        $data           = array(
            'name' => $actionFile,
            'app' => HResponse::getAttribute('HONGJUZI_APP'),
            'hash' => $hash,
            'author' => intval(HSession::getAttribute('id', 'user'))
        );
        $tplId  = empty($record) ? self::$_tpl->add($data) : $record['id'];
        if(!self::$_tpl->getRelTplAndLangMask($tplId, $maskId)) {
            self::$_tpl->addRelTplAndLangMask($tplId, $maskId);
        }
    }

    /**
     * 得到动作加载的文件
     *
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return String 当前的action文件或是模板文件
     */
    protected static function _getActionFile()
    {
        return !empty(self::$_attributes['RENDER_TPL']) ? self::$_attributes['RENDER_TPL']
            : HResponse::getAttribute('HONGJUZI_APP') . '/' . HResponse::getAttribute('HONGJUZI_MODEL');
    }

    /**
     * 加载语言库文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param  String $file 当前的语言库文件
     */
    public static function loadLang($file)
    {
        $start      = false !== strrpos($file, '/') ? strrpos($file, '/') : 0;
        $langPath   = ROOT_DIR . 'i18n/' . HSession::getAttribute('lang_type', 'website') 
            . '/' . HResponse::getAttribute('HONGJUZI_APP') . '/' 
            . substr($file, $start) . '.php';
        if(file_exists($langPath)) {
            self::$_lang     = array_merge(self::$_lang, require_once($langPath));
        }
    }

}

?>
