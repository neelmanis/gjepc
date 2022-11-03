<?php 
include 'include/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php');exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id = intval(filter($_SESSION['USERID']));
$app_id	=	intval(filter($_SESSION['APP_ID']));
if($_SESSION['APP_ID']==''){ header('location:trade_approval.php'); exit; }
$exhibition_type=getExhibitionType($_SESSION['APP_ID'],$conn);
/*else if(isset($_SESSION['APP_ID']) && $_SESSION['APP_ID']!='')
{
	$exh_sql1="select * from trade_exhibition_info where app_id=$app_id and registration_id='$registration_id'";
	$exh_result1=mysql_query($exh_sql1);
	$exh_cnt=mysql_num_rows($exh_result1);
	if($exh_cnt>0)
	{
		header('location:trade_approval_documents.php');
		exit;
	}
}*/

$info_status =  $conn ->query("select status,region_id,member_type_id from information_master where registration_id='$registration_id' and status=1");
$info_result = $info_status->fetch_assoc();
$info_num = $result->num_rows;

$region_id=$info_result['region_id'];
$member_type_id=$info_result['member_type_id'];
?>
<script type="text/javascript">
function validate()
{
	return false;	
}
</script>

<section>
	<div class="container inner_container">
		<div class="row mb">
    <div class="col-12">
            	<div class="innerpg_title">
                	<h1>My Account - Trade Permission General Info</h1>
                </div>
           </div>

	<div class="col-lg-3 col-md-4 order-md-12" data-sticky_parent>
		<?php include 'include/regMenu.php'; ?>
	</div>

	<div class="col-lg-9 col-md-8 col-sm-12 order-md-1">
		<p class="blue">Trade Approval</p>
