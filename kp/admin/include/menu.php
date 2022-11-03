<?php
if($_SESSION['curruser_login_id']=="" || $_SESSION['curruser_email_id']=="")
{  
	echo"<meta http-equiv=refresh content=\"0;url=index.php\">";
}
?>
<?php 
$url = $_SERVER['PHP_SELF'];
#for Local
$attach = "/gjepc/kp/admin/";
#for Live
//$attach = "/admin/";
?>

<div id="smoothmenu1" class="ddsmoothmenu ">
<ul>
<?php
if($_SESSION['curruser_role']=="Super Admin")
{
?>  
			<li><a href="#" <?php if(($url == $attach.'manage_admin.php') || ($url == $attach. 'manage_admin_bank.php') || ($url == $attach. 'manage_admin_custom.php')) { ?> class="selected" <?php } ?>>Manage users</a> 
		
            <ul class="terms">
             	<li><a href="manage_admin.php?action=view" >Manage Admin</a></li>
            	<li><a href="manage_admin_bank.php?action=view">Manage Bank</a></li>
             	<li><a href="manage_admin_custom.php?action=view">Manage Custom</a></li>
    		</ul>                    
             
  			<li><a href="import_export_view.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Import/Export Data</a></li>
    		<li><a href="uploaddata.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Upload Import/Export Data</a></li>
            <li><a href="#"  <?php if(($url == $attach.'download_application.php') || ($url == $attach.'update_application.php') || ($url == $attach.'search_application.php') || ($url == $attach.'search_application.php') || ($url == $attach.'search_payment.php'))  { ?> class="selected" <?php } ?> >Application</a>
         <ul class="terms">
        	<!--<li><a href="download_application.php?action=view">Download Application</a></li>
            <li><a href="upload_application.php?action=view">Upload Application</a></li>-->
            <li><a href="manage_export_series.php?action=view">Manage Export Series</a></li>
            <li><a href="search_application.php?action=view">Search Application</a></li>
            <li><a href="search_payment.php?action=view">Search Payments</a></li>
            <li><a href="export_advol.php?action=view">Download Advolerem Report</a></li>
        </ul>
			</li>
     
			<li><a href="#" <?php if(($url == $attach.'member_search.php') || ($url == $attach.'agent_search.php')) { ?> class="selected" <?php } ?>>Manage Master Data</a>
   			<ul class="terms">
				<li><a href="member_search.php?action=view">Search Member</a></li>
				<li><a href="agent_search.php?action=view">Search Agent</a></li>
				<li><a href="manage_foreign_party.php?action=view">Search Foreign Party</a></li>
    		</ul>
</li>

<li><a href="#" <?php if(($url == $attach.'committee_administration.php') || ($url == $attach.'pm_bd_sub_committee.php') || ($url == $attach.'ideal_cut_newsletter.php') || ($url == $attach.'tender.php') || ($url == $attach.'seminars.php') || ($url == $attach.'kimberly_info.php') || ($url == $attach.'circulars.php') || ($url == $attach.'circulars_to_member.php') || ($url == $attach.'exhibition_permission.php') || ($url == $attach.'notifications.php') || ($url == $attach.'policy_handbook.php') ||($url == $attach.'union_budget.php') ||($url == $attach.'statistics_export.php') || ($url == $attach.'statistics_import.php') || ($url == $attach.'trade_information.php') ||($url == $attach.'trade_news.php') ||($url == $attach.'press_release.php') ||($url == $attach.'careers.php')) { ?> class="selected" <?php } ?>>Manage Master</a>
   
   <ul class="terms">
        <li><a href="manage_designation.php?action=view">Designation</a></li>
        <li><a href="manage_type_of_member.php?action=view">Type Of Member</a></li>
        <li><a href="manage_status.php?action=view">Status</a></li>
        <li><a href="manage_type_of_application.php?action=view">Type Of Application</a></li>
        <li><a href="manage_hs_code.php?action=view">HS Code</a></li>
        <li><a href="manage_application_fee.php?action=view">Application Fee</a></li>
        <li><a href="manage_courier_charges.php?action=view">Courier Charges</a></li>
        <li><a href="manage_location.php?action=view">Location</a></li>
        <li><a href="manage_dow_up_parameter.php?action=view">Download/Upload Parameters </a></li>
        <li><a href="manage_payment_type.php?action=view">Payment Type</a></li>
        <li><a href="manage_payment_status.php?action=view">Payment Status</a></li>
    </ul>
</li>    

<li><a href="manage_banner.php?action=view" <?php if($url == $attach.'manage_banner.php') { ?> class="selected" <?php } ?>>Manage Banner</a></li>
<li><a href="preliminary_event.php?action=view" <?php if($url == $attach.'preliminary_event.php') { ?> class="selected" <?php } ?>>Manage Plenary Event</a></li>

</li>

<li><a href="import_member_details.php?action=view" <?php if($url == $attach.'import_member_details.php') { ?> class="selected" <?php } ?>>Import Member Data</a></li>
<li><a href="non_member.php?action=view" <?php if($url == $attach.'import_member_details.php') { ?> class="selected" <?php } ?>>Non Member GST</a></li>
<?php
}else if($_SESSION['curruser_role']=="bank" || $_SESSION['curruser_role']=="custom")
{
?>			
	<li><a href="import_export_view.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Import/Export Data</a></li>
    <li><a href="report.php" <?php if($url == $attach.'manage_admin.php'){ ?> class="selected" <?php } ?>>Report generation</a></li>
    <?php if(isset($_REQUEST['erp_id']) && $_REQUEST['erp_id']>0) { ?>
    <li><a href="reportexcel.php?erp_id=<?php echo $_REQUEST['erp_id'];  ?>&action=<?php echo $_REQUEST['action'];  ?>" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Report </a></li>
    <?php } ?>
<?php
}else
{
	if(preg_match('/1/',$_SESSION['curruser_admin_access']))
	{
?>	
	<li><a href="manage_admin.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Manage Admin</a></li>
<?php
	}
	if(preg_match('/2/',$_SESSION['curruser_admin_access']))
	{
?>

   <li><a href="#" <?php if(($url == $attach.'member_search.php') || ($url == $attach.'agent_search.php')) { ?> class="selected" <?php } ?>>Manage Members</a>
   
   <ul class="terms">
        <li><a href="member_search.php?action=view">Search Member</a></li>
        <li><a href="agent_search.php?action=view">Search Agent</a></li>
    </ul>
</li>
<?php 
	}if(preg_match('/3/',$_SESSION['curruser_admin_access']))
	{
?>
	
    <li><a href="#" <?php if(($url == $attach.'committee_administration.php') || ($url == $attach.'pm_bd_sub_committee.php') || ($url == $attach.'ideal_cut_newsletter.php') || ($url == $attach.'tender.php') || ($url == $attach.'seminars.php') || ($url == $attach.'kimberly_info.php') || ($url == $attach.'circulars.php') || ($url == $attach.'circulars_to_member.php') || ($url == $attach.'exhibition_permission.php') || ($url == $attach.'notifications.php') || ($url == $attach.'policy_handbook.php') ||($url == $attach.'union_budget.php') ||($url == $attach.'statistics_export.php') || ($url == $attach.'statistics_import.php') || ($url == $attach.'trade_information.php') ||($url == $attach.'trade_news.php') ||($url == $attach.'press_release.php') ||($url == $attach.'careers.php')) { ?> class="selected" <?php } ?>>Manage Master</a>
   
   <ul class="terms">
        <li><a href="committee_administration.php?action=view">Designation</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Type Of Member</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Status</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Type Of Application</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">HS Code</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Application Fee</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Courier Charges</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Location</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Download/Upload parameters </a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Payment Type</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">Payment Status</a></li>
    </ul>
</li> 

<?php	
	}
	if(preg_match('/4/',$_SESSION['curruser_admin_access']))
	{
?>
<li><a href="#"  <?php if(($url == $attach.'download_application.php') || ($url == $attach.'update_application.php') || ($url == $attach.'search_application.php') || ($url == $attach.'search_application.php') || ($url == $attach.'search_payment.php'))  { ?> class="selected" <?php } ?> >Application</a>
  <ul class="terms">
    <!--<li><a href="download_application.php?action=view">Download Application</a></li>
    <li><a href="upload_application.php?action=view">Upload Application</a></li>-->
    <li><a href="search_application.php?action=view">Search Application</a></li>
    <li><a href="search_payment.php?action=view">Search Payments</a></li>
  </ul>
</li>
<?php
    }
	if(preg_match('/5/',$_SESSION['curruser_admin_access']))
	{
?>

	<li><a href="manage_banner.php?action=view" <?php if($url == $attach.'manage_banner.php') { ?> class="selected" <?php } ?>>Manage Banner</a></li>
	<?php 
	}	
	if(preg_match('/6/',$_SESSION['curruser_admin_access']))
	{
?>
   
    <li><a href="import_member_details.php?action=view" <?php if($url == $attach.'import_member_details.php') { ?> class="selected" <?php } ?>>Import Member Data</a></li>
    <li>
      <?php 
	}
}
?>
</li>
</ul>
<ul>
  <p>&nbsp;    </p>
</ul>
</div>
        
</div>