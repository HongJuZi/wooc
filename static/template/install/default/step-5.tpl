<?php require_once(HResponse::path() . '/install/common/header.tpl'); ?>
    </head>
    <body>
    <?php require_once(HResponse::path() . '/install/common/logo-top.tpl'); ?>
    <div class="main">
        <div class="pleft">
            <dl class="setpbox t1">
                <dt>安装步骤</dt>
                <dd>
                    <ul>
                        <li class="succeed">许可协议</li>
                        <li class="succeed">环境检测</li>
                        <li class="succeed">参数配置</li>
                        <li class="succeed">正在安装</li>
                        <li class="now">安装完成</li>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="pright">
            <div class="pr-title"><h3>安装完成</h3></div>
            <div class="install-msg">恭喜您!已成功安装红橘子自助建站系统.您现在可以:</div>
            <div class="over-link fs-14">
                <a href="<?php echo HResponse::url('', '', 'cms'); ?>">访问网站首页</a>
                <a href="<?php echo HResponse::url('', '', 'admin'); ?>">登录网站后台</a>
            </div>
            <div class="install-msg">
                或者访问红橘子网站:<br />
            </div>
            <div class="over-link">
                <a href="http://www.xjiujiu.com" target="_blank">红橘子官方网站</a>
                <a href="http://blog.xjiujiu.com" target="_blank">红橘子博客</a>
                <a href="http://help.xjiujiu.com" target="_blank">帮助中心</a>
            </div>
        </div>
    </div>
    <div class="foot"></div>
    </body>
</html>
