<?php session_start();
	ob_start();
 ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from employee_details where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	//echo"<meta http-equiv=refresh content=\"0;url=manage_directory.php?action=view\">";
	header("location:manage_directory.php?action=view");
						exit;
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{

		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update  employee_details set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		//echo"<meta http-equiv=refresh content=\"0;url=manage_directory.php?action=view\">";
		header("location:manage_directory.php?action=view");
						exit;
}

if ($_REQUEST['action']=='save')
{
	//$post_date = date('Y-m-d');
	 $post_date=$_REQUEST['p_date'];
	 $h_name=filter_input_string($_REQUEST['h_name']);
	 $pass=filter_input_string($_REQUEST['pass']);
	 $department=filter_input_string($_REQUEST['dept']);
	 $region=filter_input_string($_REQUEST['region']);
	 $dob=filter_input_string($_REQUEST['dob']);
	 $age=$_REQUEST['age'];
	 $designation=filter_input_string($_REQUEST['designation']);
	 $email=$_REQUEST['email'];
	 $mobile=filter_input_string($_REQUEST['mobile']);
	 $dob=strtotime($dob);
	 $dob=date('d-M-y',$dob);
	 
		$export_attachment = '';
		$target_folder = '../images/profile/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		
			if($_FILES['h_file']['name']!='')
			{	
				if (($_FILES["h_file"]["type"] == "image/gif") || ($_FILES["h_file"]["type"] == "image/jpeg") || ($_FILES["h_file"]["type"] == "image/pjpeg") ||($_FILES["h_file"]["type"] == "image/png"))
				{
					echo $target_path = $target_folder.$_FILES['h_file']['name'];
					
					if(@move_uploaded_file($_FILES['h_file']['tmp_name'], $target_path))
					{
						 $h_file = $_FILES['h_file']['name'];
						
						 $sql="INSERT INTO  employee_details (employee_name,password,department,region,dob,age,designation,email,profile_pic,mobile_no,post_date) VALUES ('$h_name','$pass','$department','$region','$dob','$age','$designation','$email','$h_file','$mobile','$post_date')";		
				
						if (!mysql_query($sql,$dbconn))
						{
							die('Error: ' . mysql_error());
						}
						//echo"<meta http-equiv=refresh content=\"0;url=manage_directory.php?action=view\">";
						header("location:manage_directory.php?action=view");
						exit;
					}
					else
					{
						echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='manage_directory.php?action=add';</script>";
					return;
					}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_directory.php?action=add';</script>";
			 }	
			}
						
						
						
					
	
	
		
	
}

//echo $_REQUEST['action'];
if ($_REQUEST['action']=='update')
{

	$id = $_REQUEST['id'];
	 $post_date=$_REQUEST['p_date'];
	 $h_name=addslashes($_REQUEST['h_name']);
	  $pass=filter_input_string($_REQUEST['pass']);
	 $department=filter_input_string($_REQUEST['dept']);
	 $region=filter_input_string($_REQUEST['region']);
	 $dob=filter_input_string($_REQUEST['dob']);
	 $age=filter_input_string($_REQUEST['age']);
	 $designation=filter_input_string($_REQUEST['designation']);
	 $email=filter_input_string($_REQUEST['email']);
	 $mobile=filter_input_string($_REQUEST['mobile']);
	 $dob=strtotime($dob);
	 $dob=date('d-M-y',$dob);
	
		
						$export_attachment = '';
		$target_folder = '../images/profile/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		
		
			if($_FILES['h_file']['name']!='' || $_REQUEST['action1']!='')
			{	
			
				if($_FILES['h_file']['name']!='')
					{
						if (($_FILES["h_file"]["type"] == "image/gif") || ($_FILES["h_file"]["type"] == "image/jpeg") || ($_FILES["h_file"]["type"] == "image/pjpeg") ||($_FILES["h_file"]["type"] == "image/png"))
						{
							$target_path = $target_folder.$_FILES['h_file']['name'];
							if(@move_uploaded_file($_FILES['h_file']['tmp_name'], $target_path))
							{
								 $h_file = $_FILES['h_file']['name'];
								
							}
							else
							{
								echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='manage_directory.php?action=add';</script>";
							return;
							}
						}else
						{
						echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_directory.php?action=add';</script>";
						}	
					}
				else
					{
						$h_file=filter_input_string($_REQUEST['action1']);
						
					}
					
					echo $sql="update employee_details set employee_name='$h_name',password='$pass',designation='$designation',region='$region',dob='$dob',email='$email',department='$department',profile_pic='$h_file',post_date='$post_date' where id='$id' ";		
						
						if (!mysql_query($sql,$dbconn))
						{
							die('Error: ' . mysql_error());
						}
						//echo"<meta http-equiv=refresh content=\"0;url=manage_directory.php?action=view\">";
						header("location:manage_directory.php?action=view");
						exit;
				
			}
						
					
	
	
		
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>

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
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#p_date').datepick();
	$('#dob').datepick();
	//$('#from_date').datepick();

});
</script>

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
<?php 
?>
<script language="javascript">

