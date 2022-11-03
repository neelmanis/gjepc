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
			$uname = "appadmin";
			$pwd = "#21SAq109@65%n";
			$database = "gjepc_kp";

			$conn = @mysqli_connect($hostname,$uname,$pwd,$database);
			// Check connection
			if (mysqli_connect_errno($conn))
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();exit;
			}
			
			/* DB Connection End*/
			/*....................... Get Registration Id using IEC Number ................................*/
            $invoice_number = $parameters->invoice_number;
            $invoice_date = $parameters->invoice_date;
			$receipt_number = $parameters->receipt_number;
			$receipt_date = $parameters->receipt_date;
			$sales_order_number = trim($parameters->sales_order_number);
			$delivery_number = $parameters->delivery_number;
			$order_reason = $parameters->order_reason;
			$odn = $parameters->odn;
			$exchnage_rate = $parameters->exchnage_rate;
			
			$kp_fee = $parameters->kp_fee;
			$courier_charges = $parameters->courier_charges;
			$carat_price = $parameters->carat_price;
			$net_price = $parameters->net_price;
			$cgst = $parameters->cgst;
			$sgst = $parameters->sgst;
			$igst = $parameters->igst;
			$invoice_status = $parameters->invoice_status;
			$gstn = $parameters->gstn;
			$advol_exchange_rate = trim($parameters->advol_exchange_rate);
			$advol_amount = trim($parameters->advol_amount);
			
		  //echo $x=$invoice_number."==".$invoice_date."==".$receipt_number."--".$receipt_date."==".$sales_order_number."==".$delivery_number."==".$order_reason."==".$odn;exit;
			$num=mysqli_num_rows(mysqli_query($conn,"select * from kp_payment_master where SO_NUMBER like '%$sales_order_number%'"));
			if($num>0){
				if(!empty($sales_order_number))
				{
					$sqlx = "UPDATE kp_payment_master SET INVOICE_GENERATE_STATUS='1',INVOICE_NUMBER = '$invoice_number', INVOICE_DATE = '$invoice_date',RECEIPT_NUMBER = '$receipt_number', RECEIPT_DATE = '$receipt_date',	DELIVERY_NUMBER = '$delivery_number',ORDER_REASON = '$order_reason', ODN = '$odn',KP_FEE='$kp_fee',EXHCHNAGE_RATE='$exchnage_rate',COURIER_CHARGES='$courier_charges',CARAT_PRICE='$carat_price',NET_PRICE='$net_price',CGST='$cgst',SGST='$sgst',IGST='$igst',KP_INVOICE_STATUS='$invoice_status',GSTN='$gstn',advol_exchange_rate='$advol_exchange_rate',advol_amount='$advol_amount' WHERE SO_NUMBER like '%$sales_order_number%'";
					$x = $sqlx;		
					//exit;	
					$update_result=mysqli_query($conn,$sqlx);
					if($update_result)
					{
						$x = "Data Successfully Updated ". mysqli_affected_rows();
					} else {
						$x = "Something error!!";
					}
					
				} else {
					$x = "SO No Not Found";
				}
			} else {
				$x = "Sales order does not exist on web.";
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
	