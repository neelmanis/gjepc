<?php 
include 'include/header.php';
include 'db.inc.php'; 
include 'functions.php';
?>

<?php
$id = filter(intval($_REQUEST['id']));
$sql="select * from `seminar_calendar` WHERE status='1' and id='$id'";
$result = $conn ->query($sql);
$num = $result->num_rows;
if($num > 0)
{
$rows = $result->fetch_assoc();
} else {
	$_SESSION['err_msg']="Something Wrong";
}
// print_r($rows);
$title = filter($rows['title']);
$to_email = filter($rows['region_email']);
?>

<?php
$action=$_REQUEST['action'];
if($action=="save")
{

//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {	

$name	=	filter($_REQUEST['name']);
$designation	=	filter($_REQUEST['designation']);
$organization	=	filter($_REQUEST['organization']);
$address		=	filter($_REQUEST['address']);
$pincode		=	filter($_REQUEST['pincode']);
$phone			=	filter($_REQUEST['phone']);
$email			=	filter($_REQUEST['email']);
$ip = $_SERVER['REMOTE_ADDR'];

/* Validation Start */
	if(empty($name)){
	$signup_error = "Please Enter Name";
	} else if(empty($designation)){
	$signup_error = "Please Enter Designation";
	} else if(empty($organization)){
	$signup_error = "Please Enter Organization";
	} else if(empty($address)){
	$signup_error = "Please Enter Address";
	} else if(empty($pincode)){
	$signup_error = "Please Enter Pincode";
	} else if(strlen($pincode)>6 || strlen($pincode)<6){
	$signup_error="Pincode should be 6 digits.";
	} else if(empty($email)){
	$signup_error = "Please Enter Email";
	} else if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
	$signup_error = "Please Enter Valid Email";	
	} else {
$sql1="INSERT INTO seminar_registration set name='$name',designation='$designation',organization='$organization',address='$address',pincode='$pincode',phone='$phone',
email='$email',event_title='$title',post_date=NOW()";
$result = $conn ->query($sql1);

$_SESSION['succ_msg']="Information saved successfully";

/********************** Send Mail *****************/
$to  =  $to_email;
$subject= "GJEPC AWARENESS CAMPAIGN SEMINARS";
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
	<td width="85%" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="105" height="91" /></td>         
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"> Feedback on GJEPC Awareness Campaign Seminars </td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Name :</strong> '. $name .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Designation :</strong> '. $designation .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Organization :</strong> '. $organization .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Address :</strong> '. $address .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Pin Code :</strong> '. $pincode .'</td>
  </tr>
  <tr>
    <td align="left"  style="text-align:justify;"><strong>Phone :</strong> '. $phone .' </td>
  </tr>
  <tr>
    <td align="left"  style="text-align:justify;"><strong>Email :</strong> '. $email .' </td>
  </tr>
   <tr>
  <td>&nbsp; </td>
    </tr>
    
</table>'; 
				
				$headers = 'From: GJEPC Seminars <do-not-reply@gjepc.org>' . "\n";
				$headers .= "MIME-Version: 1.0" . "\n";
   				$headers .= "Content-type:text/html;charset=UTF-8" . "\n"; 

			  mail($to, $subject, $message, $headers);

if($result)
{
	$name="";
	$designation="";
	$organization="";
	$address="";
	$pincode="";
	$phone="";
	$email="";
}
	} } else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>

<?php 
if($_SESSION['err_msg']!=""){
echo "<div class='alert alert-danger' role='alert'>".$_SESSION['err_msg']."</div>";
$_SESSION['err_msg']="";
}
if($_SESSION['succ_msg']!=""){
echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
$_SESSION['succ_msg']="";
}
?>
<?php if(isset($signup_error)){ echo "<div class='alert alert-danger' role='alert'>". $signup_error."</div>"; }?>

<section>	
    <div class="container-fluid inner_container">
		<div class="row justify-content-center grey_title_bg">   
        	
            	<div class="innerpg_title_center">
                	<h1>Registration Form</h1>
                </div>            
         </div>
                    
            <div class="container">				
                <div class="row justify-content-center">
				
<form class="cmxform col-12 box-shadow mb-5" method="post" name="infoForm" id="infoForm"  autocomplete="off">
<input type="hidden" name="action" value="save">
<?php token(); ?>

			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="Name">Name:<span style="color: red;"> *</span></label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo $name;?>" name="name" autocomplete="off" id="name" maxlength="30"/>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="designation">Designation:<span style="color: red;"> *</span></label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo $designation;?>" name="designation" id="designation" autocomplete="off" maxlength="15"/>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="organization">Organization: <span style="color: red;"> *</span></label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo $organization;?>" name="organization" id="organization" autocomplete="off"/>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="Address">Address: </label></div>
				<div class="col-md-6">
				<textarea class="form-control" name="address" id="address"><?php echo $address;?></textarea>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="pincode">Pin Code: </label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo $pincode;?>" name="pincode" id="pincode" maxlength="6" minlength="6" autocomplete="off"/>
			    </div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="person_name">Phone: <span style="color: red;"> *</span></label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo $phone;?>" name="phone" id="phone" maxlength="15" autocomplete="off">
			    </div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="person_name">E- Mail: <span style="color: red;"> *</span></label></div>
				<div class="col-md-6">
				<input type="text" class="form-control" value="<?php echo $email;?>" name="email" id="email" autocomplete="off"/>
			    </div>
			</div>
								                        
			<div class="form-group row">
				<div class="col-md-6">
				<label class="form-label" for="submit"></label></div>
				<div class="col-md-6">
				<input type="submit" class="btn btn-success" name="submit" value="Submit"/></div>
			</div>
			</form>
</div>    
	</div>    
    </div>
</section> 

<?php include 'include/footer.php'; ?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 

<!--<script type="text/javascript">
$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
	if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
   };
    },	"Special Characters Not Allowed");
	
	$("#infoForm").validate({
			//var member_id=$("#member_type_id").val();
		rules: {  
			name:{
				required: true,
				specialChrs: true
			},  
			designation:{
				required: true,
				specialChrs: true
			},
			organization:{
				required: true,
				specialChrs: true
			},
			address1:{
			    required: true,
				specialChrs: true				
			},
			pincode:{
			    required: true,
				number:true,
				minlength:6,
				maxlength:6
			},
			phone:{
			    required: true,
				number: true,
				minlength: 10,
				maxlength:10
			},
			email:{
			    required: true,
				email: true,
			},		
		},
		messages: {
			name: {
				required: "Please Enter Name",
			},  
			designation: {
				required: "Please Enter Designation",
			}, 
			organization: {
				required: "Please Enter Organization",
			},
			address1: {
				required: "Please Enter Address",
			},
			pincode: {
				required: "Please Enter your pin code",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 6 characters",
				maxlength:"Please Enter not more than 6 characters"	
			},
			phone: {
				required: "Please Enter Contact Number",
			},
			email: {
				required: "Please Enter Email Id",
				remail: "Please Enter valid Email Id",
			},	
		}
	});
});
</script>-->
