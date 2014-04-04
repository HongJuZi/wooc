<?php require_once(HResponse::path() . '/common/header.tpl'); ?>    
</head>
<body>
    <?php require_once(HResponse::path() . '/common/top-navmenu.tpl'); ?>    
    <div class="wrapper">
        <div class="mian-mian">
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
            <div class="mian-mian-right">
                <div class="location-box">
                    <?php $record = HResponse::getAttribute('record'); ?>
                    <div class="rights-top-right">
                        <span class="location-title">你现在坐在的位置：</span>
                        <a href="<?php echo HResponse::url(); ?>"><span>首页</span></a>&gt;&gt;
                        <a href="<?php echo HResponse::url('goods'); ?>"><span>产品展示</span></a>
                    </div>
                    <h3 class="title">产品展示<span>Show</span></h3>
                </div>
                <div class="mian-rights-footers content-box">
                    <h1 class="title"><?php echo $record['name']; ?></h1>
                    <p class="other-info">
                        发布时间：<?php echo $record['create_time']; ?>
                        浏览量：<strong><?php echo $record['total_visits']; ?></strong>
                    </p>
                    <div class="footers-foot content">
                        <?php if($record['image_path']) { ?>
                        <p class="pic-box">
                            <img src="<?php echo HResponse::url() . $record['image_path']; ?>" />
                        </p>
                        <?php }?>
                        <?php echo HString::decodeHtml($record['content']); ?>
                    </div>
                </div>
                <div class="pre-next-record">
                     <?php HHtml::aPreRecord(); HHtml::aNextRecord(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php require_once(HResponse::path() . '/common/footer.tpl'); ?>    
</body>
</html>
