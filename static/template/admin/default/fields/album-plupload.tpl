                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <div id="uploader">
                                            <p>您的浏览器没有 Flash, Silverlight or HTML5 support.</p>
                                        </div>
                                        <input name="album_hash" type="hidden"
                                        value="<?php echo empty($record['album_hash']) ? HString::getUUID('') : $record['album_hash']; ?>"/>
                                        <span class="help-inline"><?php $popo->getFieldComment($field); ?></span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    HHJsLib.importCss([
                                        "<?php echo HResponse::uri('vendor'); ?>/jquery/plugins/jqueryui/themes/base/jquery-ui.min.css", 
                                        "<?php echo HResponse::uri('vendor'); ?>/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css"
                                    ]);
                                    HHJsLib.importJs([
                                        "<?php echo HResponse::uri('vendor'); ?>/plupload/js/plupload.full.min.js", 
                                        "<?php echo HResponse::uri('vendor'); ?>/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js",
                                        "<?php echo HResponse::uri('vendor'); ?>/plupload/js/i18n/zh_CN.js"
                                    ], function() {
                                        // Initialize the widget when the DOM is ready
                                        $("#uploader").plupload({
                                            browse_button: '添加文件',
                                            // General settings
                                            runtimes : 'html5,flash,silverlight,html4',
                                            url : siteUrl + 'index.php/admin/album/aupload',
                                            // User can upload no more then 20 files in one go (sets multiple_queues to false)
                                            max_file_count: 20,
                                            chunk_size: '1mb',

                                            // Resize images on clientside if we can
                                            resize : {
                                                width : 200, 
                                                height : 200, 
                                                quality : 90,
                                                crop: true // crop to exact dimensions
                                            },
                                            
                                            filters : {
                                                // Maximum file size
                                                max_file_size : '5mb',
                                                // Specify what files to browse for
                                                mime_types: [
                                                    {title : "图片类型", extensions : "jpg,gif,png"}
                                                ]
                                            },

                                            // Rename files by clicking on their titles
                                            rename: true,
                                            
                                            // Sort files
                                            sortable: true,

                                            // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
                                            dragdrop: true,

                                            // Views to activate
                                            views: {
                                                list: true,
                                                thumbs: true, // Show thumbs
                                                active: 'thumbs'
                                            },

                                            // Flash settings
                                            flash_swf_url : siteUrl + '/vendor/plupload/js/Moxie.swf',

                                            // Silverlight settings
                                            silverlight_xap_url : siteUrl + '/vendor/plupload/js/Moxie.xap'
                                        });
                                    });
                                </script>
