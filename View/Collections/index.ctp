<?php
echo $this->Html->div('title_portal', __('Books & medias'));
$this->set('title_for_layout', __('Books & medias'));

echo $this->Html->para(Null, $this->Html->image('static/library.jpg', array('alt'=>__('Library'), 'title'=>__('Library'))));
if ( count($data) > 0 ):
    echo '<fieldset>';
    echo '<legend>'.__('Search') .'</legend>';
    echo $this->Form->create('Collection', array('action'=>'search'));
    echo $this->Form->input('Collection.terms', array('size'=>30, 'maxlength'=>30,  'label'=>False));
    echo '</fieldset>';
    echo $this->Form->end(__('Search'));

    # Show collection
    echo '<table style="width:100%;font-size:7pt;">';
    $th = array(
                $this->Paginator->sort('title', __('Title')), 
                $this->Paginator->sort('author',__('Author')), 
                $this->Paginator->sort('Type.type',__('Type')), 
                $this->Paginator->sort('copies',__('Copies')),
                $this->Paginator->sort('category',__('Category')), 
                $this->Paginator->sort('taxonomy',__('Clasification'))
               );
    echo $this->Html->tableHeaders($th);
    foreach($data as $v):
        $tr = array(
                    '<b>'.$v['Collection']['title'].'</b>',
                    $v['Collection']['author'], 
                    $v['Type']['type'], 
                    $v['Collection']['copies'], 
                    $this->Html->tag('span', $v['Clasification']['name'], array('style'=>'font-size:7pt;')),
                    $this->Html->tag('span', $v['Collection']['taxonomy'], array('style'=>'font-size:7pt;'))
               );
        echo $this->Html->tableCells($tr, array('bgcolor'=>'#beebed'));
    endforeach;
    echo '</table>';

    $t  = $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
    $t .= $this->Html->div(Null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
    $t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
else:
    echo $this->Html->para(Null, __('Sorry, the College Library is empty'));
endif;

# ? > EOF