<?php

namespace App;

use App\Services\Youtube;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verified_email',
        'verified_phone',
    ];

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
    public function tokens()
    {
        return $this->hasMany(UserToken::class);
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
     * Sets verified phone to true.
     *
     * @return User
     */
    public function confirmPhone()
    {
        $this->verified_phone = true;
        $this->save();

        return $this;
    }

    /**
     * Sets verified email to true.
     *
     * @return User
     */
    public function confirmedEmail()
    {
        $this->verified_email = true;
        $this->save();

        return $this;
    }

    /**
     * Creates new campaign for the current user.
     * Adds campaign videos if there are any.
     *
     * @param array $data
     *
     * @return Campaign
     */
    public function addCampaign(array $data)
    {
        // add campaign
        $data['user_id'] = $this->id;

        if (!Campaign::typeHasName($data['type'])) {
            $data['name'] = Youtube::title($data);
        }

        $campaign = Campaign::create($data);

        // add campaign videos
        $campaign->addVideos($data);

        return $campaign;
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
     * @return Campaign|null
     */
    public function campaignById($id)
    {
        return $this->campaigns()
                    ->whereId($id)
                    ->first();
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
}
