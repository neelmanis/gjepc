<?php 
session_start();
ob_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php
include('../db.inc.php');
include('../functions.php');
if($_REQUEST['Reset']=="Reset")
{
	$_SESSION['company_name']="";
	$_SESSION['unique_code']="";
	$_SESSION['hall_no']="";
	$_SESSION['gate_no']="";
	$_SESSION['category_search']="";
	$_SESSION['vehicle_no']="";  
  header("Location: car-passes_old.php?action=view");
} else { 
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{
	  $_SESSION['company_name']	=	filter($_REQUEST['company_name']);
	  $_SESSION['unique_code']	=	filter($_REQUEST['unique_code']);
	  $_SESSION['hall_no']		=	$_REQUEST['hall_no'];
	  $_SESSION['gate_no']	=	$_REQUEST['gate_no'];
	  $_SESSION['category_search']	=	$_REQUEST['category_search'];
	  $_SESSION['vehicle_no']	=	$_REQUEST['vehicle_no'];
	}
}
?>  

<?php 
if(($_REQUEST['action']=='reset') && ($_REQUEST['id']!=''))
{
	$id = filter(intval($_REQUEST['id']));
	$checkData = "SELECT isDataPosted FROM gjepclivedatabase.globalparking WHERE 1 and id='$id'" ;
	$resultData = $conn->query($checkData);
	$rows = $resultData->fetch_assoc();
	$isDataPosted = $rows['isDataPosted'];
		
	$sql = "update gjepclivedatabase.globalparking set isDataPosted='N' where id='$id'";
	$query = $conn ->query($sql);
	if($query) {
		echo "<meta http-equiv=refresh content=\"0;url=car-passes_old.php?action=view\">";
	} else {
		die ($conn->error);
	}	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Car Passes List</title>
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
	    alert('The date chosen is ' + date);
    }
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
	<div class="breadcome"><a href="admin.php">Home</a> >Car Passes List</div>
</div>

