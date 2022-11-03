<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php
$regId = filter($_SESSION['curruser_login_id']);
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from gst_cust where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", intval($_REQUEST['id']));
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">"; }
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = intval(filter($_REQUEST['id']));
	$sql="update gst_cust set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">"; }
}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$member_code=addslashes($_REQUEST['member_code']);
	$mem_company_name=addslashes($_REQUEST['mem_company_name']);
	$person_name=addslashes($_REQUEST['person_name']);
	$email_id=addslashes($_REQUEST['email_id']);
	$mobile=addslashes($_REQUEST['mobile']);
	$subject=addslashes($_REQUEST['subject']);
	$query=addslashes($_REQUEST['query']);
	$comment=addslashes($_REQUEST['comment']);

	$sql="update gst_cust set regId='$regId', comment='$comment' where id='$id'";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=gst_cust.php?action=view\">"; }

/********************** Send Mail *****************/

$to  =  $email_id;
$subject=addslashes($_REQUEST['subject']);
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
	<td width="85%" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="105" height="91" /></td>         
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"> Feedback on Customer GST </td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Member Code :</strong> '. $member_code .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Member Company Name :</strong> '. $mem_company_name .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Member Person Name :</strong> '. $person_name .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Email Id :</strong> '. $email_id .'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Mobile Number :</strong> '. $mobile .'</td>
  </tr>
  <tr>
    <td align="left"  style="text-align:justify;"><strong>Description :</strong> '. $query .' </td>
  </tr>
   <tr>
    <td align="left"  style="text-align:justify;"><strong>Comment :</strong> '. $comment .' </td>
  </tr>
   <tr>
  <td>&nbsp; </td>
    </tr>
    
</table>'; 
				
				$headers = 'From:GJEPC GST Feedback <do-not-reply@gjepc.org>' . "\n";
				$headers .= "MIME-Version: 1.0" . "\n";
   				$headers .= "Content-type:text/html;charset=UTF-8" . "\n"; 

			  mail($to, $subject, $message, $headers);
	}		  
/********************** Send Mail *****************/
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

<script language="javascript">
function checkdata()
{
	if(document.getElementById('comment').value == '')
	{
		alert("Please put your comment for customer");
		document.getElementById('comment').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Customer GST</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Customer GST</div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
        <td>Member Code</td>
        <td>Member Company Name</td>
        <td>Contact Person Name</td>
		<td>Email ID</td>
        <td>Mobile Number</td>
        <td>Subject</td>
        <td>Description</td>
        <td>Reply</td> 
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM gst_cust where 1".$attach." ";
    $query = $conn -> prepare($sqlx1);
	$query->execute();			
	$result = $query->get_result();
    $rCount=0;
    $rCount=$result->num_rows;		
    if($rCount>0)
    {
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
       <td><?php echo $i;?></td>
        <td><?php echo strip_tags($row['member_code']); ?></td>
        <td><?php echo strip_tags($row['mem_company_name']); ?></td>
        <td><?php echo strip_tags($row['person_name']); ?></td>
        <td><?php echo strip_tags($row['email_id']); ?></td>
        <td><?php echo strip_tags($row['mobile']); ?></td>
        <td><?php echo strip_tags($row['subject']); ?></td>
		<td><?php echo strip_tags($row['query']); ?></td>		
        <td>
		<?php 
		    $regId = $row['regId']; 		   	
			if($regId == 0) {
		 ?>			
		<a href="gst_cust.php?action=edit&id=<?php echo $row['id']?>"><img src="images/reply.png" title="Reply" border="0" style=""/></a>	
		<?php } else {?>
		<a onclick="return(window.confirm('Already Sent'));"><img src="images/active.png"/></a>
		<?php } ?>	
		
		</td>	
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
		$sql3 = "SELECT * FROM gst_cust where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{			
			$member_code=stripslashes($row2['member_code']);
			$mem_company_name=stripslashes($row2['mem_company_name']);
			$person_name=stripslashes($row2['person_name']);
			$email_id=stripslashes($row2['email_id']);
			$mobile=stripslashes($row2['mobile']);
			$subject=stripslashes($row2['subject']);		
			$query=stripslashes($row2['query']);
			$comment=stripslashes($row2['comment']);
		}
  }
?>
<?php  
$sql3 = "select * from gst_cust where id=?";
$query = $conn -> prepare($sql3);
$query -> bind_param("i", intval($_REQUEST['id']));
$query->execute();	
$result2 = $query->get_result();
$row = $result2->fetch_assoc()
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form" id="form" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Admin</td>
    </tr>

    <tr>
		<td class="content_txt">Member Code <span class="star">*</span></td>
		<td>
		  <input type="text" name="member_code" id="member_code" title="Please enter Member Code" class="show-tooltip input_txt" 
		  value="<?php echo $row['member_code'];?>" readonly/>
		</td>
    </tr>
	
	 <tr>
		<td class="content_txt">Member Company Name <span class="star">*</span></td>
		<td><input type="text" name="mem_company_name" id="mem_company_name" title="Please enter Member Company Name" class="show-tooltip input_txt" 
		value="<?php echo $row['mem_company_name'];?>" readonly/> </td>
    </tr>
	
	<tr>
	   <td class="content_txt">Person Name <span class="star">*</span></td>
	   <td>
		  <input type="text" name="person_name" id="person_name" title="Please enter Person Name" class="show-tooltip input_txt" 
		  value="<?php echo $row['person_name'];?>" readonly/>
	   </td>
    </tr>
	
	<tr>
		<td class="content_txt">Email ID <span class="star">*</span></td>
		<td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $row['email_id'];?>" readonly/></td>
    </tr>
  
   
    <tr>
		<td class="content_txt">Mobile Number <span class="star">*</span></td>
		<td><input type="text" name="mobile" id="mobile" class="input_txt" value="<?php echo $row['mobile'];?>" readonly/>
        <label id="lblMsg" style="display:none;">Please enter your contact no.</label>    </td>
    </tr>
    
    
    
    <tr>
    <td class="content_txt">Subject <span class="star">*</span></td>
    <td>
	  <select name="subject" id="subject" class="input_txt">
				<option value="">---Select Subject---</option>
				<option value="<?php echo $row['subject'];?>" <?php if($subject==$row['subject']){?> selected="selected"<?php }?> ><?php echo $row['subject'];?></option>				
	  </select>
	</td>
    </tr>
	
    <tr>
      <td valign="top" class="content_txt">Description</td>
      <td><label>
        <textarea name="query" id="query" rows="5" class="input_txt" readonly><?php echo $row['query'];?></textarea>
      </label></td>
    </tr>
	
	 <tr>
      <td valign="top" class="content_txt">Comment</td>
      <td><label>
        <textarea name="comment" id="comment" rows="5" class="input_txt" value=""></textarea>
      </label></td>
    </tr>              
                
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
</table>
</form>        </div>
        
 <?php } ?>    
    
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
