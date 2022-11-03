<?php
include 'include-new/header.php'; 
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php
unset($_SESSION['succ_msg']);
$user_id = intval(filter($_SESSION['USERID']));

$sql_gcode = "select gcode from registration_master where id='$user_id'";
$execute_gcode = $conn ->query($sql_gcode);
if (!$execute_gcode) die ($conn->error);
	
$get_gcode = $execute_gcode->fetch_assoc();
$gcode=$get_gcode["gcode"];
$autofill = "select a.gcode,a.region_id ,b.Panel_Name,c.membership_certificate_type from information_master a ,communication_details_master b ,approval_master c where a.registration_id='$user_id' and b.registration_id='$user_id' and c.registration_id='$user_id' LIMIT 1";
$result =$conn ->query($autofill);

if(!$execute_gcode) die ($conn->error);
else
{
	$bind_data=$result->fetch_assoc();
	$gcode=$bind_data["gcode"];
	$region_id=$bind_data["region_id"];
	$Membership_Type=$bind_data["membership_certificate_type"];
	$Panel_Name=$bind_data["Panel_Name"];
	$Name=$bind_data["Name"];
}
if(isset($_REQUEST['action']))
{
	$action=$_REQUEST['action'];
	if($action=="save")
	{ 
		$submited_date=date('Y-m-d');
		$user_id=$_POST["registration_id"];
		$type_of_membership=$_POST["type_of_membership"];
		$current_panel=$_POST["current_panel"];
		$new_panel=$_POST['new_panel'];
		if($new_panel=="Lab Grown Diamond"){ $lgd_disclaimer="YES"; }
		$region_id=$_POST["region_id"];
		$query1=$conn ->query("select * from update_panel where registration_id='$user_id'");
		$num_rows=$query1->num_rows;
		if($num_rows>0){
		 $update_query = "update update_panel set region_id='$region_id', type_of_membership='$type_of_membership', current_panel='$current_panel',new_panel='$new_panel', modified_date='$submited_date',lgd_disclaimer='$lgd_disclaimer' where registration_id='$user_id'";
		} else {
		$update_query = "insert into update_panel set region_id='$region_id', registration_id='$user_id', type_of_membership='$type_of_membership', current_panel='$current_panel',new_panel='$new_panel', modified_date='$submited_date',submited_date='$submited_date',lgd_disclaimer='$lgd_disclaimer'";
		}
		$update_result = $conn ->query($update_query);
		if(!$update_result)
			$_SESSION['succ_msg']="Problems while Updating Panel Check Your Detials";
		else
			$_SESSION['succ_msg']="Information saved successfully";
	}
}
?>

<section class="py-5">
	<div class="container inner_container">
    <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto">My Account - Update Panel</h1>
