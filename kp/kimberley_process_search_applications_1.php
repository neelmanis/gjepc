<?php include('header_include.php');?>
<?php include('chk_login.php');?>
<?php	
	$membertype=$_SESSION['MEMBERTYPE'];
	$APPLICANT_NAME=$_SESSION['USERNAME'];
	if($membertype=="Member"){
		$APPLICANT_ID=$_SESSION['MEMBER_ID'];
		$PHONE=getMemberPhone($conn,$APPLICANT_ID);
		$EMAIL=getMemberEmail($conn,$APPLICANT_ID);
		$APPLICANT_bp_no = $_SESSION['BP_NUMBER'];
	}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['member_type']="";
  $_SESSION['delivery_status']="";
  $_SESSION['app_type']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['PROCES_CNTR']="";
  header("Location: kimberley_process_search_applications.php");
} else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  
  $_SESSION['member_type']=$_REQUEST['member_type'];
  $_SESSION['app_type']=$_REQUEST['app_type'];
  $_SESSION['from_date']=$_REQUEST['from_date'];
  $_SESSION['to_date']=$_REQUEST['to_date'];
  $_SESSION['delivery_status']=$_REQUEST['delivery_status'];
  $_SESSION['PROCES_CNTR']=$_REQUEST['PROCES_CNTR'];
  
  if($action=='search')
  {
	if(isset($_SESSION['MEMBERTYPE']) && $_SESSION['MEMBERTYPE']=='Agent'){
	if($_SESSION['member_type']=="")
		$_SESSION['error_msg']="Please select Member Type";
	}else{
		if($_SESSION['app_type']=="")
			$_SESSION['error_msg']="Please select Application Type";
	}	
  }
}
?> 
<?php include('include-new/header.php');?>
<?php
/* KP FEE */
if(isset($_POST['PAY']) && !empty($_POST['PAY']))
{
	$TOTAL_AMOUNT =	base64_decode($_REQUEST['TOTAL_AMOUNT']);
	$EXPORT_APP_ID = filter($_POST['EXPORT_APP_ID']);
	$PAYMENT_MST_ID = getPAYMENTMSTID($conn,$EXPORT_APP_ID);
	
	if($TOTAL_AMOUNT !=0){
		$_SESSION['ReferenceNo']=$ReferenceNo=rand(100,9999999).time();

		$result = $conn ->query("update kp_payment_master set PAYMENT_TYPE='93',CHEQUE_NO='$ReferenceNo',CHEQUE_DATE=NOW(),PAYMENT_DATE=NOW(), ReferenceNo='$ReferenceNo',STATUS='94',PAYMENT_DESCRIPTION='dashboard' WHERE APPLICANT_ID='$APPLICANT_ID' AND PAYMENT_MST_ID='$PAYMENT_MST_ID'");
		if($result){
	
		$total_payable = $TOTAL_AMOUNT;
		//$total_payable = 1;
		$key="2900042967901118";
		$payment_mode = "9";
		$return_url = "https://gjepc.org/webinar_payment_success.php";
		$submerchantid ="45";
		$PHONES = $PHONE;
		$mandate_str=aes128Encrypt($ReferenceNo."|".$submerchantid."|".$total_payable."|".$EMAIL."|".$APPLICANT_NAME."|".$PHONES,$key);
		
		$optional_str=aes128Encrypt($APPLICANT_bp_no."|10104|".$membertype."|KP|".$APPLICANT_ID."|0",$key);
		$return_url_str=aes128Encrypt($return_url,$key);
		$reference_str=aes128Encrypt($ReferenceNo,$key);
		$submerchant_str=aes128Encrypt($submerchantid,$key);
		$amount_str=aes128Encrypt($total_payable,$key);
		$payment_mode_str=aes128Encrypt($payment_mode,$key);
		if($total_payable !="0"){
		$redirectUrl="https://eazypay.icicibank.com/EazyPG?merchantid=296793&mandatory fields=".$mandate_str."&optional fields=".$optional_str."&returnurl=".$return_url_str."&Reference No=".$reference_str."&submerchantid=".$submerchant_str."&transaction amount=".$amount_str."&paymode=".$payment_mode_str; 
		header('location:'.$redirectUrl); exit;
		}
		} else { $_SESSION['error_msg'] = "Something went wrong"; }
	
		
	} else { 
	$_SESSION['error_msg'] = "Issue in KP Total Amount";
	}
}

