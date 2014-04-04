
<DIV id=floatTools class=float0831>
    <DIV class=floatL>
        <A style="DISPLAY: none" id=aFloatTools_Show class=btnOpen title=查看在线客服
        onclick="javascript:$('#divFloatToolsView').animate({width: 'show', opacity: 'show'}, 'normal',function(){ $('#divFloatToolsView').show();kf_setCookie('RightFloatShown', 0, '', '/', 'www.istudy.com.cn'); });$('#aFloatTools_Show').attr('style','display:none');$('#aFloatTools_Hide').attr('style','display:block');"
        href="javascript:void(0);">
            展开
        </A>
        <A id=aFloatTools_Hide class=btnCtn title=关闭在线客服 onclick="javascript:$('#divFloatToolsView').animate({width: 'hide', opacity: 'hide'}, 'normal',function(){ $('#divFloatToolsView').hide();kf_setCookie('RightFloatShown', 1, '', '/', 'www.istudy.com.cn'); });$('#aFloatTools_Show').attr('style','display:block');$('#aFloatTools_Hide').attr('style','display:none');"
        href="javascript:void(0);">
            收缩
        </A>
    </DIV>
    <DIV id=divFloatToolsView class=floatR>
        <DIV class=tp>
        </DIV>
        <DIV class=cn>
            <UL>
                <LI class=top>
                    <H3 class=titZx>
                        QQ咨询
                    </H3>
                </LI>
                <LI>
                    <SPAN class=icoZx>
                        在线咨询
                    </SPAN>
                </LI>
                <?php foreach(explode(',', $siteCfg['qq']) as $qq) { ?>
                <LI>
                    <a class="icoTc" target="_blank"
                    href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $qq; ?>&site=<?php echo HResponse::url(); ?>&menu=yes"><?php echo $qq; ?></a>
                </LI>
                <?php }?>
            </UL>
            <UL>
                <LI>
                    <H3 class=titDh>
                        电话咨询
                    </H3>
                </LI>
                <LI>
                    <SPAN class=icoTl><?php echo $siteCfg['phone']; ?></SPAN>
                </LI>
            </UL>
        </DIV>
    </DIV>
</DIV>
