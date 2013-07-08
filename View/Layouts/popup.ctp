<?php
 echo '<?xml version="1.0"?>';
 echo $this->Html->docType();

 echo '<html><head><title>Karamelo::'. $title_for_layout.'</title>';
 echo $this->Html->charset('utf-8');
 echo $this->Html->script(array('jquery-min', 'myfunctions'));
 echo $this->Html->scriptBlock('window.onload = timedMsg;');
 echo $this->Html->css('common/blog');
?>
<style type="text/css">
<!--
img{border:0}
body {background-color:#fff;margin:3pt;font-family: Arial, Verdana, Helvetica, Tahoma;}
.Correct{font-size:7pt;color:green;}
.Incorrect{font-size:7pt;color:red;}
.title_section {
	color:#cc0033;
	border-bottom:dotted 1px gray;
	font-size:12pt;
  margin:7px 0 7px 0;
  padding:3px;
	}
.der {text-align:right;font-weight:bold;font-size:9pt;}
#container {text-align:left;font-size:10pt;width:90%;margin-left:auto;margin-right:auto;min-height:400px;}
#titulo {border:1px orange solid; margin-top:16pt;padding:12pt;color:#e67d1c;font-size:16pt;text-align:center;width:70%;margin-left:auto;margin-right:auto;}
#footer {border:1px grey solid; margin-top:36pt;padding:2px;color:#000;background-color:#efefef;font-size:7pt;text-align:left;width:90%;margin-left:auto;margin-right:auto;}
.warning {color:red;font-size:10px;text-align:left;}
.divblock{margin:5px;border:1px dotted gray;padding:4px;}
/* Message by flash CakePHP stuff */
.message
{
    position:absolute;
    top:5px;
    right:10px;
    width:200px;
    font-size:9pt;
    font-weight:bold;
    color:white;
    border: solid 1px orange;
    padding:2px;
    background-color:#cc3300;
    text-align:center;
}
/* Begin forms */
input, button, textarea, select {
    background-color: #fff;
    color: #000;
    padding: 2px;
    font-family: "Lucida Grande", Myriad, "Andale Sans", "Luxi Sans", "Bitstream Vera Sans", Tahoma, "Toga Sans", Helvetica, Arial, sans-serif;
    font-size: small;
}

button, input[type="button"], input[type="submit"]  {
    background-color: #efefef;
    color: #888a85;
    border: 1px solid #babdb6;
    border-top: 1px solid #d3d7cf;
    border-left: 1px solid #d3d7cf;
    font-weight: bold;
    margin-left: 2px;
    margin-right: 2px;
    font-family: "Lucida Grande", Myriad, "Andale Sans", "Luxi Sans", "Bitstream Vera Sans", Tahoma, "Toga Sans", Helvetica, Arial, sans-serif;
    cursor: pointer;
    font-size: small;
}

select {
     cursor: pointer;
     background-color: #d6ff67;
     color: #000;
     border: 1px solid #666699; 
     padding:4px;
     font-size:9pt;
}

button:hover, input[type="button"]:hover, input[type="submit"]:hover  {
    background-color: #3465a4;
    color: #fff;
}

button:active, input[type="button"]:active, input[type="submit"]:active {
    background-color: #fff;
    color: #000;
    border: 1px solid #3465a4;
}
 .divhelp{width:100px;float:right;}
-->
</style>
</head>
<body>
<?php 
echo $this->Session->flash(); 
echo '<div id="container">';
echo $this->Html->div('divhelp', $this->element('window_help'));
echo $content_for_layout; 
?>
</div>
<div style="clear:both"></div>
<div id="footer">Powered by <a href="http://www.chipotle-software.com/" target="_blank">Karamelo Project 2006-2012 &copy;</a></div>
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>