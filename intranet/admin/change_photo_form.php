<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){
	header("location:login.php");
	exit;
}
?>
<?php
$uid = $_SESSION['USERID'];
if(isset($_POST['payment_made_for']))
{
	$participate_for_show="Signature";
	$participation_year="2015";
	$payment_made_for="Signature 2015";
	$payment_mode=$_POST['payment_mode'];
	
	
	
	if($payment_mode=="DD" || $payment_mode=="Cheque")
	{
		$drawn_on_bank=$_POST['drawn_on_bank'];
		$branch_of_bank=$_POST['branch_of_bank'];
		$branch_city=$_POST['branch_city'];
		$branch_postal=$_POST['branch_postal'];
		$cheque_dd_no=$_POST['cheque_dd_no'];
		echo $cheque_dd_dt=date("Y-m-d",strtotime(str_replace('/','-',$_POST['cheque_dd_dt'])));
		
	}
	else
	{
		$drawn_on_bank="";
		$branch_of_bank="";
		$branch_city="";
		$branch_postal="";
		$cheque_dd_no="";
		$cheque_dd_dt="";
	}
		
	$participation_fee=$_POST['participation_fee'];
		
	$updatequery="update pvr_registration_details set participate_for_show='".$participate_for_show."',participation_year='".$participation_year."',payment_made_for='".$payment_made_for."',payment_mode='".$payment_mode."',drawn_on_bank='".$drawn_on_bank."',branch_of_bank='".$branch_of_bank."',branch_city='".$branch_city."',branch_postal='".$branch_postal."',cheque_dd_no='".$cheque_dd_no."',cheque_dd_dt='".$cheque_dd_dt."',participation_fee='".$participation_fee."',payment_approve='P',payment_reason='',modified_dt=NOW() where uid='$uid'"; 

	$update_result = mysql_query($updatequery);

	if(!$update_result){
		echo "Error: ".mysql_error();	
	}
	else{
		header("location:Test/TestSsl.php");
		exit;
	}
}
?>

<?php
	$uid=$_SESSION['USERID'];
	$sql="SELECT * FROM `pvr_registration_details` WHERE uid=$uid";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	
	$photograph_fid=$rows['photo_image'];
	$passport_fid=$rows['id_proof'];
	/*if($photograph_fid=="")
	{
	 	$photosql="SELECT photo_image FROM `temp_privilege_visitor_reg` WHERE `privilege_code`='".$_SESSION['PVRCODE']."'";	
		$photoresult=mysql_query($photosql);
		$photorows=mysql_fetch_array($photoresult);
		$photograph_fid=$photorows['photo_image'];
		if($photograph_fid != "")
		{
				copy("images/pvr_image/temp_pvr_image/$photograph_fid", "images/pvr_image/$photograph_fid");
				
				if(isset($_REQUEST['action']) && $_REQUEST['action']=='check')
				{
					$query1 ="update pvr_registration_details set photo_image='$photograph_fid' where uid='$uid' and participate_for_show='SIGNATURE' and participation_year='2015' ";
					$ans =mysql_query($query1);
				}
		}
		
	}*/
	
	
	
?>

<!-- fetching data -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  

<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

<script type="text/javascript" src="js/ddsmoothmenu.js">
</script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<!--navigation script end-->


<!-- small slider -->
	<script type="text/javascript" src="js/jquery.cycle.all.js"></script>

<!-- SLIDER -->
	<script type="text/javascript">
	$(document).ready(function(){ 
	
	$('#imgSlider').cycle({ 
			fx:    'scrollHorz', 
			timeout: 6000, 
			delay: -1000,
			prev:'.prev1',
			next:'.next1', 
		});
	});
	
		


	</script>


<!--  SLIDER Starts  -->



