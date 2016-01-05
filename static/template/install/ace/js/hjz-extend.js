
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

 HHJsLib.extend({
     codeEditor: {},

    /**
     * 成功信息提醒弹框
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String msg 提示信息
     * @return HHJsLib 库对象
     */
    succeed: function(msg, callback) {
        this.alert(msg, 'succeed', callback);

        return false;
     },

    /**
     * 警告提醒弹框
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String msg 提示信息
     * @return HHJsLib 库对象
     */
    warn: function(msg, callback) {
        this.alert(msg, 'warning', callback);

        return false;
     },

    /**
     * 信息提醒弹框
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String msg 提示信息
     * @return HHJsLib 库对象
     */
    info: function(msg, callback) {
        this.alert(msg, 'information', callback);

        return false;
     },

     /**
      * 第三方公用的显示方法
      * 
      * @author xjiujiu <xjiujiu@foxmail.com>
      * @access public
      * @param  String msg 需要显示的信息
      * @param  String type 信息类型 
      */
     alert: function(msg, type, callback) {
        var content     = this.getMessage(msg);
        this.focusTarget(msg.dom);
        HHJsLib.importCss([cdnUrl + "/jquery/plugins/notification/css/jquery.notification.css"]);
        HHJsLib.importJs([cdnUrl + "/jquery/plugins/notification/jquery.notification.js"], function() {
            var closeTime   = 3;
            showNotification({
                message: content + "（此信息<span id='close-time'>" + closeTime + "</span>秒后将自动关闭。）",
                type: type,
                autoClose: true,
                duration: closeTime
            });
            var timer   = setInterval(function() {
                var time    = parseInt($("#close-time").text()) - 1;
                if(time < 1) {
                    time    = 0;
                    clearInterval(timer);
                }
                $("#close-time").html(time);
            }, closeTime * 300);
            if('undefined' !== typeof(callback)) {
                setTimeout(function() {
                    callback();
                }, 1000);
            }
        });
     },

     Modal: {
         /**
          * @var dialogTpl: 弹框使用的模板
          */
         dialogTpl: '<div id="dialog-{id}" data-id="{id}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="dialog-{id}" aria-hidden="true">'
         + ' <div class="modal-header">'
         + ' <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
         + ' <h3 id="dialog-{id}">{title}</h3>'
         + ' </div>'
         + ' <div class="modal-body" id="dialog-body-{id}">{content}</div>'
         + ' <div class="modal-footer" id="dialog-footer-{id}">'
         + ' <button class="btn btn-primary btn-sm" data-id="{id}" id="ok-btn-{id}">确认</button>'
         + ' </div>'
         + ' </div>',
         succeed: function(content) {
             return this.alert('success', content); 
         },
         warn: function(content) {
             return this.alert('warning', content); 
         },
         error: function(content) {
             return this.alert('error', content); 
         },
         info: function(content) {
             return this.alert('info', content); 
         },
         alert: function(type, content) {
             return this.dialog(
                 '系统助手提示您',
                 '<div class="alert alert-' + type + '">' + content + '</div>'
             ); 
         },
         confirm: function(title, content, callback) {
             return this.dialog(title, content, callback);
         },

         /**
          * 重新定义当前弹框的显示方法
          * 
          * 使用Bootstrap的内置方法
          * 
          * @author xjiujiu <xjiujiu@foxmail.com>
          * @access public
          * @param  Object msg 需要显示的对象
          * @param  String title 标题
          * @param  Function callback 回调函数
          * @return false
          */
         dialog: function(title, content, callback) {
            var id          = new Date().valueOf();
            content         = this.dialogTpl.replace(/{content}/gi, content);
            content         = content.replace(/{id}/gi, id);
            content         = content.replace(/{title}/gi, title);
            $("body").append(content);
            var $dialog     = $('#dialog-' + id);
            $dialog.removeClass('hide').modal('show').on('hide, hidden', function() {
                $dialog.remove();
            });
            $("#ok-btn-" + id).click(function() {
                $dialog.modal('hide');
                'undefined' === typeof(callback) ? false : callback($dialog);
            });

            return $dialog;
         }
     },
     timestampToDateTime: function(timestamp) {
         var date   = new Date(timestamp * 1000);
         var year   = date.getFullYear();
         var month  = date.getMonth() + 1;
         var day    = date.getDate();
         var hour   = date.getHours();
         var min    = date.getMinutes();
         var sec    = date.getSeconds();

         return year + '-' + month + '-' + day + ' ' + hour + ':' + min + ':' + sec;
     }
 });
