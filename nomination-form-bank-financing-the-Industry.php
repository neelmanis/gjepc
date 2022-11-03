<?php 
include('header_include.php');
include('include-new/header.php');
// print_r($_SESSION);
// $step = "qualitative_information";  
// $_SESSION['bank_step'] = $step;
// $step = "bank_general_info";
          
// Configure upload directory and allowed file types
$upload_dir = 'images/igja_awards/';
$allowed_types = array('jpg', 'png', 'jpeg', 'doc','pdf','PDF','docx','csv','zip');
// Define maxsize for files i.e 2MB
$maxsize = 2 * 1024 * 1024;
  $created_at =date("Y-m-d H:i:s");
  $reg_id = $_SESSION["bank_reg_id"];
 if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="general_info"){

    $bank_name = filter($_REQUEST['bank_name']);
    $year = filter($_REQUEST['year']);
   
    $tel_no = filter($_REQUEST['tel_no']);
    $fax_no = filter($_REQUEST['fax_no']);
    $email_id = filter($_REQUEST['email_id']);
    $website = filter($_REQUEST['website']);
    $address_line_1 = filter($_REQUEST['address_line_1']);
    $address_line_2 = filter($_REQUEST['address_line_2']);
    $city = filter($_REQUEST['city']);
    $state = filter($_REQUEST['state']);
    $zipcode = filter($_REQUEST['zipcode']);
    $bank_type = filter($_REQUEST['bank_type']);
    $end_year = filter($_REQUEST['end_year']);
    if(!empty(array_filter($_FILES['attatchment']['name']))) {

        // Loop through each file in files[] array
        foreach ($_FILES['attatchment']['tmp_name'] as $key => $value) {
      
        $file_tmpname = $_FILES['attatchment']['tmp_name'][$key];
        $file_name = $_FILES['attatchment']['name'][$key];
        $file_name = str_replace(" ","_",$file_name);
        $file_name = time().'_'.$file_name;
        $attatchments[] = $file_name;
        $file_size = $_FILES['attatchment']['size'][$key];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        // Set upload file path
        $filepath = $upload_dir.$file_name;
        // Check file type is allowed or not
        if(in_array(strtolower($file_ext), $allowed_types)) {
        // Verify file size - 2MB max
          if ($file_size > $maxsize){
              $signup_error="Error: File size is larger than the allowed limit.";
          }else{
                // If file with name already exist then append time in
          // front of name of the file to avoid overwriting of file
          $filepath = $upload_dir.$file_name;
          move_uploaded_file($file_tmpname, $filepath);
            }
        }
        else {
        
          // If file extention not valid
          $signup_error= "Error uploading {$file_name} ";
          $signup_error= "({$file_ext} file type is not allowed)<br / >";
          }
        }
    } 
     $senior_management = serialize(array("sm_title"=>$_POST['sm_title'],"sm_name"=>$_POST['sm_name'],"sm_designation"=>$_POST['sm_designation'])); 
     $finance_details = serialize(array("particular"=>$_POST['fin_details'],"FY20"=>$_POST['fin_details_FY20'],"FY19"=>$_POST['fin_details_FY19'],"FY18"=>$_POST['fin_details_FY18']));
        $attatchments = serialize(array("attatchment"=>$attatchments));     
      $sql_general_info = "INSERT INTO igja_best_bank_financing_award SET bank_name='$bank_name',year='$year',tel_no='$tel_no',fax_no='$fax_no',email_id='$email_id',website='$website',address_line_1='$address_line_1',address_line_2='$address_line_2',city='$city',state='$state',zipcode='$zipcode',bank_type='$bank_type',senior_management='$senior_management',finance_details='$finance_details',end_year='$end_year',attatchment='$attatchments',created_at='$created_at'";

      $result = $conn->query($sql_general_info);
        if($result ===TRUE){

           $reg_id =  $conn->insert_id;
           $step = "bank_general_info";
           $_SESSION['bank_reg_id'] = $reg_id ;
           $_SESSION['bank_step'] = $step;
      }

}
if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="declaration" && $reg_id !=""){
$respondant_name = $_POST['respondant_name'];
$designation = $_POST['designation'];
$mobile = $_POST['mobile'];
$email_id = $_POST['email_id'];
$declaration_date = $_POST['declaration_date'];
$ca_firm_name = $_POST['ca_firm_name'];
$ca_name = $_POST['ca_name'];
$ca_designation = $_POST['ca_designation'];
$ca_mobile = $_POST['ca_mobile'];
$ca_email = $_POST['ca_email'];
$ca_declaration_date = $_POST['ca_declaration_date'];

$respondant_details = serialize(array("respondant_name"=>$respondant_name,"designation"=>$designation,"mobile"=>$mobile,"email_id"=>$email_id,"declaration_date"=>$declaration_date));
$ca_details =  serialize(array("ca_firm_name"=>$ca_firm_name,"ca_name"=>$ca_name,"ca_designation"=>$ca_designation,"ca_mobile"=>$ca_mobile,"ca_email"=>$ca_email,"ca_declaration_date"=>$ca_declaration_date));
// Checks if user sent an empty form
if(!empty($_FILES['attatchment']['name'])) {

    // Loop through each file in files[] array
    $file_tmpname = $_FILES['attatchment']['tmp_name'];
    $file_name = $_FILES['attatchment']['name'];
    $file_name = str_replace(" ","_",$file_name);
    $file_name = time().'_'.$file_name;
    $attatchment = $file_name;
    $file_size = $_FILES['attatchment']['size'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    // Set upload file path
    $filepath = $upload_dir.$file_name;
    // Check file type is allowed or not
    if(in_array(strtolower($file_ext), $allowed_types)) {
    // Verify file size - 2MB max
    if ($file_size > $maxsize){
        $signup_error="Error: File size is larger than the allowed limit.";
    }else{
        $filepath = $upload_dir.$file_name;
        move_uploaded_file($file_tmpname, $filepath);
        }
    }else {
    // If file extention not valid
    $signup_error= "Error uploading {$file_name} ";
    $signup_error= "({$file_ext} file type is not allowed)<br / >";
    }

}
  $sql_declaration = "UPDATE  igja_best_bank_financing_award SET respondant_details='$respondant_details',ca_details='$ca_details',created_at='$created_at',ca_certificate='$attatchment' WHERE id='$reg_id'";
$result = $conn->query($sql_declaration);
          $date = date("jS F Y ");

          $sql_info = "SELECT * FROM igja_best_bank_financing_award where id='$reg_id'";
          $result_info = $conn->query($sql_info);
          $row_info =  $result_info->fetch_assoc();
          $company_name =$row_info['bank_name'];
          $company_email_id =$row_info['email_id'];

         $html ='<table width="80%" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">

    <tbody>
    
    <tr>
      <td align="left"><img src="http://www.gjepc.org/images/gjepc_logo.png"></td>
    </tr>
        
    <tr>
      <td colspan="3" height="30"><hr></td>
    </tr>
        
    <tr>
        
        <td colspan="3" id="content">
            
            <table width="100%">

                                
                <tr>
                   
                    <td align="right"> <strong> '.$date.'</strong> </td>

                </tr>

            </table>

     

           <p style="line-height:22px;">Dear '.$company_name.',</p>

            <p style="line-height:22px;"> Your Application for Best Bank Financing the Industry has been  Submitted Successfully</p>
       

            
            <p style="line-height:22px;">Thanking you.</p>

            <p style="line-height:22px;">Yours faithfully,</p>

            <p style="line-height:22px;"><strong>Team GJEPC.</strong></p>
                  
        </td>
                  
    </tr>
      

        
        <tr>
            <td colspan="3" height="30"><hr></td>
        </tr>
        
        <tr>
            <td align="center" colspan="3">
            
                <img src="https://www.gjepc.org/images/gjepc_logo.png">
                
                <p style="line-height:22px;">
                    <b>The Gem &amp; Jewellery Export Promotion Council</b><br>Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400051 
 <br> Tel + 9122 43541800 Fax +9122 26524769  <br> Website: <a href="https://www.gjepc.org/" target="_blank">https://www.gjepc.org/ </a>
                </p>

                
                <table cellpadding="5">
                    <tr>
                        <td> <a href="https://www.facebook.com/GJEPC" target="_blank"> <img src="https://gjepc.org/download/icon/fb.png" /> </a> </td>
                        <td> <a href="https://twitter.com/GJEPCIndia" target="_blank"> <img src="https://gjepc.org/download/icon/tw.png" /> </a> </td>
                        <td> <a href="https://www.instagram.com/gjepcindia/" target="_blank"> <img src="https://gjepc.org/download/icon/insta.png" /> </a> </td>
                        <td> <a href="https://www.linkedin.com/in/sabyaray/" target="_blank"> <img src="https://gjepc.org/download/icon/li.png" /> </a> </td>
                    </tr>
                </table>
                
            </td>
        </tr>    
           
    </tbody>
    
</table>';

    $to = $company_email_id;
    $subject = "IGJA AWARDS REGISTRATION"; 
    $headers  = 'MIME-Version: 1.0' . "\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
    $headers .= 'From: GJEPC <admin@gjepc.org>';
    // $headers .= 'Cc: raksha@gjepcindia.com\r\n';     
    mail($to, $subject, $html, $headers);

$step = "bank_declaration";
$_SESSION['bank_step'] = $step;
   

}
?>


<section class="py-5">

    <div class="container">
    
    	<div class="mb-4">
    
            <div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div> Nomination Form - <span> Bank Financing the Industry</span>  </div>
                
            <p class="text-center"> <strong> Last date for submission is <span style="background:#a89c5d; color:#fff; padding:3px;">25th June,2022 </span> </strong> </p>		
        
        </div>
        
        <div class="row mb grid_gallery nomination_container">        
        	
            <div class="col-12 d-none d-lg-block" id="nav">
                
                <ul id="tabs" class="nav nav-tabs justify-content-center d-flex" role="tablist">
                                    
                    <li class="nav-item">
                        <a id="tab-A" href="#pane-A" class="nav-link <?php if( $_SESSION['bank_step'] ==""){ echo "active";}else{echo "disabled";}?> " data-toggle="tab" role="tab">General Information</a>
                    </li>                   
                
                    <li class="nav-item">
                        <a id="tab-B" href="#pane-B" class="nav-link <?php if($_SESSION['bank_step'] !="" && $_SESSION['bank_step'] =="bank_general_info"){
                            echo "active";}else{ echo "disabled";}?>" data-toggle="tab" role="tab">Declaration</a>
                    </li>
                    <?php if($_SESSION['bank_step'] !="" && $_SESSION['bank_step'] =="bank_declaration"){?>
                    <li class="nav-item">
                        <a id="tab-J" href="#pane-J" class="nav-link " data-toggle="tab" role="tab"></a>

                    </li>
                    <?php }?>
                     
                </ul>
            
            </div>

            <div id="content" class="col-12 tab-content" role="tablist">
                
                <div id="pane-A" class="card tab-pane fade <?php if($_SESSION['bank_step']==""){ echo "show active";}else{echo "hide";}?>" role="tabpanel" aria-labelledby="tab-A">
                
                    <div class="card-header" role="tab" id="heading-A">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">General Information</a>
                        </h5>
                    </div>

                    <div id="collapse-A" class="collapse show" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">
                        
                        <div class="card-body p-0">
                        
                            <form class="box-shadow" method="POST" name="general_info" id="general_info" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">
    
                                <div class="row">
                                
                                	<div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Key Instructions </strong></p> </div>								
                                    
                                    <div class="form-group col-12">
                                    
                                    	<ul class="inner_under_listing">
                                        	<li>These award categories recognise banks for their support to the gems & jewellery sector by way of export financing.</li>							
                                            
                                            <li>The nomination form has been designed to capture data pertaining to the quantum of lending made by banks to the gems & jewellery sector. However, please note that this does not include non-funded credit facilities.</li>

