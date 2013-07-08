<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: app/Test/Case/Model/SubjectTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Subject', 'Model');

class SubjectTestCase extends CakeTestCase {
 
 public $fixtures = array('app.quote', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Subject = ClassRegistry::init('Subject');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Subject');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeSubjects() 
 {
   $result  = $this->Subject->threeSubjects();
   $expected = array(
                     array('Subject' => array(
                                      'id'      => 1,
                                      'quote'   => 'Subject Subject Subject ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Subject' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Subject' => array(
                                      'id'      => 3,
                                      'quote'   => 'Subject 333 Subject 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Subject');
 }
}

# ? > EOF
