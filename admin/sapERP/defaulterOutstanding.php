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

			$dbconn = @mysqli_connect($hostname,$uname,$pwd);
			@mysqli_select_db($database);
			/* DB Connection End*/
			/*....................... Get Registration Id using IEC Number ................................*/
			function getRegid($bp_no)
			{
				$query_sel = "SELECT registration_id FROM `communication_address_master` WHERE c_bp_number='$bp_no' and type_of_address='2' limit 1";	
				$result_sel = mysqli_query($query_sel);								
				if($row = mysqli_fetch_array($result_sel))		 	
				{ 		
					return $row['registration_id'];
				}
			}
		
            $bp_no = $parameters->bp_no;
			$registration_id = getRegid($bp_no);
			
			$organisation_name = $parameters->organisation_name;
			$payment_defaulter = $parameters->defaulter_status;
			$payment_defaulter_outstandingamount = $parameters->outstanding_amount;
			$payment_defaulter_reason= $parameters->defaulter_reason;

			$x=$bp_no."==".$organisation_name."--".$outstanding_amount;
			
			if(!empty($registration_id))
			{
				$sqlx = "UPDATE registration_master SET";
				if($payment_defaulter!='') { $sqlx .=" payment_defaulter = '$payment_defaulter',"; }
				if($payment_defaulter_outstandingamount!='') { $sqlx .=" payment_defaulter_outstandingamount = '$payment_defaulter_outstandingamount',"; }
				if($payment_defaulter_reason!='') {	$sqlx .=" payment_defaulter_reason = '$payment_defaulter_reason'"; }
				$sqlx .=" WHERE id = '$registration_id'";
				$x = $sqlx;
						
				$update_result=mysqli_query($sqlx);
				if($update_result)
				{
					$x = "Data Successfully Updated ". mysqli_affected_rows();
				} else {
					$x = "Something error!!";
				}
			} else {
				$x = "BP No Not Match";
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
    $server = new SOAPServer('SapToWebOutstanding.wsdl', array(
        'soap_version' => SOAP_1_2,
        'style' => SOAP_RPC,
        'use' => SOAP_LITERAL,
        'classmap'=>$classmap
    ));
    $server->setObject($Service);
    //$server->setClass('Erptoweb');
    $server->handle();
	