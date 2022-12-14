<?PHP
session_start(); 
ob_start();
include('../db.inc.php');
  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "relief-aid_" . date('Ymd') . ".csv";

  /*header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv");*/

  $out = fopen("php://output", 'w');

  $flag = false;
  $result = $conn ->query("SELECT * FROM relief_aid order by id") or die('Query failed!');
  while(false !== ($row =  $result->fetch_assoc())) {
    if(!$flag) {
      // display field/column names as first row
      fputcsv($out, array_keys($row), ',', '"');
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    fputcsv($out, array_values($row), ',', '"');
  }
  fclose($out);
 
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=".$filename);
	header("Pragma: no-cache");
	header("Expires: 0");
    exit;
?>