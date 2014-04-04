--
-- 网站数据库"jxby_"备份内容！
--


-- ----------------------------------------

DROP TABLE IF EXISTS `#_article`;
CREATE TABLE `#_article` (`article_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`article_name` varchar(255) NOT NULL , INDEX(`article_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`model_text` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=9 comment='文章';
DROP TABLE IF EXISTS `#_articletype`;
CREATE TABLE `#_articletype` (`articletype_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`articletype_name` varchar(255) NOT NULL , INDEX(`articletype_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=11 comment='文章类型';
DROP TABLE IF EXISTS `#_banner`;
CREATE TABLE `#_banner` (`banner_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`banner_name` varchar(255) NOT NULL , INDEX(`banner_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=5 comment='大图展示';
DROP TABLE IF EXISTS `#_cases`;
CREATE TABLE `#_cases` (`cases_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`cases_name` varchar(255) NOT NULL , INDEX(`cases_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`model_text` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=3 comment='工程案例';
DROP TABLE IF EXISTS `#_casetype`;
CREATE TABLE `#_casetype` (`casetype_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`casetype_name` varchar(255) NOT NULL , INDEX(`casetype_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=2 comment='案例类型';
DROP TABLE IF EXISTS `#_friendlink`;
CREATE TABLE `#_friendlink` (`friendlink_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`friendlink_name` varchar(255) NOT NULL , INDEX(`friendlink_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=3 comment='友情链接';
DROP TABLE IF EXISTS `#_genmodel`;
CREATE TABLE `#_genmodel` (`genmodel_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`model_zh_name` varchar(50) NOT NULL ,
`model_en_name` varchar(30) NULL ,
`model_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`model_show_qcp` smallint(6) NULL ,
`image_path` varchar(255) NULL ,
`create_time` datetime NULL ,
`creator` varchar(50) NULL ,
`menu_flag` smallint(6) NULL DEFAULT '1' ,
`top_flag` smallint(6) NULL DEFAULT '1' ,
`pass_flag` smallint(6) NULL DEFAULT '1' ,
`file_path` varchar(255) NULL ,
`edit_time` datetime NULL ,
`delete_flag` smallint(6) NULL DEFAULT '1' 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=129 comment='框架核心表，用来存储当前模块信息。';
DROP TABLE IF EXISTS `#_message`;
CREATE TABLE `#_message` (`message_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`message_name` varchar(255) NOT NULL , INDEX(`message_name`),
`visitor_name` varchar(50) NULL ,
`model_text` text NULL ,
`model_desc` text NULL ,
`email` varchar(255) NULL ,
`phone` varchar(255) NULL ,
`address` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`total_visits` int(11) NOT NULL ,
`edit_time` datetime NULL , INDEX(`edit_time`),
`create_time` datetime NULL , INDEX(`create_time`),
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=13 comment='访客给网站的留言';
DROP TABLE IF EXISTS `#_navmenu`;
CREATE TABLE `#_navmenu` (`navmenu_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`navmenu_name` varchar(255) NOT NULL , INDEX(`navmenu_name`),
`sort_num` int(11) NOT NULL DEFAULT '9999' , INDEX(`sort_num`),
`parent_id` int(11) NULL DEFAULT '-1' ,
`jump_url` varchar(255) NULL ,
`table_id` varchar(50) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL ,
`edit_time` datetime NOT NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=38 comment='网站导航栏';
DROP TABLE IF EXISTS `#_news`;
CREATE TABLE `#_news` (`news_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`news_name` varchar(255) NOT NULL , INDEX(`news_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`model_text` text NULL ,
`image_path` varchar(255) NULL ,
`menu_flag` int(11) NULL DEFAULT '-1' , INDEX(`menu_flag`),
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL ,
`edit_time` datetime NOT NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=3 comment='公司新闻的详细内容';
DROP TABLE IF EXISTS `#_newstype`;
CREATE TABLE `#_newstype` (`newstype_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`newstype_name` varchar(255) NOT NULL , INDEX(`newstype_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`menu_flag` int(11) NULL DEFAULT '-1' , INDEX(`menu_flag`),
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL ,
`edit_time` datetime NOT NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=3 comment='公司的新闻所属类型';
DROP TABLE IF EXISTS `#_product`;
CREATE TABLE `#_product` (`product_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`product_name` varchar(255) NOT NULL , INDEX(`product_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`model_text` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=3 comment='产品展示';
DROP TABLE IF EXISTS `#_producttype`;
CREATE TABLE `#_producttype` (`producttype_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`producttype_name` varchar(255) NOT NULL , INDEX(`producttype_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`total_visits` bigint(20) NULL DEFAULT '0' ,
`edit_time` datetime NULL ,
`create_time` datetime NULL ,
`author` varchar(50) NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=2 comment='产品类型';
DROP TABLE IF EXISTS `#_user`;
CREATE TABLE `#_user` (`user_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`user_name` varchar(255) NOT NULL , INDEX(`user_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`user_passwd` varchar(32) NOT NULL ,
`parent_id` int(11) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`edit_time` datetime NOT NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=8 comment='网站的用户列表';
DROP TABLE IF EXISTS `#_usertype`;
CREATE TABLE `#_usertype` (`usertype_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`usertype_name` varchar(255) NOT NULL , INDEX(`usertype_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`parent_id` int(11) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`edit_time` datetime NOT NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=4 comment='系统管理者类型';

-- ----------------------------------------

--
-- #_article
--

INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '我是第一篇文章', '9', '我是第一篇文章', '我是第一篇文章', '1', '我是第一篇文章', '&lt;p&gt;我是第一篇文章我是第一篇文章我是第一篇文章我是第一篇文章我是第一篇文章&lt;img src=&quot;http://localhost/hongjuzi-juxibuyi/render/editor/ueditor/server/upload/uploadimages/56911348650628.png&quot; style=&quot;float:none;&quot; title=&quot;1348631770_diagram-02.png&quot; border=&quot;0&quot; hspace=&quot;0&quot; vspace=&quot;0&quot; /&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/article/2012/09/26/48.jpg', '1', '1', '2012-09-26 17:09:25', '2012-09-26 17:09:25', 'admin');
INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('4', '巨布艺网站发布', '9999', '巨布艺网站发布', '巨布艺网站发布', '10', '巨布艺网站发布', '&lt;p&gt;巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布&lt;br /&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://localhost/xyrj-juxibuyi/render/editor/ueditor/server/upload/uploadimages/22921348831462.jpg&quot; style=&quot;float:none;&quot; title=&quot;about-us.jpg&quot; border=&quot;0&quot; hspace=&quot;0&quot; vspace=&quot;0&quot; /&gt;&lt;br /&gt;&lt;/p&gt;', '2', '1', '2012-09-28 19:09:17', '2012-09-28 19:09:17', 'admin');
INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('3', '公司简介', '9999', '巨鑫布艺简介', '巨鑫布艺简介', '5', '巨鑫布艺纺织有限公司是一家集开发设计和生产销售为一体的专业化企业。产品融合欧美流行布艺潮流，以自身独特的艺术特点，主要生产经典提花窗帘布等系列产品，产品销售遍及全国各地并远销欧美、日本、台湾等国家与地区，深受广大客户的青睐与好评巨鑫布艺纺织有限公司是一家集开发设计和生产销售为一体的专业化企业。产品融合欧美流行布艺潮流，以自身独特的艺术特点，主要生产经典提花窗帘布等系列产品，产品销售遍及全国各地并远销欧美、日本、台湾等国家与地区，深受广大客户的青睐与好评.....', '&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;巨鑫布艺纺织有限公司是一家集开发设计和生产销售为一体的专业化企业。产品融合欧美流行布艺潮流，以自身独特的艺术特点，主要生产经典提花窗帘布等系列产品，产品销售遍及全国各地并远销欧美、日本、台湾等国家与地区，深受广大客户的青睐与好评。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;自企业成立之日起，本着“互利互惠，携手共进”的创业思路，企业立足高起点，产品高质量，服务高素质，实实在在做人，踏踏实实做事，给所有合作过的客户留了极其良好的印象。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;巨鑫布艺与您共创灿烂光辉的明天！&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/article/2012/09/28/smallproduct.jpg', '2', '1', '30', '2012-09-28 18:09:19', '2012-09-28 18:09:19', 'admin');
INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('5', '巨布艺网站发布', '9999', '巨布艺网站发布', '巨布艺网站发布', '3', '巨布艺网站发布', '&lt;p&gt;巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布&lt;br /&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://localhost/xyrj-juxibuyi/render/editor/ueditor/server/upload/uploadimages/22921348831462.jpg&quot; style=&quot;float:none;&quot; title=&quot;about-us.jpg&quot; border=&quot;0&quot; hspace=&quot;0&quot; vspace=&quot;0&quot; /&gt;&lt;br /&gt;&lt;/p&gt;', '2', '1', '2012-09-28 19:09:28', '2012-09-28 19:09:28', 'admin');
INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('6', '巨布艺网站发布', '9999', '巨布艺网站发布', '巨布艺网站发布', '10', '巨布艺网站发布', '&lt;p&gt;巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布&lt;br /&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://localhost/xyrj-juxibuyi/render/editor/ueditor/server/upload/uploadimages/22921348831462.jpg&quot; style=&quot;float:none;&quot; title=&quot;about-us.jpg&quot; border=&quot;0&quot; hspace=&quot;0&quot; vspace=&quot;0&quot; /&gt;&lt;br /&gt;&lt;/p&gt;', '2', '1', '6', '2012-09-28 19:09:20', '2012-09-28 19:09:20', 'admin');
INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('7', '巨布艺网站发布', '9999', '巨布艺网站发布', '巨布艺网站发布', '10', '巨布艺网站发布', '&lt;p&gt;巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布&lt;br /&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://localhost/xyrj-juxibuyi/render/editor/ueditor/server/upload/uploadimages/22921348831462.jpg&quot; style=&quot;float:none;&quot; title=&quot;about-us.jpg&quot; border=&quot;0&quot; hspace=&quot;0&quot; vspace=&quot;0&quot; /&gt;&lt;br /&gt;&lt;/p&gt;', '2', '1', '5', '2012-09-28 19:09:34', '2012-09-28 19:09:34', 'admin');
INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('8', '巨布艺网站发布', '9999', '巨布艺网站发布', '巨布艺网站发布', '10', '巨布艺网站发布', '&lt;p&gt;巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布巨布艺网站发布&lt;br /&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://localhost/xyrj-juxibuyi/render/editor/ueditor/server/upload/uploadimages/22921348831462.jpg&quot; style=&quot;float:none;&quot; title=&quot;about-us.jpg&quot; border=&quot;0&quot; hspace=&quot;0&quot; vspace=&quot;0&quot; /&gt;&lt;br /&gt;&lt;/p&gt;', '2', '1', '10', '2012-09-28 19:09:45', '2012-09-28 19:09:45', 'admin');
--
-- #_articletype
--

INSERT INTO `#_articletype` (`articletype_id`, `articletype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '公司概况', '9999', '公司概况', '公司概况', '-1', '公司概况', '2', '1', '2012-09-26 17:09:16', '2012-09-26 17:09:16', 'admin');
INSERT INTO `#_articletype` (`articletype_id`, `articletype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('3', '公司动态', '9999', '公司动态', '公司动态', '-1', '公司动态', '2', '1', '2012-09-26 17:09:02', '2012-09-26 17:09:02', 'admin');
INSERT INTO `#_articletype` (`articletype_id`, `articletype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('10', '新闻', '9999', '巨鑫布艺新闻', '巨鑫布艺新闻', '3', '巨鑫布艺新闻', '2', '1', '2012-09-28 17:09:57', '2012-09-28 17:09:57', 'admin');
INSERT INTO `#_articletype` (`articletype_id`, `articletype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('5', '简介', '9999', '简介', '简介', '1', '简介', '2', '1', '2012-09-26 17:09:16', '2012-09-26 17:09:16', 'admin');
INSERT INTO `#_articletype` (`articletype_id`, `articletype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('6', '文化', '9999', '文化', '文化', '1', '文化', '2', '1', '2012-09-26 17:09:43', '2012-09-26 17:09:43', 'admin');
INSERT INTO `#_articletype` (`articletype_id`, `articletype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('7', '历程', '9999', '历程', '历程', '1', '历程', '2', '1', '2012-09-26 17:09:04', '2012-09-26 17:09:04', 'admin');
INSERT INTO `#_articletype` (`articletype_id`, `articletype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('8', '荣誉', '9999', '荣誉', '荣誉', '1', '荣誉', '2', '1', '2012-09-26 17:09:20', '2012-09-26 17:09:20', 'admin');
--
-- #_banner
--

INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '经典欧式系列', '9999', '经典欧式系列', '经典欧式系列', '-1', '经典欧式系列', 'public/resource/images/banner/2012/09/28/1.jpg', '2', '1', '2012-09-26 17:09:30', '2012-09-26 17:09:30', 'admin');
INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('2', '简约欧式系列', '9999', '简约欧式系列', '简约欧式系列', '-1', '简约欧式系列', 'public/resource/images/banner/2012/09/28/2.jpg', '2', '1', '2012-09-28 17:09:58', '2012-09-28 17:09:58', 'admin');
INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('3', '美式田园系列', '9999', '美式田园系列', '美式田园系列', '-1', '美式田园系列', 'public/resource/images/banner/2012/09/28/3.jpg', '2', '1', '2012-09-28 17:09:23', '2012-09-28 17:09:23', 'admin');
INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `jump_url`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('4', '简约休闲系列', '9999', '简约休闲系列', '简约休闲系列', '-1', '/index.php', '简约休闲系列', 'public/resource/images/banner/2012/09/28/4.jpg', '2', '1', '2', '2012-09-28 17:09:41', '2012-09-28 17:09:41', 'admin');
--
-- #_cases
--

INSERT INTO `#_cases` (`cases_id`, `cases_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('1', '精品案例一', '9999', '精品案例一', '精品案例一', '1', '产品系列：	简约欧式系列
产品名称：	巨鑫布艺窗帘
产品型号：	巨鑫布艺窗帘
产品宽幅：	巨鑫布艺窗帘', '&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;有限公司是一家集开发设计和生产销售为一体的专业化企业。产品融合欧美流行布艺潮流，以自身独特的艺术特点，主要生产经典提花窗帘布等系列产品，产品销售遍及全国各地并远销欧美、日本、台湾等国家与地区，深受广大客户的青睐与好评。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;自企业成立之日起，本着“互利互惠，携手共进”的创业思路，企业立足高起点，产品高质量，服务高素质，实实在在做人，踏踏实实做事，给所有合作过的客户留了极其良好的印象。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/cases/2012/09/28/HehEtrle.jpg', '2', '1', '4', '2012-09-28 15:09:13', '2012-09-28 15:09:13', 'admin');
INSERT INTO `#_cases` (`cases_id`, `cases_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('2', '精品案例2', '9999', '精品案例2', '精品案例2', '1', '产品系列：	简约欧式系列
产品名称：	巨鑫布艺窗帘
产品型号：	巨鑫布艺窗帘
产品宽幅：	巨鑫布艺窗帘', '&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;有限公司是一家集开发设计和生产销售为一体的专业化企业。产品融合欧美流行布艺潮流，以自身独特的艺术特点，主要生产经典提花窗帘布等系列产品，产品销售遍及全国各地并远销欧美、日本、台湾等国家与地区，深受广大客户的青睐与好评。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;自企业成立之日起，本着“互利互惠，携手共进”的创业思路，企业立足高起点，产品高质量，服务高素质，实实在在做人，踏踏实实做事，给所有合作过的客户留了极其良好的印象。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/cases/2012/09/28/HehEtrle.jpg', '2', '1', '22', '2012-09-28 15:09:20', '2012-09-28 15:09:20', 'admin');
--
-- #_casetype
--

INSERT INTO `#_casetype` (`casetype_id`, `casetype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '案例系列一', '9999', '案例系列一', '案例系列一', '-1', '案例系列一', '2', '1', '2012-09-28 15:09:39', '2012-09-28 15:09:39', 'admin');
--
-- #_friendlink
--

INSERT INTO `#_friendlink` (`friendlink_id`, `friendlink_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '中国家纺网', '9999', '中国家纺网', '中国家纺网', '-1', '中国家纺网', '2', '1', '2012-09-28 17:09:58', '2012-09-28 17:09:58', 'admin');
INSERT INTO `#_friendlink` (`friendlink_id`, `friendlink_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('2', '怀化学院软件创新基地', '9999', '怀化学院软件创新基地', '怀化学院软件创新基地', '-1', 'http://xyrj.hhtc.edu.cn', '怀化学院软件创新基地', '2', '1', '2012-09-28 17:09:21', '2012-09-28 17:09:21', 'admin');
--
-- #_genmodel
--

INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('77', '导航菜单', 'navmenu', '网站导航栏', '-1', '2', 'public/resource/images/genmodel/navigator.jpg', '2012-04-26 09:04:32', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('128', '友情链接', 'friendlink', '友情链接', '-1', '2', 'public/resource/images/genmodel/friend-link-icon.jpg', '2012-09-28 17:09:25', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('126', '产品类型', 'producttype', '产品类型', '-1', '2', 'public/resource/images/genmodel/producttype-icon.jpg', '2012-09-28 15:09:56', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('127', '产品展示', 'product', '产品展示', '126', '2', 'public/resource/images/genmodel/product-icon.jpg', '2012-09-28 15:09:46', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('122', '案例类型', 'casetype', '案例类型', '-1', '2', 'public/resource/images/genmodel/casetype-icon.jpg', '2012-09-28 15:09:59', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('123', '工程案例', 'cases', '工程案例', '122', '2', 'public/resource/images/genmodel/cases-icon.jpg', '2012-09-28 15:09:39', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('117', '大图展示', 'banner', '大图展示', '-1', '2', 'public/resource/images/genmodel/banner-icon-1.jpg', '2012-09-26 17:09:13', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('116', '访客留言', 'message', '访客留言', '-1', '2', 'public/resource/images/genmodel/message-icon-1.jpg', '2012-09-26 17:09:29', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('113', '文章类型', 'articletype', '文章类型', '-1', '2', 'public/resource/images/genmodel/documents.jpg', '2012-09-26 17:09:43', '1', '1', '2', '1');
INSERT INTO `#_genmodel` (`genmodel_id`, `model_zh_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `create_time`, `menu_flag`, `top_flag`, `pass_flag`, `delete_flag`) VALUES ('114', '文章', 'article', '文章', '113', '2', 'public/resource/images/genmodel/article.jpg', '2012-09-26 17:09:27', '1', '1', '2', '1');
--
-- #_message
--

INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('11', 'test', 'asdf', 'test', '邮箱', '电话', '2', '2', '2012-09-30 11:09:03', '2012-09-30 11:09:03');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('12', 'test', 'asdf', 'test', '邮箱', '电话', '2', '2', '2012-09-30 11:09:51', '2012-09-30 11:09:51');
--
-- #_navmenu
--

INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '首页', '9', '-1', 'index.php', '网站主页', '2', '1', '2012-04-26 09:04:45', '2012-04-26 09:04:45', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `table_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('19', '公司概况', '19', '-1', 'index.php/article/type?id=1', 'companyinfo:1', '公司概况', '2', '1', '2012-04-27 11:04:43', '2012-04-27 11:04:43', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('20', '产品展示', '29', '-1', 'index.php/product', '产品展示', '2', '1', '2012-04-27 18:04:34', '2012-04-27 18:04:34', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('21', '工程案例', '49', '-1', 'index.php/cases', '工程案例', '2', '1', '2012-04-27 18:04:29', '2012-04-27 18:04:29', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('29', '公司动态', '27', '-1', 'index.php/article/type?id=3', '我们的动态信息。', '2', '1', '2012-06-26 23:06:32', '2012-06-26 23:06:32', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('28', '招商加盟', '69', '-1', 'index.php/article/type?id=28', '招商加盟', 'public/resource/images/navmenu/2012/05/24/24.jpg', '2', '1', '2012-05-24 00:05:30', '2012-05-24 00:05:30', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('30', '联系我们', '9999', '-1', 'index.php/message', '联系我们', '2', '1', '2012-09-26 17:09:17', '2012-09-26 17:09:17', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('33', '简介', '20', '19', 'index.php/article/type?id=5', '公司简介', '2', '1', '2012-09-28 16:09:46', '2012-09-28 16:09:46', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('34', '文化', '22', '19', 'index.php/article/type?id=7', '公司文化', '2', '1', '2012-09-28 16:09:12', '2012-09-28 16:09:12', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('35', '历程', '21', '19', 'index.php/article/type?id=6', '公司历程', '2', '1', '2012-09-28 16:09:37', '2012-09-28 16:09:37', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('36', '荣誉', '23', '19', 'index.php/article/type?id=8', '公司荣誉', '2', '1', '2012-09-28 16:09:48', '2012-09-28 16:09:48', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('37', '新闻', '28', '29', 'index.php/article/type?id=10', '公司新闻', '2', '1', '2012-09-28 16:09:59', '2012-09-28 16:09:59', 'admin');
--
-- #_news
--

INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `menu_flag`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('1', '新闻信息一', '9999', '新闻信息一', '新闻信息一新闻信息一', '1', '新闻信息一新闻信息一新闻信息一', '&lt;p&gt;&lt;span style=&quot;font-size:12px;font-family:arial, verdana;&quot;&gt;新闻信息一新闻信息一新闻信息一新闻信息一&lt;/span&gt;&lt;/p&gt;', 'public/resource/images/news/2012/06/28/23.jpg', '-1', '2', '1', '37', '2012-04-27 12:04:14', '2012-04-27 12:04:14', 'admin');
INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `menu_flag`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('2', '新闻信息二', '9999', '新闻信息二', '新闻信息二新闻信息二', '2', '新闻信息二新闻信息二', '&lt;p&gt;&lt;span style=&quot;font-size:12px;font-family:arial, verdana;&quot;&gt;新闻信息二新闻信息二新闻信息二新闻信息二&lt;/span&gt;&lt;/p&gt;', 'public/resource/images/news/2012/06/28/13.jpg', '-1', '2', '1', '83', '2012-04-27 12:04:37', '2012-04-27 12:04:37', 'admin');
--
-- #_newstype
--

INSERT INTO `#_newstype` (`newstype_id`, `newstype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `menu_flag`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '新闻类型一', '9999', '新闻类型一新闻类型一', '新闻类型一新闻类型一新闻类型一', '-1', '新闻类型一新闻类型一新闻类型一新闻类型一', 'public/resource/images/genmodel/2012/04/27/18.jpg', '-1', '2', '2', '2012-04-27 12:04:36', '2012-04-27 12:04:36', 'admin');
INSERT INTO `#_newstype` (`newstype_id`, `newstype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `menu_flag`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('2', '新闻类型二', '9999', '新闻类型二新闻类型二', '新闻类型二新闻类型二新闻类型二', '-1', '新闻类型二新闻类型二新闻类型二新闻类型二', 'public/resource/images/genmodel/2012/04/27/62.jpg', '-1', '2', '2', '2012-04-27 12:04:52', '2012-04-27 12:04:52', 'admin');
--
-- #_product
--

INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('1', '巨鑫布艺窗帘', '9999', '巨鑫布艺窗帘', '巨鑫布艺窗帘', '1', '产品系列：	简约欧式系列
产品名称：	巨鑫布艺窗帘
产品型号：	巨鑫布艺窗帘
产品宽幅：	巨鑫布艺窗帘', '&lt;p&gt;&lt;span style=&quot;white-space:nowrap;&quot;&gt;产品系列：简约欧式系列&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:nowrap;&quot;&gt;产品名称：巨鑫布艺窗帘&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:nowrap;&quot;&gt;产品型号：巨鑫布艺窗帘&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:nowrap;&quot;&gt;产品宽幅：巨鑫布艺窗帘&lt;/span&gt;&lt;/p&gt;', 'public/resource/images/product/2012/09/28/HehEtrle.jpg', '2', '1', '7', '2012-09-28 15:09:57', '2012-09-28 15:09:57', 'admin');
INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('2', '巨鑫布艺窗帘二', '9999', '巨鑫布艺窗帘二', '巨鑫布艺窗帘二', '1', '产品系列：	简约欧式系列
产品名称：	巨鑫布艺窗帘
产品型号：	巨鑫布艺窗帘
产品宽幅：	巨鑫布艺窗帘', '&lt;p&gt;&lt;span style=&quot;white-space:nowrap;&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;有限公司是一家集开发设计和生产销售为一体的专业化企业。产品融合欧美流行布艺潮流，以自身独特的艺术特点，主要生产经典提花窗帘布等系列产品，产品销售遍及全国各地并远销欧美、日本、台湾等国家与地区，深受广大客户的青睐与好评。&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;自企业成立之日起，本着“互利互惠，携手共进”的创业思路，企业立足高起点，产品高质量，服务高素质，实实在在做人，踏踏实实做事，给所有合作过的客户留了极其良好的印象。&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:nowrap;&quot;&gt;&lt;/span&gt;&lt;/p&gt;', 'public/resource/images/product/2012/09/28/HehEtrle.jpg', '2', '1', '16', '2012-09-28 15:09:36', '2012-09-28 15:09:36', 'admin');
--
-- #_producttype
--

INSERT INTO `#_producttype` (`producttype_id`, `producttype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '简约欧式系列', '9999', '简约欧式系列', '简约欧式系列', '-1', '简约欧式系列', 'public/resource/images/producttype/2012/09/28/HehEtrle.jpg', '2', '1', '2012-09-28 15:09:20', '2012-09-28 15:09:20', 'admin');
--
-- #_user
--

INSERT INTO `#_user` (`user_id`, `user_name`, `sort_num`, `user_passwd`, `parent_id`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('6', 'test', '9999', '098f6bcd4621d373cade4e832627b4f6', '1', '2', '1', '2012-09-27 19:09:46', '2012-09-27 19:09:46', 'admin');
--
-- #_usertype
--

INSERT INTO `#_usertype` (`usertype_id`, `usertype_name`, `sort_num`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '超级管理员', '9999', '系统的最高权限用户', '2', '2', '2012-04-21 11:04:25', '2012-04-21 11:04:25', 'xjiujiu');
INSERT INTO `#_usertype` (`usertype_id`, `usertype_name`, `sort_num`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('3', 'test', '9999', '2', 'eeee', '2', '2', '2012-09-27 20:09:42', '2012-09-27 20:09:42', '土豆');
