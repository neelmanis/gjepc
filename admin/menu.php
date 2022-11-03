
<?php
if($_SESSION['curruser_login_id']=="" || $_SESSION['curruser_email_id']=="")
{  
	echo"<meta http-equiv=refresh content=\"0;url=index.php\">";
}
?>
<?php 
$url = $_SERVER['PHP_SELF'];
#for Local
//$attach = "/gjepc/admin/";
#for Live
$attach = "/admin/";
?>

<div id="smoothmenu1" class="ddsmoothmenu ">
<ul> 
<?php
if($_SESSION['curruser_role']=="Super Admin")
{
?>               
    <li><a href="manage_admin.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Manage Admin</a></li>
    <li style="background:none;"> | </li>
    <li><a href="#"  <?php if(($url == $attach.'manage_export_amount.php') || ($url == $attach.'committee_administration_category.php') || ($url == $attach.'pm_bd_sub_committee_category.php') || ($url == $attach.'ideal_cut_newsletter_category.php') || ($url == $attach.'circulars_category.php') || ($url == $attach.'circulars_to_member_category.php')  || ($url == $attach.'notifications_category.php') || ($url == $attach.'policy_handbook_category.php') ||($url == $attach.'union_budget_category.php') ||($url == $attach.'statistics_export_category.php') || ($url == $attach.'statistics_import_category.php')  || ($url == $attach.'renewal_deadline.php'))  { ?> class="selected" <?php } ?> >Master</a>
         <ul class="terms">
        	<li><a href="manage_export_amount.php?action=view">Export Amount Master</a></li>
            <li><a href="committee_administration_category.php?action=view">Committee Administration Category</a></li>
            <li><a href="pm_bd_sub_committee_category.php?action=view">PM & BD Sub-Committee Category</a></li>
            <li><a href="ideal_cut_newsletter_category.php?action=view">Ideal Cut Newsletter Category</a></li>
            <li><a href="circulars_category.php?action=view">Circulars Category</a></li>
            <li><a href="circulars_to_member_category.php?action=view">Circulars To Member Category</a></li>
            <li><a href="notifications_category.php?action=view">Notifications Category</a></li>
            <li><a href="policy_handbook_category.php?action=view">Policy & Handbook Category</a></li>
            <li><a href="union_budget_category.php?action=view">Union Budget Category</a></li>
            <li><a href="statistics_export_category.php?action=view">Statistics Export Category</a></li>
            <li><a href="statistics_import_category.php?action=view">Statistics Import Category</a></li>
            <li><a href="renewal_deadline.php?action=view">Renewal Deadline</a></li>
        </ul>
	</li>

<li style="background:none;"> | </li>
<li><a href="manage_registration.php?action=view" <?php if($url == $attach.'manage_registration.php') { ?> class="selected" <?php } ?>>Registration</a></li>

<li style="background:none;"> | </li>
<li><a href="membership.php?action=view" <?php if(($url == $attach.'membership.php') || ($url == $attach.'information_form.php')|| ($url == $attach.'communication_form.php')|| ($url == $attach.'challan_form.php')|| ($url == $attach.'approval_form.php')) { ?> class="selected" <?php } ?>>Membership</a></li>
     
<li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'committee_administration.php') || ($url == $attach.'pm_bd_sub_committee.php') || ($url == $attach.'ideal_cut_newsletter.php') || ($url == $attach.'tender.php') || ($url == $attach.'seminars.php') || ($url == $attach.'kimberly_info.php') || ($url == $attach.'circulars.php') || ($url == $attach.'circulars_to_member.php') || ($url == $attach.'exhibition_permission.php') || ($url == $attach.'notifications.php') || ($url == $attach.'policy_handbook.php') ||($url == $attach.'union_budget.php') ||($url == $attach.'statistics_export.php') || ($url == $attach.'statistics_import.php') || ($url == $attach.'trade_information.php') ||($url == $attach.'trade_news.php') ||($url == $attach.'press_release.php') ||($url == $attach.'careers.php') ||($url == $attach.'whats_new.php')) { ?> class="selected" <?php } ?>>Manage Pages</a>
   
   <ul class="terms">
        <li><a href="committee_administration.php?action=view">Committee Administration</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">PM & BD Sub-Committee</a></li>
        <li><a href="ideal_cut_newsletter.php?action=view">Ideal Cut Newsletter</a></li>
        <li><a href="tender.php?action=view">Tender</a></li>
        <li><a href="tender.php?action=view">Applied Tenders List</a></li>
        <li><a href="seminars.php?action=view">Seminars</a></li>
        <li><a href="kimberly_info.php?action=view">Kimberly Info</a></li>
        <li><a href="circulars.php?action=view">Circulars</a></li>
        <li><a href="circulars_to_member.php?action=view">Circulars To Member</a></li>
        <li><a href="exhibition_permission.php?action=view">Exhibition Permission</a></li>
        <li><a href="notifications.php?action=view">Notifications</a></li>
        <li><a href="policy_handbook.php?action=view">Policy & Handbook</a></li>
        <li><a href="union_budget.php?action=view">Union Budget</a></li>
        <li><a href="statistics_export.php?action=view">Statistics Export</a></li>
        <li><a href="statistics_import.php?action=view">Statistics Import</a></li>
        <li><a href="trade_information.php?action=view">Trade Information</a></li>
        <li><a href="trade_news.php?action=view">Trade News</a></li>
        <li><a href="news.php?action=view">News</a></li>
        <li><a href="trade_show.php?action=view">Trade Show</a></li>
        <li><a href="press_release.php?action=view">Press Release</a></li>
        <li><a href="careers.php?action=view">Careers</a></li>
        <li><a href="marketing_development_assistance.php?action=view">Marketing Development Assistance</a></li>
        <li><a href="gold_rate.php?action=view">Glod Rate</a></li>
        <li><a href="whats_new.php?action=view">Whats New</a></li>
        
    </ul>
