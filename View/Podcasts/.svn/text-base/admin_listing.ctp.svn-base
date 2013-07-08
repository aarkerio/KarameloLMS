<?php
$this->set('title_for_layout',  __('Quotes'));
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $this->Html->image('ipod.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Podcasts'), 'title'=>__('Podcasts'))).' '.$this->Session->read('Auth.User.username')."'s Podcasts");

 echo $this->Html->para(Null, $this->Html->link($this->Html->image('actions/new.png', 
                                                                   array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/podcasts/edit', 
                                                                   array('escape'=>False)));
?>
<table class="tbadmin">
<?php
#die(debug($data));
if ($data ):
    $th = array(__('Edit'), __('Title'), __('Description'), __('Created'), __('Status'), __('Hear'),__('Delete'));
    echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;'));
endif;
foreach ($data as $val):
     if ($val['Podcast']['status'] == 1):
        $img   = 'static/status_1_icon.png';
        $st    = __('Published');
     else:
        $img   = 'static/status_0_icon.png';
        $st    = __('Draft');
        $order = $st;
    endif;
    $st = $this->Gags->setStatus($val['Podcast']['status']); # current status:  published/draft
    $tr = array (
        $this->Gags->sendEdit($val['Podcast']['id'], 'podcasts'),
        $val['Podcast']['title'],
        $val['Podcast']['description'],
        $val['Podcast']['created'],
        $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                    '/admin/podcasts/change/'.$val['Podcast']['id'].'/'.$val['Podcast']['status'], array('escape'=>False)),
        $this->Html->link($val['Podcast']['filename'], '/files/podcasts/'.$val['Podcast']['filename']),
        $this->Gags->confirmDel($val['Podcast']['id'], 'podcasts')
    );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
?>
</table>
<?php 
#echo $pagination;   until next Karamelo release
# ? > EOF


