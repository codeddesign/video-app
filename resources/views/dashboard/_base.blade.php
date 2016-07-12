<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
    <title>Video App</title>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.js"></script>

    <!-- Font-awesome icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.js"></script>

    <!-- Moment -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>

    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>


    <!-- ingrid default stylesheet -->
    <link href="/template/css/ingrid.css" rel="stylesheet" type="text/css">
    <link href="/template/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/template/js/jquery.ingrid.js"></script>
    
    <!-- add creation steps -->
    <script type="text/javascript" src="/template/js/jquery.steps.min.js"></script>

    <!-- jQuery debounce -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.js"></script>

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

            <a href="#">
                <li class="{{ set_active_nav('/analytics', 'active') }}">ANALYTICS</li>
            </a>

            <a href="#">
                <li class="{{ set_active_nav('/campaigns', 'active') }}">CAMPAIGNS</li>
            </a>
            
            <a href="/create-campaign">
                <li class="{{ set_active_nav('/create-campaign', 'active') }}">CREATE CAMPAIGN</li>
            </a>

            <a href="/wordpress">
                <li class="{{ set_active_nav('/wordpress', 'active') }}">WEBSITE CONFIG</li>
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

            <!-- ACCOUNT DETAILS -->
            <div id="accountdetails" class="rightside-navdropdown">ACCOUNT DETAILS <span></span></div>
            <ul id="accountdetails-navdroparea" class="rightside-navdroparea" style="display:none;">
                <a href="/settings">
                    <li>EDIT ACCOUNT</li>
                </a>
                <a href="/account/logout">
                    <li>LOGOUT</li>
                </a>
            </ul>

			<!-- AVAILABLE WEBSITES -->
			<div id="availablesites" class="rightside-navdropdown">WEBSITES <span></span></div>
            <ul id="availablesites-navdroparea" class="rightside-navdroparea" style="display:none;">
                <a href="##">
                    <li>SITE.COM</li>
                </a>
                <a href="##">
                    <li>ABC.COM</li>
                </a>
            </ul>
        </div>

        @yield('content')

        <script type="text/javascript">
            $(document).ready(function() {
            	// WEBSITE LIST DROPDOWN
            	$('#availablesites, #availablesites-navdroparea').mouseover(function() {
                    $('#availablesites-navdroparea').show();
                    $('#availablesites').css('background', '#303749');
                    //$('#availablesites').css('border-right', '1px solid #303749');
                });
                $('#availablesites, #availablesites-navdroparea').mouseout(function() {
                    $('#availablesites-navdroparea').hide();
                    $('#availablesites').css('background', 'transparent');
                    //$('#availablesites').css('border-right', '1px solid #5C5882');
                });
                // ACCOUNT DETAILS DROPDOWN
                $('#accountdetails, #accountdetails-navdroparea').mouseover(function() {
                    $('#accountdetails-navdroparea').show();
                    $('#accountdetails').css('background', '#303749');
                    $('#accountdetails').css('border-left', '1px solid #303749');
                });
                $('#accountdetails, #accountdetails-navdroparea').mouseout(function() {
                    $('#accountdetails-navdroparea').hide();
                    $('#accountdetails').css('background', 'transparent');
                    $('#accountdetails').css('border-left', '1px solid #5C5882');
                });
            });
        </script>
</body>

</html>
