            <div id="J_m_head" class="m_head clearfix">
                <div class="head_logo fl">
                    <a href="<?php echo HResponse::url('ishopping'); ?>" class="logo_b fl" title="红橘子iShopping">
                        红橘子iShopping 
                    </a>
                </div>
                <div class="exchange-search">
                	<input type="text" name="name">
                	<div class="in-and-out">
                		<!--
                		<a href="" class="getin">换来</a>
                		<a href="" class="getout">换去</a>
                		-->
                		<?php 
                			$nextUrl = HResponse::url('bater/mall'); 
                			$user = HSession::getAttributeByDomain('user');
                			if(!empty($user)){
                		?>
                		欢迎回来,<?php echo $user['name'];?>
                		<a href="<?php echo HResponse::url('userinfo/usercenter','','public');?>">个人中心</a>
                		<a href="<?php echo HResponse::url('auser/logout','','oauth');?>">注销</a>
                		<?php }else{ ?>
                		<a href="<?php echo HResponse::url('userinfo/login','next_url='.$nextUrl,'public');?>">登录</a>
                		<a href="<?php echo HResponse::url('userinfo/register','','public');?>">注册</a>
                		<?php }?>
                	</div>
                </div>
            </div>
            <div id="J_m_nav" class="clearfix">
                <ul class="nav_list fl">
                    <li class="current">
                        <a href="<?php echo HResponse::url('index'); ?>">首页</a>
                    </li>
                    <li class="split ">
                        <a href="<?php echo HResponse::url('mvp'); ?>">精选</a>
                    </li>
                    <li class="split ">
                        <a href="<?php echo HResponse::url('market'); ?>">集市</a>
                    </li>
                    <li class="split ">
                        <a href="<?php echo HResponse::url('find'); ?>">发现</a>
                    </li>
                    <li class="split ">
                        <a href="<?php echo HResponse::url('aboutus'); ?>">关于</a>
                    </li>
                    <li class="top_search">
                        <form action="<?php echo HResponse::url('search'); ?>" method="get"
                        target="_blank">
                            <input type="hidden" name="m" value="search">
                            <input type="text" autocomplete="off" def-val="懒得逛了，我搜~" value="懒得逛了，我搜~"
                            class="ts_txt fl" name="q">
                            <input type="submit" class="ts_btn" value="搜索">
                        </form>
                    </li>
                </ul>
            </div>
