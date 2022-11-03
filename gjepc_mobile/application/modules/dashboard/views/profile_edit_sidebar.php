<?php 
$currUrl=$this->uri->segment(2);
$active='active';
$userId=$info[0]->regId;
$userId=base64_encode($userId);

?>
<?php if($page=='Profile') 
{ ?>
<ul class="dashboardLinkVer">
            <li><a href="<?php echo base_url()."dashboard/view_profile/".$userId; ?>" <?php if($currUrl=='view_profile') echo "class='active'" ?>>View Profile</a></li>
			<li><a href="<?php echo base_url()."dashboard/edit_profile/".$userId; ?>" <?php if($currUrl=='edit_profile') echo "class='active'" ?>>Edit Profile</a></li>
			<li><a href="<?php echo base_url()."dashboard/address" ?>" <?php if($currUrl=='address') echo "class='active'" ?>>Add Address</a></li>
			<li><a href="<?php echo base_url()."dashboard/list_address" ?>" <?php if($currUrl=='list_address') echo "class='active'" ?>>All Address</a></li>
            <li><a href="<?php echo base_url()."dashboard/edit_photos/".$userId; ?>" <?php if($currUrl=='edit_photos') echo "class='active'" ?>>Photos</a></li>
            <li><a href="<?php echo base_url()."dashboard/edit_trust_verification/".$userId; ?>" <?php if($currUrl=='edit_trust_verification') echo "class='active'" ?>>Trust and Verification</a></li>
            <li><a href="<?php echo base_url()."dashboard/review_about_you/".$userId; ?>" <?php if($currUrl=='review_about_you' || $currUrl=='review_by_you') echo "class='active'" ?>>Reviews</a></li>
<li><a href="<?php echo base_url()."dashboard/verify_mobile"; ?>" <?php if($currUrl=='verify_mobile' || $currUrl=='verify_mobile') echo "class='active'" ?>>Verify your mobile Number</a></li>
</ul>
<?php } ?>

<?php if($page=='Listing') 
{ ?>
<ul class="dashboardLinkVer">
            <li><a href="<?php echo base_url()."dashboard/listing/" ?>" <?php if($currUrl=='listing') echo "class='active'" ?>>Your Listing</a></li>
            <li><a href="<?php echo base_url()."dashboard/on_rent/" ?>" <?php if($currUrl=='on_rent' || $currUrl=='addProductPhoto') echo "class='active'" ?>>On rent</a></li>
</ul>
<?php } ?>

<?php if($page=='Borrow') 
{ ?>
<ul class="dashboardLinkVer">
            <li><a href="<?php echo base_url()."dashboard/borrow_approval_pending/" ?>" <?php if($currUrl=='borrow_approval_pending') echo "class='active'" ?>>Approval Pending</a></li>
            <li><a href="<?php echo base_url()."dashboard/borrow_disapproved/" ?>" <?php if($currUrl=='borrow_disapproved') echo "class='active'" ?>>Disapproved</a></li>
			<li><a href="<?php echo base_url()."dashboard/borrow_order_history/" ?>" <?php if($currUrl=='borrow_order_history' || $currUrl=='addProductPhoto') echo "class='active'" ?>>Order history</a></li>
</ul>
<?php } ?>