<div id="main">
    <div class="content">
    
        <div class="content_head"><a href="car-passes_old.php?action=view">
            <div class="content_head_button">Car Passes List</div></a>
            <!-- <a href="car-passes_old.php?action=add"><div class="content_head_button">Add Pass</div></a> -->
            <!--  -->
        </div>
            
            <div class="clear"></div>
            <?php if ($_REQUEST['action'] == 'view') { ?>
            <div class="content_details1">
                <form name="search" action="" method="POST"> 
                    <input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	
                    <?php
                    if ($_SESSION['succ_msg'] != "") {
                        echo "<span class='notification n-success'>" . $_SESSION['succ_msg'] . "</span>";
                        $_SESSION['succ_msg'] = "";
                    }
                    ?>
                    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
                        <tr class="orange1">
                            <td colspan="11" >Search Options</td>
                        </tr>
                        <tr>
                            <td><strong>Company Name</strong></td>
                            <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo filter($_SESSION['name']); ?>" /></td>
                        </tr>
                        <tr>
                            <td><strong>Unique Id</strong></td>
                            <td><input type="text" name="unique_code" id="unique_code" class="input_txt" value="<?php echo filter($_SESSION['unique_code']); ?>" /></td>
                        </tr>
                        <tr>
                            <td><strong>Category</strong></td>
                            <td>
                                <select name="category_search" id="category_search" class="input_txt">
                                    <option value="">Select Category</option>
                                    <option value="VIS" <?php echo isset($_SESSION['category_search']) && $_SESSION['category_search'] == "VIS" ? 'selected' : ''; ?>>Domestic Visitor</option>
                                    <option value="INTL" <?php echo isset($_SESSION['category_search']) && $_SESSION['category_search'] == "INTL" ? 'selected' : ''; ?>>International Visitor</option>
                                    <option value="E" <?php echo isset($_SESSION['category_search']) && $_SESSION['category_search'] == "E" ? 'selected' : ''; ?>>Exhibitor</option>
                                    <option value="O" <?php echo isset($_SESSION['category_search']) && $_SESSION['category_search'] == "O" ? 'selected' : ''; ?>>Organizer</option>
                                    <option value="VIP" <?php echo isset($_SESSION['category_search']) && $_SESSION['category_search'] == "VIP" ? 'selected' : ''; ?>>VIP</option>
                                    <option value="VVIP" <?php echo isset($_SESSION['category_search']) && $_SESSION['category_search'] == "VVIP" ? 'selected' : ''; ?>>VVIP</option>
                                    <option value="G" <?php echo isset($_SESSION['category_search']) && $_SESSION['category_search'] == "G" ? 'selected' : ''; ?>>Guest</option>
                                    <option value="S" <?php echo isset($_SESSION['category_search']) && $_SESSION['category_search'] == "S" ? 'selected' : ''; ?>>Service</option>
                                </select>
                            </td>   
                        </tr>
                        <tr>
                            <td><strong>Hall No</strong></td>
                            <td><input type="text" name="hall_no" id="hall_no" class="input_txt" value="<?php echo $_SESSION['hall_no']; ?>" /></td>
                        </tr>
                        <tr>
                            <td><strong>Gate No</strong></td>
                            <td><input type="text" name="gate_no" id="gate_no" class="input_txt" value="<?php echo filter($_SESSION['gate_no']); ?>" /></td>
                        </tr>
                        <tr>
                            <td><strong>Vehicle Number</strong></td>
                            <td><input type="text" name="vehicle_no" id="vehicle_no" class="input_txt" value="<?php echo filter($_SESSION['vehicle_no']); ?>" /></td>
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
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
                    <tr class="orange1">
                        <td width="7%" height="30">Reg ID</td>
                        <td width="7%">Unique Id</td>
                        <td width="7%">Category</td>
                        <td width="14%">Name</td>
                        <td width="5%">Hall No</td>
                        <td width="5%">Gate No</td>
                        <td width="10%">Car Pass</td>
                        <td width="10%">Ground No</td>
                        <td width="10%">Car Number</td>
                        <td width="5%">Status</td>
                        <td width="5%">Sync Status</td>
                        <td width="7%">Action</td>
                        <td width="7%">Pass</td>                        
                    </tr>
                        <?php
                            $page = 1; //Default page
                            $limit = 100; //Records per page
                            $start = 0; //starts displaying records from 0
                            
                            if (isset($_GET['page']) && $_GET['page'] != '') {
                                $page = $_GET['page'];
                            }
                            $start = ($page - 1) * $limit;
                            $sql = "select * from globalparking as a where agency_category = 'S' and `isGenerated`='N' ";
                            //hall_no = '1' and name != '' and `isGenerated`='N'
                            // if ($_SESSION['company_name'] != "") {
                            //     $sql .= " and a.name like '%" . $_SESSION['company_name'] . "%'";
                            // }
                            // if ($_SESSION['unique_code'] != "") {
                            //     $sql .= " and a.unique_code like '%" . $_SESSION['unique_code'] . "%'";
                            // }

                            // if ($_SESSION['hall_no'] != "") {
                            //     $sql .= " and a.hall_no like '%" . $_SESSION['hall_no'] . "%'";
                            // }

                            // if ($_SESSION['gate_no'] != "") {
                            //     $sql .= " and a.gate_no like '%" . $_SESSION['gate_no'] . "%'";
                            // }
                            // if ($_SESSION['category_search'] != "") {
                            //     $sql .= " and a.agency_category like '%" . $_SESSION['category_search'] . "%'";
                            // }
                            // if ($_SESSION['vehicle_no'] != "") {
                            //     $sql .= " and a.vehicle_no like '%" . $_SESSION['vehicle_no'] . "%'";
                            // }

                            $sql .= " group by a.id order by a.created_at desc";

                            $result = $conn->query($sql);

                            $rCount = $result->num_rows;
                            $sql1 = $sql . "  limit $start, $limit";
                            $result1 = $conn->query($sql1);

                            if ($rCount > 0) {
                                while ($rows = $result1->fetch_assoc()) { ?>
                                <tr>
                                    <form action="" method="POST">                                        
                                    <td><?php echo $rows['id']; ?></td>
                                    <td><?php echo filter($rows['unique_code']); ?></td>
                                    <td><?php echo filter($rows['agency_category']); ?></td>
                                    <td><?php echo filter($rows['name']); ?></td>
                                    <td><?php echo filter($rows['hall_no']); ?></td>
                                    <td><?php echo filter($rows['gate_no']); ?></td>
                                    <td><?php echo filter($rows['car_pass']); ?></td>
                                    <td><?php echo filter($rows['ground_no']); ?></td>
                                    <td><?php echo filter($rows['vehicle_no']); ?></td>
                                    <td>    
                                        <?php echo $rows['status']; ?>
                                        <!-- <select name="pass-status">
                                            <option <?php echo $rows['status'] == "Y" ? 'selected' : ''; ?>>Y</option>
                                            <option <?php echo $rows['status'] == "P" ? 'selected' : ''; ?>>P</option>
                                            <option <?php echo $rows['status'] == "D" ? 'selected' : ''; ?>>D</option>
                                        </select> -->
                                    </td>
                                    <td><?php echo filter($rows['isDataPosted']); ?></td>
                                    <td>
                                        <a  href="car-passes_old.php?action=update&uniquecode=<?php echo $rows['unique_code'] ?>" title="UPDATE"><img src="https://gjepc.org/admin/images/edit.gif" border="0"> 
                                        </a>&nbsp;
                                        <a href="car-passes_old.php?action=reset&id=<?php echo $rows['id'];?>"><img src="images/reset.png" title="Reset" border="0" width="16" height="16" /></a>  
                                    </td>
                                    <?php $i++ ?>
                                    <?php  if ($rows['isGenerated'] == "N") { ?>
                                        <td><a href="https://registration.gjepc.org/car-parking-qr-code.php?v=2.<?php echo $i; ?>&action=generatePassOld&unique_code=<?php echo $rows['unique_code']; ?>" target="_blank"> Download</a></td>
                                    <?php } ?>
                                </tr>
                                                    
                                <?php
                                    $i++;
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="10">Records Not Found</td>
                            </tr>                        
                        <?php } ?>  
                </table>
            </form>
            </div>  
            <?php
                function pagination($per_page = 10, $page = 1, $url = '', $total)
                {

                    $adjacents = "2";

                    $page = ($page == 0 ? 1 : $page);
                    $start = ($page - 1) * $per_page;

                    $prev = $page - 1;
                    $next = $page + 1;
                    $lastpage = ceil($total / $per_page);
                    $lpm1 = $lastpage - 1;

                    $pagination = "";
                    if ($lastpage > 1) {
                        $pagination .= "<ul class='pagination'>";
                        $pagination .= "<li class='details'>Page $page of $lastpage</li>";
                        if ($lastpage < 7 + ($adjacents * 2)) {
                            for ($counter = 1; $counter <= $lastpage; $counter++) {
                                if ($counter == $page)
                                    $pagination .= "<li><a class='current'>$counter</a></li>";
                                else
                                    $pagination .= "<li><a href='{$url}$counter'>$counter</a></li>";
                            }
                        } elseif ($lastpage > 5 + ($adjacents * 2)) {
                            if ($page < 1 + ($adjacents * 2)) {
                                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                    if ($counter == $page)
                                        $pagination .= "<li><a class='current'>$counter</a></li>";
                                    else
                                        $pagination .= "<li><a href='{$url}$counter'>$counter</a></li>";
                                }
                                $pagination .= "<li class='dot'>...</li>";
                                $pagination .= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
                                $pagination .= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";
                            } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                $pagination .= "<li><a href='{$url}1'>1</a></li>";
                                $pagination .= "<li><a href='{$url}2'>2</a></li>";
                                $pagination .= "<li class='dot'>...</li>";
                                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                    if ($counter == $page)
                                        $pagination .= "<li><a class='current'>$counter</a></li>";
                                    else
                                        $pagination .= "<li><a href='{$url}$counter'>$counter</a></li>";
                                }
                                $pagination .= "<li class='dot'>..</li>";
                                $pagination .= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
                                $pagination .= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";
                            } else {
                                $pagination .= "<li><a href='{$url}1'>1</a></li>";
                                $pagination .= "<li><a href='{$url}2'>2</a></li>";
                                $pagination .= "<li class='dot'>..</li>";
                                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                    if ($counter == $page)
                                        $pagination .= "<li><a class='current'>$counter</a></li>";
                                    else
                                        $pagination .= "<li><a href='{$url}$counter'>$counter</a></li>";
                                }
                            }
                        }

                        if ($page < $counter - 1) {
                            $pagination .= "<li><a href='{$url}$next'>Next</a></li>";
                            $pagination .= "<li><a href='{$url}$lastpage'>Last</a></li>";
                        } else {
                            $pagination .= "<li><a class='current'>Next</a></li>";
                            $pagination .= "<li><a class='current'>Last</a></li>";
                        }
                        $pagination .= "</ul>\n";
                    }
                    return $pagination;
                }
            ?>	
            <div class="pages_1">Total Number of Application: <?php echo $rCount; ?>
                <?php echo pagination($limit, $page, 'car-passes_old.php?action=view&page=', $rCount); //call function to show pagination?>
            </div>        
        <?php } ?> 
        
        <?php 
        //add request
        if(($_REQUEST['action']=='add')){ ?>
            <div class="content_details1">
                <form method="POST" name="form1" id="form1" action="https://registration.gjepc.org/car-parking-qr-code.php"  onsubmit="return checkdata()">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <input type="hidden" name="admin" value="<?php echo intval(filter($_SESSION['curruser_login_id'])) ?>" />
                        <tr class="orange1">
                            <td colspan="2">&nbsp;Add New Car Pass</td>
                        </tr>
                        <tr>
                            <td class="content_txt">Name: <span class="star">*</span></td>
                            <td><input type="text" name="name" id="name" title="Please enter  name" class="show-tooltip input_txt" value=""/></td>
                        </tr>  
                        <tr>
                            <td class="content_txt">Category <span class="star">*</span></td>
                            <td>
                                <select name="category" id="category">
                                    <option value="">Select Category</option>
                                    <option value="VIS">Domestic Visitor</option>
                                    <option value="INTL">International Visitor</option>
                                    <option value="EXH">Exhibitor</option>
                                    <option value="O">Organizer</option>
                                    <option value="VIP">VIP</option>
                                    <option value="VVIP">VVIP</option>
                                    <option value="G">Guest</option>
                                    <option value="S">Service</option>
                                    <!-- <option value="EXHM">Machinery Exhibitor</option>
                                    <option value="CONTR">Contractor/Agency</option>
                                    <option value="IGJME">IGJME</option> -->
                                </select>
                            </td>
                        </tr> 
                        <tr>
                            <td class="content_txt">Gate No :  <span class="star">*</span></td>
                            <td>
                                <select name="gate" id="gate" class="gate">
                                    <option value="">Select Gate</option>
                                        <?php $gateGet = $conn->query("SELECT * FROM gate_master WHERE `is_active`='1'"); 
                                        while($rowCat = $gateGet->fetch_assoc()){ ?>
                                            <option value="<?php echo $rowCat['gate'];?>"><?php echo $rowCat['gate_no'];?></option>
                                        <?php   }  ?>
                                </select>
                            </td>
                        </tr>  
                        <tr>
                            <td class="content_txt">Hall No : <span class="star">*</span></td>
                            <td>
                                <select name="hall_no" id="hall_no">
                                    <option value="">Select Hall No</option>  
                                    <?php $hallGet = $conn->query("SELECT * FROM hall_master WHERE `status`='Y' order by hall_desc"); 
                                        while($rowHall = $hallGet->fetch_assoc()){ ?>
                                            <option value="<?php echo $rowHall['hall_no'];?>"><?php echo $rowHall['hall_desc'];?></option>
                                        <?php   }  ?>
                                </select>     
                            </td>
                        </tr> 
                        <tr>
                            <td class="content_txt">Ground No : <span class="star">*</span></td>
                            <td>
                                <select name="ground_no" id="ground_no">
                                    <option value="">Select Ground No</option>  
                                </select>     
                            </td>
                        </tr> 
                        <tr>
                            <td valign="content_txt" class="content_txt">Status<span class="star">*</span></td>
                            <td>
                                <select name="status" id="status">
                                    <option value="">Select Status</option>
                                    <option value="P">Pending</option>
                                    <option value="Y">Approved</option>
                                    <option value="D">Disapproved</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="hidden" name="action" id="action" value="save" />
                                <input type="submit" value="Submit" class="input_submit"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>       
        <?php } ?>
                                   
        <?php if(isset($_REQUEST['action']) && ($_REQUEST['action']=='update')) { ?>
            <?php
                
                $unique_id = $_REQUEST['uniquecode'];
                $checkData="select * from globalparking where unique_code='$unique_id'";
                $resultData = $conn->query($checkData);
                $status_rows = $resultData->fetch_assoc();
                $update_name = $status_rows['name'];
                $vehicle_number = $status_rows['vehicle_no'];
                $gate_no = $status_rows['gate_no'];
                $area = $status_rows['area'];
                $hall_no = $status_rows['hall_no'];
                $ground_no = $status_rows['ground_no'];
                $update_category = $status_rows['category'];
                $update_status = $status_rows['status'];
                if(!isset($status_rows)){
                    echo '<script language="javascript">';
                    echo 'alert(Data Not Found)';  
                    echo '</script>';
                }
            ?>
            <div class="content_details1">
                <form method="POST" name="update-form" id="update-form" action="https://registration.gjepc.org/car-parking-qr-code.php"  onsubmit="return checkdata()">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <input type="hidden" name="admin" value="<?php echo intval(filter($_SESSION['curruser_login_id'])) ?>" />
                        <tr class="orange1">
                            <td colspan="2">&nbsp;Update Car Pass</td>
                        </tr>
                        <tr>
                            <td class="content_txt">Name: <span class="star">*</span></td>
                            <td><input type="text" name="update_name" id="update_name" title="Please enter name" class="show-tooltip input_txt" value="<?php echo isset($update_name) ? $update_name : ''; ?>"/></td>
                        </tr>  
                        <!-- <tr>
                            <td class="content_txt">Category <span class="star">*</span></td>
                            <td>
                                <select name="category" id="category">
                                    <option value="">Select Category</option>
                                    <option value="VIS" <?php echo isset($update_category) && $update_category == "VIS" ? 'selected' : ''; ?>>Domestic Visitor</option>
                                    <option value="INTL" <?php echo isset($update_category) && $update_category == "INTL" ? 'selected' : ''; ?>>International Visitor</option>
                                    <option value="EXH" <?php echo isset($update_category) && $update_category == "EXH" ? 'selected' : ''; ?>>Exhibitor</option>
                                    <option value="O" <?php echo isset($update_category) && $update_category == "O" ? 'selected' : ''; ?>>Organizer</option>
                                    <option value="VIP" <?php echo isset($update_category) && $update_category == "VIP" ? 'selected' : ''; ?>>VIP</option>
                                    <option value="VVIP" <?php echo isset($update_category) && $update_category == "VVIP" ? 'selected' : ''; ?>>VVIP</option>
                                    <option value="G" <?php echo isset($update_category) && $update_category == "G" ? 'selected' : ''; ?>>Guest</option>
                                    <option value="S" <?php echo isset($update_category) && $update_category == "S" ? 'selected' : ''; ?>>Service</option>
                                </select>
                            </td>
                        </tr>  -->
                        <tr>
                            <td class="content_txt">Vehicle Number: <span class="star">*</span></td>
                            <td><input type="text" name="vehicle_number" id="vehicle_number" title="Please Vehicle Number" class="show-tooltip input_txt" style="text-transform:uppercase;" value="<?php echo isset($vehicle_number) ? $vehicle_number : ''; ?>"/></td>
                        </tr> 
                        <tr>
                            <td class="content_txt">Gate No :  <span class="star">*</span></td>
                            <td>
                                <select name="gate" id="gate" class="gate">
                                    <option value="">Select Gate</option>
                                        <?php $gateGet = $conn->query("SELECT * FROM gate_master WHERE `is_active`='1'"); 
                                        while($rowCat = $gateGet->fetch_assoc()){ ?>
                                            <option value="<?php echo $rowCat['gate']; ?>" <?php echo $rowCat['gate'] == $gate_no ? 'selected' : ''; ?>><?php echo $rowCat['gate_no'];?></option>
                                        <?php   }  ?>
                                </select>
                            </td>
                        </tr>  
                        <tr>
                            <td class="content_txt">Hall No : <span class="star">*</span></td>
                            <td>
                                <select name="hall_no" id="hall_no">
                                    <option value="">Select Hall No</option>  
                                    <?php $hallGet = $conn->query("SELECT * FROM hall_master WHERE `status`='Y' order by hall_desc"); 
                                        while($rowHall = $hallGet->fetch_assoc()){ ?>
                                            <option value="<?php echo $rowHall['hall_no']; ?>" <?php echo $rowHall['hall_no'] == $hall_no ? 'selected' : ''; ?>><?php echo $rowHall['hall_desc'];?></option>
                                        <?php   }  ?>
                                </select>     
                            </td>
                        </tr> 
                        <tr>
                            <td class="content_txt">Ground No : <span class="star">*</span></td>
                            <td>
                                <select name="ground_no" id="ground_no" class="ground_no">
                                    <option value="">Select Ground No</option>  
                                    <?php $gateGet = $conn->query("SELECT * FROM gate_master WHERE `is_active`='1'"); 
                                        while($rowCat = $gateGet->fetch_assoc()){ ?>
                                            <option value="<?php echo $rowCat['ground_no']; ?>" <?php echo $rowCat['ground_no'] == $ground_no ? 'selected' : 'disabled'; ?>><?php echo $rowCat['ground_no'];?></option>
                                        <?php   }  ?>
                                   
                                </select>     
                            </td>
                        </tr> 
                        <tr>
                            <td valign="content_txt" class="content_txt">Status<span class="star">*</span></td>
                            <td>
                                <select name="status" id="status">
                                    <option value="">Select Status</option>
                                    <option value="P" <?php echo isset($update_status) && $update_status == "P" ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Y" <?php echo isset($update_status) && $update_status == "Y" ? 'selected' : ''; ?>>Approved</option>
                                    <option value="D" <?php echo isset($update_status) && $update_status == "D" ? 'selected' : ''; ?>>Disapproved</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="hidden" name="unique_code" id="unique_code" value="<?php echo $unique_id; ?>" />
                                <input type="hidden" name="action" id="action" value="update" />
                                <input type="submit" value="Submit" class="input_submit"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        <?php } ?>
        
    </div>