$action=$_REQUEST['action'];
if($action=="save")
{
 //echo '<pre>';	 print_r($_POST); exit;
	$EXPORT_APP_ID = filter($_POST['EXPORT_APP_ID']);
	$PAYMENT_MST_ID = getPAYMENTMSTID($conn,$EXPORT_APP_ID);
	$tds_tax = filter($_POST['tds_tax']);
	$tds_amount = filter($_POST['tds_amount']);
	$advol_net_payable_amount = filter($_POST['advol_net_payable_amount']);
	
	if($advol_net_payable_amount !=0){
	$_SESSION['advol_ReferenceNo'] = $advol_ReferenceNo = rand(100,9999999).time();
	
	$result = $conn ->query("update kp_payment_master set tds_tax='$tds_tax',tds_amount='$tds_amount',advol_net_payable_amount='$advol_net_payable_amount',advol_ReferenceNo='$advol_ReferenceNo' where PAYMENT_MST_ID='$PAYMENT_MST_ID'");
	if($result){
	
	$total_payable = $advol_net_payable_amount;
	//$total_payable = 1;
	$key="2900042967901118";
	$payment_mode = "9";
	$return_url = "https://gjepc.org/webinar_payment_success.php";
	$submerchantid ="45";
	$PHONES ="ADVALOREM";
	$mandate_str=aes128Encrypt($advol_ReferenceNo."|".$submerchantid."|".$total_payable."|".$EMAIL."|".$APPLICANT_NAME."|".$PHONES,$key);
	
	$optional_str=aes128Encrypt($APPLICANT_bp_no."|10104|".$MEMBERTYPE."|ADVALOREM|".$APPLICANT_ID."|0",$key);
	$return_url_str=aes128Encrypt($return_url,$key);
	$reference_str=aes128Encrypt($advol_ReferenceNo,$key);
	$submerchant_str=aes128Encrypt($submerchantid,$key);
	$amount_str=aes128Encrypt($total_payable,$key);
	$payment_mode_str=aes128Encrypt($payment_mode,$key);
	if($total_payable !="0"){
	$redirectUrl="https://eazypay.icicibank.com/EazyPG?merchantid=296793&mandatory fields=".$mandate_str."&optional fields=".$optional_str."&returnurl=".$return_url_str."&Reference No=".$reference_str."&submerchantid=".$submerchant_str."&transaction amount=".$amount_str."&paymode=".$payment_mode_str; 
	header('location:'.$redirectUrl); exit;
	}
	}
	 
	} else { 
	$_SESSION['error_msg'] = "Issue in Amount";
	}
}
?>

<section class="py-5">
	
	<div class="container-fluid inner_container">
	<div class="container">
    <ul class="row justify-content-center  igja_nav  mb-4">
    	<li class="col-auto"><a href="import_application.php" class="d-block ">Import Application</a></li>
        <li class="col-auto"><a href="export_application.php" class="d-block"> Export Application </a></li>
        <li class="col-auto"><a href="kimberley_process_search_applications.php" class="d-block active">Application History </a></li>
      	<li class="col-auto"><a href="images/pdf/KP-User-Manual.pdf" target="_blank" class="d-block ">Online Manual</a></li> 
    </ul>
    </div>
	
<div class="container ">
<div class="row justify-content-center no-gutters">
				<!-- Midle -->
