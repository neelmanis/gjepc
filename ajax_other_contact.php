<?php 
session_start(); ob_start();
include('db.inc.php'); 	
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
$registration_id = intval($_SESSION['USERID']);
  
if(!empty($_POST))  
{  
      $output = '';  
      $message = '';  
      
	  $dept = filter($_REQUEST['dept']);
$other_name = filter($_REQUEST['other_name']);
$other_email= filter($_REQUEST['other_email']);
$other_phone= filter($_REQUEST['other_phone']);
	  
      if($_POST["id"] != '')  
      { 	
		  	$getuid =   $_POST["id"];
		    $sqlx="SELECT id, dept FROM other_contact_detail WHERE dept = '$dept' AND registration_id='".$registration_id."'"; 
			$result = $conn ->query($sqlx);
			$countdept = $result->num_rows;
			
			if($countdept){
			$deptArray = $result->fetch_assoc(); 
			$databaseAutoId2 = $deptArray['id'];
			$databaseEmail = $deptArray['dept'];
			//echo $getuid ."---". $databaseAutoId2;
			if($getuid != $databaseAutoId2){ echo 0; }
			else{
				 $query = "UPDATE `other_contact_detail` SET `dept`='$dept',`other_name`='$other_name',`other_email`='$other_email',`other_phone`='$other_phone' WHERE id='".$_POST["id"]."' AND registration_id='".$registration_id."'";	   
				 $message = 'Details Updated';
			}
			} else {
		   
          $query = "UPDATE `other_contact_detail` SET `dept`='$dept',`other_name`='$other_name',`other_email`='$other_email',`other_phone`='$other_phone' WHERE id='".$_POST["id"]."' AND registration_id='".$registration_id."'";	   
           $message = 'Details Updated';
			}
      }
      else  
      { 	
			$sqlx = "SELECT * FROM `other_contact_detail` WHERE dept='$dept' and registration_id='$registration_id' and status='1'";
			$result = $conn ->query($sqlx);
			$num = $result->num_rows;
			if($num>0)
			{
			echo 0;
			}else{
           $query = "INSERT INTO `other_contact_detail`(`post_date`, `registration_id`, `dept`, `other_name`, `other_email`, `other_phone`, `status`) VALUES (NOW(),'$registration_id','$dept','$other_name','$other_email','$other_phone','1')";
           $message = 'Contact Details Added'; 
			}
		   
      }  
      if($conn ->query($query)) 
      {
           $output .= '<label class="text-success">' . $message . '</label>';  
           $select_query = "SELECT * FROM other_contact_detail where registration_id='$registration_id'";  
           $result = $conn ->query($select_query);  
           $output .= '  
                <table class="table">  
                     <tr>
					<th>Dept</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>EDIT</th>
				</tr>';  
           while($row = $result->fetch_assoc())  
           {  
                $output .= '  
                     <tr>  
                          <td>' . $row["dept"] . '</td>  
                          <td>' . $row["other_name"] . '</td>  
                          <td>' . $row["other_email"] . '</td>  
                          <td>' . $row["other_phone"] . '</td>  
                          <td><input type="button" name="edit" value="Edit" id="'.$row["id"] .'" class="btn btn-info btn-xs edit_data" /></td>  
                     </tr>  
                ';  
           }  
           $output .= '</table>';  
      }
      echo $output;  
 }  
 ?>