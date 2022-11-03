<?php
session_start();
ob_start();
include('db.inc.php');
$user_name = $_SESSION['username'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

 $today_date=date('m/d');
$query = "select * from employee_details where 1";
$result = mysql_query($query);
$i=1;
while($row = mysql_fetch_array($result))
{	
	
	 $birth_date=$row['dob'];
	 $birth_date=strtotime($birth_date);
	 //echo $birth_date=date('Y/m/d',$birth_date);
	 $birth_date=date('m/d',$birth_date);
	 if($today_date==$birth_date)
	 {
	 	echo $i;
 echo $message ='<table width="70%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">

<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fbfbfb" cellpadding="0" cellspacing="0">
    
    <tr>
    <td width="33%"  align="left" valign="top"><a href="http://www.iijs.org/" target="_blank"><img src="http://iijs.org/mailers/embassy/gjepc_logo.png" border="0" usemap="#Map2" width="180"/></a></td>
   <!-- <td width="33%" align="center">&nbsp;</td>
    <td width="33%"  align="right" valign="top"><a href="http://www.gjepc.org/index.php" target="_blank"><img src="http://iijs.org/mailers/embassy/gjepc_logo.png" /></a></td>
    </tr>-->
    
    
    <tr>
    <td colspan="2">&nbsp;</td>
    <td align="right">&nbsp;</td>
    </tr>
    
    <tr>
    <td align="right" colspan="3" height="30"><hr /></td>
    </tr>
    
    
    
    <tr>
    <td align="right" colspan="3" height="10"></td>
    </tr>
    
    
    
    <tr>
    <td colspan="3" style="font-size:13px; line-height:22px;">
   
   <p style="font-weight:bold; color:#D1A3C9; font-size:15px;">Dear '.$row['employee_name'].', </p>
  
   <p style="font-weight:bold; color:#D1A3C9; font-size:15px; ">May Your Birthday be Filled with Sunshine and Smiles,Laughter,Love and Cheer. </p>
   <p style="font-weight:bold; color:#D1A3C9; font-size:15px;">Happy Birthday . </p><br/>
   <img src="http://theartisan.kwebmakeruk.com/images/album/birthday_candles.png" style="width:600px; height:300px;" />
  
  
  
    
    
    <p></p>          
<p style="color:#D1A3C9;"><strong>Warm Regards,</strong><br />
  GJEPC Team<br />
  </tr>
  
   <tr>
   <!-- <td width="33%"  align="left" valign="top"><a href="http://www.iijs.org/" target="_blank"><img src="http://iijs.org/mailers/embassy/gjepc_logo.png" border="0" usemap="#Map2" width="180"/></a></td>
    <td width="33%" align="center">&nbsp;</td>-->
    <!--<td width="33%"  align="right" valign="top"><a href="http://www.gjepc.org/index.php" target="_blank"><img src="http://iijs.org/mailers/embassy/gjepc_logo.png" /></a></td>-->
    </tr>

</table>';
	
	
	$email=$row['email'];
 $to=$email;
		  $subject = "BirthDay Notification:"; 
		// $subject = "FB2 : Registration ".$count." : ".$date." : ".$todaycount." : ".$name; 
		 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
		 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		 $headers .= 'From:ajit@kwebmaker.com';
			 if($email!="")
			 {			
				mail($to,$subject,$message,$headers);
				$i++;
				
			 }
		 }
	}
?>
</body>
</html>