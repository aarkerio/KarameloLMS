<?php

class TestsControllerTest extends ControllerTestCase {

 public $geneRate  = array('methods' => array(
                                       'isAuthorized'
                                      ),
                    'models' => array(
                                       'Test' => array('save')
                                     ),
                    'components' => array(
                                       'RequestHandler' => array('isPut'),
                                       'Email'          => array('send'),
                                       'Session')
                     );

  public function testView() 
  {
   $Tests = $this->generate('Tests', $this->geneRate);
   $data = array('aarkerio','1','1');

   $result = $this->testAction('/tests/view/', array('data' => $data, 'method' => 'get'));
   #debug($result);
  }

  /*
  public function testAdminListing() 
  {
    $result = $this->testAction('/admin/tests/listing');
    $this->assertIsA($this->vars['tests'], 'array');
    $this->assertEquals($this->headers['Location'], '/posts/index');
    debug($result);
    } */

}

# ? > EOF
