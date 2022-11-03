$(document).ready(function () {
  let cookieSet = $.cookie("isInfoSubmitted");
  let cookieEmail = $.cookie("email");
  if (typeof cookieSet !== "undefined" || typeof cookieSet !== "") {
    recordUserVisits(cookieEmail);
  }
});
let recordUserVisits = (email) => {
  let action = "recordVisits";
  $.ajax({
    type: "POST",
    url: "statisticsVisitorEntry.php",
    data: { email: email, action: action },
    dataType: "json",
    success: function (data) {
      console.log(data);
    },
  });
};

$(window).on("load", function () {
  let cookieSet = $.cookie("isInfoSubmitted");
  let cookieEmail = $.cookie("email");

  console.log(cookieSet);
  if (typeof cookieSet == "undefined" || typeof cookieSet == "") {
    var delayMs = 1500; // delay in milliseconds
    setTimeout(function () {
      //$('#myModal').modal('show');
      $("#myModal").modal({ backdrop: "static", keyboard: false });
    }, delayMs);
  }
});

function first_alert() {
  alert("Only Registered Members can access the Link. \n Please Login First");
  window.location.href = "https://gjepc.org/login.php";
}

$(".select_box")
  .change(function () {
    var select = $(this).find(":selected").val();
    var switchbox = $(this).attr("data-switch");

    $("." + switchbox + "_hide").hide();
    $("#" + select).show();
  })
  .change();

// event poster slider
$(".any_slider").slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: !0,
  autoplaySpeed: 2e3,
  arrows: !0,
  dots: !1,
  responsive: [
    { breakpoint: 700, settings: { slidesToShow: 2, slidesToScroll: 1 } },
    { breakpoint: 500, settings: { slidesToShow: 1, slidesToScroll: 1 } },
  ],
});

// event poster slider
$(".position_slider").slick({
  slidesToShow: 1,
  adaptiveHeight: true,
  slidesToScroll: 1,
  autoplay: !1,
  autoplaySpeed: 1500,
  speed: 1500,
  arrows: !0,
  dots: !1,
});

// Month wise
function drawMonthLinechart() {
  var year = $("#year1").val();
  var type = "";
  $(".line .month").each(function () {
    if ($(this).hasClass("active")) {
      //  console.log(type);
      type = $(this).attr("data-findby");
    }
  });
  //console.log(year + ":" + type);
  if (year != "" && type != "") {
    $.ajax({
      type: "POST",
      url: "getStatsData.php",
      dataType: "json",
      data: "actiontype=sendMonthDetails&year=" + year + "&type=" + type,
      beforeSend: function () {
        $("#imgLoading1").show();
      },
      success: function (data) {
        // console.log(data.data);
        $("#imgLoading1").hide();
        var lbl = data.labels;
        var totalcurrentyearval = data.datasets.totalUSDBillionData;
        var totallastyearval = data.datasets.totalUSDBillionDataLast;
        var currentval = data.currentyear;
        var lastval = data.lastyear;

        //Draw new chart with ajax data
        var ctxz = document.getElementById("month_export");
        if (window.myLineCharts != undefined) {
          window.myLineCharts.destroy();
        }
        window.myLineCharts = new Chart(ctxz, {
          type: "line", // Define chart type
          data: {
            labels: lbl,
            datasets: [
              {
                label: currentval,
                fill: false,
                backgroundColor: "#81b214",
                borderColor: "#81b214",
                data: totalcurrentyearval,
                borderWidth: 2,
              },
              {
                label: lastval,
                fill: false,
                backgroundColor: "#206a5d",
                borderColor: "#206a5d",
                data: totallastyearval,
                borderWidth: 3,
              },
            ],
          },
          options: {
            legend: {
              display: true,
              position: "bottom",
              labels: {
                boxWidth: 10,
                boxHeight: 10,
              },
            },
          },
        });
      },
    });
  } else {
    // alert("Please Select Export/Import Type & Year");
  }
}

// Draw chart with Ajax request
$("#year1").on("change", function (e) {
  drawMonthLinechart();
});

