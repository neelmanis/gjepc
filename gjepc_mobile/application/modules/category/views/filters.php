<div class="catagoryFilters">
    <?php if(isset($subcategories)){ ?>
    <div class="widget"> <strong class="title">Categories</strong>
        <ul class="listing">
            <?php foreach($subcategories as $subcategory): ?>
            <li><a href="<?php echo base_url()."product/search/".$catname."/".$subcategory->slug?>"><?php echo $subcategory->name ?>
			</a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php } ?>
	
	<?php if(is_array($pricefilter) && sizeof($pricefilter)){ ?>
    <div class="widget"> <strong class="title">Price Range</strong>
        <ul class="listing">
				<?php foreach($pricefilter as $price){	?>
         <li><?php echo $price;?></li>
			<?php } ?>
		</ul>
    </div>
	<?php } ?>
</div>