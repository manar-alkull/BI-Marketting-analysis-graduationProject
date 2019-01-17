/**
 * Created by ASUS_NB on 25/07/2018.
 */
console.log("withhhhhhhhhhhhhhhhhhhhhhhhhhhhhh");
//log chart
var logActivity = {
    options: {
        date: {
            startDate: moment().subtract(6, 'days'),
            endDate: moment(),
            minDate: moment().subtract(60, 'days'),
            maxDate: moment(),
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ],
                firstDay: 1
            }
        },
        chart: {
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
                verticalLines: true,
                hoverable: true,
                clickable: true,
                tickColor: "#d5d5d5",
                borderWidth: 1,
                color: '#fff'
            },
            colors: ["#B71C1C", "#D32F2F", '#F44336', '#FF5722', '#FF9100', '#4CAF50', '#1976D2', '#90CAF9'],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)",
                mode: "time",
                tickSize: [1, "day"],
                //tickLength: 10,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10
            },
            yaxis: {
                ticks: 8,
                tickColor: "rgba(51, 51, 51, 0.06)",
            },
            tooltip: false
        }
    },
    gteChartData: function ($el, start, end) {
        var self = this;

        $.ajax({
            url: 'withTime/log-chart',
            data: {start: start, end: end},
            success: function (response) {
                var data = {};
                var progress = {all: 0};

                $.each(response, function (k, v) {
                    data[k] = [];
                    progress[k] = 0;
                    $.each(v, function (date, value) {
                        data[k].push([new Date(date).getTime(), value]);
                        progress.all += value;
                        progress[k] += value;
                    });
                });

                $.plot($el,
                    [data.emergency, data.alert, data.critical, data.error, data.warning, data.notice, data.info, data.debug],
                    self.options.chart);


                $.each(progress, function (k, v) {
                    var $progress = $('.progress-bar.log-' + k);
                    if ($progress.length) {
                        $progress.attr('data-transitiongoal', 100 / progress.all * v).progressbar();
                    }
                });
            }
        });
    },
    init: function ($el) {
        var self = this;

        $el = $($el);

        var $dateEl = $el.find('.date_piker');
        var $chartEl = $el.find('.chart');

        $dateEl.daterangepicker(this.options.date, function (start, end) {
            $dateEl.find('.date_piker_label').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });

        $dateEl.on('apply.daterangepicker', function (ev, picker) {
            self.gteChartData($chartEl, picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
        });

        self.gteChartData($chartEl, this.options.date.startDate.format('YYYY-MM-DD'), this.options.date.endDate.format('YYYY-MM-DD'));
    }
};

logActivity.init($('#log_activity1'));


var registrationUsage = {
    _defaults: {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    "#3498DB",
                    "#3498DB",
                    "#9B59B6",
                    "#E74C3C",
                ],
                hoverBackgroundColor: [
                    "#36CAAB",
                    "#49A9EA",
                    "#B370CF",
                    "#E95E4F",
                ]
            }]
        },
        options: {
            legend: false,
            responsive: false
        }
    },
    init: function ($el) {
        var self = this;
        $el = $($el);

        $.ajax({
            url: 'withTime/registration-chart',
            success: function (response) {
                $.each($el.find('.tile_label'), function () {
                    self._defaults.data.labels.push($(this).text());
                });

                var count = 0;

                $.each(response, function () {
                    count += parseInt(this);
                });

                $('#registration_usage_from').text(100 / count * parseInt(response.registration_form));
                $('#registration_usage_google').text(100 / count * parseInt(response.google));
                $('#registration_usage_facebook').text(100 / count * parseInt(response.facebook));
                $('#registration_usage_twitter').text(100 / count * parseInt(response.twitter));

                self._defaults.data.datasets[0].data = [response.registration_form, response.google, response.facebook, response.twitter];

                new Chart($el.find('.canvasChart'), self._defaults);
            }
        });
    }
};

registrationUsage.init($('#registration_usage'));


