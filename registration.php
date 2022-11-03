<?php 
$pageTitle = "Gem & Jewellery | New Registration - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is India's Apex body of Gems & Jewellery supported by the Ministry of Commerce and Industry, Govt. Of India.";
?>

<?php include 'include-new/header.php'; ?>
<?php
include 'db.inc.php';
include 'functions.php';
$action=$_REQUEST['action'];
if($action=="save")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	
	$email_id = filter($_REQUEST['email_id']);
	if(empty($email_id))
	{   $_SESSION['err_msg']="Please Enter a valid Email id";}
	else if(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
	{
		$_SESSION['err_msg']= "The captcha code does not match!";
	} else {

	$company_pan_no	=	strtoupper(filter(mysqli_real_escape_string($conn,$_REQUEST['company_pan_no'])));
	$company_gstn	=	strtoupper(filter(mysqli_real_escape_string($conn,$_REQUEST['company_gstn'])));
	$company_type	=	$_REQUEST['company_type'];
	$pass		=	generatePassword();
	$company_name	=	strtoupper(filter(mysqli_real_escape_string($conn,$_REQUEST['company_name'])));
	$address_line1	=	strtoupper(filter(mysqli_real_escape_string($conn,$_REQUEST['address_line1'])));
	$address_line2	=	strtoupper(filter(mysqli_real_escape_string($conn,$_REQUEST['address_line2'])));
	$address_line3	=	strtoupper(filter(mysqli_real_escape_string($conn,$_REQUEST['address_line3'])));
	$pin_code = filter($_REQUEST['pin_code']);
	$city	  =	strtoupper(filter($_REQUEST['city']));
	$country  = strtoupper($_REQUEST['country']);
	$state    = strtoupper(addslashes($_REQUEST['state']));
	$mobile_no 		= filter(mysqli_real_escape_string($conn,$_REQUEST['mobile_no']));
	$land_line_no 	= filter(mysqli_real_escape_string($conn,$_REQUEST['land_line_no']));
    //$member_of_any_other_organisation = $_REQUEST['member_of_any_other_organisation'];
	//$name_of_organisation = strtoupper(filter($_REQUEST['name_of_organisation']));
	$nature_of_buisness   = $_REQUEST['nature_of_buisness'];
	
	foreach($nature_of_buisness as $val)
	{
		if($val=="other")
		{
			$nature_of_buisness_other=$_REQUEST['nature_of_buisness_other'];
			$nature_of_buisness_new.=$nature_of_buisness_other.",";
		} else	{
			$nature_of_buisness_new.=$val.",";	
		}
	}
	$dt = date('Y-m-d');
	$ip = $_SERVER['REMOTE_ADDR'];
	$website="GJEPC - ".  date("Y");
	
	$query  = $conn->query("select * from registration_master where email_id='$email_id' or company_pan_no='$company_pan_no'");
	$num = $query->num_rows;
	if($num>0)
	{	
		$_SESSION['err_msg']="Already registered with this Email id or Pan no";
	} else
    {
	$hash = md5(rand(0,1000));
	$password = md5($pass);
	$sql="insert into registration_master set email_id='$email_id',old_pass='$pass',company_secret='$password',company_pan_no='$company_pan_no',company_gstn='$company_gstn',company_type='$company_type',company_name='$company_name',address_line1='$address_line1',address_line2='$address_line2',pin_code='$pin_code',city='$city',country='$country',state='$state',land_line_no='$land_line_no',mobile_no='$mobile_no',nature_of_buisness='$nature_of_buisness_new',status='0',website='$website',post_date='$dt',ip='$ip',hash='$hash'";
	$query  = $conn->query($sql);
	if($query){
	/*.......................................Send mail to users mail id...............................................*/
	$message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://www.gjepc.org/assets/images/logo.png"> </td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Thank you for registering at Gems and Jewellery Export Promotion Council (GJEPC).</h4></td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td>Your account has been created, Please click The following link For verifying and activation of your account</td></tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Company Name :</strong> '. $company_name .' </td>
    </tr>
	<tr>
    <td align="left" style="text-align:justify;"><strong>Password :</strong> '. $pass .' </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">Please click this link to activate your account:<br/>
    https://gjepc.org/verify.php?email='.$email_id.'&hash='.$hash.'</td>
  </tr>
   <tr><td>       
      <p>Kind Regards,<br>
      <b>GJEPC Web Team,</b>
      </p>
	  <p> For Any Queries : </p>
    </td>
  </tr>
  <tr><td><b>Toll Free Number :</b> 1800-103-4353 <br/>
<b>Missed Call Number :</b> +91-7208048100
 </td></tr> 
</table>';
  
	 $to = $email_id;
	 $subject = "New User Registration"; 
	 $cc = "";
/*	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From: GJEPC <admin@gjepc.org>';
	 mail($to, $subject, $message, $headers); */
	 send_mail($to,$subject,$message,$cc);
	// send_mail("neelmani@kwebmaker.com","hi","This is test mail","donotreply@gjepcindia.com");
	 $_SESSION['succ_msg']="Thanks for Registration, <br/> Please verify it by clicking the activation link that has been send to your email.";
	 }
	 else{
	 $_SESSION['err_msg']="There is some technical problem";
	 }
	}
  }
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>
<style>
	.loader {
    position: fixed;
	display:none;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('https://gjepc.org/assets/images/logo.png') 50% 50% no-repeat rgb(249,249,249);
    opacity: 80;
	}
	.body_text{height: 95px;margin-top: 20px;}
	ol li{list-style: disc;}
</style>	
<?php 
if($_SESSION['err_msg']!=""){
echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
$_SESSION['err_msg']="";
}
if($_SESSION['succ_msg']!=""){
echo "<div class='text-center py-5'><span style='color: green;'>".$_SESSION['succ_msg']."</span></div>";
$_SESSION['succ_msg']="";
}
else{
?>	

<section class="py-5">
	<div class="loader">  <div style="display:table; width:100%; height:100%;"><span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span></div></div>
    <div class="container-fluid inner_container">
		<div class="row justify-content-center grey_title_bg">      
        	
            <div class="col-12 bold_font text-center d-block"><div class="d-block"><img src="assets/images/gold_star.png"></div> New Registration </div>
                <div class="col-12">               
                    <div class="d-flex justify-content-center mb-3 lang_switcher">
                		<div><button id="en" class="lang active">English</button></div>
                		<div><button id="hi" class="lang">Hindi</button></div>
            		</div>
                </div>                  
        </div>
                    
            <div class="container">				
                <div class="row justify-content-center">
                            
                    <form class="cmxform col-md-10 box-shadow" method="POST" name="regisForm" id="regisForm" autocomplete="off">
					<div class="row mb-4">                        
                        <div class="form-group col-12 mb-4">
                            <p class="blue tr" key="enroll">Account Information &nbsp;&nbsp;<span id="chkregisuser"></span><br/><span id="chkpanuser"></span></p>
                        </div>                          
                        <input type="hidden" name="action" value="save"/>
                        
                        <?php token(); ?>
                        
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="email_id" key="email_id" class="tr">Email address (Username)</label>
                                <input type="email" class="form-control" id="email_id" name="email_id" autocomplete="off" maxlength="40">
                            </div>
                            
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="cemail_id" key="cemail_id" class="tr">Confirm Email address</label>
                                <input type="email" class="form-control" id="cemail_id" name="cemail_id" autocomplete="off" maxlength="40">
                            </div>	
                            
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="cemail_id" key="company_pan_no" class="tr">Company PAN No</label>
								<span id="panVerifyIcon" class="inputMaskIcon"><i class="text-success fa fa-check"></i></span>
                                <input type="text" class="form-control" id="company_pan_no" name="company_pan_no" autocomplete="off" maxlength="10">								
                            </div>
                                
                            <div class="form-group col-lg-4 col-md-6">                                
                                <label for="company_name" key="GSTIN_holder_status" class="tr">GSTIN Holder Status</label>                                
                                <div class="mt-2">                                  
                                    <label for="Yes" class="mr-3"><input type="radio" name="gst_holder" id="gst_holder" value="Y" class="mr-2"/><span class="tr" key="yes">Yes</span></label>
                                    <label for="No"><input type="radio" name="gst_holder" id="gst_holder" value="N" class="mr-2"/><span class="tr" key="no">No</span></label>
                                </div>                                
                                <label for="gst_holder" generated="true" style="display: none;" class="error">Please select your eligibility for GST</label>                        
                            </div>
                        
                            <div class="form-group col-lg-4 col-md-6">
                            <label for="cemail_id" key="company_gstn" class="tr">Company GSTIN</label>
							<span id="gstVerifyIcon" class="inputMaskIcon"><i class="text-success fa fa-check"></i></span>
                            <input type="text" class="form-control" id="company_gstn" name="company_gstn" autocomplete="off" maxlength="15">
                            </div>                            
                         </div>                           
                         
                          <div class="row mb-4">                    
                            <div class="form-group col-12 mb-4"><p class="blue tr" key="company_info">Company Information</p></div>                            
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="company_name" class="tr" key="company_type">Company Type</label>
                                <div class="mt-2">
                                <label for="company_type" generated="true" style="display: none;" class="error">Please Select Company type</label>
                                       
                                    <label for="Propritory" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="14" class="mr-2"><span class="tr" key="Propritory">Propritory </span>
                                    </label>
                                    <label for="Partnership" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="11" class="mr-2"><span class="tr" key="Partnership">Partnership</span>
                                    </label>
                                    <label for="Private" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="13" class="mr-2"><span class="tr" key="Private">Private Ltd.</span>
                                    </label>                          
                                    <label for="Public">
                                    <input type="radio" id="company_type" name="company_type" value="12"  class="mr-2"><span class="tr" key="Public">Public Ltd.</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="company_name" class="tr" key="company_name">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" autocomplete="off" maxlength="38">
							</div>
							
                            <div class="form-group col-lg-4 col-md-6">
                            <label for="address_line1" class="tr" key="address1">Address Line 1</label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1" autocomplete="off" >
                            </div>
                            
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="address_line2" class="tr" key="address2">Address Line 2</label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2" autocomplete="off">
                        </div>
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="address_line3" class="tr" key="pincode">Pin code</label>
                            <input type="text" class="form-control numeric" id="pin_code" name="pin_code" maxlength="6" minlength="6" autocomplete="off"/>
                        </div>                      
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="country" class="tr" key="Country">Country</label>
                            <select name="country" id="country" class="form-control"> 
                            <option value="IN" selected="selected">INDIA</option>
                            </select> 			
                        </div>
                        
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="country" class="tr" key="State">State</label>
                            <div id="stateDiv">
                            <select name="state" id="state" class="form-control">
                            <option value="">--- Select State ---</option>
                            <?php 
							$sql="SELECT state_code,state_name from state_master WHERE country_code = 'IN'";
							$stmt = $conn -> prepare($sql);
							$stmt -> execute();			
							$query = $stmt->get_result();
							while($result = $query->fetch_assoc()) { ?>
							<option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
							<?php }?>
                            </select>
                            </div>	
                        </div>
                        
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="city" class="tr" key="City">City</label>
                            <input type="text" class="form-control" id="city" name="city" autocomplete="off">
                        </div>
                        
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="land_line_no" class="tr" key="Landline">Landline No</label>
                            <input type="number" class="form-control" id="land_line_no" name="land_line_no" autocomplete="off" onkeypress="if(this.value.length==14) return false;" >
                        </div>
                        
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="mobile_no" class="tr" key="Mobile">Mobile No</label>
                            <input type="number" class="form-control numeric" id="mobile_no" name="mobile_no" autocomplete="off" onkeypress="if(this.value.length==10) return false;" >
                        </div>            
                        
                        <div class="form-group col-lg-8 col-md-6">
                            <div class="d-block"><label for="mobile_no" class="tr" key="Business"><strong>Business Nature</strong></label></div>                        
                            <label for="Retailer" class="mr-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Retailer"><span class="tr" key="Retailer"> Retailer </span></label>
                            <label for="Wholesaler" class="mr-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Wholesaler"><span class="tr" key="Wholesaler"> Wholesaler Agent</span></label>
                            <label for="Importers" class="mr-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="IE"><span class="tr" key="Importers"> Importers / Exporters</span></label>
                            <label for="Manufacturer" class="mr-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Manufacturer"><span class="tr" key="Manufacturer"> Manufacturer</span></label> 
							<label for="Other" class="mr-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="other" value="other"> 
                            <!--<input type="text" class="form-control" id="nature_of_buisness_other" name="nature_of_buisness_other" autocomplete="off" onkeypress="" placeholder="Other">--><span class="tr" key="Other">Other</span></label>
                        </div>
                        
                        <div class="form-group col-12 d-none">
                        <p class="blue">Terms of Agreement</p>
                        <div class="form-group col-md-12">
                      
                             <p>These are the general terms and conditions of&nbsp;Gems and Jewellery Export Promotion Council&nbsp;(GJEPC) for use of the GJEPC web site. Please read these terms and conditions carefully as your use of the Site is subject to them. GJEPC reserves the right at its sole discretion to change, modify or add to these terms and conditions without prior notice to you. By continuing to use the Site you agree to be bound by such amended terms.</p>
                
                            <ol class="inner_under_listing">
                                <li>What you are allowed to do You may:
                                <ol>
                                    <li>browse the Site and view the information on it for personal, professional or other commercial purposes;</li>
                                    <li>print off pages from the Site to the extent reasonably necessary for your use of the Site in accordance with the above. Provided that at all times you do not do any of the things set out in clause 2.</li>
                                </ol>
                                </li>
                                <li>What you are not allowed to do Subject to these terms and conditions, you may not:
                                <ol>
                                    <li>systematically copy (whether by printing off onto paper, storing on disk or in any other way) substantial parts of the Site;</li>
                                    <li>remove, change or obscure in any way anything on the Site or otherwise use any material contained on the Site except as set out in these terms and conditions;</li>
                                    <li>include or create hyperlinks to the Site or any materials contained on the Site; or</li>
                                    <li>use the Site and anything available from the Site in order to produce any publication or otherwise provide any service that competes with the Site (whether on-line or by other media); or</li>
                                    <li>for unlawful purposes and you shall comply with all applicable laws, statutes and regulations at all times.</li>
                                </ol>
                                </li>
                                <li>No Investment Advice You acknowledge that:
                                <ol>
                                    <li>GJEPC does not provide investment advice and that nothing on the Site constitutes investment advice (as defined in the Financial Services Act 1986) and that you will not treat any of the Site&#39;s content as such;</li>
                                    <li>GJEPC does not recommend any financial product;</li>
                                    <li>GJEPC does not recommend that any financial product should be bought, sold or held by you; and</li>
                                    <li>nothing on the Site should be construed as an offer, nor the solicitation of an offer, to buy or sell securities by GJEPC</li>
                                    <li>information which may be referred to on the Site from time to time may not be suitable for you and that you should not make any investment decision without consulting a fully qualified financial adviser.</li>
                                </ol>
                                </li>
                                <li>Access The Site is directed exclusively at users located within the United Kingdom and as such any use of the site by users outside India is at their sole risk. By using the Site you confirm that you are located within India and that you are permitted by law to use the Site.</li>
                                <li>Your personal information:<br />
                                GJEPC&#39;s use of your personal information is governed by GJEPC&#39;s Privacy Policy, which forms part of these terms and conditions.</li>
                                <li>Copyright and Trade Marks
                                <ol>
                                    <li>All copyright and other intellectual property rights in any material (including text, photographs and other images and sound) contained in the Site is either owned by GJEPC or has been licensed to GJEPC by the rights owner(s) for use by GJEPC on the Site. You are only allowed to use the Site and the material contained in the Site as set out in these terms and conditions.</li>
                                    <li>The Site contains trade marks, including the GJEPC name and logo. All trade marks included on the Site belong to GJEPC or have been licensed to GJEPC by the trade mark owner(s) for use on the Site. You are not allowed to copy or otherwise use any of these trade marks in any way except as set out in these terms and conditions.</li>
                                </ol>
                                </li>
                                <li>Exclusions and limitations of liability
                                <ol>
                                    <li>GJEPC does not exclude or limit its liability for death or personal injury resulting from its negligence, fraud or any other liability which may not by applicable law be excluded or limited.</li>
                                    <li>Subject to clause 7.1, in no event shall GJEPC be liable (whether for breach of contract, negligence or for any other reason) for (i) any loss of profits, (ii) exemplary or special damages, (iii) loss of sales, (iv) loss of revenue, (v) loss of goodwill, (vi) loss of any software or data, (vii) loss of bargain, (viii) loss of opportunity, (ix) loss of use of computer equipment, software or data, (x) loss of or waste of management or other staff time, or (xi) for any indirect, consequential or special loss, however arising.</li>
                                </ol>
                                </li>
                                <li>Disclaimer
                                <ol>
                                    <li>ALL INFORMATION CONTAINED ON THE SITE IS FOR GENERAL INFORMATIONAL USE ONLY AND SHOULD NOT BE RELIED UPON BY YOU IN MAKING ANY INVESTMENT DECISION. THE SITE DOES NOT PROVIDE INVESTMENT ADVICE AND NOTHING ON THE SITE SHOULD BE CONSTRUED AS BEING INVESTMENT ADVICE. BEFORE MAKING ANY INVESTMENT CHOICE YOU SHOULD ALWAYS CONSULT A FULLY QUALIFIED FINANCIAL ADVISER.</li>
                                    <li>ALTHOUGH GJEPC USES ITS REASONABLE EFFORTS TO ENSURE THAT INFORMATION ON THE SITE IS ACCURATE AND COMPLETE, WE CANNOT GUARANTEE THIS TO BE THE CASE. AS A RESULT, USE OF THE SITE IS AT YOUR SOLE RISK AND GJEPC CANNOT ACCEPT ANY LIABILITY FOR LOSS OR DAMAGE SUFFERED BY YOU ARISING FROM YOUR USE OF INFORMATION CONTAINED ON THE SITE. YOU SHOULD TAKE ADEQUATE STEPS TO VERIFY THE ACCURACY AND COMPLETENESS OF ANY INFORMATION CONTAINED ON THE SITE.</li>
                                    <li>Information contained on the site is not tailored for individual use and as a result such information may be unsuitable for you and your investment decisions. You should consult a financial adviser before making any investment decision.</li>
                                    <li>The Site includes advertisements and links to external sites and co-branded pages in order to provide you with access to information and services which you may find useful or interesting. GJEPC does not endorse such sites nor approve any content, information, goods or services provided by them and cannot accept any responsibility or liability for any loss or damage suffered by you as a result of your use of such sites.</li>
                                    <li>GJEPC is unable to exercise control over the security or content of information passing over the network or via the Service, and GJEPC hereby excludes all liability of any kind for the transmission or reception of infringing or unlawful information of whatever nature.</li>
                                    <li>GJEPC accepts no liability for loss or damage suffered by you as a result of accessing Site content which contains any virus or which has been maliciously corrupted.</li>
                                </ol>
                                </li>
                                <li>Availability and updating of the Site
                                <ol>
                                    <li>GJEPC may suspend the operation of the Site for repair or maintenance work or in order to update or upgrade its content or functionality from time to time. GJEPC does not warrant that access to or use of the Site or of any sites or pages linked to it will be uninterrupted or error free.</li>
                                    <li>GJEPC may change the format and content of the Site at its sole discretion from time to time. You should refresh your browser each time you visit the Site to ensure that you access the most up to date version of the Site.</li>
                                </ol>
                                </li>
                                <li>Enquiries or complaints<br />
                                If you have any enquiries or complaints about the Site then please address them (within 30 days of such enquiry or complaint first arising) to : email: info@gjepc.org</li>
                                <li>General and governing law
                                <ol>
                                    <li>These terms and conditions form the entire understanding of the parties and supersede all previous agreements, understandings and representations relating to the subject matter. If any provision of these terms and conditions is found to be unenforceable, this shall not affect the validity of any other provision. GJEPC may delay enforcing its rights under these terms and conditions without losing them. You agree that GJEPC may sub-contract the performance of any of its obligations or may assign these terms and conditions or any of its rights or obligations without giving you notice.</li>
                                    <li>GJEPC will not be liable to you for any breach of these terms and conditions which arises because of any circumstances which GJEPC cannot reasonably be expected to control.</li>
                                    <li>These terms and conditions shall be governed and interpreted in accordance with Indian law, and you consent to the non-exclusive jurisdiction of the Indian courts.</li>
                                </ol>
                                </li>
                            </ol>
                
                        </div>
                        
                        <div class="form-group radio col-md-12">
                            <label for="terms_and_cond">
                            <input type="checkbox" name="terms_and_cond" id="terms_and_cond" value="1"> I have read and agree to the 'Terms of Agreement' above.<label for="terms_and_cond" generated="true" style="display: none;" class="error"></label></label>
                        </div>                        
                    </div>
                    
                        <div class="form-group col-12">		
                        <p class="tr" key="text">This is for testing whether you are a human visitor and to prevent automated spam submissions.</p>
                        </div>
                        
                        <div class="form-group col-lg-4 col-md-6">
                        <input type="text" class="form-control" autocomplete="off" id="captcha_code" name="captcha_code" placeholder="Enter Captcha Code"/>
                        </div>
                        <div class="form-group col-md-6">
                        <div class="d-flex align-items-center">
                        <div class="mr-3"><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/></div>
                        <div><a href='javascript: refreshCaptcha();'><b><i class="fa fa-refresh" aria-hidden="true"></i></b></a></div>
                        </div>
                        </div>
                        
                        <div class="form-group col-12">
                            <div class="d-flex">
                                <div><button type="submit" id="register" class="cta fade_anim mr-2">Submit</button></div>
                                <div><button type="reset" class="cta cta2 fade_anim">Reset</button></div>
                             </div>
                        </div>                        
              </div>
			</form>                
                </div>            
            </div>    
	</div>    
    </div>
</section> 
    
<?php } ?>
</div>
<?php include 'include-new/footer.php'; ?>

<script src="assets/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
	if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
   };
   },	"Special Characters Not Allowed");
   
	jQuery.validator.addMethod("panno", function (value, element) {
	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
		if (value.match(regExp) ) {
			return true;
		} else {
			return false;
		};
		},"Please Enter Valid PAN No.");
		
	$("input[type='radio']").on('change', function () {
         var gst_holder = $("input[name='gst_holder']:checked").val();
         if (gst_holder=='N')
               $("#company_gstn").val("NA");
		  else
		  	$("#company_gstn").val("Company GSTIN");
     });
	
	$.validator.addMethod("gstno", function(value, element) {
	if(value=='NA')
		return true;
	else {
	return this.optional(element) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test(value);
	} }, "Please Enter Valid GSTIN No.");

	$("#regisForm").validate({
		rules: {  
			email_id: {
				required: true,
				email:true
			},  
			cemail_id:{
			 required: true,
			 email:true,
			 equalTo: "#email_id"
			},
			company_pan_no: {
				required: true,
				panno: true,
				minlength: 10,
				maxlength:10
			}, 
			gst_holder:"required", 
			company_gstn: {
				required: true,
				gstno:true
			},  
			company_type: {
				required: true,
			},
			company_name: {
				required: true,
				specialChrs: true
			}, 	 
			address_line1: {
				required: true,
				specialChrs: true
			},
			pin_code: {
				required: true,
				number:true,
				minlength:6,
				maxlength:6
			},
			city: {
				required: true,
				specialChrs: true
			},
			country: {
				required: true,
			},
			state: {
				required: true,
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
			// member_of_any_other_organisation: {
			// 	required: true,
			// },
			nature_of_buisness: {
				required: true,
			},
			/*terms_and_cond:	{
				required: true,
			},*/
			captcha_code:{
				required: true,
			},
		},
		messages: {
			email_id: {
				required: "Please Enter a valid Email id",
			},
			cemail_id: {
				required: "Please Enter a valid Email id",
				equalTo: "Please Enter the same Email id as above"
			},  
			company_pan_no: {
				required: "Please Enter Company PAN No",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},  
			gst_holder: "Please select your eligibility for GST",
			company_gstn: {
				required: "Please Enter Company GSTIN",
			},
			company_type: {
				required: "Please Select Company type",
			},   
			company_name: {
				required: "Please Enter Company Name",
			},  
			address_line1: {
				required: "Please Enter Your Address",
			},
			pin_code: {
				required: "Please Enter your pin code",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 6 characters",
				maxlength:"Please Enter not more than 6 characters"				
			},
			city: {
				required: "Please Enter City",
			},
			country: {
				required: "Please Choose Country",
			},
			state: {
				required: "Please Choose state",
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
			// member_of_any_other_organisation: {
			// 	required: "Please Select any",
			// },
			nature_of_buisness: {
				required: "Please selct bussiness nature",
			},  
			/*terms_and_cond: {
				required:"Required.",
			},*/
			captcha_code:{
				required: "Please Enter Captcha Code",
			}
	 }
	});
});
</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<script>
$(document).ready(function(){
$("#country").change(function(){
	country=$("#country").val();
		$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getCity&country="+country,
					dataType:'html',
					beforeSend: function(){
							$('.loader').show();
							},
					success: function(data){
							$('.loader').hide();
							//alert(data);
							$("#stateDiv").html(data);  
							}
		});
 });
 });
