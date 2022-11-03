<?php 
$pageTitle = "Gem & Jewellery | Tenders - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header_vendor.php';
include 'db.inc.php';?>

<section class="py-5">

	<div class="container inner_container">	
		<div class="row justify-content-center" id="tender">

			<div class="col-12 text-center">
          <h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
          Tenders</h1>
      </div>

	     	<div class="col-12">

					<div class="row mb-5">
						<div class="col-sm-6 mb-2 mb-sm-0">
							<a href="pdf/HELP-DOCUMENT-vendor.pdf" class="cta w-100 h-100 text-center d-block" target="_blank"> Help Document for Online Vendor Registration & EOI Process</a>
						</div>
						<div class="col-sm-6">
							<a href="vendor_login.php" class="cta w-100 h-100 text-center d-block"> Vendor-Registration/ Login  For EOI 2022-2024</a>
						</div>
					</div>

					<ul class="circular_wrap row">
						<?php
						$sql="SELECT * FROM `tender_master` WHERE status='1' order by id desc";
						$result=$conn ->query($sql);
						while($rows=$result->fetch_assoc())
						{ 
						$getID = filter($rows['id']);
						?>
						<li class="col-12">
						<a data-toggle="modal" class="new_pdf_wrp" onclick="$('#pdf_id').val(($(this).attr('tenderid')));" tenderid="<?php echo $getID;?>" href="#modal-id" />
						<div class="circular_text"><?php echo $rows[name];?></div></a><?php if($getID==129){?><a href="admin/Tender/GJEPC SON V6_0.xlsx">GJEPC Statement of Need(SON)</a><?php }?>
						</li>
            <?php } ?>
					</ul>

				</div>

		    <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>				
                    </div>
                    <div class="modal-body">
                        
		                <form action="tender.inc.php" method="post" enctype="multipart/form-data" class="form-block minibuffer" onSubmit="return loginvalidate()">
		                <?php token(); ?>
                      <div class="form-group">
                        <label class="form-label" for="company_name">Company Name :</label>
                        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="" autocomplete="off"> 
                      </div>

                      <div class="form-group">
                        <label class="form-label" for="name"> Name :</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="" autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label class="form-label" for="email"> Email :</label>
                        <input type="text" class="form-control" name="email" id="email" autocomplete="off" placeholder="">
                      </div>

                      <div class="form-group">
                        <label class="form-label" for="mobile"> Mobile No :</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" autocomplete="off" maxlength="10" placeholder="">
                      </div>

                      <div class="form-group">
                          <label class="form-label" for="address">Address :</label>
                          <textarea class="form-control" name="address" id="address" style="height:70px"></textarea>
                      </div>

                      <div class="modal-footer justify-content-center border-0">
                        <input type="submit" class="cta" value="Submit" style="width:150px" />
                        <input type="hidden" id="pdf_id" name="pdf_id"/>
                  		</div>
		                </form>
                    
                </div>
                </div>
            </div>
        </div>



	   
		</div>
	</div>
</section>

<?php include 'include-new/footer.php'; ?>

<script language="javascript">
function loginvalidate()
{
	var company_name = document.getElementById("company_name").value;
	var name = document.getElementById("name").value;
	var email = document.getElementById("email").value;
	var mobile = document.getElementById("mobile").value;
	var address = document.getElementById("address").value;
	if(company_name=='')
	{
		alert("Please Enter Company Name");
		$("#company_name").focus();
		return false;
	}		
	if(name=="")
	{
		alert("Please Enter Name");
		$("#name").focus();
		return false;
	}	
	if(email=="")
	{
		alert("Please Enter Email");
		$("email").focus();
		return false;
	}	
	if(echeck(document.getElementById('email').value)==false)
	{
		document.getElementById('email').focus();
		return false;
	}
	
	if(mobile=="")
	{
		alert("Please Enter Mobile No");
		$("mobile").focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('mobile').value))
	{
		alert("Please enter valid Mobile No.")
		document.getElementById('mobile').focus();
		return false;
	}	
	if(document.getElementById('mobile').value.length < 10)
	{
		alert("Please enter 10 digit Mobile No.");
		document.getElementById('mobile').focus();
		return false;
	}	
	if(address=="")
	{
		alert("Please Enter Address");
		$("address").focus();
		return false;
	}
	$('#modal-id').modal('toggle');	
}

function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID")
		return false
	}
	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 return true					
}

function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   //if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}

function alphanumeric(strString)
{
   var strValidChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz0123456789_,";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}


</script>