<?php 
include 'include/header.php'; 
include 'db.inc.php'; 
include('functions.php');
?>

<section>
	<div class="banner_wrap mb">    
        <ul class="d-flex breadcrumb">
    		<li><a href="index.php">Home</a></li>
    		<li class="active">Research & Statistics</li>
  		</ul>        
    </div>
<div class="container inner_container">
		<div class="row mb">        
        	<div class="col-12"> <div class="innerpg_title"><h1>Result</h1> </div> </div>
        	
            <div class="col-12">
<?php
$year = filter($_REQUEST['year']);
$quarter=$_REQUEST['quarter'];
$month=$_REQUEST['month'];
$commodity_name=$_REQUEST['commodity_name'];
$hs_code=$_REQUEST['hs_code'];
$trade_type=$_REQUEST['trade_type'];
$top_limit = filter($_REQUEST['top_limit']);

$sql="select comodity_description,product_category_code,year,export_import_date,country_name,country_code,SUM(ROUND(value_INR)) as total_inr, SUM(ROUND(REPLACE(value_USD, ',', ''))) as total_usd from statistics_report where 1 ";
//$sql="select comodity_description,product_category_code,year,export_import_date,country_name,country_code,value_INR as total_inr,value_USD as total_usd,export_import_date from statistics_report where 1 ";

if($year!="")
{
$sql.=" and year='$year' ";
}

if($quarter!="")
{
	if($quarter==1)
	{
	$sql.=" and (export_import_date between '$year-01-01' and '$year-03-31' || export_import_date between '01/01/$year' and '31/03/$year')";
	}else if($quarter==2)
	{
	$sql.=" and (export_import_date between '$year-04-01' and '$year-06-30' || export_import_date between '01/04/$year' and '30/06/$year')";
	}else if($quarter==3)
	{
	$sql.=" and (export_import_date between '$year-07-01' and '$year-09-30' || export_import_date between '01/07/$year' and '30/09/$year')";
	}else if($quarter==4)
	{
	$sql.=" and (export_import_date between '$year-10-01' and '$year-12-31' || export_import_date between '01/10/$year' and '31/12/$year')";
	}	
}

if($month!="")
{
    $monthlength = strlen((string)$month);
    if($monthlength!='2'){
    	$addzero = "0";
    }else{
    	$addzero = "";
    }
    $maxMonth = 31;
    for ($maxMonth=1; $maxMonth <= 31 ; $maxMonth++) {

    	$str[] .= "'".$maxMonth."/".$addzero.$month."/".$year."'";
		$strs[] .= "'".$year."-".$addzero.$month."-".$maxMonth."'";
    }
    $allDates = implode(",", $str);
	$allSDates = implode(",", $strs);
    $sql.=" and (export_import_date IN ($allDates) || export_import_date IN ($allSDates))";	
}

/* Comment on 21MAY-2018
if($quarter!="")
{
	if($quarter==1)
	{
	$sql.=" and export_import_date between '$year-01-01' and '$year-03-31' ";
	}else if($quarter==2)
	{
	$sql.=" and export_import_date between '$year-04-01' and '$year-06-30' ";
	}else if($quarter==3)
	{
	$sql.=" and export_import_date between '$year-07-01' and '$year-09-30' ";
	}else if($quarter==4)
	{
	$sql.=" and export_import_date between '$year-10-01' and '$year-12-31' ";
	}	
} */
/*
if($month!="")
{
	if($month==1)
	{
	$sql.=" and export_import_date between '$year-01-01' and '$year-01-31' ";
	}else if($month==2)
	{
	$sql.=" and export_import_date between '$year-02-01' and '$year-02-29' ";
	}else if($month==3)
	{
	$sql.=" and export_import_date between '$year-03-01' and '$year-03-31' ";
	}else if($month==4)
	{
	$sql.=" and export_import_date between '$year-04-01' and '$year-04-30' ";
	}else if($month==5)
	{
	$sql.=" and export_import_date between '$year-05-01' and '$year-05-31' ";
	}else if($month==6)
	{
	$sql.=" and export_import_date between '$year-06-01' and '$year-06-30' ";
	}else if($month==7)
	{
	$sql.=" and export_import_date between '$year-07-01' and '$year-07-31' ";
	}else if($month==8)
	{
	$sql.=" and export_import_date between '$year-08-01' and '$year-08-31' ";
	}else if($month==9)
	{
	$sql.=" and export_import_date between '$year-09-01' and '$year-09-30' ";
	}else if($month==10)
	{
	$sql.=" and export_import_date between '$year-10-01' and '$year-10-31' ";
	}else if($month==11)
	{
	$sql.=" and export_import_date between '$year-11-01' and '$year-11-30' ";
	}else if($month==12)
	{
	$sql.=" and export_import_date between '$year-12-01' and '$year-12-31' ";
	}	
} */

if($commodity_name!="")
{
$sql.=" and product_category_code LIKE '$commodity_name' ";
}

if($hs_code!="")
{
$sql.=" and hs_code='$hs_code' ";
}
if($trade_type!="")
{
$sql.=" and trade_type='$trade_type' ";
}

$sql.=" group by country_code order by total_inr desc";

$sql2=$sql;

if($top_limit!="")
{
$sql.=" limit 0,$top_limit ";
}

$result1 =  $conn ->query($sql);
$rows1	 = $result1->fetch_assoc();
$num_rows= $result1->num_rows;

