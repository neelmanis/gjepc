<?php include('header_include.php');?>
<?php include('chk_login.php');?>
	<?php	
	$membertype=$_SESSION['MEMBERTYPE'];
	if($membertype=="Agent"){
		$APPLICANT_ID=$_SESSION['AGENT_ID'];
		$APPLICANT_ADD1=getAgentAdd1($conn,$APPLICANT_ID);
		$APPLICANT_ADD2=getAgentAdd2($conn,$APPLICANT_ID);
		$APPLICANT_ADD3=getAgentAdd3($conn,$APPLICANT_ID);
		$PHONE=getAgentPhone($conn,$APPLICANT_ID);
		$EMAIL=getAgentEmail($conn,APPLICANT_ID);
	}
	else if($membertype=="Member"){
		$APPLICANT_ID=$_SESSION['MEMBER_ID'];
		$APPLICANT_ADD1=getMemberAdd1($conn,$APPLICANT_ID);
		$APPLICANT_ADD2=getMemberAdd2($conn,$APPLICANT_ID);
		$APPLICANT_ADD3=getMemberAdd3($conn,$APPLICANT_ID);
		$PHONE=getMemberPhone($conn,$APPLICANT_ID);
		$EMAIL=getMemberEmail($conn,$APPLICANT_ID);
	}
	else if($membertype=="NonMember"){
		$APPLICANT_ID=$_SESSION['NON_MEMBER_ID'];
		$APPLICANT_ADD1=getNonMemberAdd1($conn,$APPLICANT_ID);
		$APPLICANT_ADD2=getNonMemberAdd2($conn,$APPLICANT_ID);
		$APPLICANT_ADD3=getNonMemberAdd3($conn,$APPLICANT_ID);
		$PHONE=getNonMemberPhone($conn,$APPLICANT_ID);
		$EMAIL=getNonMemberEmail($conn,$APPLICANT_ID);
	}
