<?php
include 'include-new/header.php';
include 'db.inc.php';
include 'functions.php';
function getCompanyNameFormRegistrationMaster($registration_id,$conn)
{
	$query_sel = "SELECT company_name FROM  registration_master  where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['company_name'];
}
?>
<?php
$success = "";
$error_message = "";
if(!empty($_POST["submit_mobile"])) {
	$mobile_no = filter($_POST['mobile_no']);
//	$sqlx = "SELECT mobile1 FROM `parichay_person_details` WHERE `mobile1`='$mobile_no' AND parichay_status='Y' AND company_approval='Y' LIMIT 1";
/* Company Approval Meaning that Association or Member Company */
	$sqlx = "SELECT mobile1 FROM `parichay_person_details` WHERE `mobile1`='$mobile_no' AND company_approval='Y' LIMIT 1";
	$resultCheck = $conn ->query($sqlx);
    $count = $resultCheck->num_rows;
	if($count>0) {
		$otp = rand(100000,999999); // generate OTP	
		$message = "One Time Password for Parichay Card is.".$otp.", Regards GJEPC";
		$isSent  = get_data($message,$mobile_no); // Send OTP
		if($isSent){
		$getMobile = "SELECT mobile_no FROM parichay_person_otp_verification WHERE mobile_no='$mobile_no'";
		$getMobileResult = $conn->query($getMobile);
		$countMobile = $getMobileResult->num_rows;
		if($countMobile>0){
        $UpdateMobileOtp = "UPDATE parichay_person_otp_verification SET otp='$otp',verified ='0' WHERE mobile_no='$mobile_no'";
		$result = $conn ->query($UpdateMobileOtp);   
		} else {
		$ins = "INSERT INTO `parichay_person_otp_verification`(`post_date`,`mobile_no`, `otp`, `verified`) VALUES (NOW(),'$mobile_no','$otp','0')"; 
		$result = $conn ->query($ins);
		}
			
		$_SESSION['mobile_no']=$mobile_no;
		$_SESSION['secretotp'] = $otp; // save otp code in session	
		$_SESSION['end'] = time() + 2 * 60;	// set sesion time to 5 mins
			
		if(!empty($result)) {
				$success=1;
		}
		} else {
		$error_message = "OTP Not sent!";
		}
	} else {
		$error_message = "Karigar Information Approval is Pending / Mobile No does not exists!";
	}
}

