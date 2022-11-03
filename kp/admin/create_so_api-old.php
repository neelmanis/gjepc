<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
include('../functions.php');

session_start();
$adminID=$_SESSION['curruser_login_id'];
 
//if(!empty($_POST))  
if(true)
{ 
	/*$bpno = trim($_POST['bpno']);*/
	//$PAYMENT_MST_ID = trim($_POST['PAYMENT_MST_ID']);
	 
	$bpno = "6000001";
	$PAYMENT_MST_ID = "11";
	
	$soapSalesUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_BATCH_SO_CREATION:CC_BATCH_SO_Sender"; // Test
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	/*............................Get SO Details.............................*/
	$sql="select * from kp_payment_master where PAYMENT_MST_ID='$PAYMENT_MST_ID'";
	$query=mysql_query($sql);
	$result=mysql_fetch_array($query);
	
	$PAYMENT_DATE=str_replace('-','',date('Y-m-d',strtotime($result['CHEQUE_DATE'])));
	$FEES_AMOUNT=$result['FEES_AMOUNT'];
	if($result['COURIER_AMOUNT']=="")
		$COURIER_AMOUNT=0;
	else
		$COURIER_AMOUNT=$result['COURIER_AMOUNT'];
	
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
            <sold_cust>'.$bpno.'</sold_cust>
            <ship_cust>'.$bpno.'</ship_cust>
            <po_ref>TR00012323</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>109</order_Reason>
            <SO_Date>'.$PAYMENT_DATE.'</SO_Date>
            <Cust_Ref_Date>'.$PAYMENT_DATE.'</Cust_Ref_Date>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>MUMBAI</Incoterm_Loc>
         </SOAD_Header>';
         
		$sql1="select * from  kp_payment_details where PAYMENT_MST_ID='$PAYMENT_MST_ID'";
		$query1=mysql_query($sql1);
		$i=10;
		while($result1=mysql_fetch_array($query1)){
		$KP_CERT_NO=getKP_CERT($result1['EXPORT_APP_ID']);
		$FORM_TYPE=getFORM_TYPE($result1['EXPORT_APP_ID']);
		$MATERIAL="";
		if($FORM_TYPE=="E");
			$MATERIAL="8000040";
		if($FORM_TYPE=="I")
			$MATERIAL="8000000";
			
		
        $xml_sales_order_string .= '<SOAD_Item>
            <Item>'.$i.'</Item>
            <Material>'.$MATERIAL.'</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>1010</Plant>
            <Item_Category>TAN</Item_Category>
            <Batch_No>'.$KP_CERT_NO.'</Batch_No>
            <Partner_Fun>6000001</Partner_Fun>//party BP number
            <Currency/>
            <cond1_Lebel>ZKP</cond1_Lebel>
            <Cond1_Val>'.$FEES_AMOUNT.'</Cond1_Val>//charges without GST
            <Cond2_Lebel>ZCHG<Cond2_Lebel>//for Courier
            <Cond2_Val>'.$COURIER_AMOUNT.'</Cond2_Val> //courier charges
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
			//echo $response;exit; 
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