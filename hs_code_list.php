<?php 
$pageTitle = "Gems And Jewellery Industry In India | HS Code Search - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
include 'functions.php';

		if($_REQUEST['Reset']=="Reset")
		{
		  $_SESSION['commoditySel']	   =""; 
		  $_SESSION['commodity']       =""; 		  
		  $_SESSION['commodity_level'] =""; 		  		  
		  
		  header("Location: hs_code_list.php");
		} else {
		$search_type = $_REQUEST['search_type'];
		
		if(isset($search_type)=="SEARCH")
		{
		$commoditySel 	 = filter($_REQUEST['commoditySel']);
		$commodity = $_POST['commodity'];
		$commodity_level = filter($_REQUEST['commodity_level']);		
		
		$_SESSION['commoditySel'] 	= $commoditySel;
		$_SESSION['commodity_level'] = $commodity_level;
		$_SESSION['commodity'] 		= $commodity;
		
		if($commoditySel=="")
		{  $signup_error = "Please Select Commodity."; }
		else if($commoditySel=="SpecificCommodity" && $commodity=="")
		{  $signup_error = "Please Select Specific Commodity."; }
		else if($commoditySel=="allCommodity" && $commodity_level=="")
		{  $signup_error = "Please Select Commodities Level."; }
		else {

		$sql="SELECT * from statistics_integration_hscode_master where 1";

		if(isset($commoditySel) && $commoditySel=="SpecificCommodity")
		{
			$sql.=" AND hs_code='$commodity'";
		}
		
		if(isset($commodity_level) && $commodity_level!='')
		{
			if($commodity_level==2)
			{
			$sql.=" AND level='2'";
			}else if($commodity_level==4)
			{
			$sql.=" AND level='4'";
			}else if($commodity_level==6)
			{
			$sql.=" AND level='6'";
			}else if($commodity_level==8)
			{
			$sql.=" AND level='8'";
			}
		} 
		
		$sql.=" order by hs_code asc";	
		$sql2 = $sql;		
		$resultx = $conn ->query($sql2);  
		$rCount = $resultx->num_rows;
		$getValue="";
		if($rCount>0) { $getValue=1; } if($rCount==0) { $getValue='NO'; }
		}
		}
		}
?>

<section>       
 
<div class="container inner_container">
    <div class="row justify-content-center mb-0 mt-3">
        <div class="col-12 text-center">
            <h1 class="bold_font">Trade Tools</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        
            <div class="row">
			<form class="cmxform form-export-import col-12 box-shadow mb-4" method="POST" name="hscodeForm" id="hscodeForm" autocomplete="off">
			<input type="hidden" name="search_type" id="search_type" value="SEARCH"/>
			
                <div class="form-group col-12 mb-4">
                    <p class="blue text-center">Chapter 71 <br/>
