<?php
session_start();
include('db.inc.php');
include('functions.php');
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getAmounts"){
	$myarray=$_POST['myCheckboxes'];
	$export_app_id=explode(",",$myarray);
	
	$query_loc=mysqli_query($conn,"select TOTAL_AMOUNT,LOC_PICKUP_ID from kp_export_application_master where EXPORT_APP_ID='".$export_app_id[0]."'");
     $result_loc=mysqli_fetch_array($query_loc);
	 $location=$result_loc['LOC_PICKUP_ID'];
	//print_r($export_app_id);
	$tot_amount=0;
	foreach($export_app_id as $val)
    { //echo "select TOTAL_AMOUNT,LOC_PICKUP_ID from kp_export_application_master where EXPORT_APP_ID='$val' and LOC_PICKUP_ID='$location'";
      $query = mysqli_query($conn,"select TOTAL_AMOUNT,LOC_PICKUP_ID from kp_export_application_master where EXPORT_APP_ID='$val' and LOC_PICKUP_ID='$location'");
	  $num=mysqli_num_rows($query);
	  $result=mysqli_fetch_array($query);
	  if($num>0){
	  $amount = $result['TOTAL_AMOUNT'];
      $tot_amount+=$amount;
	 }
	 else
	 {
	 	echo "error";
	 }
    }
	echo $tot_amount;	
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getAmount"){
	$export_app_id=$_POST['export_app_id'];
	
	 $query_tot=mysqli_query($conn,"select TOTAL_AMOUNT from kp_export_application_master where EXPORT_APP_ID='".$export_app_id."'");
     $result_tot=mysqli_fetch_array($query_tot);
	 $TOTAL_AMOUNT=$result_tot['TOTAL_AMOUNT'];
	 if($TOTAL_AMOUNT==0)
		echo "error";
	echo $TOTAL_AMOUNT;
} 
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getbranch"){
	$bank_id=$_POST['bank_id'];
	
	 $query=mysqli_query($conn,"select BANK_NAME,BRANCH_NAME from kp_bank_branch_master where BANK_ID='$bank_id'");
	 $result=mysqli_fetch_array($query);
	 echo $bank_name=$result['BANK_NAME']."#";
	 echo $branch_name=$result['BRANCH_NAME'];
 }
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteImporter"){
	$EXPORT_APP_ID=$_POST['EXPORT_APP_ID'];
	mysqli_query($conn,"delete from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'");
	mysqli_query($conn,"delete from kp_expimp_tran_detail where EXPORT_APP_ID='$EXPORT_APP_ID'");
 } 