if(!empty($_POST["submit_otp"])) {
	$mobile_no = filter($_POST["mobile_no"]);
	$otp = filter($_POST["otp"]);
	$otp=str_replace(" ","",$otp);
	$otp=str_replace(";","",$otp);
	$otp=str_replace("-","",$otp);
	$otp=str_replace("|","",$otp);
	$otp=str_replace("'","",$otp);
	$otp=str_replace("\"","",$otp);
	
	//$sqlx = "SELECT mobile_no FROM `parichay_person_otp_verification` WHERE mobile_no='$mobile_no' AND otp='$otp' AND verified='0' AND NOW() <= DATE_ADD(post_date, INTERVAL 24 HOUR)"; 
	$sqlx = "SELECT mobile_no FROM `parichay_person_otp_verification` WHERE mobile_no='$mobile_no' AND otp='$otp' AND verified='0'"; 
	$result = $conn ->query($sqlx);
	$num = $result->num_rows;
	$rowsData = $result->fetch_assoc();	
	$getMobile_no = $rowsData['mobile_no'];
		
	if($num>0) {
		$updatex = "UPDATE `parichay_person_otp_verification` SET `verified`='1' WHERE otp='$otp'";
		$resultx = $conn ->query($updatex);
		$_SESSION['mobile_no'] = $getMobile_no;
		$success = 2; 
	} else { 
		$success = 1;
		$error_message = "Invalid OTP!. Please Enter the Proper Code";
		
	}
}
?>
<?php
if($_SESSION['err_msg']!=""){
echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
$_SESSION['err_msg']="";
}
?>
<section>	
    <div class="container-fluid inner_container">
    	 <div class="row justify-content-center grey_title_bg">              
            <div class="bold_font text-center"> 
            <div class="d-block"><img src="assets/images/gold_star.png"></div>Download Parichay Card</div>                    
        </div> 		
                  
            <div class="container">				
                <div class="row">				
                    <form class="cmxform col-12 box-shadow mb-5" method="post" name="mobileForm" id="mobileForm" autocomplete="off">
					
					<?php if(!empty($error_message)) { echo '<div class="alert alert-danger" role="alert">'.$error_message.'</div>';} ?>
					<?php if(!empty($success == 1)) { ?>
					
					
					<div class="row">   
					 <div class="form-group col-12 mb-4">
                        <p class="blue">Check Mobile for the OTP</p>
                     </div>                        
                    <div class="form-group col-sm-6">
                    <label for="otp">Enter OTP</label>
                    <input type="text" class="form-control numeric" placeholder="One Time Password" id="otp" name="otp" maxlength="6" autocomplete="off">
					<input type="hidden" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no;?>">
                    </div>
					</div>		
					
					<div class="form-group">
					<input type="submit" class="cta fade_anim" name="submit_otp" value="Submit" class="btnSubmit">
                    </div>	
						
					<?php } else if ($success == 2) {

					$mobile = $_SESSION['mobile_no']; 
					$sqlx = "SELECT * FROM `parichay_person_details` WHERE `mobile1`='$mobile' LIMIT 1";
					$resultx = $conn ->query($sqlx);
					$rowsX = $resultx->fetch_assoc();
					$registration_id = $rowsX['registration_id'];
					$sqly = "SELECT * FROM `parichay_card` WHERE `registration_id`='$registration_id' LIMIT 1";
					$resulty = $conn ->query($sqly);
					$rowsy = $resulty->fetch_assoc();
					$date = date("jS M y", strtotime($rowsX['post_date']));
                    $created_date = $rowsX['post_date'];
                    $parichay_type = $rowsy['parichay_type'];
					if($parichay_type=="association"){ $class= "parichayCard_White"; } else { $class= "parichayCard"; }
					
					$EndDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $created_date);
					$EndDateTime->modify('+10 years');
					$expiry =  date("jS M y", strtotime($EndDateTime->format('Y-m-d H:i:s')));

					/*Generate Parichay Card Number*/
					$sql_reg="SELECT * FROM registration_master WHERE id='$registration_id'";
					$result_reg =$conn->query($sql_reg);
					$row_reg = $result_reg->fetch_assoc();
					$state = $row_reg['state'];
					$company_association_digits = $row_reg['parichay_series'];
					$region = trim(getRegionNameFromState($state,$conn));
					$sql_region_master = "SELECT parichay_series FROM region_master WHERE region_name='$region'";
					$result_region_master = $conn->query($sql_region_master);
					$row_region_master=$result_region_master->fetch_assoc();
					$region_digit =$row_region_master['parichay_series'];
					if($company_association_digits < 10){
						$company_association_digits = "00".$company_association_digits;
					}elseif($company_association_digits >=10 || $company_association_digits < 100){
						$company_association_digits = "0".$company_association_digits;
					}elseif( $company_association_digits >= 100){
						$company_association_digits = $company_association_digits;
					}
					$person_digits = $rowsX['person_series'];

					$card_no = $region_digit."-".$company_association_digits."-".$person_digits;
					?>
					<!-- <span style="background:#f5f1ff;">Welcome! <strong><?php echo $rowsX['fname'].' '.$rowsX['mname'].' '.$rowsX['surname']?> </strong></span> -->
					<div class="row">
					<div class="form-group col-12 mb-4">
                    <p class="blue">Welcome! <strong><?php echo $rowsX['fname'].' '.$rowsX['mname'].' '.$rowsX['surname']?> </strong></p>
                    </div>      
					</div>
					
	<div class="row mb-5 mt-5 vm_wrp justify-content-center" id="print">
            <div class="col-lg-6 mb-4 mb-lg-0">
            	<div class="mb-5">
                	<h2 class="title">Front</h2>
                
                    <div class="<?php echo $class;?> mb-5">
                    	<div class="cardHead cardPatern mb-4">gem & jewellery <span>parichay card</span></div>
                        
                        <div class="row cardDetails mb-5">
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-4">Name</div>
                                    <div class="col-8"><span><?php echo $rowsX['fname'].' '.$rowsX['mname'].' '.$rowsX['surname'];?></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">id</div>
                                    <div class="col-8"><span><?php echo $card_no;?></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">d.o.b</div>
                                    <div class="col-8"><span><?php echo date("d-m-Y",strtotime($rowsX['date_of_birth']));?></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">blood g</div>
                                    <div class="col-8"><span> <?php echo $rowsX['blood_group'];?></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">valid from</div>
                                    <div class="col-8"><span><?php echo $date; ?> TO <?php echo $expiry; ?></span></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-3">
                            	<div class="cardHolder"><img src="images/parichay_card/person/photo/<?php echo $rowsX['photo'];?>" class="img-fluid d-block"></div>
                            </div>
                    	</div>
                        
                        <div class="row cardSigned">
                        	<div class="col-3">
                                <span class="d-block">VIPUL SHAH</span>
                                GJEPC CHAIRMAN
                            </div>
                            <div class="col-9 text-right">
                            	<span class="d-block"> <?php echo strtoupper($rowsy['association_head_name']);?></span><span class="d-block"><?php echo getCompanyNameFormRegistrationMaster($rowsX['registration_id'],$conn) ;?></span>
                                <?php echo strtoupper($rowsy['association_head_designation']);?>
                            </div>
                        </div>
                    </div>              
                    
                    <h2 class="title">back</h2>
                
                    <div class="<?php echo $class;?>">
                    	<div class="cardHead_2 mb-2">gem & jewellery <span>parichay card</span>
                        	<div class="gjepcLogo"><img src="assets/images/gjepcLogo_black.png"></div>
                        </div>
                        
                        <div class="compName"><?php echo getCompanyNameFormRegistrationMaster($rowsX['registration_id'],$conn) ;?> </div>
                        
                        <p>This card is the property of The Gem & Jewellery Export Promotion Council (GJEPC) & the Local Association / Company / Individual. This is an identity card issued by GJEPC on the basis of documents information given by the card holder. </p>
                        
                        <p>GJEPC takes no responsibility for any inaccuracy of the information details of the card holder printed on this card. The holder of this card is not an employee or agent or servant of GJEPC and GJEPC takes no responsibility for any acts or omissions of this card.</p>
                        
                        <p><strong>If found, please return the card to the Association / Company office.</strong><br>