<li>The year to be considered for awards is the financial year of 2018-19, 2019-20 and 2020-21, i.e. from 1st April 2018 to 31st March 2019 and from 1st April 2020 to 31st March, 2021.</li>

<li>Nominations are open for all types of banks - Scheduled Commercial Banks, Urban cooperative Banks, Regional Rural Banks, Co-operative Banks, etc.</li>

<li>The nomination form should be signed and stamped by an authorised signatory of the bank.</li>

<li>The details furnished in the nomination form should also be certified by a Chartered Accountant by filling out the Chartered Accountant Declaration in the nomination form. Nomination forms with incomplete C.A. declaration details will not be considered for the awards.</li>

<li>Financial details will be kept confidential and used only for computation purpose</li>

                                        </ul>
                                        
                                    </div>
                                    <div class="form-group col-12">
                                    <?php  if(isset($signup_error)){ echo "<div class='alert alert-danger' role='alert'>".$signup_error.'</div>';} ?>
                                 </div>
                                
                                    <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Basic Information</strong></p> </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Bank Name*</label>
                                        <input type="text" class="form-control" name="bank_name"> 
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Year of Establishment*</label>
                                         <select name="year" class="form-control">
                                            <option value="">Select</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                            <option value="2012">2012</option>
                                            <option value="2011">2011</option>
                                            <option value="2010">2010</option>
                                            <option value="2009">2009</option>
                                            <option value="2008">2008</option>
                                            <option value="2007">2007</option>
                                            <option value="2006">2006</option>
                                            <option value="2005">2005</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                            <option value="1999">1999</option>
                                            <option value="1998">1998</option>
                                            <option value="1997">1997</option>
                                            <option value="1996">1996</option>
                                            <option value="1995">1995</option>
                                            <option value="1994">1994</option>
                                            <option value="1993">1993</option>
                                            <option value="1992">1992</option>
                                            <option value="1991">1991</option>
                                            <option value="1990">1990</option>
                                            <option value="1989">1989</option>
                                            <option value="1988">1988</option>
                                            <option value="1987">1987</option>
                                            <option value="1986">1986</option>
                                            <option value="1985">1985</option>
                                            <option value="1984">1984</option>
                                            <option value="1983">1983</option>
                                            <option value="1982">1982</option>
                                            <option value="1981">1981</option>
                                            <option value="1980">1980</option>
                                            <option value="1979">1979</option>
                                            <option value="1978">1978</option>
                                            <option value="1977">1977</option>
                                            <option value="1976">1976</option>
                                            <option value="1975">1975</option>
                                            <option value="1974">1974</option>
                                            <option value="1973">1973</option>
                                            <option value="1972">1972</option>
                                            <option value="1971">1971</option>
                                            <option value="1970">1970</option>
                                            <option value="1969">1969</option>
                                            <option value="1968">1968</option>
                                            <option value="1967">1967</option>
                                            <option value="1966">1966</option>
                                            <option value="1965">1965</option>
                                            <option value="1964">1964</option>
                                            <option value="1963">1963</option>
                                            <option value="1962">1962</option>
                                            <option value="1961">1961</option>
                                            <option value="1960">1960</option>
                                            <option value="1959">1959</option>
                                            <option value="1958">1958</option>
                                            <option value="1957">1957</option>
                                            <option value="1956">1956</option>
                                            <option value="1955">1955</option>
                                            <option value="1954">1954</option>
                                            <option value="1953">1953</option>
                                            <option value="1952">1952</option>
                                            <option value="1951">1951</option>
                                            <option value="1950">1950</option>
                                            <option value="1949">1949</option>
                                            <option value="1948">1948</option>
                                            <option value="1947">1947</option>
                                            <option value="1946">1946</option>
                                            <option value="1945">1945</option>
                                            <option value="1944">1944</option>
                                            <option value="1943">1943</option>
                                            <option value="1942">1942</option>
                                            <option value="1941">1941</option>
                                            <option value="1940">1940</option>
                                            <option value="1938">1938</option>
                                            <option value="1937">1937</option>
                                            <option value="1936">1936</option>
                                            <option value="1935">1935</option>
                                            <option value="1934">1934</option>
                                            <option value="1933">1933</option>
                                            <option value="1932">1932</option>
                                            <option value="1931">1931</option>
                                            <option value="1930">1930</option>
                                            <option value="1929">1929</option>
                                            <option value="1928">1928</option>
                                            <option value="1927">1927</option>
                                            <option value="1926">1926</option>
                                            <option value="1925">1925</option>
                                            <option value="1924">1924</option>
                                            <option value="1923">1923</option>
                                            <option value="1922">1922</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4">
                                        <label>Fax</label>
                                        <input type="text" class="form-control" name="fax_no"  value="<?php echo $fax_no;?>"> 
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4">
                                        <label>Telephone No *</label>
                                       <input type="text" name="tel_no" id="tel_no" value="<?php echo $tel_no;?>"  class="form-control numeric">
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Email ID *</label>
                                        <input type="text" class="form-control" name="email_id"  value="<?php echo $email_id;?>"> 
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Website</label>
                                        <input type="text" class="form-control" name="website"  value="<?php echo $website;?>">
                                    </div>
                                    
                                    <div class="form-group col-sm-6"> 
                                        <label>Address *</label>
                                        <textarea class="form-control" name="address_line_1" > <?php echo $address_line_1;?></textarea>
                                    </div>
                                    
                                    <div class="form-group col-sm-6"> 
                                        <label>Address Line 2 (optional) </label>
                                        <textarea class="form-control" name="address_line_2"><?php echo $address_line_2;?></textarea>
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>City *</label>
                                        <input type="text" class="form-control" name="city" value="<?php echo $city;?>"> 
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>State *</label>
                                        <select name="state" id="state" class="form-control">
                                            <option value="0">Select</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                            <option value="Daman and Diu">Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Zipcode *</label>
                                        <input type="text" class="form-control" name="zipcode" value="<?php echo $zipcode;?>"> 
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    <div class="form-group col-12">
                                        <label for="company_name"><strong>Ownership Pattern *</strong></label>
                                        <div class="mt-2">
                                            <label for="company_type" generated="true" style="display: none;" class="error">Please Select Company type</label>
                                            <label for="Propritory" class="mr-3">
                                            <input type="radio" id="bank_type1" name="bank_type" value="Public Bank " class="mr-2">Public Bank 
                                            </label>
                                            <label for="Partnership" class="mr-3">
                                            <input type="radio" id="bank_type1" name="bank_type" value="Private Bank" class="mr-2">Private Bank
                                            </label>
                                            <label for="Private" class="mr-3">
                                            <input type="radio" id="bank_type1" name="bank_type" value="Foreign Bank" class="mr-2">Foreign Bank 
                                            </label>                          
                                            <label for="Public">
                                            <input type="radio" id="bank_type1" name="bank_type" value="Cooperative Bank" class="mr-2">Cooperative Bank
                                            </label>
                                        </div>
                                        <label for="bank_type" generated="true" class="error d-none">Please Select Bank Type</label>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Senior Management</strong></p> </div>
                                    
                                      <div class="col-12">
                                        <div class="row">
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Title *</label>
                                        <select class="form-control" name="sm_title[0]">
                                            <option value="">Select Title</option>
                                            <option <?php if($_POST['sm_title'][0] =="Mr"){ echo "selected";}?>  value="Mr">Mr</option>
                                            <option <?php if($_POST['sm_title'][0] =="Ms"){ echo "selected";}?> value="Ms">Ms</option>
                                            <option <?php if($_POST['sm_title'][0] =="Mrs"){ echo "selected";}?> value="Mrs">Mrs</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Name *</label>
                                        <input type="text" name="sm_name[0]" id="sm_name" value="<?php echo $_POST['sm_name'][0];?>" class="form-control"> 
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Designation *</label>
                                        <input type="text" name="sm_designation[0]" id="m_designation" value="<?php echo $_POST['sm_designation'][0];?>" class="form-control"> 
                                    </div>
                                    
                                   
                                        </div>
                                    </div>
                                     <div class="col-12">
                                        <div class="row">
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Title </label>
                                        <select class="form-control" name="sm_title[]">
                                            <option value="">Select Title</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Mrs">Mrs</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Name </label>
                                        <input type="text" name="sm_name[]" id="sm_name" class="form-control"> 
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Designation </label>
                                        <input type="text" name="sm_designation[]" id="m_designation" class="form-control"> 
                                    </div>
                                    
                                   
                                        </div>
                                    </div>
                                     <div class="col-12">
                                        <div class="row">
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Title</label>
                                        <select class="form-control" name="sm_title[]">
                                            <option value="">Select Title</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Mrs">Mrs</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Name</label>
                                        <input type="text" name="sm_name[]" id="sm_name" class="form-control"> 
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                        <label>Designation</label>
                                        <input type="text" name="sm_designation[]" id="m_designation" class="form-control"> 
                                    </div>
                                    
                                   
                                        </div>
                                    </div>
                                    
            
                                    <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong> Financial Details *</strong></p> </div> 
                                    
                                    <div class="form-group col-12"> 
                                        
                                        <table class="responsive_table category_table">
                                            <thead>
                                                <tr>
                                                    <th>Particular</th>
                                                    <th>FY21</th>
                                                    <th>FY20</th>
                                                    <th>FY19</th>
                                                </tr>
                                            </thead>
                           
                                            <tbody>
                                                <tr>
                                                    <td data-column="Particular">Total Income (Interest Income + Other Income) (Rs Crore) <input type="hidden" class="form-control" name="fin_details[0]" value="Total Income (Interest Income + Other Income) (Rs Crore)"></td>
                                                    <td data-column="FY21"><input type="text" class="form-control" name="fin_details_FY20[0]"></td>
                                                    <td data-column="FY20"><input type="text" class="form-control"  name="fin_details_FY19[0]"></td>
                                                    <td data-column="FY19"><input type="text" class="form-control"  name="fin_details_FY18[0]"></td>
                                                </tr>
                                                <tr>
                                                    <td data-column="Particular">Total lending to Gems and Jewellery Sector (Rs Crore) <input type="hidden" class="form-control " name="fin_details[1]" value="Total lending to Gems and Jewellery Sector (Rs Crore)"></td>
                                                    <td data-column="FY21"><input type="text" class="form-control" name="fin_details_FY20[1]"></td>
                                                    <td data-column="FY20"><input type="text" class="form-control"  name="fin_details_FY19[1]"></td>
                                                    <td data-column="FY19"><input type="text" class="form-control"  name="fin_details_FY18[1]"></td>
                                                </tr>
                                                <tr>
                                                    <td data-column="Particular">Total Export Finance sanctioned (Rs Crore) <input type="hidden" class="form-control " name="fin_details[2]" value="Total Export Finance sanctioned (Rs Crore) "></td>
                                                    <td data-column="FY21"><input type="text" class="form-control" name="fin_details_FY20[2]"></td>
                                                    <td data-column="FY20"><input type="text" class="form-control"  name="fin_details_FY19[2]"></td>
                                                    <td data-column="FY19"><input type="text" class="form-control"  name="fin_details_FY18[2]"></td>
                                                </tr>
                                                 
                                                 <tr>
                                                    <td data-column="Particular">Export finance sanctioned for Gems & Jewellery Sector (Rs Crore)<input type="hidden" class="form-control " name="fin_details[3]" value="Export finance sanctioned for Gems & Jewellery Sector (Rs Crore) "></td>
                                                    <td data-column="FY21"><input type="text" class="form-control" name="fin_details_FY20[3]"></td>
                                                    <td data-column="FY20"><input type="text" class="form-control"  name="fin_details_FY19[3]"></td>
                                                    <td data-column="FY19"><input type="text" class="form-control"  name="fin_details_FY18[3]"></td>
                                                </tr>
                                                
                                                 <!-- <tr>
                                                    <td>Export finance sanctioned to MSME Companies in Gems & Jewellery Sector (Rs Crore)<input type="hidden" class="form-control " name="fin_details[4]" value="Export finance sanctioned to MSME Companies in Gems & Jewellery Sector (Rs Crore) "></td>
                                                    <td><input type="text" class="form-control" name="fin_details_FY20[4]"></td>
                                                    <td><input type="text" class="form-control"  name="fin_details_FY19[4]"></td>
                                                    <td><input type="text" class="form-control"  name="fin_details_FY18[4]"></td>
                                                </tr> -->

                                                <tr>
                                                    <td data-column="Particular">Total loans outstanding in Gems and Jewellery Sector (Rs Crore)<input type="hidden" class="form-control " name="fin_details[4]" value="Total loans outstanding in Gems and Jewellery Sector (Rs Crore)"></td>
                                                    <td data-column="FY21"><input type="text" class="form-control" name="fin_details_FY20[4]"></td>
                                                    <td data-column="FY20"><input type="text" class="form-control"  name="fin_details_FY19[4]"></td>
                                                    <td data-column="FY19"><input type="text" class="form-control"  name="fin_details_FY18[4]"></td>
                                                </tr>
                                                
                                                
                                               <!--  <tr>
                                                    <td>Total loans outstanding to MSMEs in Gems and Jewellery Sector (Rs Crore)<input type="hidden" class="form-control " name="fin_details[6]" value="Total loans outstanding to MSMEs in Gems and Jewellery Sector (Rs Crore)"></td>
                                                     <td><input type="text" class="form-control" name="fin_details_FY20[6]"></td>
                                                    <td><input type="text" class="form-control"  name="fin_details_FY19[6]"></td>
                                                    <td><input type="text" class="form-control"  name="fin_details_FY18[6]"></td>
                                                </tr>
                                                -->
                                                <tr>
                                                    <td data-column="Particular">Total number of exporters from Gems & Jewellery sector financed <input type="hidden" class="form-control " name="fin_details[5]" value="Total number of exporters from Gems & Jewellery sector financed"></td>
                                                    <td data-column="FY21"><input type="text" class="form-control" name="fin_details_FY20[5]"></td>
                                                    <td data-column="FY20"><input type="text" class="form-control"  name="fin_details_FY19[5]"></td>
                                                    <td data-column="FY19"><input type="text" class="form-control"  name="fin_details_FY18[5]"></td>
                                                </tr>
                                                <!--  <tr>
                                                    <td>Total number of Gems & Jewellery clients financed <input type="hidden" class="form-control " name="fin_details[7]" value="Total number of Gems & Jewellery clients financed"></td>
                                                     <td><input type="text" class="form-control" name="fin_details_FY20[7]"></td>
                                                    <td><input type="text" class="form-control"  name="fin_details_FY19[7]"></td>
                                                    <td><input type="text" class="form-control"  name="fin_details_FY18[7]"></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Total number of MSME Gems & Jewellery clients financed  <input type="hidden" class="form-control " name="fin_details[9]" value="Total number of MSME Gems & Jewellery clients financed"></td>
                                                  <td><input type="text" class="form-control" name="fin_details_FY20[9]"></td>
                                                    <td><input type="text" class="form-control"  name="fin_details_FY19[9]"></td>
                                                    <td><input type="text" class="form-control"  name="fin_details_FY18[9]"></td>
                                                </tr> -->
                                                
                                                <tr>
                                                    <td data-column="Particular">Total NPAs (Rs Crore) <input type="hidden" class="form-control " name="fin_details[6]" value="Total NPAs (Rs Crore)"></td>
                                                    <td data-column="FY21"><input type="text" class="form-control" name="fin_details_FY20[6]"></td>
                                                    <td data-column="FY20"><input type="text" class="form-control"  name="fin_details_FY19[6]"></td>
                                                    <td data-column="FY19"><input type="text" class="form-control"  name="fin_details_FY18[6]"></td>
                                                </tr>
                                                
                                                
                                                
                                                 
                                                

                                            </tbody>
                                        
                                        </table>
                                      
                                    </div>
                                      <div class="form-group col-12"> 
                                        <label>Note: For year ending period other than April to March, please mention the year end period  </label>
                                        <div class="row">
                                          <div class="col-md-6">                                        <input type="text" name="end_year" id="end_year" class="form-control  numeric"> 
