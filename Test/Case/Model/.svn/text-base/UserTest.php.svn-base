<?php
/*
 * Chipotle Software(c) 2012
 * File: APP/Test/Case/Model/UserTest.php
 */

App::uses('User', 'Model');

class UserTestCase extends CakeTestCase {
  
    public $fixtures = array('app.user', 'app.faq', 'app.acquaintance');

  public function setup() 
  {
     parent::setUp();
     $this->User = ClassRegistry::init('User');
  }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('User', 'Acquaintance');
 }

 public function testGetComments() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');

   $result = $this->User->getComments(1);

   $expected = array(
                     array('User' => array( 'id' => 1, 'title' => 'First User' )),
                     array('User' => array( 'id' => 2, 'title' => 'Second User' )),
                     array('User' => array( 'id' => 3, 'title' => 'Third User' ))
                    );

   $this->assertEquals($expected, $result);
  }

  public function testAddVisit($user_id=1) 
  {
    $this->markTestIncomplete('This test has not been implemented yet.');
    $result = $this->User->addVisit($user_id);
  }
}

# ? > EOF
