<?php require_once(HResponse::path() . '/common/header.tpl'); ?>
</head>
<body>
    <?php require_once(HResponse::path() . '/common/top-navmenu.tpl'); ?>
    <div class="wrapper">
        <div class="mian-mian">
            <div class="lefts">
                <div class="lefts-top">
                    <div class="part1"><span>最新招聘</span><span>Job</span></div>
                    <div class="part2">
                        <ul>
                            <?php foreach(HResponse::getAttribute('job') as $job) { ?>
                            <li><a href="<?php echo HResponse::url('job', 'id=' .  $job['id']); ?>"><?php echo $job['description']; ?></a><span><?php echo date('Y-m-d',strtotime($job['create_time'])); ?></span>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                        <div class="clearfix"></div>
                    <div class="lefts-foot">
                        <div class="part1" ><span>联系我们</span><span>product</span></div>
                        <div class="lefts-foot-part2">
                                <?php require_once(HResponse::path() . '/common/link-us.tpl'); ?>
                        </div>
                    </div>
            </div>
            <div class="mian-mian-right">
                <div class="rights-top">
                            <div class="rights-top-left"><h3>联系方式</h3><span>Message</span></div>
                            <div class="rights-top-right">
                                <span class="location-title">你现在坐在的位置>></span><span>联系方式</span>
                            </div>
                </div>
                <hr/>
                <div class="mian-rights-footers">
                    <?php $record = HResponse::getAttribute('record'); ?>
                    <div class="footers-top"><h3><?php echo $record['name']; ?></h3><span>发布人:<?php echo $record['author']; ?>  发布时间：<?php echo date('Y-m-d', strtotime($record['create_time'])); ?></span></div>
                    <hr/ style="width:570px;background-color:#b1b1b1;margin:0 auto;height: 1px;">
                    <div class="footers-foot">
                        <span><?php echo $record['content']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
	</div>
    <?php require_once(HResponse::path() . '/common/footer.tpl'); ?>
</body>
</html>
