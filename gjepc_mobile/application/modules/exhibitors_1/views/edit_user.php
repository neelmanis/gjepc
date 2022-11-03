  <div class="form-panel">
    <h4 class="mb">User Detail</h4>
    <div style="display: none;" class="form_error"></div>
    <div style="display: none;" class="form_success"></div>
	<form id="form" class="form-horizontal style-form">
		<div class="form-group" id='message'>
			<div class="col-sm-12">
			</div>
		</div>
        
      <?php 
	  if(is_array($display)) {
	   ?>   
		<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">User Name:</label>
		    <div class="col-sm-9">
				<input type="text" name="uname" id="uname" readonly="readonly" class="form-control" value="<?php echo $display[0]->username; ?>"/>
			</div>
		</div>

		<div class="form-group">
		    <label class="col-sm-3 control-label">Email</label>
		    <div class="col-sm-9">
		<input type="text"  name="email" id="email" class="form-control noreset" readonly="readonly" value="<?php echo $display[0]->email; ?>"/>
		    </div>
		</div>
        
        <div class="form-group">
		    <label class="col-sm-3 control-label">User Space</label>
		    <div class="col-sm-9">
		<input type="text"  name="userSpace" id="userSpace" class="form-control noreset" value="<?php echo $display[0]->userspace; ?>"/>
		    </div>
		</div>
        
        <div class="form-group">
		    <label class="col-sm-3 control-label">Device Type</label>
		    <div class="col-sm-9">
			    <select name="deviceType" id="deviceType" class="form-control noreset">
                  <option value="A" <?php if($display[0]->deviceType == "A"){ echo "selected";}?>>Android</option>
                  <option value="I" <?php if($display[0]->deviceType == "I"){ echo "selected";}?>>iPhone</option>
                </select>
		    </div>
		</div>
      
        
        <div class="form-group">
		    <label class="col-sm-3 control-label">User Type</label>
		    <div class="col-sm-9">
			    <select name="usertype" id="usertype" class="form-control noreset">
                  <option value="N" <?php if($display[0]->usertype == "N"){ echo "selected";}?>>Normal</option>
                  <option value="P"<?php if($display[0]->usertype == "P"){ echo "selected";}?>>Premium</option>
                </select>
		    </div>
		</div>
        
        <input type="hidden" name="id" id="id" value="<?php echo $display[0]->regId;?>">
        
        
         <button type="submit">Update</button>
   <?php } ?>		
	</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
								
var CI_ROOT= "<?php echo base_url();?>";

	jQuery("#form").submit(function(e){
	e.preventDefault();

          var uname = $("#uname").val(); 
		  var uemail = $("#email").val();
		  var uspace = $("#userSpace").val();
		  var utype = $("#usertype").val();
		  var uref = $("#refCode").val();
		  var user = $("#deviceType").val();
		  
          var formdata = jQuery("#form").serialize();
		  
      	jQuery.ajax({
				type :"POST",
				data :formdata,
				url :CI_ROOT+"users/updateUser",
				success : function(result){ 
                           if(result==1)
						   {
						   $(".form_success").css("display","block");
						   $(".form_success").html("This information updated successfully.").delay(1000).fadeOut(5000);
						   }
						   else
						   {
						   $(".form_error").css("display","block");
						   $(".form_error").html(result).delay(1000).fadeOut(5000);
 						   } 
				}
			})
})
})
</script>