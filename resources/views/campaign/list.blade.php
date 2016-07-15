@extends('_base')

@section('content')
<div class="page-index" v-cloak>
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
    </div>
</div>

@include('_vue')
<script>
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
</script>
@endsection
