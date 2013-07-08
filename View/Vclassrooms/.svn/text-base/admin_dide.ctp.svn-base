<?php
$this->set('title_for_layout', 'Kandies');
echo $this->Gags->imgLoad('loading'); 
?>
<style>
#container {
width:800px;
}

.tabs {
 width:140px;
 margin-right:10px;
 padding:6px;
 text-align:center;
 float:left;
 cursor:pointer;
 border:1px solid #ccc;
 border-bottom:0;
 }

.tabs a, a:visited{ text-decoration:none;font-weigth:bold;color:blue;}
.tabs a:hover{color:orange;}

#content {
padding:8px;
min-height:350px;
clear:both;
border:1px solid #ccc;
}
#load {
position:absolute;
left:0;
top:0;
width:80px;
height:20px;
background-color:red;
color:white;
display:none;
}
</style>

<div id="container">
<?php
  echo $this->Html->div('tabs',$this->Js->link(__('Link Kandie'), '/admin/vclassrooms/newkm/'.$vclassroom_id,
        array('update'      => '#content',
              'evalScripts' => True,
              'before'      => $this->Gags->ajaxBefore('content'),
              'complete'    => $this->Gags->ajaxComplete('content')
              )));

  echo $this->Html->div('tabs', $this->Js->link(__('Kandies linked'), '/admin/vclassrooms/ekm/'.$vclassroom_id,
        array('update'      => '#content',
              'evalScripts' => True,
              'before'      => $this->Gags->ajaxBefore('content'),
              'complete'    => $this->Gags->ajaxComplete('content')
              )));

echo $this->Gags->ajaxDiv('content').$this->Gags->divEnd('content'); 

echo '</div>';
echo $this->Js->writeBuffer();

# ? > EOF