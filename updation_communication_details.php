<?php include 'include-new/header.php'; ?>
<?php
if(!isset($_SESSION['USERID'])){ header('location:login.php'); }
include 'db.inc.php';
include 'functions.php';
?>
<?php
$user_id=intval($_SESSION['USERID']);
$membership_id = getMembershipId($user_id,$conn);
$sql_gcode="select gcode from registration_master where id='$user_id'";
$execute_gcode = $conn->query($sql_gcode);
if (!$execute_gcode) die ($conn->error);
	
$get_gcode=$execute_gcode->fetch_assoc();
$gcode=$get_gcode["gcode"];

$autofill = "select * from updation_communication_details where gcode='$gcode' LIMIT 1";
$result = $conn->query($autofill);
if (!$result) die ($conn->error);
else
{
	$bind_data=$result->fetch_assoc();
	
	$gcode=stripslashes($bind_data["gcode"]);
	$Membership_Type=stripslashes($bind_data["Membership_Type"]);
	$Panel_Name=stripslashes($bind_data["Panel_Name"]);
	$Name=stripslashes($bind_data["Name"]);

	$Address=stripslashes($bind_data["Address"])." ".stripslashes($bind_data["Address2"])." ".stripslashes($bind_data["Address3"])." ".stripslashes($bind_data["City"]).": ".stripslashes($bind_data["Post_Code"]);

	$Phone_No=stripslashes($bind_data["Phone_No"]);
	$Fax_No=stripslashes($bind_data["Fax_No"]);
	$Contact=stripslashes($bind_data["Contact"]);
	$Head_Office_Mobile_No=stripslashes($bind_data["Head_Office_Mobile_No"]);
	$email=stripslashes($bind_data["E-Mail"]);
	
}

if(isset($_REQUEST['action']))
{
	$action=$_REQUEST['action'];
	if($action=="save")
	{
		//validate Token
		if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
			
		$gcode=filter($_POST["gcode"]);
		$Membership_Type=filter($_POST["Membership_Type"]);
		$Panel_Name=filter($_POST["Panel_Name"]);
		$Name=filter($_POST["Name"]);
		$Address=filter($_POST["Address"]);
		$Phone_No=filter($_POST["Phone_No"]);
		$Fax_No=filter($_POST["Fax_No"]);
		$Contact=filter($_POST["Contact"]);
		$Head_Office_Mobile_No=filter($_POST["Head_Office_Mobile_No"]);
		$email=filter($_POST["email"]);
	
		$update_query = "update updation_communication_details set registration_id='$user_id',membership_id='$membership_id',Address='$Address', Phone_No='$Phone_No', Fax_No='$Fax_No', update_status='1', update_date=NOW() where gcode='$gcode'";
		$update_result =  $conn ->query($update_query);		
		if(!$update_result)
			$_SESSION['error_msg']="Problems while Updating Please Check Your Detials";
		else
			$_SESSION['succ_msg']="Information saved successfully";
		} else {
			$_SESSION['error_msg']="Invalid Token Error";
		}
	}
}
?>

