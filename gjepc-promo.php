<?php 
include('db.inc.php');
include('functions.php');
$pageTitle = "Gems And Jewellery Industry In India | Deepawali Promo Video request - GJEPC India";
$pageDescription  = "The Gem & Jewellery Export Promotion Council (GJEPC) was set up by the Ministry of Commerce, Government of India (GoI) in 1966. It was one of several Export Promotion Councils (EPCs) launched by the Indian Government";
?>
<?php include 'include-new/header.php'; ?>

<style type="text/css">
    label.error{color: #a50000!important}
      .inputcontainer {
          position: relative;
        }

        
        .icon-container {
          position: absolute;
          right: 10px;
          top: calc(50% - 10px);
        }
        .loader_input {
          position: relative;
          height: 20px;
          width: 20px;
          display: inline-block;
          animation: around 5.4s infinite;
        }

        @keyframes around {
          0% {
            transform: rotate(0deg)
          }
          100% {
            transform: rotate(360deg)
          }
        }

        .loader_input::after, .loader_input::before {
          content: "";
          background: white;
          position: absolute;
          display: inline-block;
          width: 100%;
          height: 100%;
          border-width: 2px;
          border-color: #333 #333 transparent transparent;
          border-style: solid;
          border-radius: 20px;
          box-sizing: border-box;
          top: 0;
          left: 0;
          animation: around 0.7s ease-in-out infinite;
        }

        .loader_input::after {
          animation: around 0.7s ease-in-out 0.1s infinite;
          background: transparent;
        }
</style>
<section>
    
<div class="container inner_container">

    <div class="row justify-content-center mb-0 mt-3">
        <div class="col-12 text-center">
            <h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
          BOOST YOUR JEWELLERY SALES THIS <span>Dhanteras!</span> </h1>
        </div>
    </div>

    <div class="row ab_none  justify-content-between mb-5">

        <div class="col-12">
            <h1 class="bold_font font_responsive text-center"><div class="d-block ">AN EXCLUSIVE OFFER FOR IIJS PATRONS!</h1>

            	<img src="images/promo-video-artwork.jpg?v=1.2" class="img-fluid mb-5">
              
                
                <ul class="inner_under_listing">
                    <li>Complimentary usage rights*</li>
                    <li>Incorporate  your Retail Brand logo in any of these films to Boost Festive Sales</li>
                    <li>10 Gold & Diamond Films to Choose From</li>
                    <li>Languages Available: Hindi (All Films) | Bengali, Tamil & Malayalam(Select Films)</li>
                    <li><strong>*Processing Fee - Only Rs. 2000 Inclusive of GST Per Film</strong> </li>
                </ul>
               
               
        </div>
           <div class="col-12 mt-5 " >
            <form class="webinarRegister"   id="promo-video-registration"  enctype="multipart/form-data" autocomplete="off" >
                <h3 class="text-center">Dhanteras Promo Video Request Application</h3>
                <div class="row ab_none justify-content-center">
                    <!--  <label class="d-inline-block mr-3 radio-box" for="member">
                          <input type="radio" name="check_member" id="member" value="member" >Member</label> -->
                   
                    <div class="col-md-6">
                    <div class="inputcontainer">
                    <input type="text" name="pan_number" id="pan_number" class="form-control mb-2" placeholder="Company Pan number ( X********Y )" />
                       <div class="icon-container">
                                   <i class="loader_input bp_check_loader" ></i>
                                   <i class="fa fa-check text-success bp_check" ></i> 
                                </div>
                            </div>
                            <label class="error" for="pan_number" generated="true"></label>
                    </div>

                  
                    <div class="col-12">
                    	<div class="row" id="member_info">
                    		<div class="col-md-6">
                        <input type="text" name="company_name" id="company_name" class="form-control mb-2" placeholder="Company Name" readonly="readonly" />
                    <label class="error" for="company_name" generated="true"></label>
                    
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="gst_number" id="gst_number" class="form-control mb-2" placeholder="GST No." readonly="readonly" />
                    <label class="error" for="gst_number" generated="true"></label>
                   
                    </div><div class="col-md-6">
                        <input type="text" name="address" id="address" class="form-control mb-2" placeholder="Company Address" readonly="readonly" />
                        <input type="hidden" name="address_id" id="address_id"  value="" />
                    <label class="error" for="address" generated="true"></label>
                   
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="city" id="city" class="form-control mb-2" placeholder="city" readonly="readonly" />
                    <label class="error" for="city" generated="true"></label>
                   
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="region" id="region" class="form-control mb-2" placeholder="Region/ State" readonly="readonly" />
                    <label class="error" for="region" generated="true"></label>
                   
                    </div>

                    
                   
                    
                     
                    <div class="col-md-6">
                        <input type="file" name="company_logo" id="company_logo" class="form-control mb-2" placeholder="company logo"  />
                        <i id="file_info">(Company logo :jpeg or png & upload max size 2MB)</i>
                    <label class="error" for="company_logo" generated="true"></label>
                   
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="person_name" id="person_name" class="form-control mb-2" placeholder="Contact Person Name"  />
                        
                    <label class="error" for="person_name" generated="true"></label>
                   
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="person_email_id" id="person_email_id" class="form-control mb-2" placeholder="Contact Person Email id"  />
                       
                    <label class="error" for="person_email_id" generated="true"></label>
                   
                    </div>
                     <div class="col-md-6">
                        <input type="text" name="person_mobile_number" id="person_mobile_number" class="form-control mb-2" placeholder="Contact Person Mobile Number (10 Digit Only)"  />
                        
                    <label class="error" for="person_mobile_number" generated="true"></label>
                   
                    </div>
                    <div class="col-md-6">
                    	<label class="d-block">
                    		Select Language 
                    	</label>
                        <?php 
                            $sql_lang = "SELECT * FROM promo_video_language_master WHERE status='1'";
                            $result_lang = $conn->query($sql_lang);
                            while($row_lang = $result_lang->fetch_assoc()){
                        ?>
                        <label ><input type="checkbox" name="vid_language[]"  value="<?php echo $row_lang['id'];?>" class="mr-2 vid_language"><?php echo $row_lang['language'];?></label>
                        <?php  } ?>
                       
                     
                    <label class="error d-block" for="vid_language" generated="true"></label>
                   
                    </div>
                    <div class="col-12">
                        <label class="error" for="common_error" generated="true"></label>
                        <div id="demo_video_links">
                            
                        </div>
                    </div>
                    
                    


                    
                    <div class="col-12 payment_calculation ">
                        
                            <p> Total Amount :-  <span id="promo_video_fees">2000</span> * <span id="number_of_videos">0</span> = <span id="final_amount">0000/-</span></p>
                        
                        
                        
                    </div>
                    <input type="hidden" name="action" value="promo-video-registration"/>
                    <div class="form-group col-12 mt-3" id="terms_condition_div">
                        	<label><input type="checkbox" name="agree_terms" value="yes" id="agree_terms"> Accept Terms And Condition</label>
                        	<div class="terms_condition_div w-100   p-2">
                        	 <ul class="inner_under_listing">Usage Terms & Conditions
                            <li>First cum first served basis</li>
		                     <li>The Films along with the images and content used in the Films should not be edited in any manner whatsoever.</li>
		                     <li>The proprietary and ownership rights and title on all the films shall vest only with GJEPC.</li>
		                     <li>The Films shall be used by Retailers only for promotional purposes for this festive season.</li>
		                     <li>The copies of the Films shall not be shared with any other entity or group companies, without prior written consent of GJEPC</li>
		                   	</ul>

                        	</div>
                        	<label for="agree_terms" generated="true" class="error"></label>
                        </div>
                    	</div>
                    </div>
                    
                    <div class="col">
                         <button type="submit" class="form-control text-center w-25 mt-2 d-table mx-auto" id="submit" value="Submit">Submit</button>
                    </div>
                  
                </div>
            </form>
        </div>
             <div class="col-12 mt-3">
             	<p class="gold_clr text-center mb-3"><strong>For Any Assistance, Contact </strong></p>
             	
             	<table class="responsive_table mb-3 ">
             		
             		<tbody>
             			<tr>
             				<td >Maharashtra & Goa Region</td>
             				<td>Ameya Chitnis at ameya.chitnis@gjepcindia.com  | 9987753842 <br>
                            Annu Pal at annu@gjepcindia.com | 7738098225 </td>
             				
             			</tr>
             			<tr>
             				
             				<td>Rajasthan Region</td>
             				<td>Ajay Purohit at ajaypurohit@gjepcindia.com | 9829381458 <br>
                               Anindya Panwar at  anindhya.panwar@gjepcindia.com | 9414069442
                            </td>
             			</tr>
             			<tr>
             				
             				<td>Gujarat Region</td>
             				<td>Malcom Sarkari at malcom@gjepcindia.com | 9427100648 <br>
                             Utsav Ansurkar  at  utsav.ansurkar@gjepcindia.com  | 9099086383 </td>
             			</tr>
             			<tr>
             				
             				<td>Southern Region </td>
             				<td>P anand at p.anand@gjepcindia.com | 8754423658 <br>
                              Vishnu Kumar at vishnu.kumar@gjepcindia.com | 9884988583
                            </td>
             			</tr>
             			
             			<tr>
             				<td >Eastern Region </td>
             				<td>Kaushik Ghosh at kaushik@gjepcindia.com  | 9836485163<br>
                              Partha Kajli at partha.kajli@gjepcindia.com | 9830131130</td>
             			
             			</tr>
             			
             			<tr>
             				<td>Northern Region  </td>
             				<td>Pranabes Hazra at pranabes@gjepcindia.com | 9958622977<br> 

                            Gunjan Lunia at gunjan.lunia@gjepcindia.com | 9871366625</td>
             		
             			</tr>
             		</tbody>
             		<tfoot>
             			<tr>
             				<td colspan="3" class="text-center"> Toll Free Number:1800-103-4353 <span><strong>&nbsp;&nbsp;|&nbsp;&nbsp;</strong></span> Missed Called Number: +91-7208048100</td>
             			</tr>
             		</tfoot>
             	</table>
             </div>
    </div>
</div>
</section>
<!-- <style type="text/css">
    .radio-box{border:1px solid#9e9457;width: 100%;padding: 6px 5px; border-radius: 5px;}
    .radio-box:hover{background: #9e9457;border:1px solid#9e9457;color:#000;}
    .radio-box input[type=radio]{margin-bottom: 6px }
    .radio-box-active{border:1px solid#7b702c;background: #9e9457;color: #000!important}
</style> -->
<?php include 'include-new/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.error').hide();
        $(".bp_check_loader").hide();
        $(".mobile_check_loader").hide();
        $(".lang_check_loader").hide();
        $(".bp_check").hide();
        $(".mobile_check").hide();
        $(".lang_check").hide();
       
        $('#vid_language').hide();
        $('.payment_calculation').hide();
        $('#terms_condition_div').hide();
        $('#member_info').hide();

       
   
       
        $("#bp_number").on("paste",function(){
          $("#bp_number").trigger("keyup");
        });
        $('.Number').keypress(function (event) {
            var keycode = event.which;
            if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                event.preventDefault();
            }
        });
       
    
          $("#pan_number").keyup(function(){
        $(".pan_check").hide();
        var pan_number = $(this).val();
        var action = "get_details_from_pan_number";
        $.ajax({
        type:'POST',
        data:{pan_number:pan_number,action:action},
        url:"webinarAction.php",
        dataType: "json",
        beforeSend: function() {
        $(".pan_check_loader").show();
        },
        success: function(result) { 
            $(".bp_check_loader").hide();
            if(result.status=="error-single"){
               // $('#submit').attr('disabled', false);
                $("label[for='"+result.label+"']").show();
                $("label[for='"+result.label+"']").text(result.message);
               
                $('#vid_language').hide();
                $('#company_name').val("");
                $('#gst_number').val("");
                $('#address').val("");
                $('#address_id').val("");
                $('#city').val("");
                $('#region').val("");
                $('#member_info').slideUp();
                
                 
            }else if(result.status=="success"){
                
                $('#company_name').val(result.data.company_name);
                $('#gst_number').val(result.data.gst_number);
                $('#address').val(result.data.address);
                $('#address_id').val(result.data.address_id);
                $('#city').val(result.data.city);
                $('#region').val(result.data.state);
                $('#vid_language').show();
                $('.error').hide();
                $('#member_info').slideDown();
                
            
            }
            
        
        }
        });

        });

        $(".vid_language").on("change",function(){
        $(".error").html("");

        var formdata = $("#promo-video-registration").serializeArray();
      
        formdata.push({ name: "action", value: "fetch_videos" });

        
        $.ajax({
        type:'POST',
        data: formdata,
        url:"webinarAction.php",
        dataType: "json",
        beforeSend: function() {
        $(".lang_check_loader").show();
        },
        success: function(result) { 
        $(".lang_check_loader").hide();

           if(result.status=="success"){

                $("#demo_video_links").show();
                $("#demo_video_links").html(result.output);
                $('.payment_calculation').show();
                $('#terms_condition_div').show();
           }else if(result.status=="error-single"){
                $("label[for='"+result.label+"']").show();
                $("label[for='"+result.label+"']").text(result.message);
                $("input[name='"+result.label+"']").focus();
                $("#demo_video_links").html("");
           }else{
                 $("#demo_video_links").html("");
           }
            
        
        }
        });


        });
           
           
           $(document).on("change",".occasion", function(){
            $(".payment_calculation ").show();
            var occasionInput = $('input[name="occasion[]"]');
               var countCheckedCheckboxes = occasionInput.filter(':checked').length;
               $("#number_of_videos").text(countCheckedCheckboxes);
               var finalAmount = countCheckedCheckboxes*2000;
               $("#final_amount").text(finalAmount+"/-");
               if(finalAmount >0){
                
            }
               
               
           });
           

        /*
        ** WEBINAR REGISTRATION FORM SUBMIT SCRIPT
        */
        $("#promo-video-registration").on("submit",function(e){
        e.preventDefault();
        $(".error").html("");
        var form = $('#promo-video-registration');
          var formdata = false;

          if (window.FormData){
              formdata = new FormData(form[0]);
          }
        $.ajax({
        type:'POST',
        data:formdata ? formdata : form.serialize(),
        url:"webinarAction.php",
        dataType: "json",
        cache:false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#preloader").show();
            $("#status").show();
        // $('#submit').attr('disabled', 'disabled');
        },
        success: function(result) { 
        
         // $('#submit').attr('disabled', false);
            if(result.status =="success"){
            // alert(result.redirectUrl);
             fbq('track', 'Dhanteras_Submit'); 
         
            window.location.href=result.redirectUrl;          
            }else if(result.status=="error-single"){
                $("#preloader").fadeOut();
                $("#status").fadeOut();
                $("label[for='"+result.label+"']").show();
                $("label[for='"+result.label+"']").text(result.message);
                $("input[name='"+result.label+"']").focus();

            }else{
                $("#preloader").fadeOut();
                $("#status").fadeOut();

            $.each(result, function(i, v) {
            $("label[for='"+v.label+"']").show();
            $("label[for='"+v.label+"']").html(v.msg);
                            
            });
            }
    
        }
        });

              });

    });
</script>
<style type="text/css">
	.terms_condition_div{ /*height: 100px; background: #eaeaea; overflow-y: scroll;*/ border:1px solid #a59459; }
    .payment_calculation p span,.payment_calculation p{font-size: 21px;font-weight: bold;}
    @media only screen and (max-width: 760px), (max-device-width: 991px) and (min-device-width: 768px){
     .responsive_table td {
        padding-left: 10px;
     }
    }
</style>