Natural Or Cultured Pearls, Precious Or Semi-Precious Stones, Precious Metal,
Metals Clad With Precious Metal, <br/>And Articles Thereof; Imitation Jewellery; Coin </br>
List of HS codes as per ITC (HS),2017, Schedule 1-Import Policy </p>
                </div>
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>'; } ?>
               
			    <div class="col-md-1"><div class="form_side_pattern"></div></div>
                <div class="col-md-11 mb-3">
                    <div class="row">                       

                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label>Select Commodity</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8 d-flex justify-content-between">
                          <label class="d-inline-block mr-3 radio-box" for="allCommodity">
						  <input type="radio" name="commoditySel" id="allCommodity" value="allCommodity" <?php if($_SESSION['commoditySel']=="allCommodity"){ echo "checked";}?>> HS Code</label>                          
                          <label  class="d-inline-block radio-box" for="SpecificCommodity">
						  <input type="radio" name="commoditySel" id="SpecificCommodity" value="SpecificCommodity" <?php if($_SESSION['commoditySel']=="SpecificCommodity"){ echo "checked";}?>> Specific Commodity</label>                          
                        </div>
						</div>
                        </div>
						
                        <div class="col-12 mb-2" id="specific-commodity" <?php if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="SpecificCommodity"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
                        <div class="col-3  d-flex align-items-center">
                            <label> Specific Commodity Name</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
                            <select name="commodity" id="commodity" class="form-control search_bar" placeholder="Search Specific Commodity">
                            	<?php 
								$region_query = "select * from statistics_integration_hscode_master where 1 AND status ='1' order by commodity_description";
								$execute_region = $conn ->query($region_query);
								while($show_region = $execute_region->fetch_assoc())
								{
									if($_SESSION['commodity']==$show_region['hs_code'])
									{
										echo "<option value='$show_region[hs_code]' selected='selected'>$show_region[commodity_description]</option>";
									} else
									{
									echo "<option value='$show_region[hs_code]'>$show_region[commodity_description]</option>";
									}
								?>
								<?php } ?> 	 
							</select>
						</div>
                        </div>
						</div>

                         <div class="col-12 mb-2" id="commodity-level" <?php if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="allCommodity"){?> <?php } else { ?> style="display: none" <?php } ?>>
                            <div class="row">
                             <div class="col-3  d-flex align-items-center">
                            <label> Commodities Level</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
                            <select name="commodity_level" id="commodity_level" class="form-control">
                            <option value="">Select Commodity Level</option> 
                            <option value="2" <?php if($_SESSION['commodity_level']=="2"){ echo "selected='selected'";}?>>2 Digit Level</option>
                            <option value="4" <?php if($_SESSION['commodity_level']=="4"){ echo "selected='selected'";}?>>4 Digit Level</option>
							<option value="6" <?php if($_SESSION['commodity_level']=="6"){ echo "selected='selected'";}?>>6 Digit Level</option>
							<option value="8" <?php if($_SESSION['commodity_level']=="8"){ echo "selected='selected'";}?>>8 Digit Level</option>
                            </select>
                        </div>
                        </div>
                        </div>                        
                        
                    <div class="col-12 mt-5">
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                 <input type="submit" name="submit" value="Submit" class="gold_btn fade_anim d-block w-100 mr-3">
                            </div>
                            <div class="col-6">
                                <input type="submit" name="Reset" value="Reset" class="fade_anim btn-reset w-100 d-block ">
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
			</form>
			
			<?php
			if(!empty($getValue==1)) {
			if(isset($rCount) && $rCount>0)
			{ ?>
            <div class="col-12">
                        <div class="row py-3" style="border-top: 1px solid #ccc">
                            <div class="col-12"><h2 class="title text-center mb-1"><span class="d-table mx-auto mb-3" style="width:35px;"><img src="assets/images/black_star.png" class="img-fluid d-block"></span>HS Code wise commodity Description</h2></div>
                            
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <p><strong>Date</strong>: <?php echo date("d/m/Y");?></p>
                                </div>
								<!--<div class="row justify-content-center mt-4">
                                   		<div class="col-md-9 searchResultwrap">
                                        	<ul>
												<?php
												if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="SpecificCommodity"){ 
												?>
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Specific Commodity Name</div>
                                                        <div class="col-md-8 sResult">
															<?php 
															echo getCommodityDescription($_POST['commodity'],$conn);
															?>
                                                        </div>
                                                    </div>
                                                </li>
												<?php }
												if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="allCommodity"){
												?>
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Commodities Level</div>
                                                        <div class="col-md-8 sResult">
														<?php if($_SESSION['commodity_level']=="2"){?>2 Digit Level <?php } ?>
														<?php if($_SESSION['commodity_level']=="4"){?>4 Digit Level <?php } ?>
														</div>
                                                    </div>
                                                </li>
												<?php } ?>
                                            </ul>                                            
                                        </div>                                    
                                   </div>-->
								   
                                 <!--   <div class="d-flex justify-content-start">
                                    <a class="d-inline-block ml-1" title="Download Report" href="#"> <i class="fa fa-file-excel-o" style="font-size: 40px;color: green"></i></a>
                                   </div>-->
                            </div>
                            
                            <div class="col-12">
                                <table class="table table-bordered tableInfo">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>HS Code</th>
                                            <th>Commodity Description</th>
                                            <th>HS Code Digit Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									while($row = $resultx->fetch_assoc())
									{ ?>
										 <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $row['hs_code'];?></td>
                                            <td><?php echo $row['commodity_description'];?></td>
                                            <td>
											<?php 
											if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="allCommodity")
											{
											if($row['level']=="2"){ ?>
											<a target="_blank" href="hs_code_list4.php?hs=<?php echo $row['hs_code'];?>"><u>4</u></a> <a target="_blank" href="hs_code_list6.php?hs=<?php echo $row['hs_code'];?>"><u>6</u></a> <a target="_blank" href="hs_code_list8.php?hs=<?php echo $row['hs_code'];?>"><u>8</u></a>
											<?php }											
											else if($_SESSION['commodity_level']=="4"){ ?><a target="_blank" href="hs_code_list6.php?hs=<?php echo $row['hs_code'];?>"><u>6</u></a> <a target="_blank" href="hs_code_list8.php?hs=<?php echo $row['hs_code'];?>"><u>8</u></a><?php }
											else if($_SESSION['commodity_level']=="6"){ ?><a target="_blank" href="hs_code_list8.php?hs=<?php echo $row['hs_code'];?>"><u>8</u></a><?php }
											
											} 
											if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="SpecificCommodity"){
												if($row['level']=="2"){ ?><a target="_blank" href="hs_code_list4.php?hs=<?php echo $row['hs_code'];?>"><u>4</u></a> <a target="_blank" href="hs_code_list6.php?hs=<?php echo $row['hs_code'];?>"><u>6</u></a> <a target="_blank" href="hs_code_list8.php?hs=<?php echo $row['hs_code'];?>"><u>8</u></a><?php }
												else if($row['level']=="4"){ ?><a target="_blank" href="hs_code_list6.php?hs=<?php echo $row['hs_code'];?>"><u>6</u></a> <a target="_blank" href="hs_code_list8.php?hs=<?php echo $row['hs_code'];?>"><u>8</u></a><?php } 
												else if($row['level']=="6"){ ?><a target="_blank" href="hs_code_list8.php?hs=<?php echo $row['hs_code'];?>"><u>8</u></a><?php }
											}											
											?>
											</td>
										</tr>                                                                   
										<?php 
										$i++; } ?>
                                    </tbody>                                   
                                </table>
                            </div>
							<?php } ?>
                        </div>
						
                    </div> 
					<?php } if(isset($rCount) && $rCount==0){ ?>  No Data Found <?php } ?>
    </div>
