<?php session_start(); ob_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="assets/images/fav_icon.png">
<?php
if(isset($pageTitle)){ ?>
<title><?php echo $pageTitle;?></title>
<meta name="description" content="<?php echo $pageDescription; ?>">
<?php } else { ?>
<title>GJEPC INDIA</title>
<meta name="description" content="Gem Jewellery Export Promotion Council is Indias Apex body supported by the ministry of commerce and industry. Diamonds, Gold, Silver, Gem stones, in exports of gems & jewellery, Promoting skilled manpower, trade facilitator, advisory role to government, nodal agency for Kimberly process,world�s largest manufacturer of cut & polished diamonds." />
<?php } ?>

<meta name="keywords" content="gem,gems,gem and jewellery,gems and jewellery,gem & jewellery,gems & jewellery,gem & jewellery export,gems & jewellery export,gem and jewellery export,gems and jewellery export,Indias exports of gold,Indias exports of silver,Indias exports of precious stones,Indias exports of semi precious stones,courses in jewellery designing,courses in gem and jewellery designing,nodal agency for Kimberly Process Certification Scheme,Kimberly Process Certification Scheme India,India Kimberly Process Certification Scheme" />
<link rel="canonical" href="https://gjepc.org/">

<link rel="stylesheet" href="assets-new/css/fonts.css">
<link rel="stylesheet" href="assets-new/css/bootstrap.min.css">
<link rel="stylesheet" href="assets-new/css/aos.css">
<link rel="stylesheet" href="assets-new/css/sina-nav.css">
<link rel="stylesheet" href="assets-new/css/jquery.fancybox.min.css">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="assets-new/css/general.css?v=1.2">
<link rel="stylesheet" href="assets-new/css/inner_page.css?v=1.2">
<link rel="stylesheet" href="assets-new/css/rohan.css">

<!-- Facebook Pixel Code -->
<script>  
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '398834417477910');
  fbq('track', 'PageView');
</script>
<noscript>
<img height="1" async width="1" style="display:none" data-src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Ads: 679056788 -->
<script async data-src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'AW-679056788');
  gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'});
</script>

