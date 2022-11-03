<?php
$qaddress=mysql_query("select address1,address2,city,pincode,country,mobile_no,email_id from communication_address_master where registration_id='".$row[0]."'");
				$raddress=mysql_fetch_array($qaddress);
while($raddress=mysql_fetch_array($qaddress)){
				//fwrite($fh,getaddresstype($raddress['type_of_address']));
				$num1 = mysql_num_fields($qaddress) ;
				if($raddress['type_of_address']=='2')
				{
						for($i = 0; $i<$num1; $i++) {
						 fwrite($fh, $raddress[$i]);
						 fwrite($fh, "|");
						}
				}
				else{for($i = 0; $i<$num1; $i++) {fwrite($fh, "|");}}
				if($raddress['type_of_address']=='6')
				{
						for($i = 0; $i<$num1; $i++) {
						 fwrite($fh, $raddress[$i]);
						 fwrite($fh, "|");
						}
				}
				else{for($i = 0; $i<$num1; $i++) {fwrite($fh, "|");}}
				if($raddress['type_of_address']=='3')
				{
						for($i = 0; $i<$num1; $i++) {
						 fwrite($fh, $raddress[$i]);
						 fwrite($fh, "|");
						}
				}
				else{for($i = 0; $i<$num1; $i++) {fwrite($fh, "|");}}
			 }