$(".line .nav-tabs")
  .find("a")
  .on("shown.bs.tab", function () {
    drawMonthLinechart();
  });

function drawDestinationpiechart() {
  var year = $("#year").val();
  var type = "";
  $(".pie .dest").each(function () {
    if ($(this).hasClass("active")) {
      //  console.log(type);
      type = $(this).attr("data-findby");
    }
  });

  //console.log(year + ":" + type);
  if (year != "" && type != "") {
    $.ajax({
      type: "POST",
      url: "getStatsData.php",
      dataType: "json",
      data: "actiontype=sendDetails&year=" + year + "&type=" + type,
      beforeSend: function () {
        $("#imgLoading2").show();
      },
      success: function (data) {
        $("#imgLoading2").hide();
        // console.log(data.data);
        var lbl = data.labels;
        var val = data.datasets.data;

        // Delete previous chart
        //   myChart.destroy();

        //Draw new chart with ajax data
        var ctx = document.getElementById("destination_export");
        //console.log(window.myPieCharts);
        if (window.myPieCharts != undefined) {
          window.myPieCharts.destroy();
        }
        window.myPieCharts = new Chart(ctx, {
          type: "pie", // Define chart type
          data: {
            labels: lbl,
            datasets: [
              {
                label: "Chart.JS",
                fill: false,
                backgroundColor: [
                  "#ffc93c",
                  "#07689f",
                  "#40a8c4",
                  "#a2d5f2",
                  "#8d93ab",
                ],
                data: val,
              },
            ],
          },
          options: {
            legend: {
              display: true,
              position: "bottom",
              pieSliceText: "value-and-percentage",
              labels: {
                boxWidth: 10,
                boxHeight: 10,
              },
            },
            tooltips: {
              callbacks: {
                label: function (tooltipItem, data) {
                  var dataset = data.datasets[tooltipItem.datasetIndex];
                  var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                  var total = meta.total;
                  var currentValue = dataset.data[tooltipItem.index];
                  var percentage = parseFloat(
                    ((currentValue / total) * 100).toFixed(1)
                  );
                  return currentValue + " (" + percentage + "%)";
                },
                title: function (tooltipItem, data) {
                  return data.labels[tooltipItem[0].index];
                },
              },
            },
          },
        });
      },
    });
  } else {
    // alert("Please Select Export/Import Type & Year");
  }
}

// Draw chart with Ajax request
$("#year").on("change", function (e) {
  drawDestinationpiechart();
});

$(".pie .nav-tabs")
  .find("a")
  .on("shown.bs.tab", function () {
    drawDestinationpiechart();
  });

//commodity export/import

