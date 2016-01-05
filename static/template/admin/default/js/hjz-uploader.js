
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

/**
 * 上传工具类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package js
 * @since 1.0.0
 */
 var HJZUploader    = {
     defOpts: { 
         // swf文件路径
         swf: siteUrl + 'vendor/webuploader/Uploader.swf',
         // 文件接收服务端。
         server: queryUrl + 'public/resource/auploadimage',
         // 选择文件的按钮。可选。
         // 内部根据当前运行是创建，可能是input元素，也可能是flash.
         pick: '#upload-btn',
         // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
         resize: false,
         auto: true,
         accept: {
             title: 'Images',
             extensions: 'gif,jpg,jpeg,bmp,png',
             mimeTypes: 'image/*'
         },
         formData: {},
         fileVal: 'path',
         fileNumLimit: 5,
         fileSizeLimit: 0.5,
         dnd: '',
         disableGlobalDnd : true,
         duplicate: true 
     },
     createImage: function(dom, opts, callback) {
         opts['server']     = queryUrl + 'public/resource/auploadimage';
         opts['accept']     = {
             title: 'Images',
             extensions: 'gif,jpg,jpeg,bmp,png',
             mimeTypes: 'image/*'
         };

         return this.create(dom, opts, callback);
     },
     createFile: function(dom, opts, callback) {
         opts['server']     = queryUrl + 'public/resource/auploadfile';
         opts['accept']     = {title: '所有文件'};

         return this.create(dom, opts, callback);
     },
     createVideo: function(dom, opts, callback) {
         opts['server']     = queryUrl + 'public/resource/auploadvideo';
         opts['accept']     = {
             title: '视频',
             extensions: 'avi,flv,rmvb,mp4,mkv,rm,mov,wmv,asf',
             mimeTypes: 'video/*'
         };

         return this.create(dom, opts, callback);
     },
     createAudio: function(dom, opts, callback) {
         opts['server']     = queryUrl + 'public/resource/auploadaudio';
         opts['accept']     = {
             title: '音频',
             extensions: 'mp3,wma,wav,ogg,flac',
             mimeTypes: 'audio/*'
         };

         return this.create(dom, opts, callback);
     },
     create: function(dom, opts, callback) {
         var params     = this.defOpts;
         for(var ele in params) {
             if('undefined' === typeof(opts[ele])) {
                 continue;
             }
             params[ele] = opts[ele];
         }
         if(!params.server) {
             throw '上传不能为空！';
         }
         params['pick']             = dom;
         params.formData.is_ajax    = true;
         var uploader   = WebUploader.create(params);
         var total      = 0;
         uploader.on( 'error', function(type){
			uploader.reset();
            if(type == 'Q_EXCEED_NUM_LIMIT'){
                HHJsLib.warn('上传文件数量超出了指定值！');
            }else if(type == 'Q_EXCEED_SIZE_LIMIT'){
                HHJsLib.warn('上传文件大小超出了指定值！');
            }else if(type == 'Q_TYPE_DENIED'){
                HHJsLib.warn('上传文件类型不支持！');
            }else{
                HHJsLib.warn('未知错误，请稍后重试!');
            }
         });
         //上传完成后重设
         uploader.on('uploadFinished', function( file ) {
            uploader.reset();
         });
         //上传出错
         uploader.on( 'uploadError', function( file ) {
            uploader.reset();
            HHJsLib.warn("您的网络繁忙，上传“" + file.name + "”文件失败，请调整文件大小或是稍后再来上传！");
         });
         // 文件上传成功，给item添加成功class, 用样式标记上传成功。
         uploader.on( 'uploadSuccess', function( file, data ) {
            if('undefined' !== typeof(callback)) {
                callback(file, data);
            }
         });

         return uploader;
     }
 };


