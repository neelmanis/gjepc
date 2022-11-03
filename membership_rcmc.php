<?php 
include 'include-new/header.php'; 
if(!isset($_SESSION['USERID'])){	header('location:login.php');	}

include 'db.inc.php';
include 'functions.php';
?>
<?php 
$ckAppliedForparichay = isApplied_for_parichay($_SESSION['USERID'],$conn); 
if($ckAppliedForparichay!="association"){ ?>
<section class="py-5">
	<div class="container inner_container">
    	
        <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> My Account - Membership & RCMC</h1>
		
		<a href="https://customersuggestions.co.in/gjepc/gjepc.aspx" target="_blank"><img src="images/icici.jpg" class="img-fluid" style="width: 100%; height: 250px;object-fit: coainnt;"></a>
		
		<div class="row">
        	
            <div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
            	<?php include 'include/regMenu.php'; ?>
            </div>
        	
            <div class="col-lg col-md-12 ">

<?php 
$registration_id = intval($_SESSION['USERID']);
$query  = $conn->query("SELECT * FROM approval_master WHERE 1 and registration_id=$registration_id");
$result = $query->fetch_assoc();
$num = $query->num_rows;
if($result['final_submission']=="Y")
{
?>
<div class="righttable_css">
<?php 
if(($result['membership_id']=="" && $result['apply_membership_renewal']=="N") || ($result['membership_id']!="" && $result['apply_membership_renewal']=="Y")) 
//if(($result['membership_id']=="" && $result['apply_membership_renewal']=="N") || ($result['membership_id']!=""))
{ ?>    
<div class="sub_head">GJEPC Membership Status</div>
<table class="table">
			<thead>
				<tr>
					<th>Processing Details</th>
					<th>Admin Status</th>
					<th>GJEPC Admin Comment</th>
				</tr>
			</thead>
			<tbody>
				
				<tr>
					<td>Information verified</td>
					<td>
						<?php 
							if($result['information_approve']=="P"){ echo "Pending";}
							else if($result['information_approve']=="Y"){echo "Approve";}
							else{echo "Disapprove";}
						?>
					</td>
					<td>
						<?php if($result['information_approve']=='N'){echo $result['disapprove_reason'];}?>
					</td>
				</tr>

				<tr>
					<td>Document verified</td>
					<td>
						<?php 
							if($result['document_approve']=="P"){echo "Pending";}
							else if($result['document_approve']=="Y"){echo "Approve";}
							else{echo "Disapprove";}
						?>
					</td>
					<td>
						<?php if($result['document_approve']=='N'){echo $result['disapprove_reason'];}?>
					</td>
				</tr>

				<tr>
					<td>Payment approved</td>
					<td>
						<?php 
							if($result['payment_approve']=="P"){echo "Pending";}
							else if($result['payment_approve']=="Y"){echo "Approve";}
							else{echo "Disapprove";}
						?>
					</td>
					<td>
						<?php if($result['payment_approve']=='N'){echo $result['disapprove_reason'];}?>
					</td>
				</tr>

				<tr>
					<td colspan="3">
					<a class="cta" href="print_acknowledgement.php">Print Acknowledgement</a>
					</td>
				</tr>

			</tbody>
	</table>

	</div>
	<?php } else {	?>
	<div class="sub_head"><i class="fa fa-users" aria-hidden="true"></i> GJEPC Membership Details</div>
	<table class="table">
			<tbody>				
				<tr>
					<td>Issued Membership ID</td>
					<td><?php echo $result['membership_id'];?></td>
				</tr>
				<tr>
					<td>Membership Issued Date</td>
					<td><?php if($result['membership_issued_dt']=== NULL){ echo '';} else { echo date("d-m-Y",strtotime($result['membership_issued_dt'])); }?></td>
				</tr>
				<!--<tr>
					<td>Membership Renewal Date</td>
					<td><?php echo date("d-m-Y",strtotime($result['membership_renewal_dt']));?></td>
				</tr>
				<tr>
					<td>Membership Expiry</td>
					<td><?php echo date("d-m-Y",strtotime($result['membership_expiry_dt']));?></td>
				</tr>-->
				<tr>
					<td colspan="3">
					<?php
				   //if($result['membership_expiry_dt']<=date("Y-m-d"))
				   if($result['eligible_for_renewal']=="Y")
				   { 
					$sql = "SELECT Response_Code FROM `challan_master` WHERE 1 and registration_id='$registration_id' and challan_financial_year='2022' order by id desc limit 1";
					$resultZ = $conn ->query($sql);
					$rowsZ = $resultZ->fetch_assoc();
					$Response_Code = $rowsZ['Response_Code'];
					if($Response_Code == "E000"){ } else {
					?>
					<a class="btn" href="challan_form_renew.php" style="color:magenta"><i class="fa fa-repeat" aria-hidden="true"></i> <b>Renew Membership</b></a>
                   <!--<a class="btn" href="#" onClick="alert('Under maintenance..');return false" style="color:magenta"><i class="fa fa-repeat" aria-hidden="true"></i> <b>Renew Membership</b></a>-->
				   <?php  }  }
				   ?>
					</td>
				</tr>
			</tbody>
	</table>
	
<?php } ?>	

	<div class="sub_head"><i class="fa fa-certificate" aria-hidden="true"></i> RCMC Certificate Status</div>		
	<table class="table">
			<thead>
				<tr>
					<th>Processing Details</th>
					<th>Admin Status</th>
					<th>GJEPC Admin Comment</th>
				</tr>
			</thead>
			<tbody>				
				<tr>
					<td>RCMC Certificate</td>
					<td>
						<?php 
							if($result['rcmc_certificate_approve']=="P"){ echo "Pending"; }
							else if($result['rcmc_certificate_approve']=="Y"){ echo "Approve"; }
							else { echo ""; }
						?>
					</td>
					<td>
						<?php echo $result['rcmc_certificate_disapprove_reason'];?>
					</td>
				</tr>
			</tbody>
	</table>

<?php } else { ?>

		<p class="blue"> RCMC Dashboard</p>
		<p> <strong> What is Registration Cum Membership Certificate (RCMC No.) ? </strong></p>
		<p>The basic objective of export promotion councils is to promote and develop the exports of the country. Each council is responsible for the promotion of a particular group of products. As per para 2.44 of the policy, any person applying for licence / certificate / permission to import or export, (except restricted items as per the policy) or any ... </p>		
        
        <div id="accordion" class="myaccordion">  			
            <div class="card">            
    			<div class="card-header" id="headingOne">
      				<button class="text-left align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"> Application form for Associate Membership </button>
      				</h2>
    			</div>                
    			<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      				<div class="card-body">
 						<p>This is first step of online GJEPC membership process.</p>                        
                        <div class="d-flex"><a href="information_form.php" class="cta">Apply</a></div>                        
					</div>
    			</div>                
  			</div>
            
  			<div class="card">
    			<div class="card-header" id="headingTwo">
        			<button class="text-left align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Application for Registration – Cum – Membership Certificate (RCMC)</button>
      			</div>
    			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      				<div class="card-body">
        				<p>This is second step of online GJEPC membership process. Applicant has to provide his/her communication details such as - Head Office, Branch Office, Registered Office, Factory Office, etc. Also applicant has show interest against which panel he/she would like to register themselves.</p>                    
                    	<p>Referral of existing GJEPC member is a must for enrollment of GJEPC membership.</p>
                    
                    	<p>Applicant has to confirm the submission of list of respective business document that need to be couriered to respective council regional offices.</p>			
                        <a href="communication_form.php" class="cta">Apply</a>                        
      				</div>
    			</div>
  			</div>
  			
            <div class="card">
            
    			<div class="card-header" id="headingThree">
      				<button class="text-left align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Challan Form</button>
      			</div>
                
    			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      				<div class="card-body">
          				<p>This is third step of online GJEPC membership process. Applicant has to submit their previous year export / import performance details based on which his/her membership fee will be payable. Payment mode and payment details need to be submitted by applicant while processing this step</p>
                        
                        <a href="challan_form.php" class="cta">Apply</a>
      				</div>
   				</div>
  			
            </div>
            
            <div class="card">
            
    			<div class="card-header" id="headingFour">
      				<button class="text-left align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Apply RCMC Certificate</button>
      				
    			</div>
                
    			<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
      				<div class="card-body">
 						<p>This is first step of online GJEPC membership process. Applicant has to fill in his/her company details and authorized representative persons details.</p>	
                        
                        <a href="apply_rcms_certificate.php" class="cta">Apply</a>
                        
					</div>
    			</div>
                
  			</div>
            
  			<div class="card">
    			<div class="card-header" id="headingFive">
        			<button class="text-left align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Print Acknowledgement</button>
      			</div>
    			<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
      				<div class="card-body">
                        <a href="print_acknowledgement.php" class="cta">Print</a>                        
      				</div>
    			</div>
  			</div>
  			
            <div class="card">
            
    			<div class="card-header" id="headingSix">
      				<button class="text-left align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"> Upload Challan Scanned Copy</button>
      			</div>
                
    			<div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
      				<div class="card-body">
          				<p>Instead of sending courier, applicants can upload a copy of the duly acknowledged Challan after making the payment in the Bank.</p>
                        
                        <a href="upload_challan_scanned_copy.php" class="cta">Apply</a>
                        
      				</div>
   				</div>
  			
            </div>
        </div>
	<?php } ?>
</div>
</div>  
</div>
</section>
<?php } else { ?>
<section class="py-5">
	<div class="container inner_container">
        <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> Association </h1>
		<div class="row">
            <div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
            	<?php include 'include/regMenu.php'; ?>
            </div>
        	
            <div class="col-lg col-md-12">
			
			</div>
			</div>
			</div>
			</section>
<?php } ?>
<?php include 'include-new/footer.php'; ?>