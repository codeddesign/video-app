@extends('_base')

@section('page_name')
    @if(!isset($campaign))
        CREATE CAMPAIGN
    @else
        PREVIEW CAMPAIGN
    @endif
@endsection

@section('content')

<script>
	$(document).ready(function(){
		$("#adcreation-form").steps({
		    headerTag: "h3",
		    bodyTag: ".adcreation-section",
		    transitionEffect: "fade",
		    autoFocus: true,
		    enablePagination: true
		});
	});
</script>
	<div class="selectadtype-overlay">
		<div id="adcreation-form">
	        <!-- start select ad type -->
	        <h3>Select Ad Type</h3>
	        <div class="adcreation-section">
		        <div class="selectadtype-title">Select your ad type to proceed:</div>
				<div class="selectadtype-wrapper">
					<ul class="selectadtype-adtypes">
						<li>
							<img src="/template/images/adtype-sidebarrow.png">
							<div class="selectadtype-adtypetitle">Sidebar Row</div>
							<div class="selectadtype-adtypeselect">select this ad</div>
						</li>
						<li>
							<img src="/template/images/adtype-actionoverlay.png">
							<div class="selectadtype-adtypetitle">Action Overlay</div>
							<div class="selectadtype-adtypeselect">select this ad</div>
						</li>
						<li>
							<img src="/template/images/adtype-standard.png">
							<div class="selectadtype-adtypetitle">Standard</div>
							<div class="selectadtype-adtypeselect">select this ad</div>
						</li>
						<li>
							<img src="/template/images/adtype-halfpagegallery.png">
							<div class="selectadtype-adtypetitle">Half-Page Gallery</div>
							<div class="selectadtype-adtypeselect">select this ad</div>
						</li>
						<li>
							<img src="/template/images/adtype-fullwidthgallery.png">
							<div class="selectadtype-adtypetitle">Full-Width Gallery</div>
							<div class="selectadtype-adtypeselect">select this ad</div>
						</li>
						<li>
							<img src="/template/images/adtype-horizontalrow.png">
							<div class="selectadtype-adtypetitle">Horizontal Row</div>
							<div class="selectadtype-adtypeselect">select this ad</div>
						</li>
						<li>
							<img src="/template/images/adtype-onscrolldisplay.png">
							<div class="selectadtype-adtypetitle">On-Ccroll Display</div>
							<div class="selectadtype-adtypeselect">select this ad</div>
						</li>
						<li>
							<img src="/template/images/adtype-incontentgallery.png">
							<div class="selectadtype-adtypetitle">In-Content Gallery</div>
							<div class="selectadtype-adtypeselect">select this ad</div>
						</li>
					</ul>
				</div>
			</div>
			<!-- end select ad type -->
			<!-- start create ad name -->
	        <h3>Create Ad Name</h3>
	        <div class="adcreation-section">
		        <div class="selectadtype-title">Create a Reference Name for your Ad:</div>
				<div class="selectadtype-wrapper">
					<div class="createcampaign-fulltoparea">
						<div class="campaign-creationwrap createcampaign-middlecreatewrap">
							<form onsubmit="" name="campaignForm">
								<input type="hidden" name="_token" value="">
								<div class="campaign-creationyoutube">
									<label>CAMPAIGN NAME</label>
					                <div class="campaignform-error hidden">Already same title exists.</div>
									<input id="campaign_name" name="campaign_name" type="text" required>
								</div>
								<div class="campaign-creationvidsize">
									<label>VIDEO SIZE</label>
									<input id="auto_resize" name="auto_resize" type="checkbox" onclick="autoResize()"><span>AUTO-RESIZE</span>
									<input id="video_width" class="video_size_width" name="video_width" type="text" placeholder="width(px)" required
					                    @if(isset($campaign)) value="{{ $campaign->video_width }}" @endif
					                >
									<input id="video_height" class="video_size_height" name="video_height" type="text" placeholder="height(px)" required
					                    @if(isset($campaign)) value="{{ $campaign->video_height }}" @endif
					                >
								</div>

								<button>PROCEED TO AD PREVIEW</button>
							</form>
						</div>
					</div>
				</div>
	        </div>
			<!-- end create ad name -->
		</div>

	</div>

	<!-- HIDDEN FOR NOW
	<div class="createcampain-adtestingwrap">
		<div class="createcampaign-adtestingarea">
			<div class="createcampaign-adtestingtitle">Ad Testing Area</div>
			<div class="createcampaign-browseroutwrap">
				<div class="createcampaign-browsercircles"></div>
				<div class="createcampaign-browsericons"></div>
				<div class="createcampaign-browserbar"></div>
				<div class="createcampaign-browserwhitearea">
					<div class="createcampaign-browserleft">
						<div class="createcampaign-browserinwrap">
							<div class="createcampaign-browserbar1" style="width:350px;background:#CCCCCC;"></div>
							<div class="createcampaign-browserbar1" style="width:300px;"></div>
							<div class="createcampaign-browserbar1" style="margin-left:12px;width:255px;"></div>
							<div class="createcampaign-browserbar1" style="width:550px;"></div>
						</div>
						<div class="createcampaign-browserinwrap">
							<div class="createcampaign-browserbar2" style="width:100%;"></div>
						</div>
						<div class="createcampaign-browserinwrap">
							<div class="createcampaign-browserbar3"></div>

							<div class="createcampaign-browserbar1" style="width:338px;"></div>
							<div class="createcampaign-browserbar1" style="width:288px;"></div>
							<div class="createcampaign-browserbar1" style="margin-left:12px;width:98px;"></div>
							<div class="createcampaign-browserbar1" style="width:399px;"></div>
							<div class="createcampaign-browserbar1" style="width:335px;"></div>
							<div class="createcampaign-browserbar1" style="width:100px;"></div>
							<div class="createcampaign-browserbar1" style="margin-left:12px;width:285px;"></div>
							<div class="createcampaign-browserbar1" style="width:399px;"></div>
						</div>
						<div class="createcampaign-browserinwrap">
							<div class="createcampaign-browserbar3"></div>

							<div class="createcampaign-browserbar1" style="width:338px;"></div>
							<div class="createcampaign-browserbar1" style="width:288px;"></div>
							<div class="createcampaign-browserbar1" style="margin-left:12px;width:98px;"></div>
							<div class="createcampaign-browserbar1" style="width:399px;"></div>
							<div class="createcampaign-browserbar1" style="width:335px;"></div>
							<div class="createcampaign-browserbar1" style="width:100px;"></div>
							<div class="createcampaign-browserbar1" style="margin-left:12px;width:285px;"></div>
							<div class="createcampaign-browserbar1" style="width:399px;"></div>
						</div>
						<div class="createcampaign-browserinwrap">
							<div class="createcampaign-browserbar3"></div>

							<div class="createcampaign-browserbar1" style="width:338px;"></div>
							<div class="createcampaign-browserbar1" style="width:288px;"></div>
							<div class="createcampaign-browserbar1" style="margin-left:12px;width:98px;"></div>
							<div class="createcampaign-browserbar1" style="width:399px;"></div>
							<div class="createcampaign-browserbar1" style="width:335px;"></div>
							<div class="createcampaign-browserbar1" style="width:100px;"></div>
							<div class="createcampaign-browserbar1" style="margin-left:12px;width:285px;"></div>
							<div class="createcampaign-browserbar1" style="width:399px;"></div>
						</div>
					</div>
					<div class="createcampaign-browserright">
						<div class="createcampaign-browserinwrap">
							<div class="createcampaign-browserbar4"></div>
							<div class="createcampaign-browserbar1" style="width:90px;"></div>
							<div class="createcampaign-browserbar1" style="width:120px;"></div>
						</div>
						<div class="createcampaign-browserinwrap">
							<div class="createcampaign-browserbar4"></div>
							<div class="createcampaign-browserbar1" style="width:90px;"></div>
							<div class="createcampaign-browserbar1" style="width:120px;"></div>
						</div>
						<div class="createcampaign-browserinwrap">
							<div class="createcampaign-browserbar4"></div>
							<div class="createcampaign-browserbar1" style="width:90px;"></div>
							<div class="createcampaign-browserbar1" style="width:120px;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	-->

	<!-- BASIC AD TYPE CREATION -->
	<div class="createcampaign-leftsep">
		<div class="display-septext">CREATION</div>
	</div>

    <div class="createcampaign-rightsep">
		<div class="display-septext">OUTPUT</div>
	</div>

	<div class="campaign-creationwrap">
		<form onsubmit="return createCampaign()" name="campaignForm">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="campaign-creationyoutube">
				<label>YOUTUBE URL</label>
				<input id="video_url" name="video_url" type="text" placeholder="https://www.youtube.com/watch?v=HgbHx4CY300" required
                    @if(isset($campaign)) value="https://www.youtube.com/watch?v={{$campaign->video_url}}" @endif
                >
                <span class="status-icon @if(isset($campaign)) green @endif "><i class="fa @if(isset($campaign)) fa-check @endif"></i></span>
			</div>
			<div class="campaign-creationyoutube">
				<label>CAMPAIGN NAME</label>
                <div class="campaignform-error hidden">Already same title exists.</div>
				<input id="campaign_name" name="campaign_name" type="text" required
                    @if(isset($campaign)) value="{{ $campaign->campaign_name }}" @endif
                >
			</div>
			<div class="campaign-creationvidsize">
				<label>VIDEO SIZE</label>
				<input id="auto_resize" name="auto_resize" type="checkbox" onclick="autoResize()"><span>AUTO-RESIZE</span>
				<input id="video_width" class="video_size_width" name="video_width" type="text" placeholder="width(px)" required
                    @if(isset($campaign)) value="{{ $campaign->video_width }}" @endif
                >
				<input id="video_height" class="video_size_height" name="video_height" type="text" placeholder="height(px)" required
                    @if(isset($campaign)) value="{{ $campaign->video_height }}" @endif
                >
			</div>

			<button>GENERATE VIDEO</button>
		</form>
	</div>

	<div class="campaign-outputwrap">
		<div class="campaign-videoarea">
            @if(isset($campaign))
				<script src="{{ env('PLAYER_HOST') }}/p{{$campaign->play_id}}.js"></script>
			@endif
		</div>
		<div class="campvideoarea-embedtitles">
			<div class="campvideoarea-embedcodetitle">EMBED CODE</div>
			<div class="campvideoarea-copycodetitle" data-copytarget="#campvideoarea-textembedcode">COPY THIS CODE</div>
		</div>
		<div class="campvideoarea-codearea">
			<script>
                function h(e) {
                    $(e).css({
                        'height': 'auto',
                        'overflow-y': 'hidden'
                    }).height(e.scrollHeight);
                }

                $('textarea').each(function() {
                    h(this);
                }).on('input', function() {
                    h(this);
                });
            </script>

			@if(isset($campaign))
				<textarea readonly id="campvideoarea-textembedcode"><script src="{{ env('PLAYER_HOST') }}/p{{$campaign->play_id}}.js"></script></textarea>
			@endif
		</div>
	</div>

    <!-- COPY EMBED TO CLIPBOARD -->
    <script type="text/javascript" src="/template/js/copyclipboard.js"></script>
@endsection
