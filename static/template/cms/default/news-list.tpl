﻿<?php require_once(HResponse::path() . '/common/header.tpl'); ?>    
    </head>
    <body>
            <?php require_once(HResponse::path() . '/common/top-navmenu.tpl'); ?>
        </div>
        <div class="wrapper">
            <div class="mains">
                <div class="mians-left">
                    <div class="lefts-top">
                        <div class="part1 title"><strong>新闻分类&nbsp;/</strong>News</div>
                        <div class="part2">
                            <ul>
                             <?php foreach(HResponse::getAttribute('catList') as $cat) { ?>
                                <li><a href="<?php echo HResponse::url('news/type', 'id=' . $cat['id']); ?>"><?php echo $cat['name']; ?></a></li>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php require_once(HResponse::path() . '/common/contact-box.tpl'); ?>
                </div>
                <div class="mians-right">
                    <div class="location-box">
                        <div class="rights-top-right">
                            <span class="location-title">你现在坐在的位置：</span>
                            <a href="<?php echo HResponse::url(); ?>"><span>首页</span></a>&gt;&gt;
                            <span>新闻中心</span>
                        </div>
                        <h3 class="title">新闻中心<span>News Center</span></h3>
                    </div>
                    <div class="mains-right-lefts">
                            <span >标题</span>
                        <ul>
                            <?php foreach(HResponse::getAttribute('list') as $news) { ?>
                            <li><a href="<?php echo HResponse::url('news', 'id=' .  $news['id']); ?>"><?php echo $news['description']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="mains-right-rights">
                        <span>时间</span>
                        <ul>
                            
                            <?php foreach(HResponse::getAttribute('list') as $news) { ?>
                            <li><?php echo date('Y-m-d', strtotime($news['create_time'])); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="mains-footer pages">
                        <?php echo HResponse::getAttribute('pageHtml'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once(HResponse::path() . '/common/footer.tpl'); ?>    	
    </body>
</html>
