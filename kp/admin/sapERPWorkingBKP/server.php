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

			$dbconn = @mysql_connect($hostname,$uname,$pwd);
			@mysql_select_db($database);
			/* DB Connection End*/
			/*....................... Get Registration Id using IEC Number ................................*/
			function getRegid($pan_no,$bp_no)
			{
				//$query_sel = "SELECT registration_id FROM information_master where pan_no='$pan_no'";	
				$query_sel = "SELECT registration_id FROM `communication_address_master` WHERE pan_no='$pan_no' AND c_bp_number='$bp_no' and type_of_address='2' limit 1";	
				$result_sel = mysql_query($query_sel);								
				if($row = mysql_fetch_array($result_sel))		 	
				{ 		
					return $row['registration_id'];
				}
			}
			
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
			$registration_id = getRegid($pan_no,$bp_no);
			
			$x=$pan_no."==".$bp_no."==".$rcmc_certificate_issue_date."--".$registration_id;
			
			if(!empty($registration_id))
			{
				/*$sqlx = "UPDATE approval_master SET rcmc_certificate_issue_date = '$rcmc_certificate_issue_date', rcmc_certificate_expire_date = '$rcmc_certificate_expire_date',
						merchant_certificate_no = '$merchant_certificate_no', manufacturer_certificate_no = '$manufacturer_certificate_no',
						membership_issued_dt = '$membership_issued_dt',	membership_renewal_dt = '$membership_renewal_dt',
						membership_id = '$membership_id', membership_issued_certificate_dt = '$membership_issued_certificate_dt',
						membership_certificate_type = '$membership_certificate_type', invoice_no = '$invoice_no',
						invoice_date = '$invoice_date', receipt_no = '$receipt_no', receipt_date = '$receipt_date' WHERE registration_id = '$registration_id'"; */
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
						
				$update_result=mysql_query($sqlx);
				if($update_result)
				{
					$x = "Data Successfully Updated ". mysql_affected_rows();
				} else {
					$x = "Something error!!";
				}
				
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
	