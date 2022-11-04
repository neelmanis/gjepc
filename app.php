<?php 
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php');exit; }
include 'db.inc.php';
include 'functions.php';
$registration_id = intval(filter($_SESSION['USERID']));
?>

<section class="py-5">
    <div class="container inner_container">
    
    <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png"  class="d-block mx-auto mb-4"> My Account - Trade Permission</h1>
	<div class="row justify-content-between">
	<div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
		<?php include 'include/regMenu.php'; ?>
	</div>
    
<?php 
if($_SESSION['form_chk_msg']!=""){
echo "<span style='color: green;'>";
echo $_SESSION['form_chk_msg']."<br>";
echo "</span>";
$_SESSION['form_chk_msg']='';
}
?>

<div class="col-lg col-md-12 ">

<?php if($admin_allowed=='Y' || $application_status=='C'){ ?>
<a href="trade_approval.php?action=Add"  class="cta">ADD NEW APPLICATION</a>
<?php } else if($count==1){
	if(($today_date > $f_date) && ($app_report_status=='P' || $app_report_status=='N')){?>
	<div class="padding_width_head" style="font-size:13px;" >NOTE : Report is not submitted duration exceeded 90 days</div>
	<?php }else {?>
	<a href="trade_approval.php?action=Add" class="cta">ADD NEW APPLICATION</a>
	<?php }} else {?>
    <a href="trade_approval.php?action=Add" class="cta">ADD NEW APPLICATION</a>
    <?php } ?>
	
		<table class="responsive_table portal_table mb-4" style="font-size:13px;">
			<thead>
				<tr>
					<th>No.</th>
					<th>Member Name</th>
					<th>Membership ID</th>
					<th>Created Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="CommunicationDetails">
			<?php
			$sql = $conn ->query("select * from trade_general_info where registration_id='$registration_id' AND registration_id!=0");
			$count = $sql->num_rows;
			$i=1;
			while($ans= $sql->fetch_assoc())
			{
			$app_id = filter($ans['app_id']);
			?>
				<tr>
					<td data-column="No."><?php echo $i;?></td>
					<td data-column="Member Name"><a href="trade_approval.php?app_id=<?php echo $app_id; ?>">
					<?php echo filter(strtoupper(str_replace(array('&amp;','&AMP;'), '&', $ans['member_name'])));?> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
					<td data-column="Membership ID"><?php echo filter($ans['membership_id']);?></td>
					<td data-column="Created Date"><?php echo $ans['created_date'];?></td>
					<td class="gallery" data-column="Action">
					<?php if($ans['application_status']=='P') { ?>
					<a href="#">Application Pending</a>
					<?php }else if($ans['application_status']=='C') { ?>
					<a href="#">Application Cancelled</a>
					<?php } else if($ans['application_status']=='Y' && $ans['app_report_status']=='P'){ ?>
					<!-- <a href="trade_report.php?app_id=<?php //echo $app_id; ?>" data-toggle="modal" href='#modal-id' class='various3'>Submit Report</a> -->
					<a app_id=<?php echo $app_id; ?> class="modalcaller" data-toggle="modal" href='#modal-id'>Submit Report</a>
					<?php } else if($ans['application_status']=='Y' && $ans['app_report_status']=='N'){ ?>
					<!--<a href="trade_report.php?app_id=<?php echo $app_id; ?>" class='various3'>Report Disapproved(Edit)</a>-->
					<a app_id=<?php echo $app_id; ?> class="modalcaller" data-toggle="modal" href='#modal-id'>Report Disapproved(Edit)</a>
					<?php } else if($ans['application_status']=='Y' && $ans['app_report_status']=='Y'){ ?>
					<a href="#">Report & Application Approved</a>			  
					<?php } ?>
					</td>
					<!--<td>
					<?php if($ans['permission_type']=="exhibition"){?>
					 <a href="trade_exh_print_ack.php?app_id=<?php echo $app_id; ?>" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
					<?php } else {?>
					<a href="trade_other_print_ack.php?app_id=<?php echo $app_id; ?>" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print</a> 
					<?php }?>
					</td>-->
					<?php $i++; if($ans['admin_allow_for_application']=='Y'){$admin_allowed=$ans['admin_allow_for_application'];}} ?>

