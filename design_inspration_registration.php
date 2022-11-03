<?php 
include 'include/header.php';
include 'db.inc.php';
include 'functions.php';
?>


<?php 
$action=$_REQUEST['action'];
if($action=="save")
{

  if($_REQUEST['optradio']=="member")
{
   $category = "GJEPC Members";
    $fees ="2360";
}elseif($_REQUEST['optradio']=="non_member"){
   $category = "Non Members";
    $fees ="2950";
}elseif($_REQUEST['optradio']=="student"){
   $category = "Student";
   $fees ="1180";
}elseif($_REQUEST['optradio']=="other_student"){
    $category = "Outstation Students";
    $fees ="590";
}
  /* print_r($_POST); exit;*/
   $created_date=date('Y-m-d');
   $participant_name=$_REQUEST['participant_name'] ;
   $company_name=$_REQUEST['company_name'] ;
   $email_id=$_REQUEST['email_id'] ;
   $membership_no=$_REQUEST['membership_no'] ;
   $tel_no= $_REQUEST['tel_no'];
   $mobile_no=$_REQUEST['mobile_no'] ;
   $address= $_REQUEST['address'];
   $website=$_REQUEST['website'] ;
   $contact_person= $_REQUEST['contact_person'];
   $designation=$_REQUEST['designation'] ;
   
   $ip=$_SERVER['REMOTE_ADDR'];
   
    $insert = "insert into design_inspiration set created_date='$created_date',participant_name='$participant_name',company_name='$company_name', email_id='$email_id',membership_no='$membership_no',tel_no='$tel_no',mobile_no='$mobile_no',address='$address',website='$website',contact_person='$contact_person',designation='$designation',category='$category',fees='$fees',ip='$ip'"; 
	
  if($inserted=mysql_query($insert,$dbconn)){
  	$_SESSION['succ_msg']="You have been successfully registered";
  }else{
  	$_SESSION['err_msg']="There is some technical problem";
  }
}
?>

