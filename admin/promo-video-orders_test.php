<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = $_SESSION['curruser_login_id'];
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";
  $_SESSION['company_name']="";
  $_SESSION['email_id']="";
  $_SESSION['approval_status']="";
  $_SESSION['pvrcode']="";
  $_SESSION['company_pan_no']="";
  $_SESSION['response']="";
  $_SESSION['city']="";
  
  header("Location: promo-video-orders.php?action=view");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
		$_SESSION['name']=filter($_REQUEST['name']);
		$_SESSION['company_name']=filter($_REQUEST['company_name']);
		$_SESSION['email_id']=filter($_REQUEST['email_id']);
		$_SESSION['approval_status']=filter($_REQUEST['approval_status']);
		$_SESSION['company_pan_no']=filter($_REQUEST['company_pan_no']);
		$_SESSION['response']=filter($_REQUEST['response']);
		$_SESSION['city']=filter($_REQUEST['city']);
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
<tr class="orange1"><td colspan="11">Search Options</td></tr>
<tr>
    <td width="19%" ><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
</tr>     
<tr >
  <td><strong>Person Name</strong></td>
  <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" /></td>
</tr>
<tr >
  <td><strong>Person Email ID</strong></td>
  <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $_SESSION['email_id'];?>" /></td>
</tr>

<tr >
  <td><strong>Pan No.</strong></td>
  <td><input type="text" name="company_pan_no" id="company_pan_no" class="input_txt" value="<?php echo $_SESSION['company_pan_no'];?>" /></td>
</tr>
<tr >
  <td><strong>City.</strong></td>
  <td><input type="text" name="city" id="city" class="input_txt" value="<?php echo $_SESSION['city'];?>" /></td>
</tr>
<tr >
  <td><strong>Application Status.</strong></td>
  <td>

  	<select  name="approval_status" id="approval_status" class="input_txt">
  		<option value="">Select Status</option>
  		<option <?php if($_SESSION['approval_status']=="P"){echo "selected";}?> value="P">Pending</option>
  		<option <?php if($_SESSION['approval_status']=="Y"){echo "selected";}?> value="Y">Approved</option>
  		<option <?php if($_SESSION['approval_status']=="N"){echo "selected";}?> value="N">Disapproved</option>
  	</select></td>
</tr>
<tr >
  <td><strong>Payment Response.</strong></td>
  <td>

  	<select  name="response" id="response" class="input_txt">
  		<option value="">Select Response</option>
  		<option <?php if($_SESSION['response']=="E000"){echo "selected";}?> value="E000">Success</option>
  		<option <?php if($_SESSION['response']=="E00329"){echo "selected";}?> value="E00329">NEFT</option>
  		<option <?php if($_SESSION['response']=="E00335"){echo "selected";}?> value="E00335">Cancelled</option>
  		<option <?php if($_SESSION['response']=="aborted"){echo "selected";}?> value="aborted">Aborted</option>
  	</select></td>
