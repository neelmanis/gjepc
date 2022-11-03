<?php include('header_include.php');?>
<?php 
if(isset($_POST['Member']))
{
	$array=explode("|", $_POST['Member']);
} else {
	$array=explode("|", $_POST['Member1']);
}
//print_r($_POST['Member']);
$Member_type=$array[0];
$PROCES_CNTR=$_POST['PROCES_CNTR'];
$EXP_APP_DATE=date('Y-m-d H:i:s');

$M_ADD_SR_NO=$_POST['M_ADD_SR_NO'];
$COUNTRY_DEST_ID=$_POST['COUNTRY_DEST_ID'];
$AGENT_ID=$_POST['AGENT_ID'];
if($Member_type=="member"){$MEMBER_ID=$array[1];
$MEMBER_VAL=18;
}else {$MEMBER_ID="";}
if($Member_type=="nonmember"){$NON_MEMBER_ID=$array[1];
$MEMBER_VAL=19;
}else {$NON_MEMBER_ID="";}

$INVOICE_DATE = date('Y-m-d',strtotime($_POST['INVOICE_DATE']));
$INVOICE_NO = trim($_POST['INVOICE_NO']); 
$KP_CERT_ISSUE_DATE=date('Y-m-d',strtotime($_POST['KP_CERT_ISSUE_DATE']));
$KP_CERT_EXPIRY_DATE=date('Y-m-d',strtotime($_POST['KP_CERT_EXPIRY_DATE'])); 

$NUMBER_OF_PARCELS = filter($_POST['NUMBER_OF_PARCELS']); 
$Declaration = $_POST['Declaration'];

$FEES_AMOUNT = trim($_POST['FEES_AMOUNT']); 
$COURIER_AMOUNT=$_POST['COURIER_AMOUNT'];
$TOTAL_AMOUNT=$_POST['TOTAL_AMOUNT'];
$IE_PARTY_NAME=addslashes($_POST['IE_PARTY_NAME']);
$IE_PARTY_ID = trim($_POST['PARTY_ID']);
$IE_ADDRESS1 = filter($_POST['IE_ADDRESS1']);
$IE_TEL1 = $_POST['IE_TEL1'];
$IE_ADDRESS2 = filter($_POST['IE_ADDRESS2']);
$IE_TEL2=$_POST['IE_TEL2'];
$IE_ADDRESS3 = filter($_POST['IE_ADDRESS3']);
$IE_FAX = filter($_POST['IE_FAX']);
$IE_CITY = filter($_POST['IE_CITY']);
$IE_PIN = filter($_POST['IE_PIN']);
$IE_COUNTRY = $_POST['IE_COUNTRY'];

$M_DATE=$_POST['M_DATE'];
$M_COMPANY_NAME = filter($_POST['M_COMPANY_NAME']);
$M_ADDRESS = filter($_POST['M_ADDRESS']);
$M_CITY = filter($_POST['M_CITY']);
$M_STATE=$_POST['M_STATE'];
$M_PIN=$_POST['M_PIN'];
$M_COUNTRY=$_POST['M_COUNTRY'];

$Exporter_Name=$_POST['Exporter_Name'];

$C_COMPANY_NAME=$_POST['C_COMPANY_NAME'];
$C_ADDRESS1=$_POST['C_ADDRESS1'];
$C_TELEPHONE1=$_POST['C_TELEPHONE1'];
$C_ADDRESS2=$_POST['C_ADDRESS2'];
$C_TELEPHONE2=$_POST['C_TELEPHONE2'];
$C_ADDRESS3=$_POST['C_ADDRESS3'];
$C_FAX=$_POST['C_FAX'];
$C_CITY=$_POST['C_CITY'];
$C_PIN=$_POST['C_PIN'];
$C_COUNTRY=$_POST['C_COUNTRY'];
$C_TELEPHONE1=$_POST['C_TELEPHONE1'];
$C_TELEPHONE1=$_POST['C_TELEPHONE1'];
$C_TELEPHONE1=$_POST['C_TELEPHONE1'];

