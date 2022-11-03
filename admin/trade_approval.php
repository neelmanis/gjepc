<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php 
$registration_id	=	intval($_REQUEST['registration_id']);
$app_id	=	intval($_REQUEST['app_id']);
$app_detail = fetch('select * from trade_general_info where app_id='.$app_id) ;
$exhibition_type=getExhibitionType($_REQUEST['app_id'],$conn);
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

<script type="text/javascript">
$(document).ready(function(){
		//alert('hello');
		$('#customer_add').change(function(){
				//alert($( this ).val());
				var option = $(this).val();
				var reg_id =$('#registration_id').val();
			
			  $.ajax({ type: 'POST',
					url: 'ajax_trade.php',
					data: "actiontype=optionValue&&option="+option+"&&reg_id="+reg_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
						 if($.trim(data)!=""){
							 //$('#selected_area').html(data);
							 data=data.split("#");
							 $("#member_name").val(data[0]);
							  $("#address1").val(data[1]);
							   $("#address2").val(data[2]);
							   $("#city").val(data[3]);
							   $("#pincode").val(data[4]);
							 
						 }
					}
		});
	});
});
	function validate()
	{
		var permission_no =  $("#permission_no").val();
		var membership_id =  $("#membership_id").val();
		if(membership_id=='')
		{
			alert('Please Enter Membership Id');
			$("#membership_id").focus();
			return false;
		}
		var customer_add =  $("#customer_add").val();
		var permission_type =  $("#permission_type").val();
		if(permission_type=='')
		{
			alert('Please select permission type');
			return false;
		}else if(permission_type=='promotional_tour' || permission_type=='person_hand')
		{
			var visiting_countries1 =  $("#visiting_countries1").val();
			if(visiting_countries1=='')
			{
				alert('Please Enter visiting countries1');
				$("#visiting_countries1").focus();
				return false;
			}
		var city1 =  $("#city1").val();
		if(city1=='')
		{
		alert('Please Enter city1');
		$("#city1").focus();
		return false;
		}
		}		
		
		var item1 =  $("#item1").val();
		if(item1=='')
		{
			alert('Please Enter Item1');
			$("#item1").focus();
			return false;
		}
	
		var bank_name =  $("#bank_name").val();
		if(bank_name=='')
		{
			alert('Please Enter Bank Name');
			$("#bank_name").focus();
			return false;
		}
			
		var bank_branch =  $("#bank_branch").val();
		if(bank_branch=='')
		{
			alert('Please Enter Bank Branch');
			$("#bank_branch").focus();
			return false;
		}		
		if(permission_type=='promotional_tour')	
		{
			var person_name_carrying =  $("#person_name_carrying").val();
			if(person_name_carrying=='')
			{
				alert('Please Enter Person name carrying');
				$("#person_name_carrying").focus();
				return false;
			}	
			var passport_no =  $("#passport_no").val();
			if(passport_no=='')
			{
				alert('Please Enter Passport No');
				$("#passport_no").focus();
				return false;
			}	
			
				var date_of_daparture =  $("#date_of_daparture").val();
				if(date_of_daparture=='')
				{
					alert('Please Enter Date of Departure');
					$("#date_of_daparture").focus();
					return false;
				}	
			}
			
			var region_code =  $("#region_code").val();
			if(region_code=='')
			{
				alert('Please Enter Region code');
				$("#region_code").focus();
				return false;
			}
			var from_date =  $("#from_date").val();
			if(from_date=='')
			{
				alert('Please Enter From date');
				$("#from_date").focus();
				return false;
			}
			
			var to_date =  $("#to_date").val();
			if(to_date=='')
			{
				alert('Please Enter To date');
				$("#to_date").focus();
				return false;
			}		
			
			var date_of_data_entry =  $("#date_of_data_entry").val()
			if(date_of_data_entry=='')
			{
				alert('Please Enter Date Of Data Entry');
				$("#date_of_data_entry").focus();
				return false;
			}	
		
			var application_date =  $("#application_date").val();
			if(application_date=='')
			{
				alert('Please Enter application date');
				$("#application_date").focus();
				return false;
			}
			
			var no_of_orders =  $("#no_of_orders").val();
			if(no_of_orders=='')
			{
				alert('Please Enter Number of orders');
				$("#no_of_orders").focus();
				return false;
			}  			
	}
</script>
 
 <script>
