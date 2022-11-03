<?php
    $soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_PARTIAL_ADVANCE:CC_PARTIAL_ADVANCE_Sender"; // Development
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
    $xml_exhibition_string ="";
	$xml_exhibition_string ='<?xml version="1.0" encoding="utf-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://GJEPC_PARTIAL_ADVANCE.com">
    <soapenv:Header/>
        <soapenv:Body>
            <gjep:MT_PADV_IN>
             <SO_Advance>
                <Doc_date>20200508</Doc_date>
                <Posting_date>20200508</Posting_date>
                <Company_code>1000</Company_code>
                <Currency>INR</Currency>
                <customer_no>8036259</customer_no>
                <event_type>D</event_type>
                <wbs_element>DE-010</wbs_element>
                <Sp_gl_indicator>A</Sp_gl_indicator>
                <Doc_Type>DZ</Doc_Type>
                <Doc_text>Partial_domestic</Doc_text>
                <Bank_Acc_No>255301</Bank_Acc_No>
                <Bus_area>1111</Bus_area>
                <Amount>90000</Amount>
                <Profit_centre>1110</Profit_centre>
                <cheque_No></cheque_No>
                <Assignment>3300000409</Assignment>
                <Sales_Doc></Sales_Doc>
                <Line_item>10</Line_item>
             </SO_Advance>
            </gjep:MT_PADV_IN>
        </soapenv:Body>
    </soapenv:Envelope>';

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
            //echo $respons;
            if(curl_errno($ch1))
                print curl_error($ch1);
            else
                curl_close($ch1);

            // print to get response print_r($response);
            var_dump($respons); exit;     
    ?>