<section class="inner_container">

    <div class="container-fluid">
    
        <div class="row justify-content-center grey_title_bg">
            <div class="innerpg_title_center"><h1> Design Inspirations Registration 2020 </h1></div>
            
        </div>
        
    </div>
    
	<div class="container p-0">
    
    	<div class="row justify-content-center">    	
        	
            
       
            <form class="cmxform col-12 box-shadow mb-5" method="POST" name="regisForm" id="regisForm" autocomplete="off">	
            	
                <?php 
				if($_SESSION['err_msg']!=""){
				echo "<span style='color: red;'>".$_SESSION['err_msg']."</span>";
				$_SESSION['err_msg']="";
				}
				if($_SESSION['succ_msg']!=""){
				echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
				$_SESSION['succ_msg']="";
				}
				else{
            	?>
          		<div class="row mb-4">
                
               
                
                <div class="form-group col-sm-6"> 
                	<label> Participant's Name </label>
                    <input type="text" name="participant_name" id="participant_name" autocomplete="off" class="form-control"/>
                </div>
                
                <div class="form-group col-sm-6"> 
                	<label> Participant's Name of Firm/Institute(if any) </label>  
                    <input type="text" name="company_name" id="company_name" autocomplete="off" class="form-control"/>
                </div>
                
                
                <div class="form-group col-sm-6"> 
                	<label>Council's Membership No. (2019-20) (Not applicable to Non-members)   </label>  
                    <input type="text" name="membership_no" id="membership_no" autocomplete="off" class="form-control"/>
                </div>
                
                <div class="form-group col-sm-6"> 
                	<label> E-mail Address  </label>  
                    <input type="text" name="email_id" id="email_id" autocomplete="off" class="form-control" />
                </div>
                
                
                
                <div class="form-group col-sm-6"> 
                	<label> Tel. No. (with area code) </label>  
                    <input type="text" name="tel_no" id="tel_no" autocomplete="off" class="form-control"/>
                </div>
                
                <div class="form-group col-sm-6 "> 
                	<label> Mobile No. </label>  
                    <input type="text" name="mobile_no" id="mobile_no" autocomplete="off" maxlength="10" class="form-control"/>
                </div>                
                
                <div class="form-group col-12"> 
                	<label> Full Office Address (for correspondence)</label>  
                    <textarea name="address" id="address" autocomplete="off" class="form-control"> </textarea>
                </div>
				
                <div class="form-group col-sm-6"> 
                	<label> Website of Firm/Company   </label>  
                    <input type="text" name="website" id="website" autocomplete="off" class="form-control"/>
                </div>
                
               
                
                <div class="form-group col-sm-6"> 
                	<label> Name of the Contact Person</label>  
                    <input type="text" name="contact_person" id="contact_person" autocomplete="off" class="form-control"/>
                </div>
				
				<div class="form-group col-sm-6 "> 
                	<label>Designation  </label>  
                    <input type="text" name="designation" id="designation" autocomplete="off" class="form-control"/>
                </div>
                
                 <div class="form-group col-sm-6 "> 
                	<label> GST Registration details (To be provided by Non-members)   </label>  
                    <input type="text" name="website" id="website" autocomplete="off" class="form-control"/>
                </div>
                
                <div class="form-group col-12 "> 
                	<label>A brief about business (To be provided by Non-members) </label>  
                    <textarea name="business" id="about_business" autocomplete="off" class="form-control"> </textarea>
                </div>
                
                
                
                </div>
                
                <div class="row mb-4">
                
                <div class="form-group col-12 mb-4"> 
                	<p class="blue">Participation Fees</p>
                </div>
                
                <div class="form-group col-12">                 
               		
                    <table class="mt-0">  
                    	
                        <thead>
                        				
                            <tr>
                                <th>Sr No.</th>
                                <th>Category</th>
                                <th>Category Fee (Rs.)*</th>
                                <th>Category Fee (Rs.) <br /> with service tax </th>
                                <th width="20%">Category Opted <br /> (Please tick as applicable)</th>
                            </tr> 
                        
                        </thead>
                        
                        <tbody>
                         					
                            <tr>
                                <td data-column="Sr No." align="center">1</td>
                                <td data-column="Category">GJEPC Members</td>
                                <td data-column="Category Fee (Rs.)*">2,000/-</td>
                                <td data-column="Category Fee (Rs.) with service tax ">2,360/</td>
                                <td data-column="Category Opted (Please tick as applicable)"><input type="checkbox"  name="optradio" value="member"/> </td>
                            </tr>
                            
                            <tr>
                                <td data-column="Sr No." align="center">&nbsp;</td>
                                <td data-column="Category">Non Members</td>
                                <td data-column="Category Fee (Rs.)*" >2,500/-</td>
                                <td data-column="Category Fee (Rs.) with service tax ">2,950/</td>
                                <td data-column="Category Opted (Please tick as applicable)"><input type="checkbox"  name="optradio" value="non_member" /> </td>
                            </tr>
                                         
                            <tr>
                                <td data-column="Sr No." align="center">2</td>
                                <td data-column="Category">Student (current student)</td>
                                <td data-column="Category Fee (Rs.)*">1,000/- (reference letter from the Institute)**</td>
                                <td data-column="Category Fee (Rs.) with service tax ">1,180/-</td>
                                <td data-column="Category Opted (Please tick as applicable)"><input type="checkbox"  name="optradio" value="student" /> </td>
                            </tr>                    
                      
                            <tr>
                                <td data-column="Sr No." align="center">3</td>
                                <td data-column="Category">IIGJ Mumbai Student <br />(Students of 2019 & 2020 Batch)</td>
                                <td data-column="Category Fee (Rs.)*">1,000/-(reference letter from the Institute required) **</td>
                                <td data-column="Category Fee (Rs.) with service tax ">1,180/-</td>                        
                                <td data-column="Category Opted (Please tick as applicable)"> <input type="checkbox"  name="optradio" value="other_student" /> </td>
                            </tr>
                            
                            <tr>
                                <td data-column="Sr No." align="center">4</td>
                                <td data-column="Category">Outstation Students <br /> (IIGJ & other institutes)</td>
                                <td data-column="Category Fee (Rs.)*" >500/- (reference letter from the Institute required) ***</td>
                                <td data-column="Category Fee (Rs.) with service tax ">590/-</td>                        
                                <td data-column="Category Opted (Please tick as applicable)"> <input type="checkbox"  name="optradio" value="other_student" /> </td>
                            </tr>
                        
                        </tbody>
				
                	</table>

				</div>
                
				<p>** (reference letter from the Institute)</p> 
                <p>***(reference letter from the Institute required)</p>
                
                <div class="col-12"> 
                	<button  type="submit" class="cta fade_anim" id="submit"> Submit</button>
                  	<input type="hidden" name="action" value="save" />
                </div>
                
                </div>
                
            </form>    
            
            	<?php }?>   
                  
        </div> 
               
	</div>

</section>

<?php include 'include/footer.php'; ?>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$("#regisForm").validate({
		rules: {
			participant_name: {
				required: true,
			},
			company_name: {
				required: true,
			},
			email_id: {
				required: true,
				email:true
			},
			membership_no: {
				required: true,
			},
			tel_no: {
				required: true,
				number:true
			}, 
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			address: {
				required: true,
			}, 	 
			contact_person: {
				required: true,
			},
			designation: {
				required: true,
			},
      optradio: {
        required: true,
      },
		},
		messages: {
			participant_name: {
				required: "Participant Name is Required",
			}, 
			company_name: {
				required: "Please Enter Company Name",
			},  
			email_id: {
				required: "Please Enter Email Id",
			},
			membership_no: {
				required: "Please Enter Membership No",
			},
			tel_no: {
				required: "Please Enter Telephone Number",
				number: "Please Enter Numbers only"
			},
			mobile_no: {
				required: "Please Enter Mobile Number",
				number: "Please Enter Numbers only",
				minlength: "Please Enter at least {10} digit.",
				maxlength: "Please Enter no more than {0} digit."
			},   
			address: {
				required: "Please Enter Your Address",
			},  
			contact_person: {
				required: "Please Enter Contact Person Name",
			},
			designation: {
				required: "Please Enter Contact Person Designation",
			},
      optradio: {
        required: "Category Opted (Please tick as applicable)",
      },
	 }
	});
});
</script>