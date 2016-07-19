<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

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
     * @param array $data
     *
     * @return array
     */
    public static function stats($data)
    {
        // range
        $from = date('Y-m-d');
        if (isset($data['from']) && trim($data['from'])) {
            $from = trim($data['from']);
        }

        $to = date('Y-m-d');
        if (isset($data['to']) && trim($data['to'])) {
            $to = trim($data['to']);
        }

        $names = self::select('name', 'event')
            ->distinct('name', 'event')
            ->get()
            ->groupBy('name');

        foreach ($names as $name => $events) {
            foreach ($events as $index => $event) {
                if (stripos($event->event, 'fail') !== false) {
                    unset($names[$name][$index]);
                    continue;
                }

                $count = self::select(DB::raw('count(*) as total'))
                    ->whereName($name)
                    ->whereEvent($event->event)
                    ->where('created_at', '>=', $from.' 00:00:00')
                    ->where('created_at', '<=', $to.' 20:00:00')
                    ->first();

                $names[$name][$index]['total'] = $count->total;
            }

            $names[$name] = array_values($names[$name]->toArray());
        }

        return $names;
    }
}
