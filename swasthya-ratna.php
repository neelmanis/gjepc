<?php 
$pageTitle = "Gems And Jewellery Industry In India | The Organisation - GJEPC India";
$pageDescription  = "The Gem & Jewellery Export Promotion Council (GJEPC) was set up by the Ministry of Commerce, Government of India (GoI) in 1966. It was one of several Export Promotion Councils (EPCs) launched by the Indian Government";
?>
<?php
include 'include-new/header.php';
include 'db.inc.php'; 

$action=$_REQUEST['action'];
if($action=="login")
{
//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$email_id = filter($_REQUEST['email_id']);
	if(empty($email_id))
	{   $_SESSION['err_msg']="Please Enter a valid Email id";
	} else {
	$company_name	=	strtoupper(filter($_REQUEST['company_name']));
	$address		=	strtoupper(filter($_REQUEST['address']));
	$total_employee	=	filter($_REQUEST['total_employee']);
	$fname			=	strtoupper(filter($_REQUEST['fname']));
	$designation	=	strtoupper(filter($_REQUEST['designation']));
	$mobile_no 		= filter($_REQUEST['mobile_no']);
	$land_line_no 	= filter($_REQUEST['land_line_no']);
	$membership_number 	= filter($_REQUEST['membership_number']);
  
	$dt=date('Y-m-d');
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$query=$conn ->query("select * from swasthya_enrollment where email_id='$email_id'");
	$num=$query->num_rows;
	if($num>0)
	{	
		$_SESSION['err_msg']="Already registered with this Email id";
	} else
    {
	$sql=$conn ->query("insert into swasthya_enrollment set email_id='$email_id',company_name='$company_name',address='$address',total_employee='$total_employee',fname='$fname',designation='$designation',land_line_no='$land_line_no',mobile_no='$mobile_no',membership_number='$membership_number',status='1',post_date='$dt',ip='$ip'");
	 if($sql){
	/*.......................................Send mail to users mail id...............................................*/
	$message ='<table border="1" bordercolor="#ddd"  style="font-family:Arial, sans-serif; color:#333333; font-size:13px; border-collapse:collapse;" cellpadding="10" cellspacing="0">
	
    <tr>
        <td colspan="2" align="center"> <img src="https://gjepc.org/assets/images/logo.png"> </td>
	</tr>    
    <tr>
        <td> <strong>Company Name</strong>  </td>
        <td> '.$company_name.' </td>
    </tr> 
    <tr bgcolor="#f2f2f2">
        <td> <strong>Company Address</strong>  </td>
        <td> '.$address.' </td>
    </tr>     
    <tr>
        <td> <strong>Total No. Of Employees / Workers</strong>  </td>
        <td> '.$total_employee.' </td>
    </tr>    
    <tr bgcolor="#f2f2f2">
        <td> <strong>Name</strong>  </td>
        <td> '.$fname.'</td>
    </tr>     
    <tr>
        <td> <strong>Designation</strong>  </td>
        <td>'.$designation.' </td>
    </tr>     
    <tr bgcolor="#f2f2f2">
        <td> <strong>Email Id</strong>  </td>
        <td>'.$email_id.' </td>
    </tr>     
    <tr>
        <td> <strong>Mobile No.</strong>  </td>
        <td>'.$mobile_no.'</td>
    </tr> 
    
    <tr bgcolor="#f2f2f2">
        <td> <strong>Landline No.</strong>  </td>
        <td>'.$land_line_no.'</td>
    </tr>
    
    <tr>
        <td> <strong>Membership No.</strong>  </td>
        <td>'.$membership_number.'</td>
    </tr> 
</table>';
  
	 $to = "swasthya@gjepcindia.com";
	 $subject = "Swasthya Ratna policy"; 
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'. "\r\n"; 
	 $headers .='From: GJEPC Swasthya Ratna Policy <admin@gjepc.org>';				
	 mail($to, $subject, $message, $headers);
	 
	$message_user ='<table bordercolor="#ddd"  style="font-family:Arial, sans-serif; color:#333333; font-size:13px; border-collapse:collapse;" cellpadding="10" cellspacing="0">
    <tr>
        <td colspan="2" align="center"> <img src="https://gjepc.org/assets/images/logo.png"> </td>
	</tr>
	<tr>
	<td colspan="2">
	<p><strong>Dear Sir/Madam,</strong>  <br/>Thank you for your interest in Swasthya Ratna. Our representative will get in touch with you within 24 hours. 
    </p>
	</td>
	</tr>
	</table>';
	 
	 $to_user = $email_id;
	 $subject_user = "Swasthya Ratna policy"; 
	 $headers_user  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers_user .= 'Content-type: text/html; charset=iso-8859-1'. "\r\n"; 
	 $headers_user .='From: GJEPC Swasthya Ratna Policy <admin@gjepc.org>';				
	 mail($to_user, $subject_user, $message_user, $headers_user);
	 
	// $_SESSION['succ_msg']="You have been successfully Enrolled Yourself";
	 echo "<script type='text/javascript'>alert('Thank you for your interest in GJEPC Swasthya Ratna Policy. Our team will connect with you within 3 working days!')</script>";
	 } else  {
	 $_SESSION['err_msg']="There is some technical problem";
	 }
	}
  }
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>
					
<section>
    <div class="container position-relative inner_banner">
        <img src="assets/images/inner_banner/swasthya_ratna.jpg" class="img-fluid d-block" /> 
        <div class="innerpg_title">
            <div class="d-flex h-100">
                <div class="my-auto"><h1>Swasthya Ratna</h1></div>
            </div>
        </div>
    </div>
               
    <div class="container mb-5 position-relative" id="english">
        
      <button class="w-100 d-md-none page_subtabs_btn">Swasthya Ratna <i class="fa fa-angle-down" aria-hidden="true"></i></button>
        
       <ul class="row no-gutters justify-content-center page_subtabs">
                <li class="col-auto"><a href="swasthya-ratna.php" class="d-none d-md-block active">Swasthya Ratna</a></li>
                <li class="col-auto"><a href="swasthya-ratna-policy-details.php" class="d-block">Policy Details</a></li>
                <li class="col-auto"><a href="swasthya-ratna-premium-rates.php" class="d-block ">Premium Rates</a></li>
                <li class="col-auto"><a href="swasthya-ratna-claim-procedure.php" class="d-block">Claim Procedure</a></li>
                <li class="col-auto"><a href="swasthya-ratna-faqs.php" class="d-block" style="text-transform:inherit;"> FAQs </a></li>
            </ul>
        
        
        
        </div>
    
    <div class="container position-relative">
    
        
        <div class="langBtn">
            <div class="d-flex justify-content-center mb-3 lang_switcher">
                <div><button onclick="location.href = 'swasthya-ratna.php#english';" class="lang active">English</button></div>
                <div><button onclick="location.href = 'swasthya-ratna-hindi.php#hindi';" class="lang">Hindi</button></div>
            </div>
        </div>
    	
        <div class="row mb-5">
    		
            <div class="col-12">
    			
                <h1 class="bold_font"><div class="d-block"><img src="assets/images/black_star.png"></div> <span> Swasthya </span> Ratna</h1>
                
                <ul class="mb-5 inner_under_listing">
            
                    <li> The GJEPC launched Swasthya Ratna, a group mediclaim scheme, to provide health insurance benefits to employees of GJEPC Member companies.</li>
                    <li>The primary objective of launching this scheme is to provide quality medical care of choice to the workforce of the industry.</li>
                    <li>GJEPC has partnered with Edelweiss Gallagher Insurance Brokers Ltd. to run and manage a flexible scheme with different options like family size, coverages, benefits, etc., which enables companies of different sizes to avail of tailor-made plans.</li>
                    <li>Council has negotiated affordable premiums and contributes a percentage of the premium amount through its CSR initiative as an additional benefit for its members. The scheme is accessible from all parts of India through GJEPC offices in Mumbai, Surat, Delhi, Kolkata and Chennai. </li>
                    <li>	The Swasthya Ratna Scheme has received a phenomenal response over the last 5 years of its operation and several gem and jewellery companies have obtained the policy for their employees. </li>	
                    <li>Multiple sum assured options ranging from Rs. 1 lakh to Rs. 5 lakh</li>
                    
                    </ul>
                        
               <div class="ctaBox mb-5">
                            
                    <div class="ctaContentBox">
                    	<?php
						if($_SESSION['err_msg']!=""){
						echo "<div class='alert alert-danger' role='alert'>".$_SESSION['err_msg']."</div>";
						$_SESSION['err_msg']="";
						}
						 
						if($_SESSION['succ_msg']!=""){
						echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
						$_SESSION['succ_msg']="";
						}
						?>
                        
                        <h2 class="title text-uppercase tr mb-4" key="enroll">Enroll Your Company </h2>
                        
                        <!--<div class="d-flex ab_none justify-content-between align-items-center mb-4">
                        	<div></div>
                            <div>
                            	<div class="d-flex lang_switcher">
                					<div><button id="en" class="lang active">English</button></div>
                					<div><button id="hi" class="lang">Hindi</button></div>
            					</div>
                            </div>
                        </div>-->
                        
                        
                            
                        <form method="POST" name="loginform" id="loginform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" class="ctaForm">
						 <input type="hidden" name="action" value="login" />
                        <?php token(); ?>
                        	
                            <div class="row">
                        	
                        
                    		<div class="col-md-4 form-group">
                           		<label key="company_name" class="tr">Company Name</label>
                              	<input type="text" id="company_name" name="company_name" maxlength="38" class="form-control" autocomplete="off">
                            </div>
                            
                            <div class="col-md-4 form-group">
                             	<label key="address" class="tr">Company Address</label>
                              	<input type="text" id="address" name="address" autocomplete="off" class="form-control" >
                            </div>
							
							<div class="col-md-4 form-group">
                            	<label key="total_employee" class="tr">Total no. of employees / workers</label>
                              	<input type="text" id="total_employee" name="total_employee" maxlength="4" autocomplete="off" class="form-control">
                            </div>
                             
                            <div class="col-md-4 form-group">
                            	<label key="fname" class="tr">Name</label>
                              <input type="text" id="fname" name="fname" autocomplete="off" maxlength="50" class="form-control">
                            </div>
                            
                            <div class="col-md-4 form-group">
                            	<label key="designation" class="tr">Designation</label>
                              <input type="text" id="designation" name="designation" autocomplete="off" class="form-control">
                            </div>
                            
                            <div class="col-md-4 form-group">
                            	<label key="email_id" class="tr">Email</label>
                              <input type="text" id="email_id" name="email_id" autocomplete="off" class="form-control">
                            </div>
                            
                            <div class="col-md-4 form-group">
                            	<label key="mobile_no" class="tr">Mobile No.</label>
                              <input type="text" class="form-control numeric" autocomplete="off" id="mobile_no" name="mobile_no">
                            </div>
                            
                            <div class="col-md-4 form-group">
                            	<label key="land_line_no" class="tr">Landline No.</label>
                              <input type="text" class="form-control" autocomplete="off" id="land_line_no" name="land_line_no">
                            </div>
                            
                            <div class="col-md-4 form-group">
                            	<label key="membership_number" class="tr">Membership Number</label>
                              <input type="text" class="form-control" autocomplete="off" id="membership_number" name="membership_number">
                            </div>
                            
                            <div class="col-md-4 form-group">
                               <input type="submit" class="gold_btn fade_anim" value="SUBMIT">
                            </div>
                            
                            </div>
                    	</form>                  	
                    </div>                            
     			</div>
                
                <h2 class="mb-5 title">Key Figures Since 2015</h2>
                
                <div class="row justify-content-center align-content-stretch">
                
                    <div class="col-6 col-md-4 pb-5">
                        <div class="kf_box">
                            <div class="kf_no"> <span>6,00,000</span></div> 
                            Lives <br /> Covered 
                        </div>
                     </div>
           
                     <div class="col-6 col-md-4 pb-5">
                        <div class="kf_box">
                            <div class="kf_no"><span>1,75,000</span></div> 
                            Families <br /> Covered
                        </div>
                    </div>
                    
                     <div class="col-6 col-md-4 pb-5">
                        <div class="kf_box"><div class="kf_no"><span>800</span></div> Companies <br /> (Policies Issued)</div>
                    </div>
                    
                     <div class="col-6 col-md-4 pb-5">
                        <div class="kf_box"><div class="kf_no"><span> 2,50,00,000</span></div> Contribution <br /> by GJEPC</div>
                    </div>
                    
                     <div class="col-6 col-md-4 pb-5">
                        <div class="kf_box"><div class="kf_no"><span>1,30,00,00,000</span></div>Claims <br /> Disbursed</div>
                    </div>
                    
                </div>
         		
                <p class="mb-5">Our efforts are ongoing to capture the entire pool of workers from the gem and jewellery industry and we encourage all our members to come forward and take advantage of this scheme. </p>
                        
             	<div class="row justify-content-between mb-5 ab_none">
                    
                    <div class="col-md-6 mb-5 mb-md-0"> 
                    
           				<h2 class="title">Benefits Of The Policy</h2>
    
                        <ul class="mb-3 inner_under_listing">
                            <li>Family floater policy covering entire family, including parents</li>
                            <li>No waiting period and pre-existing diseases covered from Day 1</li>
                            <li>No medical check-up even for parents</li>
                            <li>Maternity and newborn baby coverage from Day 1 </li>
                        </ul>
                    	
                        <p>Standard exclusions of a Mediclaim policy applicable</p>
                        
                    </div>
                    
                    <div class="col-md-5">
                    	<div class="swasthya_know_more">
                            <h2 class="text-uppercase">To Know More </h2>
                            <p class="text-capitalize">contact our dedicated Swasthya Ratna Team :</p>
                            <p><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:sales@cms.co.in">swasthya@gjepcindia.com</a></p>
                            <p >Naren Kotak : <a href="tel:9322860724">+91 93228 60724</a></p>
                            <p>Kshitij Mohan : <a href="tel:9833958730">+91 98339 58730</a></p>
                            
                           
                            
                        </div>
                    </div>
                    
				</div>
                
                	
                	<h2 class="title">Companies Availed Swasthya Ratna Scheme</h2>
                    
                    <div class="enrolled_slider">
                            
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">A Lallubhai & Brothers Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Abharan Jewellers Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Akarsh Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Akshar Impex Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Alok Impex Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Aneri Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Ankit Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Anmol Jewellers Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Ans Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Ansh Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Antara Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Antrix Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Apranje Jewellers Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Asha Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Ashlyn Chemunnoor Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Ashwin Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Asian Star Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Auro Manufacturing Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Avishay Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">B Ashwinkumar Group</div></div></div>
                     		</div>
                        </div>
                        
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">B Manek Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Bhansali Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Bipinchandra & Co Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Birdhichand Ghanshyamdas Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Blue Star Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">BR Design Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Brillimpex Export Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Carat King Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">CGR Metalloys Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Charu Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Chintan Impex Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Concept Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">D Navinchandra Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">D S Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Daga Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Dai Rays Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Davariya Brothers Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Deccan Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Dev Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">DFine Jewellery Group</div></div></div>
                     		</div>
                        </div>
                        
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Dhanera Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Dharmanandan Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Diagems Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Diamars Fine Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Diasmaart Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Dirgh Diamond Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">DNJ Creation Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Doshi Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">DRC Techno Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">DTS Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Elegant Collection Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Emerald Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">EON Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Estrella Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Facet Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Farah Khan Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Fine Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Finess Design Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">G V Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Gandhi Enterprise Group</div></div></div>
                     		</div>
                        </div>
                        
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Gems Mart Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">GG Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Global Diam Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Global Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Glow Star Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Golawala Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Gold Star Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Golkunda Diamonds Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Gurukrupa Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">H Dipak Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Hari Darshan Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Harshwardhan Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Idex Online Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Indian Gem Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Indus Advanced Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">J B Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Jagruti Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Jaipur Emporium Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Janam Diamonds Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Jasani Jewellery Group</div></div></div>
    						</div>
                        </div>
                        
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Jewel India Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Jewel Star Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Jewelex Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">JH Jeweller Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Jogani Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">K Girdharlal Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">K M Shah Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">K P Sanghavi Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">K P Sanghvi Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Kama Schachter Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Kantilal Chhotalal Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Kapu Gems Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Kays Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">KBS Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Ketan Brothers Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">KGK Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Khushi Creation Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Kiran Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">KM Martiya Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">KNS Group</div></div></div>
    						</div>
                        </div>
                        
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Kothari Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">L B Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Lavasa Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Laxmi Diamond Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Laxya Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Lemon Technomist Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Lotus Gem Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">M J Gold Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">M L Gadara Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">M Suresh Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Mahendra Brother Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Mani Jewel Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Marque Artisans Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Maruti Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Meet Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Mehta Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Mira Gems Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">MK Impex Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Monarch Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">N J Gems Group</div></div></div>
    						</div>
                        </div>
                        
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">N K Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Neel Madhav Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Nemichand Bamalwa Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Nikhaar Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">NK Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">NTS Navrattan Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">P Mangatram Jewellers Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Padmavati Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Paras Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Parishi Diamond Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Peacemoon Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Pinkcity Jewel Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Precigem Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Priority Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Prism Jewellery Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">R Suresh Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Rainbow Star Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Raj Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Rajesh Corp Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Rapaport Diamond Group of Companies</div></div></div>
    						</div>
                        </div>
                        
                       	<div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Rare Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Red Exim Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Renaissance Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Rijiya Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">RMC Gems Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Rockrush Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Rutava Gems Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">S Vinodkumar Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Samarth Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Sant Ram Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Santosh Jewellers Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Saraff Solitaires Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shah Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shairu Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shasvat Diam Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Sheetal Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shiv Shakti Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shree Omkar Jewellers Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shree Ramkrishna Exports (SRK) Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shreeji Diamond Group</div></div></div>
    						</div>
                        </div>
                        
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shri Hari Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shrushti Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Shubhang Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Star Rays Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Steckbeck Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Stellar Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">SunJewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Sunny Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Sunshine Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Suraj Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Suvarnakala Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Swati Pearls Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Tanvirkumar Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Thumar Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Tirupati Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Trio Jewels Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Twinkle Star Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">UNI Design Group of Companies</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Utsav Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Vaibhav Gems Group</div></div></div>
    						</div>
                        </div>
                        
                        <div> 
                        	<div class="d-flex px-2 flex-wrap align-content-stretch align-content-center">
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Vallabhji Malsi Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Varni Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Vees Star Diamond Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Venus Jewel Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Vijay Gems Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">VM Jewellery Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Yash Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Zaveri Exports Group</div></div></div>
                                <div class="ec_box"><div class="d-flex h-100"><div class="m-auto">Zaveri Jewellery Group</div></div></div>
    						</div>
                        </div>
                        
                   	</div>
               
              
   				            
 			</div>
                    
        </div>        
    </div>       
</section>

<?php include 'include-new/footer.php'; ?>
<script src="assets/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery().ready(function() {
	$("#loginform").validate({
		rules: { 
			company_name: {
				required: true,
			}, 
			address: {
				required: true,
			},
			total_employee: {
				required: true,
				number:true,
			},
			fname: {
				required: true,
			},
			designation: {
				required: true,
			},
			email_id: {
				required: true,
				email:true
			}, 
			land_line_no: {
				required: true,
				number:true
			},
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			membership_number:{
				required: true,
			},
		},
		messages: {
			company_name: {
				required: "Please Enter Company Name",
			},
			address: {
				required: "Please Enter Address",
			},
			total_employee: {
				required: "Please Enter Total Employee",
				number:"Please Enter Numbers only",
				maxlength:"Please enter no more than {0} digit."
			}, 
			fname: {
				required: "Please Enter Name",
			},
			designation: {
				required: "Please Enter Designation",
			},
			email_id: {
				required: "Please Enter a valid email id",
			},
			land_line_no: {
				required: "Please Enter landline number",
				number:"Please Enter Numbers only"
			},
			mobile_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			membership_number: {
				required: "Please Enter Membership Number",
			}
	 }
	});
	
	$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});
	
});
</script>


