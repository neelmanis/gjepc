<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php
$adminID = intval($_SESSION['curruser_login_id']);

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	//Unlink the previuos image		  
	$qpreviousimg = "select images,pdf from seminar_calendar where id=?";
	$stmt = $conn -> prepare($qpreviousimg);
	$stmt->bind_param("i", intval($_REQUEST['id']));
	$stmt -> execute();
	$result = $stmt->get_result();		   
	$rpreviousimg = $result->fetch_assoc();
	$images_del="calendar/".$rpreviousimg['images'];
	$pdf_del="calendar/".$rpreviousimg['pdf'];
	unlink($images_del);  
	unlink($pdf_del);  
	
	$sql="delete from seminar_calendar where id=?";	
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", intval($_REQUEST['id']));
	if($stmtd->execute()){	echo"<meta http-equiv=refresh content=\"0;url=seminar_calendar.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$modified_date = date('Y-m-d');
	$sql="update seminar_calendar set status=?,adminId=?,modified_date=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("sisi", $status,$adminID,$modified_date,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=seminar_calendar.php?action=view\">"; } else { echo 'error'; }
}

if($_REQUEST['action']=='save')
{	
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$title = filter($_REQUEST['title']);
	$date_time = trim($_REQUEST['date_time']);	
	$date_start = trim($_REQUEST['date_start']);
	$date_end = trim($_REQUEST['date_end']);
	$place = filter($_REQUEST['place']);
	$seminar_theme = filter($_REQUEST['seminar_theme']);
	$seminar_objective = filter($_REQUEST['seminar_objective']);
	$contact_person = filter($_REQUEST['contact_person']);
	$full_description = filter($_REQUEST['full_description']);
	$region = filter($_REQUEST['region']);
	$region_email = filter($_REQUEST['region_email']);
	
	if(isset($_FILES['event_image']) && $_FILES['event_image']['name']!="")
	{
		$event_image = '';
		$target_folder = 'calendar/';
		$file_name = $_FILES['event_image']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";		
		$target_path = "";
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='seminar_calendar.php?action=add';</script>";
			exit;
		}
		else if($file_name !='')
		{
		if((($_FILES["event_image"]["type"] == "image/png") || ($_FILES["event_image"]["type"] == "image/jpg") || ($_FILES["event_image"]["type"] == "image/jpeg")) && $file_size < 2097152)
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['event_image']['tmp_name'], $target_path))
				{
				$event_image = $temp_code.'_'.$file_name;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='seminar_calendar.php?action=add';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid Image.\");location.href='seminar_calendar.php?action=add';</script>";
			}		
		}
	}
	
	if(isset($_FILES['event_pdf']) && $_FILES['event_pdf']['name']!="")
	{
		$upload_pdf = '';
		$target_folder = 'calendar/';
		$file_name = $_FILES['event_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$target_path = "";
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='seminar_calendar.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{					
			if(($_FILES["event_pdf"]["type"] == "application/pdf" || $_FILES["event_pdf"]["type"] == "application/PDF"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['event_pdf']['tmp_name'], $target_path))
				{
				$upload_pdf = $temp_code.'_'.$file_name;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='seminar_calendar.php?action=add';</script>";
				return;
				}
			 } else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid PDF.\");location.href='seminar_calendar.php?action=add';</script>";
			 }		
		}
	}
	$status=1;
	$sql="INSERT INTO `seminar_calendar`(`title`, `start`, `end`, `date_time`, `place`, `seminar_theme`, `seminar_objective`, `contact_person`, `full_description`,`images`, `pdf`, `region`, `region_email`,`status`, `adminId`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("sssssssssssssii", $title,$date_start,$date_end,$date_time,$place,$seminar_theme,$seminar_objective,$contact_person,$full_description,$event_image,$upload_pdf,$region,$region_email,$status,$adminID);
	$stmt->execute();
	echo"<meta http-equiv=refresh content=\"0;url=seminar_calendar.php?action=view\">";
	} else {
	 echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='seminar_calendar.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{	
	$id = $_REQUEST['id'];
	$title = filter($_REQUEST['title']);
	$date_time = trim($_REQUEST['date_time']);	
	$date_start = trim($_REQUEST['date_start']);
	$date_end = trim($_REQUEST['date_end']);
	$place = filter($_REQUEST['place']);
	$seminar_theme = filter($_REQUEST['seminar_theme']);
	$seminar_objective = filter($_REQUEST['seminar_objective']);
	$contact_person = filter($_REQUEST['contact_person']);
	$full_description = trim($_REQUEST['full_description']);
	$region = filter($_REQUEST['region']);
	$region_email = filter($_REQUEST['region_email']);
	$status = filter($_REQUEST['status']);
	
	if(isset($_FILES['event_image']) && $_FILES['event_image']['name']!="")
	{
		$event_image = '';
		$target_folder = 'calendar/';
		$file_name = $_FILES['event_image']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";		
		$target_path = "";
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='seminar_calendar.php?action=add';</script>";
			exit;
		}
		else if($file_name !='')
		{
		if((($_FILES["event_image"]["type"] == "image/png") || ($_FILES["event_image"]["type"] == "image/jpg") || ($_FILES["event_image"]["type"] == "image/jpeg")) && $file_size < 2097152)
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['event_image']['tmp_name'], $target_path))
				{
				$event_image = $temp_code.'_'.$file_name;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='seminar_calendar.php?action=add';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid Image.\");location.href='seminar_calendar.php?action=add';</script>";
			}		
		}
	}
	
	if(isset($_FILES['event_pdf']) && $_FILES['event_pdf']['name']!="")
	{
		$upload_pdf = '';
		$target_folder = 'calendar/';
		$file_name = $_FILES['event_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$target_path = "";
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='seminar_calendar.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{					
			if(($_FILES["event_pdf"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['event_pdf']['tmp_name'], $target_path))
				{
				$upload_pdf = $temp_code.'_'.$file_name;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='seminar_calendar.php?action=add';</script>";
				return;
				}
			 } else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid PDF.\");location.href='seminar_calendar.php?action=add';</script>";
			 }		
		}
	}
	
	$sql.="UPDATE `seminar_calendar` SET `modified_date`=NOW(),`title`='$title',`start`='$date_start',`end`='$date_end',`date_time`='$date_time',`place`='$place',`seminar_theme`='$seminar_theme',`seminar_objective`='$seminar_objective',`contact_person`='$contact_person',`full_description`='$full_description',`region`='$region',`region_email`='$region_email'";
	if(isset($event_image) && $event_image!='')
			$sql.=",`images`='$event_image'";
	if(isset($upload_pdf) && $upload_pdf!='')
		$sql.=",`pdf`='$upload_pdf'";

	$sql.=",`status`='$status',`adminId`='$adminID' WHERE id='$id'";
	$stmt = $conn -> prepare($sql);
	$stmt->execute();
	echo "<meta http-equiv=refresh content=\"0;url=seminar_calendar.php?action=view\">";
			
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script src="js/jqueryNew.js"></script>  <!-- Calendar    -->
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<!-- Calendar Starts -->
<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">	
<link href="https://www.malot.fr/bootstrap-datetimepicker/css/bootstrap.css" rel="stylesheet">
<!-- Calendar End -->
<script src="//cdn.ckeditor.com/4.4.4/full/ckeditor.js"></script>
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
	if(document.getElementById('title').value == '')
	{
		alert("Please Enter Title.");
		document.getElementById('title').focus();
		return false;
	}
	
