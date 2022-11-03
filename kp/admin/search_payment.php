<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
 
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['member_type']="";
  $_SESSION['tran_type']="";
  $_SESSION['status']="";
  $_SESSION['EXPORT_APP_ID']="";
  $_SESSION['KP_CERT_NO']="";
  $_SESSION['cheque_no']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
 
  header("Location: search_payment.php?action=view");
}else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  $_SESSION['member_type']=$_REQUEST['member_type'];
  $_SESSION['tran_type']=$_REQUEST['tran_type'];
  $_SESSION['payment_type']=$_REQUEST['payment_type'];
  $_SESSION['status']=$_REQUEST['status'];
  $_SESSION['EXPORT_APP_ID']=$_REQUEST['EXPORT_APP_ID'];
  $_SESSION['KP_CERT_NO']=$_REQUEST['KP_CERT_NO'];
  $_SESSION['cheque_no']=$_REQUEST['cheque_no'];
  $_SESSION['from_date']=$_REQUEST['from_date'];
  $_SESSION['to_date']=$_REQUEST['to_date'];
 
  if($action=='search')
  {
  	if($_SESSION['member_type']=="")
	{
	 $_SESSION['error_msg']="Please select user type";
	}
  }
}
?>  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Payment || KP ||</title>

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
</head>

<body>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> > Search Payment</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Search Payment</div></div>
    	
      
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr >
    <td><strong>Agent/Member/Non Member Type</strong></td>
    <td><select name="member_type" id="member_type" class="input_txt">
      <option value="">Please Select User Type</option>
      <option value="1" <?php if($_SESSION['member_type']=="1"){ echo "selected=selected";}?>>Agent</option>
      <option value="2" <?php if($_SESSION['member_type']=="2"){ echo "selected=selected";}?>>Non Member</option>
      <option value="4" <?php if($_SESSION['member_type']=="4"){ echo "selected=selected";}?>>Member</option>
     </select>
     </td>
      <td><strong>Tran. Type</strong></td>
      <td><select name="tran_type" id="tran_type" class="input_txt">
          <option value="">Please Select Type</option>
          <?php 
           $sql="select * from  kp_lookup_details where LOOKUP_ID='9'";
           $result=mysqli_query($conn,$sql);
           while($rows=mysqli_fetch_array($result))
           {
           if($rows['LOOKUP_VALUE_CODE']==$_SESSION['tran_type'])
           {
           echo "<option selected='selected' value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
           }else
           {
           echo "<option value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
           }
           }
           ?>	
        </select>  
        </td>
</tr>	
<tr>
  <td><strong>Payment Type</strong></td>
  <td>
  <select name="payment_type" id="payment_type" class="input_txt">
      <option value="">Please Select Status</option>
       <?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='15' order by LOOKUP_VALUE_ORDER";
	   $result=mysqli_query($conn,$sql);
	   while($rows=mysqli_fetch_array($result))
	   {
		   if($rows['LOOKUP_VALUE_ID']==$_SESSION['payment_type'])
		   {
				echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
		   }else
		   {
				echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
		   }
	   }
	   ?>	
    </select>
    </td>
	<td><strong>Status</strong></td>
  	<td>
      <select name="status" id="status" class="input_txt">
        <option value="">Please App Type</option>
        <?php 
           $sql="select * from  kp_lookup_details where LOOKUP_ID='16' order by LOOKUP_VALUE_ORDER";
           $result=mysqli_query($conn,$sql);
           while($rows=mysqli_fetch_array($result))
           {
           if($rows['LOOKUP_VALUE_CODE']==$_SESSION['status'])
           {
           echo "<option selected='selected' value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
           }else
           {
           echo "<option value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
           }
           }
           ?>	
        </select>
    </td>
  </tr>
  
 <tr>
  <td><strong>KP CERT No.</strong></td>
  <td><input type="text" name="KP_CERT_NO" id="KP_CERT_NO" value="<?php echo $_SESSION['KP_CERT_NO'];?>"  class="input_txt1"/></td>
  <td><strong>Application No.</strong></td>
    <td><input type="text" name="EXPORT_APP_ID" id="EXPORT_APP_ID" value="<?php echo $_SESSION['EXPORT_APP_ID'];?>"  class="input_txt1"/></td>
</tr> 
  
<tr>
  <td><strong>Cheque/DD No</strong></td>
  <td><input type="text" name="cheque_no" id="cheque_no" value="<?php echo $_SESSION['cheque_no'];?>"  class="input_txt1"/></td>
  <td><strong>From Date</strong></td>
    <td><input type="date" name="from_date" id="from_date" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>"  class="input_date"/>
     <input type="date" name="to_date" id="to_date" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
