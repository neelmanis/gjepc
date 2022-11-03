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
	if($num>0)
	{
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
	} else {
	$_SESSION['succ_msg']="You have entered wrong username or password";
	}
	
	} else { $_SESSION['succ_msg']="Please select Member Type"; }
}
?>
<?php include('include-new/header.php');?>
<section class="py-5">
		
	<div class="inner_container">
		
		
	
		
		
		<div class="container">
        
        <div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div>Advalorem</div>
        
        <ul class="download_pdf row">
        
         <li class="col-lg-4 col-md-4 col-sm-6 mb-4"><a href="assets/pdf/advalorem/DPA-ppt-for-Members-2017-20-Report.pdf" target="_blank" class="pdf_wrp">DPA for Members 2017-20 Report</a> 
                        </li>
        
         <li class="col-lg-4 col-md-4 col-sm-6 mb-4"><a href="assets/pdf/advalorem/Payment-Gateway-for-payment-of-0.02-Advalorem-updated.html" target="_blank" class="pdf_wrp">Activation of Payment Gateway through KP Portal for payment of 0.02% Advalorem.</a> 
                        </li>
                        
                        
                         <li class="col-lg-4 col-md-4 col-sm-6 mb-4"><a href="assets/pdf/advalorem/Collection-of-0.02-AD-VALOREM-on-Import-of-Rough-Diamonds.html" target="_blank" class="pdf_wrp">Collection of 0.02% AD-VALOREM on Import of Rough Diamonds </a> 
                        </li>
        
                       <li class="col-lg-4 col-md-4 col-sm-6 mb-4"><a href="assets/pdf/advalorem/Generic-Diamond-Promotion.pdf" target="_blank" class="pdf_wrp">Generic Diamond	Promotion</a> 
                        </li>
                        </ul>
		</div>
		
		
	</div>
</section>

<?php include('include-new/footer.php');?>


<noscript>
<meta http-equiv="refresh" content="0.0;url=404.php">
<p>Are you using a browser that doesn't support JavaScript?</p><br><br>
<p>If your browser does not support JavaScript, you can upgrade to a newer browser</p><br><br>
<p>If you have disabled JavaScript, you must re-enable JavaScript to use this page. To enable JavaScript</p>
</noscript>
</body>
</html>