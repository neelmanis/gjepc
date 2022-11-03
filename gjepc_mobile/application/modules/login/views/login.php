 <script src="<?php echo base_url()?>assets/js/jquery-2.1.3.js"></script>
 <script type="text/javascript">
 	var CI_ROOT="<?php echo base_url()?>index.php/";
 </script>
<script src="<?php echo base_url()?>assets/js/admin/login.js"></script>
<div class="container">
	  	
		      <form class="form-login" >
		        <h2 class="form-login-heading">sign in now</h2>
		        <div class="login-wrap">
		        	<div class="alert alert-danger" style="display: none;"></div> 
		        	<div class="alert alert-success" style="display: none;"></div>
		            <input type="text" id="txtusername" class="form-control" placeholder="User ID" autofocus>
		            <br>
		            <input type="password" id="txtpassword" class="form-control" placeholder="Password">
		            <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
		
		                </span>
		            </label>
		            <button class="btn btn-theme btn-block" id="btnlogin"  type="button"><i class="fa fa-lock"></i> SIGN IN</button>
		            <hr>
		            <!--
		            <div class="login-social-link centered">
		            <p>or you can sign in via your social network</p>
		                <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
		                <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
		            </div>
		            <div class="registration">
		                Don't have an account yet?<br/>
		                <a class="" href="#">
		                    Create an account
		                </a>
		            </div>-->
		
		        </div>
		
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Forgot Password ?</h4>
		                      </div>
		                      <div class="modal-body">
		                          <p>Enter your e-mail address below to reset your password.</p>
		                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
		
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-theme" type="button">Submit</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
		          <!-- modal -->
		
		      </form>	  	
	  	
	  	</div>