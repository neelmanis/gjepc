<?php session_start();
	ob_start();
 ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from poll_master where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_polls.php?action=view\">";
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update poll_master set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_polls.php?action=view\">";
}
if ($_REQUEST['action']=='save')
{
		$question = $_REQUEST['question'];
		$opt1 = addslashes($_REQUEST['opt1']);
		$opt2 = addslashes($_REQUEST['opt2']);
		$opt3 = addslashes($_REQUEST['opt3']);
		$opt4 = addslashes($_REQUEST['opt4']);
		$post_date = $_REQUEST['s_date'];
		$end_date = $_REQUEST['e_date'];
		$c_answer=$_REQUEST['c_answer'];
		$login_required=$_REQUEST['login_required'];
		$sql="INSERT INTO poll_master (question,opt1,opt2,opt3,c_answer,login_required,status,post_date,end_date) VALUES ('$question','$opt1','$opt2','$opt3','$c_answer','$login_required','1','$post_date','$end_date')";
		$resultx = $conn ->query($sql);
		$last_id = mysqli_insert_id($conn);
		
		$option_insert1="insert into polloption_master (q_id,option_name) values ('$last_id','$opt1')";
		$option_insert2="insert into polloption_master (q_id,option_name) values ('$last_id','$opt2')";
		$option_insert3="insert into polloption_master (q_id,option_name) values ('$last_id','$opt3')";
		//$option_insert4="insert into polloption_master (q_id,option_name) values ('$last_id','$opt4')";
		$resultx1 = $conn ->query($option_insert1);
		$resultx2 = $conn ->query($option_insert2);
		$resultx3 = $conn ->query($option_insert3);
		echo"<meta http-equiv=refresh content=\"0;url=manage_polls.php?action=view\">";
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

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
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
    	<div class="content_head"><a href="manage_polls.php?action=add"><div class="content_head_button">Add Polls</div></a> <a href="manage_polls.php?action=view"><div class="content_head_button">View Polls</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Question</td>
        <td >option1</td>
        <td >option2</td>
        <td >option3</td>
        <td >Correct Answer</td>
        <td >Login Required</td>
        <td>Start Date</td>
        <td>End Date</td>
        <td>Answer</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$result = $conn ->query("SELECT * FROM poll_master where 1".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
		//$option_query="select * from polloption_master where q_id=".$row['id'];
		//$result_option=mysql_query($option_query);
		
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['question']; ?></td>
        <td><?php echo $row['opt1']; ?></td>
        <td><?php echo $row['opt2']; ?></td>
        <td><?php echo $row['opt3']; ?></td>
        <td><?php echo getanswer($row['id'],$conn); ?></td>
        <td><?php echo $row['login_required']; ?></td>
        <td><?php echo $row['post_date']; ?></td>
        <td><?php echo $row['end_date']; ?></td>
        <td><a href="view_answer.php?action=view&id=<?php echo $row['id'];?>">View Percentage</a> / <a href="view_feedback.php?action=view&id=<?php echo $row['id'];?>">View Feedback</a>/ <a href="view_polls.php?action=view&id=<?php echo $row['id'];?>">View Polls</a></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_polls.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_polls.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
       <td><a href="manage_polls.php?action=edit&id=<?php echo $row['id']; ?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        
        <td><a href="manage_polls.php?action=del&id=<?php echo $row['id']; ?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></a></td>
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
		$result2 = $conn ->query("SELECT *  FROM poll_master  where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{
			
			$contact_name=stripslashes($row2['contact_name']);
			$address=stripslashes($row2['address']);
			$mobile_no=stripslashes($row2['mobile_no']);
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
			$role=stripslashes($row2['role']);
			$admin_access=$row2['admin_access'];
			$region_id=stripslashes($row2['region_id']);
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
    <td class="content_txt">Question</td>
    <td><input type="text" name="question" id="question" title="Please enter your name" class="show-tooltip input_txt" />    </td>
    </tr>
  
   
    <tr>
    <td class="content_txt">option1</td>
    <td><input type="text" name="opt1" id="opt1" class="input_txt" />
           </td>
    </tr>
    <tr>
    <td class="content_txt">option2</td>
    <td><input type="text" name="opt2" id="opt2" class="input_txt" />
           </td>
    </tr>
    <tr>
    <td class="content_txt">option3</td>
    <td><input type="text" name="opt3" id="opt3" class="input_txt" />
           </td>
    </tr>
   <!-- <tr>
    <td class="content_txt">option4</td>
    <td><input type="text" name="opt4" id="opt4" class="input_txt" />
           </td>
    </tr>-->
    
    <tr>
        <td class="content_txt">Correct Answer</td>
        <td>
        <select class="input_txt" name="c_answer" id="c_answer">
            <option value="">Select Correct Answer</option>
            <option value="1">option 1</option>
            <option value="2">option 2</option>
            <option value="3">option 3</option>
        </select>
        </td>
    </tr>
    
    <tr>
    <td class="content_txt">Login Required</td>
        <td>
        <select class="input_txt" name="login_required" id="login_required">
            <option value="">Select Option</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
        </td>
    </tr>
    
    <tr>
        <td class="content_txt">Start Date</td>
        <td><input type="date" name="s_date" id="s_date" class="input_txt"  /></td>
    </tr>
    <tr>
        <td class="content_txt">End Date</td>
        <td><input type="date" name="e_date" id="e_date" class="input_txt"  /></td>
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
