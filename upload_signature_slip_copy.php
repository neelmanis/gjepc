<?php
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id = intval(filter($_SESSION['USERID']));
$info_status = $conn ->query("select status from information_master where registration_id='$registration_id' and status=1");
$info_num = $info_status->num_rows;

$comm_status = $conn ->query("select status from communication_details_master where registration_id='$registration_id' and status=1");
$comm_num = $comm_status->num_rows;

$chln_status = $conn ->query("select status from challan_master where registration_id='$registration_id' and status=1");
$chln_num = $chln_status->num_rows;

if($info_num==0 && $comm_num==0 && $chln_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
$_SESSION['form_chk_msg1']="Please first fill Communication form";
$_SESSION['form_chk_msg2']="Please first fill challan form";
header('location:information_form.php');
}

if($comm_num==0 && $chln_num==0)
{ 
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:communication_form.php');
}
if($chln_num==0)
{	
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:challan_form.php');
}
?>

<?php
$action=$_REQUEST['action'];
if($action=="upload")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$signature_slip = '';
	$target_folder = 'signature_slip/';
	$temp_code = rand();
	$file_name = $_FILES['signature_slip']['name'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name) || preg_match("/.PhP/i", $file_name)){
    		$_SESSION['upload_error'] = "Sorry you have select Invalid file";
	} elseif($file_name != '')
	{  
	  //Unlink the previous image
	   $qpreviousimg = $conn ->query("select signature_slip_copy from challan_master where registration_id='$registration_id'");
	   $rpreviousimg = $qpreviousimg->fetch_assoc();
	   $filename="signature_slip/".$rpreviousimg['signature_slip_copy'];
	   @unlink($filename);
		if(($_FILES["signature_slip"]["type"] == "image/jpg") || ($_FILES["signature_slip"]["type"] == "image/jpeg") || ($_FILES["signature_slip"]["type"] == "image/png") && $_FILES['signature_slip']['size'] < 2097152 && getimagesize($_FILES['signature_slip']['tmp_name']))
		{
			$target_path = $target_folder.$temp_code.'_'.$file_name;			
			if(@move_uploaded_file($_FILES['signature_slip']['tmp_name'], $target_path))
			{
				 $signature_slip = $temp_code.'_'.$file_name;
				 $sql="update challan_master set signature_slip_copy='$signature_slip' where registration_id='$registration_id'";
				 $result = $conn ->query($sql);
				 if(!$result)die("Unable to Update");
			} else {
				$_SESSION['upload_error']="Sorry image could not be uploaded";
				return;
			}
		} else
		{
				$_SESSION['upload_error']="Sorry you have select Invalid file";
		}	
	}
	} else {
	 $_SESSION['upload_error']="Invalid Token Error";
	}
 }
?>


<section class="py-5">
	<div class="container inner_container">
    
       <h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto">My Account - Upload Signature Slip Copy</h1>
	<div class="row">
		
		<div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
		</div>

	<div class="col-lg col-md-12">

	<?php 
	$qscan = $conn ->query("select signature_slip_copy from challan_master where registration_id='$registration_id'");
	$rscan = $qscan->fetch_assoc();
	if($rscan['signature_slip_copy']!=""){ ?>
	<div class="col-md-4"> <img src="signature_slip/<?php echo $rscan['signature_slip_copy'];?>" class="img-responsive"> </div>
	<?php } else { ?>
	<div class="col-md-4"> <img src="images/upload_img.jpg" class="img-responsive"> </div>
	<?php } ?>
			
			<?php 
            if($_SESSION['upload_error']!=""){
            echo "<div class='alert alert-danger' role='alert'>";
              echo $_SESSION['upload_error']."<br>";
			  $_SESSION['upload_error']="";
			   echo "</div>";
            }
			?>
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" class="form-block">
			<input type="hidden" name="action" value="upload"/>
			<?php token(); ?>
					<div class="col-md-8"> 
						<div class="col-md-12">
						<input type="file" name="signature_slip" id="signature_slip" class="form-control"  accept=".jpg,.jpeg,.png">
						<p class=""><b class="minibuffer">Please note : </b>Upload only jpeg, jpg, png files</p>
						<!--<p class="minibuffer"><input type="button" name="fakeFileBtn" onclick="jQuery('#signature_slip').click();" id="fakeFileBtn" value="Select File"></p>-->
						<p class=""><input type="submit" class="cta fade_anim" value="Upload"></p>								
						</div>				
					</div>
			</form>		
	</div>    
    </div>    
    </div>    
    </section>    
<?php include 'include-new/footer.php'; ?>