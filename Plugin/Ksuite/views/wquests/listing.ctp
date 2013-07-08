<fb:dashboard>
      <fb:action href="index">Home</fb:action>
      <fb:action href="listing">My Webquests</fb:action>
      <fb:action href="help">Quick Help</fb:action>
      <fb:create-button href="add">Add new Webquest</fb:create-button>
</fb:dashboard>
     <fb:grouplink gid="2541896821" />
<style type="text/css">
    .container { padding:10px; }
    .graydiv { padding:4px; margin:3px;border:1px dotted gray;font-size:14pt;}
</style>
<h1>Your Webquests</h1>
<?php
if ( !$data ):
    echo $html->div(Null, 'You do not have any Webquest yet. <a href="add">Create one</a>');
endif;

foreach($data as $v): 
    echo $html->div('graydiv');
    echo '<a href="view/'.$v['Wquest']['id'].'">'.$v['Wquest']['title'] .'</a>';
    ?>
    <fb:fbml>
    <fb:editor action="edit">
    <input type="hidden" id="WquestId" name="data[Wquest][id]" value="<?php echo $v['Wquest']['id']; ?>" />
    <fb:editor-buttonset>
      <fb:editor-button value="Edit" />
    </fb:editor-buttonset>
    </fb:editor>

    <fb:editor action="delete">
    <input type="hidden" id="WquestId" name="data[Wquest][id]" value="<?php echo $v['Wquest']['id']; ?>" />
    <fb:editor-buttonset>
      <fb:editor-button value="Delete" />
    </fb:editor-buttonset>
    </fb:editor>

    </fb:fbml>
    </div>
   <?php
endforeach;
?>