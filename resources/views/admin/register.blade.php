<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<title>Video App</title>
<link href="{{url('/')}}/template/css/style.css" rel="stylesheet" type="text/css">
<!-- ingrid default stylesheet -->
<style media="all" type="text/css">@import "{{url('/')}}/template/css/ingrid.css";</style>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<!-- include ingrid lib -->
<script type="text/javascript" src="{{url('/')}}/template/js/jquery.ingrid.js"></script>

<!-- include typekit font -->
<script src="https://use.typekit.net/lwk5wec.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

</head>
<body id="loginpage">

<div class="loginwrapper">
    <div class="loginlogo">
        <center>
            <img src="{{url('/')}}/template/images/videologo.png" width="66" height="63">
        </center>
    </div>
    <form action="/account" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div>
            <input type="email" name="email" placeholder="email address.." required>
            <span class="loginemailicon"></span>
        </div>

        <div>
            <input type="password" name="password" placeholder="password.." required>
            <span class="loginpassicon"></span>
        </div>
        <div>
            <input type="password" name="confirm_password" placeholder="confirm..." required>
            <span class="loginpassicon"></span>
        </div>
        <button>REGISTER</button>
    </form>
    <div class="loginadditional">
        <div class="login-registerbutton"><a href="/">LOGIN</a></div>
        <div class="login-lostpassbutton"><a href="/account/recover">LOST PASSWORD</a></div>
    </div>
</div>
</body>
</html>
