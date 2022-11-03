<?php 
include 'include-new/header.php';

if(!isset($_SESSION['USERID'])){ header('location:login.php');exit; }
include 'db.inc.php';
include 'functions.php';
$registration_id = intval(filter($_SESSION['USERID']));
?>
<?php
function getStateNames($state,$conn)
{
	$query_sel = "SELECT state_code FROM state_master where state_name like '".$state."%' limit 1";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['state_code'];	
}
	
if(isset($_POST["submit"]))
{		
		$insert_count=0;
            $filename=$_FILES["upload_file"]["tmp_name"];
    		if($_FILES["upload_file"]["size"] > 0)
    		{
    		  	$file = fopen($filename, "r");
    	        $temapData = fgetcsv($file); // Skip the first line
				 
				 while(($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
						{				
							//echo '<pre>'; print_r($emapData); exit;
						
						//	$registration_id
						//	$person_series
						
						$parichay_type = isApplied_for_parichay($registration_id,$conn);
						if($parichay_type =="association"){
							$sql_series = "SELECT  MAX(p.person_series) FROM parichay_person_details p join registration_master r on p.registration_id=r.id WHERE r.parichay_type='association'";
							$result_series = $conn->query($sql_series);
							$row_series = $result_series->fetch_array();
							if($row_series[0] == "0" ){
								$person_series = "5000001";
							} else {
								$person_series = $row_series[0]+1;
							}
							} else {
							$sql_series = "SELECT  MAX(p.person_series) FROM parichay_person_details p join registration_master r on p.registration_id=r.id WHERE r.parichay_type!='association'";
							$result_series = $conn->query($sql_series);
							$row_series = $result_series->fetch_array();
							if($row_series[0] == "0" ){
								$person_series = "1000001";
							} else {
								$person_series = $row_series[0]+1;
							}
							}
						    $fname = $emapData[0]; 
						    $mname = $emapData[1]; 
						    $surname = $emapData[2]; 	
							
							$dob = $emapData[3]; 							 
							$dob = str_replace('/', '-', $dob);
							$dobDate  = date('y-m-d',strtotime($dob));
							if(empty($dob)) { $dobDate = "0000-00-00"; } 
							
							$gender  = filter($emapData[4]); 
							$blood_group = filter($emapData[5]);	
							
							$education = $emapData[6];
							$mobile1 = $emapData[7];				 
							$mobile2 = $emapData[8];				 
							$email_id = $emapData[9];				 
							$same_address = $emapData[10];
							$p_address1	= strtoupper(filter($emapData[11]));
							$p_address2	= strtoupper(filter($emapData[12]));
							$p_state	= filter($emapData[13]);
							$pState	= getStateNames($p_state,$conn);
							$p_city	= strtoupper(filter($emapData[14]));							
							$p_pin_code	= filter($emapData[15]);
							
							$c_address1 = strtoupper(filter($emapData[16]));
							$c_address2 = strtoupper(filter($emapData[17]));
							$c_state = strtoupper(filter($emapData[18]));
							$cState	= getStateNames($c_state,$conn);
							$c_city = strtoupper(filter($emapData[19]));							
							$c_pin_code = filter($emapData[20]);
							
							$bank = filter($emapData[21]);
							$account_no = filter($emapData[22]);
							$ifsc = filter($emapData[23]);
							$work_experience = filter($emapData[24]);
							
							$swasthya_kosh_option = filter($emapData[25]);
							
							$sqlx = "SELECT mobile1 FROM parichay_person_details WHERE mobile1 ='$mobile1' ";
							$result = $conn ->query($sqlx);
							$countx =  $result->num_rows;
							
							if( $countx > 0) 
							{						
							echo 'Mobile NO already exist'; 							
							}
							else
							{
							$sql1 = "INSERT INTO `parichay_person_details`(`post_date`, `registration_id`, `fname`, `mname`, `surname`,  `date_of_birth`, `gender`, `blood_group`, `education`, `mobile1`, `mobile2`, `email`, `same_address`, `p_address1`, `p_address2`, `p_state`, `p_city`, `p_pin_code`, `c_address1`, `c_address2`, `c_state`, `c_city`, `c_pin_code`, `bank`, `account_no`, `ifsc`,`work_experience`, `parichay_type`,`person_series`,`parichay_status`, `otpVerified`,`company_approval`) VALUES (NOW(),'$registration_id','$fname','$mname','$surname','$dobDate','$gender','$blood_group','$education','$mobile1','$mobile2','$email_id','$same_address','$p_address1','$p_address2','$pState','$p_city','$p_pin_code','$c_address1','$c_address2','$cState','$c_city','$c_pin_code','$bank','$account_no','$ifsc','$work_experience','dump','$person_series','P','1','P')";	
							$resultx = $conn ->query($sql1);						
							}	
							$insert_count++;		
						}
						fclose($file);
									
			echo "<script type=\"text/javascript\">alert(\"File has been successfully Imported.\");</script>";
			?>
			<!--<div class="content_details1"> 
			<?php echo "Total New inserted Member Records Are :".$insert_count."<br/><br/>";?> 
			</div>-->
    	<?php	} else { echo "<script type=\"text/javascript\">alert(\"Please Upload CSV file only\");</script>";		 }
}
?>


<section class="py-5">
    <div class="container inner_container">  
    <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="d-block mx-auto mb-4">Import Karigar List</h1> 
	<div class="row justify-content-between">
	<div class="col-lg-auto order-lg-12 col-md-12" data-sticky_parent>
		<?php include 'include/regMenu.php'; ?>
	</div>

<div class="col-lg col-md-12">

<form name="search" action="" method="POST" enctype="multipart/form-data"> 
<div class="row mb-3">
  <div class="col-12">
    <h2 class="title mb-0">UPLOAD Karigar's Data Using CSV format Template</h2> Download Dummy CSV Template here... <a href="parichay_csv_data.csv"><b><u>Template</u></b> </a> &nbsp;  <a href="PARICHAY-MASTER-LISTS.xlsx"><b><u>Master List Template</u></b> </a>
  </div>
  <div class="col-12 d-flex justify-content-start">
    <label>CSV FILES : </label>&nbsp;
   <input type="file" name="upload_file" id="upload_file"/>
  </div>
  
  <div class="col-12 mt-2">
    <input type="submit" name="submit" value="Submit" class="cta fade_anim"/> 
  </div>
</div>
</form>
</div>	
</div>
</div>
</section>

<?php include 'include-new/footer.php'; ?>
<style>
.portal_table td { white-space:nowrap; word-break: inherit; } 
.portal_table th {white-space:nowrap}
</style>