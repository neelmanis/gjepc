<?php 
$pageTitle = "Jewellery Digital platform | IIJS Virtual Sparks A Digital Revolution - GJEPC India";
$pageDescription  = "If you build it, they will come,” goes the famous line from the classic movie Field of Dreams (1989). But unlike a baseball stadium, simply developing a state-of-the-art virtual trade show platform was no guarantee that visitors would arrive.";
?>
<?php 
include 'db.inc.php'; 
//include 'include-new/header.php';
include 'include-new/headernews.php';
?>
<link href="css/jquery-social-share-bar.css" rel="stylesheet" type="text/css">
<?php
$slug = filter($_REQUEST['news']);
$sql= "select * from `news_master` WHERE 1 and status='1' and slug=?";
$stmt = $conn -> prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_assoc();
?>

<section class="py-5">
	<div class="container">
        <div class="news_detail">  
        	
            <div class="d-flex py-3 justify-content-between ab_none align-items-center mb-5" style="border-bottom:1px solid #ddd; border-top:1px solid #ddd">
                <div> <p> <strong> <?php echo date("M d, Y",strtotime($rows['post_date']));?> </strong> </p> </div>
                <div> <div id="share-bar"></div>  </div>
    		</div>   
            
            <div class="row justify-content-between align-items-center ab_none">            
                <div class="col-md-5 mb-5 order-md-12">
                    <div class="poster">
                        <img src="../admin/images/news_images/<?php echo $rows['news_pic']; ?>" class="img-fluid d-block">
                    </div>
                </div>          	
                <div class="col-md-7"> 
                    <img src="assets/images/gold_star.png" class="img-fluid d-block mb-4" />  
					<h2 class="mb-4 bold_font"><?php echo trim($rows['name']);?></h2>    
                </div>            
            </div>
          
          	<div class="row mb-5">        
             	<div class="col-12 text-justify news_detail_box" > <?php echo trim($rows['long_desc']);?></div>          
            </div> 
            <?php
           $newsId = $rows['id'];
            $prevSql = "select * from news_master where id = (select max(id) from news_master where id < $newsId limit 1) limit 1";
            $prevResult =$conn->query($prevSql);
            $isExistPrev =$prevResult->num_rows;
            if($isExistPrev>0){
			$prevRow = $prevResult->fetch_assoc();
            $prevId = $prevRow['slug'];
            $prevUrl = "news_detail.php?news=".$prevId;
            } else {
              $prevUrl = "#";              
            }
                      
            $nextSql = "select * from news_master where id = (select min(id) from news_master where id > $newsId limit 1) limit 1";
            $nextResult =$conn->query($nextSql);
            $isExistnext =$nextResult->num_rows;
            if($isExistnext>0){ 
            $nextRow = $nextResult->fetch_assoc();
            $nextId = $nextRow['slug'];
            $nextUrl = "news_detail.php?news=".$nextId;
            } else {
              $nextUrl = "#";
            }   ?> 
             <div class="d-flex ">
                <div class="mr-3"><a href="<?php echo $prevUrl;?>" class="gold_btn">Prev</a></div>
                <div><a href="<?php echo $nextUrl;?>" class="gold_btn">Next</a></div>
            </div>             
		</div>       
    </div>     
</section>

<?php include 'include-new/footer.php'; ?>

<script src="js/jquery-social-share-bar.js"></script>
<script>
$('#share-bar').share({popupWidth: 1800});
</script>

<style>
.news_detail li {margin:0 0 10px 0;}
</style>
<script type="text/javascript">
$(document).ready(function() {
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

$(document).on("click",'.whatsapp',function() {
if(isMobile.any()) {

        var text = $(this).attr("data-text");
        var url = $(this).attr("data-link");
        var message = encodeURIComponent(text)+" - "+encodeURIComponent(url);
        var whatsapp_url = "whatsapp://send?text="+message;
        window.location.href= whatsapp_url;
} else {
    alert("Please share this News in mobile device");
}
});
});
</script>