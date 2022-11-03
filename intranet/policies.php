<?php 
//include_once('include/header_include.php');
//include_once('include/header_include.php');
session_start();
ob_start();
include_once('db.inc.php');
include_once('functions.php');

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

<div class="heading">Policies 

<div class="selectField">
<select name="Select Year">
<option>2014 - 2013</option>
<option>2013 - 2012</option>
<option>2012 - 2011</option>
<option>2010 - 2009</option>
</select>

</div>

</div>




<div class="boxWrapper">

<?php
 $cat_query = "select * from category_master where 1 order by id desc";
$result_cat=mysql_query($cat_query );
while($row_cat=mysql_fetch_array($result_cat))
	{
	
	echo "<div class='grayBorder'><div class='clear'></div></div>";
	echo "<h2><div style='margin:5px; padding-left:14px;'>".$row_cat['name']."</div></h2>";
 $sql_policy="select * from policy_master where 1 and cat_name='".$row_cat['name']."' order by id desc";

	$result_policy=mysql_query($sql_policy);
	$cnt=mysql_num_rows($result_policy);
if($cnt>0)
{
	while($row=mysql_fetch_array($result_policy))
	{
	
 ?>
<div class="boxPolicy">

<a href='policy/<?php echo $row['cat_name'];?>/<?php echo $row['p_file'];?>' target='_blank'> 

<h1><?php  $post_date=strtotime($row['post_date']); echo $row['p_name'];//date('jS F Y', $post_date); ?></h1>
<div class="borderNew"></div>
<p style=""><?php ?></p>
</a>
</div>
<?php } }}?>
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