<?php 
    if($_SESSION['succ_msg']!=""){
		echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
		$_SESSION['succ_msg']="";
    }
    if($_SESSION['form_chk_msg']!="" || $_SESSION['form_chk_msg1']!="" || $_SESSION['form_chk_msg2']!=""){
		echo "<span class='notification n-attention'>";
		echo "</span>";
		$_SESSION['form_chk_msg']="";
		$_SESSION['form_chk_msg1']="";
		$_SESSION['form_chk_msg2']="";
    }
    ?>		
		<div class="d-flex mb-3 tabHeaders">
			<div class=" tabHead"><a href="trade_approval.php">General</a></div>
			<?php  if($exhibition_type=="exhibition" || $exhibition_type==""){?>
			<div class="tabHead tabactive"><a href="trade_exhibition.php">Exhibition</a></div>
			<?php } ?>
			<div class="tabHead"><a href="trade_approval_documents.php">Documents</a></div>
		</div>	
		
		<form action="" method="post" id="exh_form" name="exh_form" onsubmit="validate();">
			
                <div class="tabCont nopadding" id="th1">
                
						<div class="repeatInThis">
						<?php
						$exh = fetch('select * from trade_exhibition_info where app_id='.$app_id);
            			(count($exh)==0)? $exhcount = count($exh)+1 : $exhcount = count($exh);
						$idarray = array();
						for($i=0;$i<$exhcount;$i++){
							$idarray[] = $exh[$i]['exh_id'];
						?>
						<?php 
						$query1 = $conn ->query("select * from trade_general_info where app_id='$app_id'");
						$result=  $query1->fetch_assoc();
						$application_status=$result['application_status'];

						if($application_status=='Y' || $application_status=='C')
						{
						?>
							<div class="row repeatThis">                            
								<div class="form-group col-12">                                
									<div class="col-12">
										<p class="lead blue">Exhibition <?php echo $i+1;?></p>
									</div>                                
                                </div>
                                    
								<div class="trade_lable1 col-sm-6">
                                <label class="form-label" for="exhibition1">Exhibition Name <?php echo $i+1;?>*:</label>
										<select name="exhibition_1[]" id="exhibition_1[]" class="form-control">
				                            <option value="" selected disabled>---------- Select ----------</option>
				                            <?php
				                            $sql_exh_master = $conn ->query("select * from trade_exhibition_master order by Exhibition_Id desc");
				                            while($result_exh_master =  $sql_exh_master->fetch_assoc())  {
				                            ?>
				                            <option value="<?php echo $result_exh_master['Exhibition_Id']; ?>" <?php if($exh[$i]['exhibition_id']==$result_exh_master['Exhibition_Id']) echo 'selected="selected"' ; ?>><?php echo $result_exh_master['Exhibition_Name']." From (".$result_exh_master['From_Date']." - ".$result_exh_master['To_Date'].")";  ?></option>
				                            <?php } ?>
				                         </select>									
								</div>
                                
								<div class="form-group col-sm-6">
									<div class="trade_lable1"><label class="form-label" for="dateFrom1">Exhibition Date From <?php echo $i+1;?>:</label></div>
									<input type="text" class="form-control" name="dateFrom_1[]" id="dateFrom_1[]" value="<?php echo $exh[$i]['exhibition_date_from']; ?>" disabled="disabled">
								</div>
                                
								<div class="form-group col-sm-6">
									<div class="trade_lable1"><label class="form-label" for="dateTo1">Exhibition Date To <?php echo $i+1;?>:</label></div>
									<input type="text" class="form-control" name="dateTo_1[]" id="dateTo_1[]" value="<?php echo $exh[$i]['exhibition_date_to']; ?>" onchange="checkDate()" disabled="disabled">
								</div>
                                
								<div class="form-group col-sm-6">
									<div class="trade_lable1"><label class="form-label" for="organizer_address">Organizer address <?php echo $i+1;?>:</label></div>
									<input type="text" class="form-control" name="organizer_address[]" id="organizer_address[]" value="<?php echo $exh[$i]['organizer_address']; ?>" readonly="readonly">
								</div>
                                
								<div class="form-group col-sm-6">
									<div class="trade_lable1"><label class="form-label" for="venue_address">Venue address <?php echo $i+1;?>:</label></div>
									<input type="text" class="form-control" name="venue_address[]" id="venue_address[]" value="<?php echo $exh[$i]['venue_address']; ?>" readonly="readonly">
								</div>
								
							</div>
							<?php } else { ?>
							
							<div class="repeatThis row">
                            
								<div class="form-group col-12">
										<p class="blue">Exhibition <?php echo $i+1;?></p>
								</div>                                
                                <div class="form-group col-sm-6">
                                
                                	<div class="trade_lable1 "><label class="form-label" for="exhibition1">Exhibition Name <?php echo $i+1;?>*:</label></div>
										<select name="exhibition_1[]" id="exhibition_1[]" class="form-control">
										<option value="">---------- Select ----------</option>
										<?php
				                        $sql_exh_master = $conn ->query("select * from trade_exhibition_master order by Exhibition_Id desc");
				                        while($result_exh_master =  $sql_exh_master->fetch_assoc())  {
				                        ?>										
										<option value="<?php echo $result_exh_master['Exhibition_Id']; ?>" <?php if($exh[$i]['exhibition_id']==$result_exh_master['Exhibition_Id']) echo 'selected="selected"' ; ?>><?php echo filter($result_exh_master['Exhibition_Name'])." From (".$result_exh_master['From_Date']." - ".$result_exh_master['To_Date'].")";  ?></option>
										<?php } ?>
									  </select>									
								</div>
                                
								<div class="form-group col-sm-6">
									<div class="trade_lable1"><label class="form-label" for="dateFrom1">Exhibition Date From <?php echo $i+1;?>:</label></div>
									<input type="text" class="form-control" name="dateFrom_1[]" id="dateFrom_1[]" value="<?php echo $exh[$i]['exhibition_date_from']; ?>" readonly="readonly">
								</div>
                                
								<div class="form-group col-sm-6">
									<div class="trade_lable1"><label class="form-label" for="dateTo1">Exhibition Date To <?php echo $i+1;?>:</label></div>
									<input type="text" class="form-control" name="dateTo_1[]" id="dateTo_1[]" value="<?php echo $exh[$i]['exhibition_date_to']; ?>" onchange="checkDate()" readonly="readonly">
								</div>
                                
								<div class="form-group col-sm-6">
									<div class="trade_lable1"><label class="form-label" for="organizer_address">Organizer address <?php echo $i+1;?>:</label></div>
									<input type="text" class="form-control" name="organizer_address[]" id="organizer_address[]" value="<?php echo $exh[$i]['organizer_address']; ?>" readonly="readonly">
								</div>
                                
								<div class="form-group col-sm-6">
									<div class="trade_lable1 col-md-6"><label class="form-label" for="venue_address">Venue address <?php echo $i+1;?>:</label></div>
									<input type="text" class="form-control" name="venue_address[]" id="venue_address[]" value="<?php echo $exh[$i]['venue_address']; ?>" readonly="readonly">
								</div>
								<!-- <hr> -->
							</div>
							<?php } ?>
							<?php } ?>						
							
						</div>
                        
						<div class="addMore form-group col-12">
							<button class="add_field_button">Add More Fields</button>
							<button class="remove_field_button">Remove Fields</button>
						</div>
										
                    
					<div class="col-12">
					 	<input type="hidden" value="<?php echo $app_id; ?>" name="app_id" />
						<input type="submit" value="Next" name="sub" id="sub" class="cta fade_anim" />
					</div>			
				</div>
		
		</form>
	</div>
    
    </div>
    
    </div>
    
    </section>


