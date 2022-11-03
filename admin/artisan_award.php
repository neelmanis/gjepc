<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
include('../db.inc.php');
include('../functions.php');
$adminID=$_SESSION['curruser_login_id'];
?>
<?php
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
  $id = intval($_REQUEST['id']);
  $name = filter($_REQUEST['name']);
  $last_name  = filter($_REQUEST['last_name']);
  $company_name = filter($_REQUEST['company_name']);
  $designation  = filter($_REQUEST['designation']);
  $address1  = filter($_REQUEST['address1']);
  $address2  = filter($_REQUEST['address2']);
  $address3 = filter($_REQUEST['address3']);
  $city = filter($_REQUEST['city']);
  $state = filter($_REQUEST['state']);
  $pincode = filter($_REQUEST['pincode']);
  $country = filter($_REQUEST['country']);
  
  $tel_no     = filter($_REQUEST['tel_no']);
  $mobile_no      = filter($_REQUEST['mobile_no']);
  $email_id   = filter($_REQUEST['email_id']);
 
  $serealize_categories_details =serialize( array("categories"=>$_REQUEST['category'],"entry_title"=>$_REQUEST['entry_title'],'type_of_ornament'=>$_REQUEST['type_of_ornament'],'write_up'=>$_REQUEST['write_up'],'weight'=>$_REQUEST['weight'],'material'=>$_REQUEST['material']));

  if(isset($id) && $id!=""){    
  $sqlx = "UPDATE `artisan_award_applicaiton` SET `post_date`=NOW(), `name`='$name',`last_name`='$last_name',`designation`='$designation', `company_name`='$company_name',`address1`='$address1',`address2`='$address2',`address3`='$address3', `tel_no`='$tel_no',`mobile_no`='$mobile_no', `email_id`='$email_id',`city`='city',`country`='$country',`state`='$state',`pincode`='$pincode',`participation_categories_details`='$serealize_categories_details' WHERE id='$id'";
  $resultx = $conn->query($sqlx);
  echo"<meta http-equiv=refresh content=\"0;url=artisan_award.php?action=view\">";
  }
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";
  $_SESSION['company_name']="";
  $_SESSION['tel_no']="";
  
  header("Location: artisan_award.php?action=view");
} else
{
  $search_type=$_REQUEST['search_type'];
  if($search_type=="SEARCH")
  { 
  $_SESSION['name']=$conn->real_escape_string($_REQUEST['name']);
  $_SESSION['company_name']=$conn->real_escape_string($_REQUEST['company_name']);
  $_SESSION['tel_no']=$conn->real_escape_string($_REQUEST['tel_no']);
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Participant ||GJEPC||</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="fancybox/jquery-3.3.1.js"></script>    
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
  <!--<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>-->
  <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="fancybox/fancybox_js.js"></script>

<script type="text/javascript">
ddsmoothmenu.init({
  mainmenuid: "smoothmenu1", //menu DIV id
  orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
  classname: 'ddsmoothmenu', //class added to menu's outer DIV
  //customtheme: ["#1c5a80", "#18374a"],
  contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

<style>
.img_size{
  width: 150px;
    height: 150px;
  padding: 10px 0;
}
.fancybox-button--zoom,.fancybox-button--play,.fancybox-button--thumbs,.fancybox-button--arrow_left,.fancybox-button--arrow_right,.fancybox-infobar{display:none!important;}
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
  <div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
  <div class="breadcome"><a href="admin.php">Home</a> > Artisan Award</div>
</div>

<div id="main">
  <div class="content">
      <div class="content_head">Artisan Award&nbsp;&nbsp;
        <div style="float:right; padding-right:10px; font-size:12px;"><?php if($adminID!=''){?><a href="export_artisan_award.php">&nbsp;Export Artisan Award</a><?php } ?></div>
        </div>
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
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
<tr>
    <td width="19%" ><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>Name</strong></td>
  <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Telephone No</strong></td>
  <td><input type="text" name="tel_no" id="tel_no" class="input_txt" value="<?php echo $_SESSION['tel_no'];?>" autocomplete="off"/></td>
</tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr> 
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') {?>     
<div class="content_details1">
          
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
    <tr class="orange1">
        <td width="5%"><a href="#">No.</a></td>
    <td width="10%">Full Name</td>
    <td width="20%">Participant’s Name</td>
    <td width="25%">Full Address</td>
        <td width="15%">Tel. No.</td>
        <td width="25%">E-mail</td>
        <!--<td width="20%">Website</td>--> 
    <td width="15%">Action</td>   
    </tr>
    
    <?php   
  $page=1;//Default page
  $limit=50;//Records per page
  $start=0;//starts displaying records from 0
  if(isset($_GET['page']) && $_GET['page']!=''){
  $page=$_GET['page'];  
  }
  $start=($page-1)*$limit;
  
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
  
    $sql="SELECT * FROM `artisan_award_applicaiton` WHERE `year`='2020'";
  
  if($_SESSION['name']!="")
  {
  $sql.=" and name like '%".$_SESSION['name']."%'";
  }
  
  if($_SESSION['company_name']!="")
  {
  $sql.=" and company_name like '%".$_SESSION['company_name']."%'";
  }
  
  if($_SESSION['tel_no']!="")
  {
  $sql.=" and tel_no ='".$_SESSION['tel_no']."'";
  }
  
  $sql.= "  ".$attach." ";
  $result1=$conn->query($sql);
  $rCount=$result1->num_rows; 
  $sql1= $sql." limit $start, $limit";
  $result=$conn->query($sql1);

    if($rCount>0)
    { 
  while($row = $result->fetch_assoc())
  { 
    ?>  
  <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo filter(strtoupper($row['name']));?></td>
        <td><?php echo filter(strtoupper($row['company_name']));?></td>
        <td><?php echo filter(strtoupper($row['address1'])).','.filter(strtoupper($row['address2'])).','.filter(strtoupper($row['address3']));?></td>
    <td><?php echo filter(strtoupper($row['tel_no']));?></td>
        <td><?php echo filter(strtoupper($row['email_id']));?></td>
    <td align="left"><a href="artisan_award.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
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
    <?php  }    ?>
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
<div class="pages_1">Total number of Participant: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'artisan_award.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
    $action='update';
    $result2 = $conn->query("SELECT * FROM artisan_award_applicaiton where id='$_REQUEST[id]'");
    if($row2 = $result2->fetch_assoc())
    { 
      $name=stripslashes($row2['name']);
      $last_name=stripslashes($row2['last_name']);
      $company_name=stripslashes($row2['company_name']);
      $full_address=stripslashes($row2['full_address']);
      $address1=stripslashes($row2['address1']);
      $address2=stripslashes($row2['address2']);
      $address3=stripslashes($row2['address3']);
      $designation=stripslashes($row2['designation']);
      $city=stripslashes($row2['city']);
      $state=stripslashes($row2['state']);
      $pincode=stripslashes($row2['pincode']);
      $country=stripslashes($row2['country']);
      $email_id=htmlentities(strip_tags($row2['email_id']));
      $tel_no=htmlentities(strip_tags($row2['tel_no']));
      $mobile_no=htmlentities(strip_tags($row2['mobile_no']));
      $company_website=htmlentities(strip_tags($row2['company_website']));
      $participation_categories=stripslashes($row2['participation_categories']);
      $jewellery_description=htmlentities(strip_tags($row2['jewellery_description']));
      $images=stripslashes($row2['images']);
      $images1=stripslashes($row2['images1']);
      $participation_categories_details = stripslashes($row2['participation_categories_details']);
    }
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"/>
    <tr class="orange1">
    <td colspan="2"> &nbsp;Edit Form <?php if($ismember=='M') { $isMember = 'Member';} elseif ($ismember=='NM') { $isMember = 'NonMember';} else { $isMember = 'international';} echo strtoupper($isMember);?></td>
    </tr>
   <tr>
       <td class="content_txt" width="15%">Name </td>
       <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
     </tr>
     <tr>
       <td class="content_txt" width="15%">Last Name </td>
       <td><input type="text" name="last_name" id="last_name" class="input_txt" value="<?php echo $last_name; ?>" /></td>
     </tr>
          
     <tr>
       <td class="content_txt">Company Name</td>
       <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $company_name; ?>"/></td>
     </tr>
     <tr>
       <td class="content_txt">Designation </td>
       <td><input type="text" name="designation" id="designation" class="input_txt" value="<?php echo $designation; ?>"/></td>
     </tr>     
      <tr>
       <td class="content_txt"> Address1 </td>
       <td><input type="text" name="address1" id="address1" class="input_txt" value="<?php echo $address1; ?>"/></td>
     </tr>
      <tr>
       <td class="content_txt"> Address2</td>
       <td><input type="text" name="address2" id="address2" class="input_txt" value="<?php echo $address2; ?>"/></td>
     </tr>
      <tr>
       <td class="content_txt"> Address2 </td>
       <td><input type="text" name="address3" id="address3" class="input_txt" value="<?php echo $address3; ?>"/></td>
     </tr>
   <tr>
    <td class="content_txt">City </td>
       <td><input type="text" name="city" id="city" class="input_txt" value="<?php echo $city; ?>"/></td>
     </tr>
     <tr>
     <td class="content_txt">State </td>
       <td><input type="text" name="state" id="state" class="input_txt" value="<?php echo $state; ?>"/></td>
     </tr>
      <tr>
     <td class="content_txt">Country </td>
       <td><input type="text" name="country" id="country" class="input_txt" value="<?php echo $country; ?>"/></td>
     </tr>
     <tr>
     <td class="content_txt">Pincode </td>
       <td><input type="text" name="pincode" id="pincode" class="input_txt" value="<?php echo $pincode; ?>"/></td>
     </tr>
     <tr>
       <td class="content_txt">Mobile No </td>
       <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $mobile_no; ?>"/></td>
     </tr>
     <tr>
     <td class="content_txt">Telephone No </td>
       <td><input type="text" name="tel_no" id="tel_no" class="input_txt" value="<?php echo $tel_no; ?>"/></td>
     </tr>
     <tr>
       <td class="content_txt">Email Id</td>
       <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $email_id; ?>"/></td>
     </tr>     
     <?php $categories_details = unserialize($participation_categories_details);
     // echo "<pre>";print_r($categories_details);exit;
     $countCategegories = count($categories_details['categories']);
     ?>
    <?php 

  for( $x = 0; $x < $countCategegories; $x++){ ?>
     <tr>
       <td class="content_txt"><?php echo $categories_details['categories'][$x];?>
         <input type="hidden" name="category[]" value="<?php echo $categories_details['categories'][$x];?>">
       </td>
       <td> <table width="100%" border="0" cellspacing="0" cellpadding="0"/>
         <tr>
          <td class="content_txt">Title Of Entry</td>
           <td>
             <td><input type="text" name="entry_title[]" id="entry_title[]" class="input_txt" value="<?php echo $categories_details['entry_title'][$x]; ?>"/></td>
           </td>
         </tr>
         <tr>
          <td class="content_txt">Type of wearable omament </td>
           <td>
             <td><input type="text" name="type_of_ornament[]" id="type_of_ornament[]" class="input_txt" value="<?php echo $categories_details['type_of_ornament'][$x]; ?>"/></td>
           </td>
         </tr>
         <tr>
          <td class="content_txt">Write Up</td>
           <td>
             <td><textarea name="write_up[]" id="write_up[]" class="input_txt"> <?php echo $categories_details['write_up'][$x]; ?></textarea></td>
           </td>
         </tr>
         <tr>
          <td class="content_txt">Weight</td>
           <td>
             <td><input type="text" name="weight[]" id="weight[]" class="input_txt" value="<?php echo $categories_details['weight'][$x]; ?>"/></td>
           </td>
         </tr>
         <tr>
          <td class="content_txt">Material</td>
           <td>
             <td><input type="text" name="material[]" id="material[]" class="input_txt" value="<?php echo $categories_details['material'][$x]; ?>"/></td>
           </td>
         </tr>
       </table></td>
     </tr>    
  <?php } ?>
     <!-- <tr>
       <td class="content_txt">Company Website</td>
       <td><input type="text" name="company_website" id="company_website" class="input_txt" value="<?php echo $company_website; ?>" /></td>
     </tr> -->
     <!-- <tr>
       <td class="content_txt">Images First Design</td>
       <td>
         <?php if(!empty($images)){ ?>
         <a data-fancybox="gallery" href="http://theartisanawards.com/images/design/<?php echo $images; ?>">
        <img class="blah img_size" src="http://theartisanawards.com/images/design/<?php echo $images; ?>" alt="your image"/>
        <?php } else { ?>
        <a data-fancybox="gallery" href="images/upload_img.jpg">
        <img class="blah img_size" src="images/upload_img.jpg" alt="your image"/>
        <?php } ?>
       </td>
    </tr> -->
<!--     <tr>
       <td class="content_txt">Images Second Design</td>
       <td>
         <?php if(!empty($images1)){ ?>
         <a data-fancybox="gallery" href="http://theartisanawards.com/images/design2/<?php echo $images1; ?>">
        <img class="blah img_size" src="http://theartisanawards.com/images/design2/<?php echo $images1; ?>" alt="your image"/>
        <?php } else { ?>
        <a data-fancybox="gallery" href="images/upload_img.jpg">
        <img class="blah img_size" src="images/upload_img.jpg" alt="your image"/>
        <?php } ?>
       </td>
    </tr> -->
<!-- <tr>
<td valign="top" bgcolor="#FFFFFF" class="text_content">Participation Categories</td>
 <td bgcolor="#FFFFFF" class="text_content">
    <ul class="matterText">    
    <li><input type="checkbox" name="participation_categories[]" id="participation_categories" value="Rings or Pendants" <?php if(preg_match('/Rings or Pendants/',$participation_categories)){ echo 'checked="checked"'; }?>>Rings or Pendants</li>  
      
    <li><input type="checkbox" name="participation_categories[]" id="participation_categories" value="Brooches, Hair Pins or any Body Accessory" <?php if(preg_match('/Brooches, Hair Pins or any Body Accessory/',$participation_categories)){ echo 'checked="checked"'; }?>>Brooches, Hair Pins or any Body Accessory</li>
    
     <li><input type="checkbox" name="participation_categories[]" id="participation_categories" value="Earrings or Bracelets" <?php if(preg_match('/Earrings or Bracelets/',$participation_categories)){ echo 'checked="checked"'; }?>>Earrings or Bracelets</li>    
     
     <li><input type="checkbox" name="participation_categories[]" id="participation_categories" value="E" <?php if(preg_match('/E/',$participation_categories)){ echo 'checked="checked"'; }?>>Solitaire Engagement Rings</li>  
       
    <li><input type="checkbox" name="participation_categories[]" id="participation_categories" value="Men’s Jewellery" <?php if(preg_match('/Men’s Jewellery/',$participation_categories)){ echo 'checked="checked"'; }?>>Men’s Jewellery</li> 
       
    <li><input type="checkbox" name="participation_categories[]" id="participation_categories" value="Technical Innovation in Design" <?php if(preg_match('/Technical Innovation in Design/',$participation_categories)){ echo 'checked="checked"'; }?>disabled="disabled">Technical Innovation in Design</li>
    
    </ul>    
</td>
</tr> -->
<!-- <tr>
    <td class="content_txt">Jewellery Description </td>
    <td><textarea name="jewellery_description" id="jewellery_description" class="input_txt"><?php echo $jewellery_description;?></textarea></td>
</tr> -->
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
</table>
</form>
        </div>
        
<?php } ?>    
 
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>