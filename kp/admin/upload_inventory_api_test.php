<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
include('../functions.php');

function getLocationId($conn,$LOCATION_ID)
{
	$query_sel = "SELECT SAP_LOCATION_CODE FROM  kp_location_master  where LOCATION_ID='$LOCATION_ID'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['SAP_LOCATION_CODE'];
	}
}
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
if(true)
//if(!empty($_POST))  
{ 
	//$EXPORT_APP_ID = trim($_POST['EXPORT_APP_ID']);
	$EXPORT_APP_ID = "2377";
	
	$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Inventory_Upload:CC_Inventory_upload_Sender";
	//$soapUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_Inventory_Upload:CC_Inventory_upload_Sender";

	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password

	
	/*............................Get KP Application Detail.............................*/
	$sql="select * from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'";
	$query=mysqli_query($conn,$sql);
	$result=mysqli_fetch_array($query);
	
	$COUNTRY_DEST_ID =$result['COUNTRY_DEST_ID'];
	$FORM_TYPE=$result['FORM_TYPE'];
	if($COUNTRY_DEST_ID=="BE" && $FORM_TYPE=="I")
		$KP_CERT_NO =$result['KP_BATCH_NO'];
	else	
		$KP_CERT_NO =$result['KP_CERT_NO'];

	$PROCES_CNTR=getLocationId($conn,$result['PROCES_CNTR']);
	$NUMBER_OF_PARCELS=$result['NUMBER_OF_PARCELS'];
	//$posting_date=date('2019-04-01');//current date 
	$posting_date=date('Y-m-d'); 
	
	
	if($FORM_TYPE=="I"){
			$MATERIAL="7000000000";
		}
	else{
			$MATERIAL="7000000001";
		}
	
	/*...................Testig .....................*/
	$MATERIAL="8000000";
	$KP_CERT_NO="GAMMA555";
	
	$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://Gjepc_Inventory_Upload.com">
   <soapenv:Header/>
   <soapenv:Body>
      <gjep:MT_Inventory_IN>';		
$xml_post_string .= "
			<Inventory_upload>
            <Material>".$MATERIAL."</Material>
            <Batch>".$KP_CERT_NO."</Batch>
            <Plant>".$PROCES_CNTR."</Plant>
            <move_type>561</move_type>
            <Storage_Location>1000</Storage_Location>
            <entry_Quantity>1</entry_Quantity>
            <entry_unit>EA</entry_unit>
            <posting_date>".$posting_date."</posting_date>
            <Document_Date>".$posting_date."</Document_Date>
         </Inventory_upload>";
	
	$xml_post_string .= "
		</gjep:MT_Inventory_IN>
   </soapenv:Body>
</soapenv:Envelope>";
 header ("Content-Type:text/xml");
  echo $xml_post_string;exit;
           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "Content-length: ".strlen($xml_post_string),
                    );

            $url = $soapUrl;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            //curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch); 
			echo $response;exit;
            if(curl_errno($ch))
				curl_error($ch);
			else
				curl_close($ch);
				
			//print_r($response);
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$response;
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
			$flag=0;			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
					$arr = $header->xpath('//Message'); // Should output 'something'.
					$leadid = $arr[0];
					$strings = $leadid;
					
					if(!empty($strings))
					{
						if(preg_match("/S Inventory Material/", $strings)){
							$flag=1;
							$INVENTORY_DOCUMENT_NO = get_string_between($strings, '@', ':');
							mysqli_query($conn,"UPDATE kp_export_application_master SET INVENTORY_UPLAOD_STATUS='Y',INVENTORY_DOCUMENT_NO='$INVENTORY_DOCUMENT_NO' WHERE EXPORT_APP_ID='$EXPORT_APP_ID'");
						}							
					}
			}
			echo $flag;
		}
?>