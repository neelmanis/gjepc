<?php 
//include_once('include/header_include.php');
session_start();
ob_start();
include_once('db.inc.php');
include_once('functions.php');
$dept =$_SESSION['department'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC :: Intranet</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel="stylesheet" href="css/liteaccordion.css">
<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>


   <script>
$(document).ready(function(){
	var str=location.href.toLowerCase();
	$(".nav li a").each(function() {
		if (str.indexOf(this.href.toLowerCase()) > -1) {
				$("li").removeClass("active");
				$(this).parent().addClass("active");
		}
	});
});
</script>
</head>

<body>

<?php include 'include/header.php';?>



<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">MIS

<!--<div class="selectField">
<select name="Select Year">
<option>2014 - 2013</option>
<option>2013 - 2012</option>
<option>2012 - 2011</option>
<option>2010 - 2009</option>
</select>

</div>-->

</div>

<div class="grayBorder"></div>

<div class="boxWrapper">
<h2 style="font-size:18px;">coming soon</h2>
<?php $sql_mis="select * from mis_master where 1 order by id desc";

	$result_mis=mysql_query($sql_mis);
	$cnt=mysql_num_rows($result_mis);
if($cnt>0)
{
	while($row=mysql_fetch_array($result_mis))
	{
		
 ?>
<!--<div class="boxPolicy">
	
<!--<a href='images/mis/<?php echo $row['file_name'];?>' target='_blank'> 

<h1><?php  $post_date=strtotime($row['post_date']); echo date('jS F Y', $post_date);?></h1>
<div class="borderNew"></div>
<p style=""><?php echo $row['report_name'];?></p>
</a>
</div>-->
<?php } }?>
<!--<div class="boxPolicy">

<a href="#">
<h1>7 April, 2014</h1>

<div class="borderNew"></div>

<p>
        Recommendation letter for Advance Remittance for import of rough diamonds </p>

</a>

</div>

<div class="boxPolicy">

<a href="#">
<h1>7 April, 2014</h1>

<div class="borderNew"></div>

<p>
        Recommendation letter for Advance Remittance for import of rough diamonds </p>

</a>

</div>

<div class="boxPolicy">

<a href="#">
<h1>7 April, 2014</h1>

<div class="borderNew"></div>

<p>
        Recommendation letter for Advance Remittance for import of rough diamonds </p>

</a>

</div>

<div class="boxPolicy">

<a href="#">
<h1>7 April, 2014</h1>

<div class="borderNew"></div>

<p>
        Recommendation letter for Advance Remittance for import of rough diamonds </p>

</a>

</div>

<div class="boxPolicy">

<a href="#">
<h1>7 April, 2014</h1>

<div class="borderNew"></div>

<p>
        Recommendation letter for Advance Remittance for import of rough diamonds </p>

</a>

</div>-->


<div class="clear"></div>
</div>    
  </div>  
    

    
    
    
    
    
    
    
    
    

    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->


<?php include 'include/footer.php';?>



</body>
</html>
