<?php 
//echo "<pre>"; print_r($info[0]);
?>


<div class="col-sm-9">
          <form class="profile FlowupLabels" id="profile_update">
            <fieldset>
              <legend>Personal info</legend>
              <div class="validError">
			  </div>
            
              <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="emailAddress">Email Address</label>
                  <input type="text" class="form-control fl_input" name="email"  value="<?php echo $info[0]->email; ?>">
				  <?php echo form_error('email'); ?>
                </div>
              
              </div>
			   <div class="form-group row">              
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">Phone Number</label>
                  <input type="text" class="form-control fl_input" name="mobileNo"  value="<?php echo $info[0]->mobileNo; ?>">				 
                </div>
              
              </div>
			  <div class="form-group row">
                <div class="col-xs-12">
				<input type="hidden" name="page_type" value="update_profile" />
				<input type="hidden" name="regId" value="<?php echo $info[0]->regId; ?>" />
				<input type="hidden" name="curr_email" value="<?php echo $info[0]->email; ?>" />
				<input type="hidden" name="curr_phone" value="<?php echo $info[0]->mobileNo; ?>" />
                  <input type="submit" value="Save" class="btn orangeBorder borderBtn"> 
                  <input onclick="location.href='<?php echo base_url('dashboard/profile') ?>'" type="button" value="Cancel" class="btn borderBtn">
                </div>
              </div>
            </fieldset>
            
		  </form>
		   <form class="profile FlowupLabels" id="password_update">
            <fieldset>
              <legend>Change Password</legend>
              <div class="validErrorPassword">
			  </div>
			  
			  
			  <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="oldPassword">Old Password</label>
                  <input type="password" class="form-control fl_input" name="oldPassword" >				  
                </div>              
              </div>
            
              <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="newPassword">New Password</label>
                  <input type="password" class="form-control fl_input" name="newPassword" >				  
                </div>              
              </div>
			  
			   <div class="form-group row">              
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="newPasswordConfirm">Confirm new password</label>
                  <input type="password" class="form-control fl_input" name="newPasswordConfirm"  >				 
                </div>              
              </div>
			  
			  <div class="form-group row">
                <div class="col-xs-12">
				<input type="hidden" name="page_type" value="change_password" />
				<input type="hidden" name="regId" value="<?php echo $info[0]->regId; ?>" />
				<input type="submit" value="Save" class="btn orangeBorder borderBtn"> 
                  <input onclick="location.href='<?php echo base_url('dashboard/profile') ?>'" type="button" value="Cancel" class="btn borderBtn">
                </div>
              </div>
            </fieldset>
            
		  </form>
</div>
      