@extends('account._base')

@section('content')
<form action="/account/recover" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div>
		<input type="email" name="username" placeholder="email address.." required>
		<span class="loginemailicon"></span>
	</div>

	<button>SEND</button>
</form>

@include('account._additional', ['on' => 'recover'])

@endsection