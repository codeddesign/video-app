<?php

namespace App;

use App\Services\Youtube;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['campaign_id', 'url', 'source'];

    /**
     * Parse given youtube link and save only it's id.
     *
     * @param string $url
     */
    public function setUrlAttribute($url)
    {
        if (stripos($url, 'youtube') !== false) {
            $url = Youtube::id($url);
        }

        $this->attributes['url'] = $url;
    }

    /**
     * @return mixed
     */
    public function campaign()
    {
        return $this->hasOne(Campaign::class);
    }

    /**
     * Videos can be either 'directly' or 'comming from a request'.
     *
     *  If directly it means that it expects it to be a simple
     *  array with values that represent video urls.
     *
     *  If it's comming from a request it expects the video/s
     *  to be in a subkey called ['video'] or ['videos'] when
     *  there are multiple ones added by user.
     *
     * @param array $data
     *
     * @return array
     */
    public static function videosFromData($data)
    {
        $videos = $data;

        if (isset($data['video'])) {
            $videos = [$data['video']];
        }

        if (isset($data['videos']) and count($data['videos'])) {
            $videos = $data['videos'];
        }

        return $videos;
    }
}
