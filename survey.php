<?php
session_start();
include 'include/header.php'; 
include('db.inc.php');
$survey_id = $_SESSION['survey_id'];
//echo '<pre>'; print_r($_SESSION); exit;

unset($_SESSION['checkInFor']);
?>
<?php
/*if(!isset($_SESSION['email_id'])){header('location:survey_start.php');} */ 
if(empty($survey_id)){header('location:index_poll.php');} 
?>
<style>
.maindiv{ 
  text-align: left;
    FONT-SIZE: 16px;
    font-family: Verdana;
    position: relative;
    /* right: -100px; */
    margin-left: 50%;
    margin-bottom: 150px;
    background-color: #f1f1f1;
    width: 800px;
    padding: 10px;
    transform: translate(-50%);
}
.lb{ 
 text-align:left; 
FONT-SIZE: 14px;
font-weight: normal; color: #4c4c4c;
font-family: Verdana;
position: relative; 
right: -20px; 
}
.innerbanner{display: none;}
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #fff;
    z-index: 99999999999;
    height: 100%;
    width: 100%;  
}

#status {   
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    margin: -22px 0 0 -22px;    
}
</style>
<script type="text/javascript" src="js/jquery.ui.min.js"></script>
<script>

$(document).ready(function() {
	$(window).on('load',function(){
    $('#preloader').hide();
    $('#status').hide();
	});
$("input:radio[name=options]").click(function() {
$('#preloader').show();
$('#status').show();
/*$('#maindiv').hide('slide', {direction: 'left'}, 100);*/
	$.post("survey_answers.php", 
	{

		"opt":$(this).val(),
		"qst_id":$("#qst_id").val(),
		"survey_id":$("#survey_id").val(),
		"order_no":$("#order_no").val(),
	},
	
function(return_data)
{ 
	/*var myJSON = JSON.stringify(return_data);
	alert(myJSON);
	*/
	$('#preloader').hide();
$('#status').hide();
if(return_data.next=='T'){
$('#q1').html(return_data.data.q1);
$('label[for=opt1]').html(return_data.data.opt1);
$('label[for=opt2]').html(return_data.data.opt2);
$('label[for=opt3]').html(return_data.data.opt3);
$('label[for=opt4]').html(return_data.data.opt4);
$("#qst_id").val(return_data.data.qst_id);
$("#survey_id").val(return_data.data.survey_id);
$("#order_no").val(return_data.data.order_no);
}
else
{ 
	$('#maindiv').html("Thank you for completing the survey!");
	var delay = 3000; 
	setTimeout(function(){ window.location = 'https://gjepc.org/index_poll.php'; }, delay);
	//window.location = "survey_unset.php";
}

},"json"); 
$("#f1")[0].reset();
 $('#maindiv').show('slide', {direction: 'right'}, 1000);
});
});
</script>

<?php
$ip_address=$_SERVER['REMOTE_ADDR'];
$_SESSION['REMOTE_ADDR'] = $ip_address;
      
if(isset($_SESSION['USERID']) && $_SESSION['USERID']!='')
    $sqlChk="select * from survey_answer where user_id='".$_SESSION['USERID']."' and survey_id='$survey_id'";
else
    $sqlChk = "SELECT IP_address FROM survey_answer WHERE IP_address= '".$_SESSION['REMOTE_ADDR']."'  AND survey_id='$survey_id'";

$chKresult = mysql_query($sqlChk);
$countx = mysql_num_rows($chKresult);
if($countx>0){
//echo "<a href='survey_result.php' target='_blank'>View Result</a>";
 echo "<script>alert('Sorry, you can only once during each Survey. You have already expressed your opinion on this topic');
            window.location.href='index.php';
          </script>";
} else {

$i=1;
//$sql="SELECT * FROM survey_qst WHERE survey_id= '$survey_id' AND order_no ='1'";
$sql="SELECT * FROM survey_qst WHERE survey_id= '$survey_id'";
$result = mysql_query($sql);
$count = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);
if($count>0){ ?>
<div id="preloader">
        <div id="status"><img src="images/loaderp.gif" alt=""></div>
    </div>
<div id='maindiv' class='maindiv'>
<form id='f1'>
<table>
<tr><td>
<h1 id='q1'><?php echo $row['qst'];?></h1></td></tr>
<tr><td>
<input type="hidden" id="order_no" value="<?php echo $i;?>">
<input type="hidden" id="qst_id" value="<?php echo $row['qst_id'];?>">
<input type="hidden" id="survey_id" value="<?php echo $row['survey_id'];?>">
<tr><td>
      <input type='radio' name='options' id='opt1' value='option1'> <label for='opt1' class='lb'><?php echo $row['opt1'];?></label>
</td></tr>
<tr><td>
      <input type='radio' name='options' id='opt2' value='option2'>  <label for='opt2' class='lb'><?php echo $row['opt2'];?></label>
</td></tr>
<tr><td>
      <input type='radio' name='options' id='opt3' value='option3'>  <label for='opt3' class='lb'><?php echo $row['opt3'];?></label>
</td></tr>
<tr><td>
      <input type='radio' name='options' id='opt4' value='option4'>  <label for='opt4' class='lb'><?php echo $row['opt4'];?></label>
</td></tr>

</table>
</form>
</div>

<?php } ?>
<?php } ?>