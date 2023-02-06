<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
include('../functions.php');
?>
<?php 



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <style>
        #container {
            height: 1000px;
            min-width: 310px;
            max-width: 800px;
            margin: 0 auto;
        }

        .loading {
            margin-top: 10em;
            text-align: center;
            color: blue;
        }
        .highcharts-title{
            display:none;
        }
        .highcharts-credits{
            display:none;
        }
        .main_container{
            width: 1200px !important;
            max-width: 1200px !important;
        }
        div#highcharts-1jmlxr0-0 {
            width: 1200px !important;
        }
        .graph_loader {
            position: absolute;
            left: 15px;
            top: 0;
            right: 15px;
            bottom: 0;
            background: #fff;
            z-index: 9999;
        }    

        .highcharts-loading {
        opacity: 1!important;
        }
        .highcharts-loading-inner {
        display: block;
        }

        .highcharts-loading-inner,
        .highcharts-loading-inner:before,
        .highcharts-loading-inner:after {
        background: #dfdfdf;
        -webkit-animation: load1 1s infinite ease-in-out;
        animation: load1 1s infinite ease-in-out;
        width: 1em;
        height: 4em;
        }
        .highcharts-loading-inner {
        color: #dfdfdf;
        text-indent: -9999em;
        margin: 0 auto;
        top: 50%!important;
        position: relative;
        font-size: 11px;
        -webkit-transform: translate3d(-50%, -50%, 0);
        -ms-transform: translate3d(-50%, -50%, 0);
        transform: translate3d(-50%, -50%, 0);
        -webkit-animation-delay: -0.16s;
        animation-delay: -0.16s;
        }
        .highcharts-loading-inner:before,
        .highcharts-loading-inner:after {
        position: absolute;
        top: 0;
        content: '';
        }
        .highcharts-loading-inner:before {
        left: -1.5em;
        -webkit-animation-delay: -0.32s;
        animation-delay: -0.32s;
        }
        .highcharts-loading-inner:after {
        left: 1.5em;
        }
        @-webkit-keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em;
            height: 5em;
        }
        }
        @keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em;
            height: 5em;
        }
        }

    </style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

<!--navigation end-->
<link href="../css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<script type="text/javascript">
</script>
<script type="text/javascript" src="../assets-new/js/Chart.min.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>   
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script language="javascript">



</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>


    <div class="manage-shows" style="text-align:center;">
        
        <label style="display: block;margin-bottom: 10px;font-size: 18px;">Select show</label>
        <div class="select">
            <select name="data" id="data" class='websiteRadio'>				
                <option value="signature23" <?php if($show=="signature23"){?> selected <?php }?>>IIJS SIGNATURE 2023</option>
                <option value="iijstritiya23" <?php if($show=="iijstritiya23"){?> selected <?php }?>>IIJS TRITIYA 2023</option>
                <option value="combo23" <?php if($show=="combo23"){?> selected <?php }?>>IIJS PREMIERE 22 &amp;  IIJS SIGNATURE 23 &amp; IIJS TRITIYA 23</option>
                <option value="stcombo23" <?php if($show=="stcombo23"){?> selected <?php }?>> IIJS SIGNATURE &amp; IIJS TRITIYA 23</option>
            </select>
        </div>
	</div>

    <div id="container" class="main_container">
        <!-- <div id='imgLoading1' class="graph_loader" style='display:none'>
            <div class="d-flex">
                <div class="m-auto"><img src="https://registration.gjepc.org/images/loader.gif" alt="Uploading...."/></div>
            </div>
        </div> -->
        <button id="button">Show loading...</button>
    </div>
    



<script>
    
        $('.websiteRadio').change( function (e) {   
            drawVisitorbarchart();
        });
        var data_response = [];
        function drawVisitorbarchart(){
            var event = $('.websiteRadio').val();
            var type = '';
            
            if(event != '')  
            {
                $.ajax({
                    type: "POST",
                    url: 'getVisitorStatsData.php',
                    dataType: 'json',
                    data: "actiontype=sendVisitorDetails&event="+event,
                    beforeSend: function(){
                        
                        $('#imgLoading1').show();
                        console.log('load....');
                    },
                    success: function(data) {
                        $('#imgLoading1').hide();
                        //console.log('data ', data.datasets['data']);
                        response = data.datasets['data'];
                        var len = response.length;
                        var data = [];
                        var obj = {};
                        for (var i = 0; i < len; i++) {
                            var key = response[i].state_id;
                            if(response[i].state_id != null && response[i].state_id != '' && response[i].state_id != undefined){
                                let temp= [response[i].state_id, response[i].stateCount];
                                data.push(temp);
                            }
                            
                            
                        }
                        
                        console.log(data);
                        
                        getStateCount(data);
                    }           
                });
            } else {  
                alert("Please Select Event Type...");  
            } 
        }


        function getStateCount (data) {
            (async () => {

            const topology = await fetch(
            'https://code.highcharts.com/mapdata/countries/in/in-all.topo.json'
            ).then(response => response.json());
            var isLoading = false,
            $button = $('#button');
            $button.click(function() {
                if (!isLoading) {
                    chart.showLoading();
                    $button.html('Hide loading');
                } else {
                    chart.hideLoading();
                    $button.html('Show loading');
                }
                isLoading = !isLoading;
            });
                    
            // Prepare demo data. The data is joined to map using value of 'hc-key'
            // property by default. See API docs for 'joinBy' for more info on linking
            // data and map.
            // const data = [
            //     ['in-py', 10],
            //     ['in-ld', 11],
            //     ['in-wb', 12],
            //     ['in-or', 13],
            //     ['in-br', 14],
            //     ['in-sk', 15],
            //     ['in-ct', 16],
            //     ['in-tn', 17],
            //     ['in-mp', 18],
            //     ['in-2984', 19],
            //     ['in-ga', 20],
            //     ['in-nl', 21],
            //     ['in-mn', 22],
            //     ['in-ar', 23],
            //     ['in-mz', 24],
            //     ['in-tr', 25],
            //     ['in-3464', 26],
            //     ['in-dl', 27],
            //     ['in-hr', 28],
            //     ['in-ch', 29],
            //     ['in-hp', 30],
            //     ['in-jk', 31],
            //     ['in-kl', 32],
            //     ['in-ka', 33],
            //     ['in-dn', 34],
            //     ['in-mh', 35],
            //     ['in-as', 36],
            //     ['in-ap', 37],
            //     ['in-ml', 38],
            //     ['in-pb', 39],
            //     ['in-rj', 40],
            //     ['in-up', 41],
            //     ['in-ut', 42],
            //     ['in-jh', 43]
            // ];

            // Create the chart
            Highcharts.mapChart('container', {
                chart: {
                    map: topology,
                },

                title: {
                    text: 'Highcharts Maps basic demo'
                },

                subtitle: {
                    text: 'Source map: <a href="http://code.highcharts.com/mapdata/countries/in/in-all.topo.json">India</a>'
                },
                color: {
                    radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                    stops: [
                    [0, '#003399'],
                    [1, '#3366AA']
                    ]
                }, 
                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                    verticalAlign: 'bottom'
                    }
                },

                colorAxis: {
                    min: 0
                },

                series: [{
                    data: data,
                    name: 'Total Application',
                    states: {
                    hover: {
                        color: '#BADA55'
                    }
                    },
                    dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                    }
                }]
            });

            })();
        }
        
    
        drawVisitorbarchart();
</script>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>