<?php 
include 'include/header.php'; 
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

<section>
	<div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>
        <ul class="d-flex breadcrumb">
    		<li><a href="index.php">Home</a></li>
    		<li class="active">COVID-19 - Industry News and Updates</li>
  		</ul>
    </div>

	<div class="container inner_container">	
		<div class="row mb">    	
            <div class="col-12">
            	<div class="innerpg_title">
              		<h1>COVID-19 - Industry News and Updates</h1>
                </div>
       		</div>
            
            <div class="col-12 grid_gallery">
            
            	<ul id="tabs" class="nav nav-tabs justify-content-center" role="tablist">
        			
                    <li class="nav-item">
            			<a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">Other Association</a>
        			</li>
        			
                    <li class="nav-item">
            			<a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">Mining</a>
        			</li>
                    
                    <li class="nav-item">
                        <a id="tab-C" href="#pane-C" class="nav-link" data-toggle="tab" role="tab">Events</a>
                    </li>
        
                  
        
                    
                </ul>

				<div id="content" class="tab-content" role="tablist">
        			
                    <div id="pane-A" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                    
            			<div class="card-header" role="tab" id="heading-A">
                			<h5 class="mb-0">
                    			<a data-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">Other Association</a>
                			</h5>
            			</div>

                        <div id="collapse-A" class="collapse show" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">
                			
                            <div class="card-body">
                    			
                                <div class="row">
                                
                                <a href="news_detail.php?id=6017" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/434723779_JewlerSupportNetwork.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 10, 2020</span>
                        	<h2> RJC Joins DPA and Other Trade Bodies to Form Jewelers Support Network </h2>
                        	<p>The Responsible Jewellery Council (RJC) has joined hands with the Diamond Producers Association (DPA) and other industry bodies for a new initiative – the Jewelers Support Network.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=6014" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1450428792_gold-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 09, 2020</span>
                        	<h2> Gold: Investment Demand Surges, Imports into India Fall Amidst COVID-19 Pandemic </h2>
                        	<p>Amidst uncertainty over how long the current lockdown in major parts of the world will last and the medium and longer-tern impact on different sectors of the global economy, investment demand in one of the most popular safe havens for investors, gold, has soared over the past few weeks even as prices continued to remain high.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5998" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/115478216_CIBJO.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 06, 2020</span>
                        	<h2> CIBJO President Calls for Industry-wide Discussion on How to Move Forward in Considering the COVID-19 Crisis </h2>
                        	<p>"Historically, international crises have been inflection points in the human experience, and the COVID-19 epidemic is likely to be one of the most transformative in living memory," proclaimed CIBJO President Dr. Gaetano Cavalieri in a message he sent out to the gems and jewellery industry today.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5982" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1597628612_DMCC-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 31, 2020</span>
                        	<h2> DMCC Unveils Business Support Package for Existing and New Members </h2>
                        	<p>The Dubai Multi-Commodities Centre (DMCC) has announced the roll-out of a special Business Support Package, including discounts and waivers, for both existing and new members, applicable from April 1, 2020.</p>
                        </div>
                  	</div>  
                </a>
                
                <a href="news_detail.php?id=5984" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/572657944_diamond-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 31, 2020</span>
                        	<h2> Submission Date for First Diamonds Do Good Jewelry Awards Extended to June 30 </h2>
                        	<p>The organisers of the Diamonds Do Good Jewelry Awards, Diamonds Do Good and JCK, have announced that the submission date for the first edition of the annual Awards has been extended to June 30, 2020.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5979" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1087583426_diamond-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 30, 2020</span>
                        	<h2> AWDC-IDI Organised Online Diamond Trade Show Opens Today with 70 Exhibitors, 500 Trade Visitors </h2>
                        	<p>The online diamond trade show co-organised by The Antwerp World Diamond Centre (AWDC) and Israeli Diamond Institute (IDI) opens today with 70 exhibitors and over 500 pre-registered trade visitors, according to an announcement on The Diamond Loupe, the online news site associated with AWDC.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5980" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1701911733_chow-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 30, 2020</span>
                        	<h2> Chow Tai Fook Starts Manufacturing Face Masks at its Factory in Lunijao, Shunde </h2>
                        	<p>Chow Tai Fook Jewellery Group Limited announced yesterday that production of face masks at its T MARK diamond processing factory in Lunjiao, Shunde had commenced on March 19 with a capability of around 100,000 pieces per day.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5964" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/2020788035_south_africa-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 26, 2020</span>
                        	<h2> Oppenheimers and Johann Rupert Donate R1 Bn Each to Aid Small Businesses Hit by COVID-19 in S. Africa </h2>
                        	<p>Two prominent South African business families closely linked to the luxury goods sector, the Oppenheimers who formerly owned De Beers and Johann Rupert Chairman of Compagnie Financiere Richemont, known for its brands Cartier and Montblanc, have come forward to donate R1 billion each to assist small businesses and their employees affected by the coronavirus pandemic.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5958" class="col-md-4 mb-3">        
                        <div class="news_box">
                            <div class="col-12 mb-3"> <img src="admin/images/news_images/1298952749_Ernie-Blom-(hi-res).jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                            <div class="col-12 news_short_para">
                                <span>Mar 25, 2020</span>
                                <h2> WFDB to Set Up a New Diamond Trading Platform Keeping in Mind Members Needs </h2>
                                <p>The World Federation of Diamond Bourses today announced that it has decided to create a new Diamond Trading Platform, which is in the process of being set up and will be launched in due course.</p>
                            </div>
                        </div>  
                    </a>
                
                            <a href="news_detail.php?id=5939" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/20894069_WFDB.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 19, 2020</span>
                        	<h2> WFDB Extends Sympathy to Victims of COVID-19; Calls on Industry to Find Innovative Ways to Face Crisis </h2>
                        	<p>The President of the World Federation of Diamond Bourses (WFDB), Ernie Blom, on behalf of the entire Executive Committee, extended his sincere sympathy to all victims of the coronavirus, even as he urged the industry to "be innovative so that some semblance of business continues to take place" during the present phase.</p>
                        </div>
                  	</div>  
                </a>
                
                  
                			</div>
                			
                            </div>
                            
            			</div>
        			
                    </div>

        			<div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
            			
                        <div class="card-header" role="tab" id="heading-B">
                			<h5 class="mb-0">
                    			<a class="collapsed" data-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
                        			Mining
                    			</a>
                			</h5>
            			</div>
                        
            			<div id="collapse-B" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
                			
                            <div class="card-body">
                    			
                                <div class="row">
                                
                                <a href="news_detail.php?id=6016" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/799466855_alsoro.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 10, 2020</span>
                        	<h2> After a Great Start to the Year, ALROSA's March 2020 Sales of Diamonds Take a Nosedive to Reach US Dollar 152.8 Mn </h2>
                        	<p>ALROSA began 2020 on a high note with total sales of diamonds in January 2020 touching US$405 million. However, the impact of COVID-19 is evident as the major miner's total sales for March 2020 plummeted to US$152.8&nbsp;million.</p>
                        </div>
                  	</div>  
                </a>
                
                <a href="news_detail.php?id=6018" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1455781555_petra-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 10, 2020</span>
                        	<h2> Petra Diamonds Seeks to Preserve Liquidity Position; Suspends Work at Williamson Mine in Tanzania </h2>
                        	<p>Petra Diamonds Limited in a market update issued yesterday said that it was taking all steps necessary to preserve the company's liquidity position in the unprecedented depressed market environment due to the global COVID-19 pandemic, including suspending operations at the Williamson Mine in Tanzania.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=6013" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1309443659_BlueRock-Diamonds.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 09, 2020</span>
                        	<h2> BlueRock's Q1 2020 Production &amp; Sales Zoom But Stopped in the Track by COVID-19 </h2>
                        	<p>BlueRock Diamonds PLC, owner and operator of the Kareevlei Diamond Mine in the Kimberley region of South Africa, providing an update on its Q1 2020 production, said that in the first quarter of 2020 the Company had seen phenomenal growth.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=6008" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1256797241_alsoro.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 08, 2020</span>
                        	<h2> ALROSA and its CEO Together Spending RUB 166 Mn for Medical Supplies for Yakutia's Fight Against COVID-19 </h2>
                        	<p>Close on the heels of the announcement that ALROSA's CEO Sergey Ivanov had made a contribution to support the fight of communities of Yakutia against COVID-19, comes the announcement that ALROSA, as a Company, is also contributing to the effort.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=6004" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1282840606_de_beers-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 07, 2020</span>
                        	<h2> De Beers Contributes $2,500,000 across Botswana and Namibia to Support COVID-19 Response </h2>
                        	<p>De Beers Group has said that it will contribute $2,500,000 across Botswana and Namibia to aid the response to the COVID-19 crisis by supporting community leaders, healthcare professionals, and government measures.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5999" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1843869376_Sergey-ivanov-ALROSA.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 06, 2020</span>
                        	<h2> ALROSA CEO Reduces Personal Stake in Company; Donates Proceeds to Support Fight against COVID-19 in Yakutia </h2>
                        	<p>ALROSA CEO Sergey Ivanov has sold half of his stake in the Company and donated the proceeds, amounting to more than RUB 18.5 million, to counter the spread of COVID-19 infection in Mirny district of Yakutia, where the miner operates.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5991" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1764235708_lucara-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 02, 2020</span>
                        	<h2> Lucara Suspends its 2020 Guidance Due to COVID-19 Impact Which is Yet to be Fully Gauged </h2>
                        	<p>Lucara Diamond Corp. has suspended its 2020 Guidance and also said that it was unlikely to be able to hold its tenders due to the situation created by COVID-19, and given the uncertainty as to when prevailing travel restrictions will be lifted.</p>
                        </div>
                  	</div>  
                </a>
				
                                <a href="news_detail.php?id=5987" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1340613684_gemfield-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 01, 2020</span>
                        	<h2> Gemfields Suspends Operations at Kagem; Anticipates Detrimental Impact on Business in 2020 Due to COVID-19 </h2>
                        	<p>Calling the turmoil stemming from COVID-19 one of "the most serious challenges faced by many companies globally", Gemfields said yesterday that "a significant detrimental impact on its operations, revenues and business is inevitable during 2020 and possibly beyond".</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5983" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1166615578_petra-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 31, 2020</span>
                        	<h2> Petra Diamonds Withdraws 2020 Guidance; Peter Hill Assumes Role as New Chairman </h2>
                        	<p>Petra Diamonds said today that, as previously announced, its Founder and Chairman Adonis Pouroulis stepped down from the Board of Directors with Peter Hill, Non-Executive Director and Chairman-designate since December 2019 taking over the responsibility.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5978" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1267904473_de_beers-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 30, 2020</span>
                        	<h2> De Beers Not to Hold 3rd Sight of 2020; Permits Deferment of 100% of Allocations to Later in Year </h2>
                        	<p>De Beers today announced that it would not be holding the third sight of 2020 which was scheduled to begin in Botswana today on account of the ongoing Covid-19 pandemic.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="https://gjepc.org/news_detail.php?id=5974" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1905165744_alsora.png" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 27, 2020</span>
                        	<h2> Even as ALROSA's Diamond Production Activity at Mines Continues, Company Takes Measures to Prevent Spread of COVID-19 </h2>
                        	<p>ALROSA said yesterday that production activity at the company\'s diamond-mining enterprises in Yakutia and the Arkhangelsk region is continuing as usual.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5962" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1413548847_alsoro.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 26, 2020</span>
                        	<h2> ALROSA's Newly Launched Digital Tender for Large Rough Diamonds on Between March 23 and April 6, 2020 </h2>
                        	<p>ALROSA's new digital tender for special size (over 10.8 carats) rough diamonds launched in the face of the outbreak of the coronavirus pandemic and travel restrictions imposed by several countries as a result, is currently taking place, having been scheduled for March 23- April 6.  &nbsp;</p>
                        </div>
                  	</div>  
                </a>
                
                				<a href="news_detail.php?id=5963" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1403894415_lucapa-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 26, 2020</span>
                        	<h2> Operations Suspended at Mothae Mine Following Declaration of 21-Day Lockdown in South Africa </h2>
                        	<p>Lucapa Diamond Company Limited and its partner, the Government of Lesotho, have together decided to suspend operations at the joint venture Mothae Diamond Mine in Lesotho.</p>
                        </div>
                  	</div>  
                </a>
                
                				
                
                				<a href="news_detail.php?id=5960" class="col-md-4 mb-3">        
                        <div class="news_box">
                            <div class="col-12 mb-3"> <img src="admin/images/news_images/1860382413_Diamonds.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                            <div class="col-12 news_short_para">
                                <span>Mar 25, 2020</span>
                                <h2> COVID-19: Many Diamond Miners and Jewellery Retailers Across the World Announce Suspension of Operations </h2>
                                <p>Even as nearly all the important centres for manufacturing and trading diamonds have suspended work in factories, offices and bourses, the impact of the COVID-19 pandemic brought mining and retail operations in different countries to a halt.</p>
                            </div>
                        </div>  
                    </a>
                
                				<a href="news_detail.php?id=5955" class="col-md-4 mb-3">        
                        <div class="news_box">
                            <div class="col-12 mb-3"> <img src="admin/images/news_images/1729933273_province-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                            <div class="col-12 news_short_para">
                                <span>Mar 24, 2020</span>
                                <h2> Mountain Province  Says COVID-19 Has Reversed Positive Beginning to 2020; Withdraws All Guidance Metrics </h2>
                                <p>Mountain Province Diamonds Inc. yesterday announced its unaudited financial and operating results for the fourth quarter (Q4 2019) and the full year ended&nbsp;December 31, 2019&nbsp;(FY 2019).</p>
                            </div>
                        </div>  
                    </a>
                
                	<a href="news_detail.php?id=5951" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/310030938_dominion-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 23, 2020</span>
                        	<h2> COVID-19 Impact: Dominion Suspends Operations at Ekati </h2>
                        	<p>Dominion Diamond Mines announced yesterday that it was suspending operations at its Ekati Diamond Mine in NWT, Canada to safeguard its employees and the communities surrounding it, while Rio Tinto said that the Diavik Diamond Mine was continuing to work at capacity, albeit with enhanced precautions in place.</p>
                        </div>
                  	</div>  
                </a>
                
                    <a href="news_detail.php?id=5946" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/444058272_Alrosa.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 20, 2020</span>
                        	<h2> ALROSA May Take Trading Online As Travel Restrictions Imposed By Several Countries </h2>
                        	<p>ALROSA has said on its official Twitter account that it is "considering options for online trade as global travel restrictions due to the coronavirus outbreak complicate traditional physical inspection of gemstones".</p>
                        </div>
                  	</div>  
                </a>
                
                    <a href="news_detail.php?id=5948" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/123257318_GemDiamonds.png" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 20, 2020</span>
                        	<h2> Gem Diamonds: 18% Drop in Prices at Small Diamond Tender; Large Diamonds Tender Cancelled </h2>
                        	<p>Gem Diamonds announced a drop in proceeds at its tender of small diamonds from the Letseng mine which concluded on March 18 and said that it was cancelling the ongoing Letseng large diamond tender and replacing it with a flexible direct sale process.</p>
                        </div>
                  	</div>  
                </a>
                
                	<a href="news_detail.php?id=5940" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/450103845_Mountain-Province.png" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 19, 2020</span>
                        	<h2> Mountain Province's Third Diamond Sale of 2020 Put off Till Further Notice </h2>
                        	<p>Mountain Province Diamonds Inc., which only recently postponed the release of its year-end results by a week, has also announced that that the Company's third diamond sale of 2020 has been put off "until further notice".</p>
                        </div>
                  	</div>  
                </a>
                
                 
                
                    
                </div>
                			
                            </div>
            			
                        </div>
        			
                    </div>

        			<div id="pane-C" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
            			
                        <div class="card-header" role="tab" id="heading-C">
                			<h5 class="mb-0">
                    			<a class="collapsed" data-toggle="collapse" href="#collapse-C" aria-expanded="false" aria-controls="collapse-C">
                        			Events
                    			</a>
                			</h5>
            			</div>
                        
            			<div id="collapse-C" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-C">
                			
                            <div class="card-body">
                    			
                                <div class="row">
                                
                                <a href="news_detail.php?id=6010" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/386184985_HKTDC-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Apr 08, 2020</span>
                        	<h2> HKTDC Announces New Dates for HKIJS Exhibition; Opens Online Spring Expo </h2>
                        	<p>The Hong Kong Trade Development Council (HKTDC) has said that the rescheduled HKTDC Hong Kong International Diamond, Gem &amp; Pearl Show 2020 and the HKTDC Hong Kong International Jewellery Show 2020 will now be held from August 3-6, 2020 instead of the originally announced dates in May.</p>
                        </div>
                  	</div>  
                </a>
                                
                                <a href="news_detail.php?id=5956" class="col-md-4 mb-3">        
                        <div class="news_box">
                            <div class="col-12 mb-3"> <img src="admin/images/news_images/2056229969_hong-kong-530-x-326.jpg" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                            <div class="col-12 news_short_para">
                                <span>Mar 24, 2020</span>
                                <h2> Organisers Suspend Preparations for Hong Kong Jewellery Shows that Had Been Rescheduled to May </h2>
                                <p>The organisers of the HKTDC Hong Kong International Diamond, Gem &amp; Pearl Show 2020 and the HKTDC Hong Kong International Jewellery Show 2020 have decided to suspend the preparation work for the twin fairs that had already been rescheduled from March to May.</p>
                            </div>
                        </div>  
                    </a>
                
                	<a href="news_detail.php?id=5947" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1840943588_AWDC-Africa-Conference.png" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 20, 2020</span>
                        	<h2> AWDC and Partners Postpone African Diamond Conference Originally Scheduled For May 2020 </h2>
                        	<p>The Antwerp World Diamond Centre (AWDC) has announced that the organisation and its   partners – the South African Department of Mineral Resources and Energy, the African Diamond Producers Association and Belgium's Federal Public Service-Foreign Affairs – have decided to postpone the African Diamond Conference, scheduled to be held in Durban, South Africa, from May5-6, 2020.</p>
                        </div>
                  	</div>  
                </a>
                
                    <a href="news_detail.php?id=5935" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1917557266_JCK-530-x-326.png" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 18, 2020</span>
                        	<h2> JCK Las Vegas Postponed to Later This Year;  New Dates to be  Announced Soon </h2>
                        	<p>The organisers of the largest gems and jewellery fair in the world,  JCK, Las Vegas  have announced that the show – and its counterpart the Luxury show -- will not be held as per their  scheduled dates, but have been postponed to later this year.</p>
                        </div>
                  	</div>  
                </a>
                
                    <a href="news_detail.php?id=5936" class="col-md-4 mb-3">        
                    <div class="news_box">
                    	<div class="col-12 mb-3"> <img src="admin/images/news_images/1722560651_kimberley-530-x-326.png" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-12 news_short_para">
                        	<span>Mar 18, 2020</span>
                        	<h2> KP Chair Says June Intersessional Meet Will be Held in Virtual Mode </h2>
                        	<p>The Kimberley Process Chair for 2020, Alexey Moiseev, Dy. Minister of Finance of the Russian Federation, has announced that the forthcoming Intersessional Meet of the organisation, scheduled for June 8-9, 2020 will not be held in a face-to-face format this year on account of the coronavirus COVID-19 outbreak.</p>
                        </div>
                  	</div>  
                </a>
                
                </div>
                			
                            </div>
            			
                        </div>
        			
                    </div>
                    
                    
                    
                    
                </div>
            
            </div>

</div>
</div>
</div>
<?php include 'include/footer.php'; ?>