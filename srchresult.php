<?php 
include 'include/header.php'; 
include 'db.inc.php'; 
?>

<div class="col-md-8 col-sm-12 col-xs-12 wrapper">
	
	<div class="inneContent">
	 	 <div class="title">
	        <h4>Search Result</h4>
	     </div>

			 
<?php
$highlight = true;//highlight results or not
$search_in = array('php');//allowable filetypes to search in
$search_dir = '.';//starting directory
$recursive = false;//should it search recursively or not
$files = list_files($search_dir);

$search_results = array();
foreach($files as $file){ 
	$contents = file_get_contents($file);
	preg_match_all("/\<p\>(.*)".$_GET['s']."(.*)\<\/p\>/i", $contents, $matches, PREG_SET_ORDER);
	foreach($matches as $match){
		//trmiming results to show excerpt
		$match[1] = trim_result($match[1]);
		$match[2] = trim_result($match[2], true);
		//highlighting if needed
		if($highlight == true){
			$match[1] .= '<span style="background: #ffff00;">';
			$match[2] = '</span>'.$match[2];
		}
		preg_match("/\<title\>(.*)\<\/title\>/", $contents, $matches2);
		$search_results[] = array($file, $match[1].$_GET['s'].$match[2], $matches2[1]);
	}
}
?>

<?php 
$num_search_results=count($search_results);
if($num_search_results>0){
foreach($search_results as $result) : ?>

	    <div class="content row">

	    	<div class="col-md-12">
	    	<div class="newslist">
		    	<div class="col-md-12 news_title"><a href="<?php echo $result[0]; ?>"><?php $newFileName = substr(strtoupper($result[0]), 0 , (strrpos(strtoupper($result[0]), "."))); echo $stuff=substr($newFileName,2);?></a></div>
		    	<div class="col-md-12 news_date"><?php echo $result[1];echo "...."; ?></div>
			</div>
			</div>
		</div>

<?php endforeach; ?>
<?php } else {?>
<p>No Result Found.</p>
<?php }?>

<?php
//lists all the files in the directory given (and sub-directories if it is enabled)
function list_files($dir){
	global $recursive, $search_in;

	$result = array();
	if(is_dir($dir)){
		if($dh = opendir($dir)){
			while (($file = readdir($dh)) !== false) {
				if(!($file == '.' || $file == '..')){
					$file = $dir.'/'.$file;
					if(is_dir($file) && $recursive == true && $file != './.' && $file != './..'){
						$result = array_merge($result, list_files($file));
					}
					else if(!is_dir($file)){
						if(in_array(get_file_extension($file), $search_in)){
							$result[] = $file;
						}
					}
				}
			}
		}
	}
	return $result;
}

//returns the extention of a file
function get_file_extension($filename){
	$result = '';
	$parts = explode('.', $filename);
	if(is_array($parts) && count($parts) > 1){
		$result = end($parts);
	}
	return $result;
}

//trims the given string to 15 words max
function trim_result($text, $start = false){
	$words = split(' ', strip_tags($text));
	if($start){
		$words = array_slice($words, 0, 15);
	}
	else{
		$start = count($words) - 15;
		$words = array_slice($words, ($start < 0 ? 0 : $start), 15);
	}
	return implode(' ', $words);
}

?>   

    
</div>

</div>

<div class="col-md-4 col-sm-12 col-xs-12">

	<?php include 'include/newsletter.php';?>

</div>


<div class="col-md-12 col-sm-12 col-xs-12">

	<div class="row mainRow">
		<div class="col-md-12">
			<div class="upcomingEvents">
		        <div class="title">
		          <h4>Upcoming Events</h4>
		        </div>
		        <?php include 'include/eventsslider.php'; ?>
	      </div>
		</div>
	</div>	
</div>

<style type="text/css">
	
	.newslist{
		float: left;
    background: #fff;
    padding: 15px 0px;
    margin-bottom: 10px;
	}

	.newslist .news_title{
		font-size: 22px;
		margin-bottom: 10px;
	}

</style>

<?php include 'include/footer.php'; ?>