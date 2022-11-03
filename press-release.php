<?php 
$pageTitle = "Gem & Jewellery | Press Release - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
?>
<?php
$pressaction=$_REQUEST['pressaction'];
if($pressaction=="save")
{	
		$fname	= strtoupper(filter($_REQUEST['fname']));
		$mobile = filter($_REQUEST['mobile_no']);
		$email  = filter($_REQUEST['email']);
		$subject = filter($_REQUEST['subject']);
		$kit_type = $_REQUEST['kit_type'];
		foreach($kit_type as $val)
		{
			$kit_type_new.=$val.",";	
		}
		$msg = filter($_REQUEST['message']);

		if(empty($fname))
		{ $signup_error1 = "Please Enter Name"; }
		else if(empty($email))
		{ $signup_error1 = "Please Enter a valid Email id"; }
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{ $signup_error1 = "Please Enter Valid Email"; }
		else {		
		$result = $conn ->query("select * from press_enquiry where email='$email'");
		$num   = $result->num_rows;
		if($num>0)
		{	
			$signup_error1 = "Already registered with this Email id";
		} else {
		    $query = "insert into press_enquiry (fname,mobile,email,kit_type,subject,message,post_date) values('$fname','$mobile','$email','$kit_type_new','$subject','$msg',now())";
			$result = $conn ->query($query);
			if($result){
				$signup_success1 = "Thanks for Enquiry";
				
				/*.......................................Send mail to Admin mail id...............................................*/
	$message ='<table border="1" bordercolor="#ddd"  style="font-family:Arial, sans-serif; color:#333333; font-size:13px; border-collapse:collapse;" cellpadding="10" cellspacing="0">
	
    <tr>
        <td colspan="2" align="center"> <img src="https://gjepc.org/assets/images/logo.png"> </td>
	</tr>    
    <tr>
        <td> <strong>Name</strong>  </td>
        <td> '.$fname.' </td>
    </tr>    
    <tr bgcolor="#f2f2f2">
        <td> <strong>Email Id</strong>  </td>
        <td>'.$email.' </td>
    </tr>     
    <tr>
        <td> <strong>Mobile No.</strong>  </td>
        <td>'.$mobile.'</td>
    </tr>     
    <tr bgcolor="#f2f2f2">
        <td> <strong>Subject.</strong>  </td>
        <td>'.$subject.'</td>
    </tr>    
    <tr>
        <td> <strong>Media Kit</strong>  </td>
        <td>'.strtoupper($kit_type_new).'</td>
    </tr> 
	<tr>
        <td> <strong>Message</strong>  </td>
        <td>'.$msg.'</td>
    </tr> 
</table>';

	 $to = "pmbd@gjepcindia.com";
	 $subject = "Press Enquiry"; 
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'. "\r\n"; 
	 $headers .='From: Press Enquiry <admin@gjepc.org>';				
	 mail($to, $subject, $message, $headers);

	/*.......................................Send mail to users mail id...............................................*/
	if(in_array("chairman",$kit_type)) 
	{	$links.="Chairman(Photo & Profile) link : https://gjepc.org/assets/images/media/Profile-Colin-Shah-Chairman-GJEPC.pdf<br/>"; }
	 if(in_array("vice_chairman",$kit_type))
	{   $links.="Vice Chairman(Photo & Profile) link : https://gjepc.org/assets/images/media/Profile-Vipul-Shah-Vice-Chairman-GJEPC.pdf<br/>"; }
	 if(in_array("brochure",$kit_type))
	{   $links.="Corporate Brochure link : https://gjepc.org/assets/images/media/GJEPC-brochure.pdf"; }

	$messageu ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://gjepc.org/images/gjepc_logon.png"> </td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Thank you for Press Enquiry Media Kit at Gems and Jewellery Export Promotion Council (GJEPC).</h4></td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td>Please click or copy the below link For download Media Kit.</td></tr>';
  
  $messageu .='<tr>
    <td align="left"  style="text-align:justify;">Media Kit :<br/>'.$links.'</td>
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

	$tou = $email;
	// $to = "neelmani@kwebmaker.com";
	 $subjectu = "Press Enquiry"; 
	 $headersu  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headersu .= 'Content-type: text/html; charset=iso-8859-1'. "\r\n"; 
	 $headersu .='From: Press Enquiry <admin@gjepc.org>';				
	 mail($tou, $subjectu, $messageu, $headersu);
	 
		}
		}
		}
}
?>	

