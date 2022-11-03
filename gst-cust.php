<?php 
$pageTitle = "Gem & Jewellery |Customer GST Form - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php include 'include-new/header.php'; ?>
<?php
include 'db.inc.php';
$action=$_REQUEST['action'];
if($action=="save")
{
//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
$member_code=filter($_REQUEST['member_code']);
$mem_company_name=filter($_REQUEST['mem_company_name']);
$person_name=filter($_REQUEST['person_name']);
$email_id=filter($_REQUEST['email_id']);
$mobile=filter($_REQUEST['mobile']);
$subject=filter($_REQUEST['subject']);
$query=filter($_REQUEST['query']);
$ip = $_SERVER['REMOTE_ADDR'];

$sql1="INSERT INTO gst_cust set member_code='$member_code',mem_company_name='$mem_company_name',person_name='$person_name',mobile='$mobile',email_id='$email_id',subject='$subject',query='$query',post_date=NOW(),ip='$ip'";
$result=mysql_query($sql1);
$_SESSION['succ_msg']="Information saved successfully";


/********************** Send Mail *****************/
$to  =  "";
$subject=filter($_REQUEST['subject']);
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
    <td align="left" style="text-align:justify;"> Feedback on Customer GST </td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Member Code :</strong> '. $member_code .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Member Company Name :</strong> '. $mem_company_name .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Contact Person Name :</strong> '. $person_name .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Email Id :</strong> '. $email_id .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Mobile Number :</strong> '. $mobile .'</td>
  </tr>
  <tr>
    <td align="left"  style="text-align:justify;"><strong>Description :</strong> '. $query .' </td>
  </tr>
   <tr>
  <td>&nbsp; </td>
    </tr>
    
</table>'; 
				
				$headers = 'From:GJEPC GST Feedback <do-not-reply@gjepc.org>' . "\n";
				$headers .= "MIME-Version: 1.0" . "\n";
   				$headers .= "Content-type:text/html;charset=UTF-8" . "\n"; 

			  mail($to, $subject, $message, $headers);

	if($result){
	$member_code="";	$mem_company_name="";	$person_name="";	$email_id="";
	$mobile="";	$subject="";	$query=""; 
	}
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>



<section class="my-5">
	
    <div class="container-fluid inner_container">
    
    	<div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div>Customer GST Form
 </div>

		<div class="container p-0">
			
            <div class="row justify-content-center mb-5">
            
<?php 
if($_SESSION['succ_msg']!=""){
echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
$_SESSION['succ_msg']="";
}
if($_SESSION['err_msg']!=""){
echo "<div class='alert alert-danger' role='alert'>".$_SESSION['err_msg']."</div>";
$_SESSION['err_msg']="";
}
?>

                <form class="cmxform col-lg-5 box-shadow" method="post" name="infoForm" id="infoForm">
                	<input type="hidden" name="action" value="save">
               		<?php token(); ?>	
                    <div class="row">
                    
                        <div class="form-group col-12">
                            <input type="text" class="form-control" value="<?php echo $member_code;?>" name="member_code" id="member_code" placeholder="Member Code" maxlength="30">
                         </div>
                         		
                        <div class="form-group col-12">
                            
                            <input type="text" class="form-control" value="<?php echo $mem_company_name;?>" name="mem_company_name" id="mem_company_name" placeholder="Company Name" maxlength="40">
                            
                        </div>	
                        		
                        <div class="form-group col-12">
                            
                            <input type="text" class="form-control" value="<?php echo $person_name;?>" name="person_name" id="person_name" placeholder="Contact Person" maxlength="30">
                          
                        </div>
                        
                        <div class="form-group col-12">
                            <input type="text" class="form-control" value="<?php echo $email_id;?>" name="email_id" id="email_id" placeholder="E-Mail ID">
                            
                        </div>
                        			
                        <div class="form-group col-12">
                            <input type="text" class="form-control" value="<?php echo $mobile;?>" name="mobile" id="mobile" placeholder="Mobile Number">
                        </div>
                     
                        <div class="form-group col-12">
                           
                            <select name="subject" id="subject" class="form-control">
                                <option value="">--- Select Subject ---</option>
                                <option value="GST Query">GST Query</option>				
                            </select>
                            
                        </div>
                        			
                        <div class="form-group col-12">
                          
                            <textarea style="width:100%; height:100px;" name="query" id="query" class="form-control">Description of Query</textarea>
                          
                        </div>	
                        							                        
                        <div class="form-group col-12">
                           
                            <input type="submit" class="cta fade_anim" name="submit" value="Submit"/>
                        </div>
                     </div>
				</form>
            
 			</div>
            
		</div>
    </div>

</section>

<?php include 'include-new/footer.php'; ?>


<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 

<script type="text/javascript">
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
			member_code:{
				required: true,
				specialChrs: true
			},  
			mem_company_name:{
				required: true,
				specialChrs: true
			},
			person_name:{
				required: true,
				specialChrs: true
			},
			email_id:{
			    required: true,
				email: true,				
			},
			mobile:{
			    required: true,
				number: true,
				minlength: 10,
				maxlength:10
			},
			subject:{
			    required: true,
			},
			query: {
				required: true,
				specialChrs: true
			},			
		},
		messages: {
			member_code: {
				required: "Please Enter Member's Code",
			},  
			mem_company_name: {
				required: "Please Enter Member Company Name",
			}, 
			person_name: {
				required: "Please Enter Contact Person Name",
			},
			email_id: {
				required: "Please Enter Email Id",
				remail: "Please Enter valid Email Id",
			},
			mobile: {
				required: "Please Enter Mobile Number",
				number: "Please Enter Number only",
			},
			subject: {
				required: "Please Enter Subject",
			},			
			query: {
				required: "Please Enter Decription",
			},		
		}
	});
});
</script>