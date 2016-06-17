<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['id', 'user_id', 'campaign_name', 'video_url', 'video_width', 'video_height', 'video_plays', 'revenue', 'active'];

    protected $appends = ['play_id'];

    public function setVideoUrlAttribute($video_url)
    {
        $parsed = parse_url($video_url);

        foreach (explode('&', $parsed['query']) as $data) {
            list($key, $value) = explode('=', $data);

            $pairs[$key] = trim($value);
        }

        $this->attributes['video_url'] = $pairs['v'];
    }

    public function getPlayIdAttribute()
    {
        return $this->id . '-' . $this->video_url;
    }
}
