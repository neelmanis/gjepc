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
<link rel="stylesheet" href="assets/css/fonts.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/new/inner_page.css">
<link rel="stylesheet" href="assets/css/new/sina-nav.css">
<link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="assets/css/new/general.css">
<link rel="stylesheet" href="assets/css/inner_page.css">

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
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async data-src="https://www.googletagmanager.com/gtag/js?id=UA-6559133-2"></script>
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
    <div id="status" class="align-self-center"> <img src="assets/images/loader.gif"></div>
    </div>
</div> <!-- preloader wrp -->

<div class="menu_overlay"></div> <!-- menu overlay wrp -->

<header>
	<div class="nav-container">
		
        <nav class="sina-nav mobile-sidebar navbar-transparent navbar-fixed" data-top="40" data-md-top="40" data-xl-top="40">
        
			<div class="container">
        		
                <div class="container sina-nav-header social-on">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <span class="fade_anim"></span>
                        <span class="fade_anim"></span>
                        <span class="fade_anim"></span>
                        <span class="fade_anim"></span>
                    </button>
                    
                    <a class="sina-brand" href="index.php"><img src="assets/images/logo.png"></a>
                    
                    <div class="head_right">                    
                    	<div class="d-flex mb-4 justify-content-end wl_wrp">                        	
                            <div class="mr-3">
                            	<a href="pdf/GJEPC-Communication-during-Lockdown.pdf" target="_blank" class="whats_new" data-toggle="tooltip" data-placement="left" title="GJEPC Communication During Lockdown"><i class="mr-2 fa fa-bolt" aria-hidden="true"></i> What's New !</a>
                            </div>                            
                            <div>
                            <div class="language_wrp language"> 
							<div id="google_translate_element"></div> 
							</div>
                            </div>
                            
                        </div>	
                        <?php if(isset($_SESSION['USERID'])){?>
                        <div class="d-flex position-relative log_reg_btn">
                      		<div><a href="my_account.php"> <span> <?php echo htmlentities(strip_tags($_SESSION['COMPANYNAME']));?></span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                            <div><a href="logout.php" class="reg_btn"> <span> Logout</span> <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>
                        </div>
						<?php }else if(isset($_SESSION['vendorId'])){?>
						<div class="d-flex position-relative log_reg_btn">
                      		<div><a href="vendor_profile.php"> <span> <?php echo htmlentities(strip_tags($_SESSION['company_name']));?></span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                            <div><a href="logout.php" class="reg_btn"> <span> Logout</span> <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>
                        </div>
						<?php }else{?>
						<div class="d-flex position-relative log_reg_btn">
                      		<div><a href="login.php"> <span> Login </span> <i class="fa fa-user" aria-hidden="true"></i> </a></div>
                            <div><a href="registraiton_landing.php" class="reg_btn"> <span> Registration </span> <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>
                        </div>
						<?php }?>                            
					</div>                        
				</div>     
                
                  
           
           </div>
                
            <div class=" nav_bg">
            <div class="container-fluid collapse navbar-collapse" id="navbar-menu">
                
                <ul class="sina-menu" data-in="fadeInLeft" data-out="fadeInOut">
                
                    <li class="menu-item-has-mega-menu"> <a href="index.php">Home</a> </li>
                    
                    <li class="dropdown menu-item-has-mega-menu">
                        
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">About Us</a>
                         
                         
                        <div class="mega-menu dropdown-menu">
                            <ul class="mega-menu-row" role="menu">
                                
                                <li class="mega-menu-col">
                                    <ul class="sub-menu">
                                        <li><a href="about-us.php">GJEPC</a></li>
                                        <!--<li><a href="mission-and-vision.php"> Mission & Vision Statement</a></li>-->
                                        <li><a href="india-center.php">India Centre</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Committees</a>
                                            <ul class="dropdown-menu ">
                                                <li><a href="coa.php">COA</a> </li>
                                                <li><a href="sub-committee.php"> Sub-Committees</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="secretariat.php">Secretariat</a> </li>
                                        <li><a href="pdf/coe_2016.pdf" target="_blank">Code of Ethics</a> </li>
                                     </ul>
                                     
                                </li>
                                            
                                <li class="mega-menu-col col-sm-6 col-md-4 float-lg-right">
                                    <img src="assets/images/menu_bg.jpg" class="img-fluid"> 
                                </li>
                                       
                            </ul><!-- end row -->
                        </div>
                          
                    </li>
                    
                    <li class="dropdown menu-item-has-mega-menu">                            
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Trade Shows</a>                                    
                        <div class="mega-menu dropdown-menu">                                    
                            <ul class="mega-menu-row" role="menu">                                    
                                <li class="mega-menu-col">
                                    <ul class="sub-menu">
                                         <!--<li><a href="trade-shows.php">Overview</a></li>-->
                                         
                                         <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Domestic</a>
                                            <ul class="dropdown-menu ">
                                                  <li><a href="https://www.iijs.org/" target="_blank">Indian International Jewellery Show (IIJS)</a></li>
                                                    <li><a href="https://www.iijs-signature.org/" target="_blank">Signature IIJS</a></li>
                                                <li><a href="https://www.gjepc.org/igjme/" target="_blank">India Gem &amp; Jewellery Machinery Exhibition (IGJME)</a></li>
                                            </ul>
                                        </li>
                                         
                                         <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >International</a>
                                            <ul class="dropdown-menu ">
                                                <li><a href="https://intl.gjepc.org/jaipur" target="_blank">International Gem & Jewellery Show (IGJS Exhibition 2020)</a></li>
                                                <li><a href="http://intl.gjepc.org/india-pavilions" target="_blank">India Pavilions</a></li>
                                                <li><a href="http://intl.gjepc.org/deligation" target="_blank">Buyer-Seller Meets</a></li>
                                                <!--<li><a href="http://intl.gjepc.org/deligation" target="_blank">Intl Diamond Week</a></li>-->
                                            </ul>
                                        </li>
                                        
                                         
                                         
                                         
                                       
                                         
                                         <!--<li><a href="ddes.php">DDES</a></li>-->
                                         <!--<li><a href="road-shows.php">Road Shows</a></li>-->
                                     </ul>                                         
                                </li>                                                
                               <li class="mega-menu-col col-sm-6 col-md-4 float-lg-right">
                                    <img src="assets/images/menu_bg.jpg" class="img-fluid"> 
                                </li>                                           
                            </ul>                                        
                        </div>                              
                    </li>
                    
                    <li class="dropdown menu-item-has-mega-menu">                            
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Events</a>                            
                        <div class="mega-menu dropdown-menu">                                    
                            <ul class="mega-menu-row" role="menu">                                    
                                <li class="mega-menu-col">
                                    <ul class="sub-menu">
                                        <!--<li><a href="events.php">Overview</a></li>-->
                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Awards</a>
                                            <ul class="dropdown-menu ">
                                                <li><a href="http://awards.gjepc.org/" target="_blank">India Gem & Jewellery Awards 2019</a></li>
                                            </ul>
                                        </li>
                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Design Initiatives</a>
                                            <ul class="dropdown-menu ">
                                                <li><a href="aatman-2020.php"> Aatman Jewellery Trend Book 2020</a></li>
                                                <li><a href="design-inspiration.php">Design Inspirations 2020</a></li>
                                                <li><a href="design-workshop.php">Design Workshop</a></li>
                                                <li><a href="http://theartisanawards.com/" target="_blank">The Artisan Jewellery Design Awards 2020</a></li>
                                            </ul>
                                        </li>
                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Conferences</a>
                                            <ul class="dropdown-menu ">
                                                <li><a href="india-gold-submit.php">India Gold & Jewellery Summit 2019</a></li> 
                                                <li><a href="knowledge_forum.php">Knowledge Forum</a></li>
                                            </ul>
                                        </li>
                                        
                                        
                                        
                                        <!--<li><a href="kp-gallery.php">KP International Session 2019</a></li> -->
                                        
                                        <!--<li><a href="mines-to-market.php">Mines to market</a></li> -->
                                        
                                        <!--<li><a href="wdc.php">World Diamond Conference </a></li>-->
                                        <!--<li><a href="https://www.iijw.org/" target="_blank">India International Jewellery Week (IIJW)</a></li>-->
                                        
                                    </ul>
                                </li>                                                
                                <li class="mega-menu-col col-sm-6 col-md-4 float-lg-right">
                                    <img src="assets/images/menu_bg.jpg" class="img-fluid"> 
                                </li>                                           
                            </ul>
                        </div>
                                
                                                      
                    </li>
                    
                    <li class="dropdown menu-item-has-mega-menu">
                        
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects</a>
                                
                        <div class="mega-menu dropdown-menu">                                    
                            <ul class="mega-menu-row" role="menu">                                    
                                <li class="mega-menu-col">
                                    <ul class="sub-menu">
                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Institutes</a>
                                            <ul class="dropdown-menu ">
                                                <li><a href="https://www.iigj.org/" target="_blank">IIGJ Mumbai</a></li>
                                                <li><a href="http://iigjdelhi.org/" target="_blank">IIGJ Delhi</a></li>
                                                <li><a href="http://www.iigjjaipur.com/" target="_blank">IIGJ Jaipur </a></li>
                                                <li><a href="http://iigj.org/varanasi/" target="_blank">IIGJ Varanasi </a></li>
                                                <li><a href="https://iigj.org/udupi/" target="_blank">IIGJ Udupi </a></li>
                                            </ul>
                                        </li>
                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Laboratory</a>
                                            <ul class="dropdown-menu ">
                                                 <li><a href="idi-surat.php">Indian Diamond Institute (IDI)</a> </li>
                                        <li><a href="http://giionline.com/" target="_blank">Gemmological Institute of India (GII)</a></li>
                                        <li><a href="http://www.gtljaipur.info/" target="_blank">Gem Testing Laboratory, Jaipur (GTL)</a></li>
                                        <li><a href="http://www.igi-gtl.org/" target="_blank">Indian Gemmological Institute - Gem Testing Laboratory (IGI-GTL), Delhi </a>
                                        </li>
                                            </ul>
                                        </li>
                                    
                                        <li><a href="cfc.php">CFC</a></li>    
                                        <li><a href="https://www.mykycbank.com/" target="_blank">My kyc Bank </a></li>     
                                                                       
                                     </ul>                                         
                                </li>                                                
                                <li class="mega-menu-col col-sm-6 col-md-4 float-lg-right">
                                    <img src="assets/images/menu_bg.jpg" class="img-fluid"> 
                                </li>                                           
                            </ul><!-- end row -->                                        
                        </div>                              
                    </li>
                    
                    <li class="dropdown menu-item-has-mega-menu">
                        
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Members</a>
                                
                        <div class="mega-menu dropdown-menu">
                                
                            <ul class="mega-menu-row" role="menu">
                                
                                <li class="mega-menu-col">
                                    <ul class="sub-menu">
                                        <!--<li><a href="region-wise-panel-wise-members-during-2018-19.php">Region-wise &amp; Panel-wise Members During 2018-19</a></li>-->
                                        
                                        <li><a href="kimberley-process.php">Kimberley Process</a></li>
                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Membership Information</a>
                                            <ul class="dropdown-menu ">
                                                    <li><a <?php if(!isset($_SESSION['USERID'])){ ?>href="javascript: void(0)" onclick="alert('Please Login');" <?php } else { ?> href="members_directory.php" <?php } ?>>Members Directory</a></li>
                                                <li><a href="apply-for-membership.php">Apply for Membership</a> </li>
                                                <li><a <?php if(!isset($_SESSION['USERID'])){ ?>href="javascript: void(0)" onclick="alert('Please Login');" <?php } else { ?> href="marketing_development_asst.php" <?php } ?>>Marketing Development Assistance</a> </li>
                                                <li> <a <?php if(!isset($_SESSION['USERID'])){ ?>href="javascript: void(0)" onclick="alert('Please Login');" <?php } else { ?> href="images/pdf/rcmc.pdf" <?php } ?>>Membership Renewal</a> </li>	
                                                
                                                <li> <a <?php if(!isset($_SESSION['USERID'])){ ?>href="javascript: void(0)" onclick="alert('Please Login');" <?php } else { ?> href="election_coa.php" <?php } ?> >Election for COA</a></li>
                                                <li> <a <?php if(!isset($_SESSION['USERID'])){ ?>href="javascript: void(0)" onclick="alert('Please Login');" <?php } else { ?> href="circulars_to_members.php" <?php } ?>>Circulars for Members</a></li>
                                                <li><a <?php if(!isset($_SESSION['USERID'])){ ?>href="javascript: void(0)" onclick="alert('Please Login');" <?php } else { ?> href="pdf/Visa_Format.pdf" <?php } ?>>Visa Recommendation</a></li>	
                                                
                                                <li><a <?php if(!isset($_SESSION['USERID'])){ ?>href="javascript: void(0)" onclick="alert('Please Login');" <?php } else { ?> href="annualreport.php" <?php } ?>>Annual Report</a></li>
                                            </ul>
                                        </li>
                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >MSME</a>
                                            <ul class="dropdown-menu ">
                                                
                                                  <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Government Assistance Schemes</a>
                                            <ul class="dropdown-menu ">
                                                  <li><a href="pdf/MSME/Central-Government-Scheme.pdf" target="_blank">Central Government Scheme</a></li>
                                                    <li><a href="pdf/MSME/State-Government-Scheme.pdf" target="_blank">State Government Scheme</a></li>
                                            </ul>
                                        </li>
                                         
                                         <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >GJEPC Initiatives</a>
                                            <ul class="dropdown-menu ">
                                                  <li><a href="apply-for-membership.php">Membership/Micro-membership</a></li>
                                                  <li><a href="parichay.php">Parichay Card</a></li>
                                                  <li><a href="swasthya-kosh.php" target="_blank">Swasthya Kosh</a></li>
                                                  <li><a href="about-swasthya-ratna-policy.php" target="_blank">Swasthya Ratna</a></li>
                                                  <li><a href="pdf/MSME/Jewellery-Park.pdf" target="_blank">Jewellery park</a></li>
                                                  <li><a href="common-facility-centre.php">Common Facility Center</a></li>
                                                  <li><a href="pdf/MSME/Cluster-Development.pdf" target="_blank">Cluster development</a></li>
                                                  <li><a href="#" target="_blank">IIJS Premiere/Signature exhibition/Buyer Seller meets</a></li>
                                                  <li><a href="https://survey.jamoutsourcing.com/gjepc_new/index.php/complaint/complaint" target="_blank">Helpdesk</a></li>
                                                  <li><a href="#" target="_blank">Skill development & training for Artisans</a></li>
                                            </ul>
                                        </li>
                                        
                                         <li><a href="udhyog-aadhar-registration.php">Udhyog Aadhar Registration</a></li>
                                         
                                         <li><a href="pdf/MSME/MSME-Data-Bank-Registration.pdf" target="_blank">MSME Data Bank Registration</a></li>
                                         
                                         <li><a href="pdf/MSME/Contact-Details-MSME.pdf" target="_blank">Contact details MSME DI, DIC & NSIC Offices</a></li>
                                         
                                         <li><a href="#" target="_blank">Latest updates and revised Schemes: MSME Notification/Circulars</a></li>
                                         
                                         <li><a href="pdf/MSME/MSME-Seminar.pdf" target="_blank">MSME Activity reports: Seminars, Workshops, Training, Udyog Aadhar and Parichay Card Shibirs</a></li>
                                         
                                         <li><a href="pdf/MSME/photo-gallery.pdf" target="_blank">Photo Gallery of Events </a></li>
                                         
                                         <li><a href="pdf/MSME/FAQ.pdf" target="_blank">FAQs </a></li>
                                         
                                         <li><a href="pdf/MSME/Feedback.pdf" target="_blank">Feedback form</a></li>		
                                                
                                                
                                            </ul>
                                        </li>
                                        
                                        
                                        
                                        

                                        
                                        
                                        <li><a href="https://dgft.gov.in/" target="_blank">Policy & Handbook</a></li>                                            
                                        <!--<li><a href="sdb.php">SDB Diamond Bourse Surat</a></li>-->                                            
                                        
                                        </ul>                                         
                                </li>
                                            
                                <li class="mega-menu-col col-sm-6 col-md-4 float-lg-right">
                                    <img src="assets/images/menu_bg.jpg" class="img-fluid"> 
                                </li>                                           
                            </ul><!-- end row -->                                        
                        </div>
                          
                    </li>
                    
                        
                                        
                    <li class="menu-item-has-mega-menu"> <a href="statistics.php">Research & Statistics</a> </li>   
                                         
                    <li class="dropdown menu-item-has-mega-menu">                            
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">CSR</a>                                    
                        <div class="mega-menu dropdown-menu">
                                
                            <ul class="mega-menu-row" role="menu">
                                
                                <li class="mega-menu-col">
                                    <ul class="sub-menu">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Swasthya Ratna</a>
                                            <ul class="dropdown-menu ">
                                                <li><a href="about-swasthya-ratna-policy.php">About Swasthya Ratna </a></li>
                                                <li><a href="https://gjepc.org/pdf/final_premium_rates-2017.pdf" target="_blank">Enroll Yourself </a></li>
                                                <li><a href="pdf/claims-procedure.pdf" target="_blank">Claims Procedure </a></li>
                                                <li><a href="https://mdindiaonline.com/LoginPage.aspx" target="_blank">Claim Status</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="swasthya-kosh.php">Swasthya Kosh</a></li>
                                        <li><a href="parichay.php">Parichay Card</a></li>
                                        <li><a href="jewellers-for-hope.php">Jewellers For Hope</a></li>
                                        <li><a href="gem-&-jewellery-national-relief-foundation.php">Gem & Jewellery National Relief Foundation</a></li>

                                    </ul>
                                </li>                                                
                                <li class="mega-menu-col col-sm-6 col-md-4 float-lg-right">
                                    <img src="assets/images/menu_bg.jpg" class="img-fluid"> 
                                </li>                                           
                            </ul><!-- end row -->                                        
                        </div>                              
                    </li>
                    
                    <li class="dropdown menu-item-has-mega-menu">                            
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Media</a>                                    
                        <div class="mega-menu dropdown-menu">                                    
                            <ul class="mega-menu-row" role="menu">                                    
                                <li class="mega-menu-col">
                                    <ul class="sub-menu">
                                       <!-- <li><a href="circulars-and-notifications.php">Circulars &amp; Notifications</a></li>-->
                                        <li><a href="press-release.php">Press Release</a></li>
                                        <li><a href="solitaire.php">Solitaire Magazine</a></li>
                                        <li><a href="newsletters.php">Newsletter</a></li>
                                        <!--<li><a href="media-registration-form.php">Media Registration Form</a></li>-->
                                        <li><a href="media-contact-details.php">Media Contact Details</a></li>
                                        <li><a href="photo.php">Photo Gallery</a></li>
                                        <!--<li><a href="video-gallery.php">Video Gallery</a></li>-->
                                        
                                        <!--<li><a href="advertise.php">Advertise</a></li>-->
                                     </ul>
                                </li>                                                
                                <li class="mega-menu-col col-sm-6 col-md-4 float-lg-right">
                                    <img src="assets/images/menu_bg.jpg" class="img-fluid"> 
                                </li>                                           
                            </ul> <!-- end row -->                                        
                        </div>                              
                    </li>
                    
                    <li class="menu-item-has-mega-menu"> <a href="circulars-and-notifications.php">Circulars & Notifications</a> </li>   
                                        
                    <!--<li class="dropdown menu-item-has-mega-menu">                            
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">GST</a>                                    
                        <div class="mega-menu dropdown-menu">                                    
                            <ul class="mega-menu-row" role="menu">                                    
                                <li class="mega-menu-col">
                                    <ul class="sub-menu">
                                        <li><a href="member_gst.php">Member GST</a></li>
                                        <li><a href="vendor_gst.php">Vendor GST</a></li>
                                        <li><a href="gst_cust.php">GST Enquiry</a></li>
                                     </ul>
                                </li>                                                
                                <li class="mega-menu-col col-sm-6 float-lg-right">
                                    <img src="assets/images/menu_bg.jpg" class="img-fluid"> 
                                </li>                                           
                            </ul>                                     
                        </div>                              
                    </li>-->            
                                
                    <li><a href="http://survey.jamoutsourcing.com/gjepc_new/index.php/complaint/complaint" target="_blank">Helpdesk</a></li>                            
                </ul>                    
                
                 <div class="social_contact_wrp">
                   	<ul class="row social">
                	<li><a href="" class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="" class="twitter" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="" class="instagram" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                   	<li><a href="" class="linkedin" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
					<!--<li><i class="fa fa-search" aria-hidden="true"></i></li>-->
                	</ul>
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

</body>
</html>