</li>

    
<li style="background:none;"> | </li>
<li><a href="manage_banner.php?action=view" <?php if($url == $attach.'manage_banner.php') { ?> class="selected" <?php } ?>>Manage Banner</a></li>

<li style="background:none;"> | </li>
<li><a href="http://www.gjepc.org/dataport/index.php" <?php if($url == $attach.'') { ?> class="selected" <?php } ?> target="_blank">Manage DataPort</a></li>

<li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'iijs_pvr.php') || ($url == $attach.'iijs_information_pvr.php') || ($url == $attach.'iijs_obmp_profile_pvr.php') || ($url == $attach.'iijs_participation_&_payment_details_pvr.php') || ($url == $attach.'iijs_change_photo_form_pvr.php') || ($url == $attach.'iijs_approval_form_pvr.php') || ($url == $attach.'iijs_ivr.php') || ($url == $attach.'iijs_personal_information_IVR.php') || ($url == $attach.'iijs_obmp_info_IVR.php') || ($url == $attach.'iijs_photo_form_IVR.php') || ($url == $attach.'iijs_approval_form_ivr.php') || ($url == $attach.'iijs_hotel.php')) { ?> class="selected" <?php } ?>>IIJS 2014</a>
   <ul class="terms">
        <li><a href="iijs_exhibitor_rgistration.php">Exhibitor Registration</a></li>
        <li><a href="iijs_pvr.php">PVR</a></li>
        <li><a href="iijs_ivr.php">IVR</a></li>
        <li><a href="iijs_hotel.php">Hotel Registration</a></li>
        
    </ul>
</li>

<li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'pvr.php') || ($url == $attach.'information_pvr.php') || ($url == $attach.'obmp_profile_pvr.php') || ($url == $attach.'participation_&_payment_details_pvr.php') || ($url == $attach.'change_photo_form_pvr.php') || ($url == $attach.'approval_form_pvr.php') || ($url == $attach.'ivr.php') || ($url == $attach.'personal_information_IVR.php') || ($url == $attach.'obmp_info_IVR.php') || ($url == $attach.'photo_form_IVR.php') || ($url == $attach.'approval_form_ivr.php') || ($url == $attach.'hotel.php')) { ?> class="selected" <?php } ?>>Signature 2014</a>
   <ul class="terms">
        <li><a href="#">Exhibitor Registration</a></li>
        <li><a href="pvr.php">PVR</a></li>
        <li><a href="ivr.php">IVR</a></li>
        <li><a href="hotel.php">Hotel</a></li>
  
    </ul>
</li>

<li style="background:none;"> | </li>
<li><a href="http://helpdesk.gjepc.org/cpanel/" <?php if($url == $attach.'') { ?> class="selected" <?php } ?> target="_blank">HelpDesk</a></li>
</li>

