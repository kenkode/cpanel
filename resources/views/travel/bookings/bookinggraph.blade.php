@extends('layouts.travel')

@section('content')

       <?php $currency = ''; ?>
       @if($organization->currency_shortname == null || $organization->currency_shortname == '')
       <?php $currency = 'KES'; ?>
       @else
       <?php $currency = $organization->currency_shortname; ?>
       @endif
        
                <div class="row  border-bottom white-bg dashboard-header" style="min-height: 1200px">
                    <form>
                        <input type="hidden" id="year" value="{{$year}}">
                        <input type="hidden" id="type" value="{{$type}}">
                    </form>

                    <!-- <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-pie-content" id="flot-pie-chart"></div>
                            </div>
                        </div> -->
                
                    <div class="col-sm-12">
                    <h2 align="center" style="font-weight: 500">{{date('Y')}} Revenues</h2>
                        
                        <div>
                        <h4 style="float: left;">Revenues ({{$currency}})</h4>
                                <canvas id="barChart" height="140"></canvas>
                                <h4 align="center">Months</h4>
                            </div>
                      
                    </div>
                    

            </div>
        

                @include('includes.footer')
           
    <script>
        $(document).ready(function() {

        var results;
        var year = $('#year').val();
        var type = $('#type').val();

        $.ajax({
                        type: "GET",
                        url: "{{url('bookgraph')}}",
                        data: {year:year},
                        async:false,
                        success: function(data){
                           results = JSON.parse(data);
                           //alert(results);
                           //console.log(results.replace(/['"]+/g, ''));
                           console.log(results);                   
                        },
                        error: function(xhr,thrownError) {
                       console.log(xhr.statusText);
                       console.log(xhr.responseText);
                       console.log(xhr.thrownError);
                        //return false;
                     } 
                 });

        if(type == 'bar'){

        var barData = {
        labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(26,179,148,0.5)",
                strokeColor: "rgba(26,179,148,0.8)",
                highlightFill: "rgba(26,179,148,0.75)",
                highlightStroke: "rgba(26,179,148,1)",
                data: results
            }
        ]
    };

    var barOptions = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        responsive: true,
        scaleLabel:
        function(label){return parseFloat(label.value.toString()).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");}
    }


    var ctx = document.getElementById("barChart").getContext("2d");
    var myNewChart = new Chart(ctx).Bar(barData, barOptions);



            var data1 = [
                [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
            ];
            var data2 = [
                [0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
            ];
            $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                data1, data2
            ],
                    {
                        series: {
                            lines: {
                                show: false,
                                fill: true
                            },
                            splines: {
                                show: true,
                                tension: 0.4,
                                lineWidth: 1,
                                fill: 0.4
                            },
                            points: {
                                radius: 0,
                                show: true
                            },
                            shadowSize: 2
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#d5d5d5",
                            borderWidth: 1,
                            color: '#d5d5d5'
                        },
                        colors: ["#1ab394", "#464f88"],
                        xaxis:{
                        },
                        yaxis: {
                            ticks: 4
                        },
                        tooltip: false
                    }
            );

        }else if(type == 'line'){
            var lineData = {
        labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(26,179,148,0.5)",
                strokeColor: "rgba(26,179,148,0.8)",
                highlightFill: "rgba(26,179,148,0.75)",
                highlightStroke: "rgba(26,179,148,1)",
                data: results
            }
        ]
    };

    var lineOptions = {
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        bezierCurve: true,
        bezierCurveTension: 0.4,
        pointDot: true,
        pointDotRadius: 4,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        responsive: true,
        scaleLabel:
        function(label){return parseFloat(label.value.toString()).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");}
    };


    var ctx = document.getElementById("barChart").getContext("2d");
    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

        }else if(type == 'pie'){
       var oilCanvas = document.getElementById("barChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Saudi Arabia",
        "Russia",
        "Iraq",
        "United Arab Emirates",
        "Canada"
    ],
    datasets: [
        {
            data: [133.3, 86.2, 52.2, 51.2, 50.2],
            backgroundColor: [
                "#FF6384",
                "#63FF84",
                "#84FF63",
                "#8463FF",
                "#6384FF"
            ]
        }]
};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});


        }

            /*var doughnutData = [
                {
                    value: 300,
                    color: "#a3e1d4",
                    highlight: "#1ab394",
                    label: "App"
                },
                {
                    value: 50,
                    color: "#dedede",
                    highlight: "#1ab394",
                    label: "Software"
                },
                {
                    value: 100,
                    color: "#b5b8cf",
                    highlight: "#1ab394",
                    label: "Laptop"
                }
            ];

            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
            };

            var ctx = document.getElementById("doughnutChart").getContext("2d");
            var DoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
*/
            /*var polarData = [
                {
                    value: 300,
                    color: "#a3e1d4",
                    highlight: "#1ab394",
                    label: "App"
                },
                {
                    value: 140,
                    color: "#dedede",
                    highlight: "#1ab394",
                    label: "Software"
                },
                {
                    value: 200,
                    color: "#b5b8cf",
                    highlight: "#1ab394",
                    label: "Laptop"
                }
            ];

            var polarOptions = {
                scaleShowLabelBackdrop: true,
                scaleBackdropColor: "rgba(255,255,255,0.75)",
                scaleBeginAtZero: true,
                scaleBackdropPaddingY: 1,
                scaleBackdropPaddingX: 1,
                scaleShowLine: true,
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
            };
            var ctx = document.getElementById("polarChart").getContext("2d");
            var Polarchart = new Chart(ctx).PolarArea(polarData, polarOptions);
*/
        });
    </script>
@endsection