?>
<?php
if(isset($_REQUEST['cancel']))
{
	header('location:payment_cart_e.php');
}
$action=$_REQUEST['action'];
if($action=="save")
{
$APPLICANT_ID=$_REQUEST['APPLICANT_ID'];
$MEMBERTYPE=$_REQUEST['MEMBERTYPE'];
$PAYMENT_TYPE=$_REQUEST['Payment_Mode'];
$PAYEE_BANK=$_REQUEST['Bank'];
$PAYMENT_AMOUNT=$_REQUEST['Total_Amount'];
$APPLICANT_NAME=$_SESSION['USERNAME'];
$ENTERED_ON=date('Y-m-d H:i:s');
$ENTERED_BY=$_SESSION['USERNAME'];
$MODIFIED_ON=date('Y-m-d H:i:s');
$MODIFIED_BY=$_SESSION['USERNAME'];
$CURRENCY_CODE="INR";
$CURRENCY_VAL="356";
$BILLING_TO=$_REQUEST['BILLING_TO'];
$PAYEE_BRANCH=$_REQUEST['Branch'];
$CHEQUE_NO=$_REQUEST['Cheque_No'];
$CHEQUE_DATE=date('Y-m-d',strtotime($_REQUEST['Cheque_Date']));
$STATUS="88";
$FORM_TYPE="E";

	if($PAYMENT_TYPE!=93){
	$sql="insert into kp_payment_master set MEMBERTYPE='$MEMBERTYPE',APPLICANT_ID='$APPLICANT_ID',PAYMENT_TYPE='$PAYMENT_TYPE',PAYEE_BANK='$PAYEE_BANK',PAYMENT_AMOUNT='$PAYMENT_AMOUNT',APPLICANT_NAME='$APPLICANT_NAME',APPLICANT_ADD1='$APPLICANT_ADD1',APPLICANT_ADD2='$APPLICANT_ADD2',PHONE='$PHONE',EMAIL='$EMAIL',ENTERED_ON='$ENTERED_ON',ENTERED_BY='$ENTERED_BY',MODIFIED_ON='$MODIFIED_ON',MODIFIED_BY='$MODIFIED_BY',CURRENCY_CODE='$CURRENCY_CODE',CURRENCY_VAL='$CURRENCY_VAL',PAYEE_BRANCH='$PAYEE_BRANCH',BILLING_TO='$BILLING_TO',CHEQUE_NO='$CHEQUE_NO',CHEQUE_DATE='$CHEQUE_DATE',STATUS='$STATUS',FORM_TYPE='$FORM_TYPE'";
	mysqli_query($conn,$sql);
	$PAYMENT_MST_ID=mysqli_insert_id($conn);
	$_SESSION['EXPORT_APP_ID']=$EXPORT_APP_ID=$_REQUEST['export_app_id'];
	$query=mysqli_query($conn,"select max(RECIEPT_NO) as RECIEPT_NO ,max(TRAN_ID) as TRAN_ID from kp_payment_details");
	$result=mysqli_fetch_array($query);
	$RECIEPT_NO=$result['RECIEPT_NO']+1;
	$TRAN_ID=$result['TRAN_ID']+1;
	
	$query1=mysqli_query($conn,"select MEMBER_TYPE_ID ,MEMBER_ID,NON_MEMBER_ID from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'");
	$result1=mysqli_fetch_array($query1);
	$MEMBER_TYPE_ID=$result1['MEMBER_TYPE_ID'];
	
	if($MEMBER_TYPE_ID=="18")
		$MEMBER_ID=$result1['MEMBER_ID'];
	else
		$MEMBER_ID=$result1['NON_MEMBER_ID'];
	
	 mysqli_query($conn,"insert into kp_payment_details set EXPORT_APP_ID='$EXPORT_APP_ID',PAYMENT_MST_ID='$PAYMENT_MST_ID',RECIEPT_NO='$RECIEPT_NO',APPLICANT_ID ='$APPLICANT_ID',MEMBER_TYPE_ID='$MEMBER_TYPE_ID',MEMBER_ID='$MEMBER_ID',FORM_TYPE='E',TRAN_ID='$TRAN_ID'");	
		
	 mysqli_query($conn,"update kp_export_application_master set payment_made_status='Y',KP_PAYMENT_ID='$PAYMENT_MST_ID' where EXPORT_APP_ID='$EXPORT_APP_ID'"); 	
	 
	$_SESSION['succ_msg']="Payment Made Successfully";	
	header('location:payment_cart_e.php');	
	exit;
	
	} else {
	/* Internet banking */	
	if($PAYMENT_AMOUNT !=0){
	$_SESSION['ReferenceNo']=$ReferenceNo=rand(100,9999999).time();
	$sql="insert into kp_payment_master set MEMBERTYPE='$MEMBERTYPE',APPLICANT_ID='$APPLICANT_ID',PAYMENT_TYPE='$PAYMENT_TYPE',PAYMENT_AMOUNT='$PAYMENT_AMOUNT',APPLICANT_NAME='$APPLICANT_NAME',APPLICANT_ADD1='$APPLICANT_ADD1',APPLICANT_ADD2='$APPLICANT_ADD2',PHONE='$PHONE',EMAIL='$EMAIL',ENTERED_ON='$ENTERED_ON',ENTERED_BY='$ENTERED_BY',MODIFIED_ON='$MODIFIED_ON',MODIFIED_BY='$MODIFIED_BY',CURRENCY_CODE='$CURRENCY_CODE',CURRENCY_VAL='$CURRENCY_VAL',BILLING_TO='$BILLING_TO',STATUS='$STATUS',FORM_TYPE='$FORM_TYPE',ReferenceNo='$ReferenceNo'";
	$getResults = mysqli_query($conn,$sql);
	if(!$getResults) die ($conn->error);
	$PAYMENT_MST_ID=mysqli_insert_id($conn);
	$_SESSION['EXPORT_APP_ID']=$EXPORT_APP_ID=$_REQUEST['export_app_id'];
	$query=mysqli_query($conn,"select max(RECIEPT_NO) as RECIEPT_NO ,max(TRAN_ID) as TRAN_ID from kp_payment_details");
	$result=mysqli_fetch_array($query);
	$RECIEPT_NO=$result['RECIEPT_NO']+1;
	$TRAN_ID=$result['TRAN_ID']+1;
	
	$query1=mysqli_query($conn,"select MEMBER_TYPE_ID ,MEMBER_ID,NON_MEMBER_ID from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'");
	$result1=mysqli_fetch_array($query1);
	$MEMBER_TYPE_ID=$result1['MEMBER_TYPE_ID'];
	
	if($MEMBER_TYPE_ID=="18")
		$MEMBER_ID=$result1['MEMBER_ID'];
	else
		$MEMBER_ID=$result1['NON_MEMBER_ID'];
	
	$getPResults = mysqli_query($conn,"insert into kp_payment_details set EXPORT_APP_ID='$EXPORT_APP_ID',PAYMENT_MST_ID='$PAYMENT_MST_ID',RECIEPT_NO='$RECIEPT_NO',APPLICANT_ID ='$APPLICANT_ID',MEMBER_TYPE_ID='$MEMBER_TYPE_ID',MEMBER_ID='$MEMBER_ID',FORM_TYPE='E',TRAN_ID='$TRAN_ID'");	
	if(!$getPResults) die ($conn->error);
	
	$getEResults = mysqli_query($conn,"update kp_export_application_master set KP_PAYMENT_ID='$PAYMENT_MST_ID',ReferenceNo='$ReferenceNo' where EXPORT_APP_ID='$EXPORT_APP_ID'"); 
	if(!$getEResults) die ($conn->error);
	 
	//$total_payable = $PAYMENT_AMOUNT;
	$total_payable = 1;
	$key="2900042967901118";
	$payment_mode = "9";
	$return_url = "https://gjepc.org/webinar_payment_success.php";
	$submerchantid ="45";
	$PHONES ="KP dept";
	$mandate_str=aes128Encrypt($ReferenceNo."|".$submerchantid."|".$total_payable."|".$EMAIL."|".$APPLICANT_NAME."|".$PHONES,$key);
	
	$optional_str=aes128Encrypt($total_payable."|10104|".$MEMBERTYPE."|KP|".$MEMBER_ID."|0",$key);
	$return_url_str=aes128Encrypt($return_url,$key);
	$reference_str=aes128Encrypt($ReferenceNo,$key);
	$submerchant_str=aes128Encrypt($submerchantid,$key);
	$amount_str=aes128Encrypt($total_payable,$key);
	$payment_mode_str=aes128Encrypt($payment_mode,$key);
	if($total_payable !="0"){
	$redirectUrl="https://eazypay.icicibank.com/EazyPG?merchantid=296793&mandatory fields=".$mandate_str."&optional fields=".$optional_str."&returnurl=".$return_url_str."&Reference No=".$reference_str."&submerchantid=".$submerchant_str."&transaction amount=".$amount_str."&paymode=".$payment_mode_str; 
	header('location:'.$redirectUrl); exit;
	}
	}
	}
}
?>
<?php include('include/header.php');?>
<section>
	<div class="banner_wrap mb">
		<ul class="d-flex breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li> Kimberley Process </li>
			<li class="active">  Payment Cart</li>
		</ul>
	</div>
	<div class="container inner_container">
		<div class="row mb">
			<div class="col-12">
				<div class="innerpg_title">
					<h1>Payment Cart</h1>
				</div>
			</div>
			
			<div class="col-12 border p-2">
				<form action="" method="post" onsubmit="return checkdata()" name="form2" id="form2" >
					<?php
					if($_SESSION['succ_msg']!=""){
					echo "<span class='notification n-success'>".$_SESSION['succ_msg']."<br>";
							echo "your Application ID is:".$_SESSION['EXPORT_APP_ID'];
					echo "</span>";
					$_SESSION['EXPORT_APP_ID']="";
					$_SESSION['succ_msg']="";
					}
					?>
					<p class="blue">
						<strong>Note :</strong> Payment for multiple transactions can be done only for same locations.
					</p>
					<div class="search_app_div">
						<table>
							<td><!--<input name="check_all" id="check_all" type="checkbox" value="" onClick="toggle(this)"  />--></div></td>
							<td><strong>Application Date</strong></td>
							<td><strong>Member Name</strong></td>
							<td><strong>Application Fees</strong></td>
							<td><strong>Courier Amount</strong></td>
							<td><strong>Total Amount</strong></td>
							<td><strong>Location</strong></td>
							<td><strong>Action</strong></td>
						</tr>
						
						<?php
						if(isset($_SESSION['AGENT_ID'])){
						$member_id=$_SESSION['AGENT_ID'];
						$sql_import_pending="select  * from kp_export_application_master where AGENT_ID='".$_SESSION['AGENT_ID']."' and FORM_TYPE='E' order by ENTERED_ON desc";
						}
						else if(isset($_SESSION['MEMBER_ID'])){
						$member_id=$_SESSION['MEMBER_ID'];
						$sql_import_pending="select * from kp_export_application_master where MEMBER_ID='".$_SESSION['MEMBER_ID']."' and FORM_TYPE='E'  order by ENTERED_ON desc";
						}
						else if($_SESSION['NON_MEMBER_ID']){
						$member_id=$_SESSION['NON_MEMBER_ID'];
						$sql_import_pending="select * from kp_export_application_master where NON_MEMBER_ID='".$_SESSION['NON_MEMBER_ID']."' and FORM_TYPE='E' order by ENTERED_ON desc";
						}
						$query_import_pending=mysqli_query($conn,$sql_import_pending);
						
						while($result_import_pending=mysqli_fetch_array($query_import_pending)){
						?>
						<tr>
							<td><div class="chexbox11">
							<input name="export_app_id" id="" type="radio" value="<?php echo $result_import_pending['EXPORT_APP_ID'];?>"  />
						</div>
					</td>
					<td><?php echo date("d-m-Y",strtotime($result_import_pending['ENTERED_ON']));?></td>
					<td>
						<?php
						if($result_import_pending['MEMBER_TYPE_ID']=='18'){
						echo getMemberName($conn,'Member',$result_import_pending['MEMBER_ID']);
						}
						else
						{
						echo getMemberName($conn,'NonMember',$result_import_pending['NON_MEMBER_ID']);
						}
						?>
					</td>
					<td><?php echo $result_import_pending['FEES_AMOUNT'];?></td>
					<td><?php echo $result_import_pending['COURIER_AMOUNT'];?></td>
					<td><?php echo $result_import_pending['TOTAL_AMOUNT'];?></td>
					<td><?php echo getRegionName($conn,$result_import_pending['LOC_PICKUP_ID']);?></td>
					 <td><a class="btn btn-dark p-1"> <a href="export_application.php?EXPORT_APP_ID=<?php echo $result_import_pending['EXPORT_APP_ID'];?>&action=update">Edit</a></td>
				</tr>
				
				<?php } ?>
				
				<tr>
					 <td colspan="8"><img src="images/delete.png" id="delete_importer" style="cursor:pointer;" onClick="return(window.confirm('Are you sure you want to delete?'));"; /></td>
					
				</tr>
			</table>
		</div>
		<div class="search_app_div">
		</div>
		<div class="row">
			<div class="col-12">
				<div class="form-group row">
					<label class="col-3 star">Payment Mode:</label>
					<div class="col-7">
						<?php
						$sql="select LOOKUP_VALUE_ID,LOOKUP_VALUE_CODE,LOOKUP_VALUE_NAME from  kp_lookup_details where LOOKUP_ID='15'";
						$result=mysqli_query($conn,$sql);
						while($rows=mysqli_fetch_array($result)){
						?>
						<label class="mr-3"><input name="Payment_Mode" id="Payment_Mode" type="radio" value="<?php echo $rows['LOOKUP_VALUE_ID'];?>" /> <?php echo $rows['LOOKUP_VALUE_NAME'];?></label>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-12" id="bank_details" <?php /* if($Payment_Mode!='1'){?> style="display: none" <?php } */?>>
			<p class="blue col-12">Cheque / DD Details</p>
			<div class="col-4">
				<div class="form-group">
					<label class="star">BILLING TO</label>
					<select  class="form-control" name="BILLING_TO" id="BILLING_TO">
						<option selected="selected" value="">--Select--</option>
						<?php if($_SESSION['MEMBERTYPE']=="Member" || $_SESSION['MEMBERTYPE']=="NonMember"){?>
							<option value="party" selected>Party</option>
						<?php } else { ?>
							<option value="agent">Agent</option>
							<option value="party">Party</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-4">
				<div class="form-group">
					<label>Bank/Branch</label>
					<select  class="form-control" name="Bank_Branch" id="Bank_Branch">
					<option selected="selected" value="">--Select--</option>
					<?php
						$sql="select * from  kp_bank_branch_master order by BANK_NAME asc";
						$result=mysqli_query($conn,$sql);
						while($rows=mysqli_fetch_array($result))
						{
								echo "<option  value='$rows[BANK_ID]'>$rows[BANK_NAME]/$rows[BRANCH_NAME]</option>";
						}
					?>
				</select>
				</div>
			</div>
			<div class="col-4">
				<div class="form-group">
					<label>Bank</label>
					<input name="Bank" id="Bank" class="form-control" type="text" readonly="readonly" />
				</div>
			</div>
			<div class="col-4">
				<div class="form-group">
					<label>Branch</label>
					<input name="Branch" id="Branch" class="form-control" type="text" readonly="readonly" />
				</div>
			</div>
			<div class="col-4">
				<div class="form-group">
					<label>Cheque No</label>
					<input name="Cheque_No" id="Cheque_No" class="form-control" type="text"/>
				</div>
			</div>
			<div class="col-4">
				<div class="form-group">
					<label>Cheque Date</label>
					<input type="text" name="Cheque_Date" id="popupDatepicker" value="" onkeydown="return false"  class="form-control"/>
				</div>
			</div>
			</div>
			
			<div class="col-4">
				<div class="form-group">
					<label>Total Amount</label>
					<input name="Total_Amount" id="Total_Amount" class="form-control" type="text" value="" readonly="readonly" />
				</div>
			</div>
			<div class="col-12">
				<input class="cta mr-3 d-inline-block" type="submit" value="Submit" />
				<input class="btn btn-secondary" type="button" value="Cancel" name="cancel" id="cancel" />
				<input type="hidden" name="MEMBERTYPE" id="MEMBERTYPE" value="<?php echo $_SESSION['MEMBERTYPE'];?>"/>
				<input type="hidden" name="APPLICANT_ID" id="APPLICANT_ID" value="<?php echo $APPLICANT_ID;?>"/>
				<input type="hidden" name="action" id="action" value="save"/>
			</div>
		</div>

		
</form>
</div>
</div>
</div>
</section>
<?php include('include/footer.php');?>

 <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
 <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script>
        $('#popupDatepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
        $('#popupDatepicker1').datepicker({
            uiLibrary: 'bootstrap4'
        });
</script>
<style>
	.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('kp/assets/images/loader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: 80;
	}
</style>
<script>
$('input[name="export_app_id"]').on('change', function() {
	var export_app_id=$('input[name="export_app_id"]:checked').val();
	//alert(export_app_id);
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getAmount&export_app_id="+export_app_id,
					dataType:'html',
					beforeSend: function(){
							$("#status").show();
							$("#preloader").show();
							},
					success: function(data){
							 //alert(data);return false;
								$("#status").hide();
								$("#preloader").hide();
								if (data.indexOf("error") >= 0)
								{
									alert("Payment amount should be greater than 0");
									$(location).attr('href','payment_cart_e.php');
								}
								else
								{
									$('#Total_Amount').val(data);
								}
							
							}
		});
});
</script>
<script>
$("#Bank_Branch").on('change', function(){
var bank_id=$("#Bank_Branch").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getbranch&bank_id="+bank_id,
					dataType:'html',
					beforeSend: function(){
							$("#status").show();
							$("#preloader").show();
							},
					success: function(data){
							$("#status").hide();
							$("#preloader").hide();
								var data=data.split("#");
								$('#Bank').val(data[0]);
								$('#Branch').val(data[1]);
							}
		});
});
</script>
<script>
$("#delete_importer").on('click', function(){
if($("input:radio[name='export_app_id']").is(":checked")) {
	var EXPORT_APP_ID=$('input[name="export_app_id"]:checked').val();
	//alert(EXPORT_APP_ID);
    } else {
		alert("Atleast select an application");
		return false;
	}
    $.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=deleteImporter&EXPORT_APP_ID="+EXPORT_APP_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
						$(location).attr('href','payment_cart_e.php');
						}
		});
});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("input[name='Payment_Mode']").click(function () {
			if($(this).val()!="93") {
				$("#bank_details").show();								
				$("#BILLING_TO").removeAttr("disabled");
				$("#Bank_Branch").removeAttr("disabled");
				$("#Bank").removeAttr("disabled");
				$("#Branch").removeAttr("disabled");
				$("#Cheque_No").removeAttr("disabled");
				$("#Cheque_Date").removeAttr("disabled");				
            } else {				
                $("#bank_details").hide();
				$("#BILLING_TO").attr("disabled", "disabled"); 
				$("#Bank_Branch").attr("disabled", "disabled"); 
				$("#Bank").attr("disabled", "disabled"); 
				$("#Branch").attr("disabled", "disabled"); 
				$("#Cheque_No").attr("disabled", "disabled"); 
				$("#Cheque_Date").attr("disabled", "disabled"); 				
            }
        });
    });
