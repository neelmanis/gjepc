<?php 
session_start();
if(!isset($_SESSION['curruser_contact_name'])){ header('Location: index.php'); exit; } 
if(!isset($_SESSION['curruser_login_id'])){	header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['financial_year']="";
  $_SESSION['iec_no']="";
  header("Location: manage_igja_awards.php?action=view");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
		$_SESSION['company_name']=filter($_REQUEST['company_name']);
		$_SESSION['email_id']=filter($_REQUEST['email_id']);
		$_SESSION['categories']=filter($_REQUEST['categories']);
	}
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage IGJA Awards||GJEPC||</title>
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


</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>

<div class="breadcome_wrap"><div class="breadcome"><a href="#">Home</a> > <a href="manage_igja_awards.php?action=view">Manage IGJA Awards</a> </div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage IGJA Awards</div>
<div class="content_details1">

<?php 
if($_REQUEST['action']=="view" && $_REQUEST['action']!="" ){
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
  <td><strong>Email Id.</strong></td>
  <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $_SESSION['email_id'];?>" /></td>
</tr>
<tr >
  <td><strong>Award Categories.</strong></td>
  <td><select name="categories" id="categories" value='<?php echo $_SESSION["categories"]?>' class="input_txt" >
  	<option value="">Select Category</option>
  	<option value="industry-performance" <?php if($_SESSION['categories'] =="industry-performance"){echo "selected";}?>>Industry Performance Awards</option>
    <option value="theme-based"  <?php if($_SESSION['categories'] =="theme-based"){echo "selected";}?>>Theme Based Awards</option>
    <option value="bank-financing"  <?php if($_SESSION['categories'] =="bank-financing"){echo "selected";}?>>Best Bank financing Awards</option>
  	<option value="supply-gold"  <?php if($_SESSION['categories'] =="supply-gold"){echo "selected";}?>>Agencies/Banks supplying gold Awards</option>
  	<option value="other"  <?php if($_SESSION['categories'] =="other"){echo "selected";}?>>Other Awards</option>
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

<?php if($_REQUEST['search_type']=='SEARCH') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td width="25%">Company Name</td>
        <td width="25%">Email-Id</td>
		<td width="25%" colspan='2'>Action</td>
    </tr>   
    <?php   
    if($_SESSION['categories']=="bank-financing"){
      $sql="SELECT id as `RegID`,bank_name as company_name,email_id FROM igja_best_bank_financing_award WHERE id!='' ";
    }else if($_SESSION['categories']=="supply-gold"){
     $sql="SELECT id as `RegID`,company_name,email_id FROM igja_gold_supply_awards WHERE id!=''";
    }else if($_SESSION['categories']=="industry-performance" || $_SESSION['categories']=="theme-based" || $_SESSION['categories']=="other"){
     $sql="SELECT id as `RegID`,company_name,email_id FROM igja_industry_performance_and_theme_based_awards WHERE id!=''";
    }  
    
	
	if($_SESSION['company_name']!="")
	{
		$sql.=" and company_name like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['email_id']!="")
	{
		$sql.=" and email_id like '%".$_SESSION['email_id']."%'";
	}

  if($_SESSION['categories']=="industry-performance" || $_SESSION['categories']=="theme-based" || $_SESSION['categories']=="other"){
	if($_SESSION['categories']=="industry-performance")
	{

		$sql.=" and performance_award_category !=''";
	}
	if($_SESSION['categories']=="theme-based")
	{
		$sql.=" and theme_based_award_category !=''";
	}
	if($_SESSION['categories']=="other")
	{
		$sql.=" and other_award_category !=''";
	}
}
  $sql.="order by id desc";
  //	echo $sql;
	$result = $conn ->query($sql);
	$rCount  = $result->num_rows;	
    if($rCount>0)
    {	
	$i=1;
	while($row = $result->fetch_assoc())
	{ 
  $rowId= $row["RegID"];
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['company_name']; ?></td>
		<td width="5%"><?php echo $row['email_id']; ?></td>
        
        <td width="20%"><a href=' <?php if($_SESSION['categories']=="industry-performance" || $_SESSION['categories']=="theme-based" || $_SESSION['categories']=="other"){?>igja_awards_application_pdf.php?registration_id=<?php echo $row['RegID'];?><?php }else  if($_SESSION['categories']=="bank-financing"){?>
          igja_awards_bank_financing_application_pdf.php?registration_id=<?php echo $row['RegID'];?>
        <?php  }else if($_SESSION['categories']=="supply-gold"){?>

          igja_awards_supply_gold_application_pdf.php?registration_id=<?php echo $row['RegID'];?>
       <?php  } ?>' target='_blank'>Downlaod Application Data</a></td>

        <?php if($_SESSION['categories']=="industry-performance" || $_SESSION['categories']=="theme-based" || $_SESSION['categories']=="other"){?>
        <td width="15%"><a href='manage_igja_awards.php?registration_id=<?php echo $row['RegID'];?>&action=attatchments'> View attatchments</a></td>
       <?php }else if($_SESSION['categories']=="bank-financing"){
       
        $sql_bank_attatchment = "SELECT attatchment FROM igja_best_bank_financing_award WHERE id ='$rowId'";
        $result_bank_attatchment  = $conn->query($sql_bank_attatchment);
        $row_bank_attatchment = $result_bank_attatchment->fetch_assoc();
        $bank_attatchment = "../images/igja_awards/".trim($row_bank_attatchment["attatchment"]);
        ?>
         
        <td> <?php if(file_exists($bank_attatchment) && $row_bank_attatchment["attatchment"]!=""){?> 
         <a href="<?php echo $bank_attatchment;?>"  target="_blank">Attatchment</a>
          <?php } ?></td>
       <?php }else if($_SESSION['categories']=="supply-gold"){
          $sql_gold_supply_attatchment = "SELECT attatchment FROM igja_gold_supply_awards WHERE id ='$rowId'";
        $result_gold_supply_attatchment  = $conn->query($sql_gold_supply_attatchment);
        $row_gold_supply_attatchment = $result_gold_supply_attatchment->fetch_assoc();
        $gold_supply_attatchment = "../images/igja_awards/".trim($row_gold_supply_attatchment["attatchment"]);
        ?>
         
        <td> <?php if(file_exists($gold_supply_attatchment) && $row_gold_supply_attatchment["attatchment"]!=""){?> 
         <a href="<?php echo $gold_supply_attatchment;?>"  target="_blank">Attatchment</a>
          <?php } ?></td>
       <?php } ?>
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
    <?php  }  ?>
</table>
</div>
<?php } }   