Or call GJEPC Call Center: Toll Free Number: 1800-103-4353 | Missed Call Number: +91-7208048100<br>
You can also log on to GJEPC website for more details: https://www.gjepc.org/parichay-card.php<br>
TO VERIFY THE CARD, SMS PAR(LAST 7 DIGITS OF PARICHAY CARD NUMBER) TO +91 9223599301</p>   
                    </div>
                </div>
            </div>
        </div>  
		<a href="javascript:void(0)"  class="d-inline-block mt-5 print_btn"><i class="fa fa-download"></i>&nbsp; Download Parichay Card</a>
					<?php } else { ?>	
                        <div class="row">       
                        <div class="form-group col-12 mb-4">
                        <p class="blue">Download Parichay Card</p> </div>                     
                            <div class="form-group col-sm-6">
                            <label for="otp"></label>
                            <label>Enter Mobile No</label>
                            <input type="text" class="form-control numeric" placeholder="Enter Mobile No" name="mobile_no" id="mobile_no" autocomplete="off" maxlength="10"/>
                            </div>
						</div>		
                                                			
              			<div class="form-group">
							<input type="submit" class="cta fade_anim" name="submit_mobile" value="Submit" class="btnSubmit">
                        </div>
						<?php  }	?>
                    </form>  
					
                </div>                           
            </div>    
	</div>    
    </div>
</section> 
</div>
<?php include 'include-new/footer.php'; ?>
<style>

.card {
        box-shadow: 0 8px 8px 10px rgba(87, 84, 84, 0.4);
        max-width: 250px;
        padding: 10px;
        margin: auto;
        text-align: center;
      }
