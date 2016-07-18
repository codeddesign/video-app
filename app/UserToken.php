<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'token', 'type'];

    /**
     * @param User   $user
     * @param string $type
     *
     * @return UserToken
     */
    public static function random(User $user, $type)
    {
        return self::create([
            'user_id' => $user->id,
            'type' => $type,
            'token' => str_random(32),
        ]);
    }

    /**
     * @return array
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public static function process($token)
    {
        $token = self::whereToken($token)->first();

        if (!$token) {
            return false;
        }

        $user = User::find($token->user_id);

        $token->delete();

        switch ($token->type) {
            case 'confirm':
                $user->confirmedEmail();
            break;
            case 'reset':
                // ask user to enter his new pasword
            break;
        }

        return true;
    }
}
