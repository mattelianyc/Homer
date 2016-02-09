google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawDonutOne);

function drawDonutOne() {
  var data = google.visualization.arrayToDataTable([
    ['Task', 'Hours per Day'],
    ['Would Recommend This Building', 29],
    ['Would NOT Recommend This Building', 71]
  ]);

  var options = {
    pieHole: 0.4,
    legend: 'none',
    width: 487.5,
    height: 650,
    pieSliceText: 'none'
  };

  var donutChartOne = new google.visualization.PieChart(document.getElementById('donutchart'));
  donutChartOne.draw(data, options);
}

google.load("visualization", "2", {packages:["corechart"]});
google.setOnLoadCallback(drawDonutTwo);

function drawDonutTwo() {
  var data = google.visualization.arrayToDataTable([
    ['Task', 'Hours per Day'],
    ['Approve of Management', 54],
    ['Do NOT Approve of Management', 46]
  ]);

  var options = {
    pieHole: 0.4,
    legend: 'none',
    width: 487.5,
    height: 650,
    pieSliceText: 'none'
  };

  var donutChartTwo = new google.visualization.PieChart(document.getElementById('donutchart_two'));
  donutChartTwo.draw(data, options);
}

// ANALYTICS BLDG PAGE CHART

  google.load('visualization', '1.1', {packages: ['line']});
  google.setOnLoadCallback(drawRentLineChart);

  function drawRentLineChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('date', 'Year');
    data.addColumn('number', 'Average Rent');
    data.addRows([
      [new Date(2013, 12, 1),  4000],
      [new Date(2014, 12, 1), 4500],
      [new Date(2015, 12, 1), 5000]
    ]);

    var options = {
      chart: {
        title: 'Rent History',
        subtitle: 'in US skrilla'
      },
      width: 900,
      height: 500,
      axes: {
        x: {
          0: {side: 'bottom'}
        },
        y: {
        	1: {side: 'left'}
        }
      },
      legend: { position: "none" }
    };

    var rentPriceHistoryLineChart = new google.charts.Line(document.getElementById('line_top_x'));
    rentPriceHistoryLineChart.draw(data, options);
  }

 // FINANCIAL TAB BAR CHART 

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawFinancialsBarChart);
function drawFinancialsBarChart() {
  var data = google.visualization.arrayToDataTable([
    ["Element", "Density", { role: "style" } ],
    ["Copper", 8.94, "#b87333"],
    ["Silver", 10.49, "silver"],
    ["Gold", 19.30, "gold"],
    ["Platinum", 21.45, "color: #e5e4e2"]
  ]);

  var view = new google.visualization.DataView(data);
  view.setColumns([0, 1,
                   { calc: "stringify",
                     sourceColumn: 1,
                     type: "string",
                     role: "annotation" },
                   2]);

  var options = {
    title: "Density of Precious Metals, in g/cm^3",
    width: 450,
    height: 250,
    bar: {groupWidth: "95%"},
    legend: { position: "none" },
  };
  var financialsBarChart = new google.visualization.BarChart(document.getElementById("barchart_values"));
  financialsBarChart.draw(view, options);
}