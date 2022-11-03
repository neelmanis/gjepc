<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
include('../functions.php');

//if(true)
if(!empty($_POST))  
{ 
	
	$SO_NUMBER = trim($_POST['SO_NUMBER']);
	$PAYMENT_MST_ID=trim($_POST['PAYMENT_MST_ID']);
	
	/*$SO_NUMBER = "3200062396";
	$PAYMENT_MST_ID="1631";*/
	
	//$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_DELIVERY_CREATION:CC_DELIVERY_Sender";
	$soapUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_DELIVERY_CREATION:CC_DELIVERY_Sender";
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password

	
	/*............................Create Delivery.............................*/
	$delivery_date1=date('Y-m-d');
	//$delivery_date="2019-04-15";
	$delivery_date=date('Y-m-d');
	$xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://GJEPC_BATCH_DELIVERY_CREATION.COM">
   <soapenv:Header/>
   <soapenv:Body>
      <gjep:MT_DELIVERY_IN>';
        $xml_post_string .= '<DELIVERY>
            <Shipping_Point>0001</Shipping_Point>
            <Selection_Date>'.$delivery_date1.'</Selection_Date>
            <SO_Number>'.$SO_NUMBER.'</SO_Number>
            <SO_Item_No>10</SO_Item_No>
            <Delivery_Qty>1</Delivery_Qty>
            <SALES_UNIT>EA</SALES_UNIT>
            <SALES_UNIT_ISO>EA</SALES_UNIT_ISO>
         </DELIVERY>
         <Delivery_PGI>
            <Storage_Location>1000</Storage_Location>
            <Picking_Qty>1</Picking_Qty>
            <Actual_GI_Date>'.$delivery_date.'</Actual_GI_Date>
			<Plan_Gds_Mvmt>'.$delivery_date.'</Plan_Gds_Mvmt>
         </Delivery_PGI>';
       $xml_post_string .='</gjep:MT_DELIVERY_IN>
   </soapenv:Body>
</soapenv:Envelope>';
 /*header ("Content-Type:text/xml");
  echo $xml_post_string;exit;*/
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
			//echo $response;
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
					$flag=1;	
					//echo "UPDATE kp_payment_master SET DELIVERY_STATUS='Y' WHERE PAYMENT_MST_ID='$PAYMENT_MST_ID' and SO_NUMBER='$SO_NUMBER'";	
					mysqli_query($conn,"UPDATE kp_payment_master SET DELIVERY_STATUS='Y' WHERE PAYMENT_MST_ID='$PAYMENT_MST_ID'");							
					}
			}
			echo $flag;
		}
?>