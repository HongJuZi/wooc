<?php require_once(HResponse::path() . 'common/header.tpl'); ?>	
</head>
<body>
<div class="header pt-20">
    <?php require_once(HResponse::path() . 'common/navmenu.tpl'); ?>
</div>
<div class="container main pd-0">
    <div class="row-fluid banner-box">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php foreach(HResponse::getAttribute('bannerList') as $key => $item) { ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key;?>" <?php echo !$key ? 'class="active"' :  '';?>></li>
                <?php }?>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php foreach(HResponse::getAttribute('bannerList') as $key => $item) { ?>
                <div class="item <?php echo !$key ? 'active' :  '';?>">
                    <a href="<?php echo HResponse::url($item['url']);?>">
                        <img src="<?php echo HResponse::touri($item['image_path']);?>" >
                    </a>
                </div>
                <?php }?>
            </div>
            <!-- Controls -->
            <a class="left leftbtn carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right rightbtn carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="row-fluid con_box">
        <div class="col-md-4 news-box">
            <div class="row-fluid">
                <div class="col-md-12">
                   <h3>公司新闻 <span>COMPANY NEWS</span></h3>
                    <img src="<?php echo HResponse::uri(); ?>images/img01.png">
                    <ul>
                        <?php foreach(HResponse::getAttribute('newsList') as $item) { ?>
                        <li>
                            <a href="<?php echo HResponse::url('news', 'id=' . $item['id']);?>"><?php echo $item['name'];?></a>
                            <span><?php echo date('Y-m-d', strtotime($item['create_time']));?></span>
                        </li>
                        <?php }?>
                    </ul>
                    <a  href="###"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 news-box cases_box">
            <div class="row-fluid">
                <div class="col-md-12">
                    <h3>经典案例 <span>CLASSIC CASE</span></h3>
                    <ul>
                        <?php foreach(HResponse::getAttribute('casesList') as $item) { ?>
                        <li><a href="<?php echo HResponse::url('cases', 'id=' .  $item['id']);?>" class="a_exit"><?php echo $item['name'];?></a>
                            <div class="row-fluid div_avtive">
                                <div class="col-md-4">
                                    <img src="<?php echo HResponse::touri($item['image_path']);?>">
                                </div>
                                <div class="col-md-8">
                                    <a href="<?php echo HResponse::url('cases', 'id=' .  $item['id']);?>"><?php echo $item['name'];?></a>
                                    <span><?php echo $item['description'];?></span>
                                </div>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                    <a  href="###"></a>
                </div>
            </div>
        </div>
        <div class="col-md-1 bg_score"></div>
        <div class="col-md-3 news-box score_box">
            <div class="row-fluid">
                <div class="col-md-12">
                    <h3>业务范围 <span>BUSINESS SCOPE</span></h3>
                    <?php $bessinessInfo    = HResponse::getAttribute('bessinessInfo');?>
                    <div>
                        <?php echo HString::decodeHtml($bessinessInfo['content']);?>
                    </div>
                </div>
                <div class="col-md-12 more03">
                    <a  href="###"></a>
                </div>
            </div>
        </div>
    </div>
</div>
        <?php require_once(HResponse::path() . 'common/footer.tpl'); ?>	
    </body>
</html>
