<?php 


//echo "<pre>"; print_r($prod_list);


?>

<!--<form class="container-fluid FlowupLabels">
            <div class="form-group fl_wrap pull-right searchProduct">     
                  <label class="fl_label" for="searchProducts">Search Products</label>
                  <input type="text" class="form-control fl_input" id="searchProducts">  
                  <input type="button" value="Search" class="btn searchBtn">   
            </div>
</form>-->
          <table class="rwd-table" id="dataTables">
          <thead>
            <tr>
              <th></th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>From</th>
              <th>To</th>
              <th>Deposit</th>
			  <th>Admin Approval</th>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($prod_list)) 
			{
				foreach($prod_list as $prod) 
				{ 
					 $productImage=$this->mdl_dashboard->get_product_image($prod->proId);
					if(!empty($productImage))
					{
						foreach($productImage as $img)
						{
							$image=$img->Name;
						}						
						//echo $image."<br/>";
						$pic = image_resizer('',89,100,$croptofit='crop-to-fit',$image,$info[0]->regId,'products');
						
					}
					//----------------------------------------------------------------------
					if($prod->priceTimeUnit == "D"){
						$timeUnit= "Day";
					} else if($prod->priceTimeUnit == "W"){
						$timeUnit= "Week";
					} else if($prod->priceTimeUnit == "M"){
						$timeUnit= "Month";
					} else {
						$timeUnit= "Year";
					}
					//---------------------------------------------------------------------------
					if($prod->status == "P"){
						$status= "Pending";
					} else if($prod->status == "A"){
						$status= "Approved";
					}  else {
						$status= "Disapproved";
					}
					
					
					
				
				?>
            <tr>
              <td data-th="Edit / Delete" class="editDelete"><a href="<?php echo base_url() ?>product/productEdit/<?php echo base64_encode($prod->proId) ?>">Edit</a><a href="" class="delProduct" id="<?php echo $prod->proId; ?>">Delete</a></td>
              <td data-th="Product Name"><a href="#">
                <div class="imgList"><img src="<?php echo $pic ?>"></div>
                <div class="nameList"><?php echo $prod->title ?></div>
                </a></td>
              <td data-th="Quantity"><?php echo $prod->qty ?></td>
              <td data-th="Price"><i class="fa fa-inr"></i> <?php echo $prod->price ?>/<?php echo $timeUnit ?></td>
              <td data-th="From"><?php echo date('d-m-Y',strtotime($prod->rentFrom)) ?></td>
              <td data-th="To"><?php echo date('d-m-Y',strtotime($prod->rentTo)) ?></td>
              <td data-th="Deposit"><i class="fa fa-inr"></i> <?php echo $prod->deposit; ?></td>
			  <td data-th="Status"><?php echo $status; ?></td>
            </tr>
				<?php }//foreach
			} //if 
			 ?>				
           
            </tbody>
          </table>
        <!--  <div class="pagination text-right"><a href="#"><i class="fa fa-chevron-left"></i></a><a href="#" class="active">1</a><a href="#">2</a><a>...</a><a href="#">6</a><a href="#"><i class="fa fa-chevron-right"></i></a></div> -->
        
      
	  
	  