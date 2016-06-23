<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
    <title>Video App</title>
    <!-- ingrid default stylesheet -->
    <link href="/template/css/ingrid.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>
    <link href="/template/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/template/js/jquery.ingrid.js"></script>
    <!-- include typekit font -->
    <script src="https://use.typekit.net/lwk5wec.js"></script>
    <script>try { Typekit.load({ async: true }); } catch (e) {}</script>
</head>

<body>
    <!-- LEFT SIDE -->
    <div class="leftsidebar">
        <div class="logoarea">
            <div class="videologo"></div>
        </div>

        <ul class="navlist">
            <a href="/">
                <li class="{{ set_active_nav('/', 'active') }}">DASHBOARD</li>
            </a>

            <a href="/campaign">
                <li class="{{ set_active_nav('/campaign', 'active') }}">CREATE CAMPAIGN</li>
            </a>

            <a href="/wordpress">
                <li class="{{ set_active_nav('/wordpress', 'active') }}">WORDPRESS SITES</li>
            </a>

            <a href="#">
                <li class="{{ set_active_nav('#', 'active') }}">SUPPORT</li>
            </a>
        </ul>
    </div>
    <!-- RIGHT SIDE -->
    <div class="rightside">
        <div class="rightside-nav">
            <div class="rightside-navlefttitle">
                @yield('page_name')
            </div>

            <div class="rightside-navdropdown">ACCOUNT DETAILS <span></span></div>
            <ul class="rightside-navdroparea" style="display:none;">
                <a href="/settings">
                    <li>EDIT ACCOUNT</li>
                </a>
                <a href="/account/logout">
                    <li>LOGOUT</li>
                </a>
            </ul>
        </div>

        @yield('content')

        <!-- COPY EMBED TO CLIPBOARD -->
        <script type="text/javascript" src="/template/js/copyclipboard.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.rightside-navdropdown, .rightside-navdroparea').mouseover(function() {
                    $('.rightside-navdroparea').show();
                    $('.rightside-navdropdown').css('background', '#303749');
                    $('.rightside-navdropdown').css('border-left', '1px solid #303749');
                });

                $('.rightside-navdropdown, .rightside-navdroparea').mouseout(function() {
                    $('.rightside-navdroparea').hide();
                    $('.rightside-navdropdown').css('background', 'transparent');
                    $('.rightside-navdropdown').css('border-left', '1px solid #5C5882');
                });
            });
        </script>
</body>

</html>
