<?php 
include 'include/header.php';
include 'db.inc.php';
include 'functions.php';
?>

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
}?>
<div class="col-xs-12 wrapper di_reg">
	<div class="title"> <h4>Design Inspirations Registration</h4> </div>
	<div class="content">
        <div class="di_reg_form">     	
            <div class="di_subtitle">
                <h5>Kindly fill the following information to nominate yourself for the PREVIEW DAY – 8thAugust, 2019 by invitation </h5>
                <p>Kindly note that the selection/invitation will be based on the criteria set by the management. The database provided to GJEPC will be highly confidential and will solely be used for the promotion of GJEPC events only.</p>
            </div>
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
            <form class="row" method="POST" name="regisForm" id="regisForm" autocomplete="off">	
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Name of Retail Showroom* :   </label>  
                    <input type="text" name="retail_showroom" id="retail_showroom" autocomplete="off" class="input_style"/>
                </div>
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Name of Owner/ Partner / Director* :   </label>  
                    <input type="text" name="owner" id="owner" autocomplete="off" class="input_style" />
                </div>
                
                <div class="col-xs-12 col-md-12 form-group"> 
                	<label> Showroom Address : </label>  
                    <input type="text" name="showroom_address" id="showroom_address" autocomplete="off" class="input_style"/>
                </div>
                
                  
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label>Mobile No of Owner/ Partner / Director *: </label>  
                    <input type="text" name="mobile" id="mobile" autocomplete="off" class="input_style"/>
                </div>
                
                   <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Email Id*:    </label>  
                    <input type="text" name="email" id="email" autocomplete="off" class="input_style"/>
                </div>
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Name of Secretariat Person*:  </label>  
                    <input type="text" name="secretariat_name" id="secretariat_name" autocomplete="off" maxlength="10" class="input_style"/>
                </div>                
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Designation :</label>  
                    <input type="text" name="designation" id="designation" autocomplete="off" class="input_style"/>
                </div>
				
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Mobile No* :   </label>  
                    <input type="text" name="mob_no" id="mob_no" autocomplete="off" class="input_style"/>
                </div>
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Email Id* :</label>  
                    <input type="text" name="email_id" id="email_id" autocomplete="off" class="input_style"/>
                </div>
				
				<!--<div class="col-xs-12 col-md-6 form-group"> 
                	<label>Designation  </label>  
                    <input type="text" name="designation" id="designation" autocomplete="off" class="input_style"/>
                </div>-->
                
                <h5>Kindly submit your KYC details below*and attach company GST / Gomastha Certificate, Company Pan Card for verification purpose only.</h5>
                
                <div class="col-xs-12 col-md-12 form-group">                 
                <table class="rwd-table">  					
                    <tr>
    					<th width="50">Sr No.</th>
    					<th class="smallTh">Showroom branch in which city</th>
    					<th >Showroom Address</th>
    					<th class="smallTh">Area of Showroom in (Sqft)</th>
    					<th class="smallTh">No of Employees/ Per Showroom</th>
                        <th class="smallTh">Year of Establishment </th>
					</tr>  					
                    <tr>
    					<td data-th="Sr No.">1</td>
    					<td data-th="Showroom branch in which city"><input type="text"></td>
    					<td data-th="Showroom Address"><input type="text"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text"></td>
                        <td data-th="No of Employees/ Per Showroom"><input type="text"></td>
                        <td data-th="Year of Establishment"><input type="text"></td>
  					</tr>
                    
                    <tr>
    					<td data-th="Sr No.">2</td>
    					<td data-th="Showroom branch in which city"><input type="text"></td>
    					<td data-th="Showroom Address"><input type="text"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text"></td>
                        <td data-th="No of Employees/ Per Showroom"><input type="text"></td>
                        <td data-th="Year of Establishment"><input type="text"></td>
  					</tr>
                    
                    <tr>
    					<td data-th="Sr No.">3</td>
    					<td data-th="Showroom branch in which city"><input type="text"></td>
    					<td data-th="Showroom Address"><input type="text"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text"></td>
                        <td data-th="No of Employees/ Per Showroom"><input type="text"></td>
                        <td data-th="Year of Establishment"><input type="text"></td>
  					</tr>
  					
				
                </table>