$(document).ready(function(){
		//alert('hello');
		$('#permission_type').change(function(){
				//alert($( this ).val());
				 var p_type = $(this).val();
				//var p_type =$('#premission_type').val();
				if(p_type=="exhibition")
				{
					$("#visiting_countries1").attr("disabled", "disabled");
					$("#city1").attr("disabled", "disabled");
					$("#visiting_countries2").attr("disabled", "disabled");
					$("#city2").attr("disabled", "disabled");
					$("#visiting_countries3").attr("disabled", "disabled");
					$("#city3").attr("disabled", "disabled");
					$("#visiting_countries4").attr("disabled", "disabled");
					$("#city4").attr("disabled", "disabled");
					$("#visiting_countries5").attr("disabled", "disabled");
					$("#city5").attr("disabled", "disabled");
					$("#visiting_countries6").attr("disabled", "disabled");
					$("#city6").attr("disabled", "disabled");
					$("#reg_brand_name_of_j").attr("disabled", "disabled");
					$("#reg_brand_name_of_a").attr("disabled", "disabled");
					$("#address_of_place_of_dis").attr("disabled", "disabled");
					$("#type_of_good").attr("disabled", "disabled");
					$("#person_name_carrying").attr("disabled", "disabled");
					$("#passport_no").attr("disabled", "disabled");
					$("#date_of_daparture").attr("disabled", "disabled");
				}else if(p_type=="branded_jewellery")
				{
					$("#visiting_countries1").attr("disabled", "disabled");
					$("#city1").attr("disabled", "disabled");
					$("#visiting_countries2").attr("disabled", "disabled");
					$("#city2").attr("disabled", "disabled");
					$("#visiting_countries3").attr("disabled", "disabled");
					$("#city3").attr("disabled", "disabled");
					$("#visiting_countries4").attr("disabled", "disabled");
					$("#city4").attr("disabled", "disabled");
					$("#visiting_countries5").attr("disabled", "disabled");
					$("#city5").attr("disabled", "disabled");
					$("#visiting_countries6").attr("disabled", "disabled");
					$("#city6").attr("disabled", "disabled");
					$("#reg_brand_name_of_j").attr("disabled", "disabled");
					$("#reg_brand_name_of_a").attr("disabled", "disabled");
					$("#address_of_place_of_dis").attr("disabled", "disabled");
					$("#type_of_good").attr("disabled", "disabled");
					$("#person_name_carrying").attr("disabled", "disabled");
					$("#passport_no").attr("disabled", "disabled");
					$("#date_of_daparture").attr("disabled", "disabled");
				}else if(p_type=="promotional_tour")
				{
					$("#visiting_countries1").removeAttr('disabled');
					$("#city1").removeAttr('disabled');
					$("#visiting_countries2").removeAttr('disabled');
					$("#city2").removeAttr('disabled');
					$("#visiting_countries3").removeAttr('disabled');
					$("#city3").removeAttr('disabled');
					$("#visiting_countries4").removeAttr('disabled');
					$("#city4").removeAttr('disabled');
					$("#visiting_countries5").removeAttr('disabled');
					$("#city5").removeAttr('disabled');
					$("#visiting_countries6").removeAttr('disabled');
					$("#city6").removeAttr('disabled');
					$("#reg_brand_name_of_j").attr("disabled", "disabled");
					$("#reg_brand_name_of_a").attr("disabled", "disabled");
					$("#address_of_place_of_dis").attr("disabled", "disabled");
					$("#address_of_place_of_dis").attr("disabled", "disabled");
					$("#type_of_good").removeAttr('disabled');
					$("#person_name_carrying").removeAttr('disabled');
					$("#passport_no").removeAttr('disabled');
					$("#date_of_daparture").removeAttr('disabled');
				}else
				{
					$("#visiting_countries1").removeAttr('disabled');
					$("#city1").removeAttr('disabled');
					$("#visiting_countries2").removeAttr('disabled');
					$("#city2").removeAttr('disabled');
					$("#visiting_countries3").removeAttr('disabled');
					$("#city3").removeAttr('disabled');
					$("#visiting_countries4").removeAttr('disabled');
					$("#city4").removeAttr('disabled');
					$("#visiting_countries5").removeAttr('disabled');
					$("#city5").removeAttr('disabled');
					$("#visiting_countries6").removeAttr('disabled');
					$("#city6").removeAttr('disabled');
					$("#reg_brand_name_of_j").attr("disabled", "disabled");
					$("#reg_brand_name_of_a").attr("disabled", "disabled");
					$("#address_of_place_of_dis").attr("disabled", "disabled");
					$("#address_of_place_of_dis").attr("disabled", "disabled");
					$("#type_of_good").attr("disabled", "disabled");
					$("#person_name_carrying").attr("disabled", "disabled");
					$("#passport_no").attr("disabled", "disabled");
					$("#date_of_daparture").attr("disabled", "disabled");					
				}		
		
		});
	});
