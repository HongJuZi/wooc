<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <title>系统助手提示您</title>
        <link href="<?php echo HResponse::uri('cdn'); ?>/bootstrap/v2/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo HResponse::uri('cdn'); ?>/bootstrap/v2/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo HResponse::uri('public'); ?>/dialog/ace.min.css" />
        <script language="javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/jquery.js"></script>
        <script language="javascript" src="<?php echo HResponse::uri('cdn'); ?>/bootstrap/v2/js/bootstrap.min.js"></script>
        <script language="javascript" src="<?php echo HResponse::uri('cdn'); ?>/hhjslib/hhjslib.min.js"></script>
        <script language="javascript" src="<?php echo HResponse::uri('public'); ?>/dialog/hjz-extend.js"></script>
        <script type="text/javascript">
            $(function() {
                var typeMap     = {
                    status200: 'success',
                    status201: 'info',
                    status400: 'warning',
                    status500: 'error'
                };
                HHJsLib.dialog(
                    "<strong><?php echo $message; ?></strong>"
                    + "<i style='font-weight: 400;'>（请您稍等，<b id='close-time'><?php echo $time; ?></b>秒后页面将跳转...）</i>",
                    typeMap['status<?php echo $status; ?>']
                );
                setTimeout(function() {
                <?php if(is_int($url)) { ?>
                    history.go(<?php echo $url; ?>);
                <?php } else { ?>
                    window.location.href    = '<?php echo $url; ?>';
                <?php }?>
                }, <?php echo $time * 1000; ?>);
                $(function() {
                    setInterval(function() {
                        var time    = parseInt($('#close-time').html()) - 1;
                        time        = time < 1 ? 0 : time;
                        $('#close-time').html(time);
                    }, 800);
                });
            }); 
        </script>
    </head>
    <body></body>
</html>
