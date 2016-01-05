<?php

/**
 * @version			$Id$
 * @create 			2012-5-6 22:50:30 By xjiujiu
 * @package 		app.admin
 * @subpackage 		action
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminBaseAction');

/**
 * 主题管理工具类 
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class ThemesAction extends AdminBaseAction
{

    /**
     * 模板管理主页动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function index()
    {
        parent::__construct();
        $this->_assignThemes();
        $this->_render('hongjuzi/themes');
    }

    /**
     * 赋值当前模板信息集合 
     * 
     * @desc
     * 
     * @access protected
     * @return void
     * @exception none
     */
    protected function _assignThemes()
    {
        $themes     = $this->_getAllThemes();
        HResponse::setAttribute('currentTheme', $themes['current']);
        HResponse::setAttribute('themes', $themes['other']);//$themes['other']);
    }

    /**
     * 得到所有主题 
     * 
     * @desc
     * 
     * @access protected
     * @return array
     * @exception none
     */
    protected function _getAllThemes()
    {
        HClass::import('hongjuzi.filesystem.HDir');
        $themes         = array();
        $themesDir      = HDir::getDirs(HObject::GC('THEMES_DIR'));
        foreach($themesDir as $themeDir) {
            $themeConfig    = $this->_loadThemeConfigFile($themeDir);
            if(HObject::GC('CUR_THEME') == $themeConfig['name']) {
                $themes['current']         = $themeConfig;
            } else {
                $themes['other'][]    = $themeConfig;
            }
        }

        return $themes;
    }

    /**
     * 加载对应模板的配置文件 
     * 
     * @desc
     * 
     * @access protected
     * @param string $thememDir 主题的存储目录
     * @return array 
     * @exception none
     */
    protected function _loadThemeConfigFile($themeDir)
    {
        $themeConfigPath    = ROOT_DIR . DS . $themeDir . DS . 'config.php';
        if(HFile::isExists($themeConfigPath)) {
            $themeConfig    = require_once($themeConfigPath);
        } else {
            $themeConfig['error']   = '配置文件不存在！';
        }
        $themeConfig['path'] = $themeDir;
        $themeConfig['name'] = HDir::getDirName($themeDir);
        
        return $themeConfig;
    }

    /**
     * 启用主题 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function open()
    {
        HVerify::stringLen(HRequest::getParameter('name'), '主题名', 1, 50);
        HFile::isExists(ROOT_DIR . DS . HObject::GC('THEMES_DIR') . DS . HRequest::getParameter('name'));
        HObject::SC('CUR_THEME', HRequest::getParameter('name'));
        if(!HObject::EC()) {
            throw new HRequestException('启用失败！');
        }
        HResponse::succeed('启用成功！');
    }
   
    /**
     * 预览主题 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function preview()
    {
    
    }

    /**
     * 删除主题 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function delete()
    {
    
    }

}

?>
