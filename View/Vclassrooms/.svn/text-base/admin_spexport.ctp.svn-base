<?php
# GPLv3 2008-2011
# data is made for: http://trac.chipotle-software.com/karamelo/browser/trunk/app/models/vclassroom.php#L276 
# See: http://trac..chipotle-software.com/karamelo/wiki/studentRecord
#die(debug($vclass));
$filename = mb_convert_encoding($vclass['Vclassroom']['name'], "UTF-8", "auto"); 
#die($filename);
$this->Csv->setFilename(str_replace(' ','_',strtolower($filename)));
$this->Csv->addRow(array('Karamelo vClassroom'));
$this->Csv->addRow(array($vclass['Vclassroom']['name'], ' ', $this->Time->nice($this->Time->gmt())));

$line = array('Name', 'Username', 'Email',  __('Activity'), __('Points'));
$this->Csv->addRow($line); 

foreach($data as $u):  # each user
  #debug($u);
  $this->Csv->addRow(array($u['User']['name'], $u['User']['username'], $u['User']['email']));
  $points = (int) 0;
  # 1) Test
  if ( count($u['tests']) > 0):
    $this->Csv->addRow(array('', '', '', __('Tests')));
    foreach($u['tests'] as $t):
        if ($t['Test']['points'] === NULL):
            $this->Csv->addRow(array('', '', '',  $t['Test']['title'], 'Test not answered yet'));
        else:
            $this->Csv->addRow(array('', '', '',  $t['Test']['title'], $t['Test']['points']));
            $points += (int) $t['Test']['points'];
        endif; 
    endforeach;
  endif;
  
  # 2) Webquest
  if ( count($u['webquests']) > 0):
    $this->Csv->addRow(array('', '', '', __('Webquests')));
    foreach($u['webquests'] as $w):
        if ($w['ResultWebquest']['points'] === NULL):
            $this->Csv->addRow(array('', '', '',  $w['Webquest']['title'], 'Webquest not answered yet'));
        else:
            $this->Csv->addRow(array('', '', '',  $w['Webquest']['title'], $w['ResultWebquest']['points']));
            $points += (int) $w['ResultWebquest']['points'];
        endif; 
    endforeach;
  endif;
  
  # 3) Treasure
  if ( count($u['treasures']) > 0):
    $this->Csv->addRow(array('', '', '', __('Savenger hunts')));
    foreach($u['treasures'] as $tr):
        if ($tr['ResultTreasure']['points'] === NULL):
            $this->Csv->addRow(array('', '', '',  $tr['Treasure']['title'], 'Treasure not answered yet'));
        else:
            $this->Csv->addRow(array('', '', '',  $tr['Treasure']['title'], $tr['ResultTreasure']['points']));
            $points += (int)  $tr['ResultTreasure']['points'];
        endif; 
    endforeach;
  endif;
  
  # 4) Replies on forums
  if ( count($u['replies']) > 0):
      foreach ($u['replies'] as $re):  
            $this->Csv->addRow(array('', '', __('Participations in forums')));
            $this->Csv->addRow(array('', '', '',  __('Points'), $re['Reply']['points']));
            $points += (int) $re['Reply']['points'];
      endforeach;
  endif;
  
  # 5) Participation 
  if ( count($u['participations']) > 0):
    $this->Csv->addRow(array('', '', '', __('Participations')));
    foreach($u['participations'] as $pr):
            $this->Csv->addRow(array('', '', '',  $pr['Participation']['title'], $pr['Participation']['points']));
            $points += (int) $pr['Participation']['points'];
    endforeach;
  endif;
  
  # 6) Reports
  if ( count($u['reports']) > 0):
      $this->Csv->addRow(array('', '', __('Reportes')));
      foreach($u['reports'] as $rp):
            $this->Csv->addRow(array('', '', '',  $rp['Report']['description'], $rp['Report']['points']));
            $points += (int) $rp['Report']['points'];
      endforeach;
  endif;

  # 7) Gap fillings
  if ( count($u['gaps']) > 0):
    $this->Csv->addRow(array('', '', '', __('Gaps filling')));
    foreach($u['gaps'] as $ga):
        if ($ga['Gap']['points'] === NULL):
            $this->Csv->addRow(array('', '', '',  $ga['Gap']['title'], __('Gap filling not answered yet')));
        else:
            $this->Csv->addRow(array('', '', '',  $ga['Gap']['title'], $ga['Gap']['points']));
        endif; 
    endforeach;
  endif;
 
  # 8) Wikis
  if ( count($u['wikis']) > 0):
    $this->Csv->addRow(array('', '', '', __('WikiPages')));
    foreach($u['wikis'] as $wk):
      $this->Csv->addRow(array('', '', '',  __('Wiki Page') . ': '.$wk['Wiki']['title'] ));
        if ( count($wk['Revision']) > 0):
            foreach ($wk['Revision'] as $Rev):
                $this->Csv->addRow(array('', '', '', __('Points'), $Rev['points']));
                $points += (int)  $Rev['points'];
            endforeach;
        else:
            $this->Csv->addRow(array('', '', '',  __('Student has no participated in this WikiPage')));
        endif; 
    endforeach;
  endif;
  
  # 9) SCORMS (Not yet done)
 
  $this->Csv->addRow(array('', '', '',  __('Total earned by'). ' ' . $u['User']['name'], $points));
endforeach;

echo $this->Csv->render();

# ? > EOF
