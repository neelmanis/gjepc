<?php 
//echo "<pre>"; print_r($info[0]);
?>


<div class="col-sm-9">
          <form class="profile FlowupLabels" id="add_address">
            <fieldset>
              <legend>Address</legend>
			  <div class="validError">
			  </div>
            
               <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="emailAddress">Address Title<span class="wrong_right">*</span></label>
                  <input type="text" class="form-control fl_input" name="addtitle" id="addtitle" >
				    <span id="first" class="error"></span>
				     <!--<div class="righterr" id="first_right"><img src="<?php echo base_url()?>assets/images/right.png"></div>
                     <div class="wrong" id="first_wrong"><img src="<?php echo base_url()?>assets/images/wrng.png"></div>-->           
                </div>
			 </div>
			 
              <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="emailAddress">First Name<span class="wrong_right">*</span></label>
                  <input type="text" class="form-control fl_input" name="firstName" id="firstName" >
				    <span id="first" class="error"></span>
				     <!--<div class="righterr" id="first_right"><img src="<?php echo base_url()?>assets/images/right.png"></div>
                     <div class="wrong" id="first_wrong"><img src="<?php echo base_url()?>assets/images/wrng.png"></div>-->           
                </div>
			 </div>
			 
			  <div class="form-group row">
                
				 <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="emailAddress">Middle Name</label>
                  <input type="text" class="form-control fl_input" name="MiddleName"  >
                </div>
			 </div>
			 
			 
			 
			   <div class="form-group row">              
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">Last Name<span class="wrong_right">*</span></label>
                  <input type="text" class="form-control fl_input" name="lastName" id="lastName" /> 
				  <span id="last" class="error"></span>
					<!--<div id="last_right" class="righterr"><img src="<?php echo base_url()?>assets/images/right.png"></div>
				   <div id="last_wrong" class="wrong"><img src="<?php echo base_url()?>assets/images/wrng.png"></div>-->	
                </div>
              </div>
			  
			   <div class="form-group row">              
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">Building<span class="wrong_right">*</span></label>
                  <input type="text" class="form-control fl_input" name="building" id="building" >
					 <span class="error" id="build"></span>
				     <div id="build_right" class="righterr"><img src="<?php echo base_url()?>assets/images/right.png"></div>
				    <div id="build_wrong" class="wrong"><img src="<?php echo base_url()?>assets/images/wrng.png"></div>
                </div>
				</div>
				<div class="form-group row">              
                 <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">Street<span class="wrong_right">*</span></label>
                  <input type="text" class="form-control fl_input" name="street" id="street"  >
				   <span class="error" id="street_text"></span>
                   <!--<div id="street_right" class="righterr"><img src="<?php echo base_url()?>assets/images/right.png"></div>
                   <div id="street_wrong" class="wrong"><img src="<?php echo base_url()?>assets/images/wrng.png"></div>-->
                </div>
				</div>
				
             
			  
			   <div class="form-group row">              
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">Country</label>
                  <select class="form-control fl_input" name="countryId">
							<option value="">Select Country</option>
						</select>
                </div>
				</div>
				<div class="form-group row">  
				<div class="col-xs-6 fl_wrap">
                  <div class="form-group fl_wrap" id="state"></div>
                </div>
              </div>
			  
			   <div class="form-group row">              
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">City</label>
                 <div class="form-group fl_wrap" id="city"></div>
                </div>
              </div>
			  
			   <div class="form-group row">              
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">Pincode<span class="wrong_right">*</span></label>
                  <input type="text" class="form-control fl_input" name="pincode"  id="pincode" >
						<span class="error" id="pin_code"></span>
                        <!--<div id="pin_right" class="righterr"><img src="<?php echo base_url()?>assets/images/right.png"></div>
						<div id="pin_wrong" class="wrong"><img src="<?php echo base_url()?>assets/images/wrng.png"></div>-->
                </div>
				</div>
				<div class="form-group row">   
				<div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">Mobile No<span class="wrong_right">*</span></label>
                  <input type="text" class="form-control fl_input" name="mobileNo"  id="mobile">
					<span class="error" id="contact"></span>
					   <!--<div id="phone_right" class="righterr"><img src="<?php echo base_url()?>assets/images/right.png"></div>
					  <div id="phone_wrong" class="wrong"><img src="<?php echo base_url()?>assets/images/wrng.png"></div>-->
                </div>
              </div>
			  
			 </div>
			  
			  <div class="form-group row">
                <div class="col-xs-12">
				
				<input type="hidden" name="regId" value="<?php echo $info[0]->regId; ?>" />
                  <input type="submit" value="Save" class="btn orangeBorder borderBtn"> 
                  <input onclick="location.href='<?php echo base_url('dashboard/profile') ?>'" type="button" value="Cancel" class="btn borderBtn">
                </div>
              </div>
            </fieldset>
            
		  </form>
</div>
      