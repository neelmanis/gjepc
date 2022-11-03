<?php 
$pageTitle = "Gem & Jewellery | advertise - GJEPC India";
$pageDescription  = "Reach out to millions in gems & jewellery Industry";
?>
<?php include 'include/header.php'; ?>

<?php 
if(isset($_POST['submit']))
{
error_reporting(0);

		$company_name = filter($_POST['company_name']);
		$name	=	filter($_POST['name']);
		$email	=	filter($_POST['email']);
		$mobile	=	filter($_POST['mobile']);
		$post_date=date('Y/m/d');		
		
			  $message = "<font style='font-size: 13px; color: black; font-family: arial'>";			 
			
			  $message = $message .= "<strong>Sender Details : </strong><br>"; 
			  $message = $message .= "Company Name : $company_name<br>"; 
			  $message = $message .= "Name : $name<br>"; 
			  $message = $message .= "Email : $email<br>"; 
			  $message = $message .= "Mobile :$mobile<br></br>"; 
			
			  $message = $message .= "</font>";
			  // $to="k@kwebmaker.com";
			   $subject="GJEPC: Enquiry For Monetization";
			   $headers  = 'MIME-Version: 1.0' . "\n"; 
			   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
			   $headers .= 'From:admin@gjepc.org';			   
		
			  $ans=mail($to, $subject, $message, $headers);
			  if($ans)
			  	{
					$signup_success="Thank you for contacting us, Our Advertising team will get back to you.";
				}
}
?>
<?php if(isset($signup_success)){ echo '<span style="color: green;" />'.$signup_success.'</span>';} ?>


<section>
	
    
    <div class="container-fluid inner_container">
    	
        <div class="row justify-content-center grey_title_bg">
        
        	
            	<div class="innerpg_title_center">
                	<h1> Reach out to millions in gems & jewellery Industry </h1>
                </div>
           
            
         </div>
         
        
        <div class="container p-0">
        
        	<div class="row justify-content-center mb-5">
            	
                <form action="" method="post" name="loginproject" id="regisForm" class="col-lg-5 box-shadow">
                
                	<div class="row">
						
                        <div class="form-group col-12">
							<input type="text" class="form-control" name="company_name" id="company_name" autocomplete="off" placeholder="Company Name">
						</div>
			
						<div class="form-group col-12">
							<input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="Name">
						</div>
                        
						<div class="form-group col-12">
							<input type="email" class="form-control" name="email" id="email" autocomplete="off" placeholder="Email">
						</div>
                        
						<div class="form-group col-12">
							<input type="text" class="form-control" name="mobile" id="mobile" autocomplete="off" placeholder="Mobile">
						</div>
                        
                        <div class="form-group col-12">
							<input type="text" class="form-control" autocomplete="off" id="captcha_code" name="captcha_code" placeholder="Enter Captcha Code"/>
						</div>
                        
						<div class="form-group col-12">
							<img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/>
						</div>
	
						<div class="form-group col-12">				
							<button type="submit" class="cta fade_anim" value="Submit" name="submit" >Submit</button>
			
						</div>
                        
                        </div>
					
                    </form>
                
            </div>
            
            
        </div>
          
            
        </div>
	
    </div>
    
    
    
    
    

</section>


<?php include 'include/footer.php'; ?>

<script src="assets/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$("#regisForm").validate({
		rules: {
			company_name: {
				required: true,
			},
			name: {
				required: true,
			},
			email: {
				required: true,
				email:true
			},
			mobile: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},			
			captcha_code:{
				  required: true,
				  remote: "check-captcha.php",
				  type:"post"
			},
		},
		messages: {
			company_name: {
				required: "Please Enter Company Name",
			}, 			
			name: {
				required: "Please Enter your Name",
			},
			email: {
				required: "Please Enter a valid Email id",
			},
			mobile: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			}, 
		captcha_code:{
				required: "Please Enter Captcha Code",
				remote: "Captcha Entered Incorrectly"
		}
	 }
	});
});
</script>