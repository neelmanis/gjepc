<?php include 'include/header.php'; ?>
<?php
if(!isset($_SESSION['USERID'])){header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php
//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
$registration_id = intval($_SESSION['USERID']);
$buy_sell_profile_code	=	filter($_REQUEST['user_type']);
$company_name	=	filter(strtoupper($_REQUEST['company_name']));
$contact_person	=	filter(strtoupper($_REQUEST['contact_person']));
$designation	=	filter($_REQUEST['designation']);
$website		=	filter(strtoupper($_REQUEST['website']));
$write_up		=	filter(strtoupper($_REQUEST['write_up']));
$wa_jewellery1	=	$_REQUEST['wa_jewellery'];
$wa_jewellery_other	=	filter($_REQUEST['wa_jewellery_other']);
foreach($wa_jewellery1 as $val)
{
    $end=end($wa_jewellery1);
	$wa_jewellery.=$val;
	if($end!=$val){$wa_jewellery.=",";}
    if($val=='any other'){$wa_jewellery.=",".$wa_jewellery_other;} 
}
 
$wa_machinery1=$_REQUEST['wa_machinery'];
$wa_machinery_other=$_REQUEST['wa_machinery_other'];
foreach($wa_machinery1 as $val)
{
    $end=end($wa_machinery1);
	$wa_machinery.=$val;
	if($end!=$val){$wa_machinery.=",";}
    if($val=='any other'){$wa_machinery.=",".$wa_machinery_other;} 
}
$wa_other1=$_REQUEST['wa_other'];
$wa_other_other=$_REQUEST['wa_other'];
foreach($wa_other1 as $val)
{
    $end=end($wa_other1);
	$wa_machinery.=$val;
	if($end!=$val){$wa_other.=",";}
    if($val=='any other'){$wa_other.=",".$wa_other_other;} 
}
$pd_jewellery1=$_REQUEST['pd_jewellery'];
$pd_jewellery_other=$_REQUEST['pd_jewellery_other'];

foreach($pd_jewellery1 as $val)
{
	$end=end($pd_jewellery1);
	$pd_jewellery.=$val;
	if($end!=$val){$pd_jewellery.=",";}
    if($val=='any other'){$pd_jewellery.=",".$pd_jewellery_other;}
}

$pd_machinery1=$_REQUEST['pd_machinery'];
$pd_machinery_other=$_REQUEST['pd_machinery_other'];
foreach($pd_machinery1 as $val)
{
  $end=end($pd_machinery1);
  $pd_machinery.=$val;
  if($end!=$val){$pd_machinery.=",";}
  if($val=='any other'){$pd_machinery.=",".$pd_machinery_other;}
}
$objective1=$_REQUEST['objective'];
$objective_other=$_REQUEST['objective_other'];
foreach($objective1 as $val)
{
    $end=end($objective1);
	$objective.=$val;
	if($end!=$val){$objective.=",";}
    if($val=='any other'){$objective.=",".$objective_other;}
}
$import_from1=$_REQUEST['import_from'];
$import_from_other=$_REQUEST['import_from_other'];
foreach($import_from1 as $val)
{
    $end=end($import_from1);
	$import_from.=$val;
	if($end!=$val){$import_from.=",";}
    if($val=='any other'){$import_from.=",".$import_from_other;}
}
$item_interest1=$_REQUEST['item_interest'];
$item_interest_other=$_REQUEST['item_interest_other'];
foreach($item_interest1 as $val)
{
    $end=end($item_interest1);
	$item_interest.=$val;
	if($end!=$val){$item_interest.=",";}
    if($val=='any other'){$item_interest.=",".$item_interest_other;}
}
$caratage=mysql_real_escape_string($_REQUEST['caratage']);

$d_size1=$_REQUEST['d_size'];
foreach($d_size1 as $val){
$end=end($d_size1);
$d_size.=$val;
if($end!=$val){$d_size.=",";}
}

$d_clarity1=$_REQUEST['d_clarity'];
foreach($d_clarity1 as $val){
$end=end($d_clarity1);
$d_clarity.=$val;
if($end!=$val){$d_clarity.=",";}
}

$d_color_shade1=$_REQUEST['d_color_shade'];
foreach($d_color_shade1 as $val){
$end=end($d_color_shade1);
$d_color_shade.=$val;
if($end!=$val){$d_color_shade.=",";}
}

$d_pp_from=$_REQUEST['d_pp_from'];
$d_pp_to=$_REQUEST['d_pp_to'];

$cgs_stone1=$_REQUEST['cgs_stone'];
foreach($cgs_stone1 as $val){
$end=end($cgs_stone1);
$cgs_stone.=$val;
if($end!=$val){$cgs_stone.=",";}
}
$cgs_shade=$_REQUEST['cgs_shade'];
$cgs_shape=$_REQUEST['cgs_shape'];
$cgs_quantity=$_REQUEST['cgs_quantity'];
$cgs_pp_from=$_REQUEST['cgs_pp_from'];
$cgs_pp_to=$_REQUEST['cgs_pp_to'];

$ip_address=$_SERVER['REMOTE_ADDR'];

if(in_array("loose diamonds", $item_interest1))
{
if(count($d_size1)==0){$_SESSION['upload_error'].="diamond size is required.<br/>";header('location:members_profile.php');} 
if(count($d_clarity)==0){$_SESSION['upload_error'].="diamond clarity is required.<br/>";header('location:members_profile.php');}
if(count($d_color_shade)==0){$_SESSION['upload_error'].="diamond color/shade is require.";header('location:members_profile.php');}
}
if(in_array("coloured gemstones", $item_interest1))
{
if(count($cgs_stone1)==0) {$_SESSION['upload_error']="Name of the stone is required.";header('location:members_profile.php');exit;}
}
$dt=date('Y-m-d');
/*...........................Check if already there...............................*/
$query=mysql_query("select * from member_directory where registration_id='$registration_id'");
$num=mysql_num_rows($query);
if($num>0)
{
	$product_logo = '';
	$target_folder = 'product_logo/';
	$temp_code = rand();
	if($_FILES['product_logo']['name'] != '')
	{  
		if(($_FILES["product_logo"]["type"] == "image/jpg") || ($_FILES["product_logo"]["type"] == "image/jpeg") || ($_FILES["product_logo"]["type"] == "image/png"))
		{
			$target_path = $target_folder.$temp_code.'_'.$_FILES['product_logo']['name'];
			if(@move_uploaded_file($_FILES['product_logo']['tmp_name'], $target_path))
			{
				$product_logo = $temp_code.'_'.$_FILES['product_logo']['name'];
				$sql="update member_directory set product_logo='$product_logo' where registration_id='$registration_id'";
				$result=mysql_query($sql);
			}
			else
			{
				$_SESSION['upload_error']="Sorry product image could not be uploaded";
				header('location:members_profile.php');
				exit;
			}
		} else
		{
			$_SESSION['upload_error']="Sorry you have select Invalid file for product logo";
			header('location:members_profile.php');	exit;
		}	
	}

	$company_logo = '';
	$target_folder = 'company_logo/';
	$temp_code = rand();
	if($_FILES['company_logo']['name'] != '')
	{  
		if(($_FILES["company_logo"]["type"] == "image/jpg") || ($_FILES["company_logo"]["type"] == "image/jpeg") || ($_FILES["company_logo"]["type"] == "image/png"))
		{
			$target_path = $target_folder.$temp_code.'_'.$_FILES['company_logo']['name'];
			if(@move_uploaded_file($_FILES['company_logo']['tmp_name'], $target_path))
			{
				$company_logo = $temp_code.'_'.$_FILES['company_logo']['name'];
				$sql="update member_directory set company_logo='$company_logo' where registration_id='$registration_id'";
				$result=mysql_query($sql);
			}
			else
			{
				$_SESSION['upload_error']="Sorry comapny image could not be upload";
				header('location:members_profile.php');	exit;
			}
		} else
		{
			$_SESSION['upload_error']="Sorry you have select Invalid file for company logo";
			header('location:members_profile.php');	exit;
		}	
	}

	
mysql_query("update member_directory set registration_id='$registration_id',buy_sell_profile_code='$buy_sell_profile_code',company_name='$company_name',contact_person='$contact_person',designation='$designation',website='$website',write_up='$write_up',wa_jewellery='$wa_jewellery',wa_machinery='$wa_machinery',wa_other='$wa_other',pd_jewellery='$pd_jewellery',pd_machinery='$pd_machinery',objective='$objective',import_from='$import_from',item_interest='$item_interest',caratage='$caratage',d_size='$d_size',d_clarity='$d_clarity',d_color_shade='$d_color_shade',d_pp_from='$d_pp_from',d_pp_to='$d_pp_to',cgs_stone='$cgs_stone',cgs_shade='$cgs_shade',cgs_shape='$cgs_shape',cgs_quantity='$cgs_quantity',cgs_pp_from='$cgs_pp_from',cgs_pp_to='$cgs_pp_to',product_logo='$product_logo',company_logo='$company_logo',ip_address='$ip_address' where registration_id='$registration_id'");

$_SESSION['msg']="Member directory updated successfully";
header('location:members_profile.php');
}
else
{
	$product_logo = '';
	$target_folder = 'product_logo/';
	$temp_code = rand();
	if($_FILES['product_logo']['name'] != '')
	{  
		if(($_FILES["product_logo"]["type"] == "image/jpg") || ($_FILES["product_logo"]["type"] == "image/jpeg") || ($_FILES["product_logo"]["type"] == "image/png"))
		{
			$target_path = $target_folder.$temp_code.'_'.$_FILES['product_logo']['name'];
			if(@move_uploaded_file($_FILES['product_logo']['tmp_name'], $target_path))
			{
				$product_logo = $temp_code.'_'.$_FILES['product_logo']['name'];
			}
			else
			{
				$_SESSION['upload_error']="Sorry image could not be upload";
				header('location:members_profile.php');	    exit;
			}
		} else
		{
			$_SESSION['upload_error']="Sorry you have select Invalid file";
			header('location:members_profile.php');		exit;
		}	
	}
	
	$company_logo = '';
	$target_folder = 'company_logo/';
	$temp_code = rand();
	if($_FILES['company_logo']['name'] != '')
	{  
		if (($_FILES["company_logo"]["type"] == "image/jpeg") || ($_FILES["company_logo"]["type"] == "image/png"))
		{
			$target_path = $target_folder.$temp_code.'_'.$_FILES['company_logo']['name'];
			if(@move_uploaded_file($_FILES['company_logo']['tmp_name'], $target_path))
			{
				$company_logo = $temp_code.'_'.$_FILES['company_logo']['name'];
			} else
			{
				$_SESSION['upload_error']="Sorry image could not be upload";
				header('location:members_profile.php');    exit;
			}
		}
		else
		 {
			$_SESSION['upload_error']="Sorry you have select Invalid file";
			header('location:members_profile.php');	exit;
		 }	  
	}

mysql_query("insert into member_directory set registration_id='$registration_id', 	buy_sell_profile_code='$buy_sell_profile_code',company_name='$company_name',contact_person='$contact_person',designation='$designation',website='$website',write_up='$write_up',wa_jewellery='$wa_jewellery',wa_machinery='$wa_machinery',wa_other='$wa_other',pd_jewellery='$pd_jewellery',pd_machinery='$pd_machinery',objective='$objective',import_from='$import_from',item_interest='$item_interest',caratage='$caratage',d_size='$d_size',d_clarity='$d_clarity',d_color_shade='$d_color_shade',d_pp_from='$d_pp_from',d_pp_to='$d_pp_to',cgs_stone='$cgs_stone',cgs_shade='$cgs_shade',cgs_shape='$cgs_shape',cgs_quantity='$cgs_quantity',cgs_pp_from='$cgs_pp_from',cgs_pp_to='$cgs_pp_to',product_logo='$product_logo',company_logo='$company_logo',status=1,ip_address='$ip_address',post_date='$dt'");

$_SESSION['msg']="Member directory save successfully";
header('location:members_profile.php');
}
} else {
	 $_SESSION['msg']="Invalid Token Error";
	}
?>