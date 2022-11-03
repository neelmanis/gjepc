<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['first_name']="";
  $_SESSION['last_name']="";
  $_SESSION['company_name']="";
  $_SESSION['email']="";
  $_SESSION['from_date']="";
    $_SESSION['to_date']="";
    $_SESSION['country']="";
    $_SESSION['status']="";
  $_SESSION['visitor_approval'] = "";
  $_SESSION['IIJS_PREMIERE_2022'] = "";
  
  
  header("Location: iijs_ivr_onspot.php?action=view");
  
} else
{ 
    $search_type=$_REQUEST['search_type'];
    if($search_type=="SEARCH")
  { 
    $_SESSION['first_name']=$_REQUEST['first_name'];
    $_SESSION['last_name']=$_REQUEST['last_name'];
    $_SESSION['company_name']= filter($_REQUEST['company_name']);
    $_SESSION['email']=$_REQUEST['email'];
    $_SESSION['from_date']=$_REQUEST['from_date'];
    $_SESSION['to_date']=$_REQUEST['to_date'];
    $_SESSION['country']=$_REQUEST['country'];
    $_SESSION['status']=$_REQUEST['status'];
    $_SESSION['visitor_approval'] = $_REQUEST['visitor_approval'];
    $_SESSION['IIJS_PREMIERE_2022'] = $_REQUEST['IIJS_PREMIERE_2022'];
  }
if($search_type=='SEARCH')
{
if($_SESSION['first_name']=="" && $_SESSION['company_name']=="" && $_SESSION['from_date']=="Form" && $_SESSION['to_date']=="To" && $_SESSION['country']=="" && $_SESSION['status']=="" && $_SESSION['IIJS_PREMIERE_2022'] =="")
{
$_SESSION['error_msg']="Please fill atleast one field to search";
}else if($_SESSION['from_date']=="Form" && $_SESSION['to_date'] !="To")
{
$_SESSION['error_msg']="Please enter form date";
}else if($_SESSION['from_date']!="Form" && $_SESSION['to_date']=="To")
{
$_SESSION['error_msg']="Please enter to date";
}

}
}
?> 



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS International Visitor Registration - <?php echo $show_name; ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
  $('#popupDatepicker').datepick();
  $('#inlineDatepicker').datepick({onSelect: showDate});
  $('#popupDatepicker1').datepick();
  $('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
  alert('The date chosen is ' + date);}
</script>

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

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $("div.fancyDemo a").fancybox();
    });
</script>
<!-- lightbox Thum -->
</head>

<body>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
  <div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
  <div class="breadcome"><a href="admin.php">Home</a> >IIJS IVR</div>
</div>

<div id="main">
  <div class="content">    
      <div class="content_head">
    <a href="iijs_ivr_onspot.php?action=view"><div class="content_head_button">Manage ONSPOT IIJS IVR</div></a> 
   
    </div>

<?php if($_REQUEST['action'] == "view"){?>
<div class="content_details1">
<?php 
  $sql5="SELECT * FROM  `ivr_registration_details` WHERE 1 AND `personal_info_reason` = 'onspot'";
  $result5=$conn ->query($sql5);
  $total_application=$result5->num_rows;
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
    <td colspan="11">IIJS PREMIERE 2022 ONSPOT Summary</td>
  </tr>
  <tr>
    <td><strong>Total Application</strong> <?php echo $total_application;?></td>
    <!--<td><strong>Approve Application</strong></td>
    <td><strong>Disapprove Application</strong></td>
    <td><strong>Pending Application</strong></td>-->
  </tr>

</table>
</div> 
<?php }?>
     
