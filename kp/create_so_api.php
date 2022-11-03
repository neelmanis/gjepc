<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
include('../functions.php');

session_start();
$adminID=$_SESSION['curruser_login_id'];
function getLocationId($LOCATION_ID)
{
	$query_sel = "SELECT SAP_LOCATION_CODE FROM  kp_location_master  where LOCATION_ID='$LOCATION_ID'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['SAP_LOCATION_CODE'];
	}
}
 
if(true)
//if(!empty($_POST))  
{ 
	/*$EXPORT_APP_ID= trim($_POST['EXPORT_APP_ID']);
	$PAYMENT_MST_ID = trim($_POST['PAYMENT_MST_ID']);*/
	
	$EXPORT_APP_ID= 1;
	$PAYMENT_MST_ID =1;

	//$soapSalesUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_BATCH_SO_CREATION:CC_BATCH_SO_Sender"; // Test
	$soapSalesUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_BATCH_SO_CREATION:CC_BATCH_SO_Sender"; // Live
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	/*............................Get SO Details.............................*/
	$sql="select * from kp_payment_master where PAYMENT_MST_ID='$PAYMENT_MST_ID'";
	$query=mysql_query($sql);
	$result=mysql_fetch_array($query);
	
	$PAYMENT_DATE=str_replace('-','',date('Y-m-d',strtotime($result['CHEQUE_DATE'])));
	$BILLING_TO=$result['BILLING_TO'];
	$po_ref=$result['CHEQUE_NO'];
	
	
	/*................................Get BP No.......................................*/
	$sql2="SELECT AGENT_ID,MEMBER_TYPE_ID,MEMBER_ID,NON_MEMBER_ID,FORM_TYPE FROM `kp_export_application_master` WHERE EXPORT_APP_ID='$EXPORT_APP_ID'";
	$query2=mysql_query($sql2);
	$result2=mysql_fetch_array($query2);
	$AGENT_ID=$result2['AGENT_ID'];
	$MEMBER_TYPE_ID=$result2['MEMBER_TYPE_ID'];
	$MEMBER_ID=$result2['MEMBER_ID'];
	$NON_MEMBER_ID=$result2['NON_MEMBER_ID'];
	$FORM_TYPE=$result2['FORM_TYPE'];

	if($FORM_TYPE=="I"){
		$MATERIAL="7000000000";
		$order_Reason="108";
	}
	if($FORM_TYPE=="E"){
		$MATERIAL="7000000001";
		$order_Reason="109";
	}
			

	if($BILLING_TO=="agent"){
		$BPNUMBER=trim(getBpNumber('Agent',$AGENT_ID));
		if($MEMBER_TYPE_ID=="18")
			$Partner_Fun=trim(getBpNumber('Member',$MEMBER_ID));
		elseif($MEMBER_TYPE_ID=="19")
			$Partner_Fun=trim(getBpNumber('NonMember',$NON_MEMBER_ID));
	}else{
		if($MEMBER_TYPE_ID=="18"){
			$BPNUMBER=trim(getBpNumber('Member',$MEMBER_ID));
			$Partner_Fun=trim(getBpNumber('Member',$MEMBER_ID));
		}
		elseif($MEMBER_TYPE_ID=="19"){
			$BPNUMBER=trim(getBpNumber('NonMember',$NON_MEMBER_ID));
			$Partner_Fun=trim(getBpNumber('NonMember',$NON_MEMBER_ID));
		}
	}
	
	/*...........................Get Export/Import Amount....................................*/
	$query3=mysql_query("select FEES_AMOUNT,COURIER_AMOUNT,PROCES_CNTR from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'");
	$result3=mysql_fetch_array($query3);	
	$FEES_AMOUNT=$result3['FEES_AMOUNT'];
	if($result3['COURIER_AMOUNT']=="")
		$COURIER_AMOUNT=0;
	else
		$COURIER_AMOUNT=$result3['COURIER_AMOUNT'];
		
	$PROCES_CNTR=getLocationId($result3['PROCES_CNTR']);
	
	$xml_sales_order_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://Gjepc_Batch_SO.com">
   <soapenv:Header/>
   <soapenv:Body>
      <gjep:MT_Batch_SO_IN>
         <!--1 or more repetitions:-->
         <SOAD_Header>
            <Sales_Doc>ZKMB</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>20</Dis_channel>
            <Division>10</Division>
            <sold_cust>'.$BPNUMBER.'</sold_cust>
            <ship_cust>'.$BPNUMBER.'</ship_cust>
            <po_ref>'.$po_ref.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>'.$order_Reason.'</order_Reason>
            <SO_Date>'.$PAYMENT_DATE.'</SO_Date>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>MUMBAI</Incoterm_Loc>
         </SOAD_Header>';
         
		$sql1="select * from  kp_payment_details where PAYMENT_MST_ID='$PAYMENT_MST_ID'";
		$query1=mysql_query($sql1);
		$i=10;
		while($result1=mysql_fetch_array($query1)){
		$KP_CERT_NO=getKP_CERT($result1['EXPORT_APP_ID']);
		//$FORM_TYPE=getFORM_TYPE($result1['EXPORT_APP_ID']);		
		
        $xml_sales_order_string .= '<SOAD_Item>
            <Item>'.$i.'</Item>
            <Material>'.$MATERIAL.'</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>'.$PROCES_CNTR.'</Plant>
            <Item_Category>TAN</Item_Category>
            <Batch_No>'.$KP_CERT_NO.'</Batch_No>
            <Partner_Fun>'.$Partner_Fun.'</Partner_Fun>
            <Currency/>
            <cond1_Lebel>ZKP</cond1_Lebel>
            <Cond1_Val>'.$FEES_AMOUNT.'</Cond1_Val>
            <Cond2_Lebel>ZCHG</Cond2_Lebel>
            <Cond2_Val>'.$COURIER_AMOUNT.'</Cond2_Val> 
            <cond3_Lebel/>
            <Cond3_Val/>
            <cond4_Lebel/>
            <Cond4_Val/>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>MUMBAI</Incoterms_Loc>
            <Net_Weight>2</Net_Weight>
            <Gross_weight>3</Gross_weight>
            <Sales_Item_Text>Line 10</Sales_Item_Text>
         </SOAD_Item>';
			$i=$i+10;
		}
      $xml_sales_order_string .= '</gjep:MT_Batch_SO_IN>
	  </soapenv:Body>
	</soapenv:Envelope>';
				
header ("Content-Type:text/xml");
echo $xml_sales_order_string; exit; 
	
			$headers1 = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_sales_order_string),
                    ); //SOAPAction: your op URL

            $urls = $soapSalesUrl;

            // PHP cURL  for https connection with auth
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch1, CURLOPT_URL, $urls);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch1, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
           // curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_sales_order_string); // the SOAP request
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);

            // converting
            $response = curl_exec($ch1); 
			echo $response; 
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);
				
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$response;
			//echo $xmlstr;
			
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
			$flag=0;			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
					$arr = $header->xpath('//Message'); // Should output 'something'.
					$leadid = $arr[0];
					$strings = $leadid;
					if(!empty($strings))
					{   $flag=1;
						$sales_order_no=substr($strings, strpos($strings, "@ ")+1,11);
						mysql_query("UPDATE kp_payment_master SET SO_STATUS='Y',SO_NUMBER='$sales_order_no' WHERE PAYMENT_MST_ID='$PAYMENT_MST_ID'");
					}
			}
			echo $flag;

}
?>