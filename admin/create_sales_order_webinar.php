<?php 
session_start();
include ("../db.inc.php");

if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);


function getRegionName($id,$conn)
{
    $query_sel = "SELECT region FROM state_master where state_code='$id'";
    $result = $conn->query($query_sel);
    $row = $result->fetch_assoc();          
        return $row['region'];      
}

if($_POST['bp_number'] !="" && $_POST['payment_id'] !="" &&  $_POST['reg_no'] !="" && $_POST['action'] =="webinar_sales_order_action" ){
    
    $reg_no = trim($_POST['reg_no']);
    $bp_no = trim($_POST['bp_number']);
    $payment_id = trim($_POST['payment_id']);
    $eventType= "Domestic"; 

    


    /*FIND PAYMEND DETAILS*/
    $payment = $conn->query("SELECT * FROM webinar_payment_history WHERE id='$payment_id'");
    $row_payment = $payment->fetch_assoc();

    $member_type = $row_payment['member_type']; 
    $webinar_id = $row_payment['webinar_id']; 

    /*
    ** GET MATERIAL NO
    */
    $sql_webinar = "SELECT * FROM webinar_master WHERE id='$webinar_id'";
    $result_webinar = $conn->query($sql_webinar);
    $row_webinar = $result_webinar->fetch_assoc();

    if($member_type =="member"){
        /*................................Get Country Code.....................................*/
        $sql_reg_data="select * from registration_master where `id` = '$reg_no'";
        $result_reg_data = $conn->query($sql_reg_data);
        $row_reg_data = $result_reg_data->fetch_assoc();
        
         $rcity=$row_reg_data['city'];

         $bpinfo = "SELECT c_bp_number,city FROM `communication_address_master` WHERE `registration_id` = '$reg_no' and type_of_address='2' limit 1";

        $bpInfoResult = $conn->query($bpinfo);

        $bpInfoRow = $bpInfoResult->fetch_assoc();

        $city = trim($bpInfoRow['city']);

        if($city=='')
            $city = trim($rcity);
        else 
            $city = trim($city);
        
        $info = "SELECT * FROM `information_master` WHERE `registration_id` = '$reg_no' limit 1";
        $infoResult = $conn ->query($info);
        $row_info = $infoResult->fetch_assoc();
        $region = $row_info['region_id'];

    }else if ($member_type =="non-member"){
        
        $sql_reg_data="select * from webinar_registration_details where `id` = '$reg_no'";
        $result_reg_data = $conn->query($sql_reg_data);
        $row_reg_data = $result_reg_data->fetch_assoc();
        $region=strtoupper(getRegionName($row_reg_data['state'],$conn));
        $city=$row_reg_data['address3'];
    }else{

        exit;
    }



    if($region=='HO-MUM (M)'){ $region=1010;}
    if($region=='RO-JAI'){ $region=1020;}
    if($region=='RO-SRT'){ $region=1030;}
    if($region=='RO-CHE'){ $region=1040;}
    if($region=='RO-DEL'){ $region=1050;}
    if($region=='RO-KOL'){ $region=1060;}

    if($region=='HO-MUM (M)'){ $businessArea = 1013; } else { $businessArea = 1000; }

    $type = $row_webinar['type'];
    if($type =="workshop" || $type =="webinar" ){
        $soapSalesUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_SOAD_PRD:CC_SOAD_Sender"; // Live
        $soapUser = "pi_admin";  //  username
        $soapPassword = "Deloitte@123"; // password
        $profit_center = "1010";
        $businessArea = 1011;
    }else{
        $soapSalesUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender";
        $soapUser = "pi_admin";  //  username
        $soapPassword = "Deloitte@123"; // password
        $businessArea = 1111;
        $profit_center = "1110";
    }
    $gl_code = "255251";
    
   
    $total_amount = trim($row_payment['Transaction_Amount']);
    $billing_bp_number=$bp_no;
    $ho_bp_number=$bp_no;
    
    $materialNo = $row_webinar['material_no'];
    $wbs_number = $row_webinar['wbs_number'];
    

 
   
    $Date = date('Ymd');
    $payment_Date =  date("Ymd", strtotime($row_payment['created_at']));
    $order_id = $row_payment['order_id'];
 if($type =="workshop" || $type =="webinar" ){
$xml_exhibition_string ='<?xml version="1.0" encoding="utf-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcsoad.com">
    <soapenv:Header/>
    <soapenv:Body>
    <gjep:MT_SOAD_IN>
    <SOAD_Header>
        <Sales_Doc>ZMEM</Sales_Doc>
        <SOrg>1000</SOrg>
        <Dis_channel>10</Dis_channel>
        <Division>20</Division>
        <sold_cust>'.$ho_bp_number.'</sold_cust>
        <ship_cust>'.$ho_bp_number.'</ship_cust>
        <po_ref>'.$order_id.'</po_ref>
        <Pay_term>0001</Pay_term>
        <order_Reason>106</order_Reason>
        <Incoterms>CFR</Incoterms>
        <Incoterm_Loc>'.$city.'</Incoterm_Loc>
    </SOAD_Header>
    <SOAD_Item>
        <Item>000010</Item>
        <Material>'.$materialNo.'</Material>
        <Order_Qty>1</Order_Qty>
        <Plant>'.$region.'</Plant>
        <Item_Category>TAD</Item_Category>
        <cond1_Lebel>ZMEM</cond1_Lebel>
        <Cond1_Val>'.$total_amount.'</Cond1_Val>
        <Cond2_Lebel>ZADM</Cond2_Lebel>
        <Cond2_Val></Cond2_Val>
        <Incoterms>CFR</Incoterms>
        <Incoterms_Loc>'.$city.'</Incoterms_Loc>
    </SOAD_Item>
    <SO_Advance>
        <Doc_date>'.$Date.'</Doc_date>
        <Posting_date>'.$payment_Date.'</Posting_date>
        <Company_code>1000</Company_code>
        <Currency>INR</Currency>
        <Account>'.$ho_bp_number.'</Account>
        <Sp_gl_indicator>A</Sp_gl_indicator>
        <Doc_text>SK</Doc_text>
        <Bank_Acc_No>'.$gl_code.'</Bank_Acc_No>
        <Bus_area>'.$businessArea.'</Bus_area>
        <Amount>'.$total_amount.'</Amount>
        <Profit_centre>'.$profit_center.'</Profit_centre>
        <Assignment></Assignment>
        <Sales_Doc></Sales_Doc>
        <Line_item>10</Line_item>
    </SO_Advance>
    </gjep:MT_SOAD_IN>
    </soapenv:Body>
    </soapenv:Envelope>';
}else{
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
                    <sold_cust>'.$ho_bp_number.'</sold_cust>
                    <ship_cust>'.$ho_bp_number.'</ship_cust>
                    <po_ref>'.$order_id.'</po_ref>
                    <Pay_term>0001</Pay_term>
                    <order_Reason>112</order_Reason>
                    <Incoterms>CFR</Incoterms>
                    <Incoterm_Loc>'.$city.'</Incoterm_Loc>
                    <Event_Type>D</Event_Type>
                </SOAD_Header>
                <SOAD_Item>
                    <Item>0010</Item>
                    <Material>'.$materialNo.'</Material>
                    <Order_Qty>1</Order_Qty>
                    <Plant>1110</Plant>
                    <Item_Category>TAD</Item_Category>
                    <cond1_Lebel>ZREG</cond1_Lebel>
                    <Cond1_Val>'.$total_amount.'</Cond1_Val>          
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
                    <WBS>'.trim($wbs_number).'</WBS>
                    <Incoterms>CFR</Incoterms>
                    <Incoterms_Loc>'.$city.'</Incoterms_Loc>
                    <Net_weight>1</Net_weight>
                    <Gross_Weight>1</Gross_Weight>
                 </SOAD_Item>
                 <SOAD_Advance>
                    <Doc_date>'.$Date.'</Doc_date>
                    <Posting_date>'.$payment_Date.'</Posting_date>
                    <Company_code>1000</Company_code>
                    <Currency>INR</Currency>
                    <WBS>'.trim($wbs_number).'</WBS>
                    <Account>'.$ho_bp_number.'</Account>
                    <Sp_gl_indicator>A</Sp_gl_indicator>
                    <Doc_text>SK</Doc_text>
                    <Bank_Acc_No>'.$gl_code.'</Bank_Acc_No>
                    <Bus_area>'.$businessArea.'</Bus_area>
                    <Amount>'.$total_amount.'</Amount>
                    <Profit_centre>'.$profit_center.'</Profit_centre>
                    <Assignment></Assignment>
                    <Sales_Doc></Sales_Doc>
                    <Line_item>10</Line_item>
                </SOAD_Advance>
              </gjep:MT_Exhibition_IN>
           </soapenv:Body>
        </soapenv:Envelope>';
}
        // header ("Content-Type:text/xml");
        // echo $xml_exhibition_string; exit;
    
    
        $headers1 = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_exhibition_string),
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
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_exhibition_string); // the SOAP request
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);

            // converting
            $response = curl_exec($ch1); 
            //echo $response; exit;
            if(curl_errno($ch1))
                print curl_error($ch1);
            else
                curl_close($ch1);
                
            $xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$response;
             // echo $xmlstr;exit;
            
            $xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
            $xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
            $flag=0;      
            
            
            foreach($xml->xpath('//soapenv:Body') as $header)
            {
                    $arr = $header->xpath('//msg_val'); // Should output 'something'.
                    $leadid = $arr[0];
                    $strings = $leadid;
                    if(!empty($strings))
                    {  
                        $flag=1;
                        $date_time = date("Y-m-d H:i:s");
                        $sales_order_no=substr($strings, strpos($strings, "@ ")+1,11);
                        $advance_doc = trim(substr($strings, strpos($strings, "# ")+1,11));

                          $update_so = "UPDATE webinar_payment_history SET sap_sale_order_create_status='1',sap_push_date='$date_time',sap_push_admin='$adminID',sales_order_no='$sales_order_no',advance_doc='$advance_doc' WHERE id='$payment_id'";
                        $result_update_so=$conn->query($update_so);
                        if($result_update_so){
                             echo json_encode(array("status"=>"Success")); exit;
                        }else{
                             echo json_encode(array("status"=>"failed update")); exit;
                        }
                    }
            }
            
            echo $flag; 
     }else{
     echo json_encode(array("status"=>"invalid Request")); exit;
     }

?>