<?php 
include 'include/header.php'; 
include 'db.inc.php';
include 'functions.php';
if(!isset($_SESSION['artisan_eligable'])){header('location:artisan_registration_apply.php');}
?>
<?php
$action=$_REQUEST['action'];
if($action=="save")
{
	$company_name=strtoupper($_REQUEST['company_name']);
	$email_id=$_REQUEST['email_id'];
	$contact_no=$_REQUEST['contact_no'];
	$stall_no=$_REQUEST['stall_no'];

	$awards=$_REQUEST['awards'];

	foreach($awards as $val)
	{
		$awards.=$val.",";	
	}
	$dt=date('Y-m-d');
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$query=mysql_query("select * from artisan_award_application_2019 where email_id='$email_id'");
	$num=mysql_num_rows($query);
	if($num>0)
	{	
		$_SESSION['err_msg']="Already registered with this Email id";
	}
   else
   {
	$sql="insert into artisan_award_application_2019 set company_name='$company_name',email_id='$email_id',contact_no='$contact_no',stall_no='$stall_no',awards='$awards',created_date='$dt',ip='$ip'";
		if(mysql_query($sql)){
		/*.......................................Send mail to users mail id...............................................*/
		$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
	  <tr>
		<td colspan="2"> 
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
		<td width="85%" align="left"><img src="http://gjepc.org/images/gjepc_logo.png" width="105" height="91" /></td>         
			</tr>
		  </table>    </td>
	  </tr>
	  <tr>
		<td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
	  </tr>
	  <tr>
		<td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear '. $company_name.',</td>
	  </tr>
	  <tr>
		<td align="left" style="text-align:justify;"> Thank you for registering for ARTISAN AWARDS.
	</td>
	  </tr>
	  <tr>
		<td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
	  </tr>
	  <tr>
		<td align="left"><strong>GJEPC Web Team,</strong></td>
	  </tr>  
	</table>';
	  
		 $to =$email_id;
		 //$to ="mukesh@kwebmaker.com";
		 $subject = "New User Registration"; 
		 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
		 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		 $headers .= 'From:admin@gjepc.org';			
		 mail($to, $subject, $message, $headers);
		 $_SESSION['succ_msg']="You have been successfully registered";
		 }
		 else{
		 $_SESSION['err_msg']="There is some technical problem";
		 }
	}
}
?>
    <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
    <script type="text/javascript">
$().ready(function() {
	$("#regisForm").validate({
		rules: {  
			company_name: {
				required: true,
			},  
			email_id: {
				required: true,
				email:true
			},  
			contact_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			stall_no: {
				required: true,
			}, 	 
			awards: {
				required: true,
				},
		},
		messages: {
			company_name: {
				required: "Company Name is Required",
			},  
			email_id: {
				required: "Company Email Id is Required",
			},
			contact_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},   
			stall_no: {
				required: "Please Enter Your Stall Number",
			},  
			awards: {
				required: "Please Select Alteast Select Any Ane Category",
			}
	 }
	});
});

