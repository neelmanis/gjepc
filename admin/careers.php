<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$adminID	=	intval($_SESSION['curruser_login_id']);
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from job_master where id=?";
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", $_REQUEST['id']);
	if($stmtd->execute()){	echo"<meta http-equiv=refresh content=\"0;url=careers.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
		$status = filter($_REQUEST['status']);	
		$id     = filter($_REQUEST['id']);
		$modified_date = date('Y-m-d');
		$sql = "update job_master set status=?,adminId=?,modified_date=? where id=?";
		$stmt = $conn -> prepare($sql);
		$stmt->bind_param("iisi", $status,$adminID,$modified_date,$id);
		if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=careers.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$cat_id		=	$conn->real_escape_string($_REQUEST['cat_id']);
	$position_name	=	$conn->real_escape_string($_REQUEST['position_name']);
	$experience	=	$conn->real_escape_string($_REQUEST['experience']);
	$no_of_vacancies	=	$conn->real_escape_string($_REQUEST['no_of_vacancies']);
	$qualification	=	$conn->real_escape_string($_REQUEST['qualification']);
	$requirement	=	$conn->real_escape_string($_REQUEST['requirement']);
	$location	=	$conn->real_escape_string($_REQUEST['location']);
	
	//---------------------------------------- uplaod  Full Profile -----------------------------------------------
		$profile_detail = '';
		$target_folder = 'ResumeProfile/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['profile_detail']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace("'","",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='careers.php?action=add';</script>";
			exit;
		} else if($_FILES['profile_detail']['name']!='')
		{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['profile_detail']['name'];
				if(@move_uploaded_file($_FILES['profile_detail']['tmp_name'], $target_path))
				{
				$profile_detail = $temp_code.'_'.$_FILES['profile_detail']['name'];
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='careers.php?action=add';</script>";
				return;
				}
		}
		
	$sql = "INSERT INTO job_master (cat_id,position_name,experience,no_of_vacancies,qualification,requirement,location,profile_detail,status,post_date) VALUES ('$cat_id','$position_name','$experience','$no_of_vacancies','$qualification','$requirement','$location','$profile_detail','1','$post_date')";
	$stmt = $conn->query($sql);
	echo"<meta http-equiv=refresh content=\"0;url=careers.php?action=view\">";
}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$cat_id=$conn->real_escape_string($_REQUEST['cat_id']);
	$position_name=$conn->real_escape_string($_REQUEST['position_name']);
	$experience=$conn->real_escape_string($_REQUEST['experience']);
	$no_of_vacancies=$conn->real_escape_string($_REQUEST['no_of_vacancies']);
	$qualification=$conn->real_escape_string($_REQUEST['qualification']);
	$requirement=$conn->real_escape_string($_REQUEST['requirement']);
	$location=$conn->real_escape_string($_REQUEST['location']);
	$id=$conn->real_escape_string($_REQUEST['id']);

	//---------------------------------------- uplaod  Full Profile -----------------------------------------------
		$profile_detail = '';
		$target_folder = 'ResumeProfile/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();		
		
		if($_FILES['profile_detail']['name']!='')
		{			
				$target_path = $target_folder.$temp_code.'_'.$_FILES['profile_detail']['name'];
				if(@move_uploaded_file($_FILES['profile_detail']['tmp_name'], $target_path))
				{
				$profile_detail = $temp_code.'_'.$_FILES['profile_detail']['name'];
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='careers.php?action=add';</script>";
				return;
				}	
		}

	$sql="update job_master set cat_id='$cat_id',position_name='$position_name', experience='$experience',no_of_vacancies='$no_of_vacancies',qualification='$qualification',requirement='$requirement',location='$location',profile_detail='$profile_detail' where id='$id'";
	$sqlDatas = $conn->query($sql);
	echo"<meta http-equiv=refresh content=\"0;url=careers.php?action=view\">";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Careers :: GJEPC</title>

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

