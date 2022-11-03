  <?php $path = "http://localhost/lifefeed/" ;?>
  <div class="form-panel">
    <h4 class="mb">Feed Detail</h4>
	<form id="form" class="form-horizontal style-form">
		<div class="form-group" id='message'>
			<div class="col-sm-12">
			</div>
		</div>
         <?php if(is_array($feed)){
        ?>

		<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Feed Description</label>
		    <div class="col-sm-9">
				<input type="text" name="catName" id="catName" readonly="readonly" class="form-control" value="<?php echo $feed[0]->description; ?>"/>
			</div>
		</div>

		<div class="form-group">
		    <label class="col-sm-3 control-label">Category</label>
            <?php if(is_array($feed_cat)) {
			 ?>
		    <div class="col-sm-9">
			    <input type="text"  name="parentId" id="parent_category" readonly="readonly" class="form-control noreset" value="<?php echo $feed_cat[0]['catName']; ?>"/>
		    </div>
            <?php } ?>
		</div>

		<div class="form-group">
		    <label class="col-sm-3 control-label">Contacts</label>
            <?php if(is_array($contact)) {
			 ?>
		    <div class="col-sm-9">
			    <table border="1">
   <thead>
     <th>Contact Name</th>
     <th>Contact Number</th>
   </thead>
   <tbody>
    <?php foreach($contact as $row) { ?>
    <tr>
     <td><?php echo $row['contactName']; ?></td>
     <td><?php echo $row['contactNumber']; ?></td>
    </tr>
<?php } } ?>
</tbody>
</table>
		    </div>
           
		</div>
        <?php if(!empty($image)) {?>
        <div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Images</label>
            <?php if(is_array($image)){
			?>
             <div class="col-sm-9">
			   <?php  
			   
			   
			   foreach($image as $val){
				
		
		
			?>
		   
             <img src="<?php echo $path;?>uploads/feeds/<?php echo $val['imgId']?>/images/<?php echo $val['imageName'];?>" style="width:100px !important;height:100px !important;">
            <?php } } ?>
            </div>
		</div>
        <?php } ?>
	    <div class="form-group">
		    <label class="col-sm-3 control-label">Status</label>
		    <div class="col-sm-9">
			    <select  name="isActive" id="category_status" class="form-control">
			        <option value="1" <?php if($feed[0]->isActive=='1'){ echo "selected";}?> >Active</option>
			        <option value="0" <?php if($feed[0]->isActive=='0'){ echo "selected";}?>>Deactive</option>
			    </select>
		    </div>
		</div>
		
		<!--<div class="form-group">
			<label class="col-sm-3 control-label">&nbsp;</label>
			<div class="col-sm-9">
				<input type="submit" class="btn btn-primary noreset" id="banner_btn" value='Save'>
				<a href="<?php echo base_url("category/lists")?>" class="btn btn-primary">Cancel</a>
			</div>
		</div>-->
        
        <?php } ?>
	</form>
</div>