<?php
}else
{
?>
<li><a href="#" <?php if(($url == $attach.'iijs_pvr.php') || ($url == $attach.'iijs_information_pvr.php') || ($url == $attach.'iijs_obmp_profile_pvr.php') || ($url == $attach.'iijs_participation_&_payment_details_pvr.php') || ($url == $attach.'iijs_change_photo_form_pvr.php') || ($url == $attach.'iijs_approval_form_pvr.php') || ($url == $attach.'iijs_ivr.php') || ($url == $attach.'iijs_personal_information_IVR.php') || ($url == $attach.'iijs_obmp_info_IVR.php') || ($url == $attach.'iijs_photo_form_IVR.php') || ($url == $attach.'iijs_approval_form_ivr.php') || ($url == $attach.'iijs_hotel.php')) { ?> class="selected" <?php } ?>>IIJS 2014</a>
   <ul class="terms">
        <?php
		if(preg_match('/L/',$_SESSION['curruser_admin_access']))
		{
        echo "<li><a href='iijs_exhibitor_rgistration.php'>Exhibitor Registration</a></li>";
		}
		if(preg_match('/I/',$_SESSION['curruser_admin_access']))
		{
        echo "<li><a href='iijs_ivr.php'>IVR</a></li>";
		}
		if(preg_match('/J/',$_SESSION['curruser_admin_access']))
		{
        echo "<li><a href='iijs_pvr.php'>PVR</a></li>";
		}
		if(preg_match('/K/',$_SESSION['curruser_admin_access']))
		{
        echo "<li><a href='iijs_hotel.php'>Hotel Registration</a></li>";
		}
		?>
    </ul>
</li>
<?php

	if(preg_match('/A/',$_SESSION['curruser_admin_access']))
	{
?>	
	<li><a href="manage_admin.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Manage Admin</a></li>
<?php
	}
	if(preg_match('/B/',$_SESSION['curruser_admin_access']))
	{
?>
    <li style="background:none;"> | </li>
    <li><a href="manage_registration.php?action=view" <?php if($url == $attach.'manage_registration.php') { ?> class="selected" <?php } ?>>Registration</a></li>

<?php 
	}if(preg_match('/C/',$_SESSION['curruser_admin_access']))
	{
?>
	<li style="background:none;"> | </li>
    <li><a href="#"  <?php if(($url == $attach.'manage_export_amount.php') || ($url == $attach.'committee_administration_category.php') || ($url == $attach.'pm_bd_sub_committee_category.php') || ($url == $attach.'ideal_cut_newsletter_category.php') || ($url == $attach.'circulars_category.php') || ($url == $attach.'circulars_to_member_category.php')  || ($url == $attach.'notifications_category.php') || ($url == $attach.'policy_handbook_category.php') ||($url == $attach.'union_budget_category.php') ||($url == $attach.'statistics_export_category.php') || ($url == $attach.'statistics_import_category.php'))  { ?> class="selected" <?php } ?> >Master</a>
         <ul class="terms">
        	<li><a href="manage_export_amount.php?action=view">Export Amount Master</a></li>
            <li><a href="committee_administration_category.php?action=view">Committee Administration Category</a></li>
            <li><a href="pm_bd_sub_committee_category.php?action=view">PM & BD Sub-Committee Category</a></li>
            <li><a href="ideal_cut_newsletter_category.php?action=view">Ideal Cut Newsletter Category</a></li>
            <li><a href="circulars_category.php?action=view">Circulars Category</a></li>
            <li><a href="circulars_to_member_category.php?action=view">Circulars To Member Category</a></li>
            <li><a href="notifications_category.php?action=view">Notifications Category</a></li>
            <li><a href="policy_handbook_category.php?action=view">Policy & Handbook Category</a></li>
            <li><a href="union_budget_category.php?action=view">Union Budget Category</a></li>
            <li><a href="statistics_export_category.php?action=view">Statistics Export Category</a></li>
            <li><a href="statistics_import_category.php?action=view">Statistics Import Category</a></li>
        </ul>
	</li>

<?php	
	}
	if(preg_match('/D/',$_SESSION['curruser_admin_access']))
	{
?>	
	<li style="background:none;"> | </li>
	<li><a href="membership.php?action=view" <?php if(($url == $attach.'membership.php') || ($url == $attach.'information_form.php')|| ($url == $attach.'communication_form.php')|| ($url == $attach.'challan_form.php')|| ($url == $attach.'approval_form.php')) { ?> class="selected" <?php } ?>>Membership</a></li>
<li style="background:none;"> | </li>
	<li><a href="/dataport/admin_rcmc_status.php" target="_blank">Set Rcmc Status</a></li>

<?php
    }
	if(preg_match('/E/',$_SESSION['curruser_admin_access']))
	{
?>
	<li style="background:none;"> | </li>
	<li><a href="#" <?php if(($url == $attach.'committee_administration.php') || ($url == $attach.'pm_bd_sub_committee.php') || ($url == $attach.'ideal_cut_newsletter.php') || ($url == $attach.'tender.php') || ($url == $attach.'seminars.php') || ($url == $attach.'kimberly_info.php') || ($url == $attach.'circulars.php') || ($url == $attach.'circulars_to_member.php') || ($url == $attach.'exhibition_permission.php') || ($url == $attach.'notifications.php') || ($url == $attach.'policy_handbook.php') ||($url == $attach.'union_budget.php') ||($url == $attach.'statistics_export.php') || ($url == $attach.'statistics_import.php') || ($url == $attach.'trade_information.php') ||($url == $attach.'trade_news.php') ||($url == $attach.'press_release.php') ||($url == $attach.'careers.php') ||($url == $attach.'whats_new.php')) { ?> class="selected" <?php } ?>>Manage Pages</a>
   
   <ul class="terms">
        <li><a href="committee_administration.php?action=view">Committee Administration</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">PM & BD Sub-Committee</a></li>
        <li><a href="ideal_cut_newsletter.php?action=view">Ideal Cut Newsletter</a></li>
        <li><a href="tender.php?action=view">Tender</a></li>
        <li><a href="seminars.php?action=view">Seminars</a></li>
        <li><a href="kimberly_info.php?action=view">Kimberly Info</a></li>
        <li><a href="circulars.php?action=view">Circulars</a></li>
        <li><a href="circulars_to_member.php?action=view">Circulars To Member</a></li>
        <li><a href="exhibition_permission.php?action=view">Exhibition Permission</a></li>
        <li><a href="notifications.php?action=view">Notifications</a></li>
        <li><a href="policy_handbook.php?action=view">Policy & Handbook</a></li>
        <li><a href="union_budget.php?action=view">Union Budget</a></li>
        <li><a href="statistics_export.php?action=view">Statistics Export</a></li>
        <li><a href="statistics_import.php?action=view">Statistics Import</a></li>
        <li><a href="trade_information.php?action=view">Trade Information</a></li>
        <li><a href="trade_news.php?action=view">Trade News</a></li>
        <li><a href="news.php?action=view">News</a></li>
        <li><a href="trade_show.php?action=view">Trade Show</a></li>
        <li><a href="press_release.php?action=view">Press Release</a></li>
        <li><a href="careers.php?action=view">Careers</a></li>
        <li><a href="marketing_development_assistance.php?action=view">Marketing Development Assistance</a></li>
        <li><a href="gold_rate.php?action=view">Glod Rate</a></li>
        <li><a href="whats_new.php?action=view">Whats New</a></li>
        
    </ul>

<?php 
	}
	if(preg_match('/F/',$_SESSION['curruser_admin_access']))
	{
?>	
	<li style="background:none;"> | </li>
	<li><a href="manage_banner.php?action=view" <?php if($url == $attach.'manage_banner.php') { ?> class="selected" <?php } ?>>Manage Banner</a></li>

<?php 
	}if(preg_match('/G/',$_SESSION['curruser_admin_access']))
	{
?>	
	<li style="background:none;"> | </li>
	<li><a href="http://www.gjepc.org/dataport/index.php" <?php if($url == $attach.'') { ?> class="selected" <?php } ?> target="_blank">Manage DataPort</a></li>
<?php
	}
	if(preg_match('/H/',$_SESSION['curruser_admin_access']))
	{
?>
    <li style="background:none;"> | </li>
<li><a href="http://helpdesk.gjepc.org/cpanel/" <?php if($url == $attach.'') { ?> class="selected" <?php } ?> target="_blank">HelpDesk</a></li>

<?php 
	}
}

?>

  
 
         
</ul>
</div>
      </div>

























