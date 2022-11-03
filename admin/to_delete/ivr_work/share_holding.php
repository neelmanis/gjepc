<?php
/* Template Name: Share Holding */ 

get_header('financial_result'); ?>

<?php
function get_breadcrumb() {
	global $post;
	$trail = '';
	$page_title = get_the_title($post->ID);
	if($post->post_parent) {
		$parent_id = $post->post_parent;
 
		while ($parent_id) {
			$page = get_page($parent_id);
			$breadcrumbs[] ='<span>'.get_the_title($page->ID) . '</span>&nbsp;&nbsp;&gt;&nbsp;&nbsp;';
			$parent_id = $page->post_parent;
		}
		$breadcrumbs = array_reverse($breadcrumbs);
		foreach($breadcrumbs as $crumb) $trail .= $crumb;
	}
 
	$trail .= $page_title;
	$trail .= '';
 
	return $trail;	
	}
?>
<!-- ----------------------------- banner starts ------------------------- -->
<div class="inner_banner">
<?php	
while ( have_posts() ) : the_post();
if ( has_post_thumbnail() && ! post_password_required() ) : 
the_post_thumbnail('full'); 
endif;
$postid = get_the_ID();
$parent=$post->post_parent;
endwhile;
?>
</div>
<!-- ----------------------------- banner ends ------------------------- -->

<!-- ----------------------------- container starts ------------------------- -->
<div class="container_wrap">
<div class="breadcum">
<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> ><?php echo get_breadcrumb();?></div>
   
   <div class="clear"></div>
   
    <div class="spacer">
      <div class="inner"><h3><?php	$title=the_title(); ?></h3></div>
    </div>
    