<div class="clear"></div>
<?php if($_REQUEST['action'] == "view"  ){?>
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />          
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
    <td colspan="11" >Search Options</td>
  </tr>
  <!-- <tr>
    <td width="19%"><strong>First Name</strong></td>
    <td width="81%"><input type="text" name="first_name" id="first_name" class="input_txt" value="<?php echo $_SESSION['first_name'];?>" /></td>
  </tr>
  <tr>
    <td><strong>Last Name</strong></td>
    <td><input type="text" name="last_name" id="last_name" class="input_txt" value="<?php echo $_SESSION['last_name'];?>" /></td>
  </tr> -->
  <tr>
    <td><strong>Company Name</strong></td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
  </tr>
  <tr>
    <td><strong>Email ID</strong></td>
    <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $_SESSION['email'];?>" /></td>
  </tr>

  <tr >
    <td><strong>Country</strong></td>
    <td><select name="country" id="country" class="input_txt">
      <option value="">Please Select Country Name</option>
      <?php 
        $sql2="select * from country_master where status=1";
        $result2=$conn ->query($sql2);
        while($rows2=$result2->fetch_assoc())
        {
        if($_SESSION['country_code']==$rows2['country_code'])
        {
        echo "<option value='$rows2[country_code]' selected='selected'>$rows2[country_name]</option>";
        }else
        {
        echo "<option value='$rows2[country_code]'>$rows2[country_name]</option>";
        }
        }
      ?>
      </select></td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" />
      <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
  </tr>
</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="7%" height="10">#</td>
    <td width="24%">Company Name</td>
    <td width="17%" align="center">Email</td>
    <td width="10%">Country</td>
    <td width="20%">NAME</td>
    <td width="15%">Registration For Show</td>
    <td width="15%">Date</td>    
    <td width="15%">Photo</td>    
    <td width="15%">Passport</td>    
    <td width="15%">Visiting Card</td>    
  </tr>
  <?php
  $counter = 1;
  $page=1;//Default page
  $limit=20;//Records per page
  $start=0;//starts displaying records from 0
  if(isset($_GET['page']) && $_GET['page']!=''){
  $page=$_GET['page'];
  
  }
  $start=($page-1)*$limit;
  $sql="SELECT * FROM  `ivr_registration_details` WHERE 1 AND `personal_info_reason` = 'onspot'";

  if($_SESSION['first_name']!="")
  {
  $sql.=" and first_name like '%".$_SESSION['first_name']."%'";
  }
  
  if($_SESSION['last_name']!="")
  {
  $sql.=" and last_name like '%".$_SESSION['last_name']."%'";
  }
  
  if($_SESSION['company_name']!="")
  {
  $sql.=" and company_name like '%".$_SESSION['company_name']."%'";
  }
  
  if($_SESSION['email']!="")
  {
  $sql.=" and email_id like '%".$_SESSION['email']."%'";
  }
  
  if($_SESSION['country']!="")
  {
  $sql.=" and country='".$_SESSION['country']."'";
  } 
  //echo $sql;
  $result=$conn ->query($sql);

  $rCount=$result->num_rows;
  $sql1= $sql."  limit $start, $limit";
  $result1=$conn ->query($sql1);
  
if($rCount>0)
  { 
  while($rows=$result1->fetch_assoc())
  {
    $date = $rows['time_stamp'] != '' &&   $rows['time_stamp'] != null ? $date =  $rows['time_stamp'] : '';
  ?>
  <tr>
    <td><?php echo $counter++ ;?></td>
    <td><?php echo strtoupper(filter($rows['company_name']));?></td>
    <td><?php echo $rows['email'];?></td>
    <td><?php echo getCountryName($rows['country'],$conn);?></td>
    <td><?php echo $rows['first_name'].' '.$rows['last_name'];?></td>
    <td><?php echo strtoupper(filter($rows['trade_show']));?></td>
    <td> <?php echo date("Y-m-d", strtotime($date)); ?> </td>
	<td><img src="<?php echo "https://registration.gjepc.org/images/ivr_image/photograph/".$rows['photograph_fid'];?>" width="100"/></td>
	<td><img src="<?php echo "https://registration.gjepc.org/images/ivr_image/passport/".$rows['passport_fid'];?>" width="100"/></td>
	<td><img src="<?php echo "https://registration.gjepc.org/images/ivr_image/visiting_card/".$rows['visit_card_fid'];?>" width="100"/></td>
  </tr>
  
  <?php
   $i++;
   }   
  }
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
  
   <?php  } ?>  
</table>
<div class="pages_1">Total number of Companies: <?php echo $rCount;?>
<?php echo pagination(20,$page,'iijs_ivr_onspot.php?action=view&page=',$rCount); //call function to show pagination?>
</div> 
</form>

</div>  

<?php } ?>

