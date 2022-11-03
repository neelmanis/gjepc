<?php 
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php');exit; }
include 'db.inc.php';
include 'functions.php';
$registration_id = intval(filter($_SESSION['USERID']));
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";
  $_SESSION['mobile1']="";
  $_SESSION['company_approval']="";
  
  header("Location: person-list.php");
} else {
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['name']		      =	$_REQUEST['name'];
	$_SESSION['mobile1']		  =  $_REQUEST['mobile1'];
	$_SESSION['company_approval'] = $_REQUEST['company_approval'];
	}
}
?>
<style>
.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}

.portal_table th {white-space: nowrap;}
.portal_table td {word-break: inherit;}
</style>
<section class="py-5">
    <div class="container inner_container">  
    <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png"  class="d-block mx-auto mb-4">Karigar List</h1> 
	<div class="row justify-content-between">
	<div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
		<?php include 'include/regMenu.php'; ?>
	</div>
	
<!--<div class="tooltip">
<button onclick="myFunction()" onmouseout="outFunc()">
  <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
  Copy text
  </button>
</div>
<input type="text" value="Hello World" id="myInput">-->

<div class="col-lg col-md-12">
<?php
$getParichay_type = isApplied_for_parichay($_SESSION['USERID'],$conn); 
$sharelinks = 'https://gjepc.org/add-karigar-person.php?type='.$getParichay_type.'&via=links&uid='.$registration_id;
?>
<?php
$getStatus = getParichay_status($registration_id,$conn);
if($getStatus=="P"){ echo "Application is Pending "; } else if($getStatus=="D"){ echo "Application is Disapproved "; } else { ?>
<a href="add-person-details.php" class="cta">ADD NEW APPLICATION</a> 
<!-- <input type="text" class="form-control" value="<?php echo $sharelinks;?>" id="myInput"> -->
<div class="row mb-2 mt-2">
<div class="col-9">
	<input id="foo" type="text" class="form-control" value="<?php echo $sharelinks;?>">
</div>
<div class="col-3">
<!--   <a href="mailto:?subject=Parichay Card Registration Link &body=<?php echo $sharelinks;?>" class="text-center d-block cta copy_btn">Share link &nbsp;<i class="fa fa-share "></i></a> -->
    <a href="javascript:void()" class="text-center d-block cta copy_btn btn" data-clipboard-action="copy" data-clipboard-target="#foo">copy link &nbsp;<i class="fa fa-copy "></i></a>
</div>
</div>

<?php } ?>
	
<form name="search" action="" method="POST" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />

<div class="row mb-3">
  <div class="col-12">
    <h2 class="title mb-0">Search Options</h2>
  </div>
  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
    <label>Name:</label>
    <input type="text" name="name" id="name" class="form-control" value="<?php echo $_SESSION['name'];?>" autocomplete="off"/>
  </div>
  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
    <label>Mobile Number:</label>
    <input type="text" name="mobile1" id="mobile1" class="form-control" value="<?php echo $_SESSION['mobile1'];?>" maxlength="10" autocomplete="off"/>
  </div>
  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
    <label>Karigar Status:</label>
     <select name="company_approval" class="form-control">
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['company_approval']=='P'){echo "selected='selected'";}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['company_approval']=='Y'){echo "selected='selected'";}?>>Approved</option>
        <option value="D" <?php if($_SESSION['company_approval']=='D'){echo "selected='selected'";}?>>Disapproved</option>
        </select>
  </div>
  <div class="col-12 mt-2">
    <input type="submit" name="Submit" value="Search" class="cta fade_anim"/> 
<input type="submit" name="Reset" value="Reset"  class="cta fade_anim" />
  </div>
</div>

