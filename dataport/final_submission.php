<?php
include('../header_include.php');

if(!isset($_SESSION['curruser_login_id'])) { header("location:../index.php"); exit; }
$adminID=$_SESSION['curruser_login_id'];

if(($_REQUEST['registration_id']!=''))
{
	$registration_id = intval($_REQUEST['registration_id']);
	$result = $conn ->query("update approval_master set final_submission='N' where registration_id='$registration_id'");
	if($result){
	$_SESSION['activate_msg']="Final Submission Reset Successfully";
	header('location:final_submission.php');exit;
		//echo"<meta http-equiv=refresh content=\"0;url=download_status.php\">";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dataport</title>

<!-- Main css -->
<link href="css/gjpec.css" rel="stylesheet" type="text/css" />
<!-- Main css -->
<style>
.input_submit {
    width: auto;
    height: 30px;
    background: url(../admin/images/black_btn.jpg) repeat-x;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    color: #000000;
    text-align: center;
    font-weight: bold;
    margin-bottom: 2px;
    margin-top: 5px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 0px;
    float: left;
    margin-right: 5px;
    cursor: pointer;
    border: dashed 0px #000000;
}
</style>
</head>

<body>
<!-- main -->
<div class="main">

<!-- Midle Bg -->
<div class="inner_mainwidth">

<div style="height:70px;"></div>

<!-- Midle -->
<div class="inner_midle_bgdeta">

<div style="background-color:#; text-align:center;"><a href="index.php"><img src="../images/gjepc_logo.png" width="176" height="94" /></a></div>
<div class="clear"></div>
<div class="text_heading_new">Reset Final Submission</div>
<div class="clear"></div>

<div style="margin: 0px auto;  margin-bottom:25px;">
<?php 
if($_SESSION['activate_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['activate_msg']."</span>";
$_SESSION['activate_msg']="";
}
?>
<div>
		<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
                <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
                  <tr class="orange1">
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="28%">&nbsp;</td>
                     <td>&nbsp;</td>
                  </tr>                  
                  <tr>
                    <td align="left" class="content_txt">Enter IEC Number<span class="star">*</span></td>
                    <td width="72%" align="left"><input type="text" id="iec_no" name="iec_no" placeholder="Enter IEC Number" maxlength="12"/>
                    <input type="hidden" id="action" name="action" value="save"/>
                    </td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td align="left" >&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" class="content_txt"></td>
                    <td align="left"><input type="submit" class="input_submit" id="save" name="save" value="Submit"/>                    
                    </td>
                  </tr>
                </table>
	</form>
<?php
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="save")
	{
	$iec_no = $_POST['iec_no'];
	$registration_id=getRegid($iec_no,$conn);
	$sql="select a.id,b.company_name,b.iec_no,b.region_id,d.merchant_certificate_no,d.manufacturer_certificate_no,d.membership_id ,d.download_status from registration_master a,information_master b,challan_master c,approval_master d where a.id='$registration_id' and b.registration_id='$registration_id' and c.registration_id='$registration_id' and d.registration_id='$registration_id'";
		$result = $conn ->query($sql);
		$num = $result->num_rows;
		$rows= $result->fetch_assoc();
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
                      <a href="final_submission.php?registration_id=<?php echo $registration_id; ?>" onclick="return(window.confirm('Are You sure you want to Reset.'));"><?php echo "Reset"; ?></a>                 
				 </td>
                </tr>
                <?php } else { ?>
                <tr class="orange1"></tr>
                <tr>
                  <td colspan="6">Records Not Found</td>
                </tr>
                <?php } ?>
              </table>
              <?php } ?>
</div>

</div>

<div style="height:50px;"></div>
<div class="clear"></div>
</div>
<!-- Midle -->

<div class="clear"></div>
</div>
<!-- Midle Bg -->
</div>
<!-- main -->
</body>
</html>