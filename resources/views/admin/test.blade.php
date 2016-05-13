<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>afterglow development sandbox</title>
   	<script type="text/javascript" src="{{url('/')}}/template/js/afterglow.min.js"></script>
	<!-- custom.js -->
    <script src="http://players.brightcove.net/videojs-overlay/1/videojs-overlay.min.js"></script>
    <script type="text/javascript" src="http://3ee.com/videojs/videojs-disable-progress/src/videojs.disableProgress.js"></script>
 	<link href="http://players.brightcove.net/videojs-overlay/1/videojs-overlay.css" rel='stylesheet'>  
	<script type="text/javascript" src="{{url('/')}}/template/js/custom.js"></script>
	<!-- SCRIPTS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>
   <link href="{{url('/')}}/template/css/afterglow-custom-ads.css" rel="stylesheet" type="text/css">

 

	<style>
		body{
			max-width:800px;
			margin: 0 auto;
			padding:0 50px 50px;
		}
	</style>
</head>
<body style="background:#111;">
	<h1>&nbsp;</h1>
    <div style="width:800px;float:left;">
	    <video id="video2light" preload="auto" width="1280" height="720" data-autoresize="fit" poster="http://s22.postimg.org/lfnkkdrv4/vidoverlay.jpg" class="afterglow"  data-skin="custom-ads" webkit-playsinline>
	        <source src="{{url('/')}}/template/video/4kvid.mp4" type="video/mp4"/>
	        <source src="{{url('/')}}/template/video/hdvid.mp4" type="video/mp4" data-quality="hd"/>
	    </video>
    </div>
</body>
</html>