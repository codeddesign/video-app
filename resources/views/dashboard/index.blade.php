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

    <ul class="totalstats-row">
        <li>
            <div class="campaignstats-digit">
                <canvas id="graph_total" width="1000" height="200"></canvas>
            </div>
        </li>
    </ul>

    <!-- CAMPAIGN SELECTION AREA -->
    <div class="campaignselection-wrap">
        <div class="currentcamp-title">CURRENT CAMPAIGN</div>
        <div class="currentcamp-createbutton"><a href="/campaign">CREATE CAMPAIGN</a></div>

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
                <table id="table1">
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Created On</th>
                            <th>RPM</th>
                            <th>Video Plays</th>
                            <th>Revenue</th>
                            <th>State</th>
                            <th>edit</th>
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
                                    <div class="campview-campoff campview-campoffactive"></div>
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

<script src="/template/js/d3.v3.js"></script>
<script src="/template/js/nv.d3.js"></script>

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
    var mygrid1 = $("#table1").ingrid({
        url: '/',
        height: 'auto',
        width: '100%',
        rowClasses: ['grid-row-style1', 'grid-row-style2'],
        resizableCols: true,
        paging: false,
        sorting: false
    });

    var data = {
        labels: ["Jul 1", "Jul 2", "Jul 3", "Jul 4", "Jul 5", "Jul 6", "Jul 7"],
        datasets: [
            {
                label: "My First dataset",
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(5,164,222,1)",
                borderColor: "rgba(5,164,222,1)",
                pointBorderColor: "rgba(5,164,222,1)",
                pointBackgroundColor: "rgba(255,255,255,1)",
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(5,164,222,1)",
                pointHoverBorderColor: "rgba(5,164,222,1)",
                pointHoverBorderWidth: 2,
                data: [100, 700, 500, 1300, 1100, 300, 900]
            }
        ]
    };

    Chart.controllers.line.prototype.origDraw = Chart.controllers.line.prototype.draw;
    Chart.controllers.line.prototype.draw = function (ease) {
        var me = this;
        var meta = me.getMeta();
        var points = meta.data || [];

        for (var i=0; i<points.length; i++) {
            if (points[i]._view.backgroundColor == "rgba(5,164,222,1)") {
                var point = points[i];

                var gridLineOptions = point._xScale.options.gridLines;
                ctx.lineWidth = gridLineOptions.lineWidth;
                ctx.strokeStyle = "rgba(5,164,222,1)";
                ctx.beginPath();
                ctx.moveTo(point._model.x, (point._xScale.top + point._xScale.bottom) / 2);
                ctx.lineTo(point._model.x, 0);
                ctx.stroke();
                ctx.restore();
            }
        }
        this.origDraw(ease);
    };

    var ctx = $('#graph_total').get(0).getContext("2d");
    var chart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontSize: 15
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontSize: 15,
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }]
            },
            tooltips: {
                mode: 'label'
            }
        }
    });
});
</script>

@endsection
