<?php
$profilePic=$info[0]->profilePhoto;
if($profilePic!='')
$profilePic= image_resizer('',201,201,$croptofit='crop-to-fit',$profilePic,$info[0]->regId,'profile');
else
$profilePic= base_url() . 'assets/images/profilePhoto.jpg';	

$currUrl=$this->uri->segment(2);
$active='active';
$userId=base64_encode($info[0]->regId);

?>

<div class="dashboardPanel">
        <ul>
        	<li class="profile"><a href="<?php echo base_url().'users/view_user_profile/'.$userId ?>"><img src="<?php echo $profilePic; ?>"><strong><?php echo $info[0]->firstName . ' ' . $info[0]->lastName; ?></strong></a></li>
			
        	<li class="Dashboard"><a href="<?php echo base_url('dashboard/profile') ?>"><i></i><span>Dashboard</span></a></li>
			
            <li class="ProductInProcess <?php if($currUrl=='borrower_approved') echo $active ?>"><a href="<?php echo base_url()?>dashboard/borrower_approved"><i></i><span>Product In Process</span></a></li>
			
            <li class="OrderProduct <?php if($currUrl=='borrower_approval_pending') echo $active ?>"><a href="<?php echo base_url()?>dashboard/borrower_approval_pending"><i></i><span>Approval Pending</span></a></li>
			
            <li class="TotalSpend <?php if($currUrl=='borrower_total_spend') echo $active ?>"><a href="<?php echo base_url()?>dashboard/borrower_total_spend"><i></i><span>Total Spend</span></a></li>
			
            <!--<li class="ReviewsByYou"><a href="Dashboard_Borrower_Reviews_By_You.php"><i></i><span>Reviews By You</span></a></li>-->
			
            <!--<li class="AwaitingForApproval"><a href="#"><i></i><span>Awaiting For Approval</span></a></li>
            <li class="TopFiveFastMovers"><a href="#"><i></i><span>Top Five Fast Movers</span></a></li>-->
        </ul>
</div>

