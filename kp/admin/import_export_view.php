<?php session_start(); 
 
?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php 
	
if(isset($_POST['action']))
{ //echo"<pre>";print_r($_POST);exit;
	$erp_id=$_POST['erp_id'];
	$role=$_POST['role'];
	$logged_in_user=$_POST['logged_in_user'];
	$bank_id=$_POST['bank_id'];
	$approve=$_POST['approve'];
	$curr_date =date('Y-m-d');
	$mode=$_POST['chkPassPort'];
	$partamt=$_POST['partamount'];
	
	$sql.="update kp_admin_erpweb set ";
	if($role=="bank"){
		$sql.=" approved_by_bank='$logged_in_user'";
		$sql.=" ,approved_bank_date='$curr_date'";
		$sql.=" ,payment_type='$mode'";
		$sql.=" ,part_amount='$partamt'";

		}
	if($role=="custom"){
		$sql.=" approved_by_custom='$logged_in_user'";
		$sql.=" ,approved_custom_date='$curr_date'";
		}
		
	$sql.=" where id='$erp_id'";
	
	if($approve=="Y")
	{
		mysql_query($sql);
		header('location:import_export_view.php?action=view');
	}
	else
	{
		echo '<script language="javascript">alert("sorry !! please check the information.");location.href="import_export_view.php?action=view";</script>';
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Welcome to GJEPC</title>
					<link rel="stylesheet" type="text/css" href="css/style.css" />
		 </head>
<!--navigation-->
<script type="text/javascript" src="js/jquery.min.js"></script>   
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
});
</script>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"/>
<script type="text/javascript">
/*$(document).ready(function() {
    $('#example').DataTable({
    "bLengthChange": false,
	"iDisplayLength": 10
	});
});*/
</script>
<script type="text/javascript">
    $(function () {
        $("input[name='chkPassPort']").click(function () {
            if ($("#chkYes").is(":checked")) {
                $("#dvPassport").show();
            } else {
                $("#dvPassport").hide();
            }
        });
    });
</script>

<script>
$(document).ready(function(){
	$("#submit2").click(function(){ 
		var p = $("#applicationtype").val();
		var q = $("#importname").val();
		var r = $("#exportname").val();
		var s = $("#kpno").val();
		// Returns successful data submission message when the entered information is stored in database.
		//var dataString = 'applicationtype1='+ p + '&importname='+ q + '&exportname='+ r + '&kpno='+ s;
		var dataString=$('#searchForm').serialize();
		//alert(dataString);
		//alert(q.length);
		if(p==''||q==''||r==''||s=='')
		{
			alert("Please Fill All Fields");
		}
		else if((q.length<3) || (r.length<3))
		{
			alert("Please Fill add minimum 3 characters for import/export name");
		}
		else
		{
			// AJAX Code To Submit Form.
			$.ajax({
			type: "POST",
			url: "importdetails.php",
			data: dataString,
			cache: false,
			success: function(result){
			//alert(result);
			$('#ajaxTable').html(result);
			}
			});
		}
		return false;
	});
});
</script>


<!--navigation end-->
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
   
