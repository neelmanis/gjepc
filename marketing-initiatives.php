<?php 
$pageTitle = "Gem & Jewellery | Marketing Initiatives - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php
include 'include/header.php';
include 'db.inc.php';
//echo "<pre>"; print_r($_POST);
?>

<?php
$action=$_REQUEST['action'];
if($action=="save")
{
    $company=mysql_real_escape_string(strip_tags(addslashes($_REQUEST['company'])));
	$contact_person1=mysql_real_escape_string(strip_tags(addslashes($_REQUEST['contact_person1'])));
	$number1=mysql_real_escape_string(strip_tags($_REQUEST['number1']));
    $mobile1=mysql_real_escape_string(strip_tags($_REQUEST['mobile1']));
	$email1=$_REQUEST['email1'];
	$contact_person2=mysql_real_escape_string(strip_tags(addslashes($_REQUEST['contact_person2'])));
	$number2=mysql_real_escape_string(strip_tags($_REQUEST['number2']));
    $mobile2=mysql_real_escape_string(strip_tags($_REQUEST['mobile2']));
	$email2=$_REQUEST['email2'];
	
		$sql="INSERT INTO marketing_initiatives set company='$company',contact_person1='$contact_person1',number1='$number1',mobile1='$mobile1',email1='$email1',
		contact_person2='$contact_person2',number2='$number2',mobile2='$mobile2',email2='$email2',post_date=NOW()";
	//	mysql_query($sql);	
		$msg = "Thanks for Participation";
}		
?>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
<script type="text/javascript">
$().ready(function() {

	$("#regisForm").validate({
		
		rules: {
		    company: {
				required: true,
			},
			contact_person1: {
				required: true,
			}, 
			/*number1: {
				required: true,
				number:true,
				minlength: 8,
				maxlength: 8
			},*/
			mobile1: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			email1: {
				required: true,
				email:true
			},
			contact_person2: {
				required: true,
			}, 
			/*number2: {
				required: true,
				number:true,
				minlength: 8,
				maxlength: 8
			},*/
			mobile2: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			email2: {
				required: true,
				email:true
			},
		},
		messages: {
		    company: {
				required: "Enter Company",
			}, 
			contact_person1: {
				required: "Enter Contact Person",
			}, 
			/*number1: {
				required:"Enter Landline Number",
				number:"Enter Numbers only",
				minlength:"Enter at least {0} digit.",
				maxlength:"Enter no more than {0} digit."
			},*/
			mobile1: {
				required:"Enter Mobile Number",
				number:"Enter Numbers only",
				minlength:"Enter at least {10} digit.",
				maxlength:"Enter no more than {0} digit."
			},
			email1: {
				required: "Enter a valid Email id",
			},
			contact_person2: {
				required: "Enter Contact Person",
			}, 
			/*number2: {
				required:"Enter Landline Number",
				number:"Enter Numbers only",
				minlength:"Enter at least {0} digit.",
				maxlength:"Enter no more than {0} digit."
			},*/
			mobile2: {
				required:"Enter Mobile Number",
				number:"Enter Numbers only",
				minlength:"Enter at least {10} digit.",
				maxlength:"Enter no more than {0} digit."
			},
			email2: {
				required: "Enter a valid Email id",
			}
	 }
	});
});
</script>

<section>
	
    <div class="container-fluid inner_container">
    
    	<div class="row justify-content-center grey_title_bg">      
        	
            <div class="innerpg_title_center">
            	<h1> GJEPC MARKETING INITIATIVES <?php echo $verifyMember;?></h1>
            </div>
                      
        </div>   
         	
        <div class="container p-0">        
        	
            <div class="row justify-content-center">
            	
					<?php
          if($msg!=""){
          echo "<span style='color: red; font-size: 20px;'>".$msg."</span>";
          $msg="";
                 }
    ?>
                <form class="cmxform col-lg-5 box-shadow mb-5"  method="post" name="regisForm" id="regisForm" enctype="multipart/form-data">
                
                <input type="hidden" name="action" value="save" />
                <input type="hidden" name="verifyMember" value="<?php echo $verifyMember;?>" />
                <input type="hidden" name="gcode" value="<?php echo $gcode;?>" />	
                
                <div class="col-md-12 col-sm-12 col-xs-12 minibuffer">
                
                <div class="sub_head">Please fill in the details of the Official who would be in receipt of Marketing Related Communication </div>
                
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="input_title" style="font-size:20px;">Company</div>
                <div class="content_wrp">
                <input type="text" class="form-control" id="company" name="company" placeholder="Company" autocomplete="off">
                </div>
                </div> 
                
                <div class="sub_head">Contact Person 1</div>
                
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="input_title">Contact Person</div>
                <div class="content_wrp">
                <input type="text" class="form-control" id="contact_person1" name="contact_person1" placeholder="Contact Person" autocomplete="off">
                </div>
                </div>
                
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="input_title">Mobile Number</div>
                <div class="content_wrp">
                <input type="text" class="form-control" id="mobile1" name="mobile1" placeholder="Mobile Number" autocomplete="off">
                </div>
                </div>
                
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="input_title">Email Id</div>
                <div class="content_wrp">
                <input type="text" class="form-control" id="email1" name="email1" placeholder="Email Id">
                </div>
                </div>	
                
                <div class="sub_head">Contact Person 2</div>
                
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="input_title">Contact Person</div>
                <div class="content_wrp">
                <input type="text" class="form-control" id="contact_person2" name="contact_person2" placeholder="Contact Person" autocomplete="off">
                </div>
                </div>
                
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="input_title">Mobile Number</div>
                <div class="content_wrp">
                <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Mobile Number" autocomplete="off">
                </div>
                </div>
                
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="input_title">Email Id</div>
                <div class="content_wrp">
                <input type="text" class="form-control" id="email2" name="email2" placeholder="Email Id">
                </div>
                </div>			
                
                </div>
                
                <div class="col-md-12 col-sm-12 col-xs-12 minibufer">
                <button type="submit" class="btn btn-default">Submit</button>
                <button type="reset" class="btn btn-default">Reset</button>
                </div>
                
                </form>

                    
            </div>     
                   
        </div>	
        
    </div>
    
</section>


<?php include 'include/footer.php'; ?>
