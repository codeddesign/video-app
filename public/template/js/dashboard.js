new Vue({
    el: '.page-index',
    data: {
        search: '',
        advancedSearch: false,
        response: {
            campaigns: [],
            stats: {
                campaign: {},
                day: {
                    list: {},
                    plays: 0,
                    revenue: 0
                },
                month: {
                    list: {},
                    plays: 0,
                    revenue: 0
                }
            }
        },
        startDate: null,
        endDate: null
    },

    created: function() {
        this.$http.get('/campaign/stats')
            .then(function(response) {
                this.response = response.data;
            });
    },

    computed: {
        graphStats: function() {
            var keys = Object.keys(this.response.stats);

            if (!keys.length) {
                return false;
            }

            keys.forEach(function(key) {
                if (this.response.stats[key] == null || this.response.stats[key].list == null) {
                    return false;
                }

                $("#graph_" + key).sparkline(this.response.stats[key].list.plays, {
                    type: 'bar',
                    barWidth: 4,
                    height: '50px',
                    barColor: '#757092',
                    negBarColor: '#c6c6c6'
                });

                $("#graph_" + key + '_r').sparkline(this.response.stats[key].list.revenue, {
                    type: 'bar',
                    barWidth: 4,
                    height: '50px',
                    barColor: '#757092',
                    negBarColor: '#c6c6c6'
                });
            }.bind(this));
        }
    },

    methods: {
        toggleAdvancedSearch: function() {
            this.advancedSearch = !this.advancedSearch;
        },
        formatDate: function(date) {
            if (date === null) {
                return "[null]";
            } else {
                return date.format("YYYY-MM-DD");
            }
        }
    }
});

$(document).ready(function() {
    $('#datetimepicker6').datetimepicker();
    $('#datetimepicker7').datetimepicker({
        useCurrent: false //Important! See issue #1075
    });
    $("#datetimepicker6").on("dp.change", function (e) {
        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker7").on("dp.change", function (e) {
        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    });
    
    var ctx = $('#graph_total').get(0).getContext("2d");

    var data = {
        labels: ["Jul 1", "Jul 2", "Jul 3", "Jul 4", "Jul 5", "Jul 6"],
        datasets: [
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [300, 300, 300, 300, 300, 300]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [280, 280, 280, 280, 280, 280]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [520, 520, 520, 520, 520, 520]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [480, 480, 480, 480, 480, 480]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [510, 510, 510, 510, 510, 510]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [1020, 1020, 1020, 1020, 1020, 1020]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [710, 710, 710, 710, 710, 710]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [860, 860, 860, 860, 860, 860]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [360, 360, 360, 360, 360, 360]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [420, 420, 420, 420, 420, 420]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [740, 740, 740, 740, 740, 740]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [940, 940, 940, 940, 940, 940]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [1700, 1700, 1700, 1700, 1700, 1700]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [1400, 1400, 1400, 1400, 1400, 1400]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [280, 280, 280, 280, 280, 280]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [220, 220, 220, 220, 220, 220]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [480, 480, 480, 480, 480, 480]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [740, 740, 740, 740, 740, 740]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [880, 880, 880, 880, 880, 880]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [1000, 1000, 1000, 1000, 1000, 1000]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [660, 660, 660, 660, 660, 660]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [1240, 1240, 1240, 1240, 1240, 1240]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [260, 260, 260, 260, 260, 260]
            },
            {
                backgroundColor: "rgb(136,212,237)",
                borderWidth: 0,
                hoverBackgroundColor: "rgb(2,163,222)",
                data: [720, 720, 720, 720, 720, 720]
            }
        ]
    };

    var helpers = Chart.helpers;
    var currentElement;

    Chart.Scale.prototype.origDraw = Chart.Scale.prototype.draw;
    Chart.Scale.prototype.draw = function (chartArea) {
        this.origDraw(chartArea);
        var me = this;
        var context = me.ctx;
        var options = me.options;
        var isHorizontal = me.isHorizontal();
        var gridLines = options.gridLines;
        if (gridLines.drawBorder) {
            context.lineWidth = helpers.getValueAtIndexOrDefault(gridLines.lineWidth, 0);
            context.strokeStyle = helpers.getValueAtIndexOrDefault(gridLines.color, 0);
            var x1, x2, x3, x4;
            var y1, y2, y3, y4;
            var aliasPixel = helpers.aliasPixel(context.lineWidth);
            if (isHorizontal) {
                y1 = y2 = options.position === 'top' ? me.bottom : me.top;
                y1 += aliasPixel;
                y2 += aliasPixel;

                x1 = 0;
                x2 = me.left;
                x3 = me.right-15;
                x4 = me.right-15;

                y3 = 0;
                y4 = me.top + 15;

                context.beginPath();
                context.moveTo(x1, y1);
                context.lineTo(x2, y2);
                context.moveTo(x3, y3);
                context.lineTo(x4, y4);
                context.stroke();

            } else {
                x1 = x2 = options.position === 'left' ? me.right : me.left;
                x1 += aliasPixel;
                x2 += aliasPixel;
                x3 = me.right - 15;
                x4 = me.right - 15;

                y1 = 0;
                y2 = me.top;
                y3 = me.bottom;
                y4 = me.bottom + 15;

                context.beginPath();
                context.moveTo(x1, y1);
                context.lineTo(x2, y2);
                context.moveTo(x1, y3);
                context.lineTo(x2, y4);
                context.stroke();
            }
        }
    };

    helpers.extend(Chart.Controller.prototype, {

        getElementAtEvent: function(e) {
            var me = this;
            var eventPosition = helpers.getRelativePosition(e, me.chart);
            var elementsArray = [];

            helpers.each(me.data.datasets, function(dataset, datasetIndex) {
                if (me.isDatasetVisible(datasetIndex)) {
                    var meta = me.getDatasetMeta(datasetIndex);
                    helpers.each(meta.data, function(element, index) {
                        if (element.inRange(eventPosition.x, eventPosition.y)) {
                            elementsArray.push(element);
                            return elementsArray;
                        }
                    });
                }
            });
            currentElement = elementsArray[0];
            return elementsArray;
        },

        updateHoverStyle: function(elements, mode, enabled) {
            var method = enabled? 'setHoverStyle' : 'removeHoverStyle';
            var element, i;

            switch (mode) {
                case 'single':
                    elements = [ elements[0] ];
                    break;
                case 'label':
                case 'dataset':
                    // elements = elements;
                    break;
                default:
                    // unsupported mode
                    return;
            }

            for (i=0; i<elements.length; i++) {
                element = elements[i];
                if (element) {
                    if(currentElement && element._datasetIndex == currentElement._datasetIndex) {
                        element._chart.config.data.datasets[i].hoverBackgroundColor = "rgb(63,72,92)";
                        this.getDatasetMeta(element._datasetIndex).controller[method](element);
                    } else {
                        this.getDatasetMeta(element._datasetIndex).controller[method](element);
                    }
                }
                element._chart.config.data.datasets[i].hoverBackgroundColor = "rgb(2,163,222)";
            }
        }
    });

    var chart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            title: {
                display: true,
                text: '',
                padding: 5
            },
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                display: false,
                xAxes: [{
                    ticks: {
                        fontSize: 13
                    },
                    gridLines: {
                        display: false,
                        offsetGridLines: true
                    },
                    barPercentage: 0.8,
                    categoryPercentage: 0.98
                }],
                yAxes: [{
                    ticks: {
                        fontSize: 13,
                        callback: function(value) {
                            if (value % 200 == 0) {
                                return '';
                            } else {
                                return '$' + value;
                            }
                        },
                        min: 0,
                        stepSize: 100
                    },
                    gridLines: {
                        display: false
                    }
                }],
                top: 15
            },
            tooltips: {
                caretSize: 0,
                backgroundColor: 'rgb(63,72,92)',
                callbacks: {
                    title: function() {
                        return '';
                    },
                    label: function() {
                        return 'Views:    2091';
                    },
                    afterLabel: function() {
                        return 'Revenue:   $'+currentElement._chart.config.data.datasets[currentElement._datasetIndex].data[currentElement._index];
                    }
                }
            }
        }
    });

    $('#video_url').keyup($.debounce(1000, checkValidation));
});

