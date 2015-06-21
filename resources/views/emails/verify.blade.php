<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Activate your account</h2>

        <div>
            Thanks for creating an account with Lexington Tutor Exchange.
            Please follow the link below to verify your email address
            {{ URL::to('auth/verify/' . $confirmation_code) }}.<br/>

        </div>

    </body>
</html>
