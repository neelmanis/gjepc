<?php include 'include/header.php'; ?>
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
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email_id))
	{
		$_SESSION['err_msg']="The email you have entered is invalid, please try again."; 
	}else if(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
	{
		$_SESSION['err_msg']= "The captcha code does not match!";
	} else {
	
	$taxation_code	 =	filter($_REQUEST['taxation_code']);
	$taxaiton_number = strtoupper(filter($_REQUEST['taxaiton_number']));
	$company_type	 =	filter($_REQUEST['company_type']);
	$pass		 =	generatePassword();
	$company_name	=	strtoupper(filter($_REQUEST['company_name']));
	$address_line1	=	strtoupper(filter($_REQUEST['address_line1']));
	$address_line2	=	strtoupper(filter($_REQUEST['address_line2']));
	$address_line3	=	strtoupper(filter($_REQUEST['address_line3']));
	$city		=	strtoupper(filter($_REQUEST['city']));
	$country	=	strtoupper($_REQUEST['country']);
	$state		=	strtoupper(filter($_REQUEST['state']));
	$mobile_no	=	filter($_REQUEST['mobile_no']);
	$land_line_no	=	filter($_REQUEST['land_line_no']);
	$nature_of_buisness	=	$_REQUEST['nature_of_buisness'];
	
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
	
	$dt=date('Y-m-d');
	$ip = $_SERVER['REMOTE_ADDR'];
	$website="GJEPC INTL- ".  date("Y");
	
	$query  = $conn->query("select * from registration_master where email_id='$email_id' or taxaiton_number='$taxaiton_number'");
	$num = $query->num_rows;
	if($num>0)
	{	
		$_SESSION['err_msg']="Already registered with this Email id or Taxaiton Number";
	}
    else
    {
	$hash = md5( rand(0,1000) );
	$password = md5($pass);
	$sql="insert into registration_master set email_id='$email_id',company_secret='$password',taxation_code='$taxation_code',taxaiton_number='$taxaiton_number',company_type='$company_type',company_name='$company_name',address_line1='$address_line1',address_line2='$address_line2',address_line3='$address_line3',city='$city',country='$country',state='$state',land_line_no='$land_line_no',mobile_no='$mobile_no',nature_of_buisness='$nature_of_buisness_new',status='0',website='$website',post_date='$dt',ip='$ip',hash='$hash'";
	$query  = $conn->query($sql);
	if($query){
	/*.......................................Send mail to users mail id...............................................*/
	$message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://gjepc.org/images/gjepc_logon.png"> </td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Thank you for registering at Gems and Jewellery Export Promotion Council (GJEPC).</h4></td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td>Your account has been created, Please click The following link For verifying and activation of your account</td></tr>
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
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From: GJEPC <admin@gjepc.org>';		
	 mail($to, $subject, $message, $headers);
	 $_SESSION['succ_msg']="Thanks for Registration, <br/> please verify it by clicking the activation link that has been send to your email.";
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
<section>
	
     <div class="container-fluid inner_container">    	
        <div class="row justify-content-center grey_title_bg">       
        	
            	<div class="innerpg_title_center">
                	<h1>International User Registration </h1>
                </div>                
         </div>
            
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
            	
                <div class="container">                
                <div class="row justify-content-center">                
            <form class="cmxform col-12 box-shadow mb-5" method="POST" name="regisForm" id="regisForm" autocomplete="off">            
            <div class="row">
            
            	<div class="form-group col-12">
                	<p class="blue">Account Information &nbsp;&nbsp;<span id="chkregisuser"></span><br/><span id="chkpanuser"></span></p>
                </div>                
                <input type="hidden" name="action" value="save"/>
                
                <?php token(); ?>
                    <div class="form-group col-sm-6">
                        <label for="email_id">Email address</label>
                        <input type="email" class="form-control" id="email_id" name="email_id" autocomplete="off">
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="cemail_id">Confirm Email address</label>
                        <input type="email" class="form-control" id="cemail_id" name="cemail_id" autocomplete="off">
                    </div>	
                    
                    <div class="form-group col-sm-4">
                    <label for="country">Country</label>
                    <select name="country" id="country" class="form-control"> 
                        <option value="">---------- Select Country ----------</option>
                           <?php 
                            $getCountry=$conn->query("SELECT * FROM country_master where country_code!='IN' order by country_name ASC");
                            while($result = $getCountry->fetch_assoc()){ ?>
                            <option value="<?php echo $result['country_code'];?>" ><?php echo $result['country_name'];?></option>
                            <?php }?>
                    </select> 
                    </div>		
                 
                	<div class="form-group col-sm-4">
                        <label for="country">Taxation Detail</label>
                        <div id="taxationDiv">
                        <select name="taxation_code" id="taxation_code" class="form-control">
                        <option value="">--- Select Taxation Detail---</option>
                        <?php 
                        $gettax=$conn->query("SELECT * from taxation_master WHERE country_code != 'IN'");
                        while($result = $gettax->fetch_assoc()){ ?>
                        <option value="<?php echo $result['taxation_code'];?>"><?php echo $result['taxation_description'];?></option>
                        <?php }?>
                        </select>
                        </div>	
                	</div>	
                
                	<div class="form-group col-sm-4">
                    <label for="company_name">Taxation Number</label>
                    <input type="text" class="form-control" id="taxaiton_number" name="taxaiton_number" autocomplete="off">
                	</div>
           
        			<div class="form-group col-12 mt-3">
                		<p class="blue">Company Information</p>
                	</div>
                    
                    <div class="form-group col-sm-6">
                	<div class="d-block mb-2"><label for="company_name"><strong>Company Type</strong></label></div>
                          
                     <label for="Propritory" class="mr-3">
                    <input type="radio" id="company_type" name="company_type" value="14" class="mr-2">Propritory </label>
                    <label for="Partnership" class="mr-3">
                    <input type="radio" id="company_type" name="company_type" value="11" class="mr-2">Partnership </label>
                    <label for="Private" class="mr-3">
                    <input type="radio" id="company_type" name="company_type" value="13" class="mr-2">Private Ltd.</label>
                   
                    <label for="Public" class="mr-3">
                    <input type="radio" id="company_type" name="company_type" value="12" class="mr-2">Public Ltd.</label>
                            
                	</div>
                
                <div class="form-group col-sm-6">
                    <label for="company_name">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" maxlength="40" autocomplete="off">
                </div>
                
                <div class="form-group col-sm-4">
                    <label for="address_line1">Address Line 1</label>
                    <input type="text" class="form-control" id="address_line1" name="address_line1" autocomplete="off">
                </div>
                <div class="form-group col-sm-4">
                    <label for="address_line2">Address Line 2</label>
                    <input type="text" class="form-control" id="address_line2" name="address_line2" autocomplete="off">
                </div>
                <div class="form-group col-sm-4">
                    <label for="address_line3">Address Line 3</label>
                    <input type="text" class="form-control" id="address_line3" name="address_line3" autocomplete="off">
                </div>
              
                
                <div class="form-group col-sm-4">
                    <label for="country">State/Province</label>
                    <div id="stateDiv">
                    <input type="text" class="form-control" id="state" name="state" autocomplete="off">
                    </div>	
                </div>
                <div class="form-group col-sm-4">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" autocomplete="off">
                </div>
                <div class="form-group col-sm-4">
                    <label for="land_line_no">Landline No</label>
                    <input type="number" class="form-control" id="land_line_no" name="land_line_no" autocomplete="off" onkeypress="if(this.value.length==14) return false;">
                </div>
             
                <div class="form-group col-sm-4">
                    <label for="mobile_no">Mobile No</label>
                    <input type="number" class="form-control" id="mobile_no" name="mobile_no" autocomplete="off" >
                </div>
                
                <div class="form-group col-md-8">
             
                    <label for="mobile_no">Buisness Nature</label>
                        <div class="mt-2">
                        <label for="Retailer" class="mr-3">
                        <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Retailer" class="mr-2"> Retailer</label>
                        <label for="Wholesaler" class="mr-3">
                        <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Wholesaler" class="mr-2"> Wholesaler Agent</label>
                        <label for="Importers" class="mr-3">
                        <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="IE" class="mr-2"> Importers / Exporters</label>
                        <label for="Manufacturer" class="mr-3">
                        <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Manufacturer" class="mr-2"> Manufacturer</label>
                        
                        <label for="Other"  class="mr-3">
                        <input type="checkbox" name="nature_of_buisness[]" id="other" value="other" class="mr-2">Other
                        </label> 
                        </div>
                	</div>
             
        
            <!--<div class="col-md-12 col-sm-12 col-xs-12 minibuffer">
                <div class="sub_head">Terms of Agreement</div>
                <div class="form-group col-md-12">
                    <div class="form-control terms">
                     <p>These are the general terms and conditions of&nbsp;Gems and Jewellery Export Promotion Council&nbsp;(GJEPC) for use of the GJEPC web site. Please read these terms and conditions carefully as your use of the Site is subject to them. GJEPC reserves the right at its sole discretion to change, modify or add to these terms and conditions without prior notice to you. By continuing to use the Site you agree to be bound by such amended terms.</p>
        
                    <ol>
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
                </div>
                <div class="form-group radio col-md-12">
                    <label for="terms_and_cond">
                    <input type="checkbox" name="terms_and_cond" id="terms_and_cond" value="1">I have read and agree to the 'Terms of Agreement' above.<label for="terms_and_cond" generated="true" style="display: none;" class="error"></label></label>
                </div>
            </div>-->
        
            	<div class="form-group col-12">		
               		<p>This question is for testing whether you are a human visitor and to prevent automated spam submissions.</p>
            	</div>
                
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" autocomplete="off" id="captcha_code" name="captcha_code" placeholder="Captch Code">
                </div>
                <div class="form-group col-sm-6">
                    <div class="sub_head">&nbsp;</div>
                    <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/>
                            Can't read the image? Click <a href='javascript: refreshCaptcha();'>Here</a> to Refresh
                </div>
        
            	<div class="form-group col-12">
                	<div class="d-flex">
                	<div><button type="submit" id="register" class="cta fade_anim">Submit</button></div>
                	<div><button type="reset" class="cta cta2 fade_anim">Reset</button></div>
                    </div>
            	</div>
                
                </div>
            </form>
            
            </div>
            
            </div>
        <?php } ?>
        </div>
    
    </div>

</section>

<?php include 'include/footer.php'; ?>

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
			country: {
				required: true,
			}, 
			taxation_code:{
				required: true,
			},
			taxaiton_number:{
				required: true,
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
			city: {
				required: true,
				specialChrs: true
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
				number:true
				},
			nature_of_buisness:{
				required:true
			},
			terms_and_cond:
			{
				required: true,
			},
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
			country:{
				required: "Please Select Country Id",
			},
			taxation_code:{
				required: "Please Select Taxation Detail",
			},
			taxaiton_number:{
				required: "Please Enter Taxation Number",
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
				number:"Please Enter Numbers only"
			},
			nature_of_buisness: {
				required: "Please selct bussiness nature",
			},  
		terms_and_cond: {
		required:"Required.",
		},
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
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getTaxation&country="+country,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
							     //alert(data);
								$('#preloader').hide();
								 $('#status').hide();
							     $("#taxationDiv").html(data);  
							}
		});
 });
 });
 </script>
 
<script>
$(document).ready(function(){
  $("#email_id").change(function(){
	email_id=$("#email_id").val();
	//alert(email_id);
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkregisuser&email_id="+email_id,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
								$('#preloader').hide();
								 $('#status').hide();
							     //alert(data);
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

<script type="text/javascript">
	jQuery("#country").change(function(event) {
		if (jQuery("#country").val()=="IND") {
			jQuery("#stateSel").show();
			jQuery("#stateTxt").hide();
		}
		else{
			jQuery("#stateSel").hide();
			jQuery("#stateTxt").show();
		}
	});
</script>