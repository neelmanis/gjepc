<?php //error_reporting(0);?>
<style>
    .mb-2{margin-bottom: 20px;}
    .display-none{display: none;}
    .error{color: red}
</style>

<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
        	<h4>View Notification</h4>
             <div style="display: none;" class="form_error"></div>
             <div style="display: none;" class="form_success"></div>
     
	        <section id="no-more-tables">
                <div class="table-responsive">
	            <table class="table table-striped table-condensed cf table-responsive" id='bannerTable'>
	            <thead class="cf">
					<tr>
                      
					  	<th>ID</th>
					  	<th>Device ID</th>
                        <th>Device Type</th>
					</tr>
				</thead>

				<tbody>
				<?php 
					$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
					if(is_array($getAllusers) && !empty($getAllusers)){						
						foreach($getAllusers as $val)
						{ 
					     if($val->isActive == 1){$status="Active";}else{$status="Deactive";}
						 if($val->deviceType == 'A'){$device="Android";}else{$device="iPhone";}
				?> 
					<tr>
                  
					  	<td data-title="Name"><?php echo $val->id;?></td>
                        <td data-title="Order"><?php echo $val->deviceId;?></td>
                        <td data-title="Order"><?php echo $val->deviceType;?></td>
					</tr>
				<?php
					} }
				?>
				</tbody>
	        </table>  
            </div>   
             </section> 
               <div class="row">
                   <div class="col-md-10 col-md-offset-1">
                    <div id="loader" style="display: none; margin-left:50%;transform: translate(-50%);width: 60px;height: 60px;"> <img src="<?php echo base_url()?>public/images/1548097831_loading.gif" style="width: 100%";> </div>
                         <form id="Notification_form" class="form-horizontal">
                         	<div class="col-md-6 col-md-offset-1 ">
                         		<p id="typeText" class="error"></p>
                <select name="type" id='type' class="form-control mb-2" >
                	<option value="0">---Select Type---</option>
                	<option value="A">Android</option>
                	<option value="I">IOS</option>
                
                </select>
                 

            </div>
                <div class="col-md-10 col-md-offset-1">
                <p id="titleText" class="error"></p>
                 <input type="text" name="title" class="form-control mb-2">  
               

               <div> 
                 <p id="messageText" class="error"></p>                               
                <textarea class="newTextArea form-control mb-2" rows="10" id="txtmsg" name="message" cols="100" placeholder="Type message"></textarea>
               

            </div>
            <div>
                <input type="submit" name="btn_submit" id="btnSubmit" value="Send Notification"></div>

                </form> 
                <div style="display:block;"><p style="text-align: center;" id="notificationText"></p></div>
                   </div>
               </div>
             
        </div>   	
        </div>
    </div>


<script>				
	$(document).ready(function(){
		$('#bannerTable').DataTable();
		$('body').delegate('.deleterows','click',function(e){
			e.preventDefault();
			var user_id = this.id;
			  $.ajax({
				type:"POST",
				url:"<?php echo base_url();?>users/delete_user",
				data:{user_id:user_id},
				success:function(result){
					alert("Category De-active successfuly..");
					location.reload(true);
				}
			}) 
		});
	});			
</script>
<script>
var baseUrl = '<?php echo base_url(); ?>';
$(document).ready(function(){   
    $("#Notification_form").on("submit",function(e){
      
        e.preventDefault();
      
        if(window.FormData != 'undefined')
        {
            var formdata = new FormData(this);
    
         $.ajax({
            type:"POST",
            url:"<?php echo base_url();?>notification/sendNotification",  
            data:formdata,
            processData : false,
            contentType : false,
            dataType:'json',
            mimeType : 'multipart/form-data',
            beforeSend: function(){
                $("#btnSubmit").attr("disabled", true);
                $('#loader').show();
                $('#notificationText').text("Notification Sending in Progress Please Wait...");
                $('#Notification_form').hide();
            },
            success:function(result){
                $("#btnSubmit").attr("disabled", false);
                     $('#loader').hide();
                     $('#Notification_form').show();
                if(result['status'] == "success"){
                    $('#Notification_form')[0].reset();
                $('#notificationText').text("Notification Sent successfuly");
                 $('#typeText').text("");
                 $('#titleText').text("");
                 $('#messageText').text("");		
                }else if(result['status'] == "emptyType"){

                $('#typeText').text("Device Type is required");
                 $('#notificationText').text("");
                }else if(result['status'] == "emptyTitle"){
                 $('#notificationText').text("");
                $('#titleText').text("Title is required");	
                }else if(result['status'] == "emptyMessage"){
                 $('#notificationText').text("");
                $('#messageText').text("message is required");	
                }
               }
            })
        }
    });
})
</script>           	
