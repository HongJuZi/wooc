<?php require_once(HResponse::path() . '/common/header.tpl'); ?>    
    </head>
    <body>
    <?php require_once(HResponse::path() . '/common/top-navmenu.tpl'); ?>
        </div>
        <div class="wrapper">
            <div class="middles">
            <div class="lefts">
                <div class="lefts-top">
                    <div class="part1 title"><strong>产品分类&nbsp;/</strong>Product</div>
                    <div class="part2">
                        <ul>
                         <?php foreach(HResponse::getAttribute('catList') as $cat) { ?>
                            <li><a href="<?php echo HResponse::url('goods/type', 'id=' . $cat['id']); ?>"><?php echo $cat['name']; ?></a></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php require_once(HResponse::path() . '/common/contact-box.tpl'); ?>
            </div>
                <div class="rights">
                    <div class="location-box">
                        <div class="rights-top-right">
                            <span class="location-title">你现在坐在的位置：</span>
                            <a href="<?php echo HResponse::url(); ?>"><span>首页</span></a>&gt;&gt;
                            <span>产品展示</span>
                        </div>
                        <h3 class="title">产品展示<span>Show</span></h3>
                    </div>
                    <div class="rights-middle product-list-box">
                        <ul class="product-list">
                         <?php foreach(HResponse::getAttribute('list') as $goods){ ?>
                            <li>
                                <a href="<?php echo HResponse::url('goods', 'id=' . $goods['id']); ?>">
                                    <img src="<?php echo HResponse::url() . $goods['image_path']; ?>"/>
                                    <span> <?php echo $goods['name'];?></span>
                                    发布时间: <?php echo date('Y-m-d', strtotime($goods['create_time'])); ?>
                                </a>
                            </li>
                          <?php }?>
                        </ul> 
                    </div>
                    <div class="rights-foot pages">
                         <?php echo HResponse::getAttribute('pageHtml'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once(HResponse::path() . '/common/footer.tpl'); ?> 
    </body>
</html>
