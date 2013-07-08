<?php
$username = (string) $this->Session->read('Auth.User.username');

$this->set('title_for_layout', 'Knets');

#die(debug($data)));
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > '); 
echo $this->Html->div('title_section', 'Knets');
?>
<table class="tbadmin">
<?php
    $th = array(__('Type'), __('Title'), __('Author'),  __('Import'),  __('Export'));
echo $this->Html->tableHeaders($th);
foreach ( $kandies as $k ):
    foreach ($data[$k] as $v):
        if (  $v['User']['username'] == $username ):
            $owner = $v['User']['username'].'own!';
        else:
            $owner = $v['User']['username'];
        endif;
        $tr = array(
            $k,
            $v[$k]['title'],
            $owner,
            $this->Html->link(__('Import'), '/admin/knets/import/'.$k.'/'.$v[$k]['id'], array('escape'=>False)),
            $this->Html->link(__('Export'), '/admin/knets/export/'.$k.'/'.$v[$k]['id'], array('escape'=>False))
            );
        echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
    endforeach;
endforeach;

echo '</table>';

/*
$t  = $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(null,$this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;')); */

# ? > EOF