</div>
                                        </div>

                                    
                                </div> 

                                <div class="form-group col-12"> 
                                        <label>Upload List of Clients/ Exporters sanctioned export finance by the bank (including sanctioned amount) along with the proof (last three FY)</label>
                                        <div class="row">
                                          <div class="col-md-6">
                                          <input type="file" name="attatchment[]" id="" class="form-control"> 

                                          </div>
                                        </div>
                                        <label class="d-block">(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label>

                                    
                                </div> 

                                <div class="form-group col-12"> 
                                    <input type="hidden" name="action" value="general_info">
                                   <input type="submit" name="submit" value="Next" class="btnNext gold_btn d-table" >
                               </div>
          
    						</form>
                        
                        </div>
                        
                    </div>
                    
                
                </div>
            </div>

                
                <div id="pane-B" class="card tab-pane fade <?php if($_SESSION['bank_step'] !="" && $_SESSION['bank_step'] =="bank_general_info"){
                            echo "show active";}else{ echo "hide";}?>" role="tabpanel" aria-labelledby="tab-B">
                    
                    <div class="card-header" role="tab" id="heading-B">
                        <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
                                Declaration 
                            </a>
                        </h5>
                    </div>
                    
                    <div id="collapse-B" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
                        
                        <div class="card-body p-0">
                            
                            <form class="box-shadow" name="declaration" id="declaration"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">
                          		
                                <div class="row">
                                
                                	<div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Declaration * </strong></p> </div>
                                	
                               		<div class="form-group col-12"> <p>This is to certify that the above information is true and correct to the best of my knowledge</p> </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                      <label for="">Name of the Respondent</label>
                                      <input type="text"   name="respondant_name" class="form-control">  
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                    <label for="">Designation</label>

                                      <input type="text" class="form-control" name="designation">  
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                    <label for="">Mobile</label>

                                      <input type="text"  name="mobile" maxlength="10" class="form-control numeric">  
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4">
                                    <label for="">Email Id</label>

                                       <input type="text"  name="email_id" class="form-control"> 
                                       </div>
                                    
                                    
                                    <!-- <div class="form-group col-sm-6 col-lg-4">
                                       <input type="" placeholder="Date" class="form-control position-relative" id="declaration_date" name="declaration_date" > 
                                        </div> -->
                                    
                                    <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Chartered Accountant Declaration </strong></p> </div>
                                     
                                      <div class="form-group col-sm-6 col-lg-4"> 
                                      <label for="">Name of the CA Firm</label>

                                        <input type="text" name="ca_firm_name" class="form-control">  
                                      </div> 
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                    <label for="">Name of the individual</label>

                                      <input type="text"  name="ca_name" class="form-control">  
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-lg-4"> 
                                    <label for="">Designation</label>

                                      <input type="text" name="ca_designation" class="form-control"> 
                                     </div> 
                                    
                                    <div class="form-group col-sm-6 col-lg-4">
                                    <label for="">Mobile</label>

                                       <input type="text"  maxlength="10" name="ca_mobile" class="form-control numeric"> 
                                       </div> 
                                    
                                    <div class="form-group col-sm-6 col-lg-4">
                                    <label for="">Email</label>

                                       <input type="text"  name="ca_email" class="form-control"> 
                                       </div>   
                                    <!-- <div class="form-group col-sm-6 col-lg-4">
                                    <label for="">Name of the Respondent</label>

                                       <input type="" placeholder="Date" class="form-control position-relative" id="ca_date" name="ca_declaration_date"> 
                                       </div>  -->

                                   
                                     <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Please upload CA Certification here.</strong></p> </div>
                                      <div class="form-group col-sm-6"> <input type="file"  class="form-control"  name="attatchment"> (upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)  </div> 
                                    <div class=" col-12"> 
                                         <input type="hidden" name="action" value="declaration">
                                         <button class="gold_btn mb-0" type="submit"> Submit </button>  </div> 
                                      
                                     
                                </div>	
                        	
                            </form>
                            
                        </div>
                    
                    </div>
                
                </div>

                 <?php if($_SESSION['bank_step'] !="" && $_SESSION['bank_step'] =="bank_declaration"){?>
                      <div id="pane-J" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-J">
                    
                    <div class="card-header" role="tab" id="heading-J">
                        <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse-J" aria-expanded="false" aria-controls="collapse-J">
                                Declaration 
                            </a>
                        </h5>
                    </div>
                    <?php 
                        $reg_id = $_SESSION['reg_id'];
                        $query = "UPDATE igja_best_bank_financing_award SET STATUS = 'Y' WHERE id= $reg_id";
                        $result = $conn->query($query);
                    ?>
                    <div id="collapse-J" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-J">
                        
                        <div class="card-body p-0">
                            
                            <div class=" row box-shadow py-5">
                                <div class="col-12 text-center">
                                    <p class=" text-center text-success">Your application for Nomination Awards has been  submitted successfully</p>
                                    <!-- <a href="https://gjepc.org/igja-form1.php?form-reset=yes" class="d-inline-block  btnNext gold_btn">Back</a> -->
                                </div>
                                
                            </div>
                            
                        </div>
                    
                    </div>
                
                </div>
                 <?php } ?>
                
            
            </div>
            
		</div>	
        
    </div>
	
