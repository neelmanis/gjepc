<?php include 'include/header.php'; ?>
<?php if(!isset($_SESSION['USERID'])){header('location:login.php');}?>
<?php
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id=$_SESSION['USERID'];
$info_status=mysql_query("select member_type_id,type_of_firm,status from information_master where registration_id='$registration_id' and status=1");
$info_num=mysql_num_rows($info_status);
$info_row=mysql_fetch_array($info_status);
$member_type_id=$info_row['member_type_id'];
$type_of_firm=$info_row['type_of_firm'];
if($info_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
header('location:information_form.php'); exit;
}
?>

<?php
$action=$_REQUEST['action'];
if($action=="ADD")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
$registration_id=filter($_SESSION['USERID']);
$company_name=filter($_REQUEST['company_name']);
$gcode=filter($_REQUEST['gcode']);
$address=filter($_REQUEST['address']);
$name=filter($_REQUEST['name']);
$pan_no=filter(str_replace(" ","",$_REQUEST['pan_no']));
$post_date=date('Y-m-d');

$sql2="SELECT * from photo_card_master where name='$name' AND pan_no='$pan_no'";
$result2=mysql_query($sql2);
$num_rows_count=mysql_num_rows($result2);
if($num_rows_count==0)
{
		if(isset($_FILES['pan_copy']) && $_FILES['pan_copy']['name']!="")
		{
			$file_name=$_FILES['pan_copy']['name'];
			$file_temp=$_FILES['pan_copy']['tmp_name'];
			$file_type=$_FILES['pan_copy']['type'];
			$file_size=$_FILES['pan_copy']['size'];
			$attach=rand();
			if($_FILES['pan_copy']['name']!="")
			{
				$pan_copy=uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,"PanCopy");
			}
		}
		
		if(isset($_FILES['photo_copy']) && $_FILES['photo_copy']['name']!="")
		{
			$file_name=$_FILES['photo_copy']['name'];
			$file_temp=$_FILES['photo_copy']['tmp_name'];
			$file_type=$_FILES['photo_copy']['type'];
			$file_size=$_FILES['photo_copy']['size'];
			$attach=rand();
			if($_FILES['photo_copy']['name']!="")
			{
				$photo_copy=uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,"PhotoCopy");
			}
		}
if(!empty($registration_id)){
$sql1="insert into photo_card_master (registration_id,gcode,company_name,name,address,pan_no,pan_copy,photo_copy,post_date) values ('$registration_id','$gcode','$company_name','$name','$address','$pan_no','$pan_copy','$photo_copy','$post_date')";
if(!mysql_query($sql1)){ die('Error: ' . mysql_error()); }
$_SESSION['succ_msg']="Apply successfully";
}
}
else
{
	$_SESSION['form_chk_msg']="Name or PAN No Already Exist.";
}
header('location:apply_photo_id_card.php');exit;
	 } else {
	 $_SESSION['form_chk_msg']="Invalid Token Error";
	}
}

$sql="SELECT * FROM `communication_address_master` WHERE 1 and registration_id='$registration_id' and type_of_address='2'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

$address1=$rows['address1'];
$address2=$rows['address2'];
$address3=$rows['address3'];
$city=$rows['city'];
$country=$rows['country'];
$pincode=$rows['pincode'];

$address=$address1.' '.$address2.' '.$address3.' '.$city.' '.$country.' '.$pincode;
?>
<!-- Datepicker End -->

<section>
    <div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>
    </div>
    
	<div class="container inner_container">

