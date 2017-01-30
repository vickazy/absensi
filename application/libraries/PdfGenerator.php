<?php
 
class PdfGenerator
{
  public function generate($html,$filename,$size,$oriental)
  {
    define('DOMPDF_ENABLE_AUTOLOAD', true);
    require_once("./vendor/dompdf/dompdf/dompdf_config.inc.php");
    
    $dompdf = new dompdf();
    $dompdf->load_html($html);
    $dompdf->set_paper($size, $oriental);
    $dompdf->render();
    $dompdf->stream($filename.'.pdf',array("Attachment"=>0)); 
  }
}