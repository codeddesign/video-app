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
        $from = (isset($data['from']) && trim($data['from'])) ? $data['from'] : date('Y-m-d');
        $to = (isset($data['to']) && trim($data['to'])) ? $data['to'] : date('Y-m-d');

        $from = date('Y-m-d H:i:s', strtotime($from.' 00:00:00 -4 hours'));
        $to = date('Y-m-d H:i:s', strtotime($to.' 23:59:59 -4 hours'));

        $names = self::select('name', 'event')
            ->distinct('name', 'event')
            ->get()
            ->groupBy('name');

        $ignoreFailed = false; //
        foreach ($names as $name => $events) {
            foreach ($events as $index => $event) {
                if ($ignoreFailed && stripos($event->event, 'fail') !== false) {
                    unset($names[$name][$index]);
                    continue;
                }

                $count = self::select(DB::raw('count(*) as total'))
                    ->whereName($name)
                    ->whereEvent($event->event)
                    ->where('created_at', '>=', $from)
                    ->where('created_at', '<=', $to)
                    ->first();

                $names[$name][$index]['total'] = $count->total;
            }

            $names[$name] = array_values($names[$name]->toArray());
        }

        return $names;
    }
}
