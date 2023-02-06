<?php 
$pageTitle = "Gem & Jewellery | Tree plantation appeal to the IIJS family - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php include 'include-new/header.php'; ?>
<?php 
if(isset($_REQUEST['no_of_trees'])){
 $no_of_trees = $_REQUEST['no_of_trees'];
}else{
   $no_of_trees = "50"; 
}

?>

<style>
    h2.title {margin-bottom: 15px; font-size: 20px;}
    p {font-size: 16px; margin-bottom: 20px;}
    </style>

<section>

    <div class="container mb-4">
        <img src="https://registration.gjepc.org/images/ONE-EARTH-Banner-400.jpg" class="img-fluid" alt="">
    </div>

    <div class="container mb-5">
        <h2 class="title">The Global Phenomenon</h2>
        
        <p>In 2021 Global CO2 emissions grew 4.8%, reaching 34.9 billion tonnes of CO2. The increase in carbon emission only added to the climatic change, causing extreme weather conditions like tropical storms, wildfires, severe droughts, and heat waves, negatively affecting crop production and causing disruption to the natural habitats. The time has come to do our bit to reduce carbon footprints to make the world a better inhabitable place. </p>

        <h2 class="title">GJEPC's Role in Preserving Mother Earth</h2>
        <p>GJEPC is committed to contributing to Mother Earth while creating a conducive ecosystem for our valued gem and jewellery members. We are introducing the <strong> "ONE EARTH"</strong> initiative to treasure Planet Earth, in association with <strong> SankalpTaru Foundation.</strong> As a part of our initiative, we aim to preserve nature, plant more trees and generate income for our nation's farmers.</p>
        <h2 class="title">Appeal to all IIJS SIGNATURE 2023; EXHIBITORS</h2>
        <p>GJEPC is donating 2 trees per stall as a part of shared responsibility in contributing towards the <strong>ONE EARTH</strong>  initiative. At just <strong>Rs. 155/- per tree,</strong>  you can contribute to planting more and more trees, and the proceeds would go to <strong>SankalpTaru Foundation.</strong> They will, in turn, utilize the fund to generate income for a <strong>farmer,</strong> enabling him to earn approximately <strong>Rs. 10,000/-</strong> in <strong>20 years.</strong> The tree plantation drive will be instrumental in securing the future of our country's millions of farmers.  </p>
        <p>Therefore, let us come together to play our part in this noble project. We urge you to contribute at least 1% of the booth cost or more, towards the cause and support the initiative to take shape. </p>

        <p>All contributors are eligible to receive an <strong>80G certificate.</strong></p>
        <p>Join us in this initiative to collectively engage in nurturing <strong> ONE EARTH.</strong> </p>

        <a href="https://sankalptaru.org/brand-promotions/one-earth-initiative/?tree_count=<?php echo $no_of_trees; ?>#loaded" target="_blank" class="cta d-table">I agree to plant a tree</a>
    </div>
        
</section>

<?php include 'include-new/footer.php'; ?>