<link href="css/slider.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
$(function() {
	$("#scroller .item").css("width", 986);
	$("#scroller").scrollable({
			circular: true,
			speed: 1500
	}).autoscroll({ interval: 9000 }).navigator();
	api = $('#scroller').data("scrollable");
	$(window).resize(function() {
		if($('#scroller .items:animated').length == 0) {
			$("#scroller .item").css("width", $(document).width());
			nleft = $(document).width() * (api.getIndex() + 1);
			$("#scroller .items").css("left", "-"+nleft+"px");
		}
	});
});
</script>

<!--  SLIDER Ends  -->



<!-- place holder script for ie -->

<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();
         
            $(active).focus();
           
           
            
        }
    });
</script>    

<script>
function check_extension(file_name)
{
	var result=file_name.split('.').pop();
	if(result=="gif" || result=="jpeg" || result=="jpg" || result=="png" || result=="GIF" || result=="JPEG" || result=="JPG" || result=="PNG" )
		return true;
	else
		return false;
}

function validation(){
	
	/* photograph validation */
	var photo_img=document.getElementById("photo_image").value;
	var photo_ext=check_extension(photo_img);
	
	<?php if($photograph_fid==""){?>	
	if(photo_img==""){
		document.getElementById("photograph_error").innerHTML="Please Select file";
		/*flag_photo=1;*/
		return false;
	}
	else if(!photo_ext){
		document.getElementById("photograph_error").innerHTML="Invalid File";
		/*flag_photo=1;*/
		return false;
	}
	else{
		document.getElementById("photograph_error").innerHTML="";
		/*flag_photo=0;*/
	}
	<?php } ?>
	/* passport validation */
	
	var id_proof=document.getElementById("id_proof").value;
	var passport_ext=check_extension(id_proof);
	
	<?php if($passport_fid==""){?>
	if(id_proof==""){
		document.getElementById("passport_error").innerHTML="Please Select file";
		/*flag_pass=1;*/
		return false;
	}
	else if(!passport_ext){
		document.getElementById("passport_error").innerHTML="Invalid File";
		/*flag_pass=1;*/
		return false;
	}
	else{
		document.getElementById("passport_error").innerHTML="";
		/*flag_pass=0;*/
	}
	<?php } ?>
	/*if(flag_photo==1 || flag_pass==1 )
		return false;
	else
		return true;*/
}

</script>
  
</head>

<body>
<!-- header starts -->

<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<!-- header ends -->


<div class="clear"></div>

<!--banner starts-->
<div class="banner_inner_wrap">
	<div class="banner_inner">
    	<img src="images/highlight_banner.jpg" />
    </div>
</div>
<!--banner ends-->

<div class="clear"></div>


<!--container starts-->
<div class="container_wrap">
	<div class="container">
    	<div class="container_left">
        	<span class="headtxt">My Signature - Photo</span>
			<div id="loginForm">
            <div id="formContainer">
<form id="form1" enctype="multipart/form-data" method="post" action="national_visitor_registration.php" onsubmit="return validation()">
            <div id="form">
			
    <ul id="tabs" class="tab_1">
    <li id=""><a href="n_p_v_r.php"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="obmp_profile_pvr.php"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="participation_&_payment_details.php"  ><strong>Step 3 Payment</strong></a></li>
    <li id=""><a href="change_photo_form.php"  class="lastBg active" ><strong>Step 4 Photo</strong></a></li>  
    
    <div class="clear"></div> 
    
</ul>

