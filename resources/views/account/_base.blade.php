<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<title>Video App</title>
<link href="/template/css/style.css" rel="stylesheet" type="text/css">
<!-- ingrid default stylesheet -->
<style media="all" type="text/css">@import "/template/css/ingrid.css";</style>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<!-- include ingrid lib -->
<script type="text/javascript" src="/template/js/jquery.ingrid.js"></script>

<!-- include typekit font -->
<script src="https://use.typekit.net/lwk5wec.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

<!-- Custom javascript -->
<script type="text/javascript" src="/template/js/account.js"></script>

</head>
<body id="loginpage">

<div class="loginwrapper">
    <div class="loginlogo">
        <center>
            <img src="/template/images/videologo.png" width="78" height="29">
        </center>
    </div>

    @yield('content')
</div>

</body>
</html>
