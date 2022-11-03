<?php

 $to ="santosh@kwebmaker.com";
 $message = "testmail";
	 $subject = "Password of GJEPC Member"; 
	 $headers  = 'MIME-Version: 1.0'."\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
	 $headers .= 'From: admin@gjepc.org';			
    $test =  @mail($to, $subject, $message, $headers);
 if($test){
 	echo "send";
 }else{
 echo "not send";
}
    ?>