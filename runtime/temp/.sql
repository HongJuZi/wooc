--
-- 网站数据库"xyrj_hongjuzi"备份内容！
--


-- ----------------------------------------

DROP TABLE IF EXISTS `#_actor`;
CREATE TABLE `#_actor` (`name` varchar(255) NOT NULL , INDEX(`name`),
`resource` varchar(255) NULL DEFAULT '-1' ,
`description` varchar(255) NULL ,
`base_id` int(11) NULL , INDEX(`base_id`)
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment= comment='角色|角色信息表';
DROP TABLE IF EXISTS `#_article`;
CREATE TABLE `#_article` (`sort_num` mediumint(9) NOT NULL DEFAULT '9999' , INDEX(`sort_num`),
`id` int(11) unsigned NOT NULL auto_increment PRIMARY KEY,
`name` varchar(255) NOT NULL , INDEX(`name`),
`seo_name` varchar(255) NULL ,
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`jump_url` varchar(255) NULL ,
`parent_id` int(11) NULL DEFAULT '-1' ,
`tags` varchar(225) NULL ,
`description` text NULL ,
`content` text NULL ,
`image_path` varchar(255) NULL ,
`has_video` enum('1','2') NOT NULL DEFAULT '1' ,
`has_music` enum('1','2') NOT NULL DEFAULT '1' ,
`recommend` enum('是','否') NOT NULL DEFAULT '否' ,
`status` tinyint(4) unsigned NULL DEFAULT '1' ,
`pass` enum('是','否') NULL DEFAULT '是' , INDEX(`pass`),
`top` enum('是','否') NOT NULL DEFAULT '否' , INDEX(`top`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP' ,
`author` int(11) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=6 comment='文章|文章信息模块';
DROP TABLE IF EXISTS `#_banner`;
CREATE TABLE `#_banner` (`id` int(11) NOT NULL auto_increment PRIMARY KEY,
`name` varchar(255) NOT NULL , INDEX(`name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`jump_url` varchar(255) NULL ,
`description` text NULL ,
`image_path` varchar(255) NULL ,
`menu_flag` int(11) NULL DEFAULT '-1' , INDEX(`menu_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=8 comment='首页广告大图';
DROP TABLE IF EXISTS `#_category`;
CREATE TABLE `#_category` (`sort_num` int(11) unsigned NOT NULL DEFAULT '9999' , INDEX(`sort_num`),
`id` int(11) unsigned NOT NULL auto_increment PRIMARY KEY,
`name` varchar(255) NOT NULL , INDEX(`name`),
`en_name` varchar(255) NOT NULL ,
`parent_id` int(11) NULL DEFAULT '-1' ,
`parent_path` varchar(255) NULL ,
`description` text NULL ,
`image_path` varchar(255) NULL ,
`top_flag` enum('否','是') NULL DEFAULT '否' ,
`create_time` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP' ,
`author` int(11) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=11 comment='信息分类|后台信息分类模块';
DROP TABLE IF EXISTS `#_datamodel`;
CREATE TABLE `#_datamodel` (`datamodel_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`datamodel_name` varchar(255) NOT NULL , INDEX(`datamodel_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`model_desc` text NULL ,
`has_fields` varchar(255) NOT NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=3 comment='数据模型';
DROP TABLE IF EXISTS `#_field`;
CREATE TABLE `#_field` (`field_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`field_name` varchar(255) NOT NULL , INDEX(`field_name`),
`field_zh_name` varchar(255) NOT NULL ,
`field_sql` varchar(255) NOT NULL ,
`field_config` text NOT NULL ,
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=31 comment='模块字段';
DROP TABLE IF EXISTS `#_files`;
CREATE TABLE `#_files` (`name` varchar(255) NULL ,
`description` varchar(255) NULL ,
`path` varchar(255) NULL ,
`pass_flag` enum('不通过','通过','未审核') NULL DEFAULT '通过' , INDEX(`pass_flag`),
`base_id` int(11) NULL , INDEX(`base_id`)
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment= comment='系统文件|文件管理';
DROP TABLE IF EXISTS `#_goods`;
CREATE TABLE `#_goods` (`name` varchar(255) NULL ,
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`jump_url` varchar(255) NULL ,
`tags` varchar(225) NULL ,
`market_price` float NULL ,
`price` float NULL ,
`grade` float NULL ,
`content` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` enum('不通过','通过','未审核') NULL DEFAULT '通过' , INDEX(`pass_flag`),
`top_flag` enum('否','是') NULL DEFAULT '否' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`id` int(11) NULL , INDEX(`id`)
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment= comment='商品|商品信息表';
DROP TABLE IF EXISTS `#_item`;
CREATE TABLE `#_item` (`sort_num` mediumint(9) NOT NULL DEFAULT '9999' , INDEX(`sort_num`),
`id` int(11) unsigned NOT NULL auto_increment PRIMARY KEY,
`parent_id` int(11) unsigned NULL ,
`create_time` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP' ,
`author` int(11) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=28 comment='基础信息表';
DROP TABLE IF EXISTS `#_langmask`;
CREATE TABLE `#_langmask` (`words` varchar(255) NOT NULL  PRIMARY KEY,
`id` int(11) NULL , INDEX(`id`)
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment= comment='站位|语言标记表';
DROP TABLE IF EXISTS `#_language`;
CREATE TABLE `#_language` (`mask_id` int(11) NOT NULL ,
`words` varchar(255) NOT NULL  PRIMARY KEY,
`id` int(11) NULL , INDEX(`id`)
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment= comment='语言|语言配置';
DROP TABLE IF EXISTS `#_link`;
CREATE TABLE `#_link` (`name` varchar(100) NULL ,
`jump_url` varchar(255) NULL ,
`description` varchar(255) NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` enum('是','否') NULL DEFAULT '是' , INDEX(`pass_flag`),
`top_flag` enum('否','是') NULL DEFAULT '否' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`id` int(11) NULL , INDEX(`id`)
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment= comment='友情链接|友情链接表';
DROP TABLE IF EXISTS `#_log`;
CREATE TABLE `#_log` (`IP` varchar(255) NOT NULL , INDEX(`IP`),
`url` varchar(255) NULL ,
`broswer` text NULL ,
`action` varchar(50) NULL , INDEX(`action`),
`model` varchar(50) NULL , INDEX(`model`),
`id` int(11) NULL , INDEX(`id`)
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment= comment='访问日志|系统访问日志';
DROP TABLE IF EXISTS `#_message`;
CREATE TABLE `#_message` (`id` int(11) NOT NULL auto_increment PRIMARY KEY,
`name` varchar(255) NOT NULL , INDEX(`name`),
`visitor_name` varchar(50) NULL ,
`company_name` varchar(255) NULL ,
`content` text NULL ,
`email` varchar(255) NULL ,
`phone` varchar(255) NULL ,
`address` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=18 comment='访客给网站的留言';
DROP TABLE IF EXISTS `#_modelmanager`;
CREATE TABLE `#_modelmanager` (`id` int(11) NOT NULL auto_increment PRIMARY KEY,
`name` varchar(50) NOT NULL ,
`en_name` varchar(30) NULL ,
`sort_num` int(11) NOT NULL DEFAULT '9999' ,
`description` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`on_desktop` enum('是','否') NULL DEFAULT '是' ,
`image_path` varchar(255) NULL ,
`menu_flag` smallint(6) NULL DEFAULT '1' ,
`top_flag` smallint(6) NULL DEFAULT '1' ,
`pass_flag` smallint(6) NULL DEFAULT '1' ,
`edit_time` datetime NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=201 comment='框架核心表，用来存储当前模块信息。';
DROP TABLE IF EXISTS `#_navmenu`;
CREATE TABLE `#_navmenu` (`id` int(11) NOT NULL auto_increment PRIMARY KEY,
`name` varchar(255) NOT NULL , INDEX(`name`),
`sort_num` int(11) NOT NULL DEFAULT '9999' , INDEX(`sort_num`),
`parent_id` int(11) NULL DEFAULT '-1' ,
`jump_url` varchar(255) NULL ,
`description` text NULL ,
`image_path` varchar(255) NULL ,
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL ,
`create_time` date NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=53 comment='网站导航栏';
DROP TABLE IF EXISTS `#_user`;
CREATE TABLE `#_user` (`id` int(11) NOT NULL auto_increment PRIMARY KEY,
`name` varchar(255) NOT NULL , INDEX(`name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`password` varchar(32) NOT NULL ,
`parent_id` int(11) NULL ,
`description` text NULL ,
`image_path` varchar(255) NULL ,
`email` varchar(50) NOT NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`edit_time` datetime NOT NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=8 comment='网站的用户列表';
DROP TABLE IF EXISTS `#_usertype`;
CREATE TABLE `#_usertype` (`id` int(11) NOT NULL auto_increment PRIMARY KEY,
`name` varchar(255) NOT NULL , INDEX(`name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`parent_id` int(11) NULL ,
`description` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`edit_time` datetime NOT NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=3 comment='系统管理者类型';

-- ----------------------------------------

--
-- #_actor
--

--
-- #_article
--

INSERT INTO `#_article` (`sort_num`, `id`, `name`, `seo_name`, `seo_keywords`, `seo_desc`, `parent_id`, `description`, `content`, `image_path`, `has_video`, `has_music`, `recommend`, `status`, `pass`, `top`, `total_visits`, `create_time`, `author`) VALUES ('9999', '1', '我是一个新闻', '我是一个新闻', '我是一个新闻', '我是一个新闻', '3', '我是一个新闻', '&lt;p&gt;我是一个新闻我是一个新闻我是一个新闻&lt;/p&gt;', 'public/resource/1371993918122300.jpg', '1', '1', '是', '1', '否', '是', '66', '2013-06-19 12:06:02', '5');
INSERT INTO `#_article` (`sort_num`, `id`, `name`, `seo_keywords`, `seo_desc`, `parent_id`, `description`, `content`, `image_path`, `has_video`, `has_music`, `recommend`, `status`, `pass`, `top`, `total_visits`, `create_time`) VALUES ('9999', '2', '我是一个作品', '我是一个作品', '我是一个作品', '5', '我是一个作品', '&lt;p&gt;我是一个作品我是一个作品我是一个作品我是一个作品&lt;/p&gt;', 'public/resource/1371993957895100.jpg', '1', '1', '是', '1', '否', '是', '66', '2013-06-23 21:06:31');
INSERT INTO `#_article` (`sort_num`, `id`, `name`, `seo_keywords`, `seo_desc`, `parent_id`, `tags`, `description`, `content`, `image_path`, `has_video`, `has_music`, `recommend`, `status`, `pass`, `top`, `total_visits`, `create_time`, `author`) VALUES ('9999', '3', '我是一个作品', '我是一个作品', '我是一个作品', '5', ',产品,图片,作品,', '我是一个作品', '&lt;p&gt;我是一个作品我是一个作品我是一个作品我是一个作品我是一个作品asdfasdfasdf&lt;/p&gt;', 'public/resource/13719939711671600.jpg', '1', '1', '是', '1', '是', '是', '66', '2013-06-23 21:06:58', '5');
INSERT INTO `#_article` (`sort_num`, `id`, `name`, `seo_name`, `seo_keywords`, `seo_desc`, `parent_id`, `tags`, `description`, `content`, `image_path`, `has_video`, `has_music`, `recommend`, `status`, `pass`, `top`, `total_visits`, `create_time`, `author`) VALUES ('9999', '4', '我是一个作品', 'asdfasdf', '我是一个作品', '我是一个作品', '3', '产品,图片,作品', '我是一个作品我是一个作品我是一个作品我是一个作品', '&lt;p&gt;&lt;embed type=&quot;application/x-shockwave-flash&quot; class=&quot;edui-faked-music&quot; pluginspage=&quot;http://www.macromedia.com/go/getflashplayer&quot; src=&quot;http://box.baidu.com/widget/flash/bdspacesong.swf?from=tiebasongwidget&amp;amp;url=&amp;amp;name=Enjoy&amp;amp;artist=Bjork&amp;amp;extra=Post&amp;amp;autoPlay=false&amp;amp;loop=true&quot; width=&quot;400&quot; height=&quot;95&quot; align=&quot;none&quot; wmode=&quot;transparent&quot; play=&quot;true&quot; loop=&quot;false&quot; menu=&quot;false&quot; allowscriptaccess=&quot;never&quot; allowfullscreen=&quot;true&quot; /&gt;&lt;/p&gt;&lt;p&gt;我是一个作品我是一个作品我是一个作品我是一个作品我是一个作品我是一个作品afasfasdf&lt;br /&gt;&lt;/p&gt;', 'public/resource/1375592173101392367500.png', '1', '2', '是', '1', '是', '是', '66', '2013-06-23 21:06:12', '5');
--
-- #_banner
--

INSERT INTO `#_banner` (`id`, `name`, `sort_num`, `seo_keywords`, `seo_desc`, `jump_url`, `description`, `image_path`, `menu_flag`, `top_flag`, `total_visits`, `create_time`, `author`) VALUES ('4', '怀化学院化工系系站', '9999', '学院软件案例，怀化学院化工系系站', '怀化学院化工系系站', 'http://xyrj.hhtc.edu.cn/index.php/case?id=4', '怀化学院化工系系站，化工系的网上交流、宣传窗口。', 'public/resource/1371994728580200.jpg', '-1', '1', '159', '2012-06-28 00:06:25', 'admin');
INSERT INTO `#_banner` (`id`, `name`, `sort_num`, `seo_keywords`, `seo_desc`, `jump_url`, `description`, `image_path`, `menu_flag`, `top_flag`, `total_visits`, `create_time`, `author`) VALUES ('5', 'UsedGo', '9999', '学院软件案例，交易平台案例，UsedGo，二手交易平台，校园二手交易', '学院软件案例，交易平台案例，UsedGo，二手交易平台，校园二手交易', 'http://xyrj.hhtc.edu.cn/index.php/case?id=2', 'UsedGo-努力打造最实用的校园二手交易平台', 'public/resource/1371994681962100.jpg', '-1', '1', '189', '2012-06-28 00:06:49', 'admin');
INSERT INTO `#_banner` (`id`, `name`, `sort_num`, `seo_keywords`, `seo_desc`, `jump_url`, `description`, `image_path`, `menu_flag`, `top_flag`, `total_visits`, `create_time`, `author`) VALUES ('6', '北京丝彩', '9999', '北京丝彩', '北京丝彩', 'http://xyrj.hhtc.edu.cn/index.php/case?id=3', '北京丝彩', 'public/resource/1371994649165800.jpg', '-1', '1', '147', '2012-06-28 00:06:09', 'admin');
INSERT INTO `#_banner` (`id`, `name`, `sort_num`, `seo_keywords`, `seo_desc`, `description`, `image_path`, `menu_flag`, `top_flag`, `total_visits`, `create_time`, `author`) VALUES ('7', '禧饰软装', '9999', '怀化禧饰软装', '怀化禧饰软装', '怀化禧饰软装', 'public/resource/13719945891296500.jpg', '-1', '1', '389', '2012-10-28 14:10:47', 'admin');
--
-- #_category
--

INSERT INTO `#_category` (`sort_num`, `id`, `name`, `en_name`, `parent_path`, `description`, `top_flag`, `create_time`) VALUES ('9999', '1', '文章', 'article', '::', '文章信息模块', '否', '2013-07-11 15:07:08');
INSERT INTO `#_category` (`sort_num`, `id`, `name`, `en_name`, `parent_id`, `parent_path`, `description`, `top_flag`, `create_time`, `author`) VALUES ('9999', '2', '新闻', 'news', '1', ':2::', '新闻信息模块', '否', '2013-07-11 15:07:47', '5');
INSERT INTO `#_category` (`sort_num`, `id`, `name`, `en_name`, `parent_path`, `description`, `top_flag`, `create_time`) VALUES ('9999', '3', '产品', 'product', '::', '产品信息模块', '否', '2013-07-11 18:07:11');
INSERT INTO `#_category` (`sort_num`, `id`, `name`, `en_name`, `parent_path`, `description`, `top_flag`, `create_time`) VALUES ('9999', '4', '留言', 'message', '::', '用户留言', '否', '2013-07-11 18:07:03');
INSERT INTO `#_category` (`sort_num`, `id`, `name`, `en_name`, `parent_path`, `description`, `top_flag`, `create_time`, `author`) VALUES ('9999', '5', '友情链接', 'link', ':5:', '友情链接表', '否', '2013-07-11 18:07:22', '5');
INSERT INTO `#_category` (`sort_num`, `id`, `name`, `en_name`, `parent_path`, `description`, `top_flag`, `create_time`, `author`) VALUES ('9999', '6', '导航', 'navmenu', ':6:', '网站导航菜单', '否', '2013-07-11 18:07:37', '5');
--
-- #_datamodel
--

INSERT INTO `#_datamodel` (`datamodel_id`, `datamodel_name`, `sort_num`, `model_desc`, `has_fields`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('1', '文章模型', '9999', '详细文章数据表模型', ',2,4,5,6,7,8,9,10,23,24,25,26,30,', '2', '1', '2012-10-29 12:10:18', 'admin');
INSERT INTO `#_datamodel` (`datamodel_id`, `datamodel_name`, `sort_num`, `model_desc`, `has_fields`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('2', '模块类型模型', '9999', '模块类型表', ',2,4,5,6,7,8,10,23,24,25,26,30,', '2', '1', '2012-10-29 12:10:28', 'admin');
--
-- #_field
--

INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('1', 'visitor_name', '游客姓名', '`visitor_name` varchar(50) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; &#039;ASC&#039;,&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-10 21:10:20', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('2', 'sort_num', '排序编号', '`sort_num` int default 999 not null,index (`sort_num`)', ' &#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; &#039;ASC&#039;,&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-10 21:10:47', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('3', 'password', '文本密码', '`password` varchar(32) not null', '&#039;isShowInList&#039; =&gt; false', '9999', '2', '1', '2012-10-10 21:10:49', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('4', 'seo_keywords', 'SEO关键字', '`seo_keywords` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; false', '9999', '2', '1', '2012-10-10 21:10:24', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('5', 'seo_desc', 'SEO描述信息', '`seo_desc` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; false', '9999', '2', '1', '2012-10-10 21:10:02', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('6', 'parent_id', '所属类型', '`parent_id` int null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-10 21:10:34', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('7', 'jump_url', '跳转链接', '`jump_url` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; false', '9999', '2', '1', '2012-10-10 21:10:08', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('8', 'model_desc', '描述信息', '`model_desc` text null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; false', '9999', '2', '1', '2012-10-10 21:10:41', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('9', 'model_text', '文章内容', '`model_text` text null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; false', '9999', '2', '1', '2012-10-10 21:10:11', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('10', 'image_path', '上传图片', '`image_path` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true,&#039;isGenDateDir&#039; =&gt; false,&#039;uploadfile&#039; =&gt; array(&#039;savePath&#039; =&gt; &#039;public/resource/images&#039;,&#039;maxSize&#039; =&gt; 0.5,&#039;supportFileType&#039; =&gt; array(&#039;.jpg&#039;, &#039;.gif&#039;, &#039;.png&#039;)),&#039;zoom&#039; =&gt; array(&#039;list&#039; =&gt; array(60, 60),&#039;m_list&#039; =&gt; array( 280, 145),&#039;qo&#039; =&gt; array(64, 64))', '9999', '2', '1', '2012-10-10 21:10:37', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('11', 'file_path', '上传文件', '`file_path` varchar(255) null', '&#039;isSearch&#039; =&gt; true,&#039;isOrder&#039; =&gt; &#039;ASC&#039;,&#039;isShowInList&#039; =&gt; true,&#039;isGenDateDir&#039; =&gt; true,&#039;uploadfile&#039; =&gt; array(&#039;savePath&#039; =&gt; &#039;public/resource/files&#039;,&#039;maxSize&#039; =&gt; 2,&#039;supportFileType&#039; =&gt; array(&#039;.txt&#039;, &#039;.doc&#039;, &#039;.xls&#039;, &#039;.rar&#039;, &#039;.zip&#039;)', '9999', '2', '1', '2012-10-10 21:10:07', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('12', 'money', '每人单价', '`money` varchar(10) null default 0', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 21:10:14', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('13', 'sex', '性别', '`sex` enum(&#039;男&#039;, &#039;女&#039;) null default &#039;男&#039;', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 21:10:46', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('14', 'start_time', '开始时间', '`start_time` date null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 21:10:22', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('15', 'end_time', '结束时间', '`end_time` date null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 21:10:39', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('16', 'hot_flag', '热门', '`hot_flag` smallint default 2, index(`hot_flag`)', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 21:10:57', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('17', 'recommend_flag', '推荐', '`recommend_flag` smallint default 2, index(`recommend_flag`)', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 21:10:14', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('18', 'card_id', '身份证编号', '`card_id` char(18) not null', '&#039;isSearch&#039; =&gt; true,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 21:10:44', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('19', 'email', '邮箱地址', '`email` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 22:10:09', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('20', 'phone', '电话号码', '`phone` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 22:10:37', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('21', 'address', '详细地址', '`address` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true ', '9999', '2', '1', '2012-10-10 22:10:57', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('22', 'menu_flag', '导航栏标识', '`menu_flag` int default -1,index(`menu_flag`)', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; true,&#039;empty&#039; =&gt; -1,&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-10 22:10:19', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('23', 'pass_flag', '审查标识', '`pass_flag` smallint default 2, index(`pass_flag`)', '&#039;isSearch&#039; =&gt; true,&#039;isOrder&#039; =&gt; &#039;DESC&#039;,&#039;empty&#039; =&gt; 1,&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-10 22:10:56', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('24', 'top_flag', '置顶标识', '`top_flag` smallint default 1, index(`top_flag`)', '&#039;isSearch&#039; =&gt;  false,&#039;isOrder&#039; =&gt; null,&#039;isShowInList&#039; =&gt; false ', '9999', '2', '1', '2012-10-10 22:10:28', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('25', 'create_time', '创建时间', '`create_time` datetime null default null', '&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-10 22:10:56', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('26', 'author', '操作人', '`author` varchar(50) null default null', '&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-10 22:10:19', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('27', 'want_study', '打算学1', '`want_study` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; &#039;ASC&#039;', '9999', '2', '1', '2012-10-15 11:10:49', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('28', 'has_study', '学到了', '`has_study` text null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; &#039;ASC&#039;', '9999', '2', '1', '2012-10-16 12:10:37', 'admin');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('29', 'user_id', '发表用户', '`user_id` int not null, index(`user_id`)', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; &#039;&#039;,&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-16 12:10:59', 'admin');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `create_time`, `author`) VALUES ('30', 'edit_time', '编辑时间', '`edit_time` datetime null', '&#039;isSearch&#039; =&gt; false, 
&#039;isOrder&#039; =&gt; &#039;&#039;, 
&#039;isShowInList&#039; =&gt; false', '9999', '2', '2012-10-29 12:10:33', 'admin');
--
-- #_files
--

--
-- #_goods
--

--
-- #_item
--

INSERT INTO `#_item` (`sort_num`, `id`, `parent_id`, `create_time`, `author`) VALUES ('9999', '18', '5', '2013-07-27 11:07:07', '5');
INSERT INTO `#_item` (`sort_num`, `id`, `create_time`, `author`) VALUES ('9999', '19', '2013-07-27 11:07:07', '5');
INSERT INTO `#_item` (`sort_num`, `id`, `parent_id`, `create_time`, `author`) VALUES ('9999', '20', '5', '2013-07-27 12:07:52', '5');
INSERT INTO `#_item` (`sort_num`, `id`, `parent_id`, `create_time`, `author`) VALUES ('9999', '21', '5', '2013-07-27 13:07:04', '5');
INSERT INTO `#_item` (`sort_num`, `id`, `parent_id`, `create_time`, `author`) VALUES ('9999', '24', '5', '2013-07-27 13:07:28', '5');
INSERT INTO `#_item` (`sort_num`, `id`, `parent_id`, `create_time`, `author`) VALUES ('9999', '23', '5', '2013-07-27 13:07:49', '5');
INSERT INTO `#_item` (`sort_num`, `id`, `parent_id`, `create_time`, `author`) VALUES ('9999', '25', '5', '2013-07-27 13:07:52', '5');
INSERT INTO `#_item` (`sort_num`, `id`, `parent_id`, `create_time`, `author`) VALUES ('9999', '26', '9', '2013-07-27 13:07:08', '5');
INSERT INTO `#_item` (`sort_num`, `id`, `parent_id`, `create_time`, `author`) VALUES ('9999', '27', '2', '2013-07-27 21:07:14', '5');
--
-- #_langmask
--

--
-- #_language
--

--
-- #_link
--

INSERT INTO `#_link` (`name`, `jump_url`, `description`, `image_path`, `pass_flag`, `top_flag`, `id`) VALUES ('test', 'tes', 'tstestset', 'public/resource/13748974221693700.jpg', '是', '否', '18');
INSERT INTO `#_link` (`name`, `jump_url`, `description`, `top_flag`, `id`) VALUES ('xiami', 'http://www.asfd.com', 'xiami', '否', '19');
INSERT INTO `#_link` (`name`, `description`, `image_path`, `pass_flag`, `top_flag`, `id`) VALUES ('德胜桥', '德胜桥', 'public/resource/13749011982295800.jpg', '是', '否', '20');
INSERT INTO `#_link` (`name`, `jump_url`, `description`, `pass_flag`, `top_flag`, `id`) VALUES ('德胜桥2', 'test', 'test', '是', '否', '21');
INSERT INTO `#_link` (`name`, `jump_url`, `description`, `pass_flag`, `top_flag`, `id`) VALUES ('test233', 'test', 'test', '是', '否', '24');
INSERT INTO `#_link` (`name`, `jump_url`, `description`, `image_path`, `pass_flag`, `top_flag`, `id`) VALUES ('test233', 'test', 'test', 'public/resource/13749016362542300.jpg', '是', '否', '23');
INSERT INTO `#_link` (`name`, `jump_url`, `description`, `image_path`, `pass_flag`, `top_flag`, `id`) VALUES ('test233', 'test', 'test', 'public/resource/1374901866278000.jpg', '是', '否', '25');
--
-- #_log
--

--
-- #_message
--

INSERT INTO `#_message` (`id`, `visitor_name`, `content`, `email`, `pass_flag`, `top_flag`, `create_time`) VALUES ('14', 'test', '您的留言内容setewst', 'test@test.com', '2', '2', '2013-07-20 20:07:16');
INSERT INTO `#_message` (`id`, `visitor_name`, `content`, `email`, `pass_flag`, `top_flag`, `create_time`) VALUES ('15', 'test', 'test', 'test@test.com', '2', '2', '2013-07-23 10:07:05');
INSERT INTO `#_message` (`id`, `name`, `content`, `pass_flag`, `top_flag`) VALUES ('16', '投稿给我们-', '<br/>', '2', '2');
INSERT INTO `#_message` (`id`, `name`, `visitor_name`, `content`, `pass_flag`, `top_flag`) VALUES ('17', '投稿给我们-test', 'test', 'test<br/>', '2', '2');
--
-- #_modelmanager
--

INSERT INTO `#_modelmanager` (`id`, `name`, `en_name`, `sort_num`, `description`, `parent_id`, `on_desktop`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`, `author`) VALUES ('77', '导航菜单', 'navmenu', '9999', '网站导航栏', '-1', '是', 'public/resource/images/genmodel/navigator.jpg', '1', '1', '2', '2013-08-08 00:00:00', '5');
INSERT INTO `#_modelmanager` (`id`, `name`, `en_name`, `sort_num`, `description`, `parent_id`, `on_desktop`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`) VALUES ('128', '友情链接', 'friendlink', '9999', '友情链接', '-1', '是', 'public/resource/images/genmodel/friend-link-icon.jpg', '1', '1', '2', '0000-00-00 00:00:00');
INSERT INTO `#_modelmanager` (`id`, `name`, `en_name`, `sort_num`, `description`, `parent_id`, `on_desktop`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`) VALUES ('117', '大图展示', 'banner', '9999', '大图展示', '-1', '是', 'public/resource/images/genmodel/banner-icon-1.jpg', '1', '1', '2', '0000-00-00 00:00:00');
INSERT INTO `#_modelmanager` (`id`, `name`, `en_name`, `sort_num`, `description`, `parent_id`, `on_desktop`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`, `author`) VALUES ('116', '访客留言', 'message', '9999', '访客留言', '-1', '是', 'public/resource/images/genmodel/message-icon-1.jpg', '1', '1', '2', '0000-00-00 00:00:00', 'admin');
INSERT INTO `#_modelmanager` (`id`, `name`, `en_name`, `sort_num`, `description`, `parent_id`, `on_desktop`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`, `author`) VALUES ('164', '信息分类', 'category', '9999', '后台信息分类模块', '-1', '是', 'public/resource/1371991960630000.jpg', '1', '1', '2', '2013-06-17 01:06:50', 'admin');
INSERT INTO `#_modelmanager` (`id`, `name`, `en_name`, `sort_num`, `description`, `parent_id`, `on_desktop`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`, `author`) VALUES ('200', '文章', 'article', '9999', '文章信息模块', '164', '是', 'public/resource/1371991555411100.jpg', '1', '1', '2', '2013-06-18 10:06:11', '5');
--
-- #_navmenu
--

INSERT INTO `#_navmenu` (`id`, `name`, `sort_num`, `parent_id`, `jump_url`, `description`, `top_flag`, `create_time`, `author`) VALUES ('48', '浏览', '1', '-1', 'index.php/works', '浏览', '2', '2013-06-19', '5');
INSERT INTO `#_navmenu` (`id`, `name`, `sort_num`, `parent_id`, `jump_url`, `description`, `top_flag`, `create_time`, `author`) VALUES ('49', '品牌', '5', '-1', 'index.php/brand', '品牌', '2', '2013-06-19', '5');
INSERT INTO `#_navmenu` (`id`, `name`, `sort_num`, `parent_id`, `jump_url`, `description`, `top_flag`, `create_time`, `author`) VALUES ('50', '搜索', '10', '-1', 'index.php/search', '搜索', '2', '2013-06-19', '5');
INSERT INTO `#_navmenu` (`id`, `name`, `sort_num`, `parent_id`, `jump_url`, `description`, `top_flag`, `create_time`, `author`) VALUES ('51', '帮助', '20', '-1', 'index.php/faq', '帮助', '2', '2013-06-19', '5');
--
-- #_user
--

INSERT INTO `#_user` (`id`, `name`, `sort_num`, `password`, `parent_id`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('5', 'admin', '1', '21232f297a57a5a743894a0e4a801fc3', '1', 'public/resource/13720499692878700.jpg', '2', '2', '2012-07-04 10:07:42', '2012-07-04 10:07:42', 'admin');
INSERT INTO `#_user` (`id`, `name`, `sort_num`, `password`, `parent_id`, `description`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('6', 'xyrj', '9999', '355e736be265d0f128bf898a45eb75d5', '2', '网站管理员', '2', '1', '2012-07-06 10:07:43', '2012-07-06 00:00:00', 'admin');
INSERT INTO `#_user` (`id`, `name`, `sort_num`, `password`, `parent_id`, `description`, `pass_flag`, `edit_time`, `create_time`, `author`) VALUES ('7', 'xjiujiu', '99', 'ce12638cd8c8c74f4869e1ab6d093748', '1', '管理员', '2', '2012-07-31 10:07:15', '2012-07-04 10:07:42', 'admin');
--
-- #_usertype
--

INSERT INTO `#_usertype` (`id`, `name`, `sort_num`, `description`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '超级管理员', '9999', '系统的最高权限用户', '2', '2', '2012-04-21 11:04:25', '2012-04-21 11:04:25', 'xjiujiu');
