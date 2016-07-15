<!DOCTYPE html>
<html>

    <head>

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
            <meta charset="utf-8" id="token" value="{{ csrf_token() }}">
            <title>Video App</title>
            <link href="/template/css/style.css" rel="stylesheet" type="text/css">
        </head>
    </head>

    <body>

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
