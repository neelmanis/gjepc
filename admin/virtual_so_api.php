<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start(); 
$adminID = $_SESSION['curruser_login_id'];
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

function getEvent_material_no($event,$conn)
{
	$query_sel = "SELECT material_no FROM iijs_sap_dummy_stall where category='$event'";
	$result_sel = $conn ->query($query_sel);		
	$row = $result_sel->fetch_assoc(); 	
	return $row['material_no'];
}

function getBillingBPNO($id,$conn)
{
	$query_sel = "SELECT c_bp_number FROM `communication_address_master` WHERE `id`='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['c_bp_number'];
}

if(!empty($_POST)) 
//if(true)
{	
	$registration_id = trim($_POST['registration_id']);
	$bpno = trim($_POST['bpno']);

	//$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // Development
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // LIVE
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	/*................................Get Country Code.....................................*/
	$q = $conn ->query("select * from registration_master where `id` = '$registration_id' limit 1");
	$r = $q->fetch_assoc();
	$country_code = $r['country'];
		   $rcity = $r['city'];
	
	$info = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id' limit 1";
	$infoResult = $conn ->query($info);
	$rows = $infoResult->fetch_assoc();
	if($rows['region_id']=='HO-MUM (M)'){ $region=1010;}
	if($rows['region_id']=='RO-JAI'){ $region=1020;}
	if($rows['region_id']=='RO-SRT'){ $region=1030;}
	if($rows['region_id']=='RO-CHE'){ $region=1040;}
	if($rows['region_id']=='RO-DEL'){ $region=1050;}
	if($rows['region_id']=='RO-KOL'){ $region=1060;}
	
	$show = "IIJS VIRTUAL SHOW 2021";
	
	/* Start Sales Order */
	$bpinfo = "SELECT c_bp_number,city FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1";
	$bpInfoResult = $conn ->query($bpinfo);
	$bpRows = $bpInfoResult->fetch_assoc();
	$ho_bp_number = trim($bpRows['c_bp_number']); /* Pass Parent BP Number From communication_address_master Table*/
	$city = trim($bpRows['city']);
	if($city=='')
		$city = trim($rcity);
	else 
		$city = trim($city);
		
	$query="select * from virtual_event_registration where event_selected='vbsm2' AND payment_status='approved' AND application_status='approved' AND registration_id='".$registration_id."' ";
	$getChallanResult = $conn ->query($query);
	$eventCountx = $getChallanResult->num_rows;
	$challanResult = $getChallanResult->fetch_assoc();
	
	$renewDate = date("Ymd", strtotime($challanResult['post_date']));
	$event = trim($challanResult['event']);
	$additional_image = $challanResult['additional_image']; 
	$meeting_room = $challanResult['meeting_room']; 
		
	$event_rate   = $challanResult['show_charge']; 
	$image_rate   = 50; 
	$meeting_rate = 10000; 
	
	$event_item_material = getEvent_material_no($event,$conn); // Event Material No
	$meeting_item_material = 4000007001; // Meeting Room Material No 
	$image_item_material = 4000007002;   // Additional Image Material No
	
	$billing_bp_number = $challanResult['get_billing_bp_number'];
	if($billing_bp_number==''){ $billing_bp_number = $bpno; }
	if($ho_bp_number=='')     { $ho_bp_number=$bpno; }
	
	/* UTR Data */
	$getUTR = "SELECT * FROM `utr_history` where registration_id='$registration_id' AND utr_approved='Y' AND `show` ='$show' AND event_selected='vbsm2' order by `utr_date` asc limit 1";
	$utrResult = $conn ->query($getUTR);
	$utrResultrows = $utrResult->fetch_assoc();
	$utr_id = $utrResultrows['id'];
	$utr_number = filter($utrResultrows['utr_number']);
	$utr_date = $utrResultrows['utr_date']; 
	$getUtr_Date = date("Ymd", strtotime($utr_date));
	$amountPaid = $utrResultrows['amountPaid'];
	
	$Date = date('Ymd');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = $next_year."0331"; // Next Financial year
	
	$xml_exhibition_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcexhibition.com">
    <soapenv:Header/>
    <soapenv:Body>
      <gjep:MT_Exhibition_IN>
        <SOAD_Header>
            <Sales_Doc>ZEVT</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>30</Dis_channel>
            <Division>20</Division>
            <sold_cust>'.$billing_bp_number.'</sold_cust>
            <ship_cust>'.$ho_bp_number.'</ship_cust>
            <po_ref>'.$utr_number.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>112</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>'.$city.'</Incoterm_Loc>
			<Event_Type>D</Event_Type>
        </SOAD_Header>';
			
		if($eventCountx > 0){
		$xml_exhibition_string .= '
        <SOAD_Item>
            <Item>0010</Item>
            <Material>'.$event_item_material.'</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>TAD</Item_Category>
            <cond1_Lebel>ZREG</cond1_Lebel>
            <Cond1_Val>'.$event_rate.'</Cond1_Val>			
            <Cond2_Lebel></Cond2_Lebel>
            <Cond2_Val></Cond2_Val>			
            <Cond3_Lebel></Cond3_Lebel>
            <Cond3_val></Cond3_val>			
            <Cond4_Lebel></Cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Cond5_Lebel></Cond5_Lebel>
            <Cond5_Val></Cond5_Val>
            <Cond6_Lebel></Cond6_Lebel>
            <Cond6_Val></Cond6_Val>
            <Batch></Batch>
            <WBS>DE-051</WBS>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>'.$city.'</Incoterms_Loc>
            <Net_weight>1</Net_weight>
            <Gross_Weight>1</Gross_Weight>
         </SOAD_Item>
		 <SOAD_Item>
            <Item>0020</Item>
            <Material>'.$image_item_material.'</Material>
            <Order_Qty>'.$additional_image.'</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>TAD</Item_Category>
            <cond1_Lebel>ZREG</cond1_Lebel>
            <Cond1_Val>'.$image_rate.'</Cond1_Val>			
            <Cond2_Lebel></Cond2_Lebel>
            <Cond2_Val></Cond2_Val>			
            <Cond3_Lebel></Cond3_Lebel>
            <Cond3_val></Cond3_val>			
            <Cond4_Lebel></Cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Cond5_Lebel></Cond5_Lebel>
            <Cond5_Val></Cond5_Val>
            <Cond6_Lebel></Cond6_Lebel>
            <Cond6_Val></Cond6_Val>
            <Batch></Batch>
            <WBS>DE-051</WBS>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>'.$city.'</Incoterms_Loc>
            <Net_weight>1</Net_weight>
            <Gross_Weight>1</Gross_Weight>
         </SOAD_Item>
		 <SOAD_Item>
            <Item>0030</Item>
            <Material>'.$meeting_item_material.'</Material>
            <Order_Qty>'.$meeting_room.'</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>TAD</Item_Category>
            <cond1_Lebel>ZREG</cond1_Lebel>
            <Cond1_Val>'.$meeting_rate.'</Cond1_Val>			
            <Cond2_Lebel></Cond2_Lebel>
            <Cond2_Val></Cond2_Val>			
            <Cond3_Lebel></Cond3_Lebel>
            <Cond3_val></Cond3_val>			
            <Cond4_Lebel></Cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Cond5_Lebel></Cond5_Lebel>
            <Cond5_Val></Cond5_Val>
            <Cond6_Lebel></Cond6_Lebel>
            <Cond6_Val></Cond6_Val>
            <Batch></Batch>
            <WBS>DE-051</WBS>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>'.$city.'</Incoterms_Loc>
            <Net_weight>1</Net_weight>
            <Gross_Weight>1</Gross_Weight>
         </SOAD_Item>';
		}
		
		$xml_exhibition_string .= ' 
         <SOAD_Advance>
            <Doc_date>'.$Date.'</Doc_date>
            <Posting_date>'.$getUtr_Date.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
			<WBS>DE-051</WBS>
            <Account>'.$billing_bp_number.'</Account>
            <Sp_gl_indicator>A</Sp_gl_indicator>
            <Doc_text>SK</Doc_text>
            <Bank_Acc_No>255241</Bank_Acc_No>
            <Bus_area>1111</Bus_area>
            <Amount>'.$amountPaid.'</Amount>
            <Profit_centre>1110</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
         </SOAD_Advance>
      </gjep:MT_Exhibition_IN>
   </soapenv:Body>
</soapenv:Envelope>';
				
	/* header ("Content-Type:text/xml");
	echo $xml_exhibition_string; exit; */
	
			$headers1 = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_exhibition_string),
                    ); //SOAPAction: your op URL

            $urls = $soapRenewalUrl;

            // PHP cURL  for https connection with auth
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch1, CURLOPT_URL, $urls);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch1, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
           // curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_exhibition_string); // the SOAP request
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);

            // converting
            $respons = curl_exec($ch1); 
			//echo $respons;exit;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);

			// print to get response print_r($response);
			//var_dump($respons); exit;			
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$respons;
			//echo $xmlstr;
			
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
			$flag=0;			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
					$arr = $header->xpath('//msg_val'); // Should output 'something'.
					$leadid = $arr[0];
					$strings = $leadid;
					if(!empty($strings))
					{	$flag=1;
						$sales_order_no = trim(substr($strings, strpos($strings, "@ ")+1,11));
						$advance_doc = trim(substr($strings, strpos($strings, "# ")+1,11));
						
						$sqlx = "UPDATE `virtual_event_registration` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sales_order_no`='$sales_order_no',`sap_sale_order_create_status`='1' WHERE `registration_id`='$registration_id' AND event_selected='vbsm2'";
						$result = $conn ->query($sqlx);
						
						$sqly = "UPDATE `utr_history` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`first_sales_order_no`='$sales_order_no',`sap_so_status`='1',`IsDone`='1',`advance_doc`='$advance_doc' WHERE `registration_id`='$registration_id' AND id='$utr_id' AND `show` ='$show' AND event_selected='vbsm2'";
						$resulty = $conn ->query($sqly);
					}
			}
			echo $flag;	
}
?>