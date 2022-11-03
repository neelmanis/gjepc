<?php 
$pageTitle = "Gems And Jewellery Industry In India";
$pageDescription  = "The Gem & Jewellery Export Promotion Council (GJEPC) was set up by the Ministry of Commerce, Government of India (GoI) in 1966. It was one of several Export Promotion Councils (EPCs) launched by the Indian Government";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
ini_set('max_execution_time', 900);
?>
<?php
//error_reporting(0);
if(!isset($_GET['s'])) {
	die('You must define a search term!');
}

$highlight = true;//highlight results or not
$search_in = array('php');//allowable filetypes to search in
$search_dir = '.';//starting directory
$recursive = false;//should it search recursively or not

$files = list_files($search_dir);
$search_results = array(); //echo '<pre>'; print_r($files); exit;
foreach($files as $file){  


	 $contents = file_get_contents($file); 
	
	//preg_match_all("/\<p\>(.*)".$_GET['s']."(.*)\<\/p\>/i", $contents, $matches, PREG_SET_ORDER);
	//preg_match_all("|<h[^>]+>(.*)".$_GET['s']."(.*)\</h[^>]+>|iU", $contents, $matches, PREG_SET_ORDER);
	preg_match_all("|<[^>]+>(.*)".$_GET['s']."(.*)</[^>]+>|i", $contents, $matches, PREG_SET_ORDER);
		
	//preg_match_all("@<li>(.*?)".$_GET['s']."</li>@",$contents, $matches, PREG_SET_ORDER);
	//preg_match_all("/\<li\>(.*)".$_GET['s']."(.*)\<\/li\>/i", $contents, $matches, PREG_SET_ORDER);
	
	//preg_match_all("|<[^>]+>(.*)".$_GET['s']."(.*)</[^>]+>|U", $contents, $matches, PREG_PATTERN_ORDER);
    

	//preg_match_all("/\<h1\>(.*)".$_GET['s']."(.*)\<\/h1\>/i", $contents, $matches, PREG_SET_ORDER);
	//preg_match_all('/\<div <h2 class="gold_clr"\>(.*)".$_GET["s"]."(.*)\<\/h2 /div\>/i', $contents, $matches, PREG_SET_ORDER);
	//preg_match('/<div class="gold_clr">(.*?)'.$_GET['s'].'<\/div>/s', $contents, $matches, PREG_SET_ORDER);
	//preg_match_all("#<\s*([a-za-z]*)[^>]*>.*?{$key}.*?<\/\s*\\1\s*>#msi",$str,$match); 
	/*$key = $_GET['s'];
    preg_match_all("#<\s*([a-zA-Z]*)[^>]*>.*?{$key}.*?<\/\s*\\1\s*>#msi",$contents,$matches);*/

	/*if(isset($matches[0])) {
       print_r($matches[0]);
    }else{
       echo "No match";
    } */

 //echo "<pre>";   print_r($matches);
	 


 $matches = array_unique($matches, SORT_REGULAR);


	foreach($matches as $match){ 
		//echo "<pre>"; print_r($match);
		//trmiming results to show excerpt
		$match[1] = $match[1];
		$match[2] = $match[2];
		//highlighting if needed
		if($highlight == true){
			$match[1] .= '<span style="background: #ffff00;">';
			$match[2] = '</span>'.$match[2];
		}
		preg_match("/\<title\>(.*)\<\/title\>/", $contents, $matches2);
		$search_results[] = array($file, $match[1].$_GET['s'].$match[2], $matches2[1]);
		//echo "<pre>";print_r($search_results);
		
	}

}
?>
<section class="py-5">
<div class="container">
<h1 class="bold_font text-center"><div class="d-block"><img src="assets/images/gold_star.png"></div> Search Results : <span class="text-uppercase"> <?php echo filter($_GET['s']);?> </span> </h1>
<?php
$num_search_results=count($search_results);
if($num_search_results>0){
	
foreach($search_results as $result) :  
$strTitle1 = ltrim($result[0], './'); 
//$strTitle2 = rtrim($strTitle1, '.php'); 
$strTitle2 = substr($strTitle1, 0, -4);; 
$strTitle = strtoupper(trim(preg_replace('/_+/', '-', $strTitle2)));?>
<div class="search_box py-3">
<a href="<?php echo $result[0]; ?>" class="search_head" title="<?php echo $strTitle;?>"><strong><?php echo $strTitle;?></strong></a>
<p><?php echo strip_html_tags($result[1]); echo "...."; ?></p>
</div>
<?php endforeach; ?>

<?php /* New Search */
$sql = "SELECT id,name,slug, short_desc FROM news_master WHERE name LIKE '%" . 
           $_GET['s'] . "%' OR short_desc LIKE '%" . $_GET['s'] ."%'";
$result1 = $conn ->query($sql);
$rCount  = $result1->num_rows;
if($rCount>0){
while($rows=$result1->fetch_assoc()) { ?>
	
	<a href="news_detail.php?news=<?php echo $rows['slug'];?>" title="<?php echo $rows['name'];?>"><strong><?php echo $rows['name'];?></strong></a>
	<p><?php echo substr($rows['name'],0,200); echo "...."; ?></p>
<?php }  
} /*else { ?>
<p>No Result Found.</p>
<?php } */

} else { ?>
<!-- If Not found in site search then search in this -->
<?php
$sql = "SELECT id,name, short_desc,slug FROM news_master WHERE name LIKE '%" . 
           $_GET['s'] . "%' OR short_desc LIKE '%" . $_GET['s'] ."%'";
$result = $conn ->query($sql);
$rCount  = $result->num_rows;
if($rCount>0){
while($rows=$result->fetch_assoc()) { ?>
	<a href="news_detail.php?news=<?php echo $rows['slug'];?>" title="<?php echo $rows['name'];?>"><strong><?php echo replaceAccents($rows['name']);?></strong></a>
	<p><?php echo replaceAccents(substr($rows['name'],0,200)); echo "...."; ?></p>
<?php }  
} /*else { ?>
<h1 class="bold_font">No Result Found..</h1>
<?php } */ ?>

<!-- If Not found in site search then search in circular & notifications -->
<?php
$sql1 = "SELECT id,name,upload_circulars FROM circulars_to_member_master WHERE name LIKE '%" . $_GET['s'] . "%' AND status='1'";
$result1 = $conn ->query($sql1);
$rCount1  = $result1->num_rows;
if($rCount1>0){
while($rows1=$result1->fetch_assoc()) { ?>
	<a href="admin/Circulars/<?php echo $rows1['upload_circulars'];?>" target="_blank" title="<?php echo $rows1['name'];?>"><strong><?php echo replaceAccents($rows1['name']);?></strong></a>
	<p><?php echo replaceAccents(substr($rows1['name'],0,200)); echo "...."; ?></p>
<?php } 
} ?>

<!-- If Not found in site search then search in circular & notifications -->
<?php
$sql2 = "SELECT id,name,upload_circulars FROM circulars_master WHERE name LIKE '%" . $_GET['s'] . "%' AND status='1'";
$result2 = $conn ->query($sql2);
$rCount2  = $result2->num_rows;
if($rCount2>0){
while($rows2=$result2->fetch_assoc()) { ?>
	<a href="admin/Circulars/<?php echo $rows2['upload_circulars'];?>" target="_blank" title="<?php echo $rows2['name'];?>"><strong><?php echo replaceAccents($rows2['name']);?></strong></a>
	<p><?php echo replaceAccents(substr($rows2['name'],0,200)); echo "...."; ?></p>
<?php } 
} else { ?>
<!--<h1 class="bold_font">No Result Found..</h1>-->
<?php }  ?>

<?php } ?>
</div>
    