</tr>
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>
<?php if($_REQUEST['action']=='view') {

	function getOccasionName($occasion_id,$conn)
{
	$query_sel = "SELECT * FROM  promo_video_demo_master  where id='$occasion_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	$occasion =  $row['occasion'];
	$language_id =  $row['language_id'];
	
	$query_sel2 = "SELECT * FROM  promo_video_language_master  where id='$language_id'";
	$result2 = $conn->query($query_sel2);
	$row2 = $result2->fetch_assoc(); 		
	$language =  $row2['language'];

	return $occasion.'-'.$language;

}


?>    	
<div class="content_details1">
	<a href="http://gjepc.org/admin/promo_video_payment_report.php" style="margin-bottom: 10px;display: inline-block;float: right;">Download Report</a>
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
        <td width="5%">Time</td>
       	<td width="10%">Company Name</td>
       	<td width="5%">Person Name</td>
     <!--    <td width="5%">Email Id</td> -->
        <td width="5%">Mobile No.</td>
        <td width="5%">City</td>
        <td width="20%">Occasions</td>
        <td width="5%">Logo</td>
        <td width="3%">Amount</td>
        <td width="3%">Response</td>
        <td width="10%">Approval</td>
        <td width="27%">Bp Number</td>
        <td width="27%">Advance Doc</td>
        <td width="27%">Sales Order</td>
    
    </tr>
    
    <?php 
  $page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'b.created_at';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    //$sql="SELECT registration_master.id,registration_master.gcode,registration_master.email_id,registration_master.password,registration_master.company_name,registration_master.status,registration_master.post_date,registration_master.company_pan_no,information_master.iec_no FROM registration_master LEFT JOIN information_master ON registration_master.id=information_master.registration_id where registration_master.status=1";
    $sql="SELECT a.id,a.email_id,a.old_pass,a.company_name,a.status,a.post_date,a.company_pan_no,a.company_gstn,a.city,b.id as payment_id,b.created_at,b.name as person_name,b.email_id as person_email,b.mobile_no as person_number,b.occasion,b.company_logo,b.Response_Code,b.Transaction_Amount,b.approval_status,b.sales_order_no,b.sap_sale_order_create_status,b.advance_doc FROM promo_video_payment_history b LEFT JOIN registration_master a ON a.id=b.registration_id  WHERE a.status='1'";
	if($_SESSION['name']!="")
	{
	$sql.=" and b.name like '%".$_SESSION['name']."%'";
	}
	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and a.company_name like '%".$_SESSION['company_name']."%'";
	}
	
	if($_SESSION['email_id']!="")
	{
	$sql.=" and b.email_id like '%".$_SESSION['email_id']."%'";
	}
	if($_SESSION['city']!="")
	{
	$sql.=" and a.city like '%".$_SESSION['city']."%'";
	}

	
	
	if($_SESSION['company_pan_no']!="")
	{
	$sql.=" and a.company_pan_no ='".trim($_SESSION['company_pan_no'])."'";
	}
	if($_SESSION['approval_status']!="")
	{
	$sql.=" and b.approval_status ='".trim($_SESSION['approval_status'])."'";
	}
	if($_SESSION['response']!="")
	{
		if($_SESSION['response']=="aborted"){
        $sql.=" and b.Response_Code is null";
         
		}else{
        $sql.=" and b.Response_Code ='".trim($_SESSION['response'])."'";
		}
	
	}
	
	$sql.= " ".$attach." ";

	$result1 = $conn ->query($sql);
	$rCount  = $result1->num_rows;
	
	 $sql1= $sql." limit $start, $limit ";
	$result = $conn ->query($sql1);
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	

      $regNo = $row['id'];
      $bpNumber = getBPNO($regNo,$conn);
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
         <td><?php echo $row['created_at']; ?></td>
	    <td><?php echo $row['company_name']; ?></td>
	    <td><?php echo $row['person_name']; ?></td>
	  <!--   <td><?php echo $row['person_email']; ?></td> -->
	    <td><?php echo $row['person_number']; ?></td>
	    <td><?php echo $row['city']; ?></td>
	    <td><?php 
	    foreach(explode(",",$row['occasion']) as $val){
	    	echo getOccasionName($val,$conn)."<br>";
	    }  ?></td>
	    <td> <a href="https://gjepc.org/images/company_logo/<?php echo $row['company_logo'];?>" target="_blank"><img src="https://gjepc.org/images/company_logo/<?php echo  $row['company_logo'];?>" style="width:100px; height: auto;"></a></td>
	    <td><?php echo $row['Transaction_Amount']; ?></td>
		
        <td><?php if($row['Response_Code']=="E00335"){
        	echo  "Cancelled";
        }else if($row['Response_Code']=="E000"){
        	echo "Success";
        }else if($row['Response_Code']=="E00314"){
        	echo "Failed";
        }else if($row['Response_Code']=="E00329"){
        	echo "NEFT ";
        }else{
        	echo "Aborted ";
        } ?>
        	
        </td>
        <td>
        <span class="approval_status_text">
        <?php if($row['approval_status']=='P'){
        	echo "Pending";
        }else if($row['approval_status']=='Y'){
            echo "Approved";
        }else if($row['approval_status']=='N'){
            echo "Disapproved";
        }
        ?>
        </span>
       
        <?php if($row['approval_status']=='P'){?>
    	<select name="app_approval" class="input_txt approve-diaspprove" style="width: 80%">
    		<option value="">Select Approval</option>
    		<option value="Y">Approve</option>
    		<option value="N">Disapprove</option>
    	</select>
        <?php } ?>
        	<input type="hidden" name="payment_id" class="payment_id" value="<?php echo $row['payment_id'];?>">
        	<p class="success_msg" style="color: green"></p>
        </td>
        <td>
           <?php if( $bpNumber !=""){
            echo  $bpNumber ;
           }else{
            $sql_reg_master = "SELECT * FROM registration_master WHERE  id='$regNo' AND status='1'";
            $result_reg_master = $conn->query($sql_reg_master);
            $row_reg_master =$result_reg_master ->fetch_assoc();
            $nm_bp_number = trim($row_reg_master['NM_bp_number']);
             echo $nm_bp_number ;
           }?>
        </td>
        <td><?php echo $row['advance_doc']; ?></td>
        <td> 
          <?php 
          
          
          $payment_id = $row['payment_id'];
          $sales_order_no = trim($row['sales_order_no']);
          $sap_sale_order_create_status = $row['sap_sale_order_create_status'];
          if($row['approval_status']=="Y"){
          if($row['Response_Code']=="E000" || $row['Response_Code']=="E00329"){

          if(($sales_order_no =="" || is_null($sales_order_no)) && $sap_sale_order_create_status=="0" ){

          if($bpNumber ==""){
          	$sql_reg_master = "SELECT * FROM registration_master WHERE  id='$regNo' AND status='1'";
          	$result_reg_master = $conn->query($sql_reg_master);
          	$row_reg_master =$result_reg_master ->fetch_assoc();
          	$nm_bp_number = trim($row_reg_master['NM_bp_number']);
            if($nm_bp_number =="" ||  is_null($nm_bp_number) || $nm_bp_number =="0"){ ?>
              <a href="#" >Create BP</a>
            <?php }else{ ?>
           <a data-url="<?php echo $nm_bp_number." ".$regNo." ".$payment_id; ?>"  title="Create Sales Order" class='so'><img src="images/yes.gif" border="0"></a>
          <?php  }

          }else{ ?>
          	<a data-url="<?php echo $bpNumber." ".$regNo." ".$payment_id; ?>"  title="Create Sales Order" class='so'><img src="images/yes.gif" border="0"></a>

         <?php  }   }else{

          echo $sales_order_no;

           }
         }else{ ?>
            <img src="images/notification-exclamation.gif" border="0">
        <?php }

      }else  if($row['approval_status']=="N"){
        echo "Disapproved";

      }else{
        echo "Application Pending";
      }


         ?>
          
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
       
