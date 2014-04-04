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
                        <li class="now">环境检测</li>
                        <li>参数配置</li>
                        <li>正在安装</li>
                        <li>安装完成</li>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="pright">
            <div class="pr-title"><h3>服务器信息</h3></div>
            <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
                <tr>
                    <th width="300" align="center"><strong>参数</strong></th>
                    <th width="424"><strong>值</strong></th>
                </tr>
                <tr>
                        <td><strong>服务器域名</strong></td>
                        <td><?php echo HResponse::getAttribute('serverHost'); ?></td>
                </tr>
                <tr>
                        <td><strong>服务器操作系统</strong></td>
                        <td><?php echo HResponse::getAttribute('serverOs'); ?></td>
                </tr>
                <tr>
                        <td><strong>服务器解译引擎</strong></td>
                        <td><?php echo HResponse::getAttribute('parseEngine'); ?></td>
                </tr>
                <tr>
                        <td><strong>PHP版本</strong></td>
                        <td><?php echo HResponse::getAttribute('phpVersion'); ?></td>
                </tr>
                <tr>
                        <td><strong>系统安装目录</strong></td>
                        <td><?php echo ROOT_DIR; ?></td>
                </tr>
            </table>
            <div class="pr-title"><h3>系统环境检测</h3></div>
            <div style="padding:2px 8px 0px; line-height:33px; height:23px; overflow:hidden; color:#666;">
                系统环境要求必须满足下列所有条件，否则系统或系统部份功能将无法使用。
            </div>
            <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
                <tr>
                    <th width="200" align="center"><strong>需开启的变量或函数</strong></th>
                    <th width="80"><strong>要求</strong></th>
                    <th width="400"><strong>实际状态及建议</strong></th>
                </tr>
                <tr>
                        <td>allow_url_fopen</td>
                        <td align="center">On </td>
                        <td><?php echo HResponse::getAttribute('isAllowUrlFopen'); ?> <small>(不符合要求将导致采集、远程资料本地化等功能无法应用)</small></td>
                </tr>
                <tr>
                        <td>safe_mode</td>
                        <td align="center">Off</td>
                        <td><?php echo HResponse::getAttribute('isSafeMode'); ?> <small>(本系统不支持在<span class="STYLE2">非win主机的安全模式</span>下运行)</small></td>
                </tr>
                
                <tr>
                        <td>GD 支持 </td>
                        <td align="center">On</td>
                        <td><?php echo HResponse::getAttribute('isGd') ?> <small>(不支持将导致与图片相关的大多数功能无法使用或引发警告)</small></td>
                </tr>
                <tr>
                        <td>MySQL 支持</td>
                        <td align="center">On</td>
                        <td><?php echo HResponse::getAttribute('isMysql'); ?> <small>(不支持无法使用本系统)</small></td>
                </tr>
            </table>
            
            
            <div class="pr-title"><h3>目录权限检测</h3></div>
            <div style="padding:2px 8px 0px; line-height:33px; height:23px; overflow:hidden; color:#666;">
                系统要求必须满足下列所有的目录权限全部可读写的需求才能使用，其它应用目录可安装后在管理后台检测。
            </div>
            <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
                <tr>
                    <th width="300" align="center"><strong>目录名</strong></th>
                    <th width="212"><strong>读取权限</strong></th>
                    <th width="212"><strong>写入权限</strong></th>
                </tr>
                <?php
                foreach(HResponse::getAttribute('dirsInfo') as $dir => $info)
                {
                ?>
                <tr>
                    <td><?php echo $dir; ?></td>
                <?php
                    echo '<td>';
                    echo $info['r'] ? '<font color=green>[√]读</font>' : '<font color=red>[×]读</font>';
                    echo '</td><td>';
                    echo $info['w'] ? '<font color=green>[√]写</font>' : '<font color=red>[×]写</font>';
                    echo '<td>';
                  ?>
                </tr>
                <?php
                    }
                ?>
            </table>
            
            <div class="btn-box">
                <input type="button" class="btn-back" value="后退"
                onclick="window.location.href='<?php echo HResponse::url('', '', 'install'); ?>'" />
                <input type="button" class="btn-next" value="继续"
                onclick="window.location.href='<?php echo HResponse::url('', 'step=3', 'install'); ?>'" />
            </div>
        </div>
    </div>
    <div class="foot"></div>
    </body>
</html>
