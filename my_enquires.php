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
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
			<h4>My Account - Members Directory - My Enquires</h4>
		</div>
	</div>

	<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
		<?php include 'include/regMenu.php'; ?>
	</div>
<?php 
if($_SESSION['msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['msg']."</span>";
$_SESSION['msg']="";
}
?>
	<div class="col-md-8 col-sm-8 col-xs-12  speakerSelector">
		<div class="sub_head minibuffer">My Enquires</div>
		
		<div class="col-md-12 nopadding tabHeaders">
			<div class="col-md-6 tabHead tabactive" onclick="showTabDiv('th1')">Send Enquiry</div>
			<div class="col-md-6 tabHead" onclick="showTabDiv('th2')">Received Enquiry</div>
		</div>
		<div class="col-md-12 nopadding tabContainers">
			<div class="rows">
				<div class="col-md-12 tabCont  nopadding" id="th1">
					<table class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Company Name</th>
								<th>Date and Time</th>
								<th>Description</th>
								<th>Contact Person</th>
								<th>Products Interested In</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						/*............................Send Enquiry....................................*/
					   $i=1;
					   $sendenquiry=mysql_query("select * from obmp_enquiries where from_uid='$registration_id'");
					   $num_enquiry=mysql_num_rows($sendenquiry);
					   if($num_enquiry>0){					   
					   while($rsendenquiry=mysql_fetch_array($sendenquiry)){
					   ?>
							<tr>
								<td data-type="No"><?php echo $i;?></td>
								<td data-type="Company Name"><?php echo stripslashes($rsendenquiry['from_company_name']);?></td>
								<td data-type="Date and Time"><?php echo $rsendenquiry['created'];?></td>
								<td data-type="Description"><?php echo stripslashes($rsendenquiry['enquiry_description']);?></td>
								<td data-type="Contact Person"><?php echo stripslashes($rsendenquiry['from_contact_person']);?></td>
								<td data-type="Products Interested In"><?php echo stripslashes($rsendenquiry['product_interested']);?></td>
							</tr>
							<?php $i++;}} else { ?>
							<tr><td colspan="6">No record found</td></tr>
							<?php }?>
						</tbody>
					</table>					
				</div>
				<div class="col-md-12 tabCont nopadding" id="th2">
					<table class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Company Name</th>
								<th>Date and Time</th>
								<th>Description</th>
								<th>Contact Person</th>
								<th>Products Interested In</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							/*............................Recieved Enquiry....................................*/
						   $j=1;
						   $rec_enquiry=mysql_query("select * from obmp_enquiries where to_uid='$registration_id'");
						   $num_rec_enquiry=mysql_num_rows($rec_enquiry);
						   if($num_rec_enquiry>0){
						   while($result_rec_enquiry=mysql_fetch_array($rec_enquiry)){
						   ?>
							<tr>
								<td data-type="No"><?php echo $j;?></td>
								<td data-type="Company Name"><?php echo $result_rec_enquiry['to_company_name'];?></td>
								<td data-type="Date and Time"><?php echo $result_rec_enquiry['created'];?></td>
								<td data-type="Description"><?php echo stripslashes($result_rec_enquiry['enquiry_description']);?></td>
								<td data-type="Contact Person"><?php echo stripslashes($result_rec_enquiry['from_contact_person']);?></td>
								<td data-type="Products Interested In"><?php echo stripslashes($result_rec_enquiry['product_interested']);?></td>
							</tr>
							  <?php $j++;}} else {?>
							 <tr><td colspan="6">No record found</td></tr>
							  <?php }?>
						</tbody>
					</table>					
				</div>
			</div>
		</div>

	</div>

<?php include 'include/footer.php'; ?>