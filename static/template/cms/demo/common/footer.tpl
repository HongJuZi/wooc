<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 foot-nav">
                <p>
                    <a href="<?php echo HResponse::url('contact');?>">联系我们</a>|
                    <a href="<?php echo HResponse::url('news');?>">新闻动态</a>|
                    <a href="<?php echo HResponse::url('product');?>">产品展示</a>|
                    <a href="<?php echo HResponse::url('cases');?>">成功案例</a>|
                    <a href="<?php echo HResponse::url('jobs');?>">加入我们</a>|
                    <span>Copyright © 2016 <?php echo $siteCfg['name'];?></span>
                </p>
            </div>
        </div>
    </div>
</div>
<a id="go-top" href="javascript:void(0);" style="display: none;">Top</a>
<script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/jquery.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/bootstrap/v3/js/bootstrap.min.js?v=<?php echo $v; ?>"></script>
<div class="hide"><?php echo HString::decodeHtml($siteCfg['tongji_code']);?></div>
