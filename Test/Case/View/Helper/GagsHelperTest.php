<?php

App::uses('GagsHelper', 'View/Helper');
App::uses('View', 'View');

class GagsHelperTest extends CakeTestCase {

 private $gags = null;

 public function setUp() 
 {
  parent::setUp();
  $view = new View('Entry');
  $this->Gags = new GagsHelper($view);
 }

 public function testAjaxComplete() 
 {
   $result = $this->Gags->ajaxComplete($div='list', $img='loading', $effectOut='fadeOut',  $effectIn='fadeIn');
   $this->assertContains('fadeOut', $result);
   $this->assertContains('fadeIn', $result);

   $result = $this->Gags->ajaxComplete(Null, 'perro');
   $this->assertContains('perro', $result);
 }

 public function testSortKey() 
 {
   $result = $this->Gags->sortKey();
   $this->assertContains('fadeOut', $result);
   $this->assertContains('fadeIn', $result);

   $result = $this->Gags->sortKey(Null, 'perro');
   $this->assertContains('perro', $result);
 }

 public function testConfirmDel()
 {
  $result = $this->Gags->confirmDel($id, $model);
  $this->assertContains('perro', $result); 
 } 

 public function testClean()
 {
  $result = $this->Gags->clean($input);
  $this->assertContains('perro', $result);
 }

 public function testMouseOverOut($div=null, $text=null)
 {
   $result = $this->Gags->mouseOverOut($div=null, $text=null);
   $this->assertContains('perro', $result);
 }
}

# ? > EOF
