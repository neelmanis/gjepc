<?php
    ini_set("soap.wsdl_cache_enabled", "0");
	//echo "hieee";exit;
    class Server{

        protected $class_name = '';

        public function __construct($class_name)
        {
            $this->class_name = $class_name;
        }
        public function AuthHeader($Header)
        {
            //if($Header->username == 'foo' && $Header->password == 'bar')
            //   $this->authenticated = true;
        }

        public function log($method_name,$data)
        {
            $filename = 'log.txt';
            $handle = fopen($filename, 'a+');
            fwrite($handle, date("l dS of F Y h:i:s A").' - '.$_SERVER['REMOTE_ADDR']."\r\n".$method_name."\r\n".print_r($data,true));
            fclose($handle);
        }

        public function __call($method_name, $parameters)
        {
            $this->log($method_name,$parameters); //  log
            //if($arguments[0]!=AUTH) return 'Authorization required'; // auth check
            if(!method_exists($this->class_name, $method_name )) return 'Method '.$method_name.' not found'; // methot exist check
            return call_user_func_array(array($this->class_name, $method_name ), $parameters); //call method
        }
    }


    class Erptoweb {
	
        public function Average ($parameters)
        {	
			/* DB Connection Start*/
			$hostname = "localhost";
			$uname = "gjepcliveuserdb";
			$pwd = "KGj&6(pcvmLk5";
			$database = "gjepclivedatabase";

			$conn = new mysqli($hostname, $uname, $pwd, $database);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} else {
				//echo "connected";
			}			
			/* DB Connection End*/
			
			/*....................... Get Registration Id using IEC Number ................................*/
			function getRegid($pan_no,$bp_no,$conn)
			{
				$query_sel = "SELECT registration_id FROM `communication_address_master` WHERE pan_no='$pan_no' AND c_bp_number='$bp_no' and type_of_address='2' limit 1";	
				$result = $conn->query($query_sel);
				$row = $result->fetch_assoc();		
					return $row['registration_id'];
			}
			
			function getUserMobile($id,$conn)
			{
				$query_sel = "SELECT mobile_no FROM registration_master where id='$id'";	
				$result = $conn->query($query_sel);
				$row = $result->fetch_assoc(); 		
					return $row['mobile_no'];
			}
			
			function sendOPTIN($mobile)
			{
				$mobile = trim($mobile);
				$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=OPT_IN&format=json&userid=2000193706&password=dCtjkxnX&phone_number=".$mobile;
				$url.="&v=1.1&auth_scheme=plain&channel=WHATSAPP";
				
				//$headers = array("Content-Type: application/json");
							 
				$curl = curl_init();
				$timeout = 5;
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
				
				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);
				
				if($err) {
				 echo "cURL Error #:" . $err;
				} else {
					//header('Content-type: application/json');
					return $response;
				// echo $response;
				}
			}
			
			function sendMsg($memberMobile,$registration_id)
			{
				$memberMobile = trim($memberMobile);
				$$registration_id = trim($registration_id);
				$fy = "2022-23";
				$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$memberMobile."&v=1.1&auth_scheme=plain&msg_type=TEXT";
			
				$url.="&msg=Dear%20Sir%2C%0AThank%20you%20for%20renewing%20your%20Membership%20for%20the%20year%20".$fy.".%20Please%20click%20here%20for%20Invoice%20%26%20Membership%20certificate%20%20%20https%3A%2F%2Fgjepc.org%2Frcmc%2Fmembership.php%3Fregistration_id%3D".$registration_id."%20%20%20also%20note%20that%20Membership%20Certificate%20and%20invoice%20will%20also%20available%20on%20your%20dashboard%20for%20your%20records%20%0A%20%0ARegards%2C%0ATeam%20Membership%20GJEPC"; 
				//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";
					 
				$curl = curl_init();
				$timeout = 5;
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
				
				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);
				
				if($err) {
				 echo "cURL Error #:" . $err;
				} else {
					//header('Content-type: application/json');
					return $response;
				// echo $response;
				}
			}
			
			$financial_year = 2022;
			
            //$iec_no = $parameters->iec_no;
            $pan_no = $parameters->pan_no;
            $bp_no = $parameters->bp_no;
			$rcmc_certificate_issue_date = $parameters->rcmc_certificate_issue_date;
			$rcmc_certificate_issue_date = $parameters->rcmc_certificate_issue_date;
			$rcmc_certificate_expire_date = $parameters->rcmc_certificate_expire_date;
			$merchant_certificate_no = $parameters->merchant_certificate_no;
			$manufacturer_certificate_no = $parameters->manufacturer_certificate_no;
			$membership_issued_dt = $parameters->embership_issued_dt;
			$membership_renewal_dt = $parameters->membership_renewal_dt;
			$membership_id = $parameters->mbership_id;
			$membership_issued_certificate_dt = $parameters->membership_issued_certificate_dt;
			$membership_certificate_type = $parameters->membership_certificate_type;
			$invoice_no = $parameters->invoice_no;
			$invoice_date = $parameters->invoice_date;
			$receipt_no = $parameters->receipt_no;
			$receipt_date = $parameters->receipt_date;
			$qr_code = $parameters->qr_code;
			$irn = $parameters->irn;
			$registration_id = getRegid($pan_no,$bp_no,$conn);
			
			$x=$pan_no."==".$bp_no."==".$rcmc_certificate_issue_date."--".$registration_id;
			
			if(!empty($registration_id))
			{
				$check = "select * from approval_master where registration_id = '$registration_id' AND eligible_for_renewal='Y'";
				$queryResult  = $conn->query($check);
				$numCheck = $queryResult->num_rows;
				if($numCheck>0){
				$sqlx = "UPDATE approval_master SET";
				if($rcmc_certificate_issue_date!='') {	$sqlx .=" rcmc_certificate_issue_date = '$rcmc_certificate_issue_date',"; }
				if($rcmc_certificate_expire_date!='') {	$sqlx .=" rcmc_certificate_expire_date = '$rcmc_certificate_expire_date',"; }
				if($merchant_certificate_no!='') {	$sqlx .=" merchant_certificate_no = '$merchant_certificate_no',"; }
				if($manufacturer_certificate_no!='') {	$sqlx .=" manufacturer_certificate_no = '$manufacturer_certificate_no',"; }
				if($membership_issued_dt!='') {	$sqlx .=" membership_issued_dt = '$membership_issued_dt',"; }
				if($membership_renewal_dt!='') {	$sqlx .=" membership_renewal_dt = '$membership_renewal_dt',"; }
				if($membership_id!='') {	$sqlx .=" membership_id = '$membership_id',"; }
				if($membership_issued_certificate_dt!='') {	$sqlx .=" membership_issued_certificate_dt = '$membership_issued_certificate_dt',"; }
				if($membership_certificate_type!='') {	$sqlx .=" membership_certificate_type = '$membership_certificate_type',"; }
				if($invoice_no!='') {	$sqlx .=" invoice_no = '$invoice_no',"; }
				if($invoice_date!='') {	$sqlx .=" invoice_date = '$invoice_date',"; }
				if($receipt_no!='') {	$sqlx .=" receipt_no = '$receipt_no',"; }
				if($receipt_date!='') {	$sqlx .=" receipt_date = '$receipt_date'"; }
				$sqlx .=" WHERE registration_id = '$registration_id'";
				$x = $sqlx;
				
				} else {
				/* stop rcmc for new Member */	
				$sqlx = "UPDATE approval_master SET";
				if($membership_issued_dt!='') {	$sqlx .=" membership_issued_dt = '$membership_issued_dt',"; }
				if($membership_renewal_dt!='') {	$sqlx .=" membership_renewal_dt = '$membership_renewal_dt',"; }
				if($membership_id!='') {	$sqlx .=" membership_id = '$membership_id',"; }
				if($membership_issued_certificate_dt!='') {	$sqlx .=" membership_issued_certificate_dt = '$membership_issued_certificate_dt',"; }
				if($membership_certificate_type!='') {	$sqlx .=" membership_certificate_type = '$membership_certificate_type',"; }
				if($invoice_no!='') {	$sqlx .=" invoice_no = '$invoice_no',"; }
				if($invoice_date!='') {	$sqlx .=" invoice_date = '$invoice_date',"; }
				if($receipt_no!='') {	$sqlx .=" receipt_no = '$receipt_no',"; }
				if($receipt_date!='') {	$sqlx .=" receipt_date = '$receipt_date'"; }
				$sqlx .=" WHERE registration_id = '$registration_id'";
				$x = $sqlx;						
				}
						
				$update_result = $conn ->query($sqlx);
				if($update_result)
				{
					$x = "Data Successfully Updated ". mysqli_affected_rows();
				} else {
					$x = "Something error!!";
				}
				
				$challan = "UPDATE challan_master SET qr_code = '$qr_code',irn = '$irn' WHERE registration_id = '$registration_id' AND challan_financial_year='$financial_year'";
				$update_challan = $conn ->query($challan);
				
				/* Send WhatsApp Msg Start */				
				/* First optin API After that Msg API */
			//	$memberMobile = getUserMobile($registration_id,$conn);
			/*	$memberMobile = "+919619662253";
				$apiurl = sendOPTIN($memberMobile);
				$getResult = json_decode($apiurl,true);
				if($getResult['response']['status']=="success")
				{
					foreach($getResult['data'] as $value)
					{
						$code = $value[0]['id'];
						$msg  = $value[0]['details'];
						$phone = $value[0]['phone'];
						
						$msgurl = sendMsg($memberMobile,$registration_id);
						$getResults = json_decode($msgurl,true);
						if($getResults['response']['status']=="success")
						{
							//echo $getResults['response']['status'];
						} else { 
							//echo $getResults['response']['details'];
						}		
					}
					
				} else { 
					echo "Failed ! Message Not Sent";
				}  */
				/* Send WhatsApp Msg End */
				
			} else {
				$x = "PAN & BP No Not Match";
			}
			
			return self::AverageResponse($x);
        }

        public function AverageResponse ($message)
        {
            return ['Result' => $message];
        }
    }

    class in {

    }

    $Service = new Server('Erptoweb');
	
    $classmap=[
        'in' => 'in'
    ];
    $server = new SOAPServer('erptoweb.wsdl', array(
        'soap_version' => SOAP_1_2,
        'style' => SOAP_RPC,
        'use' => SOAP_LITERAL,
        'classmap'=>$classmap
    ));
    $server->setObject($Service);
    //$server->setClass('Erptoweb');
    $server->handle();
	