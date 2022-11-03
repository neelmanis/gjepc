<?php include('../header_include.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: ../admin/index.php'); exit; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dataport</title>
<!-- Main css -->
<link href="css/gjpec.css" rel="stylesheet" type="text/css" />
<!-- Main css -->
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
<div class="text_heading_new">Dataport</div>
<div class="clear"></div>
<div style="margin: 0px auto; width:380px; margin-bottom:25px;">

<div class="detaportbg">
<ul>
<li><a href="download_dgft.php">DGFT</a></li>
<li><a href="final_submission.php">Reset Final Submission</a></li>

<!--<li><a href="webtoerp_export.php">Export New Member Web To ERP</a></li>
<li><a href="renewalwebtoerp_export.php">Export Renewal Web To ERP</a></li>
<li><a href="import_export.php">Import Export Membership Data</a></li>
<li><a href="erptoweb_import.php">Import ERP To Web</a></li>
<li><a href="download_status.php">Activate Download Status</a></li>
<li><a href="import_export_reset.php">Reset Import Export</a></li>
<li><a href="igjme_exhibitor_webtoerp.php">Export IGJME Exhibitor Web To ERP</a></li>
<li><a href="igjme_exhibitor_erptoweb.php">Export IGJME Exhibitor ERP To Web</a></li>
<li><a href="exhibitor_webtoerp.php">Export Exhibitor Web To ERP</a></li>
<li><a href="exhibitor_erptoweb.php">Import Exhibitor ERP To WEB</a></li>-->
</ul>
</div>
</div>
<div style="height:50px;"></div>
<div class="clear"></div>
</div>
<!-- Midle -->
<div class="clear"></div>
</div>
<!-- Midle Bg -->
</div>
<!-- main -->
</body>
</html>