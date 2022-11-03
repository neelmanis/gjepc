<?php session_start(); ob_start();?>
<?php
$slug = filter($_REQUEST['news']);
$sql= "select * from `news_master` WHERE 1 and status='1' and slug=?";
$stmt = $conn -> prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <title><?php echo filter($rows['name']);?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo filter($rows['name']);?>">
    <meta property="og:title" content="<?php echo filter($rows['name']);?>" />
    <meta property="og:url" content="https://gjepc.org/news_detail.php?news=<?php echo $slug;?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://gjepc.org/admin/images/news_images/<?php echo $rows['news_pic'];?>" />
    <meta property="og:description" content="<?php echo filter($rows['name']);?>" />
    <meta name="twitter:card" content="summary_large_image" /> 
	<link rel="shortcut icon" href="https://gjepc.org/assets/images/fav_icon.png" />
	<meta name="keywords" content="gem,gems,gem and jewellery,gems and jewellery,gem & jewellery,gems & jewellery,gem & jewellery export,gems & jewellery export,gem and jewellery export,gems and jewellery export,Indias exports of gold,Indias exports of silver,Indias exports of precious stones,Indias exports of semi precious stones,courses in jewellery designing,courses in gem and jewellery designing,nodal agency for Kimberly Process Certification Scheme,Kimberly Process Certification Scheme India,India Kimberly Process Certification Scheme" />
 
<link rel="canonical" href="https://gjepc.org/">

<link rel="stylesheet" href="assets-new/css/fonts.css">
<link rel="stylesheet" href="assets-new/css/bootstrap.min.css">
<link rel="stylesheet" href="assets-new/css/aos.css">
<link rel="stylesheet" href="assets-new/css/sina-nav.css">
<link rel="stylesheet" href="assets-new/css/jquery.fancybox.min.css">
<link rel="stylesheet" type="text/css" href="assets-new/css/fastselect.min.css">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="assets-new/css/general.css">
<link rel="stylesheet" href="assets-new/css/inner_page.css">
<link rel="stylesheet" href="assets-new/css/rohan.css">
<link rel="stylesheet" href="assets-new/css/mangesh.css">

</head>
<body>

<div id="preloader">
	<div class="d-flex justify-content-center h-100">
    <div id="status" class="align-self-center"> <img src="https://gjepc.org/assets/images/logo.png"></div>
    </div>
</div> <!-- preloader wrp -->

<div class="menu_overlay"></div> <!-- menu overlay wrp -->
<header>
	<div class="nav-container">
		
        <nav class="sina-nav mobile-sidebar navbar-transparent navbar-fixed" data-top="40" data-md-top="40" data-xl-top="40">
        
			<div class="container">
        		
                <div class="sina-nav-header social-on">
                
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <span class="fade_anim"></span>
                        <span class="fade_anim"></span>
                        <span class="fade_anim"></span>
                        <span class="fade_anim"></span>
                    </button>
                    
                    <a class="sina-brand" href="index.php"><img src="assets/images/logo.png"></a>
                    
                    <div class="head_right">        
                    	
						<?php if(isset($_SESSION['USERID'])){?>
                        <div class="d-flex justify-content-end position-relative log_reg_btn mb-3">
                      		<div><a href="my_account.php"> <span> <?php echo strtoupper(str_replace('&amp;', '&', $_SESSION['COMPANYNAME'])); ?></span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                            <div><a href="logout.php" class="reg_btn"> <span> Logout</span> <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>
                        </div>
						<?php }else if(isset($_SESSION['vendorId'])){?>
						<div class="d-flex justify-content-end position-relative log_reg_btn mb-3">
                      		<div><a href="vendor_profile.php"> <span> <?php echo htmlentities(strip_tags($_SESSION['company_name']));?></span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                            <div><a href="logout.php" class="reg_btn"> <span> Logout</span> <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>
                        </div>
						<?php }else{?>
						<div class="d-flex justify-content-end position-relative log_reg_btn mb-3">
                      		<div><a href="login.php"> <span> Log in </span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                            <div><a href="registration.php" class="reg_btn"> <span> Registration </span> <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>
                            <div class="ml-3"><button class="search_btn"> <i class="fa fa-search" aria-hidden="true"></i></button></div>
                        </div>
						<?php }?>
						
						<!--<div class="d-flex justify-content-end position-relative log_reg_btn mb-3">
                      		<div><a href="login.php"> <span> Login </span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                            <div><a href="registraiton_landing.php" class="reg_btn active"> <span> Registration </span> <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>
                        </div>-->
					
                        <ul class="d-sm-flex mb-3 justify-content-center justify-content-lg-end upper_link">
                        	<li class="flex-fill"><a href="projects.php"> Projects</a></li>
                            <li class="flex-fill"><a href="csr.php"> CSR</a></li>
                            
                            <li class="flex-fill"><a href="press-release.php"> Media</a></li>
                            <!-- <li class="flex-fill"><a href="solitaire.php"> <img src="assets/images/magzine.svg" class="d-block d-md-none">Solitaire International</a></li>-->
                            <li class="flex-fill"> <a href="https://www.mykycbank.com/" target="_blank">MyKYCBank</a></li>
                            <li class="flex-fill"><a href="https://survey.jamoutsourcing.com/gjepc_new/index.php/complaint/complaint" target="_blank">Helpdesk</a></li>                            
                        </ul>                        
                        <button class="quick_btn"> <span> + </span> </button>                                                   
					</div>                        
				</div>  
           </div>                
