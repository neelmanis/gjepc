<?php 
$pageTitle = "Gem & Jewellery | Seminar - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php';
$sql = "SELECT * FROM `seminar_calendar` where status='1'";
$result = $conn ->query($sql);
$events = array();
while($row =  $result->fetch_assoc())
{
	$id = $row['id'];
	$title = filter($row['title']);
    $start = $row['start'];                              
    $end = $row['end'];
    $date_time = str_replace(array("\r", "\n"), '',$row['date_time']);
    $images = $row['images'];
	$pdf = $row['pdf'];
    $place = str_replace(array("\r", "\n"), '',$row['place']);
    $seminar_theme = $row['seminar_theme'];
    $seminar_objective = $row['seminar_objective'];
	$full_description = str_replace(array("\r", "\n"), '',$row['full_description']);
    $contact_person = str_replace(array("\r", "\n"), '',$row['contact_person']);
    $events[]=array( 'id'=>$id,'title'=>$title, 'start'=>$start, 'end'=>$end,'date_time'=>$date_time,'images'=>$images,'place'=>$place,'seminar_theme'=>$seminar_theme,'seminar_objective'=>$seminar_objective,'contact_person'=>$contact_person,'full_description'=>$full_description,'pdf'=>$pdf);
}
//echo $events[0]['title'].": Start: ".$events[0]['start'].", End: ".$events[0]['end'].", Images: ".$events[0]['images'].", DateTime: ".$events[0]['date_time'].".<br>";
?>

<link href='calendar/css/fullcalendar.css' rel='stylesheet'/>
<style type="text/css">
	/*.inner_container td{background: #fff!important;border-bottom: 1px solid #ccc!important;border-right: 1px solid#ccc!important}*/
	.inner_container tr:nth-of-type(odd) {
    background: #fff;
}
</style>
<section class="py-5">

	 <div class="container">   
	    <div class="row mb">        
            <div class="col-12">
            	<div class="innerpg_title">
                	<h1>GJEPC Awareness Campaign Seminars</h1>
                </div>
            </div>
            
            <div class="col-12">            
            	<div class="d-flex mb-5 py-2" style="background:#dbe9f9;">
            		
                    <div class="col-auto"><p class="blue">Upcoming Seminars :</p></div>
                
                    <marquee direction="left" class="col">	
                    <ul class="reltdLinks inner_under_listing">
                    <?php 
                    $sqlx = "SELECT * FROM `seminar_calendar` WHERE DATE(`end`) >= CURDATE() and status='1' order by end desc";
                    $resultx = $conn ->query($sqlx);
                    $num = $resultx->num_rows;
                    if($num>0){
                    while($rowx = $resultx->fetch_assoc()){ 
						$encrypted_id = base64_encode($rowx['id']); 
					?>
                    <li> <a href="seminar_detail.php?id=<?php echo $encrypted_id;?>" target="_blank"><?php echo $rowx['title']; ?></a> <span><?php echo date("d-m-Y",strtotime($rowx['start'])); ?></span></li>
                    <?php } } else {?> <strong> No Seminar Found </strong> <?php } ?>
                    </ul>
                	</marquee>
              	
                </div>
                
                <div class="row">                
                	<div id="calendar" class="col-centered col-lg-8"> </div>             	
            
                    <div class="col-lg-4">                    
                    	<p class="blue">Post Seminars Updates</p>
                    			
                    <ul class="inner_under_listing post_seminar">
                    <?php		
                    $sqlx = "SELECT * FROM seminar_calendar WHERE status='1' and end <=DATE(NOW())order by end desc limit 4";
                    $resultx =  $conn ->query($sqlx);
                    while($rowx = $resultx->fetch_assoc()){
					$encrypted_id = base64_encode($rowx['id']); ?>
                    <li><a href="past_seminar_detail.php?id=<?php echo $encrypted_id;?>" target="_blank"><?php echo $rowx['title'];?></a><span><?php echo date("d-m-Y",strtotime($rowx['start'])); ?></span></li>
                    <?php } ?>
                    </ul>
                    <?php 
                    $sql1 = "SELECT * FROM seminar_calendar WHERE status='1'";
                    $result1 =  $conn ->query($sql1);
                    $count = $result1->num_rows;
                    if($count >4) { ?>                   
                    <a href="past_seminar.php" class="cta">View More</a>
                    <?php } ?>
                </div>
                    
               	</div>                
            </div>		    
    	</div>        
	</div>    
</section>

<?php include 'include-new/footer_stats.php'; ?>

<!-- FullCalendar -->

<script src='calendar/js/moment.min.js'></script>
<script src='calendar/js/fullcalendar.min.js'></script>

<script>
	$(window).load(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: new Date(),
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			allDay:false,
			select: function(start, end) {			
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				//$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element, view) {
				element.find('.fc-title').html('*'); 
			/*Popup closed
     			element.bind('click', function() {
					$('#ModalEdit #id').val(event.id);
					//$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #title').html(event.title);
					$('#ModalEdit #start').val(event.start);
					$('#ModalEdit #end').val(event.end);
					$('#ModalEdit #date_time').val(event.date_time);
					$('#ModalEdit #images').attr('src','admin/calendar/'+event.images);	
					console.log(event.pdf);
					if(event.pdf==''){
						$('#ModalEdit #pdf').attr('href','#');	
						$('#ModalEdit #pdf').attr('target','_self');	
					}else {
						$('#ModalEdit #pdf').attr('href','admin/calendar/'+event.pdf);
						$('#ModalEdit #pdf').attr('target','_blank');						
					}					
					$('#ModalEdit #place').val(event.place);
					$('#ModalEdit #seminar_theme').val(event.seminar_theme);
					$('#ModalEdit #seminar_objective').val(event.seminar_objective);
					$('#ModalEdit #contact_person').val(event.contact_person);
					$('#ModalEdit #full_description').html(event.full_description);
					
					$('#ModalEdit').modal('show');
				}); */
			},
			eventDrop: function(event, delta, revertFunc) {
				edit(event);
			},
			
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
				edit(event);
			},
			events: [
			<?php foreach($events as $event): 
			
				$start = explode(" ", $event['start']);
				$end = explode(" ", $event['end']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end'];
				}
			?>
				{
					id: '<?php echo $event['id']; ?>',
					title: '<?php echo $event['title']; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					date_time: '<?php echo $event['date_time']; ?>',
					images: '<?php echo $event['images']; ?>',
					place: '<?php echo $event['place']; ?>',
					seminar_theme: '<?php echo $event['seminar_theme']; ?>',
					seminar_objective: '<?php echo $event['seminar_objective']; ?>',
					contact_person: '<?php echo $event['contact_person']; ?>',
					full_description: '<?php echo $event['full_description']; ?>',
					color  : '#f2634d',					
					pdf: '<?php echo $event['pdf']; ?>',
					url: 'seminar_detail.php?id=<?php echo $event['id'];?>',
				},
			<?php endforeach; ?>
			],
			displayEventTime: false, //To delete "12a", add displayEventTime: false.		
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else{
						alert('Could not be saved. try again.'); 
					}
				}
			});
		}					
	});
	</script>