function checkdata()
{
	
	//alert(dte);
	
	if(document.getElementById('h_name').value == '')
	{
		alert("Please Enter Name");
		document.getElementById('h_name').focus();
		return false;
	}
	if(document.getElementById('pass').value == '')
	{
		alert("Please Enter password")
		document.getElementById('pass').focus();
		return false;
	}
	else if(document.getElementById('pass').value<6)
	{
		alert("Please Enter password Greater than 6 chracter")
		document.getElementById('pass').focus();
		return false;
	}
	if(document.getElementById('dept').value == '')
	{
		alert("Please Enter Department.");
		document.getElementById('dept').focus();
		return false;
	}
	if(document.getElementById('region').value == '')
	{
		alert("Please Enter region")
		document.getElementById('region').focus();
		return false;
	}
	if(document.getElementById('dob').value == '')
	{
		alert("Please Enter DOB")
		document.getElementById('dob').focus();
		return false;
	}
	if(document.getElementById('age').value == '' || isNaN(document.getElementById('age').value))
	{
		alert("Please Enter Age")
		document.getElementById('age').focus();
		return false;
	}
	if(document.getElementById('designation').value == '')
	{
		alert("Please Enter designation")
		document.getElementById('designation').focus();
		return false;
	}
	// if(document.getElementById('email').value == '')
	// {
		// alert("Please Enter Email Id")
		// document.getElementById('email').focus();
		// return false;
	// }
	// else
	// {
		// email_value = document.getElementById('email').value;
		// e_exp=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i;
		// var ans = e_exp.test(email_value);
		// if(ans==false)
		// {
		// alert("Please Enter Valid Email Id");
		// document.getElementById('email').focus();
		// return false;
		// }
	// }
	// if(document.getElementById('mobile').value == '' || isNaN(document.getElementById('mobile').value))
	// {
		// alert("Please Enter Mobile")
		// document.getElementById('mobile').focus();
		// return false;
	// }
	
	// if(document.getElementById('h_file').value == '')
	// {
		// alert("Please Select File")
		// document.getElementById('h_file').focus();
		// return false;
	// }
	
	 // var ext = h_file.substring(h_file.lastIndexOf('.') + 1);
	// if(ext!='jpg')
	// {
		// alert('Select Only jpg File');
		// document.getElementById('h_file').focus();
		// return false;
	// }
	
	if(document.getElementById('p_date').value == '')
	{
		alert("Please Enter post Date")
		document.getElementById('p_date').focus();
		return false;
	}
	
	
	
		
}
function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID")
		return false
	}
	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 return true					
}

function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   //if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}


</script>
<script language="javascript">
$(document).ready(function(){
 $("#role").change(function () {
	var role=$(this).val();
	if(role=="Super Admin")
	{
		$("#admin_access_div").hide();
	}else
	{
		$("#admin_access_div").show();
	}
	
 });
});
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Admin</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_directory.php?action=add"><div class="content_head_button">Add Employee details</div></a> <a href="manage_directory.php?action=view"><div class="content_head_button">View Employee Details</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td>Name</td>
        <td>Department</td>
        <td>Region</td>
		<td>DOB</td>
		<td>Designation</td>
		<td>Mobile No</td>
        <td>Post_date</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
	
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$query1 = "SELECT * FROM  employee_details where 1".$attach." ";
	$result = mysql_query($query1);
    $rCount=0;
    $rCount = @mysql_num_rows($result);	
	$sql1= $query1."  limit $start, $limit";
	$result2=mysql_query($sql1);
	
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result2))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['employee_name']; ?></td>
		<td><?php echo $row['department']; ?></td>
		<td><?php echo $row['region']; ?></td>
		<td><?php echo $row['dob']; ?></td>
		<td><?php echo $row['designation']; ?></td>
        <td><?php echo $row['mobile_no']; ?></td>
        <td><?php echo $row['post_date']; ?></td>
      
        

        
        <td><a href="manage_directory.php?action=edit&id=<?php echo $row['id']; ?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        
        <td><a href="manage_directory.php?action=del&id=<?php echo $row['id']; ?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></a></td>
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
        