$ENTERED_BY = trim($_SESSION['USERNAME']);
$ENTERED_ON = date('Y-m-d H:i:s');
$PICKUP_TYPE = $_POST['PAYMENT_MODE'];
$KP_CERT_NO = str_replace(' ','',$_POST['KP_CERT_NO']); 
$KP_BATCH_NO = str_replace(' ','',$_POST['KP_BATCH_NO']); 
$LOC_PICKUP_ID=$_POST['PROCES_CNTR'];
$COUNTRY_PROV_ID=$_POST['COUNTRY_DEST_ID'];

$sql="select AGENT_MEM_LINK_ID from kp_agent_member_link where AGENT_ID='$AGENT_ID'";
if($MEMBER_ID!=""){$sql.=" and MEMBER_ID='$MEMBER_ID'";}
if($NON_MEMBER_ID!=""){$sql.=" and NON_MEMBER_ID='$NON_MEMBER_ID'";}
$querys=mysqli_query($conn,$sql);
$result=mysqli_fetch_array($querys);
$nums=mysqli_num_rows($querys);
if($nums>0){$AGENT_MEM_LINK_ID=$result['AGENT_MEM_LINK_ID'];}
else{$AGENT_MEM_LINK_ID="";}

$APPLICANT_ID=$_POST['APPLICANT_ID'];
$qusd=mysqli_query($conn,"select sum(WEIGHT) as TOTAL_WGHT,sum(AMOUNT) as USD_AMOUNT from kp_expimp_temp_tran_detail where MEMBER_ID='$APPLICANT_ID'");
$rusd=mysqli_fetch_array($qusd);

$TOTAL_WGHT=$rusd['TOTAL_WGHT'];
$USD_AMOUNT=$rusd['USD_AMOUNT'];
$EXPORT_APP_ID=$_REQUEST['EXPORT_APP_ID'];
/*.............................Check Update......................................*/
$query = mysqli_query($conn,"select * from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'");
$num = mysqli_num_rows($query);