</section>

<?php include('include-new/footer.php');?>

<script>
$(document).ready(function () { 

	$("#declaration_date").datepicker({              
	format: "dd-mm-yyyy"
	});
	
	$("#ca_date").datepicker({              
	format: "dd-mm-yyyy"
	});
						
});    
</script>

<script src="jsvalidation/jquery.validate.js?v=1.1" type="text/javascript"></script> 

<script type="text/javascript">
  $(document).ready(function(){
jQuery.validator.addMethod("specialChrs", function (value, element) {
  if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
    };
    },  "Special Characters Not Allowed");
jQuery.validator.addMethod("Chrs", function (value, element) {
  if (/[^a-zA-Z\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
    };
    },  "Only Letters are Allowed");
jQuery.validator.addMethod("mobno", function (value, element) {
  var regExp = /^[6-9]\d{9}$/; 
  if (value.match(regExp) ) {
    return true;
  } else {
    return false;
  };
  },"Please Enter valid Mobile No");

      $("#general_info").validate({

    rules: {  

      bank_name:{
       required: true,
      
      },
      // year:{
      //  required: true,
      // },
      tel_no:{
       required: true,
      },
      fax_no:{
       required: true,
      },
      email_id: {
        required: true,
        email:true
      },
      website:{
       required: true,
      },
      address_line_1:{
       required: true,
      },
      city:{
       required: true,
       Chrs: true
      },
      state:{
       required: true,
       Chrs: true
      },
      zipcode:{
       required: true,
       number:true,
      },
      bank_type:{
       required: true,
      },
      "sm_name[0]":{
       required: true,
      },
      "sm_designation[0]":{
       required: true,
      },
      "sm_title[0]":{
       required: true,
      },
      "fin_details[0]":{
        required:true,
      },
      "fin_details_FY20[0]":{
        required:true,
      },
      "fin_details_FY19[0]":{
        required:true,
      },
      "fin_details_FY18[0]":{
        required:true,
      },
      "fin_details[1]":{
        required:true,
      },
      "fin_details_FY20[1]":{
        required:true,
      },
      "fin_details_FY19[1]":{
        required:true,
      },
      "fin_details_FY18[1]":{
        required:true,
      },
      "fin_details[2]":{
        required:true,
      },
      "fin_details_FY20[2]":{
        required:true,
      },
      "fin_details_FY19[2]":{
        required:true,
      },
      "fin_details_FY18[2]":{
        required:true,
      },
      "fin_details[3]":{
        required:true,
      },
      "fin_details_FY20[3]":{
        required:true,
      },
      "fin_details_FY19[3]":{
        required:true,
      },
      "fin_details_FY18[3]":{
        required:true,
      },
      "fin_details[4]":{
        required:true,
      },
      "fin_details_FY20[4]":{
        required:true,
      },
      "fin_details_FY19[4]":{
        required:true,
      },
      "fin_details_FY18[4]":{
        required:true,
      },
      "fin_details[5]":{
        required:true,
      },
      "fin_details_FY20[5]":{
        required:true,
      },
      "fin_details_FY19[5]":{
        required:true,
      },
      "fin_details_FY18[5]":{
        required:true,
      },
      "fin_details[6]":{
        required:true,
      },
      "fin_details_FY20[6]":{
        required:true,
      },
      "fin_details_FY19[6]":{
        required:true,
      },
      "fin_details_FY18[6]":{
        required:true,
      },
      "fin_details[7]":{
        required:true,
      },
      // "fin_details_FY20[7]":{
      //   required:true,
      // },
      // "fin_details_FY19[7]":{
      //   required:true,
      // },
      // "fin_details_FY18[7]":{
      //   required:true,
      // },
      // "fin_details[8]":{
      //   required:true,
      // },
      // "fin_details_FY20[8]":{
      //   required:true,
      // },
      // "fin_details_FY19[8]":{
      //   required:true,
      // },
      // "fin_details_FY18[8]":{
      //   required:true,
      // },
      // "fin_details[9]":{
      //   required:true,
      // },
      // "fin_details_FY20[9]":{
      //   required:true,
      // },
      // "fin_details_FY19[9]":{
      //   required:true,
      // },
      // "fin_details_FY18[9]":{
      //   required:true,
      // },
      // "fin_details[10]":{
      //   required:true,
      // },
      // "fin_details_FY20[10]":{
      //   required:true,
      // },
      // "fin_details_FY19[10]":{
      //   required:true,
      // },
      // "fin_details_FY18[10]":{
      //   required:true,
      // },
      // "fin_details[11]":{
      //   required:true,
      // },
      // "fin_details_FY20[11]":{
      //   required:true,
      // },
      // "fin_details_FY19[11]":{
      //   required:true,
      // },
      // "fin_details_FY18[11]":{
      //   required:true,
      // },
      // "fin_details_FY20[12]":{
      //   required:true,
      // },
      // "fin_details_FY19[12]":{
      //   required:true,
      // },
      // "fin_details_FY18[12]":{
      //   required:true,
      // },

     
    }, 
    messages: {
      
      bank_name: {
      required: "Bank name is Required",
      },
      year: {
      required: "Company Establishment year is required",
      },
      tel_no: {
      required: "Telephone Number  is Required",
      },
      fax_no: {
      required: "Fax Number  is Required",
      },
      email_id: {
        required: "Email id is Required",
        email: "Please Enter a valid Email id",
      },
      website: {
        required: "Website  is Required",
      },
       address_line_1: {
      required: "Address1 name is Required",
      },  
      city: {
      required: "City name is Required",
      },
      state: {
      required: "Choose from the list",
      },
      zipcode: {
      required: "Zip code  is Required",
      },
      bank_type: {
      required: "Please Select Bank Type",
      },
      sr_name: {
      required: "Please Select Nature of business ",
      },
      "sm_name[0]": {
      required: "Name is Required",
      },
      "sm_designation[0]": {
      required: "Designation is Required",
      },
      "sm_title[0]": {
      required: "Select Title ",
      },
      "fin_details[0]": {
      required: "Required ",
      },
      "fin_details_FY20[0]":{
        required:"Required",
      },
      "fin_details_FY19[0]":{
        required:"Required",
      },
      "fin_details_FY18[0]":{
        required:"Required",
      },
      "fin_details[1]": {
      required: "Required ",
      },
      "fin_details_FY20[1]":{
        required:"Required",
      },
      "fin_details_FY19[1]":{
        required:"Required",
      },
      "fin_details_FY18[1]":{
        required:"Required",
      },
      "fin_details[2]": {
      required: "Required ",
      },
      "fin_details_FY20[2]":{
        required:"Required",
      },
      "fin_details_FY19[2]":{
        required:"Required",
      },
      "fin_details_FY18[2]":{
        required:"Required",
      },
      "fin_details[3]": {
      required: "Required ",
      },
      "fin_details_FY20[3]":{
        required:"Required",
      },
      "fin_details_FY19[3]":{
        required:"Required",
      },
      "fin_details_FY18[3]":{
        required:"Required",
      },
      "fin_details[4]": {
      required: "Required ",
      },
      "fin_details_FY20[4]":{
        required:"Required",
      },
      "fin_details_FY19[4]":{
        required:"Required",
      },
      "fin_details_FY18[4]":{
        required:"Required",
      },
      "fin_details[5]": {
      required: "Required ",
      },
      "fin_details_FY20[5]":{
        required:"Required",
      },
      "fin_details_FY19[5]":{
        required:"Required",
      },
      "fin_details_FY18[5]":{
        required:"Required",
      },
      "fin_details[6]": {
      required: "Required ",
      },
      "fin_details_FY20[6]":{
        required:"Required",
      },
      "fin_details_FY19[6]":{
        required:"Required",
      },
      "fin_details_FY18[6]":{
        required:"Required",
      },
      "fin_details[7]": {
      required: "Required ",
      },
      // "fin_details_FY20[7]":{
      //   required:"Required",
      // },
      // "fin_details_FY19[7]":{
      //   required:"Required",
      // },
      // "fin_details_FY18[7]":{
      //   required:"Required",
      // },
      // "fin_details[8]": {
      // required: "Required ",
      // },
      // "fin_details_FY20[8]":{
      //   required:"Required",
      // },
      // "fin_details_FY19[8]":{
      //   required:"Required",
      // },
      // "fin_details_FY18[8]":{
      //   required:"Required",
      // },
      // "fin_details[9]": {
      // required: "Required ",
      // },
      // "fin_details_FY20[9]":{
      //   required:"Required",
      // },
      // "fin_details_FY19[9]":{
      //   required:"Required",
      // },
      // "fin_details_FY18[9]":{
      //   required:"Required",
      // },
      // "fin_details[10]": {
      // required: "Required ",
      // },
      // "fin_details_FY20[10]":{
      //   required:"Required",
      // },
      // "fin_details_FY19[10]":{
      //   required:"Required",
      // },
      // "fin_details_FY18[10]":{
      //   required:"Required",
      // },
      // "fin_details[11]": {
      // required: "Required ",
      // },
      // "fin_details_FY20[11]":{
      //   required:"Required",
      // },
      // "fin_details_FY19[11]":{
      //   required:"Required",
      // },
      // "fin_details_FY18[11]":{
      //   required:"Required",
      // },
      // "fin_details_FY20[12]":{
      //   required:"Required",
      // },
      // "fin_details_FY19[12]":{
      //   required:"Required",
      // },
      // "fin_details_FY18[12]":{
      //   required:"Required",
      // },
      
     
     
    
      
      
   }
  });
$("#declaration").validate({

    rules: {  

      respondant_name:{
       required: true,
      },
      designation:{
       required: true,
      },
      mobile:{
       required: true,
       
      },
      email_id:{
       required: true,
       email:true
      },
       declaration_date:{
       required: true,
      },
      ca_firm_name:{
       required: true,
      },
      ca_name:{
       required: true,
      },
      ca_designation:{
       required: true,
      },
      ca_mobile:{
        required: true,
      },
      ca_email:{
        required: true,
        email:true
      },
       ca_declaration_date:{
       required: true,
      },
     
    }, 
    messages: {
       respondant_name:{
       required:'Enter Respondant name'
      },
      designation:{
       required: 'Enter Designation',
      },
      mobile:{
       required: 'Enter Mobile No',
      },
      email_id:{
       required: 'Enter Email ID',
      },
      declaration_date:{
       required: 'Enter Declaration Date',
      },
      ca_firm_name:{
       required: 'Enter CA Firm Name',
      },
      ca_name:{
       required: "Enter Individual Name",
      },
      ca_designation:{
       required: "Enter Designation ",
      },
      ca_mobile:{
        required: "Enter Mobile Number",
      },
      ca_email:{
        required: "Enter Email Id",
      },
      ca_declaration_date:{
       required: 'Enter Declaration Date',
      },
      
      

   }
  });
$('.numeric').keypress(function (event) {
var keycode = event.which;
if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
event.preventDefault();
}
});
});
</script>

<style>
    select {
    -webkit-appearance: auto; 
}
    .card-body .row {border: 0; padding: 0; margin-bottom: 0;}
    .award_input_box label input {left: 0;}
    .award_input_box label {padding-left: 30px;}
    .responsive_table tr{background: #f1f1f1!important;}

   .addBtn {    font-weight: 600;
    color: #a59459;
    margin-top: 10px;}
</style>