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
			<form action="{{URL::to('adminSearch/'.$user->id)}}" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input class="campaignview-search" name="all_search" placeholder="search for..">
				<div class="campaignview-searchicon"></div>

				<div class="campaignview-dropbutton">+</div>
				<div class="campaignview-droppedarea" style="display:none;">
					<div class="campview-dropwhere">
						<div class="campview-droptitle">WHERE</div>
						<select name="campaign_select">
							<option>Campaign Name</option>
							<option>Ad Name</option>
						</select>
						<div class="campview-selectarrow"></div>
					</div>
					<div class="campview-dropsearchfor">
						<div class="campview-droptitle">SEARCH FOR</div>
						<div class="campview-searchinput">
							<input type="text" name="campaign_name">
							<div class="campview-searchinputicon"></div>
						</div>
					</div>
					<div class="campview-dropandwhere">
						<div class="campview-droptitle">WHERE</div>
						<select name="plays_select">
							<option>Video Plays</option>
							<option>Revenue</option>
						</select>
						<div class="campview-selectarrow"></div>
					</div>
					<div class="campview-dropmin">
						<div class="campview-droptitle">MIN</div>
						<input type="text" name="plays_min">
					</div>
					<div class="campview-droptomax">
						<div class="campview-droptitle">MAX</div>
						<input type="text" name="plays_max">
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
			   			<?php $pm = $value->id.'@'.$user->id?>
				       	<td><?=$value->campaign_name?></td>
				       	<td><?php
                                echo substr($value->created_at,5,2)."/".substr($value->created_at,8,2)."/".substr($value->created_at,0,4);
                            ?>
                       	</td>
				       	<td><?=$value->ad_name?></td>
				       	<td><?=$value->video_plays?></td>
				       	<td>$<?=$value->revenue?></td>
				       	<td>
					       <a href="/campaign/delete/<?=$value->id?>"><div class="campview-campoff campview-campoffactive"></div></a>
				       	</td>
				       	<td>
					       <a href="/campaign/view/<?=$value->id?>"><img class="edit_icon" src="{{url('/')}}/template/images/edit.png"></div></a>
				       	</td>
				    </tr>
				    <?php }?>
				   </tbody>
				</table>
			</div>
		</div><!-- end .campaignview-wrap -->
	</div>
</div>

@endsection
