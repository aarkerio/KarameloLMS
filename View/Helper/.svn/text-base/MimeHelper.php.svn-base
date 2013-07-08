<?php
/** 
*  Mime Helper
*  2009-2011 Manuel Montoya Affero GPLv3
*  Chipotle Software (c)
*/
class MimeHelper extends Helper
{
 public function getMimeType($file)
 { 
   #die(debug($file));
   if (function_exists('finfo_file')):
       #This is not tested yet!!!
       $finfo = finfo_open(FILEINFO_MIME,  "/usr/share/misc/magic"); # return mime type ala mimetype extension
                                                                     # http://php.net/manual/en/function.finfo-open.php
       if (!$finfo):
           return 'No mime database';
       endif;

       /* get mime-type for a specific file */
       $mime = finfo_file($finfo, $file);
       finfo_close($finfo);

       return $mime;

   elseif (function_exists('mime_content_type')):
       #Deprecated since PHP 5.3
       return mime_content_type($file);
   else:
       return 'application/force-download';
   endif;
 }
}
# ? > EOF
