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
     * @var array
     */
    protected $hidden = ['ip', 'updated_at', 'deleted_at'];

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

    /**
     * @return array
     */
    public static function eventTypes()
    {
        return self::select('name', 'event')->distinct('name', 'event')->get();
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public static function eventList($data)
    {
        // range
        $from = date('Y-m-d', strtotime(date('Y-m-d').' -2 day'));
        if (isset($data['from']) && $data['from']) {
            $from = $data['from'];
        }

        $to = date('Y-m-d');
        if (isset($data['to']) && $data['to']) {
            $to = $data['to'];
        }

        // date
        $events = self::where('created_at', '>=', $from.' 20:00:00')
            ->where('created_at', '<=', $to.' 19:59:59');

        // event types
        if (isset($data['types']) && count($data['types'])) {
            $events->where(function ($q) use ($events, $data) {
                foreach ($data['types'] as $unique => $info) {
                    $q->orWhere(function ($q) use ($info) {
                        $q->where('name', '=', $info['name'])
                            ->where('event', '=', $info['event']);
                    });
                }
            });
        }

        // pagination
        $page = (isset($data['page']) && $data['page']) ? ($data['page'] - 1) : 0;
        $limit = (isset($data['limit']) && $data['limit']) ? ($data['limit']) : 100;

        $events->skip($page * $limit)->take($limit);

        return [
            'events' => $events->get(),
            'total' => $events->count(),
            'limit' => $limit,
        ];
    }
}
