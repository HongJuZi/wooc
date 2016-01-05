-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- 主机: localhost:3306
-- 生成日期: 2015-05-17 19:45:04
-- 服务器版本: 5.5.32
-- PHP 版本: 5.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES {charset} */;

--
-- 数据库: `test_wooc`
--

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}actor`
--

CREATE TABLE IF NOT EXISTS `{prefix}actor` (
  `sort_num` double DEFAULT NULL COMMENT '排序|只能是数字，默认为：当前时间。|show,desc|text',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号|系统自动编号|show|hidden',
  `name` varchar(255) NOT NULL COMMENT '名称|长度255|show',
  `identifier` varchar(20) DEFAULT NULL COMMENT '标识|字符串长度：20|show|text',
  `description` text COMMENT '描述|角色介绍信息||textarea',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10 08:09:09||datetime',
  `author` int(11) NOT NULL COMMENT '维护员|上一次修改的管理员|show',
  PRIMARY KEY (`id`),
  KEY `usertype_name` (`name`),
  KEY `identifier` (`identifier`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='系统管理者类型' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}adv`
--

CREATE TABLE IF NOT EXISTS `{prefix}adv` (
  `sort_num` double unsigned DEFAULT NULL COMMENT '排序|只能是数字，默认为：当前时间。|show,asc|text',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '标题|长度范围：2~255。|show,search|text',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '位置|显示位置|show|tree',
  `url` varchar(255) NOT NULL DEFAULT '###' COMMENT '跳转链接|合法的URL发址',
  `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '打开位置|当前窗口_self、新窗口_blank、自定义|show|text',
  `description` text COMMENT '内容简介|长度255字以内。|show|textarea',
  `image_path` varchar(255) DEFAULT NULL COMMENT '图片|请选择允许的类型。|show|image',
  `lang_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属网站|数据所在的网站范围|hide|hidden',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL COMMENT '维护人|最后一次维护人员|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`),
  KEY `AK_sort_num` (`sort_num`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='大图展示|宣传、展示类大图' AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}article`
--

CREATE TABLE IF NOT EXISTS `{prefix}article` (
  `sort_num` int(11) NOT NULL DEFAULT '9999' COMMENT '排序|显示排序|show|text',
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` text NOT NULL COMMENT '标题|长度范围：2~255。|show,search|text',
  `extend_class` varchar(255) DEFAULT NULL COMMENT '扩展样式|自动定义样式|show|text',
  `identifier` varchar(200) DEFAULT '' COMMENT '标识|唯一，最好用英文|show',
  `parent_id` varchar(50) DEFAULT '0' COMMENT '所属分类|请正确选取|hide|multiselect',
  `description` text COMMENT '内容简介|长度255字以内。|show|textarea',
  `content` longtext COMMENT '详细内容|长度10000字以内。||editor',
  `tags` varchar(255) DEFAULT ',1,' COMMENT '标签|信息包含的标签分类|hide|tags',
  `tags_name` varchar(255) DEFAULT ',博客主页,' COMMENT '标签名称缓存|标签名称缓存|show|text',
  `image_path` varchar(255) DEFAULT NULL COMMENT '图片|请选择允许的类型。|show|image',
  `total_visits` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数|总到访数|show|text',
  `total_comments` bigint(20) NOT NULL DEFAULT '0' COMMENT '总评论数|只能是数字|show|text',
  `hash` char(32) NOT NULL DEFAULT 'testsetsetest' COMMENT '相册|相册图片大小300pxX350px，或这个比例，大小300KB以下|hide|album',
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态|1草稿,2发布,3删除',
  `lang_id` int(11) NOT NULL DEFAULT '454' COMMENT '语言|对应语言|show|select',
  `edit_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间|上一次更新时间|show|datetime',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '维护人|最近一次维护人员|show',
  PRIMARY KEY (`id`),
  KEY `post_name` (`identifier`),
  KEY `type_status_date` (`create_time`,`id`),
  KEY `post_parent` (`parent_id`),
  KEY `post_author` (`author`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}category`
--

CREATE TABLE IF NOT EXISTS `{prefix}category` (
  `sort_num` double unsigned NOT NULL DEFAULT '9999' COMMENT '排序|只能是数字，默认为：当前时间。|show,desc|text',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '标题|长度范围：2~255。|show,search|text',
  `identifier` varchar(255) DEFAULT NULL COMMENT '标识|唯一，建议使用英文|show',
  `parent_id` int(11) NOT NULL DEFAULT '-1' COMMENT '所属分类|请正确选取|show|category',
  `parent_path` varchar(255) DEFAULT NULL COMMENT '所属层级|格式:：:3:2:1:|hide|hidden',
  `description` text COMMENT '内容简介|长度255字以内。||textarea',
  `image_path` varchar(255) DEFAULT NULL COMMENT '图片|请选择允许的类型。|show|image',
  `total_use` int(11) NOT NULL DEFAULT '0' COMMENT '总使用数|当前分类总使用数|show|text',
  `lang_id` int(11) NOT NULL DEFAULT '454' COMMENT '语言|对应语言|show|select',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL DEFAULT '1' COMMENT '作者|用户的ID|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`),
  KEY `AK_sort_num` (`sort_num`),
  KEY `identifier` (`identifier`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='信息分类|后台信息分类模块' AUTO_INCREMENT=474 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}comment`
--

CREATE TABLE IF NOT EXISTS `{prefix}comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号|系统编号|show,desc|hidden',
  `name` tinytext NOT NULL COMMENT '维护人|信息最后一次维护人|show|text',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱|评论人联系邮箱|show|text',
  `content` varchar(500) NOT NULL COMMENT '评论内容|长度255|show|textarea',
  `item_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文章|被评论的文章|show|text',
  `status` int(20) NOT NULL DEFAULT '1' COMMENT '状态|1, 正常, 2 删除|show|select',
  `ip` varchar(100) NOT NULL DEFAULT '' COMMENT 'IP|评论的IP地址|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|评论提交时间|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护人|信息最后一次维护人|show|text',
  PRIMARY KEY (`id`),
  KEY `comment_post_ID` (`item_id`),
  KEY `comment_approved_date_gmt` (`status`),
  KEY `comment_author_email` (`email`(10))
) ENGINE=MyISAM  DEFAULT CHARSET={charset} AUTO_INCREMENT=92123 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}contact`
--

CREATE TABLE IF NOT EXISTS `{prefix}contact` (
  `sort_num` int(11) NOT NULL DEFAULT '999' COMMENT '次序|显示的前后关系|show,asc|text',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '说明|联系方式说明信息|show|textarea',
  `identifier` varchar(50) DEFAULT '' COMMENT '标识|唯一，最好用英文|show',
  `content` text NOT NULL COMMENT '内容|联系方式内容。|show|code',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10||datetime',
  `author` int(11) NOT NULL COMMENT '维护人|最后一次维护人员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='联系方式|联系方式管理模块' AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}lang`
--

CREATE TABLE IF NOT EXISTS `{prefix}lang` (
  `sort_num` double unsigned NOT NULL DEFAULT '9999' COMMENT '排序|只能是数字，默认为：当前时间。|show,desc|text',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '标题|长度范围：2~255。|show,search|text',
  `identifier` varchar(255) DEFAULT NULL COMMENT '标识|唯一，建议使用英文|show',
  `image_path` varchar(255) DEFAULT NULL COMMENT '图片|请选择允许的类型。|show|image',
  `is_default` tinyint(4) NOT NULL DEFAULT '1' COMMENT '默认|默认前后台使用的语言|show|checkbox',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL DEFAULT '1' COMMENT '作者|用户的ID|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`),
  KEY `AK_sort_num` (`sort_num`),
  KEY `identifier` (`identifier`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='语言种类|语言种类管理模块' AUTO_INCREMENT=457 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}link`
--

CREATE TABLE IF NOT EXISTS `{prefix}link` (
  `sort_num` double unsigned NOT NULL DEFAULT '999' COMMENT '排序|只能是数字，默认为：99999。|show,asc|text',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '名称|长度范围：2~255。|show,search|text',
  `url` varchar(255) NOT NULL COMMENT '链接|合法的URL发址|show',
  `description` varchar(255) NOT NULL COMMENT '内容简介|长度255字以内。|show|textarea',
  `image_path` varchar(255) DEFAULT NULL COMMENT '图片|请选择允许的类型。|show|image',
  `lang_id` int(11) NOT NULL DEFAULT '454' COMMENT '语言|对应语言|show|select',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10 10:00:00||datetime',
  `author` int(11) NOT NULL COMMENT '维护人|最近一次维护人员|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`),
  KEY `AK_sort_num` (`sort_num`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='友情链接|收集好友的网站，提供网站导航' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_actor_rights`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_actor_rights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` int(10) unsigned NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=302 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_adv_lang`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_adv_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` int(11) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` int(11) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=385 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_article_category`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_article_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` char(32) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` varchar(50) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=208 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_article_lang`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_article_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` int(11) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` int(11) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=393 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_article_resource`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_article_resource` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` char(32) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` int(10) unsigned DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_article_tags`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_article_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` char(32) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` varchar(50) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '1' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=368 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_category_lang`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_category_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` int(11) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` int(11) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=387 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_link_lang`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_link_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` int(11) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` int(11) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=385 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_navmenu_lang`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_navmenu_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` int(11) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` int(11) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=399 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_tpl_mark`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_tpl_mark` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` int(32) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` varchar(50) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '1' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=2022 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}linkeddata_website_lang`
--

CREATE TABLE IF NOT EXISTS `{prefix}linkeddata_website_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `item_id` int(10) unsigned NOT NULL COMMENT '被关联编号|多的对象的编号|show|text',
  `rel_id` int(11) NOT NULL COMMENT '关联编号|一的对象的编号|show|text',
  `extend` int(11) NOT NULL DEFAULT '0' COMMENT '扩展信息|如标签关联的分类信息等|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护人|文件审核人|show',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='关联数据|信息项目与资源的关联关系表' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}log`
--

CREATE TABLE IF NOT EXISTS `{prefix}log` (
  `IP` varchar(255) NOT NULL COMMENT 'IP|长度范围：2~255。|show,search|text',
  `url` varchar(255) DEFAULT NULL COMMENT '链接|合法的URL发址',
  `broswer` text COMMENT '浏览器|长度255字以内。||textarea',
  `action` varchar(50) DEFAULT NULL COMMENT ' 动作|执行的操作|show',
  `model` varchar(50) DEFAULT NULL COMMENT '模块|访问的模块|show',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '基础表ID|当所属的基础表',
  KEY `AK_ip` (`IP`),
  KEY `AK_action` (`action`),
  KEY `AK_model` (`model`),
  KEY `AK_base_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='访问日志|系统访问日志' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}mark`
--

CREATE TABLE IF NOT EXISTS `{prefix}mark` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '标识|长度范围：2~255。|show,search|textarea',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '操作人|用户|hide',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='语言标识|语言标识模块' AUTO_INCREMENT=572 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}message`
--

CREATE TABLE IF NOT EXISTS `{prefix}message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '称呼|长度范围：2~255。|show,search|text',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱|用户邮箱地址|show|text',
  `parent_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属分类|请正确选取|show|select',
  `content` text NOT NULL COMMENT '详细内容|长度10000字以内。||editor',
  `ip` varchar(50) NOT NULL COMMENT 'IP|留言都使用的IP地址|show|text',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态|1正在处理,2删除,3解决',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL DEFAULT '-1' COMMENT '维护人|最后一次修改人员|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='访客留言|访客的疑问或是意见反馈' AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}modelmanager`
--

CREATE TABLE IF NOT EXISTS `{prefix}modelmanager` (
  `sort_num` double unsigned NOT NULL DEFAULT '9999' COMMENT '排序|只能是数字，默认为：当前时间。|show,asc|text',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID|编号系统生成|show|hidden',
  `name` varchar(50) NOT NULL COMMENT '名称|模块名称|show|text',
  `identifier` varchar(30) NOT NULL COMMENT '标识|模块标识，唯一|show|text',
  `description` varchar(255) DEFAULT NULL COMMENT '介绍|描述说明|show|textarea',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级模块|上层模板编号|show|tree',
  `type` int(11) NOT NULL DEFAULT '424' COMMENT '类型|模块所在的栏目|show,search|select',
  `image_path` varchar(255) DEFAULT NULL COMMENT '封面|模块LOGO|show|image',
  `has_multi_lang` tinyint(4) NOT NULL DEFAULT '1' COMMENT '多语言|是否支持多语言|show|checkbox',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护员|上一次修改的管理员|show',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='框架核心表，用来存储当前模块信息。' AUTO_INCREMENT=298 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}navmenu`
--

CREATE TABLE IF NOT EXISTS `{prefix}navmenu` (
  `sort_num` double unsigned NOT NULL DEFAULT '999' COMMENT '排序|只能是数字，默认为：当前时间。|show,asc|text',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '标题|长度范围：2~255。|show,search|text',
  `url` varchar(255) NOT NULL COMMENT '跳转链接|合法的URL发址|show',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类|请正确选取|show|tree',
  `position_id` int(11) NOT NULL DEFAULT '0' COMMENT '位置|菜单显示的位置|show|select',
  `description` text COMMENT '内容简介|长度255字以内。||textarea',
  `target` varchar(50) NOT NULL DEFAULT '_self' COMMENT '打开位置|_self本窗口、_blank新开窗口、自定义|show|text',
  `extend` varchar(255) DEFAULT NULL COMMENT '自定义数据|如标识、扩展类名等|hide|text',
  `lang_id` int(11) NOT NULL DEFAULT '454' COMMENT '语言|对应语言|show|select',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10||datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护员|所属会员',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`),
  KEY `AK_sort_num` (`sort_num`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='导航菜单|网站导航菜单信息。' AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}resource`
--

CREATE TABLE IF NOT EXISTS `{prefix}resource` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '名称|长度范围：2~255。|show,search|text',
  `path` varchar(255) NOT NULL COMMENT '存储位置|请选择允许的类型。|show|file',
  `type` varchar(20) NOT NULL COMMENT '文件类型|文件扩展名|show',
  `fhash` char(40) NOT NULL COMMENT '文件哈希|用于对比文件是否改变|show',
  `total_use` int(11) NOT NULL DEFAULT '0' COMMENT '使用数|默认为0|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL COMMENT '维护员|所属会员|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='文件资源|文件、图片等资源管理' AUTO_INCREMENT=96 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}rights`
--

CREATE TABLE IF NOT EXISTS `{prefix}rights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '名称|长度范围：2~255。|show,search|text',
  `identifier` varchar(50) DEFAULT NULL COMMENT '标识|对应于代码里的模块或方法名称|show',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属模块|请正确选取|show|tree',
  `app` varchar(255) DEFAULT NULL COMMENT '应用|所有在的应用|show',
  `description` text COMMENT '内容简介|长度255字以内。||textarea',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL DEFAULT '-1' COMMENT '维护员|所属会员|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`),
  KEY `AK_en_name` (`identifier`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='权限资源|权限资源管理' AUTO_INCREMENT=563 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}rss`
--

CREATE TABLE IF NOT EXISTS `{prefix}rss` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `email` varchar(60) NOT NULL COMMENT '邮箱地址|订阅都的邮箱地址|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='订阅|订阅信息模块' AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}sharecfg`
--

CREATE TABLE IF NOT EXISTS `{prefix}sharecfg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '昵称|第三方称呼|show|text',
  `user_id` int(11) NOT NULL COMMENT '用户|对应用户编号|show|select',
  `identifier` varchar(50) NOT NULL COMMENT '标识|唯一，建议使用英文|show',
  `token` char(32) NOT NULL COMMENT '口令|认证口令|show|text',
  `content` text COMMENT '内容|验证配置具体内容。|show|code',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '有效时间|口令的有效时间|show|datetime',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态|分享同步状态1,没有,2正在同步|show|checkbox',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10||datetime',
  `author` int(11) NOT NULL COMMENT '维护人|最后一次维护人员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='分享配置|如微博、QQ微博、QQ空间等' AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}sharesetting`
--

CREATE TABLE IF NOT EXISTS `{prefix}sharesetting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '昵称|第三方称呼|show|text',
  `identifier` varchar(50) NOT NULL COMMENT '标识|唯一，建议使用英文|show',
  `appid` char(32) NOT NULL DEFAULT '' COMMENT '口令|认证口令|show|text',
  `content` varchar(100) DEFAULT '' COMMENT '验证链接|key值验证链接。|show|code',
  `key` char(32) NOT NULL DEFAULT '1' COMMENT '认证key值|认证的key值|show|checkbox',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10||datetime',
  `author` int(11) NOT NULL COMMENT '维护人|最后一次维护人员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='分享设置|社交媒体分享的必要信息' AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}staticcfg`
--

CREATE TABLE IF NOT EXISTS `{prefix}staticcfg` (
  `sort_num` double unsigned DEFAULT NULL COMMENT '排序|只能是数字，默认为：当前时间。|show,asc|text',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '标题|长度范围：2~255。|show,search|text',
  `identifier` varchar(50) DEFAULT NULL COMMENT '标识|唯一，建议使用英文|show',
  `content` text COMMENT '内容|静态配置具体内容。|show|textarea',
  `lang_id` int(11) NOT NULL DEFAULT '454' COMMENT '语言|对应语言|show|select',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL COMMENT '维护人|最后一次维护人员|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`),
  KEY `AK_sort_num` (`sort_num`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='静态配置|如热门关键词、热门产品分类等' AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}tags`
--

CREATE TABLE IF NOT EXISTS `{prefix}tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号|系统自动增加|show|hidden',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '名称|标签名称|show|text',
  `hots` int(11) NOT NULL DEFAULT '1' COMMENT '热度|使用量|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间|记录创建时间|show|datetime',
  `author` int(11) NOT NULL DEFAULT '1' COMMENT '维护人|信息最后一次发布人员|show|author',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} AUTO_INCREMENT=94 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}theme`
--

CREATE TABLE IF NOT EXISTS `{prefix}theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '标题|长度范围：2~255。|show,search|text',
  `identifier` varchar(50) NOT NULL COMMENT '标识|跟模板目录名称一致|show|text',
  `description` text NOT NULL COMMENT '模板介绍|模板相关描述信息。|show|textarea',
  `image_path` varchar(255) DEFAULT NULL COMMENT '预览图片|图片地址|show|textarea',
  `tag` varchar(255) DEFAULT 'all' COMMENT '标签|模板的关键词|show|text',
  `publisher` varchar(50) NOT NULL COMMENT '作者|开发作者|show|text',
  `website` varchar(255) DEFAULT '' COMMENT '作者网站|作者个人的网站|show|text',
  `version` varchar(20) NOT NULL DEFAULT '1.0' COMMENT '版本|模板版本号|show|text',
  `status` int(4) NOT NULL DEFAULT '1' COMMENT '状态|1不使用、2使用、3删除|show|select',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show|datetime',
  `author` int(11) NOT NULL DEFAULT '1' COMMENT '作者|用户的ID|show',
  `app` varchar(50) NOT NULL DEFAULT 'cms' COMMENT '应用|适用于的应用名称|show|text',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`),
  KEY `identifier` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='主题风格|主题风格管理模块' AUTO_INCREMENT=475 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}tpl`
--

CREATE TABLE IF NOT EXISTS `{prefix}tpl` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '名称|长度范围：2~255。|show,search|text',
  `app` varchar(50) NOT NULL COMMENT '所属应用|所属的应用|show|text',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10|show',
  `author` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作人|管理人员|show',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='模板|系统里的模板' AUTO_INCREMENT=334 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}translate`
--

CREATE TABLE IF NOT EXISTS `{prefix}translate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `content` text NOT NULL COMMENT '翻译|翻译内容|show|textarea',
  `mark_id` int(11) NOT NULL DEFAULT '0' COMMENT '标识|对应的标识编号|show|text',
  `parent_id` int(11) NOT NULL COMMENT '语言|对应语言的编号|show|select',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|关联添加的时间表|hidedatetime',
  `author` int(11) NOT NULL DEFAULT '1' COMMENT '维护人|文件审核人|hide',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='翻译|语言翻译数据管理模块' AUTO_INCREMENT=390 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}user`
--

CREATE TABLE IF NOT EXISTS `{prefix}user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|系统编号|show|hidden',
  `name` varchar(50) NOT NULL COMMENT '用户名|登录系统使用的账号|show',
  `password` char(32) DEFAULT NULL COMMENT '密码|登录系统密码||password',
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '性别|用户性别：1，男；2，女；3. 其它。|show',
  `birthday` date DEFAULT NULL COMMENT '出生日期|格式：YYYY-MM-DD|hide|date',
  `parent_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属角色|用户所具有的权限|show|select',
  `description` varchar(255) DEFAULT NULL COMMENT '简介|用户信息简介||textarea',
  `image_path` varchar(255) DEFAULT NULL COMMENT '头像|用户头像,支持jpg|show|image',
  `qq` varchar(20) DEFAULT NULL COMMENT 'QQ|常用QQ号|show',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱|常用邮箱地址|show',
  `phone` varchar(30) DEFAULT NULL COMMENT '电话号码|常用电话号码，方便联系|hide',
  `hash` varchar(60) DEFAULT NULL COMMENT '哈希|记录用户的登陆状态||hidden',
  `login_time` int(11) NOT NULL COMMENT '编辑时间|最近一次修改时间||datetime',
  `ip` char(32) NOT NULL COMMENT '登陆IP|上一次登陆IP|hide',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10 08:09:09||datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护员|上一次修改的管理员|show',
  PRIMARY KEY (`id`),
  KEY `user_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='网站的用户列表' AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}website`
--

CREATE TABLE IF NOT EXISTS `{prefix}website` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID|只能是数字|show,desc|hidden',
  `name` varchar(255) NOT NULL COMMENT '网站名称|长度范围：2~255。|show,search|text',
  `image_path` varchar(255) DEFAULT NULL COMMENT '网站LOGO|合法的图片地址，只支持jpg, png图片。|show|image',
  `seo_keywords` varchar(255) DEFAULT NULL COMMENT 'SEO关键字|如公司的经营范围等长度范围：300以内。|show|textarea',
  `seo_desc` varchar(255) DEFAULT NULL COMMENT 'SEO描述|如，公司的经营理念及范围描述长度范围：300以内。|show|textarea',
  `description` text COMMENT '网站简介|长度255字以内。|hidetextarea',
  `copyright` varchar(255) DEFAULT NULL COMMENT '备案编号|可选填 ，如果有备案请填写此项|hidetext',
  `tongji_code` text COMMENT '统计代码|网站使用的统计代码|hide|textarea',
  `lang_id` int(11) NOT NULL DEFAULT '454' COMMENT '语言|网站使用的语言|show|select',
  `is_default` tinyint(4) NOT NULL DEFAULT '1' COMMENT '默认|1否2是|show|checkbox',
  `is_open` tinyint(4) NOT NULL DEFAULT '2' COMMENT '开放|1是,2否|show|checkbox',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间|格式：2013-04-10||datetime',
  `author` int(11) NOT NULL DEFAULT '0' COMMENT '维护员|会员信息',
  PRIMARY KEY (`id`),
  KEY `AK_model_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET={charset} COMMENT='公司信息|公司信息管理模块' AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