<form class="col-lg-12 box-shadow p-0"  name="search" action="" method="post">
 <div class="col-md-12  form-block  col-sm-12 col-xs-12 loginform p-3"> 
	<?php					
	if($_SESSION['error_msg']!=""){
		echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error_msg']."</div>";
		$_SESSION['error_msg']="";
	}
	?>
	<input type="hidden" name="action" value="search" />
	<div class="row">
		<div class="form-group col-12 mb-4">
        <p class="blue">Application Search History &nbsp;&nbsp;</p>
        </div>	

			<?php if(isset($_SESSION['MEMBERTYPE']) && $_SESSION['MEMBERTYPE']=='Agent'){?>
				<div class="col-sm-6 col-md-4">
					<div class="form-group">
						<label class="star">Type (Member / Non-Member):</label>
						<select  class="form-control" name="member_type" id="member_type">
							<option selected="selected" value="">--Select--</option>
							<?php 
								   $sql="select * from  kp_lookup_details where LOOKUP_ID='7'";
								   $result=mysqli_query($conn,$sql);
								   while($rows=mysqli_fetch_array($result))
								   {
								   if($rows['LOOKUP_VALUE_ID']==$_SESSION['member_type'])
								   {
								   echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
								   }else
								   {
								   echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
								   }
								   }
							?>	
						</select>
					</div>
				</div>
			<?php } ?>
				<div class="col-sm-6 col-md-4">
					<div class="form-group">
						<label class="star">App Type (Importer / Exporter):</label>
						<select  class="form-control" name="app_type" id="app_type">
							<option selected="selected" value="">-- Select Type --</option>
							<?php 
							$sql="select * from  kp_lookup_details where LOOKUP_ID='9'";
							$result=mysqli_query($conn,$sql);
							while($rows=mysqli_fetch_array($result))
							{
							    if($rows['LOOKUP_VALUE_CODE']==$_SESSION['app_type'])
							    {
							    echo "<option selected='selected' value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
								} else  {
								   echo "<option value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
								}
							}
							?>	
						</select>						
					</div>
				</div>
				<div class="col-sm-6 col-md-4">
				<div class="form-group">
				<label class="star">Processing Location:</label>
				<select  class="form-control" name="PROCES_CNTR" id="PROCES_CNTR">
				<option value="">-- Select Location --</option>
					<?php
						$sql="select * from  kp_location_master order by LOCATION_NAME asc";
						$result=mysqli_query($conn,$sql);
						while($rows=mysqli_fetch_array($result))
						{
						if($rows[LOCATION_ID]==$_SESSION['PROCES_CNTR'])
							{
								echo "<option  value='$rows[LOCATION_ID]' selected='selected'>$rows[LOCATION_NAME]</option>";
							}
							else
							{
								echo "<option  value='$rows[LOCATION_ID]'>$rows[LOCATION_NAME]</option>";
							}
						}
					?>
				</select>
				</div>
				</div>
								 
				<div class="col-sm-6 col-md-4">
					<div class="form-group">
						<label class="star">From Date:</label>
						<input onkeydown="return false" type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){ echo "From"; } else { echo $_SESSION['from_date']; } ?>" class="form-control" autocomplete="off"/>
					</div>
				</div>
			   <div class="col-sm-6 col-md-4">
					<div class="form-group">
						<label class="star">To Date:</label>
						<input onkeydown="return false" type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="form-control" autocomplete="off"/>
					</div>
				</div>
				
				<div class="col-12">
                    <input class="cta mr-3 d-inline-block fade_anim" type="submit" value="Submit" />	
                    <input class="cta fade_anim" type="submit" value="Reset" name="Reset" id="Reset" />	
				</div>
				<div class="col-12">
				<?php if($_SESSION['MEMBERTYPE']=="Agent"){ ?>
				<p class="blue mt-3"><a href="addmember.php"><b>Click here</b></a> to create your client list by adding Member / NonMember</p>
				<?php } else { ?>
				<p></p>
				<?php } ?>
					<?php 
					if(isset($_SESSION['AGENT_ID'])){
					$sql_import_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where AGENT_ID='".$_SESSION['AGENT_ID']."' and FORM_TYPE='I' and payment_made_status='N'";
					}
					else if(isset($_SESSION['MEMBER_ID'])){
					$sql_import_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where MEMBER_ID='".$_SESSION['MEMBER_ID']."' and FORM_TYPE='I' and payment_made_status='N'";
					}
					else if($_SESSION['NON_MEMBER_ID']){
					$sql_import_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where NON_MEMBER_ID='".$_SESSION['NON_MEMBER_ID']."' and FORM_TYPE='I' and payment_made_status='N'";
					}

					$query_import_pending=mysqli_query($conn,$sql_import_pending);
					$result_import_pending=mysqli_fetch_array($query_import_pending);
					$import_count=$result_import_pending['count'];
					?>
					<?php if($import_count>0){ ?>
					<div class="search_app_div">You have <strong><?php echo $import_count;?></strong> Import Application Pending Payment 
					<a href="payment_cart_i.php">Click Here</a>					
					</div>
					<?php } ?>
					<?php 
					if(isset($_SESSION['AGENT_ID'])){
					$sql_export_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where AGENT_ID='".$_SESSION['AGENT_ID']."' and FORM_TYPE='E' and payment_made_status='N'";
					}
					else if(isset($_SESSION['MEMBER_ID'])){
					$sql_export_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where MEMBER_ID='".$_SESSION['MEMBER_ID']."' and FORM_TYPE='E' and payment_made_status='N'";
					}
					else if($_SESSION['NON_MEMBER_ID']){
					$sql_export_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where NON_MEMBER_ID='".$_SESSION['NON_MEMBER_ID']."' and FORM_TYPE='E' and payment_made_status='N'";
					}

					$query_export_pending=mysqli_query($conn,$sql_export_pending);
					$result_export_pending=mysqli_fetch_array($query_export_pending);
					$export_count=$result_export_pending['count'];
					?>
					<?php if($export_count>0){ ?>
					<div class="search_app_div">You have <strong><?php echo $export_count;?></strong> Export Application Pending Payment					
					<a href="payment_cart_e.php">Click Here</a>					
					</div>
					<?php }?>
				</div>
	
	</div>
