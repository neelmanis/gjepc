<?php
include('db.inc.php');
$sql = "SELECT * FROM news_master ORDER BY id DESC LIMIT 5";
$query = mysql_query($sql) or die(mysql_error());

header("Content-type: text/xml");

echo "<?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
<title>GJEPC News Headlines</title>
<link>http://gjepc.org</link>
<description>GJEPC Latest News</description>
<language>en-us</language>";

while($row = mysql_fetch_array($query))
{
$title = str_replace(array('&', '<'), array('&#x26;', '&#x3C;'), $row['short_desc']);
$link="www.gjepc.org?id=".$row['id'];
$description=str_replace(array('&', '<'), array('&#x26;', '&#x3C;'), $row['long_desc']);

echo "<item>
<title>$title</title>
<link>$link</link>
<description>$description</description>
</item>";
}
echo "</channel></rss>";
?>