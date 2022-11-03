<?php
session_start();
include 'include/header.php'; 
include('db.inc.php');

?>
<style type="text/css">
.innerbanner{display: none;}

.maindiv{ 
text-align:left; 
FONT-SIZE: 16px;
font-family: Verdana;
position: relative; 
right: -100px; 
top: 100px; 
background-color: #f1f1f1; 
width: 800px; 
padding: 10px; 
}
.lb{ 
 text-align:left; 
FONT-SIZE: 14px;
font-weight: normal; color: #4c4c4c;
font-family: Verdana;
position: relative; 
right: -20px; 
}
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css">

<?php
echo $query="select opt, count(ans_id) as no, opt1,opt2,opt3,opt4,qst,order_no from survey_answer left join survey_qst on survey_qst.qst_id=survey_answer.qst_id where survey_answer.email='".$_SESSION['email_id']."' group by order_no";
$resultxx = mysql_query($query);
$count = mysql_num_rows($resultxx);
while($row=mysql_fetch_array($resultxx)){

switch ($row['opt']){
case 'option1':
$opt1=$row['opt1'];
$no1=$row['no'];
break;

case 'option2':
$opt2=$row['opt2'];
$no2=$row['no'];
break;

case 'option3':
$opt3=$row['opt3'];
$no3=$row['no'];
break;

case 'option4':
$opt4=$row['opt4'];
$no4=$row['no'];
break;

}
//echo "<br>$row[ans],$row[no] <br>";

$total=($no1+$no2+$no3+$no4);
$no1_p=number_format($no1*100/$total);
$no2_p=number_format($no2*100/$total);
$no3_p=number_format($no3*100/$total);
$no4_p=number_format($no4*100/$total);

$title = $row['qst'];

echo '<div class="container"';
echo '<h4 style="text-align:center">'.$title.'</h4>';

echo '<div class="progress">';
echo '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$no1_p.'"
  aria-valuemin="0" aria-valuemax="100" style="width:'.$no1_p.'%">';
echo $opt1 . '  '.$no1_p.'%';
echo '</div>';
echo '</div>';

echo '<div class="progress">';
echo '<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'.$no2_p.'"
  aria-valuemin="0" aria-valuemax="100" style="width:'.$no2_p.'%">';
echo $opt2 . '  '.$no2_p.'%';
echo '</div>';
echo '</div>';

echo '<div class="progress">';
echo '<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'.$no3_p.'"
  aria-valuemin="0" aria-valuemax="100" style="width:'.$no3_p.'%">';
echo $opt3 . '  '.$no3_p.'%';
echo '</div>';
echo '</div>';

echo '<div class="progress">';
echo '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$no4_p.'"
  aria-valuemin="0" aria-valuemax="100" style="width:'.$no4_p.'%">';
echo $opt4 . '  '.$no4_p.'%';
echo '</div>';
echo '</div>';
}
echo '</div>';
echo "<br><br>Total answers : $count <hr>";
?>
</body>
</html>