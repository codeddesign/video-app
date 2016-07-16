<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    /**
     * @return mixed
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    /**
     * @return mixed
     */
    public function wordpress()
    {
        return $this->hasMany(WordpressSite::class);
    }

    /**
     * @param string $link
     *
     * @return WordpressSite
     */
    public function addWordpress($link)
    {
        return WordpressSite::create([
            'user_id' => $this->id,
            'domain' => $link,
        ]);
    }

    /**
     * @param int $id
     *
     * @return Wordpressite|null
     */
    public function wordpressById($id)
    {
        return $this->wordpress()
                    ->whereId($id)
                    ->first();
    }

    /**
     * @param string $name
     *
     * @return Campaign|null
     */
    public function campaignByName($name)
    {
        return $this->campaigns()
                    ->whereCampaignName($name)
                    ->first();
    }

    /**
     * @param int $id
     *
     * @return Campaign|null
     */
    public function campaignById($id)
    {
        return $this->campaigns()
                    ->whereId($id)
                    ->first();
    }

    /**
     * @param array $data
     *
     * @return Campaign
     */
    public function addCampaign(array $data)
    {
        $data['user_id'] = $this->id;

        $campaign = Campaign::create($data);

        return $campaign;
    }
}
