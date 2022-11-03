<?php 
include 'include/header.php'; 

if(!isset($_SESSION['USERID'])){header('location:login.php');}
$uid=$_SESSION['USERID'];
$gcode=$_SESSION['USER_GCODE'];
include 'db.inc.php';
include 'functions.php';
?>
<script>
$(document).ready(function(){
    $('#invoice_event').change(function() {
 //   alert($("#invoice_event option:selected").text());
	location.href="my_invoice.php?id="+$("#invoice_event option:selected").val();
  });  
});
</script>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
			<h4>Print Event Invoicing</h4>
		</div>
	</div>

	<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
		<?php include 'include/regMenu.php'; ?>
	</div>

	<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">
		
		<div class="sub_head"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Your Invoice</div>

		<p class="ab_description">Please take a print of the below mentioned forms and courier your mandatory document to the council within 15 days. The cheque should be drawn in the name of "The Gem and Jewellery Export Promotion Council"</p>
		
		<?php
		if($_GET['id']=='')
		{
			$sqlz="SELECT * FROM `invoice_event_master` order by id asc limit 1";
			$resultz=mysql_query($sqlz);
			while($rowz=mysql_fetch_array($resultz)){
			$getevent_id=$rowz['event_id'];
			}
		} else {
			$getevent_id=$_GET['id'];
		}
		?>
		<div class="form-block form-group row">
				<div class="sub_head">Events</div>
				<hr>
				<div class="col-md-6">
				<p>
				<select name="invoice_event" id="invoice_event" class="form-control">
				<option>Choose Event</option>
				<?php
				$sqle="SELECT * FROM `invoice_event_master` order by id desc";
				$resulty=mysql_query($sqle);
				while($rowy=mysql_fetch_array($resulty)){
				$event_id=trim($rowy['event_id']);
				$event_name=trim($rowy['event_name']); 
				if($event_id==$getevent_id){
				echo "<option selected='selected' value=".$event_id.">" . $event_name."</option>";
				} else	{
					echo "<option value=".$event_id.">" . $event_name."</option>";
				} }?>
				</select>
				</p>
				</div>
		</div>
		
<?php
$sqlx="SELECT * FROM `iijs_all_invoice_detail` WHERE gcode='$gcode' and event_id='$getevent_id' group by purpose_id";	

$resultx=mysql_query($sqlx);
while($rowx=mysql_fetch_array($resultx))
{	
$event_id=$rowx['event_id'];
$cpurpose_id=trim($rowx['purpose_id']);
$get_gcode=$rowx['gcode'];
?>
<?php
if($cpurpose_id=='BADGES') { 
$action='badges_invoice.php';
}else if($cpurpose_id=='REPLACEBADGES'){
$action='replace_badges_invoice.php';	
}else if($cpurpose_id=='HOUSEKIP'){
$action='housekip_invoice.php';	
}else if($cpurpose_id=='STANDFIT'){
$action='standfit_invoice.php';	
}else if($cpurpose_id=='LOST BADGES'){
$action='lost_badges_invoice.php';	
}else if($cpurpose_id=='SAFE'){
$action='safe_invoice.php';	
}else if($cpurpose_id=='SPONS'){
$action='sponsorship_invoice.php';	
}else if($cpurpose_id=='ELECTRIC'){
$action='electric_invoice.php';	
}else if($cpurpose_id=='MCB'){
$action='mcb_invoice.php';	
}else if($cpurpose_id=='PART'){
$action='iijs_part_invoice.php';	
}
?>
<form method="GET" target="_blank" action="<?php echo $action;?>" name="InvoiceForm" onsubmit="return ValidateContactForm();" >
			<div class="form-block form-group row">
				<div class="sub_head"><?php echo getPurposeName($cpurpose_id);?></div>
				<hr>
				<div class="col-md-6">
<p>
  <select name="invoices" id="invoices" class="form-control">
    <option>Choose Invoice</option>
    <?php
echo $sqly="SELECT * FROM `iijs_all_invoice_detail` WHERE gcode='$get_gcode' and event_id='$getevent_id' and purpose_id='$cpurpose_id'";
$resulty=mysql_query($sqly);
while($rowy=mysql_fetch_array($resulty)){
$invoice_id=$rowy['id'];
$purpose_id=trim($rowy['purpose_id']); 
$invoice_no=$rowy['invoice_no'];
$invoice_date=$rowy['invoice_date'];

echo "<option>" . $rowy['invoice_no']."</option>";
?>
    <?php } ?>
  </select>
</p>
<input type="hidden" name="<?php echo $purpose_id;?>" value="<?php echo $purpose_id;?>">
<input type="hidden" name="invoice_id" value="<?php echo $invoice_id;?>">
<input type="hidden" name="event_id" value="<?php echo $getevent_id;?>">

				</div>
			  <div class="col-md-6 text-right">
				<button type="submit" name="submit" class="btn"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
					<!--<input type="submit" name="submit" value="Print" class="btn">-->
				</div>
			</div>
</form>
			<?php } ?>

			
			
			
