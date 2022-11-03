<?php include('../header_include.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dataport</title>
<!-- Main css -->
<link href="css/gjpec.css" rel="stylesheet" type="text/css" />
<!-- Main css -->
<script src="../jquery.min.js"></script> 
<link href="../css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#date_from').datepick();
	$('#date_to').datepick();
});
</script>

</head>

<body>
<!-- main -->
<div class="main">

<!-- Midle Bg -->
<div class="inner_mainwidth">

<div style="height:70px;"></div>

<!-- Midle -->
<div class="inner_midle_bgdeta">

<div style="background-color:#; text-align:center;"><a href="index.php"><img src="../images/gjepc_logo.png" width="176" height="94" /></a></div>
<div class="clear"></div>
<div class="text_heading_new">Merchant Download Date wise</div>
<div class="clear"></div>


<div style="margin: 0px auto;  margin-bottom:25px;">
<div>
		<form action="merchant.php" method="post" name="form1" id="form1" enctype="multipart/form-data">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr class="orange1">
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="28%">&nbsp;</td>
                     <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td align="left" class="content_txt"></td>
                    <td width="72%" align="left">
                    From <input type="text" id="date_from" name="date_from" autocomplete="off"/> To<input type="text" id="date_to" name="date_to" autocomplete="off"/>
                    </td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td align="left" >&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" class="content_txt"></td>
                    <td align="left"><input type="image" src="images/submit.png"  id="save" name="save" value="Submit"/>
                    </td>
                  </tr>
                </table>
	    </form>
    </div>
</div>

	<div style="height:50px;"></div>
	<div class="clear"></div>
</div>
	<div class="clear"></div>
	</div>
	</div>
	</body>
</html>
