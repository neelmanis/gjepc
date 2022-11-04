<?php 
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php');exit; }
include 'db.inc.php';
include 'functions.php';
$registration_id = intval(filter($_SESSION['USERID']));
?>
<?php 
if(isset($_REQUEST['app_id']) && $_REQUEST['app_id']!="")
{
	$_SESSION['APP_ID'] = filter($_REQUEST['app_id']);
	$app_id				= filter($_SESSION['APP_ID']);
}
else if($_REQUEST['action']=='Add'){
 $_SESSION['APP_ID']="";
}
else { $app_id = $_SESSION['APP_ID'];}

$member_type = getMemberType($registration_id,$conn);
$exhibition_type = getExhibitionType($app_id,$conn);
/*if(isset($_SESSION['APP_ID']) && $_SESSION['APP_ID']!='')
{
	header('location:trade_exhibition.php');
}*/
$sql_max = $conn ->query("select * from trade_general_info where app_id IN (select max(app_id) from trade_general_info where registration_id='$registration_id')");
$ans_result = $sql_max->fetch_assoc();

$info_status = $conn ->query("select status,region_id,member_type_id from information_master where registration_id='$registration_id' and status=1");
$info_result = $info_status->fetch_assoc();
$region_name = $info_result['region_id'];
$member_type_id = $info_result['member_type_id'];

if($region_name=='HO-MUM (M)')
	$r_name="MUM";
else if($region_name=='RO-CHE')
	$r_name="CHE";
else if($region_name=='RO-DEL')
	$r_name="DEL";
else if($region_name=='RO-JAI')
	$r_name="JAI";
else if($region_name=='RO-KOL')
	$r_name="KOL";
else if($region_name=='RO-KOL')
	$r_name="KOL";
else if($region_name=='RO-SRT')
	$r_name="SRT";
