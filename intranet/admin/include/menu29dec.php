<?php
if($_SESSION['curruser_login_id']=="" || $_SESSION['curruser_email_id']=="")
{  
	echo"<meta http-equiv=refresh content=\"0;url=index.php\">";
}
?>
<?php 
 $url = $_SERVER['PHP_SELF'];
#for Local
 $attach = "/Gjepc_intranet/admin/";
#for Live
//$attach = "/admin/";
?>

<div id="smoothmenu1" class="ddsmoothmenu ">
<ul> 
<?php
if($_SESSION['curruser_role']=="Super Admin")
{
?>               
    <li><a href="manage_admin.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Manage Admin</a></li>
    <li style="background:none;"> | </li>
    <li><a href="#"  <?php if(($url == $attach.'manage_policies.php') || ($url== $attach.'manage_traning_calender.php')) { ?> class="selected" <?php } ?> >Manage PDF</a>
         <ul class="terms">
        	<li><a href="manage_policies.php?action=view">Manage Policies</a></li>
            <li><a href="manage_traning_calender.php?action=view">Manage Traning Calender</a></li>
            
        </ul>
	</li>
     
<li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'manage_videos.php') || ($url == $attach.'manage_images.php')) { ?> class="selected" <?php } ?>>Manage Gallary</a>
   
   <ul class="terms">
        <li><a href="manage_videos.php?action=view">Manage Videos</a></li>
        <li><a href="manage_gallary.php?action=view">Manage Images</a></li>
    </ul>
</li>
<li style="background:none;"> | </li>
<!--<li><a href="#" <?php if(($url == $attach.'committee_administration.php') || ($url == $attach.'pm_bd_sub_committee.php') || ($url == $attach.'ideal_cut_newsletter.php') || ($url == $attach.'tender.php') || ($url == $attach.'seminars.php') || ($url == $attach.'kimberly_info.php') || ($url == $attach.'circulars.php') || ($url == $attach.'circulars_to_member.php') || ($url == $attach.'exhibition_permission.php') || ($url == $attach.'notifications.php') || ($url == $attach.'policy_handbook.php') ||($url == $attach.'union_budget.php') ||($url == $attach.'statistics_export.php') || ($url == $attach.'statistics_import.php') || ($url == $attach.'trade_information.php') ||($url == $attach.'trade_news.php') ||($url == $attach.'press_release.php') ||($url == $attach.'careers.php')) { ?> class="selected" <?php } ?>>Manage Master</a>
   
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
</li>    -->
<!--<li style="background:none;"> | </li>-->
<li><a href="manage_mis.php?action=view" <?php if($url == $attach.'manage_mis.php') { ?> class="selected" <?php } ?>>Manage MIS</a></li>


</li>
<li style="background:none;"> | </li>
<li><a href="manage_announcement.php?action=view" <?php if($url == $attach.'manage_announcement.php') { ?> class="selected" <?php } ?>>Manage Annoucements</a></li>
<li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'manage_polls.php') || ($url == $attach.'manage_forum.php') || ($url == $attach.'manage_suggestions.php')) { ?> class="selected" <?php } ?>>Manage Polls & Forum</a>
<ul class="terms">
		<li><a href="manage_polls.php?action=view">Manage Polls</a></li>
        <li><a href="manage_forum.php?action=view">Manage Forum</a></li>
        <li><a href="manage_suggestions.php?action=view">Manage Suggestions </a></li>

</ul>
		


</li><li style="background:none;"> | </li>
<li><a href="manage_directory.php?action=view" <?php if($url == $attach.'manage_health.php') { ?> class="selected" <?php } ?>>Manage Directory </a></li>
<!--<li style="background:none;"> | </li>
<li><a href="manage_traning_calender.php?action=view" <?php if($url == $attach.'manage_traning_calender.php') { ?> class="selected" <?php } ?>>Manage Traning Calender</a></li>-->

<!--<li style="background:none;"> | </li>
<li><a href="manage_forum.php?action=view" <?php if($url == $attach.'manage_forum.php') { ?> class="selected" <?php } ?>>Manage Forum</a></li>-->




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
    <li style="background:none;"> | </li>
   <li><a href="#"  <?php if(($url == $attach.'Manage_Policies.php') || ($url== $attach.'manage_traning_calender.php')) { ?> class="selected" <?php } ?> >Manage PDF</a>
         <ul class="terms">
        	<li><a href="Manage_Policies.php?action=view">Manage Policies</a></li>
            <li><a href="manage_traning_calender.php?action=view">Manage Traning Calender</a></li>
            
        </ul>
	</li>
<?php 
	}if(preg_match('/3/',$_SESSION['curruser_admin_access']))
	{
?>
	<li style="background:none;"> | </li>
    <li><a href="#" <?php if(($url == $attach.'manage_images.php') || ($url == $attach.'manage_videos.php')) { ?> class="selected" <?php } ?>>Manage Gallary</a>
   
   <ul class="terms">
        <li><a href="manage_images.php?action=view">Manage images</a></li>
        <li><a href="manage_videos.php?action=view">Manage Videos</a></li>
        
        
    </ul>
</li> 

<?php	
	}
	if(preg_match('/4/',$_SESSION['curruser_admin_access']))
	{
?>	
	<li style="background:none;"> | </li>
	<li><a href="#" <?php if(($url == $attach.'manage_polls.php') || ($url == $attach.'manage_forum.php') || ($url == $attach.'manage_suggestions.php')) { ?> class="selected" <?php } ?>>Manage Polls & Forum</a>
<ul class="terms">
		<li><a href="manage_polls.php?action=view">Manage Polls</a></li>
        <li><a href="manage_forum.php?action=view">Manage Forum</a></li>
        <li><a href="manage_suggestions.php?action=view">Manage Suggestions </a></li>

</ul>
		


</li>

<?php
    }
	if(preg_match('/5/',$_SESSION['curruser_admin_access']))
	{
?>
	<!--<li style="background:none;"> | </li>
	<li><a href="manage_traning_calender.php?action=view" <?php if($url == $attach.'manage_traning_calender.php') { ?> class="selected" <?php } ?>>Manage Training Calender</a></li>-->
<?php 
	}	
	if(preg_match('/6/',$_SESSION['curruser_admin_access']))
	{
?>
    <li style="background:none;"> | </li>
    <li><a href="import_member_details.php?action=view" <?php if($url == $attach.'import_member_details.php') { ?> class="selected" <?php } ?>>Import Member Data</a></li>
<?php 
	}
}


?>
<li style="background:none;"> | </li>
<li><a href="manage_health.php?action=view" <?php if($url == $attach.'manage_health.php') { ?> class="selected" <?php } ?>>Manage Health Tip </a></li>
         
</ul>
</div>

























        
     	
     
        
      
       
        
       
        
     
        
       
        
    
        
      
     
        
        
        
      </div>

