<?php
$sql_max = $conn ->query("select a.registration_id,a.app_id,a.permission_type,a.to_date,a.visiting_country1,b.exhibition_date_to from trade_general_info a left join trade_exhibition_info b on a.registration_id=b.registration_id where a.registration_id='$registration_id' order by a.app_id desc limit 0,1");
$ans_max = $sql_max->fetch_assoc();

if($ans_max ['permission_type']=='promotional_tour')
{
	$c_date = $ans_max['to_date'];
	$f_date = strtotime(date('Y-m-d',strtotime($c_date."+30 days")));
} else {
	$c_date = $ans_max['exhibition_date_to'];
	if($ans_max['visiting_country1']=="USA")
		$f_date = strtotime(date('Y-m-d',strtotime($c_date."+120 days")));
	else
		$f_date = strtotime(date('Y-m-d',strtotime($c_date."+90 days")));
}

$today_date = strtotime(date('Y-m-d'));
$sql_max1 = $conn ->query("SELECT * FROM trade_general_info WHERE app_id IN (SELECT max( app_id )FROM trade_general_info WHERE registration_id = '$registration_id')");
$ans_max2 = $sql_max1->fetch_assoc();
$app_report_status	= $ans_max2['app_report_status'];
$application_status = $ans_max2['application_status'];
?>
					
</tr>
</tbody>
</table>
</div>
</div>
</div>
</section>
<?php
$sqlx1 = $conn ->query("select * from trade_general_info where registration_id = '$registration_id' AND `app_id` = '$app_id'");
$rowx1 = $sqlx1->fetch_assoc();
$actual_invoice_amt = $rowx1['actual_invoice_amt'];
$sold_amt = $rowx1['sold_amt'];
$unsold_amt = $rowx1['unsold_amt'];
$good_description = $rowx1['good_description'];
?>
<!-- Trade Report Popup -->
<div class="modal fade" id="modal-id">
	<div class="modal-dialog" style="max-width:700px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Submit Report</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form action="trade_report.inc.php" method="post" enctype="multipart/form-data" name="loginproject" onSubmit="return loginvalidate()">
						<div class="row">							
							<div class="form-group col-md-6">
							<label class="form-label" for="actual_invoice_amt">Actual Invoice Value (FOB Value) :</label>					
								<input type="text" class="form-control trade_input_text" name="actual_invoice_amt" id="actual_invoice_amt" autocomplete="off" value="<?php echo $actual_invoice_amt;?>">
							</div>							
							<div class="form-group col-md-6">
							<label class="form-label" for="sold_amt">Value of goods sold :</label>							
								<input type="text" class="form-control trade_input_text" name="sold_amt" id="sold_amt" value="" onkeyup="getTotInvoice()" autocomplete="off">
							</div>
							<div class="form-group col-md-6">
							<label class="form-label" for="unsold_amt">Value of goods unsold :</label>
								<input type="text" class="form-control trade_input_text" name="unsold_amt" id="unsold_amt" value="" readonly="readonly" autocomplete="off">
							</div>
							<div class="form-group col-md-6">
							<label class="form-label" for="good_description">Describe your goods :</label>
								<input type="text" class="form-control trade_input_text" name="good_description" id="good_description" value="" autocomplete="off">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-6">
							<label class="form-label" for="good_description">Specify Countries:</label>
								<input type="text" class="form-control trade_input_text" name="specify_country" id="specify_country" value="" autocomplete="off">
							</div>
							<div class="form-group col-md-6">
							<label class="form-label" for="good_description">Latest Trend <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-content="(What is the market demand ?)" aria-hidden="true"></i></label>
								<input type="text" class="form-control trade_input_text" name="latest_trend" id="latest_trend" value="">
							</div>
							<div class="form-group col-md-6">
							<label class="form-label" for="future_prospect">Future Prospects <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-content="(What is expected demand?)" aria-hidden="true"></i></label>
								<input type="text" class="form-control trade_input_text" name="future_prospect" id="future_prospect" value="">
							</div>
							<div class="form-group col-md-6">
							<label class="form-label" for="prob_face">Any Problems Faced</label>
							<input type="text" class="form-control trade_input_text" name="prob_face" id="prob_face" value="">
							</div>
						</div>
						<div class="row">							
							<div class="form-group col-md-12">
							<label class="form-label" for="comments">Comments & Suggestions</label>
								<textarea class="form-control" name="comments" id="comments"></textarea>
							</div>
							<div class="form-group col-md-12">
							<label class="form-label" for="comments">Upload Report</label>
								<input type="file" style="display: none;" name="trade_report" id="trade_report">
								<button type="button" class="cta" onclick="document.getElementById('trade_report').click();">Choose File</button>
							</div>
							<div class="form-group col-md-12">
								<label class="form-label" for="prob_face"><u><b>Note : </b></u></label>
									<ol>
										<li>* Kindly upload custom attested Import & Export Invoice.</li>
										<li>* All Values Should be in USD Only.</li>
									</ol>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<label>
									<input type="checkbox" name="terms_and_cond" id="terms_and_cond" value="Y" class="form-checkbox"/>
										I here by confirm the above information filled is true & best of my knowledge.
									</label>
								</div>
							</div>
						</div>
				</div>
			</div>
			<div class="modal-footer">			
				
				<input type="hidden" class="app_id" name="app_id" id="app_id" value="<?php echo $_GET['app_id'];?>" />
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!--<input type="submit" name="sub" id="sub" class="submitButton" value="submit" />-->
				<button type="submit" name="sub" id="sub" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Trade Report Popup End -->

