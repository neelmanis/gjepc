<?php 
//include_once('include/header_include.php');
session_start();
ob_start();
include_once('db.inc.php');
include_once('functions.php');
//$dept =$_SESSION['department'];
?>

<?php 

if($_REQUEST['Reset']=="Reset")
{
	
	$_SESSION['name']="";
	$_SESSION['reg']="";
	$_SESSION['dept']="";
	$_SESSION['designation']="";
	
  
  header("Location: emp_directory.php");
  exit;
  
}else
{ 
  	 $search_type=$_REQUEST['search_type'];
  	
	if($search_type=="SEARCH")
	{ 
		
	  $_SESSION['name']=filter_input_string($_REQUEST['name']);
	  $_SESSION['reg']=filter_input_string($_REQUEST['region']);
	  $_SESSION['dept']=filter_input_string($_REQUEST['dept']);
	  $_SESSION['designation']=filter_input_string($_REQUEST['designation']);
	  
	  //$_SESSION['email']=$_REQUEST['email'];
	  //$_SESSION['from_date']=$_REQUEST['from_date'];
	  //$_SESSION['to_date']=$_REQUEST['to_date'];
	  //$_SESSION['country']=$_REQUEST['country'];
	  //$_SESSION['status']=$_REQUEST['status'];
	}
/*if($search_type=='SEARCH')
{
if($_SESSION['f_name']=="" && $_SESSION['c_name']=="" && $_SESSION['p_type']=="")
{
$_SESSION['error_msg']="Please fill field to search";
}else if($_SESSION['f_name']=="" && $_SESSION['c_name'] =="")
{
$_SESSION['error_msg']="Please enter First name And Company name";
}else if($_SESSION['f_name']!="" && $_SESSION['p_type']=="")
{
$_SESSION['error_msg']="Please enter to date";
}

}*/
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC :: Intranet</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel="stylesheet" href="css/liteaccordion.css">
<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>


   <script>
$(document).ready(function(){
	var str=location.href.toLowerCase();
	$(".nav li a").each(function() {
		if (str.indexOf(this.href.toLowerCase()) > -1) {
				$("li").removeClass("active");
				$(this).parent().addClass("active");
		}
	});
	
	$("#search").click(function(){
		/*$(this).find('input[type=text], select').each(function(){
            alert(11);
			if($(this).val() != "")
			{
			 valid+=1;
			}
			alert(valid);
        });
		
		if(valid==0)
		{
			alert("please select Atleast one field");
			return false;
		}*/
	
	
	});
	
});
</script>
</head>

<body>

<?php include 'include/header.php';?>



<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">Search Employee Directory

<!--<div class="selectField">
<select name="Select Year">
<option>2014 - 2013</option>
<option>2013 - 2012</option>
<option>2012 - 2011</option>
<option>2010 - 2009</option>
</select>

</div>-->

</div>

<div class="grayBorder"></div>

<div class="boxWrapper">

<div class="formNew">
<form name="emp_dir" id="emp_dir" method="post">
 <div class="login_textfield_new">
        	<span>Name :</span>
            <input type="text" class="field_new" name="name" id="name" value="<?php echo $_SESSION['name'];?>" />
        </div>
  <div class="login_textfield_new">
        	<span>Region :</span>
            <select class="field_new_1" name="region" id="region">
            <option value="">Please Select Region</option>
            <?php $region_query="select distinct region from employee_details where 1";
				$region_result=mysql_query($region_query);
				while($region_row=mysql_fetch_array($region_result))
				{ ?>
					<option value="<?php echo $region_row['region'];?>" <?php if($region_row['region']==$_SESSION['reg']){ echo "selected";}?>><?php echo $region_row['region'];?></option>
				<?php } 
				//print_r($region_row);
			?>
            <!--<input type="text" class="field" name="username" id="username" />-->
            </select>
        </div>
         <div class="clear"></div>
        
   <div class="login_textfield_new">
        	<span>Department :</span>
            <!--<input type="text" class="field" name="username" id="username" />-->
             <select class="field_new_1" name="dept" id="dept">
            <option value="">Please Select Department</option>
            <?php $dept_query="select distinct department from employee_details where 1";
				$dept_result=mysql_query($dept_query);
				while($dept_row=mysql_fetch_array($dept_result))
				{ ?>
					<option value="<?php echo $dept_row['department'];?>" <?php if($dept_row['department']==$_SESSION['dept']){ echo "selected";}?>><?php echo $dept_row['department'];?></option>
			<?php	}
				//print_r($region_row);
			?>
            
            </select>
        </div>
   <div class="login_textfield_new">
        	<span>Designation :</span>
          
            <select class="field_new_1" name="designation" id="designation">
            <option value="">Please Select Designation</option>
            <?php $desg_query="select distinct designation from employee_details where 1";
				$desg_result=mysql_query($desg_query);
				while($desg_row=mysql_fetch_array($desg_result))
				{ ?>
					<option value="<?php echo $desg_row['designation'];?>" <?php if($desg_row['designation']==$_SESSION['designation']){ echo "selected";}?>><?php echo $desg_row['designation'];?></option>
			<?php	}
				//print_r($region_row);
			?>
            
            </select>
        </div>                
        
        <div class="clear"></div>
        
        <div class="login_textfield_new1">
         <input type="hidden"  name="search_type" id="search_type" value="SEARCH" />
        	<input type="submit" value="Search" name="search" id="search" class="submitNew" />
            <input type="submit" name="Reset" value="Reset" class="submitNew" />
            
        </div>
        
</form>

</div>

<?php if(isset($_POST['search_type']) && $_POST['search_type']=='SEARCH') { ?>
<table cellspacing="0" cellpadding="0" class="nameTable" >
  <tr class="orange1">
    <th>Name</th>
   <!-- <td width="6%">Participation Type</td>
    <td width="10%">Category Name</td>
    <td width="8%">Email ID</td>
	<td width="8%">Password</td>
    <td width="10%">Contact No.</td>
	<td width="10%">Company Name</td>
    
    
    <td width="8%">Application Date</td>
    <td width="8%">Document Received</td>
    <td width="7%" align="center">Status</td>
    <td width="7%">Action</td>-->
    
    
  </tr>
  <?php 
  	if($_SESSION['name']=='' && $_SESSION['reg']=='' && $_SESSION['dept']=='' && $_SESSION['designation']=='' )
	{
		 echo "<tr><td>no records found</td></tr>"; 
	}else
	{
  $search_query="select * from employee_details where 1 ";
  if($_SESSION['name']!="")
	{
	
  $search_query.="and employee_name like '%".$_SESSION['name']."%' ";
  
  }
  if($_SESSION['reg']!="")
  {
  	$search_query.="and region='".$_SESSION['reg']."' ";
  }
  if($_SESSION['dept']!="")
  {
  	$search_query.="and department='".$_SESSION['dept']."' ";
  }
  if($_SESSION['designation']!="")
  {
  	$search_query.="and designation='".$_SESSION['designation']."' ";
  }
  //echo $search_query;
  $searh_result=mysql_query($search_query);
  $search_row=mysql_num_rows($searh_result);
  if($search_row>0)
  {
  while($search_row=mysql_fetch_array($searh_result))
  {
   ?>
   <tr>
   <td><a href="emp_details.php?id=<?php echo $search_row['id'];?>"><?php echo $search_row['employee_name'];?></a></td>
   
   </tr>
   
   <?php } }else { echo "<tr><td>no records found</td></tr>";}
   }
   
    ?>
</table>
<?php  } ?>
<div class="clear"></div>
</div>    
  </div>  
    

    
    
    
    
    
    
    
    
    

    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->


<?php include 'include/footer.php';?>



</body>
</html>
