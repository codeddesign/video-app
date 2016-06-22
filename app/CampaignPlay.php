<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignPlay extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['campaign_id', 'referer'];

    /**
     * @var array
     */
    protected $appends = ['day', 'hour'];

    /**
     * @return string
     */
    public function getDayAttribute()
    {
        return date('d', strtotime((string) $this->created_at));
    }

    /**
     * @return string
     */
    public function getHourAttribute()
    {
        return date('H', strtotime((string) $this->created_at));
    }
}
