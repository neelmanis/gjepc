<?php 
session_start();
if(!isset($_SESSION['curruser_contact_name'])){ header('Location: index.php'); exit; } 
if(!isset($_SESSION['curruser_login_id'])){	header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
$adminID = intval(filter($_SESSION['curruser_login_id']));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Registered Member List ||GJEPC||</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>

<div class="breadcome_wrap"><div class="breadcome"><a href="#">Home</a> > Manage Registered Member List</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Registered Member List  </div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>    
</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<div id="mobileMsg"></div>
<!--<button type="button" class="btn btn-success" id="sendMobile">Send Email</button>-->
  <tr class="orange1">
    <td width="8%">Date</td>
    <td>Company Name</td>
    <td>Name</td>
	<td>BP Number</td>
    <td>Designation Type</td>
    <td>Designation</td>
    <td>Mobile Number</td>
    <td>Pan No.</td>
    <td>Status</td>
    <!--<td>Select</td>
    <td>Action</td>-->
  </tr>
    <?php  
	$page=1;//Default page
	$limit=10;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
    $i=1;
    $sql="select rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.email_id,rm.address_line1,rm.address_line2,rm.city,rm.state,sm.state_name,sm.region,rm.pin_code,rm.land_line_no,rm.mobile_no, vd.bp_number, vd.shows, vd.year, vd.name, vd.lname, vd.degn_type,vd.designation, vd.gender, vd.mobile, vd.email, vd.aadhar_no, vd.pan_no, vd.photo, vd.salary_slip_copy, vd.pan_copy, vd.partner, vd.visitor_approval, vd.disapprove_reason from visitor_directory vd inner join registration_master rm on vd.registration_id = rm.id 
 left join state_master sm on sm.state_code = rm.state where vd.visitor_approval='Y' and vd.status = '1' order by rm.state"; 	 
	$result = $conn ->query($sql);
	$rCount =  $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn ->query($sql1);
	
  if($rCount>0)
  {	
  while($rows = $result1->fetch_assoc())
  { 
	$visitor_approval = $rows['visitor_approval'];
	if($visitor_approval == "Y"){ $visitor_approval= "<span style='color:green'>Approved</span>"; $v_date = date("d-m-Y",strtotime($rows['post_date'])); } 
	if($visitor_approval == "P"){ $visitor_approval= "<span style='color:blue'>Pending</span>";   $v_date = date("d-m-Y",strtotime($rows['post_date']));}
	if($visitor_approval == "D"){ $visitor_approval= "<span style='color:red'>Disapproved</span>"; $v_date = date("d-m-Y",strtotime($rows['mod_date']));}
	if($visitor_approval == "U"){ $visitor_approval= "<span style='color:green'>Updated</span>";  $v_date = date("d-m-Y",strtotime($rows['mod_date']));}
  ?>
  <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
    <td><?php echo $i;?></td>
    <td><?php echo strtoupper(filter($rows['company_name']));?></td>
    <td><?php echo strtoupper(filter($rows['name']).' '.filter($rows['lname']));?></td>
	<td><?php echo strtoupper(filter($rows['bp_number']));?></td>
    <td><?php echo $rows['degn_type'];?></td> 
    <td><?php echo getVisitorDesignation($rows['designation'],$conn);?></td> 
    <td><?php echo filter($rows['mobile']);?></td> 
    <td><?php echo filter($rows['pan_no']);?></td>  
    <td><?php echo $visitor_approval;?></td>   
	<!--<td><input type="checkbox" class="mobile" name="mobile" value="<?php echo $rows["mobile"]; ?>"></td>-->
	
    <td><input type="checkbox" name="single_select" class="single_select" data-mobile="<?php echo $rows["mobile"];?>"/></td>   
    <td><button type="button" name="smsl_button" class="btn btn-info btn-xs smsl_button" id="<?php echo $i;?>" data-mobile="<?php echo $rows["mobile"];?>" data-action="single">Send Single</button></td> 
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
  <?php  }  ?>
    <tr>
      <td colspan="10"></td>
      <td><button type="button" name="bulk_email" class="btn btn-info smsl_button" id="bulk_email" data-action="bulk">Send Bulk</button></td>
    </td>
	</tr>
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
       
<div class="pages_1">Total number of Members: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_registration.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
 
</div>
</div>

<script>
$(document).ready(function(){
 $('.smsl_button').click(function(){
  $(this).attr('disabled', 'disabled');
  
  var id = $(this).attr("id");
  var action = $(this).data("action");  
  var mobile_data = [];
  
  if(action == 'single')
  {
    mobile_data.push({
    mobile: $(this).data("mobile")
    //name: $(this).data("name")
   });
 
 }  else  { 
 
   $('.single_select').each(function(){
    if($(this). prop("checked") == true)
    {
     mobile_data.push({
      mobile: $(this).data("mobile")
      //name: $(this).data('name')
     });
    }
   });
  }

   console.log(mobile_data);
  //console.log(mobile_data.length);
    if(mobile_data.length > 0) {
    $("#mobileMsg").html('<div class="alert alert-primary">Please wait...!</div>');
		  
  $.ajax({
	url : "send_ajax_whatsappMsg.php",
	method : "POST",
    data : { mobile_data : mobile_data },
    beforeSend : function(){
    $('#'+id).html('Sending...');
    $('#'+id).addClass('btn-danger');
   },
   success:function(data){ //alert(data);
    if(data = 'ok')
    {
     $('#'+id).text('Success');
     $('#'+id).removeClass('btn-danger');
     $('#'+id).removeClass('btn-info');
     $('#'+id).addClass('btn-success');
    }
    else
    {
     $('#'+id).text(data);
    }
    $('#'+id).attr('disabled', false);
   }   
   });
    } else {
        $("#mobileMsg").html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button> Plase Select at least one checkbox </div>');
    }
 });
});
</script>
<!--<script type="text/javascript">
  $(document).ready(function(){
    $("#sendMobile").click(function(){
      
      var mobile = [];
      
      $(".mobile:checked").each(function(){
        mobile.push($(this).val());
      });

      if (mobile.length > 0) {
          $("#mobileMsg").html('<div class="alert alert-primary">Please wait...!</div>');
          $.ajax({
            url:"send_ajax_whatsappMsg.php",
            type : "POST",
            cache:false,
            data : {mobile:mobile},
            success:function(response){
              if(response == true) {
                $("#mobileMsg").html(response);
              }else{
                $("#mobileMsg").html();
              }
            }
          });
      } else {
        $("#mobileMsg").html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button> Plase Select at least one checkbox </div>');
      }
    });
  });
</script>-->
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>