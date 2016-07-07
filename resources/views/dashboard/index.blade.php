@extends('dashboard._base')

@section('page_name') DASHBOARD @endsection

@section('content')

<div class="page-index" v-cloak>
    <div class="display-leftsep">
        <div class="display-septext">VIDEO PLAYS</div>
    </div>
    <div class="display-rightsep">
        <div class="display-septext">REVENUE</div>
    </div>

    <!-- ANALYTICS STATS -->
    <ul class="campaignstats-row" :graphStats='graphStats'>
        <li>
            <div class="campaignstats-title">THIS MONTH</div>
            <div class="campaignstats-digit" id="currentMonthViews">@{{ response.stats.month.plays }}</div>
            <div class="campaignstats-digit"><span id="graph_month"></span></div>
        </li>
        <li>
            <div class="campaignstats-title">TODAY</div>
            <div class="campaignstats-digit" id="currentDayViews">@{{ response.stats.day.plays }}</div>
            <div class="campaignstats-digit"><span id="graph_day"></span></div>
        </li>
        <li>
            <div class="campaignstats-title">THIS MONTH</div>
            <div class="campaignstats-digit">$@{{ response.stats.month.revenue.toFixed(2) }}</div>
            <div class="campaignstats-digit"><span id="graph_month_r"></span></div>
        </li>
        <li>
            <div class="campaignstats-title">TODAY</div>
            <div class="campaignstats-digit">$@{{ response.stats.day.revenue.toFixed(2) }}</div>
            <div class="campaignstats-digit"><span id="graph_day_r"></span></div>
        </li>
    </ul>

	<div class="currentcamp-createbutton"><a href="/campaign">CREATE NEW CAMPAIGN</a></div>

    <ul class="totalstats-row">
        <li>
            <div class="campaignstats-digit">
                <canvas id="graph_total" width="1000" height="285"></canvas>
            </div>
        </li>
    </ul>

    <!-- CAMPAIGN SELECTION AREA -->
    <div class="campaignselection-wrap">
        <div class="currentcamp-title">CURRENT CAMPAIGN</div>
        

        <div class="campaignview-wrap">
            <form @submit.prevent="">
                <input class="campaignview-search" name="all_search" id="all_search" placeholder="search for.." v-model="search">
            </form>

            <form action="#" method="post">
                <div class="campaignview-searchicon"></div>

                <div class="campaignview-dropbutton" @click="toggleAdvancedSearch">+</div>
                <div class="campaignview-droppedarea" v-if="advancedSearch">
                    <div class="campview-dropwhere">
                        <div class="campview-droptitle">WHERE</div>
                        <select name="ad_campaign_select">
                            <option value="campaign_name">Campaign Name</option>
                            <option value="video_rpm">RPM</option>
                        </select>
                        <div class="campview-selectarrow"></div>
                    </div>
                    <div class="campview-dropsearchfor">
                        <div class="campview-droptitle">SEARCH FOR</div>
                        <div class="campview-searchinput">
                            <input type="text" name="ad_campaign_value">
                            <div class="campview-searchinputicon"></div>
                        </div>
                    </div>
                    <div class="campview-dropandwhere">
                        <div class="campview-droptitle">WHERE</div>
                        <select name="video_rev_select">
                            <option value="video_plays">Video Plays</option>
                            <option value="revenue">Revenue</option>
                        </select>
                        <div class="campview-selectarrow"></div>
                    </div>
                    <div class="campview-dropmin">
                        <div class="campview-droptitle">MIN</div>
                        <input type="text" name="min">
                    </div>
                    <div class="campview-droptomax">
                        <div class="campview-droptitle">MAX</div>
                        <input type="text" name="max">
                    </div>
                    <button>SEARCH</button>
                </div>
                <!-- end .campaignview-droppedarea -->
            </form>

            <div class="campview-camplistwrap">
                <table id="table1" class="datagrid grid-header-bg">
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th width="290px">Created On</th>
                            <th width="70px">RPM</th>
                            <th width="105px">Video Plays</th>
                            <th width="90px">Revenue</th>
                            <th width="55px">State</th>
                            <th width="35px">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="campaign in response.campaigns | filterBy search">
                            <td>@{{ campaign.campaign_name }}</td>
                            <td>@{{ campaign.created_at }}</td>
                            <td>@{{ campaign.rpm }}</td>
                            <td>@{{ response.stats.campaign[campaign.id].plays }}</td>
                            <td>$@{{ response.stats.campaign[campaign.id].revenue.toFixed(2) }}</td>
                            <td>
                                <a href="/campaign/delete/@{{ campaign.id }}">

                                    <img class="remove_icon" src="/template/images/campviewoff.png">
                                </a>
                            </td>
                            <td>
                                <a href="/campaign/view/@{{ campaign.id }}">
                                    <img class="edit_icon" src="/template/images/edit.png">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end .campaignview-wrap -->
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>

<script src="/template/js/sparkline.min.js"></script>

<script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.25/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.8.0/vue-resource.js"></script>

<script type="text/javascript">
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
        }
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
        }
    }
})
</script>

<script type="text/javascript">
$(document).ready(function() {
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

    console.log(chart);
});
</script>

@endsection
