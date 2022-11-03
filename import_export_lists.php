<?php 
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';

$registration_id = intval(filter($_SESSION['USERID']));
?>

<section class="py-5">   
    <div class="container inner_container">    
    <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> Export/Import (Quarterly Returns)</h1>
    
	<div class="row">        
	<div class="col-lg-auto order-lg-12 col-md-12" data-sticky_parent>
		<?php include 'include/regMenu.php'; ?>
	</div>
<div class="col-lg col-md-12">
<a data-fancybox data-src="#modals" href="javascript:;" class="cta"><strong>Submission Form</strong></a>
		<?php
		$sql = "SELECT * FROM statistics where registration_id='$registration_id' AND registration_id!=0" ;
		$result = $conn->query($sql);
		$count = $result->num_rows;

		if($count > 0){
		?>
		<table class="responsive_table portal_table">
			<thead>
				<tr>
					<th class="text-lg-center">No.</th>
					<th class="text-lg-center">Date</th>
					<th class="text-lg-center">Membership ID</th>
					<th class="text-lg-center">Region</th>
					<th class="text-lg-center">Financial Year</th>
					<th class="text-lg-center">Quarter</th>
					<th class="text-lg-center">Status</th>
				</tr>
			</thead>
			<tbody id="CommunicationDetails">
			<?php			
			$i=1;
			while($ans = $result->fetch_assoc()){ //echo '<pre>'; print_r($ans);	?>
				<tr>
					<td class="text-lg-center" data-column="No."><?php echo $i;?></td>
					<td class="text-lg-center" data-column="Date"><?php echo date("d-m-Y",strtotime($ans['created_at']));?></td>
					<td class="text-lg-center" data-column="Membership ID"><?php echo $ans['membership_no'];?></td>
					<td class="text-lg-center" data-column="Region"><?php echo $ans['region'];?></td>
					<td class="text-lg-center" data-column="Financial Year"><?php echo $ans['financial_year'];?></td>
					<td class="text-lg-center" data-column="Quarter"><?php echo getQuarterDescription($ans['quarter_year'],$conn);?></td> 
					<?php if($ans['isDraft']=="Y" ){ ?>
					<td class="text-lg-center" data-column="Status"><a href="import_export_demo.php?application_id=<?php echo $ans['id']; ?>" ><span style="text-decoration: underline;">Edit</span> &nbsp;&nbsp; <i>(Draft)</i></a></td>
					<?php } else { ?>
					<td class="text-lg-center"><i data-id='<?php echo $ans["id"]?>' class="userinfo fa fas fa-eye"></i></td>
					<?php } ?>
					<?php $i++; ?>				
				</tr>
			<?php } } ?>
			</tbody>
		</table>
</div>
</div>
</div>
</section>
 <!-- Modal -->
   <div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog" style="max-width: 980px;">

     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">VIEW Export/Import (Quarterly Returns)</h4>        
      </div>
      <div class="modal-body"> 
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
     </div>
    </div>
   </div>

<style >
	.fancybox-close-small{display: none!important;}
</style>
<div style="display: none;" id="modals">
			<h1 align="center" class="mb-2 blue" > Instructions for filing up the form : </h1>
			<div class="row">
				<div class="col-6">
		  <p>1. Visit <a href="https://gjepc.org/login.php" class="blue">https://gjepc.org/login.php</a> </p>
          <p>2. Log in the Member Dashboard</p>
          <p>3.	Click on the "Export/Import Quarterly Returns"</p>
          <p>4.	Then click on the "Submission Form"</p>
          <p>5.	You will see instructions for submitting the form.</p>
          <p>6.	Select the Quarter Year </p>
          <p>7.	Select "Yes" if exported in current quarter; otherwise select "No". Please note that after selecting "No"; you will be directed to submit the form.</p>
          <p>8.	If you select yes, the HS Code of the export/import commodities and the 
              commodity description will come automatically.</p>
          <p>9.	You can select more than one Country of exports/imports.</p>
          <p>10. Enter the value of “Exports (FOB)”/ “Imports (CIF)” either in USD/Euro </p>
          <p>11. <b>a).</b> Enter the Carat (Diamonds & Lab Grown Diamonds & Synthetic Stones), 
<b>b).</b> Enter the Carat (Precious Stone)
<b>c).</b> Enter the Carat (Semi Precious stone)
<b>d).</b> Ener the Grams ( Pearls, gold & Silver)
</p>
          <p>12.Mention suggestions/issues in Remarks box.</p>
          <p>13.Click on Agree Terms & Conditions</p>
          <p>14.Click on "save as draft" if want to edit later or on "submit" to submit it immediately</p>
			</div>
			<div class="col-6">
					
          <p>Other Instructions</p>
          <p><strong>In case members have NIL exports, this is mandatory to file the return and in such cases Steps from 1-7, 13 and 14 would be applicable.</strong></p>
          <p><strong>You are informed that window for furnishing the export returns for Fourth quarters (Q4 of the FY 2020-2021). </strong></p>
          <p><strong>Members who have filed information for any quarter may furnish the details for the remaining quarters. If export return is not furnished for any quarter(s), members are required to file the return for all the quarters even in case of not exporting.</strong></p>
          <p>Please note we have added revised HS Codes for Precious and Semi-Precious Stones Product Category</p>
          <p>For Sales to Foreign Tourist you may select the following 8-digit Code</p>
          <p>Sales to Foreign Tourist Code – 71000000 (This is not a HS code, for the ease of members to enter the value for the said category a simple code of 8 digit is added in the list).</p>
          <p> <strong><i>That this is mandatory to submit the quarterly returns, in case of non-filing of returns regularly your RCMC is liable to get cancelled / suspended.</i></strong></p>
		<p>For submitting any query:</p>
		<p>1.	Visit GJEPC helpdesk at www.gjepcindia.com</p>
		<p>2.	Fill your details</p>
		<p>3.	Select</p>
		<ul class="inner_under_listing">
			<li>Region</li>
			<li>Statistics Dept</li>
			<li>Export /Import Quarterly Return</li>
		</ul>
			</div>
			</div>

<p>If there are any queries you may please call at : 1800-103-4353 </p>
          <a href="import_export_demo.php" class="btn btn-secondary">OK</a>
          <a class="btn btn-warning cancel">Cancel</a>
</div>
<style type="text/css">
	#modals p{line-height: 15px}
</style>

<?php include 'include-new/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
$(document).ready(function()
{   
	$('.cancel').click(function(){
		$.fancybox.close();
	 });
	$('.userinfo').click(function(){  
    var appid = $(this).data('id');
    var actionType = "modalDataAction"
   // AJAX request
   $.ajax({
    url:"statisticsAction.php",
    type: 'post',
    data: {appid: appid,actionType: actionType},
    success: function(response){
      $('.modal-body').html(response);
      $('#empModal').modal('show'); 
    }
  });
 }); 
});
</script>