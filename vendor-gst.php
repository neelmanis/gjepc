<?php 
$pageTitle = "Gem & Jewellery | VENDOR GST - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php include 'include/header.php'; ?>
<?php
include 'db.inc.php';
$action=$_REQUEST['action'];
if($action=="save")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) 
	{
		$vendor_id=filter($_REQUEST['vendor_id']);
		$vendor_name=filter($_REQUEST['vendor_name']);
		$pan_no=filter($_REQUEST['pan_no']);
		$address=filter($_REQUEST['address']);
		$gst_no=filter($_REQUEST['gst_no']);
		$sql="select vendor_id, pan_no from gst_vendor where pan_no='$pan_no'";
		$query = mysql_query($sql);
		$row = mysql_num_rows($query);
		if($row > 0)
		{
		$_SESSION['err_msg']= "Vendor Id or Pan Number already exist";
		}
		else
		{
		$sql1="INSERT INTO gst_vendor set vendor_id='$vendor_id',gst_no='$gst_no',vendor_name='$vendor_name',pan_no='$pan_no',address='$address',post_date=NOW()";
		$result=mysql_query($sql1);
		if($result){
		$_SESSION['succ_msg']="Information saved successfully";
		$vendor_id="";	$vendor_name="";	$pan_no="";	$address="";	$gst_no="";
		}		
		}	
	} else {
	 $_SESSION['succ_msg']="Invalid Token Error";
	}
}
?>
<?php
$vendor_id = $_REQUEST['vendor_id'];
$vendor_name = $_REQUEST['vendor_name'];
$pan_no = $_REQUEST['pan_no'];
$address = $_REQUEST['address'];
$gst_no = $_REQUEST['gst_no'];

$sql = "select * from vender_dump where vendor_id='$vid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
?>

<section>    
    <div class="banner_wrap mb">
            <?php include 'include/inner_banner.php'; ?>            
            <ul class="d-flex breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>GST</li>
                <li class="active"> Vendor GST</li>
            </ul>            
        </div>    
    <div class="container inner_container">    	
        <div class="row mb justify-content-center">

	<div class="col-12">
		<div class="title inner_title">
             <h1> Vendor GST </h1>
		</div>
	</div>
    
	<div class="col-12">
		<?php 
        if($_SESSION['succ_msg']!=""){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
        $_SESSION['succ_msg']="";
        }
        if($_SESSION['err_msg']!=""){
        echo "<div class='alert alert-danger' role='alert'>".$_SESSION['err_msg']."</div>";
        $_SESSION['err_msg']="";
        }
        ?>

		<form class="cmxform row" method="post" name="infoForm" id="infoForm">        
            <input type="hidden" name="action" value="save">
            <?php token(); ?>										
			<div class="form-group col-sm-4">			
			<input type="text" class="form-control" value="<?php echo $row['gst_no'];?>" name="gst_no" id="gst_no" placeholder="GST Number" maxlength='15' minlength='15'>                
			</div> 		
			<div class="form-group col-sm-4">
			<input type="text" class="form-control" value="<?php echo $row['vendor_name'];?>" name="vendor_name" id="vendor_name" placeholder="Vendor Name" maxlength='30'>
			</div>		            	
			<div class="form-group col-sm-4">
            <input type="text" class="form-control" value="<?php echo $row['pan_no'];?>" name="pan_no" id="pan_no" placeholder="PAN No." maxlength='10'>
			</div>            			
			<div class="form-group col-12">
			<textarea style="width:100%; height:100px;" name="address" id="address" class="form-control"><?php echo $row['address'];?></textarea>
			</div>            							                        
			<div class="form-group col-12">
			<button type="submit" class="cta fade_anim" name="submit" value="Submit"> Submit</button>
            </div>	
		</form>	
    </div>    
    	</div>
       </div>    
</section>
    
<?php include 'include/footer.php'; ?>
<script src="assets/js/jquery.validate.js" type="text/javascript"></script> 

<script type="text/javascript">
$().ready(function() {
	
	jQuery.validator.addMethod("panno", function (value, element) {
	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
	if (value.match(regExp) ) {
		return true;
	} else {
		return false;
	};
	},"Please Enter valid PAN No");

	$.validator.addMethod("company_gstn", function(value, element) {
		var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
		if (gstinformat.test(value)) {
			return true;
		} else {
			return false;
		}
	},"Please Enter Valid GSTIN Number");
	
	$("#infoForm").validate({			
		rules: {  			  
			vendor_id:{
				required: true,
			},
			vendor_name:{
				required: true,
			},
			pan_no:{
			    required: true,
				panno: true,
				minlength: 10,
				maxlength:10
			},
			address:{
			    required: true,	
			},
			gst_no:{
			   required: true,
                minlength: 15,
                maxlength: 15,
				company_gstn: true
			},					
		},
		messages: {		
			vendor_id: {
				required: "Please Enter Vender ID",
			}, 
			vendor_name: {
				required: "Please Enter Vender Name",
			},
			pan_no: {
				required: "Enter Company PAN no",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."				
			},
			address: {
				required: "Please Enter Address",
			},
			gst_no: {
				required: "Please Enter GSTIN No.",
				minlength:"Please enter not less than 15 characters",
				maxlength:"Please enter not more than 15 characters"
			},					
		}
	});
});
</script>