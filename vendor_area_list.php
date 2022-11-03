<?php include 'include-new/header.php';
if(!isset($_SESSION['vendorId'])){header('location:vendor_login.php');}
include 'db.inc.php';?>
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
.btn-submit{background: #9c1658;color: #fff; font-weight: 400;font-size: 15px;}
.btn-submit:hover{color: #fff}
.edit_profile {
border: 1px solid #dcd1d1;
padding: 14px;
}
.heading span{font-weight: 700}
.column-2{columns: 2}
.mt-3{margin-top: 30px;}
.mb-2{margin-bottom: 20px;}
/* The container */
.remarks{background: #f0ad4e; padding: 12px;margin-bottom: 12px;border-radius: 5px;text-align: center;position: relative;margin-top: -20px;}
.remarks:after{position: absolute;content: "";
top: -21px;
right: 10px;
width: 0;
height: 0;
border-style: solid;
border-width: 0 10.5px 22px 10.5px;
border-color: transparent transparent #f0ad4e transparent;

}
.area_wrap{background: #f1f1f1;position: relative;border: 1px solid#ccc;border-bottom:3px solid#004ea3; margin-bottom: 15px;}
.btn-apply{display: block;padding: 5px 10px; color: #000;margin-top: 50%;color: #fff}
.bg_blue{background: #004ea3;}
.btn-apply:hover{color: #fff}
.area_inner{min-height: 140px;}
.area_inner h3{font-weight: 600;font-size: 18px}
</style>

<div class="container-fluid">
	<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
	<?php include 'include/vendor_menu.php'; ?>
</div>
<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">
	<div class="">
		
		 <div class="col-md-12 text-center heading"><h3><span>EOI</span>&nbsp;&nbsp;Application List</h3></div>
		<!-- <div class="mb-2"> <h3></h3></div> -->
		<?php $areaSql =$conn->query("SELECT * FROM  vendor_area_master WHERE status= '1' ") ;
		$num_area=$areaSql->num_rows;
		while($row = $areaSql->fetch_assoc()){
       $vendorId = $_SESSION['vendorId'];
       $areaId= $row['id'];
     $getRegistered = $conn->query("SELECT * FROM vendor_area_registration WHERE vendor_id='$vendorId' AND area_id='$areaId'");
     $getRegisteredResult = $getRegistered->fetch_assoc();
     $getRegisteredCount =$getRegistered->num_rows;
			?>
		<div class="col-md-12 area_wrap">
			<div class="col-md-10 area_inner">
				<h3> <?php echo $row['area'];?></h3>
				<p><?php echo $row['description'];?> </p>
			</div>
			<div class="col-md-2 area_inner ">
				<?php if ($getRegisteredCount==0) {?>
				 	<a href="vendor_area_registration.php?id=<?php echo $row['id'];?>" class="btn btn-apply cta">Apply</a> 
				<?php }else{

                if ($getRegisteredResult['status']=='pending') {?>

                <a href="#" class="btn btn-apply btn-warning">Pending</a> 
                <?php }else if($getRegisteredResult['status']=='approved'){?>

                <a href="#" class="btn btn-apply btn-success">Approved</a>
                <?php }else if($getRegisteredResult['status']=='rejected'){?>
                <a  href="vendor_area_registration.php?id=<?php echo $row['id'];?>" class="btn btn-apply btn-danger">Rejected</a>
                <?php  }
				
					
			 } ?>
				
			</div>
			<div class="clearfix"></div>
			<div class="col-md-8"></div>
			<div class="col-md-4"> <?php if ($getRegisteredResult['status']=='rejected') {?>
				<div class="remarks"><p><?php echo $getRegisteredResult['remarks'];?></p></div>
		   <?php 	} ?></div>
			
			
		</div>
	<?php } ?>
		
		
		
	</div>
</div>
</div>

	<?php include 'include-new/footer.php'; ?>
	<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" type="text/javascript"></script>