else
	$r_name="MUM";

 $chars = '0123456789'; 
 $count = mb_strlen($chars); 

    for ($i = 0, $result = ''; $i < 4; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
$permission_no=$r_name."/15/DSP-".$result;

$q_ref = $conn ->query("select * from trade_general_info where region_code='$region_code' ORDER BY app_id desc limit 1");
$r_ref = $q_ref->fetch_assoc();
$start=$r_ref['end']+1;
$end=$start+2;
//echo $start.'--'.$end;
?>

<section class="py-5">
    
	<div class="container inner_container">
    
    	<h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> My Account - Trade Permission</h1>

		<div class="row">

            
    
            <div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
                <?php include 'include/regMenu.php'; ?>
            </div>

      		<div class="col-lg col-md-12">
            
            <p class="blue">Trade Approval</p>
			
			<?php 
            if($_SESSION['succ_msg']!=""){
            echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
            $_SESSION['succ_msg']="";
            }
            
            if($_SESSION['form_chk_msg']!="" || $_SESSION['form_chk_msg1']!="" || $_SESSION['form_chk_msg2']!=""){
            echo "<span class='notification n-attention'>";
            if($_SESSION['form_chk_msg']!=""){
            echo $_SESSION['form_chk_msg']."<br>";
            }
            if($_SESSION['form_chk_msg1']!=""){
            echo $_SESSION['form_chk_msg1']."<br>";
            }
            if($_SESSION['form_chk_msg2']!=""){
            echo $_SESSION['form_chk_msg2'];
            }
            echo "</span>";
            $_SESSION['form_chk_msg']="";
            $_SESSION['form_chk_msg1']="";
            $_SESSION['form_chk_msg2']="";
            }
            ?>		
    
    		<form action="trade_approval_action.php" method="POST" id="trade_permission" name="trade_permission" onsubmit="return validate();">
				
				<?php
                $queryT =  $conn ->query("select * from trade_general_info where app_id='$app_id' AND app_id!=0");
                $result = $queryT->fetch_assoc();
                $application_status = $result['application_status'];
                
                if($application_status=='Y' || $application_status=='C'){ ?>
                	
                <div class="d-flex mb-3 tabHeaders">
                    <div class="tabHead tabactive"><a href="trade_approval.php">General</a></div>
                    <?php if($exhibition_type=="exhibition" || $exhibition_type==""){?>
                    <div class="p-3 tabHead"><a href="trade_exhibition.php">Exhibition</a></div>
                    <?php } ?>
                    <div class="tabHead"><a href="trade_approval_documents.php">Documents</a></div>
                </div>               
    
                <div class="tabContainers">
                        <div class="row tabCont nopadding" id="th1">                 
                            
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="app_date">Application Date</label>
                                    <input type="hidden" name="application_status" id="application_status" value="Y"/>
                                    <input type="text" class="form-control" name="application_date" id="application_date" value="<?php if($result['application_date']!=''){ echo $result['application_date']; } else { echo date("d-m-Y"); } ?>" readonly="readonly">
                               	</div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="permission_no">Premission No.</label>
                                    <input type="text" class="form-control"name="permission_no" id="permission_no" value="<?php echo (!empty($result['permission_no'])) ? $result['permission_no']:$permission_no;?>" readonly="readonly">
                                </div>
                                
                                <?php
                                $sql_R = $conn ->query("select * from registration_master where id='$registration_id'");
                                $ans_add = $sql_R->fetch_assoc();
                                ?>                                
                                <div class="form-group col-sm-6">
                                <label class="form-label" for="membership_id">Membership ID</label>
                                <input type="text" class="form-control" name="membership_id" id="membership_id" value="<?php echo $ans_add['gcode']; ?>" readonly="readonly">
                                </div>                              
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="cust_add">Customer Address <span>*</span></label>
                                  	<select name="customer_add" id="customer_add" class="form-control" disabled>
                                        <option value="">- Select Address -</option>
                                       <?php
										$sql_comm = $conn ->query("select * from communication_address_master where registration_id=$registration_id");
										while($row_add = $sql_comm->fetch_assoc()) { ?>
                                        <option value="<?php echo filter($row_add['type_of_address']);?>" <?php if($result['type_of_address']==$row_add['type_of_address']){?> selected="selected"<?php }?>><?php echo filter($row_add['address1']); ?></option>
                                        <?php } ?>
                                    </select>                                  
                                </div>
                                
                                <div class="form-group col-sm-6">
                                	<label class="form-label" for="member_name">Member Name <span>*</span></label>;
                                    <input type="text" class="form-control" name="member_name" id="member_name" 
									value="<?php echo filter(strtoupper(str_replace(array('&amp;','&AMP;'), '&', $_SESSION['COMPANYNAME'])));?>" onkeyup="getexportdata()" readonly="readonly">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="Address1">Address <span>*</span></label>
                                    <input type="text" class="form-control" name="address1" id="address1" value="<?php echo filter($result['address1']);?>" readonly="readonly">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="address2">Address 2 <span>*</span></label>
                                    <input type="text" class="form-control" name="address2" id="address2" value="<?php echo filter($result['address2']);?>" readonly="readonly">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                	<label class="form-label" for="pincode">Pincode <span>*</span></label>
                                    <input type="text" class="form-control numeric" name="pincode" id="pincode" value="<?php echo filter($result['pincode']);?>" readonly="readonly" autocomplete="off" maxlength="6" onkeypress="if(this.value.length==6) return false;">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="city">City <span>*</span></label>
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo filter($result['city']);?>" readonly="readonly">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="email">E-mail <span>*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo filter($ans_add['email_id']); ?>" readonly="readonly">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="comemail">Communication E-mail <span>*</span></label>
                                    <input type="text" class="form-control" name="commemail" id="commemail" value="<?php echo filter($result['commemail']);?>" readonly="readonly">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="per_type">Premission Type <span>*</span></label>
                                  
                                        <select name="permission_type" id="permission_type" class="form-control">
                                        <option value="">---------- Select ----------</option>
                                        <option value="promotional_tour" <?php if($result['permission_type']=="promotional_tour"){?> selected="selected"<?php }?>>Promotional Tour</option>
                                        <option value="exhibition" <?php if($result['permission_type']=="exhibition"){?> selected="selected"<?php }?>>Exhibition</option>
                                        <!--<option value="branded_jewellery" <?php if($result['permission_type']=="branded_jewellery"){?> selected="selected"<?php }?>>Branded Jewellery</option>
                                        <option value="person_hand" <?php if($result['permission_type']=="person_hand"){?> selected="selected"<?php }?>>Person & Hand </option>-->
                                        </select>                                    
                                </div>
                                
                                <div class="repeatInThis" <?php if($result['permission_type']=="exhibition"){?> style="display:none"<?php }?>>
                                
                                    <div class="repeatThis">
                                        <div class="form-group col-sm-6">
                                            <label class="form-label" for="per_type">Visiting Countries <span>*</span></label>
                                                <select name="visiting_country[]" id="visiting_country" class="form-control" disabled>
                                                <option value="">----------Select ----------</option>
                                                <?php
                                                $sql_country = $conn ->query("select * from country_master  where status=1");
                                                while($result_country = $sql_country->fetch_assoc())  {
                                                ?>
                                                <option value="<?php echo filter($result_country['country_code']);?>" <?php if($result['visiting_country1']==$result_country['country_code']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];?></option>
                                                <?php } ?>
                                                </select>                                          
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form-label" for="city">City <span>*</span></label>
                                            <input type="text" class="form-control" name="visiting_city[]" id=""  value="<?php echo $result['city1'];?>" readonly="readonly">
                                        </div>                                        
                                    </div>
                                    <div class="addMore form-group row col-md-12">
                                        <button class="cta add_button" title="Add field">Add More</button>
                                    </div>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="item1">Export Product Category 1</label>
                   
                                        <select name="item1" id="item1" class="form-control" disabled>
                                        <option value="">Select Item</option>								
                                        <option value="LOOSE DIAMONDS" <?php if($result['item1']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                        <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item1']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                        <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item1']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                        <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item1']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                        <option value="COLOURED GEMSTONES, PEARLS/BEAD" <?php if($result['item1']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEMSTONES, PEARLS/BEADS </option>
                                        <option value="CUT & POLISHED DIAMONDS" <?php if($result['item1']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
										<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item1']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
										<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item1']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                        <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item1']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                        </select> 
                               
                                    <label class="form-label" for="invoice_value1">Invoice Value in Dollar </label>
                                    <input type="number" class="form-control" name="invoice_value1" id="invoice_value1"  value='<?php echo $result['invoice_value1'];?>' onkeyup="getotalinvoice()" autocomplete="off" readonly="readonly">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="item1">Export Product Category 2</label>
                                    
                                        <select name="item2" id="item2" class="form-control" disabled>
                                        <option value="">Select Item</option>
                                        <option value="LOOSE DIAMONDS" <?php if($result['item2']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                        <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item2']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                        <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item2']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                        <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item2']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                        <option value="COLOURED GEMSTONES, PEARLS/BEAD" <?php if($result['item2']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEMSTONES, PEARLS/BEAD</option>
                                        <option value="CUT & POLISHED DIAMONDS" <?php if($result['item2']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
										<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item2']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
										<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item2']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                        <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item2']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                        </select>
                                  
                                    <label class="form-label" for="invoice_value2">Invoice Value in Dollar </label>
                                    <input type="number" class="form-control" name="invoice_value2" id="invoice_value2" value="<?php echo $result['invoice_value2'];?>" onkeyup="getotalinvoice()" autocomplete="off" readonly="readonly">
                                </div>	
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="item1">Export Product Category 3</label>
                                   
                                        <select name="item3" id="item3" class="form-control" disabled>
                                        <option value="">Select Item</option>
                                        <option value="LOOSE DIAMONDS" <?php if($result['item3']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                        <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item3']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                        <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item3']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                        <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item3']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                        <option value="COLOURED GEMSTONES, PEARLS/BEAD" <?php if($result['item3']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEMSTONES, PEARLS/BEAD</option>
                                        <option value="CUT & POLISHED DIAMONDS" <?php if($result['item3']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
										<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item3']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
										<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item3']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                        <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item3']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                        </select>
                                 
                                    <label class="form-label" for="invoice_value3">Invoice Value in Dollar </label>
                                    <input type="number" class="form-control" name="invoice_value3" id="invoice_value3" value="<?php echo $result['invoice_value3'];?>" onkeyup="getotalinvoice()" autocomplete="off" readonly="readonly">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="item1">Export Product Category 4</label>
                                        <select name="item4" id="item4" class="form-control" disabled>
                                        <option value="">Select Item</option>
                                        <option value="LOOSE DIAMONDS" <?php if($result['item4']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                        <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item4']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                        <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item4']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                        <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item4']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                        <option value="COLOURED GEMSTONES, PEARLS/BEAD" <?php if($result['item4']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEMSTONES, PEARLS/BEAD</option>
                                        <option value="CUT & POLISHED DIAMONDS" <?php if($result['item4']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
										<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item4']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
										<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item4']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                        <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item4']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                        </select>
                                   
                                    <label class="form-label" for="invoice_value4">Invoice Value in Dollar </label>
                                    <input type="number" class="form-control" name="invoice_value4" id="invoice_value4" value="<?php echo $result['invoice_value4'];?>" onkeyup="getotalinvoice()" autocomplete="off" readonly="readonly">
                                </div>	
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="item1">Export Product Category 5</label>
                                        <select name="item5" id="item5" class="form-control" disabled>
                                        <option value="">Select Item</option>
                                        <option value="LOOSE DIAMONDS" <?php if($result['item5']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                        <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item5']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                        <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item5']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                        <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item5']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                        <option value="COLOURED GEMSTONES, PEARLS/BEAD " <?php if($result['item5']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEMSTONES, PEARLS/BEAD</option>
                                        <option value="CUT & POLISHED DIAMONDS" <?php if($result['item5']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
										<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item5']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
										<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item5']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COMMEMORATIVE COINS(LEGAL TENDER)</option>
                                        <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item5']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                        </select>
                               
                                    <label class="form-label" for="invoice_value5">Invoice Value in Dollar </label>
                                    <input type="number" class="form-control" name="invoice_value5" id="invoice_value5" value="<?php echo $result['invoice_value5'];?>" onkeyup="getotalinvoice()" autocomplete="off" readonly="readonly">
                                </div>
                                	
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="apprx_invoice_value">Approx Invoice Value <span>*</span></label>
                                    <input type="text" class="form-control" name="apprx_invoice_value" id="apprx_invoice_value" value="<?php echo (!empty($result['apprx_invoice_value'])) ? $result['apprx_invoice_value'] : 0?>" readonly="readonly">
								</div>					
                     
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="bank_name">Bank Name <span>*</span></label>                                    
                                        <select name="bank_name" id="bank_name" class="form-control" disabled>
                                        <option value="">---------- Select ----------</option>
                                        <?php 
                                        $bquery = $conn ->query("select * from bank_master where status=1 order by id asc");
                                        while($bresult = $bquery->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo filter($bresult['bank_name']);?>" <?php if($bresult['bank_name']==$result['bank_name']){?> selected="selected" <?php }?>><?php echo $bresult['bank_name'];?></option>
                                        <?php }?>
                                        </select>                                    
                                </div>
                                
                                <div class="form-group" <?php if($result['other_bank_name']==''){?> style="display:none;" <?php }?> id="other_bank_div">
                                    <label class="form-label" for="other_bank_name">Other bank name <span>*</span></label>
                                        <input type="text" class="form-control trade_input_text" name="other_bank_name" id="other_bank_name" value="<?php echo filter($result['other_bank_name']);?>" readonly="readonly">                                   
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="bank_branch">Bank Branch <span>*</span></label>
                                        <input type="text" class="form-control trade_input_text" name="bank_branch" id="bank_branch" value="<?php echo filter($result['branch_name']);?>" readonly="readonly">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="person_name_carrying">Person Name Carrying</label>
                                        <input type="text" class="form-control trade_input_text" name="person_name_carrying" id="person_name_carrying" value="<?php echo filter($result['person_name_carrying']);?>" readonly="readonly">                                    
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="passport_no">Passport No.</label>
                                        <input type="text" class="form-control trade_input_text" name="passport_no" id="passport_no" value="<?php echo filter($result['passport_no']);?>"readonly="readonly">                                  
                                </div>
                                
                                <div class="form-group col-sm-6" id="picker-container">
                                    <label class="form-label" for="passport_issue_dates">Passport Issue Date</label>
                                        <input type="text" class="form-control trade_input_text" name="passport_issue_date" id="passport_issue_date" readonly="true" value="<?php echo $result['passport_issue_date'];?>" disabled="disabled" placeholder="Passport Issue Date">                              
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="passport_expiry_dates">Passport Expiry Date</label>
                                    <input type="text" class="form-control trade_input_text" name="passport_expiry_date" id="passport_expiry_date" readonly="true" value="<?php echo $result['passport_expiry_date'];?>" disabled="disabled" placeholder="Passport Expiry Date">                                  
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="date_of_dapartures">Date of Departure</label>
                                        <input type="text" class="form-control trade_input_text" name="date_of_daparture" id="date_of_daparture" readonly="true" value="<?php echo $result['date_of_departure'];?>" disabled="disabled">                                    
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="reg_brand_name_of_j">Reg. Brand Name of J</label>
                                        <input type="text" class="form-control trade_input_text" name="reg_brand_name_of_j" id="reg_brand_name_of_j" value="<?php echo filter($result['reg_brand_name_of_j']);?>" readonly="readonly">                                    
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="reg_brand_name_of_a">Reg. Brand Name of A</label>
                                        <input type="text" class="form-control trade_input_text" name="reg_brand_name_of_a" id="reg_brand_name_of_a" value="<?php echo filter($result['reg_brand_name_of_a']);?>" readonly="readonly">
                                    
                                </div>
                                
                                <div class="form-group col-sm-6">
                                <label class="form-label" for="address_of_place_of_dis">Address of place of Dis.</label>
                                <input type="text" class="form-control trade_input_text" name="address_of_place_of_dis" id="address_of_place_of_dis"  value="<?php echo filter($result['address_of_place_of_dis']);?>" readonly="readonly">                                  
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="region_code">Region Code</label>
                                    <input type="text" class="form-control trade_input_text" name="region_code" id="region_code" value="<?php echo filter($region_name);?>" readonly="readonly">                                    
                                </div>
                                
                                <div class="form-group col-12 exh_date" <?php if($result['permission_type']=="exhibition"){?> style="display:none"<?php }?>>
                                
                                <div class="row">
                                
                                <div class="form-group col-sm-6">
                                <label class="form-label" for="from_dates">From Date</label>
                                <input type="text" class="form-control trade_input_text" name="from_date" id="from_date" value="<?php echo $result['from_date'];?>" readonly="readonly" disabled="disabled">                                    
                                </div>
                                						
                                <div class="form-group col-sm-6">
                                <label class="form-label" for="to_dates">To Date</label>
                                <input type="text" class="form-control trade_input_text" name="to_date" id="to_date" value="<?php echo $result['to_date'];?>" readonly="readonly" disabled="disabled">                                   
                                </div>                                
                                </div>
                                
                                </div>
                    
                                <?php
                                $sql_data = $conn ->query("select * from approval_master where registration_id=$registration_id");                             
                                $result_data = $sql_data->fetch_assoc();
                                if($member_type==6){
                                    $manu_reg_no=$result_data['manufacturer_certificate_no'];
                                } else {
                                    $mer_reg_no=$result_data['merchant_certificate_no'];
                                } ?>
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="merchant_reg_no">Merchant Reg No.</label>
                                    <input type="text" class="form-control trade_input_text" name="merchant_reg_no" id="merchant_reg_no" value="<?php echo filter($mer_reg_no); ?>" readonly="readonly">                                 
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="manufacture_reg_no">Manufacture Reg No.</label>
                                    <input type="text" class="form-control trade_input_text" name="manufacture_reg_no" id="manufacture_reg_no" value="<?php echo filter($manu_reg_no);?>" readonly="readonly">                                
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="member_id">Member's Id.</label>
                                    <input type="text" class="form-control trade_input_text" name="member_id" id="member_id" value="<?php echo filter($result_data['membership_id']);?>" readonly="readonly">                                    
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="old_reference_no">Old Reference Number.</label>
                                    <input type="text" class="form-control trade_input_text" name="old_reference_no" id="old_reference_no" value="<?php echo $ans_result['permission_no'];?>" readonly="readonly">                                   
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="new_reference_no">New Reference Number.</label>
                                    <input type="text" class="form-control trade_input_text" name="new_reference_no" id="new_reference_no" value="<?php echo $permission_no;?>" readonly="readonly">                                    
                                </div>
                                
                            <div class="col-md-12">
                                <button class="cta" type="submit" value="next">Next</button>
                            </div>			
                        </div>
                    
                </div>
                
        		<?php } else { ?>
        
            	<div class="d-flex mb-3 tabHeaders">
                    <div class="tabHead tabactive"><a href="trade_approval.php">General</a></div>
                    <?php if($exhibition_type=="exhibition" || $exhibition_type==""){?>
                    <div class="tabHead"><a href="trade_exhibition.php">Exhibition</a></div>
                    <?php } ?>
                    <div class="tabHead"><a href="trade_approval_documents.php">Documents</a></div>
            	</div>
            
            <div class="col-md-12 nopadding tabContainers">
                    <div class="row tabCont nopadding" id="th1">
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="application_date">Application Date</label>
                                <input type="hidden" name="application_status" id="application_status" value="N"/>
                                <input type="text" class="form-control" name="application_date" id="application_date" value="<?php if($result['application_date']!=''){echo $result['application_date'];} else {echo date("d-m-Y");}?>" readonly="readonly">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="permission_no">Premission No.</label>
                                <input type="text" class="form-control" name="permission_no" id="permission_no" value="<?php echo (!empty($result['permission_no'])) ? $result['permission_no']:$permission_no;?>" readonly="readonly">
                            </div>
                            <?php
                            $sql_add = $conn ->query("select * from registration_master where id='$registration_id'");
                            $ans_add = $sql_add->fetch_assoc();
                            ?>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="members_no">Membership ID</label>
                                <input type="text" class="form-control" name="membership_id" id="membership_id" value="<?php echo filter(getMembershipId($_SESSION['USERID'],$conn)); ?>" readonly="readonly">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="pan_no">Customer Address <span>*</span></label>
                                    <select name="customer_add" id="customer_add" class="form-control">
                                    <option value="">- Select -</option>
                                    <?php
									$comm_sql = $conn ->query("select * from communication_address_master where registration_id=$registration_id");
									while($row_add = $comm_sql->fetch_assoc()) { ?>
                                    <option value="<?php echo $row_add['type_of_address'] ?>" <?php if($result['type_of_address']==$row_add['type_of_address']){?> selected="selected"<?php }?>><?php echo $row_add['address1'] ?></option>
                                    <?php } ?>
                                    </select>                               
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="member_name">Member Name <span>*</span></label>
                                <input type="text" class="form-control" name="member_name" id="member_name" value="<?php echo filter(strtoupper(str_replace(array('&amp;','&AMP;'), '&', $_SESSION['COMPANYNAME'])));?>" onkeyup="getexportdata()" readonly="readonly">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="Address1">Address <span>*</span></label>
                                <input type="text" class="form-control" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?php echo $result['address1'];?>" name="address1" id="address1" value="<?php echo filter($result['address1']);?>" >
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="address2">Address 2 <span>*</span></label>
                                <input type="text" class="form-control" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?php echo $result['address2'];?>" name="address2" id="address2" value="<?php echo filter($result['address2']);?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="pincode">Pincode <span>*</span></label>
                                <input type="text" class="form-control numeric" name="pincode" id="pincode" value="<?php echo filter($result['pincode']);?>" autocomplete="off" maxlength="6" onkeypress="if(this.value.length==6) return false;"></div>
                          
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="city">City <span>*</span></label>
                                <input type="text" class="form-control" name="city" id="city" value="<?php echo filter($result['city']); ?>">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="email">E-mail <span>*</span></label>
                                <input type="text" class="form-control" name="email" id="email" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?php echo $result['email_id'];?>" value="<?php echo filter($ans_add['email_id']);?>" readonly="readonly">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="comemail">Communication E-mail <span>*</span></label>
                                <input type="text" class="form-control" name="commemail" id="commemail" value="<?php echo filter($result['commemail']);?>">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="per_type">Premission Type <span>*</span></label>
                                    <select name="permission_type" id="permission_type" class="form-control">
                                    <option value="">- Select -</option>
                                    <option value="promotional_tour" <?php if($result['permission_type']=="promotional_tour"){?> selected="selected"<?php }?>>Promotional  Tour</option>
                                    <option value="exhibition" <?php if($result['permission_type']=="exhibition"){?> selected="selected"<?php }?>>Exhibition</option>
    <!--<option value="branded_jewellery" <?php if($result['permission_type']=="branded_jewellery"){?> selected="selected"<?php }?>>Branded Jewellery</option>
                                    <option value="person_hand" <?php if($result['permission_type']=="person_hand"){?> selected="selected"<?php }?>>Person & Hand </option>-->
                                    </select>
                            </div>
                            
                            <div class="form-group col-12 repeatInThis" <?php if($result['permission_type']=="exhibition"){?> style="display:none"<?php }?>>
                            
                                <div class="row repeatThis">
                                
                                    <div class="form-group col-sm-6">
                                        <label class="form-label" for="per_type">Visiting Countries <span>*</span></label>
                                            <select name="visiting_country[]" id="visiting_country" class="form-control">
                                            <option value="">- Select -</option>
                                            <?php
                                            $sql_country = $conn ->query("select * from country_master where status=1");
                                            while($result_country = $sql_country->fetch_assoc())  {
                                            ?>
                                            <option value="<?php echo $result_country['country_code'];?>" <?php if($result['visiting_country1']==$result_country['country_code']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];?></option>
                                            <?php } ?>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-sm-6">
                                        <label class="form-label" for="city">City <span>*</span></label>
                                        <input type="text" class="form-control" name="visiting_city[]" id=""  value="<?php echo $result['city1'];?>">
                                    </div>                                    
                                </div>
                                
                                <div class="row repeatThis">
                                
                                    <div class="form-group col-sm-6">
                                        <label class="form-label" for="per_type">Visiting Countries <span>*</span></label>
                                            <select name="visiting_country[]" id="visiting_country" class="form-control">
                                            <option value="">- Select -</option>
                                            <?php
                                            $sql_country = $conn ->query("select * from country_master where status=1");
                                            while($result_country = $sql_country->fetch_assoc())  {
                                            ?>
                                            <option value="<?php echo $result_country['country_code'];?>" <?php if($result['visiting_country2']==$result_country['country_code']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];?></option>
                                            <?php } ?>
                                            </select>                                      
                                    </div>
                                    
                                    <div class="form-group col-sm-6">
                                        <label class="form-label" for="city">City <span>*</span></label>
                                        <input type="text" class="form-control" name="visiting_city[]" id=""  value="<?php echo $result['city2'];?>">
                                    </div>
                                    
                                </div>
                                
                                <div class="row repeatThis">
                                
                                    <div class="form-group col-sm-6">
                                        <label class="form-label" for="per_type">Visiting Countries <span>*</span></label>
                                            <select name="visiting_country[]" id="visiting_country" class="form-control">
                                            <option value="">- Select -</option>
                                            <?php
                                            $sql_country = $conn ->query("select * from country_master where status=1");
                                            while($result_country = $sql_country->fetch_assoc())  {
                                            ?>
                                            <option value="<?php echo $result_country['country_code'];?>" <?php if($result['visiting_country3']==$result_country['country_code']){?> selected="selected"<?php }?>><?php echo $result_country['country_name'];?></option>
                                            <?php } ?>
                                            </select>
                                        
                                    </div>
                                    
                                    <div class="form-group col-sm-6">
                                        <label class="form-label" for="city">City <span>*</span></label>
                                        <input type="text" class="form-control" name="visiting_city[]" id="" value="<?php echo filter($result['city3']);?>">
                                    </div>	
                                    							
                                </div>
                                
                                <div class="addMore form-group">                                   
                                    
                                    <a href="javascript:void(0);" class="cta add_button" title="Add field"><i class="fa fa-plus" aria-hidden="true"> </i> Add More</a>	
                                </div>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="item1">Export Product Category 1</label>
                                    <select name="item1" id="item1" class="form-control">
                                    <option value="">Select Item</option>                
                                    <option value="LOOSE DIAMONDS" <?php if($result['item1']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                    <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item1']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                    <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item1']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                    <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item1']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                    <option value="COLOURED GEM STONES,PEARLS/BEADS" <?php if($result['item1']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEM STONES, PEARLS/BEADS</option>
                                    <option value="CUT & POLISHED DIAMONDS" <?php if($result['item1']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
									<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item1']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
									<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item1']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                    <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item1']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                    </select>
                              
                                <label class="form-label" for="invoice_value1">Invoice Value in Dollar </label>
                                <input type="number" class="form-control" name="invoice_value1" id="invoice_value1"  value='<?php echo $result['invoice_value1'];?>' onkeyup="getotalinvoice()" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="item1">Export Product Category 2</label>
                                    <select name="item2" id="item2" class="form-control">
                                    <option value="">Select Item</option>
                                    <option value="LOOSE DIAMONDS" <?php if($result['item2']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                    <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item2']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                    <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item2']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                    <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item2']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                    <option value="COLOURED GEM STONES, PEARLS/BEADS" <?php if($result['item2']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEM STONES, PEARLS/BEADS</option>
                                    <option value="CUT & POLISHED DIAMONDS" <?php if($result['item2']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
									<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item2']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
									<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item2']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                    <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item2']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                    </select>
                                <label class="form-label" for="invoice_value2">Invoice Value in Dollar </label>
                                <input type="number" class="form-control" name="invoice_value2" id="invoice_value2" value="<?php echo $result['invoice_value2'];?>" onkeyup="getotalinvoice()" autocomplete="off">
                            </div>
                            	
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="item1">Export Product Category 3</label>
                                    <select name="item3" id="item3" class="form-control">
                                    <option value="">Select Item</option>
                                    <option value="LOOSE DIAMONDS" <?php if($result['item3']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                    <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item3']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                    <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item3']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                    <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item3']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                    <option value="COLOURED GEM STONES, PEARLS/BEADS" <?php if($result['item3']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEM STONES, PEARLS/BEADS</option>
                                    <option value="CUT & POLISHED DIAMONDS" <?php if($result['item3']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
									<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item3']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
									<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item3']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                    <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item3']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                    </select>
                             
                                <label class="form-label" for="invoice_value3">Invoice Value in Dollar </label>
                                <input type="number" class="form-control" name="invoice_value3" id="invoice_value3" value="<?php echo $result['invoice_value3'];?>" onkeyup="getotalinvoice()" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="item1">Export Product Category 4</label>
                                    <select name="item4" id="item4" class="form-control">
                                    <option value="">Select Item</option>
                                    <option value="LOOSE DIAMONDS" <?php if($result['item4']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                    <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item4']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                    <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item4']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                    <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item4']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                    <option value="COLOURED GEM STONES, PEARLS/BEADS" <?php if($result['item4']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEM STONES, PEARLS/BEADS</option>
                                    <option value="CUT & POLISHED DIAMONDS" <?php if($result['item4']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
									<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item4']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
									<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item4']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                    <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item4']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                    </select>
                            
                                <label class="form-label" for="invoice_value4">Invoice Value in Dollar </label>
                                <input type="number" class="form-control" name="invoice_value4" id="invoice_value4" value="<?php echo $result['invoice_value4'];?>" onkeyup="getotalinvoice()" autocomplete="off">
                            </div>	
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="item1">Export Product Category 5</label>
                                    <select name="item5" id="item5" class="form-control">
                                    <option value="">Select Item</option>
                                    <option value="LOOSE DIAMONDS" <?php if($result['item5']=="LOOSE DIAMONDS"){?> selected="selected"<?php }?>>LOOSE DIAMONDS</option>
                                    <option value="GOLD JEWELLERY PLAIN/STUDDED" <?php if($result['item5']=="GOLD JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>GOLD JEWELLERY PLAIN/STUDDED</option>
                                    <option value="SILVER JEWELLERY PLAIN/STUDDED" <?php if($result['item5']=="SILVER JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>SILVER JEWELLERY PLAIN/STUDDED</option>
                                    <option value="PLATINUM JEWELLERY PLAIN/STUDDED" <?php if($result['item5']=="PLATINUM JEWELLERY PLAIN/STUDDED"){?> selected="selected"<?php }?>>PLATINUM JEWELLERY PLAIN/STUDDED</option>
                                    <option value="COLOURED GEM STONES, PEARLS/BEADS" <?php if($result['item5']=="COLOURED GEM STONES, PEARLS/BEADS"){?> selected="selected"<?php }?>>COLOURED GEM STONES, PEARLS/BEADS</option>
                                    <option value="CUT & POLISHED DIAMONDS" <?php if($result['item5']=="CUT & POLISHED DIAMONDS"){?> selected="selected"<?php }?>>CUT & POLISHED DIAMONDS</option>
									<option value="CVD/LAB GROWN DIAMONDS" <?php if($result['item5']=="CVD/LAB GROWN DIAMONDS"){?> selected="selected"<?php }?>>CVD/LAB GROWN DIAMONDS</option>
									<option value="SILVER COINS (OTHER THAN LEGAL TENDER)" <?php if($result['item5']=="SILVER COINS (OTHER THAN LEGAL TENDER)"){?> selected="selected"<?php }?>>SILVER COINS (OTHER THAN LEGAL TENDER)</option>
                                    <option value="ALL TYPES OF GEM & JEWELLERY" <?php if($result['item5']=="ALL TYPES OF GEM & JEWELLERY"){?> selected="selected"<?php }?>>ALL TYPES OF GEM & JEWELLERY</option>
                                    </select>
                                
                                <label class="form-label" for="invoice_value5">Invoice Value in Dollar </label>
                                <input type="number" class="form-control" name="invoice_value5" id="invoice_value5" value="<?php echo $result['invoice_value5'];?>" onkeyup="getotalinvoice()" autocomplete="off">
                            </div>	
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="apprx_invoice_value">Approx Invoice Value <span>*</span></label>
                                    <input type="number" class="form-control" name="apprx_invoice_value" id="apprx_invoice_value" value="<?php echo (!empty($result['apprx_invoice_value'])) ? $result['apprx_invoice_value'] : 0?>" readonly="readonly">
                            </div>	
                            				
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="bank_name">Bank Name <span>*</span></label>
                                    <select name="bank_name" id="bank_name" class="form-control">
                                    <option value="">-- Select Bank --</option>
                                    <?php 
                                    $bquery =  $conn ->query("select * from bank_master where status='1' order by id asc");
                                    while($bresult = $bquery->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $bresult['bank_name'];?>" <?php if($bresult['bank_name']==$result['bank_name']){?> selected="selected" <?php }?>><?php echo strtoupper($bresult['bank_name']);?></option>
                                    <?php }?>
                                    </select> 
                            </div>
                            
                            <div class="form-group" <?php if($result['other_bank_name']==''){?> style="display:none;" <?php }?> id="other_bank_div">
                                <label class="form-label" for="other_bank_name">Other Bank Name <span>*</span></label>
                                <input type="text" class="form-control trade_input_text" name="other_bank_name" id="other_bank_name" value="<?php echo filter($result['other_bank_name']);?>">                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="bank_branch">Bank Branch <span>*</span></label>
                                <input type="text" class="form-control trade_input_text" name="bank_branch" id="bank_branch" value="<?php echo filter($result['branch_name']);?>">                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="person_name_carrying">Person Name Carrying</label>
                                <input type="text" class="form-control trade_input_text" name="person_name_carrying" id="person_name_carrying" value="<?php echo filter($result['person_name_carrying']);?>">                               
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="passport_no">Passport No.</label>
                                <input type="text" class="form-control trade_input_text" name="passport_no" id="passport_no"  value="<?php echo filter($result['passport_no']);?>">                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="passport_issue_dates">Passport Issue Date</label>
                                <div id="picker-container">
                                <input type="text" class="form-control trade_input_text" name="passport_issue_date" id="passport_issue_date" readonly="true" value="<?php echo $result['passport_issue_date'];?>">
                                </div>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="passport_expiry_dates">Passport Expiry Date</label>
                                <input type="text" class="form-control trade_input_text" name="passport_expiry_date" id="passport_expiry_date" readonly="true" value="<?php echo $result['passport_expiry_date'];?>">                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="date_of_dapartures">Date of Departure</label>
                                <input type="text" class="form-control trade_input_text" name="date_of_daparture" id="date_of_daparture" readonly="true" value="<?php echo $result['date_of_departure'];?>">                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="reg_brand_name_of_j">Reg. Brand Name of J</label>
                                <input type="text" class="form-control trade_input_text" name="reg_brand_name_of_j" id="reg_brand_name_of_j" value="<?php echo filter($result['reg_brand_name_of_j']);?>">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="reg_brand_name_of_a">Name of Brand Reg A</label>
                                <input type="text" class="form-control trade_input_text" name="reg_brand_name_of_a" id="reg_brand_name_of_a" value="<?php echo $result['reg_brand_name_of_a'];?>">                              
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="address_of_place_of_dis">Address of place of Dis.</label>
                                <input type="text" class="form-control trade_input_text" name="address_of_place_of_dis" id="address_of_place_of_dis" value="<?php echo $result['address_of_place_of_dis'];?>">                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="region_code">Region Code</label>
                                <input type="text" class="form-control trade_input_text" name="region_code" id="region_code" value="<?php echo $region_name;?>" readonly>
                            </div>
                            
                            <div class="col-12 exh_date" <?php if($result['permission_type']=="exhibition"){?> style="display:none"<?php }?>>                            
                            <div class="row">
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="from_dates">From Date</label>
                                    <input type="text" class="form-control trade_input_text" name="from_date" id="from_date" value="<?php echo $result['from_date'];?>" readonly="true" placeholder="From Date">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="to_dates">To Date</label>
                                    <input type="text" class="form-control trade_input_text" name="to_date" id="to_date" value="<?php echo $result['to_date'];?>" readonly="true" placeholder="To Date">
                            </div>                            
                            </div>                            
                            </div>                            
                            <?php
                            $sql_data = $conn ->query("select * from approval_master where registration_id=$registration_id");
                            $result_data = $sql_data->fetch_assoc();
                            if($member_type==6){
                                $manu_reg_no=$result_data['manufacturer_certificate_no'];
                            } else {
                                $mer_reg_no=$result_data['merchant_certificate_no'];
                            } ?>
                            
                            <div class="form-group col-sm-6">
                            <label class="form-label" for="merchant_reg_no">Merchant Reg No.</label>
                            <input type="text" class="form-control trade_input_text"  name="merchant_reg_no" id="merchant_reg_no" value="<?php echo filter($mer_reg_no); ?>" readonly="readonly">
                            </div>
                            
                            <div class="form-group col-sm-6">
                            <label class="form-label" for="manufacture_reg_no">Manufacture Reg No.</label>
                            <input type="text" class="form-control trade_input_text" name="manufacture_reg_no" id="manufacture_reg_no" value="<?php echo filter($manu_reg_no);?>" readonly="readonly">                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                            <label class="form-label" for="member_id">Member Id.</label>
                            <input type="text" class="form-control trade_input_text" name="member_id" id="member_id" value="<?php echo filter($result_data['membership_id']);?>" readonly="readonly">
                            </div>
                            
                            <div class="form-group col-sm-6">
                            <label class="form-label" for="old_reference_no">Old Reference Number.</label>
                            <input type="text" class="form-control trade_input_text" name="old_reference_no" id="old_reference_no" value="<?php echo $ans_result['permission_no'];?>" readonly="readonly">
                            </div>
                            
                            <div class="form-group col-sm-6">
                            <label class="form-label" for="new_reference_no">New Reference Number.</label>
                            <input type="text" class="form-control trade_input_text" name="new_reference_no" id="new_reference_no" value="<?php echo $permission_no;?>" readonly="readonly">
                            </div>                                                	
                        <div class="col-12">
                            <button class="cta" type="submit" value="next">Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                        </div>	
                        		
                    </div>
               
            </div>
        <?php } ?>
   		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="app_id" id="app_id" value="<?php echo $_SESSION['APP_ID'];?>" />
		<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
		<input type="hidden" name="region_id" id="region_id" value="<?php echo $region_name;?>" />
		</form>    
        </div>    
    	</div>    
    </div>    
</section>
    
<?php include 'include-new/footer.php'; ?>
<script src="js/trade_js.js"></script>
<!-- Datepicker Start -->

<!--<script src="js/bootstrap-datepicker.js"></script>-->
<!--<link href="css/datepicker.css" rel="stylesheet" type="text/css" />
-->
<style>
.form-group label span {
    color: #f00;
    font-size: 18px;
}
</style>
<script>
$("#passport_issue_date").keypress(function(event) {event.preventDefault();});
$("#passport_expiry_date").keypress(function(event) {event.preventDefault();});
$("#date_of_daparture").keypress(function(event) {event.preventDefault();});
$("#from_date").keypress(function(event) {event.preventDefault();});
$("#to_date").keypress(function(event) {event.preventDefault();});
</script>
<script>
$(document).ready(function () { 
				$('#passport_issue_date').datepicker({ 
                minDate: 0,
                autoclose: true, 
                todayHighlight: true,
				//container: ‘#picker-container’,
				 container: '#picker-container',
                format: "dd-mm-yyyy"
                }).on('changeDate', function (ev) {
					 $(this).datepicker('hide');
				});
				
				$('#passport_expiry_date').datepicker({
                minDate: 0,
                autoclose: true, 
                todayHighlight: true,
                format: "dd-mm-yyyy"
                }).on('changeDate', function (ev) {
					 $(this).datepicker('hide');
				});
				
				$('#date_of_daparture').datepicker({
                minDate: 0,
                autoclose: true, 
                todayHighlight: true,
                orientation: 'left',
                format: "dd-mm-yyyy"
                }).on('changeDate', function (ev) {
					 $(this).datepicker('hide');
				});
				
				$('#from_date').datepicker({
                minDate: 0,
                autoclose: true, 
                todayHighlight: true,
                format: "dd-mm-yyyy"
                }).on('changeDate', function (ev) {
					 $(this).datepicker('hide');
				});
				
				$('#to_date').datepicker({
                minDate: 0,
                autoclose: true, 
                todayHighlight: true,
                format: "dd-mm-yyyy"
                }).on('changeDate', function (ev) {
					 $(this).datepicker('hide');
				});
				
				
				
$('#to_date').datepicker().on("changeDate", function(e) {
       // console.log("From :"+jQuery("#from_date").val());
       // console.log("To :"+jQuery("#to_date").val());

			var to_date =  $("#to_date").val();
			var from_date =  $("#from_date").val();
			from_date = from_date.split('-');
		
			to_date = to_date.split('-');
				
			from_date = new Date(from_date[2], from_date[1], from_date[0]);
			to_date = new Date(to_date[2], to_date[1], to_date[0]);
			date1_unixtime = parseInt(from_date.getTime() / 1000);
			date2_unixtime = parseInt(to_date.getTime() / 1000);
			var to_date =  $("#to_date").val();
			var from_date =  $("#from_date").val();
			var timeDifference = date2_unixtime - date1_unixtime;
			var timeDifferenceInHours = timeDifference / 60 / 60;
			var timeDifferenceInDays = timeDifferenceInHours  / 24;
			
			if(timeDifferenceInDays>45)
			{
				alert("The from date and to date should not exceed 45 days");
				$("#from_date").focus();
				return false;
			}

    });
});    
</script>

<script type="text/javascript">   
$(document).ready(function() {   
$('#permission_type').change(function(){
var type=$(this).val();	
if(type=="promotional_tour") 
{
    $('#visiting_country[]').show();   
	$('#visiting_city[]').show(); 
	$('#from_date').show(); 
	$('#to_date').show();	
} else 
{   
   $('#visiting_country[]').hide(); 
   $('#visiting_city[]').hide();
   $('#from_date').hide(); 
   $('#to_date').hide();     
}   
});   
});   
</script> 
<script>
function getotalinvoice()
{
	var permission_type=document.getElementById("permission_type").value;
	
	var invoice_value1=document.getElementById("invoice_value1").value;
	if(invoice_value1==""){invoice_value1=0;}
	var invoice_value2=document.getElementById("invoice_value2").value;
	if(invoice_value2==""){invoice_value2=0;}
	var invoice_value3=document.getElementById("invoice_value3").value;
	if(invoice_value3==""){invoice_value3=0;}
	var invoice_value4=document.getElementById("invoice_value4").value;
	if(invoice_value4==""){invoice_value4=0;}
	var invoice_value5=document.getElementById("invoice_value5").value;
	if(invoice_value5==""){invoice_value5=0;}
	var tot_examount=parseInt(invoice_value1)+parseInt(invoice_value2)+parseInt(invoice_value3)+parseInt(invoice_value4)+parseInt(invoice_value5);
	if(permission_type=="promotional_tour"){
		if(tot_examount>1000000)
		{
			alert("sorry Your total invoice is crossing the limit");
			//return false;
		}
	}
	document.getElementById("apprx_invoice_value").value = tot_examount;
}
</script>
<script type="text/javascript">
$(document).ready(function(){
$('#bank_name').on('change',function(){
	bank_name=$('#bank_name').val();
	if(bank_name=="other")
		$('#other_bank_div').show();
	else
	  $('#other_bank_div').hide();	
	});	
});
</script>
<script>
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});
</script>