if($num>0)
{
$sql_exp ="update `kp_export_application_master` set PROCES_CNTR='$PROCES_CNTR',`EXP_APP_DATE`='$EXP_APP_DATE', `COUNTRY_DEST_ID`='$COUNTRY_DEST_ID', `AGENT_ID`='$AGENT_ID', `MEMBER_ID`='$MEMBER_ID', `NON_MEMBER_ID`='$NON_MEMBER_ID', `MEMBER_TYPE_ID`='$MEMBER_VAL', `INVOICE_DATE`='$INVOICE_DATE', `INVOICE_NO`='$INVOICE_NO', `NUMBER_OF_PARCELS`='$NUMBER_OF_PARCELS', `TOTAL_WGHT`='$TOTAL_WGHT', `Declaration`='$Declaration', `FEES_AMOUNT`='$FEES_AMOUNT',`COURIER_AMOUNT`='$COURIER_AMOUNT', `TOTAL_AMOUNT`='$TOTAL_AMOUNT',`IE_PARTY_NAME`='$IE_PARTY_NAME', `IE_PARTY_ID`='$IE_PARTY_ID', `IE_ADDRESS1`='$IE_ADDRESS1', `IE_ADDRESS2`='$IE_ADDRESS2', `IE_COUNTRY`='$IE_COUNTRY', `IE_CITY`='$IE_CITY', `IE_PIN`='$IE_PIN', `IE_TEL1`='$IE_TEL1', `IE_TEL2`='$IE_TEL2', `IE_FAX`='$IE_FAX',`M_ADD_SR_NO`='$M_ADD_SR_NO', `M_DATE`='$M_DATE', `M_COMPANY_NAME`='$M_COMPANY_NAME', `M_ADDRESS`='$M_ADDRESS', `M_CITY`='$M_CITY', `M_STATE`='$M_STATE', `M_PIN`='$M_PIN', `M_COUNTRY`='$M_COUNTRY', `C_COMPANY_NAME`='$C_COMPANY_NAME', `C_ADDRESS1`='$C_ADDRESS1', `C_ADDRESS2`='$C_ADDRESS2', `C_COUNTRY`='$C_COUNTRY', `C_CITY`='$C_CITY', `C_PIN`='$C_PIN', `C_TELEPHONE1`='$C_TELEPHONE1', `C_TELEPHONE2`='$C_TELEPHONE2', `C_FAX`='$C_FAX',`PICKUP_TYPE`='$PICKUP_TYPE',`KP_CERT_NO`='$KP_CERT_NO',`KP_BATCH_NO`='$KP_BATCH_NO',KP_CERT_ISSUE_DATE='$KP_CERT_ISSUE_DATE',KP_CERT_EXPIRY_DATE='$KP_CERT_EXPIRY_DATE',`USD_AMOUNT`='$USD_AMOUNT', `LOC_PICKUP_ID`='$LOC_PICKUP_ID',`IE_ADDRESS3`='$IE_ADDRESS3', `AGENT_MEM_LINK_ID`='$AGENT_MEM_LINK_ID', `COUNTRY_PROV_ID`='$COUNTRY_PROV_ID' where EXPORT_APP_ID='$EXPORT_APP_ID'";
$resultx = mysqli_query($conn,$sql_exp);
 
		$import_attachment = '';
		$target_folder = 'import_attachment/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		$file_name = $_FILES['EXP_Attach1']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace(".xml","",$file_name);
		$file_name = str_replace("'","",$file_name);
	
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.PhP/i", $file_name) || preg_match("/.xml/i", $file_name)){
		echo "invalidfile"; exit;
		} else if($file_name != '')
		{			
			if(($_FILES["EXP_Attach1"]["type"] == "image/jpeg") || ($_FILES["EXP_Attach1"]["type"] == "image/png") || ($_FILES["EXP_Attach1"]["type"] == "image/jpg") || ($_FILES["EXP_Attach1"]["type"] == "image/JPG") || ($_FILES["EXP_Attach1"]["type"] == "image/JPEG") || ($_FILES["EXP_Attach1"]["type"] == "image/PNG"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['EXP_Attach1']['tmp_name'], $target_path))
				{
				$EXP_Attach1 = $temp_code.'_'.$file_name;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='import_application.php?EXPORT_APP_ID=$EXPORT_APP_ID&action=update';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='import_application.php?EXPORT_APP_ID=$EXPORT_APP_ID&action=update';</script>";
			}		
		}

		$import_attachment = '';
		$target_folder = 'import_attachment/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		$file_name2 = $_FILES['EXP_Attach2']['name'];
		$file_name2 = str_replace(" ","_",$file_name2);
		$file_name2 = str_replace(".php","",$file_name2);
		$file_name2 = str_replace(".xml","",$file_name2);
		$file_name2 = str_replace("'","",$file_name2);
		
		if(preg_match("/.php/i", $file_name2) || preg_match("/shell/i", $file_name2) || preg_match("/.PhP/i", $file_name2) || preg_match("/.xml/i", $file_name2)){
		echo "invalidfile"; exit;
		} else if($file_name2 != '')
		{
			if(($_FILES["EXP_Attach2"]["type"] == "image/jpeg") || ($_FILES["EXP_Attach2"]["type"] == "image/png") || ($_FILES["EXP_Attach2"]["type"] == "image/jpg") || ($_FILES["EXP_Attach2"]["type"] == "image/JPG") || ($_FILES["EXP_Attach2"]["type"] == "image/JPEG") || ($_FILES["EXP_Attach2"]["type"] == "image/PNG"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name2;
				if(@move_uploaded_file($_FILES['EXP_Attach2']['tmp_name'], $target_path))
				{
				$EXP_Attach2 = $temp_code.'_'.$file_name2;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='import_application.php?EXPORT_APP_ID=$EXPORT_APP_ID&action=update';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='import_application.php?EXPORT_APP_ID=$EXPORT_APP_ID&action=update';</script>";
			}		
		}

		$import_attachment = '';
		$target_folder = 'import_attachment/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		$file_name3 = $_FILES['EXP_Attach3']['name'];
		$file_name3 = str_replace(" ","_",$file_name3);
		$file_name3 = str_replace(".php","",$file_name3);
		$file_name3 = str_replace(".xml","",$file_name3);
		$file_name3 = str_replace("'","",$file_name3);
		
		if(preg_match("/.php/i", $file_name3) || preg_match("/shell/i", $file_name3) || preg_match("/.PhP/i", $file_name3) || preg_match("/.xml/i", $file_name3)){
		echo "invalidfile"; exit;
		}  else if($file_name3 != '')
		{
			if(($_FILES["EXP_Attach3"]["type"] == "image/jpeg") || ($_FILES["EXP_Attach3"]["type"] == "image/png") || ($_FILES["EXP_Attach3"]["type"] == "image/jpg") || ($_FILES["EXP_Attach3"]["type"] == "image/JPG") || ($_FILES["EXP_Attach3"]["type"] == "image/JPEG") || ($_FILES["EXP_Attach3"]["type"] == "image/PNG"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name3;
				if(@move_uploaded_file($_FILES['EXP_Attach3']['tmp_name'], $target_path))
				{
				$EXP_Attach3 = $temp_code.'_'.$file_name3;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='import_application.php?EXPORT_APP_ID=$EXPORT_APP_ID&action=update';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='import_application.php?EXPORT_APP_ID=$EXPORT_APP_ID&action=update';</script>";
			}		
		}

$EXP_Attach1_Carat = filter($_POST['EXP_Attach1_Carat']);
$EXP_Attach2_Carat = filter($_POST['EXP_Attach2_Carat']);
$EXP_Attach3_Carat = filter($_POST['EXP_Attach3_Carat']);

for($k=0;$k<3;$k++){
if($k==0){
if($EXP_Attach1!=""){
	$kp1 ="update kp_export_attachment_master set ATTACHMENT_TYPE_ID='1',ATTACHMENT_PATH='$EXP_Attach1',CARATS='$EXP_Attach1_Carat' where EXPORT_APP_ID='$EXPORT_APP_ID'";
	$q_kp1 = mysqli_query($conn,$kp1);
	}
	}
if($k==1){
if($EXP_Attach2!=""){
	$kp2 ="update kp_export_attachment_master set ATTACHMENT_TYPE_ID='2',ATTACHMENT_PATH='$EXP_Attach2',CARATS='$EXP_Attach2_Carat' where EXPORT_APP_ID='$EXPORT_APP_ID'";
	$q_kp2 = mysqli_query($conn,$kp2);
	}
}
if($k==2){
if($EXP_Attach3!=""){
	$kp3 ="update kp_export_attachment_master set ATTACHMENT_TYPE_ID='3',ATTACHMENT_PATH='$EXP_Attach3',CARATS='$EXP_Attach3_Carat' where EXPORT_APP_ID='$EXPORT_APP_ID'";
	$q_kp3=mysqli_query($conn,$kp3);
    }
   }
  }
  
}
else
{

$sql_exp="INSERT INTO `kp_export_application_master` (`PROCES_CNTR`, `TRAN_NO`, `EXP_APP_DATE`, `COUNTRY_DEST_ID`, `AGENT_ID`, `MEMBER_ID`, `SEZ_MEMBER_ID`, `NON_MEMBER_ID`, `MEMBER_TYPE_ID`, `INVOICE_DATE`, `INVOICE_NO`, `NUMBER_OF_PARCELS`, `TOTAL_WGHT`, `Declaration`, `FEES_AMOUNT`, `KP_OTH_CHG`, `COURIER_AMOUNT`, `TOTAL_AMOUNT`, `PAYMENT_MODE`, `IE_PARTY_NAME`, `IE_PARTY_ID`, `IE_ADDRESS1`, `IE_ADDRESS2`, `IE_COUNTRY`, `IE_CITY`, `IE_PIN`, `IE_TEL1`, `IE_TEL2`, `IE_FAX`, `SPACE_SOFT_EXP_ID`, `M_ADD_SR_NO`, `M_DATE`, `M_COMPANY_NAME`, `M_ADDRESS`, `M_CITY`, `M_STATE`, `M_PIN`, `M_COUNTRY`, `C_COMPANY_NAME`, `C_ADDRESS1`, `C_ADDRESS2`, `C_COUNTRY`, `C_CITY`, `C_PIN`, `C_TELEPHONE1`, `C_TELEPHONE2`, `C_FAX`,`ENTERED_BY`, `ENTERED_ON`, `MODIFIED_ON`, `MODIFIED_BY`, `ORDER_STATUS`, `FORM_TYPE`, `PICKUP_TYPE`, `DELIVERY_STATUS`, `KP_CERT_NO`,`KP_BATCH_NO`,`KP_CERT_ISSUE_DATE`, `KP_VALID_DAYS`, `KP_CERT_EXPIRY_DATE`, `KP_IMP_EXP_CD`, `KP_CANCEL_DATE`, `KP_HS_CODE1`, `KP_HS_CODE2`, `KP_HS_CODE3`, `KP_PAYMENT_ID`, `KP_REMARKS`, `KP_ADV_NOTIFY`, `KP_ADV_NOTIFY_DATE`, `KP_TECH_DATE`, `MEMBER_ADD_ID`, `USD_AMOUNT`, `LOC_PICKUP_ID`, `IE_COUNTRY_ID`, `IE_CITY_ID`, `M_COUNTRY_ID`, `M_STATE_ID`, `M_CITY_ID`, `C_COUNTRY_ID`, `C_CITY_ID`, `IE_ADDRESS3`, `IE_ADDRESS4`, `C_ADDRESS3`, `C_ADDRESS4`, `AGENT_MEM_LINK_ID`, `COUNTRY_PROV_ID`, `DOWNLOAD_MAIN`, `DOWNLOAD_DETAIL`, `DOWNLOAD_RECEIPTS`, `DOWNLOAD_ACOLL`, `DOWNLOAD_ATTACH`)VALUES ('$PROCES_CNTR', NULL, '$EXP_APP_DATE', '$COUNTRY_DEST_ID', '$AGENT_ID', '$MEMBER_ID', NULL, '$NON_MEMBER_ID', '$MEMBER_VAL', '$INVOICE_DATE', '$INVOICE_NO', '$NUMBER_OF_PARCELS', '$TOTAL_WGHT', '$Declaration', '$FEES_AMOUNT', NULL, '$COURIER_AMOUNT', '$TOTAL_AMOUNT', '', '$IE_PARTY_NAME', '$IE_PARTY_ID', '$IE_ADDRESS1', '$IE_ADDRESS2', '$IE_COUNTRY', '$IE_CITY', '$IE_PIN', '$IE_TEL1', '$IE_TEL2', '$IE_FAX', NULL, '$M_ADD_SR_NO', '$M_DATE','$M_COMPANY_NAME', '$M_ADDRESS', '$M_CITY', '$M_STATE', '$M_PIN', '$M_COUNTRY', '$C_COMPANY_NAME', '$C_ADDRESS1', '$C_ADDRESS2', '$C_COUNTRY', '$C_CITY', '$C_PIN', '$C_TELEPHONE1', '$C_TELEPHONE2', '$C_FAX','$ENTERED_BY', '$ENTERED_ON', '$ENTERED_ON', '$ENTERED_BY', NULL, 'I', '$PICKUP_TYPE', NULL, '$KP_CERT_NO', '$KP_BATCH_NO','$KP_CERT_ISSUE_DATE', NULL, '$KP_CERT_EXPIRY_DATE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$USD_AMOUNT', '$LOC_PICKUP_ID', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', '$IE_ADDRESS3', NULL, NULL, NULL, '$AGENT_MEM_LINK_ID', '$COUNTRY_PROV_ID', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL')";

mysqli_query($conn,$sql_exp);
$EXPORT_APP_ID=mysqli_insert_id($conn);

 $ans1 = $_FILES["EXP_Attach1"]["name"];
 $ans2 = $_FILES["EXP_Attach2"]["name"];
 $ans2 = $_FILES["EXP_Attach3"]["name"];

	//---------------------------------------- uplaod  newsletter pdf  -----------------------------------------------
		$import_attachment = '';
		$target_folder = 'import_attachment/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		$file_name = $_FILES['EXP_Attach1']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace(".xml","",$file_name);
		$file_name = str_replace("'","",$file_name);
	
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.PhP/i", $file_name) || preg_match("/.xml/i", $file_name)){
		echo "invalidfile"; exit;
		}  else if($file_name != '')
		{				
			if(($_FILES["EXP_Attach1"]["type"] == "image/jpeg") || ($_FILES["EXP_Attach1"]["type"] == "image/png") || ($_FILES["EXP_Attach1"]["type"] == "image/jpg") || ($_FILES["EXP_Attach1"]["type"] == "image/JPG") || ($_FILES["EXP_Attach1"]["type"] == "image/JPEG") || ($_FILES["EXP_Attach1"]["type"] == "image/PNG"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				
				if(@move_uploaded_file($_FILES['EXP_Attach1']['tmp_name'], $target_path))
				{			
				 $EXP_Attach1 = $temp_code.'_'.$file_name;				
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='import_application.php';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='import_application.php';</script>";
			}		
		}

//---------------------------------------- uplaod  newsletter pdf  -----------------------------------------------
		$import_attachment = '';
		$target_folder = 'import_attachment/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		$file_name2 = $_FILES['EXP_Attach2']['name'];
		$file_name2 = str_replace(" ","_",$file_name2);
		$file_name2 = str_replace(".php","",$file_name2);
		$file_name2 = str_replace(".xml","",$file_name2);
		$file_name2 = str_replace("'","",$file_name2);
		
		if(preg_match("/.php/i", $file_name2) || preg_match("/shell/i", $file_name2) || preg_match("/.PhP/i", $file_name2) || preg_match("/.xml/i", $file_name2)){
		echo "invalidfile"; exit;
		}  else if($file_name2 != '')
		{
			if(($_FILES["EXP_Attach2"]["type"] == "image/jpeg") || ($_FILES["EXP_Attach2"]["type"] == "image/png") || ($_FILES["EXP_Attach2"]["type"] == "image/jpg") || ($_FILES["EXP_Attach2"]["type"] == "image/JPG") || ($_FILES["EXP_Attach2"]["type"] == "image/JPEG") || ($_FILES["EXP_Attach2"]["type"] == "image/PNG"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name2;
				if(@move_uploaded_file($_FILES['EXP_Attach2']['tmp_name'], $target_path))
				{
				 $EXP_Attach2 = $temp_code.'_'.$file_name2;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='import_application.php';</script>";
				return;
				}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='import_application.php';</script>";
			 }		
		}
		
		//---------------------------------------- uplaod  newsletter pdf  -----------------------------------------------
		$import_attachment = '';
		$target_folder = 'import_attachment/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		$file_name3 = $_FILES['EXP_Attach3']['name'];
		$file_name3 = str_replace(" ","_",$file_name3);
		$file_name3 = str_replace(".php","",$file_name3);
		$file_name3 = str_replace(".xml","",$file_name3);
		$file_name3 = str_replace("'","",$file_name3);
		
		if(preg_match("/.php/i", $file_name3) || preg_match("/shell/i", $file_name3) || preg_match("/.PhP/i", $file_name3) || preg_match("/.xml/i", $file_name3)){
		echo "invalidfile"; exit;
		}  else if($file_name3 != '')
		{
			if(($_FILES["EXP_Attach3"]["type"] == "image/jpeg") || ($_FILES["EXP_Attach3"]["type"] == "image/png") || ($_FILES["EXP_Attach3"]["type"] == "image/jpg") || ($_FILES["EXP_Attach3"]["type"] == "image/JPG") || ($_FILES["EXP_Attach3"]["type"] == "image/JPEG") || ($_FILES["EXP_Attach3"]["type"] == "image/PNG"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name3;
				if(@move_uploaded_file($_FILES['EXP_Attach3']['tmp_name'], $target_path))
				{
				 $EXP_Attach3 = $temp_code.'_'.$file_name3;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='import_application.php';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='import_application.php';</script>";
			}		
		}
		
$EXP_Attach1_Carat = filter($_POST['EXP_Attach1_Carat']);
$EXP_Attach2_Carat = filter($_POST['EXP_Attach2_Carat']);
$EXP_Attach3_Carat = filter($_POST['EXP_Attach3_Carat']);

for($i=0;$i<3;$i++){
if($i==0){
$first = "insert into kp_export_attachment_master set EXPORT_APP_ID='$EXPORT_APP_ID',ATTACHMENT_TYPE_ID='1',ATTACHMENT_PATH='$EXP_Attach1',CARATS='$EXP_Attach1_Carat'";
mysqli_query($conn,$first);
}
if($i==1){
$second = "insert into kp_export_attachment_master set EXPORT_APP_ID='$EXPORT_APP_ID',ATTACHMENT_TYPE_ID='2',ATTACHMENT_PATH='$EXP_Attach2',CARATS='$EXP_Attach2_Carat'";
mysqli_query($conn,$second);
}
if($i==2){
$third = "insert into kp_export_attachment_master set EXPORT_APP_ID='$EXPORT_APP_ID',ATTACHMENT_TYPE_ID='3',ATTACHMENT_PATH='$EXP_Attach3',CARATS='$EXP_Attach3_Carat'";
mysqli_query($conn,$third);
}
}

$HS_CODE_APP_ID=$_POST['HS_CODE_APP_ID_temp'];

$i=0;
foreach($HS_CODE_APP_ID as $val)
{
	 //echo "select * from kp_expimp_temp_tran_detail where HS_CODE_APP_ID='$val'";
	 $query1=mysqli_query($conn,"select * from kp_expimp_temp_tran_detail where HS_CODE_APP_ID='$val'");
	 $result1=mysqli_fetch_array($query1);
	 $MEMBER_ID=$result1['MEMBER_ID'];
	 $HS_CODE_ID=$result1['HS_CODE_ID'];
	 $COUNTRY_ID=$result1['COUNTRY_ID'];
	 $WEIGHT=$result1['WEIGHT'];
	 $AMOUNT=$result1['AMOUNT'];	 
	$query2=mysqli_query($conn,"insert into kp_expimp_tran_detail set EXPORT_APP_ID='$EXPORT_APP_ID',HS_SUB_SR_NO='$i',HS_CODE_ID='$HS_CODE_ID',COUNTRY_ID='$COUNTRY_ID',WEIGHT='$WEIGHT',AMOUNT='$AMOUNT',ENTERED_BY='$ENTERED_BY',ENTERED_ON='$ENTERED_ON',MODIFIED_ON='$ENTERED_ON',MODIFIED_BY='$ENTERED_BY'");
	$temp ="delete from kp_expimp_temp_tran_detail where HS_CODE_APP_ID='$val'";
	 
	$query3=mysqli_query($conn,"delete from kp_expimp_temp_tran_detail where HS_CODE_APP_ID='$val'");
  $i++;
 }
}

header('location:payment_cart_i.php');
?>