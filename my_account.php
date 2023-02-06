<?php 
include 'include-new/header.php'; 

if(!isset($_SESSION['USERID'])){header('location:login.php'); exit; }
$uid=$_SESSION['USERID'];
include 'db.inc.php';
include 'functions.php';
?>

<section class="py-5">	
    <div class="container inner_container">
    
    	<h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> My Account</h1>
        
		<div class="row">
			

			<div class="col-lg-3 col-md-4 order-sm-12" data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
			</div>

			<div class="col-lg-9 col-md-8 col-sm-12 order-sm-1">		
				<p class="gold_clr"> <strong> GJEPC MEMBERSHIP / REGISTRATION CUM MEMBERSHIP CERTIFICATE (RCMC) </strong></p>
				
				<p><strong><a href="pdf/COA-Election-Result-declaration-2022-2024.pdf" target='_blank'>COA Election Result Declaration 2022-2024</a></strong></p>
</br/>				
				<p><strong><a href="pdf/FINAL-NOTICE-18082022.pdf">Final Notice for COA Election 2022-2024</a></strong></p>			
				<ul class="mb-4">
					<li><a href='pdf/FINAL-NOTICE-18082022.pdf' target='_blank' class='new_pdf_wrp'>Final Notice</a></li>
					<li><a href='pdf/ELECTION RULES 2022.pdf' target='_blank' class='new_pdf_wrp'>Annex 1- Election Rules</a></li>
					<li><a href='pdf/GJEPC_EVS_manual.pdf' target='_blank' class='new_pdf_wrp'>Annex 2- Election Voting Process Manual</a></li>
				</ul>
				
				<p><strong>Trade Shows</strong></p>
				
                <ul class="mb-4">
					<li class="new_pdf_wrp">National Trade Shows</li>
					<li class="new_pdf_wrp">International Trade Shows</li>
				</ul>	
				<p><strong>Circulars</strong></p>			
					<ul class="mb-4">
						<?php 
							$sql2="SELECT * FROM `circulars_master` WHERE 1 and status='1' order by post_date desc limit 6";
							$result2=$conn ->query($sql2);
							while($rows2=$result2->fetch_assoc())
							{
							$date=date('Y-m-d');
							$date_arr=explode('-',$date);
							$date2=Date("Y-m-d",mktime(0,0,0,$date_arr[1],$date_arr[2]-7,$date_arr[0]));
							
							echo "<li><a href='admin/Circulars/$rows2[upload_circulars]' target='_blank' class='new_pdf_wrp'>$rows2[name] ";
							if($rows2['post_date']>=$date2)
							{
							echo "&nbsp;<img src='images/new_icon.png' />";
							}  
							echo "</a></li>";
							}
						?>
					</ul>
								
            <p><strong>Notice Board</strong></p>            
			<ul class="mb-4">
				<li><a href="pdf/FINAL AGM NOTICE.pdf" target="_blank" class="new_pdf_wrp">56TH AGM OF GJEPC ON 30TH AUGUST 2022</a></li>
				<li><a href="pdf/HINDI FINAL AGM NOTICE.pdf" target="_blank" class="new_pdf_wrp">56TH AGM OF GJEPC ON 30TH AUGUST 2022 (HINDI)</a></li>
				<li><a href="pdf/FINAL ANNUAL REPORT 2020-21.pdf" target="_blank" class="new_pdf_wrp">FIFTY FIFTH ANNUAL REPORT FOR THE YEAR 2020-21 OF THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL</a></li>
				<li><a href="pdf/FINAL WEB ANNUAL REPORT 2019-20.pdf" target="_blank" class="new_pdf_wrp">Fifty Fourth Annual Report For The Year 2019-20 Of The Gem & Jewellery Export Promotion Council</a></li>
				<li><a href="pdf/FINAL AGM NOTICE IN HINDI-54TH AGM.pdf" target="_blank" class="new_pdf_wrp">NOTICE OF THE 54TH ANNUAL GENERAL MEETING OF THE COUNCIL DULY TRANSLATED IN HINDI SCHEDULED ON 29TH SEPTEMBER 2020 AT 12.00 NOON (HINDI)</a></li>
				<li><a href="pdf/FINAL AGM NOTICE-54TH AGM.pdf" target="_blank" class="new_pdf_wrp">Notice Of The Fifty Fourth Annual General Meeting Of The Council</a></li>
				<li><a href="http://pgportal.gov.in/" target="_blank" class="new_pdf_wrp">Public Grievances</a></li>
			</ul>            
            <a href="membership_rcmc.php" class="cta">Membership Portal</a>										
	</div>    
    	</div>	
    </div>
</section>
<?php include 'include-new/footer.php'; ?>

<style>
.inner_container p a {text-decoration:inherit;}
</style>