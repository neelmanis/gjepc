  <div class="form-panel">
    <h4 class="mb">Exhibitor Detail</h4>
    <div style="display: none;" class="form_error"></div>
    <div style="display: none;" class="form_success"></div>
	<form id="form" class="form-horizontal style-form">
		
      <?php 
	  if(is_array($display)) {
			foreach($display as $row) {
	   ?>   
		<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Gcode: </label>
		    <div class="col-sm-9">
				<input type="text" name="gcode" id="gcode" class="form-control" value="<?php echo $row->Customer_No; ?>"/>
			</div>
		</div>

		<div class="form-group">
		    <label class="col-sm-3 control-label">Exhibitor Name</label>
		    <div class="col-sm-9">
		<input type="text"  name="Exhibitor_Name" id="Exhibitor_Name" class="form-control noreset" value="<?php echo $row->Exhibitor_Name; ?>"/>
		    </div>
		</div>
        
        <div class="form-group">
		    <label class="col-sm-3 control-label">Exhibitor Contact Person</label>
		    <div class="col-sm-9">
		<input type="text"  name="Exhibitor_Contact_Person" id="Exhibitor_Contact_Person" class="form-control noreset" value="<?php echo $row->Exhibitor_Contact_Person; ?>"/>
		    </div>
		</div>
        
		<div class="form-group">
		    <label class="col-sm-3 control-label">Exhibitor Designation</label>
		    <div class="col-sm-9">
		<input type="text"  name="Exhibitor_Designation" id="Exhibitor_Designation" class="form-control noreset" value="<?php echo $row->Exhibitor_Designation; ?>"/>
		    </div>
		</div>
		
		<div class="form-group">
		    <label class="col-sm-3 control-label">Exhibitor Email</label>
		    <div class="col-sm-9">
		<input type="text"  name="Exhibitor_Email" id="Exhibitor_Email" class="form-control noreset" value="<?php echo $row->Exhibitor_Email; ?>"/>
		    </div>
		</div>
		
		<div class="form-group">
		    <label class="col-sm-3 control-label">Exhibitor Mobile</label>
		    <div class="col-sm-9">
		<input type="text"  name="Exhibitor_Mobile" id="Exhibitor_Mobile" class="form-control noreset" value="<?php echo $row->Exhibitor_Mobile; ?>"/>
		    </div>
		</div>
		
		<div class="form-group">
		    <label class="col-sm-3 control-label">Event</label>
		    <div class="col-sm-9">
		<input type="text"  name="event_name" id="event_name" class="form-control noreset" value="<?php echo $row->event_name; ?>"/>
		    </div>
		</div>
		
		<div class="form-group">
		    <label class="col-sm-3 control-label">Year</label>
		    <div class="col-sm-9">
		<input type="text"  name="year" id="year" class="form-control noreset" value="<?php echo $row->year; ?>"/>
		    </div>
		</div>
       
        <div class="form-group">
	       	<label class="col-sm-3 control-label">Status</label>
		    <div class="col-sm-9">
			<select class="form-control" name="status">
				<option value="1" <?php if($row->Exhibitor_IsActive=="1") echo 'selected="selected"';?> >Active</option>
				<option value="0" <?php if($row->Exhibitor_IsActive=="0") echo 'selected="selected"';?> >Inactive</option>
			</select>
			</div>
		</div>
			
        <input type="hidden" name="id" id="id" value="<?php echo $row->Exhibitor_ID;?>">
        
        
         <button type="submit">Update</button>
	  <?php } } ?>		
	</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
								
var CI_ROOT= "<?php echo base_url();?>";

	jQuery("#form").submit(function(e){
	e.preventDefault();

          var gcode = $("#gcode").val();
		  var Exhibitor_Name = $("#Exhibitor_Name").val();
		  var Exhibitor_Contact_Person = $("#Exhibitor_Contact_Person").val();
		  var Exhibitor_Designation = $("#Exhibitor_Designation").val(); 		  
		  var Exhibitor_Email = $("#Exhibitor_Email").val();
		  var Exhibitor_Mobile = $("#Exhibitor_Mobile").val();
		  var event_name = $("#event_name").val();
		  var year = $("#year").val();
		  var status = $("#status").val();
		  
          var formdata = jQuery("#form").serialize();
		  
      	jQuery.ajax({
				type :"POST",
				data :formdata,
				url :CI_ROOT+"exhibitors/updateUser",
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