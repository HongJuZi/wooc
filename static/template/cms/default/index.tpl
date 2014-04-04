<?php require_once(HResponse::path() . '/common/header.tpl'); ?>    
</head>
<body>
    <?php require_once(HResponse::path() . '/common/top-navmenu.tpl'); ?>
	</div>
	<div class="main">
	<div class="main-top">
		<div class="weiduduan">
			<div id="focus">
				<ul>
                    <?php foreach(HResponse::getAttribute('bannerList') as $banner) { ?>
				    <li><a href="<?php echo $banner['jump_url']; ?>"><img  src="<?php echo HResponse::url() . $banner['image_path']; ?>" alt="<?php echo $banner['name']; ?>"/></a></li>
                    <?php } ?>
				</ul>
			</div>
		</div> 
		</div>
		<div class="main-down">
			<div class="wrapper">
				<div class="down-top">
				<div class="left">
					<div class="left-top">
					<a href="<?php echo HResponse::url('company'); ?>"><img src="<?php echo HResponse::uri(); ?>/images/star.png"/></a>
					<div>
					<h5>公司简介</h5>
					<span>Company</span>
					</div>
					</div>
					<div class="left-foot">
                    <?php foreach(HResponse::getAttribute('company') as $company) { ?>
					    <img src="<?php echo HResponse::url() . $company['image_path']; ?>" class="company-logo"/>
					    <span><?php echo $company['description']; ?></span>
                        <a href="<?php echo HResponse::url('company'); ?>">了解更多&gt;&gt;</a>
                     <?php } ?>
					</div>
				</div>
				<div class="middle">
				<div class="middle-top">
					<a href="<?php echo HResponse::url('news'); ?>"><img src="<?php echo HResponse::uri(); ?>/images/book.png"/></a>
					<h5>新闻动态</h5>
					<span>News</span>
					</div>
					<div class="middle-foot">
                        <ul class="index-news-list">
                            <?php foreach(HResponse::getAttribute('newsList') as $news) { ?>
                            <li>
                                <a href="<?php echo HResponse::url('news', 'id=' .  $news['id']); ?>">
                                    <span><?php echo date('Y-m-d', strtotime($news['create_time'])); ?></span>
                                    <?php echo $news['name']; ?>&nbsp;
                                    <img src="<?php echo HResponse::uri(); ?>/images/top.png"/>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
					</div>
				</div>
				<div class="right">
                    <div class="middle-top">
                        <a href="###"><img src="<?php echo HResponse::uri(); ?>/images/point.png"/></a>
                        <h5>联系我们</h5>
                        <span>Contact</span>
                    </div>
                    <div class="right-foot">
                        <ul>
                            <li><h4>地  址：</h4><span><?php echo $siteCfg['address']; ?></span></li>
                            <li><h4>电  话：</h4><span><?php echo $siteCfg['phone']; ?><span></li>
                            <li><h4>传  真：</h4><span><?php echo $siteCfg['fax']; ?><span></li>
                            <li><h4>E-mail：</h4><span><?php echo $siteCfg['email']; ?><span></li>
                            <li><h4>Q Q：</h4><span><?php echo $siteCfg['qq']; ?><span></li>
                            <li><h4>联系人：</h4><span><?php echo $siteCfg['administrator']; ?></span></li>
                        </ul>
                    </div>
				</div>
				</div>
				<div class="down-middle">
					<a href="<?php echo HResponse::url('goods'); ?>"><img src="<?php echo HResponse::uri(); ?>/images/car.png"/></a>
					<div>
					<h5>产品展示</h5>
					<span>Show</span>
					</div>	
				</div>
				<div class="down-down" >
					<div style="float:left;height: 0px;margin-top: 72px;width:30px;">
                        <a href="###" id="LeftButton2">
                            <img  src="<?php echo HResponse::uri(); ?>/images/left.png"/>
                        </a>
                    </div>
					<div  style="float:left;" ID="MarqueeDiv2" class="index-product-list-box">
                        <ul class="index-product-list">
                            <?php foreach(HResponse::getAttribute('goodsList') as $goods) { ?>
                            <li>
                                <a href="<?php echo HResponse::url('goods', 'id=' . $goods['id']); ?>">
                                    <img src="<?php echo HResponse::url() . $goods['image_path'];
                            ?>"/>
                                    <span><?php echo $goods['name']; ?></span>
                                </a>
                             </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div style="float:left;margin-top: 72px;width:30px;">
                        <a href="###" id="RightButton2"><img  src="<?php echo HResponse::uri(); ?>/images/right.png"/></a>
                    </div>
                </div>
				<div class="down-down-down">
                    <span class="frind-link-title">友情链接：</span>
                    <?php foreach(HResponse::getAttribute('linkList') as $link) { ?>
                    <a href="<?php echo $link['jump_url']; ?>"><?php echo $link['name']; ?></a>
                    <?php } ?>
				</div>
			</div>
			</div>
		</div>
    <?php require_once(HResponse::path() . '/common/footer.tpl'); ?>    
	<script type="text/javascript" src="<?php echo HResponse::uri(); ?>/js/js.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo HResponse::uri(); ?>/js/MyClass.js"></script>
	<script type="text/javascript" src="<?php echo HResponse::uri(); ?>/js/marquee.js"></script>

</body>
</html>
