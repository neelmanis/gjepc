<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = $_SESSION['curruser_login_id'];
?>
<?php 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from webinar_master where id=?";	
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", intval($_REQUEST['id']));
	if($stmtd->execute()){	echo"<meta http-equiv=refresh content=\"0;url=webinar.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$modified_date = date('Y-m-d');
	$sql="update webinar_master set status=?,adminId=?,modified_date=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("sisi", $status,$adminID,$modified_date,$id);
	if($stmt->execute()){	echo "<meta http-equiv=refresh content=\"0;url=webinar.php?action=view\">"; } else { echo 'error'; }
}

if($_REQUEST['action']=='save')
{


// echo "<pre";print_r($_POST);exit;
//validate Token
if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$title = filter($_REQUEST['title']);
	$type = filter($_REQUEST['type']);
	$fees = filter($_REQUEST['fees']);
	$description = htmlspecialchars($_REQUEST['description']);
	$short_desc = $conn->real_escape_string($_REQUEST['short_desc']);
	$youtube_url = filter($_REQUEST['youtube_url']);
	$speaker_name = $_REQUEST['speaker_name'];
	$designation = $_REQUEST['designation'];
    $time = $_POST['time'];
   // $time = date("h:i A", strtotime($_POST['time']));
	$status = $_REQUEST['status'];

	
	//---------------------------------------- uplaod  webinar pdf  -----------------------------------------------
		$banner = '';
		$target_folder = '../assets/images/webinar/new/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		$name = $_FILES['banner']['name'];
	    $name = str_replace(" ","_",$name);
		
		if(preg_match("/.php/i", $name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='webinar.php?action=add';</script>";
			exit;
		}
		else if($name !='')
		{
			if(($_FILES["banner"]["type"] == "image/jpeg") || ($_FILES["banner"]["type"] == "image/jpg") || ($_FILES["banner"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$name;
				if(@move_uploaded_file($_FILES['banner']['tmp_name'], $target_path))
				{
					$banner = $temp_code.'_'.$name;
					$sql="INSERT INTO webinar_master (title,type,fees,short_desc,description,banner,youtube_url,status,post_date,start_time,adminID) VALUES (?,?,?,?,?,?,?,?,?,?,?)";			
					$stmt = $conn -> prepare($sql);
					$stmt->bind_param("ssssssssssi", $title,$type,$fees,$short_desc,$description,$banner,$youtube_url,$status,$post_date,$time,$adminID);
					$stmt->execute();
					$insert_id = $conn->insert_id;
					if($insert_id ){	

                    if(is_array($speaker_name) && is_array($designation)){
                    
                    $count = sizeof($speaker_name);
				    for($i=0 ;$i < $count ; $i++) { 
                         filter($speaker_name[$i]);
                         filter($designation[$i]);
				    	if(!empty($speaker_name[$i]) && !empty($designation[$i])){
				    		 $sql2 = "INSERT INTO webinar_speaker_details SET webinar_id='$insert_id', speaker_name='$speaker_name[$i]',speaker_designation='$designation[$i]'";
				    	$conn->query($sql2);
				    	}
				    	
				    }
				 	}
	
						echo "<meta http-equiv=refresh content=\"0;url=webinar.php?action=view\">"; 
					}else{ die ($conn->error); }
				} else {
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='webinar.php?action=add';</script>";
				return;
				}
			} else {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='webinar.php?action=add';</script>";
			}	
		}		
	} else {
		echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$title = filter($_REQUEST['title']);
	$type = filter($_REQUEST['type']);
	$fees = filter($_REQUEST['fees']);
	$description = htmlspecialchars($_REQUEST['description']);
	$short_desc = $conn->real_escape_string($_REQUEST['short_desc']);
	$youtube_url = filter($_REQUEST['youtube_url']);	
	$status = $_REQUEST['status'];
	$id = filter($_REQUEST['id']);	
    $speaker_name = $_REQUEST['speaker_name'];
	$designation = $_REQUEST['designation'];
	$time = $_POST['time'];
	//------------------------------------  Update webinar PDF ----------------------------------------------------
		$banner = '';
		$target_folder = '../assets/images/webinar/new/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		$name = $_FILES['banner']['name'];
	    $name = str_replace(" ","_",$name);
		
		$getDetails =  $conn ->query("SELECT * FROM webinar_master where id='$id'");
		$resultDetails =$getDetails->fetch_assoc(); 
		$bannerImage = $resultDetails['banner'];
		if(preg_match("/.php/i", $name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='webinar.php?action=add';</script>";
			exit;
		}
		 if($name !='')
		{
			if(($_FILES["banner"]["type"] == "image/jpeg") || ($_FILES["banner"]["type"] == "image/jpg") || ($_FILES["banner"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$name;
				if(@move_uploaded_file($_FILES['banner']['tmp_name'], $target_path))
				{
					$banner = $temp_code.'_'.$name;
					$sql = $conn ->query("update webinar_master set banner='$banner' where id='$id'");
					if(!$sql) die ($conn->error);
				}	else {
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='webinar.php?action=edit&id=$id';</script>";
				return;
				}
			} else {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='webinar.php?action=edit&id=$id';</script>";
			}	
		}
		// echo "update webinar_master set title='$title',type='$type',short_desc='$short_desc',description='$description',youtube_url='$youtube_url',status='$status',post_date='$post_date',start_time='$time' where id='$id'";exit;
	$sql = $conn ->query("update webinar_master set title='$title',type='$type',fees='$fees',short_desc='$short_desc',description='$description',youtube_url='$youtube_url',status='$status',post_date='$post_date',start_time='$time' where id='$id'");	
	if(!$sql) die ($conn->error);


                    if(is_array($speaker_name) && is_array($designation)){
                    $deleteSql = "DELETE FROM webinar_speaker_details WHERE webinar_id='$id'";
                    $conn->query($deleteSql);

                    $count = sizeof($speaker_name);
				    for($i=0 ;$i < $count ; $i++) { 
                         filter($speaker_name[$i]);
                         filter($designation[$i]);
				    	if(!empty($speaker_name[$i]) && !empty($designation[$i])){
				    		 $sql2 = "INSERT INTO webinar_speaker_details SET webinar_id='$id', speaker_name='$speaker_name[$i]',speaker_designation='$designation[$i]'";
				    	$conn->query($sql2);
				    	}
				    	
				    }
				 	}
	
	echo"<meta http-equiv=refresh content=\"0;url=webinar.php?action=view\">";
	} else {
		echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
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
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>

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
<link href="../css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#post_date').datepick();

});
</script>

<script language="javascript">
function checkdata()
{


	if(document.getElementById('post_date').value == '')
	{
		alert("Please Select Webinar Date ");
		document.getElementById('post_date').focus();
		return false;
	}
	if(document.getElementById('type').value == '')
	{
		alert("Please Select Webinar/Workshop  ");
		document.getElementById('type').focus();
		return false;
	}


	if(document.getElementById('title').value == '')
	{
		alert("Please Enter Title.");
		document.getElementById('title').focus();
		return false;
	}
	if(document.getElementById('fees').value == '')
	{
		alert("Please Add Fees ");
		document.getElementById('fees').focus();
		return false;
	}
	// if(document.getElementById('banner').value == '')
	// {
	// 	alert("Please Upload webinar.");
	// 	document.getElementById('banner').focus();
	// 	return false;
	// }
	if(document.getElementById('status').value == '')
	{
		alert("Please Select Status.");
		document.getElementById('status').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('banner').value == '')
	{
		alert("Please Upload webinar.");
		document.getElementById('banner').focus();
		return false;
	}
	<?php } ?>
		
    }

	$(document).ready(function(){
	    var maxField = 20; 
		var x = 1;
		$(".add_btn").click(function(e){
			e.preventDefault();
			var wrapper = $("#speaker_table");
			if(x < maxField){
			x++; 
			$(wrapper).append(
				'<tr>'+
				'<td>'+x+'</td>'+
				'<td><input type="text" name="speaker_name[]" id="speaker_name_'+x+'" class="input_txt" width="100%" value=" " autocomplete="off" /></td>'+
				'<td><input type="text" name="designation[]" id="designation_'+x+'" class="input_txt" width="100%" value=" " autocomplete="off" /></td>'+
				'<td><a href="javascript:void(0)" onclick="removeParent(this)" class="input_submit remove_button">Remove</a></td>'+
			   '</tr>'); //Add field html
			}
		});
	});
 	function removeParent(ele){
		 ele.parentNode.parentNode.remove();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage webinar</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="webinar.php?action=add"><div class="content_head_button">Add webinar</div></a> <a href="webinar.php?action=view"><div class="content_head_button">View webinar</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Name</td>
       	<td>Type</td>
        <td>Post Date</td>
        <td>Banner</td>
        <td>fees</td>
        <td colspan="2">Orders/ export</td>
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = $conn ->query("SELECT * FROM webinar_master where 1 ".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo $row['title']; ?></td>
	    <td><?php echo $row['type']; ?></td>
        <td><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
		<td>
		<?php if($row['banner']!=""){?>
        <img src="https://gjepc.org/assets/images/webinar/new/<?php echo $row['banner']; ?>" align="center" height="50" width="80">
		<?php } ?>
        </td>
        <td><?php echo $row['fees']; ?></td>
		<!-- <td>
		<?php if($row['pdf_eng']!=""){?>
		<a href="https://gjepc.org/pdf/key-points/<?php echo $row['pdf_eng']; ?>" target="_blank"><img src="images/pdf_icon.png" height="40" width="50"></a>
		<?php } ?>
        </td>
		<td>
		<?php if($row['pdf_guj']!=""){?>
       <a href="https://gjepc.org/pdf/key-points/<?php echo $row['pdf_guj']; ?>" target="_blank"><img src="images/pdf_icon.png" height="40" width="50"></a>
		<?php } ?>
        </td> -->
        <td><a href="webinar.php?webinar_id=<?php echo $row['id']; ?>&tab=webinar_payment_history">View Orders</a></td>
        <td><a href="webinar_payment_report.php?webinar_id=<?php echo $row['id']; ?>">Export Orders</a></td>
        <td>
		<?php if($row['status'] == '1') { 
        echo "<span style='color:green'>Active</span>";
        }else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="webinar.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="webinar.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="webinar.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="webinar.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM webinar_master where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$title=stripslashes($row2['title']);
			$description=stripslashes($row2['description']);
			$short_desc=stripslashes($row2['short_desc']);

			$banner=stripslashes($row2['banner']);
			$type=stripslashes($row2['type']);
			$banner=stripslashes($row2['banner']);

			$status=stripslashes($row2['status']);
			$post_date = stripslashes(date("d-m-Y",strtotime($row2['post_date'])));
			$time = stripslashes($row2['start_time']);
			$youtube_url= stripslashes($row2['youtube_url']);
			$fees = stripslashes($row2['fees']);;
		}
        $webinar_id =intval($_REQUEST['id']);
		$getSpeakers = $conn->query("SELECT * FROM webinar_speaker_details WHERE webinar_id ='$webinar_id'");
		
		$speakerCount = $getSpeakers->num_rows;

  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New webinar</td>
    </tr>
	<tr>
      <td>Webinar Date <span class="star">*</span></td>
      <td><input type="text" name="post_date" id="post_date" class="input_txt" value="<?php echo $post_date; ?>" placeholder="Date" autocomplete="off" readonly/></td>
    </tr>
    <tr>
      <td>Time <span class="star">*</span></td>
      <td><input type="time" name="time" id="time" class="input_txt" value="<?php echo $time; ?>"  autocomplete="off" /></td>
    </tr>
    <tr>
      <td class="content_txt">Type <span class="star">*</span></td>
      <td>
      	<select name="type" id="type" class="input_txt">
      		<option value="">Select Type</option>
      		<option <?php if($type =="webinar"){echo "selected";}?> value="webinar">Webinar</option>
      		<option  <?php if($type =="workshop"){echo "selected";}?> value="workshop">Workshop</option>
      	</select>
       
    </tr>
    <tr>
      <td class="content_txt">Title <span class="star">*</span></td>
      <td><input type="text" name="title" id="title" class="input_txt" value="<?php echo $title; ?>" autocomplete="off" /></td>
    </tr>
     <tr>
      <td class="content_txt">Fees <span class="star">*</span></td>
      <td><input type="text" name="fees" id="fees" class="input_txt" value="<?php echo $fees; ?>" autocomplete="off" /></td>
    </tr>
    <tr>
    	  <tr>
      <td class="content_txt">Short Description <span class="star">*</span></td>
      <td>
      	<textarea name="short_desc" class="input_txt" id="short_desc" rows="5"><?php echo $short_desc; ?></textarea></td>
    </tr>
    
    <tr>
    	
    <td class="content_txt">Description </td>
    <td><textarea name="description" class="input_txt" id="description"><?php echo ($description) ; ?></textarea>
    <script type="text/javascript">
		CKEDITOR.replace( 'description',
                {

                	allowedContent:true,
                    filebrowserBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Connector=/admin/js/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : 'js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=/admin/js/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=/admin/js/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'/admin/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '/admin/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '/admin/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash',
					width:800
				});
	</script>   
    </td>
    </tr>
    <tr>
    <td class="content_txt">Upload Webinar Image <span class="star">*</span></td>
    <td valign="middle"><input name="banner" id="banner" type="file" />

    	<img src="../assets/images/webinar/new/<?php echo $banner;?>" style="width: 100px"></td>
    </tr>
	 <tr>
      <td class="content_txt">Youtube Url <span class="star">*</span></td>
      <td><input type="text" name="youtube_url" id="youtube_url" class="input_txt" value="<?php echo $youtube_url; ?>" autocomplete="off" /></td>
    </tr>
    <tr>
    	<td class="content_txt">Speakers </td>
    	<td>
    		<table width="100%" border="1" cellpadding="10">
    			<thead>
    				<tr>
    					<th>No.</th>
    					<th>Speaker Name</th>
    					<th>Designation </th>
    					<th>Action </th>
    				</tr>
    			</thead>
    			<tbody id="speaker_table">
    				<?php if($speakerCount > 0){
    					$z=1;
    					while($rowSpeakers = $getSpeakers->fetch_assoc()){?>

                          <tr>
    					<td><?php echo  $z;?></td>
    					<td><input type="text" name="speaker_name[]" id="speaker_name_0" class="input_txt" width="100%" value="<?php echo $rowSpeakers['speaker_name']?> " autocomplete="off" /></td>
    					<td><input type="text" name="designation[]" id="designation_0" class="input_txt" width="100%" value="<?php echo $rowSpeakers['speaker_designation'] ;?> " autocomplete="off" /></td>
    					<td> <?php if($z==1){?> <a href="javascript:void(0);" class="input_submit add_btn">Add More</a> <?php }else{?> <a href="javascript:void(0);" onclick="removeParent(this)" class="input_submit remove_button">Remove</a><?php }?> </td>
    				</tr>
    					<?php $z++; }
    				}else{?>
                    <tr>
    					<td>1</td>
    					<td><input type="text" name="speaker_name[]" id="speaker_name_0" class="input_txt" width="100%"  autocomplete="off" /></td>
    					<td><input type="text" name="designation[]" id="designation_0" class="input_txt" width="100%" autocomplete="off" /></td>
    					<td> <a href="javascript:void(0);" class="input_submit add_btn">Add More</a>  </td>
    				</tr>
    				<?php }?>
    				
    			</tbody>
    		</table>
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
    <?php if(isset($_REQUEST['webinar_id']) && $_REQUEST['webinar_id'] !="" && $_REQUEST['tab']=="webinar_payment_history" ){
    	$webinar_id = trim($_REQUEST['webinar_id']);
    	$orders = "SELECT * FROM webinar_payment_history WHERE webinar_id ='$webinar_id' ORDER BY created_at DESC";
        $resultOrders = $conn->query($orders);
        $countOrders = $resultOrders->num_rows;?>
        <div class="content_details1">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td>Sr. No.</td>
       	<td>User Type</td>
       	<td>Company Name </td>
         <td>Name</td>
         <td>Email Id</td>
         <td>Mobile No.</td>
       	<td>Order Id</td>
       	<td>Ref No </td>
       	<td>Response</td>
       	<td>Created at</td>
       	<td>Amount </td>
       	
    </tr>
       <?php
        if($countOrders>0){
        	$i=1;
        	while ($rowOrders = $resultOrders->fetch_assoc()) {
              if($rowOrders['member_type'] =="member"){
              	 $mregId = $rowOrders['registration_id'];
			      $getMInfo =$conn->query("SELECT * FROM  communication_address_master  WHERE registration_id='$mregId' AND type_of_address='2'");
			      $resultMInfo = $getMInfo->fetch_assoc();;
			      $company_name = getCompanyName($mregId,$conn);
			      $email_id = $resultMInfo['email_id'];
			      $name = $resultMInfo['name'];
			      $mobile_no = $resultMInfo['mobile_no'];
              }else{
              	$nmregId = trim($rowOrders['non_member_id']);
              
		      $getNmInfo =$conn->query("SELECT * FROM  webinar_registration_details  WHERE id='$nmregId'"); 
		      $resultNmInfo = $getNmInfo->fetch_assoc();
		     
		      $company_name = $resultNmInfo['company_name'];
		       $email_id = $resultNmInfo['email_id'];
		       $name = $resultNmInfo['name'];
		       $mobile_no = $resultNmInfo['mobile_no'];
              }
        		?>

           <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
           	<td><?php echo $i;?></td>
           	<td><?php echo $rowOrders['member_type'];?></td>

           	<td><?php echo $company_name;?></td>
           	<td><?php echo $name; ?> </td>
           	<td><?php echo $email_id; ?> </td>
           	<td><?php echo $mobile_no; ?> </td>
           	<td><?php echo $rowOrders['order_id'];?></td>
           	<td><?php echo $rowOrders['ReferenceNo'];?></td>
           	<td><?php if( $rowOrders['Response_Code']=="E00335"){echo "Cancelled by User";}else if($rowOrders['Response_Code']=="E000"){ echo "Successful";}else if($rowOrders['Response_Code']=="E00329"){echo "NEFT";}?></td>
           	<td><?php echo $rowOrders['created_at'];?></td>
           	<td><?php echo $rowOrders['Transaction_Amount'];?></td>
           	
           </tr>
        		
        <?php $i++;	}
        }else{?>
        <tr >
           <td colspan="7">No Orders found</td>
           	
           </tr>
        <?php } ?>
      </table>
  </div>
   <?php } ?>

<?php if(isset($_REQUEST['webinar_id']) && $_REQUEST['webinar_id'] !="" && $_REQUEST['tab']=="webinar_payment_export" ){



   }?>
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
