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
                      <li><a href="<?php echo HResponse::url('aboutus');?>">关于我们</a></li>
                      <li><a href="<?php echo HResponse::url('contact');?>">联系我们</a></li>
                  </ul>
              </div>
            <?php require_once(HResponse::path() . 'common/contact.tpl'); ?>
        </div>
        <div class="col-md-8 article-list over_hidden ml-15">
           <div class="row-fluid">
               <p class="list-topic">
                   <label>当前位置:</label>
                   <a href="<?php echo HResponse::url();?>">网站首页</a>&gt;
                   <span>留言本</span>
               </p>
               <div class="row-fluid pd-0 detail-form mt-25 pb-20">
                   <form class="form-inline" method="post" action="<?php echo HResponse::url('message/post');?>" id="message-form">
                       <div>
                           <div class="form-group">
                               <label>姓名：</label>
                               <input type="text" class="form-control per-sum" placeholder="" name="name" id="name">
                           </div>
                       </div>
                       <div>
                           <div class="form-group">
                               <label>电话：</label>
                               <input type="text" class="form-control per-sum" placeholder="" name="phone" id="phone">
                           </div>
                       </div>
                       <div>
                           <div class="form-group">
                               <label>Email：</label>
                               <input type="text" class="form-control per-sum" placeholder="" name="email" id="email">
                           </div>
                       </div>
                       <div>
                           <div class="form-group">
                               <label>留言内容：</label>
                               <textarea class="form-control" name="content" id="content"></textarea>
                           </div>
                       </div>
                       <div>
                           <div class="form-group">
                               <label></label>
                               <button type="submit" class="btn btn-primary btn-sure">提交</button>
                               <button type="button" class="btn btn-primary btn-sure">取消</button>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
        </div>
    </div>
</div>
        <?php require_once(HResponse::path() . 'common/footer.tpl'); ?>	
        <script type="text/javascript" src="<?php echo HResponse::uri('cdn');?>hhjslib/hhjslib.min.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri();?>js/message.js"></script>
</body>
</html>
