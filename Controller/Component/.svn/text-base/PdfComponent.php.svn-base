<?php
/**
 *  @author
 *  @license GNU Affero General Public License V3
 *
 */
class PdfComponent extends Component {

/**
 * Component Constructor
 * @return void
 */ 
 public function __construct(ComponentCollection $collection, $settings = array()) 
 {
     $this->Controller = $collection->getController();
     parent::__construct($collection, $settings);
 }

/**
 *  The initialize method is called before the controller’s beforeFilter method.
 *  @access public
*   @param Controller $controller A reference to the instantiating controller object
 *  @return void
 */
 public function initialize(Controller $controller) 
 {
		$this->request = $controller->request;
		$this->response = $controller->response;
		$this->_methods = $controller->methods;
}


  public function renderEntry($data)
  {
      $FileName=$data['Entry']['title'].'.pdf';
	  App::import('Vendor','tcpdf/xtcpdf'); 
		$tcpdf = new XTCPDF();
		$textfont = 'freesans'; 
		$tcpdf->SetAuthor("Chipotle Software");
		$tcpdf->SetAutoPageBreak(false);
		$tcpdf->setHeaderFont(array($textfont,'B',9));
        $tcpdf->xheadertext = '';
		$tcpdf->xheadercolor = array(255,255,255);
		$tcpdf->xfootertext = '';
		//set margins
		$tcpdf->SetMargins(14, 14, 14);
		$tcpdf->SetHeaderMargin(1);
		$tcpdf->SetFooterMargin(1); 

		#$Path = ROOT.'/'.APP_DIR.'/webroot/';
		# set font
		$tcpdf->SetFont('freesans', '', 9);
		$tcpdf->AddPage('P', 'LETTER'); 
		$tcpdf->SetFillColor(255, 255, 0);
		$tcpdf->setJPEGQuality(75);
	
		$style = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10,  'color' => array(0, 0, 0)); 
		
		# Header Logo
		$tcpdf->Image(ROOT.'/'.APP_DIR.'/webroot/img/static/karamelo_logo.png', 10, 8, 40);
		$tcpdf->Cell(0,2, '', 0,1,'C');
		$tcpdf->Cell(0,4, '', 0,1,'C');
		#Add HTML
		$output = "";
  		if (!empty($data) ):
			$entry_id  =  (int) $data['Entry']['id'];
			$user_id   =  (int) $data['Entry']['user_id'];
			$cmts      =  (string) __('Comments');
                    	$output.="<b>".__('Teacher').":</b>  ".$data['User']['username']."<br>";
                    	$output.="<b>".__('Title').":</b>  ".$data['Entry']['title']."<br>";
			$output.="<b>".__('Created').":</b> ".$data['Entry']['created']."<br>";
            $url = 'http://' . $_SERVER['HTTP_HOST'].'/entries/view/'.$data['User']['username'].'/'.$data['Entry']['id'];   # URL to current entry
            $output.="<b>Permalink:</b> ".$url."<br><br>";
			$output.=$this->clean($data['Entry']['body']);       
   		endif;
   	    $tcpdf->writeHTML($output, True, 0, True, 0);
		$tcpdf->Cell(0,2, '', 0,1,'C');
		#Download File
		$tcpdf->Output($FileName, 'D'); 
		#return $FileName;
	}

  public function clean($input)
  {
    if (get_magic_quotes_gpc()):
        $input = stripslashes($input);
    endif;
		  
		  $input = str_replace(array("&amp;", "&lt;", "&gt;"), array("&amp;amp;", "&amp;lt;", "&amp;gt;"),$input);
		  $input = preg_replace('#(&\#*\w+)[\x00-\x20]+;#u', "$1;",$input);
		  $input = preg_replace('#(&\#x*)([0-9A-F]+);*#iu', "$1$2;",$input);
		  $input = html_entity_decode($input, ENT_COMPAT, "UTF-8");
		  $input = preg_replace('#(<[^>]+[\x00-\x20\"\'\/])(on|xmlns)[^>]*>#iUu', "$1>",$input);
		  $input = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*)[\\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu', '$1=$2nojavascript...',$input);
		  $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'\"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu', '$1=$2novbscript...',$input);
		 $input = preg_replace('#([a-z]*)[\x00-\x20]*=*([\'\"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#iUu','$1=$2nomozbinding...',$input);
		 $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'\"]*)[\x00-\x20]*data[\x00-\x20]*:#Uu', '$1=$2nodata...',$input);
		 $input = preg_replace('#(<[^>]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*expression[\x00-\x20]*\([^>]*>#iU', "$1>",$input);
		 $input = preg_replace('#(<[^>]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*behaviour[\x00-\x20]*\([^>]*>#iU', "$1>",$input);
		 $input = preg_replace('#(<[^>]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*>#iUu', "$1>",$input);
		 $input = preg_replace('#</*\w+:\w[^>]*>#i', "",$input);
		 do 
		 {
		  $oldstring =$input;
		  $input = preg_replace('#</*(applet|meta|xml|blink|link|style|script|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i', "",$input);
		 } while ($oldstring != $input);
		 $input = str_replace(array("&amp;", "&lt;", "&gt;"), array("&amp;amp;", "&amp;lt;", "&amp;gt;"),$input);
		 return $input;
 	}
}

# ? > EOF
