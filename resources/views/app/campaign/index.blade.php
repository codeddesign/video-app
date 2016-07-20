@extends('app._base')

@section('content')
<div class="page-index" v-cloak>
    <div class="campaignselection-wrap">
        <div class="campaignview-wrap">
            <form @submit.prevent="">
                <input class="campaignview-search" name="all_search" id="all_search" placeholder="search for.." v-model="search">
            </form>

            <form action="#" method="post">
                <div class="campaignview-searchicon"></div>

                <div class="campaignview-dropbutton" @click="toggleAdvancedSearch">advanced search</div>
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
	            <ul class="campaigngrid-title">
		            <li>CAMPAIGN ID</li>
		            <li>CAMPAIGN REFERENCE</li>
		            <li>CREATE</li>
		            <li>eCPM</li>
		            <li>VIDEO PLAYS</li>
		            <li>REVENUE</li>
		            <li>CODE</li>
		            <li>DELETE</li>
		            <li>EDIT</li>
	            </ul>
	            <ul class="campaigngrid">
		            <li v-for="campaign in response.campaigns | filterBy search">
		            	<div class="camplist-data1">@{{ campaign.id }}</div>
		            	<div class="camplist-data2">@{{ campaign.name }}</div>
		            	<div class="camplist-data3">@{{ campaign.created_at_humans }}</div>
		            	<div class="camplist-data4">@{{ 'n/a' }}</div>
		            	<div class="camplist-data5">@{{ 'n/a' }}</div>
		            	<div class="camplist-data6">$@{{ 'n/a' }}</div>
		            	<div class="camplist-data7">
			            	<a href="#">
                                <div class="embedcode_icon"></div>
                            </a>
		            	</div>
		            	<div class="camplist-data8">
			            	<a href="/app/campaign/delete/@{{ campaign.id }}">
                                <div class="remove_icon"></div>
                            </a>
		            	</div>
		            	<div class="camplist-data9">
			            	<a href="/app/campaign/view/@{{ campaign.id }}">
                                <div class="edit_icon"></div>
                            </a>
		            	</div>
		            </li>
	            </ul>
	            
	            <!--
                <table id="table1" class="datagrid grid-header-bg">
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th width="290px">Created</th>
                            <th width="70px">RPM</th>
                            <th width="105px">Video Plays</th>
                            <th width="90px">Revenue</th>
                            <th width="90px">Code</th>
                            <th width="55px">Delete</th>
                            <th width="35px">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="campaign in response.campaigns | filterBy search">
                            <td>@{{ campaign.name }}</td>
                            <td>@{{ campaign.created_at_humans }}</td>
                            <td>@{{ campaign.rpm }}</td>
                            <td>@{{ 'n/a' }}</td>
                            <td>$@{{ 'n/a' }}</td>
                            <td>
                                <a href="#">
                                    <img class="remove_icon" src="/assets/images/codeicon.png">
                                </a>
                            </td>

                            <td>
                                <a href="/app/campaign/delete/@{{ campaign.id }}">
                                    <img class="remove_icon" src="/assets/images/campviewoff.png">
                                </a>
                            </td>
                            <td>
                                <a href="/app/campaign/view/@{{ campaign.id }}">
                                    <img class="edit_icon" src="/assets/images/edit.png">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                -->
                
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/vuepack.js"></script>
<script>
    new Vue({
        el: '.page-index',
        data: {
            search: '',
            advancedSearch: false,
            response: {
                campaigns: [],
            },
            startDate: null,
            endDate: null
        },

        created: function() {
            this.$http.get('/app/campaign/list')
                .then(function(response) {
                    this.response = response.data;
                });
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
