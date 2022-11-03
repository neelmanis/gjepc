<?php 
include 'include-new/header.php'; 

if(!isset($_SESSION['USERID'])){header('location:login.php');}
$uid=$_SESSION['USERID'];
include 'db.inc.php';
include 'functions.php';
?>

<section class="py-5">
	<div class="container inner_container">
    
    	<h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto">Legal and Secretarial Compliance</h1>
		<div class="row">
        	
            <div class="col-lg-auto order-lg-12 col-md-12" data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
			</div>

        	<div class="col-lg col-md-12 ">
        
                <div class="row">
                	<div class="col-12">	
						<a href="pdf/ELECTION-RULES-2022.pdf" target="_blank" class="new_pdf_wrp">ELECTION RULES 2022</a>
					</div>
                	<div class="col-12">	
						<a href="pdf/CHAIRMAN-REPORT-2022.pdf" target="_blank" class="new_pdf_wrp">CHAIRMAN REPORT 2022</a>
					</div>
                	<div class="col-12">	
						<a href="pdf/SCRUTINIZERS-REPORT-2022.pdf" target="_blank" class="new_pdf_wrp">SCRUTINIZERS REPORT 2022</a>
					</div>
                	<div class="col-12">	
						<a href="pdf/EGM-Notice-hindi.pdf" target="_blank" class="new_pdf_wrp">आर्डिनरी जनरल मीटिंग की नोटीस </a>
					</div>
                	<div class="col-12">	
						<a href="pdf/EGM-Notice.pdf" target="_blank" class="new_pdf_wrp">NOTICE OF THE EXTRA-ORDINARY GENERAL MEETING </a>
					</div>
                	<div class="col-12">	
						<a href="pdf/SCRUTINISER-REPORT-SIGNED.pdf" target="_blank" class="new_pdf_wrp">SCRUTINISER REPORT 2020-2021</a>
					</div>
					<div class="col-12">	
						<a href="pdf/CHAIRMAN-REPORT-SIGNED.pdf" target="_blank" class="new_pdf_wrp">CHAIRMAN REPORT 2020-2021</a>
					</div>
					<div class="col-12">	
						<a href="pdf/Scrutinizer's Report-GJEPC SIGNED.pdf" target="_blank" class="new_pdf_wrp">SCRUTINISER REPORT 2019-2020</a>
					</div>
					<div class="col-12">	
						<a href="pdf/Chairman's Report_GJEPC SIGNED.pdf" target="_blank" class="new_pdf_wrp">CHAIRMAN REPORT 2019-2020</a>
					</div>		
					
                    <div class="col-12">	
						<a href="pdf/GJEPC_Annual_Report_2018-19_Digital_for_Web.pdf" target="_blank" class="new_pdf_wrp">
							Annual Report of the Gem & Jewellery Export Promotion Council for 2018-19</a>
					</div>                    
                    <div class="col-12">	
						<a href="pdf/AGM_NOTICE Final_12.12.2019.pdf" target="_blank" class="new_pdf_wrp">
							NOTICE OF 53RD AGM OF THE COUNCIL ON 30TH DECEMBER 2019
						</a>
					</div>                    
                    <div class="col-12">	
						<a href="pdf/NOTICE%20OF%2051ST%20AGM%20COMP.PDF" target="_blank" class="new_pdf_wrp">
							51st Annual General Meeting
						</a>
					</div>                    
                    <div class="col-12">	
						<a href="pdf/RESULTS_OF_52ND_AGM_LIGHT.pdf" target="_blank" class="new_pdf_wrp">
							Results Of 52nd GM Result
						</a>
					</div>
                    
                    <div class="col-12">	
						<a href="pdf/CHAIRMAN REPORT.PDF" target="_blank" class="new_pdf_wrp">
							Chairman Report
						</a>
					</div>
                    <div class="col-12">	
						<a href="pdf/Report of Scrutinizer-signed by Chairman.PDF" target="_blank" class="new_pdf_wrp">
							Report of Scrutinizer
						</a>
					</div>                   
                    
                    <div class="col-12">	
						<a href="pdf/FINAL-EGM-NOTICE.pdf" target="_blank" class="new_pdf_wrp">
							Final EGM Notice
						</a>
					</div>
                    
                    <div class="col-12">	
						<a href="pdf/AnnualReport2017-18.pdf" target="_blank" class="new_pdf_wrp">
							GJEPC Annual Report 2017-18
						</a>
					</div>
                    
                    <div class="col-12">	
						<a href="pdf/TDC_GUIDELINES_COMP.PDF" target="_blank" class="new_pdf_wrp">
							Trade Disciplinary Committee
						</a>
					</div>
                    
                    <div class="col-12">	
						<a href="images/pdf/Code_of_Ethics_GJEPC_Version_2011.pdf" target="_blank" class="new_pdf_wrp">
							Code of Ethics
						</a>
					</div>                    
                </div> 
        	</div>	
        </div>        
    </div>
</section>
<?php include 'include-new/footer.php'; ?>