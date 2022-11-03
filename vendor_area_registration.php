<?php include 'include-new/header_vendor.php';
if(!isset($_SESSION['vendorId'])){header('location:vendor_login.php');}
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
.btn-submit{background: #9c1658;color: #fff; font-weight: 400;font-size: 15px;}
.btn-submit:hover{color: #fff}
.edit_profile {
border: 1px solid #dcd1d1;
padding: 14px;
}
.title{font-size: 30px;}
.title span{font-weight: 900;}
.column-2{columns: 2}
.mb-1{margin-bottom: 10px;}
.mt-3{margin-top: 30px;}
.mb-2{margin-bottom: 20px;}
/* The container */
.checkbox_wrap {
display: block;
position: relative;

margin-bottom: 12px;

font-weight: normal;
}
.line{width: 100%;border:1px solid #86265f;}
.text-dark{font-weight: 700}
.star{position: relative;}
.star:after{position:absolute;content: "*";font-size: 14px;top: 0;right: -10px;color: red}
.coumn-2{column-count: 2}
</style>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="title">
		<h4 class="text-center"> SUPPORTED DOCUMENTS </h4>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
	<?php include 'include/vendor_menu.php'; ?>
</div>

		<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">
	<div class="edit_profile">
		<?php $areaId = $_GET['id']?>
		
		<div class="mb-2 text-center"> <h3 class="title"><span>EOI</span> Application </h3></div>

		<div class="line"></div>
		<?php 
		$areaSql =$conn->query("SELECT * FROM vendor_area_master WHERE status= '1' AND id='$areaId'");	
		$result = $areaSql->fetch_assoc(); ?>
		
		<form class="form-horizontal" id="area_registration">			
			<div class="form-group mt-3">				
				<div class="col-md-4">
					<label>Area:</label>
				</div>
				<div class="col-md-8">
					<p><?php echo $result['area'];?><input type="hidden" name="area" value="<?php echo $result['area'];?>"> </p>
				</div>
				<div class="clearfix"></div>				
			</div>
			<div class="form-group mt-3" >
				<div class="col-md-4">
					<label>Description : </label>
				</div>
				<div class="col-md-8" >
					<p><?php echo $result['description'];?></p>
				</div>
			</div>

			<?php $criteriaSql =$conn ->query("SELECT * FROM  vendor_criteria_master WHERE status= '1' AND area= '$areaId' "); ?>
			
			<div class="form-group mt-3">
				<div class="col-md-4">
					<label class="star">Pre-Qualification Criteria:</label>
				</div>
				<div class="col-md-8 ">
					<ul>
                        <?php $counter = 1;?>
						<?php while($row= $criteriaSql->fetch_assoc()){
							$criteria = $row['criteria'];?>
						<li>
							<label class="checkbox_wrap <?php if(!empty($row['subcriteria'])){echo 'text-dark';}?>"><?php echo $counter.'.';?> <?php echo $criteria;?>														
							</label>
							<?php 
						    $subcriteriaSql =$conn ->query("SELECT * FROM  vendor_criteria_master WHERE status= '1' AND criteria= '$criteria' ");
                            $subrow = $subcriteriaSql->fetch_assoc();
                            $subcriteria = explode(",",$subrow['subcriteria']);
                            ?>
							<ul><?php $x = 'A';?>
								<?php foreach($subcriteria as $val){?>
								<li>
								<label class="checkbox_wrap"><?php if(!empty(trim($subrow['subcriteria']))){ echo $x.'.';}?> <?php echo $val;?>
						
							     </label>
								</li>
							    <?php $x++;} ?>
							</ul>
						</li>

					<?php $counter++; } ?>						
					</ul>		
					
				</div>
			</div>
			<div class="form-group mt-3">
				<div class="col-md-4">
					<label class="star">Uploaded Commmon Documents  :</label>
				</div>
                
				<?php 
			    $vendor_id = $_SESSION['vendorId'];				
			 	$documentSql = $conn->query("SELECT * FROM  vendor_documents WHERE  type='c' ");         
				?>
				<div class="col-md-8">
				    <?php 
				    $sql = $conn ->query("SELECT * FROM vendor_document_uploads WHERE vendor_id= '$vendor_id' "); 	 
                    while($result = $sql->fetch_assoc()){
                    $documentArray[] = $result['document_key'];}
                    ?>
                        <ul class="coumn-2">
						<?php 
                         $counter = 1;
                         
						 while ( $documentResult=$documentSql->fetch_assoc()) {
						 	$docKeyUploaded = $documentResult['document_key'];
						 	 $statusSql = $conn->query("SELECT * FROM vendor_document_uploads WHERE vendor_id= '$vendor_id' AND document_key='$docKeyUploaded' ");
						 	 $resultStatusSql = $statusSql->fetch_assoc();
						 	 ?>  
							     <div class="mb-2"><?php echo $counter.'.';?><?php echo $documentResult['name'];?> <?php if($resultStatusSql['status']=="approved"){?><img src="images/success_mark.png"   ><?php }else if($resultStatusSql['status']=="pending"){?><img src="images/warning-icon.png">	<?php }else if($resultStatusSql['status']=="rejected"){?><img src="images/rejected_docs.png"><?php }else{?> <img src="images/upload_docs.png"><?php } ?></div>
                        
						<?php $counter++; } 
						?>
                       </ul>
						<div class="clearfix"></div>
				</div>
			</div>
             <div class="form-group mt-3">
				<div class="col-md-4">
					<label class="star"> Uploaded Area Specific  Documents  :</label>
				</div>                
					<?php 
					function getDocumentKey($id,$conn)
					{
						$query_sel = "SELECT document_key FROM  vendor_documents  where id='$id'";	
						$result = $conn->query($query_sel);
						$row = $result->fetch_assoc();				 		
							return $row['document_key'];
					}
			    $vendor_id = $_SESSION['vendorId'];
				
			 	$documentSql = $conn ->query("SELECT * FROM  vendor_area_specific_docs WHERE area= '$areaId' AND status='1' ");
                $documentResult = $documentSql->fetch_assoc();
				$getAreaDocument = explode(",",$documentResult['document']);
				?>
				<div class="col-md-8">
				<?php 
				$sql2 = $conn ->query("SELECT * FROM area_spec_doc_upload WHERE vendor_id= '$vendor_id' AND area_id='$areaId' ");
				while($results = $sql2->fetch_assoc()){
                $documentsKeyArray[] = $results['document_key'];
                }
                       /*  print_r($documentsKeyArray);*/
                ?>
                 <ul class="coumn-2">
						<?php 
                         $counter = 1;
                         
                         foreach ($getAreaDocument as $val) {
                             $V_doc_key=getDocumentKey($val,$conn);
                         	
						 	 $V_statusSql = $conn ->query("SELECT * FROM area_spec_doc_upload WHERE vendor_id= '$vendor_id' AND document_key='$V_doc_key' ");
						 	 /*echo "SELECT * FROM vendor_document_uploads WHERE vendor_id= '$vendor_id' AND document_key='$V_doc_key' ";*/
						 	  $V_resultStatusSql = $V_statusSql->fetch_assoc();
						 	 ?>
                          <div class="mb-2"><?php echo $counter.'.';?><?php echo getDocumentName($val,$conn);?><?php if($V_resultStatusSql['status']=="approved"){?><img src="images/success_mark.png"   ><?php }else if($V_resultStatusSql['status']=="pending"){?><img src="images/warning-icon.png">	<?php }else if($V_resultStatusSql['status']=="rejected"){?><img src="images/rejected_docs.png"><?php }else{?> <img src="images/upload_docs.png"><?php } ?></div>

                        <?php $counter++; }						
						?>
                       </ul>
						<div class="clearfix"></div>						
				</div>
			</div>
			<div class="form-group mt-3">
				<div class="col-md-4">
					<ul>
					<li><label>NOTE</label>:</li>					
				</ul>
				</div>
			<div class="col-md-8">					
				<ul><li> <span>Approved :</span> <img src="images/success_mark.png"></li>
					<li> <span>Rejected :</span><img src="images/rejected_docs.png"></li>
					<li> <span>Pending :</span><img src="images/warning-icon.png"></li>
					<li> <span>Not Uploaded :</span><img src="images/upload_docs.png"></li>
				</ul>
			</div>
		</div>
			<div class="form-group mt-3">
				<div class="col-md-4"><label class="star">Agree:</label></div>
				<div class="col-md-8">
					<input type="checkbox" name ="agree" id="agree" ><br>
					<p> ( I agree with the terms and condition )</p>
				</div>
			</div>
			
			<div class="form-group mt-3">				
				<div class="col-md-6">
					<input type="submit" name="submit" value="Submit" class="btn btn-submit">					
					<input type="hidden" name="action" value="area_registration" />
					<input type="hidden" name="areaId" value="<?php echo $areaId;?>" />				
					<input type="hidden" name="vendorId" value="<?php echo $_SESSION['vendorId'];?>" />	  					
				</div>					
				<div class="clearfix"></div>				
			</div>		
		</div>		
	</form>
</div>
	</div>
	
</div>

<div class="clearfix"></div>
<?php include 'include-new/footer.php'; ?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#area_registration").validate({
			//var member_id=$("#member_type_id").val();
		rules: {			
			criteria:
			{
				required:true,
			},
			agree:
			{
				required:true,
			},
			sub_criteria:
			{
				required:true,
			},
	
		},
		messages: {
		
			criteria:{
			required: "Please Select Criteria",
			},
			agree:{
			required: "Please Fill This field",
			},
			sub_criteria:{
			required: "Please Fill This field",
			},
			
		},
		submitHandler: areaRegister

	});
});
function redirectDashboard() {
                    setTimeout(function(){
                     window.location = "vendor_area_list.php"; 
                 }, 1000);
               }
					function areaRegister(){
		
					var formdata = $('#area_registration').serialize();
					/*var data = $("#formenquiry").serialize();*/
				
			$.ajax({
						type:'POST',
						data:formdata,
						url:"vendorAction.php",
						dataType: "json",
						
			            success:function(result){
							
		   if(result['status'] == "success"){
								
						swal({
						title: "success",
						icon: "success",
						text: " Your are successfully submitted the Application"
					});
				redirectDashboard();
				
			
						
			}else if(result['status'] == "c_doc_error"){
								
						swal({
						title: "error",
						icon: "error",
						text: result['message']
					});
				
			}else if(result['status'] == "v_doc_error"){
						
						swal({
						title: "error",
						icon: "error",
						text: result['message']
					});
				
			}else if(result['status'] == "alreadyRegestered"){
						
						swal({
						title: "error",
						icon: "error",
						text: result['message']
					});
				redirectDashboard();
			}

						}
					});
				}
</script>