</form>
<div class="row">
  <div class="col-12">
    <table class="responsive_table  mb-4 " >
      <thead>
        <tr>
          <!--<th>No.</th>-->
          <th>Person Name</th>
          <th>Mobile </th>
          <th>Date</th>
          <th><?php if($getParichay_type=="association"){ echo "Association"; } else { echo "Company"; }?> Approval Status</th>
          <th>Agency Approval Status</th>
          <th>Action</th>
          
        </tr>
      </thead>
      <tbody id="CommunicationDetails">
      <?php
      $page=1;//Default page
      $limit=25;//Records per page
      $start=0;//starts displaying records from 0
      if(isset($_GET['page']) && $_GET['page']!=''){
      $page=$_GET['page'];  
      }
      $start=($page-1)*$limit;
      
      $sql = "SELECT * from parichay_person_details where registration_id='$registration_id' AND registration_id!=0";
      
      if($_SESSION['name']!="")
      {
      $sql.=" and fname like '%".$_SESSION['name']."%'";
      }
      if($_SESSION['mobile1']!="")
      {
      $sql.=" and mobile1 like '%".$_SESSION['mobile1']."%'";
      }
      if($_SESSION['company_approval']!="")
      { 
        if($_SESSION['company_approval']=='Y')
        {
          $sql.=" and company_approval='Y' ";
        }else if($_SESSION['company_approval']=='P')
        {
          $sql.=" and company_approval='P' ";
        } else {
          $sql.=" and company_approval='D' ";
        }
      }
        $sql .="  order by post_date desc";
      
      $result = $conn ->query($sql);
      $rCount = $result->num_rows;

      $sql1= $sql."  limit $start, $limit";
      $result1= $conn ->query($sql1);
  
      if($rCount>0)
      { 
      $i=1;
      while($ans= $result1->fetch_assoc())
      {
      ?>
        <tr>
          <!--<td data-column="No"><?php echo $i;?></td>-->
          <td data-column="Name"><?php echo $ans['fname'].' '. $ans['mname'].' '. $ans['surname'];?></td>
          <td data-column="Mobile"><?php echo $ans['mobile1'];?></td>     
          <td data-column="Date"><?php echo date("d-m-Y",strtotime($ans['post_date']));?></td>
          <!-- <td data-column="Status"><?php if($ans['parichay_status']=="Y"){ echo "APPROVED"; } else if($ans['parichay_status']=="P"){ echo "PENDING"; } else { echo "DISAPPROVED"; } ?></td> -->
            <td data-column="Status">
      <?php if($ans['company_approval']=="Y"){ echo '<i class="fa fa-check text-success" style="font-size: 18px"></i>'."APPROVED <br/>"; } else if($ans['company_approval']=="P"){ echo '<i class="fa fa-check text-warning" style="font-size: 18px"></i>'."PENDING<br/>"; } else { echo '<i class="fa fa-times text-danger" style="font-size: 18px"></i>'."DISAPPROVED <br/>"; } ?>
            <label>&nbsp;<input type="radio" name="company_approval" value="Y"  >Approve</label>
            <label>&nbsp;<input type="radio" name="company_approval" value="N" >Disapprove</label>
            <input type="hidden" name="person_id" class="person_id" value="<?php echo $ans['person_id']?>">
            <input type="hidden" name="registration_id" class="registration_id" value="<?php echo $registration_id;?>">
            <textarea name="company_remark" rows="2"><?php echo $ans['company_remark'];?></textarea>
            <p class="success_msg" style="color: green"></p>
            </td>
          <td data-column="Status">
          <!--   <label>&nbsp;<input type="radio" name="agency_approval" <?php if($ans['agency_approval']=="Y"){echo "checked";}?> value="Y">Approve</label>
            <label>&nbsp;<input type="radio" name="agency_approval" value="N" <?php if($ans['agency_approval']=="N"){echo "checked";}?>>Disapprove</label>
            <input type="hidden" name="person_id" class="person_id" value="<?php echo $ans['person_id']?>">
            <textarea name="agency_remark" rows="2"><?php echo $ans['agency_remark'];?></textarea>
            <p class="success_msg" style="color: green"></p> -->
      
            <?php if($ans['agency_approval']=="Y"){ echo "Approved"; }elseif($ans['agency_approval']=="N"){ echo "Disapproved";}else{ echo "Pending";}?>
          </td>
      <td data-column="edit"><?php if($ans['company_approval']=="Y" && $ans['agency_approval']=="Y" ){ ?>            
            <i class="fa fa-check text-success" style="font-size: 18px"></i>
            <?php } else { ?>
            <a href="update-person-details.php?person_id=<?php echo base64_encode($ans['person_id']); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <?php } ?>
            <a href="javascript:void(0)" class="karigar_view" data-id="<?=$ans['person_id'];?>"><i class="fa fa-eye"></i></a>
          </td>         
      </tr>
      <?php $i++; 
      } 
      }   else   {   ?>
        <tr>
        <td colspan="8">Records Not Found</td>
        </tr>
        <?php  }  ?>
      </tbody>
    </table>
  </div>
  <div class="col-12">
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
<div class="pages_1" id="page_ids">Total Number of Karigar : <?php echo $rCount;?>
<?php echo pagination($limit,$page,'person-list.php?&page=',$rCount); //call function to show pagination?>
</div>  
  </div>
</div>

		
</div>

</div>
</div>

<div class="modal fade" id="karigarModal" role="dialog">
    <div class="modal-dialog" >
     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <h2 class="title">Karigar Info</h2>        
      </div>
      <div class="modal-body"> 
      </div>
      <div class="modal-footer">
       <button type="button" class="cta" data-dismiss="modal">Close</button>
      </div>
     </div>
    </div>
   </div>
   <style>
@media (min-width: 576px){
.modal-dialog {
    min-width: 600px;
}
}
</style>

</section>
<script src="assets-new/js/clipboard.min.js"></script>
<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied: " + copyText.value;
}