</script>
 
<script>
$(document).ready(function(){
  $("#email_id").change(function(){
	email_id=$("#email_id").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkregisuser&email_id="+email_id,
					dataType:'html',
					beforeSend: function(){
						$('.loader').show();
							},
					success: function(data){
							     //alert(data);
								 $('.loader').hide();
								 if(data==0){
								 	$('#register').attr('disabled' , true);
									$("#chkregisuser").html("Already registered with this email id").css("color", "red"); 
								 }else{
								 	$("#chkregisuser").html("");
								 	$('#register').removeAttr("disabled");
								 }
							}
		});
 });
});
</script>
<script>
$(document).ready(function(){
	$("#panVerifyIcon").hide();
	$("#company_pan_no").change(function(){
	$("#panVerifyIcon").hide();
	company_pan_no = $("#company_pan_no").val();
	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
		
		if(company_pan_no.match(regExp)){
			
		$.ajax({		
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkpan&company_pan_no="+company_pan_no,
					dataType:'html',
					beforeSend: function(){
						$('.loader').show();
						},
					success: function(data){
							     //alert(data);
								 $('.loader').hide();
								 if(data==0){
								 	$('#register').attr('disabled' , true);
									$("#chkpanuser").html("Already registered with this pan no").css("color", "red"); 
								 } else {
									$('.loader').hide();
								 //	$('#register').removeAttr("disabled");
									$("#chkpanuser").html("");
									$.ajax({		
										type: 'POST',
										url: 'ajax.php',
										data: "actiontype=checkPanApi&company_pan_no="+company_pan_no,
										dataType:'json',
										beforeSend: function(){
												$('.loader').show();
												},
										success: function(data){
												  		$('.loader').hide();
													  	if(data.success == true){
														   if(data.response_code=="100"){
														   	$("#panVerifyIcon").show();
															$('#submit').attr("disabled", false);
															$("#chkpanuser").html("");														
														   } else {
														   	$("#panVerifyIcon").hide();
														   	$('#submit').attr("disabled", true);
															$("#chkpanuser").html("Please enter valid pan number").css("color", "red"); 
														   }
														}else{
															$("#panVerifyIcon").hide();
															$('#submit').attr("disabled", true);
															$("#chkpanuser").html("Please enter valid pan number").css("color", "red"); 
														}
												  	}
									});
								 }
							}
		});
		} else {
			$("#chkpanuser").html("Please enter valid pan number").css("color", "red"); 
			return false;
		}
 });
});
</script>
<script>
// $(document).ready(function(){
//   $("input[name=member_of_any_other_organisation]").change(function(){
// 	if($(this).val()=="Y")
// 		$("#organisation_name").show();
// 	else
// 		$("#organisation_name").hide();	
//  });
// });
</script>

