<?php 
$this->set('title_for_layout','FAQs');
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb('FAQs', '/admin/catfaqs/listing'); 
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('faq.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('FAQs'), 'title'=>__('FAQs'))).' '.__('Categories'));

echo $this->Gags->imgLoad('loading');

echo  $this->Html->para(Null, $this->Js->link($this->Html->image('actions/new.png',array('alt'=>__('Add new'),'title'=>__('Add new'))), '/admin/catfaqs/start', array('update'   => '#updater',
                      'before'   => $this->Gags->ajaxBefore('updater'), 
                      'complete' => $this->Gags->ajaxComplete('updater'),
                      'escape'   => False)));

echo $this->Gags->ajaxDiv('updater') . $this->Gags->divEnd('updater');

foreach ($data as $val):
  if ($val['Catfaq']['status'] == 1):
        $img   = 'static/status_1_icon.png';
        $st    = __('Published');
  else:
       $img   = 'static/status_0_icon.png';
       $st    = __('Draft');
  endif;
  if ($val['Catfaq']['public'] == 1):
         $img1   = 'static/icon_public.png';
         $d1    = __('Public');
  else:
         $img1   = 'static/icon_nonpublic.png';
         $d1   = __('Non public');
  endif;

  echo $this->Html->div('grayblock');
     echo $this->Html->div(null, $this->Html->link($val['Catfaq']['title'],'/admin/faqs/listing/'.$val['Catfaq']['id'], 
                      array('style'=>'font-size:14pt;font-weight:bold;')), array('style'=>'width:500px;float:left;'));
    echo $this->Html->div('titwrapper');
       echo $this->Html->div('dvtop', $this->Gags->sendEdit($val['Catfaq']['id'], 'catfaqs'));
       echo $this->Html->div('dvtop', $this->Gags->confirmDel($val['Catfaq']['id'], 'catfaqs'));
   echo '</div>';
  
   echo $this->Html->para(null,  $val['Catfaq']['description'], array('style'=>'font-weight:bold;'));
   echo $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                    '/admin/catfaqs/change/'.$val['Catfaq']['status'].'/'.$val['Catfaq']['id'],array('escape'=>False)) .'&nbsp;&nbsp;';

   echo $this->Html->link($this->Html->image($img1, array('width'=>'14px', 'alt'=>$d1, 'title'=>$d1)),
                    '/admin/catfaqs/public/'.$val['Catfaq']['id'].'/'.$val['Catfaq']['public'], array('escape'=>False));
 echo '</div>';
endforeach;

# ? > EOF
