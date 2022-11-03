<?php 
session_start();
ob_start();
include_once('db.inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC :: Intranet</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel="stylesheet" href="css/liteaccordion.css">
<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>


   <script>
$(document).ready(function(){
	var str=location.href.toLowerCase();
	$(".nav li a").each(function() {
		if (str.indexOf(this.href.toLowerCase()) > -1) {
				$("li").removeClass("active");
				$(this).parent().addClass("active");
		}
	});
});
</script>
</head>

<body>

<?php include 'include/header.php';?>



<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">Employee Profile</div>
<?php
$id=$_SESSION['user_id'];

 $sql="select * from employee_details where id=$id"; 
 $result=mysql_query($sql);
 $row=mysql_fetch_array($result);
 
 ?>


<div class="profileImg">
  <img src="images/profile/<?php echo $row['profile_pic'];?>" alt="" /></div>

<div class="left profileData">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="maroon">Name</td>
    <td>:</td>
    <td><?php echo $row['employee_name'];?></td>
    </tr>
    <tr>
    <td class="maroon">Password</td>
    <td>:</td>
    <td><?php echo $row['password'];?>
</td>
    </tr>
  <tr>
    <td class="maroon">Designation</td>
    <td>:</td>
    <td><?php echo $row['designation'];?>
</td>
    </tr>
  <tr>
    <td class="maroon">Department</td>
    <td>:</td>
    <td><?php echo $row['department'];?></td>
  </tr>
  <tr>
    <td class="maroon">Birth Date</td>
    <td>:</td>
    <td><?php echo $row['dob'];?>
</td>
    </tr>
    <tr>
    <td class="maroon">Age</td>
    <td>:</td>
    <td><?php echo $row['age'];?>
</td>
    </tr>
    
  <tr>
    <td class="maroon">Region</td>
    <td>:</td>
    <td><?php echo $row['region'];?></td>
  </tr>
  <tr>
    <td class="maroon">Email ID</td>
    <td>:</td>
    <td><a href="mailto:<?php echo $row['email'];?>"><?php echo $row['email'];?></a></td>
  </tr>
 <!-- <tr>
    <td class="maroon">Tel No.</td>
    <td>:</td>
    <td><?php echo $row['contact_no'];?>
</td>
  </tr>-->
  <tr>
    <td class="maroon">Mobile No./Contact No.</td>
    <td>:</td>
    <td><?php echo $row['mobile_no'];?></td>
  </tr>
</table>

</div>

<div class="clear"></div>
</div>  
    
<div class="clear"></div>
    

    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->


<?php include 'include/footer.php';?>



</body>
</html>
