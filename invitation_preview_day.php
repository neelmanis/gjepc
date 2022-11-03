<?php 
include 'include/header.php';
include 'db.inc.php';
include 'functions.php';
?>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$("#regisForm").validate({
		rules: {
			name_of_retail_showroom: {
				required: true,
			},
			owner_showroom_address: {
				required: true,
			},
			name_of_owner: {
				required: true,
			},
			owner_mobile_no: {
				required: true,
			},
			owner_email_id: {
				required: true,
			}, 
			secretariat_name: {
				required: true,
			},
			secretariat_designation: {
				required: true,
			}, 	 
			secretariat_mobile_no: {
				required: true,
			},
			secretariat_email_id: {
				required: true,
			},
      		company_gst: {
        		required: true,
      		},
			company_pan: {
        		required: true,
      		},
			store_frontage_picture: {
        		required: true,
      		},
			promotional_add: {
        		required: true,
      		},
			social_media_coverage: {
        		required: true,
      		},
		},
		messages: {
			name_of_retail_showroom: {
				required: "Retailer Name is Required.",
			}, 
			showroom_address: {
				required: "Showroom address is required.",
			},  
			name_of_owner: {
				required: "Please Enter Owner Name",
			},
			owner_mobile_no: {
				required: "Please Enter Owner Mobile No.",
			},
			owner_email_id: {
				required: "Please Enter Owner Email Id.",
			},
			secretariat_name: {
				required: "Please Enter Secretariat Name",
			},   
			secretariat_designation: {
				required: "Please Enter Secretariat Designation",
			},  
			secretariat_mobile_no: {
				required: "Please Enter Secretariat Mobile No.",
			},
			secretariat_email_id: {
				required: "Please Enter Secretariat Email Id",
			},
      		company_gst: {
        		required: "Please Upload Company Gst.",
      		},
			company_pan: {
        		required: "Please Upload Company Pan.",
      		},
			store_frontage_picture: {
        		required: "Please Upload Frontage Store Picture.",
      		},
			promotional_add: {
        		required: "Please Upload Promotonal Add",
      		},
			social_media_coverage: {
        		required: "Please Upload Media Coverage.",
      		},
	 }
	});
});
</script>
<?php 
function getExtension($str)
{
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}
$action=$_REQUEST['action'];
if($action=="save")
{
   $name_of_retail_showroom=$_REQUEST['name_of_retail_showroom'] ;
   $owner_showroom_address=$_REQUEST['owner_showroom_address'] ;
   $name_of_owner=$_REQUEST['name_of_owner'] ;
   $owner_mobile_no=$_REQUEST['owner_mobile_no'] ;
   $owner_email_id= $_REQUEST['owner_email_id'];
   $secretariat_name=$_REQUEST['secretariat_name'] ;
   $secretariat_designation= $_REQUEST['secretariat_designation'];
   $secretariat_mobile_no=$_REQUEST['secretariat_mobile_no'] ;
   $secretariat_email_id= $_REQUEST['secretariat_email_id'];
   $post_date=date('Y-m-d');
   $ip=$_SERVER['REMOTE_ADDR'];
   
   if(isset($_FILES['company_gst']) && $_FILES['company_gst']['name']!="")
	{
		/*.......................Company GST..........................*/
		$company_gst_name=$_FILES['company_gst']['name'];
		$company_gst_temp=$_FILES['company_gst']['tmp_name'];
		$ext = getExtension($company_gst_name);
		$actual_image_name1 = str_replace(" ", "_", $company_gst_name).".".$ext;
		$path ='preview_day/'.$actual_image_name;
		if($company_gst_name!="")
		{
			$fileUploaded= move_uploaded_file($company_gst_temp, $path);
		}
	}
	if(isset($_FILES['company_pan']) && $_FILES['company_pan']['name']!="")
	{
		/*.......................Company Pan..........................*/
		$company_pan_name=$_FILES['company_pan']['name'];
		$company_pan_temp=$_FILES['company_pan']['tmp_name'];
		$ext = getExtension($company_pan_name);
		$actual_image_name2 = str_replace(" ", "_", $company_pan_name).".".$ext;
		$path ='preview_day/'.$actual_image_name;
		if($company_pan_name!="")
		{
			$fileUploaded= move_uploaded_file($company_pan_temp, $path);
		}
	}
	if(isset($_FILES['store_frontage_picture']) && $_FILES['store_frontage_picture']['name']!="")
	{
		/*.......................Company Pan..........................*/
		$store_frontage_picture_name=$_FILES['store_frontage_picture']['name'];
		$store_frontage_picture_temp=$_FILES['store_frontage_picture']['tmp_name'];
		$ext = getExtension($store_frontage_picture_name);
		$actual_image_name3 = str_replace(" ", "_", $store_frontage_picture_name).".".$ext;
		$path ='preview_day/'.$actual_image_name;
		if($store_frontage_picture_name!="")
		{
			$fileUploaded= move_uploaded_file($store_frontage_picture_temp, $path);
		}
	}
   	if(isset($_FILES['promotional_add']) && $_FILES['promotional_add']['name']!="")
	{
		/*.......................Company Pan..........................*/
		$promotional_add_name=$_FILES['promotional_add']['name'];
		$promotional_add_temp=$_FILES['promotional_add']['tmp_name'];
		$ext = getExtension($promotional_add_name);
		$actual_image_name4 = str_replace(" ", "_", $promotional_add_name).".".$ext;
		$path ='preview_day/'.$actual_image_name;
		if($promotional_add_name!="")
		{
			$fileUploaded= move_uploaded_file($promotional_add_temp, $path);
		}
	}
    $insert = "insert into invitation_preview_day set name_of_retail_showroom='$name_of_retail_showroom',owner_showroom_address='$owner_showroom_address', name_of_owner='$name_of_owner',owner_mobile_no='$owner_mobile_no',owner_email_id='$owner_email_id',secretariat_name='$secretariat_name',secretariat_designation='$secretariat_designation',secretariat_mobile_no='$secretariat_mobile_no',secretariat_email_id='$secretariat_email_id',company_gst='$actual_image_name1',company_pan='$actual_image_name2',store_frontage_picture='$actual_image_name3',promotional_add='$actual_image_name4',post_date='$post_date',ip='$ip'"; 
	
  if($inserted=mysql_query($insert,$dbconn)){
  	$_SESSION['succ_msg']="You have been successfully registered";
  }else{
  	$_SESSION['err_msg']="There is some technical problem";
  }

  $invitation_id = mysql_insert_id();
  $showroom_city=$_POST['showroom_city'];
  $showroom_address=$_POST['showroom_address'];
  $showroom_area=$_POST['showroom_area'];
  $year_of_establishmanr=$_POST['year_of_establishmanr'];
  
  array_filter($showroom_city, function($x) { return !empty($x); });
  $cityCount =count(array_filter($showroom_city));
  for ($i=0; $i<$cityCount; $i++) {
	$city=$showroom_city[$i];
	$address=$showroom_address[$i];
	$area=$showroom_area[$i];
	$yoe=$year_of_establishmanr[$i];
	mysql_query("INSERT INTO  invitation_address SET invitation_id='$invitation_id',showroom_city='$city',showroom_address='$address',showroom_area='$area',year_of_establishmanr='$yoe'");
  }
}
?>
<div class="col-xs-12 wrapper di_reg">
	<div class="title"> <h4>Nomination Form For Preview Day - 8th August 2019 by Invitation only </h4> 
    </div>
	<div class="content">
        <div class="di_reg_form">     	
            <div class="di_subtitle">
            <P>Welcome to India International Jewellery Show 2019, (IIJS Premiere 2019) 9th to 12th August, 2019 and 8th August 2019 - Preview day by invitation only, at Bombay Exhibition Centre, Goregaon, Mumbai.