?>
<?php /*
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteImporter"){
	$EXPORT_APP_ID=$_POST['EXPORT_APP_ID'];
	$EXPORT_APP_ID=explode(",",$EXPORT_APP_ID);
	foreach($EXPORT_APP_ID as $val)
    {
	 $query1 =  mysqli_query($conn,"delete from kp_export_application_master where EXPORT_APP_ID='$val'");
	 $query2 = mysqli_query($conn,"delete from kp_expimp_tran_detail where EXPORT_APP_ID='$val'");
	}
 }*/
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getAddress")
{ //echo '--'.$_POST['Member_id'];
	$array=explode("|", $_POST['Member_id']);
	$Member_id=$array[1];
	echo $Member_type=$array[0]."|";
	echo $MEMBER_STATUS=getMembershipStatus($Member_id)."|";
	 
?>
<option value="">--select--</option> 
<?php
	if($array[0]=='member')
	{ 
		$query=mysqli_query($conn,"SELECT * FROM `kp_member_address_details` where MEMBER_ID='$Member_id' and ADDRESS_IDENTITY='CTC' AND STATUS='1'");
		while($result=mysqli_fetch_array($query)){
		?>
        <option value="<?php echo $result['MEMBER_ADD_ID'];?>"><?php echo $result['MEMBER_CO_NAME']." ".$result['MEMBER_ADDRESS1']?></option>
     <?php       
		}
	} else	{ 
		$query=mysqli_query($conn,"SELECT * FROM `kp_non_member_master` where NON_MEMBER_ID='$Member_id' AND status='1'");
		while($result=mysqli_fetch_array($query)){
		?>
        <option value="<?php echo $result['NON_MEMBER_ID'];?>"><?php echo $result['NON_MEMBER_NAME']." ".$result['ADDRESS1']?></option>
       <?php
	   } 
	}	
} ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getAddressDetail"){
	 $array=explode("|", $_POST['Member_id']);
	 $Member_id=$array[1];
	 
	$MEMBER_ADD_ID=$_POST['M_ADD_SR_NO'];
	if($array[0]=='member')
	{
		$query=mysqli_query($conn,"SELECT * FROM `kp_member_address_details` where MEMBER_ID='$Member_id' and MEMBER_ADD_ID='$MEMBER_ADD_ID' AND STATUS='1'");
		$result=mysqli_fetch_array($query);
		echo strtoupper(str_replace('&amp;', '&', $result['MEMBER_CO_NAME']))."#";
		echo $result['MEMBER_ADDRESS1']."#";
		echo $result['CITY']."#";
		echo $result['STATE']."#";
		echo $result['PINCODE']."#";
		echo $result['COUNTRY']."#";
	} else	{
		$query=mysqli_query($conn,"SELECT * FROM `kp_non_member_master` where NON_MEMBER_ID='$Member_id' AND status='1'");
		$result=mysqli_fetch_array($query);
		echo $result['NON_MEMBER_NAME']."#";
		echo $result['ADDRESS1']." ".$result['ADDRESS2']."".$result['ADDRESS3']."#";
		echo $result['CITY']."#";
		echo $result['STATE_ID']."#";
		echo $result['PINCODE']."#";
		echo $result['COUNTRY']."#";
	}
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="addIEDetail"){
	$APPLICANT_ID=$_POST['APPLICANT_ID'];
	$HS_CODE_ID=$_POST['HS_CODE_ID'];
	$WEIGHT=$_POST['WEIGHT'];
	$COUNTRY_ID=$_POST['COUNTRY_ID'];
	$AMOUNT=$_POST['AMOUNT'];
	
	mysqli_query($conn,"insert into kp_expimp_temp_tran_detail set MEMBER_ID='$APPLICANT_ID',HS_CODE_ID='$HS_CODE_ID',COUNTRY_ID='$COUNTRY_ID',WEIGHT='$WEIGHT',AMOUNT='$AMOUNT'");
?>
<table >
  <tr align="center" bgcolor="#EEEEEE">
    <td height="30"><strong>Select</strong></td>
    <td><strong>H S Code Number</strong></td>
    <td><strong>Card Weight / Mass</strong></td>
    <td><strong>Country of Origin</strong></td>
    <td><strong>Values In USD</strong></td>
  </tr>
<?php 
$query=mysqli_query($conn,"select * from kp_expimp_temp_tran_detail where MEMBER_ID='$APPLICANT_ID'");	
while($result=mysqli_fetch_array($query)){
?>
  <tr>
    <td align="center"><label><input type="checkbox" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>" /> 
    <input type="hidden" name="HS_CODE_APP_ID_temp[]" id="HS_CODE_APP_ID_temp[]" value="<?php echo $result['HS_CODE_APP_ID'];?>"/></label></td>
    <td align="center"><?php echo getHSCode($conn,$result['HS_CODE_ID']);?></td>
    <td align="center"><?php echo $result['WEIGHT'];?></td>
    <td align="center"><?php echo getOrginCountryName($conn,$result['COUNTRY_ID']);?></td>
    <td align="center"><?php echo $result['AMOUNT'];?></td>
  </tr>
<?php }?>
<tr>
    <td height="30" align="center"><img src="images/delete.png" id="delete_hs_code" style="cursor:pointer;" onClick="return(window.confirm('Are you sure you want to delete?'));";/></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?php }?>


<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteHscode"){
	$HS_CODE_APP_ID=$_POST['HS_CODE_APP_ID'];
	$HS_CODE_APP_ID=explode(",",$HS_CODE_APP_ID);
	$APPLICANT_ID=$_POST['APPLICANT_ID'];
	foreach($HS_CODE_APP_ID as $val)
    {
	 $query=mysqli_query($conn,"delete from kp_expimp_temp_tran_detail where  HS_CODE_APP_ID ='$val'");
	}
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse; margin:20px 0 20px 0;font-size:12px; border-color:#ccc; " >
  <tr align="center" bgcolor="#EEEEEE">
    <td height="30"><strong>Select</strong></td>
    <td><strong>H S Code Number</strong></td>
    <td><strong>Card Weight / Mass</strong></td>
    <td><strong>Country of Origin</strong></td>
    <td><strong>Values In USD</strong></td>
  </tr>
<?php 
$query=mysqli_query($conn,"select * from kp_expimp_temp_tran_detail where MEMBER_ID='$APPLICANT_ID'");	
$i=0;
while($result=mysqli_fetch_array($query)){
?>
  <tr>
    <td align="center"><label><input type="checkbox" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>" /><input type="hidden" name="HS_CODE_APP_ID_temp[]" id="HS_CODE_APP_ID_temp[]" value="<?php echo $result['HS_CODE_APP_ID'];?>"/></label></td>
    <td align="center"><?php echo getHSCode($conn,$result['HS_CODE_ID']);?></td>
    <td align="center"><?php echo $result['WEIGHT'];?></td>
    <td align="center"><?php echo getOrginCountryName($conn,$result['COUNTRY_ID']);?></td>
    <td align="center"><?php echo $result['AMOUNT'];?></td>
  </tr>
<?php $i++;}?>
<?php if($i>=1){?>
<tr>
    <td height="30" align="center"><img src="images/delete.png" id="delete_importer" style="cursor:pointer;" onClick="return(window.confirm('Are you sure you want to delete?'));";/></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <?php }?>
