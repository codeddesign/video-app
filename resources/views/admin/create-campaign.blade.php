@extends('header')
@section('content')
	<div class="createcampaign-leftsep">
		<div class="display-septext">CREATION</div>
	</div>
	<div class="createcampaign-rightsep">
		<div class="display-septext">OUTPUT</div>
	</div>
	<div class="campaign-creationwrap">
		<form action="/campaign/create" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<?php if (!isset($campaign)) {?>
			<div class="campaign-creationyoutube">
				<label>YOUTUBE URL</label>
				<input name="video_url" type="text" placeholder="https://www.youtube.com/watch?v=HgbHx4CY300" required>
			</div>
			<div class="campaign-creationyoutube">
				<label>CAMPAIGN NAME</label>
				<input name="campaign_name" type="text" required>
			</div>
			<div class="campaign-creationvidsize">
				<label>VIDEO SIZE</label>
				<input name="auto_resize" onmouseup="autoResize()" type="checkbox"><span>AUTO-RESIZE</span>
				<input class="video_size_width" name="video_width" type="text" placeholder="width(px)" required>
				<input class="video_size_height" name="video_height" type="text" placeholder="height(px)" required>
			</div>
			<?php } else {?>
			<div class="campaign-creationyoutube">
				<label>YOUTUBE URL</label>
				<input name="video_url" type="text" placeholder="https://www.youtube.com/watch?v=HgbHx4CY300" value="https://www.youtube.com/watch?v=<?=$campaign->video_url?>" required>
			</div>
			<div class="campaign-creationyoutube">
				<label>CAMPAIGN NAME</label>
				<input name="campaign_name" type="text" value="<?=$campaign->name?>" required>
			</div>
			<div class="campaign-creationvidsize">
				<label>VIDEO SIZE</label>
				<input name="auto_resize" onmouseup="autoResize()" type="checkbox"><span>AUTO-RESIZE</span>
				<input class="video_size_width" name="video_width" type="text" placeholder="width(px)" value="<?=$campaign->video_width?>" required>
				<input class="video_size_height" name="video_height" type="text" placeholder="height(px)" value="<?=$campaign->video_height?>" required>
			</div>
			<?php }?>
			<button>GENERATE VIDEO</button>
		</form>
	</div>
	<div class="campaign-outputwrap">
		<div class="campaign-videoarea">
			<?php if (isset($campaign)) {?>
				<script src="{{ env('PLAYER_HOST') }}/p{{$campaign->play_id}}.js"></script>
			<?php }?>
		</div>
		<div class="campvideoarea-embedtitles">
			<div class="campvideoarea-embedcodetitle">EMBED CODE</div>
			<div class="campvideoarea-copycodetitle" data-copytarget="#campvideoarea-textembedcode">COPY THIS CODE</div>
		</div>
		<div class="campvideoarea-codearea">
			<script>
				function h(e) {
				  $(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight);
				}
				$('textarea').each(function () {
				  h(this);
				}).on('input', function () {
				  h(this);
				});
			</script>
			@if(isset($campaign))
				<textarea readonly id="campvideoarea-textembedcode"><script src="{{ env('PLAYER_HOST') }}/p{{$campaign->play_id}}.js"></script></textarea>
			@endif
		</div>
	</div>
</div><!-- end .rightside -->
@endsection
