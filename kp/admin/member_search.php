<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;} 
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['category_type']="";
  $_SESSION['name']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['status']="";
  header("Location: member_search.php?action=view");
}else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  $_SESSION['category_type']=$_REQUEST['category_type'];
  $_SESSION['name']=$_REQUEST['name'];
  $_SESSION['from_date']=$_REQUEST['from_date'];
  $_SESSION['to_date']=$_REQUEST['to_date'];
  $_SESSION['status']=$_REQUEST['status'];
  if($action=='search')
  {
  	if($_SESSION['category_type']=="")
	{
	$_SESSION['error_msg']="Please select category";
	}
	
  }
}
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member Search || KP ||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">

	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});

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

<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
<script type="text/javascript">
$("div.fancyDemo a").fancybox();	
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
	<div class="breadcome"><a href="admin.php">Home</a> > Member Search</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Member Search</div></div>
    	
<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>

<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>  
<tr>
    <td width="19%"><strong>Type</strong></td>
    <td width="81%">
        <select name="category_type" id="category_type" class="input_txt">
        <option value="">Please Select Type</option>	
        <option value="Agent" <?php if($_SESSION['category_type']=="Agent"){echo "selected='selected'";}?>>Agent</option>
        <option value="Non Member" <?php if($_SESSION['category_type']=="Non Member"){echo "selected='selected'";}?>>Non Member</option>
        <option value="Member" <?php if($_SESSION['category_type']=="Member"){echo "selected='selected'";}?>>Member</option>	
        </select>    
	</td>
</tr>

<tr>
    <td ><strong>Name</strong></td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" /></td>
</tr>	
    
<tr>
    <td><strong>Date</strong></td>
    <td><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>"  class="input_date"/>
     <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
</tr>

<tr>
    <td><strong>Status</strong></td>
    <td>
    <select name="status" id="status" class="input_txt">
    <option value="">Please Select Status</option>	
    <option value="21" <?php if($_SESSION['status']=="21"){echo "selected='selected'";}?>>Pending</option>
    <option value="22" <?php if($_SESSION['status']=="22"){echo "selected='selected'";}?>>Approved</option>
    <option value="23" <?php if($_SESSION['status']=="23"){echo "selected='selected'";}?>>Rejected</option>	
    </select>    </td>
</tr>    
    
