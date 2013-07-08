<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/VclassroomTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Vclassroom', 'Model');

class VclassroomTestCase extends CakeTestCase {
 
 public $fixtures = array('app.faq', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Vclassroom = ClassRegistry::init('Vclassroom');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Vclassroom');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeVclassrooms() 
 {
   $this->markTestIncomplete('This is incomplete, I know!!');

   $result  = $this->Vclassroom->threeVclassrooms();
   $expected = array(
                     array('Vclassroom' => array(
                                      'id'      => 1,
                                      'quote'   => 'Vclassroom Vclassroom Vclassroom ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Vclassroom' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Vclassroom' => array(
                                      'id'      => 3,
                                      'quote'   => 'Vclassroom 333 Vclassroom 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Vclassroom');
 }
}

# ? > EOF