function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
}
</script>
<?php include 'include-new/footer.php'; ?>
<style>
.portal_table td { white-space:nowrap; word-break: inherit; } 
.portal_table th {white-space:nowrap}
</style>
<script type="text/javascript">
  $(document).ready(function(){
$('input[name="company_approval"]').change(function(){
  var approval = $(this).val();
  //var person_id = $(this).parent().siblings("input").val(); 
  var person_id = $(this).parent().siblings(".person_id").val(); //alert(person_id);
  var registration_id = $(this).parent().siblings(".registration_id").val(); // alert(registration_id);
  var company_remark = $(this).parent().siblings("textarea").val();
  
  var ref= $(this);
  if(approval!=""){
            if(approval=="N" && company_remark==""){
            alert("Add remark Here");
            ref.prop('checked', false);
            return false;
            }
            if(approval=="Y" ){
              ref.parent().siblings("textarea").val("");
              company_remark = "";
            }
              if(confirm("Approve/ Disapprove")){
                    var actionType = "company_approval_status_update_action";
              $.ajax({
              type:'POST',
              data:{approval:approval,person_id:person_id,registration_id:registration_id,actionType:actionType,company_remark:company_remark},
              url:"ajax.php",
              dataType: "json",
              beforeSend: function() {
              $(".pan_check_loader").show();
              },
              success: function(result) { //alert(result);
                if(result.status=='success'){
                if(result.flag=="Y"){
					ref.parent().siblings(".success_msg").text("Application Approved");                          
                } else if(result.flag=="N"){
                ref.parent().siblings(".success_msg").text("Application Disapproved");
                }
                  
                }else if(result.status=='fail'){
                  alert("Server Error");
                }    
              }
              });
              }else{
                return false;
              }

      }else{
        return false;
      }
});
$('input[name="agency_approval"]').change(function(){
  var approval = $(this).val();
  var person_id = $(this).parent().siblings("input").val();
  var agency_remark = $(this).parent().siblings("textarea").val();
  
  var ref= $(this);
  if(approval!=""){
            if(approval=="N" && agency_remark==""){
            alert("Add remark Here");
            ref.prop('checked', false);
            return false;
            }
            if(approval=="Y" ){
              ref.parent().siblings("textarea").val("");
              agency_remark = "";
            }
              if(confirm("Approve/ Disapprove")){
                    var actionType = "agency_approval_status_update_action";
              $.ajax({
              type:'POST',
              data:{approval:approval,person_id:person_id,actionType:actionType,agency_remark:agency_remark},
              url:"ajax.php",
              dataType: "json",
              beforeSend: function() {
              $(".pan_check_loader").show();
              },
              success: function(result) { 
                 if(result.status=='success'){
                  if(result.flag=="Y"){                            
                            ref.parent().siblings(".success_msg").text("Application Approved");
                          
                  }else if(result.flag=="N"){                    
                            ref.parent().siblings(".success_msg").text("Application Disapproved");
                           
                  }                  
                 }else if(result.status=='fail'){
                  alert("Server Error");
                 }
              }
              });
              }else{
                return false;
              }

      }else{
        return false;
      }
});

});

</script>
 <script>
    var clipboard = new ClipboardJS('.btn');

    clipboard.on('success', function(e) {
        alert("Link copied to clipboard");
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });

    $('.karigar_view').click(function(){
      var karigarid = $(this).data('id');
      var actiontype = "getKarigarDetails";
      $.ajax({
        url: 'ajax.php',
        type: 'post',
        data: {karigarid: karigarid,actiontype:actiontype},
        dataType: "json",
        success: function(response){ 
          $('.modal-body').html(response.output);
          $('#karigarModal').modal('show'); 
        }
      });
    });
    </script>