<body><div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > ImportExport View</div>
</div>
<div id="main">
	<div class="content">
   
 
		<!--	for view details-->
 		<?php if($_REQUEST['action'] == 'viewdetail' )
		{	
		
	   		$erp_id = $_REQUEST['erp_id'];
			
			$curruser_login_id = $_SESSION['curruser_login_id'];
			$res = mysql_query("SELECT kpno,carat,amount,importername,importeraddress,exportername,exporteraddress,region,applicationtype,DATE_FORMAT(postingdate,'%d %M %Y ') as postingdate,DATE_FORMAT(issuedate,'%d %M %Y ') as issuedate,membershipstatus,approved_by_bank,part_amount,payment_type,approved_by_custom FROM kp_admin_erpweb where id = '$erp_id'"  );
			$row = mysql_fetch_array($res);	
				
			?>  
             <a href="import_export_view.php?action=view">Back</a>
     
          <form name="ieVerfication" action="" method="post"  />
            <table width="50%" border="1"  align="center" />
            <th colspan="2"> VIEW IMPORT AND EXPORT DETAILS</th>
             <tr>
                <td>Kpno:</td>
                <td><?php echo $row[0]; ?></td>
              </tr>
             <tr>
                <td>Carat:</td>
                <td><?php echo $row[1]; ?></td>
              </tr>
              <tr>
                <td>Amount:</td>
                <td><?php echo $row[2]; ?></td>
              </tr>
              <tr>
                <td>Foreign Party:</td>
                <td><?php echo $row[3]; ?></td>
              </tr>
              <tr>
                <td>Importer address:</td>
                <td><?php echo $row[4]; ?></td>
              </tr>
              <tr>
                <td>Indian Party:</td>
                <td><?php echo $row[5]; ?></td>
              </tr>
              <tr>
                <td>Exporter Address:</td>
                <td><?php echo $row[6]; ?></td>
              </tr>
             
              <tr>
                <td>Region:</td>
                <td><?php echo $row[7]; ?></td>
              </tr>
               <tr>
                <td> Application type:</td>
                <td><?php echo $row[8]; ?></td>
              </tr>
               <tr>
                <td> postingdate :</td>
                <td><?php echo $row[9]; ?></td>
              </tr>
              <tr>
                <td> Issue date :</td>
                <td><?php echo $row[10]; ?></td>
              </tr>
              <tr>
                <td>Membership:</td>
                <td><?php echo $row[11]; ?></td>
              </tr>  
               
               
      <?php if( $_SESSION['curruser_role']== "Super Admin" ){?>
               
             <?php  
			 if( $row[12]!= '0' ) {?>
           <tr>
           <td colspan="2">This Information has been Approved By <?php echo getAdminName($row[12] );?></td>
           </tr>
              <?php  } elseif($row[13]!= '0') { ?>
            <tr>
            <td colspan="2">This Information has been Approved By<?php echo getAdminName($row[13]);?></td>
            </tr>
            <?php } else {?>
               <tr>
                <td colspan="2">This Information has Not been Approved.</td>
                </tr> 
          <?php } 
	}?>      
                 
            <?php if($_SESSION['curruser_role']=="bank"){?>
           
            <?php if($row[12]== 0) {?>
            <tr>
                 <td>Payment:</td>
                <td>
             <input type="radio" id="chkYes" name="chkPassPort" value="part"/>Part
              <input type="radio" id="chkNo" name="chkPassPort" value="full"/>Full
              <div id="dvPassport" style="display: none">
    		<input type="text" id="partamount" name="partamount" placeholder="Enter Amount"/>
			</div>
               </td>
              </tr>   
              <tr>
                <td>Approve</td>
                <td><input type="checkbox" name="approve" value="Y" /></td>
              </tr>
              <tr>
             <td  align="center" colspan="2"><input type="submit" name="submit" value="Submit" onsubmit="return validateForm()" /></td>
                </tr>
              <?php  }else {
			  ?>
                 <tr>
                <td>Payment Mode:</td>
                <td><?php echo $row[14]; ?></td>
              </tr>  
               <tr>
                <td>Balance Amount :</td>
                <td>
					<?php
                        $q=$row[14];
                   
                        $a=str_replace(',','',$row[2]);
                        $b=floatval($a);
                        $c=str_replace(',','',$row[12]);
                        $d=floatval($c);
                        $xyz=($b)-($d);	
						if($q=='part'){
                        echo $xyz; }else {
						$xyz=0; 
						echo $xyz;
						} ?>
					</td>
					 
					
		            </tr> 
			   <tr>
                <td colspan="2">This Information has been Approved By <?php echo getAdminName($row['12'] );?> </td>
              </tr>
			 <?php }}?>
              
              <?php if($_SESSION['curruser_role']=="custom"){?>
           
            <?php if($row[13]== 0) {?>
            
              <tr>
                <td>Approve</td>
                <td><input type="checkbox" name="approve" value="Y" /></td>
              </tr>
              <tr>
             <td  align="center" colspan="2"><input type="submit" name="submit" value="Submit" onsubmit="return validateForm()" />				</td>
                </tr>
              <?php  }else { ?>
			   <tr>
                <td colspan="2">This Information has been Approved By <?php echo getAdminName( $row['13'] );?> </td>
              </tr>
			 <?php }}
			 //echo $curruser_login_id;
			 $bank_id=getNonMemberBankid($curruser_login_id); 
			 ?>
            <input type="hidden" name="logged_in_user" value="<?php echo $curruser_login_id;?>"/>
            <input type="hidden" name="role" value="<?php echo $_SESSION['curruser_role'];?>"/>
            <input type="hidden" name="erp_id" value="<?php echo $erp_id;?>"/>
            <input type="hidden" name="bank_id" value="<?php echo $bank_id;?>"/>
           <input type="hidden" name="amount" value="<?php  echo getamount($erp_id);?>"/>
		   <input type="hidden" name="id" value="<?php echo $row[12]; ?>"/>
               <input type="hidden" name="bank_name" value="<?php echo getBank($bank_id);?>"/>
            <input type="hidden" name="action" value="save"/>

            </table>
          </form>

<?php 	} ?>




	<!--For view  table -->
<?php if($_REQUEST['action']=='view') {?> 
<div id="mainform">  
  <form name="searchh" id="searchForm">
          
            <p align="center">Application type:
            <select name="applicationtype" id="applicationtype"  />
            <option value="select">select</option>
            <option value="Import" >Import</option>
            <option value="Export" >Export</option>
            </select> <br />
            
      	Indian Party :<input type="text" name="exportname" id="exportname"><br/>
        Foreign Party :  <input type="text" name="importname" id="importname"><br />
        
            <p>
      <div align="center">
          kpno:<input type="text" name="kpno" id="kpno" title="Please enter your kpno"/></br>
            <input type="button" name="submit2" id="submit2" value="submit"  style="margin-top:13px;"  />
            <button type="reset" value="Reset">Reset</button>     
            </p>
        <div align="center"></div>
      </div>
            <div align="center"></div>
            <div align="center"></div>
            <div align="center"></div>
  </form>
  </div>
  
  
  <div id="ajaxTable"></div>
<?php } ?>
</div>
</div>
 </div>
<div id="footer_wrap">
	Developed by <a href="http://kwebmaker.com/" target="_blank">K Webmaker™</a>
</div>
</body>
</html>