/*	if(!isAlphaNumeric(document.getElementById('date_time').value))
	{	
		alert("Please Enter Date & Time");
		document.getElementById('date_time').focus();
		return false;
	} */
	
	if(document.getElementById('start').value == '')
	{
		alert("Please Choose Start Date & Time.");
		document.getElementById('start').focus();
		return false;
	}
	
	if(document.getElementById('end').value == '')
	{
		alert("Please Choose End Date & Time.");
		document.getElementById('end').focus();
		return false;
	}
	
	if(document.getElementById('long_desc').value == '')
	{
		alert("Please Enter Long Desc.");
		document.getElementById('long_desc').focus();
		return false;
	}		
}

function isAlphaNumeric(str) {
  var name = document.getElementById('name').value;
    if( /[^a-zA-Z 0-9\-]+$/i.test( name ) ) {
		//->  /[^a-zA-Z 0-9]/
       //alert("Please Enter Valid Name");
       return false;
    }
    return true; 
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
<style>
	.view_btn {
    color: #fff;
    text-align: center;
    font-weight: bold;
    margin-bottom: 2px;
    margin-top: 5px;
    padding-left: 20px;
	}	
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Seminars</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="seminar_calendar.php?action=add"><div class="content_head_button">Add New</div></a> <a href="seminar_calendar.php?action=view"><div class="content_head_button">View Events</div></a> </div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Title</td>
        <td>Start</td>
        <td>End</td>        
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = $conn ->query("SELECT * FROM seminar_calendar where 1".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo filter($row['title']); ?></td>
        <td><?php echo $row['start']; ?></td>
        <td><?php echo $row['end']; ?></td>        
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="seminar_calendar.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="seminar_calendar.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td><a href="seminar_calendar.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td><a href="seminar_calendar.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
    <?php  } ?>
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
		$sql3 = "SELECT * FROM seminar_calendar where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$title=stripslashes(trim($row2['title']));
			$date_time = stripslashes(trim($row2['date_time']));	
			$date_start = stripslashes(trim($row2['start']));
			$date_end = stripslashes(trim($row2['end']));
			$place = stripslashes(trim($row2['place']));
			$seminar_theme = stripslashes(trim($row2['seminar_theme']));
			$seminar_objective = stripslashes(trim($row2['seminar_objective']));
			$contact_person = stripslashes(trim($row2['contact_person']));
			$full_description = stripslashes(trim($row2['full_description']));
			$images = stripslashes(trim($row2['images']));
			$pdf = stripslashes(trim($row2['pdf']));
			$region = stripslashes(trim($row2['region']));
			$region_email = stripslashes(trim($row2['region_email']));
			$status = stripslashes(trim($row2['status']));
		}
	}
