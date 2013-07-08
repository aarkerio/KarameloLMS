<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: app/Test/Case/Model/AnnotationTest.php
 */


App::uses('Controller', 'Controller');
App::uses('Annotation', 'Model');

class AnnotationTest extends CakeTestCase {
 
 public $fixtures = array('app.annotation', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
   parent::setUp();
   $this->Annotation = ClassRegistry::init('Annotation');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Annotation');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeAnnotations() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');

   $result  = $this->Annotation->threeAnnotations();
   $expected = array(
                     array('Annotation' => array(
                                      'id'      => 1,
                                      'quote'   => 'Annotation Annotation Annotation ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Annotation' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Annotation' => array(
                                      'id'      => 3,
                                      'quote'   => 'Annotation 333 Annotation 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Annotation');
 }
}

# ? > EOF
