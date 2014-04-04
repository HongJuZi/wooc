    <?php require_once(HResponse::path() . '/common/header.tpl'); ?>
    </head>
    <body>
    <?php require_once(HResponse::path() . '/common/logo-top.tpl'); ?>
    <form action="<?php echo HResponse::url('', 'step=4', 'install'); ?>" method="post" name="config_params">
    <input type="hidden" name="step" value="4" />
    <div class="main">
        <div class="pleft">
            <dl class="setpbox t1">
                <dt>安装步骤</dt>
                <dd>
                    <ul>
                        <li class="succeed">许可协议</li>
                        <li class="succeed">环境检测</li>
                        <li class="now">参数配置</li>
                        <li>正在安装</li>
                        <li>安装完成</li>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="pright">
            <div class="pr-title"><h3>数据库设定</h3></div>
            <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
                <tr>
                    <td class="onetd"><strong>数据库主机：</strong></td>
                    <td><input name="dbHost" id="db_host_id" type="text" value="localhost" class="input-txt" />
                    <small>一般为localhost</small></td>
                </tr>
                <tr>
                    <td class="onetd"><strong>数据库用户：</strong></td>
                    <td><input name="dbUserName" id="db_user_name_id" type="text" value="root" class="input-txt" /></td>
                </tr>
                <tr>
                    <td class="onetd"><strong>数据库密码：</strong></td>
                    <td>
                      <div style='float:left;margin-right:3px;'><input name="dbUserPassword" id="db_user_password_id" type="text" class="input-txt"/></div>
                      <div style='float:left' id='dbpwdsta'></div>
                    </td>
                </tr>
                <tr>
                    <td class="onetd"><strong>数据表前缀：</strong></td>
                    <td>
                        <input name="tablePrefix" id="table_prefix_id" type="text" value="hongjuzi_" class="input-txt" />
                        <small>如无特殊需要,请不要修改</small>
                    </td>
                </tr>
                <tr>
                    <td class="onetd"><strong>数据库名称：</strong></td>
                    <td>
                        <div style='float:left;margin-right:3px;'>
                            <input name="dbName" id="db_name_id" type="text" value="hongjuzi" class="input-txt"/>
                        </div>
                        <div style='float:left' id='havedbsta'></div>
                    </td>
                </tr>
            </table>

            <div class="pr-title"><h3>管理员初始密码</h3></div>
            <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
                <tr>
                    <td class="onetd"><strong>用户名：</strong></td>
                    <td>
                        <input name="admin_user_name" type="text" value="admin" class="input-txt" />
                        <p><small>只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符</small></p>
                    </td>
                </tr>
                <tr>
                    <td class="onetd"><strong>密　码：</strong></td>
                    <td><input name="admin_user_passwd" type="text" value="admin" class="input-txt" /></td>
                </tr>
                <tr>
                    <td class="onetd"><strong>Cookie加密码：</strong></td>
                    <td><input name="cookie_encode" type="text" value="<?php echo HObject::GC('COOKIE_ENCODE'); ?>" class="input-txt" /></td>
                </tr>
            </table>

            <div class="pr-title"><h3>网站设置</h3></div>
            <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
                <tr>
                    <td class="onetd"><strong>网站名称：</strong></td>
                    <td>
                        <input name="site_name" type="text" value="我的网站" class="input-txt" />
                    </td>
                </tr>
                <tr>
                    <td class="onetd"><strong>管理员邮箱：</strong></td>
                    <td><input name="admin_email" type="text" value="admin@xjiujiu.com" class="input-txt" /></td>
                </tr>
                <tr>
                    <td class="onetd"><strong> 网站网址：</strong></td>
                    <td><input name="site_url" type="text" value="<?php echo HObject::GC('SITE_URL'); ?>" class="input-txt" /></td>
                </tr>
                <tr>
                    <td class="onetd"><strong>程序安装目录：</strong></td>
                    <td><input name="root_dir" type="text" class="input-txt" value="<?php echo ROOT_DIR; ?>" /><small>在根目录安装时不必理会</small></td>
                </tr>
            </table>
            
          <div class="pr-title"><h3>安装测试体验数据</h3></div>
            <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
                <tr>
                    <td width="168"><strong> 
                      初始化数据体验包</strong>：</td>
                     <?php
                       if($isdemosign == 0)
                       {
                      ?>
                    <td width="558"><div class="olink" id="_remotesta"><div style="float:left">&nbsp; <font color="red">[×]</font> 不存在</div><a href="javascript:GetRemoteDemo()">远程获取</a></div></td>
                    <?php
                       } else {
                     ?>
                    <td width="558">&nbsp; <font color="green">[√]</font> 存在(您可以选择安装进行体验)</td>   
                     <?php
                     }
                     ?>
              </tr>
                <tr>
                    <td colspan="2"><label for="installdemo"><strong> 
                        <input name="installdemo" type="checkbox" id="installdemo" value="1" />
                    安装初始化数据进行体验</strong>(体验数据将含带HongJuZi大部分功能的应用操作示例)</label></td>
              </tr>
            </table>

            <div class="btn-box">
                <input type="button" class="btn-back"
                value="后退"onclick="window.location.href='<?php echo HResponse::url('', '', 'install'); ?>?step=2';" />
                <input type="submit" class="btn-next" value="开始安装" />
            </div>
        </div>
    </div>
    <div class="foot"></div>
    </form>
    </body>
</html>