<div class="clear bottomSpace"></div>
    <div class="title">
    <h4>Photograph</h4>
    </div>
    
    <div class="clear"></div>
    
    <div class="borderBottom"></div>
      
         
         <div class="field bottomSpace">
         
         <div class="userPic">
			 <?php if($photograph_fid==""){?>
                <img src="images/user_pic.jpg" width="100" height="100" alt="" />
             <?php }
             else{ 
                  echo  "<img src='images/pvr_image/$photograph_fid' width='100' height='100' alt='' />";
             } ?>
         </div>
         
         <div class="leftFile">
             <div class="midTitle">Please browse to attach your photograph : <sup>*</sup> </div>
             <p><strong>Filename</strong></p>
             <input name="photo_image" id="photo_image" type="file" class="textField" style="margin-bottom:10px; background:#fff;" <?php if($rows['photo_approval']=='Y'){?> disabled="disabled" <?php } ?> />
			<br>
            <span>Upload <strong>jpg, gif, png, bmp</strong> files only </span><br />

            
             <span id="photograph_error" class="error_msg"></span>
		</div>
        
        
        <div class="approval">
            	<div class="status">Approval Status :</div>
                <div class="appr">
				<?php if($rows['photo_approval']=='P')
							 echo "Pending";
						  else if($rows['photo_approval']=='Y')
						  	 echo "Approved";
						  else
						  	 echo "Disapproved  <span style='margin-left:50px;font-style:italic;'>".$rows['photo_reson']."</span>";	
				?>
                </div>
            </div>
     		
            <div class="clear"></div>
	        <div class="note">Note: Kindly upload passport size colour photograph. (Maximum upload file size is 2 MB)</div>
         	
            </div>
            
         
         	<div class="title">
            <h4>Identy Proof</h4>
            </div>
            
            <div class="clear"></div>
            
            <div class="borderBottom"></div>
         
              <div class="clear bottomSpace"></div>
              
              
              
              <div class="field bottomSpace">
          <div class="userPic">
		  <?php if($passport_fid==""){?>
                <img src="images/user_pic.jpg" width="100" height="100" alt="" />
             <?php }
             else{ 
                  echo  "<img src='images/pvr_image/$passport_fid' width='100' height='100' alt='' />";
             } ?>
          </div>
         
         <div class="leftFile">
             <div class="midTitle">Please browse to attach your identity proof : <sup>*</sup> </div>
             <p><strong>Filename</strong></p>
             <input name="id_proof" id="id_proof" type="file" class="textField" style="margin-bottom:10px; background:#fff;" <?php if($rows['identy_proof_approval']=='Y'){?> disabled="disabled" <?php } ?> />
 			 <br>
             <span>Upload <strong>jpg, gif, png, bmp</strong> files only </span><br />

             
             <span id="passport_error" class="error_msg"></span>
		</div>
        
        
        <div class="approval">
            	<div class="status">Approval Status :</div>
                <div class="appr">
                <?php if($rows['identy_proof_approval']=='P')
							 echo "Pending";
						  else if($rows['identy_proof_approval']=='Y')
						  	 echo "Approved";
						  else
						  	 echo "Disapproved  <span style='margin-left:50px;font-style:italic;'>".$rows['identy_proof_reson']."</span>";	
				?>
                </div>
            </div>
            	
        	<div class="clear"></div>
	        <div class="note">Note: You can upload pan card,passport,driving license etc. For any queries contact pvr@gjepcindia.com (Maximum upload file size is 2 MB)</div>
            
            </div>
         

         
        
         
         
         	 <div class="borderBottom"></div>
            
             <?php if($rows['photo_approval']!='Y' || $rows['identy_proof_approval']!='Y'){ ?>
             <div class="button"><input type="submit" value="Submit" class="newMaroonBtn"></div>
              <?php }?>
             <?php if($rows['photo_approval']=='Y' && $rows['identy_proof_approval']=='Y'){ ?>
             <div class="maroonBtn" style="margin-right:10px;"><a href="national_visitor_registration.php">Next</a></div> <div class="maroonBtn"><a href="participation_&_payment_details.php">Previous</a></div>
            <?php } ?>
            <div class="clear"></div>
             
             
             
            
            
            
            </div>
 </form>            
            
            
            </div>
            
            
            </div>
          
          
          
           
            
        
        </div>
        
        
        <?php include ('rightContent.php'); ?>
       
      
        <div class="clear"></div>
        
    </div>
    
    
    
</div>
<!--container ends-->

<!--footer starts-->

<div class="footer_wrap">


<?php include ('footer.php'); ?>



</div>

<!--footer ends-->

</body>
</html>
