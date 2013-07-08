<?php
# By Adam (ifunk)
# http://bakery.cakephp.org/articles/view/csv-helper-php5
# 0.3 Version MM Chipotle Software
# This helper does not work with cakephp-instaweb

class CsvHelper extends AppHelper {
     
  public $delimiter = ',';
  public $enclosure = '"';
  public $filename  = 'Export.csv';
  public $line      = array();
  public $buffer    = null;  # file
  
/**
 *
 * @param integer
 * @access public
 */ 
  public function CsvHelper() 
  {
    $this->clear();
  }

/**
 *
 * @param integer
 * @access public
 */ 
  public function clear() 
  {
    $this->line = array();
    $this->buffer = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');
  }
    
/**
 *
 * @param integer
 * @access public
 */ 
  public function addField($value) 
  {
    $this->line[] = $value;
  }
    
/**
 *
 * @param integer
 * @access public
 */ 
  public function endRow() 
  {
    $this->addRow($this->line);
    $this->line = array();
  }

/**
 *
 * @param integer
 * @access public
 */ 
  public function addRow($row) 
  {
    fputcsv($this->buffer, $row, $this->delimiter, $this->enclosure);
  }

/**
 *
 * @param integer
 * @access public
 */ 
  public function renderHeaders() 
  {
    header("Content-type:application/vnd.ms-excel");
    header("Content-disposition:attachment;filename=".$this->filename);
  }
    
/**
 *
 * @param integer
 * @access public
 */ 
  public function setFilename($filename) 
  {
    $this->filename = $filename;
    if (strtolower(substr($this->filename, -4)) != '.csv'):
      $this->filename .= '.csv';
    endif;
  }
 
/**
 *
 * @param integer
 * @access public
 */   
  public function render($outputHeaders = true, $to_encoding = null, $from_encoding = "auto") 
  {
    if ($outputHeaders):
        if (is_string($outputHeaders)):
	        $this->setFilename($outputHeaders);
        endif;
        $this->renderHeaders();
    endif;
    rewind($this->buffer);
    $output = stream_get_contents($this->buffer);
    if ($to_encoding):
        $output = mb_convert_encoding($output, $to_encoding, $from_encoding);
    endif;
    #die(debug($output));
    return $this->output($output);
  }
}

# ? > EOF
