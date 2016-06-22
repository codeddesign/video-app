<?php

namespace App;

use App\CampaignPlay;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'campaign_name', 'video_url', 'video_width', 'video_height', 'video_plays', 'revenue', 'active'];

    /**
     * @var array
     */
    protected $appends = ['play_id'];

    /**
     * Parse given youtube link and save only it's id
     *
     * @param string $video_url
     *
     * @return void
     */
    public function setVideoUrlAttribute($video_url)
    {
        $parsed = parse_url($video_url);

        foreach (explode('&', $parsed['query']) as $data) {
            list($key, $value) = explode('=', $data);

            $pairs[$key] = trim($value);
        }

        $this->attributes['video_url'] = $pairs['v'];
    }

    /**
     * Script embed pattern.
     * campaign id - youtube video id
     *
     * @return string
     */
    public function getPlayIdAttribute()
    {
        return $this->id . '-' . $this->video_url;
    }

    /**
     * @return mixed
     */
    public function plays()
    {
        return $this->hasMany(CampaignPlay::class);
    }
}