if($_REQUEST['action']=="attatchments" && $_REQUEST['action']!="" ){
$registration_id = $_REQUEST['registration_id'];
$general_info = "SELECT attatchments FROM igja_industry_performance_and_theme_based_awards WHERE id='$registration_id'";
$res_general_info = $conn->query($general_info);
$row_general_info = $res_general_info->fetch_assoc();
$attatchments1 = unserialize($row_general_info['attatchments']);
$annual_reports = $attatchments1['annual_reports'];
$income_tax_return_attatchments = $attatchments1['income_tax_return_attatchments'];

 $best_growing = "SELECT attatchments FROM igja_industry_performance_best_growing_performance WHERE reg_id='$registration_id'";
$res_best_growing = $conn->query($best_growing);
$row_best_growing = $res_best_growing->fetch_assoc();
$attatchments2 = unserialize($row_best_growing['attatchments']);


$qualitative_info = "SELECT attatchments FROM igja_industry_perfomance_qualitative_info WHERE reg_id='$registration_id'";
$res_qualitative_info = $conn->query($qualitative_info);
$row_qualitative_info = $res_qualitative_info->fetch_assoc();
$attatchments3 = unserialize($row_qualitative_info['attatchments']);

$innovaitive = "SELECT attatchments FROM igja_theme_based_innovative_company WHERE reg_id='$registration_id'";
$res_innovaitive = $conn->query($innovaitive);
$row_innovaitive = $res_innovaitive->fetch_assoc();
$attatchments4 = unserialize($row_innovaitive['attatchments']);


$best_digital = "SELECT attatchments FROM igja_theme_based_digital_initiative WHERE reg_id='$registration_id'";
$res_best_digital = $conn->query($best_digital);
$row_best_digital = $res_best_digital->fetch_assoc();
$attatchments5 = unserialize($row_best_digital['attatchments']);


$socially_responsible = "SELECT attatchments FROM igja_theme_based_digital_initiative WHERE reg_id='$registration_id'";
$res_socially_responsible = $conn->query($socially_responsible);
$row_socially_responsible = $res_socially_responsible->fetch_assoc();
$attatchments6 = unserialize($row_socially_responsible['attatchments']);

$declaration = "SELECT attatchments FROM igja_industry_performance_declaration WHERE reg_id='$registration_id'";
$res_declaration = $conn->query($declaration);
$row_declaration = $res_declaration->fetch_assoc();
$attatchments7 = unserialize($row_declaration['attatchments']);





?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
	<td colspan="11">View and Download all documents</td>
	<td colspan="11"><a href="manage_igja_awards.php?action=view"> Back</a></td>
</tr>

<tr>
    <td width="19%" ><strong>Annual Reports</strong></td>
    <td width="81%"><?php foreach($annual_reports as $report){ 
      if( file_exists("../images/igja_awards/".$report)){
      ?>
    	<a href="../images/igja_awards/<?php echo $report ;?>" target="Blank"><?php echo $report; ?></a> <br>
   <?php } }?></td>
</tr>    
<tr>
    <td width="19%" ><strong>income_tax_return_attatchments </strong></td>
    <td width="81%"><?php foreach($income_tax_return_attatchments as $incm_tx_attatchment){ 
      if( file_exists("../images/igja_awards/".$incm_tx_attatchment)){?>
    	<a href="../images/igja_awards/<?php echo $incm_tx_attatchment ;?>" target="Blank"><?php echo $incm_tx_attatchment; ?></a><br>
   <?php } } ?></td>
</tr>     

<tr>
    <td width="19%" ><strong>Export Related Documents </strong></td>
    <td width="81%"><?php foreach($attatchments2['attatchments'] as $exp_attatchment){ 
       if( file_exists("../images/igja_awards/".$exp_attatchment)){?>
    	<a href="../images/igja_awards/<?php echo $exp_attatchment ;?>" target="Blank"><?php echo $exp_attatchment; ?></a><br>
   <?php } }
  
    ?></td>
</tr>  
<tr>
    <td width="19%" ><strong>Qualitative Info Documents </strong></td>
    <td width="81%"><?php foreach($attatchments3['attatchments'] as $qualitative_attatchment){ 
      if( file_exists("../images/igja_awards/".$qualitative_attatchment)){?>
    	<a href="../images/igja_awards/<?php echo $qualitative_attatchment ;?>" target="Blank"><?php echo $qualitative_attatchment; ?></a><br>
   <?php } } ?></td>
</tr>  
<tr>
    <td width="19%" ><strong>innovative Company  Documents </strong></td>
    <td width="81%"><?php foreach($attatchments4['attatchments'] as $innovative_company_doc){
      if( file_exists("../images/igja_awards/".$innovative_company_doc)){?>
    	<a href="../images/igja_awards/<?php echo $innovative_company_doc ;?>" target="Blank"><?php echo $innovative_company_doc; ?></a><br>
   <?php } }?></td>
</tr>     

<tr>
    <td width="19%" ><strong>Best Digital Company  Documents </strong></td>
    <td width="81%"><?php foreach($attatchments5['attatchments'] as $best_digital_company_doc){ 
       if( file_exists("../images/igja_awards/".$best_digital_company_doc)){?>
    	<a href="../images/igja_awards/<?php echo $best_digital_company_doc ;?>" target="Blank"><?php echo $best_digital_company_doc; ?></a><br>
   <?php } }?></td>
</tr>     

<tr>
    <td width="19%" ><strong>Socially responsible Company  Documents </strong></td>
    <td width="81%"><?php foreach($attatchments6['attatchments'] as $socially_resp_comp_doc){
      if( file_exists("../images/igja_awards/".$socially_resp_comp_doc)){?>
    	<a href="../images/igja_awards/<?php echo $socially_resp_comp_doc ;?>" target="Blank"><?php echo $socially_resp_comp_doc; ?></a><br>
   <?php } }?></td>
</tr>  
<tr>
    <td width="19%" ><strong>Declaration Documents </strong></td>
    <td width="81%"><?php foreach($attatchments7['attatchments'] as $declaration_documents){ 
      if( file_exists("../images/igja_awards/".$declaration_documents)){?>
    	<a href="../images/igja_awards/<?php echo $declaration_documents ;?>" target="Blank"><?php echo $declaration_documents; ?></a><br>
   <?php } }?></td>
</tr>     


</table>
<?php } ?> 
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>