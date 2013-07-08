<?php
/*
 * Chipotle Software(c) 2012
 * File: app/Test/Case/Model/EntryTest.php
 */

App::uses('Entry', 'Model');

class EntryTestCase extends CakeTestCase {
  
  public $fixtures = array('app.entry','app.comment','app.user','app.profile','app.group','app.userVclassroom','app.faq', 'app.acquaintance', 'app.lesson', 'app.confirm');

  public function setup() 
  {
     parent::setUp();
     $this->Entry = ClassRegistry::init('Entry');
  }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Entry', 'Comment', 'User', 'Acquaintance');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testGetComments() 
 {
  #$this->markTestIncomplete('This test has not been implemented yet.');

   $result = $this->Entry->getComments(1);
   debug($result);
   $expected = array(
                     array('Entry' => array( 'id' => 1, 'title' => 'First Entry' )),
                     array('Entry' => array( 'id' => 2, 'title' => 'Second Entry' )),
                     array('Entry' => array( 'id' => 3, 'title' => 'Third Entry' ))
                    );

   #$this->assertEquals($expected, $result);
   $this->assertInternalType('array',$result);
   $this->assertClassHasAttribute('validate', 'Entry');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
  public function testAddVisit($user_id=1) 
  {
    $this->markTestIncomplete('This test has not been implemented yet.');
    $result = $this->Entry->addVisit($user_id);
  }
}

# ? > EOF
