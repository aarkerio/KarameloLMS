<style type="text/css">
#wikitoolbar {
 padding:3px;
 margin:15px 0 0 0;
 width:700px;
 height:10px;
}
.flotter{float:right;width:200px;}
#wikitoolbar img {display:block; padding:0;margin:0;vertical-align:bottom;float:left; }
</style>

<script type= "text/javascript">
/*<![CDATA[*/
// wiki_add('--','--','underline')
function wiki_add(open_tag, close_tag, tag_text) 
{
  var text_element = document.getElementById('Revision0Content');

  if (text_element.setSelectionRange > '') 
  {
    var p0   = text_element.selectionStart; // inicio
    var p1   = text_element.selectionEnd;   // final
    var top  = text_element.scrollTop;
    var str  = tag_text;
    var cur0 = p0 + open_tag.length;
    var cur1 = p0 + open_tag.length + str.length;
    while (p1 > p0 && text_element.value.substring(p1-1, p1) == ' ') 
    {
      p1--;   // position
    }
    if (p1 > p0)  // si en verdad hay texto en el textarea 
    {
      str = text_element.value.substring(p0, p1);
      cur0 = p0 + open_tag.length + str.length + close_tag.length;
      cur1 = cur0;
    }
    text_element.value = text_element.value.substring(0,p0) + open_tag + str + close_tag + text_element.value.substring(p1);
    text_element.focus();
    text_element.selectionStart = cur0;
    text_element.selectionEnd   = cur1;
    text_element.scrollTop      = top;
  }  
  else if (document.selection) 
  {
    var str = document.selection.createRange().text;
    text_element.focus();
    range = document.selection.createRange()
    if (str == '') 
    {
       range.text = open_tag + tag_text + close_tag;
       range.moveStart('character', -close_tag.length - tag_text.length );
       range.moveEnd('character', -close_tag.length );
    } 
    else 
    {
       if (str.charAt(str.length - 1) == " ") 
       {
	  close_tag = close_tag + " ";
	  str = str.substr(0, str.length - 1);
       }
       range.text = open_tag + str + close_tag;
    }
    range.select();
  } 
  else 
  { 
    text_element.value += open_tag + tag_text + close_tag; 
  }
  return;
}
/*]]>*/
</script>

<div id="wikitoolbar">
<a href="#legend"><img onclick="wiki_add('**','**','bold');" src="/img/static/button_bold.png" alt="Bold" title="Bold" /></a> 
<a href="#legend"><img onclick="wiki_add('\'\'\'','\'\'\'','italics');" src="/img/static/button_italic.png" alt="Italics"  /></a> 
<a href="#legend"><img onclick="wiki_add('___','___','underline');" src="/img/static/button_underline.png" alt="Underline" title="Underline" /></a> 
<a href="#legend"><img onclick="wiki_add('<code type=\'php\'>\n','</code>\',' Some code\');" src="/img/static/wiki_source.png" alt="Code" title="Code" /></a> 
<a href="#legend"><img onclick="wiki_add('', '<br />\n','');" src="/img/static/wiki_br.png" alt="BreakLine" title="Breakline" /></a> 
<a href="#legend"><img onclick="wiki_add('\n++', '\n','heading');" src="/img/static/button_headline.png" alt="Heading" title="Headline" /></a> 
<a href="#legend"><img onclick="wiki_add('', '\n----\n','');" src="/img/static/button_hr.png" alt="Line" title="Line" /></a> 
<a href="#legend"><img onclick="wiki_add('[', ']','http://www.ejemplo.com Titulo del enlace');" src="/img/static/button_extlink.png" alt="Link" title="Link" /></a> 

<?php
echo $this->Html->link($this->Html->image('static/button_image.png',
     array('onclick'=>"wiki_add('[', ']','http://".$_SERVER['HTTP_HOST']."/img/imgusers/image.png Description');", 'alt'=>'Inline image', 'title'=>'Inline image')), '#legend', array('escape'=>False));
 
echo $this->Html->link($this->Html->image('static/arrow_below.gif', array('alt'=>__('Expand area height'), 'onclick'=>'new ResizeableTextarea(\'Revision0Content\');', 'style'=>'margin-left:25px;', 'title'=>__('Expand area height'))), '#legend', array('escape'=>False));
echo '</div><div style="clear:both"></div>';
echo $this->Form->input('Revision.0.content', array('cols'=>110,'rows' =>20, 'type'=>'textarea', 'class'=>'wikitext', 'label'=>False));
?>