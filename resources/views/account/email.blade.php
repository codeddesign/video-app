<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Verify Your Email Address</h2>

<div>
    <p>Hi. &nbsp; Please follow the link below to verify your email address</p>
    {{ URL::to('account/email-verify/' . $confirmation_code) }}.<br/>
</div>

</body>
</html>