<script type="text/javascript">
	jQuery("#country").change(function(event) {
		if (jQuery("#country").val()=="IN") {
			jQuery("#stateSel").show();
			jQuery("#stateTxt").hide();
		} else {
			jQuery("#stateSel").hide();
			jQuery("#stateTxt").show();
		}
	});
</script>

<script>
	// preparing language file
var aLangKeys=new Array();
aLangKeys['en']=new Array();
aLangKeys['hi']=new Array();

aLangKeys['en']['enroll']='Account Information';
aLangKeys['en']['email_id']='Email address (Username)';
aLangKeys['en']['cemail_id']='Confirm Email address';
aLangKeys['en']['company_pan_no']='Company PAN No';
aLangKeys['en']['GSTIN_holder_status']='GSTIN Holder Status';
aLangKeys['en']['company_gstn']='Company GSTIN';
aLangKeys['en']['yes']='Yes';
aLangKeys['en']['no']='No';

aLangKeys['en']['company_info']='Company Information';
aLangKeys['en']['company_type']='Company Type';
aLangKeys['en']['Propritory']='Propritory ';
aLangKeys['en']['Partnership']='Partnership';
aLangKeys['en']['Private']='Private Ltd.';
aLangKeys['en']['Public']='Public Ltd.';
aLangKeys['en']['company_name']='Company Name';
aLangKeys['en']['address1']='Address Line 1';
aLangKeys['en']['address2']='Address Line 2';
aLangKeys['en']['pincode']='Pin code';
aLangKeys['en']['Country']='Country';
aLangKeys['en']['State']='State';
aLangKeys['en']['City']='City';
aLangKeys['en']['Landline']='Landline No';

