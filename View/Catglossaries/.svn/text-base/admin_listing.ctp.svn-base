
<?php 
$this->set('title_for_layout', __('Glossaries'));
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $this->Html->image('Glossary.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Glossaries'), 'title'=>__('Glossaries'))).' '.__('Categories') .' '. __('Glossaries'));

echo $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/catglossaries/edit',array('escape'=>False));

foreach ($data as $val):
  if ($val['Catglossary']['status'] == 1):
        $img   = 'static/status_1_icon.png';
        $st    = __('Published');
  else:
       $img   = 'static/status_0_icon.png';
       $st    = __('Draft');
  endif;
  if ($val['Catglossary']['public'] == 1):
         $img1   = 'static/icon_public.png';
         $d1    = __('Public');
  else:
         $img1   = 'static/icon_nonpublic.png';
         $d1   = __('Non public');
  endif;

  echo $this->Html->div('grayblock');
    echo $this->Html->div(Null, $this->Html->link($val['Catglossary']['title'],'/admin/catglossaries/items/'.$val['Catglossary']['id'], 
                      array('style'=>'font-size:14pt;font-weight:bold;',  'title'=>__('Click to add glossary in this category'))), array('style'=>'width:500px;float:left;'));
    echo $this->Html->div('titwrapper');
       echo $this->Html->div('dvtop', $this->Gags->sendEdit($val['Catglossary']['id'], 'catglossaries'));
       echo $this->Html->div('dvtop', $this->Gags->confirmDel($val['Catglossary']['id'], 'catglossaries'));
   echo '</div>';

   echo $val['Catglossary']['description']  . '<br />';
   echo $this->Html->para(Null,  $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                           '/admin/catglossaries/change/'.$val['Catglossary']['status'].'/'.$val['Catglossary']['id'], 
                                       array('style'=>'font-size:7pt', 'escape'=>False))
                  );

   echo $this->Html->link($this->Html->image($img1, array('width'=>'14px', 'alt'=>$d1, 'title'=>$d1)),
                    '/admin/catglossaries/public/'.$val['Catglossary']['id'].'/'.$val['Catglossary']['public'], array('escape'=>False));
  echo '</div>';   
endforeach;

# ? > EOF
