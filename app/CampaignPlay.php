<?php

namespace App;

use App\Campaign;
use Illuminate\Database\Eloquent\Model;

class CampaignPlay extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['campaign_id', 'referer'];

    public static function stats($userId)
    {
        $campaigns = Campaign::whereUserId($userId)->get()->lists('id');

        $plays = self::whereIn('campaign_id', $campaigns)
            ->whereBetween('created_at', self::monthStartEnd())
            ->get();

        $by_date = self::dates();
        $by_hour = self::hours();
        foreach ($plays as $play) {
            $ts = strtotime($play->created_at);

            $date = date('Y-m-d', $ts);
            $by_date[$date] += 1;

            if ($date != date('Y-m-d')) {
                continue;
            }

            $hour = date('h', $ts);
            $by_hour[$hour] += 1;
        }

        return compact('by_date', 'by_hour');
    }

    protected static function monthStartEnd($year = false, $month = false)
    {
        $year  = $year ? $year : date('Y');
        $month = $month ? $month : date('m');

        $from_date = date('Y-m-d', strtotime(implode('-', [$year, $month, '01'])));
        $to_date   = date('Y-m-d', strtotime($from_date . ' 1 month -1 second'));

        return [
            $from_date,
            $to_date,
        ];
    }

    protected static function dates()
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

        $dates = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $i = ($i <= 9) ? '0' . $i : $i;

            $dates[date('Y-m') . '-' . $i] = 0;
        }

        return $dates;
    }

    protected static function hours()
    {
        $hours = [];
        for ($i = 0; $i <= 23; $i++) {
            $i = ($i <= 9) ? '0' . $i : $i;

            $hours[$i] = 0;
        }

        return $hours;
    }
}
