<?php
session_start();
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
?>
<div class="right_box" data-sticky_column>

	<h2>My Account</h2>
	<ul class="right_box_list">
		<?php $ckAppliedForparichay = isApplied_for_parichay($_SESSION['USERID'],$conn); 
		if($ckAppliedForparichay!="association"){ ?>
		<li class="right_box_submenu"> 
        	<a href="javascript:void(0)">Manage GJEPC <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul>
            	<li> <a href="membership_rcmc.php">  Membership & RCMC  </a> </li>
            	<li> <a href="information_form.php"> Application form for Associate Membership</a> </li>
      			<li> <a href="communication_form.php"> Application for Registration – Cum – Membership Certificate (RCMC) </a> </li>
				<?php 
                $chln_query= $conn->query("select eligible_for_renewal from approval_master where registration_id='".$_SESSION['USERID']."'");
                $chln_result = $chln_query->fetch_assoc();
                $eligible_for_renewal=$chln_result['eligible_for_renewal'];
                if($eligible_for_renewal=="Y"){ 
                ?>  
				<li><a href="challan_form_renew.php">Challan Form</a></li> 
                <!--<li><a href="#" onClick="alert('Membership Renewal for the FY 2020-21 which starts from 1st April 2020 has now been postponed to 1st July 2020');return false">Challan Form</a></li> -->
				<?php } else { ?>
                <li><a href="challan_form.php">Challan Form</a></li>
                <?php } ?>
				<li> <a href="apply_rcms_certificate.php"> Apply RCMC Certificate </a> </li>
				<li> <a href="print_acknowledgement.php"> Print Acknowledgment </a> </li>
				<!--<li> <a href="upload_challan_scanned_copy.php"> Upload Challan Scanned Copy </a> </li>
				<li> <a href="upload_signature_slip_copy.php">Upload Signature Slip</a></li>-->
				<li> <a href="update_panel.php"> Update Panel </a> </li>
				<!--<li> <a href="apply_photo_id_card.php"> Apply Photo ID Card </a> </li>-->
				<li> <a href="updation_communication_details.php"> Updation of Communication Details </a> </li>
				<li> <a href="pdf/signature_slip.pdf" target="_blank"> Blank format for Signature Slip </a> </li>
				<?php
				$form_sql = $conn->query("select * from trade_general_info where registration_id='".$_SESSION['USERID']."'");
				$form_ans = $form_sql->fetch_assoc();
				$count1 = $form_sql->num_rows;
				if($count1==0){	?>
				<li><a href="trade_approval.php?action=Add">Trade Permission</a></li>
				<?php	}	else {	?>
				<li><a href="app.php">Trade Permission</a></li>
				<?php	}	?>
              </ul>
       </li>   
        <!--<li class="right_box_submenu">
        	<a href="javascript:void(0)">Buy / Sell <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul>
				<li> <a href="members_profile.php"> Members Profile </a> </li>
				<li> <a href="auto_match.php"> Auto Match </a> </li>
				<li> <a href="advance_member_search.php"> Advance Member Search </a> </li>
				<li> <a href="my_enquires.php"> My Enquires </a> </li>
			</ul>
		</li>-->
		<?php $ckAppliedForparichay = isApplied_for_parichay($_SESSION['USERID'],$conn); 
		if($ckAppliedForparichay=="M" || $ckAppliedForparichay=="NM"){ ?>
		<li class="right_box_submenu">
        	<a href="javascript:void(0)">Parichay Card <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul>
				<li><a href="company-profile-details.php">Company Profile</a></li>
				<li><a href="person-list.php">Applicant Details</a></li>
			</ul>
		</li>
		<?php } ?>
		
		<?php					
		//$schk_membership = $conn->query("SELECT * FROM `approval_master` WHERE 1 and `registration_id`='".$_SESSION['USERID']."' AND issue_membership_certificate_expire_status='Y'");
		$schk_membership = $conn->query("SELECT * FROM `approval_master` WHERE 1 and `registration_id`='".$_SESSION['USERID']."' AND eligible_for_renewal='Y'");
		$nchk_membership = $schk_membership->num_rows;	
		if($nchk_membership>0){ ?>
        <!--<li><a href="import_export_lists.php"> Export / Import (Quarterly Returns)</a> </li>-->
		<?php } ?>
		<li><a href="gjepc_annual_report.php">Legal and Secretarial Compliance</a></li>
		<li><a href="statistics.php">Research & Statistics</a></li>
		<li><a href="trade_show.php">Trade Show</a></li>
        <li><a href="e-voting.php">E-Voting of COA Election </a></li>
		<li><a href="change_password.php">Change Password</a></li>
		
		<?php } else { ?>
		<li class="right_box_submenu">	<!--Association -->
        	<a href="javascript:void(0)">Parichay Card <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul>
				<li><a href="association_update_details.php">Association Profile</a></li>
				<li><a href="person-list.php">Applicant Details</a></li>
			</ul>
		</li>
		<?php } ?>
	</ul>
</div>