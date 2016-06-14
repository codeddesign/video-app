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
<!-- Toastr style -->
<link href="/template/css/toastr.min.css" rel="stylesheet">

<!-- include typekit font -->
<script src="https://use.typekit.net/lwk5wec.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

</head>
<body id="loginpage">

<div class="loginwrapper">
    <div class="loginlogo">
        <center>
            <img src="/template/images/videologo.png" width="66" height="63">
        </center>
    </div>

    <form action="/auth" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div>
            <input type="email" name="email" placeholder="email address.." required>
            <span class="loginemailicon"></span>
        </div>
        <div>
            <input type="password" name="password" placeholder="password.." required>
            <span class="loginpassicon"></span>
        </div>
        <button>LOGIN</button>
    </form>

    <div class="loginadditional">
        <div class="login-registerbutton"><a href="/account">REGISTER</a></div>
        <div class="login-lostpassbutton"><a href="/account/recover">LOST PASSWORD</a></div>
    </div>
</div>

<!-- Toastr script -->
<script src="/template/js/toastr.min.js"></script>

<script>

    $(document).ready(function(){
            var i = -1;
            var toastCount = 0;

            <?php if (isset($error)) {?>
                var getMessage = function () {

                    var msg = '<?=$error?>';
                    return msg;
                };

                var msg = "";
                var title = "";

                var toastIndex = toastCount++;

                toastr.options = {
                    closeButton: true,
                    debug: true,
                    progressBar: true,
                    preventDuplicates: true,
                    positionClass: "toast-top-right",
                    onclick: null
                };

                toastr.options.showDuration = 1000;
                toastr.options.hideDuration = 1000;
                toastr.options.timeOut = 7000;
                toastr.options.extendedTimeOut = 1000;
                toastr.options.showEasing = "swing";
                toastr.options.hideEasing = "linear";
                toastr.options.showMethod = "fadeIn";
                toastr.options.hideMethod = "fadeOut";
                if (!msg) {
                    msg = getMessage();
                }

                toastr['error'](msg); // Wire up an event handler to a button in the toast, if it exists

            <?php } ?>
     });
</script>
</body>
</html>
