<script type="text/javascript">
// Current Server Time script (SSI or PHP)- By JavaScriptKit.com (http://www.javascriptkit.com)
// For this and over 400+ free scripts, visit JavaScript Kit- http://www.javascriptkit.com/
// This notice must stay intact for use.

//Depending on whether your page supports SSI (.shtml) or PHP (.php), UNCOMMENT the line below your page supports and COMMENT the one it does not:
//Default is that SSI method is uncommented, and PHP is commented:

//var currenttime = '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' //SSI method of getting server date
var currenttime = '<?php print date("F d, Y H:i:s", time()); ?>' // PHP method of getting server date

///////////Stop editting here/////////////////////////////////

var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime)

function padlength(what)
{
 var output=(what.toString().length==1)? "0"+what : what
 return output
}

function displaytime()
{
 serverdate.setSeconds(serverdate.getSeconds()+1)
 var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()
 var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
 document.getElementById("servertime").innerHTML=datestring+" "+timestring
}

setInterval("displaytime()", 1000)

</script>

<?php 
# Check date_default_timezone_set('America/Mexico_City');  in php.ini
echo $this->Html->div(Null, Null, array('style'=>'float:right;width:240px;')); 
?>
<b><?php echo __('Current Server Time'); ?>:</b><br /> <div id="servertime"></div>
</div>
