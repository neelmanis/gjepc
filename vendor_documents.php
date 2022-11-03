<?php 
include 'include-new/header.php';
if(!isset($_SESSION['vendorId'])){ header('location:vendor_login.php'); }
include 'db.inc.php';
include 'functions.php';
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

.mb-1{margin-top: 10px;}
.mt-2{margin-top: 10px;}
.mt-3{margin-top: 20px;}
.edit_profile {
border: 1px solid #dcd1d1;
padding: 14px;

}
.fa-download{font-size: 20px ;margin-top: 5px}

.status{text-align: center; padding: 6px 10px; border-radius: 3px;background: #f0ad4e;color: #fff;display: inline-block; }
.status_a{text-align: center; padding: 6px 10px; border-radius: 3px;background: #449d44;color: #fff; display: inline-block;}
.status_r{text-align: center; padding: 6px 10px; border-radius: 3px;background: #c9302c;color: #fff; display: inline-block;}
.status_u{text-align: center; padding: 6px 10px; border-radius: 3px;background: #2e6da4;color: #fff; display: inline-block;}

.top_heading{border-bottom: 1px solid #000;}
.doc_status{padding: 5px 8px;}
.no_padding{padding: 0!important}
.form_title h3{background:#ccc;padding: 6px 10px; text-align: center;border-radius: 4px;    font-size: 20px;
 }
input[type="submit"]:disabled {background: #ccc;color:#000;}
.mb-2{margin-bottom: 20px;}
.remark{background: #f0ad4e;text-align: center;border-radius: 5px;padding: 5px;position: relative;-webkit-box-shadow: 10px 14px 11px -10px rgba(0,0,0,0.75);
-moz-box-shadow: 10px 14px 11px -10px rgba(0,0,0,0.75);
box-shadow: 10px 14px 11px -10px rgba(0,0,0,0.75);}
.remark:after{position: absolute;content: "";
top: -21px;
right: 10px;
width: 0;
height: 0;
border-style: solid;
border-width: 0 10.5px 22px 10.5px;
border-color: transparent transparent #f0ad4e transparent;

}
.error{color: red;}
.remark_wrp{padding: 0 40px}
</style>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="title">
		<h4 class="text-center"> SUPPORTED DoCUMENTS </h4>
	</div>
</div>
<div class="col-md-3 col-sm-4 col-xs-12 wrapper selectedSpeaker">
	<?php include 'include/vendor_menu.php'; ?>
</div>
<div class="col-md-9 col-sm-8 col-xs-12 speakerSelector">
	<div class="edit_profile">		
		<div class="mb-2 form_title"> <h3>Common Documents For All Area (.PDF,.PNG,.JPG,.JPEG ,size upto 2MB) </h3></div>
		
		<?php
		$vendorId = $_SESSION['vendorId'];
		$c_documents =$conn ->query("SELECT * FROM vendor_documents WHERE status='1' AND type='c'");
		$v_documents =$conn ->query("SELECT * FROM vendor_documents WHERE status='1' AND type='v'");
		$uploaded_docs = $conn ->query("SELECT * FROM vendor_document_uploads WHERE vendor_id ='$vendorId'");
		$result_docs = $uploaded_docs->fetch_assoc();
		$num_result_docs= $uploaded_docs->num_rows;
		$document_name = implode(",", $result_docs['document_name']);
		$document = explode(",",$result_docs['document']);
		$documentCount = count($document);
		$num_c_documents= $c_documents->num_rows;;
		$num_v_documents= $v_documents->num_rows;;?>

		    	<div class="form-group mt-3 top_heading">
				<div class="row">
				<div class="col-md-5">
					<label >Document Name</label>
				</div>
				<div class="col-md-3">					
					<label>Upload File</label>
				</div>
				<div class="col-md-1 ">
					<label> Action</label>
				</div>
				<div class="col-md-1">
					<label> Download</label>
				</div>
				<div class="col-md-2">
					<label >Status</label>
				</div>
				</div>
				<div class="clearfix"></div>
				
			</div>
			<?php if($num_c_documents>0){
			$filecount_c =1;

			while($row = $c_documents->fetch_assoc()){?>
				<form class="form-horizontal" id="<?php echo $filecount_c;?>documents_upload" enctype="multipart/form-data" >
			<div class="form-group mt-3">
				    <?php
                    $c_doc_key =$row['document_key'];
					$getCommonDocs = $conn ->query("SELECT * FROM vendor_document_uploads WHERE vendor_id='$vendorId' AND document_key='$c_doc_key'");
					$getResult= $getCommonDocs->fetch_assoc();

					$remark  = $getResult['remark'];
					$status  = $getResult['status'];
                    $getResultCount = $getCommonDocs->num_rows;
					?>
				<div class="col-md-5">
				<label ><?php echo $row['name']?><input type="hidden" name="document_key" id="document_key"  value="<?php echo $row['document_key']?>"></label>
				</div>
				<div class="col-xs-6 col-md-3">
				<input type="file" name="document"  id="document" class="form-control" >
				</div>

				<div class="col-xs-3 col-md-1 ">
					<input type="submit" name="submit" id="submit" data-id="<?php echo $filecount_c; ?>" value="<?php if ($getResultCount>0) {echo "Update"; }else{echo "Submit";} ?>" class="btn cta  btn-submit" <?php if ($getResult['status']=="approved") { echo "disabled";}?> >
					
                     <input type="hidden" name="docName" value="<?php echo $row['name'];?>"/>
                     <input type="hidden" name="docType" value="<?php echo $row['type'];?>"/>
                     <input type="hidden" name="action" value="document_upload"/>
					<input type="hidden" name="vendorId" value="<?php echo $_SESSION['vendorId'];?>" />
				</div>
				<div class=" col-xs-1 col-md-1" style="text-align: right;">
                    <?php if ($getResultCount>0) {?>
                    	<a href="<?php echo $getResult['document'];?>" download><i class="fa fa-download" aria-hidden="true"></i></a>
                    <?php } ?>
					
				</div>
				
			 <div class="col-xs-2 col-md-2">
			 	 <span class="doc_status"><?php if($getResult['status']=="pending"){ echo '<span class=" btn-warning status" >Pending</span>';}else if($getResult['status']=="approved"){echo '<span class=" btn-success status_a" >Approved</span>';}else if($getResult['status']=="rejected"){echo '<span class=" btn-danger status_r" >Rejected</span>';} ?></span>
			 </div>
				
				<div class="clearfix"></div>
			
				 <?php if ($status=="rejected") {?>
				 	<div class="remark_wrp">
					<div class="col-md-7 mt-3"> </div>
					<div class="col-md-5 mt-3 remark"><?php echo $getResult['remarks'];?></div>
					</div>  <?php } ?>
			</div>
				</form>
			<?php $filecount_c++;} }else{?>
			<div class="text-center">No data Added</div>
			<?php } ?>
			

			<div class="mb-2 form_title"> <h3>Area Specific Documents(.PDF,.PNG,.JPG,.JPEG ,size upto 2MB) </h3></div>

			<?php if($num_v_documents>0){
			$fileCount_v =1;
			while($row = $v_documents->fetch_assoc()){?>
				<form class="form-horizontal" id="<?php echo $fileCount_v;?>documents_upload_v" enctype="multipart/form-data" >
			<div class="form-group mt-3">
				<?php $documentKey = $row['document_key'];?> 
				<div class="col-md-5">
					<label ><?php echo $row['name']?><input type="hidden" name="document_key" id="document_key"  value="<?php echo $row['document_key']?>"></label>
				
				</div>
				<div class="col-md-2">
                  
					<?php
                     $doc_id = $row['id'];
					 $areaSql = $conn ->query("SELECT * FROM vendor_area_specific_docs WHERE document LIKE '%$doc_id%'");?>
					<select class="form-control" name="area" id="area">
						<option value="">Select Area</option>
						<?php while($result_area =  $areaSql->fetch_assoc()){?>
						<option value="<?php echo $result_area['area']?>"><?php echo getVendorAreaName($result_area['area'],$conn);?></option>
					<?php }?>
						
					</select>
					<p class="areaBlank error"></p>
				</div>
				<div class="col-xs-6 col-md-3">					
					<input type="file" name="document"  id="document" class="form-control" >
				</div>				

				<div class="col-xs-6 col-md-2">
					<input type="submit" name="submit" id="submit" data-id="<?php echo $fileCount_v; ?>" value="Submit" class="btn cta text-light btn-submit-v ">
                     <input type="hidden" name="docName" value="<?php echo $row['name'];?>"/>
                     <input type="hidden" name="docType" value="<?php echo $row['type'];?>"/>
                     <input type="hidden" name="action" value="document_upload_v"/>
					<input type="hidden" name="vendorId" value="<?php echo $_SESSION['vendorId'];?>" />
				</div>
				
				<div class="clearfix"></div>
					<div class="col-md-12">
						<?php $docArea= $conn ->query("SELECT * FROM area_spec_doc_upload Where vendor_id='$vendorId' AND document_key='$documentKey' ")  ;
						$counter = 1;
                         while ($docs_area_result =  $docArea->fetch_assoc()) {?>
                         	<div class="row">
                         	 <div class="mt-2 col-md-12">
                         	<div class=" col-md-1"><?php echo $counter.')';?></div>
                         	<div class="col-md-7"><p><?php echo getVendorAreaName($docs_area_result['area_id'],$conn) ?></p> 
								
                          </div>
                          <div class="col-md-2">
                    
                    	<a href="<?php echo $docs_area_result['document']?>" download><i class="fa fa-download " aria-hidden="true"></i></a>
                  
                          </div>
                          <div class="col-md-2"><span class="doc_status"><?php if($docs_area_result['status']=="pending"){ echo '<span class=" btn-warning status" >Pending</span>';}else if($docs_area_result['status']=="approved"){echo '<span class=" btn-success status_a" >Approved</span>';}else{echo '<span class=" btn-danger status_r" >Rejected</span>';} ?></span></div>

                         </div>
                     </div>
                     <div class="clearfix"></div>
                     <?php 
                      if ($docs_area_result['status']=="rejected") {?>
				 	<div class="remark_wrp">
					<div class="col-md-7 mt-3"> </div>
					<div class="col-md-5 mt-3 remark"><?php echo $docs_area_result['remarks'];?></div>
					</div>  <?php } ?>
                         	
                        <?php $counter++;  }                          
						?>
					</div>				
			</div>
				</form>
			<?php $fileCount_v++;} }else{?>
			<div class="text-center">No data Added</div>
			<?php } ?>
		</div>		
</div>
<div class="clearfix"></div>
<?php include 'include-new/footer.php'; ?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" type="text/javascript"></script>
<script>
$(".btn-submit").on("click",function(e){
   e.preventDefault();	
   var id = $(this).data('id');

    var form = $('#'+id+'documents_upload');
    var formdata = false;
    if (window.FormData){
        formdata = new FormData(form[0]);
    }

    var formAction = form.attr('action');
  	//var formData =  new FormData('#'+id+'documents_upload');
  
   	//var formData =   $('#'+id+'documents_upload').serialize();
   /*alert(formData);return false;*/
  //alert( $('#'+id+'documents_upload').serialize());return false;
    $.ajax({
           type: "POST",
           
            url: "vendorAction.php",
            data:formdata ? formdata : form.serialize(),
            dataType: "json",
            cache:false,
            contentType: false,
            processData: false,
		    beforeSend:function(){
			$("#submit").attr("disabled", true);
			},
           success: function(result) {
           	$("#submit").attr("disabled", false);
        if(result['status'] == "successInsert"){
					swal({
						title: "success",
						icon: "success",
						text: "Your Documemnt Successfully uploaded"
					});	
					  redirectDashboard();
				
			
						
			}else if(result['status'] == "successUpdate"){
				    swal({
						title: "success",
						icon: "success",
						text: "Your Documemnt Successfully Updated"
					});
             		 redirectDashboard();

			}else if(result['status'] == "invalidDocs"){
				swal({
						title: "error",
						icon: "warning",
						text: "You Are Selected Invalid Document"
					});

			}
           }
    })
    
});
function redirectDashboard() {
                    setTimeout(function(){
                     window.location = "vendor_documents.php"; 
                 }, 1000);
               }
$(".btn-submit-v").on("click",function(e){
   e.preventDefault();	
   var id = $(this).data('id');

    var form = $('#'+id+'documents_upload_v');
    var formdata = false;
    if (window.FormData){
        formdata = new FormData(form[0]);
    }

    var formAction = form.attr('action');
  	//var formData =  new FormData('#'+id+'documents_upload');
  
   	//var formData =   $('#'+id+'documents_upload').serialize();
   /*alert(formData);return false;*/
  //alert( $('#'+id+'documents_upload').serialize());return false;
    $.ajax({
           type: "POST",
           
            url: "vendorAction.php",
            data:formdata ? formdata : form.serialize(),
            dataType: "json",
            cache:false,
            contentType: false,
            processData: false,
		    beforeSend:function(){
			$("#submit").attr("disabled", true);
			},
           success: function(result) {
           	$("#submit").attr("disabled", false);
               					if(result['status'] == "successInsert"){
					swal({
						title: "success",
						icon: "success",
						text: result['message']
					});	
					  redirectDashboard();
				
			
						
			}else if(result['status'] == "successUpdate"){
				    swal({
						title: "success",
						icon: "success",
						text: result['message']
					});
             		 redirectDashboard();

			}else if(result['status'] == "areaBlank"){
             $('.areaBlank').text("Please Select Area");
			}else if(result['status'] == "invalidDocs"){
				swal({
						title: "error",
						icon: "warning",
						text: result['message']
					});

			}
           }	
    })
    
});
</script>