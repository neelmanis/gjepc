<?php
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
$registration_id = @$_REQUEST['regid'];
$orderId = filter($_REQUEST['orderId']);
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['orderId']="";
  $_SESSION['pan_no']="";
  $_SESSION['company_name']="";
  header("Location: upload_vaccination_certificate.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{
	$_SESSION['orderId']= filter($_REQUEST['orderId']);
	$_SESSION['pan_no']= filter($_REQUEST['pan_no']);
	$_SESSION['company_name']= filter($_REQUEST['company_name']);
	}
}

function getVisitorIdNew($pan_no,$conn){

	$query_sel = "SELECT visitor_id FROM visitor_directory where pan_no='$pan_no' order by visitor_id desc limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 		
	return $row['visitor_id'];
}
?>
<?php
if($_REQUEST['action']=='vaccineUploadAction')
{    
		function uploadSingleVIsitorCovid($file_name,$file_temp,$file_type,$file_size,$mobile,$name,$certificate,$registration_id)
		{
			$upload_image = '';
	
			$target_folder = '/var/www/html/registration.gjepc.org/images/covid/vis/'.$registration_id.'/'.$name.'/';

			$target_path = "";
			$user_id = $registration_id;
			$file_name = str_replace(" ","_",$file_name);
			
			if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
		    echo "Sorry something error while uploading..."; exit;
			}
			else if($file_name != '')
			{
				if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
				{
					$random_name = rand();
					 $target_path = $target_folder.$certificate.'_'.$mobile."_".$file_name;
					if(@move_uploaded_file($file_temp, $target_path))
					{
						  $upload_image = $certificate."_".$mobile."_".$file_name;
					}
					else
					{
						 $upload_image = "fail";
					}
				}
				else
				{
					 $upload_image = "invalid";
				}	
			}
			
			return $upload_image;
		}

        $registration_id = $_POST['registration_id'];
	    $visitor_id = $_POST['visitor_id'];
        $certificate = $_POST['valueType'];
        $via="self";
	    
		/*=======================GET Details OF VISITOR===========================*/
         
         $resultMobileSql =$conn->query("SELECT * FROM `visitor_directory` WHERE `visitor_id`='$visitor_id'") ;

         $getMobileRow = 	 $resultMobileSql->fetch_assoc();

         $isSecondary = $getMobileRow['isSecondary'];
         if($isSecondary =="Y"){
         	$mobile_no = $getMobileRow['secondary_mobile'];
         }else{
         	$mobile_no = $getMobileRow['mobile'];
         }
        $visitor_email = $getMobileRow['email'];
		$CompanyName = getCompanyName($registration_id,$conn); 
	    $visitorName = $getMobileRow['name']." ".$getMobileRow['lname'];
        $pan_no = $getMobileRow['pan_no'];


		/*=======================GET Details OF VISITOR===========================*/

		/*==================GET VISITOR SELECTED SHOW=============*/
		$category_for = getVisitorSelectedShow($visitor_id,$conn);
	
		if($category_for =="igjme22"){
	    $category_for = "IGJME";
		}else{
	    $category_for ="VIS";
		}
		/*===============GET VISITOR SELECTED SHOW================*/

		$create_directory = '/var/www/html/registration.gjepc.org/images/covid/vis/'.$registration_id ;
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	    }

	    if(isset($_FILES['vaccine_certificate']) && $_FILES['vaccine_certificate']['name']!=""){
		
		$vaccine_certificate_name=$_FILES['vaccine_certificate']['name'];
		$vaccine_certificate_temp=$_FILES['vaccine_certificate']['tmp_name'];
		$vaccine_certificate_type=$_FILES['vaccine_certificate']['type'];
		$vaccine_certificate_size=$_FILES['vaccine_certificate']['size'];

		$attach="vaccine_certificate";
		if($vaccine_certificate_name!="")
		{
		    $create_vaccine_certificate = '/var/www/html/registration.gjepc.org/images/covid/vis/'.$registration_id.'/'.$attach;
			if (!file_exists($create_vaccine_certificate)) {
			mkdir($create_vaccine_certificate, 0777);
			}
			  $vaccine_certificate=uploadSingleVIsitorCovid($vaccine_certificate_name,$vaccine_certificate_temp,$vaccine_certificate_type,$vaccine_certificate_size,$mobile_no,$attach,$certificate,$registration_id);
			 if ($vaccine_certificate =="fail") {
			 	echo "<script> alert('Sorry, report uploading has been failed on server. Please contact administrator');</script>";
			 	
			 }elseif ($vaccine_certificate =="invalid") {
			 
			  		 	echo "<script> alert('Please Select valid file type');</script>";
			  		 	 echo "<meta http-equiv=refresh content=\"0;url=upload_vaccination_certificate.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
			 }
		}else{
			
			echo "<script> alert('Please Select covid vaccination certificate');</script>";
			 echo "<meta http-equiv=refresh content=\"0;url=upload_vaccination_certificate.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
		}
		}else{
	
			echo "<script> alert('Please Select covid vaccination certificate');</script>";
			 echo "<meta http-equiv=refresh content=\"0;url=upload_vaccination_certificate.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
		}



	$checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'" ;
	$resultData =$conn->query($checkData);
	$countData =  $resultData->num_rows;
	
 
	$datetime = date("Y-m-d H:i:s");
	
	/*======================= SEND SMS AFTER UPLOAD CERTIFICATE  ===================*/
	$cert = "Vaccination Certificate";
	$website = "IIJS SIGNATURE 2022";
   // $smsContent ="Your ".$cert." has been uploaded successfully. We will notify you on approval/disapproval of the document. Regards, GJEPC";
   // get_data($smsContent,$mobile_no);
    $smsContent ="Your ".$cert." has been uploaded successfully for ".$website." .We will notify you on approval/disapproval. Regards, GJEPC";