In our endeavour, to make your visit to the show more comfortable & enriching, we are opening the doors of IIJS Premiere 2019 for SELECTED BUYERS |BY INVITATION on 8th August - ‘Preview Day’. The objective of preview day is to provide you with business/networking opportunity with the exhibitors in a comparatively quieter and focused atmosphere
</P>
                <p>Request you to please share / submit the below said details to GJEPC latest by 15th June, 2019.</p>
                <p>Kindly note that the selection/invitation will be based on the criteria set by the management. The database provided to GJEPC will be highly confidential and will solely be used for the promotion of GJEPC events only.</p>
            </div>
            <?php 
            if($_SESSION['err_msg']!=""){
            echo "<span style='color: red;'>".$_SESSION['err_msg']."</span>";
            $_SESSION['err_msg']="";
            }
            if($_SESSION['succ_msg']!=""){
            echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
            $_SESSION['succ_msg']="";
            }
            else{
            ?>
            <form class="row" method="POST" name="regisForm" id="regisForm" autocomplete="off" enctype="multipart/form-data">
            <!--<form class="row" method="POST"  autocomplete="off" enctype="multipart/form-data">-->	
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Name of Retail Showroom* :   </label>  
                    <input type="text" name="name_of_retail_showroom" id="name_of_retail_showroom" autocomplete="off" class="input_style"/>
                </div>
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Name of Owner/ Partner / Director* :   </label>  
                    <input type="text" name="name_of_owner" id="name_of_owner" autocomplete="off" class="input_style" />
                </div>
                
                <div class="col-xs-12 col-md-12 form-group"> 
                	<label> Showroom Address : </label>  
                    <input type="text" name="owner_showroom_address" id="owner_showroom_address" autocomplete="off" class="input_style"/>
                </div>

                <div class="col-xs-12 col-md-6 form-group"> 
                	<label>Mobile No of Owner/ Partner / Director *: </label>  
                    <input type="text" name="owner_mobile_no" id="owner_mobile_no" autocomplete="off" class="input_style"/>
                </div>
                
                   <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Email Id*:    </label>  
                    <input type="text" name="owner_email_id" id="owner_email_id" autocomplete="off" class="input_style"/>
                </div>
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Name of Secretariat Person*:  </label>  
                    <input type="text" name="secretariat_name" id="secretariat_name" autocomplete="off" maxlength="10" class="input_style"/>
                </div>                
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Designation :</label>  
                    <input type="text" name="secretariat_designation" id="secretariat_designation" autocomplete="off" class="input_style"/>
                </div>
				
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Mobile No* :   </label>  
                    <input type="text" name="secretariat_mobile_no" id="secretariat_mobile_no" autocomplete="off" class="input_style"/>
                </div>
                
                <div class="col-xs-12 col-md-6 form-group"> 
                	<label> Email Id* :</label>  
                    <input type="text" name="secretariat_email_id" id="secretariat_email_id" autocomplete="off" class="input_style"/>
                </div>
				
				<!--<div class="col-xs-12 col-md-6 form-group"> 
                	<label>Designation  </label>  
                    <input type="text" name="designation" id="designation" autocomplete="off" class="input_style"/>
                </div>-->
                
                <h5>Kindly submit your KYC details below*and attach company GST / Gomastha Certificate, Company Pan Card for verification purpose only.</h5>
                
                <div class="col-xs-12 col-md-12 form-group">                 
                <table class="rwd-table">  					
                    <tr>
    					<th width="50">Sr No.</th>
    					<th class="smallTh">Showroom branch in which city</th>
    					<th >Showroom Address</th>
    					<th class="smallTh">Area of Showroom in (Sqft)</th>
    					<th class="smallTh">No of Employees/ Per Showroom</th>
                        <th class="smallTh">Year of Establishment </th>
					</tr>  					
                    <tr>
    					<td data-th="Sr No.">1</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]"></td>
                        <td data-th="No of Employees/ Per Showroom"><input type="text" name="no_of_employee[]"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishmanr[]"></td>
  					</tr>
                    
                    <tr>
    					<td data-th="Sr No.">2</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]"></td>
                        <td data-th="No of Employees/ Per Showroom"><input type="text" name="no_of_employee[]"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishmanr[]"></td>
  					</tr>
                    
                    <tr>
    					<td data-th="Sr No.">3</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]"></td>
                        <td data-th="No of Employees/ Per Showroom"><input type="text" name="no_of_employee[]"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishmanr[]"></td>
  					</tr>
                    <tr>
    					<td data-th="Sr No.">4</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]"></td>
                        <td data-th="No of Employees/ Per Showroom"><input type="text" name="no_of_employee[]"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishmanr[]"></td>
  					</tr>
                    <tr>
    					<td data-th="Sr No.">5</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]"></td>
                        <td data-th="No of Employees/ Per Showroom"><input type="text" name="no_of_employee[]"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishmanr[]"></td>
  					</tr>
  					
				
                </table>