@media (max-width:600px) {
header, footer {display:none;}
}
.custom-file-label::after {height:38px; padding:0; line-height:38px; width:60px; text-align:center;}
.parichay-card{
 background: #aca161;
 padding: 30px;
 border-radius:15px;
}
.parichay-card-title{
 color: #fff;
 font-size: 21px
}
.parichay-card-title span{
	
	font-family: "eloquent-jf-pro";
    letter-spacing: 1px;

}
.parichay-card-footer p{
 color:#000;
 font-weight: 500;
 font-size: 14px;
 text-align: left;
}
.parichay-card-footer span{
	border-top: 1px solid#bbb1b1;
	display: block;
	margin-bottom: 3px;
}
.parichay-card-details p{
	font-weight: bold;
}
.parichay-card-right{
	position: relative;
}
.parichay-card-img img{
	border-radius: 5px
}
.parichay-card-details-backside p{
	font-size: 11px;
	line-height: 15px;
	margin-bottom: 7px;
}
/*.parichay-card-right:after {
	content: "";
    position: absolute;
    left: 0px;
    top: 0;
    width: 18%;
    height: 150px;
    background: url(https://gjepc.org/assets/images/star_pattern.png) no-repeat;
    background-size: cover;
}*/
</style>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	// validate signup form on keyup and submit
	$("#mobileForm").validate({
		rules: {  
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			}
		},
		messages: {
			mobile_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
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


(function($){
	'use strict'

	$.fn.printElement = function(options){
		let settings = $.extend({
			title	: jQuery('title').text("Parichay Card"),
			css		: 'extend',
			ecss	: null,
			lcss	: [],
			keepHide: [],
			wrapper : {
						wrapper: null,
						selector: null,
					}
		}, options);

		const element = $(this).clone();
		let html = document.createElement('html');

		let head = '<head><meta property="og:image" content="https://gjepc.org/assets/images/sharelogo.png"/><meta property="og:title" content="Gem & Jewellery Export Promotion Council - GJEPC India"/><meta property="og:description" content="Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body of Gems & Jewellery supported by the Ministry of Commerce and Industry, Govt. Of India."/><link rel="canonical" href="https://gjepc.org/"><link rel="stylesheet" href="assets-new/css/fonts.css"><link rel="stylesheet" href="assets-new/css/bootstrap.min.css"><link rel="stylesheet" href="assets-new/css/aos.css"><link rel="stylesheet" href="assets-new/css/sina-nav.css"><link rel="stylesheet" href="assets-new/css/jquery.fancybox.min.css"><link rel="stylesheet" type="text/css" href="assets-new/css/fastselect.min.css"><link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/><link rel="stylesheet" href="assets-new/css/general.css"><link rel="stylesheet" href="assets-new/css/inner_page.css"><link rel="stylesheet" href="assets-new/css/rohan.css"><link rel="stylesheet" href="assets-new/css/mangesh.css"><style> #print{width:60%;margin-left:50%; transform:translate(-50%)}</style></head>';
		if(settings.title != null && settings.title != ''){
			head = $(head).append($(document.createElement('title')).text(settings.title));
		}
		else{
			head = $(head);
		}

		if(settings.css == 'extend' || settings.css == 'link'){
			$('link[rel=stylesheet]').each(function(index, linkcss){
				head = head.append($(document.createElement('link')).attr('href', $(linkcss).attr('href')).attr('rel', 'stylesheet').attr('media', 'print'));
			})
		}

		for(var i = 0; i < settings.lcss.length; i++){
			head = head.append($(document.createElement('link')).attr('href', settings.lcss[i]).attr('rel', 'stylesheet').attr('media', 'print'));
		}

		if(settings.css == 'extend' || settings.css == 'style'){
			head.append($(document.createElement('style')).append($('style').clone().html()));
		}

		if(settings.ecss != null){
			head.append($(document.createElement('style')).html(settings.ecss));
		}

		if (settings.wrapper.wrapper === null){
			var body = document.createElement('body');
			body = $(body).append(element);
		}
		else{
			var body = $(settings.wrapper.wrapper).clone();
			body.find(settings.wrapper.selector).append(element);
		}

		for(let i = 0; i < settings.keepHide.length; i++){
			$(body).find(settings.keepHide[i]).each(function(index, data){
				$(this).css('display', 'none');
			})
		}

		html = $(html).append(head).append(body);

		const fn_window = document.open('', settings.title, 'width='+$(document).width()+',height=' + $(document).width() + '');
		fn_window.document.write(html.clone().html());
		setTimeout(function(){fn_window.print();fn_window.close()}, 10000);

		return $(this);
	}
}(jQuery));

</script>
<script>
  $('.print_btn').click(function(){
    $('#print').printElement({
    });
  })
</script>