@extends('app._base')

@section('content')
<div class="accountpasswrap">
    <div class="accountpass-leftsep" style="width:100%;">
        <div class="display-septext">CHANGE YOUR ACCOUNT PASSWORD</div>
    </div>

    <form action="/app/profile" method="post">
        <div class="accountpass-accountidwrap">
            <div class="accountpass-accountidtitle">ACCOUNT ID</div>
            <div class="accountpass-accountid">{{ $user->id }}</div>
        </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div>
            <label>CHANGE PASSWORD</label>
            <input name="password" placeholder="new password.." type="password" required>
        </div>

        <div>
            <label>CONFIRM PASSWORD</label>
            <input name="confirm_password" placeholder="confirm password.." type="password" required>
        </div>

        <button type="submit">SAVE CHANGES</button>
    </form>
</div>
@endsection
