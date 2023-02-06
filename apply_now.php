<?php 
include 'include-new/header.php'; 
include 'db.inc.php';
include 'functions.php';
?>

<?php
$job_id=$conn->real_escape_string($_REQUEST['jid']);
$sql="select position_name from job_master where id='$job_id'";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();

//print_r($rows);
$position_name=$rows['position_name'];
?>

<?php 
if(isset($_REQUEST['action'])=='ADD')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
$job_id=filter($_REQUEST['job_id']);
$name=filter($_REQUEST['name']);
$mobile_no=filter($_REQUEST['mobile_no']);
$email_id=filter($_REQUEST['email_id']);
$apply_date=date("Y-m-d");

	if(empty($job_id)){
	$signup_error = "Something Missing ! Try Again";
	} else if(empty($name)){
	$signup_error = "Please Enter Name";
	} else if(empty($mobile_no)){
	$signup_error = "Please Enter Mobile No";
	} else if(strlen($mobile_no)>10 || strlen($mobile_no)<10){
	$signup_error="Mobile Number should be 10 digits.";
	} else if(empty($email_id)){
	$signup_error = "Please Enter Emailid";
	} else {
//---------------------------------------- uplaod  resume  -----------------------------------------------
		$resume = '';
		$target_folder = 'resume/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		$file_name = $_FILES['resume']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace("'","_",$file_name);
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name) || preg_match("/.PhP/i", $file_name)){
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='careers.php';</script>";
			exit;
		}
		else if($file_name!='')
		{
		if(($_FILES["resume"]["type"] == "application/pdf") || ($_FILES["resume"]["type"] == "application/PDF") || ($_FILES["resume"]["type"] == "application/DOC") || ($_FILES["resume"]["type"] == "application/doc"))
		{
			$target_path = $target_folder.$temp_code.'_'.$file_name;
		
			if(move_uploaded_file($_FILES['resume']['tmp_name'], $target_path))
			{
				$resume = $temp_code.'_'.$file_name;
				$sql="insert into job_apply (job_id,name,mobile_no,email_id,resume,apply_date) values ('$job_id','$name','$mobile_no','$email_id','$resume','$apply_date')";
				$result=$conn->query($sql);
				if($result){
				
				if($_REQUEST['page']=="gjepc"){$to = "career@gjepcindia.com";}
				if($_REQUEST['page']=="center"){$to = "career@gjepcindia.com";}
		
				$subject = "Applying Candidates Details";
				$message = '<table width="600" border="0" cellspacing="2" cellpadding="2">
				<tr>
				<td colspan="2"><strong>Applying Candidates Details : </strong></td>
				</tr>
				<tr>
				<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
				<td style="width:170px;">Position Applied for :</td>
				<td>'.$position_name.'</td>
				</tr>
				
				<tr>
				<td style="width:170px;">Name :</td>
				<td>'.$name.'</td>
				</tr>
				
				<tr>
				<td style="width:170px;">Mobile No :</td>
				<td>'.$mobile_no.'</td>
				</tr>
				<tr>
				<td style="width:170px;">Email ID :</td>
				<td>'.$email_id.'</td>
				</tr>
				<tr>
				<td style="width:170px;">Applying Date:</td>
				<td>'.$apply_date.'</td>
				</tr>
				</table>
				<br><br>Please <a href="www.gjepc.org/resume/'.$resume.'" target="blank">click here</a> to view CV<br><br>
				<a href="https://www.gjepc.org/">www.gjepc.org</a><br>';
				/*
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: '.$email_id;	*/
				$cc = "";
				send_mail($to,$subject,$message,$cc);
				$msg = 'Thank you for applying.';
				}
			} else
			{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this resume.\");location.href='apply_now.php?jid=$_REQUEST[job_id]&xid=767';</script>";
				return;
			}
		} else {
			echo "<script langauge=\"javascript\">alert(\"Please select valid file.\");location.href='apply_now.php?jid=$_REQUEST[job_id]&xid=767';</script>";
				return;
		}
	}
	}
	} else {
	 $msg="Invalid Token Error";
	}
}
?>

