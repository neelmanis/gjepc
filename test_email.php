<?php 
   include('functions.php');
    $message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="https://gjepc.org/images/gjepc_logon.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		
		</td>		
		</tr>
		</table>
		</td>		
		</tr>
	</table>'; 
	 $to ="santosh@kwebmaker.com";
	 $cc ="rohit@kwebmaker.com";
	 $subject = "Trade Application";
	
	 send_mail($to, $subject, $message, $cc);

?>