</div>
</div>
</section>

<?php include 'include-new/footer.php'; ?>

<style type="text/css">
    .form-export-import label, .form-export-import span{color: #9e9457;font-weight: bold;}
    
    .form_side_pattern:before{content:"";position: absolute;top: 0;bottom: 0;left: 13px;width: 79%;background: url(https://gjepc.org/assets/images/mobile_bg.png) repeat left;background-size: 300px;}
    .radio-box{border:1px solid#9e9457;width: 100%;padding: 6px 5px; border-radius: 5px;}
    .radio-box:hover{background: #9e9457;border:1px solid#9e9457;color:#000;}
    .radio-box input[type=radio]{margin-bottom: 6px }
    .radio-box-active{border:1px solid#7b702c;background: #9e9457;color: #000!important}
    .search_bar{position: relative;}
    .fix-into-input{    position: absolute;
    top: 10px;
    right: 7%;
    font-size: 19px;
    color: #9e9457;cursor: pointer;}
    .fix-into-input:hover{color: #000}
    .btn-reset{    background: #ccc;
    padding: 10px 15px;
    color: #fff;
  
    margin-bottom: 15px;
    position: relative;
    text-align: center;}
    .btn-reset:hover{    background: #a2a1a1;
   }
   .tableInfo thead{background: #000;
    color: #a89c5d;}
    .fstElement {
    display: block;}
    .fstToggleBtn{padding: 8px;font-size: 13px}
    .fstMultipleMode .fstControls{width: 100%}
    .fstChoiceItem,.fstResultItem,.fstMultipleMode .fstQueryInput{font-size: 12px;width: 100%}
    .fstNoResults {
    font-size: 13px;}
    .fstChoiceItem{    border: 1px solid #888158;background-color: #948b52;}
    .fstResultItem.fstSelected {
    color: #fff;
    background-color: #948b52;
    border-color: #847d54;}
    .fstResultItem.fstFocused {
    color: #fff;
    background-color: #948b52;
    border-color: #7d7855;}
    .fstMultipleMode.fstActive .fstResults{max-height:200px }
</style>

<script type="text/javascript">
          $('input[type="radio"]').on("change",function(){
             $('input[type="radio"]:not(:checked)').parent('label').removeClass("radio-box-active");
             $('input[type="radio"]:checked').parent('label').addClass("radio-box-active");
        });
 
    //$("#tableResult").hide();
    //$("#specific-commodity").hide();
    //$("#commodity-level").hide();
    $('input[name="commoditySel"]').on("change",function(){
        var commoditySel = $(this).val();
        if(commoditySel =="SpecificCommodity"){
        $("#specific-commodity").slideDown();
        $("#commodity-level").slideUp();

        }else if(commoditySel="allCommodity"){
        $("#commodity-level").slideDown();
        $("#specific-commodity").slideUp();        
        }
    });
	
      $('#commodity').fastselect();

      $("#commodity_level").on("change",function(){
       var  value = $(this).val();
       if(value=="6"|| value=="8"){
        $("#quantity").slideDown();
       }else{
        $("#quantity").slideUp();
       }

      });
</script>