</table>	
<?php }?>




<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getState")
{
$COUNTRY_ID=$_POST['COUNTRY_ID'];
echo "<label class='star'>State</label>";
$query=mysqli_query($conn,"SELECT * FROM `kp_state_master` WHERE status='1' AND `country_code` = '$COUNTRY_ID'");
if($COUNTRY_ID=="IN"){ ?>
    <select  class="search_app_bg_text" id="stateDiv" name="STATE_ID">
	<option value="">--Select--</option>
	<?php while($result=mysqli_fetch_array($query)){?>
    <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
    <?php }?>
    </select>
<?php } else { ?>
<input type="text" class="form-control" maxlength="15" autocomplete="off" id="STATE" name="STATE" />
<?php 
}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity")
{
$STATE_ID=$_POST['STATE_ID'];
$query=mysqli_query($conn,"SELECT * FROM  `kp_city_master` WHERE  `LSTATE_CODE` = '$STATE_ID' order by LCDESC asc");
?>
    <select class="search_app_bg_text" id="CITY" name="CITY">
	<option selected="selected" value="">--Select--</option>
	<?php while($result=mysqli_fetch_array($query)){?>
    <option value="<?php echo $result['LCDESC'];?>"><?php echo $result['LCDESC'];?></option>
    <?php }?>
    </select>
<?php
}

if(isset($_POST['action']) && $_POST['action']=="getCountryRelatedExporterName" ){
	 $COUNTRY_DEST_ID = $_POST['COUNTRY_DEST_ID'];
	 $sqlExporters = "select * from kp_foreign_imp_master Where COUNTRYID ='$COUNTRY_DEST_ID'";
	 $resultExporters = mysqli_query($conn,$sqlExporters);
     $output = "";
     $output .= '<option value="">--Select--</option>'; 
	 while($rowExporters = mysqli_fetch_array($resultExporters)){ 
	 	$PARTY_ID  =$rowExporters['PARTY_ID'];
	 	$LONGNAME  =$rowExporters['LONGNAME'];
        $output .=  "<option value=".$PARTY_ID .">".$LONGNAME."</option>";
	  }
	  echo json_encode(array('output' => $output ));
}

if(isset($_POST['action']) && $_POST['action']=="getExportersDetails" ){
	 $PARTY_ID = $_POST['PARTY_ID'];
	 $sqlExporters = "select * from kp_foreign_imp_master Where PARTY_ID ='$PARTY_ID'";
	 $resultExporters = mysqli_query($conn,$sqlExporters);
	 $count = mysqli_num_rows($resultExporters);
	 if($count>0){
	 	while($rowExporters = mysqli_fetch_array($resultExporters)){
	    $IE_PARTY_NAME=$rowExporters['LONGNAME'];
		$IE_ADDRESS1=$rowExporters['ADDRESS1'];
		$IE_ADDRESS2=$rowExporters['ADDRESS2'];
		$IE_ADDRESS3=$rowExporters['ADDRESS3'];
		$IE_COUNTRY=$rowExporters['COUNTRYID'];
		$IE_TEL1=$rowExporters['PHONE1'];
		$IE_TEL2=$rowExporters['PHONE2'];
		$IE_FAX=$rowExporters['FAX1'];
		$IE_CITY=$rowExporters['CITY_NAME'];
		$IE_PIN=$rowExporters['PINCODE'];
	 	}
	 }else{
	 	 $IE_PARTY_NAME="";
		$IE_ADDRESS1="";
		$IE_ADDRESS2="";
		$IE_ADDRESS3="";
		$IE_COUNTRY="";
		$IE_TEL1="";
		$IE_TEL2="";
		$IE_FAX="";
		$IE_CITY="";
		$IE_PIN="";
	 }
	   echo json_encode(array('IE_PARTY_NAME' => $IE_PARTY_NAME,'IE_ADDRESS1'=>$IE_ADDRESS1,'IE_ADDRESS2'=>$IE_ADDRESS2,
	  	'IE_ADDRESS3'=>$IE_ADDRESS3,'IE_COUNTRY'=>$IE_COUNTRY,'IE_TEL1'=>$IE_TEL1,'IE_TEL2'=>$IE_TEL2,'IE_FAX'=>$IE_FAX,
	  	'IE_CITY'=>$IE_CITY,'IE_PIN'=>$IE_PIN ));exit;

}


?>