/*
 function init_flot_chart(){

 if( typeof ($.plot) === 'undefined'){ return; }

 console.log('init_flot_chart');


 var chart_plot_09_data_time = [
 [1, 0.5],
 [2, 0.42],
 [3, 0.2],
 [4, -0.2],
 [5, 0.3],
 [6, -0.2],
 [7, -0.5],
 [8, 0.7],
 [9, 0.44],
 [10,0.18],
 [11, 0.8],
 [12, 0.9]
 ];

 var chart_plot_09_time_settings = {
 series: {
 curvedLines: {
 apply: true,
 active: true,
 monotonicFit: true
 }
 },
 colors: ["#26B99A"],
 grid: {
 borderWidth: {
 top: 0,
 right: 0,
 bottom: 1,
 left: 1
 },
 borderColor: {
 bottom: "#7F8790",
 left: "#7F8790"
 }
 }
 };


 if ($("#chart_plot_09_time").length){
 console.log('Plot3');


 $.plot($("#chart_plot_09_time"), [{
 label: "Price Sentiment",
 data: chart_plot_09_data_time,
 lines: {
 fillColor: "rgba(150, 202, 89, 0.12)"
 },
 points: {
 fillColor: "#fff"
 }
 }], chart_plot_09_time_settings);

 };

 }
 init_flot_chart();
 */

//log chart with time

var chartWithTime = {
    chart_plot_09_time_settings : {
        series: {
            curvedLines: {
                apply: false,
                active: true,
                monotonicFit: true
            }
        },
        colors: ["#26B99A",'#73879C','#E74C3C'],
        grid: {
            borderWidth: {
                top: 0,
                right: 0,
                bottom: 1,
                left: 1
            },
            borderColor: {
                bottom: "#7F8790",
                left: "#7F8790"
            }
        },
        tooltipOpts: {
            content: "%s: %y.0",
            xDateFormat: "%d/%m",
            shifts: {
                x: -30,
                y: -50
            },
            defaultTheme: false
        },
        xaxis: {
            mode: "time",
            minTickSize: [1, "day"],
            timeformat: "%d/%m/%y"
        }
    },
    gteChartData: function ($el, start, end) {
        var self = this;

        $.ajax({
            url: 'withTime/get-chart',
            data: {start: start, end: end},
            success: function (response) {
                console.log(response.data);
                var data =[];
                var data2 =[];
                var data3 =[];
                /*
                for (var i = 0; i < response.data.length; i++) {
                    data.push([new Date(2018,8,i+1).getTime(),response.data[i][1]]);
                }
                */
                data.push([new Date(response.data[0][0]).getTime(),response.data[0][1]]);
                data.push([new Date(response.data[1][0]).getTime(),response.data[1][1]]);
                data2.push([new Date(response.data2[0][0]).getTime(),response.data2[0][1]]);
                data2.push([new Date(response.data2[1][0]).getTime(),response.data2[1][1]]);
                data3.push([new Date(response.data2[0][0]).getTime(),response.data2[0][1]]);
                data3.push([new Date(response.data3[1][0]).getTime(),response.data3[1][1]]);

                console.log(data);
                $.plot($("#chart_plot_09_time"), [{
                    label: response.label,
                    data: data,
                    lines: {
                        fillColor: "rgba(150, 202, 89, 0.12)"
                    },
                    points: {
                        fillColor: "#fff"
                    }
                },{
                    label: response.label2,
                    data: data2,
                    lines: {
                        fillColor: "rgba(150, 202, 89, 0.12)"
                    },
                    points: {
                        fillColor: "#fff"
                    }},
                    {
                        label: response.label3,
                        data: data3,
                        lines: {
                            fillColor: "rgba(150, 202, 89, 0.12)"
                        },
                        points: {
                            fillColor: "#fff"
                        }}
                ], chartWithTime.chart_plot_09_time_settings);
            }
        });
    },
    init: function ($el) {
        var self = this;

        $el = $($el);


        self.gteChartData($el,'','');
    }
};

chartWithTime.init($('#chart_plot_09_time'));
