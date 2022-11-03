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

if(true)
//if(!empty($_POST))  
{ 
	//$EXPORT_APP_ID = trim($_POST['EXPORT_APP_ID']);
	$EXPORT_APP_ID = "2377";
	
	$soapUrl ="https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_BATCH_CREATION:CC_BATCH_Sender"; 
	
	//$soapUrl ="https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_KP_BATCH_CREATION:CC_KP_Batch_Sender";//Live
				
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password

	
	/*............................Get KP Application Detail.............................*/
	$sql="select * from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'";
	$query=mysqli_query($conn,$sql);
	$result=mysqli_fetch_array($query);
	
	$FORM_TYPE=$result['FORM_TYPE'];
	$IE_PARTY_ID =$result['IE_PARTY_ID'];
	$FOREIGN_BP=getForeignBp($conn,$IE_PARTY_ID);
	$processing_location=$result['PROCES_CNTR'];
	
	$PROCES_CNTR=getLocationId($conn,$result['PROCES_CNTR']);
	//$PROCES_CNTR=1030;
	if($FORM_TYPE=="I"){
			$class="KP_IMPORT";
			$KP_CERT_NO =$result['KP_CERT_NO'];
			///*.........Test Matrial ............*/$MATERIAL="8000000";
			$MATERIAL="7000000000";
			$DATE_OF_ISSUE=$result['KP_CERT_ISSUE_DATE'];
			$DATE_OF_EXPIRY=$result['KP_CERT_EXPIRY_DATE'];
			$import_batch="X";
			$FOREIGN_BP=getForeignPartyName($conn,$IE_PARTY_ID);
		}
	else{
			$class="KP_EXPORT";
			$result1=mysqli_fetch_array(mysqli_query($conn,"select last_serial_no from kp_export_batch_serial where status=1 and processing_location='$processing_location' order by id limit 0,1"));
			$KP_CERT_NO =$result1['last_serial_no'];
			$MATERIAL="7000000001";
			$DATE_OF_ISSUE="";
			$DATE_OF_EXPIRY="";
			$export_batch="X";
		}
	
	$COUNTRY_DEST_ID=getOrginCountryName($conn,$result['COUNTRY_DEST_ID']);
	
	
	$NUMBER_OF_PARCELS=$result['NUMBER_OF_PARCELS'];

	/*.................Kp Transaction Detail.......................*/
	$query_trans=mysqli_query($conn,"select sum(WEIGHT) as TOTAL_WGHT ,sum(AMOUNT) as USD_AMOUNT,COUNTRY_ID from kp_expimp_tran_detail where EXPORT_APP_ID='$EXPORT_APP_ID'");
	$result_trans=mysqli_fetch_array($query_trans);
	if($result_trans['TOTAL_WGHT']!="")
		$TOTAL_WGHT=$result_trans['TOTAL_WGHT'];
	else
		$TOTAL_WGHT=0;
	if($result_trans['USD_AMOUNT']!="")
		$USD_AMOUNT=$result_trans['USD_AMOUNT'];
	else
		$USD_AMOUNT=0;
		
	$COUNTRY_OF_ORIGIN=getOrginCountryName($conn,$result_trans['COUNTRY_ID']);
	
	
	//For Testing purpose
	$MATERIAL="8000000";
	$KP_CERT_NO="DELTA321";
	
	/*$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://GJEPC_BATCH_CREATION.com">
   <soapenv:Header/>
   <soapenv:Body>
      <gjep:MT_KP_BATCH_IN>';	  
$xml_post_string .= "
      		<Batch_Create>
            <Material>".$MATERIAL."</Material>
            <Batch>".$KP_CERT_NO."</Batch>
            <Plant>".$PROCES_CNTR."</Plant>
            <Storage_Location>1000</Storage_Location>
            <CARAT_PRICE>".$USD_AMOUNT."</CARAT_PRICE>
            <class_num>".$class."</class_num>
            <batchlevel>1</batchlevel>
            <doclassify>X</doclassify>
            <import_batch>".$import_batch."</import_batch>
            <export_batch>".$export_batch."</export_batch>
            <CARAT_VALUE>".$TOTAL_WGHT."</CARAT_VALUE>";
			

	*/	
	/*.................Kp Transaction Detail Split.......................
	$query_trans1=mysqli_query($conn,"select * from kp_expimp_tran_detail where EXPORT_APP_ID='$EXPORT_APP_ID' order by HS_CODE_ID ASC");
	$i=0;
	
	$xml_post_string1=array();
	while($result_trans1=mysqli_fetch_array($query_trans1)){
	$i++;		
	$HS_CODE_ID=$result_trans1['HS_CODE_ID'];
	$xml_post_string1 [$HS_CODE_ID]= "			
			<HSN".$HS_CODE_ID."_PRICE>".$result_trans1['AMOUNT']."</HSN".$HS_CODE_ID."_PRICE>
			<HSN".$HS_CODE_ID."_CARAT>".$result_trans1['WEIGHT']."</HSN".$HS_CODE_ID."_CARAT>";
	}
	for($j=1;$j<=3;$j++){
		if (array_key_exists($j,$xml_post_string1)){
			$xml_post_string.=$xml_post_string1[$j];		
		}else{
			$xml_post_string.="			
			<HSN".$j."_PRICE>0</HSN".$j."_PRICE>
			<HSN".$j."_CARAT>0</HSN".$j."_CARAT>";
		}
	}

$xml_post_string .= "			
            <COUNTRY>INDIA</COUNTRY>
            <No_of_PARCEL>".$NUMBER_OF_PARCELS."</No_of_PARCEL>
            <DATE_OF_ISSUE>".$DATE_OF_ISSUE."</DATE_OF_ISSUE>
            <DATE_OF_EXPIRY>".$DATE_OF_EXPIRY."</DATE_OF_EXPIRY>
            <COUNTRY_OF_ORIGIN>".$COUNTRY_OF_ORIGIN."</COUNTRY_OF_ORIGIN>
            <FOREIGN_BP>".$FOREIGN_BP."</FOREIGN_BP>
            <KPCNO></KPCNO>
            <IMPCONF_SLIP></IMPCONF_SLIP>
            <REMARKS></REMARKS>
            <KP_CANTECH></KP_CANTECH>
            <KPC_ENDORSEMENT_DATE></KPC_ENDORSEMENT_DATE>
            <CUSTOM_CLEARANCE_DATE></CUSTOM_CLEARANCE_DATE>
            <Provision_Num>0</Provision_Num>
            <Provision_char></Provision_char>
         </Batch_Create>";
	$xml_post_string .= "
		</gjep:MT_KP_BATCH_IN>
   </soapenv:Body>
</soapenv:Envelope>";

	$xml_post_string=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xml_post_string);*/

$xml_post_string='
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://GJEPC_BATCH_CREATION.com">
   <soapenv:Header/>
   <soapenv:Body>
      <gjep:MT_BATCH_IN>
         <!--1 or more repetitions:-->
         <Batch_Create>
            <Material>8000000</Material>
            <Batch>GAMMA555</Batch>
            <Plant>1010</Plant>
            <Storage_Location>1000</Storage_Location>
            <CARAT_PRICE>12345678910.34</CARAT_PRICE>
            <class_num>KP_IMPORT</class_num>
            <batchlevel>1</batchlevel>
            <doclassify>X</doclassify>
            <import_batch>X</import_batch>
            <export_batch> </export_batch>
            <CARAT_VALUE>8329382982.45</CARAT_VALUE>
            <HSN1_PRICE>12345678930.65</HSN1_PRICE>
            <HSN1_CARAT>0</HSN1_CARAT>
            <HSN2_PRICE>0</HSN2_PRICE>
            <HSN2_CARAT>0</HSN2_CARAT>
            <HSN3_PRICE>9384923849.43</HSN3_PRICE>
            <HSN3_CARAT>9829832923.54</HSN3_CARAT>
            <COUNTRY>INDIA</COUNTRY>
            <No_of_PARCEL>55</No_of_PARCEL>
            <DATE_OF_ISSUE>2019-01-01</DATE_OF_ISSUE>
            <DATE_OF_EXPIRY>2019-04-02</DATE_OF_EXPIRY>
            <COUNTRY_OF_ORIGIN></COUNTRY_OF_ORIGIN>
            <FOREIGN_BP></FOREIGN_BP>
            <KPCNO></KPCNO>
            <IMPCONF_SLIP></IMPCONF_SLIP>
            <REMARKS></REMARKS>
            <KP_CANTECH>C</KP_CANTECH>
            <KPC_ENDORSEMENT_DATE></KPC_ENDORSEMENT_DATE>
            <CUSTOM_CLEARANCE_DATE></CUSTOM_CLEARANCE_DATE>
            <Provision_Num>0</Provision_Num>
            <Provision_char></Provision_char>
         </Batch_Create>
      </gjep:MT_BATCH_IN>
   </soapenv:Body>
</soapenv:Envelope>';
	
  /* header ("Content-Type:text/xml");
   echo $xml_post_string;exit;*/
  
 
           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_post_string),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
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

            // converting
            $response = curl_exec($ch); 
			echo $response;exit;
            if(curl_errno($ch))
				curl_error($ch);
			else
				curl_close($ch);
				
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$response;
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
			$flag=0;			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
					$arr = $header->xpath('//Message'); // Should output 'something'.
					$leadid = $arr[0];
					$strings = substr($leadid,1,2);
					if(!empty($strings))
					{
						if($strings=="SS" || $strings=="SE"){
							if($strings=="SS")$flag=1;
							if($strings=="SE")$flag=2;
							mysqli_query($conn,"UPDATE kp_export_application_master SET KP_BATCH_STATUS='Y',KP_BATCH_RES='$strings',KP_CERT_NO='$KP_CERT_NO' WHERE EXPORT_APP_ID='$EXPORT_APP_ID'");
							if($FORM_TYPE=="E")
								mysqli_query($conn,"UPDATE `kp_export_batch_serial` SET `last_serial_no`=`last_serial_no`+1 where processing_location='$processing_location' and status=1");
						}elseif($strings=="EE"  )$flag=3;			
					}
			}
			echo $flag;
		}
?>