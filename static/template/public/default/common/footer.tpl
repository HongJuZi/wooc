        <div class="footer_wrap rt10">
            <a href="<?php echo HResponse::url(); ?>" class="foot_logo"></a>
            <div class="foot_links clearfix">
                <dl class="foot_nav fl">
                    <dt>网站导航</dt>
                    <dd>
                        <a href="<?php echo HResponse::url('mvp'); ?>">精选</a>
                    </dd>
                    <dd>
                        <a href="<?php echo HResponse::url('market'); ?>">集市</a>
                    </dd>
                    <dd>
                        <a href="<?php echo HResponse::url('find'); ?>">发现</a>
                    </dd>
                </dl>
                <dl class="aboutus fl">
                    <dt>关于我们</dt>
                    <dd>
                        <a href="<?php echo HResponse::url('aboutus'); ?>" target="_blank">关于我们</a>
                    </dd>
                    <dd>
                        <a href="<?php echo HResponse::url('contactus'); ?>" target="_blank">联系我们</a>
                    </dd>
                    <dd>
                        <a href="<?php echo HResponse::url('joinus'); ?>" target="_blank">加入我们</a>
                    </dd>
                </dl>
                <dl class="flinks fr">
                    <dt>
                        友情链接
                    </dt>
                    <?php foreach(HResponse::getAttribute('linkList') as $link) { ?>
                    <dd>
                        <a href="<?php echo $link['jump_url']; ?>" target="_blank">
                            <?php echo $link['name']; ?>
                        </a>
                    </dd>
                    <?php }?>
                </dl>
                <dl class="followus fr">
                    <dt>
                        关注我们
                    </dt>
                    <dd>
                        <a href="http://www.weibo.com/isoubei" target="_blank">
                            <img src="<?php echo HResponse::uri(); ?>/images/sina.jpeg" class="fl mr5" />
                            新浪微博
                        </a>
                    </dd>
                    <dd>
                        <a href="http://tx.com/ishopping" target="_blank">
                            <img src="<?php echo HResponse::uri(); ?>/images/qq_weibo.jpg"
                            class="fl mr5" />
                            腾讯微博
                        </a>
                    </dd>
                </dl>
            </div>
            <p class="pt20">
                Powered by
                <a href="http://www.hongjuzi.net" class="tdu clr6" target="_blank">
                   红橘子信息科技工作室 
                </a>
                &copy;Copyright 2013
                <a href="<?php echo HResponse::url(); ?>" class="tdu clr6" target="_blank">红橘子iShopping</a>
            </p>
        </div>
        <div id="J_returntop" class="return_top">&nbsp;</div>
        <script src="<?php echo HResponse::uri('vendor'); ?>/jquery/jquery.js"></script>
        <script src="<?php echo HResponse::uri('exchange'); ?>/js/jquery.prompt.min.js"></script>
        <script type="text/javascript">
        	var siteUrl = "<?php echo HResponse::url();?>";
        </script>
        <!--
        <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" 
　　　　　　　	data-appid="100566621" data-redirecturi="http://www.hongjuzi.net/ishopping/enter/qqlogin1" charset="utf-8">
　　　　　</script>
		-->
	
        <script>
            var PINER = {
                root: "/upload",
                uid: "",
                async_sendmail: "",
                config: {
                    wall_distance: "500",
                    wall_spage_max: "3"
                },
                //URL
                url: {}
            };
            //语言项目
            var lang = {};
            lang.please_input = "请输入";
            lang.username = "用户名";
            lang.password = "密码";
            lang.login_title = "用户登陆";
            lang.share_title = "我要分享";
            lang.correct_itemurl = "正确的商品地址";
            lang.join_album = "加入专辑";
            lang.create_album = "创建新专辑";
            lang.edit_album = "修改专辑";
            lang.confirm_del_album = "删除专辑，专辑里所有的图片都会被删除哦！你确定要删除此专辑吗？";
            lang.title = "标题";
            lang.card_loading = "正在获取用户信息";
            lang.confirm_unfollow = "确定要取消关注么？";
            lang.wait = "请稍后......";
        </script>
        <script type="text/javascript" src="<?php echo HResponse::uri(); ?>/js/9b0aa949f62c6ac17f960806ae200d08.js?20131119"> </script>
