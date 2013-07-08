<?php
/*
 * Chipotle Software(c) 2012
 * File: app/Test/Case/Model/WebquestTest.php
 */

App::uses('Webquest', 'Model');

class WebquestTestCase extends CakeTestCase {
  
  public $fixtures = array('app.entry','app.comment','app.user','app.profile','app.group','app.userVclassroom','app.faq', 'app.acquaintance', 'app.webquest');

  public function setup() 
  {
     parent::setUp();
     $this->Webquest = ClassRegistry::init('Webquest');
  }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Webquest', 'Comment', 'User', 'Acquaintance');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testGetComments() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');

   $result = $this->Webquest->getComments(1);
   debug($result);
   $expected = array(
                     array('Webquest' => array( 'id' => 1, 'title' => 'First Webquest' )),
                     array('Webquest' => array( 'id' => 2, 'title' => 'Second Webquest' )),
                     array('Webquest' => array( 'id' => 3, 'title' => 'Third Webquest' ))
                    );

   #$this->assertEquals($expected, $result);
   $this->assertInternalType('array',$result);
   $this->assertClassHasAttribute('validate', 'Webquest');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
  public function testAddVisit($user_id=1) 
  {
    $this->markTestIncomplete('This test has not been implemented yet.');
    $result = $this->Webquest->addVisit($user_id);
  }
}

# ? > EOF