<?php include 'include-new/footer.php'; ?>

<script language="javascript">
$(document).ready(function(){
$("#sub").click(function(){
  
  var actual_invoice_amt =  $("#actual_invoice_amt").val();
    if(actual_invoice_amt=='')
    {
      alert('Please Enter Actual Invoice Amount Value');
      $("#actual_invoice_amt").focus();
      return false;
    } 
  
    var sold_amt =  $("#sold_amt").val();
    if(sold_amt==''){
      alert('Please Enter Sold Value');
      $("#sold_amt").focus();
      return false;
    }     
    
    var good_description =  $("#good_description").val();
    if(good_description=='')
    {
      alert('Please Enter Good Description');
      $("#good_description").focus();
      return false;
    }
    
    var specify_country =  $("#specify_country").val();
    if(specify_country=='')
    {
      alert('Please Specify the Country');
      $("#specify_country").focus();
      return false;
    }
    var latest_trend =  $("#latest_trend").val();
    if(latest_trend=='')
    {
      alert('Please Enter Latest Trend');
      $("#latest_trend").focus();
      return false;
    }
    var future_prospect =  $("#future_prospect").val();
    if(future_prospect=='')
    {
      alert('Please Enter Future Prospect');
      $("#future_prospect").focus();
      return false;
    }
    var prob_face =  $("#prob_face").val();
    if(prob_face=='')
    {
      alert('Please Enter Problem Faced');
      $("#prob_face").focus();
      return false;
    }   
    
    p_file=$("#trade_report").val();
    var regex = new RegExp("(.*?)\.(docx|doc|xls|pdf|PDF|xlsx|jpg|png|jpeg|JPEG|PNG|JPG)$");
    if(!regex.test(p_file)) {
      alert('Please upload xls,docx,doc,jpg,xlsx,jpeg,png,PDF,pdf,JPEG,PNG,JPG');
      return false;   
    } 
    if(!document.getElementById('terms_and_cond').checked)
    {
      alert('Please Select Terms And Condition');
      $("#terms_and_cond").focus();
      return false;
    }
  });
});

function getTotInvoice()
{
  var sold_amt=document.getElementById("sold_amt").value;
  if(sold_amt==""){sold_amt=0;}
  var actual_invoice_amt=document.getElementById("actual_invoice_amt").value;
  if(actual_invoice_amt==""){actual_invoice_amt=0;}
  
  var tot_examount=parseInt(actual_invoice_amt)-parseInt(sold_amt); 
  //var tot_examount=parseInt(sold_amt)-parseInt(actual_invoice_amt); 
  
  if(parseInt(actual_invoice_amt)>parseInt(sold_amt))
  //if(parseInt(sold_amt)>parseInt(actual_invoice_amt))

  var tot_examount=parseInt(actual_invoice_amt)-parseInt(sold_amt);
  //var tot_examount=parseInt(sold_amt)-parseInt(actual_invoice_amt);
  else
  {
    alert("Actual Invoice Amount should be greater than Sold amount");
    var tot_examount=0;
  }
    
  document.getElementById("unsold_amt").value = tot_examount;
}
</script>

<script type="text/javascript">
	
jQuery(".modalcaller").click(function(event) {
	// console.log($(this).attr('app_id'));
	jQuery("#app_id").val($(this).attr('app_id'));
});

</script>