</script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#from_date').datepick();
	$('#to_date').datepick();
	$('#date_of_daparture').datepick();
	$('#date_of_data_entry').datepick();
	$('#passport_issue_date').datepick();
	$('#passport_expiry_date').datepick();
});
</script>
<script>
	
</script>

<link rel="stylesheet" type="text/css" href="css/trade_approval.css"/>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Trade permission</div>
</div>

<div id="main">
	<div class="content">

<form action="trade_approval_action.php" method="post" id="trade_permission" name="trade_permission" onsubmit="return validate();">
<!-- Right Table -->
<div class="righttable_css">

<div class="padding_width_head">General Info </div>
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}

if($_SESSION['form_chk_msg']!="" || $_SESSION['form_chk_msg1']!="" || $_SESSION['form_chk_msg2']!=""){
echo "<span class='notification n-attention'>";
if($_SESSION['form_chk_msg']!=""){
echo $_SESSION['form_chk_msg']."<br>";
}
if($_SESSION['form_chk_msg1']!=""){
echo $_SESSION['form_chk_msg1']."<br>";
}
if($_SESSION['form_chk_msg2']!=""){
echo $_SESSION['form_chk_msg2'];
}
echo "</span>";
$_SESSION['form_chk_msg']="";
$_SESSION['form_chk_msg1']="";
$_SESSION['form_chk_msg2']="";
}
?>
<div class="dotet_line"></div>
<div class="padding_width">
<div class="admin_trade_wrap">
	<div class="trade_wrap">
    	<div class="trade_title">
        	<ul>
            	<li class="active"><a href="#">General</a></li>
                <?php if($exhibition_type=="exhibition" || $exhibition_type==""){?>
                <li><a href="trade_exhibition.php?app_id=<?php echo $_REQUEST['app_id']; ?>&&registration_id=<?php echo $_REQUEST['registration_id'];?>">Exhibition</a></li>
                <?php }?>
                <li><a href="trade_approval_documents.php?app_id=<?php echo $_REQUEST['app_id'];?>&&registration_id=<?php echo $_REQUEST['registration_id']; ?>">Documents</a></li>                
            </ul>
        </div>
        <div class="trade_form">
        	<div class="left">
            <div class="trade_form_field">
            		<div class="trade_lable">Application Date</div>
                    <div class="trade_input1"><input type="text" class="trade_input_text1" name="application_date" id="application_date" value="<?php echo $app_detail[0]['application_date'];?>" readonly="readonly"></div>
            	</div>
                 <div class="clear"></div>
            	<div class="trade_form_field">
            		<div class="trade_lable">Premission No.</div>
                    <div class="trade_input"><input type="text" class="trade_input_text " name="permission_no" id="permission_no" value="<?php echo $app_detail[0]['permission_no'] ; ?>"></div>
            	</div>
                <div class="clear"></div>
				<?php
				$sql_add = "select * from registration_master where id='$registration_id'";
				$query_add = $conn ->query($sql_add);
				$ans_add = $query_add->fetch_assoc();
				$memID = $app_detail[0]['membership_id'];
				if($memID!='')
				{
					$memID = $app_detail[0]['membership_id'];
				} else {
					$memID = $ans_add['gcode'];
				}				
                ?>
                <div class="trade_form_field">
            		<div class="trade_lable">Membership Id.</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="membership_id" id="membership_id" value="<?php echo $memID ;  ?>"></div>
            	</div>
                
                <div class="clear"></div>
				<?php
            	$comm_sql = "select * from communication_address_master where registration_id=?";
            	$stmtx = $conn -> prepare($comm_sql);
				$stmtx->bind_param("i", $registration_id);
				$stmtx -> execute();
				$resultx = $stmtx->get_result();
				?>
                <div class="trade_form_field">
            		<div class="trade_lable">Customer Address</div>
                    <div class="trade_input">
                    <select name="customer_add" id="customer_add" class="trade_input_text ">
                        <option value="">---------- Select ----------</option>
                        <?php while($row_add = $resultx->fetch_assoc()) { ?>
                        <option value="<?php echo $row_add['id'];?>" <?php if($app_detail[0]['type_of_address'] ==$row_add['type_of_address']) echo 'selected="selected"'; ?>><?php echo $row_add['address1'];?></option>
                        <?php } ?>                                            
                    </select>
                    </div>
            	</div>
            
            <div class="clear"></div>
                <div class="trade_form_field">
            	<div class="trade_lable">Member Name</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="member_name" id="member_name"  value="<?php echo $app_detail[0]['member_name'] ; ?>"></div>
            	</div>                
                <div class="clear"></div>                 
                <div class="trade_form_field">
            	<div class="trade_lable">Address</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="address1" id="address1" value="<?php echo $app_detail[0]['address1']; ?>" ></div>
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">Address2</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="address2" id="address2" value="<?php echo $app_detail[0]['address2']; ?>"></div>
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
				<div class="trade_lable">Pin Code</div>
                <div class="trade_input1"><input type="text" class="trade_input_text1" name="pincode" id="pincode" value="<?php echo $app_detail[0]['pincode'] ; ?>" maxlength="6"></div>
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">City</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="city" id="city" value="<?php echo $app_detail[0]['city'];?>"></div>
            	</div>                
                <div class="clear"></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable">Email</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="email" id="email" value="<?php echo $ans_add['email_id']; ?>"></div>
            	</div>                
                 <div class="clear"></div>
				 
                 <div class="trade_form_field">
            		<div class="trade_lable">Communication Email-Id</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="commemail" id="commemail" value="<?php echo $app_detail[0]['commemail']; ?>"></div>
            	</div>
                
                 <div class="clear"></div>
                    <div class="trade_form_field">
            		<div class="trade_lable">Premission Type</div>
                    <div class="trade_input">
                    <select name="permission_type" id="permission_type" class="trade_input_text ">
                    <option value="">---------- Select ----------</option>
                    <option value="promotional_tour" <?php if($app_detail[0]['permission_type']=="promotional_tour") echo 'selected="selected"' ; ?>>Promotional  Tour</option>
                    <option value="exhibition" <?php if($app_detail[0]['permission_type']=="exhibition") echo 'selected="selected"' ; ?> >Exhibition</option>
                    <option value="branded_jewellery" <?php if($app_detail[0]['permission_type']=="branded_jewellery") echo 'selected="selected"' ; ?>>Branded Jewellery</option>
                    <option value="person_hand" <?php if($app_detail[0]['permission_type']=="person_hand") echo 'selected="selected"' ; ?> >Person & Hand </option>
					</select>
                    </div>
            	</div>
            <div class="clear"></div>
            <?php if($app_detail[0]['permission_type']!="exhibition"){ ?>
            <div class="trade_form_field">
            		<div class="trade_lable">Visiting Countries1</div>
                    <div class="trade_input">
                    <select name="visiting_country1" id="visiting_country1" class="trade_input_text">
                        <option value="">---------- Select ----------</option>
                        <?php
                        $sql_country = "select * from country_master  where status=1";
                        $query_country = $conn ->query($sql_country);
                        while($result_country = $query_country->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result_country['country_code']; ?>" <?php if($result_country['country_code']==$app_detail[0]['visiting_country1']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];  ?></option>
                        <?php } ?>
                    </select>
                    </div>
            	</div>
                
                 <div class="clear"></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable">City1</div>
                    <div class="trade_input"><input type="text" class="trade_input_text " name="city1" id="city1"  value="<?php echo $app_detail[0]['city1'] ; ?>"></div>
            	</div>
                
                 <div class="clear"></div>
                 
                   <div class="trade_form_field">
            		<div class="trade_lable">Visiting Countries2</div>
                    <div class="trade_input">
                    <select name="visiting_country2" id="visiting_country2" class="trade_input_text">
                        <option value="">---------- Select ----------</option>
                        <?php
                        $sql_country = "select * from country_master  where status=1";
                        $query_country = $conn ->query($sql_country);
                        while($result_country = $query_country->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result_country['country_code']; ?>" <?php if($result_country['country_code']==$app_detail[0]['visiting_country2']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];  ?></option>
                        <?php } ?>
                    </select>
                    </div>
            	</div>
                
                 <div class="clear"></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable">City2</div>
                    <div class="trade_input"><input type="text" class="trade_input_text " name="city2" id="city2" value="<?php echo $app_detail[0]['city2'] ; ?>"></div>
            	</div>
                
                 <div class="clear"></div>
                 
                   <div class="trade_form_field">
            		<div class="trade_lable">Visiting Countries3</div>
                    <div class="trade_input">
                    <select name="visiting_country3" id="visiting_country3" class="trade_input_text">
                        <option value="">---------- Select ----------</option>
                        <?php
                        $sql_country = "select * from country_master  where status=1";
                        $query_country = $conn ->query($sql_country);
                        while($result_country = $query_country->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result_country['country_code']; ?>" <?php if($result_country['country_code']==$app_detail[0]['visiting_country3']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];  ?></option>
                        <?php } ?>
                    </select>
                    </div>
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">City3</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="city3" id="city3" value="<?php echo $app_detail[0]['city3'];?>"></div>
            	</div>
                
                 <div class="clear"></div>
                 
                   <div class="trade_form_field">
            		<div class="trade_lable">Visiting Countries4</div>
                    <div class="trade_input">
                    <select name="visiting_country4" id="visiting_country4" class="trade_input_text">
                        <option value="">---------- Select ----------</option>
                        <?php
                        $sql_country = "select * from country_master  where status=1";
                        $query_country = $conn ->query($sql_country);
                        while($result_country = $query_country->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result_country['country_code']; ?>" <?php if($result_country['country_code']==$app_detail[0]['visiting_country4']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];  ?></option>
                        <?php } ?>
                    </select>
                    </div>
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">City4</div>
                <div class="trade_input"><input type="text" class="trade_input_text " name="city4" id="city4"  value="<?php echo $app_detail[0]['city4'] ; ?>"></div>
            	</div>
                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            		<div class="trade_lable">Visiting Countries5</div>
                    <div class="trade_input">
                    <select name="visiting_country5" id="visiting_country5" class="trade_input_text">
                        <option value="">---------- Select ----------</option>
                        <?php
                        $sql_country = "select * from country_master  where status=1";
                        $query_country = $conn ->query($sql_country);
                        while($result_country = $query_country->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result_country['country_code']; ?>" <?php if($result_country['country_code']==$app_detail[0]['visiting_country5']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];  ?></option>
                        <?php } ?>
                    </select>
                    </div>
            	</div>
                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">City5</div>
                <div class="trade_input"><input type="text" class="trade_input_text " name="city5" id="city5"  value="<?php echo $app_detail[0]['city5'] ; ?>"></div>
            	</div>
                
                 <div class="clear"></div>
                 
                   <div class="trade_form_field">
            		<div class="trade_lable">Visiting Countries6</div>
                      <div class="trade_input">
                    <select name="visiting_country6" id="visiting_country6" class="trade_input_text">
                        <option value="">---------- Select ----------</option>
                        <?php
                        $sql_country = "select * from country_master  where status=1";
                        $query_country = $conn ->query($sql_country);
                        while($result_country = $query_country->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result_country['country_code']; ?>" <?php if($result_country['country_code']==$app_detail[0]['visiting_country6']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];  ?></option>
                        <?php } ?>
                    </select>
                    </div>
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">City6</div>
                <div class="trade_input"><input type="text" class="trade_input_text " name="city6" id="city6"  value="<?php echo $app_detail[0]['city6'] ; ?>"></div>
            	</div>
				<?php }?>
                 <div class="clear"></div>
                  <div class="trade_form_field">
            		<div class="trade_lable">Item1/Invoice Value 1</div>
                    <div class="trade_input1">
                    <?php /*?><input type="text" class="trade_input_text1" name="item1" id="item1" value="<?php echo $app_detail[0]['item1'] ; ?>"><?php */?>
                    	<select name="item1" id="item1" class="trade_input_text1">
								<option value="">Select Item</option>								
								<option value="LOOSE DIAMONDS" <?php if($app_detail[0]['item1']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
								<option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item1']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
								<option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item1']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
								<option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item1']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
								<option value="COLOURED GEMSTONES, PEARLS/BEADS" <?php if($app_detail[0]['item1']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected" <?php }?>>COLOURED GEMSTONES, PEARLS/BEADS</option>
								<option value="CUT & POLISHED DIAMONDS" <?php if($app_detail[0]['item1']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
								<option value="CVD/LAB GROWN DIAMONDS" <?php if($app_detail[0]['item1']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
								<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item1']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
								<option value="ALL TYPES OF GEM & JEWELLERY" <?php if($app_detail[0]['item1']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected" <?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
						</select>
                    </div>
                    <div class="trade_input1"><input type="text" class="trade_input_text1" name="invoice_value1" id="invoice_value1" value="<?php echo $app_detail[0]['invoice_value1'] ; ?>"></div>
            	</div>
                
                 <div class="clear"></div>
            
            <div class="trade_form_field">
            		<div class="trade_lable">Item1/Invoice Value 2</div> <?php /*if($app_detail[0]['item2']=="ALL TYPES OF GEM & JEWELLERY"){ echo 'Match';} else { echo 'not match';} */ ?>
                    <div class="trade_input1">
                    <select name="item2" id="item1" class="trade_input_text1">
								<option value="">Select Item</option>								
								<option value="LOOSE DIAMONDS" <?php if($app_detail[0]['item2']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
								<option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item2']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
								<option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item2']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
								<option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item2']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
								<option value="COLOURED GEMSTONES, PEARLS/BEADS" <?php if($app_detail[0]['item2']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected" <?php }?>>COLOURED GEMSTONES, PEARLS/BEADS</option>
								<option value="CUT & POLISHED DIAMONDS" <?php if($app_detail[0]['item2']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
								<option value="CVD/LAB GROWN DIAMONDS" <?php if($app_detail[0]['item2']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
								<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item2']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
								<option value="ALL TYPES OF GEM & JEWELLERY" <?php if($app_detail[0]['item2']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected" <?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
								</select>
                    </div>
                    <div class="trade_input1"><input type="text" class="trade_input_text1" name="invoice_value2" id="invoice_value2" value="<?php echo $app_detail[0]['invoice_value2'] ; ?>"></div>
            	</div>                
                <div class="clear"></div>            
            
            <div class="trade_form_field">
            		<div class="trade_lable">Item1/Invoice Value 3</div>
                    <div class="trade_input1">
                    <?php /*?><input type="text" class="trade_input_text1" name="item3" id="item3" value="<?php echo $app_detail[0]['item3'] ; ?>"><?php */?>
                    <select name="item3" id="item1" class="trade_input_text1">
						<option value="">Select Item</option>								
						<option value="LOOSE DIAMONDS" <?php if($app_detail[0]['item3']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
						<option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item3']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
						<option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item3']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
						<option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item3']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
						<option value="COLOURED GEMSTONES, PEARLS/BEADS" <?php if($app_detail[0]['item3']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected" <?php }?>>COLOURED GEMSTONES, PEARLS/BEADS</option>
						<option value="CUT & POLISHED DIAMONDS" <?php if($app_detail[0]['item3']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
						<option value="CVD/LAB GROWN DIAMONDS" <?php if($app_detail[0]['item3']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
						<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item3']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
						<option value="ALL TYPES OF GEM & JEWELLERY" <?php if($app_detail[0]['item3']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected" <?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
					</select>
                    </div>
                    <div class="trade_input1"><input type="text" class="trade_input_text1" name="invoice_value3" id="invoice_value3" value="<?php echo $app_detail[0]['invoice_value3'] ; ?>" ></div>
            	</div>                
                 <div class="clear"></div>            
            
            <div class="trade_form_field">
            		<div class="trade_lable">Item1/Invoice Value 4</div>
                    <div class="trade_input1">
                    <?php /*?><input type="text" class="trade_input_text1" name="item4" id="item4" value="<?php echo $app_detail[0]['item4'] ; ?>"><?php */?>
                    <select name="item4" id="item1" class="trade_input_text1">
								<option value="">Select Item</option>								
								<option value="LOOSE DIAMONDS" <?php if($app_detail[0]['item4']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
								<option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item4']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
								<option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item4']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
								<option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item4']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
								<option value="COLOURED GEMSTONES, PEARLS/BEADS" <?php if($app_detail[0]['item4']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected" <?php }?>>COLOURED GEMSTONES, PEARLS/BEADS</option>
								<option value="CUT & POLISHED DIAMONDS" <?php if($app_detail[0]['item4']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
								<option value="CVD/LAB GROWN DIAMONDS" <?php if($app_detail[0]['item4']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
								<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item4']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
								<option value="ALL TYPES OF GEM & JEWELLERY" <?php if($app_detail[0]['item4']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected" <?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
								</select>
                    </div>
                    <div class="trade_input1"><input type="text" class="trade_input_text1" name="invoice_value4" id="invoice_value4" value="<?php echo $app_detail[0]['invoice_value4'] ; ?>"></div>
            	</div>
                
                 <div class="clear"></div>
            
            <div class="trade_form_field">
            		<div class="trade_lable">Item1/Invoice Value 5</div>
                    <div class="trade_input1">
                    <?php /*?><input type="text" class="trade_input_text1" name="item5" id="item5" value="<?php echo $app_detail[0]['item5'] ; ?>"><?php */?>
                    <select name="item5" id="item1" class="trade_input_text1">
								<option value="">Select Item</option>								
								<option value="LOOSE DIAMONDS" <?php if($app_detail[0]['item5']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
								<option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item5']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
								<option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item5']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
								<option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($app_detail[0]['item5']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
								<option value="COLOURED GEMSTONES, PEARLS/BEADS" <?php if($app_detail[0]['item5']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected" <?php }?>>COLOURED GEMSTONES, PEARLS/BEADS</option>
								<option value="CUT & POLISHED DIAMONDS" <?php if($app_detail[0]['item5']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
								<option value="CVD/LAB GROWN DIAMONDS" <?php if($app_detail[0]['item5']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
								<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item5']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
								<option value="ALL TYPES OF GEM & JEWELLERY" <?php if($app_detail[0]['item5']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected" <?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
								</select>
                    </div>
                    <div class="trade_input1"><input type="text" class="trade_input_text1" name="invoice_value5" id="invoice_value5" value="<?php echo $app_detail[0]['invoice_value5'] ; ?>" onkeyup="getexportdata()"></div>
            	</div>
                
                 <div class="clear"></div>
                 
             <div class="trade_form_field">
            		<div class="trade_lable">Appx Invoice Value</div>
                    <div class="trade_input1"><input type="text" class="trade_input_text1" name="apprx_invoice_value" id="apprx_invoice_value" value="<?php echo $app_detail[0]['apprx_invoice_value']; ?>"></div>
             	</div>
                
                 <div class="clear"></div>    
            </div>
            <div class="right">
            	<div class="trade_form_field">
            		<div class="trade_lable">Bank Name</div>
                    <div class="trade_input">
                    <select name="bank_name" id="bank_name" class="trade_input_text">
                    <option value="">---------- Select ----------</option>
						<?php 
                        $bquery = $conn ->query("select * from bank_master where status=1 order by id asc");
                        while($bresult =  $bquery->fetch_assoc()){
                        ?>
                        <option value="<?php echo $bresult['bank_name'];?>" <?php if($bresult['bank_name']==$app_detail[0]['bank_name']){?> selected="selected" <?php }?>><?php echo $bresult['bank_name'];?></option>
                        <?php } ?>
                    </select> 
                    </div>
            	</div>
                <div class="clear"></div>
                <div class="trade_form_field" <?php if($app_detail[0]['other_bank_name']==''){?> style="display:none;" <?php }?>>
            		<div class="trade_lable"> other Bank Name</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="other_bank_name" id="other_bank_name" value="<?php echo $app_detail[0]['other_bank_name']; ?>"></div>
            	</div>
                <div class="clear"></div>
                <div class="trade_form_field">
            		<div class="trade_lable">Bank Branch</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="branch_name" id="bank_branch" value="<?php echo $app_detail[0]['branch_name'] ; ?>"></div>
            	</div>
                <div class="clear"></div>
                <div class="trade_form_field">
            		<div class="trade_lable">Person Name Carrying.</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="person_name_carrying" id="person_name_carrying" value="<?php echo $app_detail[0]['person_name_carrying']; ?>"></div>
            	</div>
                <div class="clear"></div>
                <div class="trade_form_field">
            		<div class="trade_lable">Passport No.</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="passport_no" id="passport_no"  value="<?php echo $app_detail[0]['passport_no']; ?>"></div>
            	</div>
                <div class="clear"></div>
                <div class="trade_form_field">
            		<div class="trade_lable">Passport Issue date</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="passport_issue_date" id="passport_issue_date" value="<?php echo $app_detail[0]['passport_issue_date']; ?>" readonly></div>
            	</div>
                <div class="clear"></div>
                <div class="trade_form_field">
            		<div class="trade_lable">Passport Expiry date</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="passport_expiry_date" id="passport_expiry_date" value="<?php echo $app_detail[0]['passport_expiry_date']; ?>" readonly></div>
            	</div>
                 <div class="clear"></div>
                <div class="trade_form_field">
            		<div class="trade_lable">Date of Departure</div>
                    <div class="trade_input1"><input type="text" class="trade_input_text" name="date_of_departure" id="date_of_daparture"  value="<?php echo $app_detail[0]['date_of_departure']; ?>" readonly></div>
            	</div>
                <div class="clear"></div>
                
                 <div class="trade_form_field">
            		<div class="trade_lable">Reg. Brand Name of J</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="reg_brand_name_of_j" id="reg_brand_name_of_j"  value="<?php echo $app_detail[0]['reg_brand_name_of_j']; ?>"></div>
            	</div>
                <div class="clear"></div>
                
                <div class="trade_form_field">
            		<div class="trade_lable">Name of Brand Reg A</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="reg_brand_name_of_a" id="reg_brand_name_of_a"  value="<?php echo $app_detail[0]['reg_brand_name_of_a']; ?>"></div>
            	</div>
                <div class="clear"></div>
                
                 <div class="trade_form_field">
            		<div class="trade_lable">Address of place of Dis.</div>
                    <div class="trade_input"><input type="text" class="trade_input_text" name="address_of_place_of_dis" id="address_of_place_of_dis"  value="<?php echo $app_detail[0]['address_of_place_of_dis']; ?>"></div>
            	</div>
                <div class="clear"></div> 
                <div class="trade_form_field">
            	<div class="trade_lable">Region Code</div>
               	<div class="trade_input1"><input type="text" class="trade_input_text1" name="region_code" id="region_code" value="<?php echo $app_detail[0]['region_code'];?>"></div>                    
            	</div>
                
                <div class="clear"></div>
                <?php if($app_detail[0]['permission_type']!="exhibition"){?>
                <div class="trade_form_field">
            	<div class="trade_lable">From Date</div>
                <div class="trade_input1"><input type="text" class="trade_input_text1" name="from_date" id="from_date" value="<?php echo $app_detail[0]['from_date'];?>"></div>
            	</div>
                <div class="clear"></div>
                <div class="trade_form_field">
            	<div class="trade_lable">To Date</div>
                <div class="trade_input1"><input type="text" class="trade_input_text1" name="to_date" id="to_date" value="<?php echo $app_detail[0]['to_date'] ;?>"></div>
            	</div>
				<?php } ?>
                <div class="clear"></div>
                <div class="trade_form_field">
            	<div class="trade_lable">Actual Invoice Amount</div>
                <div class="trade_input1"><input type="text" class="trade_input_text1" name="actual_invoice_amt" id="actual_invoice_amt" value="<?php echo $app_detail[0]['actual_invoice_amt'];?>"></div>                    
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">Unsold Amount</div>
                <div class="trade_input1"><input type="text" class="trade_input_text1" name="unsold_amt" id="unsold_amt" value="<?php echo $app_detail[0]['unsold_amt'];?>"></div>                    
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">Sold Amount</div>
                <div class="trade_input1"><input type="text" class="trade_input_text1" name="sold_amt" id="sold_amt" value="<?php echo $app_detail[0]['sold_amt'];?>"></div>
            	</div>                
                <div class="clear"></div>
				
                <div class="trade_form_field">
            	<div class="trade_lable">Merchant Reg No.</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="merchant_reg_no" id="merchant_reg_no" value="<?php echo $app_detail[0]['merchant_reg_no'] ;?>"></div>                    
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">Manufacture Reg No.</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="manufacturer_reg_no" id="manufacture_reg_no" value="<?php echo $app_detail[0]['manufacturer_reg_no'] ;?>"></div>                    
            	</div>                
                <div class="clear"></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable">Member Id.</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="member_id" id="member_id" value="<?php echo $app_detail[0]['member_id'];?>"></div>                    
            	</div>                
                <div class="clear"></div>
				
                <div class="trade_form_field">
            	<div class="trade_lable">Old Reference Number.</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="old_ref_no" id="old_reference_no" value="<?php echo $app_detail[0]['old_ref_no'];?>"></div>
            	</div>                
                <div class="clear"></div>
				
                <div class="trade_form_field">
            	<div class="trade_lable">New Reference Number.</div>
                <div class="trade_input"><input type="text" class="trade_input_text" name="new_ref_no" id="new_reference_no" value="<?php echo $app_detail[0]['new_ref_no'];?>"></div>
            	</div>
                <div class="clear"></div>
            </div>
        <div class="clear"></div>
		<div class="trade_form_field">
        <div class="register-button">
            <input type="submit" name="BtnSubmit" value="Update" id="BtnSubmit">
        </div>
            <div class="register-button">
                <?php if($app_detail[0]['permission_type']=="promotional_tour"){ ?>
				<a href="trade_approval_documents.php?app_id=<?php echo $app_id; ?>&&registration_id=<?php echo $registration_id; ?>">
                <span id="BtnCancel">Next</span></a>
				<?php } else { ?>
				<a href="trade_exhibition.php?app_id=<?php echo $app_id; ?>&&registration_id=<?php echo $registration_id; ?>">
				<span id="BtnCancel">Next</span>
                </a> 
				<?php } ?>				              
            </div>
			<div class="clear"></div>
		</div>
        <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
</div>
<!-- div -->
<div class="clear"></div>
<div class="padding_width">
<div class="search_bt_icon">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
<input type="hidden" name="app_id" id="app_id" value="<?php echo $app_id;?>" />
<input type="hidden" name="region_id" id="region_id" value="<?php echo $region_id;?>" />
<!--<input type="image" src="images/update_bt.jpg" alt="Update" width="72" height="30" />-->
 
</div>
</div>
</div>
<!-- Right Table -->
</form>
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>