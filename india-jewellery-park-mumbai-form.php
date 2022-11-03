<?php 
$pageTitle = "Gems And Jewellery Industry In India | India jewellery Park Mumbai - GJEPC India";
$pageDescription  = "";
?>
<?php include 'include-new/header.php'; ?>

<style>
.live_update {border:1px solid #a59459; padding:20px; box-shadow:0 5px 10px 0 rgba(0,0,0,.12);}
.live_update h2 {color:#a89c5d; font-size:20px;}
/*.live_update .inner_under_listing li {margin-bottom:20px; font-size:15px;}
.live_update .inner_under_listing li:last-child {margin:0;}
.live_update .inner_under_listing li:before {background:url(../assets/../images/icon/gold_star.png) no-repeat center; background-size:cover;}*/
.swasthya_know_more a {color: #a59459; font-weight: 500;}
</style>


<section class="py-5">       
 
    <div class="container">

        <div class=" bold_font text-center d-block"> <div class="d-block"><img src="assets/images/gold_star.png"></div> Expression of Interest Form for Booking of Units </div> 

        <form class="box-shadow">

            <div class="row"> 

                <div class="form-group col-12 mb-4">
                    <p class="blue">Company Details</p>
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="company_name" class="tr" key="company_type">Ownership Detail</label>
                    <div class="row mx-auto">
                        <div class="col-auto form-check">
                            <input class="form-check-input" type="radio" name="Ownership Detail" id="Propritory" value="Propritory">
                            <label class="form-check-label" for="Propritory">
                            Propritory
                            </label>
                        </div>
                        <div class="col-auto form-check">
                            <input class="form-check-input" type="radio" name="Ownership Detail" id="Partnership" value="Partnership">
                            <label class="form-check-label" for="Partnership">
                            Partnership
                            </label>
                        </div>

                        <div class="col-auto form-check">
                            <input class="form-check-input" type="radio" name="Ownership Detail" id="PrivateLtd" value="PrivateLtd">
                            <label class="form-check-label" for="PrivateLtd">
                            Private Ltd.
                            </label>
                        </div>

                        <div class="col-auto form-check">
                            <input class="form-check-input" type="radio" name="Ownership Detail" id="PublicLtd" value="PublicLtd">
                            <label class="form-check-label" for="PublicLtd">
                            Public Ltd.
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">Company Name</label>
                   <input type="text" class="form-control">
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">Email ID</label>
                   <input type="text" class="form-control">
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">Address Line 1</label>
                   <input type="text" class="form-control">
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">Address Line 2</label>
                   <input type="text" class="form-control">
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">City</label>
                   <input type="text" class="form-control">
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">State</label>
                   <input type="text" class="form-control">
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">Pincode</label>
                   <input type="text" class="form-control">
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">Country</label>
                   <input type="text" class="form-control">
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">Contact No</label>
                   <input type="text" class="form-control">
                </div> 
                
                <div class="form-group col-sm-6 col-md-4">
                    <label for="">GJEPC Member</label>
                    <div class="row mx-0">
                        <div class="col-auto form-check">
                            <input class="form-check-input" type="radio" name="GJEPC Member" id="GJEPCMemberYes" value="GJEPCMemberYes">
                            <label class="form-check-label" for="GJEPCMemberYes">Yes </label>
                        </div>
                        <div class="col-auto form-check">
                            <input class="form-check-input" type="radio" name="GJEPC Member" id="GJEPCMemberNo" value="GJEPCMemberNo">
                            <label class="form-check-label" for="GJEPCMemberNo">No</label>
                        </div>
                    </div>
                </div> 

                <div class="form-group col-sm-6 col-md-4">
                    <label for="">GJEPC Member ID</label>
                    <input type="text" class="form-control">
                </div> 
                
            </div> 

            <div class="row"> 

                <div class="form-group col-12 mb-4">
                    <p class="blue">Interested in purchasing</p>
                </div>

                <div class="form-group col-12">
                    <table class="responsive_table text-center">
                        <thead>
                            <tr class="gold_clr">
                                <th class="text-left text-md-center"><strong> Tick </strong></th>
                                <th class="text-left text-md-center"><strong> Type </strong></th>
                                <th class="text-left text-md-center"><strong> Sizes </strong></th>
                                <th class="text-left text-md-center"><strong> No. of Units </strong></th>
                                <th class="text-left text-md-center"><strong> Booking Amount </strong></th>
                            </tr>
                            <tbody>
                                <tr>
                                    <td class="text-left text-md-center" data-column="Tick"><input type="checkbox" name=""></td>
                                    <td class="text-left text-md-center" data-column="Type">Large Unit</td>
                                    <td class="text-left text-md-center" data-column="Sizes">
                                      <select id="inputState" class="form-control">
                                        <option selected>Select Size</option>
                                        <option>5000 sq. ft & above </option>
                                        <option>601 to 5000 sq. ft.</option>
                                        <option>0 to 600 sq. ft.</option>
                                      </select> 
                                    </td>
                                    <td class="text-left text-md-center"data-column="No. of Units"> <input type="number" placeholder="No. of Units"  min="0" class="form-control"></td>
                                    <td class="text-left text-md-center" data-column="Booking Amount">Rs. 1,00,001/- </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left text-md-center" data-column="Tick"><input type="checkbox" name=""></td>
                                    <td class="text-left text-md-center" data-column="Type">Medium Unit</td>
                                    <td class="text-left text-md-center" data-column="Sizes">
                                      <select id="inputState" class="form-control">
                                        <option selected>Select Size</option>
                                        <option>5000 sq. ft & above </option>
                                        <option>601 to 5000 sq. ft.</option>
                                        <option>0 to 600 sq. ft.</option>
                                      </select> 
                                    </td>
                                    <td class="text-left text-md-center" data-column="No. of Units" class="w-auto"> <input type="number" placeholder="No. of Units"  min="0" class="form-control"></td>
                                    <td class="text-left text-md-center" data-column="Booking Amount">Rs. 1,00,001/- </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left text-md-center" data-column="Tick"><input type="checkbox" name=""></td>
                                    <td class="text-left text-md-center" data-column="Type">Small Unit </td>
                                    <td class="text-left text-md-center" data-column="Sizes">
                                      <select id="inputState" class="form-control">
                                        <option selected>Select Size</option>
                                        <option>5000 sq. ft & above </option>
                                        <option>601 to 5000 sq. ft.</option>
                                        <option>0 to 600 sq. ft.</option>
                                      </select> 
                                    </td>
                                    <td class="text-left text-md-center" data-column="No. of Units" class="w-auto"> <input type="number" placeholder="No. of Units"  min="0" class="form-control"></td>
                                    <td class="text-left text-md-center" data-column="Booking Amount">Rs. 1,00,001/- </td>
                                </tr>
                            </tbody>
                        </thead>
                    </table>

                </div>

            </div>

            <div class="row justify-content-center align-items-center mt-4">
                <div class="col-md-auto text-center mb-4 mb-md-0">
                    <strong>
                        Total Booking Amount <span class="gold_txt" style="font-size:22px"> Rs. 1,00,001/- </span></strong> <span class="d-block" style="font-size:12px">*Refundable without any interest</span>
                </div>
                <div class="col-md-auto">
                    <button class="cta fade_anim d-table mx-auto">Click here for Payment</button>     
                </div>
            </div>                        
            
                                    
                        
        </form>            
            
    </div>  

</section>



<?php include 'include-new/footer.php'; ?>



