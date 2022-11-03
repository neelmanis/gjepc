<?php include 'include/header.php'; ?>
<?php if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }?>

<?php
include 'db.inc.php';
$gcode=$_SESSION['USER_GCODE'];
$action=$_REQUEST['action'];
if($action=="save")
{ 
$location = filter($_REQUEST['location']);
$address  = filter($_REQUEST['address']);
$gst_no   = filter($_REQUEST['gst_no']);

$gst = count($gst_no);
for ($i=0; $i <$gst; $i++) {
		if (empty($gst_no[$i]) || empty($address[$i])) {
        continue;
		}
$gst_no[$i];
$address[$i];

$sql1="INSERT INTO gst_member set g_code='$gcode',gst_no='$gst_no[$i]',address='$address[$i]',post_date=NOW()";
$result=mysql_query($sql1);
$_SESSION['succ_msg']="Information saved successfully";
 }
}
?>

<?php
$location = filter($_REQUEST['location']);
$address  = filter($_REQUEST['address']);
if($gcode ==!""){
$sql = "select location, concat(address1, ', ' ,address2,', ', address3) as address from communication_address_master where gcode = '$gcode'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
}
else
{
$msg = "Member's G-Code not available";
echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>
<section>
    <div class="banner_wrap mb">
            <?php include 'include/inner_banner.php'; ?>            
            <ul class="d-flex breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Media</li>
                <li class="active"> Advertise</li>
            </ul>            
        </div>
    
    <div class="container inner_container">
    	
        <div class="row mb justify-content-center">

            <div class="col-12">
                <div class="title inner_title">
                    <h1> Member GST </h1>
                </div>
            </div>

            <div class="col-12">
                <?php 
                if($_SESSION['succ_msg']!=""){
                echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
                $_SESSION['succ_msg']="";
                }
                ?>
        
                <form class="cmxform" method="post" name="infoForm" id="infoForm">                    
                    <input type="hidden" name="action" value="save">                	
                    <div class="collection">                    	
                        <div class="row collection_box">                       		
                    
                        <div class="form-group col-sm-6">
                            <select name="address[]" id="address" class="form-control" required>
                            <option value="">--- Select Address ---</option>
                            <?php 
                            $sql="select id, state, concat(address1,', ',city,', ',country,', ',state,', ',pincode) as address from communication_address_master where
                            gcode = '$gcode'";
                            $query = mysql_query($sql);
                            while($row=mysql_fetch_array($query)){ ?>
                            <option value="<?php echo filter($row['state']); ?>"><?php echo $row['address']; ?></option>
                            <?php } ?>
                            </select>                            
                        </div>															
                    
                        <div class="form-group col-sm-6">
                            <input type="text" class="form-control" value="" name="gst_no[]" id="gst_no" placeholder="GST Number" required>
                        </div>                        
                        </div>                    
                    </div>                    
                    <a href="javascript:void(0);" class="add_button" title="Add field">Add More</a>                                  
                    <div class="form-group">
                        <button type="submit" class="cta fade_anim" name="submit" value="Submit"> Submit </button>
                    </div>                                
                </form>            
            </div>				
        </div>    
    </div>
</section>        
<?php include 'include/footer.php'; ?>

<script src="assets/js/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	$("#infoForm").validate({
			//var member_id=$("#member_type_id").val();
		rules: { 		     			  									
			'address[]':{
			    required: true,	
			},	
			'gst_no[]':{
			    required: true,	
			},				
		},
		messages: {					           		
			address: {
				required: "Please Enter Address",
			},	
			gst_no: {
				required: "Please Enter GST Number",
			},					
		}
	});
});
</script>
<script type="text/javascript">		
	$(document).ready(function(){
	var maxField = 100; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.collection'); //Input field wrapper
	var fieldHTML = jQuery('.collection_box').html();
	var fieldHTML = "<div class='row collection_box'>"+fieldHTML+"<a href='javascript:void(0);' class='remove_button' title='Remove field'>Remove</a></div>";
	//console.log(fieldHTML);
	var x = 1; //Initial field counter is 1
	$(addButton).click(function(){ //Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$('.remove_button').click(function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('.collection_box').remove(); //Remove field html
		x--; //Decrement field counter
	});
});
</script>