function drawCommoditybarchart() {
  var year = $("#year2").val();
  var type = "";
  $(".bar .comm").each(function () {
    if ($(this).hasClass("active")) {
      //  console.log(type);
      type = $(this).attr("data-findby");
    }
  });

  //console.log(year + ":" + type);
  if (year != "" && type != "") {
    $.ajax({
      type: "POST",
      url: "getStatsData.php",
      dataType: "json",
      data: "actiontype=sendCommodityDetails&year=" + year + "&type=" + type,
      beforeSend: function () {
        $("#imgLoading3").show();
      },
      success: function (data) {
        $("#imgLoading3").hide();
        // console.log(data.data);
        var lbl = data.labels;
        var totalcurrentyearval = data.datasets.totalUSDBillionData;
        var totallastyearval = data.datasets.totalUSDBillionDataLast;
        var currentval = data.currentyear;
        var lastval = data.lastyear;

        var canvas = document.getElementById("commodity_export");
        var ctx = canvas.getContext("2d");

        // Data with datasets options
        var data = {
          labels: lbl,
          datasets: [
            {
              label: currentval,
              fill: true,
              backgroundColor: [
                "#5588bb",
                "#66bbbb",
                "#aa6644",
                "#99bb55",
                "#ee9944",
                "#444466",
                "#bb5555",
              ],
              data: totalcurrentyearval,
            },
            {
              label: lastval,
              fill: true,
              backgroundColor: [
                "#5588bb",
                "#66bbbb",
                "#aa6644",
                "#99bb55",
                "#ee9944",
                "#444466",
                "#bb5555",
              ],
              data: totallastyearval,
            },
          ],
        };

        // Notice how nested the beginAtZero is
        var options = {
          scales: {
            xAxes: [
              {
                gridLines: {
                  display: false,
                  drawBorder: true,
                  drawOnChartArea: false,
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
              },
            ],
          },
        };

        // added custom plugin to wrap label to new line when \n escape sequence appear
        var labelWrap = [
          {
            beforeInit: function (chart) {
              chart.data.labels.forEach(function (e, i, a) {
                if (/\n/.test(e)) {
                  a[i] = e.split(/\n/);
                }
              });
            },
          },
        ];

        // Chart declaration:
        if (window.myBarCharts != undefined) {
          window.myBarCharts.destroy();
        }
        window.myBarCharts = new Chart(ctx, {
          type: "bar",
          data: data,
          options: {
            legend: {
              display: false,
              position: "bottom",
              labels: {
                boxWidth: 10,
                boxHeight: 10,
              },
            },
          },
          plugins: [
            {
              beforeInit: function (chart) {
                chart.data.labels.forEach(function (value, index, array) {
                  var a = [];
                  a.push(value.slice(0, 25));
                  var i = 1;
                  while (value.length > i * 25) {
                    a.push(value.slice(i * 25, (i + 1) * 25));
                    i++;
                  }
                  array[index] = a;
                });
              },
            },
          ],
        });
      },
    });
  } else {
    // alert("Please Select Export/Import Type & Year");
  }
}

// Draw chart with Ajax request
$("#year2").on("change", function (e) {
  drawCommoditybarchart();
});

$(".bar .nav-tabs")
  .find("a")
  .on("shown.bs.tab", function () {
    drawCommoditybarchart();
  });

$(".nav-link.dashboard").click(function () {
  // $('.nav-link.dashboard').removeClass("active");
  // $(this).addClass("active");
  drawWholeData();
});

function drawWholeData() {
  var values = "";
  $(".nav-link.dashboard").each(function () {
    if ($(this).hasClass("active")) {
      values = $(this).data("url").split(" ");
    }
  });

  var info = values[0]; //alert(registration_id);
  $.ajax({
    type: "POST",
    url: "getStatsData.php",
    data: "actiontype=getDetails&info=" + info,
    dataType: "json",
    beforeSend: function () {
      $("#imgLoading4").show();
      //$('#tabs-1').hide();
    },
    success: function (data) {
      if (data.success) {
        $("#imgLoading4").hide();
        //$('#tabs-1').show();
        // console.log(data);
        if (data.monthData == "monthData") {
          // $('#tabs-1').show();
          // $('#tabs-2').hide();
          $("#totalExportUSDMillion").html(data.totalExportUSDMillion);
          $("#totalImportUSDMillion").html(data.totalImportUSDMillion);
          $("#growthMothExportPer").html(data.growthMothExportPer);
          $("#growthMotImportPer").html(data.growthMotImportPer);
        }
        if (data.monthData == "fyData") {
          // $('#tabs-2').show();
          // $('#tabs-1').hide();
          $("#totalExportFYUSDMillion").html(data.totalExportFYUSDMillion);
          $("#totalImportFYUSDMillion").html(data.totalImportFYUSDMillion);
          $("#growthFYExportPer").html(data.growthFYExportPer);
          $("#growthFYImportPer").html(data.growthFYImportPer);
        }
      }
    },
  });
  return false;
}

$(function () {
  var hash = window.location.hash;
  hash && $('ul.statisticTab a[href="' + hash + '"]').tab("show");
  $("ul.statisticTab a").click(function (e) {
    $(this).tab("show");
    var scrollmem = $("body").scrollTop();
    window.location.hash = this.hash;
  });
});

$(".adv_slider").slick({
  slidesToShow: 1,
  autoplay: true,
  dots: false,
  slidesToScroll: 1,
  speed: 1000,
  arrows: false,
  fade: true,
});

drawWholeData();
drawDestinationpiechart();
drawMonthLinechart();
drawCommoditybarchart();
