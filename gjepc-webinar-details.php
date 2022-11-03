<?php 
include('db.inc.php');
include('functions.php');
$pageTitle = "Gems And Jewellery Industry In India | Vision & Mission - GJEPC India";
$pageDescription  = "The Gem & Jewellery Export Promotion Council (GJEPC) was set up by the Ministry of Commerce, Government of India (GoI) in 1966. It was one of several Export Promotion Councils (EPCs) launched by the Indian Government";
?>
<?php include 'include-new/header.php'; ?>
<?php
$webinar_id = $_REQUEST['page'];
$sql = "SELECT * FROM webinar_master WHERE id='$webinar_id' ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$count = $result->num_rows;
if($count ==0){
   header("Location: gjepc-webinar.php");
}

$banner = stripslashes($row['banner']);
$title = stripslashes($row['title']);
$date = stripslashes($row['post_date']);
$time = stripslashes($row['start_time']);
$banner = stripslashes($row['banner']);
$description = stripslashes($row['description']);
$category = stripslashes($row['type']);

$current_date = strtotime(date("Y-m-d"));
$webinar_date = strtotime($date);
 ?>
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
			GJEPC Webinar</h1>
		</div>
	</div>

	<div class="row ab_none  justify-content-between mb-5">
    	<div class="col-12 col-md-8 pr-5 webnarDetails">
        	<div class="pic"><img src="assets/images/webinar/new/<?php echo $banner; ?>" class="img-fluid d-block mb-3"></div>
            
            <h2 class="webinarTitle mb-5"><?php echo $title;?></h2>
            
            <!-- <div class="mb-5">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
            
            <div class="subTitle mb-4">AGENDA :</div>
            
            <ul class="agendaPoints mb-5">
            	<li>Impact of Covid-19 on Jewellery in india and the rise of e-commerce.</li>
                <li>What is Global selling?</li>
                <li>Why Global selling during these uncertain times?</li>
                <li>Amazon Global Selling and its focus on MSME.</li>
                <li>How can the offline sellers be a part of Global Selling.</li>
            </ul> -->
            <div>
                <?php echo html_entity_decode($description);?>
            </div>
            <?php $sql_speakers ="SELECT * FROM webinar_speaker_details WHERE webinar_id ='$webinar_id' AND speaker_name !=''";

              $result_speakers = $conn->query($sql_speakers);
              $count_speakers = $result_speakers->num_rows;
            ?>
            <div class="webinarInfo">
            <div class="row ab_none justify-content-between mb-4">
                <div class="col">
                    <div class="speaker d-flex h-100">
                    <div class="align-self-center">
                    <div class="headT mb-2">SPEAKER :</div>
                    <?php if($count_speakers>0){
                        while ($row_speakers = $result_speakers->fetch_assoc()) {?>
                            <div class="speakerName"><?php echo $row_speakers['speaker_name'];?> <span>(<?php echo $row_speakers['speaker_designation'];?>)</span></div>
                      <?php   }
                    }?>
                   
                    
                    </div>
                    </div>
                </div>
                <div class="col pl-5">
                    <div class=" d-flex h-100">
                    <div class="align-self-center">
                    <div class="d-block webinarDay mb-2 goldBg"><?php echo date("l j M, Y ", strtotime($date));?></div>
                    <?php if($time !=""){?>
                         <div class="d-block webinarDay blackBg"> <?php echo  date("h:i A", strtotime($time));?></div>
                    <?php }?>
                   
                    </div>
                    </div>
                </div>
            </div>
            </div>
            
        </div>
        <?php if($webinar_date >= $current_date){?>
<div class="col-12 col-md-4 " >
            <form class="webinarRegister"   id="webinar-registration" >
                <h3>register</h3>
                <div class="form-group">
                    <!--  <label class="d-inline-block mr-3 radio-box" for="member">
                          <input type="radio" name="check_member" id="member" value="member" >Member</label> -->
                    <label><strong>Please Select Your member type</strong></label>
                    <label><input type="radio"  name="check_member" value="member" >&nbsp;Member </label>
                    <label><input type="radio"  name="check_member" value="non-member" >&nbsp;Non-Member </label>
                    <label><input type="radio"  name="check_member" value="student" >&nbsp;Student </label>
                    <label class="error" for="check_member" generated="true"></label>
                    <div class="inputcontainer">
                    <input type="text" name="bp_number" id="bp_number" class="form-control mb-2" placeholder="BP Number ( 7********* )" />
                       <div class="icon-container">
                                   <i class="loader_input bp_check_loader" ></i>
                                   <i class="fa fa-check text-success bp_check" ></i> 
                                </div>
                            </div>
                    <label class="error" for="bp_number" generated="true"></label>
                    <div class="inputcontainer">
                    <input type="text" name="mobile_no" id="mobile_no" class="form-control Number mb-2" placeholder="Mobile No." maxlength="10" />
                     <div class="icon-container">
                                   <i class="loader_input mobile_check_loader" ></i>
                                   <i class="fa fa-check text-success mobile_check" ></i> 
                                </div>
                            </div>
                    <label class="error" for="mobile_no" generated="true"></label>
                    <input type="text" name="name" id="name" class="form-control mb-2" placeholder="Name" />
                    <label class="error" for="name" generated="true"></label>
                    <input type="text" name="email_id" id="email_id" class="form-control mb-2" placeholder="Email" />
                    <label class="error" for="email_id" generated="true"></label>
                    
                    <input type="text" name="company_name" id="company_name" class="form-control mb-2" placeholder="Company Name" />
                    <label class="error" for="company_name" generated="true"></label>
                    <label class="error" for="common_error" generated="true"></label>


                    <input type="hidden" class="form-control mb-2" name="webinar_id" value="<?php echo base64_encode($webinar_id);?>" />
                    
                    <input type="hidden" name="action" value="check-data"/>

                    <button type="submit" class="form-control text-center " id="submit" value="Submit">Submit</button>
                </div>
            </form>
        </div>
        <?php }?>
        
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
        $(".bp_check").hide();
        $(".mobile_check").hide();
        $('#bp_number').hide();
        $('#name').hide();
        $('#email_id').hide();
        $('#mobile_no').hide();
        $('#company_name').hide();
        // $('input[type="radio"]').on("change",function(){
        // $('input[type="radio"]:not(:checked)').parent('label').removeClass("radio-box-active");
        // $('input[type="radio"]:checked').parent('label').addClass("radio-box-active");
        // });
        $('input[name="check_member"]').on("change",function(){
              $('.error').hide();
              $(".bp_check").hide();
              $(".mobile_check").hide();
            var value = $(this).val();
            if(value =="member"){
             $("#bp_number").trigger("keyup");
                $('#bp_number').slideDown("slow").focus();
                $('#mobile_no').hide();
              
            }else{
            $('#bp_number').hide();
             $('#mobile_no').val("").attr("disabled",false);
            $('#mobile_no').slideDown("slow").focus();
            $("#mobile_no").trigger("keyup");
        
            }
       
        });
        $("#mobile_no").on("paste",function(){
          $("#mobile_no").trigger("keyup");
        });
        $("#bp_number").on("paste",function(){
          $("#bp_number").trigger("keyup");
        });
        $('.Number').keypress(function (event) {
            var keycode = event.which;
            if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                event.preventDefault();
            }
        });
        $("#mobile_no").keyup(function(){
        $(".mobile_check").hide();
        var mobile_no = $(this).val();
        var action = "check_registered_webinar_user";
        $.ajax({
        type:'POST',
        data:{mobile_no:mobile_no,action:action},
        url:"webinarAction.php",
        dataType: "json",
        beforeSend: function() {
       $(".mobile_check_loader").show();
        },
        success: function(result) { 

            $(".mobile_check_loader").hide();
            if(result.isNew=="yes"){
                $(".error").hide();
                $('#name').show().val("").attr("disabled",false);
                $('#email_id').val("").show().attr("disabled",false);
                //$('#mobile_no').show().attr("disabled",false);
                $('#company_name').val("").show();
            }else if(result.isNew=="no"){
                $(".error").hide();
                $(".mobile_check").show();
                $('#name').show().val(result.name).attr("disabled",false);
                $('#email_id').show().val(result.email_id).attr("disabled",false);
                $('#company_name').show().val(result.company_name).attr("disabled",false);
            }else if(result.status=="error-single"){
                $('#name').hide();
                $('#email_id').hide();
                $('#company_name').hide();
                $("label[for='"+result.label+"']").show();
                $("label[for='"+result.label+"']").text(result.message);
                $("input[name='"+result.label+"']").focus();
            }else{
                $('#name').hide();
                $('#email_id').hide();
                $('#company_name').hide();
            }
        
        }
        });

        });
        $("#bp_number").keyup(function(){
        $(".bp_check").hide();
        var bp_number = $(this).val();
        var action = "check_member_from_bp_number";
        $.ajax({
        type:'POST',
        data:{bp_number:bp_number,action:action},
        url:"webinarAction.php",
        dataType: "json",
        beforeSend: function() {
        $(".bp_check_loader").show();
        },
        success: function(result) { 
            $(".bp_check_loader").hide();
            if(result.status=="error-single"){
               // $('#submit').attr('disabled', false);
                $("label[for='"+result.label+"']").show();
                $("label[for='"+result.label+"']").text(result.message);
                $('#name').hide();
                $('#email_id').hide();
                $('#mobile_no').hide();
                $('#company_name').hide();
                
            }else if(result.status=="success"){
                $(".bp_check").show();
                $(".error").hide();
                $('#name').show().val(result.name).attr('disabled',true);
                $('#email_id').show().val(result.email_id).attr('disabled',true);
                $('#mobile_no').show().val(result.mobile_no).attr('disabled',true);
                $('#company_name').show().val(result.company_name).attr('disabled',true);
            
            }
            
        
        }
        });

        });

        /*
        ** WEBINAR REGISTRATION FORM SUBMIT SCRIPT
        */
        $("#webinar-registration").on("submit",function(e){
        e.preventDefault();
        $(".error").html("");
        var formdata = $(this).serialize();
        $.ajax({
        type:'POST',
        data:formdata,
        url:"webinarAction.php",
        dataType: "json",
        beforeSend: function() {
            $("#preloader").show();
            $("#status").show();
        $('#submit').attr('disabled', 'disabled');
        },
        success: function(result) { 
        
         $('#submit').attr('disabled', false);
            if(result.status =="success"){
            // alert(result.redirectUrl);
         
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