<div class="inner_content fade_anim">        
<div class="content_left">
            
            <div class="filter sorter">
			<?php
			$subcategories = get_categories('&child_of=25&hide_empty&order=desc'); 
			?>
			<select class="filters-select form-control">
			  <option value="*">Show All</option>
			<?php
			foreach ($subcategories as $subcategory) {?>
			  <option value=".<?php echo $subcategory->slug;?>"><?php echo $subcategory->name;?></option>
			<?php }?>
			</select>
            </div>
			
			<ul id="masonry-list">
			
			<?php		/* Year 2016 */	
			$catName1=get_cat_name(29);
			$postArray = array(
				'posts_per_page'   => 1000,
				//'category_name'    => $catName1,
				'cat' => 29,
				'orderby'          => 'date',
				'order'            => 'DESC',
			);
			$posts_array = get_posts($postArray);?>
			<li class="financial_result item share-2016">
					<div class="sub_head">Year 2016</div>
                    <div class="results">
			<?php if(is_Array($posts_array)){	
				foreach($posts_array as $news){
					$catName1 = get_the_category($news->ID);
					
				if(is_Array($catName1))
				{
				$categoryName = $catName1[0]->slug;
				}	
			?>	
                  <div class="result_box">
                      <div class="result_name"><?php echo $news->post_title;?></div>
                        <div class="result_pdf">
                          	<a href="<?php echo $news->post_content;?>" target="_blank" ><img src="<?php bloginfo('template_url')?>/images/download.png" class="center-block"><span>Download</span></a>
                        </div>						
				  </div>
							<?php  } } else { ?><h3>No Reports Found!!</h3>	
						<?php } ?>	                          
                    </div>				
            </li>
			
			<?php		/* Year 2015 */		
			$catName1=get_cat_name(28);
			$postArray = array(
				'posts_per_page'   => 1000,
				//'category_name'    => $catName1,
				'cat' => 28,
				'orderby'          => 'date',
				'order'            => 'DESC',
			);
			$posts_array = get_posts($postArray);?>
			<li class="financial_result item share-2015">
					<div class="sub_head">Year 2015</div>
					<?php //echo '<<--'.$categoryName;?>
                    <div class="results">
					<?php if(is_Array($posts_array)){	
				foreach($posts_array as $news){
					$catName1 = get_the_category($news->ID);
					
				if(is_Array($catName1))
				{
				$categoryName = $catName1[0]->slug;
				}	
			?>	
                    <div class="result_box">
                       <div class="result_name"><?php echo $news->post_title;?></div>
                       <div class="result_pdf">
                          	<a href="<?php echo $news->post_content;?>" target="_blank" ><img src="<?php bloginfo('template_url')?>/images/download.png" class="center-block"><span>Download</span></a>
                       </div>
                   </div>  
					<?php  } } else { ?><h3>No Reports Found!!</h3>	
						<?php } ?>							
                    </div>                
            </li>
			
			<?php		/* Year 2014 */		
			$catName1=get_cat_name(27);
			$postArray = array(
				'posts_per_page'   => 1000,
				//'category_name'    => $catName1,
				'cat' => 27,
				'orderby'          => 'date',
				'order'            => 'DESC',
			);
			$posts_array = get_posts($postArray);?>
			<li class="financial_result item share-2014">
					<div class="sub_head"><?php echo $catName1;?></div>
                    <div class="results">
					<?php if(is_Array($posts_array)){	
				foreach($posts_array as $news){
					$catName1 = get_the_category($news->ID);
					
				if(is_Array($catName1))
				{
				$categoryName = $catName1[0]->slug;
				}	
			  ?>	
                  <div class="result_box">
                     <div class="result_name"><?php echo $news->post_title;?></div>
                         <div class="result_pdf">
                         	<a href="<?php echo $news->post_content;?>" target="_blank" ><img src="<?php bloginfo('template_url')?>/images/download.png" class="center-block"><span>Download</span></a>
                         </div>
                  </div>  
					<?php  } } else { ?><h3>No Reports Found!!</h3>	
						<?php } ?>							
                    </div>                
            </li>
			
			<?php		/* Year 2013 */	
			$catName1=get_cat_name(26);
			$postArray = array(
				'posts_per_page'   => 1000,
			//	'category_name'    => $catName1,
				'cat' => 26,
				'orderby'          => 'date',
				'order'            => 'DESC',
			);
			$posts_array = get_posts($postArray); //echo '<pre>'; print_r($posts_array); exit;?>
			<li class="financial_result item share-2013">
					<div class="sub_head">Year 2013</div>
                    <div class="results">
			<?php if(is_Array($posts_array)){	
				foreach($posts_array as $news){
					$catName1 = get_the_category($news->ID);
					
				if(is_Array($catName1))
				{
				$categoryName = $catName1[0]->slug;
				}	
			?>	
                  <div class="result_box">
                      <div class="result_name"><?php echo $news->post_title;?></div>
                        <div class="result_pdf">
                          	<a href="<?php echo $news->post_content;?>" target="_blank" ><img src="<?php bloginfo('template_url')?>/images/download.png" class="center-block"><span>Download</span></a>
                        </div>						
				  </div>
							<?php  } } else { ?><h3>No Reports Found!!</h3>	
						<?php } ?>	                          
                    </div>				
            </li>
			
            </ul>
</div>            
<div class="related_links">
<div class="head">INVESTORS</div>          
<ul>
     <li><a href="<?php bloginfo('url'); ?>/investors/financial/annual-reports/">Financial</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/investors-grievance/">Investor's Grievance</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/company-policies/">Company Policies</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/share-holding-pattern/">Share Holding Pattern</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/postal-ballot/">Postal Ballot</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/board-notice/">Board Notice</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/iepf/">IEPF</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/press-release/">Press Release</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investor-presentation/">Investor Presentation</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/general-meeting-voting-results/">General Meeting Voting Results</a></li>
	 <li><a href="<?php bloginfo('url'); ?>/investors/subsidiary-company/">Subsidiary Company</a></li>
     <li><a href="<?php bloginfo('url'); ?>/investors/placement-documents/">Placement Document</a></li>
     </ul>           
</div>        
        <div class="clear"></div>
      
</div>
</div>
<!-- ----------------------------- container ends ------------------------- -->

<?php
get_footer();
