<?php
/**
 *   Chipotle Software(c)  2012-2014 GPLv3
 *   File: APP/Test/Case/Controller/PermanentClassControllerTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Model', 'Model');
App::uses('View', 'View');

class PermanentClassesControllerTest extends ControllerTestCase {

/**
 *  Description
 *  @access public
 *  @return void
 *  @param integer $user_id
 */
  public function testPushAndPop()
  {
    $stack = array();
    $this->assertEquals(0, count($stack));
 
    array_push($stack, 'foo');
    $this->assertEquals('foo', $stack[count($stack)-1]);
    $this->assertEquals(1, count($stack));
 
    $this->assertEquals('foo', array_pop($stack));
    $this->assertEquals(0, count($stack));
  }

  /**
   *  Description
   *  @access public
   *  @return void
   *  @param integer $user_id
   */
  public function testListing() 
  {
    $result = $this->testAction('/admin/permanent_classes/listing');
    debug($result);
  }

 }

# ? > EOF