//	send_sms($smsContent,$mobile_no);
    /*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/

    if($certificate =='dose1'){
    //	$messagev = "It is compulsory to carry Covid-19 Negative Report(RT PCR Test) done before 48 hrs of your first scheduled entry at IIJS SIGNATURE 2022.";
    }else{
    	$messagev = "We will update you After approval of your vaccination certificate, Your Digital badge will be available soon on GJEPC APP.";
    }
    $admin_id = $_SESSION['curruser_login_id'];
	if($countData > 0){
		
		if($certificate =='dose1'){
 
            $updateData =  "UPDATE visitor_lab_info SET `dose1`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose1_status`='U',`modified_at`='$datetime',`uploadAdminId`='$admin_id' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'";

		} else {

            $updateData =  "UPDATE visitor_lab_info SET `dose2`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose2_status`='U',`modified_at`='$datetime',`uploadAdminId`='$admin_id' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'";
		} 
		$ansData = $conn ->query($updateData);
       
       echo "<script> alert('Uploaded successfully');</script>";
        echo "<meta http-equiv=refresh content=\"0;url=upload_vaccination_certificate.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
        
	}else{

		if($certificate =='dose1'){

        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose1`, `status`,`approval_status`,`dose1_status`,`category_for`,`uploadAdminId`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for','$admin_id')";

		}else{

        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose2`, `status`,`approval_status`,`dose1_status`,`category_for`,`uploadAdminId`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for','$admin_id')";

		}

	    $ansData = $conn ->query($sqlx);
	    if($ansData){
			echo "<script> alert('Uploaded successfully');</script>";
	    echo "<meta http-equiv=refresh content=\"0;url=upload_vaccination_certificate.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
	    }else{
	    	 echo "<script> alert('Mobile number is already used please change and try');</script>";
	    echo "<meta http-equiv=refresh content=\"0;url=upload_vaccination_certificate.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
	    }
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Order || GJEPC ||</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

<!--navigation end-->
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Visitor Order</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">		
		<?php if($_REQUEST['action']=='view') { ?>
       Upload Vaccinaton Certifcate
		<?php } elseif($_REQUEST['action']=='orderHistory') { ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="upload_vaccination_certificate.php?action=view">Back</a></div> <?php } ?>
		</div>

<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>

<?php if($_REQUEST['action']=='view') { ?>

	<div class="content_details1">



</div>

<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<!-- <tr>
    <td width="19%"><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
</tr>  -->
   
<tr>
    <td width="19%"><strong>Pan Number</strong></td>
    <td width="81%"><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>" /></td>
</tr> 
<tr>
    <td width="19%"><strong>Order Id</strong></td>
    <td width="81%"><input type="text" name="orderId" id="orderId" class="input_txt" value="<?php echo $_SESSION['orderId'];?>" /></td>
</tr>   
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search" class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset" class="input_submit" /></td>
</tr>	
</table>
</form> 
</div>
<div class="content_details1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
    <tr class="orange1">
			<td>Company Name</td>
			<td>Pan Number</td>
		  <td>Order Id</td>
			<td>Upload Certificate</td>  
    </tr>
    <?php	
 	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'create_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql = "SELECT * FROM `visitor_order_history` WHERE (`show`='iijs22' || `show`='signature23' || `show`='iijstritiya23' || `show`='igjme22' || `show`='combo23') AND payment_status = 'Y'";
	if($_SESSION['orderId']!="")
	{
	$sql.=" and orderId like '%".$_SESSION['orderId']."%'";
	}	
	if($_SESSION['pan_no']!="")
	{
		 $visitor_id = getVisitorIdNew($_SESSION['pan_no'],$conn);
	$sql.=" and visitor_id = '".$visitor_id."'";
	}	
	// if($_SESSION['orderId']!="")
	// {
	// $sql.=" and orderId like '%".$_SESSION['orderId']."%'";
	// }	
	 $sql.= "  ".$attach." ";
	
	
	$result1= $conn ->query($sql);
	$rCount = $result1->num_rows;
	if($rCount < 50){
	 $sql1= $sql." limit 0, $limit ";
	}else{
	 $sql1= $sql." limit $start, $limit ";

	}
	$result=$conn ->query($sql1);
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{
    ?>
	
    <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
    <td><?php echo strtoupper(getNameCompany($row['registration_id'],$conn)); ?></td>
	  <td><?php echo getVisitorPAN($row['visitor_id'],$conn); ?></td>      
	  <td><?php echo filter($row['orderId']); ?></td>      
	
      <td align="left"><a href="upload_vaccination_certificate.php?action=uploadVaccineCertificate&visitor_id=<?php echo $row['visitor_id'];?>&registration_id=<?php echo $row['registration_id'];?>" style="color:#000000">Upload</a></td>
     
	
    </tr>
    <?php
	$i++;
	   }
	 }
	 else
	 {
	 ?>
    <tr>
      <td colspan="10">Records Not Found</td>
    </tr>
    <?php  }  	?>
  </table>
</div>
<?php } ?> 
<!--------------------------------------------- UPLOAD VACCINE CERTIFICATE FOR EMPLOYEE ----------------------------------------->

<?php if($_REQUEST['action']=='uploadVaccineCertificate') {?>  

	<?php 
	$visitor_id = $_REQUEST["visitor_id"];
	$registration_id = $_REQUEST["registration_id"];
    $labInfo ="SELECT * FROM `visitor_lab_info` WHERE `visitor_id`='$visitor_id' AND registration_id='$registration_id'";
    $resultLabInfo = $conn->query($labInfo);
    $countLabInfo = $resultLabInfo->num_rows;
    if($countLabInfo >0){
    	$rowLabInfo =  $resultLabInfo->fetch_assoc();
    	$certificate =$rowLabInfo['certificate'];
    	$dose1 =$rowLabInfo['dose1'];
    	$dose2 =$rowLabInfo['dose2'];

    	$approval_status = $rowLabInfo['approval_status'];
    	$dose1_status = $rowLabInfo['dose1_status'];
    	$dose2_status = $rowLabInfo['dose2_status'];
    }else{
    	$certificate = "";
    	$dose1 = "";
    	$dose2 = "";
    	$approval_status  = "";
    	$dose1_status = "";
    	$dose2_status = "";
    }
	?>
<div class="content_details1">
<form name="details" action="" method="post" enctype="multipart/form-data" >    
<h3 style="display:inline">Upload Vaccine Certificate</h3>
<div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="upload_vaccination_certificate.php?action=view">Back</a></div> 	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
     <td colspan="11">Upload Vaccine Certificate</td>
  </tr>
  <tr>
    <td ><strong>Select Dose</strong></td>
    <td>
    	<label><input type="radio" <?php if($certificate =="dose1"){echo "checked";}?> name="valueType" id="dose1" value="dose1"> Dose 1</label>
        <label><input type="radio" <?php if($certificate =="dose2"){echo "checked";}?> name="valueType" id="dose2" value="dose2"> Dose 2</label>
    </td>
  </tr>
  
  <tr >
    <td ><strong>Vaccine Certificate</strong></td>
    <td><input type="file" name="vaccine_certificate" id="vaccine_certificate" class="input_txt"  /></td>
  </tr>

  <tr>
    <td ><strong>Uploaded Vaccine Certificates </strong></td>
    <td>
    	<?php if($dose1 !=""){?>
			<a target="_blank" href="https://registration.gjepc.org/images/covid/vis/<?php echo $registration_id;?>/vaccine_certificate/<?php echo $dose1;?>">Dose 1 Certificate</a>
    	<?php }?>
  
    	&nbsp;&nbsp;&nbsp;
    	<?php if($dose2 !=""){?>
    	<a target="_blank" href="https://registration.gjepc.org/images/covid/vis/<?php echo $registration_id;?>/vaccine_certificate/<?php echo $dose2;?>">Dose 2 Certificate</a>
    	<?php }?>
    </td>
  </tr>
  
  <?php if($dose1_status =="Y" && $dose2_status =="Y"){?>
  	<tr >
    <td colspan="2">Vacccine is approved already</td>
   
  </tr>
  <?php }else{?>
<tr >
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="vaccineUploadAction" />
    <input type="hidden" name="visitor_id" id="visitor_id"  value="<?php echo $_REQUEST['visitor_id'];?>" />
    <input type="hidden" name="registration_id" id="registration_id"  value="<?php echo $_REQUEST['registration_id'];?>" />
    </td>
  </tr>
  <?php } ?>
  
</table>
</form> 
</div>
<?php }?>
<!----------------------------- ORDER HISTORY ---------------------------------->

<?php if($_REQUEST['action']=='orderHistory') {?>  
<div class="content_details1">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Visitor Name</td>
    <td>Payment Made For</td>
    <td>Amount</td>
    <td>Shows</td>
    <td>Year</td>
    <td>Payment Status</td>
  </tr>
    <?php  
	$page=1;//Default page
	$limit=100;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
    $sql="SELECT * FROM visitor_order_history where orderId = '$orderId' and registration_id = '$registration_id'"; 	 
	$result=$conn ->query($sql);
	$rCount= $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows= $result1->fetch_assoc())
  {
  $payment_status = $rows['payment_status'];
  if($payment_status == 'Y'){
	$Pstatus = "Success";} else { 
	$Pstatus = "Fail";}	
  ?>
  <tr >
    <td><?php echo VisitorFLName($rows['visitor_id'],$conn);?></td> 
    <td><?php echo filter($rows['payment_made_for']);?></td> 
    <td><?php echo $rows['amount'];?></td>   
    <td><?php echo filter($rows['show']);?></td>
    <td><?php echo filter($rows['year']);?></td> 
    <td><?php echo $Pstatus;?></td> 
  </tr>
  <?php
   $i++;
   }  
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
</div>
<?php } ?> 

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
<div class="pages_1">Total number of Order: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'upload_vaccination_certificate.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>