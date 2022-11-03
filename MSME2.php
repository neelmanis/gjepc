<?php 
include 'include/header.php'; 
include 'db.inc.php'; 
include('functions.php');

$limit=10;
$page=$_GET['p'];
if($page=='')
{
  $page=1;
  $start=0;
} else {
  $start=$limit*($page-1);
}
?>

<section>
	<div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>
        <ul class="d-flex breadcrumb">
    		<li><a href="index.php">Home</a></li>
    		<li class="active">MSME</li>
  		</ul>
    </div>

	<div class="container inner_container">	
		<div class="row mb">    	
            <div class="col-12">
            	<div class="innerpg_title">
              		<h1>Micro Small And Medium Enterprises Sector</h1>
                </div>
       		</div>
            
            <div class="col-12">
            
            	<ol class="inner_under_listing msme post_seminar">
          			<li><strong>1.</strong> Government Assistance Schemes</li>
                </ol>
            
            	<ul class="inner_under_listing msme post_seminar pl-3">
                	<li>Central Government Scheme <span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li>State Government Scheme<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
               	</ul>
            
            	<ol class="inner_under_listing msme post_seminar">
          			<li><strong>2.</strong> GJEPC Initiatives</li>
                </ol>
                
            	<ul class="inner_under_listing msme post_seminar pl-3">
          			<li>Membership/Micro-membership<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
					<li>Parichay Card<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li>Swasthya Kosh/Swasthya Ratna<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
					<li>Jewellery park <span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
					<li>Common Facility Center<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
					<li>Cluster development<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li>IIJS Premier/Signature exhibition /Buyer Seller meets etc<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li>Mobile App<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li>Help desk/Call center<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li>Skill development and training for Artisans<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
               	</ul>
                
                
                <ol class="inner_under_listing msme post_seminar">
          			<li><strong>3.</strong> Udhyog Aadhar Registration (Annexure-8) (Annexure-13)<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
					<li><strong>4.</strong> MSME Data Bank Registration (Annexure-9)<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li><strong>5.</strong> Contact details MSME DI, DIC & NSIC Offices  (Annexure-11) (Annexure-12)<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
					<li><strong>6.</strong> Latest updates and revised Schemes: MSME Notification/Circulars (Annexure-14)  ( Annexure-21)<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
					<li><strong>7.</strong> FAQ's (Annexure-10)<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
					<li><strong>8.</strong> Feedback form (Annexure-17)<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li><strong>9.</strong> MSME Activity reports: Seminars, Workshops, Training, Udyog Aadhar and Parichay Card Shibirs (Annexure-18)<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    <li><strong>10.</strong> Photo Gallery of Events (Annexure-24)<span><a href="#" target="_blank">English</a> / <a href="#" target="_blank">Hindi </a></span></li>
                    
               	</ol>
                
                <style>
				ol.inner_under_listing li {padding-left:0; }
				ol.inner_under_listing li:before {display:none;}
				.post_seminar span {position:absolute; right:0; font-weight:normal;}
				</style>
            
            	
            
            </div>

</div>
</div>
</div>
<?php include 'include/footer.php'; ?>