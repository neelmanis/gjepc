<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
  $adminId = intval(filter($_SESSION['curruser_login_id']));
  $registration_id = intval(filter($_REQUEST['regid']));
  $orderId = filter($_REQUEST['orderId']);
  $id = intval(filter($_REQUEST['id']));
  $errorMessage = "";
?>


<?php
if($_REQUEST['Reset']=="Reset")
{
  //$_SESSION['company_name']="";
  $_SESSION['category']="";
  
  header("Location: manage_visitor_badge_status_reports.php?action=view");
}else if($_REQUEST['request']=="Export"){

   
   
    $_SESSION['category'] = $_REQUEST['category'];

    $sql_report ="SELECT * FROM `globalExhibition` WHERE 1";

    if($_SESSION['category']!="")
    {

      if($_SESSION['category'] =="VIS"){
        $participant_Type= "VIS";
        $agency_category= "";
      }else if($_SESSION['category'] =="IGJME"){
        $participant_Type= "IGJME";
        $agency_category= "";
      }else{
        $participant_Type= "CONTR";
        $agency_category= $_SESSION['category'];
      }

    $sql_report.=" and participant_Type = '".$participant_Type."' " ;
    if($agency_category !==""){

        $sql_report .="and agency_category = '".$agency_category."' ";
    }
    }
   
    
   
    
        $table = $display = "";   
        $fn = strtolower($_SESSION['category'])."_badge_report_". date('Ymd');
        $table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td>Date</td>
      
        <td>Company Name</td>
        <td>Visitor Name</td>
        
     
        <td>Mobile</td>
        <td>PAN</td>

        <td>Remark</td>
        <td>Badge Download Status</td>
        <td>Badge  Status</td>
        </tr>';

        
        $result_report = $conn ->query($sql_report);

        while($row_report = $result_report->fetch_assoc())
        {   

        if($row_report['isVerified'] =="1"){
            $download = "Yes";
        }else{
             $download = "No";
        }
        if($row_report['status'] =="P"){
            $status = "Pending";
        }else if($row_report['status'] =="Y"){
             $status = "Active";
        }else if($row_report['status'] =="D"){
             $status = "Blocked";
        }

            
        $table .= '<tr>

        <td>'.$row_report['modified_date'].'</td>
     
        <td>'.$row_report['company'].'</td>
        <td>'.$row_report['fname'].'</td>
        
        
        <td>'.$row_report['mobile'].'</td>
        <td>'.$row_report['pan_no'].'</td>
      
      
        <td>'.$row_report['remark'].'</td>
        <td>'.$download.'</td>
        <td>'.$status.'</td>

        </tr>';
            
        }
         $table .= $display;
        $table .= '</table>';

        header("Content-type: application/x-msdownload"); 
        # replace excelfile.xls with whatever you want the filename to default to
        header("Content-Disposition: attachment; filename=$fn.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $table;
        exit;   
    
    
}
//print_r($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS SIGNATURE 2022</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="fancybox/jquery-3.3.1.js"></script> 
<script type="text/javascript" src="fancybox/fancybox_js.js"></script>
<script type="text/javascript">     
$("div.fancyDemo a").fancybox();
</script>     
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<!--navigation end-->
<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
<script type="text/javascript">
ddsmoothmenu.init({
    mainmenuid: "smoothmenu1", //menu DIV id
    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
    classname: 'ddsmoothmenu', //class added to menu's outer DIV
    //customtheme: ["#1c5a80", "#18374a"],
    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!-- lightbox Thum -->

<script>
$(document).ready(function(){
    $("#disapproval_remark").hide();
    $(".dose_status").change(function(){
    var approval =$(this).val();
    
    if(approval =="N"){
        $("#disapproval_remark").show();
    }else{
        $("#disapproval_remark").hide();
    } 
});
$('#disapproval').hide();

$('#disapprove').click(function(){
//alert('disapprove');
        $('#disapproval').show();
      });
      $('#approve').click(function(){
//alert('disapprove');
        $('#disapproval').hide();
      });
});


</script>

<?php
$sql3 = "SELECT * FROM visitor_directory where visitor_id='$id'";
$result3 = $conn ->query($sql3);
if($row3 = $result3->fetch_assoc())
{
$approved = filter($row3['visitor_approval']);
}
?>
<script>
var approv = '<?php echo $approved; ?>';
$(document).ready(function(){
 if(approv == 'D' || approv == 'U')
 {
 $('#disapproval').show();
 }
});
</script>

<script>
$(document).ready(function(){
$('#reg_disapprove').hide();
$('#regdisapprove').click(function(){
        $('#reg_disapprove').show();
});
$('#regapprove').click(function(){
        $('#reg_disapprove').hide();
});
});

$(document).ready(function(){
      
    $("#category").on("change",function(){
        var val = $(this).val();

        if(val=="INTL"){
        $("#email_div").show();
        $("#pan_number_div").hide();
        }else{
        $("#pan_number_div").show();
        $("#email_div").hide();

        }
    });
});
</script>
<script>
    function imageAppear(id) { 
    document.getElementById(id).style.visibility = "visible";
    document.getElementById(id).style.height = "200px";
    document.getElementById(id).style.width = "auto";
    }
    function imageDisappear(id) { 
    document.getElementById(id).style.visibility = "hidden";}
</script>
<?php
$sqlreg1 = "SELECT * FROM registration_master where id='$registration_id'";
$res = $conn ->query($sqlreg1);
if($vals = $res->fetch_assoc())
{
$reg_approved = $vals['approval_status'];
}
?>
<script>
var reg_approv = '<?php echo $reg_approved; ?>';
$(document).ready(function(){
 if(reg_approv == 'D')
 {
 $('#reg_disapprove').show();
 }
});
</script>

<style type="text/css">
.style1 {color: #FF0000}
.style2 {
    font-size: 16px;
    font-weight: bold;
}
<?php if($_REQUEST['action']=='view') { ?>
#search{display:block;}
#page_ids{display:block;}
<?php  } else { ?>
#search{display:none;}
#page_ids{display:none;}
<?php } ?>

.blah{
    width: 100px;
    height: 100px;
}
.content_head{height: auto;}
.fancybox-button--zoom,.fancybox-button--play,.fancybox-button--thumbs,.fancybox-button--arrow_left,.fancybox-button--arrow_right,.fancybox-infobar{display:none!important;}
</style>
<style type="text/css">

.inner {/*  border: 1px solid #ccc;
*/
    border: 1px solid #ccc;
    border-collapse: separate;
    margin: 0;
    padding: 0;
    background: white;
    width: 50%;
    table-layout: fixed;
}
.inner tr {
background: #f8f8f8;
border: 1px solid #ddd;
padding: .35em;
}
.inner th,
.inner td {padding: .625em;text-align: left;padding: 10px 20px;}
.inner th {font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;}

</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
    <div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
    <div class="breadcome"><a href="admin.php">Home</a>
    <?php if($_REQUEST['actions']=='companyedit'){ ?> Covid details
    <?php } else { ?>/ COVID Vaccination Certificate <?php } ?></div>
</div>

<div id="main">
    <div class="content">
    
    <div class="content_head">
        <div style="float: left;">Manage Badge download report </div>
        <div style="float: right;">
      
        </div>
        <?php if($_REQUEST['action']=='covidApproval'){ ?>
        <div class="content_head_button" style="float: right;" >
            <a href="manage_visitor_badge_status_reports.php?action=view">Back</a>
        </div> 
        <?php } ?>
        <div class="clear"></div>
    </div>
    
<?php if($_REQUEST['action']=='view') { ?>
<div class="content_details1">
<?php 
    $sql5 = "select * from globalExhibition where 1 ";
    $result5 = $conn ->query($sql5);
    $total_application= $result5->num_rows;
    
    $downloaded_badges=0;
    $total_pending=0;
    $total_disapprove=0;
    $total_Badges=0;
    while($rows5 = $result5->fetch_assoc())
    {
        if($rows5['isVerified']=='1' && $rows5['status'] !=='D' )
        {
            $downloaded_badges=$downloaded_badges+1;

        }else if($rows5['isVerified']=='0' && $rows5['status'] !=='D')
        {
            $total_pending=$total_pending+1;

        }else if($rows5['status']=='D')
        {
            $total_disapprove=$total_disapprove+1;

        }
    }   
?>
          <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
            <tr class="orange1">
              <td colspan="11">Report Summary</td>
            </tr>
            <tr>
              <td><strong>Downloaded Badges</strong></td>
              <td><strong>Pending Badges</strong></td>
              <td><strong>Blocked Badges </strong></td>
              <td><strong>Total Badges</strong></td>
        
            </tr>
            <tr>
              <td><?php echo $downloaded_badges;?></td>
              <td><?php echo $total_pending;?></td>
              <td><?php echo $total_disapprove;?></td>
              <td><?php echo $total_application;?></td>
           
            </tr>
        </table>
      </div>
<?php } ?>


<div class="content_details1" id="search">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
if($errorMessage!=""){
echo "<span class='notification n-error'>".$errorMessage."</span>";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
 <tr>
<td><strong>Category</strong></td>        
    <td>
        <select name="category" id="category" class="input_txt-select">
        <option value="">Select Category</option>
        <option value="VIS" <?php if($_SESSION['category']=='VIS'){echo "selected='selected'";}?>>Jewellery</option>
        <option value="IGJME" <?php if($_SESSION['category']=='IGJME'){echo "selected='selected'";}?>>Machinery</option>
        <option value="INTL" <?php if($_SESSION['category']=='INTL'){echo "selected='selected'";}?>>International</option>
        <option value="VIP" <?php if($_SESSION['category']=='VIP'){echo "selected='selected'";}?>>VIP</option>
        <option value="VVIP" <?php if($_SESSION['category']=='VVIP'){echo "selected='selected'";}?>>VVIP</option>
        <option value="CM" <?php if($_SESSION['category']=='CM'){echo "selected='selected'";}?>>Committee</option>
        <option value="O" <?php if($_SESSION['category']=='O'){echo "selected='selected'";}?>>Organizer</option>
        <option value="G" <?php if($_SESSION['category']=='G'){echo "selected='selected'";}?>>Guest</option>
        <option value="P" <?php if($_SESSION['category']=='P'){echo "selected='selected'";}?>>Press</option>
        
        </select>
    </td>
</tr>


<td>&nbsp;</td>
<td>
    <input type="submit" name="Reset" value="Reset"  class="input_submit" />
    <input type="submit" name="request" value="Export" class="input_submit"/>
</td>
</tr>   
</table>
</form>      
</div>


</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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

<style>
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4);    
}
@keyframes modalFade {
  from {transform: translateY(-50%);opacity: 0;}
  to {transform: translateY(0);opacity: 1;}
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
     animation-name: modalFade;
  animation-duration: .6s;
}
.modal_inner_content{margin: 20px 10px;}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.form-horizontal{border: 1px solid #ccc;padding: 25px;margin-top: 10px;}
.form-control{width: 100%;margin-bottom: 15px;}
.form-control label{width: 150px;display: inline-block;}
.form-control input{width: auto;}
</style>
</body>
</html>