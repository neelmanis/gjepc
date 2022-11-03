<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php');
?>
<?php
$adminID=$_SESSION['curruser_login_id'];
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{	
	$email_id=addslashes($_REQUEST['email']);
	$id=$_REQUEST['id'];

	$approval=addslashes($_REQUEST['approval']);
	$disapprove_reason=addslashes($_REQUEST['disapprove_reason']);
	
		 if($approval == "Y"){ $disapprove_reason = ""; }
	else if($approval == "P"){ $disapprove_reason = ""; }
	else if($approval == "C"){ $disapprove_reason = ""; }
	else{$approval = "D";}
	
	$sqlx = "UPDATE `wdc_registration` SET `modified_date`=NOW(),adminId='$adminID',`approval`='$approval',`disapprove_reason`='$disapprove_reason' WHERE id='$id'";
	$resultx = mysql_query($sqlx);
	
	if($resultx)
	{		
		/*.......................Send mail For Approved........................*/
if($approval=='Y')
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td width="150" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT THE WDC 2018</u></strong></td></tr>
		
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif; background-color: rgb(251, 251, 251);">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for <strong> THE WDC 2018 </strong> has been Approved.</td>
	</tr>
	<tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
	</tbody>
	</table>	
    </tr>
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> Tel + 9122 43541800 Fax +9122 26524769 <br> Website: <a href="http://www.gjepc.org/">http://www.gjepc.org/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id;	
	$subject = "YOUR APPLICATION FOR THE WDC 2018 Approved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
else if($approval=='D') //Send mail For DisApproved
{	
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
        <td width="150" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT APPLICATION FOR THE WDC 2018</u></strong></td></tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif; background-color: rgb(251, 251, 251);">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for <strong> THE WDC 2018 </strong> has been Disapproved.</td>
	</tr>
	<tr>
	<td colspan="2"><br/>
	<strong>Reason :</strong> '.$disapprove_reason.'.</td>
	</tr>
	<tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
	</tbody>
	</table>	
    </tr>
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> Tel + 9122 43541800 Fax +9122 26524769 <br> Website: <a href="http://www.gjepc.org/">http://www.gjepc.org/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id;
	$subject = "YOUR APPLICATION FOR THE WDC 2018 Disapproved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
else if($approval=='C') //Send mail For Cancellation
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
        <td width="150" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT APPLICATION FOR THE WDC 2018</u></strong></td></tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif; background-color: rgb(251, 251, 251);">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for <strong> WDC 2018 </strong> has been Cancelled.</td>
	</tr>
	<tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
	</tbody>
	</table>	
    </tr>
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> Tel + 9122 43541800 Fax +9122 26524769 <br> Website: <a href="http://www.gjepc.org/">http://www.gjepc.org/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id;
	$subject = "YOUR APPLICATION FOR THE WDC 2018 Canceled"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
/***  Emailer End **/
echo"<meta http-equiv=refresh content=\"0;url=wdc.php?action=view\">";
}
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";
  $_SESSION['company']="";
  
  header("Location: wdc.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['name']=mysql_real_escape_string($_REQUEST['name']);
	$_SESSION['company']=mysql_real_escape_string($_REQUEST['company']);
	}
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage WDC ||GJEPC||</title>

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

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Registration</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Participant
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="wdc.php?action=view">Back to Participant</a></div>
        <?php }?>
        <a href="wdc_export_international.php">&nbsp; &nbsp; &nbsp; Export Participant List</a>
        </div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
<tr>
    <td width="19%" ><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company" id="company" class="input_txt" value="<?php echo $_SESSION['company'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>Name</strong></td>
  <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" autocomplete="off"/></td>
</tr>

    <td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">No.</a></td>
		<td width="10%">Date</td>
        <td width="25%">Company Name</td>
        <td width="20%">Name</td>
        <td width="15%">Email ID</td>
        <td width="15%">Mobile</td>
        <td width="15%">Region</td>
		<td width="10%">Action</td>
    </tr>
    
    <?php 	
 	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql="SELECT * FROM `wdc_registration` WHERE 1";
	
	if($_SESSION['name']!="")
	{
	$sql.=" and first_name like '%".$_SESSION['name']."%'";
	}
	
	if($_SESSION['company']!="")
	{
	$sql.=" and company_name like '%".$_SESSION['company']."%'";
	}
	
	$sql.= "  ".$attach." ";
	$result1=mysql_query($sql);
	$rCount=mysql_num_rows($result1);	
	$sql1= $sql." limit $start, $limit";
	$result=mysql_query($sql1);

    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
		<td align="left"><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
        <td><?php echo strtoupper($row['company_name']);?></td>
        <td><?php echo strtoupper($row['first_name']." ".$row['last_name']);?></td>
        <td align="left"><?php echo $row['email'];?></td>
        <td align="left"><?php echo $row['mobile_no'];?></td>
        <td align="left"><?php echo strtoupper($row['region']);?></td>
		<!--<td align="left">
		<?php 
		if($row['approval']=='P'){ echo 'PENDING'; }
		elseif($row['approval']=='Y'){ echo '<span style="color:green">APPROVED</span>'; } 
		elseif($row['approval']=='C'){ echo '<span style="color:red">CANCELLED</span>'; } 
		else { echo '<span style="color:red">DISAPPROVED</span>'; } ?>
		</td> -->		
		<td align="left"><a href="wdc.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
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
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

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
<div class="pages_1">Total number of Participant: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'wdc.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT * FROM wdc_registration where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{				
			$first_name=stripslashes($row2['first_name']);
			$last_name=stripslashes($row2['last_name']);
			$company=htmlentities(strip_tags($row2['company_name']));
			$mobile_no=stripslashes($row2['mobile_no']);			
			$gender=stripslashes($row2['gender']);
			$country=stripslashes($row2['country']);			
			$visa=htmlentities(strip_tags($row2['visa']));			
			$pan_no=htmlentities(strip_tags($row2['pan_no']));			
			$email=htmlentities(strip_tags($row2['email']));			
			$passport_number=htmlentities(strip_tags($row2['passport_number']));
			$passport_issue_date=htmlentities(strip_tags($row2['passport_issue_date']));
			$passport_issue_authority=htmlentities(strip_tags($row2['passport_issue_authority']));
			$passport_expiry_date=htmlentities(strip_tags($row2['passport_expiry_date']));
			$nationality=$row2['nationality'];
			$dob=htmlentities(strip_tags($row2['dob']));
			$photo=$row2['photo'];
			$dietary_pref=$row2['dietary_pref'];
			$arrival_date=$row2['arrival_date'];
			$departure_date=stripslashes($row2['departure_date']);
			$accomodation=stripslashes($row2['accomodation']);
			$badge=htmlentities(strip_tags($row2['badge']));			
			$region=trim($row2['region']);			
			$approval=stripslashes($row2['approval']);
			$disapprove_reason=htmlentities(strip_tags($row2['disapprove_reason']));
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"/>
  	
	 <tr>
       <td class="content_txt" width="15%"> First Name </td>
       <td><input type="text" name="first_name" id="first_name" class="input_txt" value="<?php echo $first_name; ?>" readonly="readonly"/></td>
     </tr> 
	 <tr>
       <td class="content_txt" width="15%">Last Name </td>
       <td><input type="text" name="last_name" id="last_name" class="input_txt" value="<?php echo $last_name; ?>" readonly="readonly"/></td>
     </tr>   
      <tr>
       <td class="content_txt">Company Name </td>
       <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $company; ?>" readonly="readonly"/></td>
     </tr>	   
     <tr>
       <td class="content_txt">Mobile No </td>
       <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $mobile_no; ?>" readonly="readonly" /></td>
     </tr>	 
     <tr>
       <td class="content_txt">Email ID </td>
       <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $email;?>" readonly="readonly"/></td>
     </tr> 
	<tr>
		<td class="content_txt">gender</td>
		<td colspan="3">
		<input type='radio' name='gender' id='gender' value='M' <?php if($gender=='M'){ echo "checked='checked'"; }?> />Male
		<input type='radio' name='gender' id='gender' value='F' <?php if($gender=='F'){ echo "checked='checked'"; }?>/>Female
		</td>
	</tr>
	<?php
	if($region=='domestic'){
	?>
	 <tr>
		<td class="content_txt">PAN</td>
		 <td><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $pan_no;?>" readonly="readonly"/></td>
	</tr>
	<tr>
		  <td class="content_txt">Badge</td>
		  <td colspan="5">
		  <select name="badge" id="badge" class="form-control"> 
				<option value="">--------- Select Badge ---------</option>
				<option <?php if($badge=="WDC MEMBER"){?> selected="selected"<?php }?>>WDC MEMBER</option>
				<option <?php if($badge=="MEDIA"){?> selected="selected"<?php }?>>MEDIA</option>
				<option <?php if($badge=="INVITEE"){?> selected="selected"<?php }?>>INVITEE</option>
			</select>
		  </td>
	 </tr>	
	<?php } ?>
	<?php
	if($region=='international'){
	?>
     <tr>
       <td class="content_txt">Country </td>
       <td>
	   <select name="country" class="input_txt">
        <option value="">---------- Select ----------</option>
        <?php 
        $query=mysql_query("SELECT * FROM country_master");
        while($result=mysql_fetch_array($query)){  ?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$country)echo "selected=selected";?> ><?php echo $result['country_name'];?></option>
        <?php }?>
		</select>
		</td>
     </tr>
	 <tr>
       <td class="content_txt">Visa </td>
       <td colspan="3">
		<input type='radio' name='visa' id='visa' value='YES' <?php if($visa=='YES'){ echo "checked='checked'"; }?> />YES
		<input type='radio' name='visa' id='visa' value='NO' <?php if($visa=='NO'){ echo "checked='checked'"; }?>/>NO
		</td>
     </tr>
	 <tr>
       <td class="content_txt">Passport Number </td>
       <td><input type="text" name="passport_number" id="passport_number" class="input_txt" value="<?php echo $passport_number;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Date Of Issue Of Passport </td>
       <td><input type="text" name="passport_issue_date" id="passport_issue_date" class="input_txt" value="<?php echo $passport_issue_date;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Passport Issuing Authority </td>
       <td><input type="text" name="passport_issue_authority" id="passport_issue_authority" class="input_txt" value="<?php echo $passport_issue_authority;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Date Of Expiry Of Passport</td>
       <td><input type="text" name="passport_expiry_date" id="passport_expiry_date" class="input_txt" value="<?php echo $passport_expiry_date;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Nationality </td>
       <td><input type="text" name="nationality" id="nationality" class="input_txt" value="<?php echo $nationality;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">DOB </td>
       <td><input type="text" name="dob" id="dob" class="input_txt" value="<?php echo $dob;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Photo </td>      
       <td>
	   <?php 
		 if($photo=="")
		 {
		    echo "<img src='wdc/user_pic.jpg' width='100' height='100' />";
		 } else { ?>
		<div class="fancyDemo"> <a rel="group" href="../wdc/<?php echo $photo;?>">
		 <img src='../wdc/<?php echo $photo;?>' width='100' height='100'/></a></div>
		<?php } ?>
       </td>
	 </tr>
	 
	 <tr>
       <td class="content_txt">Dietary Preferences </td>
       <td colspan="3">
		<input type='radio' name='dietary_pref' id='dietary_pref' value='veg' <?php if($dietary_pref=='veg'){ echo "checked='checked'"; }?> />VEG
		<input type='radio' name='dietary_pref' id='dietary_pref' value='kosher' <?php if($dietary_pref=='kosher'){ echo "checked='checked'"; }?>/>KOSHER
		</td>
     </tr>
	 <tr>
       <td class="content_txt">Depature Date </td>
       <td><input type="text" name="departure_date" id="departure_date" class="input_txt" value="<?php echo $departure_date;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Arrival Date </td>
       <td><input type="text" name="arrival_date" id="arrival_date" class="input_txt" value="<?php echo $arrival_date;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Accomodation</td>
       <td colspan="3">
		<input type='radio' name='accomodation' id='accomodation' value='Required' <?php if($accomodation=='Required'){ echo "checked='checked'"; }?> />Required
		<input type='radio' name='accomodation' id='accomodation' value='No required' <?php if($accomodation=='No required'){ echo "checked='checked'"; }?>/>No required
		</td>
     </tr>
	
	 <tr>
		  <td class="content_txt">Badge</td>
		  <td colspan="5">
		  <select name="badge" id="badge" class="form-control"> 
				<option value="">--------- Select Badge ---------</option>
				   <?php $queryb=mysql_query("SELECT * FROM badge_master");
					while($resultb=mysql_fetch_array($queryb)){	?>
					<option value="<?php echo $resultb['badge_name'];?>" <?php if($resultb['badge_name']==$badge)echo "selected=selected";?> ><?php echo $resultb['badge_name'];?></option>
					<?php }?>
			</select>
		  </td>
	 </tr>
	 <?php } ?>
	<!-- <tr>
		<td class="content_txt">Application Approval Status</td>
		<td colspan="5">
		<input type='radio' name='approval' id='approval' value='Y' <?php if($approval=='Y'){ echo "checked='checked'"; }?> />Approve
		<input type='radio' name='approval' id='approval' value='P' <?php if($approval=='P'){ echo "checked='checked'"; }?>/>Pending
		<input type='radio' name='approval' id='approval' value='D' <?php if($approval=='D'){ echo "checked='checked'"; }?>/>Disapprove
		<input type='radio' name='approval' id='approval' value='C' <?php if($approval=='C'){ echo "checked='checked'"; }?>/>Cancel
		</td>
	</tr>
	<tr>
    <td class="content_txt">&nbsp;</td>
    <td colspan="5">
	Disapprove Reason :<input type="text" name="disapprove_reason" id="disapprove_reason" value="<?php echo $disapprove_reason;?>"/>
    </td>
	</tr>-->
	 	
    <!--<tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>-->
</table>
</form>
        </div>
        
<?php } ?>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>