?>
 
<div class="content_details1">
<form action="#" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"/>
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Seminars</td>
    </tr>  	
    <tr>
    <td class="content_txt">Title<span class="star">*</span></td>
    <td><input type="text" name="title" id="title" class="input_txt" value="<?php echo $title;?>" placeholder="Enter Title" autocomplete="off"/></td>
    </tr>
    <!--<tr>
    <td class="content_txt">Date & Time<span class="star">*</span></td>
    <td><input type="text" name="date_time" id="date_time" class="input_txt" placeholder="30th June, 2018 Time: 11 AM to 1PM" value="<?php echo $date_time;?>" autocomplete="off"/></td>
    </tr>-->
	<tr>
    <td class="content_txt">Start Date<span class="star">*</span></td>
    <td><input size="16" type="text" value="<?php echo $date_start;?>" name="date_start" class="date_start" placeholder="Choose Start Date & Time" readonly>
    <span class="add-on"><i class="icon-th"></i></span></td>
	</tr>
	<tr>
    <td class="content_txt">End Date<span class="star">*</span></td>
    <td><input size="16" type="text" value="<?php echo $date_end;?>" name="date_end" class="date_end" placeholder="Choose End Date & Time" readonly>
    <span class="add-on"><i class="icon-th"></i></span></td>
	</tr>
	<!--<tr>
    <td class="content_txt">Place<span class="star">*</span></td>
    <td><input type="text" name="place" id="place" class="input_txt" placeholder="Place" value="<?php echo $place;?>" autocomplete="off"/></td>
    </tr>
	<tr>
    <td class="content_txt">Seminar theme<span class="star">*</span></td>
    <td><textarea name="seminar_theme" id="seminar_theme" class="input_txt" placeholder="Seminar Theme"><?php echo $seminar_theme;?></textarea></td>
    </tr>
	<tr>
    <td class="content_txt">Seminar objective<span class="star">*</span></td>
    <td><textarea name="seminar_objective" id="seminar_objective" class="input_txt" placeholder="Seminar Objective"><?php echo $seminar_objective; ?></textarea></td>
    </tr>
    <tr>
    <td class="content_txt">Contact Person <span class="star">*</span></td>
    <td><textarea name="contact_person" id="contact_person" class="input_txt" placeholder="Enter Contact Person Details"><?php echo $contact_person; ?></textarea>
    </td>
    </tr> -->	
    <tr>
    <td class="content_txt">Event Image<span class="star">*</span></td>
    <td><input name="event_image" id="event_image" type="file"/>
	<?php if (isset($images) && !empty($images)) {?>
	<img src="calendar/<?php echo $images;?>" align="center" height="100" width="100"><?php } ?>
	</td>
    </tr>	
	<tr>
    <td class="content_txt">Event pdf </td>
    <td><input name="event_pdf" id="event_pdf" type="file"/> <span class="star">*</span> (If u have Events PDF) <?php if(isset($pdf) && !empty($pdf)) { ?>
	<a class="view_btn" href="calendar/<?php echo $pdf;?>" target="_blank"> <u>VIEW POST EVENTS </u></a>
	<?php } ?></td>
    </tr>
	
	<tr>
	<td class="content_txt">Full Description </td> 
	<td><textarea name="full_description" class="ckeditor" id="content"><?php echo $full_description;?></textarea></td>
	</tr>
	
	<tr>
	<td valign="top"><strong>Select Region</strong></td>
	<td>
	<input type="radio" name="region" value="HO-MUM" <?php if($region=="HO-MUM"){?> checked="checked" <?php }?>/> HO-MUM &nbsp;
	<input type="radio" name="region" value="RO-CHE" <?php if($region=="RO-CHE"){?> checked="checked" <?php }?>/> RO-CHE &nbsp;
	<input type="radio" name="region" value="RO-DEL" <?php if($region=="RO-DEL"){?> checked="checked" <?php }?>/> RO-DEL &nbsp;
	<input type="radio" name="region" value="RO-JAI" <?php if($region=="RO-JAI"){?> checked="checked" <?php }?>/> RO-JAI &nbsp;
	<input type="radio" name="region" value="RO-KOL" <?php if($region=="RO-KOL"){?> checked="checked" <?php }?>/> RO-KOL &nbsp;
	<input type="radio" name="region" value="RO-SRT" <?php if($region=="RO-SRT"){?> checked="checked" <?php }?>/> RO-SRT &nbsp;	  
	<br/>
	<input type="text" name="region_email" id="region_email" class="input_txt" placeholder="Region EmailID" value="<?php echo $region_email;?>" autocomplete="off" required/></p>
	</td>
	</tr>
	
	<tr>
    <td class="content_txt">Status <span class="star">*</span></td>
    <td>
    <select name="status" id="status" class="input_txt">
    <option value="">Select Status</option>
    <option value="1" <?php if($status=="1"){echo "selected='selected'";} ?>>Active</option>
    <option value="0" <?php if($status=="0"){echo "selected='selected'";} ?>>Inactive</option>
    </select></td>
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

<script src="https://www.malot.fr/bootstrap-datetimepicker/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?t=20130302"></script>
  <script type="text/javascript">    	
    $(".date_start").datetimepicker({
      format: 'yyyy-mm-dd hh:ii:ss',
	  autoclose: true,
      todayBtn: true,
    });  
    $(".date_end").datetimepicker({
      format: 'yyyy-mm-dd hh:ii:ss',
	  autoclose: true,
      todayBtn: true,
    });  	
  </script>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<!-- ckeditor script -->
<script>
CKEDITOR.replace( 'content', {
filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?Type=Files',
filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?Type=Images',
filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?Type=Flash',
filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
</script>
<?php  ob_end_flush(); ?>
</body>
</html>