</div>
</form>
<div class="row">
<div class="col-12">
<?php if($_SESSION['member_type'] !="" || $_SESSION['app_type']!=""){?>
<div class="content_details1">

<form name="form1" action="" method="POST"> 
<input type="hidden" name="action" value="UPDATE_STATUS" /> 

<table class="tableinfo table table-bordered mt-5">
	<thead>
	<tr>
    <th><strong>Name</strong></th>
    <!--<th><strong>Country Of Destination</strong></th>-->
    <th><strong>Invoice Date</strong></th>
    <th><strong>No of Parcels</strong></th>
    <th><strong>Carat Weight</strong></th>    
    <th><strong>Application Date</strong></th>
    <th><strong>Application Charge</strong></th>
    <th><strong>Total Amount</strong></th>
    <!--<th><strong>Pickup Type</strong></th>-->
    <th><strong>KP Certificate No</strong></th>
	<th><strong>Value in USD</strong></th>
    <?php if($_SESSION['MEMBERTYPE']=="Member"){ ?><th><strong>Advalorem charges</strong></th><?php } ?>
    <th><strong>Application Status</strong></th>
	<th><strong>Download Invoice</strong></th>
    </tr>
	</thead>
 
    <?php
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
  
	if(isset($_SESSION['MEMBERTYPE']) && $_SESSION['MEMBERTYPE']=="Agent")
		$sql="SELECT a.* FROM `kp_export_application_master` a , kp_payment_details b, kp_payment_master c  WHERE 1 and  a.`AGENT_ID`='".$_SESSION['AGENT_ID']."'";
	else if(isset($_SESSION['MEMBERTYPE']) && $_SESSION['MEMBERTYPE']=="Member")
		$sql="SELECT a.*,c.Response_Code,c.STATUS FROM `kp_export_application_master` a , kp_payment_details b, kp_payment_master c  WHERE 1 and  a.`MEMBER_ID`='".$_SESSION['MEMBER_ID']."' ";
	else if(isset($_SESSION['MEMBERTYPE']) && $_SESSION['MEMBERTYPE']=="NonMember")
		$sql="SELECT a.* FROM `kp_export_application_master` a , kp_payment_details b, kp_payment_master c WHERE 1 and  a.`NON_MEMBER_ID`='".$_SESSION['NON_MEMBER_ID']."'";

	if($_SESSION['member_type']!="")
	{
	    $sql.=" and a.MEMBER_TYPE_ID = '".$_SESSION['member_type']."' ";
	}
	
	if($_SESSION['app_type']!="")
	{
		$sql.=" and a.FORM_TYPE = '".$_SESSION['app_type']."' ";
	}
	
	if($_SESSION['delivery_status']!="")
	{
		$sql.=" and a.PICKUP_TYPE='".$_SESSION['delivery_status']."' ";
	}

	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
		$sql.=" and a.EXP_APP_DATE between '".date("Y-m-d",strtotime($_SESSION['from_date']))." 00:00:00' and '".date("Y-m-d",strtotime($_SESSION['to_date']))." 00:00:00'";
	}
	if($_SESSION['PROCES_CNTR']!=""){
		$sql.=" and a.PROCES_CNTR='".$_SESSION['PROCES_CNTR']."' ";
	}
	$sql.=" and a.EXPORT_APP_ID=b.EXPORT_APP_ID and b.PAYMENT_MST_ID=c.PAYMENT_MST_ID order by a.EXPORT_APP_ID";
	//echo $sql;
	
 	$result=mysqli_query($conn,$sql);
	$rCount=mysqli_num_rows($result);	

	$sql1=$sql." limit $start, $limit"; 
	
	//echo $sql1;
	
	$result1=mysqli_query($conn,$sql1);
		
  if($rCount>0)
  {	
  while($rows=mysqli_fetch_array($result1))
  {		
	$PAYMENT_MST_ID=getPAYMENTMSTID($conn,$rows['EXPORT_APP_ID']);
	$getAdvol_Exchange_rate = round(getAdvol_Exchange_rate($conn,$PAYMENT_MST_ID),2);
	$getAdvol_Amount = round(getAdvol_Amount($conn,$PAYMENT_MST_ID),2); 
	$getAdvol_RESPONSE_CODE=getAdvol_Response($conn,$PAYMENT_MST_ID);
	$RESPONSE_CODE = $rows['Response_Code'];
	$STATUS = $rows['STATUS'];
  ?>
  <tr bgcolor="#ededed">
    <td style="padding:3px;" class="kim">
    <a href="search_application_detail.php?ID=<?php echo $rows['EXPORT_APP_ID'];?>">
	<?php
	if($_SESSION['member_type']=="18")
		echo getMemberName($conn,'Member',$rows['MEMBER_ID']);
	else if($_SESSION['member_type']=="19")
		echo getNonMemberName($conn,'NonMember',$rows['NON_MEMBER_ID']);
	else 
		echo $_SESSION['USERNAME'];
	?>	
   	</a>
    </td>
    <!--<td><?php echo getOrginCountryName($conn,$rows['COUNTRY_DEST_ID']);?></td>-->
    <td><?php if($rows['INVOICE_DATE']!=""){echo date("d-m-Y",strtotime($rows['INVOICE_DATE']));}?></td>
    <td><?php echo $rows['NUMBER_OF_PARCELS'];?></td>
    <td><?php echo $rows['TOTAL_WGHT'];?></td>   
    <td><?php if($rows['EXP_APP_DATE']!=""){echo date("d-m-Y",strtotime($rows['EXP_APP_DATE']));}?></td>
    <td><?php echo $rows['FEES_AMOUNT'];?></td>
    <td>
	<?php echo $rows['TOTAL_AMOUNT'];?>
	<?php if($_SESSION['MEMBERTYPE']=="Member"){ ?>
	<hr/>
	<?php if($RESPONSE_CODE=="E000" || $STATUS==85 || $STATUS==95){ ?>
	<a class="btn btn-success"> Done</a>
	<?php } else { ?>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
	<input type="hidden" name="EXPORT_APP_ID" value="<?php echo $rows['EXPORT_APP_ID']; ?>">
	<input type="hidden" name="TOTAL_AMOUNT" value="<?php echo base64_encode($rows['TOTAL_AMOUNT']); ?>">
	<input type="submit" name="PAY" value="PAY" class="btn btn-success"> 
	</form>
	<?php } ?>
	<?php } ?>
	</td>
    <!--<td><?php echo $rows['PICKUP_TYPE'];?></td>-->
    <td><?php echo $rows['KP_CERT_NO'];?></td> 
    <td><?php echo $rows['USD_AMOUNT'];?></td>
	<?php if($_SESSION['MEMBERTYPE']=="Member"){ ?>
	<td>
	<?php //echo $getAdvol_Exchange_rate.'=='. $getAdvol_Amount.'=='.  $PAYMENT_MST_ID;
	if($getAdvol_Exchange_rate!='' && $getAdvol_Amount!='' && $PAYMENT_MST_ID!=''){
	if($getAdvol_RESPONSE_CODE!="E000"){ ?>
	<?php echo $getAdvol_Amount;?><hr/><a EXPORT_APP_ID=<?php echo $rows['EXPORT_APP_ID']; ?> advol_exchange_rate="<?php echo $getAdvol_Exchange_rate;?>" advol_amount="<?php echo $getAdvol_Amount;?>" class="modalcaller btn btn-success" data-toggle="modal" href='#modal-id'> PAY</a>
	<?php } else { ?> <a class="btn btn-success"> Done</a><?php }
	}  ?>
	</td>
	<?php } ?>
    <td>
	<?php 
	if(KP_DELIVERY_STATUS($conn,$PAYMENT_MST_ID)=="Y")
		echo '<img src="images/active.png">';
	else
		echo '<img src="images/pending.gif">';
	?>
	</td>
	<td>
	<?php 
	if(KP_INVOICE_STATUS($conn,$PAYMENT_MST_ID)=="Y")
		echo '<a href=invoice.php?EXPORT_APP_ID='.$rows['EXPORT_APP_ID'].' target="_blank"><img src="images/print.png"></a>';//echo "<a href='invoice.php?EXPORT_APP_ID=$rows['EXP_APP_DATE']'>Clcik Here</a>";
	else	
		echo '<img src="images/not-available.png">';
	?>
	</td>   
  </tr>
  
  <?php
   $i++;
  }
   
   ?>
   <!--<tr>
    <td colspan="11"><input type="submit" name="Change Location" value="Change Location"  class="input_submit" /></td>
   </tr>-->
   <?php 
  }
   else
   {
   ?>
   <tr>
     <td colspan="12">Records Not Found</td>
   </tr>
  
   <?php  } ?>  
