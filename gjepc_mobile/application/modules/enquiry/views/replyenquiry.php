<div class="form-panel">
        <h4 class="mb">Reply</h4>
        	
			<?php
			if(is_array($editinfo)){
            foreach($editinfo as $row){
				//echo "<pre>"; print_r($this->session->all_userdata());exit;
				$adminId = ($this->session->userdata['adminData']['userId']);
			// echo '<pre>';print_r($row);
			?>
			<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("enquiry/updateDetails");?>">
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Email</label>
		    <div class="col-sm-9">
				<input type="text" name="email" id="Email" class="form-control" value="<?php echo $row->email;?>" readonly/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Mobile</label>
		    <div class="col-sm-9">
				<input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo $row->mobile;?>" readonly/>
			</div>
			</div>
						
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Enquiry">Enquiry</label>
		    <div class="col-sm-9">
			<textarea class="form-control" Placeholder="Description Here" name="description" id="description" rows="3" disabled="disabled" required><?php echo $row->enquiry;?></textarea>			
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Feedback">Your Feedback</label>
		    <div class="col-sm-9">
			<textarea class="form-control" Placeholder="Write Your Description Here" name="description" id="description" rows="3" required></textarea>			
			</div>
			</div>
			
			<div class="form-group">
			<input type="hidden" name="id" value="<?php echo $row->id?>">
			<input type="hidden" name="adminid" value="<?php echo $adminId;?>">
			<input type="submit" class="btn btn-primary" name="submit" value="Reply">	
			</div>
			</form>			

		  <?php
			}
			} 
			?> 
</div>

        