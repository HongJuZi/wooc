<?php

/**
 * @version			$Id$
 * @create 			2013-11-04 22:11:10 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');


//导入引用文件
HClass::import('app.public.action.PublicAction');

/**
 * 文件资源静态请求的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class UriAction extends PublicAction
{

    /**
     * 构造函数 
     * 
     * @access public
     */
    public function __construct() { } 

    /**
     * 得到对应的js文件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function getjs()
    {
        // Send correct type
        header('Content-Type: text/javascript; charset=UTF-8');
        // Enable browser cache for 1 hour
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
        if (! empty($_GET['scripts']) && is_array($_GET['scripts'])) {
            foreach ($_GET['scripts'] as $script) {
                // Sanitise filename
                $script_name = 'js';
                $path = explode("/", $script);
                foreach ($path as $index => $filename) {
                    if (! preg_match("@^\.+$@", $filename) && preg_match("@^[\w\.-]+$@", $filename)) {
                        // Disallow "." and ".." alone
                        // Allow alphanumeric, "." and "-" chars only
                        $script_name .= DIRECTORY_SEPARATOR . $filename;
                    }
                }
                echo $script_name;
                exit;
                // Output file contents
                if (preg_match("@\.js$@", $script_name) && is_readable($script_name)) {
                    readfile($script_name);
                    echo ";\n\n";
                }
            }
        }
    }

}

?>