</table>

	<div class="modal fade" id="modal-id">
	<div class="modal-dialog" style="max-width:700px;">
		<div class="modal-content">
			<div class="modal-header"><h4 class="modal-title">Advalorem Payment</h4></div>
			
			<form action="#" method="POST" name="advolID" id="advolID" onSubmit="return loginvalidate()">
			<div class="modal-body">
			<div class="form-group">
				<div class="row mb-3">
                <label for="concept" class="col-auto control-label">Exchange Rate :</label>
                <div class="col-sm-5"> 
				<input id="advol_exchange_rate_show" readonly/>				
				</div>
                </div>
				<div class="row mb-3">
                <label for="concept" class="col-auto control-label">Advalorem Amount (including GST) :</label>
                <div class="col-sm-5"><input id="advol_amount_show" readonly/>	</div>
                </div>
				<div class="row mb-3">
                <label for="concept" class="col-auto control-label">TDS :</label>
                <div class="col-sm-5">
				<select class="textField" name="tds_tax" id="tds_tax" required>
				<option value="0">0% </option>
				<option value="1.5">1.5% </option>
				</select>
				</div>
                </div>
				<div class="row mb-3">
                <label for="concept" class="col-auto control-label">TDS Amount :</label>
                <div class="col-sm-5"><input name="tds_amount" id="tds_amount" type="text" class="textField" readonly/></div>
                </div>
				<div class="row mb-3">
                <label for="concept" class="col-auto control-label">Net Payable :</label>
                <div class="col-sm-5"><input name="advol_net_payable_amount" id="advol_net_payable_amount" type="text" class="textField" readonly/></div>
                </div>
            </div>                   
						
			<div class="modal-footer">
			<p class="error"> <b>Note : </b>As per view of our Tax Consultant TDS u/s 194 C or 194J is not applicable on payment for Generic Promotion Fund</p>
			<input type="hidden" name="action" value="save"/>
			<input type="hidden" name="EXPORT_APP_ID" id="EXPORT_APP_ID" value="<?php echo $_GET['EXPORT_APP_ID'];?>" />
			<input type="hidden" name="advol_exchange_rate" id="advol_exchange_rate"/>
			<input type="hidden" name="advol_amount" id="advol_amount"/>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" name="sub" id="sub" class="btn btn-success">Pay Now</button>				
			</div>
			</div>
			</form>
			
		</div>
	</div>
	</div>