if($top_limit!="")
{
	$sql3=$sql2. " limit $top_limit,18446744073709551615";
	$result3 = $conn ->query($sql3);
	$other_sub_total_inr=0;
    $other_sub_total_usd=0;
	while($rows3 = $result3->fetch_assoc())
  	{
	$getTotal_inr = str_replace(',','',$rows3['total_inr']);
	$getTotal_usd = str_replace(',','',$rows3['total_usd']);
 	$other_sub_total_inr=round($other_sub_total_inr+$getTotal_inr);
  	$other_sub_total_usd=round($other_sub_total_usd+$getTotal_usd);
  	}
}

if($num_rows>0)
{
if($year!="")
{
?>
<div class="dotet_line"></div>
<?php
if($commodity_name=="")
{
?>
<div class="reports_text1">HTS - <?php echo $hs_code;?> : <?php echo $rows1['product_category_code'];?> <br />(<?php echo $rows1['comodity_description'];?>) </div>
<?php
}else
{ 
echo "<div class='alert alert-success' role='alert'>$commodity_name</div>";
}
?>

<div class="reports_text2">
<?php
if($quarter==1)
{
echo "1'st Quarter";
}else if($quarter==2)
{
echo "2'nd Quarter";
}else if($quarter==3)
{
echo "3'rd Quarter";
}else if($quarter==4)
{
echo "4'th Quarter";
}

if($month==1)
{
echo "January";
}else if($month==2)
{
echo "February";
}else if($month==3)
{
echo "March";
}else if($month==4)
{
echo "April";
}else if($month==5)
{
echo "May";
}else if($month==6)
{
echo "June";
}else if($month==7)
{
echo "July";
}else if($month==8)
{
echo "August";
}else if($month==9)
{
echo "September";
}else if($month==10)
{
echo "October";
}else if($month==11)
{
echo "November";
}else if($month==12)
{
echo "December";
}
?>
 Data for <strong><?php echo $year;?></strong></div>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<table border="1" align="center" cellpadding="3" cellspacing="2" style="border-collapse:collapse; font-size:14px; border-color:#ccc;">
  <tr>
    <td rowspan="2"align="center" bgcolor="#EBEBEB"><strong>Country</strong></td>
    <td colspan="2"  style="padding:10px; " align="center" bgcolor="#EBEBEB"><strong><?php echo $trade_type;?> in <?php echo $year;?><br />
    </strong></td>
    </tr>
  <tr>
    <td style="padding:10px;" align="center" bgcolor="#EBEBEB">Rs. In</td>
    <td style="padding:10px;"  align="center" bgcolor="#EBEBEB">US $ in</td>
  </tr>
 
  <?php
  $sub_total_inr=0;
  $sub_total_usd=0;
  //echo $sql;
  $result = $conn ->query($sql);
  while($rows = $result->fetch_assoc())
  {
  $myTotal_inr = str_replace(',','',$rows['total_inr']);
  $myTotal_usd = str_replace(',','',$rows['total_usd']);
  $sub_total_inr=round($sub_total_inr+$myTotal_inr);
  $sub_total_usd=round($sub_total_usd+$myTotal_usd);  
  $newTotal_inr = $rows['total_inr'];
  $newTotal_usd = $rows['total_usd'];
  ?>
  <tr>
    <td style="padding:10px;" align="left"><strong><?php echo $rows['country_name']." (".$rows['country_code'].")";?></strong></td>
    <td style="padding:10px; text-align:right;"><?php echo moneyFormatIndia($newTotal_inr);?></td>
    <td style="padding:10px;text-align:right;"><?php echo moneyFormatIndia($newTotal_usd);?></td>
  </tr>
 
  <?php 
  }
  ?>
   <tr>
    <td align="center" bgcolor="#EAEAEA"><strong>Total</strong></td>
    <td  style="padding:10px; background-color:#EAEAEA; text-align:right;"><?php echo  moneyFormatIndia($sub_total_inr); ?></td>
    <td  style="padding:10px; background-color:#EAEAEA; text-align:right;"><?php echo  moneyFormatIndia($sub_total_usd); ?> </td>
  </tr>
  <!--<tr>
    <td align="center" bgcolor="#EAEAEA"><strong>Others</strong></td>
    <td  style="padding:10px; background-color:#EAEAEA; text-align:right;"><?php echo  moneyFormatIndia($other_sub_total_inr); ?></td>
    <td  style="padding:10px; background-color:#EAEAEA; text-align:right;"><?php echo  moneyFormatIndia($other_sub_total_usd); ?></td>
  </tr>-->
  <tr>
    <td align="center" bgcolor="#EAEAEA"><strong>Overall Total</strong></td>
    <td  style="padding:10px; background-color:#EAEAEA; text-align:right;"><?php echo  moneyFormatIndia($sub_total_inr+$other_sub_total_inr); ?></td>
    <td  style="padding:10px; background-color:#EAEAEA; text-align:right;"><?php echo  moneyFormatIndia($sub_total_usd+$other_sub_total_usd); ?>  </td>
  </tr>
</table></td>
  </tr>
</table>

<?php
}
}else
{
?>
<div class="dotet_line"></div>
<div class="reports_text1">HTS - <?php echo $hs_code;?> </div>
<div class="reports_text2">No Record Found</div>
<?php 
}
?>
</div>
</div>
 </div>
</div>
</div>
</section>
<?php include 'include/footer.php'; ?>