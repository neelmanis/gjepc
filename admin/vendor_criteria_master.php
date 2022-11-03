<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
?>
<?php 
date_default_timezone_set('Asia/Kolkata'); 
if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
     $request_id = $_REQUEST['id'];
	$sql="delete from vendor_criteria_master where id='$request_id'";
	// $stmtd = $conn -> prepare($sql);
	// $stmtd->bind_param("i", intval($_REQUEST['id']));
	if($conn->query($sql)){	echo"<meta http-equiv=refresh content=\"0;url=vendor_criteria_master.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$sql = "update vendor_criteria_master set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=vendor_criteria_master.php?action=view\">"; }
}

if ($_REQUEST['action']=='save')
{
    if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$area=filter($_REQUEST['area']);
	$criteria=filter($_REQUEST['criteria']);
	$subcriteria =implode(",", str_replace(","," ",$_REQUEST['sub_criteria']));
	$status=filter($_REQUEST['status']);
	$datetime = date("Y-m-d H:i:s");      
   
	$sql="INSERT INTO vendor_criteria_master (area,criteria,subcriteria,status,created_at) VALUES ('$area','$criteria','$subcriteria','$status','$datetime')";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=vendor_criteria_master.php?action=view\">"; }
	} else {
    echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
  }
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
  if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$area=filter($_REQUEST['area']);
	$criteria=filter($_REQUEST['criteria']);
	$sub_criteria=implode(",", str_replace(","," ",$_REQUEST['sub_criteria']));
	$status=filter($_REQUEST['status']);
	$datetime = date("Y-m-d H:i:s"); 
	$id=filter($_REQUEST['id']);
	$sql="update vendor_criteria_master set area='$area',criteria='$criteria',subcriteria='$sub_criteria',status='$status',created_at='$datetime' where id='$id'";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=vendor_criteria_master.php?action=view\">"; }
    } else {
    echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Registration ||GJEPC||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>      
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
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div> <textarea type="text" name="sub_criteria[] " id="sub-criteria" class="input_txt" rows="6"></textarea><a href="javascript:void(0);" class="remove_button"><img src="images/remove-icon.png"/></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>

<!--navigation end-->
<style type="text/css">
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
</style>
<script language="javascript">
function checkdata()
{
	area=document.getElementById('area').value;
	if( area=="")
	{
		alert("Please insert Area");
		document.getElementById('area').focus();
		return false;
	}
	criteria=document.getElementById('criteria').value;
	if(criteria=="")
	{
		alert("Please insert criteria.");
		document.getElementById('criteria').focus();
		return false;
	}
	status=document.getElementById('status').value;
	if( status=="")
	{
		alert("Please Select Status");
		document.getElementById('status').focus();
		return false;
	}
}
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
    	<div class="content_head"><a href="vendor_criteria_master.php?action=add"><div class="content_head_button">Add New</div></a>  
        <?php if($_REQUEST['action']=='view_details' || $_REQUEST['action']=='edit'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="vendor_criteria_master.php?action=view">Back to Import Export Master</a></div>
        <?php }?>
        </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Area</td>
        <td >Criteria</td>
        <td>Points</td>
        <td>Created at</td>
        <td>status</td>        
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $i=1;
	$sqlx1 = "SELECT * FROM vendor_criteria_master";
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
        
        <td><?php echo getVendorAreaName($row['area'],$conn) ;?></td>
        <td><?php echo $row['criteria']; ?></td>
        <td><?php $Subcriteria=explode(",",$row['subcriteria']); 
  foreach ($Subcriteria as $val ) {
     $value  = trim($val);
            if (!empty($value)) {?>
             <li><?php echo $value;?></li>
          <?php  }
            }  ?>
        </td>        
        <td><?php echo $row['created_at']; ?></td>       
        <td>
		<?php if($row['status'] == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        }else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="vendor_criteria_master.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="vendor_criteria_master.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="vendor_criteria_master.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
        <td ><a href="vendor_criteria_master.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" alt="Edit" width="15" height="15" border="0" /></a></td>
        <td ><a href="vendor_criteria_master.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
        $request_id = $_REQUEST['id'];
		$sql3 = "SELECT * FROM vendor_criteria_master where id=$request_id";
		
		$result2 = $conn->query($sql3);
		if($row2 = $result2->fetch_assoc())
		{
			$areaId = $row2['area'];
			$area=getVendorAreaName($row2['area'],$conn) ;
			$criteria=$row2['criteria'];
			$subcriteria=$row2['subcriteria'];		
			$status=$row2['status'];
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add Vendors Area </td>
    </tr>
    <?php token(); ?>
   <tr>
      <td valign="middle" class="content_txt">Area<span class="star">*</span></td>
      <td>
          <select name="area" id="area" class="show-tooltip input_txt" title="Please Select Area" >
            <?php   $queryarea = $conn ->query("SELECT * FROM vendor_area_master WHERE status=1");?>
            <option value="<?php echo $areaId; ?>"> <?php if(empty($area)){echo "Select Area";}else{echo $area;}?></option>
            <?php while($area =  $queryarea->fetch_assoc()){ ?>
            <option value="<?php echo $area['id'];?>"><?php echo $area['area'];?></option>
          <?php }?>
          </select>
      </td>
    </tr>
     <tr>
      <td valign="middle" class="content_txt">Criteria<span class="star">*</span></td>
      <td>          
          <textarea  name="criteria" id="criteria" class="show-tooltip input_txt" title="Please enter Area" rows="10" ><?php echo $criteria;?></textarea>
      </td>
    </tr>
    <tr>
      <td valign="middle" class="content_txt">Add Points</td>
      <td>
         <?php  
		 $listitems= explode(",",$subcriteria);       
         $notfrstitemlist= array_slice($listitems,1);          
          ?>
         <div class="field_wrapper">

        <div>
        <textarea type="text" name="sub_criteria[] "  id="sub-criteria"  class="input_txt" rows="6"><?php echo  $listitems[0]; ?> </textarea>
        <a href="javascript:void(0);" class="add_button" title="Add field"><img src="images/add-icon.png"/></a>
		</div>
          <?php foreach($notfrstitemlist as $items){ ?>
                    
		<div>
        <textarea type="text" name="sub_criteria[] "  id="sub-criteria"  class="input_txt" rows="6"><?php echo $items; ?> </textarea>    
        <a href="javascript:void(0);" class="remove_button "><img src="images/remove-icon.png"/></a>
		</div>
  <?php } ?>
</div>
      </td>
    </tr>    
 
     <tr>
      <td valign="middle" class="content_txt">Status<span class="star">*</span></td>     
      <td>
	  <select type="text" name="status" id="status" title="Status Type" class="show-tooltip input_txt" value="<?php echo $status;?>">
      	<option value="<?php echo $status;?>"><?php if($status=="0"){echo "Inactive";}else if($status=="1"){echo "Active";}else{echo "Select Status";} ?></option>
      	<option value="1">Active</option>
      	<option value="0">Inactive</option>
      </select></td>
    </tr>    
 
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />
    </td>
    </tr>
</table>
</form>
        </div>        
 <?php } ?>    
 
<?php 
if($_REQUEST['action']=='view_details'){
         $request_id = $_REQUEST['id'];
		$sql3 = "SELECT * FROM vendor_criteria_master where id=$request_id ";
		$query = $conn -> query($sql3);
	
		if($row2 = $query->fetch_assoc())
		{
			$area=getVendorAreaName($row2['area'],$conn) ;
			$criteria=stripslashes($row2['criteria']);	
			$created_at=stripslashes($row2['created_at']);
			$status=stripslashes($row2['status']);		
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>     
     <tr>
       <td class="content_txt">Area</td>
       <td class="text6"><?php echo $area; ?></td>
     </tr>     
      <tr>
       <td class="content_txt">Criteria</td>
       <td class="text6"><?php echo $criteria; ?></td>
     </tr>       
     <tr>
       <td class="content_txt">created at </td>
       <td class="text6"><?php echo $created_at; ?></td>
     </tr>    
     <tr>
       <td class="content_txt">Status </td>
       <td class="text6">
	    <?php if($status == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        }else if($status == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?></td>
     </tr>
   </table>
 </div>
 <?php } ?>
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>