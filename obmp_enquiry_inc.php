<?php include 'include/header.php'; ?>
<?php if(!isset($_SESSION['USERID'])){header('location:login.php');}?>
<?php
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$from_uid=$_SESSION['USERID'];
$to_uid=$_POST['to_uid'];

$from_company_name=getMemberCompany($from_uid);
$to_company_name=getMemberCompany($to_uid);

$from_contact_person=getMemberContact($from_uid);
$to_contact_person=getMemberContact($to_uid);

$product_interested=$_POST['item_interest'];
$enquiry_description=$_POST['enquiry'];

$date=date("Y-m-d");
$ip_address=$_SERVER['REMOTE_ADDR'];

$sender_emailid=getUserEmail($from_uid);
$reciever_emailid=getUserEmail($to_uid);

mysql_query("insert into obmp_enquiries set from_uid='$from_uid',to_uid='$to_uid',from_company_name='$from_company_name',to_company_name='$to_company_name',from_contact_person='$from_contact_person',to_contact_person='$to_contact_person',product_interested='$product_interested',enquiry_description='$enquiry_description',enquiry_status='p',ip='$ip_address'");


/*...................................Mail To Sender .............................................*/

$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="150" align="left"><img src="http://gjepc.kwebmakeruk.com/images/logo_gjepc.png" width="150" height="91" /></td>
          <td width="85%" align="right"><img src="http://gjepc.kwebmakeruk.com/images/logo_in.png" width="105" height="91" /></td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr><td><strong>GJEPC :: BUY / SELL</strong></td></tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear '.$from_contact_person.',</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;">Thank you for using gjepc.org - buy / sell business program</td>
  </tr>
   <tr>
    <td>&nbsp; </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">This process is designed to ensure your privacy and security on gjepc.org. </td>
  </tr>
   <tr>
  <td>&nbsp; </td>
    </tr>
   
  <tr>
    <td align="left">You have successfully sent an enquiry against the following:-</td>
  </tr>
  <tr>
    <td align="left">&nbsp;   </td>
  </tr>
  
  <tr>
  <td height="22"style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Name of the company : </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">'.$to_company_name.'<br />
	Enquiry Date: '.$date.'<br />
	Enquiry: '.$enquiry_description.'</td>
  </tr>
  <tr>
    <td align="left">&nbsp;   </td>
  </tr>
  <tr>
    <td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><emNote: This is a system generated email, replies to this email id will not be responded</em></td>
  </tr>
</table>';
  
	// $to =$sender_emailid;
	 $subject = "GJEPC : BUY / SELL (Enquiry Sent)"; 
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	 $headers .= 'From:admin@gjepc.org';			
	 mail($to, $subject, $message, $headers);


/*...................................Mail To Reciever.............................................*/

  $message1='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="150" align="left"><img src="images/logo_gjepc.png" width="150" height="91" /></td>
          <td width="85%" align="right"><img src="images/logo_in.png" width="105" height="91" /></td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr><td><strong>GJEPC :: BUY / SELL</strong></td></tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear '.$to_contact_person.',</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;">Here is an enquiry for you</td>
  </tr>
   <tr>
  <td>&nbsp; </td>
    </tr>
   
  <tr>
    <td align="left">Please check the following details:-</td>
  </tr>
  <tr>
    <td align="left">&nbsp;   </td>
  </tr>
  
  <tr>
  <td height="22"style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Name of the company : </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">'.$from_company_name.'<br />
	Interest: '.$product_interested.'<br />
	Enquiry Date: '.$date.'<br />
	Enquiry: '.$enquiry_description.'</td>
  </tr>
  <tr>
    <td align="left">&nbsp;   </td>
  </tr>
  <tr>
    <td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><em>note: This is a system generated email, replies to this email id will not be   responded</em></td>
  </tr>
</table>';

     $to1 =$reciever_emailid;
	 $subject1 = "GJEPC : BUY / SELL (Enquiry Sent)"; 
	 $headers1  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	 $headers1 .= 'From:GJEPC';			
	 mail($to1, $subject1, $message1, $headers1);
	 
	 $_SESSION['msg']="Your enquiry sent successfuly";
	header('location:my_enquires.php');
?>