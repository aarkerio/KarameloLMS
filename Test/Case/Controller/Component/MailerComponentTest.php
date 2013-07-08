<?php
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('PagematronComponent', 'Controller/Component');

// A fake controller to test against
class TestPagematronController extends Controller {
    public $paginate = null;
}

class PagematronComponentTest extends CakeTestCase {
    public $PagematronComponent = null;
    public $Controller = null;

    public function setUp() {
        parent::setUp();
        // Setup our component and fake test controller
        $Collection = new ComponentCollection();
        $this->PagematronComponent = new PagematronComponent($Collection);
        $CakeRequest = new CakeRequest();
        $CakeResponse = new CakeResponse();
        $this->Controller = new TestPagematronController($CakeRequest, $CakeResponse);
        $this->PagematronComponent->startup($this->Controller);
    }

    public function testAdjust() {
        // Test our adjust method with different parameter settings
        $this->PagematronComponent->adjust();
        $this->assertEquals(20, $this->Controller->paginate['limit']);

        $this->PagematronComponent->adjust('medium');
        $this->assertEquals(50, $this->Controller->paginate['limit']);

        $this->PagematronComponent->adjust('long');
        $this->assertEquals(100, $this->Controller->paginate['limit']);
    }

  public function tearDown() 
  {
        parent::tearDown();
        // Clean up after we're done
        unset($this->PagematronComponent);
        unset($this->Controller);
 }
}

# ? > EOF