function isNumberKey(){
length=$(":checkbox:checked").length;
if(length>1){
		alert("Sorry You can select only 1 categories");
		$("#submit").attr("disabled", 'disabled');
	}
else
	$("#submit").removeAttr('disabled');
 
}
</script>
    <div class="col-xs-12 wrapper di_reg">
      <div class="title">
        <h4>Artisan Awards Registration</h4>
      </div>
      <div class="content">
        <div class="di_reg_form">
          <div class="di_subtitle">
            <h5>Application For Participation In Artisan Awards </h5>
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
          <form class="cmxform row" method="post" name="regisForm" id="regisForm" autocomplete="off">
            <input type="hidden" name="action" value="save" />
            <div class="col-xs-12 col-md-4 form-group">
              <label> Company Name: </label>
              <input type="text" class="input_style" name="company_name" id="company_name"/>
            </div>
            <div class="col-xs-12 col-md-4 form-group">
              <label> Email Id </label>
              <input type="text" class="input_style" name="email_id" id="email_id"/>
            </div>
            <div class="col-xs-12 col-md-4 form-group">
              <label> Contact No. </label>
              <input type="text" class="input_style" name="contact_no" id="contact_no"/>
            </div>
            <div class="col-xs-12 col-md-4 form-group">
              <label> Stall No. </label>
              <input type="text" class="input_style" name="stall_no" id="stall_no"/>
            </div>
            <div class="col-xs-12 col-md-12 form-group">
              <h2 style="border-bottom:1px solid #ddd; padding-bottom:15px;">Participation Category (Select any one Category. Max 2 pieces allowed within the participating category):</h2>
            </div>
            <div class="col-md-3  form-group radio_group">
              <input type="checkbox" name="awards[]" value="Daily Wear Diamond Jewellery"  onClick="isNumberKey()">
              <label for="Daily Wear Diamond Jewellery">Daily Wear Diamond Jewellery</label>
            </div>
            <div class="col-md-3  form-group radio_group">
              <input type="checkbox" name="awards[]" value="Couture Diamond Jewellery" onClick="isNumberKey()">
              <label for="Couture Diamond Jewellery">Couture Diamond Jewellery</label>
            </div>
            <div class="col-md-3  form-group radio_group">
              <input type="checkbox" name="awards[]" value="Plain Gold Jewellery" onClick="isNumberKey()">
              <label for="Plain Gold Jewellery">Plain Gold Jewellery</label>
            </div>
            <div class="col-md-3  form-group radio_group">
              <input type="checkbox" name="awards[]" value="Silver Jewellery"onClick="isNumberKey()">
              <label for="Silver Jewellery">Silver Jewellery</label>
            </div>
            <div class="col-md-3  form-group radio_group">
              <input type="checkbox" name="awards[]" value="Platinum Jewellery" onClick="isNumberKey()">
              <label for="Platinum Jewellery">Platinum Jewellery</label>
            </div>
            <div class="col-md-3  form-group radio_group">
              <input type="checkbox" name="awards[]" value="Coloured Gemstones Jewellery" onClick="isNumberKey()">
              <label for="Coloured Gemstones Jewellery">Coloured Gemstones Jewellery</label>
            </div>
            <div class="col-md-3  form-group radio_group">
              <input type="checkbox" name="awards[]" value="Kundan Meena Jewellery" onClick="isNumberKey()">
              <label for="Kundan Meena Jewellery">Kundan Meena Jewellery</label>
            </div>
            <div class="col-md-3  form-group radio_group">
              <input type="checkbox" name="awards[]" value="Pearl Jewellery" onClick="isNumberKey()">
              <label for="Pearl Jewellery">Pearl Jewellery</label>
            </div>
            <div class="col-xs-12 col-md-12 form-group">
              <button class="submit" id="submit"> Submit</button>
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
.di_reg .title {
	margin-bottom:25px;
}
.di_reg_form {
	background:#fff;
	width:100%;
	padding:15px;
}
.di_subtitle {
	padding-bottom:15px;
	border-bottom:1px solid #ddd;
	margin-bottom:15px;
}
.di_subtitle h5 {
	font-size:18px;
}
.di_reg_form .input_style {
	width:100%;
	padding:5px;
	border:1px solid #ddd;
}
.di_reg_form label {
	width:100%;
	font-size:16px;
}
.di_reg_form textarea {
	height:100px;
}
.di_reg_form button.submit {
	background:#000;
	color:#fff;
	padding:10px 15px;
	border:0;
}
.di_reg_form span {
	font-size:11px;
	font-style:italic;
}
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
	width: 6.5em;
	display: inline-block;
}
@media (min-width: 600px) {
 .rwd-table td:before {
 display: none;
}
}
.rwd-table th, .rwd-table td {
	text-align: left;
}
@media (min-width: 600px) {
 .rwd-table th,  .rwd-table td {
 display: table-cell;
 padding: 0.25em 0.5em;
 text-align:center;
}
 .rwd-table th:first-child,  .rwd-table td:first-child {
 padding-left: 0;
}
 .rwd-table th:last-child,  .rwd-table td:last-child {
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
.rwd-table th, .rwd-table td {
	margin: 0.5em 1em;
}
@media (min-width: 600px) {
 .rwd-table th,  .rwd-table td {
 padding: 1em !important;
}
 .rwd-table th, .rwd-table td:before {
background:#ddd;
}
}
.di_reg_form .radio_style {
	width:auto;
	display:inline-block;
}
.radio_group label {
	display:inline-block;
	width:auto;
	margin:0 10px;
	font-size:14px;
}
</style>
