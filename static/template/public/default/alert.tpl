<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <title>系统助手提示您</title>
        <link href="<?php echo HResponse::uri('cdn'); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo HResponse::uri('admin'); ?>/css/ace.min.css" />
        <script language="javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/jquery.js"></script>
        <script language="javascript" src="<?php echo HResponse::uri('cdn'); ?>/bootstrap/js/bootstrap.min.js"></script>
        <script language="javascript" src="<?php echo HResponse::uri('cdn'); ?>/hhjslib/hhjslib.js"></script>
        <script language="javascript" src="<?php echo HResponse::uri('cdn'); ?>/hhjslib/hhjslib.hhfile.js"></script>
        <script language="javascript" src="<?php echo HResponse::uri('cdn'); ?>/hhjslib/hhjslib.hhdialog.js"></script>
        <script language="javascript" src="<?php echo HResponse::uri('admin'); ?>/js/hjz-extend.js"></script>
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
                    + "<i style='font-weight: 400;'>（请您稍等，<?php echo $time; ?>秒后页面将跳转...）</i>",
                    typeMap['status<?php echo $status; ?>']
                );
                <?php if(is_int($url)) { ?>
                history.go(<?php echo $url; ?>);
                <?php } else { ?>
                setTimeout(function() {
                    window.location.href    = '<?php echo $url; ?>';
                }, <?php echo $time; ?>);
                <?php }?>
            }); 
        </script>
    </head>
    <body></body>
</html>
