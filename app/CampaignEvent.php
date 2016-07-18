<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignEvent extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['campaign_id', 'name', 'event', 'referer'];

    /**
     * Set the referer on create.
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($campaignEvent) {
            $campaignEvent->referer = refererUtil();
            $campaignEvent->ip = ipUtil();
        });
    }
}
