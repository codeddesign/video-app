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

    <div class='campaign-dateselect'>
        <div class="form-group">
            <div class='input-group date' id='datetimepicker6'>
                <input type='text' class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
            </div>
        </div>
    </div>
    <div class='campaign-dateselect'>
        <div class="form-group">
            <div class='input-group date' id='datetimepicker7'>
                <input type='text' class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
            </div>
        </div>
    </div>

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



<script type="text/javascript" src="/template/js/dashboard.js"></script>
@endsection
