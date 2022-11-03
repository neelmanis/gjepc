<script src="<?php echo base_url()?>assets/js/admin/users.js"></script>
<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> Change Password</h4>
                      <form class="form-horizontal style-form" method="get">
                      <div class="alert alert-danger" style="display: none;"></div> 
		        	<div class="alert alert-success" style="display: none;"></div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Enter Old Password</label>
                              <div class="col-sm-10">
                                  <input type="password" id="txtoldpass" placeholder="Old password" class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Enter New Password</label>
                              <div class="col-sm-10">
                                  <input type="password" id="txtnewpass" placeholder="New password" class="form-control">
                                 
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Enter Confirm Password</label>
                              <div class="col-sm-10">
                                  <input type="password" id="txtconfpass" placeholder="Confirm password" class="form-control">
                                 
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label"></label>
                              <div class="col-sm-10">
                                  <button class="btn btn-theme btn-block" id="btnsubmit"  type="button"> Change Password</button>
                                 
                              </div>
                          </div>
                          
                          
                      </form>
                  </div>
          		</div><!-- col-lg-12-->      	
          	</div><!-- /row -->