<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/ckfinder/ckfinder.js"></script>

<div class="form-panel">
    <h4 class="mb">Details</h4>
	
	<form class="form-horizontal style-form categoryform" >
					<?php
					if(is_array($view_details)){
						foreach($view_details as $row){ 
					?>
		
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Title</label>
		    <div class="col-sm-9">
				<input type="text" name="title" id="title" class="form-control" value="<?php echo $row->title;?>" readonly/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Description</label>
		    <div class="col-sm-12">
				<textarea name="content" class="ckeditor" id="content" disabled><?php echo $row->description;?></textarea>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Status</label>
		    <div class="col-sm-9">
			<select class="form-control" name="status" disabled="disabled">
				<option value="1" <?php if($row->status=="1") echo 'selected="selected"';?> >Active</option>
				<option value="0" <?php if($row->status=="0") echo 'selected="selected"';?> >Inactive</option>
			</select>
			</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-3 control-label">&nbsp;</label>
			<div class="col-sm-9">
				<a href="<?php echo base_url("labeduinfo/LaboratoryList");?>"><button class="btn btn-primary" type="button">BACK</button></a>
			</div>
			</div>			
			
			<?php } } ?>
    </form>
</div>
					