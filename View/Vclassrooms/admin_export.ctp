<?php
#die(debug($data));
$counter = (int) 0;
if ( !$data):
    $this->Fpdf->newPage();
    $this->Fpdf->setData(__('No students in this classroom'));
endif;

foreach ($data as $u):  # eacher user in vClassroom
  $counter++;
  $this->Fpdf->newPage();

  $this->Fpdf->setData(__('Group').': ' . $group['Vclassroom']['name'] . '. Created '.$group['Vclassroom']['created']);
  $this->Fpdf->setData(__('Student') . ': '.$u['User']['name'] . ' '.$u['User']['email']);
  #Quizz tests
  if ( count($u['tests']) > 0 ):  
      foreach ($u['tests'] as $te):
           if ( $te['Test']['points'] ):
               $this->Fpdf->setData($te['Test']['title'] . ', '.__('Points').' '.$te['Test']['points']);
           else:
               $this->Fpdf->setData($te['Test']['title'] . ', '.__('Not answered this test yet'));
           endif;
      endforeach;
  else:
    $this->Fpdf->setData(__('Not test answered yet'));
  endif;
  # Scavenger hunts
  if ( count($u['treasures']) > 0 ):
    foreach ($u['treasures'] as $t):
      $this->Fpdf->setData($t['Treasure']['title'] . ', '.__('Points').' '.$t['ResultTreasure']['points']);
    endforeach;
  else:
    $this->Fpdf->setData(__('Not scavenger answerd yet'));
  endif;

  if ( count($u['participations']) > 0 ): # forums
    foreach ($u['participations'] as $Par):
            foreach ($Par as $p):
                $this->Fpdf->setData($p['title'] . ', '.__('Points') .' '. $p['points']);
            endforeach;
    endforeach;
  else:
    $this->Fpdf->setData(__('Not participations yet'));
  endif;

  if ( count($u['webquests']) > 0 ):
    foreach ($u['webquests'] as $w):
                       $this->Fpdf->setData($w['Webquest']['title'] . ', Points ' . $w['ResultWebquest']['points']);
    endforeach;
  else:
    $this->Fpdf->setData(__('Not webquest answered yet'));
  endif;
 endforeach;    
 
 $vname =  str_replace(' ','_', 'Karamelo_'.$group['Vclassroom']['name'].'_'.date('l jS \of F Y'));
 echo $this->Fpdf->fpdfOutput($vname.'.pdf'); 

# ? > EOF