<div class="row mb">

	<div class="col-12">
            	<div class="innerpg_title">
                	<h1>My Account - Apply Photo ID Card</h1>
                </div>
           </div>

	<div class="col-lg-3 col-md-4 order-md-12" data-sticky_parent>
                <?php include 'include/regMenu.php'; ?>
            </div>
            
	<?php 
    if($_SESSION['form_chk_msg']!=""){
    echo "<span class='notification n-attention'>".$_SESSION['form_chk_msg']."</span>";
    $_SESSION['form_chk_msg']="";
    }
    
    if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msg3']!="" || $_SESSION['error_msg4']!=""){
    echo "<span class='notification n-attention'>";
    if($_SESSION['error_msg1']!="")
    {
    echo $_SESSION['error_msg1']."<br>";
    }
    
    if($_SESSION['error_msg2']!="")
    {
    echo $_SESSION['error_msg2']."<br>";
    }
    
    if($_SESSION['error_msg3']!="")
    {
    echo $_SESSION['error_msg3']."<br>";
    }
    
    if($_SESSION['error_msg4']!="")
    {
    echo $_SESSION['error_msg4'];
    }
    
    echo "</span>";
    $_SESSION['error_msg1']="";
    $_SESSION['error_msg2']="";
    $_SESSION['error_msg3']="";
    $_SESSION['error_msg4']="";
    }
    ?>  
      
	<div class="col-lg-9 col-md-8 col-sm-12 order-md-1">
	<?php if($_SESSION['succ_msg']!=""){
    //echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
	echo "<div class='alert alert-success' role='alert'>". $_SESSION['succ_msg']."</div>"; 
    $_SESSION['succ_msg']="";
    }    
	?>
        <table>
        
			<thead>
				<tr>
					<th>Name</th>
					<th>PAN/Passport Name</th>
					<th>PAN/Passport Copy</th>
					<th>Photo</th>
				</tr>
			</thead>
            
			<tbody id="CommunicationDetails">
		<?php
	   	$query=mysql_query("select * from photo_card_master where registration_id='".$_SESSION['USERID']."'");
		while($result=mysql_fetch_array($query)){
        ?>
		<tr>
			<td data-column="Name"><?php echo filter(strtoupper($result['name']));?></td>
			<td data-column="PAN/Passport Name"><?php echo filter(strtoupper($result['pan_no']));?></td>
			<td data-column="PAN/Passport Copy"><?php if($result['pan_copy']!=""){?><a href="images/PhotoID/PanCopy/<?php echo $result['pan_copy'];?>" target="_blank">View</a><?php }?></td>
			<td data-column="Photo"><?php if($result['photo_copy']!=""){?><a href="images/PhotoID/PhotoCopy/<?php echo $result['photo_copy'];?>" target="_blank">View</a><?php }?></td>
		</tr>
		<?php } ?>		
		</tbody>
		</table>

		<form class="row" id="applyphotocard" name="applyphotocard" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" onsubmit="return validation()">
			<input type="hidden" name="action" value="ADD"/>
			<?php token(); ?>
            <input type="hidden" name="company_name"  value="<?php echo filter($_SESSION['COMPANYNAME']);?>"/>
            <input type="hidden" name="gcode" value="<?php echo filter($_SESSION['USER_GCODE']);?>"/>
            <input type="hidden" name="address" value="<?php echo filter($address);?>"/>

			<div class="form-group col-sm-6">
				<label class="form-label" for="gcode">GCode </label>
				<?php echo filter($_SESSION['USER_GCODE']);?>
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="company_name">Company Name </label>
				<?php echo filter($_SESSION['COMPANYNAME']);?>
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="address">Address </label>
				<?php echo filter($address);?>
			</div>		
			<div class="form-group col-sm-6">
				<label class="form-label" for="country">Name </label>
				
				<select class="form-control" name="name" id="name" >
				<option value="">--- Select Name ---</option>	
				<?php
				$stype_of_address="SELECT * FROM `communication_address_master` WHERE `registration_id` ='$registration_id' AND `name` != ''";
				$result=mysql_query($stype_of_address);
				while($rows=mysql_fetch_array($result))
				{
					echo "<option value='$rows[name]'>$rows[name]</option>";
				}
				?>
				</select>
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="pan_no">PAN/Passport NO </label>
				<input type="text" class="form-control" id="pan_no" name="pan_no" maxlength="15"/>
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="pan_copy">Upload PAN/Passport Copy </label>
				<input name="pan_copy" type="file" id="pan_copy" accept=".jpg,.jpeg,.png"/>
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="pan_copy">Upload Photo Copy </label>
				<input name="photo_copy" type="file" id="photo_copy" accept=".jpg,.jpeg,.png"/>
			</div>

			<div class="form-group col-12">
				<?php if($chk_info_aprv!='Y'){?> <input class="cta" type="submit" value="Save"/> <?php } ?>
				
			</div>
		</form>
	</div>
    
   </div>
   
   </div>
</section>   
    
<?php include 'include/footer.php'; ?>

<script type="text/javascript">
function validation()
{
		var name=document.getElementById('name');
		var pan_no=document.getElementById('pan_no');
		var pan_copy=document.getElementById('pan_copy');
		var photo_copy=document.getElementById('photo_copy');	
		
		if(name.value=="")
		{
			alert("Please Select Name");
			name.focus();
			return false;
		}
		
		if(pan_no.value=="")
		{
			alert("Please Enter PAN/Passport No");
			pan_no.focus();
			return false;
		}
		
		if(pan_copy.value=="")
		{
			alert("Please Upload PAN/Passport Copy");
			pan_copy.focus();
			return false;
		}
		if(photo_copy.value=="")
		{
			alert("Please Upload Photo Copy");
			photo_copy.focus();
			return false;
		}
}

</script>