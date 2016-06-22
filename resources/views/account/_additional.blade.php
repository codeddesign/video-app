<div class="loginadditional">
    @if($on != 'login')
        <div class="login-registerbutton"><a href="/account/login">LOGIN</a></div>
    @endif

    @if($on != 'register')
        <div class="login-registerbutton"><a href="/account/register">REGISTER</a></div>
    @endif

    @if($on != 'recover')
        <div class="login-lostpassbutton"><a href="/account/recover">LOST PASSWORD</a></div>
    @endif
</div>