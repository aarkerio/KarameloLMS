<?php
/* 
*  CK Editor Helper
*  2009-2012 ChS GPLv3
*  Chipotle Software (c)
*/

/* /app/View/Helper/LinkHelper.php */
App::uses('AppHelper', 'View/Helper');

class CkHelper extends AppHelper {
 
/**
 * Load regular CkEditor
 * @access public
 * @return string
 */
 public function load($id, $toolbar = 'Karamelo', $lang='en', $width = 800, $height = 450)
 { 
  $did = '';
        
  foreach (explode('/', $id) as $v):
      $did .= ucfirst($v);
  endforeach;

return <<<CK_CODE
<script type="text/javascript">
 
 function borrar(WebTextArea)
   {
      // alert(typeof CKEDITOR.instances[WebTextArea]);
      if ( typeof CKEDITOR.instances[WebTextArea] !== 'undefined')
      {
         //CKEDITOR.instances[WebTextArea].destroy();
         CKEDITOR.remove(CKEDITOR.instances[WebTextArea]);
         //alert("editor  successfully destroyed");
      }
    }
    borrar('$id')
    CKEDITOR.replace('$id',
                      {
                      toolbar : '$toolbar',
                      width   : $width,
                      height  : $height,
                      language: '$lang',
                      filebrowserImageBrowseUrl: '/admin/images/listing/set/ck'
                              });

</script>
CK_CODE;
 
 }
 
/**
 * Load regular CkEditor
 * @access public
 * @param integer
 * @param integer
 * @param integer
 * @param integer
 * @param integer $height
 * @return string
 */
 public function ckAjaxPlugin($id, $toolbar = 'Karamelo', $lang='en', $width = 800, $height = 450)
 {
 return <<<CK_CODE
<script type="text/javascript">
     // $("#$id").ckeditor();
     $("#$id").ckeditor( function() 
                          { 
                          /* callback code */
                          }, 
                          { skin:'kama', 
                            toolbar:'$toolbar', 
                            width: $width,
                            height: $height,
                            language: '$lang',
                            filebrowserImageBrowseUrl: '/admin/images/listing/set/ck'} );
function loadEditor(id)
{
    var instance = CKEDITOR.instances[id];
    if (instance)
    {
      //alert(id);        
      CKEDITOR.remove(instance);
      //instance.destroy();
      //CKEDITOR.instances['EntryBody'].destroy();
    }
    CKEDITOR.replace(id);
}
</script>
CK_CODE;
 }

/**
 *  Translate PHP ajax
 *  @access public
 */
 public function phpCkAjax() 
 {
return <<<CK_CODE
<script type="text/javascript">
  function ckAjax(WebTextArea)
  {
    // alert(WebTextArea);
    //alert(document.getElementById(WebTextArea).value);
    //var data = $(WebTextArea).val();
    //alert(data);
    //editor = $(WebTextArea).ckeditorGet(); 
    // alert(editor.checkDirty());
    //document.getElementById(WebTextArea).value = editor;
    CKEDITOR.instances[WebTextArea].destroy();
    return;
  }
</script>
CK_CODE;
}
 public function OLDckAjax() 
 {
return <<<CK_CODE
<script type="text/javascript">
 function MyCKClass()
 {
    this.send =
    this.UpdateEditorFormValue = function()
    {
      // CKEDITOR.instances.myTextArea.getData()
      for ( i = 0; i < parent.frames.length; ++i )
      {
           if ( parent.frames[i].CKEDITOR ) 
           {
               parent.frames[i].CKEDITOR.UpdateLinkedField();
           }
      }
    }
  }
  var MyCKObject = new MyCKClass();
</script>
CK_CODE;
}

}

# ? > EOF
