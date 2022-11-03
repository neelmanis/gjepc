     <div class="bannerArea">
    <div class="slider"> <img src="<?php base_url();?>assets/images/slide/1.jpg" class="placeholder"/><?php if(is_array($banner)) { 
			foreach($banner as $val) {
		?>
		<img src="<?php base_url();?>uploads/gallery/<?php echo $val->imgPath;?>"/>
		<?php } } ?>	</div>
    <div class="searchArea">
      <div>
        <div class="searchContent">
          <h2>Real Rentals, Real People</h2>
          <form>
            <div class="row">
              <div class="col-xs-4">
                <div class="customSelect">
                  <select>
                    <option>Mumbai</option>
                    <option>Pune</option>
                    <option>Nashik</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-8">
                <div class="customSearch">
                  <input type="text" placeholder="Search..." class="form-control">
                  <button class="btn">Search</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<section class="text-center works">
    <div class="container">
        <h2>How it works</h2>
        <div class="row">
            <div class="carousel">
                <ul id="works">
                    <li>
                        <div class="worksBlock"> <strong></strong> <i><img src="<?php echo base_url('assets/images/works/1.png') ?>"></i>
                            <p>Choose Amongst quality tested Products</p>
                        </div>
                    </li>
                    <li>
                        <div class="worksBlock"> <strong></strong> <i><img src="<?php echo base_url('assets/images/works/2.png') ?>"></i>
                            <p>Select the tenure for rental</p>
                        </div>
                    </li>
                    <li>
                        <div class="worksBlock"> <strong></strong> <i><img src="<?php echo base_url('assets/images/works/3.png') ?>"></i>
                            <p>Get them delivered & picked up from your doorsteps</p>
                        </div>
                    </li>
                    <li>
                        <div class="worksBlock"> <strong></strong> <i><img src="<?php echo base_url('assets/images/works/4.png') ?>"></i>
                            <p>Security deposit refund within 24 hours</p>
                        </div>
                    </li>
                    <li>
                        <div class="worksBlock"> <strong></strong> <i><img src="<?php echo base_url('assets/images/works/4.png') ?>"></i>
                            <p>Security deposit refund within 24 hours</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php $categories = Modules::run('category/_getWhere', array('isActive'=>'1','parentId'=>'1','showThumb'=>'1'))?>
<?php if(sizeof($categories)) { ?>
    <section class="text-center categories">
    <h2>Categories</h2>
    <div class="point">
        <?php foreach($categories as $category): $imgName = $category->thumb; $slug = $category->slug ?>
        <article class="pointPan">
            <img src='<?php echo base_url("uploads/category/tiles/$imgName") ?>' />
            <div class="pointPanCont">
                <div class="ppcIn">
                    <div class="content">
                        <div>
                            <h3><?php echo $category->name ?></h3>
                            <p><?php echo $category->description ?></p>
                            <a href="<?php echo base_url("category/view/$slug")?>">View More</a></div>
                    </div>
                </div>
            </div>
            <div class="overlay">
                <div class="content">
                    <div>
                        <h3><?php echo $category->name ?></h3>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach ?>
    </div>
</section>
<?php } ?>