<div class="nav_bg">	
    <div class="container collapse navbar-collapse" id="navbar-menu">		
        <ul class="sina-menu" data-in="fadeInLeft" data-out="fadeInOut">                   
            <li class="dropdown dashed">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >GJEPC</a>
                <ul class="dropdown-menu">
                    <li><a href="the-organisation.php">The Organisation</a></li>
                    <li><a href="vision-mission.php">Vision & Mission</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Leadership</a>
                        <ul class="dropdown-menu">
                            <li><a href="coa.php">COA</a> </li>
                            <li><a href="sub-committee.php"> Sub-Committees</a></li>
                        </ul>
                    </li>
                    <li><a href="our-structure.php">Our Structure</a> </li>          
                </ul>
            </li>
            
            <li class="dropdown dashed">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Members</a>
                <ul class="dropdown-menu">
                    <li><a href="benefits.php">Benefits </a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Application</a>
                        <ul class="dropdown-menu">
                            <li><a href="registration.php">New Membership</a></li>
                            <li><a href="login.php">Renewal</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            
            <li class="dashed"><a href="statistics.php">statistics</a></li>  
            
            <li class="dropdown dashed">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Business Events</a>
                <ul class="dropdown-menu">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Domestic Trade Shows</a>
                        <ul class="dropdown-menu">
                            <li><a href="https://www.iijs.org/" target="_blank">IIJS Premiere</a></li>
                            <li><a href="https://www.iijs-signature.org/" target="_blank">IIJS Signature</a></li>
                            <li><a href="https://www.gjepc.org/igjme/" target="_blank">IGJME</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">International Trade Shows</a>
                        <ul class="dropdown-menu">
                            <li><a href="https://intl.gjepc.org/jaipur" target="_blank">International Gem & Jewellery Show</a></li>
                            <li><a href="india-pavilions.php">India Pavilions</a></li>
                            <li><a href="buyer-seller-meets.php">Buyer-Seller Meets</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Events</a>
                        <ul class="dropdown-menu">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Design Initiatives</a>
                                <ul class="dropdown-menu">
                                    <li><a href="aatman-jewellery-trend-book-2020.php"> Aatman Jewellery Trend Book 2020</a></li>
                                    <li><a href="design-inspiration.php">Design Inspirations </a></li>
                                    <li><a href="design-workshop.php">Design Workshop</a></li>
                                    <li><a href="http://theartisanawards.com/" target="_blank">Artisan Awards</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Conferences</a>
                                <ul class="dropdown-menu">
                                    <li><a href="india-gold-and-jewellery-summit.php">India Gold & Jewellery Summit</a></li> 
                                	<li><a href="gems-and-jewellery-conclave.php">Gems & Jewellery Conclave</a></li>
                                </ul>
                            </li>
                            <li><a href="igja-awards.php"> India Gem & Jewellery Awards</a></li>
                        </ul>
                    </li>
                    
                </ul>
            </li>                  
                                
            <li class="dropdown dashed">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Education</a>
                <ul class="dropdown-menu">
                    <li><a href="https://www.iigj.org/" target="_blank">IIGJ Mumbai</a></li>
                    <li><a href="http://iigjdelhi.org/" target="_blank">IIGJ Delhi</a></li>
                    <li><a href="http://www.iigjjaipur.com/" target="_blank">IIGJ Jaipur </a></li>
                    <li><a href="http://iigj.org/varanasi/" target="_blank">IIGJ Varanasi </a></li>
                    <li><a href="https://iigj.org/udupi/" target="_blank">IIGJ Udupi </a></li>
                </ul>
            </li>
                         
            <li class="dropdown dashed">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Labs</a>
                <ul class="dropdown-menu">
                    <li><a href="http://giionline.com/" target="_blank">Gemmological Institute of India (GII)</a></li>
                    <li><a href="http://www.gtljaipur.info/" target="_blank">Gem Testing Laboratory, Jaipur (GTL)</a></li>
                    <li><a href="http://www.igi-gtl.org/" target="_blank">Indian Gemmological Institute - Gem Testing Laboratory (IGI-GTL), Delhi</a></li>
                    <li><a href="http://www.diamondinstitute.net/the-institute.html" target="_blank">Indian Diamond Institute (IDI)</a></li>
                </ul>
            </li>
            
            <li class="dashed"><a href="solitaire-international.php"> Solitaire International</a></li>                                
            <li class="dashed"><a href="https://www.gjepc.org/kp/login.php" target="_blank">KP</a></li>            
            <li class="dashed"><a href="circulars-and-notifications.php">Circulars</a></li>                                
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">MSME</a>
                <ul class="dropdown-menu msme_dropdown">
                    <li><a href="registration.php">Micro membership</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Government Assistance Schemes</a>
                        <ul class="dropdown-menu msme_dropdown1">
                            <li><a href="pdf/MSME/Central-Government-Scheme.pdf" target="_blank">Central Government Scheme</a></li>
                            <li><a href="pdf/MSME/State-Government-Scheme.pdf" target="_blank">State Government Scheme</a></li>
                        </ul>
                    </li>
                    <li><a href="udhyam-registration.php"> Udyam Registration</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">MSME Schemes & FAQs</a>
                        <ul class="dropdown-menu msme_dropdown1">
                            <li><a href="msme-defination.php">MSME Definition</a></li>
                            <li><a href="new-msme-schemes.php">New MSME Schemes </a></li>
                            <li><a href="existing-schemes.php">Existing Schemes</a></li>
                        </ul>
                    </li>
                    <li><a href="https://nsdcindia.org/" target="_blank">Skill development & training for Artisans</a></li>
                    <li><a href="MSME-DI-contact-details.php"> MSME DI Contacts</a></li>
                    <li><a href="msme-notification-circulars.php">Notification/Circulars</a></li>                   
                </ul>
            </li>
		</ul>     
		
        <div class="social_contact_wrp">
        	
            <div class="d-lg-flex wl_wrp">                        	
       			<div>
                	<ul class="row social w-auto">
                        <li><a href="" class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="" class="twitter" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="" class="instagram" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="" class="linkedin" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                	</ul>
            	</div>                            
      		<div></div>
            </div>
                   	
            <table class="contact_no">
                <tbody>
                    <tr>
                        <td>Toll Free</td>
                        <td><a href="tel:18001034353">1800-103-4353</a></td>
                    </tr>
                    <tr>
                        <td>Missed Call</td>
                        <td><a href="tel:917208048100">91-7208048100</a></td>
                    </tr>
                </tbody>
            </table>      
		</div>   
    </div>
