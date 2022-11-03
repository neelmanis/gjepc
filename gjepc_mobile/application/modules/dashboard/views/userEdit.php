<?php 
//echo "<pre>"; print_r($info[0]);
?>


<div class="col-sm-9">
          <form class="profile FlowupLabels" >
            <fieldset>
              <legend>Personal info</legend>
              <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="firstName">First Name</label>
                  <input type="text" class="form-control fl_input" name="firstName" readonly value="<?php echo $info[0]->firstName; ?>">
                </div>
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="middleName">Middle Name</label>
                  <input type="text" class="form-control fl_input" name="MiddleName" readonly value="<?php echo $info[0]->MiddleName; ?>" >
                </div>
              </div>
               <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="lastName">Last Name</label>
                  <input type="text" class="form-control fl_input" name="lastName"  readonly value="<?php echo $info[0]->lastName; ?>">
                </div>
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="phoneNumber">Phone Number</label>
                  <input type="text" class="form-control fl_input" name="mobileNo" readonly value="<?php echo $info[0]->mobileNo; ?>">
                </div>
              </div>
            
              <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="emailAddress">Email Address</label>
                  <input type="text" class="form-control fl_input" name="email" readonly value="<?php echo $info[0]->email; ?>">
                </div>
                <div class="col-xs-6">
                <div class="row">
                <label class="col-xs-3 control-label">I Am</label>
                <div class="col-xs-9">
				 <input type="text" class="form-control fl_input" name="Gender" readonly value="<?php echo ($info[0]->gender=='M')?'Male':'Female'; ?>">                 
                </div>
                </div>
                </div>
              </div>
            </fieldset>
            <fieldset>
              <legend>Address information</legend>
              <div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="Building">Building</label>
                  <input type="text" class="form-control fl_input" name="building" readonly value="<?php echo $info[0]->building; ?>">
                </div>
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="Street">Street</label>
                  <input type="text" class="form-control fl_input" name="street" readonly value="<?php echo $info[0]->street; ?>">
                </div>
              </div>
			  <input type="hidden" name="user_country" value="<?php echo $info[0]->countryId; ?>" />
			  <input type="hidden" name="user_state" value="<?php echo $info[0]->stateId; ?>" />
			  <input type="hidden" name="user_city" value="<?php echo $info[0]->cityId; ?>" />
			<?php 
				$city='';
				if($info[0]->cityId!='')
				$city=Modules::run('cities/_getName',$info[0]->cityId);

				$state='';
				if($info[0]->stateId!='')
				$state=Modules::run('states/_getName',$info[0]->stateId);

				$country='';
				if($info[0]->countryId!='')
				$country=Modules::run('countries/_getName',$info[0]->countryId);
				//echo "<pre>"; print_r($info); ?>
			  
			  
			  
              <div class="form-group row">
			  <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="Country">Country</label>
                  <input type="text" class="form-control fl_input" name="Country" readonly value="<?php echo ($country!='')?$country:$info[0]->otherCountries; ?>">
                </div>
				<div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="State">State</label>
                  <input type="text" class="form-control fl_input" id="State" readonly value="<?php echo ($state!='')?$state:$info[0]->otherStates; ?>">
                </div>				
               </div>
				<div class="form-group row">
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="City">City</label>
                  <input type="text" class="form-control fl_input" id="City" readonly value="<?php echo ($city!='')?$city:$info[0]->otherCities; ?>">
                </div>
				 
              </div>
              <div class="form-group row">
               
                <div class="col-xs-6 fl_wrap">
                  <label class="fl_label" for="postalZip">Postal/Zip Code</label>
                  <input type="text" class="form-control fl_input" name="pincode" readonly value="<?php echo $info[0]->pincode; ?>">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-12">
				<!--<input type="hidden" name="page_type" value="update_profile" />
				<input type="hidden" name="regId" value="<?php //echo $info[0]->regId; ?>" />-->
                  <!-- <input type="submit" value="Save" class="btn orangeBorder borderBtn"> -->
                  <input onclick="location.href='<?php echo base_url('dashboard/profile') ?>'" type="button" value="Cancel" class="btn borderBtn">
                </div>
              </div>
            </fieldset>
          </form>
        </div>
      