</div>
	<p>(If you have more than five showroom branches, then kindly email us their details at annu@gjepcindia.com)</p>
				<div class="col-md-6 col-lg-4 browse form-group">
                <label>Company GST / Gomastha Certificate (.jpg, .png)</label>
                <input type="file" name="company_gst" id="company_gst" value="">
                </div>
                
                <div class="col-md-6 col-lg-4 browse form-group">
                <label>Company Pan Card (.jpg, .png)</label>
                <input type="file" name="company_pan" id="company_pan" value="">
                </div>
                
                <div class="clearfix"></div>
                
                <!--<div class="col-xs-12">
                <p><strong>Please upload below document to fulfill preview day criteria:</strong></p> 
                </div>-->
                
                <div class="col-md-6 col-lg-4 browse form-group">
                <label>Picture of Store Frontage(.jpg, .png)</label>
                <input type="file" name="store_frontage_picture" id="store_frontage_picture" value="">
                </div>
                
                <div class="col-md-6 col-lg-4 browse form-group">
                <label>Picture  of Any Types Of Promotional Activity (Advt,./ Holding / Social Media Promoition of Reatail Showroom)(.jpg, .png)</label>
                <input type="file" name="promotional_add" id="promotional_add" value="">
                </div>
                
                <div class="col-xs-12"> 
				 <p>** Kindly note - IIJS badge is compulsory for your entry at the show.</p> 
                </div>

                 <div class="col-xs-12 col-md-12 form-group"> 
                	<button  type="submit" class="submit" id="submit"> Submit</button>
                  	<input type="hidden" name="action" value="save" />
                </div>
                
                <div class="clear"></div>               
            </form>    
            <?php }?>        
        </div>        
	</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="row mainRow">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="upcomingEvents">
		        <div class="title">
		          <h4>Upcoming Events</h4>
		        </div>
		        <?php include 'include/eventsslider.php'; ?>
	      </div>
		</div>
	</div>	
