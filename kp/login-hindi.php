<?php 
$pageTitle = "Gems & Jewellery Industry | Log In - GJEPC India";
$pageDescription  = "India was one of the founder participants in the Kimberley Process Certification Scheme (KPCS) when it was formed with a mandate from the United Nations Organisation, to prevent the trade in conflict diamonds.";
?>

<?php include('header_include.php');?>
<?php
if(isset($_SESSION['MEMBER_ID']) && $_SESSION['MEMBER_ID'] !='' && !empty($_SESSION['MEMBER_ID']) ){
	header('location:kimberley_process_search_applications.php');
	
}
$action=$_REQUEST['action'];
if($action=="login")
{
	$membertype	=	filter($_REQUEST['membertype']);
	$username	=	filter($_REQUEST['username']);
	$password	=	filter($_REQUEST['password']);
	
	if(!empty($membertype)){
		
	if($membertype=="Agent"){
		$query=mysqli_query($conn,"select * from kp_agent_master where USER_NAME='$username' and PASSWORD='$password'");
	}else if($membertype=="Member"){
		$query=mysqli_query($conn,"select * from kp_member_user_details where LOGIN_NAME='$username' and LOGIN_PASSWORD='$password'");
	}
	else if($membertype=="NonMember"){
		$query=mysqli_query($conn,"select * from kp_non_member_master where EMAIL='$username' and PASSWORD='$password'");
	}
	
	$result=mysqli_fetch_assoc($query);
	$num=mysqli_num_rows($query);

	if($num>0){

			$_SESSION['MEMBERTYPE']=$membertype;
			if($membertype=="Agent"){
				$_SESSION['USERNAME']=$result['AGENT_NAME'];
				$_SESSION['AGENT_NO']=$result['AGENT_NO'];
				$_SESSION['AGENT_ID']=$result['AGENT_ID'];
				$_SESSION['AGENT_BP_NO'] = $result['AGENT_BP_NO'];
			}
			else if($membertype=="Member"){
				$_SESSION['USERNAME']=$result['COMPANY_NAME'];
				$_SESSION['LOGIN_NAME']=$result['LOGIN_NAME'];
				$_SESSION['MEMBER_ID']=$result['MEMBER_ID'];
				$_SESSION['GCODE']=$result['GCODE'];
				$_SESSION['BP_NUMBER'] = $result['BP_NUMBER'];
			}
			else if($membertype=="NonMember"){
				$_SESSION['USERNAME']=$result['NON_MEMBER_NAME'];
				$_SESSION['NON_MEMBER_NO']=$result['NON_MEMBER_NO'];
				$_SESSION['NON_MEMBER_ID']=$result['NON_MEMBER_ID'];
				$_SESSION['NON_MEMBER_BP_NO'] = $result['NON_MEMBER_BP_NO'];
			}
				header('location:kimberley_process_search_applications.php');
		}
	else {
			$_SESSION['succ_msg']="You have entered wrong username or password";
	}
	} else { $_SESSION['succ_msg']="Please select Member Type"; }
}
?>
<?php include('include-new/header.php');?>

<style>