<script type="text/javascript">
function checkdata()
{
	if(document.form1.name.value == '')
	{
		alert("Please Enter Name")
		document.form1.name.focus();
		return false;
	}
	if(!IsCharacter(document.form1.name.value))
	{
		alert("Please Enter Valid Name")
		document.form1.name.focus();
		return false;
	}
	
	if(document.form1.mobile_no.value == '')
	{
		alert("Please Enter Mobile No")
		document.form1.mobile_no.focus();
		return false;
	}
	if(!IsNumeric(document.form1.mobile_no.value))
	{
		alert("Please Enter valid Mobile No")
		document.form1.mobile_no.focus();
		return false;
	}
	if(document.form1.email_id.value == '')
	{
		alert("Please Enter email id")
		document.form1.email_id.focus();
		return false;
	}
	if (echeck(document.form1.email_id.value)==false)
	{
		document.form1.email_id.focus();
		return false;
	}
	if(document.form1.resume.value == '')
	{
		alert("Please Upload Resume")
		document.form1.resume.focus();
		return false;
	}
}
function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID")
		return false
	}
	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 return true;					
}
function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}
function IsCharacter(strString)
{
   var strValidChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}
</script>

<section class="py-5">
<?php if(isset($signup_error)){ echo "<div class='alert alert-danger' role='alert'>". $signup_error."</div>"; }?>
    <div class="container-fluid inner_container">
        
        <div class="row justify-content-center grey_title_bg">
            
            <div class="innerpg_title_center d-flex mb-3">
                	<img src="assets/images/gold_star.png" class="icon-title mr-4"><h1 class="title d-inline-block form_title align-items-center"> Apply Now </h1><img src="assets/images/gold_star.png" class="icon-title ml-4">
                </div>
        </div>
            
    	<div class="container p-0">
    
    <?php if($conn->real_escape_string($_REQUEST['action']) == '') { ?>
    			<div class="row justify-content-center mb-5">
                   
                    <form id="form1" name="form1" class="col-lg-5 box-shadow" enctype="multipart/form-data" method="post" action="" onSubmit="return checkdata();">
                    <?php token(); ?>
                    
                    	<div class="row">
                      		
                            <div class="form-group col-12">
                      			<label class="form-label" for="company_name">Position Applied for </label>
                                <input type="text" class="form-control" value="<?php echo $position_name; ?>" readonly="readonly">
                           	</div>
                            
                           	<div class="form-group col-12">
                       			<label class="form-label" for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" maxlength="30">
                          	</div>
                            
                            <div class="form-group col-12">
                            	<label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Email" >
                          	</div>
                            
                            <div class="form-group col-12">
                                <label class="form-label" for="mobile">Mobile</label>
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile" maxlength="10">
                            </div>
                            
                            <div class="form-group col-12">
                                <label class="form-label" for="resume">Resume</label>
                                <input class="form-control" type="file" name="resume" id="resume" accept="application/pdf,application/msword"/>
                            </div>
                            
                            <div class="form-group col-12">				
                                <input type="hidden" class="btn" name="job_id" id="job_id" value="<?php echo $job_id;?>" />	
                                <input type="hidden" class="btn" name="action" id="action" value="ADD" />
                                <input type="hidden" class="btn" name="page" id="page" value="<?php echo $_REQUEST['page'];?>"/>
                                <input type="submit" class="cta fade_anim" value="Submit" name="submit" />                               
                            </div>                    	
                        </div>                    
                    </form>                    
                 </div>   
					<?php } else {  ?>
                    <div class="midleleft">
                    <?php if(isset($msg)){ ?><strong><span style="color: green;" /><?php echo $msg;?></span></strong><br>
                    We will get back to you shortly,<br>
                    if your profile suits our requirements
					<?php } ?>
                    </div>
                    <?php } ?>
   			</div>
	</div>
</section>
<?php include 'include-new/footer.php'; ?>