<?php 
include 'include/header.php';
include 'db.inc.php'; 
?>
<?php if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; } ?>


<section>

<div class="banner_wrap mb">
	<?php include 'include/inner_banner.php'; ?>
        
	<ul class="d-flex breadcrumb">
		<li><a href="index.php">Home</a></li>
      	<li class="active">Election for COA</li>
	</ul>     

</div>

<div class="container inner_container">
	
	<div class="row justify-content-center mb">
    	
        <div class="col-12">
			<div class="innerpg_title">
          		<h1>Election For COA</h1>
       		</div>
		</div>
        
		

	     <div class="col-12">
                
				<?php
				$sql_elec="SELECT * FROM `Election_Live` WHERE 1 and status='1' order by id desc";
				$result_elec=mysql_query($sql_elec);
				$rows_elec=mysql_fetch_array($result_elec);
				?>
                <ul class="circular_wrap row">
					<?php
					$sql="SELECT * FROM `election_for_coa_master` WHERE 1 and status='1' order by id desc";
					$result=mysql_query($sql);
					while($rows=mysql_fetch_array($result))
					{ ?>
					<li class="col-lg-4 col-md-4  col-sm-6 mb-4">
                        	<a href="admin/COA/<?php echo $rows['upload_pdf'];?>" target="_blank" class="pdf_wrp">
                            	<span class="blue" style="font-size:14px;"><?php echo date("d-M-Y",strtotime($rows['post_date']));?></span> 
                                <div class="circular_text"><?php echo filter($rows['name']);?> </div>
                                <div class="clearfix"></div> 
                            </a>
              
					</li>	
				
					<?php }	?>
                    
	            </ul>                
			 </div> 
	</div>	
</div>






</section>

<?php include 'include/footer.php'; ?>