<?php 
/**
*   Chipotle Software (c) TM 2006-2011
*   @license: GPLv3 
*/
App::import('Vendor', 'fpdf/myfpdf');

class FpdfHelper extends AppHelper {

/**
 * Init
 * @access public 
 * @var   boolean
 */
  public  $initialized = False;

/**
 * Init
 * @access public 
 * @var   boolean
 */
  public  $pdf  = Null;  

/**
 * Allows you to change the defaults set in the FPDF constructor
 *
 * @param string $orientation page orientation values: P, Portrait, L, or Landscape    (default is P)
 * @param string $unit values: pt (point 1/72 of an inch), mm, cm, in. Default is mm
 * @param string $format values: A3, A4, A5, Letter, Legal or a two element array with the width and height in unit given in $unit
 */
 public function __construct($orientation='P',$unit='mm',$format='Letter') 
 { 
    $this->pdf = new myFPDF();
    $this->pdf->SetFont('Arial','B',10);
 }

/**
 * Set data
 * @access public
 * @param string $title 
 * @return void
 */
 public function setTitle($title)
 {
  $this->pdf->title = $title;
  #die(debug($this->pdf->title));
 }

/**
 * Set data
 * @access public 
 * @param string $title 
 * @return void
 */
 public function setHTML($string)
 {
   $string  =  utf8_decode($string);  # UTF-8
   $this->pdf->writeHTML($string);
   $this->pdf->Ln(2);
 }

/**
 * Set data
 * @access public 
 * @param string $title 
 * @return void
 */
 public function setData($data)
 {
    $string  =  utf8_decode($data);  # UTF-8
    # Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
    $this->pdf->Cell(0,3,$string,0,1,'L');
    $this->pdf->Ln(2);
  }

/**
 * Add new PDF page
 * @access public 
 * @return void
 */
 public function newPage()
 {
  $this->pdf->AddPage();
 }

/**
 * Allows you to control how the pdf is returned to the user, most of the time in CakePHP you probably want the string
 *
 * @param string $name name of the file.
 * @param string $destination where to send the document values: I, D, F, S
 * @return string if the $destination is S
 */
 public function fpdfOutput($name = 'page.pdf', $destination = 'D') 
 {
  // I: send the file inline to the browser. The plug-in is used if available. 
  //    The name given by name is used when one selects the "Save as" option on the link generating the PDF.
  // D: send to the browser and force a file download with the name given by name.
  // F: save to a local file with the name given by name.
  // S: return the document as a string. name is ignored.
  return $this->pdf->Output($name, $destination);
 }
}
?>