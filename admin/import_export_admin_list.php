<?php
session_start();
include('../db.inc.php');
include('../functions.php');
 /*$querychart = "SELECT quarter_year, count(*) as number FROM import_export GROUP BY quarter_year"; */
 $querychart = mysql_query("SELECT quarter_year, count(*) as number FROM import_export GROUP BY quarter_year"); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Import Export ||GJEPC||</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
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
<style type="text/css">
.style1 {color: #FF0000}
.style2 {
  font-size: 16px;
  font-weight: bold;
}
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #333;
    margin-bottom: 17px;
    margin-top: 13px;
}
.btn_export{
  display:inline-block;
  background: #f67d5c;
  color: #fff;

  padding: 5px 10px;
  text-decoration: none;

}
.select-control{width: 100px;
  width: 161px;
    height: 25px;
    padding: 2px 6px;
}
.mb2{margin-bottom: 10px}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart']});  
           google.charts.setOnLoadCallback(drawChart);  
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Gender', 'Number'],  
                          <?php  
                          while($row = mysql_fetch_array($querychart))  
                          {  
                               echo "['".$row["quarter_year"]."', ".$row["number"]."],";  
                          }  
                          ?>  
                     ]);  
                var options = {  
                      title: 'Percentage of Quarter Year ',  
                      //is3D:true,  
                      pieHole: 0.3  
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
           </script> 
           <script language="javascript">
function checkdata()
{
/*  quarter=document.getElementById('quarter');
   if(!quarter.form.checkbox.checked)
{
    alert('You must agree to the terms first.');
    return false;
}*/
/*if(document.getElementById('quarter').checked = true){
}*/
   if($( 'input[class^="quarter_year"]:checked' ).length === 0) {
      alert( 'Please select quarter year.' );
      return false;
   }
   report=document.getElementById('report').value;
  if(report=="")
  {
    alert("Please Select Import or Export.");
    document.getElementById('report').focus();
    return false;
  }
region=document.getElementById('region').value;
  if(region=="")
  {
    alert("Please Select Region.");
    document.getElementById('region').focus();
    return false;
  } 
}
</script>

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
  <div class="nav"><?php include("include/menu.php");?></div>
</div>
<style>
  .exp_imp tr th{
    border:1px solid #999999;
  }
</style>
<div class="clear"></div>

<div class="breadcome_wrap">
  
</div>
<div><h3 align="center">All Members Import Export List</h3></div>
<div id="main">
  <div class="content">
     

<?php if($_REQUEST['action']=='view') {?>     
<div class="content_details1">
   <form action="export_import_to_excel.php" method="post" name="form1" id="form1" onsubmit="return checkdata()">
	<?php
	$sqlQuarterYear = mysql_query("SELECT DISTINCT quarter_year FROM import_export");
	?>
  <label>Select Quarter Year</label>   
    
        <div class="mb2">
        <?php 
        while($rowQuarterYear= mysql_fetch_assoc($sqlQuarterYear)){ ?>
        <input type="checkbox" name="quarter[]" class="quarter_year" id="quarter" value="<?php echo  $rowQuarterYear['quarter_year']; ?>"> <?php echo  $rowQuarterYear['quarter_year'] ; ?>
        <?php } ?>        
        </div> 
          <select  id="report" name="report" class="select-control">
          <option value="">Select Type</option>
          <option value="all">All</option>
          <option value="export">Export</option>
          <option value="import">Import</option>        
        </select>
        <?php $statement = "SELECT region_name, region_real_name FROM region_master WHERE status='1'";
         $result = mysql_query($statement);
         ?>
        <select  id="region" name="region" class="select-control">
          <option value="">Select Region</option>
          <option value="all">All Region</option>
          <?php while($rows = mysql_fetch_assoc($result)){?>
            <option value="<?php echo $rows['region_name'];?>"><?php echo $rows['region_real_name'] ?> </option>
          <?php } ?>         
        
        </select>
        <input type="submit"  class="btn btn_export" name="submit" value="Report To Excel ">
        <!-- <a href="export_import_to_excel.php" class="btn btn_export">Export To Excel</a>  --> 

        </form>
<table id="example" class="" style="width:100%">
        <thead>
            <tr class="orange1">
                <th>Sr. No.</th>            
                <th>Company Name</th>
                <th>Quarter Year</th>               
                <th>Import Commodities Name</th>
                <th>Export Commodities Name</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
    <?php    
    $i=1;
    $result = mysql_query("SELECT * FROM import_export");
    $rCount=0;
    $rCount = @mysql_num_rows($result);   
    if($rCount>0)
    { 
  while($row = mysql_fetch_array($result))
  { 
      if(!empty($row['exp_commodities_name']) || !empty($row['imp_commodities_name'])){
    ?>
            <tr>
                <td><?php echo $i;?></td>
                <td> <?php echo getNameCompany($row['registration_id']);?></td>
               <!--  <td><?php echo $row['registration_id'];?></td> -->
                <td><?php echo $row['quarter_year'];?></td>
               
                <td><?php echo $row['imp_commodities_name'];?></td>
                <td><?php echo $row['exp_commodities_name'];?></td>
                <td ><a href="import_export_admin_list.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
            </tr>
             <?php
  $i++;
     }
   }
   }
   ?>
          </tbody>
        </table>
</div>
        
 <div class="col-md-12">
    <div id="piechart" style="width: 100%; height: 500px;"></div> 
 </div>

<?php } ?>        
 
<style>
  ul {
    list-style: none;

  }
  ul li{

  }
</style>
        
 
 
<?php 
if($_REQUEST['action']=='view_details'){?>
  <?php   $memberdata=mysql_query("SELECT *  FROM import_export  where id='$_REQUEST[id]'");
    while($rmemberdata=mysql_fetch_array($memberdata)){
                       $registration_id=$rmemberdata['registration_id'];
                       $rowyear=$rmemberdata['quarter_year'];
                       $rowquartermonth=$rmemberdata['quarter_year_month'];
                       $roworg=$memberdata['registration_id'];
                       $rowimpweight=explode(" , ",$rmemberdata['imp_weight'] );
                       $rowimp_commodities_code =explode(" , ",$rmemberdata['imp_commodities_code'] );
                       $rowimp_commodities_name=explode(" , ",$rmemberdata['imp_commodities_name'] );
                       
                       $rowimp_amt_us=explode(" , ",$rmemberdata['imp_amt_us'] );
                       $rowimp_amt_rs=explode(" , ",$rmemberdata['imp_amt_rs'] );
                       $rowexpweight=explode(",",$rmemberdata['exp_weight'] );
                       $rowexp_amt_us=explode(",",$rmemberdata['exp_amt_us'] );
                       $rowexp_amt_rs=explode(",",$rmemberdata['exp_amt_rs'] );
                        $rowexp_commodities_code=explode(",",$rmemberdata['exp_commodities_code'] );
                        $rowexp_commodities_name=explode(",",trim($rmemberdata['exp_commodities_name']) );
                        ($rowexp_commodities_code);
                        ($rowexp_commodities_name);
                   }
             ?>


 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>
     <tr>
       <td class="content_txt">Organization Name & Address:</td>
       <td class="text6"><?php echo getNameCompany($registration_id);?><br/><?php echo getCompanyAddress($registration_id);?></td>
     </tr>
     <tr>
       <td class="content_txt">Membership No</td>
       <td class="text6"><?php echo getMembershipId($registration_id);?></td>
     </tr>
     <tr>
       <td class="content_txt">IEC No.</td>
       <td class="text6"><?php echo getIec($registration_id);?></td>
     </tr>
        <tr>
       <td class="content_txt">quarter_year </td>
       <td class="text6"><?php echo $rowyear; ?></td>
     </tr>
   </table>
    <div>   <h3>Import Details</h3></div>
   <table class="table" width="100%" border="0" cellspacing="5" cellpadding="5"  >
<tbody>
  <tr><td>Commodities Code</td>
    <td>Commodities Name</td>    
    <td>Weight</td>
    <td>Amount In US</td>
    <td>Amount In Rs</td>
  </tr>
  <tr><td><ul><?php foreach($rowimp_commodities_code as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
    <td><ul><?php foreach($rowimp_commodities_name as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
    
    <td><ul><?php foreach($rowimpweight as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
    <td><ul><?php foreach($rowimp_amt_us as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
    <td><ul><?php foreach($rowimp_amt_rs as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
  </tr>
</tbody>
    
    
   </table>
   <div>  <h3>Export Details</h3></div>
      <table class="table" width="100%" border="0" cellspacing="5" cellpadding="5"  >
<tbody>
  <tr><td>Commodities Code</td>
    <td>Commodities Name</td>
    
    <td>Weight</td>
    <td>Amount In US</td>
    <td>Amount In Rs</td>
  </tr>
  <tr><td><ul><?php foreach($rowexp_commodities_code as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
    <td><ul><?php foreach($rowexp_commodities_name as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
    
    <td><ul><?php foreach($rowexpweight as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
    <td><ul><?php foreach($rowexp_amt_us as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
    <td><ul><?php foreach($rowexp_amt_rs as $val){?>
                    <li><?php echo $val;?></li>
                  <?php } ?>
                  </ul></td>
  </tr>
</tbody>
   </table>
 </div>
 <?php } ?>
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</body>
</html>