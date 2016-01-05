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
                      <strong>公司新闻</strong>
                      <span>News</span>
                  </h3>
                  <ul class="cla-title pd-0">
                    <?php foreach(HResponse::getAttribute('catList') as $item) { ?>
                      <li><a href="<?php echo HResponse::url('news/type', 'id=' . $item['id']);?>"><?php echo $item['name'];?></a></li>
                    <?php }?>
                  </ul>
              </div>
            <?php require_once(HResponse::path() . 'common/contact.tpl'); ?>
        </div>
        <div class="col-md-8 article-list over_hidden ml-15">
            <?php $record   = HResponse::getAttribute('record');?>
           <div class="row-fluid">
               <p class="list-topic">
                   <label>当前位置:</label>
                   <a href="<?php echo HResponse::url();?>">网站首页</a>&gt;
                   <a href="<?php echo HResponse::url('news');?>"><span>公司新闻</span></a> &gt;
                   <span><?php echo $record['name'];?></span>
               </p>
               <div class="row-fluid pd-0 over_hidden ">
                   <div class="article-detail-box">
                       <h3><?php echo $record['name'];?></h3>
                       <?php echo HString::decodeHtml($record['content']);?>
                   </div>
                   <div class="article-detail-txt row-fluid pt-10 over_hidden">
                        <div class="col-md-4 pd-0 share-box">
                            <label>分享到&nbsp;:</label>
                            <a href="###"></a>
                            <a href="###" class="weibo"></a>
                            <a href="###" class="tengxun"></a>
                            <a href="###" class="weixin"></a>
                            <a href="###" class="add"></a>
                        </div>
                        <div class="col-md-8 detail-txt-list navbar-right">
                            <p><label>点击次数：</label><span><?php echo $record['total_visits'];?></span></p>
                            <p><label>更新时间：</label><span><?php echo HString::formatTime($record['create_time']);?></span></p>
                            <p><a href="###">【打印此页】</a></p>
                            <p class="mr-0"><a href="###">【关闭】</a></p>
                        </div>
                   </div>
                   <div class="row-fluid pd-0 over_hidden list-pre-next mt-20">
                       <p><?php echo HHtml::aPreRecord();?></p>
                       <p><?php echo HHtml::aNextRecord();?></p>
                   </div>
               </div>
           </div>
        </div>
    </div>
</div>
        <?php require_once(HResponse::path() . 'common/footer.tpl'); ?>	
</body>
</html>
