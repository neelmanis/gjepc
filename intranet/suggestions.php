<?php 
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

<script>
	function validate()
	{
		//alert("hello");
		var suggestion = document.getElementById('suggestion').value;
		if(suggestion=='')
		{
			alert('Please Enter Suggestion');
			document.getElementById('suggestion').focus();
			return false;
		}
		
	}
</script>
</head>

<body>

<?php include 'include/header.php';?>

<?php
if(isset($_REQUEST['action']) && $_REQUEST['action']=='save')
{
	$suggestion = $_REQUEST['suggestion'];
	$user_id = $_SESSION['user_id'];
	$post_date = date('Y-m-d');
	
	$query = "insert into suggestion_master (uid,suggestions,post_date) values('$user_id','$suggestion','$post_date')";
	$result = mysql_query($query);
}
?>

<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">Suggestions</div>


<div class="forumHeading">

Kindly give your Suggestions below -


</div>
<form name="form1" id="form1" method="post" onsubmit="return validate()">
<textarea name="suggestion" id="suggestion" cols="" rows="" class="comments"></textarea>


<input type="submit" class="submitBtn" value="submit" />
<input type="hidden" id="action" name="action" value="save">
</form>

</div>  
    

    
    
    
    
    
    
    
    
    

    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->


<?php include 'include/footer.php';?>



</body>
</html>
