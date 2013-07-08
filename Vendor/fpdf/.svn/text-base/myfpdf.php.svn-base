<?php
/**
 *  Extend PDF class to Karamelo
 *  Chipotle Software (c)
 *  GPLv3 2006-2011
 */
require('fpdf.php');

class myFPDF extends FPDF {

/*
 *  PDF title
 *  @access public
 */
public $title = 'Karamelo Report';

/*
 * HTML->PDF attributes
 * @link http://www.fpdf.org/en/script/script41.php
 */
 public $B     = 0;
 public $I     = 0;
 public $U     = 0;
 public $HREF  ='';
 public $ALIGN ='';

/**
 *  Render HTML
 *  @access public 
 *  @return void
 */
 public function writeHTML($html)
 {
  #HTML parser
  $html = str_replace("\n",' ',$html);
  $html = $this->__iLoveCervantes($html);
  $a    = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
  foreach($a as $i=>$e):
     if ($i%2==0):
         # Text
         if ($this->HREF):
             $this->PutLink($this->HREF,$e);
         elseif($this->ALIGN == 'center'):
             $this->Cell(0,5,$e,0,1,'C');
         else:
             $this->Write(5,$e);
         endif;
     else:
        # Tag
        if ( $e[0]=='/' ):
            $this->CloseTag(strtoupper(substr($e,1)));
        else:
            # Extract properties
            $a2=explode(' ',$e);
            $tag=strtoupper(array_shift($a2));
            $prop=array();
            foreach($a2 as $v):
                if (preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3)):
                    $prop[strtoupper($a3[1])]=$a3[2];
                endif;
            endforeach;
            $this->OpenTag($tag,$prop);
        endif;
     endif;
  endforeach;
 }

/**
 *  Replace spanish characters
 *  @access private
 *  @return string  
 */
 private function __iLoveCervantes($texto)
 { 
  $search = array('&aacute;','&Aacute;','&eacute;','&Eacute;','&iacute;','&Iacute;','&oacute;','&Oacute;','&uacute;','&Uacute;','&ntilde;','&Ntilde;', '&nbsp;', '&quot;'); 
  $replace = array('á','Á','é','É','í','Í','ó','Ó','ú','Ú','ñ','Ñ', ' ', '"'); 
  $string =  str_replace($search, $replace, $texto);
  $string  =  utf8_decode($string);  # UTF-8
  return $string;
 }


/**
 * Open HTML tag
 * @access public 
 * @param string $tag
 * @param string $prop
 * @return void
 */
 public function OpenTag($tag,$prop)
 {
  # Opening tag
  if ($tag=='B' || $tag=='I' || $tag=='U'):
         $this->SetStyle($tag,true);
  endif;

  if ($tag=='A'):
      $this->HREF=$prop['HREF'];
  endif;

  if ($tag=='BR'):
      $this->Ln(5);
  endif;

  if ($tag=='P' && isset($prop['ALIGN']) ):
      $this->ALIGN=$prop['ALIGN'];
  endif;

  if ($tag=='HR'):
    if ( !empty($prop['WIDTH']) ):
        $Width = $prop['WIDTH'];
    else:
        $Width = $this->w - $this->lMargin-$this->rMargin;
    endif;
    $this->Ln(2);
    $x = $this->GetX();
    $y = $this->GetY();
    $this->SetLineWidth(0.4);
    $this->Line($x,$y,$x+$Width,$y);
    $this->SetLineWidth(0.2);
    $this->Ln(2);
   endif;
 }

/**
 * 
 * @access public 
 * @return void
 */
 public function CloseTag($tag)
 {
  #Closing tag
  if ($tag=='B' || $tag=='I' || $tag=='U'):
      $this->SetStyle($tag,false);
  endif;

  if ($tag=='A'):
      $this->HREF='';
  endif;

  if ($tag=='P'):
      $this->ALIGN='';
  endif;
 }

/**
 * 
 * @access public 
 * @return void
 */
 public function SetStyle($tag,$enable)
 {
  # Modify style and select corresponding font
  $this->$tag+=($enable ? 1 : -1);
  $style='';
  foreach (array('B','I','U') as $s):
      if ($this->$s>0):
          $style.=$s;
      endif;
  endforeach;
  $this->SetFont('',$style);
 }

/**
 * 
 * @access public 
 * @return void
 */
 public function PutLink($URL,$txt)
 {
  # Put a hyperlink
  $this->SetTextColor(0,0,255);
  $this->SetStyle('U',True);
  $this->Write(5,$txt,$URL);
  $this->SetStyle('U',False);
  $this->SetTextColor(0);
 }

/**
 *  Page header overriding method
 *  @access public
 *  @return void
 */
 public function Header()
 {
  # Logo
  $this->Image('img/static/karamelo_logo.png',10,8,33);
  # Arial bold 15
  $this->SetFont('Arial','B',15);
  # Move to the right
  $this->Cell(80);
  # Title
  $this->Cell(90,10,$this->title,1,0,'C');
  # Line break
  $this->Ln(20);
 }

/**
 *  Page footer
 *  @access public
 *  @return void
 */
 public function Footer()
 {
    # Position at 1.5 cm from bottom
    $this->SetY(-15);
    # Arial italic 8
    $this->SetFont('Arial','I',8);
    # Page number
    $this->Cell(0,10,'Page '.$this->PageNo()."/{nb}",0,0,'C');
 }
}
?>
