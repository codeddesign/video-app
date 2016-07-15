@extends('dashboard._base')

@section('page_name') DASHBOARD @endsection

@section('content')

<div class="page-index" >
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

    <div class="dashboard-dailystatstitle">DAILY STATS</div>
    <ul class="dashboard-dailystatstitles">
        <li>DATE</li>
        <li>REQUESTS</li>
        <li>FILL-RATE</li>
        <li>eCPM</li>
        <li>REVENUE</li>
    </ul>
    <ul class="dashboard-dailystatslist">
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
        <li>
            <div class="dashboard-statslist1">July 10, 2016</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">18,000</div>
            <div class="dashboard-statslist2">$479</div>
            <div class="dashboard-statslist2">$479</div>
        </li>
    </ul>


</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>

<script src="/template/js/sparkline.min.js"></script>

<script src="/template/js/dashboard.js"></script>
<script src="/js/all.js"></script>
<script>new Vue({el: '.campaignstats-row'});</script>
@endsection
