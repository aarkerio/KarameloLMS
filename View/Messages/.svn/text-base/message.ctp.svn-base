<?php 
$this->set('title_for_layout', __('Contact'));

echo $this->Html->script(array('ckeditor/ckeditor','jquery.form', 'jquery.CKEditor', 'ckeditor/adapters/jquery'));

if ( $this->Session->check('Auth.User') ): 
      $username =  $this->Session->read('Auth.User.username');
      $anonym   = 0;  
      $url      = '/messages/deliver/';
else:
      $username = 'Anonymous';
      $anonym   = 1;
      $url      = '/messages/fromoutside/';
endif;

if ($blogger['User']['id'] ==  $this->Session->read('Auth.User.id')):
     echo $this->Html->para(null, '('.__('Will you send a message to yourself').'?)');;
endif;

echo $this->Gags->imgLoad('loading');

echo $this->Gags->ajaxDiv('updater');
  echo $this->Form->create();
  echo $this->Form->hidden('Message.user_id', array('value'=>$blogger['User']['id']));
  echo $this->Form->hidden('Message.ajax', array('value'=>1));
?>
<fieldset>
  <legend><?php echo __('Message to teacher from') .' '.$username; ?>:</legend>
  <?php 
   echo $this->Form->input('Message.title', array('size' => 30, 'maxlength' => 50, 'label'=>__('Title'),'between'=>':<br />')); 

   if ( !$this->Session->check('Auth.User') ):
       echo $this->Form->input('Message.email', array('size' => 20, 'maxlength' => 80, 'label'=>__('Email'),'between'=>':<br />'));
   endif;
   echo $this->Form->textarea('Message.body', array('cols'=>30, 'rows'=>35));
   echo $this->Html->scriptBlock("$('textarea#MessageBody').ckeditor({ toolbar:'Basic', width:400, height:200 });");
   echo $this->Js->submit(__('Send'), array(
                                                  'url'         => $url, 
                                                  'update'      => '#updater',
                                                  'evalScripts' => True,
                                                  'before'      => $this->Gags->ajaxBefore('updater'),
                                                  'complete'    => $this->Gags->ajaxComplete('updater'))); 
  ?>
</fieldset>
</form>
<?php  
  echo $this->Gags->divEnd('updater'); 
# ? > EOF
