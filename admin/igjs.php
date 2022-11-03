<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php
$adminID	=	intval(filter($_SESSION['curruser_login_id']));
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{	
	$email_id = filter($_REQUEST['email']);
		  $id = intval(filter($_REQUEST['id']));

	$approval = filter($_REQUEST['approval']);
	$disapprove_reason = filter($_REQUEST['disapprove_reason']);
	$card_type	 =	filter($_REQUEST['card_type']);
	$holder_name =	filter($_REQUEST['holder_name']);
	$card_number =	filter($_REQUEST['card_number']);
	$expiry_month=	filter($_REQUEST['expiry_month']);
	$expiry_year =  filter($_REQUEST['expiry_year']);
	
		 if($approval == "Y"){ $disapprove_reason = ""; }
	else if($approval == "P"){ $disapprove_reason = ""; }
	else if($approval == "C"){ $disapprove_reason = ""; }
	else{$approval = "D";}
	
	$sqlx = "UPDATE `igjs_summit_registration` SET `modified_date`=NOW(), adminId='$adminID', `approval`='$approval', `disapprove_reason`='$disapprove_reason', `card_type`='$card_type', `holder_name`='$holder_name', `card_number`='$card_number', `expiry_month`='$expiry_month', `expiry_year`='$expiry_year' WHERE id='$id'";
	$resultx = mysql_query($sqlx);
	
if($resultx)
{	
		/*.......................Send mail For Approved........................*/
if($approval=='Y')
{
$message='<table width="80%" bgcolor="#fff" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td colspan="3"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    <td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE India Gold Jewellery Summit 2019</u></strong></td></tr>
		
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif;">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for  <strong> THE India Gold Jewellery Summit 2019 </strong> has been Approved.</td>
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

	$to =$email_id.",annu@gjepcindia.com";
	$subject = "YOUR APPLICATION FOR THE India Gold Jewellery Summit 2019 Approved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .='From: India Gold Jewellery Summit 2019 <admin@gjepc.org>';	
	mail($to, $subject, $message, $headers);
}
else if($approval=='D') //Send mail For DisApproved
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td colspan="3"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE India Gold Jewellery Summit 2019</u></strong></td></tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif;">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for <strong> THE India Gold Jewellery Summit 2019 </strong> has been Disapproved.</td>
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

	$to =$email_id.",annu@gjepcindia.com";
	$subject = "YOUR APPLICATION FOR THE India Gold Jewellery Summit 2019 Disapproved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .='From: India Gold Jewellery Summit 2019 <admin@gjepc.org>';
	mail($to, $subject, $message, $headers);
}
else if($approval=='C') //Send mail For Cancellation
{
$message='<table width="80%" bgcolor="#fff" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td colspan="3"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE India Gold Jewellery Summit 2019</u></strong></td></tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif;">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for <strong> THE India Gold Jewellery Summit 2019 </strong> has been Cancelled.</td>
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

	$to =$email_id.",annu@gjepcindia.com";
	$subject = "YOUR APPLICATION FOR THE India Gold Jewellery Summit 2019 Canceled"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .='From: India Gold Jewellery Summit 2019 <admin@gjepc.org>';	
	mail($to, $subject, $message, $headers);
}
/***  Emailer End **/
echo"<meta http-equiv=refresh content=\"0;url=igjs.php?action=view\">";
}
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";
  $_SESSION['company']="";
  $_SESSION['gcode']="";
  $_SESSION['orderid']="";
  $_SESSION['ismember']="";
  
  header("Location: igjs.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['name']=filter($_REQUEST['name']);
	$_SESSION['company']=filter($_REQUEST['company']);
	$_SESSION['gcode']=filter($_REQUEST['gcode']);
	$_SESSION['orderid']=filter($_REQUEST['orderid']);
	$_SESSION['ismember']=filter($_REQUEST['ismember']);
	}
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Participant ||GJEPC||</title>
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
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage Registration</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Participant &nbsp;&nbsp;
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="igjs.php?action=view">Back to Participant</a></div>
        <?php }?>
        <a href="igjs_export.php">Export Participant List</a>&nbsp;&nbsp;
		<a href="participant.php?action=add">Participant</a>
        </div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="POST"> 
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
<!--<tr>
  <td><strong>Order No</strong></td>
  <td><input type="text" name="orderid" id="orderid" class="input_txt" value="<?php echo $_SESSION['orderid'];?>" autocomplete="off"/></td>