<div class="row">

	<div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
    <?php include 'include/regMenu.php'; ?>
    </div>
	<div class="col-lg col-md-12 ">
		
		<?php 
        if($_SESSION['succ_msg']!=""){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
        $_SESSION['succ_msg']="";
        }
        ?>
        	
		<form action="" method="post" id="updatePanel" name="updatePanel" onsubmit="return validate()" class="row">
				
			<p class="blue d-block col-12 p-0">Change in Membership Panel</p>
            
			<?php 
			$query =  $conn ->query("select * from update_panel where registration_id='$user_id'");
			$num=$query->num_rows;
			if($num>0){ ?>              
			<div class="form-group">
			<label class="form-label" for="membership_number">Kindly take <a onclick="PrintContent();" target="_blank" style="cursor:pointer; color:#9e9457; border-bottom:1px solid #9e9457;"><strong><i class="fa fa-print" aria-hidden="true"></i> Print out</strong></a> ON COMPANY LETTERHEAD and submit the signed form to the council</label>
			</div>
			 <?php } else { ?>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="type_of_membership">TYPE OF MEMBERSHIP :</label></div>
				<div class="col-md-6"><input type="text" class="form-control"  name="type_of_membership" id="type_of_membership" value="<?php echo $Membership_Type;?>" readonly="readonly"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="current_panel">CURRENT PANEL UNDER WHICH FIRM IS REGISTERED in GJEPC :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="current_panel" id="current_panel" value="<?php echo $Panel_Name;?>" readonly="readonly"/></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="new_panel">NEW PANEL SELECTED FOR UPDATION OF MEMBERSHIP RECORDS :</label></div>
				<div class="col-md-6">
					<select class="form-control" id="new_panel" name="new_panel">
						<option value="">Please Select</option>
						<option value="Coloured Gemstones">Coloured Gemstones</option>
	                    <option value="Pearls">Pearls</option>
	                    <option value="Costume/Fashion Jewellery">Costume/Fashion Jewellery</option>
	                    <option value="Sales To Foreign Tourists">Sales To Foreign Tourists</option>
	                    <option value="Diamonds">Diamonds</option>
	                    <option value="Synthetic Stones">Synthetic Stones</option>
	                    <option value="Gold Jewellery">Gold Jewellery</option>
	                    <option value="Not Indicated">Not Indicated</option>
	                    <option value="Other Precious Metal Jewellery">Other Precious Metal Jewellery</option>
	                    <option value="Silver">Silver Jewellery</option>
	                    <option value="Lab Grown Diamond">Lab Grown Diamond</option>
					</select>
				</div>
			</div>
			<div id="agree_lgd" <?php if($panel_name=='Lab Grown Diamond'){?> <?php } else { ?>style="display:none;" <?php } ?>class="tablewidth_101 form-group col-12"> 
					<div class="chexbox">
					<input type="checkbox" class="mr-2" name="agree_disclaimer" id="agree_disclaimer" value="YES" <?php if($lgd_disclaimer=='YES'){echo "checked='checked'";} ?>/>I/We <?php echo strtoupper(str_replace('&amp;', '&', $_SESSION['COMPANYNAME'])); ?> do hereby confirm my/our business interests and trading in Lab-grown diamonds and based on such business done by us do hereby affirm my/our membership registration in the Lab-Grown Diamond Panel of the Council.I/We am/are fully aware of the demarcation and the independent functioning of the new Lab-grown Diamond Panel as compared to the existing Diamond Panel of the Council. Further, it is stated that I/we shall avoid any scenario of possible conflict of interest with the functioning of the existing Diamond Panel of the Council.</div>
					<label class="error" id="agree_msg"></label>	
			</div>
			<div class="form-group row"> 
				<div class="col-md-12">
					<hr>
				  <input type="hidden" name="action" value="save" /> 
                  <input type="hidden" name="region_id" id="region_id" value="<?php echo $region_id;?>" />
                  <input type="hidden" name="registration_id" id="registration_id" value="<?php echo $user_id;?>" />
					<button class="cta" type="submit">Save</button>
				</div>
			</div>
			 <?php } ?>
		</form>
	

        <!--................................Print out.................................-->
        <?php 
        $querys =  $conn ->query("select * from update_panel where registration_id='$user_id'");
        $result= $querys->fetch_assoc();
        $region_id=$result['region_id'];
       
	    $qregion_default = $conn ->query("SELECT region_address FROM region_master WHERE region_name='$region_id'");
        $region_default = $qregion_default->fetch_assoc();
        $region_address = strtoupper($region_default['region_address']);
        ?>

        <div id="divtoprint" style="display:none;">
        <table cellpadding="0" cellspacing="0" style="font-family: 'Roboto', sans-serif; font-size:14px;line-height:18px;">
          <tr>
            <td> To <br />
              The Executive Director<br />
              The Gem & Jewellery Export Promotion Council<br />
              <?php echo $region_address;?>
              </p>
            </td>
          </tr>
          <tr>
            <td><strong>Sub: </strong> Change of Panel in membership records of GJEPC.</td>
          </tr>
          <tr>
            <td style="height:30px;">Dear Sir,</td>
          </tr>
          <tr>
            <td style="height:30px; font-size:14px;">We hereby wish to change our existing panel in the membership records of the GJEPC. </td>
          </tr>
          <tr>
            <td><table cellpadding="0" cellspacing="0"  style="font-family: 'Roboto', sans-serif; width:100%;font-size: 13px;line-height: 18px;margin-bottom: 13px;margin-top: 4px;color:#26343A;">
                <tr>
                  <td style="padding:5px; width:50%; font-weight:bold;">Membership Number</td>
                  <td style="padding:5px; width:50%;"><?php echo getBPNO($user_id,$conn);?></td>
                </tr>				
                <!--<tr>
                  <td style="padding:5px; width:50%; font-weight:bold;">Type of Membership</td>
                  <td style="padding:5px; width:50%;"><?php echo $result['type_of_membership'];?></td>
                </tr>-->
                <tr>
                  <td style="padding:5px; width:50%; font-weight:bold;">Current Panel Under Which Firm is Registered in GJEPC</td>
                  <td style="padding:5px; width:50%;"><?php echo $result['current_panel'];?></td>
                </tr>
                <tr>
                  <td style="padding:5px; width:50%; font-weight:bold;">New Panel Selected For Updation Of Membership Records</td>
                  <td style="padding:5px; width:50%;"><?php echo strtoupper($result['new_panel']);?></td>
                </tr>
              </table></td>
          </tr>
		  <?php if($result['new_panel']=='Lab Grown Diamond'){ ?>
          <tr>
            <td style="height:30px;">I/We <?php echo strtoupper(str_replace('&amp;', '&', $_SESSION['COMPANYNAME'])); ?> do hereby confirm my/our business interests and trading in Lab-grown diamonds and based on such business done by us do hereby affirm my/our membership registration in the Lab-Grown Diamond Panel of the Council.<br/>I/We am/are fully aware of the demarcation and the independent functioning of the new Lab-grown Diamond Panel as compared to the existing Diamond Panel of the Council.<br/> Further, it is stated that I/we shall avoid any scenario of possible conflict of interest with the functioning of the existing Diamond Panel of the Council.</td>
          </tr>
		  <?php } else { ?>
		  <tr>
            <td style="height:30px;">We hereby declare that the above information is correct. </td>
          </tr>
		  <?php } ?>
		  <tr>
            <td style="height:30px;"></td>
          </tr>
          <tr>
            <td style="height:30px;">Signature with Stamp(For All Partners,Directors/Proprietor)</td>
          </tr>
        </table>
        </div>	
		
	</div>
    
   </div>
   
     </div>
     
     </section>
<?php include 'include-new/footer.php'; ?>
<script>
function validate()
{
	if(document.updatePanel.new_panel.value=='')
	{
		alert("Please select new panel")
		document.updatePanel.new_panel.focus();
		return false
	}
	if ($("#agree_lgd").is(":visible") == true) { 
	if($('input:checkbox[name=agree_disclaimer]').is(':checked') == false){
	$('#agree_msg').html('Please Accept & Read Disclaimer');
	return false; 
	}
	}
}
		$('#new_panel').on("change",function(){
        var valueType = $(this).val();
        if(valueType =="Lab Grown Diamond"){	
        $("#agree_lgd").slideDown();
		} else {
         $("#agree_lgd").slideUp();
        }
       });
</script>
<script type="text/javascript">
function PrintContent(){
	var DocumentContainer = document.getElementById("divtoprint");
	var WindowObject = window.open("", "PrintWindow","width=1200,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
}
</script>