<?php 
session_start();
ob_start();
include('../db.inc.php');
include('../functions.php');
?>

<?php
function getSurveyTitle($survey_id)
{
$query=mysql_query("SELECT `survey_name` FROM `survey_master` WHERE id='$survey_id'");
$result=mysql_fetch_array($query);
return $result['survey_name'];
}
?>
<?php 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from survey_qst where qst_id='$_REQUEST[id]'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_survey.php?action=view\">";
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update survey_qst set status='$status' where qst_id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_survey.php?action=view\">";
}

if($_REQUEST['action']=='save')
{
		$survey_id = $_REQUEST['survey_id'];
		$question = $_REQUEST['question'];
		$opt1 = $_REQUEST['opt1'];
		$opt2 = $_REQUEST['opt2'];
		$opt3 = $_REQUEST['opt3'];
		$opt4 = $_REQUEST['opt4'];
		$order_no = $_REQUEST['order_no'];
		$status = $_REQUEST['status'];
		
	$chk = "select * from survey_qst where order_no='$order_no' AND survey_id='$survey_id'";
	$result = mysql_query($chk);
	$cnt = mysql_num_rows($result);
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"Order Already in use\");location.href='manage_survey.php?action=view';</script>";
	} else {
		$sql="INSERT INTO `survey_qst`(`survey_id`, `qst`, `opt1`, `opt2`, `opt3`, `opt4`,`order_no`, `status`,`post_date`) VALUES ('$survey_id','$question','$opt1','$opt2','$opt3','$opt4','$order_no','$status',NOW())";
		if(!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_survey.php?action=view\">";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
		$qst_id = $_REQUEST['id'];
		$survey_id = $_REQUEST['survey_id'];
		$question = $_REQUEST['question'];
		$opt1 = $_REQUEST['opt1'];
		$opt2 = $_REQUEST['opt2'];
		$opt3 = $_REQUEST['opt3'];
		$opt4 = $_REQUEST['opt4'];
		$order_no = $_REQUEST['order_no'];
		$status = $_REQUEST['status'];

	$sql="UPDATE `survey_qst` SET `survey_id`='$survey_id',`qst`='$question',`opt1`='$opt1',`opt2`='$opt2',`opt3`='$opt3',`opt4`='$opt4',`order_no`='$order_no',`status`='$status' WHERE qst_id='$qst_id'";	
	if (!mysql_query($sql,$dbconn))
	{
		echo "<script langauge=\"javascript\">alert(\"Order Already in use\");location.href='manage_survey.php?action=view';</script>";
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_survey.php?action=view\">";
}
/* Manage Survey Master */

if(($_REQUEST['action']=='actives') && ($_REQUEST['id']!=''))
{
		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update survey_master set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_survey.php?action=view_survey\">";
}

if ($_REQUEST['action']=='saves')
{
		$survey = $_REQUEST['survey'];
		$status = $_REQUEST['status'];
		
		$sql="INSERT INTO `survey_master`(`survey_name`, `status`,`post_date`) VALUES ('$survey','$status',NOW())";
		if (!mysql_query($sql,$dbconn))
		{
		die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_survey.php?action=view_survey\">";
}

if(($_REQUEST['action']=='updates')&&($_REQUEST['id']!=''))
{
		$id = $_REQUEST['id'];
		$survey = $_REQUEST['survey'];
		$status = $_REQUEST['status'];

	$sql="UPDATE `survey_master` SET `survey_name`='$survey',`status`='$status' WHERE id='$id'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_survey.php?action=view_survey\">";
}

if(($_REQUEST['action']=='dels') && ($_REQUEST['id']!=''))
{
	$sql="delete from survey_master where id='$_REQUEST[id]'";	
	if(!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_survey.php?action=view_survey\">";
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

<script language="javascript">
function checkdata()
{	
	if(document.getElementById('question').value == '')
	{
		alert("Please Enter Question");
		document.getElementById('question').focus();
		return false;
	}
	
	if(document.getElementById('opt1').value == '')
	{
		alert("Please Enter option1.");
		document.getElementById('opt1').focus();
		return false;
	}
	if(document.getElementById('opt2').value == '')
	{
		alert("Please Enter option2")
		document.getElementById('opt2').focus();
		return false;
	}
	/*if(document.getElementById('opt3').value == '')
	{
		alert("Please Enter option3")
		document.getElementById('opt3').focus();
		return false;
	}*/
	/*if(document.getElementById('opt4').value == '')
	{
		alert("Please Enter option4")
		document.getElementById('opt4').focus();
		return false;
	}*/
	
	if(document.getElementById('c_answer').value == '')
	{
		alert("Please Select Correct Answer");
		document.getElementById('c_answer').focus();
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
    	<div class="content_head">
		<a href="manage_survey.php?action=add"><div class="content_head_button">Add Question</div></a> 
		<a href="manage_survey.php?action=view"><div class="content_head_button">View Question</div></a>
		<a href="manage_survey.php?action=adds"><div class="content_head_button">Add Survey Master</div></a>
		<a href="manage_survey.php?action=view_survey"><div class="content_head_button">View Survey Master</div></a>
		</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
        <td>Survey Title</td>
        <td>Question</td>
        <td>Choice 1</td>
        <td>Choice 2</td>
        <td>Choice 3</td>
        <td>Choice 4</td>
        <td>Order No</td>
        <td>Post Date</td>
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'survey_id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";    
    $i=1;	
	//SELECT * FROM survey_qst where 1 order by survey_id desc, order_no asc
	//$sql.=" order by c.modified_date desc ,c.payment_id desc"; 
	$result = mysql_query("SELECT * FROM survey_qst where 1".$attach." , order_no asc");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
	?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo getSurveyTitle($row['survey_id']); ?></td>
        <td><?php echo $row['qst']; ?></td>
        <td><?php echo $row['opt1']; ?></td>
        <td><?php echo $row['opt2']; ?></td>
        <td><?php echo $row['opt3']; ?></td>
        <td><?php echo $row['opt4']; ?></td>
        <td><?php echo $row['order_no']; ?></td>        
      	<td><?php echo $row['post_date']; ?></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_survey.php?id=<?php echo $row['qst_id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_survey.php?id=<?php echo $row['qst_id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } ?></td>
        
        <td><a href="manage_survey.php?action=edit&id=<?php echo $row['qst_id']; ?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        
        <td><a href="manage_survey.php?action=del&id=<?php echo $row['qst_id']; ?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></a></td>
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
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT * FROM survey_qst where qst_id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{			
			$survey_id=stripslashes($row2['survey_id']);
			$qst=stripslashes($row2['qst']);
			$opt1=stripslashes($row2['opt1']);
			$opt2=stripslashes($row2['opt2']);
			$opt3=stripslashes($row2['opt3']);
			$opt4=stripslashes($row2['opt4']);
			$order_no=stripslashes($row2['order_no']);
			$status=stripslashes($row2['status']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" enctype="multipart/form-data" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2"> &nbsp; Add New Survey Question </td>
    </tr>
	
	<tr>
        <td class="content_txt">Survey Title</td>
        <td>
        <select class="form-control" name="survey_id">
		<?php
		$sqlx="SELECT * FROM `survey_master` WHERE `status`=1 ORDER BY post_date";
		$result = mysql_query($sqlx);
		while($mysqlrow=mysql_fetch_array($result))
		{			
			if($mysqlrow['id']==$survey_id)
			{
			echo "<option selected='selected' value='$mysqlrow[id]'>$mysqlrow[survey_name]</option>";
			} else {
			echo "<option value='$mysqlrow[id]'>$mysqlrow[survey_name]</option>";
			}
		}
		?>
		</select>
        </td>
    </tr>
	
    <tr>
    <td class="content_txt">Question</td>
    <td><input type="text" name="question" id="question" title="Please enter your Question" class="show-tooltip input_txt" value="<?php echo $qst;?>"/>    </td>
    </tr>
   
    <tr>
    <td class="content_txt">Choice 1</td>
    <td><input type="text" name="opt1" id="opt1" class="input_txt" value="<?php echo $opt1;?>"/> </td>
    </tr>
    <tr>
    <td class="content_txt">Choice 2</td>
    <td><input type="text" name="opt2" id="opt2" class="input_txt" value="<?php echo $opt2;?>"/></td>
    </tr>
    <tr>
    <td class="content_txt">Choice 3</td>
    <td><input type="text" name="opt3" id="opt3" class="input_txt" value="<?php echo $opt3;?>"/></td>
    </tr>
    <tr>
    <td class="content_txt">Choice 4</td>
    <td><input type="text" name="opt4" id="opt4" class="input_txt" value="<?php echo $opt4;?>"/></td>
    </tr>
	<tr>
    <td class="content_txt">Order No</td>
    <td><input type="text" name="order_no" id="order_no" class="input_txt" value="<?php echo $order_no;?>"/></td>
    </tr>
	<tr>
	<td valign="top"><strong>Status</strong></td>
	<td>
	<input type="radio" name="status" value="1" <?php if($status=='1'){echo "checked='checked'";}?>> Active &nbsp;
	<input type="radio" name="status" value="0" <?php if($status=='0'){echo "checked='checked'";}?>> Inactive &nbsp;
	</td>
	</tr>
  
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
</table>
</form>
        </div>
 <?php } ?>    

<!-- Survey Master -->

<?php if($_REQUEST['action']=='view_survey') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
        <td>Title</td>
        <td>Status</td>
        <td>Login Required</td>
        <td>Post Date</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;	
	$result = mysql_query("SELECT * FROM survey_master where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['survey_name']; ?></td>
        <td>
		<?php 
		if($row['status'] == '1'){ 
        echo "<span style='color:green'>Active</span>";
        } else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } ?>
        </td>
      	<td><?php echo $row['login_required'];?></td>
      	<td><?php echo $row['post_date']; ?></td>
                
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_survey.php?id=<?php echo $row['id']; ?>&status=0&action=actives" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_survey.php?id=<?php echo $row['id']; ?>&status=1&action=actives" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } ?></td>
        
        <td><a href="manage_survey.php?action=edits&id=<?php echo $row['id']; ?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        
        <td><a href="manage_survey.php?action=dels&id=<?php echo $row['id']; ?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></a></td>
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

<?php 
if(($_REQUEST['action']=='adds') || ($_REQUEST['action']=='edits'))
{
  $action='saves';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edits'))
  {
		$action='updates';
		$result2 = mysql_query("SELECT * FROM survey_master where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{			
			$survey_name = stripslashes($row2['survey_name']);
			$status = stripslashes($row2['status']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Survey</td>
    </tr>
    <tr>
    <td class="content_txt">Survey Title</td>
    <td><input type="text" name="survey" id="survey" title="Please Enter Survey Title" class="show-tooltip input_txt" value="<?php echo $survey_name;?>"/>    </td>
    </tr>
	
	<tr>
	<td valign="top"><strong>Status</strong></td>
	<td>
	<input type="radio" name="status" value="1" <?php if($status=='1'){echo "checked='checked'";}?>> Active &nbsp;
	<input type="radio" name="status" value="0" <?php if($status=='0'){echo "checked='checked'";}?>> Inactive &nbsp;
	</td>
	</tr>
	
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
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