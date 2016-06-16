<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<title>Video App</title>
<!-- ingrid default stylesheet -->
<link href="{{url('/')}}/template/css/ingrid.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>

<link href="{{url('/')}}/template/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{url('/')}}/template/js/jquery.ingrid.js"></script>

<!-- Toastr style -->
<link href="{{url('/')}}/template/css/toastr.min.css" rel="stylesheet">

<!-- include typekit font -->
<script src="https://use.typekit.net/lwk5wec.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

<!-- initialize ingrid -->
<script type="text/javascript">
$(document).ready(function() {
    // table chart js
    var mygrid1 = $("#table1").ingrid({
        url: '/',
        height: 'auto',
        width: '100%',
        rowClasses: ['grid-row-style1','grid-row-style2'],
        resizableCols: true,
        paging: false,
        sorting: false
    });
    // search area dropdown
    $('.campaignview-dropbutton').click(function(){
        $('.campaignview-droppedarea').toggle();
    });
    $('.rightside-navdropdown, .rightside-navdroparea').mouseover(function(){
        $('.rightside-navdroparea').show();
        $('.rightside-navdropdown').css('background','#303749');
        $('.rightside-navdropdown').css('border-left','1px solid #303749');
    });
    $('.rightside-navdropdown, .rightside-navdroparea').mouseout(function(){
        $('.rightside-navdroparea').hide();
        $('.rightside-navdropdown').css('background','transparent');
        $('.rightside-navdropdown').css('border-left','1px solid #5C5882');
    });
});
</script>
</head>
<body>

<!-- LEFT SIDE -->
<div class="leftsidebar">
    <div class="logoarea">
        <div class="videologo"></div>
    </div>

    <?php if (!isset($menu_flag)) {
    $menu_flag_demo = ['', '', '', '', '', ''];
} else {
    $menu_flag_demo = ['', '', '', '', '', ''];
    for ($i = 0; $i < 6; $i++) {
        if ($menu_flag[$i] == 1) {
            $menu_flag_demo[$i] = "active";
        }
    }
}
?>

    <ul class="navlist">
        <a href="/">
        	<li class="<?=$menu_flag_demo[0]?>">DASHBOARD</li>
        </a>	
        <a href="/campaign/create">
        	<li class="<?=$menu_flag_demo[1]?>">CREATE CAMPAIGN</li>
        </a>	
        <!--<li>MANAGE ADS</li>-->
        <!--<li>ANALYTICS</li>-->
        <a href="#">
        	<li class="<?=$menu_flag_demo[2]?>">SUPPORT</li>
        </a>	
    </ul>
</div>

<!-- RIGHT SIDE -->
<div class="rightside">


    <div class="rightside-nav">
        <div class="rightside-navlefttitle"><?=$page_name?></div>
        <div class="rightside-navdropdown">ACCOUNT DETAILS <span></span></div>
        <ul class="rightside-navdroparea" style="display:none;">
            <a href="/account/edit"><li>EDIT ACCOUNT</li></a>
            <a href="/auth/logout"><li>LOGOUT</li></a>
        </ul>
    </div>

@yield('content')

@extends('footer')