</tr>
  
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>	
</table>
</form>      
</div>
<?php if($_SESSION['member_type']!=""){?>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Name</td>
    <td>Application Date</td>
    <td>Application No.</td>
    <td>KP CERT No.</td>
    <td>Import/Export</td>
    <td>Amount</td>
    <td>SO Number</td>
	<td>Delivery Number</td>
    <td colspan="2">Action</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;

	$sql="SELECT a.*,b.EXPORT_APP_ID,b.PAYMENT_MST_ID,c.KP_CERT_NO FROM  `kp_payment_master` a,kp_payment_details b, kp_export_application_master c where a.PAYMENT_MST_ID=b.PAYMENT_MST_ID and b.EXPORT_APP_ID=c.EXPORT_APP_ID";
	
	if($_SESSION['member_type']!="")
	{
		if($_SESSION['member_type']=='1')
		{
		$sql.=" and a.MEMBERTYPE='Agent'";
		}else if($_SESSION['member_type']=='2')
		{
		$sql.=" and a.MEMBERTYPE='NonMember'";
		}else if($_SESSION['member_type']=='4') 
		{
		$sql.=" and a.MEMBERTYPE='Member'";
		}
	}
	
	if($_SESSION['tran_type']!="")
	{
		$sql.=" and a.FORM_TYPE = '".$_SESSION['tran_type']."' ";
	}
	
	if($_SESSION['payment_type']!="")
	{
		$sql.=" and a.PAYMENT_TYPE = '".$_SESSION['payment_type']."' ";
	}
	
	if($_SESSION['status']!="")
	{
		$sql.=" and a.STATUS='".$_SESSION['status']."' ";
	}
	if($_SESSION['EXPORT_APP_ID']!="")
	{
		$sql.=" and c.EXPORT_APP_ID='".$_SESSION['EXPORT_APP_ID']."' ";
	}
	if($_SESSION['KP_CERT_NO']!="")
	{
		$sql.=" and c.KP_CERT_NO='".$_SESSION['KP_CERT_NO']."' ";
	}
	if($_SESSION['cheque_no']!="")
	{
	$sql.=" and a.CHEQUE_NO like '%".$_SESSION['cheque_no']."%' ";
	}
	if($_SESSION['curruser_region_id']!="")
	{
	 $sql.=" and c.PROCES_CNTR='".$_SESSION['curruser_region_id']."' ";
	}
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
	$sql.=" and a.EXP_APP_DATE between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_SESSION['to_date']))."'";
	}
 	$result=mysqli_query($conn,$sql);
	$rCount=mysqli_num_rows($result);	

	$sql1=$sql." order by b.EXPORT_APP_ID DESC limit $start, $limit"; 
	//echo $sql1;
	$result1=mysqli_query($conn,$sql1);
		
  if($rCount>0)
  {	
  while($rows=mysqli_fetch_array($result1))
  { $BPNUMBER=trim(getBpNumber($conn,$rows['MEMBERTYPE'],$rows['APPLICANT_ID']));
  ?>
  <tr>
   
    <td><a href="payment_approval.php?MstId=<?php echo $rows['PAYMENT_MST_ID'];?>&member_type=<?php echo $_SESSION['member_type'];?>" style="color:#000000">
	<?php 
		echo getMemberName($conn,$rows['MEMBERTYPE'],$rows['APPLICANT_ID']);
	?>
    </a></td>
    <td><?php if($rows['ENTERED_ON']!=""){echo date("d-m-Y",strtotime($rows['ENTERED_ON']));}?></td>
    <td><?php echo $rows['EXPORT_APP_ID'];?></td>
    <td><?php echo $rows['KP_CERT_NO'];?></td>
    <td>
		<?php if($rows['FORM_TYPE']=='I')
                echo "Import";
            else
                echo "Export";
        ?>
    </td>
    <td><?php echo $rows['PAYMENT_AMOUNT'];?></td>
    <td><?php echo trim($rows['SO_NUMBER']);?></td>
	<td><?php echo trim($rows['DELIVERY_NUMBER']);?></td>
    <?php if($rows['SO_STATUS']=="Y"){?>
    	<td><a onclick="return(window.confirm('SO Already Created..'));"><img src="images/active.png"/></a></td>
        <?php if($rows['DELIVERY_STATUS']=="Y"){?>
          <td><a onclick="return(window.confirm('Delivery Already Done..'));"><img src="images/active.png"/></a></td>
         <?php } else{?>
         <td class="delivery" data-url="<?php echo trim($rows['SO_NUMBER']);?> <?php echo $rows['PAYMENT_MST_ID'];?>">Delivery</td>
         <?php }?>	
    <?php }else {?>
    	<td class="so" data-url="<?php echo $rows['EXPORT_APP_ID'];?> <?php echo $rows['PAYMENT_MST_ID'];?>">Create SO</td>
        <td><a onclick="return(window.confirm('SO Pending..'));">Delivery</a></td>
    <?php }?>
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
<div class="pages_1">Total number of Payment: <?php echo $rCount;?><?php echo pagination($limit,$page,'search_payment.php?action=view&page=',$rCount); //call function to show pagination?></div>        

<?php } ?>      
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(".so").click(function() {
	var values = $(this).data('url').split(" ");
	var EXPORT_APP_ID=values[0];
	var PAYMENT_MST_ID=values[1];

	if (confirm("Are you sure you want to create sales order")) {
		$.ajax({
		url: "create_so_api.php",
		method:"POST",
		data:{EXPORT_APP_ID:EXPORT_APP_ID,PAYMENT_MST_ID:PAYMENT_MST_ID},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			console.log(data);
			if($.trim(data)==1){
				alert("Sales Order successfully Created..");; 
				window.location.href = "search_payment.php?action=view";
			}else{
				alert("Sorry There is some problem with SAP response");; 
				window.location.href = "search_payment.php?action=view";
			
			}
			console.log(data);
		},
		});
	}	  
});
</script>
<script type="text/javascript">
$(".delivery").click(function() {
	var values = $(this).data('url').split(" ");
	var SO_NUMBER=values[0];
	var PAYMENT_MST_ID=values[1];
	/*alert(SO_NUMBER);
	alert(PAYMENT_MST_ID);
	return false;*/
	
	if (confirm("Are you sure you want to create the delivery")) {
		$.ajax({
		url: "sap_delivery_api.php",
		method:"POST",
		data:{SO_NUMBER:SO_NUMBER,PAYMENT_MST_ID:PAYMENT_MST_ID},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			console.log(data);
			if($.trim(data)==1){
				alert("Delivery successfully Created..");; 
				window.location.href = "search_payment.php?action=view";
			}else{
				alert("Sorry There is some problem with SAP response");; 
				window.location.href = "search_payment.php?action=view";
			
			}
			console.log(data);
		},
		});
	}	  
});
</script>
</body>
</html>