</div>

<?php include 'include/footer.php'; ?>

<style>		

.di_reg .title {margin-bottom:25px;}
.di_reg_form {background:#fff; width:100%; padding:15px;}
.di_subtitle {padding-bottom:15px; border-bottom:1px solid #ddd; margin-bottom:15px; }
.di_subtitle h5 {font-size:18px;}

.di_reg_form  .input_style {width:100%; padding:5px; border:1px solid #ddd;}
.di_reg_form label {width:100%; font-size:16px;}

.di_reg_form textarea{height:100px;}

.di_reg_form button.submit {background:#000; color:#fff; padding:10px 15px; border:0;}
.di_reg_form span {font-size:11px; font-style:italic;}

.rwd-table {
  margin: 1em 0;
  min-width: 300px;
}
.rwd-table tr {
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
.rwd-table th {
  display: none;
}

.rwd-table input[type="text"], .rwd-table input[type="number"]{
	width:100%;
	}

.browse label{
	font-size:14px; font-weight:bold;}
.browse input[type="file"]{
	border:1px solid #ccc; padding:8px;}


@media (min-width: 1000px) {
.rwd-table th.smallTh{
	width:150px;}

.rwd-table th.bigTh{
	width:350px;}
}

.rwd-table td {
  display: block;	
}
.rwd-table td:first-child {
  padding-top: 0.5em;
}
.rwd-table td:last-child {
  padding-bottom: 0.5em;
}
.rwd-table td:before {
  content: attr(data-th) ": ";
  font-weight: bold;
  /*width: 6.5em;*/
  display: inline-block;
}
@media (min-width: 600px) {
  .rwd-table td:before {
    display: none;
  }
}
.rwd-table th,
.rwd-table td {
  text-align: left;
}
@media (min-width: 600px) {
  .rwd-table th,
  .rwd-table td {
    display: table-cell;
    padding: 0.25em 0.5em;
	text-align:center;
  }
  .rwd-table th:first-child,
  .rwd-table td:first-child {
    padding-left: 0;
  }
  .rwd-table th:last-child,
  .rwd-table td:last-child {
    padding-right: 0;
  }
}
.rwd-table {
 overflow: hidden;
  width:100%;
}
.rwd-table tr {
  border-color: #ddd;
}
.rwd-table th,
.rwd-table td {
  margin: 0.5em 1em;
}
@media (min-width: 600px) {
  .rwd-table th,
  .rwd-table td {
    padding: 1em !important;
  }
  .rwd-table th,
.rwd-table td:before {
background:#ddd;}
}
</style> 