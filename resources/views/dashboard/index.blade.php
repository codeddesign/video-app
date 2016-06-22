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
    <ul class="campaignstats-row">
        <li>
            <div class="campaignstats-title">THIS MONTH</div>
            <div class="campaignstats-digit" id="currentMonthViews">@{{ graphStats.month.plays }}</div>
            <div class="campaignstats-digit"><span id="graph_onDay"></span></div>
        </li>
        <li>
            <div class="campaignstats-title">TODAY</div>
            <div class="campaignstats-digit" id="currentDayViews">@{{ graphStats.day.plays }}</div>
            <div class="campaignstats-digit"><span id="graph_onHour"></span></div>
        </li>
        <li>
            <div class="campaignstats-title">THIS MONTH</div>
            <div class="campaignstats-digit">$@{{ graphStats.month.revenue.toFixed(2) }}</div>
            <div class="campaignstats-digit"><span id="graph_onDay_r"></span></div>
        </li>
        <li>
            <div class="campaignstats-title">TODAY</div>
            <div class="campaignstats-digit">$@{{ graphStats.day.revenue.toFixed(2) }}</div>
            <div class="campaignstats-digit"><span id="graph_onHour_r"></span></div>
        </li>
    </ul>

    <!-- CAMPAIGN SELECTION AREA -->
    <div class="campaignselection-wrap">
        <div class="currentcamp-title">CURRENT CAMPAIGN</div>
        <div class="currentcamp-createbutton"><a href="/campaign/create">CREATE CAMPAIGN</a></div>

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
                            <td>@{{ response.for_campaign.onMonth[campaign.id].plays }}</td>
                            <td>$@{{ response.for_campaign.onMonth[campaign.id].revenue }}</td>
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
            for_campaign: {},
            total: {
                onMonth: {},
                onDay: {},
                onHour: {}
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
            var keys = Object.keys(this.response.total),
                default_ = {
                    month: {
                        plays: 0,
                        revenue: 0
                    },
                    day: {
                        plays: 0,
                        revenue: 0
                    }
                },
                stats;

            if (!keys.length || typeof this.response.total.onMonth.revenue == 'undefined') {
                return default_;
            }

            keys.forEach(function(key) {
                stats = {
                    plays: [],
                    revenue: []
                };

                Object.keys(this.response.total[key]).forEach(function(day) {
                    stats.plays.push(this.response.total[key][day].plays);
                    stats.revenue.push(this.response.total[key][day].revenue);
                }.bind(this));

                $("#graph_" + key).sparkline(stats.plays, {
                    type: 'bar',
                    barWidth: 4,
                    height: '50px',
                    barColor: '#757092',
                    negBarColor: '#c6c6c6'
                });

                $("#graph_" + key + '_r').sparkline(stats.revenue, {
                    type: 'bar',
                    barWidth: 4,
                    height: '50px',
                    barColor: '#757092',
                    negBarColor: '#c6c6c6'
                });
            }.bind(this));

            return {
                month: this.response.total.onMonth,
                day: this.response.total.onDay[(new Date).getDate()]
            };
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
});
</script>

@endsection
