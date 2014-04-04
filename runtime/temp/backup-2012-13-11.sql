--
-- 网站数据库"xyrj_demo"备份内容！
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
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=4 comment='单页文章信息，如：关于我们，公司介绍等。';
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
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=6 comment='大图展示';
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
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=2 comment='案例详细信息';
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
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=3 comment='案例类型信息';
DROP TABLE IF EXISTS `#_certificate`;
CREATE TABLE `#_certificate` (`certificate_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`certificate_name` varchar(255) NOT NULL , INDEX(`certificate_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`model_text` text NULL ,
`image_path` varchar(255) NULL ,
`start_time` datetime NOT NULL ,
`unit` varchar(255) NOT NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=9 comment='公司所获得的资质荣誉';
DROP TABLE IF EXISTS `#_certificatetype`;
CREATE TABLE `#_certificatetype` (`certificatetype_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`certificatetype_name` varchar(255) NOT NULL , INDEX(`certificatetype_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=4 comment='公司所获得的资质荣誉类型';
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
DROP TABLE IF EXISTS `#_job`;
CREATE TABLE `#_job` (`job_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`job_name` varchar(255) NOT NULL , INDEX(`job_name`),
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
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=8 comment='工作机会信息';
DROP TABLE IF EXISTS `#_jobtype`;
CREATE TABLE `#_jobtype` (`jobtype_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`jobtype_name` varchar(255) NOT NULL , INDEX(`jobtype_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=7 comment='工作类型信息';
DROP TABLE IF EXISTS `#_message`;
CREATE TABLE `#_message` (`message_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`message_name` varchar(255) NOT NULL , INDEX(`message_name`),
`visitor_name` varchar(50) NULL ,
`sort_num` int(11) NOT NULL DEFAULT '9999' ,
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
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=24 comment='访客给网站的留言';
DROP TABLE IF EXISTS `#_modelmanager`;
CREATE TABLE `#_modelmanager` (`modelmanager_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`modelmanager_name` varchar(50) NOT NULL ,
`model_en_name` varchar(30) NULL ,
`sort_num` int(11) NOT NULL DEFAULT '9999' ,
`model_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`model_show_qcp` smallint(6) NULL ,
`image_path` varchar(255) NULL ,
`menu_flag` smallint(6) NULL DEFAULT '1' ,
`top_flag` smallint(6) NULL DEFAULT '1' ,
`pass_flag` smallint(6) NULL DEFAULT '1' ,
`edit_time` datetime NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=160 comment='框架核心表，用来存储当前模块信息。';
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
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=41 comment='网站导航栏';
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
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=9 comment='新闻详细内容';
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
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=6 comment='新闻分类信息';
DROP TABLE IF EXISTS `#_photoalbum`;
CREATE TABLE `#_photoalbum` (`photoalbum_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`photoalbum_name` varchar(255) NOT NULL , INDEX(`photoalbum_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=1 comment='产品相册，案例相册等';
DROP TABLE IF EXISTS `#_picture`;
CREATE TABLE `#_picture` (`picture_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`picture_name` varchar(255) NOT NULL , INDEX(`picture_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`seo_keywords` varchar(255) NULL ,
`seo_desc` varchar(255) NULL ,
`parent_id` int(11) NULL ,
`jump_url` varchar(255) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`hash_code` char(32) NOT NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '1' , INDEX(`top_flag`),
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=1 comment='网站信息所有的图片资源。';
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
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=8 comment='产品详细信息';
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
`create_time` datetime NULL ,
`author` varchar(50) NULL ,
`edit_time` datetime NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=5 comment='产品分类信息';
DROP TABLE IF EXISTS `#_user`;
CREATE TABLE `#_user` (`user_id` int(11) NOT NULL auto_increment PRIMARY KEY,
`user_name` varchar(255) NOT NULL , INDEX(`user_name`),
`sort_num` int(11) NOT NULL DEFAULT '999' , INDEX(`sort_num`),
`user_passwd` varchar(32) NOT NULL ,
`parent_id` int(11) NULL ,
`model_desc` text NULL ,
`image_path` varchar(255) NULL ,
`email` varchar(100) NULL ,
`pass_flag` smallint(6) NULL DEFAULT '2' , INDEX(`pass_flag`),
`top_flag` smallint(6) NULL DEFAULT '2' , INDEX(`top_flag`),
`edit_time` datetime NOT NULL ,
`create_time` datetime NOT NULL ,
`author` varchar(50) NOT NULL 
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=15 comment='网站的用户列表';
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
)engine=MyISAM DEFAULT CHARSET=utf8 auto_increment=5 comment='系统管理者类型';

-- ----------------------------------------

--
-- #_article
--

INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '公司简介', '9999', '公司简介', '公司简介', '-1', '某某公司创立于1996年，从中国早期金融证券资讯服务脱颖而出，建立了第一个财经资讯垂直网站。经过十五年的专注耕耘，和讯网逐步确立了自己在业内的优势地位和品牌影响力......', '&lt;p&gt;&lt;span class=&quot;Dec_Font_Style&quot;&gt;　怀化市鹤城区吉思特种玻璃厂是一家以发展玻璃深加工产品为基础，以专业生产、设计安装于体的玻璃深加工企业。为增强竞争优势，提升传统产业，公司汇集了一批国内资深的技术专家和一支年轻的受过教育、具有丰富实践经验的高素质员工队伍，给企业的发展奠定了坚实的基础。&lt;br /&gt;　　&lt;br /&gt;　　吉思玻璃坚持“以人为本”的人才观，尊重知识，尊重人才，全面推行“展吉思风貌，铸时代精品”的企业经营理念，贯彻“以品牌树形象，以服务争市场”的指导思想。以lS09000质量管理体系的国际质量管理标准模式指导生产经营活动，为客户提供优质的玻璃深加工产品和完善的服务。&lt;br /&gt;　　&lt;br /&gt;　　吉思玻璃公司下属有郴州吉思特种玻璃厂和怀化吉思特种玻璃厂两个深加工基地；公司拥有钢化生产线两条，中空生产线两条、夹胶生产线及配套使用的双边磨边机卧式及立式单边磨边机、及异性机、斜边机等多台套，为公司的生产经营提供优越的条件。&lt;br /&gt;　　&lt;br /&gt;　　吉思玻璃坚持“以人为本”的人才观，尊重知识，尊重人才，全面推行“展吉思风貌，铸时代精品”的企业经营理念，贯彻“以品牌树形象，以服务争市场”的指导思想。以ISO9000质量管理体系的国际质量管理标准模式指导生产经营活动，为客户提供优质的玻璃深加工产品和完善的服务。&lt;br /&gt;　　&lt;br /&gt;　　蓬勃发展的“吉思玻璃”无论在规模、管理、技术、品质、服务等方面均以达到国内领先水平，并向着具有国际水准的一流现代化企业目标迈进。&lt;br /&gt;&lt;br /&gt;　　　　　　　　　　　　　吉思&lt;br /&gt;&lt;br /&gt;　　　　　　　　　　与时俱进的现代化企业！&lt;br /&gt;&lt;br /&gt;主营：湖南怀化钢化玻璃厂;湖南特种钢化玻璃厂;湖南怀化钢化玻璃价格;湖南建筑钢化玻璃价格;湖南怀化钢化玻璃厂招聘;湖南怀化特种玻璃厂招聘;贵州特种钢化玻璃厂;贵州建筑钢化玻璃价格;贵州钢化玻璃价格;贵州中空钢化玻璃价格;贵州钢化玻璃厂招聘;贵州特种玻璃厂招聘;求购建筑钢化玻璃价格;求购怀化建筑钢化玻璃;求购贵州建筑钢化玻璃;湖南钢化玻璃公司;贵州钢化玻璃公司;怀化钢化玻璃厂招聘信息;湖南钢化玻璃厂招聘信息;郴州钢化玻璃厂招聘信息&lt;/span&gt;&lt;/p&gt;', 'public/resource/images/135160447187291018300index_AboutPic.jpg', '2', '2012-10-30 21:10:42', 'admin', '2012-10-30 21:10:42');
INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('3', '单页文章', '9999', '单页', '-1', '测试', '&lt;p&gt;单页文章测试&lt;span&gt;单页文章测试&lt;span&gt;单页文章测试&lt;span&gt;单页文章测试&lt;span&gt;单页文章测试&lt;span&gt;单页文章测试&lt;span&gt;单页文章测试&lt;/span&gt;&lt;span&gt;单页文章测试单页文章测试单页文章测试单页文章测试单页文章测试&lt;span&gt;单页文章测试&lt;/span&gt;&lt;span&gt;单页文章测试单页文章测试单页文章测试单页文章测试单页文章测试&lt;span&gt;单页文章测试&lt;/span&gt;&lt;span&gt;单页文章测试单页文章测试单页文章测试单页文章测试单页文章测试&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-11-02 15:11:39', 'admin', '2012-11-02 15:11:39');
INSERT INTO `#_article` (`article_id`, `article_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', '加盟招商', '9999', '招商加盟', '招商加盟', '-1', '招商加盟', '&lt;strong style=&quot;margin:0px;padding:0px;&quot;&gt;（一）加盟政策&lt;/strong&gt;&lt;div class=&quot;detail-info&quot;&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;1. &amp;nbsp; 销售不利的产品可向总部退货，代理商无须有因产品销售不力而造成积压，代理商在销售不利时可向总部提出退货，总部将按一定折扣回购产品，解决经销商的后顾之忧，实质上与经销商共担经营风险。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;2. &amp;nbsp; 代理商有拿销售不利的产品与热销产品进行等价互换的权利，每一种产品体系的代理在一定的期限内都具有一定比例的换货权力换货可在同一种产品体系内调换，也可以在不同的产品体系之间调换。被换货的进货价格按照各自的价格比例结算。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;3. &amp;nbsp; &amp;nbsp;保护签约代理的利益与市场互动：对于已经签约的代理应保护其在相应的区域内的利益，不允许任何代理在已有独家代理的地区销售相应的产品，区域之间不允许串货。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;4. &amp;nbsp; &amp;nbsp;接受上海兰雀环保设备有限公司的考核，完成任务获得一定奖励。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;5. &amp;nbsp; &amp;nbsp;市级代理商有权发展经销商及零售专卖店，原有经销商划归市级代理商管理；经销商有权发展零售专卖店。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;6. &amp;nbsp; &amp;nbsp;公司将在兰雀网站、宣传产品，媒体广告，及时将有关信息迅速传达给经销商，解除销售商的后顾之忧。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;7. &amp;nbsp; &amp;nbsp;奖励计划（以下奖励计划与经销商签定经销合同时，具体确定奖励数额） （1）年度销售目标达成，按销售额给予一定奖励， （2）优秀经销商奖励给予企业公关活动宣传奖励。&lt;br style=&quot;margin:0px;padding:0px;&quot; /&gt;　&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;&lt;strong style=&quot;margin:0px;padding:0px;&quot;&gt;（二）加盟体系：&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;1. &amp;nbsp; &amp;nbsp;区域总代理：由省（直辖市、自治区）内某区域内形成的，拥有就近原则所组成的二至四个地级市独家代理商。由连续二年完成年度销售任务的市级代理商升级而来，享受区域总代理相应的政策待遇。不直接接受代理申请。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;2. &amp;nbsp; &amp;nbsp; 市级代理商：以一个市级为单位设立市级独家总代理，接受直接申请，也可以由连续两年完成无责任年度销售任务的普通经销商升级而来。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;3. &amp;nbsp; &amp;nbsp; 普通经销商：经商商销售范围不超过地区级行政划分，一般以区县及范围为单位，连续两年完成无责任年度销售任务的普通经销商可升级为市级代理商，享受市级代理商相应的政策待遇。&lt;/p&gt;&lt;p style=&quot;padding:0px;color:#3a3a3a;font-family:����, arial, helvetica, sans-serif;font-size:12px;line-height:24px;text-align:-webkit-left;margin-top:0px;margin-bottom:0px;&quot;&gt;4. &amp;nbsp; &amp;nbsp; 零售专卖店：专卖店为成长必备系列产品的各销售终端，无论哪一级发展的专卖店，进货必须符合成长必备系列产品代理销售政策所规定的统一标准。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;/div&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-10-30 22:10:24', 'admin', '2012-10-30 22:10:24');
--
-- #_banner
--

INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '经典欧式系列', '9999', '经典欧式系列', '经典欧式系列', '-1', '经典欧式系列', 'public/resource/images/banner/135160256997817055800banner02.jpg', '2', '1', '2012-09-26 17:09:30', '2012-09-26 17:09:30', 'admin');
INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('2', '简约欧式系列', '9999', '简约欧式系列', '简约欧式系列', '-1', '简约欧式系列简约欧式系列简约欧式系列', 'public/resource/images/banner/135160253312222767500banner01.jpg', '2', '2', '2012-09-28 17:09:58', '2012-09-28 17:09:58', 'admin');
INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('3', '美式田园系列', '9999', '美式田园系列', '美式田园系列', '-1', '美式田园系列', 'public/resource/images/banner/1351602559173918908800banner01.jpg', '2', '1', '2012-09-28 17:09:23', '2012-09-28 17:09:23', 'admin');
INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `jump_url`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('4', '简约休闲系列', '9999', '简约休闲系列', '简约休闲系列', '-1', '/index.php', '简约休闲系列', 'public/resource/images/banner/135160255118666775100banner03.jpg', '2', '1', '2', '2012-09-28 17:09:41', '2012-09-28 17:09:41', 'admin');
INSERT INTO `#_banner` (`banner_id`, `banner_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('5', '第五个系列', '9999', '第五个系列', '第五个系列', '-1', '第五个系列', 'public/resource/images/banner/1351602542150262617800banner02.jpg', '2', '1', '2012-10-10 11:10:55', '2012-10-10 11:10:55', 'test');
--
-- #_cases
--

INSERT INTO `#_cases` (`cases_id`, `cases_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '煌族大酒店', '9999', '煌族大酒店', '煌族大酒店', '1', '煌族大酒店', '&lt;p&gt;&lt;img src=&quot;http://localhost/xyrj-demo/render/editor/ueditor/php/upload/20121113/13527828633737.jpg&quot; title=&quot;huangzu-01.jpg&quot; /&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/1352782867959700huangzu.jpg', '2', '2012-11-13 13:11:27', 'admin', '2012-11-13 13:11:27');
--
-- #_casetype
--

INSERT INTO `#_casetype` (`casetype_id`, `casetype_name`, `sort_num`, `parent_id`, `model_desc`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', 'jtest', '9999', '-1', 'tttttt', '2', '2012-11-02 10:11:32', 'admin', '2012-11-02 10:11:32');
INSERT INTO `#_casetype` (`casetype_id`, `casetype_name`, `sort_num`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', 'jie7', '9999', '-1', 'ydfh', '2', '2', '2012-11-03 14:11:18', 'admin', '2012-11-03 14:11:18');
--
-- #_certificate
--

INSERT INTO `#_certificate` (`certificate_id`, `certificate_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `start_time`, `unit`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '最受消费者欢迎建材品牌', '9999', '最受消费者欢迎建材品牌', '最受消费者欢迎建材品牌', '1', '最受消费者欢迎建材品牌', '&lt;p&gt;最受消费者欢迎建材品牌&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/13516921973543028580023799.gif', '2011-07-06 22:10:50', '湖南消费者委员会', '2', '2012-10-31 22:10:59', 'admin', '2012-10-31 22:10:59');
INSERT INTO `#_certificate` (`certificate_id`, `certificate_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `start_time`, `unit`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', '国家强制性产品认证证书', '9999', '国家强制性产品认证证书', '国家强制性产品认证证书', '-1', '国家强制性产品认证证书', '&lt;p&gt;国家强制性产品认证证书&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/13516922336695745690023800.gif', '2011-05-04 22:10:20', '国家建材安全检测', '2', '2012-10-31 22:10:18', 'admin', '2012-10-31 22:10:18');
INSERT INTO `#_certificate` (`certificate_id`, `certificate_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `start_time`, `unit`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('3', '玻璃安全检测认证', '9999', '玻璃安全检测认证', '玻璃安全检测认证', '1', '玻璃安全检测认证', '&lt;p&gt;&lt;span id=&quot;ContentPlaceHolder1_Certificate3_span1&quot;&gt;玻璃安全检测认证&lt;/span&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/13516922636279640170023802.gif', '2012-10-10 22:10:50', '湖南工商检验', '2', '2012-10-31 22:10:55', 'admin', '2012-10-31 22:10:55');
INSERT INTO `#_certificate` (`certificate_id`, `certificate_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `start_time`, `unit`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('4', '2007郴州最受消费者喜爱的玻璃工艺品牌', '9999', '2007郴州最受消费者喜爱的玻璃工艺品牌', '2007郴州最受消费者喜爱的玻璃工艺品牌', '-1', '2007郴州最受消费者喜爱的玻璃工艺品牌', '&lt;p&gt;&lt;span id=&quot;ContentPlaceHolder1_Certificate4_span1&quot;&gt;2007郴州最受消费者喜爱的玻璃工艺品牌&lt;/span&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/13516923172528450010075031.JPG', '2012-10-31 22:10:20', '郴州首届家博会组委会', '2', '2012-10-31 22:10:24', 'admin', '2012-10-31 22:10:24');
INSERT INTO `#_certificate` (`certificate_id`, `certificate_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `start_time`, `unit`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('5', '2006郴州最受消费者喜爱的玻璃工艺品牌', '9999', '2006郴州最受消费者喜爱的玻璃工艺品牌', '2006郴州最受消费者喜爱的玻璃工艺品牌', '2', '2006郴州最受消费者喜爱的玻璃工艺品牌', '&lt;p&gt;&lt;span id=&quot;ContentPlaceHolder1_Certificate4_span1&quot;&gt;2006郴州最受消费者喜爱的玻璃工艺品牌&lt;/span&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/135169234111902646230075032.JPG', '2012-10-31 22:10:18', '郴州房屋装饰行业协会', '2', '2012-10-31 22:10:18', 'admin', '2012-10-31 22:10:18');
INSERT INTO `#_certificate` (`certificate_id`, `certificate_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `start_time`, `unit`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('6', '荣誉证书', '9999', '荣誉证书', '荣誉证书', '2', '荣誉证书', '&lt;p&gt;&lt;span id=&quot;ContentPlaceHolder1_Certificate4_span1&quot;&gt;荣誉证书&lt;/span&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/13516923659391221370023797.gif', '2012-10-31 22:10:42', '湖南消费者品牌认证机构', '2', '2012-10-31 22:10:42', 'admin', '2012-10-31 22:10:42');
INSERT INTO `#_certificate` (`certificate_id`, `certificate_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `start_time`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('7', '荣誉', '9999', 'ddd', 'ttt', '2', '测试', '&lt;p&gt;测试测试测试测试测试测试&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试测试测试测试测试测试&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试测试测试测试测试测试&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试测试测试测试测试测试&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/135183739988092053600登录.jpg', '2012-11-02 14:11:01', '2', '2012-11-02 14:11:01', 'admin', '2012-11-02 14:11:01');
INSERT INTO `#_certificate` (`certificate_id`, `certificate_name`, `sort_num`, `parent_id`, `model_text`, `start_time`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('8', 'good', '9999', '-1', '&lt;ol style=&quot;list-style-type:lower-alpha&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0004.gif&quot; /&gt;th&amp;nbsp;njhg,m&amp;nbsp;东方人&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;大v刹为&lt;/p&gt;&lt;/li&gt;&lt;/ol&gt;', '2012-11-03 14:11:37', '2', '2012-11-03 14:11:37', 'admin', '2012-11-03 14:11:37');
--
-- #_certificatetype
--

INSERT INTO `#_certificatetype` (`certificatetype_id`, `certificatetype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '产品类证书', '9999', '产品类证书', '产品类证书', '-1', '产品类证书', '2', '2012-10-31 21:10:12', 'admin', '2012-10-31 21:10:12');
INSERT INTO `#_certificatetype` (`certificatetype_id`, `certificatetype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', '荣誉类证书', '9999', '荣誉类证书', '荣誉类证书', '-1', '荣誉类证书', '2', '2012-10-31 21:10:55', 'admin', '2012-10-31 21:10:55');
INSERT INTO `#_certificatetype` (`certificatetype_id`, `certificatetype_name`, `sort_num`, `parent_id`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('3', '哇哇哇', '9999', '-1', '2', '2012-11-03 14:11:55', 'admin', '2012-11-03 14:11:55');
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
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('27', 'want_study', '打算学', '`want_study` varchar(255) null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; &#039;ASC&#039;', '9999', '2', '1', '2012-10-15 11:10:49', 'test');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('28', 'has_study', '学到了', '`has_study` text null', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; &#039;ASC&#039;', '9999', '2', '1', '2012-10-16 12:10:37', 'admin');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `top_flag`, `create_time`, `author`) VALUES ('29', 'user_id', '发表用户', '`user_id` int not null, index(`user_id`)', '&#039;isSearch&#039; =&gt; false,&#039;isOrder&#039; =&gt; &#039;&#039;,&#039;isShowInList&#039; =&gt; true', '9999', '2', '1', '2012-10-16 12:10:59', 'admin');
INSERT INTO `#_field` (`field_id`, `field_name`, `field_zh_name`, `field_sql`, `field_config`, `sort_num`, `pass_flag`, `create_time`, `author`) VALUES ('30', 'edit_time', '编辑时间', '`edit_time` datetime null', '&#039;isSearch&#039; =&gt; false, 
&#039;isOrder&#039; =&gt; &#039;&#039;, 
&#039;isShowInList&#039; =&gt; false', '9999', '2', '2012-10-29 12:10:33', 'admin');
--
-- #_friendlink
--

INSERT INTO `#_friendlink` (`friendlink_id`, `friendlink_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `jump_url`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `total_visits`, `edit_time`, `create_time`, `author`) VALUES ('2', '怀化学院软件创新基地', '9999', '怀化学院软件创新基地', '怀化学院软件创新基地', '-1', 'http://xyrj.hhtc.edu.cn', '怀化学院软件创新基地', 'public/resource/images/friendlink/1351665629173565568600xyrj.hhtc.edu.cn.jpg', '2', '1', '4', '2012-09-28 17:09:21', '2012-09-28 17:09:21', 'admin');
--
-- #_job
--

INSERT INTO `#_job` (`job_id`, `job_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '外贸主管 ', '9999', '外贸主管 ', '外贸主管 ', '3', '外贸主管 ', '&lt;div style=&quot;font-size:12px&quot;&gt;工作职责 &amp;nbsp; &amp;nbsp;&lt;br /&gt;1、负责区域客户询盘分配、跟进，安排和监督相应询盘、销售等工作。&lt;br /&gt;2、对客户报价的评审、大客户合同谈判。&lt;br /&gt;3、收集和掌握负责区域客户资料和市场讯息，分析、制订销售计划。 &lt;br /&gt;4、监督协助销售人员收集和制作相关客户资料，对销售技能展开培训。 &lt;br /&gt;5、培养小组骨干人员，以及对新人的培训、培养。&lt;br /&gt;&lt;/div&gt;&lt;div style=&quot;font-size:12px&quot;&gt;任职要求 &amp;nbsp; &amp;nbsp;&lt;br /&gt;1、大专以上，贸易或英语等相关专业。 &lt;br /&gt;2、英语8级以上，两年以上外贸管理经验。 &lt;br /&gt;3、有独立海外展会经验。&lt;br /&gt;4、较强的沟通、谈判能力和组织能力，应急处理能力、决策力、抗压力强。&lt;br /&gt;5、有在做品牌外企工作或国外留学经验优先考虑。&lt;/div&gt; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;br /&gt;', '2', '2012-10-30 22:10:59', 'admin', '2012-10-30 22:10:59');
INSERT INTO `#_job` (`job_id`, `job_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', '运营商技术工程师 ', '9999', '运营商技术工程师 ', '运营商技术工程师 ', '1', '运营商技术工程师 ', '&lt;div style=&quot;font-size:12px&quot;&gt;工作职责：&lt;br /&gt;1、负责运营商技术及解决方案的完善与更新；&lt;br /&gt;2、有3年以上的运营商大客户售前、售后工作经验； &lt;br /&gt;2、负责公司内部各平台及面向大客户进行解决方案宣讲、沟通交流；&lt;br /&gt;3、与厂商技术部门保持紧密关系，了解不同厂商最新技术动态及相关软硬件更新信息及方案特点； &lt;br /&gt;4、向技术部主管汇报工作，跟踪和挖掘客户需求，及时整理和上报。&lt;/div&gt;&lt;div style=&quot;font-size:12px&quot;&gt;岗位技能要求：&lt;br /&gt;1、本科以上学历，计算机、通信或网络专业毕业； &lt;br /&gt;2、有3年以上的大客户售前、售后工作经验； &lt;br /&gt;3、具备较扎实的网络知识，对三大运营商的架构理解清晰，精通城域网的设计、规划、优化与实施，精通MPLS BGP等运营商常用技术。&lt;br /&gt;4、具备一定的文字和规划能力，能够完成售前、实施方案的编写； &lt;br /&gt;5、熟悉主流厂家产品； &lt;br /&gt;6、英文阅读能力较好，能够熟练阅读各种英文技术文档； &lt;br /&gt;7、良好的学习能力、责任心和服务意识、可适应出差。 &lt;/div&gt; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-10-30 22:10:25', 'admin', '2012-10-30 22:10:25');
INSERT INTO `#_job` (`job_id`, `job_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('3', '需求分析师 ', '9999', '需求分析师 ', '需求分析师 ', '3', '需求分析师 ', '&lt;div style=&quot;font-size:12px&quot;&gt;职位描述：&lt;br /&gt;1.根据用户需求，形成需求分析说明书；&lt;br /&gt;2.为系统设计、程序开发、测试、布署上线等工作提供支持；&lt;br /&gt;3.熟悉管理软件开发知识；&lt;br /&gt;4.熟练掌握相关需求分析的工具，能熟练撰写需求分析文档；&lt;br /&gt;5.能熟练操作Visio、Project、Powerpoint等工具；&lt;br /&gt;6.善于发现产品创新需求，并能从业务的角度提供方案建议；&lt;br /&gt;岗位要求：&lt;br /&gt;1.统招本科及以上学历,计算机、信息管理与信息系统等相关专业。 &lt;br /&gt;2.5年以上工作经验，其中有3年以上的需求分析工作经历；有相关行业工作经验，有相关的业务&lt;/div&gt;&lt;div style=&quot;font-size:12px&quot;&gt; &amp;nbsp;领域工作背景。 &lt;br /&gt;3.有多个大型项目开发及管理经验&lt;br /&gt;4.有较强的责任心，能承受高强度的工作压力； &lt;br /&gt;5.具备良好的学习能力和独立思考的习惯，良好的团队合作精神；&lt;br /&gt;6.具有较好的口头沟通能力和文字表达能力。&lt;/div&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-10-30 22:10:20', 'admin', '2012-10-30 22:10:20');
INSERT INTO `#_job` (`job_id`, `job_name`, `sort_num`, `parent_id`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('4', 'jtest', '9999', '-1', '2', '2012-11-02 10:11:30', 'admin', '2012-11-02 10:11:30');
INSERT INTO `#_job` (`job_id`, `job_name`, `sort_num`, `parent_id`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('5', 'jtest', '9999', '-1', '2', '2012-11-02 10:11:14', 'admin', '2012-11-02 10:11:14');
INSERT INTO `#_job` (`job_id`, `job_name`, `sort_num`, `seo_keywords`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('6', '经理', '9999', '招聘', '-1', '招聘经理', '&lt;p&gt;测试 &amp;nbsp;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;测试 &amp;nbsp;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-11-02 15:11:34', 'admin', '2012-11-02 15:11:34');
INSERT INTO `#_job` (`job_id`, `job_name`, `sort_num`, `parent_id`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('7', '管理2', '9999', '6', '&lt;p&gt;Ю&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0019.gif&quot; /&gt;&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0007.gif&quot; /&gt;&lt;/p&gt;', '2', '2012-11-03 14:11:28', 'admin', '2012-11-03 14:11:28');
--
-- #_jobtype
--

INSERT INTO `#_jobtype` (`jobtype_id`, `jobtype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '技术', '9999', '技术', '技术', '-1', '技术', '2', '2012-10-30 22:10:57', 'admin', '2012-10-30 22:10:57');
INSERT INTO `#_jobtype` (`jobtype_id`, `jobtype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', '公关', '9999', '公关', '公关', '-1', '公关', '2', '2012-10-30 22:10:13', 'admin', '2012-10-30 22:10:13');
INSERT INTO `#_jobtype` (`jobtype_id`, `jobtype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `create_time`, `author`, `edit_time`) VALUES ('3', '业务', '9999', '业务', '业务', '-1', '业务', '2', '2', '2012-10-30 22:10:28', 'admin', '2012-10-30 22:10:28');
INSERT INTO `#_jobtype` (`jobtype_id`, `jobtype_name`, `sort_num`, `parent_id`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('6', '管理1', '9999', '-1', '2', '2012-11-03 14:11:52', 'admin', '2012-11-03 14:11:52');
--
-- #_message
--

INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('11', 'test', 'asdf', '9999', 'test', '邮箱', '电话', '2', '2', '2012-09-30 11:09:03', '2012-09-30 11:09:03');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('12', 'test', 'asdf', '9999', 'test', '邮箱', '电话', '2', '2', '2012-09-30 11:09:51', '2012-09-30 11:09:51');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('13', '让他热', '该法', '9999', '分公司多个try个', '非官方的', '叙亚太会员', '2', '2', '2012-10-08 12:10:56', '2012-10-08 12:10:56');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('14', '让他热', '该法', '9999', '分公司多个try个', '分公司地方阀盖', '让弗格森日', '2', '2', '2012-10-08 12:10:18', '2012-10-08 12:10:18');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('15', 'ttttt', 'td', '9999', 'ttttt', 'xx', '123', '2', '2', '2012-10-08 12:10:17', '2012-10-08 12:10:17');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('16', 'asdf', 'asdf', '9999', 'asdfasdf', 'asdfasdf@asdfasdf.com', 'asdf', '2', '2', '2012-10-08 19:10:57', '2012-10-08 19:10:57');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('17', 'asdf', 'asdf', '9999', 'asdfasdf', 'asdfasdf@asdfasdf.com', 'asdf', '2', '2', '2012-10-08 19:10:20', '2012-10-08 19:10:20');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('18', 'asdf', 'test', '9999', 'asdfasfd', 'xjiujiu@foxmail.com', '15111592794', '2', '2', '2012-10-08 19:10:09', '2012-10-08 19:10:09');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('19', '留言', 'll', '9999', '留言留言留言留言留言留言', '5@3.com', '15255456655', '2', '2', '2012-10-08 20:10:23', '2012-10-08 20:10:23');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('20', 'test', 'test', '9999', 'asdftest', 'test@a.com', '1213123123', '2', '2', '2012-10-09 17:10:51', '2012-10-09 17:10:51');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `phone`, `edit_time`, `create_time`) VALUES ('21', '50', 'test', '9999', 'testtest', '2864240', '2012-10-31 18:10:09', '2012-10-31 18:10:09');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `pass_flag`, `edit_time`, `create_time`, `author`) VALUES ('22', 'jtest', 'jsx', '9999', '&lt;p&gt;tttttjgfsdef唯唯否否vb&lt;/p&gt;', 'sss@gmail.com ', '15112353211', '2', '2012-11-02 11:11:04', '2012-11-02 11:11:04', 'admin');
INSERT INTO `#_message` (`message_id`, `message_name`, `visitor_name`, `sort_num`, `model_text`, `email`, `phone`, `address`, `edit_time`, `create_time`) VALUES ('23', '50', 'test', '9999', '你好你好你好你好你好你好', '144@hh.com', '15255568955', '怀化', '2012-11-02 12:11:21', '2012-11-02 12:11:21');
--
-- #_modelmanager
--

INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `sort_num`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`) VALUES ('77', '导航菜单', 'navmenu', '9999', '网站导航栏', '-1', '2', 'public/resource/images/genmodel/navigator.jpg', '1', '1', '2', '0000-00-00 00:00:00');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `sort_num`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`) VALUES ('128', '友情链接', 'friendlink', '9999', '友情链接', '-1', '2', 'public/resource/images/genmodel/friend-link-icon.jpg', '1', '1', '2', '0000-00-00 00:00:00');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('154', '新闻文章', 'news', '新闻详细内容', '153', '2', 'public/resource/images/modelmanager/13514945371835100news.jpg', '1', '2', '2012-10-29 15:10:14', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `sort_num`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`) VALUES ('117', '大图展示', 'banner', '9999', '大图展示', '-1', '2', 'public/resource/images/genmodel/banner-icon-1.jpg', '1', '1', '2', '0000-00-00 00:00:00');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `sort_num`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `top_flag`, `pass_flag`, `create_time`) VALUES ('116', '访客留言', 'message', '9999', '访客留言', '-1', '2', 'public/resource/images/genmodel/message-icon-1.jpg', '1', '1', '2', '0000-00-00 00:00:00');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('152', '工作信息', 'job', '工作机会信息', '151', '2', 'public/resource/images/modelmanager/13514944632748100job.jpg', '1', '2', '2012-10-29 15:10:14', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('153', '新闻类型', 'newstype', '新闻分类信息', '-1', '2', 'public/resource/images/modelmanager/13514944922621100newstype.jpg', '1', '2', '2012-10-29 15:10:45', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('151', '工作类型', 'jobtype', '工作类型信息', '-1', '2', 'public/resource/images/modelmanager/13514944321254400jobtype.jpg', '1', '2', '2012-10-29 15:10:41', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('150', '案例展示', 'cases', '案例详细信息', '149', '2', 'public/resource/images/modelmanager/1351494399353500cases-icon.jpg', '1', '2', '2012-10-29 15:10:07', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('149', '案例类型', 'casetype', '案例类型信息', '-1', '2', 'public/resource/images/modelmanager/13514943651470600casetype-icon.jpg', '1', '2', '2012-10-29 15:10:22', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('148', '产品展示', 'product', '产品详细信息', '147', '2', 'public/resource/images/modelmanager/13514942453033300product-icon.jpg', '1', '2', '2012-10-29 15:10:20', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('147', '产品类型', 'producttype', '产品分类信息', '-1', '2', 'public/resource/images/modelmanager/13514941992779400producttype-icon.jpg', '1', '2', '2012-10-29 15:10:55', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('155', '单页文章', 'article', '单页文章信息，如：关于我们，公司介绍等。', '-1', '2', 'public/resource/images/modelmanager/13514946482502700article.jpg', '1', '2', '2012-10-29 15:10:25', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('156', '资质荣誉类型', 'certificatetype', '公司所获得的资质荣誉类型', '-1', '2', 'public/resource/images/modelmanager/13517463982779300documents.jpg', '1', '2', '2012-10-31 21:10:52', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('157', '资质荣誉', 'certificate', '公司所获得的资质荣誉', '156', '2', 'public/resource/images/modelmanager/135169077128315029400cert.jpg', '1', '2', '2012-10-31 21:10:42', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('158', '相册', 'photoalbum', '产品相册，案例相册等', '-1', '2', 'public/resource/images/modelmanager/13522958441376800album.jpg', '1', '2', '2012-11-07 21:11:07', 'admin');
INSERT INTO `#_modelmanager` (`modelmanager_id`, `modelmanager_name`, `model_en_name`, `model_desc`, `parent_id`, `model_show_qcp`, `image_path`, `menu_flag`, `pass_flag`, `create_time`, `author`) VALUES ('159', '图片文件', 'picture', '网站信息所有的图片资源。', '158', '2', 'public/resource/images/modelmanager/13522963591897100picture.jpg', '1', '2', '2012-11-07 21:11:43', 'admin');
--
-- #_navmenu
--

INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '首页', '9', '-1', 'index.php', '网站主页', '2', '1', '2012-10-06 10:00:50', '2012-04-26 09:04:45', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `table_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('19', '公司概况', '19', '-1', 'index.php/article?id=1', 'companyinfo:1', '公司概况e', '2', '1', '2012-04-27 12:00:40', '2012-04-27 11:04:43', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('20', '产品展示', '29', '-1', 'index.php/product', '产品展示', '2', '1', '2012-04-27 18:04:34', '2012-04-27 18:04:34', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('21', '资质荣誉', '49', '-1', 'index.php/certificate', '资质荣誉', '2', '1', '2012-04-27 18:04:29', '2012-04-27 18:04:29', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('29', '公司动态', '27', '-1', 'index.php/news', '公司的动态信息。', '2', '1', '2012-06-26 23:06:32', '2012-06-26 23:06:32', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `image_path`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('28', '招商加盟', '69', '-1', 'index.php/article?id=2', '招商加盟', 'public/resource/images/navmenu/2012/05/24/24.jpg', '2', '1', '2012-05-24 00:05:30', '2012-05-24 00:05:30', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('30', '联系我们', '9999', '-1', 'index.php/message', '联系我们', '2', '1', '2012-09-26 17:09:17', '2012-09-26 17:09:17', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('33', '简介', '20', '19', 'index.php/article?id=1', '公司简介', '2', '1', '2012-09-28 16:09:46', '2012-09-28 16:09:46', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `jump_url`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('37', '业内新闻', '28', '29', 'index.php/news/type?id=1', '业内新闻', '2', '1', '2012-09-28 16:09:59', '2012-09-28 16:09:59', 'admin');
INSERT INTO `#_navmenu` (`navmenu_id`, `navmenu_name`, `sort_num`, `parent_id`, `pass_flag`, `edit_time`, `create_time`, `author`) VALUES ('40', 'jtest2', '9999', '29', '2', '2012-11-02 11:11:54', '2012-11-02 11:11:54', 'admin');
--
-- #_news
--

INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '中国家电企业勇闯澳洲 逐渐蚕食日本品牌市场', '9999', '中国家电企业勇闯澳洲 逐渐蚕食日本品牌市场', '中国家电企业勇闯澳洲 逐渐蚕食日本品牌市场', '1', '据商务部网站编译消息，《澳洲日报》报道，以TCL为代表的中国消费电子公司正准备勇闯澳洲市场，毫不畏惧已经在澳占据相当市场份额的日韩大品牌。而现在，韩国大品牌和中国新品牌(比如TCL和海信等)正逐渐蚕食日本品牌市场，导致日本品牌最近利润惨重下跌。', '&lt;p style=&quot;text-align:center;&quot;&gt;&lt;img src=&quot;HTTP://www.cenn.cn/UploadFile/20121030114855953.jpg&quot; border=&quot;0&quot; /&gt;&lt;/p&gt;&lt;p style=&quot;text-align:center;&quot;&gt;&lt;br /&gt;&lt;/p&gt;&lt;p style=&quot;text-align:center;&quot;&gt;&lt;strong&gt;以TCL为代表的中国消费电子公司正准备勇闯澳洲市场，&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;text-align:center;&quot;&gt;&lt;strong&gt;毫不畏惧已经在澳占据相当市场份额的日韩大品牌。&lt;br /&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　 　 据商务部网站编译消息，《澳洲日报》报道，以TCL为代表的中国消费电子公司正准备勇闯澳洲市场，毫不畏惧已经在澳占据相当市场份额的日韩大品牌。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　在中国境内堪称行业领头羊的TCL在过去几年里一直致力于塑造公司品牌形象，努力拓宽分销渠道，为开拓海外市场奠定基础。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　一直以来，亚洲消费电子公司都牢牢地占据澳洲市场。韩国和日本品牌，比如三星、LG、索尼和松下等，更是占据了澳洲70%的电视机市场份额，其余的份额则由中国和本地品牌共享。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　而现在，韩国大品牌和中国新品牌(比如TCL和海信等)正逐渐蚕食日本品牌市场，导致日本品牌最近利润惨重下跌。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　为了能赶上日本和韩国的对手，TCL不惜重金投资技术研发和市场营销。TCL据悉在其中国最先进的显示板工厂内投入了38亿元，而且在美国、法国和新加坡开设了研发中心。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　国际设计公司 IDEO也正在帮助TCL提升产品外形。此外，TCL还试图通过赞助盛大体育赛事来提高自己的知名度。它自2005年以来就一直为墨尔本杯(Melbourne Cup)提供电视机。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-10-30 18:10:34', 'admin', '2012-10-30 18:10:34');
INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', '东风将出资上亿欧元开展海外收购', '9999', '东风将出资上亿欧元开展海外收购', '东风将出资上亿欧元开展海外收购', '1', ' 此次与东风汽车合资的格特拉克是世界知名变速箱生产企业，其母公司是全球最大的乘用车和轻型商用车变速箱独立供应商。据悉，T工程公司将成为东风汽车首个海外研发基地及研发团队，主要为东风乘用车和商用车业务提供电子控制等领域技术，推进东风汽车走向国际化。　', '&lt;p&gt;东风汽车在资本领域频频出手。10月22日东风与格特拉克国际公司签约，组成变速箱合资公司。据悉，东风汽车与格特拉克双方将各占变速箱合资公司50%的股权。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　按照双方约定，东风格特拉克将在合资公司内建立一个变速箱产品研发中心，分阶段逐步形成完全的变速箱研究开发能力，而研发知识产权属双方共同所有。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　在此之前，东风汽车在研发领域也开始在海外“小试牛刀”。9月底，公司宣布开始着手收购瑞典T工程公司，建立第一家海外研发基地。根据双方在去年12月8日签订的基础协议，东风汽车先收购T工程公司70%的股权，剩余30%股权将在未来两年内完成收购。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　有消息人士对《证券日报》透露，两个项目东风将出资上亿欧元，主要想锻炼乘用车层面的技术研发实力，这对东风这家商用车见长的公司或许是个捷径。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　据悉，此次与东风汽车合资的格特拉克是世界知名变速箱生产企业，其母公司是全球最大的乘用车和轻型商用车变速箱独立供应商。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　公司党委工作部周密表示，双方共同拥有知识产权的产品不仅将装配在东风乘用车品牌“风神”上，也会装配在东风上。此外，东风汽车旗下合资公司及其它企业也可享受其服务。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　而类似功能在收购T工程公司股权项目中也存在。据悉，T工程公司将成为东风汽车首个海外研发基地及研发团队，主要为东风乘用车和商用车业务提供电子控制等领域技术，推进东风汽车走向国际化。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-10-30 18:10:20', 'admin', '2012-10-30 18:10:20');
INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('3', '近几年自主与外资乘用车市场份额变化', '9999', '近几年自主与外资乘用车市场份额变化', '近几年自主与外资乘用车市场份额变化', '1', '近几年，我国汽车市场由“井喷期”步入理性回归，自主品牌和外资品牌市场份额以及销量结构变化如何，下文对此做一简析。2011年，自主品牌销量仅增2.3%至386.67万辆，市场份额同比下降1.9个百分点至31.6%；外资品牌销量同比增长11.6%至837.85万辆，市场份额升至68.4%。　
', '&lt;p&gt;近几年，我国汽车市场由“井喷期”步入理性回归，自主品牌和外资品牌市场份额以及销量结构变化如何，下文对此做一简析。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　从盖世汽车网整理的数据来看，我国国产乘用车市场（不含微客）中，在车市高速增长期，自主品牌市场份额有所提升，外资品牌下降趋势；而在车市步入低迷时期，自主品牌市场份额显著下降，外资品牌则明显上升。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p style=&quot;text-align:center;&quot;&gt;&lt;img src=&quot;http://i8.hexunimg.cn/2012-10-30/147369077.jpg&quot; /&gt;&lt;/p&gt;&lt;p&gt;　　2009和2010年，在汽车刺激政策等市场利好因素影响下，国产乘用车市场进入井喷时期，整体销量大幅增长，分别增长51.3%和37.7%。在此情况下，众多企业纷纷涌入汽车行业，自主品牌销量大幅增长，市场份额也显著提升：这两年销量分别增长66.1%和46.5%至267.77万辆和377.96万辆，市场份额由2008年的29.0%分别升至2009和2010年的31.9%和33.5%。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　国产外资品牌在2009年和2010年销量虽然也实现快速增长，但市场份额呈下降趋势，其原因与该时期由于受金融危机影响，企业对中国市场战略保守有关。2009和2010年，国产外资品牌销量同比增长45.2%和33.6%至571.46万辆和750.26万辆，市场份额由2008年的71.0%分别降至2009和2010年的68.1%和66.5%。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　相对2009和2010年的高增长，2011年和今年前三季度，我国车市增速回归理性，国产乘用车市场分别仅增8.5%和7.8%。受市场竞争加剧以及自主车企前两年疯狂扩张带来的隐患等影响，自主品牌市场份额出现滑落。而国产外资品牌销量仍实现两位数增长，市场份额呈回升之势。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　2011年，自主品牌销量仅增2.3%至386.67万辆，市场份额同比下降1.9个百分点至31.6%；外资品牌销量同比增长11.6%至837.85万辆，市场份额升至68.4%。今年前三季度，自主品牌销量同比增长2.8%至286.47万辆，市场份额进一步下降至29.8%；而外资品牌销量增长10.1%至674.12万辆，市场份额升至70.2%。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p style=&quot;text-align:center;&quot;&gt;&lt;img src=&quot;http://i2.hexunimg.cn/2012-10-30/147369079.jpg&quot; /&gt;&lt;/p&gt;&lt;p&gt;　　分市场结构来看，国产轿车市场中，2008年，自主和外资市场占有率分别为25.6%和74.4%。2009和2010年自主品牌主要受益于汽车刺激政策影响，其轿车销量高速增长，占有率持续提升，至2010年升至30.8%，而外资品牌占有率持续降至2010年的69.2%。2011年和今年前三季度，自主品牌轿车销量均下滑，市场占有率持续下降：2011年降至28.7%，今年前三季度进一步降至26.2%；而外资轿车市场占有率持续上升，2011年升至71.3%，今年前三季度再升至73.8%。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p style=&quot;text-align:center;&quot;&gt;&lt;img src=&quot;http://i9.hexunimg.cn/2012-10-30/147369080.jpg&quot; /&gt;&lt;/p&gt;&lt;p&gt;　　近几年SUV市场持续火热，外资品牌表现好于自主品牌，市场占有率呈上升形势，而自主品牌呈下降之势。2008-2011年，外资SUV市场占有率由44.8%持续升至2011年的61.2%；而自主品牌由55.2%降至38.8%。今年前三季度，自主SUV在众多新车销量的推动下，占有率有所回升，升至40%，而外资SUV占有率降至60%。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　&lt;strong&gt;注：&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　乘用车（轿车、SUV、MPV）市场总量中包括少数进口车销量和出口量，故本文所计市场份额均为近似值。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-10-30 18:10:36', 'admin', '2012-10-30 18:10:36');
INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('4', '工信部明确新能源汽车技术创新项目条件', '9999', '工信部明确新能源汽车技术创新项目条件', '工信部明确新能源汽车技术创新项目条件', '1', '工信部网站18日发布《关于组织申报2012年度新能源汽车产业技术创新工程项目的通知》，通知对于申报企业条件和申报项目要求作出详细规定，其中包括新能源汽车整车项目和动力电池项目。　', '&lt;p&gt;　工信部网站18日发布《关于组织申报2012年度新能源汽车产业技术创新工程项目的通知》，通知对于申报企业条件和申报项目要求作出详细规定，其中包括新能源汽车整车项目和动力电池项目。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　通知指出，申报企业近两年研发投入占主营业务收入不低于3%。其中，电池企业对动力电池技术研发和产业化投资规模不低于5亿元人民币，电池单体年生产能力不低于1亿安时，拥有动力电池核心技术及电池单体的知识产权，并已实现规模化装车应用且表现出良好性能。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　通知同时指出，对于新能源汽车整车项目，到2015年以前，全新平台的纯电动乘用车最高车速不低于100公里/小时；插电式混合动力乘用车在混合动力驱动模式下的汽车燃料消耗量优于乘用车第三阶段燃料消耗量目标值不少于30%；纯电动商用车最高车速不低于80公里/小时；插电式混合动力商用车最高车速不低于80公里/小时，在纯电驱动模式下续驶里程不低于50公里。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-10-30 18:10:13', 'admin', '2012-10-30 18:10:13');
INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('5', '租车业霸王条款频现 服务管理亟须规范', '9999', '租车业霸王条款频现 服务管理亟须规范', '租车业霸王条款频现 服务管理亟须规范', '1', '1989年，中国第一家汽车租赁公司在北京诞生。中国出租汽车暨汽车租赁协会发布的数据显示，过去10年，国内汽车租赁行业以年均20%以上的速度增长，预计到2015年，国内市场规模将超过350亿元。　', '&lt;p&gt;1989年，中国第一家汽车租赁公司在北京诞生。20多年过去了，当年“小荷才露尖尖角”的租车行业早已褪去青涩，成为名副其实的朝阳产业，并出现了一嗨、神州等行业龙头。然而与发达国家相比，中国汽车租赁行业发展尚处于初级阶段，行业标准缺乏，参与者良莠不齐，“霸王条款”时有出现。专家认为，破解汽车租赁行业瓶颈，产业整合与升级势在必行。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　&lt;strong&gt;发展迅猛&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　家住青海西宁的尹维夏、黄冰夫妇，虽然两人都有驾照，但暂时没有购车的打算。“上班不太远，周末想带着孩子郊游的话，租个车就行。”黄冰说，“租金也就100多元，省钱省心。”&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　与西宁情况类似，在国内许多二线城市，租车已逐渐成为出行新选择。而在北京等大城市，近几年限行、限购等措施的出台，为租车行业的发展提供了空间。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　中国出租汽车暨汽车租赁协会发布的数据显示，过去10年，国内汽车租赁行业以年均20%以上的速度增长，预计到2015年，国内市场规模将超过350亿元。北京大学经济学院教授曹和平认为，“未来汽车租赁将成为国内汽车及多个相关产业发展的引擎。”&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　&lt;strong&gt;保险不全&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　10月16日，西安车友“秦川娃”在微博上抱怨：“租车的时候好好的，还车时发现一条不起眼的划痕，租车行非要我支付额外的维修费。”上述现象在租车行业中时有发生。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　同时，保险不全在租车行业中并不少见。据笔者调查，西宁多家租车公司中，大多只购买了交强险。“主要险种买全了要好几千，光买交强险可以省一半，我们不能不考虑成本。”西宁达安汽车租赁公司一位不愿透露姓名的员工说。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　在刚刚结束的国庆黄金周，西宁租车行业平均涨价20%，而且大多要求“7天起租”。消费者李涛找遍了整个西宁，也没找到一辆短租车。“我们就用两天，租长了浪费。不是不想租，是实在难租。”&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　然而，面对车友的微词，许多老板也是满腹苦水。太原新希望汽车租赁公司经理王伟表示，几乎每月都有个别人把公司的车租出去后再转租给别人赚取差价。而2011年发生在江苏宿迁的汽车租赁犯罪案，更让许多租车老板谈之色变。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　&lt;strong&gt;期待整合&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　尽管已有20多年发展历史，但目前中国汽车租赁产业仍处于初级阶段。曹和平认为，目前国内汽车租赁行业发展瓶颈之一是行业标准缺乏，由此带来管理混乱、服务滞后。“国内租车行业标准尚处于摸索阶段，尽管有一些地方性规范，但想要扶持一个产业，还需要自上而下的全国性标准。”曹和平说。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　北京大学政府管理学院副教授汤大华则认为，在全国逐步推行公车改革的大背景下，可以考虑出台相应措施，将发展汽车租赁行业与机关、事业单位后勤服务社会化改革相结合。“压缩公车开支的途径之一是以租车模式部分取代现有的养车模式，此举可以大量节省行政成本，对汽车租赁也是个有力支持。”&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;　　今年8月，奔驰(中国)公司成立专门的租赁公司，主打高端汽车租赁。在曹和平看来，今后几年，中国的汽车租赁产业还会不断面对“狼来了”的压力。“汽车租赁作为一个朝阳产业，不能再小打小闹了，现在已经到了整合升级，实现规范化、规模化、集约化经营的时候了。”曹和平说。&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/135183760880445073800登录.jpg', '2', '2012-10-30 18:10:50', 'admin', '2012-10-30 18:10:50');
INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `parent_id`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('6', 'xxxxxxx', '9999', '2', '&lt;p&gt;ffffffffffffffhhhhhhhrtrtf团吞吞吐吐忐忐忑忑&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0015.gif&quot; /&gt;&lt;/p&gt;', '2', '2012-11-02 11:11:45', 'admin', '2012-11-02 11:11:45');
INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `parent_id`, `model_desc`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('7', '元方', '9999', '3', '元方，你怎么看？', '&lt;p&gt; &amp;nbsp; &amp;nbsp;元方，你怎么看？元方，你怎么看？元方，你怎么看？元方，你怎么看？元方，你怎么看？元方，你怎么看？元方，你怎么看？元方，你怎么看？纯属娱乐，哈哈哈。。。&lt;img width=&quot;520&quot; height=&quot;340&quot; src=&quot;http://api.map.baidu.com/staticimage?center=116.378129,39.813318&amp;amp;zoom=13&amp;amp;width=520&amp;amp;height=340&amp;amp;markers=116.404,39.915&quot; /&gt;&lt;br /&gt;&lt;/p&gt;', '2', '2012-11-02 14:11:25', 'admin', '2012-11-02 14:11:25');
INSERT INTO `#_news` (`news_id`, `news_name`, `sort_num`, `parent_id`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('8', '枫叶红', '9999', '-1', '&lt;p&gt;凤飞飞飞凤飞飞飞方法隐隐约约&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0009.gif&quot; /&gt;用隐隐约约14:50:29&lt;/p&gt;', '2', '2012-11-03 14:11:43', 'admin', '2012-11-03 14:11:43');
--
-- #_newstype
--

INSERT INTO `#_newstype` (`newstype_id`, `newstype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '同行新闻', '9999', '中国企业新闻', '中国企业新闻', '-1', '中国企业新闻', '2', '2012-10-30 18:10:16', 'admin', '2012-10-30 18:10:16');
INSERT INTO `#_newstype` (`newstype_id`, `newstype_name`, `sort_num`, `parent_id`, `model_desc`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', 'jtest', '9999', '-1', 'ttttttt', '2', '2012-11-02 10:11:38', 'admin', '2012-11-02 10:11:38');
INSERT INTO `#_newstype` (`newstype_id`, `newstype_name`, `sort_num`, `seo_keywords`, `parent_id`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('3', '娱乐新闻', '9999', '娱乐', '-1', '2', '2012-11-02 14:11:49', 'admin', '2012-11-02 14:11:49');
INSERT INTO `#_newstype` (`newstype_id`, `newstype_name`, `sort_num`, `parent_id`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('5', '天寒红叶稀', '9999', '-1', '2', '2012-11-03 14:11:04', 'admin', '2012-11-03 14:11:04');
--
-- #_photoalbum
--

--
-- #_picture
--

--
-- #_product
--

INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '46米混凝土输送泵车:SY5313THB 46', '9999', '46米混凝土输送泵车:SY5313THB 46', '46米混凝土输送泵车:SY5313THB 46', '1', '46米混凝土输送泵车:SY5313THB 46', '&lt;p&gt;·五节RZ型臂架，布料灵活、范围广；&lt;br /&gt;·X型支腿，可实现单侧支撑，适合狭窄工作场地施工；&lt;br /&gt;·防倾翻控制技术，提高泵车智能化水平，增强工作时的安全性；&lt;br /&gt;·智能缓冲控制系统，换向冲击更小；&lt;br /&gt;·泵送排量达170 m&lt;sup&gt;3&lt;/sup&gt;/h，无级调节，满足各种工况需求；&lt;br /&gt;·计算机节能控制，功率自动匹配，平均节能20%；&lt;br /&gt;·独创的SYMC专用控制器，系统运行更加可靠；&lt;br /&gt;·砼活塞自动退回，检测、更换更加方便、高效；&lt;br /&gt;·全自动高低压切换，泵送适应性更好；&lt;br /&gt;·电液缓冲、压差感应、开式液压系统全液压换向，换向冲击小，可靠性高。&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/1351603097564992601001249341765586.jpg', '2', '2012-10-30 21:10:39', 'admin', '2012-10-30 21:10:39');
INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('2', '柴油机混凝土拖泵 :HBT40C-1410DⅢ', '9999', '柴油机混凝土拖泵 :HBT40C-1410DⅢ', '柴油机混凝土拖泵 :HBT40C-1410DⅢ', '1', '柴油机混凝土拖泵 :HBT40C-1410DⅢ', '&lt;p&gt;·泵送最大理论排量50 m&lt;sup&gt;3&lt;/sup&gt;/h，最大输送压力9.9 Mpa，发动机功率47.5 kW；&lt;br /&gt;·电比例排量无级调节，满足各种工况需求；&lt;br /&gt;·全局功率自适应节能技术，节能20%以上；&lt;br /&gt;·国内首创SYMC与SYLD专用智能控制系统，系统运行更加可靠；&lt;br /&gt;·彩色图形动态显示运行参数，提示故障类型，设置多重自动保护；&lt;br /&gt;·全液压换向开式系统，液压油清洁度高，油温低，换向冲击小；&lt;br /&gt;·砼活塞自动退回，检测、更换更加方便、快捷；&lt;br /&gt;·高低压自动切换专利技术，钮子开关操作，无液压油泄漏，无污染，快速排除堵管；&lt;br /&gt;·主油缸采用防水密封专利技术，有效防止水进入液压系统，防止液压油乳化；&lt;br /&gt;·先进的S管阀系统，密封性能好，易损件经济耐用，更换方便；&lt;br /&gt;·液压、电气主要元件采用国际知名品牌，可靠性高。&lt;/p&gt;&lt;p&gt; &lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/13516031522069226813001246573103502.jpg', '2', '2012-10-30 21:10:18', 'admin', '2012-10-30 21:10:18');
INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('3', '沥青砂浆车:SY9300TSJ500高弹模', '9999', '沥青砂浆车:SY9300TSJ500高弹模', '沥青砂浆车:SY9300TSJ500高弹模', '1', '沥青砂浆车:SY9300TSJ500高弹模', '&lt;p&gt;·科技部等四部委评为“国家重点新产品”；&lt;br /&gt;·高精度抗震计量，全工况自动快速调平，生产效率高，安全环保；&lt;br /&gt;·操作简单，配置无线遥控，采用触摸式显示屏、3D动画显示；&lt;br /&gt;·自动检测故障与报警功能，完善的生产数据报表系统；&lt;br /&gt;·多配方支持技术，满足高、低弹模砂浆的生产，兼容德国板、日本板及国产l、ll型板灌浆施工；&lt;br /&gt;·世界首创微泡砂浆生产技术，申请国家专利47项，所有技术指标达到国际先进水平，部份关·键技术指标处于世界领先水平。&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/13516032022051191379001246579290158.jpg', '2', '2012-10-30 21:10:13', 'admin', '2012-10-30 21:10:13');
INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('4', 'SAP系列高等级沥青摊铺机:SAP90CD', '9999', 'SAP系列高等级沥青摊铺机:SAP90CD', 'SAP系列高等级沥青摊铺机:SAP90CD', '1', 'SAP系列高等级沥青摊铺机:SAP90CD', '&lt;p&gt;• 集成协同找平技术，确保稳定、平整施工 ;&lt;br /&gt;• 大通道、大螺旋、大料斗、大厚度，功率智能分配技术，工作效率提高30%丟&lt;br /&gt;• 采用螺旋整体升降及可变料槽技术、大节距、大直径叶片及低速分料，实现智能全比例供料，有效防离析；&lt;br /&gt;• 采用分仓导流技术， 50度高温可连续24小时施工；&lt;br /&gt;• 8.5 m&lt;sup&gt;3&lt;/sup&gt;超大料斗，单独开合，应对多变作业环境；&lt;br /&gt;• 全电脑控制系统，具有故障智能诊断及记录功能；&lt;br /&gt;• 全触摸式操作台，可摆转、滑移，操作舒适、快捷；&lt;br /&gt;• 噪声源、腔复合降噪技术，噪音不超过82分贝；&lt;br /&gt;• 电控发动机，功率匹配智能化，具有经济作业模式，可省油15%。&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/135160338714186211630020120926091519393.jpg', '2', '2012-10-30 21:10:22', 'admin', '2012-10-30 21:10:22');
INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('5', 'test', '9999', '-1', 'ff', '&lt;p&gt;ttttt&lt;img title=&quot;20121019705.jpg&quot; src=&quot;http://172.28.138.234/xyrj-demo/render/editor/ueditor/php/upload/20121102/13518269724864.jpg&quot; /&gt;&lt;/p&gt;', 'public/resource/images/135184781115841040910022.jpg', '2', '2012-11-02 10:11:59', 'admin', '2012-11-02 10:11:59');
INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `seo_keywords`, `parent_id`, `model_desc`, `model_text`, `image_path`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('6', 'test1', '9999', '产品', '2', '这是一个测试', '&lt;p&gt;这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试这是一个测试&lt;br /&gt;&lt;/p&gt;', 'public/resource/images/13518492787121420260040.jpg', '2', '2012-11-02 14:11:25', 'admin', '2012-11-02 14:11:25');
INSERT INTO `#_product` (`product_id`, `product_name`, `sort_num`, `parent_id`, `model_text`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('7', 'jie7', '9999', '4', '&lt;p&gt;&lt;img title=&quot;20121020749.jpg&quot; src=&quot;http://172.28.138.234/xyrj-demo/render/editor/ueditor/php/upload/20121103/13519235426080.jpg&quot; /&gt;&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0017.gif&quot; /&gt;哈哈hiw&lt;/p&gt;', '2', '2012-11-03 14:11:20', 'admin', '2012-11-03 14:11:20');
--
-- #_producttype
--

INSERT INTO `#_producttype` (`producttype_id`, `producttype_name`, `sort_num`, `seo_keywords`, `seo_desc`, `parent_id`, `model_desc`, `pass_flag`, `create_time`, `author`, `edit_time`) VALUES ('1', '机械', '9999', '机械', '机械', '-1', '机械', '2', '2012-10-30 21:10:13', 'admin', '2012-10-30 21:10:13');
--
-- #_user
--

INSERT INTO `#_user` (`user_id`, `user_name`, `sort_num`, `user_passwd`, `parent_id`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('8', '土豆', '9999', 'e10adc3949ba59abbe56e057f20f883e', '1', '2', '2', '2012-10-06 15:10:14', '2012-10-06 15:10:14', 'test');
INSERT INTO `#_user` (`user_id`, `user_name`, `sort_num`, `user_passwd`, `parent_id`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('6', 'test', '9999', 'e10adc3949ba59abbe56e057f20f883e', '1', '2', '1', '2012-09-27 19:09:46', '2012-09-27 19:09:46', 'admin');
INSERT INTO `#_user` (`user_id`, `user_name`, `sort_num`, `user_passwd`, `parent_id`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('10', 'admin', '999', '21232f297a57a5a743894a0e4a801fc3', '1', '2', '2', '2012-10-15 21:10:30', '2012-10-15 21:10:30', 'admin');
INSERT INTO `#_user` (`user_id`, `user_name`, `sort_num`, `user_passwd`, `parent_id`, `email`, `pass_flag`, `top_flag`, `edit_time`, `create_time`) VALUES ('13', 'xjiujiu', '999', 'dec3b7027dfd3de1ecbcb58209aa69d9', '2', 'xjiujiu@foxmail.com', '2', '2', '2012-10-16 18:10:29', '2012-10-16 18:10:29');
INSERT INTO `#_user` (`user_id`, `user_name`, `sort_num`, `user_passwd`, `parent_id`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('14', 'admin', '999', '21232f297a57a5a743894a0e4a801fc3', '1', '2', '2', '2012-10-29 12:10:13', '2012-10-29 12:10:13', 'admin');
--
-- #_usertype
--

INSERT INTO `#_usertype` (`usertype_id`, `usertype_name`, `sort_num`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('1', '超级管理员', '9999', '-1', '系统的最高权限用户', '2', '1', '2012-04-21 11:04:25', '2012-04-21 11:04:25', 'xjiujiu');
INSERT INTO `#_usertype` (`usertype_id`, `usertype_name`, `sort_num`, `parent_id`, `model_desc`, `pass_flag`, `top_flag`, `edit_time`, `create_time`, `author`) VALUES ('3', 'test', '9999', '2', 'eeee', '2', '2', '2012-09-27 20:09:42', '2012-09-27 20:09:42', '土豆');
INSERT INTO `#_usertype` (`usertype_id`, `usertype_name`, `sort_num`, `parent_id`, `pass_flag`, `edit_time`, `create_time`, `author`) VALUES ('4', '团团', '9999', '-1', '2', '2012-11-03 14:11:42', '2012-11-03 14:11:42', 'admin');
