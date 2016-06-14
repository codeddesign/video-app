@extends('header')
@section('content')


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
			<div class="campaignstats-digit">60,551</div>
			<div class="campaignstats-digit" ><span id="sparkline1"></span></div>
		</li>
		<li>
			<div class="campaignstats-title">TODAY</div>
			<div class="campaignstats-digit">3,762</div>
			<div class="campaignstats-digit" ><span id="sparkline2"></span></div>
		</li>
		<li>
			<div class="campaignstats-title">THIS MONTH</div>
			<div class="campaignstats-digit">$1,087</div>
			<div class="campaignstats-digit" ><span id="sparkline3"></span></div>
		</li>
		<li>
			<div class="campaignstats-title">TODAY</div>
			<div class="campaignstats-digit">$104</div>
			<div class="campaignstats-digit" ><span id="sparkline4"></span></div>
		</li>
	</ul>

	<!-- CAMPAIGN SELECTION AREA -->
	<div class="campaignselection-wrap">
		<div class="currentcamp-title">CURRENT CAMPAIGN</div>
		<div class="currentcamp-createbutton"><a href="/campaign/create">CREATE CAMPAIGN</a></div>

		<div class="campaignview-wrap">
			<form action="" method="post" name="global-search" id="global-search">
	            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
	            <input class="campaignview-search" name="all_search" id="all_search" placeholder="search for..">
	            <input type="hidden" name="submit-global">
	        </form>

			<form action="#" method="post">
	            <input type="hidden" name="_token" value="{{ csrf_token() }}">
	            <div class="campaignview-searchicon"></div>

	            <div class="campaignview-dropbutton">+</div>
	            <div class="campaignview-droppedarea" style="display:none;">
	                <div class="campview-dropwhere">
	                    <div class="campview-droptitle">WHERE</div>
	                    <select name="ad_campaign_select">
	                        <option value="campaign_name">Campaign Name</option>
	                        <option value="ad_name">Ad Name</option>
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
	            </div><!-- end .campaignview-droppedarea -->
        	</form>
			<div class="campview-camplistwrap">
				<table id="table1">
				  <thead>
				    <tr>
				      <th>Campaign Name</th>
				      <th>Created On</th>
				      <th>Ad Name</th>
				      <th>Video Plays</th>
				      <th>Revenue</th>
				      <th>State</th>
				      <th>edit</th>
				    </tr>
				  </thead>
				  <tbody>
					  <?php foreach ($campaign as $value) {?>
						<tr>
					       	<td><?= $value->campaign_name?></td>
					       	<td><?= substr($value->created_at, 5, 2) . "/" . substr($value->created_at, 8, 2) . "/" . substr($value->created_at, 0, 4);?></td>
					       	<td><?= $value->ad_name?></td>
					       	<td><?= $value->video_plays?></td>
					       	<td>$<?= $value->revenue?></td>
					       	<td>
						       <a href="/campaign/delete/<?=$value->id?>"><div class="campview-campoff campview-campoffactive"></div></a>
					       	</td>
					       	<td>
						       <a href="/campaign/view/<?=$value->id?>"><img class="edit_icon" src="/template/images/edit.png"></div></a>
					       	</td>
					    </tr>
					  <?php }?>
					</tbody>
				</table>
			</div>
		</div><!-- end .campaignview-wrap -->
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
        $('#global-search').submit(function (e) {
            e.preventDefault();
            var url = $(this).prop('action');
            var searchFor = $('#all_search').val();

            $.ajax({
                method: "POST",
                url: "/global-search",
                data: {searchFor: searchFor, "_token": "{{ csrf_token() }}"},
                dataType: 'JSON',
            })
            .done(function (postBack) {
                var result = '';
                result += '<table id="table1">';
                result += '<thead>';
                result += '<tr>';
                result += '<th>Campaign Name</th>';
                result += '<th>Created On</th>';
                result += '<th>Ad Name</th>';
                result += '<th>Video Plays</th>';
                result += '<th>Revenue</th>';
                result += '<th>State</th>';
                result += '<th>edit</th>';
                result += '</tr>';
                result += '</thead>';
                result += '<tbody>';
                $(postBack).each(function () {
                    result += '<tr class="grid-row-style1">';
                    result += '<td data-ingrid-colid="0" style="width: 225px;"><div style="overflow: hidden;">' + this.campaign_name + '</div></td>';
                    result += '<td data-ingrid-colid="1" style="width: 225px;"><div style="overflow: hidden;">' + this.created_at + '</div></td>';
                    result += '<td data-ingrid-colid="2" style="width: 225px;"><div style="overflow: hidden;">' + this.ad_name + '</div></td>';
                    result += '<td data-ingrid-colid="3" style="width: 225px;"><div style="overflow: hidden;">' + this.video_plays + '</div></td>';
                    result += '<td data-ingrid-colid="4" style="width: 57px;"><div style="overflow: hidden;">$' + this.revenue + '</div></td>';
                    result += '<td data-ingrid-colid="5" style="width: 57px;"><div style="overflow: hidden;">'
                            + '<a href="#"><div class="campview-campoff campview-campoffactive"></div></a>'
                            + '</div></td>';
                    result += '<td data-ingrid-colid="6" style="width: 58px;"><div style="overflow: hidden;">'
                            + '<a href="http://videoapp.dev/adminEditCampaign/2@1"><img class="edit_icon" src="http://videoapp.dev/template/images/edit.png"></a>'
                            + '</div></td>';
                    result += '</tr>';
                });
                result += '</tbody>';
                result += '</table>';

                $('.campview-camplistwrap').html(result);
                $("#table1").ingrid({
                    url: '/',
                    height: 'auto',
                    width: '100%',
                    rowClasses: ['grid-row-style1', 'grid-row-style2'],
                    resizableCols: true,
                    paging: false,
                    sorting: false
                });
            });
        });
    });
</script>

@endsection