<?php if($_REQUEST['action'] == "employeesList"  ){ 

   $registration_id = $_REQUEST['registration_id'];?>


<div class="content_details1">
  <?php 

  $query_sel = "SELECT company_name FROM  registration_master  where id='$registration_id'";  
  $result = $conn->query($query_sel);
  $row = $result->fetch_assoc();    
   $company_name = $row['company_name'];
  ?>
  Company Name: <?php echo $company_name; ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_ivr_onspot.php?action=view">Back</a></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="7%" height="10">#</td>
    <td width="10%" height="30">Name</td>
    <td width="14%">Company Name</td>
    <td width="6%">Email ID</td>
    <td width="10%">Country</td>
    <td width="10%">Registration Date</td>
   
    <td width="5%">Apply Visa</td>
    <td width="5%">OTP</td>
    <td width="7%" align="center">Status</td>
    <td width="7%">Action</td>
    <?php if($adminID==1 || $adminID==45 || $adminID==154 ){?><td>Delete</td><?php } ?>
   
  </tr>
  <?php
  

 
   $sql_employees="SELECT * FROM  `ivr_registration_details` WHERE 1 AND  `uid` = '$registration_id' order by time_stamp desc ";
  
    
  
  
$counter_e = 1;
  $result_employees=$conn ->query($sql_employees);
  $eCount=$result_employees->num_rows;;


  
  if($eCount>0)
  { 
  while($rows_employees=$result_employees->fetch_assoc())
  {
  ?>
  <tr >
    <td><?php echo $counter_e++; ?></td>
    <td><?php echo strtoupper(filter($rows_employees['first_name'])) ." ".strtoupper(filter($rows_employees['last_name']));?></td>
    <td><?php echo strtoupper(filter($rows_employees['company_name']));?></td>
    <td><?php echo $rows_employees['email'];?></td>
    <td><?php echo getCountryName($rows_employees['country'],$conn);?></td>
    <td><?php echo date("d-m-Y",strtotime($rows_employees['modified_date']));?></td>
    
    <td><?php if($rows_employees['apply_visa']=="1"){echo "Yes";}else{echo "No";} ?></td>
    <td><?php echo $rows_employees['otp'];  ?></td>
    <td align="center">
  <?php 
  if($rows_employees['personal_info_approval']=='Y' && $rows_employees['photo_approval']=='Y' && $rows_employees['valid_passport_copy_approval']=='Y' && $rows_employees['visiting_card_approval']=='Y' && $rows_employees['nri_photo_approval']=='Y' )
  {
    echo "<img src='images/yes.gif' border='0' />"; 
  }else if($rows_employees['personal_info_approval']=='P' || $rows_employees['photo_approval']=='P' || $rows_employees['valid_passport_copy_approval']=='P' || $rows_employees['visiting_card_approval']=='P' || $rows_employees['nri_photo_approval']=='P')
  {
    echo "<img src='images/notification-exclamation.gif' border='0' />";  
  }else
  {
    echo "<img src='images/no.gif' border='0' />";  
  }
  ?>
    
    </td>
    <td align="left" valign="middle"><a href="iijs_personal_information_IVR.php?id=<?php echo $rows_employees['eid'];?>&registration_id=<?php echo $rows_employees['uid'];?>"><img src="images/edit1.png" border="0" /></a> </td>
    <?php if($adminID==1 || $adminID==45 || $adminID==154 ){ ?>
	<td><a style="text-decoration:none;" href="iijs_ivr_onspot.php?action=delVisitor&visitor_id=<?php echo $rows_employees['eid'];?>&registration_id=<?php echo $rows_employees['uid'];?>" onClick="return(window.confirm('Are you sure you want to Delete.'));"><img src="images/no.gif" border="0" title="Delete"/></a></td>
	<?php } ?>
  </tr>
  
  <?php
   $i++;
   }   
  }
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
  
   <?php  } ?>  
</table>
</div>
<?php } ?>
<?php if($_REQUEST['action'] == "ordersList"  ){ 

   $registration_id = $_REQUEST['registration_id'];?>


<div class="content_details1">
  <?php 

  $query_sel_order = "SELECT company_name FROM  registration_master  where id='$registration_id'";  
  $result_order = $conn->query($query_sel_order);
  $row_order = $result_order->fetch_assoc();    
   $company_name = $row_order['company_name'];
  ?>
  Company Name: <?php echo $company_name; ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_ivr_onspot.php?action=view">Back</a></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="7%" height="10">#</td>
    <td width="10%" height="30">Name</td>
    <td width="10%" height="30">Email</td>
    <td width="14%">Show </td>
    <td width="6%">Year</td>
    <td width="10%">Registered from </td>
  
  </tr>
  <?php
  

 
   $sql_order="SELECT * FROM  `ivr_registration_history` WHERE 1 AND  `registration_id` = '$registration_id' and `show`='iijs22' order by create_date desc ";
  
    
  
  
$counter_e = 1;
  $result_order=$conn ->query($sql_order);
  $oCount=$result_order->num_rows;;


  
  if($oCount>0)
  { 
  while($rows_order=$result_order->fetch_assoc())
  {
  ?>
  <tr >
    <td><?php echo $counter_e++; ?></td>
    <td><?php echo intlVisitorName($rows_order['visitor_id'],$conn);?></td>
    <td><?php echo intlVisitorEmail($rows_order['visitor_id'],$conn);?></td>
    
   
    <td><?php echo $rows_order['show'];?></td>
    <td><?php echo $rows_order['year'];?></td>
     <td><?php echo $rows_order['paymentThrough'];?></td>
    
  
 
  </tr>
  
  <?php
   $i++;
   }   
  }
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
  
   <?php  } ?>  
</table>
</div>
<?php } ?>

<?php
function pagination($per_page, $page = 1, $url = '', $total){ 

$adjacents = "2";
$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$per_page=20;
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
       
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>