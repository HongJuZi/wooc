
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

/**
 * @var var jsonpParseThemeData 分析JSONP的数据
 */
var jsonpParseThemeData     = null;

/**
 * 模板市场公用JS
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package js
 * @since 1.0.0
 */
HHJsLib.register({
    liTpl: '<li class="span3">'
    + ' <a href="{url}" target="_blank"'
    + ' class="cboxElement theme-btn" '
    + ' title="查看详细：{name}"'
    + ' data-title="{name}" >'
    + ' <img alt="{name}" src="{image}">'
    + ' <div class="text"><i class="icon-eye-open"></i> 查看详情</div>'
    + ' </a>'
    + ' <div class="tags">'
    + ' <span class="label-holder">'
    + ' <span class="label label-success">'
    + ' By <a href="{website}" target="_blank">{publisher}</a>'
    + ' </span>'
    + ' </span>'
    + ' <span class="label-holder">'
    + ' <span class="label label-info"><a href="{download}">立即下载</a></span>'
    + ' </span>'
    + ' </div>'
    + ' </li>',
    init: function() {
        this.loadThemeList(1, '');
        this.bindSearchBtn();
        this.bindPerpageChange();
        this.initJsonpThemeDataFunc();
    },
    initJsonpThemeDataFunc: function() {
        var self    = this;
        jsonpParseThemeData     = function (response) {
            if(false === response.rs) {
                $('#theme-loading-box').addClass('alert alert-warn').html(response.message);
                return;
            }
            self.initThemeList(response.data);
        };
    },
    bindPerpageChange: function() {
        var self    = this;
        $('#perpage').bind('change', function() {
            self.loadThemeList(1, $('#keywords').val());
        });
    },
    bindSearchBtn: function() {
        var self    = this;
        $('#search-btn').click(function() {
            try {
                HHJsLib.isEmptyByDom('#keywords', '关键词');
                self.loadThemeList(1, $('#keywords').val());
            } catch(e) {
                return HHJsLib.warn(e);
            }
        });
    },
    loadThemeList: function(page, keywords) {
        var self    = this;
        var params  = 'page=' + page 
        + '&perpage=' + $('#perpage').val()
        + '&keywords=' + keywords;
        $.ajax({  
            type : "get",  
            async: false,  
            url : 'http://www.hongjuzi.net/index.php/theme/awoocmarket?' + params,
            dataType : "jsonp",//数据类型为jsonp  
            jsonp: "jsonpParseThemeData", //服务端用于接收callback调用的function名的参数  
            success : function(response){
                console.log('success!');
            },
            error: function(data, event){  
                if(200 !== data.status) {
                    $('#theme-loading-box').addClass('alert alert-warn')
                    .html('<i class="icon-exclamation"></i> 加载模板市场失败，请后再试:(');
                }
            }  
        });   
    },
    initThemeList: function(data) {
        if(1 > data.list.length) {
            $('#theme-loading-box').html('<i class="icon-time"></i> 模板市场正在建设中，敬请期待！');
            return;
        }
        var themeListHtml   = '';
        for(var ele in data.list) {
            var liHtml      = this.liTpl.replace(/{name}/g, data.list[ele].name);
            for(var attr in data.list[ele]) {
                var reg     = new RegExp('{' + attr + '}', 'ig');
                liHtml      = liHtml.replace(reg, data.list[ele][attr]);
            }
            themeListHtml   += liHtml;
        }
        $('#theme-loading-box').hide();
        $('#theme-list').html(themeListHtml).removeClass('hide').show();
        $("#pages").html(data.pageHtml);
        $("#cur-page").html(data.curPage);
        $("#total-rows").html(data.totalRows);
        $("#total-page").html(data.totalPage);
        this.bindPageClick();
    },
    bindPageClick: function() {
        var self    = this;
        $('#pages a').click(function() {
            self.loadThemeList(parseInt($(this).html()));
        });
    }
});
