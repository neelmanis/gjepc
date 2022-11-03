<?php
include 'include/header.php'; 
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id = intval(filter($_SESSION['USERID']));
$info_status=mysql_query("select status from information_master where registration_id='$registration_id' and status=1");
$info_num=mysql_num_rows($info_status);

$comm_status=mysql_query("select status from communication_details_master where registration_id='$registration_id' and status=1");
$comm_num=mysql_num_rows($comm_status);

$chln_status=mysql_query("select status from challan_master where registration_id='$registration_id' and status=1");
$chln_num=mysql_num_rows($chln_status);

if($info_num==0 && $comm_num==0 && $chln_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
$_SESSION['form_chk_msg1']="Please first fill Communication form";
$_SESSION['form_chk_msg2']="Please first fill challan form";
header('location:information_form.php');
}

if($comm_num==0 && $chln_num==0)
{ 
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:communication_form.php');
}
if($chln_num==0)
{	
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:challan_form.php');
}
?>

<?php
$action=$_REQUEST['action'];
if($action=="upload")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$scan_copy = '';
	$target_folder = 'scan_copy/';
	$temp_code = rand();
	$file_name = $_FILES['scan_copy']['name'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name) || preg_match("/.PhP/i", $file_name)){
    		$_SESSION['upload_error'] = "Invalid File Upload";
	} elseif($file_name != '')
	{ 
	  //Unlink the previuos image
	   $qpreviousimg=mysql_query("select challan_scanned_copy from challan_master where registration_id='$registration_id'");
	   $rpreviousimg=mysql_fetch_array($qpreviousimg);
	   $filename="scan_copy/".$rpreviousimg['challan_scanned_copy'];
	   unlink($filename);
	
	if(($_FILES["scan_copy"]["type"] == "image/jpeg") || ($_FILES["scan_copy"]["type"] == "image/jpg") || ($_FILES["scan_copy"]["type"] == "image/png")  && $_FILES['scan_copy']['size'] < 2097152 && getimagesize($_FILES['signature_slip']['tmp_name']))
		{
			$target_path = $target_folder.$temp_code.'_'.$file_name;
			if(@move_uploaded_file($_FILES['scan_copy']['tmp_name'], $target_path))
			{
				 $scan_copy = $temp_code.'_'.$file_name;
				 $sql="update challan_master set challan_scanned_copy='$scan_copy' where registration_id='$registration_id'";
				 $result=mysql_query($sql);
				 $userinfo= mysql_query("select * from  information_master where registration_id='$registration_id'");
				 $user_result=mysql_fetch_array($userinfo);
				 $company_name	=	filter($user_result['company_name']);
				 $iec_number	=	filter($user_result['iec_no']);
				 $email_id		=	filter($user_result['email_id']);
				 $name			=	filter($user_result['name']);
				/*..........................Send Email To Admin.................................*/
				
		$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
	  <tr>
		<td colspan="2"> 
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="150" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="91" /></td>
			</tr>
		  </table>    </td>
	  </tr>
	  <tr>
		<td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
	  </tr>
	  <tr>
		<td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear admin,</td>
	  </tr>
	  <tr>
		<td align="left" style="text-align:justify;"> A scanned copy of the challan form has been uploaded on the website.</td>
	  </tr>
	   <tr>
		<td>&nbsp; </td>
		</tr>
	  <tr>
		<td align="left"  style="text-align:justify;"> Kindly find the details of the user below:</td>
	  </tr>
	   <tr>
	  <td>&nbsp; </td>
		</tr>
		 <tr>
	  <td height="22"style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Name of the company : </td>
		</tr>
	  <tr>
		<td align="left"  style="text-align:justify;">'.$company_name.' <br />
	IEC number: '.$iec_no.'<br />
	E-mail: '.$email_id.'</td>
	  </tr>
	   <tr>
		<td>&nbsp; </td>
		</tr>
	  <tr>
		<td align="left">Visit the admin panel to take the necessary actions on the same.</td>
	  </tr>
	  <tr>
		<td align="left">&nbsp;</td>
	  </tr>
	  <tr>
		<td height="22" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
	  </tr>
	  <tr>
		<td align="left"><strong>GJEPC Web Team,</strong></td>
	  </tr>
	</table>';
				
		$region=getRegion($registration_id);
		if($region=='HO-MUM (M)'){$to='mithun@gjepcindia.com,archana@gjepcindia.com,hari@gjepcindia.com';}
		if($region=='RO-CHE'){$to='venugopal@gjepcindia.com';}
		if($region=='RO-DEL'){$to='madaan@gjepcindia.com';}
		if($region=='RO-JAI'){$to='sasi@gjepcindia.com';}
		if($region=='RO-KOL'){$to='salim@gjepcindia.com';}
		if($region=='RO-SRT'){$to='salim@gjepcindia.com';}
		 $subject = "Challan Form Uploaded"; 
		 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
		 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		 $headers .= 'From:admin@gjepc.org';			
		 /*mail($to, $subject, $message, $headers);*/
		}
		else
		{
			$_SESSION['upload_error']="Sorry image could not be upload";
			return;
		}
		}
		else
		 {
			$_SESSION['upload_error']="Sorry you have select Invalid file";
		 }	
	}
	} else {
	 $_SESSION['upload_error']="Invalid Token Error";
	}
 }
?>

<section>
	<div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>        
    </div>
	<div class="container inner_container">
		<div class="row mb">
            <div class="col-12">
            	<div class="title inner_title"><h1>My Account - Upload Challan Scanned Copy</h1></div>
            </div>

            <div class="col-lg-3 col-md-4 order-sm-12" data-sticky_parent>
                <?php include 'include/regMenu.php'; ?>
            </div>

            <div class="col-lg-9 col-md-8 col-sm-12 order-sm-1">
                	
					<?php 
                    $qscan=mysql_query("select challan_scanned_copy from challan_master where registration_id='$registration_id'");
                    $rscan=mysql_fetch_array($qscan);
                    ?>
                    <div class="d-flex upload_img"> 
                    <?php if($rscan['challan_scanned_copy']!=""){?>
                    <div> <img id="preview" src="scan_copy/<?php echo $rscan['challan_scanned_copy'];?>" class="img-responsive"> </div>
                    <?php } else {?>
                    <div><img id="preview" src="images/upload_img.jpg" class="img-responsive"></div>
                    <?php } ?>
                    
                    <div class="ml-4">
                    	<p>Please note</p>
                        <p>The Stamped copy of the Challan after payment in the Bank should be uploaded and only the same will be considered by Council.</p>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" class="row">
                        <input type="hidden" name="action" value="upload"/>
                        <?php token(); ?>
                        <div class="d-flex"> 
                        <input type="file" name="scan_copy" id="scan_copy" accept=".jpg,.jpeg,.png" style="display:none;">
                        <div class="mr-3">
                        <input type="button" class="form-control" name="fakeFileBtn" onclick="jQuery('#scan_copy').click();" id="fakeFileBtn" value="Select File"></div>
                        <div>
                        <button type="submit" class="cta fade_anim" value="Upload">Upload</button>
                        <span><?php echo $_SESSION['upload_error'];$_SESSION['upload_error']="";?></span>
                        </div>
                        </div>
                        </form>
                    </div>                    
                    </div>
            </div>    
    	</div>	
    </div>
</section>  
<?php include 'include/footer.php'; ?>