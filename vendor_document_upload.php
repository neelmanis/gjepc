<?php 
include 'include/header_vendor.php';
if(!isset($_SESSION['vendorId'])){ header('location:vendor_login.php'); }
include 'db.inc.php'; ?>

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
.mb-2{margin-bottom: 20px;}
</style>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" type="text/javascript"></script>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="title">
		<h4><?php echo $_SESSION['company_name'];?> SUPPORTED DoCUMENTS </h4>
	</div>
</div>
<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
	<?php include 'include/vendor_menu.php'; ?>
</div>
<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">
	<div class="edit_profile">		
		
		<div class="mb-2"> <h3>Common  Documents </h3></div>		
		
		<?php
		$vendorId = $_SESSION['vendorId'];
		$documents = $conn ->query("SELECT * FROM vendor_documents WHERE status='1' AND type='c'");
		$uploaded_docs =  $conn ->query("SELECT * FROM vendor_document_uploads WHERE vendor_id ='$vendorId'");
		$result_docs = $uploaded_docs->fetch_assoc();
		$num_result_docs= $uploaded_docs->num_rows;
		$document_name = implode(",", $result_docs['document_name']);
		$document = explode(",",$result_docs['document']);
		$documentCount = count($document);
		$num_documents= $documents->num_rows;
		?>

		<?php if($num_documents>0){
			$fileCount =1;
			while($row= $documents->fetch_assoc()){?>
				<form class="form-horizontal" id="<?php echo $fileCount .'_';?>documents_upload">
			<div class="form-group mt-3">
				
				<div class="col-md-6">
					<label ><?php echo $row['name']?><input type="hidden" name="document_key" id="document_key"  value="<?php echo $row['document_key']?>"></label>
				</div>
				<div class="col-md-4">
					
					<input type="file" name="document"  id="document" class="form-control" >
				</div>

				<div class="col-md-2">
					<input type="submit" name="submit" id="submit" data-id="<?php echo $fileCount; ?>" value="Submit" class="btn btn-submit">
                     <input type="hidden" name="action" value="document_upload"/>
					<input type="hidden" name="vendorId" value="<?php echo $_SESSION['vendorId'];?>" />
				</div>
				<div class="clearfix"></div>
				
			</div>
				</form>
			<?php $fileCount++;} }else{?>
			<div class="text-center">No data Added</div>
			<?php } ?>			
		</div>		
</div>
<div class="clearfix"></div>
<?php include 'include/footer.php'; ?>

<script>
$(".btn-submit").on("click",function(e){
   e.preventDefault();	
   var id = $(this).data('id');
   	//var formData =  new FormData('#'+id+'documents_upload');
   	var formData =  $('#'+id+'_documents_upload').serialize();

   //alert( $('#'+id+'documents_upload').serialize());return false;
    $.ajax({
           type: "POST",
          
            data: formData,
            url: "vendorDocumentAction.php",
            dataType: "html",
			processData : false,
			 contentType: false,
			mimeType : 'multipart/form-data',
           success: function(data) {
               //alert(data); // show response from the php script.
           }
    })
    
});
</script>