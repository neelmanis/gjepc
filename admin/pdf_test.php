<?php 
$data = $_GET;
//print_r($data[0]);
$array = array();
foreach($data[0] as $i => $dat){

     array_push($array,  $dat);
}


$json = json_encode($array,JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT |JSON_HEX_QUOT );

?>
<script type="text/javascript">  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.1.0/jszip-utils.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
<!-- <script type="text/javascript" src="js/jszip.min.js"></script>  -->
<script type="text/javascript">
var new_zip = new JSZip();

// var data = "C:/wamp64/www/gjepc/admin/pdf/-ALUHA.pdf";
// //new_zip.file("C:/wamp64/www/gjepc/admin/pdf/-ALUHA.pdf", { binary: true })
// // more files !
// content = new_zip.generate();
// zip.add(data, {blob: true});
// new_zip.generateAsync({type:"blob"})
// .then(function(content) {
//     // see FileSaver.js
//     saveAs(content, "example.zip");
// });
var data = <?php echo  $json; ?>; 
console.log(data);
var a = [];
var match = [];
var keys = [];

const objectArray = Object.entries(data);

objectArray.forEach(([key, value]) => {
  // 'one'
  
  keys.push(key);
  //  match.push(value); // 1
});
console.log("link : " + match);



function download(link) {
  var filename = link.substring(link.lastIndexOf('/')+1);
        
       var anchorTag = document.createElement('a');
        anchorTag.target = '_blank';
        //anchorTag.target = prevent;
        anchorTag.download = filename;
        anchorTag.href = link;
        anchorTag.click();   
}

for(var i=0; i < Object.keys(data).length; i++ ){
 download(data[i]);
  // setTimeout(
  //   function() {
  //   download(data[i]);
  // }, 20 * 100);
}
setTimeout(
    function() {
    history.back()
  }, 20 * 100);


</script>  