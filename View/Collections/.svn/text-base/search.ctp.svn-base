<?php
echo $this->Html->image('static/library.jpg', array('alt'=>__('Library'), 'title'=>__('Library')));
echo $this->Html->div('title_portal', __('Books & medias'));

echo '<fieldset>';
echo '<legend>'.__('Search') .'</legend>';
echo $this->Form->create('Collection', array('action'=>'search'));
echo $this->Form->input('Collection.terms', array('size'=>30, 'maxlength'=>30, 'label'=>False));
echo $this->Form->end(__('Search'));
echo '</fieldset>';
echo '<table style="width:100%;font-size:7pt;">';
$th = array ( __('Title'), __('Author'), __('Copies'), __('Category'), __('Clasification'));

if ( $this->Session->read('Auth.User') ):
    #array_push($th, __('Request'));
    $logged = True;
else:
    $logged = False;
endif;

echo $this->Html->tableHeaders($th);
foreach($data as $v):
  $tr = array(
             '<b>'.$v['Collection']['title'].'</b>',
             $v['Collection']['author'],
             $v['Collection']['copies'],
             $this->Html->tag('span', $v['Clasification']['name'], array('style'=>'font-size:7pt;')),
             $v['Collection']['taxonomy'],
             );

/* if ($logged):
     array_push($tr, $this->Html->link(
                        $this->Html->image('static/request_icon.jpg', array('alt'=>__('Request'), 'title'=>__('Request'))), 
                     '/collections/request/'.$v['Collection']['id'], array('escape'=>False)));
 endif; */
    echo $this->Html->tableCells($tr,array('bgcolor'=>'#beebed'));
endforeach;
echo '</table>';

# ? > EOF
