<?php 
$pageTitle = "Gems & Jewellery MSME | MSME Overview - GJEPC India";
$pageDescription  = "Micro, Small and Medium-sized Enterprises (MSME) are one among the most important sectors, forming the backbone of the Indian economy.";
?>
<?php include 'include-new/header.php'; ?>



<section class="py-5">

	<div class="container">
    
    
    
	<div class="bold_font text-center mb-4"> <div class="d-block"><img src="assets/images/gold_star.png"></div> MSME Definition </div>
    
    <p class="text-center mb-4">For further details on below queries, you may please visit <strong><a href="https://www.dcmsme.gov.in" target="_blank" class="gold_clr">www.dcmsme.gov.in</a></strong></p>
    
    <p> <strong> 1. What was existing MSME Classification and revised definition of MSMEs? </strong> </p>
    
    <p>   Existing MSME Classification: In accordance with the provision of Micro, Small & Medium Enterprises Development (MSMED) 

Act, 2006 the Micro, Small and Medium Enterprises (MSME) are classified in two Classes: a) Manufacturing Enterprises b) Service 

Enterprises. The existing MSME Classification was based on the investment in plant and machinery / equipment for manufacturing / service 

enterprises.
                </p>
                <p>Existing MSME Classification: The limit for investment in plant and machinery / equipment for manufacturing / service enterprises, 

as under:</p>
                <p class="gold_clr"><strong>Criteria: Investment in Plant & Machinery or Equipment </strong></p>
                
                
                <table class="responsive_table mb-3">
                <thead>
                  <tr>
                  
                    <th>Classification </th>
                    <th>Micro </th>
                    <th>Small </th>
                    <th>Medium </th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td data-column="Classification">Mfg. Enterprises </td>
                    <td data-column="Micro">Investment &lt; Rs. 25    lakh</td>
                    <td data-column="Small">Investment &lt; Rs. 5    cr. </td>
                    <td data-column="Medium">Investment &lt; Rs. 10    cr.</td>
                  </tr>
                 
                  <tr>
                    <td data-column="Classification">Services </td>
                    <td data-column="Micro">Investment &lt; Rs. 10    lakh.</td>
                    <td data-column="Small">Investment &lt; Rs. 2    cr. </td>
                    <td data-column="Medium">Investment &lt; Rs. 5    cr. </td>
                  </tr>
                  </tbody>
                </table>
                
                <p class="gold_clr"><strong>Revised MSME Classification</strong> </p>
 <p>As per the Government notification dated 1st June 2020 and 26th June 2020, the new revised MSME Classification will be based on the investment in plant and machinery / 

equipment and Annual Turnover of (Manufacturing and Service enterprises) and the limit for the same is given in the below table.</p>

 <p>In continuation to above notification, the notification dated 26th June, 2020 was issued by Ministry of MSME stating that "Exports of goods 

or services or both, shall be excluded while calculating the turnover of any enterprise whether micro, small or medium, for the purposes of 

classification".</p>

                <p>Revised MSME Classification: Limits for Investment in plant and machinery / equipment for manufacturing / service enterprises, 

and Annual Turnover as under:</p>
                
                <p class="gold_clr"><strong>Composite Criteria: Investment and Annual Turnover</strong> </p>
                
                <table class="responsive_table mb-3">
                <thead>
                  <tr>
                  
                    <th>Classification </th>
                    <th>Micro </th>
                    <th>Small </th>
                    <th>Medium </th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td data-column="Classification">Manufacturing & Services </td>
                    <td data-column="Micro">Investment < Rs. 1 cr. and Turnover < Rs.5 cr. </td>
                    <td data-column="Small">Investment< Rs. 10 cr. and Turnover < Rs.50 cr. </td>
                    <td data-column="Medium">Investment< Rs. 50 cr. and Turnover < Rs.250 cr. </td>
                  </tr>
                 
                
                  </tbody>
                </table>
    	</div>
</section>


<?php include 'include-new/footer.php'; ?>

<script>
$(document).ready(function(){
    // Add minus icon for collapse element which is open by default
    $(".collapse.show").each(function(){
      $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
    });
    // Toggle plus minus icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function(){
      $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");        
    }).on('shown.bs.collapse',function(){
      $('html,body').animate({scrollTop:$(this).offset().top-150});
    }).on('hide.bs.collapse', function(){
      $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
    });


});


</script>
