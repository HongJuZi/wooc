<?php require_once(HResponse::path() . 'common/header.tpl'); ?>	
</head>
<body>
<div class="header pt-20">
    <?php require_once(HResponse::path() . 'common/navmenu.tpl'); ?>
</div>
<div class="article-list-main container pd-0">
    <div class="row-fluid banner-img">
        <img src="<?php echo HResponse::uri();?>images/article-list.png">
    </div>
    <div class="row-fluid mt-30">
        <div class="col-md-4 list-column over_hidden">
              <div class="row-fluid classfy-news">
                  <h3>
                      <strong>关于我们</strong>
                      <span>About Us</span>
                  </h3>
                  <ul class="cla-title pd-0">
                    <?php foreach(HResponse::getAttribute('sameList') as $item) { ?>
                      <li><a href="<?php echo HResponse::url('aboutus', 'id=' . $item['id']);?>"><?php echo $item['name'];?></a></li>
                    <?php } ?>
                  </ul>
              </div>
            <?php require_once(HResponse::path() . 'common/contact.tpl'); ?>
        </div>
        <div class="col-md-8 article-list over_hidden ml-15">
           <div class="row-fluid">
               <p class="list-topic">
                   <label>当前位置:</label>
                   <a href="<?php echo HResponse::Url();?>">网站首页</a>&gt;
                   <span>关于我们</span>
               </p>
               <div class="row-fluid aboutus-box pd-0 over_hidden">
                   <div class="over_hidden classfy-news about-us-con pd-0">
                    <?php $record = HResponse::getAttribute('record'); ?>
                       <h1><?php echo $record['name']?></h1>
                       <?php echo HString::decodeHtml($record['content']);?>
                   </div>
               </div>

           </div>
        </div>
    </div>
</div>
        <?php require_once(HResponse::path() . 'common/footer.tpl'); ?>	
</body>
</html>
