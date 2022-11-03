 <main>
  <section class="inner">
    <div class="container">
      <div class="row loginRegister">
        <div class="col-sm-6">
		<?php if($mobileStatus=='N')
		{ ?>
			
			<form class="row FlowupLabels" id="otpForm">
           <div class="otpBlock"> 
           <h3>Confirm your Mobile No.</h3>
          <p>An SMS-OTP has been sent to your registered mobile number</p>
          
          <p><strong>One-Time Password</strong>Please enter your 4-digit One-Time Password (OTP):</p>
		   <div class="validError">
			  </div>
          <div class="form-group fl_wrap">
              <label class="fl_label" for="otp">Enter your OTP</label>
              <input type="text" class="form-control fl_input" id="otp">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btnBlock" value="Confirm">
            </div>
          <p>If you do not receive your OTP via SMS within the next few Minutes, Please Click <a href="" class="resend_otp">here</a> to regenerate.</p>
          </div>
		   </form>   
			
			
			
	<?php 	} 
	else { ?>
	<form class="row FlowupLabels" id="otpForm">
           <div class="otpBlock"> 
           <h3>Your Mobile number is already verified</h3>
         
          </div>
		   </form>   
	<?php } ?>
              
        </div>
      </div>
    </div>
  </section>
</main>

  
        