</section>

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
	} else {
		$start = count($words) - 15;
		$words = array_slice($words, ($start < 0 ? 0 : $start), 15);
	}
	return implode(' ', $words);
}

function page_title($url) {
    $page = file_get_contents($url);
    if (!$page) return null;
    $matches = array();
    if (preg_match('/<title>(.*?)<\/title>/', $page, $matches)) {
        return $matches[1];
    } else {
        return null;
    }
}

function replaceAccents($str)
{
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í',
               'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü',
               'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë',
               'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û',
               'ü', 'ý', 'ÿ', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C',
               'c', 'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E',
               'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H',
               'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J',
               'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N',
               'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', 'Œ', 'œ',
               'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'Š', 'š',
               'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',
               'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Ÿ', 'Z', 'z', 'Z', 'z', 'Ž',
               'ž', '?', 'ƒ', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U',
               'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?',
               '?', '€', '™', '*', '˜');
    $b = array('');
    return str_replace($a, $b, $str);
}

/**
 * Remove HTML tags, including invisible text such as style and
 * script code, and embedded objects.  Add line breaks around
 * block-level tags to prevent word joining after tag removal.
 */
function strip_html_tags( $text )
{
// Remove invisible content
    $text = preg_replace(
        array(
            //ADD a (') before @<head ON NEXT LINE. Why? see below
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
}
?>   

<?php include 'include-new/footer.php'; ?>

<style>
.search_box {border-bottom:1px dotted #a89c5d;}
</style>