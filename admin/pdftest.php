<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
use Mpdf\Mpdf;
//include '../include-new/header.php';
require_once('vendor/autoload.php');

$html = '<section>  
<div class="container-fluid inner_container">
     <div class="row justify-content-center grey_title_bg">              
        <div class="bold_font text-center"> 
        <div class="d-block"><img src="http://localhost/gjepc/admin/images/logo.png"></div>Download Parichay Card</div>                    
    </div>      
              
        <div class="container">             
            <div class="row">
            </div></div></div>
            <div class="parichayCard_White"><bookmark content="Start of the Document" /><div>Section 1 text</div></div>';

// $zip = new ZipArchive(); // Load zip library 
// $zip_name = time().".zip";
$mpdf = new Mpdf();
$html1 = html_entity_decode($html, ENT_QUOTES);
//echo $html1;die();
$mpdf->WriteHTML($html1);
$file = time().'.pdf';    
//$mpdf->Output($file);
$mpdf->Output($file,'D');

if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
{ 
echo "zip error ";die();
} else {
    $get_pdf   = 'pdf/ALUHA.pdf';
   //$get_pdf   = $mpdf->Output('pdf/ALUHA.pdf','D');
  
//    $file = 'C:/wamp64/www/pdf/pdf.zip';

//    if (file_exists($file)) {
//        header('Content-Description: File Transfer');
//        header('Content-Type: application/octet-stream');
//        header('Content-Disposition: attachment; filename='.basename($file));
//        header('Content-Transfer-Encoding: binary');
//        header('Expires: 0');
//        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//        header('Pragma: public');
//        header('Content-Length: ' . filesize($file));
//        ob_clean();
//        flush();
//        readfile($file);
//        exit;
//    } else {
//        echo "hii";die();
//    }
   
    //$zip->addFile($get_pdf);
    // ob_end_clean();
    // $zip->close();

    // $archfilename = 'filename.zip';

    // header("Content-type: application/zip"); 

    // header("Content-Disposition: attachment; filename = $archfilename"); 

    // header("Pragma: no-cache"); 

    // header("Expires: 0"); 

    // readfile("$archfilename");

    // exit;

}
// $zip = new ZipArchive;
// $temp_file_name = 'my-pdf.zip';

// $zip = new ZipArchive();
// $file_zip = $temp_file_name;
// $zip->open($file_zip, ZipArchive::OVERWRITE);
// $zip->addFile($pdf, 'a.pdf');
// $zip->close();
//$mpdf->Output();

?>