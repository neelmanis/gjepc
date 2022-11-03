<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
 
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['category_type']="";
  $_SESSION['keyword']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['firm_type']="";
  $_SESSION['member_type']="";
  $_SESSION['status']="";
  
  header("Location: membership.php");
  
}else
{ 
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{ 
	  $_SESSION['category_type']=$_REQUEST['category_type'];
	  $_SESSION['keyword']=$_REQUEST['keyword'];
	  $_SESSION['from_date']=$_REQUEST['from_date'];
	  $_SESSION['to_date']=$_REQUEST['to_date'];
	  $_SESSION['firm_type']=$_REQUEST['firm_type'];
	  $_SESSION['member_type']=$_REQUEST['member_type'];
	  $_SESSION['status']=$_REQUEST['status'];
	}
if($search_type=='SEARCH')
{
if($_SESSION['category_type']=="" && $_SESSION['keyword']=="" && $_SESSION['from_date']=="Form" && $_SESSION['to_date']=="To" && $_SESSION['firm_type']=="" && $_SESSION['member_type']=="" && $_SESSION['status']=="")
{
$_SESSION['error_msg']="Please select atleast one field to search";
}else if($_SESSION['category_type']=="" && $_SESSION['keyword']!="")
{
$_SESSION['error_msg']="Please select category for the keyword entered below";
}else if($_SESSION['category_type']!="" && $_SESSION['keyword']=="")
{
$_SESSION['error_msg']="Please enter keyword for above category";
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

<?php
$action_update=$_REQUEST['action_update'];

if($action_update=="UPDATE_STATUS")
{

$issue_rcmc_cer=$_REQUEST['issue_rcmc_cer'];

foreach($issue_rcmc_cer as $val)
{
//$rcmc_certificate_issue_date=date('Y-m-d');
//$rcmc_certificate_expire_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($rcmc_certificate_issue_date)) . " +5 year"));

$update_rcmc="update approval_master set rcmc_certificate_approve='Y',rcmc_certificate_issue_status='Y',rcmc_certificate_apply='N' where registration_id='$val'";
$update_result_rcmc=mysql_query($update_rcmc);

}

$renew_application=$_REQUEST['renew_application'];

foreach($renew_application as $val1)
{

$membership_renewal_dt=date('Y-m-d');

	// current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
 	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
$next_fin_year=$cur_year+1;    
$membership_expiry_dt="$next_fin_year-03-31";

$update_renew="update approval_master set membership_renewal_dt='$membership_renewal_dt',membership_expiry_dt='$membership_expiry_dt',membership_expiry_status='N',apply_membership_renewal='N'  where registration_id='$val1'";
$update_result_renew=mysql_query($update_renew);

}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Membership Form ||GJEPC||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />




<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>



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

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}

-->
</style>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Membership</div>
</div>

<div id="main">
	<div class="content">
    
    	<!--<div class="content_head"><a href="webtoerp_export.php" target="_blank"><div class="content_head_button">Export New Member Web To ERP</div></a> <a href="renewalwebtoerp_export.php" target="_blank"><div class="content_head_button">Export Renewal Web To ERP</div></a> <a href="import_export.php" target="_blank"><div class="content_head_button">Import Export Membership data</div></a><a href="erptoweb_import.php" target="_blank"><div class="content_head_button">Import ERP To Web</div></a><a href="download_status.php" target="_blank"><div class="content_head_button">Activate Download Status</div></a>
        </div>-->
    	
      <div class="clear"></div>
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>

<div id="formAdmin">




<!--<ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#" class="lastBg active"><strong>Step 3 Photo</strong></a></li>   
    
    <div class="clear"></div>
    
</ul>-->


<div id="formContainer">

<div id="form">
			
           

<div class="clear bottomSpace"></div>
      <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Approval</td>
</tr>

<tr>
    <td colspan="11" ><div id="personalData">
              
              <div style="float:left;">
              
             <div class="leftPic">
             
               <img src="images/user_pic.jpg"  alt="" />
               <div class="clear"></div>
              
               
               </div>
               
                <div class="maroonBtn_1 changePhoto"><a href="change_photo_form_pvr.php">Change Photo</a></div>
              </div>
              
        
              
              <div class="right_text">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="bold" width="112">Company </td>
                    <td width="13">:</td>
                    <td width="323">K.P. SANGHVI &amp; SONS</td>
                  </tr>
                  <tr>
                    <td class="bold">Contact Person</td>
                    <td>:</td>
                    <td>ARVIND SANGHVI</td>
                  </tr>
                  <tr>
                    <td class="bold">Designation</td>
                    <td>:</td>
                    <td>DIRECTOR</td>
                  </tr>
                  <tr>
                    <td class="bold">Address</td>
                    <td>:</td>
                    <td>36E, PLOT NO.13, MAROL COOPERATI INDUSTRIAL ESTATE , MARO</td>
                  </tr>
                  <tr>
                    <td class="bold">Email</td>
                    <td>:</td>
                    <td><a href="mailto:info@kpsanghavi.com">info@kpsanghavi.com</a></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="topSpace">
                 
                 
                 
                 </td>
                  </tr>
                  
                     <tr>
                       <td colspan="3" class="bold "><div class="maroonBtn_1" style="margin-right:10px;"><a href="domestic_privilege_summary_form.php">View Your Application Summary</a></div>
                    <div class="maroonBtn_1"><a href="#">Print Ack</a></div>
                    
                    <div class="clear"></div>
                    
                    </td>
                     </tr>
                     <tr>
                    <td class="bold bgImage">Payment Status</td>
                    <td class="bgImage">:</td>
                    <td class="bgImage">Pending</td>
                  </tr>
                     <tr>
                       <td class="bold bgImage">Information Status</td>
                       <td class="bgImage">:</td>
                       <td class="bgImage">Pending</td>
                     </tr>
                     <tr>
                       <td colspan="3" class="bold bgImage"><div><input type="submit" name="button" id="button" value="Submit" class="maroonBtn" /></div></td>
                     </tr>
                  
                </table>
              </div>
              
              
              
              
              
              <div class="clear"></div>
              
           
            </div></td>
</tr>
            
         </table>   
            
            
            
            
            
            </div>

</div>







</div>

</form>      
</div>

<!--<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="15%" height="30">Name</td>
    <td width="11%">IEC NO.</td>
    <td width="18%">Certificate No.</td>
    <td width="20%">Membership No.</td>
    <td width="13%">Region</td>
    <td width="8%">Action</td>
    <td width="12%">&nbsp;</td>
    <?php
	if($_SESSION['status']=='Application_for_renewal_of_membership')
	{
	echo "<td width='15%'>Renewal Applications</td>";
	}
	?>
    
	<?php
	if($_SESSION['status']=='Issue_rcmc_certificate')
	{
	echo "<td width='15%'>Issue RCMC Certificate</td>";
	}
	?>

  </tr>
  <?php
  
 	$page=1;//Default page
	$limit=10;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
  
  $sql="select a.id,b.company_name,b.iec_no,b.region_id,b.member_type_id,c.challan_scanned_copy,c.signature_slip_copy,d.merchant_certificate_no,d.manufacturer_certificate_no,d.membership_id from registration_master a,information_master b,challan_master c,approval_master d where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and c.challan_financial_year='2013' ";
  
  if($_SESSION['curruser_role']=="Admin")
  {
  $sql.=" and b.region_id='".$_SESSION['curruser_region_id']."' ";
  }
  
  if($_SESSION['category_type']!="" && $_SESSION['keyword']!="")
  {
  $sql.=" and b.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
  }
  
  if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
  {
    $sql.=" and a.post_date between '".$_SESSION['from_date']."' and '".$_REQUEST['to_date']."'";
  }
  
  if($_SESSION['firm_type']!="")
  {
  $sql.=" and b.type_of_firm='".$_REQUEST['firm_type']."'";
  }
  
  if($_SESSION['member_type']!="")
  {
  $sql.=" and b.member_type_id='".$_SESSION['member_type']."' ";
  }

  if($_SESSION['status']!="")
  { 
  	if($_SESSION['status']=='New_application_for_membership')
	{
  	$sql.=" and d.membership_type='N' ";
	}else if($_SESSION['status']=='Application_for_renewal_of_membership')
	{
	$sql.=" and d.apply_membership_renewal='Y' ";
	}else if($_SESSION['status']=='Information_Approved')
	{
	$sql.=" and d.information_approve='Y' ";
	}else if($_SESSION['status']=='Information_Disapproved')
	{
	$sql.=" and d.information_approve='N' ";
	}else if($_SESSION['status']=='Information_Pending')
	{
	$sql.=" and d.information_approve='P' ";
	}else if($_SESSION['status']=='Document_Approved')
	{
	$sql.=" and d.document_approve='Y' ";
	}else if($_SESSION['status']=='Document_Disapproved')
	{
	$sql.=" and d.document_approve='N' ";
	}else if($_SESSION['status']=='Document_Pending')
	{
	$sql.=" and d.document_approve='P' ";
	}else if($_SESSION['status']=='Payment_Approved')
	{
	$sql.=" and d.payment_approve='Y' ";
	}else if($_SESSION['status']=='Payment_Disapproved')
	{
	$sql.=" and d.payment_approve='N' ";
	}else if($_SESSION['status']=='Payment_Pending')
	{
	$sql.=" and d.payment_approve='P' ";
	}else if($_SESSION['status']=='Application_for_rcmc_certificate')
	{
	$sql.=" and d.rcmc_certificate_apply='Y' ";
	}else if($_SESSION['status']=='Issue_rcmc_certificate')
	{
	$sql.=" and d.rcmc_certificate_issue_status='N' ";
	}else if($_SESSION['status']=='GJEPC_Membership_Expired')
	{
	$sql.=" and d.membership_expiry_status='Y' ";
	}else if($_SESSION['status']=='RCMC_certificate_expired')
	{
	$sql.=" and d.rcmc_certificate_expire_status='Y' ";
	}
  }	
  
 	$sql.="group by a.id  order by a.id desc limit $start, $limit"; 
	
	$result=mysql_query($sql);
	
	
	
	//total no of record 
	$sql1="SELECT COUNT( * ) FROM ( select a.id from registration_master a,information_master b,challan_master c,approval_master d where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and c.challan_financial_year='2013' ";
  
  	if($_SESSION['curruser_role']=="Admin")
	{
	$sql1.=" and b.region_id='".$_SESSION['curruser_region_id']."' ";
	}
  
	if($_SESSION['category_type']!="" && $_SESSION['keyword']!="")
	{
	$sql1.=" and b.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
	}
	
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
	$sql1.=" and a.post_date between '".$_SESSION['from_date']."' and '".$_REQUEST['to_date']."'";
	}
	
	if($_SESSION['firm_type']!="")
	{
	$sql1.=" and b.type_of_firm='".$_REQUEST['firm_type']."'";
	}
	
	if($_SESSION['member_type']!="")
	{
	$sql1.=" and b.member_type_id='".$_SESSION['member_type']."' ";
	}
	
	if($_SESSION['status']!="")
	{
		if($_SESSION['status']=='New_application_for_membership')
		{
		$sql1.=" and d.membership_type='N' ";
		}else if($_SESSION['status']=='Application_for_renewal_of_membership')
		{
		$sql1.=" and d.apply_membership_renewal='Y' ";
		}else if($_SESSION['status']=='Information_Approved')
		{
		$sql1.=" and d.information_approve='Y' ";
		}else if($_SESSION['status']=='Information_Disapproved')
		{
		$sql1.=" and d.information_approve='N' ";
		}else if($_SESSION['status']=='Information_Pending')
		{
		$sql1.=" and d.information_approve='P' ";
		}else if($_SESSION['status']=='Document_Approved')
		{
		$sql1.=" and d.document_approve='Y' ";
		}else if($_SESSION['status']=='Document_Disapproved')
		{
		$sql1.=" and d.document_approve='N' ";
		}else if($_SESSION['status']=='Document_Pending')
		{
		$sql1.=" and d.document_approve='P' ";
		}else if($_SESSION['status']=='Payment_Approved')
		{
		$sql1.=" and d.payment_approve='Y' ";
		}else if($_SESSION['status']=='Payment_Disapproved')
		{
		$sql1.=" and d.payment_approve='N' ";
		}else if($_SESSION['status']=='Payment_Pending')
		{
		$sql1.=" and d.payment_approve='P' ";
		}else if($_SESSION['status']=='Application_for_rcmc_certificate')
		{
		$sql1.=" and d.rcmc_certificate_apply='Y' ";
		}else if($_SESSION['status']=='Issue_rcmc_certificate')
		{
		$sql1.=" and d.rcmc_certificate_issue_status='N' ";
		}else if($_SESSION['status']=='GJEPC_Membership_Expired')
		{
		$sql1.=" and d.membership_expiry_status='Y' ";
		}else if($_SESSION['status']=='RCMC_certificate_expired')
		{
		$sql1.=" and d.rcmc_certificate_expire_status='Y' ";
		}
	}	
	
	$sql1.=" group by a.id ) as temp"; 
	//echo "<br>".$sql1;
	$result1=mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);
	$rCount=$rows1[0];
	
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result))
  {
  ?>
  <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
    <td><?php echo strtoupper($rows['company_name']);?></td>
    <td><?php echo $rows['iec_no'];?></td>
    <td><?php if($rows['member_type_id']=="Merchant"){echo $rows['merchant_certificate_no'];}else{echo $rows['manufacturer_certificate_no'];}?></td>
    <td><?php echo $rows['membership_id'];?></td>
    <td ><?php echo $rows['region_id']?></td>
    <td valign="middle"><a href="information_form.php?registration_id=<?php echo $rows['id'];?>"><img src="images/edit1.png" border="0" /></a> </td>
    <td align="center" valign="bottom" class="linktext">
	<?php if($rows['challan_scanned_copy']!=""){?><div class="fancyDemo">	
<a rel="group" href="../scan_copy/<?php echo $rows['challan_scanned_copy'];?>">Challan Copy</a></div><?php } ?>
	<?php if($rows['signature_slip_copy']!=""){?><div class="fancyDemo">	
<a rel="group" href="../signature_slip/<?php echo $rows['signature_slip_copy'];?>">Signature Slip</a></div><?php } ?>    </td>
     
     <?php
	if($_SESSION['status']=='Application_for_renewal_of_membership')
	{
	echo "<td align='left'><input name='renew_application[]' type='checkbox' value='$rows[id]' /></td>";
	}
	?>
    
	<?php
	if($_SESSION['status']=='Issue_rcmc_certificate')
	{
	echo "<td align='left'><input name='issue_rcmc_cer[]' type='checkbox' value='$rows[id]' /> /<a href='../rcmc/print_certificate.php?registration_id=$rows[id]' target='_blank'> View Certificate</a></td>";
	}
	?>

  </tr>
  
  <?php
   $i++;
   }
   ?>
   
		<?php
        if($_SESSION['status']=='Application_for_renewal_of_membership')
        {
        ?>
        <tr>
        <td colspan="6">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Renew Application" value="Renew Application"  class="input_submit" /></td>
        </tr>
        <?php
        }
        ?>
        
        <?php
        if($_SESSION['status']=='Issue_rcmc_certificate')
        {
        ?>
        <tr>
        <td colspan="6">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Issue RCMC Certificate" value="Issue RCMC Certificate"  class="input_submit" /></td>
        </tr>
        <?php
        }
        ?>

   
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
</div>-->  


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
<div class="pages_1">Total number of Memberships: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'membership.php?action=view&page=',$rCount); //call function to show pagination?>
</div>        
      
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
