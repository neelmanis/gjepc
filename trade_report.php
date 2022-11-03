<?php 
include 'db.inc.php';
include 'functions.php';
?>
<?php   
$registraton_id=$_SESSION['USERID'];
$info_status=mysql_query("select status,region_id,member_type_id from information_master where registraton_id='$registraton_id' and status=1");
$info_result=mysql_fetch_array($info_status);
$region_id=$info_result['region_id'];
$member_type_id=$info_result['member_type_id'];
$info_num=mysql_num_rows($info_status);
$app_id=$_GET['app_id'];
?>

<script language="javascript">
$(document).ready(function(){
$("#sub").click(function(){
	
	var actual_invoice_amt =  $("#actual_invoice_amt").val();
		if(actual_invoice_amt=='')
		{
			alert('Please Enter Actual Invoice Amount Value');
			$("#actual_invoice_amt").focus();
			return false;
		}	
	
		var sold_amt =  $("#sold_amt").val();
		if(sold_amt==''){
			alert('Please Enter Sold Value');
			$("#sold_amt").focus();
			return false;
		}			
		
		var good_description =  $("#good_description").val();
		if(good_description=='')
		{
			alert('Please Enter Good Description');
			$("#good_description").focus();
			return false;
		}
		
		var specify_country =  $("#specify_country").val();
		if(specify_country=='')
		{
			alert('Please Specify the Country');
			$("#specify_country").focus();
			return false;
		}
		var latest_trend =  $("#latest_trend").val();
		if(latest_trend=='')
		{
			alert('Please Enter Latest Trend');
			$("#latest_trend").focus();
			return false;
		}
		var future_prospect =  $("#future_prospect").val();
		if(future_prospect=='')
		{
			alert('Please Enter Future Prospect');
			$("#future_prospect").focus();
			return false;
		}
		var prob_face =  $("#prob_face").val();
		if(prob_face=='')
		{
			alert('Please Enter Problem Faced');
			$("#prob_face").focus();
			return false;
		}		
		
		p_file=$("#trade_report").val();
		var regex = new RegExp("(.*?)\.(docx|doc|xls|pdf|PDF|xlsx|jpg|png|jpeg|JPEG|PNG|JPG)$");
		if(!regex.test(p_file)) {
			alert('Please upload xls,docx,doc,jpg,xlsx,jpeg,png,PDF,pdf,JPEG,PNG,JPG');
			return false;		
		} 
		if(!document.getElementById('terms_and_cond').checked)
		{
			alert('Please Select Terms And Condition');
			$("#terms_and_cond").focus();
			return false;
		}
	});
});

function getTotInvoice()
{
	var sold_amt=document.getElementById("sold_amt").value;
	if(sold_amt==""){sold_amt=0;}
	var actual_invoice_amt=document.getElementById("actual_invoice_amt").value;
	if(actual_invoice_amt==""){actual_invoice_amt=0;}
	
	var tot_examount=parseInt(actual_invoice_amt)-parseInt(sold_amt);	
	//var tot_examount=parseInt(sold_amt)-parseInt(actual_invoice_amt);	
	
	if(parseInt(actual_invoice_amt)>parseInt(sold_amt))
	//if(parseInt(sold_amt)>parseInt(actual_invoice_amt))

	var tot_examount=parseInt(actual_invoice_amt)-parseInt(sold_amt);
	//var tot_examount=parseInt(sold_amt)-parseInt(actual_invoice_amt);
	else
	{
		alert("Actual Invoice Amount should be greater than Sold amount");
		var tot_examount=0;
	}
		
	document.getElementById("unsold_amt").value = tot_examount;
}
</script>

<form action="trade_report.inc.php" method="post" enctype="multipart/form-data" name="loginproject" onSubmit="return loginvalidate() ">

<div class="space">
    <label>Actual Invoice Value (FOB Value) :</label>
    <div class="trade_input1">
	<input type="text" class="trade_input_text1" name="actual_invoice_amt" id="actual_invoice_amt" value="">
	</div>
</div>

<div class="clear"></div>
<div class="space">
    <label>Value of goods sold :</label>
 <div class="trade_input1">
 <input type="text" class="trade_input_text1" name="sold_amt" id="sold_amt" value="" onkeyup="getTotInvoice()">
 </div>    
</div>
 
<div class="clear"></div>
<div class="space">
    <label>Value of goods unsold :</label>
    <div class="trade_input1">
	<input type="text" class="trade_input_text1" name="unsold_amt" id="unsold_amt" value="" readonly="readonly">
	</div>
</div> 

<div class="clear"></div>
<div class="space">
    <label> Describe your goods :</label>
	 <div class="trade_input1">
	 <input type="text" class="trade_input_text1" name="good_description" id="good_description" value="">
	 </div>    
</div>

<div class="clear"></div>

<div class="clear"></div>

<div class="space">
    <label>  Specify Countries:  </label>
	 <div class="trade_input1">
	 <input type="text" class="trade_input_text1" name="specify_country" id="specify_country" value="">
	 </div>
</div> 

<div class="clear"></div>

<div class="space">
    <label>  Latest Trend <br />(What is the market demand ?)   </label>
    <div class="trade_input1"><input type="text" class="trade_input_text1" name="latest_trend" id="latest_trend" value=""></div>
</div>
<div class="clear"></div>

<div class="space">
    <label>  Future Prospects <br /> (What is expected demand?) </label>
    <div class="trade_input1"><input type="text" class="trade_input_text1" name="future_prospect" id="future_prospect" value=""></div>
</div>
 
<div class="clear"></div>

<div class="space">
    <label> Any Problems Faced  </label>
    <div class="trade_input1"><input type="text" class="trade_input_text1" name="prob_face" id="prob_face" value=""></div>
</div>

<div class="clear"></div>

<div class="space">
<label> Comments & Suggestions </label><div class="trade_input1"><input type="text" class="trade_input_text1" name="comments" id="comments" value=""></div>
</div>

<div class="clear"></div>

<div class="space">
    <label> Upload Report </label>
    <div class="trade_input1"><input type="file" class="textField" name="trade_report" id="trade_report" /></div>
</div>

<div class="clear"></div>

<b>Note: 1.  Kindly upload custom attested Import & Export Invoice.</b></br></br>
<b>2. All Values Should be in USD Only.</b>

<div class="space" style="margin-top:50px;">
    <label style="width:30px;"><input type="checkbox" name="terms_and_cond" id="terms_and_cond" value="Y" class="form-checkbox"/>  </label>
    <div class="trade_input1"> I here by confirm the above information filled is true & best of my knowledge.  </div>
</div>
<div class="clear"></div>


                         
<div class="space">
    <label style="visibility:hidden;">not display</label> <input type="submit" name="sub" id="sub" class="submitButton" value="submit" />
    <input type="hidden" class="app_id" name="app_id" value="<?php echo $_GET['app_id'];?>" />
    <div class="clear"></div>
</div>
</form>