<!-- NEW Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-6559133-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-6559133-2');
</script>
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
                    
                    <a class="sina-brand" href="https://gjepc.org/"><img src="https://gjepc.org/assets/images/logo.png"></a>
                    
                    <div class="head_right">   
                    
                    	<div class="log_reg_btn h-100 ">     
                    	             
                            <div class="d-flex h-100 position-relative">
                                
                                <div class="my-auto">
                                
                                    <?php if(isset($_SESSION['USERNAME'])){ ?>
                                    <div class="d-md-flex justify-content-end position-relative mb-3">          
                                        <div><a href="kimberley_process_search_applications.php" style="text-decoration: underline;"> <?php echo $_SESSION['USERNAME'];?></a></div>
                                        <div><a href="logout.php">Logout</a></div>
                                    </div> 
                                    <?php }elseif(isset($_SESSION['USERID'])){?>
                                    <div class="d-md-flex justify-content-end position-relative mb-3">
                                        <div><a href="my_account.php"> <span> <?php echo strtoupper(str_replace('&amp;', '&', $_SESSION['COMPANYNAME'])); ?></span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                                        <div><a href="logout.php" class="reg_btn">Logout</a></div>
                                    </div>
                                    <?php }else if(isset($_SESSION['vendorId'])){?>
                                    <div class="d-md-flex justify-content-end position-relative mb-3">
                                        <div><a href="vendor_profile.php"> <span> <?php echo htmlentities(strip_tags($_SESSION['company_name']));?></span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                                        <div><a href="logout.php" class="reg_btn">Logout</a></div>
                                    </div>
                                    <?php }else{?>
                                    <div class="d-md-flex justify-content-end position-relative mb-3">
                                     <div class="my-auto">
                                        <div><a href="login.php"> Log in</a></div>
                                      </div>
                                    </div>
                                    <?php }?>
                                           
                                    <ul class="d-sm-flex mb-0 justify-content-center justify-content-lg-end upper_link">
                                        <li class="flex-fill"><a href="../projects.php"> Projects</a></li>
                                        <li class="flex-fill"><a href="../csr.php"> CSR</a></li>
                                        <li class="flex-fill"><a href="../press-release.php"> Media</a></li>
                                        <li class="flex-fill"> <a href="https://www.mykycbank.com/" target="_blank">MyKYCBank</a></li>
                                        <li class="flex-fill"><a href="http://crm.gjepc.org/gjepc_new/index.php/complaint/complaint" target="_blank">Helpdesk</a></li>
                                    </ul>
                            
                                    <button class="quick_btn"> <span class="ab_none"> + </span> </button>
                                
                                </div>
                                               
                            </div>
                        
                        </div>
                        
						
                        
                        
						<!--<div class="d-flex justify-content-end position-relative log_reg_btn mb-3">
                      		<div><a href="login.php"> <span> Login </span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                            <div><a href="registraiton_landing.php" class="reg_btn active"> <span> Registration </span> <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>
                        </div>-->
					
                       <!-- <ul class="d-flex mb-3 justify-content-center justify-content-lg-end upper_link">
                        	
                            <li class="flex-fill"><a href="https://survey.jamoutsourcing.com/gjepc_new/index.php/complaint/complaint" target="_blank"> <img src="assets/images/helpdesk.svg" class="d-block d-md-none">Helpdesk</a></li>
                            
                        </ul>-->
                                                   
					</div>                        
				</div>     
                  
           
           </div>
                
            <div class=" nav_bg">
            <div class="container collapse navbar-collapse" id="navbar-menu">
            
                
                <!--<ul class="sina-menu" data-in="fadeInLeft" data-out="fadeInOut">
                
                    
                
                    
               
                    <li class="menu-item-has-mega-menu">  <a href="./kimberley_process_search_applications.php">Home</a> </li>
                    
                   
                    
                    
                  
                    <li class="menu-item-has-mega-menu">   <a href="./images/pdf/KP-User-Manual.pdf" target="_blank">Online Manual</a>    </li>
                    
                   
                    
              <li class="menu-item-has-mega-menu"> <a href="./import_application.php" >Import Application</a></li>  
              <li class="menu-item-has-mega-menu"> <a href="./export_application.php" >Export Application</a>  </li>
              <li class="menu-item-has-mega-menu"> <a href="./kimberley_process_search_applications.php" >Application History</a>  </li>
              <li class="menu-item-has-mega-menu"> <a href="./kimberly_info_certification_scheme.php" >Kimberley Info</a> </li>
                    
                    
                   
                    
                    
                              
              
               
                              
                </ul>-->     
     
                
                <ul class="sina-menu" data-in="fadeInLeft" data-out="fadeInOut">
                   
            <li class="dropdown dashed">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >GJEPC</a>
                <ul class="dropdown-menu">
                    <li><a href="../the-organisation.php">The Organisation</a></li>
                    <li><a href="../vision-mission.php">Vision & Mission</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Leadership</a>
                        <ul class="dropdown-menu">
                            <li><a href="../coa.php">COA</a> </li>
                            <li><a href="../sub-committee.php"> Sub-Committees</a></li>
                            
                        </ul>
                    </li>
                    <li><a href="../our-structure.php">Our Structure</a> </li>          
                </ul>
            </li>
            
            <li class="dropdown dashed">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Members</a>
                <ul class="dropdown-menu">
                    <li><a href="../benefits.php">Benefits </a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Application</a>
                        <ul class="dropdown-menu">
                            <li><a href="../registration.php">New Membership</a></li>
                             <li><a href="../process-&-documentation-of-new-membership.php">Membership Process</a></li>
                            <li><a href="../login.php">Renewal</a></li>
                             <li><a href="../process-of-renewal-membership.php">Renewal Process</a></li>
                        </ul>
                    </li>
                    <li><a href="../guide-to-export.php">Guide to Export </a></li>
                </ul>
            </li>
            
            <li class="dashed"><a href="../statistics.php">statistics</a></li>  
            
            <li class="dropdown dashed">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Business Events</a>
                <ul class="dropdown-menu">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Domestic Trade Shows</a>
                        <ul class="dropdown-menu">
                        	<li><a href="../iijs-virtual/">IIJS Virtual</a></li>
                            <li><a href="../iijs-premiere/">IIJS Premiere</a></li>
                            <li><a href="../iijs-signature/">IIJS Signature</a></li>
                            <li><a href="https://www.gjepc.org/igjme/" target="_blank">IGJME</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">International Trade Shows</a>
                        <ul class="dropdown-menu">
                            <li><a href="../vbsm/" target="_blank">Virtual BSM</a></li>
                            <li><a href="https://intl.gjepc.org/jaipur" target="_blank">International Gem & Jewellery Show</a></li>
                            <li><a href="../india-pavilions.php">India Pavilions</a></li>
                            <li><a href="../buyer-seller-meets.php">Buyer-Seller Meets</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Calender of Events</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Vicenza Oro Winter</a></li>
                                    <li><a href="#">Doha Jewellery & Watches Exhibition</a></li>
                                    <li><a href="#">Hong Kong International Diamond, Gem & Pearl Show 2021</a></li>
                                    <li><a href="#">Hong Kong International Jewellery Show 2021</a></li>
                                    <li><a href="#">JCK Las Vegas 2021</a></li>
                                    <li><a href="#">Jewellery & Gem World (AWE)</a></li>
                                    <li><a href="#">Jewellery & Gem World (CEC)</a></li>
                                    <li><a href="#">Jewellery Arabia</a></li>
                                </ul>
                            </li>
                            

                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Events</a>
                        <ul class="dropdown-menu">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Design Initiatives</a>
                                <ul class="dropdown-menu">
                                    <li><a href="../aatman-jewellery-trend-book-2020.php"> Aatman Jewellery Trend Book 2020</a></li>
                                                <li><a href="../design-inspiration.php">Design Inspirations </a></li>
                                                <li><a href="../design-workshop.php">Design Workshop</a></li>
                                                <li><a href="http://theartisanawards.com/" target="_blank">Artisan Awards</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Conferences</a>
                                <ul class="dropdown-menu">
                                    <li><a href="../india-gold-and-jewellery-summit.php">India Gold & Jewellery Summit</a></li> 
                                	<li><a href="../gems-and-jewellery-conclave.php">Gems & Jewellery Conclave</a></li>
                                </ul>
                            </li>
                            <li><a href="../igja-awards.php"> India Gem & Jewellery Awards</a></li>
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
            
            <li class="dashed"><a href="../solitaire"> Solitaire International</a></li>
                                
            <li class="dashed"><a href="https://www.gjepc.org/kp/login.php" >KP</a></li>
            
            <li class="dashed"><a href="../circulars-and-notifications.php">Circulars</a></li>
                                
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">MSME</a>
                <ul class="dropdown-menu msme_dropdown">
                    <li><a href="../registration.php">Micro membership</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Government Assistance Schemes</a>
                        <ul class="dropdown-menu msme_dropdown1">
                            <li><a href="pdf/MSME/Central-Government-Scheme.pdf" target="_blank">Central Government Scheme</a></li>
                            <li><a href="pdf/MSME/State-Government-Scheme.pdf" target="_blank">State Government Scheme</a></li>
                        </ul>
                    </li>
                    <li><a href="../udhyam-registration.php"> Udyam Registration</a></li>
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">MSME Schemes & FAQs</a>
                        <ul class="dropdown-menu msme_dropdown1">
                            <li><a href="../msme-defination.php">MSME Definition</a></li>
                            <li><a href="../new-msme-schemes.php">New MSME Schemes </a></li>
                            <li><a href="../existing-schemes.php">Existing Schemes</a></li>
                        </ul>
                    </li>
                    <li><a href="https://nsdcindia.org/" target="_blank">Skill development & training for Artisans</a></li>
                    <li><a href="../MSME-DI-contact-details.php"> MSME DI Contacts</a></li>
                    <li><a href="../msme-notification-circulars.php">Notification/Circulars</a></li>
                    <li><a href="../parichay-card.php">Parichay Card</a></li>
                    
                </ul>
            </li>
		</ul>
                
                 <div class="social_contact_wrp">                 
                 	<div class="d-flex wl_wrp">                        	
                    <div>
                    <ul class="row social w-auto">
                	<li><a href="" class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="" class="twitter" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="" class="instagram" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                   	<li><a href="" class="linkedin" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                	</ul>
                    </div>                            
                    <div>                            
                    </div>                            
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