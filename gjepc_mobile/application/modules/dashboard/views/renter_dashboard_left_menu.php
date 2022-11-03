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
		
		<li class="AwaitingForApproval <?php if($currUrl=='renter_awaiting_approval') echo $active ?>"><a href="<?php echo base_url()?>dashboard/renter_awaiting_approval"><i></i><span>Awaiting For Approval</span></a></li>
		
		<li class="TopFiveFastMovers <?php if($currUrl=='renter_five_fast_movers') echo $active ?>"><a href="<?php echo base_url()?>dashboard/renter_five_fast_movers"><i></i><span>Top Five Fast Movers</span></a></li>
		
		<li class="TotalSpend <?php if($currUrl=='renter_total_sale') echo $active ?>"><a href="<?php echo base_url()?>dashboard/renter_total_sale"><i></i><span>Total Sales</span></a></li>
		
		<!--<li class="ReviewsByYou"><a href="Dashboard_Renter_Reviews_About_You.php"><i></i><span>Reviews About You</span></a></li>-->
	</ul>
</div>
      