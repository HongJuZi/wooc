<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>系统提示</title>
  <script type="text/javascript" src="<?php echo HResponse::uri('rendor'); ?>/jquery/jquery.js"></script>
  <script type="text/javascript" src="<?php echo HResponse::uri('rendor'); ?>/requirejs/require.js"></script>
  <script type="text/javascript" src="<?php echo HResponse::uri('rendor'); ?>/hhjslib/hhjslib.js"></script>
  <script type="text/javascript" src="<?php echo HResponse::uri('rendor'); ?>/hhjslib/hhjslib.hhrequire.js"></script>
  <script type="text/javascript" src="<?php echo HResponse::uri('rendor'); ?>/hhjslib/hhjslib.hhdialog.js"></script>
  <script type="text/javascript">
        var rendorUrl   = '<?php echo HResponse::uri('rendor'); ?>/jquery/plugins';
        $(function() {
            HHJsLib.depend(rendorUrl);
            HHJsLib.Modal.alert(<?php echo HResponse::getAttribute('msg'); ?>, function() {
                window.history.go(-1);
            });
        }); 
  </script>
</head>
<body>
  
</body>
</html>