<?php
$newsletteraction=$_REQUEST['newsletteraction'];
if($newsletteraction=="save")
{
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		$email = filter($_REQUEST['email']);
		if(empty($email))
		{
				$signup_error = "Please Enter a valid Email id";			
		} else {
			$result = $conn ->query("select * from newsletter where email_id='$email'");
			$num   = $result->num_rows;
			if($num>0)
			{	
				$signup_error = "Already Subscribe with this Email id";
			} else {
			$query = "insert into newsletter (email_id,post_date) values('$email',now())";
			$result = $conn ->query($query);
			if($result){
				$signup_success = "You have successfully subscribed to the newsletter";
				$success = 1;
			}
			}
		}
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>

<section>

<div class="container position-relative">
    <img src="assets/images/inner_banner/media.jpg" class="img-fluid d-block" /> 
    <div class="innerpg_title">
        <div class="d-flex h-100">
            <div class="my-auto"><h1 style="color:#000;">Media</h1></div>
        </div>
    </div>
</div>           

<div class="container">
    <ul class="row no-gutters justify-content-center mb-5 page_subtabs">
        <li class="col-auto"><a href="press-relaese.php" class="d-block active"> Press Releases </a></li>
        <li class="col-auto"><a href="gjepc-in-news.php" class="d-block"> GJEPC in News </a></li>
    </ul>
</div>

<div class="container">	
	<div class="row mb-5">

        <div class="col-12 text-center mb-5">
           <div class="form-group border-dark border d-flex my-0 mx-auto" style="line-height:40px;width:200px">
            <label class="d-inline-block mb-0 col-auto pr-0" for="selectyear">YEAR</label>
            <select class="form-control d-inline-block border-0 col" id="select_box"  style="font-size:16px;color:#333">
				<?php 
        		$sql="SELECT distinct(year) FROM `press_release_master` WHERE status='1' order by year desc";
        		$result=$conn ->query($sql);
        		while($rows=$result->fetch_assoc()){ ?>
				<option value="<?php echo filter($rows['year']);?>"><?php echo filter($rows['year']);?></option>
				<?php }	?>
            </select>            
            </div>
        </div>
        		
        <div class="col-lg-6">
			<?php 
			$sqlm="SELECT distinct(year) FROM `press_release_master` WHERE status='1' order by year desc";
			$resultm=$conn ->query($sqlm);
			while($rowsm=$resultm->fetch_assoc()){ ?>
        	<ul class="circular hide" id="<?php echo filter($rowsm['year']);?>">
            	<?php 
        		$sql2="SELECT * FROM `press_release_master` WHERE year=".$rowsm['year']." and status='1' order by post_date desc";
        		$result2=$conn ->query($sql2);
        		while($rows2=$result2->fetch_assoc())
        		{
        		?>
                <li class="col-12 item year-<?php echo $rows2['post_date'];?>">
                	   	<a href="admin/PressRelease/<?php echo $rows2['upload_press_release'];?>" target="_blank" class="new_pdf_wrp">
                        	<p class="blue"><?php echo $rows2['post_date'];?></p> 
                            <div class="circular_text"><?php echo filter($rows2['name']);?></div>
                            <div class="clearfix"></div> 
                        </a>        		
        		</li>
				<?php } ?>
            </ul>
            <?php } ?>
        
        </div>

        <div class="col-lg-6" data-sticky_parent>
            <div class="clearfix pb-0 pb-lg-5" data-sticky_column>          
                <div class="pressenquiryBox mb-4">                            
                    <div class="ctaContentBox px-0">                        
                        <h2 class="text-uppercase title mb-3">Press Enquiry</h2>
						<?php
						if($_SESSION['err_msg']!=""){
						echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
						$_SESSION['err_msg']="";
						}
						?>
						<?php if(isset($signup_error1)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error1.'</div>';} ?>
						<?php if(isset($signup_success1)){ echo '<div class="alert alert-success" role="alert">'.$signup_success1.'</div>';} ?>
                        
						<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="pressForm" id="pressForm" autocomplete="off">
							<?php token(); ?>
							<input type="hidden" name="pressaction" value="save"/> 
                            <div class="form-group mb-3">
                              <input type="text" name="fname" id="fname" value="" class="form-control" placeholder="Name" maxlength="50" autocomplete="off" >
                            </div>                            
                            <div class="form-group mb-3">
                              <input type="text" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off">
                            </div>                            
                            <div class="form-group mb-3">
                              <input type="text" name="mobile_no" id="mobile_no" class="form-control numeric" placeholder="Mobile No" maxlength="10" minlength="10" autocomplete="off" onkeypress="if(this.value.length==10) return false;">
                            </div>                            
                            <div class="form-group mb-3">
                              <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" autocomplete="off">
                            </div> 
							
                            <p><strong>Download Media Kit</strong></p>                            
                            <div class="form-group mb-3">
                            	<div class="row">
                            		<div class="col-sm-4 mb-2 mb-sm-0">
                                    	<div class="d-flex">
                                        	<div class="mr-2"><input type="checkbox" name="kit_type[]" value="chairman"></div>
                                        	<div><label class="m-0">Chairman <br class="d-none d-sm-block"> (Photo & Profile)</label></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-2 mb-sm-0">
                                    	<div class="d-flex align-items-top">
                                        	<div class="mr-2"><input type="checkbox" name="kit_type[]" value="vice_chairman"></div>
                                        	<div><label class="m-0">Vice Chairman <br class="d-none d-sm-block"> (Photo & Profile)</label></div>
                                        </div>
                                    </div>
                                	<div class="col-sm-4 mb-2 mb-sm-0">
                                    	<div class="d-flex">
                                        	<div class="mr-2"><input type="checkbox" name="kit_type[]" value="brochure"></div>
                                        	<div><label class="m-0">Corporate Brochure</label></div>
                                        </div>
                                    </div>
                                </div>
								<label for="kit_type" generated="true" class="error" style="display: none;">Please Media Kit</label>
                            </div>                            
                            <div class="form-group mb-3">
                              <textarea name="message" class="form-control" id="message" placeholder="Message" style="min-height:130px;font-size:15px"></textarea>
                            </div>                            
                            <div class="form-group">
                               <input type="submit" class="gold_btn fade_anim" value="SUBMIT" style="width:150px">
                            </div>
						</form>
                    </div>                            
                </div>   
        
                <div class="pressenquiryBox" style="background:#f5f5f5;border-top:1px solid #a59459">                            
                    <div class="ctaContentBox">  
					<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
					<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
                        <h2 class="text-uppercase title mb-3">Join our Mailing List</h2>
						<?php if(!empty($success==1)) { } else { ?>
                        <form name="newsletter" id="newsletter" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
							<?php token(); ?>
							<input type="hidden" name="newsletteraction" value="save"/>                         								
                            <div class="input-group mb-3">
                              <input type="text" name="email" id="email" class="form-control" placeholder="Email" style="height:42px;font-size:15px">
                              <div class="input-group-append">
                                  <input type="submit" class="gold_btn fade_anim" value="JOIN" style="width:100px">
                              </div>
                            </div><label for="email" generated="true" class="error" style="display: none;">Please Enter a valid Email Address.</label>
						</form>  
						<?php } ?>
                    </div>                            
                </div>
            </div>                
        </div>
	</div>
</div>

</section>
<?php include 'include-new/footer.php'; ?>
<script src="assets/js/jquery.validate.js" type="text/javascript"></script>
<!--<script type="text/javascript">
$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
	if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
   };
   },	"Special Characters Not Allowed");

	$("#pressForm").validate({
		rules: {  
			fname: {
				required: true,
			},
			email: {
				required: true,
				email:true
			},
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			subject: {
				required: true,
			},
			kit_type: {
				required: true,
			},
			message:{
				required: true,
			}
		},
		
		messages: {
			fname: {
				required: "Please Enter Your Name",
			},
			email: {
				required: "Please Enter a valid Email id",
			},
			mobile_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			subject: {
				required: "Please Enter Your Subject",
			},			
			kit_type: {
				required: "Please Select Media Kit",
			},
			message: {
				required: "Please Enter Your Message",
			}
		}
	});
});
</script>-->
<script type="text/javascript">
$().ready(function() {
	$("#newsletter").validate({
		rules: {
			email: {
				required: true,
				email:true
			}			
		},		
		messages: {
			email: {
				required: "Please Enter a valid Email id",
			}			
		}
	});
});
</script>
<script>
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});
$('#select_box').change(function () {
var select=$(this).find(':selected').val();        
 $(".hide").hide();
 $('#' + select).show();
 }).change();
</script>

<style>
.circular {height:600px; overflow-y:scroll}
@media (max-width:991px) {
.circular {height:auto; overflow:inherit;}

}
</style>