</div>
   



<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script language="javascript">
    //$(document).ready(function(e){
        
        $(".gate").change(function(e){
            e.preventDefault();
            
            var gate_no = $(".gate").val();
            if(gate_no == null || gate_no == undefined || gate_no == ""){
                return false;
            }   
            $.ajax({
                url: "car-passes_old-ajax.php?action=getGround",
                method:"POST",
                dataType:"json",
                data:{"gate_no":gate_no},
                type: "POST",
                success:function(data)
                {
                    //console.log(data.status);
                    // $('#ground_no').children().remove().end() 
                    $('.ground_no').children().remove().end()
                    if(data.status == "success"){
                        let ground_no = data.ground_no;
                        $(".ground_no").append('<option value="'+ground_no+'" "selected">'+ground_no+'</option>');
                    }if(data.status == "fail"){
                        window.location.reload(true);
                    }
                    console.log(data);
                },
            });
        })
    //})
    // $("#update-status").on('click',function(e){
        
    //     e.preventDefault();
    //     let unique_code = $(this).attr("#data-id");
    //     alert(unique_code);
    //     if(unique_code == null || unique_code == undefined || unique_code == ""){
    //         return false;
    //     }   
    //     $.ajax({
    //         url: "car-passes_old-ajax.php?action=updateStatus",
    //         method:"POST",
    //         dataType:"json",
    //         data:{"unique_code":unique_code},
    //         type: "POST",
    //         success:function(data)
    //         {
    //             //console.log(data.status);
    //             $('#ground_no').children().remove().end() 
    //             if(data.status == "success"){
    //                 let ground_no = data.ground_no;
    //                 $("#ground_no").append('<option value="'+ground_no+'" "selectd">'+ground_no+'</option>');
    //             }if(data.status == "fail"){
    //                 window.location.reload(true);
    //             }
    //             console.log(data);
    //         },
    //     });
    // })

    function checkdata()
    {
        // if(document.getElementById('name').value == '')
        // {
        //     alert("Please Enter Name");
        //     document.getElementById('name').focus();
        //     return false;
        // }
        
        if(document.getElementById('category').value == '')
        {
            alert("Please Select Category.");
            document.getElementById('category').focus();
            return false;
        }
        if(document.getElementById('hall_no').value == '')
        {
            alert("Please Select Hall No.");
            document.getElementById('hall_no').focus();
            return false;
        }
        
        if(document.getElementById('gate').value == '')
        {
            alert("Please Select Gate No.");
            document.getElementById('gate').focus();
            return false;
        }
        
        if(document.getElementById('ground_no').value == '')
        {
            alert("Please Select Ground No.");
            document.getElementById('ground_no').focus();
            return false;
        }
            
    }


    

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
