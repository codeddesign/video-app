<!DOCTYPE html>
<html lang="en-US">

    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <h2>Verify Your Email Address</h2>

        <div>
            <p>Hi. &nbsp; Please follow the link below to verify your email address:</p>

            <p>
                <a href="{{ URL::to('app/verify-email/' . $token->token) }}">
                    {{ URL::to('app/verify-email/' . $token->token) }}
                </a>
            </p>
        </div>

    </body>

</html>
