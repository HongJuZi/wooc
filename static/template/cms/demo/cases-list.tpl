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
                      <strong>成功案例</strong>
                      <span>Cases</span>
                  </h3>
                  <ul class="cla-title pd-0">
                    <?php foreach(HResponse::getAttribute('catList') as $item) { ?>
                      <li><a href="<?php echo HResponse::url('cases/type', 'id=' . $item['id']);?>"><?php echo $item['name'];?></a></li>
                    <?php }?>
                  </ul>
              </div>
            <?php require_once(HResponse::path() . 'common/contact.tpl'); ?>
        </div>
        <div class="col-md-8 article-list over_hidden ml-15">
           <div class="row-fluid">
               <p class="list-topic">
                   <label>当前位置:</label>
                   <a href="<?php echo HResponse::url();?>">网站首页</a>&gt;
                   <a href="<?php echo HResponse::url('cases');?>"><span>成功案例</span></a>
               </p>
               <ul class="list-pic pd-0 over_hidden mt-20">
                <?php foreach(HResponse::getAttribute('list') as $item) { ?>
                   <li>
                       <img src="<?php echo HResponse::touri($item['image_path']);?>"><br/>
                       <a href="<?php echo HResponse::url('cases', 'id=' . $item['id']);?>"><span><?php echo $item['name'];?></span></a>
                   </li>
                <?php }?>
               </ul>
               <div class="pic-page pt-0 text-center">
                <?php echo HResponse::getAttribute('pageHtml');?>
               </div>
           </div>
        </div>
    </div>
</div>
        <?php require_once(HResponse::path() . 'common/footer.tpl'); ?>	
</body>
</html>