</div>  
                           
   			<!-- .sina-nav-header -->                
		</nav><!-- .container -->	
    </div>      
</header>  <!-- header wrp -->

<div class="search_wrp">
	
    <div class="container h-100 position-relative">    
    	<button class="search_btn search_close fade_anim"> </button>
    
        <div class="d-flex h-100">            
            <div class="w-100 my-auto">
                <form action="search_result.php" method="get" class="row justify-content-center">
                	<div class="col-md-10">
                    	<input type="text" name="s" id="s" class="searchtextbg form-control" onfocus="if(this.value=='Search Here...')value='';" onblur="if(this.value=='')value='Search Here...';" value="Search Here..." /> 
                    <!--<input type="image" src="images/search_icon.png" alt="Submit">-->
                    </div>
                </form>
            </div>            
        </div>   	
    </div>
     
</div>

<style>
.upper_link li a {display:block; position:relative; text-transform:capitalize!important; font-weight:bold;}
.upper_link li a:hover {color:#a89c5d;}
.upper_link li a:before {width:0; height:1px; background:#a89c5d; position:absolute; left:0; bottom:0; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.upper_link li a:hover:before {width:100%; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.wl_wrp .social li a {width:auto; height:auto; color:#000;}
.social_contact_wrp a:hover {
    color: #a89c5d!important;
}
</style>        
</body>
</html>