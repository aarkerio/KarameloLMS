<?php
/**
 * Chipotle Software (c) 2006-2010
 * Render Newsletter to PDF format
 * @license GPLv3
 */
#die(debug($data));
$counter = (int) 0;
$counter++;
$fpdf->newPage();
$fpdf->setTitle($data['Newsletter']['title']);
$fpdf->setData( $data['Newsletter']['title']);
$fpdf->setData( $data['Newsletter']['created']);
$fpdf->setHTML($data['Newsletter']['body']);
$vname =  str_replace(' ','_', 'Karamelo_'.$data['Newsletter']['title'].'_'.date('l jS \of F Y'));
echo $fpdf->fpdfOutput($vname.'.pdf');    
?>