.lang_switcher button.active {color:#a59459; font-weight:bold;}
.lang_switcher button {color:#c7c7c7;}
</style>

<section class="py-5">
		
	<div class="inner_container">
		
		
		<!--<div class="row justify-content-center grey_title_bg">      
        	
            	                <div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div>KIMBERLEY PROCESS LOGIN </div>
         
        </div>-->
		
		
		<div class="container">
        
        <div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div><strong>किम्बर्ले प्रक्रिया</strong> </div>
        
         <div class="langBtn">
            <div class="d-flex justify-content-center mb-3 lang_switcher">
                <div><button onclick="location.href = '../kp/login.php';" class="lang">English</button></div>
                <div><button onclick="location.href = '../kp/login-hindi.php';" class="lang active">Hindi</button></div>
            </div>
        </div>
        
        <div class="box-shadow">
        
			<div class="row justify-content-between ab_none">
            
            <div class="order-md-12 col-lg-5 ">
			
				<form  method="post" name="from1" id="form1"  autocomplete="off" class="mb-5">
                
                	<h2 class="title">लॉग इन करें</h2>
					
					<?php					
					if($_SESSION['succ_msg']!=""){
					echo "<div class='alert alert-danger' role='alert'>".$_SESSION['succ_msg']."</div>";
					$_SESSION['succ_msg']="";
					}
					?>
					<div class="row">										
						<div class="col-md-12  form-block  col-sm-12 col-xs-12 loginform">							
							<div class="form-group">								
								<select name="membertype" class="form-control" autocomplete="off" id="membertype" onchange="MM_jumpMenu('parent',this,0)">
									<option value="">--- Select ---</option>
									<option value="Agent">--- Agent ---</option>
									<option value="Member" selected>--- Member ---</option>
									<!--<option value="NonMember">--- NonMember ---</option>-->
								</select>
							</div>							
							
							<div class="form-group">
								<input type="text" class="form-control" autocomplete="off" name="username" id="username" placeholder="Username"/>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" autocomplete="off" name="password" id="password" placeholder="Password" />
							</div>
							
							<div class="row justify-content-between ab_none align-items-center form-group">
								<div class="col-auto">
									<input class="gold_btn fade_anim py-2" type="submit" value="Submit" />
								</div>
								<div class="col-auto">
									
										<a href="forgot_password.php" class="links">पासवर्ड भूल गए? </a>
										<input type="hidden" name="action" value="login" />
								
								</div>
							</div>
                            <div class="row justify-content-between ab_none form-group">
                          
								<div class="col-auto">
									<a href="agent_registration.php" class="links"> <strong> एजेंट पंजीकरण </strong> </a>
									
								</div>
								<div class="col-auto">
									<a href="non_member_registration.php" class="links"> <strong> गैर सदस्य पंजीकरण </strong></a>
								</div>
						
                            </div>
                            
							<div class="row justify-content-between ab_none">
                           
								
								<div class="col-12 mt-2">
               <ul class="inner_under_listing">
               	<li><p><span class="blue">Note:</span> GJEPC सदस्य किम्बरली प्रक्रिया में लॉग-इन करने के लिए अपने मौजूदा यूजरनेम नाम और पासवर्ड का उपयोग कर सकते हैं।</p></li>
               	<li><p><span class="blue">जीजेईपीसी सदस्य: </span>सदस्य अपने सदस्यता लॉगिन और पासवर्ड का उपयोग कर सकते हैं।</p></li>
               	<li><p><span class="blue">गैर-सदस्य: </span>ऑनलाइन किम्बर्ले प्रक्रिया का उपयोग करने के लिए कृपया गैर-सदस्य आवेदन भरें</p></li>
               </ul>
			   </div>
							</div>
						</div>
												
					</div>
				</form>
                
                </div>
                
                <div class="col-md-6">
					<p class="blue text-left">कोर के अनुरूप</p>
					<p class="text-left">भारत किम्बरली प्रोसेस सर्टिफिकेशन स्कीम (KPCS) में संस्थापक प्रतिभागियों में से एक था, जब इसे संयुक्त राष्ट्र संगठन के एक जनादेश के साथ, संघर्षरत हीरों के व्यापार को रोकने के लिए बनाया गया था। डायमंड पाइपलाइन में शामिल देशों की सरकारें इसके सदस्य हैं और आज केपी में ८१ देशों का प्रतिनिधित्व करने वाले 54 प्रतिभागी हैं (ईयू के सदस्य राज्यों में एक प्रतिनिधि है)। KPCS के सदस्य दुनिया भर में लगभग 99.8% रफ डायमंड का उत्पादन करते हैं।</p>
                    
					<p class="text-left">भारत 1 जनवरी, 2003 से इस नियम के तहत कार्यरत है और केपीसीएस में इसके साथियों द्वारा बाद की समीक्षाओं में उड़ते हुए रंगों के साथ पारित किया गया था।</p>
                    
					<p class="text-left">GJEPC को KPCS के लिए नोडल एजेंसी के रूप में नियुक्त किया गया था और यह देश के भीतर सभी KP प्रमाणन का कार्य करती है, साथ ही सभी संबंधित मामलों पर अंतर्राष्ट्रीय मंचों पर भारत सरकार के प्रतिनिधियों की सहायता करती है। भारत वर्ष 2019 के लिए किम्बर्ले प्रक्रिया का अध्यक्ष था।</p>
                    
					<p class="text-left">जीजेईपीसी ने यह सुनिश्चित करने के लिए लगातार काम किया है कि कोन्फ़्लीट डायमंड वाले देश और मुख्यधारा के उद्योग से बाहर रखा जाए और इस क्षेत्र की कंपनियों द्वारा अनुपालन का सख्ती से पालन किया जाए।</p>
                    
                    <div class="d-flex">
					<a href="../kimberley-info.php" class="cta mr-3">किम्बर्ली जानकारी</a>
                    <a href="advalorem.php" class="cta mr-3">अडवालोरेम </a>
					<a href="../images/pdf/OnlineKimberleyProcess_Manual.pdf" target="_blank" class="cta mr-3">ऑनलाइन मैनुअल</a>
				</div>

				</div>
                
			</div>
            
			</div>
		</div>
		
		
	</div>
</section>

<?php include('include-new/footer.php');?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
			//var member_id=$("#member_type_id").val();
		rules: {
		membertype: {
				required: true,
			},
			username: {
				required: true,
			},
			password:{
			required: true,
			}
		},
		messages: {
		membertype: {
				required: "Please select Member Type",
			},
			username: {
				required: "Please enter a valid username",
			},
			password: {
				required: "Please enter your password",
			},
		}
	});
});
</script>
<script type="text/ecmascript">
function validate() {
var membertype=document.getElementById('membertype').value;
if(document.getElementById('membertype').value==""){
	alert("Please select member type");
	return false;
} else {
window.location.href = 'forgot_password.php?membertype='+membertype;
}
}
</script>
<noscript>
<meta http-equiv="refresh" content="0.0;url=404.php">
<p>Are you using a browser that doesn't support JavaScript?</p><br><br>
<p>If your browser does not support JavaScript, you can upgrade to a newer browser</p><br><br>
<p>If you have disabled JavaScript, you must re-enable JavaScript to use this page. To enable JavaScript</p>
</noscript>
</body>
</html>