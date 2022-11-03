<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
include('../db.inc.php');
include('../functions.php');
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company']="";
  
  header("Location: manage_artisan.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['company']=mysql_real_escape_string($_REQUEST['company']);
	}
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Artisan ||GJEPC||</title>

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
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="artisan_export_data.php?action=view">Back to Participant</a></div>
        <?php }?>
        <a href="artisan_export_data.php">&nbsp; &nbsp; &nbsp; Export Participant List</a>
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

    <td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">No.</a></td>
		<td width="10%">Date</td>
        <td width="25%">Company Name</td>
        <td width="15%">Email ID</td>
        <td width="15%">Contact No</td>
        <td width="15%">Stall no</td>
        <td width="15%">awards</td>
    </tr>
    
    <?php 	
 	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'created_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql="SELECT * FROM `artisan_award_application_2019` WHERE 1";
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
		<td align="left"><?php echo date("d-m-Y",strtotime($row['created_date'])); ?></td>
        <td><?php echo filter(strtoupper($row['company_name']));?></td>
        <td align="left"><?php echo filter($row['email_id']);?></td>
        <td align="left"><?php echo filter($row['contact_no']);?></td>
        <td align="left"><?php echo $row['stall_no'];?></td>
        <td align="left"><?php echo $row['awards'];?></td>		
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
<?php echo pagination($limit,$page,'manage_artisan.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT * FROM artisan_award_application_2019 where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{				
			$first_name=filter($row2['first_name']);
			$last_name=filter($row2['last_name']);
			$company=filter($row2['company_name']);
			$mobile_no=filter($row2['mobile_no']);			
			$gender=filter($row2['gender']);
			$country=filter($row2['country']);			
			$visa=filter($row2['visa']);			
			$pan_no=filter($row2['pan_no']);			
			$email=filter($row2['email']);			
			$passport_number=filter($row2['passport_number']);
			$passport_issue_date=filter($row2['passport_issue_date']);
			$passport_issue_authority=filter($row2['passport_issue_authority']);
			$passport_expiry_date=filter($row2['passport_expiry_date']);
			$nationality=filter($row2['nationality']);
			$dob=filter($row2['dob']);
			$photo=$row2['photo'];
			$dietary_pref=$row2['dietary_pref'];
			$arrival_date=$row2['arrival_date'];
			$departure_date=filter($row2['departure_date']);
			$accomodation=filter($row2['accomodation']);
			$badge=filter($row2['badge']);			
			$region=filter($row2['region']);			
			$approval=filter($row2['approval']);
			$disapprove_reason=filter($row2['disapprove_reason']);
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