<?php 
include 'include/header.php'; 
include 'db.inc.php'; 
include('functions.php');
if(!isset($_SESSION['USERID'])){header('location:login.php'); exit; }
$registration_id=$_SESSION['USERID'];
?>

<?php
if(isset($_REQUEST['keyword_earch']))
{   $_SESSION['checkbox']="";
	$keyword=$_REQUEST['keyword'];
	if($keyword=="Keyword")
	{
		$_SESSION['error_msg']="<div class='alert alert-danger' role='alert'>Please enter keyword for which you are searching</div>";
	}
}
?>

<section>

	<div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>
        
        <ul class="d-flex breadcrumb">
    		<li><a href="index.php">Home</a></li>
            <li>Members</li>
            <li>Members Information</li>
    		<li class="active">Members Directory</li>
  		</ul>
        
    </div>

    <div class="container inner_container">
        
        <div class="row">
        
            <div class="col-12">
                <div class="innerpg_title">
                    <h1>Members Directory</h1>
                </div>
            </div>
            
            <?php 
            if($_SESSION['error_msg']!=""){
            echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
            $_SESSION['error_msg']="";
            }
            if($_SESSION['error_msg']!=""){
            echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
            $_SESSION['error_msg']="";
            }
            if($_SESSION['error_msg']!=""){
            echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
            $_SESSION['error_msg']="";
            }
            ?>
            
            <div class="col-12">
                
                <form action="" method="post">
                    
                    <div class="search_other">
                        <input type="text" onfocus="if(this.value=='Keyword')value='';" onblur="if(this.value=='')value='Keyword';" value="Keyword" name="keyword" id="keyword" class="form-control">
                        <button type="submit" name="keyword_earch" id="keyword_earch" value="Search" >  <i class="fa fa-search" aria-hidden="true"></i>
 </button>
                    </div>
                        
                </form>
                    
                <p class="blue">Directory Search</p>
    <?php 
        $_SESSION['checkbox']="";
        $page_name="members_directory.php?action=view";
        @$start=$_GET['start'];
        if(strlen($start) > 0 and !is_numeric($start)){
        echo "Data Error";
        exit;
        }
        $eu = ($start - 0);
        $limit = 50;
        $this1 = $eu + $limit;
        $back = $start - 1;
        $next = $start + 1;
       $sql_search=$schk_membership="SELECT a.company_name,a.city,b.registration_id FROM registration_master a, `approval_master` b WHERE 1  and (b.`membership_issued_certificate_dt` between '2019-04-01' and '2020-03-31' || (b.`membership_renewal_dt` between '2019-04-01' and '2020-03-31')) and a.id=b.registration_id";
      
      if(@$keyword!="")
      {
        $sql_search.=" and ( a.company_name like '%$keyword%' or a.city like '%$keyword%' )";
      }	
    
    $sql_search.=" order by  a.company_name ASC";
    $query_search=mysql_query($sql_search);
    $rCount=0;
    $rCount = @mysql_num_rows($query_search);	
    $sql_search=$sql_search." limit $eu, $limit ";
    $query_search=mysql_query($sql_search);
    ?>
    <?php  
    if($rCount>0){
    while($result_search=mysql_fetch_array($query_search)){?>
    				<div class="row">
                    <ul class="col-sm-6 search_result">
                        <li>
                            <div class="d-flex"><div class="company"><strong>Company</strong></div> <?php echo strtoupper($result_search['company_name']);?></div>
                            <?php $registerid = $result_search['registration_id'] ;
                                  $query = fetch("select city from registration_master where id='$registerid'") ; ?>
                            <div class="d-flex"><div class="company"><strong>City </strong> </div> <?php echo strtoupper($query[0]['city']);?></div>
                        </li>           
                    </ul>
                    
      <?php }} else {?>
    <div class="padding_width">No Records Found.</div>
    <?php }?>              
     
    <div>Number of search result : <?php echo $rCount;?>   </div>
    
    <ul class="pagination">       
    <?php 
        if($rCount>$limit)
        {
        if($back >=0) {
        echo "<li class='prev'><a href='$page_name&start=$back'>&lt;</a></li>";
        }
        echo "<li class='number_1'>";
        $min = max($start - 5, 1); 
        $max = min($start + 5, $rCount); 
        for($i = $min; $i <= $max; ++$i) {
            if($i == $start) {
                echo "<a href='#' class='active'>{$i}</a>";
            } 
            else {
                echo "<a href='$page_name&start={$i}'>{$i}</a>";
            }
        }
            
        echo "</li>";
        if($this1 < $rCount) {
        echo "<li class='next'><a href='$page_name&start=$next'>&gt;</a></li>";}
        }  
    ?>
    <!-- <div class="next"><a href="#">&gt;</a></div> -->
    <div class="clear"></div>
    </ul>
                    <!--<div class="pagination">
                        <div class="prev"><a href="#">&lt;</a></div>
                        <a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a>
                        <div class="next"><a href="#">&gt;</a></div>
                        <div class="clear"></div>
                     </div>	-->
                    
                 </div> 
            
            </div>	
   	
    </div>
        
    <div class="container mb"> 
		<?php /*?><?php include 'include/logo_ticker.php'; ?><?php */?>
	</div>
    
    <div class="container mb">
    	<?php include 'include/inner_videos.php'; ?>
    </div>

</section>






<?php include 'include/footer.php'; ?>