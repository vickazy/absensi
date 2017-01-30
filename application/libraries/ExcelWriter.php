<?php
 
class ExcelWriter
{
  public function writeToXLS($header, $data, $filename)
  {
    require_once("./vendor/PHP_XLSXWriter-master/xlsxwriter.class.php");
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);
    $filename = $filename.".xlsx";
    header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    $writer = new XLSXWriter();
    $writer->setAuthor('Some Author');
    $writer->writeSheet($data,'Sheet1',$header);
    $writer->writeToStdOut();
    //$writer->writeToFile('example.xlsx');
    //echo $writer->writeToString();
    exit(0);
  }
}