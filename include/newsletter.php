<script type="text/javascript">
function checkmail()
{
	//alert("hello");
	email=document.getElementById('email').value;
	var reg_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	var ans_email = reg_email.test(email); 
		
	if(email=="")
	{
		alert("Kindly enter your email id and then click on Submit");
		document.getElementById('email').focus();
		return false;
	}else if(ans_email==false)
	 	{
		alert("Please Enter Valid Email Id."); 
		document.getElementById('email').focus();
		return false;
		}
}
</script>
<div class="newsletter openion widget">
			<div class="title">
		        <h4>Subscribe to Newsletter</h4>
		    </div>
			<form name="newsletter" id="newsletter" action="newsletter_action.php" method="post" >			
				<input name="email" id="email" type="text" class="form-control" placeholder="Signup for Newsletter"/>				   
				<div class="vote su row">
					<div class="col-md-12">	
						<input name="btn" type="submit" value="Submit" class="pull-right" onclick="return checkmail()"/>	
					</div>
				</div>	
			</form>
</div>	