<!--<div class="pages">
    <ul>
        <a href="#"><li style="border-right:none;">Prev </li></a>
        <a href="#"><li>1 </li></a>
        <a href="#"><li>2 </li></a>
        <a href="#"> <li>3 </li> </a>
         <a href="#"><li>4 </li></a>
        <a href="#"><li style="border-right:none;">5 </li></a>
        <a href="#"><li style="border-right:none;">Next</li></a>	           
    </ul>
</div>-->
<?php } ?>        
 
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		echo "hello";
		
		$result2 = mysql_query("SELECT *  FROM  employee_details  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			//print_r($row2);
			$name=$row2['employee_name'];
			$dept=$row2['department'];
			$region=$row2['region'];
			$pass=$row2['password'];
			$dob=$row2['dob'];
			$age=$row2['age'];
			$designation=$row2['designation'];
			$email=$row2['email'];
			$profile_pic=$row2['profile_pic'];
			$mobile=$row2['mobile_no'];
			$post_date=$row2['post_date'];
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" enctype="multipart/form-data" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Admin</td>
    </tr>

    <tr>
    <td class="content_txt"> Name <span class="star">*</span></td>
    <td><input type="text" name="h_name" id="h_name" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $name;?>" />    </td>
    </tr>
     <tr>
    <td class="content_txt"> Password <span class="star">*</span></td>
    <td><input type="password" name="pass" id="pass" title="Please enter your Password" class="show-tooltip input_txt" value="<?php echo $pass;?>" />    </td>
    </tr>
  
	    <tr>
    <td class="content_txt"> Department <span class="star">*</span></td>
    <td><input type="text" name="dept" id="dept" title="Please enter your Deaprtment" class="show-tooltip input_txt" value="<?php echo $dept;?>" />    </td>
    </tr>
	
	    <tr>
    <td class="content_txt"> Region <span class="star">*</span></td>
    <td><input type="text" name="region" id="region" title="Please enter your Region" class="show-tooltip input_txt" value="<?php echo $region;?>" />    </td>
    </tr>
	
	    <tr>
    <td class="content_txt"> DOB <span class="star">*</span></td>
    <td><input type="text" name="dob" id="dob" class="input_txt" value="<?php echo $dob;?>" /></td>
    </tr>
	
	    <tr>
    <td class="content_txt"> Age <span class="star">*</span></td>
    <td><input type="text" name="age" id="age" title="Please enter your age" class="show-tooltip input_txt" value="<?php echo $age;?>" />    </td>
    </tr>
   
    <tr>
    <td class="content_txt">Designation <span class="star">*</span></td>
    <td><input type="text" name="designation" id="designation" title="Please enter your designation" class="show-tooltip input_txt" value="<?php echo $designation;?>" />    </td>
    </tr>
    <tr>
    <td class="content_txt">Email Id <span class="star">*</span></td>
   <td><input type="text" name="email" id="email" title="Please enter your email id" class="show-tooltip input_txt" value="<?php echo $email;?>" />    </td>
    </tr>
	
	<tr>
    <td class="content_txt">Mobile <span class="star">*</span></td>
    <td><input type="text" name="mobile" id="mobile" title="Please enter your mobile" class="show-tooltip input_txt" value="<?php echo $mobile;?>" />    </td>
    </tr>
	
	<tr>
    <td class="content_txt">profile picture <span class="star">*</span></td>
    <td><input type="file" name="h_file" id="h_file" class="input_txt" value="<?php echo $profile_pic;?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Post Date <span class="star">*</span></td>
    <td><input type="text" name="p_date" id="p_date" class="input_txt" value="<?php echo $post_date;?>" /></td>
    </tr>
    
  
  
    
    


        
       
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
	<input type="hidden" name="action1" id="action1" value="<?php echo $profile_pic ;?>" />
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
</table>
</form>
        </div>
        
 <?php } ?>    
    
	<?php
function pagination($per_page = 4, $page = 1, $url = '', $total){ 

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
	<?php if($_REQUEST['action']=='view') {?>
	<div class="pages_1">Total number of Employee: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'manage_directory.php?action=view&page=',$rCount); //call function to show pagination?>
</div>   
	<?php }?>
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