<div class="pages_1">Total number of Orders: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'promo-video-orders.php?action=view&page=',$rCount); //call function to show pagination?>
</div>     
 

    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".approve-diaspprove").change(function(){
			var approval =$(this).val();
			var payment_id = $(this).siblings("input").val();
			var ref= $(this);
			
			if(approval!=""){
              if(confirm("Approve/ Disapprove")){
                  	var actiontype = "approval_status_update_action";
			        $.ajax({
			        type:'POST',
			        data:{approval:approval,payment_id:payment_id,actiontype:actiontype},
			        url:"ajax.php",
			        dataType: "json",
			        beforeSend: function() {
			        $(".pan_check_loader").show();
			        },
			        success: function(result) { 
			           if(result.status=='success'){
			           	if(approval=="Y"){

                            ref.siblings(".approval_status_text").text("Approved");
                            ref.siblings(".success_msg").text("Application Approved");
                            ref.hide();
			           	}else{
			           		 ref.siblings(".approval_status_text").text("Disapproved");
                            ref.siblings(".success_msg").text("Application Disapproved");
                            ref.hide();
			           	}
			           	
			           }
			            
			        
			        }
			        });
              }else{
              	return false;
              }
			}else{
				return false;
			}
		});

$(".so").click(function(){
  var values = $(this).data('url').split(" ");
  var bp_number =values[0];
  var reg_no = values[1];
  var payment_id = values[2];
  

  var action = "promo_video_sales_order_action";

  if (confirm("Are you sure you want to create sales order")) {
    $.ajax({
    url: "sales_order_promo_video.php",
    method:"POST",
    data:{bp_number:bp_number,reg_no:reg_no,payment_id:payment_id,action:action},
    type: "POST",
    beforeSend: function() {
      $("#overlay").show();
      },
    success:function(data)
    {   
     console.log(data); 
     return false;
     window.location.reload();

    },
    });
  }else{
  	return false;
  }   
});


	});
</script>
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
