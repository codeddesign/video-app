@extends('header')
@section('content')
	<div class="display-leftsep">
		<div class="display-septext">CREATION</div>
	</div>
	<div class="display-rightsep">
		<div class="display-septext">OUTPUT</div>
	</div>
	<div class="campaign-creationwrap">
		<form action="{{URL::to('adminCreateCampaignCheck/'.$user_account->id)}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<?php if(!isset($video_url)){?>
			<div class="campaign-creationyoutube">
				<label>YOUTUBE URL</label>
				<input name="youtube_url" type="text" placeholder="https://www.youtube.com/watch?v=HgbHx4CY300" required>
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
			<?php }
			else{
			?>
			<div class="campaign-creationyoutube">
				<label>YOUTUBE URL</label>
				<input name="youtube_url" type="text" placeholder="https://www.youtube.com/watch?v=HgbHx4CY300" value="https://www.youtube.com/watch?v=<?=$video_url?>" required>
			</div>	
			<div class="campaign-creationyoutube">
				<label>CAMPAIGN NAME</label>
				<input name="campaign_name" type="text" value="<?=$campaign_name?>" required>
			</div>
			<div class="campaign-creationvidsize">
				<label>VIDEO SIZE</label>
				<input name="auto_resize" onmouseup="autoResize()" type="checkbox"><span>AUTO-RESIZE</span>
				<input class="video_size_width" name="video_width" type="text" placeholder="width(px)" value="<?=$video_width?>" required>
				<input class="video_size_height" name="video_height" type="text" placeholder="height(px)" value="<?=$video_height?>" required>
			</div>
			<?php }?>
			<button>GENERATE VIDEO</button>	
		</form>
	</div>
	<div class="campaign-outputwrap">
		<div class="campaign-videoarea">
			<?php if(isset($video_url)){?>
			<video class="afterglow width_100" id="video2light"  data-skin="custom-ads" data-youtube-id="<?=$video_url?>">
			</video>
			<?php }?>
		</div>
		<div class="campvideoarea-embedtitles">
			<div class="campvideoarea-embedcodetitle">EMBED CODE</div>
			<div class="campvideoarea-copycodetitle">COPY THIS CODE</div>
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
			<textarea readonly>
			<?php if(isset($video_url)){?>
				<script src="{{url('/')}}/template/js/afterglow.min.js"></script>
				<video class="afterglow" id="myvideo" width="<?=$video_width?>" height="<?=$video_height?>"  data-youtube-id="<?=$video_url?>"></video>
				
			<?php }?>
			</textarea>
		</div>
	</div>
</div><!-- end .rightside -->
@endsection