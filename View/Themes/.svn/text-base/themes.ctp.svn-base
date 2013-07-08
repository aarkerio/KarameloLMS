<?php
foreach ($data as $val) 
{
         $div = 'div' . $val['Themeblog']['id'];
         echo $ajax->div($div);
             
             echo $this->Js->link("Delete", "/admin/themeblogs/delete/{$val['Themeblog']['id']}",
                     array("update" => "container", "loading"=>"Element.show('loading');", 
                             "complete"=>"$this->Js->get('#loading')->effect('fadeOut', array('buffer' => False))('loading');"), "Are you sure you want to delete this theme and entries associated?")."\n";
             
             echo $val['Themeblog']['title'] ." \n";
             
             echo $this->Js->link("Edit", "/admin/themeblogs/edit/{$val['Themeblog']['id']}",
                     array("update" => $div, "loading"=>"Element.show('loading');", "complete"=>"$this->Js->get('#loading')->effect('fadeOut', array('buffer' => False))('loading');")) ."<br />\n";
                  
        echo $ajax->divEnd($div);
}
?>