function checkValidation() {
    var url = $('#video_url').val();
    var Id = getYouTubeID(url);
    var ytKey = 'AIzaSyAIjv2KfeLl3IFlS841O8ctyDKytX0togE';
    if(typeof Id == "string") {
        $('.status-icon i').removeClass('fa-check').removeClass('fa-times').addClass('fa-spinner fa-pulse');
        $('.status-icon').removeClass('red').removeClass('green').addClass('blue');
        $.get('https://www.googleapis.com/youtube/v3/videos?id=' + Id + '&key='+ ytKey +'&part=snippet,contentDetails,statistics,status')
            .done(function(data) {
                if(data.items.length) {
                    $('.status-icon i').removeClass('fa-times').removeClass('fa-spinner fa-pulse').addClass('fa-check');
                    $('.status-icon').removeClass('blue').removeClass('red').addClass('green');
                    $('#campaign_name').val(data.items[0].snippet.localized.title);
                } else {
                    $('.status-icon i').removeClass('fa-check').removeClass('fa-spinner fa-pulse').addClass('fa-times');
                    $('.status-icon').removeClass('blue').removeClass('green').addClass('red');
                    $('#campaign_name').val('');
                }
            });
    } else {
        $('.status-icon i').removeClass('fa-check').removeClass('fa-spinner fa-pulse').addClass('fa-times');
        $('.status-icon').removeClass('blue').removeClass('green').addClass('red');
        $('#campaign_name').val('');
    }
}

function getYouTubeID(url) {
    var ID = '';
    url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    if(url[2] !== undefined) {
        ID = url[2].split(/[^0-9a-z_\-]/i);
        ID = ID[0];
    } else {
        ID = url;
    }
    return ID;
}

function createCampaign() {
    $('.campaignform-error').addClass('hidden');

    $.ajax({
        type: 'POST',
        url: '/campaign',
        data: {
            _token : document.getElementsByName('_token')[0].value,
            video_url : $('#video_url').val(),
            campaign_name : $('#campaign_name').val(),
            video_width : $('#video_width').val(),
            video_height : $('#video_height').val()
        }
    }).done(function(data) {
        if(data.status == 1) {
            location.href = '/campaign/view/' + data.id;
        } else {
            $('.campaignform-error').removeClass('hidden');
        }
    });

    return false;
}

function autoResize() {
    if($('#auto_resize').is(':checked')) {
        $('#video_width').val("1024");
        $('#video_height').val("768");
    } else {
        $('#video_width').val("");
        $('#video_height').val("");
    }
}