</script>
<script language="javascript">
function checkdata()
{
	if($("input:radio[name='export_app_id']").is(":checked")) {
    }else{
		alert("Atleast select an application");
		return false;
	}
	if ( ( document.form2.Payment_Mode[0].checked == false ) && (document.form2.Payment_Mode[1].checked == false ) && (document.form2.Payment_Mode[2].checked == false ) && (document.form2.Payment_Mode[3].checked == false ) )
	{
		alert ( "Please choose a payment mode");
		return false;
	}
	
	if(document.form2.Payment_Mode[3].checked == false)
	{
		if(document.form2.Cheque_No.value=='')
		{
			alert("Please enter Cheque/DD details")
			document.form2.Cheque_No.focus();
			return false
		}
		if(document.form2.Cheque_Date.value=='')
		{
			alert("Please enter Cheque Date")
			document.form2.Cheque_Date.focus();
			return false
		}
		
		if(document.form2.Bank_Branch.value=='')
		{
			alert("Please select Bank Branch")
			document.form2.Bank_Branch.focus();
			return false
		}
	}
	}
</script>
<script language="JavaScript">
function toggle(source) {
checkboxes = document.getElementsByName('export_app_id[]');
for(var i in checkboxes)
checkboxes[i].checked = source.checked;
}
</script>
</body>
</html>