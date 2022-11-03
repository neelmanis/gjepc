<?php include 'include/header.php'; include 'db.inc.php'; ?>

<script language="javascript">

	function formValidator()
	{
		if(document.getElementById('year').value == '')
		{
			alert("Please Select Year");
			document.getElementById('year').focus();
			return false;
		}
		 if(document.getElementById('search_field').value == '')
		 {
		 	alert("Please Select Search Field");
		 	document.getElementById('search_field').focus();
		return false;
		 }	
		if(document.getElementById('hs_code').value == '')
		{
			alert("Please Enter HS Code");
			document.getElementById('hs_code').focus();
			return false;
		}
		if(!IsNumeric(document.getElementById('hs_code').value))
		{
			alert("Please enter Numeric Value Only.")
			document.getElementById('hs_code').focus();
			return false;
		}
		if(document.getElementById('trade_type').value == '')
		{
			alert("Please Select Trade Type");
			document.getElementById('trade_type').focus();
			return false;
		}
		if(!IsNumeric(document.getElementById('top_limit').value))
		{
			alert("Please enter Numeric Value Only.")
			document.getElementById('top_limit').focus();
			return false;
		}				
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

<script>
	$(document).ready(function(){
	 $("#quarter").change(function(){
	    quarter=$('#quarter').val();
		
		if(quarter=="")
		{
		$('#month').removeAttr("disabled");
		}else
		{
		$('#month').attr("disabled","disabled");
		}
	  });
	  
	  $("#month").change(function(){
	    month=$('#month').val();
		
		if(month=="")
		{
		$('#quarter').removeAttr("disabled");
		}else
		{
		$('#quarter').attr("disabled","disabled");
		}
	  });
	});
</script>

<div class="col-md-12 text-left">
	<ol class="col-md-12 breadcrumb">
		<li>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">Research & Statistics</a>
		</li>
	</ol>
</div>

<div class="col-md-8 col-sm-12 col-xs-12 wrapper">
	
	<div class="col-md-12 nopadding">

	    <div class="content">
			<div class="title">
		        <h4>Research & Statistics</h4>		        
		    </div>
		    <div class="ab_description">
			    <p>The GJEPC tracks the import-export performance of the Indian gem & jewellery industry and maintains a comprehensive data base of statistical information dating back to when the Council was launched in 1966-67.</p>
			</div> 
    	</div>	

<div class="content">    	

<div id="horizontalTab">
	<ul class="resp-tabs-list">
		<li>Imports</li>
		<li>Exports</li>
		<li>Search</li>
		<li>Archives</li>
	</ul>

<div class="resp-tabs-container">

<div name="Imports">
<?php
$sql="SELECT * FROM `statistics_import_category` WHERE 1 and status='1' order by order_no desc";
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result))
{
?>
<?php 
	$sql2="SELECT * FROM `statistics_import_master` WHERE 1 and status='1' and set_archive='0' and cat_id='$rows[id]' order by post_date desc,id asc";	
	$result2=mysql_query($sql2);
	$import_cnt=mysql_num_rows($result2);
	if($import_cnt>0)
	{ ?>
    <div class="sub_head"><?php echo $rows['cat_name'];?></div>
	<ul class="download_pdf">
    <?php 	
	while($rows2=mysql_fetch_array($result2))
	{
	?>
    <li><a href="admin/StatisticsImport/<?php echo $rows2['upload_statistics_import'];?>" target="_blank"><?php echo $rows2['name'];?></a></li>   
    <?php
	}
	echo "</ul><ul>";
	}
	
}
	$sql3="SELECT * FROM `statistics_import_master` WHERE 1 and status='1' and set_archive='0' and cat_id='0' order by post_date desc";	
	$result3=mysql_query($sql3);
	$import_cnt2=mysql_num_rows($result3);
	if($import_cnt2>0)
	{
	while($rows3=mysql_fetch_array($result3))
	{
	?>
    <li><a href="admin/StatisticsImport/<?php echo $rows3['upload_statistics_import'];?>" target="_blank"><?php echo $rows3['name'];?></a></li>   
    <?php
	}
	echo "</ul>";
	}?>
</div>            
                         
<div name="exports">
<?php
$sql="SELECT * FROM `statistics_export_category` WHERE 1 and status=1 order by order_no desc";
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result))
{
	$sql2="SELECT * FROM `statistics_export_master` WHERE 1 and status='1' and set_archive='0' and cat_id='$rows[id]' order by post_date desc";
	$result2=mysql_query($sql2);
	$export_cnt=mysql_num_rows($result2);
	if($export_cnt>0)
	{ ?>
    <div class="sub_head"><?php echo $rows['cat_name'];?></div>
	<ul class="download_pdf">    
    <?php
	while($rows2=mysql_fetch_array($result2))
	{
	?>
    <li><a href="admin/StatisticsExport/<?php echo $rows2['upload_statistics_export'];?>" target="_blank"><?php echo $rows2['name'];?></a></li>   
    <?php
	}
	echo "</ul>";
	}
	}
	?>
</div>

<div name="search">