<section>
<div class="container inner_container">
<div class="row mb">

	<div class="col-lg-3 col-md-4 order-md-12" data-sticky_parent>
       <?php include 'include/regMenu.php'; ?>
    </div>

	<div class="col-lg-9 col-md-8 col-sm-12 order-md-1">
		
		<?php 
        if($_SESSION['succ_msg']!=""){
        echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
        $_SESSION['succ_msg']="";
        }
        if($_SESSION['chk_iec_msg']!=""){
        echo "<span class='notification n-attention'>".$_SESSION['chk_iec_msg']."</span>";
        $_SESSION['chk_iec_msg']="";
        }
        ?>
        <?php 
		if($_SESSION['form_chk_msg']!="" || $_SESSION['form_chk_msg1']!="" || $_SESSION['form_chk_msg2']!=""){
		echo "<span class='notification n-attention'>";
		if($_SESSION['form_chk_msg']!=""){
		echo $_SESSION['form_chk_msg']."<br>";
		}
		if($_SESSION['form_chk_msg1']!=""){
		echo $_SESSION['form_chk_msg1']."<br>";
		}
		if($_SESSION['form_chk_msg2']!=""){
		echo $_SESSION['form_chk_msg2'];
		}
		echo "</span>";
		$_SESSION['form_chk_msg']="";
		$_SESSION['form_chk_msg1']="";
		$_SESSION['form_chk_msg2']="";
		}
		if($_SESSION['error_msg']!=""){
		echo "<span class='notification n-attention'>";
		echo $_SESSION['error_msg']."<br>";
		echo "</span>";
		}
		?>
        		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="row">
			
            <input type="hidden" name="action" value="save" />
			<input type="hidden" class="form-control" value="<?php echo $gcode;?>" name="gcode" id="gcode" readonly />
			<?php token(); ?>			
			
            <div class="form-group col-12"><p class="blue">Updation of Communication Details</p></div>
            
			<div class="form-group col-sm-6">
				<label class="form-label" for="mem_no">Membership Number </label>
				<input type="text" class="form-control" value="<?php echo $membership_id;?>" name="membership_id" id="membership_id" readonly />
			</div>

			<div class="form-group col-sm-6">
				<label class="form-label" for="Membership_Type">Type of Membership </label>
				<input type="text" class="form-control" value="<?php echo $Membership_Type;?>" name="Membership_Type" id="Membership_Type" readonly />
			</div>

			<div class="form-group col-sm-6">
				<label class="form-label" for="Panel_Name">Panel under which Member is registered </label>
				<input type="text" class="form-control" value="<?php echo $Panel_Name;?>" name="Panel_Name" id="Panel_Name" readonly />
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="Panel_Name">Name of the Company / firm </label>
				<input type="text" class="form-control" value="<?php echo $Name;?>" name="Name" id="Name" readonly />
			</div>

			<div class="form-group col-12">
				<label class="form-label" for="Address">Communication address which will be used for sending membership related information </label>
				<textarea class="form-control" name="Address" id="Address"><?php if($Address==""){echo "N/A Please Provide";}else{echo $Address;} ?></textarea>
			</div>

			<div class="form-group col-sm-6">
				<label class="form-label" for="Phone_No">Telephone no. </label>
				<input type="text" class="form-control" value="<?php if($Phone_No==""){echo "N/A Please Provide";} else{echo $Phone_No;} ?>" name="Phone_No" id="Phone_No" /> 
			</div>

			<div class="form-group col-sm-6">
				<label class="form-label" for="Fax_No">Fax no. </label>
				<input type="text" class="form-control" value="<?php if($Fax_No==""){echo "N/A Please Provide";}else{echo $Fax_No; }?>" name="Fax_No" id="Fax_No" />
			</div>

			<div class="form-group col-12">
				<label class="form-label" for="Contact">Name of the Authorized Representative </label>
				<p>(Person who has signed Signature Slip verified by Bank at the time of applying for membership) </p>
			
            <input type="text" class="form-control" value="<?php echo $Contact;?>" name="Contact" id="Contact" readonly="readonly" />
			</div>

			<div class="form-group col-sm-6">
				<label class="form-label" for="Head_Office_Mobile_No">Mobile no. of the Authorised Representative </label>
				<input type="text" class="form-control" value="<?php echo $Head_Office_Mobile_No;?>" name="Head_Office_Mobile_No" id="Head_Office_Mobile_No" readonly="readonly"/>
			</div>

			<div class="form-group col-sm-6">
				<label class="form-label" for="email">E-mail address of the Authorised Representative </label>
				<input type="text" class="form-control" value="<?php echo $email; ?>" name="email" id="email" readonly="readonly" />
			</div>		

			<div class="form-group col-12"><p class="blue">Updation of Communication Details</p></div>

					<div class="form-group col-12 radio inline-form">
						<label for="cg"><input type="checkbox" class="mr-2" name="declaration" id="declaration" value="1" <?php if($declaration=="1"){?> checked="checked"<?php }?>>I/We hereby solemnly affirm and declare that our previous financial year exports of gems and jewellery items and import of gems and jewellery raw materials amounted to the mentioned amount in this form.</label>
					</div>
			
			<div class="form-group col-12">
			<button class="cta" type="submit">Save</button>
			</div>
		</form>	
        	
	</div>    
    </div>    
    </div>    
    </section>    
<?php include 'include-new/footer.php'; ?>