@extends('header')
@section('content')

	<div class="accountpasswrap">
		<div class="accountpass-leftsep" style="width:100%;">
			<div class="display-septext">CHANGE YOUR ACCOUNT PASSWORD</div>
		</div>
		<form action="/account/edit" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div>
				<label>CHANGE PASSWORD</label>
				<input name="password" placeholder="new password.." required>
			</div>
			<div>
				<label>CONFIRM PASSWORD</label>
				<input name="confirm_password" placeholder="confirm password.." required>
			</div>
			<button type="submit">SAVE CHANGES</button>
		</form>
	</div>

</div><!-- end .rightside -->

@endsection