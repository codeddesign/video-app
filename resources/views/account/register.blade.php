@extends('account._base')

@section('content')
<div class="user-creation">
    <div class="loginform-registertitle">ACCOUNT CREATION</div>
    <div class="loginform-error"></div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <form onsubmit="return checkValidate()" name="userForm">
        <div>
            <input type="email" name="email" placeholder="Email Address..." required>
            <span class="loginemailicon"></span>
        </div>
        <div>
            <input type="password" name="password" placeholder="Password" required>
            <span class="loginpassicon"></span>
        </div>
        <div>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <span class="loginpassicon"></span>
        </div>
        <button>CONTINUE</button>
    </form>

    <form class="hidden" onsubmit="return postVerify()" name="phoneForm">
        <div>
            <input type="tel" name="number" placeholder="Phone number.." required>
            <span class="loginemailicon"></span>
        </div>
        <button>VERIFY NUMBER</button>
    </form>

    <form class="hidden" onsubmit="return getVerify()" name="pinForm">
        <div>
            <input type="text" name="pin" placeholder="Enter verification number.." required>
        </div>
        <button>CONFIRM VERIFICATION NUMBER</button>
    </form>
</div>

<div class="verify-success">
    <span>
        <img src="/template/images/verify-success.png">
        <p>SUCCESS!</p>
    </span>
    <button>GO TO YOUR ACCOUNT</button>
</div>

@include('account._additional', ['on' => 'register'])

@endsection
