<?php require_once(HResponse::path() . '/common/header.tpl'); ?>
    </head>
    <body>
        <?php require_once(HResponse::path() . '/common/logo-top.tpl'); ?>
        <div class="main">
        <div class="pleft">
            <dl class="setpbox t1">
              <dt>安装步骤</dt>
                <dd>
                    <ul>
                        <li class="succeed">许可协议</li>
                        <li class="succeed">环境检测</li>
                        <li class="succeed">参数配置</li>
                        <li class="now">正在安装</li>
                        <li>安装完成</li>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="pright">
            <div class="pr-title"><h3>正在安装</h3></div>
            <div class="install-msg">
                <iframe src="<?php echo HResponse::url('index/setup', '', 'install'); ?>" id="mainfra" name="mainfra" frameborder="0" width='100%' height='350px'></iframe>
            </div>
        </div>
    </div>
    <div class="foot"></div>
    </body>
</html>
