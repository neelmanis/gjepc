<?php 
$pageTitle = "Gem & Jewellery | News - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
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

<section>

	<div class="container mb-5 position-relative">
        <img src="assets/images/inner_banner/news.jpg" class="img-fluid d-block" /> 
        <div class="innerpg_title">
            <div class="d-flex h-100">
                <div class="my-auto"><h1 class="text-center" style="color:#000;"> News</h1></div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid p-0 news_search mb-5">
    	
        <div class="container">
        	<form name="frmsearch" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">                	
			<div class="search_other position-relative">
         		<input type="text" class="form-control" onfocus="if(this.value=='Search here...')value='';" onblur="if(this.value=='')value='Search here...';" name="txtsearch" id="txtsearch" value="Search here..."/>
             	<button type="submit" name="keyword_earch" id="keyword_earch" value="Search" class="fade_anim" /> <i class="fa fa-search" aria-hidden="true"></i></button>  
   			</div>                
        </form>	
        </div>
        
    </div>

	<div class="container">	
				<?php
                if(isset($_REQUEST['txtsearch']) && $_REQUEST['txtsearch']!='Keyword')
                    $_SESSION['txtsearch'] = filter($_REQUEST['txtsearch']);                    
                
                    $page=1;//Default page
                    $limit=5;//Records per page
                    $start=0;//starts displaying records from 0
                    if(isset($_GET['page']) && $_GET['page']!=''){
                    $page=$_GET['page'];                    
                    }
                    $start=($page-1)*$limit;
                    
                if(isset($_SESSION['txtsearch']) && $_SESSION['txtsearch']!='')
                {
                    $sql="SELECT * FROM `news_master` WHERE status='1' and name like '%".$_SESSION['txtsearch']."%' order by post_date desc";
                }else
                {
                    $sql="SELECT * FROM `news_master` WHERE 1 and status=1 order by post_date desc,id desc";
                }
                $result1=$conn ->query($sql);
                $rCount= $result1->num_rows;
                $sql1= $sql."  limit $start, $limit";
                $result=$conn ->query($sql1);
                
                while($rows=$result->fetch_assoc()) {
                ?>
                <div class="mb-5">        
                    	<div class="row align-items-center">
                    	<div class="col-md-4 mb-3" data-aos="fade-right"> <img src="admin/images/news_images/<?php echo $rows['news_pic'];?>" class="img-fluid d-block" style="border:1px solid #ddd;"> </div>
                        <div class="col-md-8 news_short_para" data-aos="fade-left">
                        	<span class="mb-4 d-block" style="width:40px; height:40px;"><img src="assets/images/gold_star.png" class="img-fluid d-block" /></span>
                             <span class="d-block mb-3"><strong><?php echo date("M d, Y",strtotime($rows['post_date']));?></strong></span>
                        	<h2 class="bold_font font_responsive mb-5"> <?php echo filter($rows['name']);?> </h2>                            
                            <a href="news_detail.php?news=<?php echo $rows['slug'];?>" class="news_read_more long_arw">Read More <span></span></a>
                        </div>
                        </div>
                  	
                </div>               
				<?php }	?>
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination justify-content-center ab_none'>";
//$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
//$pagination.= "<li class='dot'>...</li>";
//$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
//$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
//$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
//$pagination.= "<li class='dot'>..</li>";
//$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
//$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
//$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'><i class='fa fa-angle-double-right' aria-hidden='true'></i>
</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
} 

?>	

<div class="row justify-content-between align-items-center pages_1 mb-5">
<div class="col-12 mb-4 mb-md-0 col-md-auto">
<p class="text-center">Total number of News : <strong><?php echo $rCount;?></strong></p>
</div>

<div class="col-12 col-md-auto">
<?php echo pagination($limit,$page,'news.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
</div> 

</div>
</div>

<style>
ul.pagination li {margin: 0 3px; line-height:30px;}
ul.pagination li a {display:block; border:1px solid #ddd; width:30px; height:30px; line-height:30px; text-align:center; border-radius:100px; color:#000;}

ul.pagination li a.current, ul.pagination li a:hover {background:#a89c5d; color:#fff; border:1px solid #a89c5d;}
</style>
</div>
<?php include 'include-new/footer.php'; ?>
