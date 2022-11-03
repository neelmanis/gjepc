<?php
if($_SESSION['curruser_login_id']=="" || $_SESSION['curruser_email_id']=="")
{  
	echo"<meta http-equiv=refresh content=\"0;url=index.php\">";
}
?>
<?php 
 $url = $_SERVER['PHP_SELF'];
#for Local
 //$attach = "/Gjepc_intranet/admin/";
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
	<li><a href="manage_category.php?action=view" <?php if($url == $attach.'manage_category.php')  { ?> class="selected" <?php } ?>>Manage Category</a></li>
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

<li><a href="manage_mis.php?action=view" <?php if($url == $attach.'manage_mis.php') { ?> class="selected" <?php } ?>>Manage MIS</a></li>



<li><a href="manage_health.php?action=view" <?php if($url == $attach.'manage_health.php') { ?> class="selected" <?php } ?>>Manage Health</a></li>


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
<li><a href="manage_directory.php?action=view" <?php if($url == $attach.'manage_directory.php') { ?> class="selected" <?php } ?>>Manage Directory </a></li>

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

         
</ul>
</div>

























        
     	
     
        
      
       
        
       
        
     
        
       
        
    
        
      
     
        
        
        
      </div>

