<script>

var aLangKeys=new Array();
aLangKeys['en']=new Array();
aLangKeys['hi']=new Array();

aLangKeys['en']['enroll']='ENROLL YOUR COMPANY';
aLangKeys['en']['company_name']='Company Name';
aLangKeys['en']['address']='Company Address';
aLangKeys['en']['total_employee']='Total no. of employees / workers';
aLangKeys['en']['fname']='Name';
aLangKeys['en']['designation']='Designation';
aLangKeys['en']['email_id']='Email';
aLangKeys['en']['mobile_no']='Mobile No.';
aLangKeys['en']['land_line_no']='Land line no';
aLangKeys['en']['membership_number']='Membership Number';

aLangKeys['hi']['enroll']='???????????? ??????????????? ?????? ????????????????????? ????????????';
aLangKeys['hi']['company_name']='??????????????? ?????? ?????????';
aLangKeys['hi']['address']='??????????????? ?????? ?????????';
aLangKeys['hi']['total_employee']='????????? ??????????????? ????????????????????????/ ?????????????????? ????????? ';
aLangKeys['hi']['fname']='?????????';
aLangKeys['hi']['designation']='????????????????????????????????? (???????????????)';
aLangKeys['hi']['email_id']='????????????';
aLangKeys['hi']['mobile_no']='?????????????????? ????????????';
aLangKeys['hi']['land_line_no']='???????????????????????? ??????.';
aLangKeys['hi']['membership_number']='????????????????????? ????????????';



$(document).ready(function() {
    // onclick behavior
    $('.lang').click( function() {
        var lang = $(this).attr('id'); // obtain language id

        // translate all translatable elements
        $('.tr').each(function(i){
          $(this).text(aLangKeys[lang][ $(this).attr('key') ]);
        });
    });
});


$(".lang_switcher button").click(function(){
  $(".lang_switcher button").removeClass("active");
  $(this).addClass("active");
});

</script>

