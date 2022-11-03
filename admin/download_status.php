<?php session_start();ob_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['registration_id']!=''))
  {

		 $download_status=$_REQUEST['download_status'];	
		 $registration_id=$_REQUEST['registration_id'];
		 if($status==0)
		 {
			mysql_query("update approval_master set download_status='$download_status',renewal_download_status='$download_status',ie_download_status='$download_status' where registration_id='$registration_id'");
		 }
		echo"<meta http-equiv=refresh content=\"0;url=membership.php?action=view\">";
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Activate Download Status ||GJEPC||</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script language="javascript">
function checkdata()
{
	if(document.getElementById('iec_no').value == '')
	{
		alert("Please enter iec number.");
		document.getElementById('iec_no').focus();
		return false;
	}
}
</script>
</head>

<body>
<?php /*?><div id="header_wrapper"><?php include("include/header.php");?></div><?php */?>


<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> >Activate Download Status</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Activate Download Status</div>
            <div class="content_details1 ">
              <?php 
			if($_SESSION['succ_msg']!=""){
						echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
						$_SESSION['succ_msg']="";
					}
			?>
              <form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
                <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
                  <tr class="orange1">
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="content_txt">Enter IEC Number<span class="star">*</span></td>
                    <td><input type="text" id="iec_no" name="iec_no"/>
                    </td>
                  </tr>
                  <tr>
                    <td><br/></td>
                  </tr>
                  <tr>
                    <td class="content_txt"></td>
                    <td><input type="submit" id="save" name="save" value="Submit"/>
                    </td>
                  </tr>
                </table>
              </form>
              <?php
	if(isset($_POST['save']))
	{
		$iec_no = $_POST['iec_no'];
		$registration_id=getRegid($iec_no);
	$sql="select a.id,b.company_name,b.iec_no,b.region_id,d.merchant_certificate_no,d.manufacturer_certificate_no,d.membership_id ,d.download_status from registration_master a,information_master b,challan_master c,approval_master d where a.id='$registration_id' and b.registration_id='$registration_id' and c.registration_id='$registration_id' and d.registration_id='$registration_id'";
		$result = mysql_query($sql);
		$num = mysql_num_rows($result);
		$rows=mysql_fetch_array($result);
		if($num>0){
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
                <tr class="orange1">
                  <td width="14%" height="30">Name</td>
                  <td width="10%">IEC NO.</td>
                  <td width="20%">Certificate No.</td>
                  <td width="22%">Membership No.</td>
                  <td width="12%">Region</td>
                  <td width="19%"></td>
                </tr>
                <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
                  <td><?php echo $rows['company_name'];?></td>
                  <td><?php echo $rows['iec_no'];?></td>
                  <td><?php if($rows['member_type_id']=="Merchant Exporter"){echo $rows['merchant_certificate_no'];}else{echo $rows['manufacturer_certificate_no'];}?></td>
                  <td><?php echo $rows['membership_id'];?></td>
                  <td ><?php echo $rows['region_id']?></td>
                  <td width="19%">
                      <a href="download_status.php?registration_id=<?php echo $registration_id; ?>&download_status=N" onclick="return(window.confirm('Are You sure to Activate Download Status.'));"><?php echo "Activate"; ?></a>                  </td>
                </tr>
                <?php } else {?>
                <tr class="orange1"></tr>
                <tr>
                  <td colspan="6">Records Not Found</td>
                </tr>
                <?php }?>
              </table>
              <?php } ?>
            </div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
