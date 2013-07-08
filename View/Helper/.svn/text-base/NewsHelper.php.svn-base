<?php 
/*
 * News helper By Chipotle Software(c)
 * comments, bug reports are welcome mmontoya AT gmail DOT com
 * @author aarkerio
 * @version 0.2 
 * @license GPLv3
 */
class NewsHelper extends Helper {
  
   public  $initialized = false;
   public  $helpers = array('Html', 'Ajax');

// ================Social buttons functions ==========================

public function socialNets($id, $titulo) 
{

 $SN ='<div class ="socialnet"><!-- Social networks-->
      <span style="font-size:7pt;color:black;">
    
    <a href="http://technorati.com/cosmos/search.html?url=http://'.$_SERVER['HTTP_HOST'].' /news/view/'.$id.'">
    <img alt="Technorati" src="/img/socialnet/technorati.png" title="Technorati"/></a> |
    
    <a href="http://del.icio.us/post?url=http://'.$_SERVER['HTTP_HOST'].'/news/single/'.$id.'&amp;title='.$titulo.'" title="Bookmark this post on del.icio.us.">
     <img src="/img/socialnet/delicious.png" alt="add to delicious" title="add to delicious" /></a> | 
     
    <a href="http://www.stumbleupon.com/submit?url=http://'.$_SERVER['HTTP_HOST'].'/news/single/'.$id.'&amp;title='.$titulo.'" id="akst_stumbleupon"><img src="/img/socialnet/icon_stumbleupon.gif" alt="add to stumbleupon" title="add to stumbleupon" /></a></span>
 <!-- Social networks--></div>';
    
    return $SN;
}

public function newVote($id, $votes) 
{
    
    $V = '<div id="ee3rt'.$id.'"><div class="votes_counter">';
    $V .= '<span class="votes" id="nodes_votes_'.$id.'">'.$votes.'</span><br />';
    $V .= '<span class="negrita">votos</span>';
    $V .= '<div id="loading'.$id.'" style="display:none"><img src="/img/socialnet/vote_loader.gif" /></div>';
    $V .= '<div id="bottoms_'.$id.'">';
      if ( isset($_SESSION['votes']) && in_array($id, $_SESSION['votes']) )  // only one vote per session!!
      {
        $V .= $this->Html->image('socialnet/boton_positivo_off.gif', array("alt"=>"Voted", "title"=>"Voted", "id"=>"img_vote_up_".$id));
        $V .= $this->Html->image('socialnet/boton_negativo_off.gif', array("alt"=>"Voted", "title"=>"Voted", "id"=>"img_vote_up_".$id));
      } 
      else 
      {   
       $V .= $this->Ajax->link($this->Html->image('socialnet/boton_positivo.gif'), 
                    '/news/addvote/'.$id.'/more/'.$votes,
                    array("update" => "ee3rt".$id."", "loading"=>"Element.show('loading".$id."');", "complete"=>"Element.hide('loading".$id."');"), 
                    null, false);
      $V .= $this->Ajax->link($this->Html->image('socialnet/boton_negativo.gif'), 
                    '/news/addvote/'.$id.'/less/'.$votes, 
                    array("update" => "ee3rt".$id."", "loading"=>"Element.show('loading".$id."');", "complete"=>"Element.hide('loading".$id."');"), 
                    null, false);
      }
        
      $V .= '</div></div></div>';
       
      return $V;
  }
}
?>