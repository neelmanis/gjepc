<?php
include 'include/header.php';
if(!isset($_SESSION['USERID'])){	header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<style>
#error_objective
{color: red;}
#error_importing
{ color: red;}
#error_interested
{
color: red;
}
</style>

<?php
$registration_id = intval($_SESSION['USERID']);
$sql="SELECT * FROM `member_directory` WHERE 1 and registration_id=$registration_id";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

$company_name = filter(strtoupper($rows['company_name']));
$contact_person = filter(strtoupper($rows['contact_person']));
$usertype	=	filter(strtoupper($rows['buy_sell_profile_code']));
if($usertype==""){ $usertype="NM"; }

$designation	= filter(strtoupper($rows['designation']));
$website		= filter(strtoupper($rows['website']));
$write_up		= filter(strtoupper($rows['write_up']));
$wa_jewellery=$rows['wa_jewellery'];
$pos=strpos($wa_jewellery, 'other,');
$wa_jewellery_other=substr($wa_jewellery, $pos+6);
$wa_machinery=$rows['wa_machinery'];
$pos=strpos($wa_machinery, 'other,');
$wa_machinery_other=substr($wa_machinery, $pos+6);
$wa_other=$rows['wa_other'];
$pos=strpos($wa_other, 'other,');
$wa_other_other=substr($wa_other, $pos+6);
$pd_jewellery=$rows['pd_jewellery'];
$pos=strpos($pd_jewellery, 'other,');
$pd_jewellery_other=substr($pd_jewellery, $pos+6);
$pd_machinery=$rows['pd_machinery'];
$pos=strpos($pd_machinery, 'other,');
$pd_machinery_other=substr($pd_machinery, $pos+6);
$objective=$rows['objective'];
$pos=strpos($objective, 'other,');
$objective_other=substr($objective, $pos+6);
$import_from=$rows['import_from'];
$pos=strpos($import_from, 'other,');
$import_from_other=substr($import_from, $pos+6);
$item_interest=$rows['item_interest'];
$pos=strpos($item_interest, 'other,');
$item_interest_other=substr($item_interest, $pos+6);
$caratage=$rows['caratage'];
$d_size=$rows['d_size'];
$d_clarity=$rows['d_clarity'];
$d_color_shade=$rows['d_color_shade'];
$d_pp_from=$rows['d_pp_from'];
$d_pp_to=$rows['d_pp_to'];
$cgs_stone=$rows['cgs_stone'];
$cgs_shade=$rows['cgs_shade'];
$cgs_shape=$rows['cgs_shape'];
$cgs_quantity=$rows['cgs_quantity'];
$cgs_pp_from=$rows['cgs_pp_from'];
$cgs_pp_to=$rows['cgs_pp_to'];
$product_logo=$rows['product_logo'];
$company_logo=$rows['company_logo'];
 
/*..............Check Company Logo..................*/
$qgetimg=mysql_query("select company_logo from member_directory where registration_id='".$_SESSION['USERID']."'");
$rgetimg=mysql_fetch_array($qgetimg);
$pro_img=$rgetimg['company_logo'];
?>

<section>

	 <div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>
    </div>
	
	 <div class="container inner_container">

		<div class="row mb">
        
            <div class="col-12">
                <div class="innerpg_title">
                    <h1> Buy / Sell - Members Profile</h1>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 order-sm-12" data-sticky_parent>
                <?php include 'include/regMenu.php'; ?>
            </div>

            <div class="col-lg-9 col-md-8 col-sm-12 order-sm-1">
            
				<?php 
                if($_SESSION['msg']!=""){
                echo "<span style='color: green;'>".$_SESSION['msg']."</span>";
                $_SESSION['msg']="";
                }
        
				if($_SESSION['upload_error']!=""){
				echo "<span class='notification n-attention'>".$_SESSION['upload_error']."</span>";
				$_SESSION['upload_error']="";
				}
				?>
                
            	<form class="row" action="members_profile_inc.php" method="POST" enctype="multipart/form-data" name="member" id="member" onSubmit="return validate()">
                        
                	<input type="hidden" name="user_type" id="edit-user-type" value="<?php echo $usertype;?>"/>	
                        
                        <?php token(); ?>
                        
                        	<div class="form-group col-12">
                                <p class="blue"> Company Details </p>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="edit-company-name">Name</label>
                                <input type="text" class="form-control" name="company_name" id="edit-company-name" value="<?php echo $company_name;?>" placeholder="Name"/>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="edit-contact-person">Contact Person :</label>
                                <input type="text" class="form-control" name="contact_person" id="edit-contact-person" value="<?php echo $contact_person;?>" placeholder="Contact Person"/>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="edit-designation">Designation </label>
                                
                                <select name="designation" class="form-control" id="edit-designation" />
                                    <option value="">None of these</option>
                                    <option value="Act. Executive Director" <?php if(preg_match('/Act. Executive Director/',$designation)){echo 'selected="selected"'; } ?>>A.E.D.</option>
            <option value="Asstt. Director" <?php if(preg_match('/Asstt. Director/',$designation)){echo 'selected="selected"'; } ?>>ASSTT. DIR</option>
            <option value="Authorised Signatory" <?php if(preg_match('/Authorised Signatory/',$designation)){echo 'selected="selected"'; } ?>>AUTHO</option>
            <option value="CEO" <?php if(preg_match('/CEO/',$designation)){echo 'selected="selected"'; } ?>>CEO</option>
            <option value="Chairman" <?php if(preg_match('/Chairman/',$designation)){echo 'selected="selected"'; } ?>>CHAIRMAN</option>
            <option value="Chief Designer" <?php if(preg_match('/Chief Designer/',$designation)){echo 'selected="selected"'; } ?>>CHIEF DESI</option>
            <option value="Chief Executive" <?php if(preg_match('/Chief Executive/',$designation)){echo 'selected="selected"'; } ?>>CHIEF EXEC</option>
            <option value="CMD" <?php if(preg_match('/CMD/',$designation)){echo 'selected="selected"'; } ?>>CMD</option>
            <option value="Co-Convener" <?php if(preg_match('/Co-Convener/',$designation)){echo 'selected="selected"'; } ?>>COCONV</option>
            <option value="Commercial Officer" <?php if(preg_match('/Commercial Officer/',$designation)){echo 'selected="selected"'; } ?>>COMMERCIAL</option>
            <option value="Computer Engineer" <?php if(preg_match('/Computer Engineer/',$designation)){echo 'selected="selected"'; } ?>>COMPUTER E</option>
            <option value="Convener" <?php if(preg_match('/Convener/',$designation)){echo 'selected="selected"'; } ?>>CONV</option>
            <option value="Director" <?php if(preg_match('/Director/',$designation)){echo 'selected="selected"'; } ?>>DIRECTOR</option>
            <option value="Director (EOU &amp; SEZ)" <?php if(preg_match('/Director (EOU &amp; SEZ)/',$designation)){echo 'selected="selected"'; } ?>>DIRECTOR (EOU &amp; SEZ)</option>
            <option value="Director (P T &amp; C)" <?php if(preg_match('/Director (P T &amp; C)/',$designation)){echo 'selected="selected"'; } ?>>DIRECTOR (P T &amp; C)</option>
            <option value="Deputy Director" <?php if(preg_match('/Deputy Director/',$designation)){echo 'selected="selected"'; } ?>>DY. DIRECTOR</option>
            <option value="DY. M.D. (COMMERCIAL)" <?php if(preg_match('/DY. M.D. (COMMERCIAL)/',$designation)){echo 'selected="selected"'; } ?>>DY. M.D. CO</option>
            <option value="Executive Director" <?php if(preg_match('/Executive Director/',$designation)){echo 'selected="selected"'; } ?>>E.D.</option>
            <option value="E.D. (Admn &amp; Fin)" <?php if(preg_match('/E.D. (Admn &amp; Fin)/',$designation)){echo 'selected="selected"'; } ?>>E.D. (Admn &amp; Fin)</option>
            <option value="Export Executive" <?php if(preg_match('/Export Executive/',$designation)){echo 'selected="selected"'; } ?>>EXPORT EXE</option>
            <option value="Export Man" <?php if(preg_match('/Export Man/',$designation)){echo 'selected="selected"'; } ?>>EXPORT MAN</option>
            <option value="Finance Manager" <?php if(preg_match('/Finance Manager/',$designation)){echo 'selected="selected"'; } ?>>FINANCE MANAGER</option>
            <option value="Food &amp; Beverage Manager" <?php if(preg_match('/Food &amp; Beverage Manager/',$designation)){echo 'selected="selected"'; } ?>>FOOD &amp; BEVERAGE MANAGER</option>
            <option value="General Manager" <?php if(preg_match('/General Manager/',$designation)){echo 'selected="selected"'; } ?>>GEN MANAGER</option>
            <option value="Gjepc Leader" <?php if(preg_match('/Gjepc Leader/',$designation)){echo 'selected="selected"'; } ?>>GJEPC LEADER</option>
            <option value="GJEPC SECRETARIAL" <?php if(preg_match('/GJEPC SECRETARIAL/',$designation)){echo 'selected="selected"'; } ?>>GJEPC SECRET</option>
            <option value="Government Nominee" <?php if(preg_match('/Government Nominee/',$designation)){echo 'selected="selected"'; } ?>>GOVTNOMN</option>
            <option value="Head" <?php if(preg_match('/Head/',$designation)){echo 'selected="selected"'; } ?>>HEAD</option>
            <option value="Jewellery" <?php if(preg_match('/Jewellery/',$designation)){echo 'selected="selected"'; } ?>>JEWELLERY</option>
            <option value="KARTA OF HUF" <?php if(preg_match('/KARTA OF HUF/',$designation)){echo 'selected="selected"'; } ?>>KARTA</option>
            <option value="Manager" <?php if(preg_match('/Manager/',$designation)){echo 'selected="selected"'; } ?>>MANAGER</option>
            <option value="Manager M &amp; R" <?php if(preg_match('/Manager M &amp; R/',$designation)){echo 'selected="selected"'; } ?>>MANAGER M &amp; R</option>
            <option value="Managing Director" <?php if(preg_match('/Managing Director/',$designation)){echo 'selected="selected"'; } ?>>MANAGING D</option>
            <option value="Marketing" <?php if(preg_match('/Marketing/',$designation)){echo 'selected="selected"'; } ?>>MARKETING</option>
            <option value="Member" <?php if(preg_match('/Member/',$designation)){echo 'selected="selected"'; } ?>>MEMB</option>
            <option value="Partner" <?php if(preg_match('/Partner/',$designation)){echo 'selected="selected"'; } ?>>PARTNER</option>
            <option value="President" <?php if(preg_match('/President/',$designation)){echo 'selected="selected"'; } ?>>PRESIDENT</option>
            <option value="Prod. Man.&amp; Int. Bus. Cordin." <?php if(preg_match('/Prod. Man.&amp; Int. Bus. Cordin./',$designation)){echo 'selected="selected"'; } ?>>PROD. MAN.</option>
            <option value="Proprietor" <?php if(preg_match('/Proprietor/',$designation)){echo 'selected="selected"'; } ?>>PROPRIETER</option>
            <option value="Permanent Special Invitee" <?php if(preg_match('/Permanent Special Invitee/',$designation)){echo 'selected="selected"'; } ?>>PSPINVT</option>
            <option value="Regional Chairman" <?php if(preg_match('/Regional Chairman/',$designation)){echo 'selected="selected"'; } ?>>RCHRMN</option>
            <option value="Resigned" <?php if(preg_match('/Resigned/',$designation)){echo 'selected="selected"'; } ?>>RESIGNED</option>
            <option value="Sales Executive" <?php if(preg_match('/Sales Executive/',$designation)){echo 'selected="selected"'; } ?>>SALES EXEC</option>
            <option value="Sales Manager" <?php if(preg_match('/Sales Manager/',$designation)){echo 'selected="selected"'; } ?>>SALES MANAGER</option>
            <option value="Secretary" <?php if(preg_match('/Secretary/',$designation)){echo 'selected="selected"'; } ?>>SECRETARY</option>
            <option value="Senior Vice President" <?php if(preg_match('/Senior Vice President/',$designation)){echo 'selected="selected"'; } ?>>SENIOR VICE PRESIDENT</option>
            <option value="Special Invitee" <?php if(preg_match('/Special Invitee/',$designation)){echo 'selected="selected"'; } ?>>SPINVT</option>
            <option value="Sr. Executive" <?php if(preg_match('/Sr. Executive/',$designation)){echo 'selected="selected"'; } ?>>SR. EXECUTIVE</option>
            <option value="Vice Chairman" <?php if(preg_match('/Vice Chairman/',$designation)){echo 'selected="selected"'; } ?>>VICECHRMN</option>
            <option value="Whole Time Director" <?php if(preg_match('/Whole Time Director/',$designation)){echo 'selected="selected"'; } ?>>WHOLE TIME DIRECTOR</option>
            </select>
                                
                            </div>
                          
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="edit-website">Website</label>
                                <input type="text" class="form-control" name="website" id="edit-website" value="<?php echo $website;?>" placeholder="Website"/> 
                            </div>
                        
                            <div class="form-group col-sm-12">
                                <label class="form-label" for="edit-write-up">Brief write up</label>
                                <textarea type="text" rows="5" class="form-control" name="write_up" id="edit-write-up" placeholder="Brief write up"><?php echo $write_up;?></textarea>
                            </div>
                            
                            <div class="form-group col-12">
                                <p class="blue">We are</p>
                            </div>
            
                            <div class="form-group col-sm-6">
                          		<label class="form-label" for="wa_jewellery[]">Jewellery </label>
                          		<select name="wa_jewellery[]"  class="form-control listgroup" id="edit-wa-jewellery" >
                            <option value="importers" <?php if(preg_match('/importers/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Importers</option>
                            <option value="wholesalers" <?php if(preg_match('/wholesalers/',$wa_jewellery)){echo 'selected="selected"'; } ?> >Wholesalers</option>
                            <option value="agents" <?php if(preg_match('/agents/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Agents</option>
                            <option value="chain stores" <?php if(preg_match('/chain stores/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Chain Stores</option>
                            <option value="retailers" <?php if(preg_match('/retailers/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Retailers</option>
                            <option value="manufacturers" <?php if(preg_match('/manufacturers/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Manufacturers</option>
                            <option value="exporters" <?php if(preg_match('/exporters/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Exporters</option>
                            <option value="designers" <?php if(preg_match('/designers/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Designers</option>
                            <option value="students" <?php if(preg_match('/students/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Students</option>
                            <option value="artists/craftsmen" <?php if(preg_match('/artists/craftsmen/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Artists/Craftsmen</option>
                            <option value="goldsmiths" <?php if(preg_match('/goldsmiths/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Goldsmiths</option>
                            <option value="any other" <?php if(preg_match('/any other/',$wa_jewellery)){echo 'selected="selected"'; } ?>>Any Other</option>
                            </select>
                            </div>
                        
                            <div class="form-group col-sm-6 any_otherdiv" id="wa_jewel_other" style="display:none;">
                                <label class="form-label" for="wa_jewellery_other">Other please specify :</label>
                               	<input type="text" class="form-control" name="wa_jewellery_other" id="wa_jewellery_other" >
                            </div>
            
                            <div class="form-group col-sm-6">
                          		<label class="form-label" for="wa_machinery[]">Machinery</label>
                                <select name="wa_machinery[]" class="form-control listgroup" id="edit-wa-machinery"  >
                                <option value="importers"  <?php if(preg_match('/importers/',$wa_machinery)){echo 'selected="selected"'; } ?>>Importers</option>
                                <option value="wholesalers" <?php if(preg_match('/wholesalers/',$wa_machinery)){echo 'selected="selected"'; } ?>>Wholesalers</option>
                                <option value="agents" <?php if(preg_match('/agents/',$wa_machinery)){echo 'selected="selected"'; } ?>>Agents</option>
                                <option value="chain stores" <?php if(preg_match('/chain stores/',$wa_machinery)){echo 'selected="selected"'; } ?>>Chain Stores</option>
                                <option value="retailers" <?php if(preg_match('/retailers/',$wa_machinery)){echo 'selected="selected"'; } ?>>Retailers</option>
                                <option value="manufacturers" <?php if(preg_match('/manufacturers/',$wa_machinery)){echo 'selected="selected"'; } ?>>Manufacturers</option>
                                <option value="exporters" <?php if(preg_match('/exporters/',$wa_machinery)){echo 'selected="selected"'; } ?>>Exporters</option>
                                <option value="distributors" <?php if(preg_match('/distributors/',$wa_machinery)){echo 'selected="selected"'; } ?>>Distributors</option>
                                <option value="students" <?php if(preg_match('/students/',$wa_machinery)){echo 'selected="selected"'; } ?>>Students</option>
                                <option value="foreign representatives" <?php if(preg_match('/foreign representatives/',$wa_machinery)){echo 'selected="selected"'; } ?>>Foreign Representatives</option>
                                <option value="any other" <?php if(preg_match('/any other/',$wa_machinery)){echo 'selected="selected"'; } ?>>Any Other</option>
                                </select>
                            </div>
                         
            				<div class="form-group col-sm-6 any_otherdiv" id="wa_machin_other" style="display:none;">
                            	<label class="form-label" for="wa_machinery_other">Other please specify :</label>
                                <input type="text" class="form-control" name="wa_machinery_other" id="wa_machinery_other">
                            </div>
            
                            <div class="form-group col-sm-6">
                            	<label class="form-label" for="wa_machinery[]">Others</label>
                                <select name="wa_other[]" class="form-control listgroup" id="edit-wa-other">
                                <option value="ancillary suppliers" <?php if(preg_match('/ancillary suppliers/',$wa_other)){echo 'selected="selected"'; } ?>>Ancillary Suppliers</option>
                                <option value="publications" <?php if(preg_match('/publications/',$wa_other)){echo 'selected="selected"'; } ?>>Publications</option>
                                <option value="service providers" <?php if(preg_match('/service providers/',$wa_other)){echo 'selected="selected"'; } ?>>Service Providers</option>
                                <option value="raw material suppliers" <?php if(preg_match('/raw material suppliers/',$wa_other)){echo 'selected="selected"'; } ?>>Raw Material Suppliers</option>
                                <option value="associations" <?php if(preg_match('/associations/',$wa_other)){echo 'selected="selected"'; } ?>>Associations</option>
                                <option value="any other" <?php if(preg_match('/any other/',$wa_other)){echo 'selected="selected"'; } ?>>Any Other</option>
                                </select>
                            </div>
            
                            <div class="form-group col-sm-6 any_otherdiv" id="wa_machin_other" style="display:none;">
                                <label class="form-label" for="wa_machinery_other">Other please specify </label>
                                <input type="text" class="form-control" name="wa_other_other" id="edit-wa-other-other" size="60" value="" >
                            </div>
                    
            				<div class="form-group col-12">
                          		<p class="blue">Products Dealing in</p>
                            </div>
            
                            <div class="form-group col-sm-6">
                            	<label class="form-label" for="wa_jewellery[]">Jewellery </label>
                                
                                <select name="pd_jewellery[]"  class="form-control listgroup" id="edit-pd-jewellery" >
                                <option value="plain gold jewellery" <?php if(preg_match('/plain gold jewellery/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Plain Gold Jewellery</option>
                                <option value="studded gold jewellery" <?php if(preg_match('/studded gold jewellery/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Studded Gold Jewellery</option>
                                <option value="loose diamonds" <?php if(preg_match('/loose diamonds/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Loose Diamonds</option>
                                <option value="coloured gemstones" <?php if(preg_match('/coloured gemstones/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Coloured Gemstones</option>
                                <option value="pearls" <?php if(preg_match('/pearls/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Pearls</option>
                                <option value="costume jewellery" <?php if(preg_match('/costume jewellery/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Costume Jewellery</option>
                                <option value="platinum jewellery" <?php if(preg_match('/platinum jewellery/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Platinum Jewellery</option>
                                <option value="silver jewellery" <?php if(preg_match('/silver jewellery/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Silver Jewellery</option>
                                <option value="software products" <?php if(preg_match('/software products/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Software Products</option>
                                <option value="publications" <?php if(preg_match('/publications/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Publications</option>
                                <option value="educational institutions" <?php if(preg_match('/educational institutions/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Educational Institutions</option>
                                <option value="associations" <?php if(preg_match('/associations/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Associations</option>
                                <option value="service providers" <?php if(preg_match('/service providers/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Service Providers</option>
                                <option value="any other" <?php if(preg_match('/any other/',$pd_jewellery)){echo 'selected="selected"'; } ?>>Any Other</option>
                                </select>
                             
                            </div>
            
                            <div class="form-group col-sm-6 any_otherdiv" id="wa_jewel_other" style="display:none;">
                                <label class="form-label" for="wa_jewellery_other">Other please specify :</label>
                                <input type="text" name="pd_jewellery_other" id="edit-pd-jewellery-other" size="60" value="ations" class="form-control" >
                            </div>
            
                            <div class="form-group col-sm-6">
                            	<label class="form-label" for="wa_machinery[]">Machinery </label>
                                <select name="pd_machinery[]" class="form-control listgroup" id="edit-pd-machinery" >
                                <option value="jewellery making machinery" <?php if(preg_match('/jewellery making machinery/',$pd_machinery)){echo 'selected="selected"'; } ?>>Jewellery Making Machinery</option>
                                <option value="equipments/tools" <?php if(preg_match('/equipments/tools/',$pd_machinery)){echo 'selected="selected"'; } ?>>Equipments/Tools</option>
                                <option value="ancillary products" <?php if(preg_match('/ancillary products/',$pd_machinery)){echo 'selected="selected"'; } ?>>Ancillary Products</option>
                                <option value="software company" <?php if(preg_match('/software company/',$pd_machinery)){echo 'selected="selected"'; } ?>>Software Company</option>
                                <option value="publications" <?php if(preg_match('/publications/',$pd_machinery)){echo 'selected="selected"'; } ?>>Publications</option>
                                <option value="educational insitutions" <?php if(preg_match('/educational insitutions/',$pd_machinery)){echo 'selected="selected"'; } ?>>Educational Insitutions</option>
                                <option value="associations" <?php if(preg_match('/associations/',$pd_machinery)){echo 'selected="selected"'; } ?>>Associations</option>
                                <option value="any other" <?php if(preg_match('/any other/',$pd_machinery)){echo 'selected="selected"'; } ?>>Any Other</option>
                                </select>
                                
                            </div>
            
                            <div class="form-group col-sm-6 any_otherdiv" id="wa_machin_other" style="display:none;">
                               <label class="form-label" for="wa_machinery_other">Other please specify :</label>
                               <input type="text" name="pd_machinery_other" id="edit-pd-machinery-other" size="60" value="" class="form-control">
                            </div>
            
                       		<div class="form-group col-12">
                            <p class="blue">Objective of visiting trade shows</p>
                            <span id="error_objective"></span>
                            </div>
            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="wa_jewellery[]">Please select area of your interest </label>
                                <select name="objective[]" class="form-control listgroup" id="edit-objective">
                                <option value="buying" <?php if(preg_match('/buying/',$objective)){echo 'selected="selected"'; } ?>>Buying</option>
                                <option value="source suppliers" <?php if(preg_match('/source suppliers/',$objective)){echo 'selected="selected"'; } ?>>Source Suppliers</option>
                                <option value="joint ventures" <?php if(preg_match('/joint ventures/',$objective)){echo 'selected="selected"'; } ?>>Joint Ventures</option>
                                <option value="importing" <?php if(preg_match('/importing/',$objective)){echo 'selected="selected"'; } ?>>Importing</option>
                                <option value="appointing agents" <?php if(preg_match('/appointing agents/',$objective)){echo 'selected="selected"'; } ?>>Appointing Agents</option>
                                <option value="evaluate for future participation" <?php if(preg_match('/evaluate for future participation/',$objective)){echo 'selected="selected"'; } ?>>Evaluate For Future Participation</option>
                                <option value="market information" <?php if(preg_match('/market information/',$objective)){echo 'selected="selected"'; } ?>>Market Information</option>
                                <option value="seek representatives" <?php if(preg_match('/seek representatives/',$objective)){echo 'selected="selected"'; } ?>>Seek Representatives</option>
                                <option value="source technology" <?php if(preg_match('/source technology/',$objective)){echo 'selected="selected"'; } ?>>Source Technology</option>
                                <option value="place orders" <?php if(preg_match('/place orders/',$objective)){echo 'selected="selected"'; } ?>>Place Orders</option>
                                <option value="any other" <?php if(preg_match('/any other/',$objective)){echo 'selected="selected"'; } ?>>Any Other</option>
                                </select>
                            </div>
            
                            <div class="form-group col-sm-6 any_otherdiv" id="wa_jewel_other" style="display:none;">
                            	<label class="form-label" for="wa_jewellery_other">Other please specify </label>
                                <input type="text" name="objective_other" id="edit-objective-other" size="60" value="" class="form-control">
                            </div>
            
                 
            
                        <div class="form-group col-12">
                            <p class="blue">Presently Importing From</p><span id="error_importing"></span>
                         </div>
            
                            <div class="form-group col-sm-6">
                               <label class="form-label" for="wa_jewellery[]">Please select the below countries* </label>
                             
                                <select name="import_from[]"  class="form-control listgroup" id="edit-import-from" >
                                <option value="asia" <?php if(preg_match('/asia/',$import_from)){echo 'selected="selected"'; } ?>>Asia</option>
                                <option value="europe" <?php if(preg_match('/europe/',$import_from)){echo 'selected="selected"'; } ?>>Europe</option>
                                <option value="usa" <?php if(preg_match('/usa/',$import_from)){echo 'selected="selected"'; } ?>>USA</option>
                                <option value="canada" <?php if(preg_match('/canada/',$import_from)){echo 'selected="selected"'; } ?>>Canada</option>
                                <option value="far east" <?php if(preg_match('/far east/',$import_from)){echo 'selected="selected"'; } ?>>Far East</option>
                                <option value="middle east" <?php if(preg_match('/middle east/',$import_from)){echo 'selected="selected"'; } ?>>Middle East</option>
                                <option value="africa" <?php if(preg_match('/africa/',$import_from)){echo 'selected="selected"'; } ?>>Africa</option>
                                <option value="australia" <?php if(preg_match('/australia/',$import_from)){echo 'selected="selected"'; } ?>>Australia</option>
                                <option value="new zealand" <?php if(preg_match('/new zealand/',$import_from)){echo 'selected="selected"'; } ?>>New Zealand</option>
                                <option value="india" <?php if(preg_match('/india/',$import_from)){echo 'selected="selected"'; } ?>>India</option>
                                <option value="any other" <?php if(preg_match('/any other/',$import_from)){echo 'selected="selected"'; } ?>>Any Other</option>
                              </select>
                                
                            </div>
            
                            <div class="form-group col-sm-6 any_otherdiv" id="wa_jewel_other" style="display:none;">
                               <label class="form-label" for="wa_jewellery_other">Other please specify :</label>
                                <input type="text" name="objective_other" id="edit-objective-other" size="60" value="" class="form-control">
                            </div>
                    
            
                        	<div class="form-group col-12">
                            	<p class="blue">Items Interested in</p><span id="error_interested"></span>
                            </div>
            
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="wa_jewellery[]">Please select your items of interest* </label>
                                
                                <select name="item_interest[]" class="form-control listgroup" id="edit-item-interest" >
                                <option value="rings" <?php if(preg_match('/rings/',$item_interest)){echo 'selected="selected"'; } ?>>Rings</option>
                                <option value="pendants" <?php if(preg_match('/pendants/',$item_interest)){echo 'selected="selected"'; } ?>>Pendants</option>
                                <option value="bracelets" <?php if(preg_match('/bracelets/',$item_interest)){echo 'selected="selected"'; } ?>>Bracelets</option>
                                <option value="bangles" <?php if(preg_match('/bangles/',$item_interest)){echo 'selected="selected"'; } ?>>Bangles</option>
                                <option value="chains" <?php if(preg_match('/chains/',$item_interest)){echo 'selected="selected"'; } ?>>Chains</option>
                                <option value="necklaces" <?php if(preg_match('/necklaces/',$item_interest)){echo 'selected="selected"'; } ?>>Necklaces</option>
                                <option value="loose diamonds" <?php if(preg_match('/loose diamond/',$item_interest)){echo 'selected="selected"'; } ?>>Loose Diamonds</option>
                                <option value="coloured gemstones" <?php if(preg_match('/coloured gemstones/',$item_interest)){echo 'selected="selected"'; } ?>>Coloured Gemstones</option>
                                <option value="any other" <?php if(preg_match('/any other/',$item_interest)){echo 'selected="selected"'; } ?>>Any Other</option>
                                </select>                                
                            </div>
            
                            <div class="form-group col-sm-6" id="wa_jewel_other" >
                               <label class="form-label" for="wa_jewellery_other">Caratage Preference</label>
                               <input type="text" name="caratage" id="edit-caratage" size="60" value="<?php echo $caratage;?>" class="form-control" />
                            </div>            
            
                        	<div class="form-group col-sm-6">
                            	
                                <div class="d-flex">					
                                <?php if($product_logo!=''){?>
                                    <div>
                                        <img id="preview" src="product_logo/<?php echo $product_logo;?>" class="img-responsive previewPic"/>
                                    </div>
								<?php } else { ?>
                                <div><img id="preview" src="images/upload_img.jpg" class="img-responsive previewPic" /></div><?php } ?> 
                                <div class="ml-3"> 
                                	<p><b>Product Logo</b></p>
                                	 <input name="product_logo" type="file" accept=".jpg,.jpeg,.png"/>
                              </div>
                                </div>
                             </div>                        
                           
                            <div class="form-group col-sm-6">
                            <div class="d-flex">		
                            <?php if($company_logo!=''){?>
                            <div><img id="preview" src="company_logo/<?php echo $company_logo;?>" class="img-responsive previewPic"/></div>
							<?php } else { ?><div><img id="preview" src="images/upload_img.jpg" class="img-responsive previewPic"/></div><?php } ?>
                                
                                <div class="ml-3">                                   
                                    <p><b>Company Logo</b><span id="error_company_logo"></span></p>
                                    <input name="company_logo" type="file" id="company_logo" accept=".jpg,.jpeg,.png"/>
                                </div>
                            </div>
                        	</div>
                            <div class="form-group col-12">
                                <button class="cta fade_anim">Save</button>
                            </div>                      
                    </form>                
            </div>            
		</div>        
    </div>      
</section>
    
<?php include 'include/footer.php'; ?>
<script type="text/javascript" src="js/member_directory.js"></script>

<script type="text/ecmascript">
function validate() {
		if(document.getElementById('edit-company-name').value =='')
		{
		var flag1=1;
		$('#error_company').html("Required field");
		}
		else{$('#error_company').html("");var flag1=0;}
		
		if(document.getElementById('edit-contact-person').value ==''){
		$('#error_contact').html("Required field");
		var flag2=1;
		}
		else{$('#error_contact').html("");var flag2=0;}
		
		if(document.getElementById('edit-designation').value ==''){
		$('#error_designation').html("Required field");
		var flag3=1;
		}
		else{$('#error_designation').html("");var flag3=0;}
		
		if(document.getElementById('edit-write-up').value ==''){
		$('#error_brief').html("Required field");
		var flag4=1;
		}
		else{$('#error_brief').html("");var flag4=0;}
		
       if((document.getElementById('edit-wa-jewellery').value == '') && (document.getElementById('edit-wa-machinery').value == '') && (document.getElementById('edit-wa-other').value==''))
		  {
		  $('#error_weare').html("Please select atleast one option under 'We Are'");
		  var flag5=1;
		  }
		  else{$('#error_weare').html(""); var flag5=0;}
		  
  		if((document.getElementById('edit-pd-jewellery').value == '') && (document.getElementById('edit-pd-machinery').value == '')) 		{
		var flag6=1;
		$('#error_pdin').html("Please select atleast one option under 'Products Dealing in'");
		}
		else{$('#error_pdin').html("");var flag6=0;}
		 
		if(document.getElementById('edit-objective').value ==''){
		var flag7=1;
		$('#error_objective').html("Please select area of your interest field is required.");
		}
		else{$('#error_objective').html("");var flag7=0;}
		
		if(document.getElementById('edit-import-from').value ==''){
		var flag8=1;
		$('#error_importing').html("Please select the below countries field is required.");
		}
		else{$('#error_importing').html("");var flag8=0;}
		
		if(document.getElementById('edit-item-interest').value ==''){
		var flag9=1;
		$('#error_interested').html("Please select your items of interest field is required.");
		}
		else{$('#error_interested').html("");var flag9=0;}
		var pro_img = "<?php echo $pro_img?>";
		if((document.getElementById('company_logo').value =='') && (pro_img =='')){
		var flag10=1;
		$('#error_company_logo').html("Please upload your company logo.");
		}
		else{$('#error_company_logo').html("");var flag10=0;}
		
		if(flag1==1 || flag2==1 || flag3==1 || flag4==1 || flag5==1 || flag6==1 || flag7==1 || flag8==1 || flag9==1 || flag10==1)
		{
		  return false;
		}
		else
		{
			return true
		}	
}
</script>