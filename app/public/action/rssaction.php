<?php

/**
 * @version			$Id$
 * @create 			2013-08-15 17:08:20 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.articlepopo, app.public.action.publicaction, model.articlemodel');

/**
 * RSS控制器
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.action
 * @since 1.0.0
 */
class RssAction extends PublicAction 
{

    /**
     * @var private $_categoryMap 分类哈希容器
     */
    private $_categoryMap;

    /**
     * @var private $_authorMap 发表人哈希容器
     */
    private $_authorMap;

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo    = new ArticlePopo();
        $this->_model   = new ArticleModel($this->_popo);
        $this->_categoryMap     = null;
        $this->_authorMap       = null;
    }

    /**
     * 主页方法
     * 
     * @desc
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function index()
    {
        $this->_initCategoryMap();
        $this->_initAuthorMap();
        $this->_assignSiteConfig();
        $this->_writeRSS($this->_getAllArticles(), '分享');
    }

    /**
     * 初始化发表人容器
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _initAuthorMap()
    {
        $user   = HClass::quickLoadModel('user');
        $this->_authorMap   = HArray::turnItemValueAsKey(
            $user->getAllRows(),
            'id'
        );
    }

    /**
     * 得到所有的文章
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @return Array
     */
    private function _getAllArticles()
    {
        $article    = HClass::quickLoadModel('article');

        return $article->getAllRows();
    }

    /**
     * 初始化分类容器
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _initCategoryMap()
    {
        $category   = HClass::quickLoadModel('category');
        $this->_categoryMap     = HArray::turnItemValueAsKey(
            $category->getAllRows(),
            'id'
        );
    }

    /**
     * 输出RSS格式数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  Array $items 所有的项目集合
     * @param  String $title 标题
     */
    private function _writeRSS($items, $title) 
    {
        $siteCfg    = HResponse::getAttribute('siteCfg');
        header("Content-type: application/xml");
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".
                "<rss version=\"2.0\">\n".
                "  <channel>\n".
                "    <title>" . $siteCfg['site_name'] . "</title>\n".
                "    <link>" . HResponse::url() . "</link>\n".
                "    <description>" . $title . "</description>\n".
                "    <copyright>Copyright(C) " . $siteCfg['site_name']. "</copyright>\n".
                "    <generator>HongJuZi ! Powered by HongJuZiSoft Inc .</generator>\n".
                "    <lastBuildDate>" . gmdate("r", $_SERVER["REQUEST_TIME"]) . "</lastBuildDate>\n".
                "    <ttl>" . HObject::GC('RSS_TTL') . "</ttl>\n".
                "    <image>\n".
                "      <url>" . HResponse::uri("theme") . "/images/logo.png</url>\n".
                "      <title>" . $siteCfg['site_name'] . "</title>\n".
                "      <link>".HResponse::url()."</link>\n".
                "    </image>\n";

        foreach($items as $item) {
            echo "    <item>\n".
                "      <title>" . $item["name"] . "</title>\n".
                "      <link>" . HResponse::url("article", "id=" . $item["id"])."</link>\n".
                "      <description><![CDATA[$item[description]]]></description>\n".
                "      <category>" . $this->_categoryMap[$item["parent_id"]]['name'] . "</category>\n".
                "      <author>" . $this->_authorMap[$item["author"]]['name'] . "</author>\n".
                "      <pubDate>" . @gmdate("r", $item["create_time"]) . "</pubDate>\n".
                "    </item>\n";
        }

        echo 	"  </channel>\n".
                "</rss>";
    }


}
?>
