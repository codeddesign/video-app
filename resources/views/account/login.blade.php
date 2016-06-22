@extends('account._base')

@section('content')
<form action="/account/login" method="post">
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

@include('account._additional', ['on' => 'login'])

@endsection