<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head><title>Karamelo :: <?php echo $title_for_layout?></title>
<?php
if ( isset($this->Js) ):
  echo $this->Html->charsetTag('UTF-8');
  echo $this->Html->script('jquery-min');
endif;
?>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
img{border:0}
body {background-color:#ffffff; margin:3pt;font-family: Arial, Verdana, Helvetica, Tahoma;}
.title_section {
 color:#cc0033;
 border-bottom:dotted 1px gray;
 font-size:12pt;
 margin:7px 0 7px 0;
 padding:3px;
}
.der {text-align:right;font-weight:bold;font-size:9pt;}
#container {text-align:left;font-size:10pt;width:350px;margin-left:auto;margin-right:auto;}
#titulo {border:1px orange solid; margin-top:16pt;padding:12pt;color:#e67d1c;font-size:16pt;text-align:center;width:70%;margin-left:auto;margin-right:auto;}
#footer {border:1px grey solid; margin-top:16pt;padding:4px;color:#000;background-color:#dad9d9;font-size:7pt;text-align:left;width:70%;margin-left:auto;margin-right:auto;}
.warning {color:red;font-size:10px;text-align:left;}
button {background-color:orange;color:#fff;border:1px solid gray;font-size:8pt;padding:5px;}
input {background-color:#eda2bb;color:#000;border:1px solid gray;font-size:7pt;padding:1px;}
-->
</style>
</head>
<body id="cuerpo">
  <div id="tdmain">
        <?php echo $content_for_layout ?>
  </div>
</body>
</html>