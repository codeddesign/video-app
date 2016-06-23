@extends('dashboard._base')

@section('page_name')
    @if(!isset($campaign))
        CREATE CAMPAIGN
    @else
        PREVIEW CAMPAIGN
    @endif
@endsection

@section('content')
	<div class="createcampaign-leftsep">
		<div class="display-septext">CREATION</div>
	</div>

    <div class="createcampaign-rightsep">
		<div class="display-septext">OUTPUT</div>
	</div>

	<div class="campaign-creationwrap">
		<form action="/campaign" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="campaign-creationyoutube">
				<label>YOUTUBE URL</label>
				<input name="video_url" type="text" placeholder="https://www.youtube.com/watch?v=HgbHx4CY300" required
                    @if(isset($campaign)) value="https://www.youtube.com/watch?v={{$campaign->video_url}}" @endif
                >
			</div>
			<div class="campaign-creationyoutube">
				<label>CAMPAIGN NAME</label>
				<input name="campaign_name" type="text" required
                    @if(isset($campaign)) value="{{ $campaign->campaign_name }}" @endif
                >
			</div>
			<div class="campaign-creationvidsize">
				<label>VIDEO SIZE</label>
				<input name="auto_resize" onmouseup="autoResize()" type="checkbox"><span>AUTO-RESIZE</span>
				<input class="video_size_width" name="video_width" type="text" placeholder="width(px)" required
                    @if(isset($campaign)) value="{{ $campaign->video_width }}" @endif
                >
				<input class="video_size_height" name="video_height" type="text" placeholder="height(px)" required
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

@endsection
