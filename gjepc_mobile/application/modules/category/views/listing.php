   
          <div class="row productListing">
		  <?php
			if(is_array($catproduct)) {
					foreach($catproduct as $cat){ 			
		  ?>
            <div class="col-xs-12 col-sm-6 col-md-4">
              <div class="rentalProduct">
			  <a href="<?php echo base_url();?>product/view/<?php echo $catname;?>/<?php echo $cat->slug;?>">
				<?php $image = Modules::run("product/productImages",$cat->proId); ?>
                <div class="rentalImg"><?php if(is_array($image)) {
			
				?> <img src="<?php echo image_resizer('',233,213,'crop-to-fit',$image[0]->Name,$cat->regId,'products'); ?>"><?php } ?></div>
                <div class="rentalName"><?php echo $cat->title;?></div>
                <div class="rentalPrice"><i class="fa fa-rupee"></i> <?php echo $cat->price;?> / <?php echo Modules::run("product/priceTimeUnit",$cat->priceTimeUnit);?></div></a>
              </div>
            </div>
		  <?php } } else { echo "<h3>".$catproduct."</h3>"; }?>
          </div>
 