aLangKeys['en']['Business']='Business Nature';
aLangKeys['en']['Retailer']=' Retailer ';
aLangKeys['en']['Wholesaler']=' Wholesaler Agent ';
aLangKeys['en']['Importers']=' Importers / Exporters';
aLangKeys['en']['Manufacturer']=' Manufacturer';
aLangKeys['en']['Other']='Other';
aLangKeys['en']['text']='This is for testing whether you are a human visitor and to prevent automated spam submissions.';

aLangKeys['hi']['enroll']='अकाउंट की जानकारी ';
aLangKeys['hi']['email_id']='ईमेल एड्रेस (यूजर का नाम)';
aLangKeys['hi']['cemail_id']='ईमेल एड्रेस कन्फर्म करें';
aLangKeys['hi']['company_pan_no']='कंपनी पैन कार्ड नंबर ';
aLangKeys['hi']['GSTIN_holder_status']='जीएसटीआईएन धारक का स्टेटस ';
aLangKeys['hi']['company_gstn']='कंपनी जीएसटीआईएन ';
aLangKeys['hi']['yes']='हाँ ';
aLangKeys['hi']['no']='नहीं ';

aLangKeys['hi']['company_info']='कंपनी कन्फर्मेशन ';
aLangKeys['hi']['company_type']='कंपनी का प्रकार ';
aLangKeys['hi']['Propritory']='प्रोपराइटर  ';
aLangKeys['hi']['Partnership']='पार्टनरशीप ';
aLangKeys['hi']['Private']='प्राइवेट लिमिटेड ';
aLangKeys['hi']['Public']='पब्लिक लिमिटेड ';
aLangKeys['hi']['company_name']='कंपनी का नाम ';
aLangKeys['hi']['address1']='पता लाइन 1 ';
aLangKeys['hi']['address2']='पता लाइन 2';
aLangKeys['hi']['pincode']='पिन कोड ';
aLangKeys['hi']['Country']='देश ';
aLangKeys['hi']['State']='राज्य ';
aLangKeys['hi']['City']='शहर ';
aLangKeys['hi']['Landline']='लैंडडलाइन नंबर ';

aLangKeys['hi']['Business']='व्यापार की प्रकृति ';
aLangKeys['hi']['Retailer']=' रिटेलर्स  ';
aLangKeys['hi']['Wholesaler']=' होलसेलर एजेंट  ';
aLangKeys['hi']['Importers']=' इम्पोर्टर/ एक्सपोर्टर ';
aLangKeys['hi']['Manufacturer']=' मैन्युफैक्चरर ';
aLangKeys['hi']['Other']='अन्य ';
aLangKeys['hi']['text']='यह सवाल इसलिए पूछा जा रहा है ताकि हम जान सके कि क्या आप एक ह्यूमन विजिटर हैं और हम स्वचालित स्पैम सबमिशन को रोकना चाहते हैं। ';

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

$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});
</script>

<style>
.error {color:red;}
</style>