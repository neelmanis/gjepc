<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style>
@font-face {
    font-family: 'avenirregular';
    src: url('font/avenir_roman-webfont.woff2') format('woff2'),
         url('font/avenir_roman-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}
.clear {clear:both;}
</style>
<body>
<div class="main_wrapper" style="width:600px; height:auto; margin:auto; background:#CCC; display:block;overflow:hidden !important;">

  <?php if(is_array($records)){ 
            foreach($records as $val) {  
 /*echo "<pre>";
              print_R($val);
              exit;*/
                 foreach($val as $rec) { 
                   
            
       ?>
<!---->
	<div class="pro_wrapper" style="width:100%; background:#0C9; margin-bottom:0px; position:relative; border:1px solid #999; display:block;">
    
	 <?php 
             $images = $rec[1]['feedimages'];
  
             if(is_Array($images)) {
               
        ?>  
	<div class="profile_pic" style="width=100%;height:200px; overflow:hidden;"><img src="http://digitalagencymumbai.com/lifefeed/uploads/feeds/<?php echo $rec[0]['feeddata']['regId'];?>/images/<?php echo $images[0]->imageName;?>" width="100%"; height="400px";></div>
     <?php  } ?>
    
<!--    <div class="star_rating" style="width:100%; top:0px; left:0px; position:absolute; padding:10px; display:block"><img src="star.png" width=55px;></div>-->
    
 <div class="discription" style="width:100%; bottom:0px; left:0px; background:#37938bad; height:40px; display:block;">
    &nbsp;&nbsp;&nbsp;<span style="font-size:28px; color:#FFF; font-weight:100; font-family: 'avenirregular'; float:left;">Travelling</span><span style="width:200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    <span style="font-size:24px; color:#FFF; font-weight:100;  font-family: 'avenirregular'; text-align:right; ">2016-06-03 &nbsp;1:10PM</span>
    </div>
    
    </div>
    
    <div class="disk_wrapper" style="width:100%; color:#4c4c4c; background:#f1eef0;"><br/>
    
    <div class="text_wrapper">
	<div style="font-size:16px; color:#4c4c4c;font-family:'avenirregular';text-align:center"><?php echo $rec[0]['feeddata']['description'];?></div>
	</div>
 
    
    
    
    <div class="gallery_wrapper">
    <div class="icon_wrapper" style="color:#4c4c4c; height:60px; text-align:center;">
	<img src="http://digitalagencymumbai.com/lifefeed/assets/img/02.png" width=60px;>
	</div><br/>

        <?php 
             $images = $rec[1]['feedimages'];
             $countarr = count($rec[1]['feedimages']);  
            $i = 0;
             if(is_Array($images)) {
                   foreach($images as $val) {
               if($i != 0) {
        ?>  
	<div class="image<?php echo $i;?>" style="width:30%; height:120px; margin-left:2%;float:left; background:#099; overflow:hidden; <?php if($countarr = 2) { ?> text-align:center;margin:0 auto;<?php } ?>"><img style="<?php if($countarr = 2) { ?> text-align:center;<?php } ?>"src="http://digitalagencymumbai.com/lifefeed/uploads/feeds/<?php echo $rec[0]['feeddata']['regId'];?>/images/<?php echo $val->imageName;?>" width=100%;></div>
        <?php }  $i++; } }  ?>
    <div class="clear"></div>
	</div><br/>
   
   <div class="icon_wrapper" style="color:#4c4c4c; height:auto; text-align:center;">
	<img src="http://digitalagencymumbai.com/lifefeed/assets/img/friends.png" width=60px;><br/>
   
	<div style="font-size:16px; color:#4c4c4c;font-family:'avenirregular';text-align:center">
       <?php 
             $contact = $rec[2]['feedcontact']; 
             if(is_Array($contact)) {
               foreach($contact as $con) {
              
        ?>
<?php echo $con->contactName;?><br><?php } } ?></div>
	
   </div><br/>
   
   <div class="icon_wrapper" style="color:#4c4c4c; height:auto; text-align:center;">
	<img src="http://digitalagencymumbai.com/lifefeed/assets/img/pocket.png" width=60px;>
  
	<div style="font-size:16px; color:#4c4c4c;font-family:'avenirregular';text-align:center"><?php echo $rec[0]['feeddata']['amount'];?></div>
	</div><br/><br/>
   
    
   
   
   <div class="icon_wrapper" style="color:#4c4c4c; height:auto; text-align:center;">
	<img src="http://digitalagencymumbai.com/lifefeed/assets/img/location.png" width=60px;>
   
	<div style="font-size:16px; color:#4c4c4c;font-family:'avenirregular';text-align:center"><?php echo $rec[0]['feeddata']['location'];?></div>
	</div><br/><br/>
  
   
   <div class="icon_wrapper" style="color:#4c4c4c; height:auto; text-align:center;">
	<img src="http://digitalagencymumbai.com/lifefeed/assets/img/text.png" width=60px;>
   
	<div style="font-size:16px; color:#4c4c4c;font-family:'avenirregular';text-align:center"><?php echo $rec[0]['feeddata']['note'];?></div>
	</div>
   </div><br/><br/><br/><br/>
    
<!---->    
<?php } } } ?>
  
    
</div>




</body>
</html>
