<div class="loginadditional">
    @if($on != 'login')
        <div class="login-registerbutton"><a href="/app/login">LOGIN</a></div>
    @endif

    @if($on != 'register')
        <div class="login-registerbutton"><a href="/app/register">REGISTER</a></div>
    @endif

    @if($on != 'recover')
        <div class="login-lostpassbutton"><a href="/app/recover">LOST PASSWORD</a></div>
    @endif
</div>