</tr>-->
<tr>
  <td><strong>GCode</strong></td>
  <td><input type="text" name="gcode" id="gcode" class="input_txt" value="<?php echo $_SESSION['gcode'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>IsMember</strong></td>  
  <td width="81%">
        <select name="ismember" id="ismember" class="input_txt">
        <option value="">Please Select</option>	
        <option value="M" <?php if($_SESSION['isMember']=="M"){echo "selected='selected'";}?>>Member</option>
        <option value="NM" <?php if($_SESSION['isMember']=="NM"){echo "selected='selected'";}?>>NonMember</option>
        <option value="IN" <?php if($_SESSION['isMember']=="IN"){echo "selected='selected'";}?>>International</option>	
        </select>  
    </td>
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
		<td width="5%">GCode</td>
		<td width="5%">IsMember</td>
        <td width="25%">Company Name</td>
        <td width="25%">State</td>
        <td width="20%">Name</td>
        <td width="15%">Email ID</td>
		<td width="10%">Application Status</td>		
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
	
    $sql="SELECT * FROM `igjs_summit_registration` WHERE 1";
	
	if($_SESSION['name']!="")
	{
	$sql.=" and name like '%".$_SESSION['name']."%'";
	}
	
	if($_SESSION['company']!="")
	{
	$sql.=" and company like '%".$_SESSION['company']."%'";
	}
	
	if($_SESSION['gcode']!="")
	{
	$sql.=" and gcode ='".$_SESSION['gcode']."'";
	}
	/*
	if($_SESSION['orderid']!="")
	{
	$sql.=" and orderid ='".$_SESSION['orderid']."'";
	}*/
	
	if($_SESSION['ismember']!="")
	{
	$sql.=" and ismember ='".$_SESSION['ismember']."'";
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
        <td><?php echo $row['gcode']; ?></td>
        <td>
		<?php
		if($row['ismember']=='M') { $isMember = 'Member';}elseif($row['ismember']=='NM') { $isMember = 'NonMember';}else{ $isMember = 'international';}	echo strtoupper($isMember);
		?>
		</td>
        <td><?php echo strtoupper(filter($row['company']));?></td>
        <td><?php echo strtoupper(filter($row['state_name']));?></td>
        <td><?php echo strtoupper(filter($row['name']));?></td>
        <td align="left"><?php echo filter($row['email']);?></td>
		<td align="left">
		<?php 
		if($row['approval']=='P'){ echo 'PENDING'; }
		elseif($row['approval']=='Y'){ echo '<span style="color:green">APPROVED</span>'; } 
		elseif($row['approval']=='C'){ echo '<span style="color:red">CANCELLED</span>'; } 
		else { echo '<span style="color:red">DISAPPROVED</span>'; } ?>
		</td> 		
       
        <!--<td align="left"><a href="igjs.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>-->
	<!--<td align="left"><a href="printBadges.php?action=print&id=<?php echo $row['id']?>" target="_blank"><img src="images/print.png" title="Print" border="0" /></a></td>-->
		<td align="left"><a href="igjs.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
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
<?php echo pagination($limit,$page,'igjs.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT * FROM igjs_summit_registration where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{	
			$gcode=filter($row2['gcode']);
			$ismember=filter($row2['ismember']);
			$title=filter($row2['title']);
			$name=filter($row2['name']);
			$designation=filter($row2['designation']);
			$company=filter($row2['company']);
			$address=filter($row2['address']);
			$state_name=filter($row2['state_name']);
			$city_name=filter($row2['city_name']);
			$land_line_no=filter($row2['land_line_no']);
			$mobile_no=filter($row2['mobile_no']);
			$fax=filter($row2['fax']);
			$gst_no=filter($row2['gst_no']);			
			$email=filter($row2['email']);			
			$website=filter($row2['website']);
			$pdf1=filter($row2['pdf1']);
			$pdf2=filter($row2['pdf2']);
			$business_nature=$row2['business_nature'];
			$business_nature_other=filter($row2['business_nature_other']);
			$photo=$row2['photo'];
			$fees=$row2['fees'];
			$payment_mode=$row2['payment_mode'];
			$gst_per=filter($row2['gst_per']);
			$total_payable=filter($row2['total_payable']);
			$cheque_no=filter($row2['cheque_no']);
			$cheque_date=filter($row2['cheque_date']);
			$cheque_drawn_bank_name=filter($row2['cheque_drawn_bank_name']);
			$cheque_drawn_branch_name=filter($row2['cheque_drawn_branch_name']);
			$approval=filter($row2['approval']);
			$disapprove_reason=filter($row2['disapprove_reason']);
			$card_type=filter($row2['card_type']);
			$holder_name=filter($row2['holder_name']);
			$card_number=filter($row2['card_number']);
			$expiry_month=filter($row2['expiry_month']);
			$expiry_year=filter($row2['expiry_year']);
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"/>
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Edit Form <?php if($ismember=='M') { $isMember = 'Member';} elseif ($ismember=='NM') { $isMember = 'NonMember';} else { $isMember = 'international';} echo strtoupper($isMember);?></td>
    </tr>
	<tr>
       <td class="content_txt">Photo </td>      
       <td>
	   <?php 
		 if($photo=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 } else { ?>
		<div class="fancyDemo"> <a rel="group" href="../photo/<?php echo $photo;?>">
		 <img src='../photo/<?php echo $photo;?>' width='100' height='100'/></a></div>
		<?php } ?>
       </td>
	 </tr>
	 <tr>
       <td class="content_txt" width="15%">Name </td>
       <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" readonly="readonly"/></td>
     </tr>     
     <tr>
       <td class="content_txt">Designation</td>
       <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $designation; ?>" readonly="readonly"/></td>
     </tr>     
      <tr>
       <td class="content_txt">Company Name </td>
       <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $company; ?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Office Address </td>
       <td><input type="text" name="address" id="address" class="input_txt" value="<?php echo $address; ?>" readonly="readonly" /></td>
     </tr>
	 <tr>
       <td class="content_txt">State </td>
       <td><input type="text" name="state_name" id="state_name" class="input_txt" value="<?php echo $state_name; ?>" readonly="readonly" /></td>
     </tr>
	 <tr>
       <td class="content_txt">City </td>
       <td><input type="text" name="city_name" id="city_name" class="input_txt" value="<?php echo $city_name; ?>" readonly="readonly" /></td>
     </tr>
     <tr>
       <td class="content_txt">Tel. No. </td>
       <td><input type="text" name="land_line_no" id="land_line_no" class="input_txt" value="<?php echo $land_line_no; ?>" readonly="readonly" /></td>
     </tr>     
     <tr>
       <td class="content_txt">Mobile No </td>
       <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $mobile_no; ?>" readonly="readonly" /></td>
     </tr>
	 <tr>
       <td class="content_txt">Fax No </td>
       <td><input type="text" name="fax" id="fax" class="input_txt" value="<?php echo $fax; ?>" readonly="readonly" /></td>
     </tr>
	 <tr>
       <td class="content_txt">GST No </td>
       <td><input type="text" name="gst_no" id="gst_no" class="input_txt" value="<?php echo $gst_no;?>" readonly="readonly"/></td>
     </tr>
     <tr>
       <td class="content_txt">Email ID </td>
       <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $email;?>" readonly="readonly"/></td>
     </tr>     
     <tr>
       <td class="content_txt">Website </td>
       <td><input type="text" name="website" id="website" class="input_txt" value="<?php echo $website;?>" readonly="readonly"/></td>
     </tr>

<tr>
<td valign="top" bgcolor="#FFFFFF" class="text_content">Nature of Business</td>
 <td bgcolor="#FFFFFF" class="text_content">
    <ul class="matterText">    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Gold Jewellery Manufacturer" <?php if(preg_match('/Gold Jewellery Manufacturer/',$business_nature)){ echo 'checked="checked"'; }?> disabled="disabled">Gold Jewellery Manufacturer</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Gold Jewellery Retailer" <?php if(preg_match('/Gold Jewellery Retailer/',$business_nature)){ echo 'checked="checked"'; }?>disabled="disabled">Gold Jewellery Retailer</li>
     <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Machinery" <?php if(preg_match('/Machinery/',$business_nature)){ echo 'checked="checked"'; }?>disabled="disabled">Machinery</li>    
     <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Software" <?php if(preg_match('/Software/',$business_nature)){ echo 'checked="checked"'; }?>disabled="disabled">Software</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Publication" <?php if(preg_match('/Publication/',$business_nature)){ echo 'checked="checked"'; }?>disabled="disabled">Publication</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Service Provider" <?php if(preg_match('/Service Provider/',$business_nature)){ echo 'checked="checked"'; }?>disabled="disabled">Service Provider</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="Educational Institution Association" <?php if(preg_match('/Educational Institution Association/',$business_nature)){ echo 'checked="checked"'; }?>disabled="disabled">Educational Institution Association</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="Banks" <?php if(preg_match('/Banks/',$business_nature)){ echo 'checked="checked"'; }?> disabled="disabled">Banks</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="ecomm" <?php if(preg_match('/ecomm/',$business_nature)){ echo 'checked="checked"'; }?> disabled="disabled">E- Comm</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="Exporters" <?php if(preg_match('/Exporters/',$business_nature)){ echo 'checked="checked"'; }?> disabled="disabled">Exporters</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="Jewellery Wholesalers" <?php if(preg_match('/Jewellery Wholesalers/',$business_nature)){ echo 'checked="checked"'; }?> disabled="disabled">Jewellery Wholesalers</li>
	<li><input type="checkbox" name="business_nature[]" value="Any Other" id="other_business_id" <?php if(preg_match('/Any Other/',$business_nature)){ echo 'checked="checked"'; } ?>disabled="disabled">Any Other</li>
    </ul>
<div id="wa-jewellery-other-id">
  <label style="min-width:179px;">Any Other, please specify :</label>
  <input name="other_business" type="text" class="textField" value="<?php echo $other_business;?>" readonly="readonly"/>
</div>    
</td>
</tr>

    
     
     <tr>
       <td  class="content_txt">Ticket Details from</td>
       <td class="content_txt">
       <?php 
		 if($pdf1!="")
		 {
	  ?>
		<div class="fancyDemo"> <a rel="group" href="../flight_pdf/<?php echo $pdf1;?>">
		 <img src='../flight_pdf/<?php echo $pdf1;?>' width='100' height='100'/></a></div>
		<?php } ?>
       
       </td>
     </tr>
     <tr>
       <td class="content_txt">Ticket Details to</td>
       <td class="content_txt">
	   <?php if($pdf2!=""){?>
            <div class="fancyDemo"> <a rel="group" href="../flight_pdf/<?php echo $pdf2;?>">
            <img src='../flight_pdf/<?php echo $pdf2;?>' width='100' height='100'/></a></div>
		<?php } ?>
        </td>
     </tr>
    
     <tr>
       <td colspan="2" class="content_txt">Credit Card Details</td>
     </tr>
    <tr>
		<td class="content_txt">Credit card Type (tick)</td>
		<td colspan="5">
		<input type='radio' name='card_type' id='card_type' value='V' <?php if($card_type=='V'){ echo "checked='checked'"; }?>/>Visa
		<input type='radio' name='card_type' id='card_type' value='M' <?php if($card_type=='M'){ echo "checked='checked'"; }?>/>MasterCard
		<input type='radio' name='card_type' id='card_type' value='A' <?php if($card_type=='A'){ echo "checked='checked'"; }?>/>American Express
		</td>
	</tr>
     <tr>
       <td class="content_txt">Name on credit card:</td>
       <td><input type="text" name="holder_name" id="holder_name" class="input_txt" value="<?php echo $holder_name; ?>"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Credit card Number:</td>
       <td><input type="text" name="card_number" id="card_number" class="input_txt" value="<?php echo $card_number;?>"/></td>
     </tr>
     <tr>
       <td class="content_txt">Expiry Date (Month)</td>
       <td><input type="text" name="expiry_month" id="expiry_month" class="input_txt" value="<?php echo $expiry_month;?>"/></td>
     </tr>     
     <tr>
       <td class="content_txt">Expiry Date (Year)</td>
       <td><input type="text" name="expiry_year" id="expiry_year" class="input_txt" value="<?php echo $expiry_year;?>"/></td>
     </tr>
    <!--
	 <tr>
       <td class="content_txt">Fee</td>
       <td><input type="text" name="fees" class="textField" value="<?php echo $fees;?>" readonly="readonly"/></td>
     </tr>
	 <?php if($ismember=="M" || $ismember=="NM"){ ?>	
	 <tr>
       <td class="content_txt">GST 18%</td>
       <td><input type="text" name="gst_per" class="textField" value="<?php echo $gst_per;?>" readonly="readonly"/></td>
     </tr>
	<?php } else { ?>
	 <tr>
       <td class="content_txt">IGST 18%</td>
       <td><input type="text" name="gst_per" class="textField" value="<?php echo $gst_per;?>" readonly="readonly"/></td>
     </tr>
	<?php }?>
	 <tr>
       <td class="content_txt">Total Payable</td>
       <td><input type="text" name="total_payable" class="textField" value="<?php echo $total_payable; ?>"/></td>
     </tr>-->
	 <tr>
		  <td class="content_txt">Payment Mode</td>
		  <td colspan="5">
		  <select name="fees" class="input_txt">
		  <option value="">Select Payment Mode</option>
		  <option value="cheque" <?php if($payment_mode=="cheque"){echo "selected='selected'";}?>>CHEQUE</option>
		  <option value="RTGS" <?php if($payment_mode=="RTGS"){echo "selected='selected'";}?>>RTGS</option>
		  </select>
		  </td>
	 </tr>
	 <tr>
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
 
<?php 
if(($_REQUEST['id']!='') && ($_REQUEST['action']=='view_details'))
{
		$result2 = mysql_query("SELECT * FROM igjs_summit_registration where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{			
			$post_date=filter($row2['post_date']);
			$gcode=filter($row2['gcode']);
			$ismember=filter($row2['ismember']);
			$title=filter($row2['title']);
			$name=filter($row2['name']);
			$designation=filter($row2['designation']);
			$company=filter($row2['company']);
			$address=filter($row2['address']);
			$land_line_no=filter($row2['land_line_no']);
			$mobile_no=filter($row2['mobile_no']);
			$fax=filter($row2['fax']);
			$gst_no=filter($row2['gst_no']);
			$email=filter($row2['email']);			
			$website=$row2['website'];
			$business_nature=$row2['business_nature'];
			$other_business=$row2['business_nature_other'];
			$photo=$row2['photo'];
			$fees=$row2['fees'];
			$payment_mode=$row2['payment_mode'];			
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details <?php if($ismember=='M') { $isMember = 'Member';}elseif($ismember=='NM') { $isMember = 'NonMember';}else{ $isMember = 'international';}	echo strtoupper($isMember);?></td>
     </tr>
     <tr>
       <td class="content_txt" width="15%">Name </td>
       <td class="text6"><?php echo $title.' '. $name; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Designation</td>
       <td class="text6"><?php echo $designation; ?></td>
     </tr>     
      <tr>
       <td class="content_txt">Company Name </td>
       <td class="text6"><?php echo $company; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Office Address </td>
       <td class="text6"><?php echo $address;?></td>
     </tr>
     <tr>
       <td class="content_txt">Tel. No. </td>
       <td class="text6"><?php echo $land_line_no; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Mobile No </td>
       <td class="text6"><?php echo $mobile_no; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Fax No </td>
       <td class="text6"><?php echo $fax; ?></td>
     </tr>
	 
	 <tr>
       <td class="content_txt">GST No </td>
       <td class="text6"><?php echo $gst_no;?></td>
     </tr>
     <tr>
       <td class="content_txt">Email ID </td>
       <td class="text6"><?php echo $email;?></td>
     </tr>     
     <tr>
       <td class="content_txt">Website </td>
       <td class="text6"><?php echo $website;?></td>
     </tr>
     <tr>
    <td colspan="11">
    
<div class="field bottomSpace">
<div class="leftTitle" style="padding-top:0px;">Nature of Business :</div>
<div class="rightContent">
    <ul class="matterText">    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Gold Jewellery Manufacturer" <?php if(preg_match('/Gold Jewellery Manufacturer/',$business_nature)){ echo 'checked="checked"'; }?>>Gold Jewellery Manufacturer</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Gold Jewellery Retailer" <?php if(preg_match('/Gold Jewellery Retailer/',$business_nature)){ echo 'checked="checked"'; }?>>Gold Jewellery Retailer</li>
     <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Machinery" <?php if(preg_match('/Machinery/',$business_nature)){ echo 'checked="checked"'; }?>>Machinery</li>    
     <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Software" <?php if(preg_match('/Software/',$business_nature)){ echo 'checked="checked"'; }?>>Software</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Publication" <?php if(preg_match('/Publication/',$business_nature)){ echo 'checked="checked"'; }?>>Publication</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Service Provider" <?php if(preg_match('/Service Provider/',$business_nature)){ echo 'checked="checked"'; }?>>Service Provider</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="Educational Institution Association" <?php if(preg_match('/Educational Institution Association/',$business_nature)){ echo 'checked="checked"'; }?>>Educational Institution Association</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="Banks" <?php if(preg_match('/Banks/',$business_nature)){ echo 'checked="checked"'; }?>>Banks</li>
	<li><input type="checkbox" name="business_nature[]" value="Any Other" id="other_business_id" <?php if(preg_match('/Any Other/',$business_nature)){ echo 'checked="checked"'; } ?>>Any Other</li>
    </ul>    
</div>
<div class="clear" style="margin-bottom:8px;"></div>
 
<div id="wa-jewellery-other-id">
  <label style="min-width:179px;">Any Other, please specify :</label>
  <input name="other_business" type="text" class="textField" value="<?php echo $other_business; ?>" />
</div>
</div>
    
</td>
</tr>
	 <tr>
       <td class="content_txt">Photo </td>      
       <td><?php 
		 if($photo=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 }else
		 {
		 ?>
		 <div class="fancyDemo"> <a rel="group" href="../photo/<?php echo $photo;?>">
		 <img src='../photo/<?php echo $photo;?>' width='100' height='100' /></a></div>
		 <?php
         }
		 ?>
         </td>
	 </tr>
	  <tr>
       <td class="content_txt">Fee</td>
       <td class="text6"><?php echo $fees; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Payment Mode</td>
       <td class="text6"><?php echo $payment_mode; ?></td>
     </tr>
     <tr>
       <td class="content_txt">Post Date </td>
       <td class="text6"><?php echo date("d-m-Y",strtotime($post_date)); ?></td>
     </tr>
   </table>
 </div>
 <?php 
} 
?>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>