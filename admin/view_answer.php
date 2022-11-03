<?php 
session_start();
ob_start();
?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

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
<script language="javascript">
function checkdata()
{
	var t_file=document.getElementById('t_file').value;
	//alert(dte);
	
	if(document.getElementById('t_name').value == '')
	{
		alert("Please Enter Traning Calender Name");
		document.getElementById('t_name').focus();
		return false;
	}
	
	if(document.getElementById('t_file').value == '')
	{
		alert("Please Select PDF File.");
		document.getElementById('t_file').focus();
		return false;
	}
	if(document.getElementById('p_date').value == '')
	{
		alert("Please Select Post Date")
		document.getElementById('p_date').focus();
		return false;
	}
	
	 var ext = t_file.substring(t_file.lastIndexOf('.') + 1);
	if(ext!='pdf')
	{
		alert('Select Only PDF File');
		document.getElementById('t_file').focus();
		return false;
	}
	
	/*var x=document.getElementById('mobile_no').value;
	
	if (x.charAt(0)!="9" && x.charAt(0)!="8" && x.charAt(0)!="7")
   	{
		alert("It should start with 9 or 8 or 7");
		document.getElementById('mobile_no').focus();
		return false;
   	}*/
		
}
function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID")
		return false
	}
	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 return true					
}

function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   //if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}


</script>
<script language="javascript">
$(document).ready(function(){
 $("#role").change(function () {
	var role=$(this).val();
	if(role=="Super Admin")
	{
		$("#admin_access_div").hide();
	}else
	{
		$("#admin_access_div").show();
	}
	
 });
});
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Admin</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_polls.php?action=view"><div class="content_head_button">View question</div></a> </div>

<?php if($_REQUEST['action']=='view') {
	$q_id=$_REQUEST['id'];
	$sql_query="SELECT * FROM poll_master where id=$q_id";
	$result = $conn ->query($sql_query);
    $rCount=0;
    $rCount = $result->num_rows;		
	$row = $result->fetch_assoc();

?>    	
<div class="content_details1">
        	
<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<tr style="font-size:20px; color:#CC9966; " ><td colspan="8"><b>Q.   <?php echo $row['question'];?></b></td></tr> 
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>        
        <td>Option Name</td>
        <td>Percentage</td>
        <td>Percentage</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    if($rCount>0)
    {	
		$op_query="select * from polloption_master where q_id=".$row['id'];
		$result_op=$conn ->query($op_query);
		/**********total count************/
		$total_query="select * from pollanswer_master where q_id=".$row['id'];
		$total_result=$conn ->query($total_query);
		$total_cnt = $total_result->num_rows;		 
		while($row_op = $result_op->fetch_assoc())
		{
		$answer_query="select * from pollanswer_master where q_id=".$row['id']." and o_id=".$row_op['id'];
		$result_ans=$conn ->query($answer_query);	
		$ans_cnt= $result_ans->num_rows; 
    ?> 
    
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td ><?php echo $i;?></td>
        <td><?php echo $row_op['option_name']; ?></td>
        <td><?php echo round(cal($ans_cnt,$total_cnt),2);?></td>
        <td><?php echo round(($ans_cnt/$total_cnt)*100);?></td>
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
</table>-->
<?php echo $row['question'];?>
		<?php 
		if($rCount>0)
		{	
		$op_query="select * from polloption_master where q_id=".$row['id'];
		$result_op=$conn ->query($op_query);
		/**********total count************/
		$total_query="select * from pollanswer_master where q_id=".$row['id'];
		$total_result=$conn ->query($total_query);
		$total_cnt = $total_result->num_rows;		 
		while($row_op = $result_op->fetch_assoc())
		{
		$answer_query="select * from pollanswer_master where q_id=".$row['id']." and o_id=".$row_op['id'];
		$result_ans=$conn ->query($answer_query);	
		$ans_cnt= $result_ans->num_rows; 
		echo $ans_cnt.'----'.$total_cnt;
		$percentage_vote = round(($ans_cnt/$total_cnt)*100);
		$progress_bar_class = '';
		  if($percentage_vote >= 40)
		  {
		   $progress_bar_class = 'progress-bar-success';
		  }
		  else if($percentage_vote >= 25 && $percentage_vote < 40)
		  {
		   $progress_bar_class = 'progress-bar-info';
		  }
		  else if($percentage_vote >= 10 && $percentage_vote < 25)
		  {
		   $progress_bar_class = 'progress-bar-warning';
		  }
		  else
		  {
		   $progress_bar_class = 'progress-bar-danger';
		  }
		?>
<div id="poll_result">
			<div class="row">
				<div class="col-md-2" align="right">
					<label><?php echo $row_op['option_name']; ?></label>
				</div>
				<div class="col-md-10">
					<div class="progress">
						<div class="progress-bar <?php echo $progress_bar_class;?>" role="progressbar" aria-valuenow="<?php echo $percentage_vote;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percentage_vote;?>%">
							<?php echo $percentage_vote;?>% like <b><?php echo $row_op['option_name']; ?></b>
						</div>
					</div>
				</div>
			</div>
</div>
<?php
	   }
	 }
	 else
	 {
	 ?>
    <tr>
        <td colspan="10">Records Not Found</td>
    </tr>
    <?php  }  	?>

</div>

<div class="midletext">
<?php
$query = "select * from poll_master where status=1 order by id desc ";
$result = $conn ->query($query);
$x=1;
		 
	while($row = $result->fetch_assoc())
	{
		$q_id=$row['id'];
	 	$op_query="select * from polloption_master where q_id=".$row['id'];
		$result_op=$conn ->query($op_query);
	
		$total_query="select * from pollanswer_master where q_id=".$row['id'];
		$total_result=$conn ->query($total_query);
		$total_cnt= $total_result->num_rows;	
	
	?>
	
	<div class="question">
	&nbsp;&nbsp;&nbsp;<span>Results of <?php echo date("F Y",strtotime($row['post_date']));?> Opinion Poll</span>
	<span><a href="javascript:showonlyone('newboxes<?php echo $q_id; ?>')" class="comment_button active" id="<?php echo $q_id; ?>"><?php echo "Q".$x.") ". $row['question']; ?></a></span>
	</div>
	
	<div class="ans newboxes" id="newboxes<?php echo $q_id; ?>">
	<span>Options :</span>
    	
				<?php
                $i=1;
                 while($row_op= $result_op->fetch_assoc())
                 {
                       $answer_query="select * from pollanswer_master where q_id=".$row['id']." and o_id=".$row_op['id'];
                       $result_ans=$conn ->query($answer_query);
                       $ans_cnt=$result_ans->num_rows;	
                 ?>
                <div>
                   <div class="sr"> <?php echo $i.") "; ?></div>
                    
                  <div class="cont">  <?php
                          echo $row_op['option_name'];
					?></div>
                    
                    <div class="percent"> <?php
                          echo round(cal($ans_cnt,$total_cnt),2)."%"; 
                           $i++;
                    ?></div>
                    <div class="clear"></div>
                    </div>
                  <?php  } $i=0;?>	
	
	</div>
	
	
	<?php
	
	$x++;
	} ?>



</div>
<?php } ?>        
 </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>