</div>

				<div class="col-md-6 col-lg-4 browse form-group">
                <label>Company GST / Gomastha Certificate</label>
                <input type="file" value="">
                </div>
                
                <div class="col-md-6 col-lg-4 browse form-group">
                <label>Company Pan Card </label>
                <input type="file" value="">
                </div>
                
                <div class="clearfix"></div>
                
                <div class="col-xs-12">
                <p><strong>Please upload below document to fulfill preview day criteria:</strong></p> 
                </div>
                
                <div class="col-md-6 col-lg-4 browse form-group">
                <label>Picture of Store Frontage</label>
                <input type="file" value="">
                </div>
                
                <div class="col-md-6 col-lg-4 browse form-group">
                <label>Any promotional add</label>
                <input type="file" value="">
                </div>
                
                <div class="col-md-6 col-lg-4 browse form-group">
                <label>Social media coverage</label>
                <input type="file" value="">
                </div>
				
                
                <div class="col-xs-12"> 
				 <p>** (reference letter from the Institute)</p> 
                <!--<p>***(reference letter from the Institute required)</p>-->
                
                <p>(If you have more than five showroom branches, then kindly email us their details at <strong><a href="mailto:annu@gjepcindia.com">annu@gjepcindia.com</a>)</strong></p>
                
                <p>Please upload below document to fulfill preview day criteria:</p>
                
                </div>
                
                
                
                 <div class="col-xs-12 col-md-12 form-group"> 
                	<button  type="submit" class="submit" id="submit"> Submit</button>
                  <input type="hidden" name="action" value="save" />
                </div>
                
                <div class="clear"></div>               
            </form>    
            <?php }?>        
        </div>        
	</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="row mainRow">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="upcomingEvents">
		        <div class="title">
		          <h4>Upcoming Events</h4>
		        </div>
		        <?php include 'include/eventsslider.php'; ?>
	      </div>
		</div>
	</div>	
</div>

<?php include 'include/footer.php'; ?>

<style>		

.di_reg .title {margin-bottom:25px;}
.di_reg_form {background:#fff; width:100%; padding:15px;}
.di_subtitle {padding-bottom:15px; border-bottom:1px solid #ddd; margin-bottom:15px; }
.di_subtitle h5 {font-size:18px;}

.di_reg_form  .input_style {width:100%; padding:5px; border:1px solid #ddd;}
.di_reg_form label {width:100%; font-size:16px;}

.di_reg_form textarea{height:100px;}

.di_reg_form button.submit {background:#000; color:#fff; padding:10px 15px; border:0;}
.di_reg_form span {font-size:11px; font-style:italic;}

.rwd-table {
  margin: 1em 0;
  min-width: 300px;
}
.rwd-table tr {
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
.rwd-table th {
  display: none;
}

.rwd-table input[type="text"], .rwd-table input[type="number"]{
	width:100%;
	}

.browse label{
	font-size:14px; font-weight:bold;}
.browse input[type="file"]{
	border:1px solid #ccc; padding:8px;}


@media (min-width: 1000px) {
.rwd-table th.smallTh{
	width:150px;}

.rwd-table th.bigTh{
	width:350px;}
}

.rwd-table td {
  display: block;	
}
.rwd-table td:first-child {
  padding-top: 0.5em;
}
.rwd-table td:last-child {
  padding-bottom: 0.5em;
}
.rwd-table td:before {
  content: attr(data-th) ": ";
  font-weight: bold;
  /*width: 6.5em;*/
  display: inline-block;
}
@media (min-width: 600px) {
  .rwd-table td:before {
    display: none;
  }
}
.rwd-table th,
.rwd-table td {
  text-align: left;
}
@media (min-width: 600px) {
  .rwd-table th,
  .rwd-table td {
    display: table-cell;
    padding: 0.25em 0.5em;
	text-align:center;
  }
  .rwd-table th:first-child,
  .rwd-table td:first-child {
    padding-left: 0;
  }
  .rwd-table th:last-child,
  .rwd-table td:last-child {
    padding-right: 0;
  }
}
.rwd-table {
 overflow: hidden;
  width:100%;
}
.rwd-table tr {
  border-color: #ddd;
}
.rwd-table th,
.rwd-table td {
  margin: 0.5em 1em;
}
@media (min-width: 600px) {
  .rwd-table th,
  .rwd-table td {
    padding: 1em !important;
  }
  .rwd-table th,
.rwd-table td:before {
background:#ddd;}
}
</style> 