<div class="container-fluid">
	<form name="form1" id="form1" action="report.php" onsubmit="return formValidator()">
	<div class="row">
		<div class="col-md-6">
			<label class="form-label">Select Year to Display: *</label>
		</div>
		<div class="col-md-6">
			<select name="year" id="year" class="form_text_text">
				<option selected value="" disabled> Select </option>
				<option value="2017">2017</option>
				<option value="2016">2016</option>
				<option value="2015">2015</option>
				<option value="2014">2014</option>
				<option value="2013">2013</option>
				<option value="2012">2012</option>
				<option value="2011">2011</option>
				<option value="2010">2010</option>
				<option value="2009">2009</option>
				<option value="2008">2008</option>
				<option value="2007">2007</option>
				<option value="2006">2006</option>
				<option value="2005">2005</option>
				<option value="2004">2004</option>
				<option value="2003">2003</option>
				<option value="2002">2002</option>
				<option value="2001">2001</option>
				<option value="2000">2000</option>
			</select>

		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label class="form-label">Select Quarter to Display:</label>
		</div>
		<div class="col-md-6">
			<select name="quarter" id="quarter" class="form_text_text">
				<option selected disabled>Select</option>
				<option value="1">Quarter I</option>
				<option value="2">Quarter II</option>
				<option value="3">Quarter III</option>
				<option value="4">Quarter IV</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label class="form-label">Select Month To Search:</label>
		</div>
		<div class="col-md-6">
			<select name="month" id="month" class="form_text_text">
				<option selected disabled>Select</option>
				<option value="1">January</option>
				<option value="2">February</option>
				<option value="3">March</option>
				<option value="4">April</option>
				<option value="5">May</option>
				<option value="6">June</option>
				<option value="7">July</option>
				<option value="8">August</option>
				<option value="9">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label class="form-label">Enter Commodity Name </label>
		</div>
		<div class="col-md-6">
			<select name="commodity_name" class="form_text_text" id="commodity_name" >
				<option selected disabled>Select</option>
				<option value="COL GEM">COLORED GEM</option>
				<option value="COSTUME FAS JEW">COSTUME FASHION JEW</option>
				<option value="CUT & POL">CUT & POLISH DIAMOND</option>
				<option value="GOLD BAR">GOLD BAR</option>
				<option value="GOLD FINDINGS">GOLD FINDINGS	</option>
				<option value="GOLD JEW">GOLD JEWELLERY</option>
				<option value="GOLD MEDALLIONS,COIN">GOLD MEDALLIONS,COIN</option>
				<option value="RAW PEARLS">RAW PEARLS</option>
				<option value="ROUGH COL GEMSTONES">ROUGH COLORED GEMSTONES</option>
				<option value="ROUGH DIAMOND">ROUGH DIAMOND</option>
				<option value="RGH SYNTHETIC STONES">ROUGH SYNTHETIC STONES</option>
				<option value="NON GOLD JEW">NON GOLD JEWELLERY</option>
				<option value="PEARLS">PEARLS</option>
				<option value="PLATINUM">PLATINUM</option>
				<option value="SILVER BAR">SILVER BAR</option>
				<option value="SYNTHETIC STONES">SYNTHETIC STONES</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label class="form-label">Enter Commodity Number (HS Code)* </label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control form_text_text" name="hs_code" id="hs_code"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label class="form-label">Trade Type: </label>
		</div>
		<div class="col-md-6">
			<select name="trade_type" class="form_text_text" id="trade_type"/>
				<option value="">---------- Select Trade Type ----------</option>
				<option value="1">Export</option>
				<option value="3">Re-Export</option>
				<option value="2">Import</option>
				<option value="4">Re-Import</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label class="form-label">Enter No. of Top Countries </label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control form_text_text" name="top_limit" id="top_limit" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<input type="submit" class="btn" value="Run Query" name="">
		</div>
	</div>
	</form>
</div>

</div>

<div name="archive">
 	<div class="sub_head statbtn">Statistics Export</div>
     
<ul class="download_pdf stats">
<?php
$sql="SELECT * FROM `statistics_export_master` WHERE 1 and `status`='1' and `set_archive`='1' order by post_date desc";
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result))
{
?>
<li><a href="admin/StatisticsExport/<?php echo $rows['upload_statistics_export'];?>" target="_blank"><?php echo stripslashes($rows['name']);?> <?php echo date("d/m/Y",strtotime($rows['post_date']));?></a>
<?php
}
?>
</ul>

<div class="sub_head statbtn">Statistics Import</div>    
<ul class="download_pdf stats">
<?php
$sql="SELECT * FROM `statistics_import_master` WHERE 1 and `status`='1' and `set_archive`='1' order by post_date desc";
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result))
{
?>
<li><a href="admin/StatisticsImport/<?php echo $rows['upload_statistics_import'];?>" target="_blank"><?php echo stripslashes($rows['name']);?> <?php echo date("d/m/Y",strtotime($rows['post_date']));?></a>
<?php
}
?>
</ul>

</div>
</div>
</div>
</div>

</div>

</div>

<div class="col-md-4 col-sm-6 col-xs-12 speakerSelector">
	<div class="col-md-12"><?php include 'include/newsletter.php';?></div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="row mainRow">
		<div class="col-md-12">
			<div class="upcomingEvents">
		        <div class="title">
		          <h4>Upcoming Events</h4>
		        </div>
		        <?php include 'include/eventsslider.php'; ?>
	      </div>
		</div>
	</div>	
</div>

<script>
jQuery(document).ready(function(){
	jQuery(".stats").hide();
	
	jQuery(".statbtn").click(function(){
		jQuery(".stats").slideUp();
		jQuery(this).next(".stats").slideDown();
	})
})
</script>

<?php include 'include/footer.php'; ?>