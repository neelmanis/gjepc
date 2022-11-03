<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Vendor Uploaded Variable Documents</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
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
<script language="javascript">
function checkdata()
{
  remarks=document.getElementById('remarks').value;
  if( remarks=="")
  {
    alert("Please Leave A short Remark about Document");
    document.getElementById('remarks').focus();
    return false;
  }
}
</script>
<!--navigation end-->

<style type="text/css">
.style1 {color: #FF0000}
.style2 {
  font-size: 16px;
  font-weight: bold;
}
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #333;
    margin-bottom: 17px;
    margin-top: 13px;
}
.status_a{background: #05a505;padding: 5px 5px;color: #fff}
.status_p{background: #ff9b00;padding: 5px 5px;color: #fff}
.status_r{background: #ff7575;padding: 5px 5px;color: #fff}
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
  <div class="nav"><?php include("include/menu.php");?></div>
</div>
<style>
  .exp_imp tr th{
    border:1px solid #999999;
  }
</style>
<div class="clear"></div>

<div class="breadcome_wrap">
  <div class="breadcome"><a href="admin.php">Home</a> > Manage Vendor Uploaded Variable Documents </div>
</div>
<?php 
if(($_REQUEST['action']=='approved') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$area_id     = filter($_REQUEST['area_id']);
    $document_key = $_REQUEST['document_key'];  
    $id     = intval(filter($_REQUEST['id']));
    $sql  = "update area_spec_doc_upload set status=? where id=? and area_id=? and document_key=?";
    $stmt = $conn -> prepare($sql);
	$stmt->bind_param("siss", $status,$id,$area_id,$document_key);
	if($stmt->execute()){ echo "<meta http-equiv=refresh content=\"0;url=vendor_uploaded_variable_docs.php?action=view\">"; }
}

if(($_REQUEST['action']=='reject') && ($_REQUEST['id']!=''))
{ 
    $status = "rejected"; 
    $id     = intval(filter($_REQUEST['id']));
	$remarks = filter($_REQUEST['remarks']);    
    $sql="update area_spec_doc_upload set status=?,remarks=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("ssi", $status,$remarks,$id);
	if($stmt->execute()){   echo"<meta http-equiv=refresh content=\"0;url=vendor_uploaded_variable_docs.php?action=view\">"; }
}
?>

<div id="main">
  <div class="content">
<?php if($_REQUEST['action']=='view') { ?>     
<div class="content_details1">
    
<table id="example" class="" style="width:100%">
        <thead>
            <tr class="orange1">
                <th>Sr. No.</th>
                <th>Company Name</th>
                <th>Area</th>
                <th>Document</th>
                <th>View</th>
                <th>Remarks</th>
                <th>Document Type</th> 
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
    <?php    
    $i=1;
	//$sqlx1 = "SELECT * FROM area_spec_doc_upload";
    $sqlx1 = "SELECT asd.id AS id, asd.area_id AS area_id,asd.vendor_id AS vendor_id, 
              asd.document_name AS document_name, asd.document_key AS document_key,
              asd.document AS document,asd.`status` AS status,asd.remarks AS remarks, asd.created_at AS created_at,
              asd.action_by AS action_by, vd.`type` AS type, vd.access AS document_type
              FROM area_spec_doc_upload AS asd
              LEFT JOIN vendor_documents AS vd on asd.document_key = vd.document_key";
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
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo getVendorCompanyName($row['vendor_id'],$conn);?></td>
                <td><?php echo getVendorAreaName($row['area_id'],$conn);?></td>
                <td><?php echo $row['document_name'];?></td>
                <td><a href="/<?php echo $row['document'];?>" target="_blank" ><img src="images/download.png"></a></td>
                <td><?php echo $row['remarks'];?></td>
                <td><?php echo $row['document_type'];?></td>
                <td><?php if($row['status']=="approved"){
                echo'<span class="status_a">Approved</span>';
                }else if($row['status']=="rejected"){
                   echo'<span class="status_r">Rejected</span>'; 
               }else if($row['status']=="pending"){
                   echo'<span class="status_p">Pending</span>'; 
               } ?></td>          
            </tr>
            <?php
			  $i++;
				 }
			   }
			?>
          </tbody>
        </table>        
</div>        
<?php } ?>        
 <?php if($_REQUEST['action']=='rejectForm') { 
  $action= "reject";
  $appId= $_REQUEST['id'];
 ?>  
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
    <tr class="orange1">
    <td colspan="2"> &nbsp;Reject Vendors Uploaded Variable Document </td>
    </tr>
    <tr>
      <td valign="middle" class="content_txt">Remarks<span class="star">*</span></td>
      <td><textarea  name="remarks" id="remarks" class="show-tooltip input_txt" title="Please Enter Remarks" rows="10" ></textarea></td>
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
 
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</body>
</html>