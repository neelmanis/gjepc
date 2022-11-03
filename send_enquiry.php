<?php include 'include/header.php'; ?>
<?php if(!isset($_SESSION['USERID'])){header('location:login.php');}?>
<?php
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id=$_SESSION['USERID'];
$member_registration=mysql_query("select * from member_directory where registration_id='$registration_id'");
$member_registration_num=mysql_num_rows($member_registration);
if($member_registration_num==0){
$_SESSION['msg']="Please register first in member directory";
header('location:members_profile.php');
exit;
}
?>
<script type="text/javascript">
function validate()
{
  if(document.forms['send_enquiry']['item_interest'].value=="")
  {
  alert("Please fill your interest.");
  document.forms['send_enquiry']['item_interest'].focus();
  return false;
  }
  if(document.forms['send_enquiry']['enquiry'].value=="")
  {
	  alert("Please fill your enquiry.");
	  document.forms['send_enquiry']['enquiry'].focus();
	  return false;
  }
}
</script>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
			<h4>My Account - Members Directory - Auto Match - Send Enquiry</h4>
		</div>
	</div>

	<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
		<?php include 'include/regMenu.php'; ?>
	</div>

	<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">
		<div class="form-block minibuffer">
		<div class="sub_head">Send Enquiry</div>
<?php 
$memberid=mysql_real_escape_string($_REQUEST['memberid']);
$query=mysql_query("select * from member_directory where id='$memberid'");
$result=mysql_fetch_array($query);
?>
<form action="obmp_enquiry_inc.php" method="post" name="send_enquiry"  id="send_enquiry" onSubmit="return validate()">
<input type="hidden" name="to_uid" id="to_uid" value="<?php echo $result['registration_id'];?>"/>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="company_name">Company Name :</label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo strtoupper($result['company_name']);?>" disabled="disabled" placeholder="Company Name">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="item_interest">Contact Person :</label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo strtoupper($result['contact_person']);?>" disabled="disabled" placeholder="Contact Person">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="item_interest">Products Interested In :</label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" id="item_interest" name="item_interest" value="" placeholder="Products Interested In">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="enquiry">Enquiry Description :</label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo $company_name;?>" id="enquiry" name="enquiry" placeholder="Enquiry Description">
				</div>
			</div>
			
<input class="btn" type="submit" value="Submit" />

		</form>
	</div></div>


<?php include 'include/footer.php'; ?>