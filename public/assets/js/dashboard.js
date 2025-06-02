(function ($) {
  'use strict';
  $(function () {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#income-expense-summary-chart-daterange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#income-expense-summary-chart-daterange').daterangepicker({
      opens: 'left',
      startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

      cb(start, end);

      // Income Expenses Summary Chart with chartist line chart

      var data = {
        // A labels array that can contain any sort of values
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        // Our series array that contains series objects or in this case series data arrays
        series: [
          [505, 781, 480, 985, 410, 822, 388, 874, 350, 642, 320, 796],
          [700, 430, 725, 390, 686, 392, 757, 500, 820, 400, 962, 420]
        ]
      };

      var options = {
        height:300,
        fullWidth:true,
        axisY: {
          high: 1000,
          low: 250,
          referenceValue: 1000,
          type: Chartist.FixedScaleAxis,
          ticks: [250, 500, 750, 1000]
        },
        showArea: true,
        showPoint: true,
      }
      
      var responsiveOptions = [
        ['screen and (max-width: 480px)', {
          height: 150,
          axisX: {
            labelInterpolationFnc: function (value) {
              return value;
            }
          }
        }]
      ];
    // Create a new line chart object where as first parameter we pass in a selector
    // that is resolving to our chart container element. The Second parameter
    // is the actual data object.
    new Chartist.Line('#income-expense-summary-chart', data, options, responsiveOptions);

    //Sessions by Channel doughnut chart

    var doughnutChartCanvas = $("#earningChart").get(0).getContext("2d");
            var doughnutPieData = {
                datasets: [{
                    data: [55,45],
                    backgroundColor: [
                        '#ffca00',
                        '#38ce3c',
                    ],
                    borderColor: [
                      '#ffca00',
                      '#38ce3c',
                    ],
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    'Sold',
                    'Debt',
                ]
            };
            var doughnutPieOptions = {
                cutoutPercentage: 75,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
                responsive: true,
                maintainAspectRatio: true,
                showScale: true,
                legend: {
                    display: true
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            };
            var doughnutChart = new Chart(doughnutChartCanvas, {
                type: 'doughnut',
                data: doughnutPieData,
                options: doughnutPieOptions
            });
  });

})(jQuery);