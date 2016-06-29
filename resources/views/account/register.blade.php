@extends('account._base')

@section('content')
<div class="loginform-registertitle">ACCOUNT CREATION</div>
<form action="/account/register" method="post">
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
    <button>CONTINUE</button>
</form>

@include('account._additional', ['on' => 'register'])

@endsection
