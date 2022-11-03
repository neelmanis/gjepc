<?php 
include 'include/header_vendor.php';
if(!isset($_SESSION['vendorId'])){header('location:vendor_login.php');}
include 'db.inc.php';
?>
<link rel="stylesheet" href="css/bootstrap.min.css">
<style>
	.info_table{border:1px solid #dcd1d1;border-top: 0px solid #000;position:relative;}
	.info_table table{margin-bottom: 0px;}
	.edit_panel{position: absolute;
    top: -14px;
    right: 37px;
    z-index: 999;
    background: #fff;}
    .fa-pencil-square-o{font-size: 35px;color: #86265f}
    .info_table table tbody tr th:first-child{border-right:1px solid#ddd;font-size: 15px; font-weight: bold;}
     .info_table table tbody tr th{padding:14px 14px;}
</style>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="title">
		<h4><?php echo $_SESSION['company_name'];?> Dashboard </h4>
	</div>
</div>
<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
	<?php include 'include/vendor_menu.php'; ?>
</div>
<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector"></div>
<div class="clearfix"></div>

<?php include 'include/footer.php'; ?>
<script>
$(document).ready(function(){
	$('.fa-pencil-square-o').on("click", function() {
	$(".info_table").fadeOut();
});
}); 
</script>