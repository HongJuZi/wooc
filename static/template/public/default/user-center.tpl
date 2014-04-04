<?php require_once(HResponse::path() . '/common/header.tpl'); ?>
	<link rel="stylesheet" href="<?php echo HResponse::uri('exchange'); ?>/css/user-center.css" type="text/css" media="screen">
    </head>
    
    <body>
        <div class="w960"><!--矩形广告位--></div>
        <!--头部开始-->
        <div class="header_wrap pt10">
           <?php require_once(HResponse::path() . '/common/top-nav.tpl'); 
           		$record  = HResponse::getAttribute('record');
           ?> 
        </div>
        <div class="main_wrap">
            <div class="mt10">
                <!--矩形广告位-->
                <a title="利趣" href="/index.php?m=advert&a=tgo&id=15" target="_blank">
                    <img alt="利趣" src="/data/upload/advert/1211/24/50b0819343e93.gif" width="960" height="90">
                </a>
            </div>
            <div class="user-center-wrapper">
            	<div class="left-sider">
					<div class="operate">
				    	<h3>个人中心</h3>
				        <ul id="J_navlist">
				        	<li>
				            	<h4>个人信息</h4>
				            	<div class="list-item none">
				              		<p><a href="" target="_self">我的消息</a></p>
				              		<p><a href="" target="_self">个人资料</a></p>
				              		<p><a href="" target="_self">修改密码</a></p>
				            	</div>
				          	</li>
				        	<li>
				            	<h4>以物换物</h4>
				            	<div class="list-item none">
				              		<p><a href="" target="_self">我的换物</a></p>
				              		<p><a href="" target="_self">我的收藏</a></p>
				            	</div>
				          	</li>
				          	<li>
				            	<h4>ishare分享</h4>
				            	<div class="list-item none">
				              		<p><a href="" target="_self">我的分享</a></p>
				              		<p><a href="" target="_self">我的收藏</a></p>
				            	</div>
				          	</li>
				          	<li>
				            	<h4>我的商品</h4>
				            	<div class="list-item none">
				              		<p><a href="" target="_self">我的专辑</a></p>
				              		<p><a href="" target="_self">我的收藏</a></p>
				            	</div>
				          	</li>
				        </ul>
				    </div>
				 </div>
				 <div class="right-sider">
				 	<div>
				 		<img src="<?php echo HResponse::url('').$user['image_path'];?>" style="width:200px;height:160px;float:left;">
				 		<div>
				 			<p>你好,<?php echo $record['name'];?></p>
				 		</div>
				 	</div>
				 </div>
        	</div>
               
        </div>
        <div class="w960"> <!--矩形广告位--> </div>
        <?php require_once(HResponse::path() . '/common/footer.tpl'); ?>
        <script src="<?php echo HResponse::uri('exchange'); ?>/js/user-center.js"></script>
        <script>
           
        </script>
    </body>

</html>
