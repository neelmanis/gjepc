<?php session_start(); ?>
<?php 
include('../db.inc.php');
include('../functions.php');
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getAmount"){
	$myarray=$_POST['myCheckboxes'];
	$export_app_id=explode(",",$myarray);
	
	$query_loc=mysqli_query($conn,"select TOTAL_AMOUNT,LOC_PICKUP_ID from kp_export_application_master where EXPORT_APP_ID='".$export_app_id[0]."'");
     $result_loc=mysqli_fetch_array($query_loc);
	 $location=$result_loc['LOC_PICKUP_ID'];
	//print_r($export_app_id);
	 $tot_amount=0;
	foreach($export_app_id as $val)
    {
	
      $query=mysqli_query($conn,"select TOTAL_AMOUNT,LOC_PICKUP_ID from kp_export_application_master where EXPORT_APP_ID='$val' and LOC_PICKUP_ID='$location'");
	  $num=mysql_num_rows($query);
	  $result=mysqli_fetch_array($query);
	  if($num>0){
	  $amount=$result['TOTAL_AMOUNT'];
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
	$EXPORT_APP_ID=explode(",",$EXPORT_APP_ID);
	foreach($EXPORT_APP_ID as $val)
    {
	 $query=mysqli_query($conn,"delete from kp_export_application_master where EXPORT_APP_ID='$val'");
	}
 }
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getAddress"){
	$array=explode("|", $_POST['Member_id']);
	$Member_id=$array[1];
	echo $Member_type=$array[0]."|";	
?>
<option value="">--select--</option>
<?php
	if($array[0]=='member')
	{
		$query=mysqli_query($conn,"SELECT * FROM `kp_member_address_details` where MEMBER_ID='$Member_id'");
		while($result=mysqli_fetch_array($query)){
			?>
            <option value="<?php echo $result['MEMBER_ADD_ID'];?>"><?php echo $result['MEMBER_CO_NAME']." ".$result['MEMBER_ADDRESS1']?></option>
     <?php       
		}
	}else
	{
		$query=mysqli_query($conn,"SELECT * FROM `kp_non_member_master` where NON_MEMBER_ID='$Member_id'");
		while($result=mysqli_fetch_array($query)){
		?>
        <option value="<?php echo $result['NON_MEMBER_ID'];?>"><?php echo $result['NON_MEMBER_NAME']." ".$result['ADDRESS1']?></option>
       <?php
	   } 
	}	
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getAddressDetail"){
	
	$M_ADD_SR_NO=$_POST['M_ADD_SR_NO'];
	$MEMBER_ID=$_POST['MEMBER_ID'];
	
	$query=mysqli_query($conn,"SELECT * FROM `kp_member_address_details` where MEMBER_ID='$MEMBER_ID' and MEMBER_ADD_ID='$M_ADD_SR_NO'");
	$result=mysqli_fetch_array($query);
	echo $result['MEMBER_CO_NAME']."#";
	echo $result['MEMBER_ADDRESS1']." ".$result['MEMBER_ADDRESS2']."".$result['MEMBER_ADDRESS3']."#";
	echo $result['CITY']."#";
	echo $result['STATE']."#";
	echo $result['PINCODE']."#";
	echo $result['COUNTRY']."#";
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getForeignParty"){
	$COUNTRY_DEST_ID=$_POST['COUNTRY_DEST_ID'];
	$query=mysqli_query($conn,"select * from kp_foreign_imp_master where COUNTRYID='$COUNTRY_DEST_ID'");
	echo "<option value=''>--Select Importer--</option>";
	while($result=mysqli_fetch_array($query)){
?>
    <option value="<?php echo $result['PARTY_ID'];?>"><?php echo $result['LONGNAME'];?></option>
<?php
	} 
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getForeignPartyAddress"){
	$PARTY_ID=$_POST['PARTY_ID'];
	$query=mysqli_query($conn,"select * from kp_foreign_imp_master where PARTY_ID='$PARTY_ID'");
	$result=mysqli_fetch_array($query);
	echo $result['LONGNAME']."#";
	echo $result['ADDRESS1']."#";
	echo $result['ADDRESS2']."#";
	echo $result['CITY_NAME']."#";
	echo $result['PINCODE']."#";
	echo $result['COUNTRYID']."#";
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="addIEDetail"){
	$EXPORT_APP_ID=$_POST['EXPORT_APP_ID'];
	$HS_CODE_ID=$_POST['HS_CODE_ID'];
	$WEIGHT=$_POST['WEIGHT'];
	$COUNTRY_ID=$_POST['COUNTRY_ID'];
	$AMOUNT=$_POST['AMOUNT'];
	$ENTERED_ON=date('Y-m-d H:i:s');
	$MODIFIED_BY=$_SESSION['curruser_contact_name'];
	/*.............................Last HS_SUB_SR_NO ....................................*/ 	
	mysqli_query($conn,"insert into kp_expimp_tran_detail set EXPORT_APP_ID='$EXPORT_APP_ID',HS_SUB_SR_NO='0',HS_CODE_ID='$HS_CODE_ID',COUNTRY_ID='$COUNTRY_ID',WEIGHT='$WEIGHT',AMOUNT='$AMOUNT',ENTERED_BY='$ENTERED_BY',ENTERED_ON='$ENTERED_ON',MODIFIED_ON='$ENTERED_ON',MODIFIED_BY='$MODIFIED_BY'");
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
$query=mysqli_query($conn,"select * from kp_expimp_tran_detail where EXPORT_APP_ID='$EXPORT_APP_ID'");	
while($result=mysqli_fetch_array($query)){
?>
  <tr>
    <td align="center"><label><input type="checkbox" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>" /> 
    <input type="hidden" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>"/></label></td>
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
	$EXPORT_APP_ID=$_POST['EXPORT_APP_ID'];
	$HS_CODE_APP_ID=$_POST['HS_CODE_APP_ID'];
	$HS_CODE_APP_ID=explode(",",$HS_CODE_APP_ID);
	
	foreach($HS_CODE_APP_ID as $val)
    {
	  $query=mysqli_query($conn,"delete from kp_expimp_tran_detail where  HS_CODE_APP_ID ='$val'");
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
$query=mysqli_query($conn,"select * from kp_expimp_tran_detail where EXPORT_APP_ID='$EXPORT_APP_ID'");	
$i=0;
while($result=mysqli_fetch_array($query)){
?>
  <tr>
    <td align="center"><label><input type="checkbox" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>" /><input type="hidden" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>"/></label></td>
    <td align="center"><?php echo getHSCode($conn,$result['HS_CODE_ID']);?></td>
    <td align="center"><?php echo $result['WEIGHT'];?></td>
    <td align="center"><?php echo getOrginCountryName($conn,$result['COUNTRY_ID']);?></td>
    <td align="center"><?php echo $result['AMOUNT'];?></td>
  </tr>
<?php $i++;}?>
<?php if($i>=1){?>
<tr>
    <td height="30" align="center"><img src="images/delete.png" id="delete_hs_code" style="cursor:pointer;" onClick="return(window.confirm('Are you sure you want to delete?'));";/></td>
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

$query=mysqli_query($conn,"SELECT * FROM  `kp_state_master` WHERE  `LCCOUNTRY` = '$COUNTRY_ID'");
if($COUNTRY_ID=="1")
{
?>
    <select  class="search_app_bg_text" id="STATE_ID" name="STATE_ID">
	<option value="">--Select--</option>
	<?php while($result=mysqli_fetch_array($query)){?>
    <option value="<?php echo $result['LCMINOR'];?>"><?php echo $result['LCDESC'];?></option>
    <?php }?>
    </select>

<?php } else {?>
<input type="text" class="search_app_bg_text" id="STATE" name="STATE" />
<?php 
}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity")
{
$STATE_ID=$_POST['STATE_ID'];

$query=mysqli_query($conn,"SELECT * FROM  `kp_city_master` WHERE  `LCSTATE` = '$STATE_ID'");

?>
    <select  class="search_app_bg_text" id="CITY" name="CITY">
	<option selected="selected" value="">--Select--</option>
	<?php while($result=mysqli_fetch_array($query)){?>
    <option value="<?php echo $result['LCDESC'];?>"><?php echo $result['LCDESC'];?></option>
    <?php }?>
    </select>
<?php

}
?>


