<?php
$this->set('title_for_layout', $data['Wiki']['title']);
?>
<style type="text/css">
ul#wikimenu { width: 100%; height: 43px; background: #FFF url("/img/static/menu-bg.gif") top left repeat-x; font-size: 0.8em; font-family: "Lucida Grande", Verdana, sans-serif; font-weight: bold; list-style-type: none; margin: 0; padding: 0; }
ul#wikimenu li { display: block; float: left; margin: 0 0 0 5px; }
ul#wikimenu li a { height: 43px; color: #777; text-decoration: none; display: block; float: left; line-height: 200%; padding: 8px 15px 0; }
ul#wikimenu li a:hover { color: #333; background: #FFF url("/img/static/current-bg.gif") top left repeat-x;}
ul#wikimenu li a.current{ color: #FFF; background: #FFF url("/img/static/current-bg.gif") top left repeat-x; padding: 5px 15px 0; }
</style>
<?php
 if ( $belongs === True ):
     echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$data['Wiki']['vclassroom_id']));
     $list = array(    
		$this->Html->link(__('Edit'), '/wikis/edit/'.$blogger['User']['username'].'/'.$data['Wiki']['slug']),  
		$this->Html->link(__('History'), '/wikis/history/'.$blogger['User']['username'].'/'.$data['Wiki']['slug']) 
        #$this->Html->link('Discussion', '/wikis/discussion/'.$data['Wiki']['slug'])
     ); 
     echo $this->Html->nestedList($list, array('id'=>'wikimenu'));
 endif;

 echo '<h1>'.$data['Wiki']['title'].'</h1>';
 echo $this->Html->para(Null,  'Revision: '.$data['Revision'][0]['revision']);
 echo $this->Html->div(Null, $data['Revision'][0]['content']);
 echo $this->Html->div(Null, __('Last edition'). ': '.$data['Revision'][0]['modified']);

# ? > EOF