</form>
</div>  
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
} 

?>	
<div class="pages_1">Total number of Application: <?php echo $rCount;?><?php echo pagination($limit,$page,'kimberley_process_search_applications.php?action=view&page=',$rCount); //call function to show pagination?></div>        

<?php } ?> 
		</div>
	   </div>	
	   </div>
	   <!-- Middle -->
	   </div>	
    </div>   

</section>

<?php include('include-new/footer.php');?>
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
<script type="text/javascript">
jQuery(".modalcaller").click(function(event){
	// console.log($(this).attr('EXPORT_APP_ID'));
	jQuery("#EXPORT_APP_ID").val($(this).attr('EXPORT_APP_ID'));
	var advol_exchange_rate = $(this).attr('advol_exchange_rate');
	 $('#advol_exchange_rate_show').val(advol_exchange_rate);
	 $('#advol_exchange_rate').val(advol_exchange_rate);
	 
	var advol_amount = $(this).attr('advol_amount');
	 $('#advol_amount_show').val(advol_amount);
	 $('#advol_amount').val(advol_amount);

});
</script>
<script type="text/javascript">
    $(function () {
		$("#tds_tax").on('change',function(){
			var tds_tax=$('#tds_tax').val();
			var advol_amount_show = $('#advol_amount_show').val();
			var tds_amount = advol_amount_show*tds_tax/100;
			$("#tds_amount").val(tds_amount.toFixed(2));
			
			var advol_net_payable_amount = advol_amount_show-tds_amount;
			$("#advol_net_payable_amount").val(advol_net_payable_amount.toFixed(2));
		});
    });
</script>
<script type="text/javascript">
	$('#modal-id').on('shown.bs.modal', function () {
			var tds_tax=$('#tds_tax').val(); //alert(tds_tax);
			var advol_amount_show = $('#advol_amount_show').val();
			var tds_amount = advol_amount_show*tds_tax/100; //alert(tds_amount);
			$("#tds_amount").val(tds_amount.toFixed(2));
			
			var advol_net_payable_amount = advol_amount_show-tds_amount;
			$("#advol_net_payable_amount").val(advol_net_payable_amount.toFixed(2));	
});	
</script>