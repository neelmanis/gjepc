<?php 
include 'include-new/header.php'; 
include 'db.inc.php'; 
include('functions.php');

$limit=10;
$page=$_GET['p'];
if($page=='')
{
  $page=1;
  $start=0;
} else {
  $start=$limit*($page-1);
}
?>

<section class="py-5">


	<div class="container inner_container">

		<div class="row"> 

            <div class="col-12 text-center mb-5">
                <h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
                GJEPC Updates on COVID-19</h1>
                
                <p class="text-center mb-4">GJEPC Contact During Lockdown <strong><a href="gjepc-contacts-during-lockdown.php" class="gold_clr">Click Here</a></strong></p>
                
            </div>
            
            <div class="col-12">
				
                  <a href="news_detail.php?id=6072" class="new_pdf_wrp">
                      <p class="blue">Apr 30, 2020</p> 
                      <div class="circular_text">Some G&amp;J Units in Surat and Jaipur SEZs &amp; EPIP Resume Production; First Post-Lockdown Export Parcels Shipped</div>
                  </a>
				
           	</div>
            
            <div class="col-12">
				
                  <a href="news_detail.php?id=6027" class="new_pdf_wrp">
                      <p class="blue">Apr 15, 2020</p> 
                      <div class="circular_text">SEZs and EOUs Outside Containment Zones to Resume Partial Operations After April 20</div>
                  </a>
				
           	</div>
            
            <div class="col-12">
				
                  <a href="news_detail.php?id=6019" class="new_pdf_wrp">
                      <p class="blue">Apr 13, 2020</p> 
                      <div class="circular_text">GJEPC: Large, Organised-Sector G&amp;J Units and MSMEs with Export Commitments May Resume Limited Operations Shortly</div>
                  </a>
				
           	</div>
            
            <div class="col-12">
				
                  <a href="news_detail.php?id=6015" class="new_pdf_wrp">
                      <p class="blue">Apr 10, 2020</p> 
                      <div class="circular_text">GJEPC - WTO Estimates World Trade Will Decline by 13 to 32% in 2020 Due to COVID-19</div>
                  </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="news_detail.php?id=6007" class="new_pdf_wrp">
                  <p class="blue">Apr 08, 2020</p> 
                  <div class="circular_text">GJEPC to Host Webinar with Expert Panel on Supply of Gold / Silver for Export</div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="news_detail.php?id=6003" class="new_pdf_wrp">
                  <p class="blue">Apr 07, 2020</p> 
                  <div class="circular_text">DGFT Expands Online Platform for Issuing Certificate of Origin; More FTAs  PTAs Included</div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="https://gjepc.org/pdf/COVID/Circular-regarding-Extension-of-Export-realisation-period.pdf" target="_blank" class="new_pdf_wrp">
                  <p class="blue">Apr 04, 2020</p> 
                  <div class="circular_text">RBI Circular regarding Export of Goods and Services Realisation and Repatriation of Export Proceeds-Relaxation</div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="news_detail.php?id=5994" target="_blank" class="new_pdf_wrp">
                  <p class="blue">Apr 03, 2020</p> 
                  <div class="circular_text">GJEPC Launches Campaign to Identify Daily Wage Artisans in Need of Financial Assistance </div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="pdf/COVID/Document-relaxation-sought-and-measures-announced-revised.pdf" target="_blank" class="new_pdf_wrp">
                  <p class="blue">Apr 03, 2020</p> 
                  <div class="circular_text">GJEPC: Lists down the following notifications / circulars as announced by GOVT. based on representing done with the GOVT. </div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="news_detail.php?id=5989" class="new_pdf_wrp">
                  <p class="blue">Apr 02, 2020</p> 
                  <div class="circular_text">GJEPC: Government Extends Validity of Foreign Trade Policy, Amends Deadlines Under Various Heads </div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="pdf/COVID/PM-CARE-FUNDS-hindi.pdf" target="_blank" class="new_pdf_wrp">
                  <p class="blue">Apr 01, 2020</p> 
                  <div class="circular_text">जीजेईपीसी ने पीएम केयर फंड में 21 करोड़ रूपए देने का निर्णय लिया है</div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="pdf/COVID/PM-CARE-FUNDS-hindi.pdf" target="_blank" class="new_pdf_wrp">
                  <p class="blue">Apr 01, 2020</p> 
                  <div class="circular_text">जीजेईपीसी ने पीएम केयर फंड में 21 करोड़ रूपए देने का निर्णय लिया है</div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="pdf/COVID/Honorable-PM-letter-v1.pdf" target="_blank" class="new_pdf_wrp">
                  <p class="blue">Apr 01, 2020</p> 
                  <div class="circular_text">GJEPC contributes Rs. 21 Crore to PM CARES Fund</div>
                </a>
				
           	</div>
            
            <div class="col-12">
				
                <a href="news_detail.php?id=5986" class="new_pdf_wrp">
                  <p class="blue">Apr 01, 2020</p> 
                  <div class="circular_text">GJEPC Welcomes Extension of Export Repatriation Period, Other Reliefs to Exporters</div>
                </a>
				
           	</div>
            
            <div class="col-12">
               <a href="pdf/COVID/Members-notification-FTP-HBoP.pdf" target="_blank" class="new_pdf_wrp">     
                    <p class="blue">Apr 01, 2020</p>
                    <div class="circular_text"> Members notification for FTP and HBoP</div>
                    </a>
                </div>
                  
            <div class="col-12">
                    <a href="pdf/COVID/DGFT-Notification-No57.pdf" target="_blank" class="new_pdf_wrp">
                    <p class="blue">Mar 31, 2020</p>
                    <div class="circular_text"> DGFT Notification No. 57</div>
                    </a>
                </div>
                   

           <div class="col-12">
                    <a href="pdf/COVID/DGFT-Public-Notice-No67.pdf" target="_blank" class="new_pdf_wrp">
                    <p class="blue">Mar 31, 2020</p>
                    <div class="circular_text"> DGFT Public Notice No. 67</div>
                    </a>
                </div>
                   

               <div class="col-12">
                      <a href="pdf/COVID/banks-policy-on-covid-related-reschedulement-of-dues.pdf" target="_blank" class="new_pdf_wrp">  
                    	<p class="blue">Mar 31, 2020</p>
                    	<div class="circular_text"> Regulatory measures and reliefs announced by RBI in view of COVID 19 – Bank's Policy for implementation.</div>
                        </a>
                    </div>
                  

               <div class="col-12">
                   <a href="news_detail.php?id=5977" class="new_pdf_wrp">     
                    	<p class="blue">Mar 30, 2020</p>
                    	<div class="circular_text"> GJEPC Welcomes Relaxations on Compliances in SEZs, Caution Listing Exemption Under EDPMS</div>
                        </a>
                    </div>
                    

                <div class="col-12">
                       <a href="https://gjepc.org/admin/Circulars/817721479_Circular%20to%20all%20Members%20of%20the%20Council%20reg%20RBI%20Measures.pdf" target="_blank" class="new_pdf_wrp"> 
                    	<p class="blue">Mar 28, 2020</p>
                    	<div class="circular_text">Circular to all Members of the Council reg RBI Measures</div>
                        </a>
                    </div>
                   

               <div class="col-12">
                        <a href="pdf/Impact-of-COVID-19-on-GJ-20Sector2020.pdf" target="_blank" class="new_pdf_wrp">
                    	<p class="blue">Mar 28, 2020</p>
                    	<div class="circular_text"> Covid 19 : Impact on Gem and Jewellery Sector & Industry Suggestions to Sustain the Business </div>
                        </a>
                    </div>
                  

               <div class="col-12">
                        <a href="news_detail.php?id=5970" class="new_pdf_wrp">
                    	<p class="blue">Mar 27, 2020</p>
                    	<div class="circular_text"> GJEPC Plans Virtual B2B Meet with Partners in Singapore, Switzerland to Mitigate Trade Disruption </div>
                        </a>
                    </div>
                    

              <div class="col-12">
                        <a href="news_detail.php?id=5971" class="new_pdf_wrp"> 
                    	<p class="blue">Mar 27, 2020</p>
                    	<div class="circular_text"> GJEPC: RBI Defers Interest Payment on Working Capital for Three Months; Offers Added Reliefs Amid Uncertainty </div>
                       </a>
                    </div>
                   

                <div class="col-12">
                        <a href="https://gjepc.org/admin/PressRelease/701873034_GJEPC-Contributes-INR-50-Crores-COVID-19.pdf" target="_blank" class="new_pdf_wrp">
                    	<p class="blue">Mar 26, 2020</p>
                    	<div class="circular_text"> GJEPC Contributes INR 50 Crores COVID 19 </div>
                        </a>
                    </div>
                  

                <div class="col-12">
                        <a href="https://gjepc.org/emailer_gjepc/24.03.2020/index.html" target="_blank" class="new_pdf_wrp">
                    	<p class="blue">Mar 24, 2020</p>
                    	<div class="circular_text">  Letter to members of the gem & jewellery export promotional council  </div>
                        </a>
                    </div>
                   

               <div class="col-12">
                        <a href="news_detail.php?id=5961" class="new_pdf_wrp">
                    	<p class="blue">Mar 26, 2020</p>
                    	<div class="circular_text"> Indian Government Amends Lockdown Rules, Allows Interstate Movement of Goods and Cargo for Inland &amp; Exports </div>
                        </a>
                    </div>
                    

                <div class="col-12">
                        <a href="news_detail.php?id=5957" class="new_pdf_wrp">
                    	<p class="blue">Mar 25, 2020 </p>
                    	<div class="circular_text"> GJEPC Sets Up a Rs. 50 Crore Corpus for Welfare Measures in the Wake of COVID-19 </div>
                        </a>
                    </div>
                   

                <div class="col-12">
                        <a href="news_detail.php?id=5953" class="new_pdf_wrp">
                    	<p class="blue">Mar 24, 2020</p>
                    	<div class="circular_text"> GJEPC Welcomes Operational Measures and Reliefs Announced by Indian Government </div>
                        </a>
                    </div>
                    

                <div class="col-12">
                        <a href="news_detail.php?id=5949" class="new_pdf_wrp">
                    	<p class="blue">Mar 23, 2020</p>
                    	<div class="circular_text"> GJEPC Takes Steps to Mitigate Impact of COVID-19 Crisis on Business </div>
                        </a>
                    </div>
                   

                <div class="col-12">
                        <a href="news_detail.php?id=5942" class="new_pdf_wrp">
                    	<p class="blue">Mar 20, 2020</p>
                    	<div class="circular_text"> GJEPC: Members May Approach Banks for Benefits Under Government's Revised Norms for Export Credit </div>
                        </a>
                    </div>
                   

                
            </div>

	</div>

</section>

<?php include 'include-new/footer.php'; ?>