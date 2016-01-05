		<!-- basic scripts -->
		<!--[if !IE]> -->
        <script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript">
            if (!window.jQuery) {
                var script = document.createElement('script');
                script.src = cdnUrl + "/jquery/jquery.js";
                document.body.appendChild(script);
            }
        </script>
		<!-- <![endif]-->
		<!--[if IE]>
        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo HResponse::uri();?>/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
        <![endif]-->
		<!-- page specific plugin scripts -->
        <script type='text/javascript' src="<?php echo HResponse::uri();?>/assets/js/bootstrap.min.js"></script>
        <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/js/md5.min.js"></script>
        <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/requirejs/require.js"></script>
        <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/hhjslib/hhjslib.min.js"></script>
        <script type="text/javascript">
            HHJsLib.curLang = '<?php echo HSession::getAttribute('identifier', 'lang'); ?>';
        </script>
        <script type='text/javascript' src="<?php echo HResponse::uri();?>/js/hjz-extend.js"></script>