<?php
if($getevent_id!='EVENT/15-16/00031') {
$sqlx="SELECT * FROM `iijs_invoice_part` WHERE gcode='$gcode' group by purpose_id";
$resultx=mysql_query($sqlx);
while($rowx=mysql_fetch_array($resultx))
{	
$event_id=$rowx['event_id'];
$cpurpose_id=trim($rowx['purpose_id']);
$get_gcode=$rowx['gcode'];
?>
<?php
if($cpurpose_id=='BADGES') { 
$action='signature_badges_invoice.php';
}else if($cpurpose_id=='REPLACEBADGES'){
$action='signature_replace_badges_invoice.php';	
}else if($cpurpose_id=='HOUSEKIP'){
$action='signature_housekip_invoice.php';	
}else if($cpurpose_id=='STANDFIT'){
$action='signature_standfit_invoice.php';	
}else if($cpurpose_id=='LOST BADGES'){
$action='signature_lost_badges_invoice.php';	
}else if($cpurpose_id=='SAFE'){
$action='safe_invoice.php';	
}else if($cpurpose_id=='SPONS'){
$action='sponsorship_invoice.php';	
}else if($cpurpose_id=='ELECTRIC'){
$action='electric_invoice.php';	
}else if($cpurpose_id=='MCB'){
$action='mcb_invoice.php';	
}else if($cpurpose_id=='PART'){
$action='signature_part_invoice.php';	
}
?>
<form method="GET" target="_blank" action="<?php echo $action;?>" name="InvoiceForm" onsubmit="return ValidateContactForm();" >
<!--<form method="GET" target="_blank" action="part_invoice.php">-->
			<div class="form-block form-group row">
				<div class="sub_head"><?php echo getPurposeName($cpurpose_id);?></div>
				<hr>
				<div class="col-md-6">
				<p>
<select name="invoices" id="invoices" class="form-control">
<option>Choose Invoice</option>
<?php
$sqly="SELECT * FROM `iijs_invoice_part` WHERE gcode='$get_gcode' and event_id='$getevent_id' and purpose_id='$cpurpose_id'";
$resulty=mysql_query($sqly);
while($rowy=mysql_fetch_array($resulty)){
$invoice_id=$rowy['id'];
$purpose_id=trim($rowy['purpose_id']); 
$invoice_no=$rowy['invoice_no'];
$invoice_date=$rowy['invoice_date'];

echo "<option>" . $rowy['invoice_no']."</option>";
}
?>
</select>
</p>
<input type="hidden" name="<?php echo $purpose_id;?>" value="<?php echo $purpose_id;?>">
<input type="hidden" name="invoice_id" value="<?php echo $invoice_id;?>">
<input type="hidden" name="event_id" value="<?php echo $getevent_id;?>">

				</div>
				<div class="col-md-6 text-right">
				<button type="submit" name="submit" class="btn"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
					<!--<input type="submit" name="submit" value="Print" class="btn">-->
				</div>
				
			</div>
</form>
<?php } }?>

</div>


<?php include 'include/footer.php'; ?>