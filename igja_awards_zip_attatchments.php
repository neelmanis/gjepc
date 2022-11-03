
<?php 
session_start();
if(!isset($_SESSION['curruser_contact_name'])){ header('Location: index.php'); exit; } 
if(!isset($_SESSION['curruser_login_id'])){	header("location:index.php"); exit; }
include('db.inc.php');
include('functions.php');
$registration_id = $_REQUEST['registration_id'];

$general_info = "SELECT attatchments FROM igja_industry_performance_and_theme_based_awards WHERE id='$registration_id'";
$res_general_info = $conn->query($general_info);
$row_general_info = $res_general_info->fetch_assoc();
$attatchments1 = unserialize($row_general_info['attatchments']);

$annual_reports = $attatchments1['annual_reports'];
$income_tax_return_attatchments = $attatchments1['income_tax_return_attatchments'];
$allFiles = array_merge($annual_reports,$income_tax_return_attatchments);

function createZipArchive($files = array(), $destination = '', $overwrite = false) {

   if(file_exists($destination) && !$overwrite) { return false; }

   $validFiles = array();
   if(is_array($files)) {
      foreach($files as $file) {
         if(file_exists( getcwd()."images/igja_awards/".$file)) {
            $validFiles[] =  getcwd()."images/igja_awards/".$file;
         }
      }
   }
   // echo getcwd();exit;
   // print_r($validFiles);exit;

   if(count($validFiles)) {
      $zip = new ZipArchive();
      if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) == true) {
         foreach($validFiles as $file) {
            $zip->addFile($file);
         }
         $zip->close();
         return file_exists($destination);
      }else{
          return false;
      }
   }else{
      return false;
   }
}

//print_r($appendPathArray);
$fileName = 'attatchments.zip';

$result = createZipArchive($allFiles, $fileName);

header("Content-Disposition: attachment; filename=\"".$fileName."\"");
header("Content-Length: ".filesize($fileName));
header("Pragma: no-cache"); 
header("Expires: 0"); 
readfile($fileName);

        
        