<tr>
<td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>
<?php if($_SESSION['category_type']!=""){?>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Type</td>
    <td>BP No.</td>
    <td>Name</td>
    <td>Application Date</td>
    <td>Email</td>
    <td>Create BP</td>
    <td>Select</td>
  </tr>
    <?php  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
  
  
  	if($_SESSION['category_type']=='Agent')
	{
  	$sql="SELECT AGENT_BP_NO,`AGENT_ID`,`AGENT_NAME`,CONTACT_PERSON1,`DESIGNATION1`,`STATUS`,`ENTERED_ON`,EMAIL FROM `kp_agent_master` WHERE 1  ";
		if($_SESSION['name']!="")
		{
		$sql.=" and AGENT_NAME like '%".$_SESSION['name']."%' ";
		}
	}else if($_SESSION['category_type']=='Non Member')
	{
	$sql="SELECT  NON_MEMBER_BP_NO,`NON_MEMBER_ID`,`NON_MEMBER_NAME`,`CONTACT_PERSON1`,`DESIGNATION1`,`STATUS`,`ENTERED_ON`,EMAIL FROM `kp_non_member_master` WHERE 1 ";
		if($_SESSION['name']!="")
		{
		$sql.=" and NON_MEMBER_NAME like '%".$_SESSION['name']."%' ";
		}
	}else if($_SESSION['category_type']=='Member')
	{
	$sql="SELECT  `MEMBER_ID`,`MEMBER_CO_NAME`,`CONTACT_PER_NAME`,`ENTERED_ON`,MEMBER_CO_EMAIL FROM `kp_member_master` WHERE 1 ";
		if($_SESSION['name']!="")
		{
		$sql.=" and MEMBER_CO_NAME like '%".$_SESSION['name']."%' ";
		}
	}
	
	if($_SESSION['status']!="")
	{
	$sql.=" and STATUS='".$_SESSION['status']."' ";
	}

	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
	$sql.=" and ENTERED_ON between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_SESSION['to_date']))."'";
	}
	$sql.=" ";
 	$result=mysqli_query($conn,$sql);
	$rCount=mysqli_num_rows($result);	

	$sql1=$sql." limit $start, $limit"; 
	$result1=mysqli_query($conn,$sql1);
		
  if($rCount>0)
  {	
  while($rows=mysqli_fetch_array($result1))
  {
  ?>
  <tr>
    <td><?php echo $_SESSION['category_type'];?></td>
	<td>
	<?php 
	if($_SESSION['category_type']=="Agent"){
	echo getBpNumber($conn,'Agent',$rows['AGENT_ID']);
	} else if($_SESSION['category_type']=="Non Member"){
	echo getBpNumber($conn,'NonMember',$rows['NON_MEMBER_ID']);
	} else if($_SESSION['category_type']=="Member"){
	echo getBpNumber($conn,'Member',$rows['MEMBER_ID']);
	}
	?>
	</td>
	
    <td>
	<?php 
	if($_SESSION['category_type']=="Agent")
	{
	echo $rows['AGENT_NAME'];
	}else if($_SESSION['category_type']=="Non Member")
	{
	echo $rows['NON_MEMBER_NAME'];
	}else if($_SESSION['category_type']=="Member")
	{
	echo $rows['MEMBER_CO_NAME'];
	}
	?></td>
    <td><?php echo date("d-m-Y",strtotime($rows['ENTERED_ON']));?></td>
    <td>
	<?php
	if($_SESSION['category_type']=="Agent")
	{
	echo $rows['EMAIL'];
	}else if($_SESSION['category_type']=="Non Member")
	{
	echo $rows['EMAIL'];
	}else if($_SESSION['category_type']=="Member")
	{
	echo $rows['MEMBER_CO_EMAIL'];
	}
	?></td>
    
	<?php 
	if($_SESSION['category_type']=="Agent"){
	echo '<td><img src="images/active.png"></td>';
	} else if($_SESSION['category_type']=="Non Member"){
		$NonmemberBP = getBpNumber($conn,'NonMember',$rows['NON_MEMBER_ID']);
	if($NonmemberBP=="" || $NonmemberBP==0) { ?>
	<td class="comp" data-url="<?php echo $rows['NON_MEMBER_ID'];?>"><img src="https://gjepc.org/admin/images/reply.png" title="Create" border="0" style=""/></td>
	<?php } else { ?>
	<td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
	<?php }
	} else if($_SESSION['category_type']=="Member"){
	     echo '<td><img src="images/active.png"></td>';
	}
	?>	
    <td align="center"><input name="" type="checkbox" value="" /></td>
  </tr>
  
  <?php
   $i++;
   }
   ?>
	
    <tr>
    <td colspan="7"><input type="submit" name="Email UserName/Password" value="Email UserName/Password"  class="input_submit" /></td>
    </tr>

   <?php 
    }
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
   <tr>
     <td colspan="5">&nbsp;</td>
     <td colspan="3"></td>
   </tr>
   <?php  }  	?>  
</table>

</form>
</div>  
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
<div class="pages_1">Total number of Memberships: <?php echo $rCount;?><?php echo pagination($limit,$page,'member_search.php?action=view&page=',$rCount); //call function to show pagination?></div>        

<?php } ?>      
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
/* Company BP Creation */
$(".comp").click(function() {
	var values = $(this).data('url');
	var registration_id=values;
	//alert(registration_id); exit;
	
	if (confirm("Are you sure you want to Create Company BP")) {
		$.ajax({
		url: "create_company_nm_bp_api.php",
		method:"POST",
		data:{registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data); exit;
			if($.trim(data)==1){
				alert("BP successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			console.log(data);
		},
		});
	}	  
});
</script>
<div id="overlay"></div>
<style>
#overlay {
    position: fixed;
    display: none; 
    width: 100%; 
    height: 100%; 
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.8);
z-index:999;}  	
</style>
</body>
</html>