<script language="javascript">
function checkdata()
{
	if(document.getElementById('cat_id').value == '')
	{
		alert("Please Select Category Name");
		document.getElementById('cat_id').focus();
		return false;
	}
	
	/*if(document.getElementById('position_name').value == '')
	{
		alert("Please Enter Position Name.");
		document.getElementById('position_name').focus();
		return false;
	}
	if(document.getElementById('experience').value == '')
	{
		alert("Please Enter Experience.");
		document.getElementById('experience').focus();
		return false;
	}

	if(document.getElementById('qualification').value == '')
	{
		alert("Please Enter Qualification.");
		document.getElementById('qualification').focus();
		return false;
	}
	
	if(document.getElementById('requirement').value == '')
	{
		alert("Please Enter Requirement.");
		document.getElementById('requirement').focus();
		return false;
	}
	
	if(document.getElementById('location').value == '')
	{
		alert("Please Enter Location.");
		document.getElementById('location').focus();
		return false;
	}*/
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
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Job</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="careers.php?action=add"><div class="content_head_button">Add Job</div></a> <a href="careers.php?action=view"><div class="content_head_button">View Job</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Category Name</td>
        <td>Position Name</td> 
        <td>No of Vacancies</td>
        <td>Location</td>
        <td>Resume&nbsp;&nbsp;	</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = $conn ->query("SELECT * FROM job_master where 1".$attach." ");
    $rCount = 0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php if($row['cat_id']==1){echo "Careers at GJEPC";}else if($row['cat_id']==2){echo "Careers Center";} ?></td>
        <td><?php echo $row['position_name']; ?></td>
        <td><?php echo $row['no_of_vacancies']; ?></td>
        <td><?php echo $row['location'] ?></td>
        <td>[
		<?php
		$sql2 = "SELECT count(*) as 'count' FROM `job_apply` WHERE 1 and job_id=$row[id]";
		$result2 = $conn ->query($sql2);
		$rows2 = $result2->fetch_assoc();
		echo $rows2['count'];
		?>
        ] <a href="view_resume.php?jid=<?php echo $row['id'];?>&action=view" style="color:#000000">view </a></td>
        <td>
		<?php if($row['status'] == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        }else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="careers.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="careers.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="careers.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="careers.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM job_master where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$cat_id=stripslashes($row2['cat_id']);
			$position_name=stripslashes($row2['position_name']);
			$experience=stripslashes($row2['experience']);
			$no_of_vacancies=stripslashes($row2['no_of_vacancies']);
			$qualification=stripslashes($row2['qualification']);
			$requirement=stripslashes($row2['requirement']);
			$location=stripslashes($row2['location']);
			$order_no=stripslashes($row2['order_no']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Job</td>
    </tr>
  	<tr>
      <td class="content_txt">Select Category <span class="star">*</span></td>
  	  <td>
      <select name="cat_id" id="cat_id" class="input_txt">
		<option value="">Select Category Name</option>
		<option value="1" <?php if($cat_id==1){echo "selected='selected'";}?>>Careers at GJEPC</option>
        <option value="2" <?php if($cat_id==2){echo "selected='selected'";}?>>Careers Center</option>
      </select></td>
	</tr>

    <tr>
    <td class="content_txt">Position Name </td>
    <td><input type="text" name="position_name" id="position_name" class="input_txt" value="<?php echo $position_name; ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt">Experience </td>
      <td><input type="text" name="experience" id="experience" class="input_txt" value="<?php echo $experience; ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt">No of Vacancies</td>
      <td><input type="text" name="no_of_vacancies" id="no_of_vacancies" class="input_txt" value="<?php echo $no_of_vacancies; ?>" /></td>
    </tr>
  
    <tr>
      <td valign="top" class="content_txt">Qualification</td>
      <td>
	  <label>
        <textarea name="qualification" id="qualification" rows="5" class="input_txt" ><?php echo $qualification; ?></textarea>
      </label>
	  </td>
    </tr>
    
    <tr>
    <td valign="top" class="content_txt">Requirement</td>
    <td><textarea name="requirement" id="requirement" rows="5" class="input_txt" ><?php echo $requirement; ?></textarea></td>
    </tr>
    
    <tr>
    <td class="content_txt">Location Name</td>
    <td><input type="text" name="location" id="location" class="input_txt" value="<?php echo $location; ?>" /></td>
    </tr>

	<tr>
    <td class="content_txt">Upload Full Profile</td>
    <td>
    <input type="file" name="profile_detail" id="profile_detail" class="input_txt" value="<?php echo $order_no; ?>"/>
    </td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />  
	</td>
    </tr>
</table>
</form>
        </div>
        
 <?php } ?>    
    
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>