<?php include 'include/footer.php'; ?>

<script type="text/javascript"> 
(function($){
	/*var duplicate = $('.repeatThis').last();*/


function refreshEventListner(){

$('[id="exhibition_1[]"]').off(); 

$('[id="exhibition_1[]"]').on('change',function(){
	// $('[id="exhibition_1[]"]').change(function() {
	// alert("dlfkd");
	 var $this=jQuery(this);
	 var exh_id = $(this).val();
	  $.ajax({ type: 'POST',
			url: 'ajax_trade.php',
			data: "actiontype=exh_option&&exh_id="+exh_id,
			dataType:'html',
			beforeSend: function(){
					},
			success: function(data){
				//alert(data);
				 if($.trim(data)!=""){
					 data=data.split("#");
						$this.closest('.repeatThis').find('[id="dateFrom_1[]"]').val(data[0]);
						$this.closest('.repeatThis').find('[id="dateTo_1[]"]').val(data[1]);
						$this.closest('.repeatThis').find('[id="organizer_address[]"]').val(data[2]);
						$this.closest('.repeatThis').find('[id="venue_address[]"]').val(data[3]);
				 }
			}
	});
});

}

$('.add_field_button').on('click',function(e){ 
		e.preventDefault();
		$('.repeatThis').each(function(index,element){
			// $(this).find('.datepicker').datepick('destroy');
		});
		var duplicate = $('.repeatThis:last');
		var cloned = duplicate.clone()
			.appendTo('.repeatInThis');
		
		$('.repeatThis').each(function(index,element){
			// $(this).find('.datepicker').datepick({dateFormat: "dd-mm-yyyy"});
		});
	
		cloned.find('div.trade_lable1, div.head,input').each(function(index, element){
			var currText = $(this).text();
			var labelData = currText.split(' ');
			var lastspace = currText.lastIndexOf(' ');
			var stripText = currText.substring(0, lastspace);
			var replaceLabel = stripText +' '+ currText.replace(currText, parseInt(labelData[labelData.length-1])+1);
			$(this).text(replaceLabel);
			var elem = $(this);
			if(elem.attr('type')=="text")
			 	elem.val('');
			else
				elem.removeAttr('checked');
		});


		refreshEventListner();

	});

	$('.remove_field_button').bind('click',function(e){ 
		e.preventDefault();
		var exhibitorDiv = $('.repeatThis:last');

		if($('.repeatThis').length > 1){
			exhibitorDiv.remove();
		}
	});

	/*$('.datepicker').datepick({
	dateFormat: 'dd-mm-yyyy'
	});*/
	
	
	$("#sub").click(function(e){
		e.preventDefault();
		//alert(myElements = document.getElementsByName("exhibition_1[]").length );
		j=1;
		for (i=0; i<document.getElementsByName("exhibition_1[]").length; i++) { 	
		  if (document.getElementsByName("exhibition_1[]")[i].value=='') { 
		   alert("please enter Exhibition Name "+j);
		   return false; 
		  } 
		  if (document.getElementsByName("dateFrom_1[]")[i].value=='') { 
		   alert("please enter Date From "+j);
		   return false; 
		  } 
		  
		  
		  if (document.getElementsByName("dateTo_1[]")[i].value=='') { 
		   alert("please enter Date To "+j);
		   return false; 
		  }
		  
		  date_from=document.getElementsByName("dateFrom_1[]")[i].value;
		  date_to=document.getElementsByName("dateTo_1[]")[i].value;
		  
			var fdate_split = date_from.split('-');
			var date_from1 = new Date(fdate_split[2], fdate_split[1], fdate_split[0]); //Y M D
			var date_from_final = date_from1.getTime();
			
			var tdate_split = date_to.split('-');
			var date_to1 = new Date(tdate_split[2], tdate_split[1], tdate_split[0]); //Y M D
			var date_to_final = date_to1.getTime();
		  
		  function daydiff(date_from_final, date_to_final) {
  			  return (date_to_final-date_from_final)/(1000*60*60*24);
		 }
		 daysDiff=daydiff(date_from_final,date_to_final);
			//if(daysDiff>45) 27-NOV-2017
			// if(daysDiff>47)
			// {
			// 	alert("The from date and to date should not exceed 45 days");
			// 	return false;
				
			// }
		
			//return false;
  		  if (document.getElementsByName("organizer_address[]")[i].value=='') { 
		   alert("please enter Organizer Address "+j);
		   return false; 
		  } 
		  
		  if (document.getElementsByName("venue_address[]")[i].value=='') { 
		   alert("please enter Venue Address "+j);
		   return false; 
		  } 
		  
		  j++;
 		} 
 		var exh_form = $("#exh_form").serialize();
		//alert('hello');
		$.ajax({ type: 'POST',
					url: 'ajax_trade.php',
					data: "actiontype=exh_value&"+exh_form,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						 if($.trim(data)!=""){
							 //$('#selected_area').html(data);
							
							 if(data=='insert')
							 {
							 	window.location.href='trade_approval_documents.php';
							 }else
							 {
							 	alert(data);
							 }					 
						 }
					}
		});
	});
}(jQuery));
</script>

<script type="text/javascript">

	jQuery(document).ready(function($) {
		
function refreshEventListner(){

$('[id="exhibition_1[]"]').off(); 

$('[id="exhibition_1[]"]').on('change',function(){
	// $('[id="exhibition_1[]"]').change(function() {
	// alert("dlfkd");
	 var $this=jQuery(this);
	 var exh_id = $(this).val();
	  $.ajax({ type: 'POST',
			url: 'ajax_trade.php',
			data: "actiontype=exh_option&&exh_id="+exh_id,
			dataType:'html',
			beforeSend: function(){
					},
			success: function(data){
				//alert(data);
				 if($.trim(data)!=""){
					 data=data.split("#");
						$this.closest('.repeatThis').find('[id="dateFrom_1[]"]').val(data[0]);
						$this.closest('.repeatThis').find('[id="dateTo_1[]"]').val(data[1]);
						$this.closest('.repeatThis').find('[id="organizer_address[]"]').val(data[2]);
						$this.closest('.repeatThis').find('[id="venue_address[]"]').val(data[3]);
				 }
			}
	});
});
}
		refreshEventListner();
	});
</script>