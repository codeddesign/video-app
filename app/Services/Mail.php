<?php

namespace App\Services;

use App\User;
use App\UserToken;
use Illuminate\Support\Facades\Mail as BaseMail;

class Mail  extends BaseMail
{
    public static function sendVerificationEmail(User $user)
    {
        $token = UserToken::random($user, 'confirm');

        self::send('auth.email', ['token' => $token], function ($message) use ($user) {
            $message->from('noreply@ad3media.com', 'WebMaster');

            $message->to($user['email'])->subject('Verify your email address');
        });
    }
}
